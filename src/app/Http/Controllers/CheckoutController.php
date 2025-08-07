<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index(): View|RedirectResponse
    {
        $cartItems = Cart::getCurrentCart(Auth::user(), session()->getId());

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است');
        }

        $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());
        $shippingCost = Order::calculateShippingCost($cartTotal);
        $finalTotal = $cartTotal + $shippingCost;

        return view('checkout.index', compact('cartItems', 'cartTotal', 'shippingCost', 'finalTotal'));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'create_account' => 'nullable|boolean',
        ];

        // Add password validation only if creating account
        if ($request->boolean('create_account')) {
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required|string';
        }

        $request->validate($rules);

        $cartItems = Cart::getCurrentCart(Auth::user(), session()->getId());

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است');
        }

        try {
            $user = Auth::user();

            // Create guest account if requested
            if (!$user && $request->boolean('create_account') && $request->filled('password')) {
                $user = User::create([
                    'name' => $request->input('customer_name'),
                    'email' => $request->input('customer_email'),
                    'phone' => $request->input('customer_phone'),
                    'password' => Hash::make($request->input('password')),
                    'role' => 'customer',
                    'status' => 'active'
                ]);

                // Log the user in
                Auth::login($user);

                // Transfer session cart to user cart
                Cart::where('session_id', session()->getId())
                    ->whereNull('user_id')
                    ->update(['user_id' => $user->id, 'session_id' => null]);
            }

            // Prepare customer data
            $customerData = [
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'customer_email' => $request->input('customer_email'),
                'shipping_address' => $request->input('shipping_address'),
                'postal_code' => $request->input('postal_code'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'notes' => $request->input('notes')
            ];

            // Create order
            $order = Order::createFromCart($cartItems, $customerData, $user);

            // Clear cart after successful order creation
            Cart::clearCart($user, session()->getId());

            // Redirect to payment
            return redirect()->route('checkout.payment', $order->id);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'خطا در ثبت سفارش: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    public function payment($orderId): View|RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        // Check if order belongs to current user or session
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.payment', compact('order'));
    }

    /**
     * Process payment with ZarinPal (Sandbox)
     */
    public function processPayment(Request $request, $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        // Check if order belongs to current user
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        // ZarinPal Sandbox Configuration
        $merchantId = config('services.zarinpal.merchant_id'); // از کانفیگ خوانده شود
        $amount = $order->total; // In Toman
        $description = "پرداخت سفارش #{$order->order_number}";
        $callbackUrl = route('checkout.verify', $order->id);

        try {
            // Request payment from ZarinPal
            $payload = [
                'merchant_id' => $merchantId,
                'amount' => (int) $amount,
                'description' => $description,
                'callback_url' => $callbackUrl,
                'email' => $order->customer_email ?? '',
                'mobile' => $order->customer_phone ?? ''
            ];
            Log::info('Zarinpal payment request payload', $payload);
            $zarinpalMode = config('services.zarinpal.mode', 'sandbox');
            $zarinpalBaseUrl = $zarinpalMode === 'production'
                ? 'https://www.zarinpal.com/pg/v4'
                : 'https://sandbox.zarinpal.com/pg/v4';
            $response = Http::timeout(30)->post("{$zarinpalBaseUrl}/payment/request.json", $payload);
            Log::info('Zarinpal payment response', ['status' => $response->status(), 'body' => $response->body()]);
            if (!$response->successful()) {
                return redirect()->back()->with('error', 'خطا در ارتباط با درگاه پرداخت. کد خطا: ' . $response->status());
            }

            $result = $response->json();

            if (isset($result['data']['code']) && $result['data']['code'] == 100) {
                $authority = $result['data']['authority'];

                // Save authority for verification
                $order->update([
                    'payment_method' => 'zarinpal',
                    'payment_reference_id' => $authority
                ]);

                // Redirect to ZarinPal
                return redirect()->away("https://sandbox.zarinpal.com/pg/StartPay/{$authority}");
            } else {
                $errorMessage = 'خطا در اتصال به درگاه پرداخت';
                if (isset($result['data']['code'])) {
                    $errorMessage .= ' (کد خطا: ' . $result['data']['code'] . ')';
                }
                if (isset($result['errors']['message'])) {
                    $errorMessage .= ' - ' . $result['errors']['message'];
                }
                return redirect()->back()->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'خطا در پردازش پرداخت: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment callback
     */
    public function verifyPayment(Request $request, $orderId): View
    {
        $order = Order::findOrFail($orderId);
        $authority = $request->input('Authority');
        $status = $request->input('Status');

        if ($status == 'OK' && $authority == $order->payment_reference_id) {
            // Verify payment with ZarinPal
            $merchantId = '00000000-0000-0000-0000-000000000000';

            try {
                $verifyPayload = [
                    'merchant_id' => $merchantId,
                    'amount' => (int) $order->total,
                    'authority' => $authority
                ];
                Log::info('Zarinpal verify request payload', $verifyPayload);
                $zarinpalMode = config('services.zarinpal.mode', 'sandbox');
                $zarinpalBaseUrl = $zarinpalMode === 'production'
                    ? 'https://www.zarinpal.com/pg/v4'
                    : 'https://sandbox.zarinpal.com/pg/v4';
                $response = Http::post("{$zarinpalBaseUrl}/payment/verify.json", $verifyPayload);
                Log::info('Zarinpal verify response', ['status' => $response->status(), 'body' => $response->body()]);

                $result = $response->json();

                if (isset($result['data']['code']) && $result['data']['code'] == 100) {
                    // Payment successful
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'paid_at' => now(),
                        'payment_reference_id' => $result['data']['ref_id'] ?? null,
                        'card_pan' => $result['data']['card_pan'] ?? null,
                        'payment_message' => $result['data']['message'] ?? null,
                    ]);
                    $paymentStatus = 'success';
                    $message = 'پرداخت با موفقیت انجام شد';
                    $refId = $result['data']['ref_id'] ?? null;
                } else {
                    // Payment failed
                    $order->update(['payment_status' => 'failed']);
                    $paymentStatus = 'failed';
                    $message = $result['data']['message'] ?? 'پرداخت ناموفق بود';
                    $refId = null;
                }

            } catch (\Exception $e) {
                $paymentStatus = 'error';
                $message = 'خطا در تایید پرداخت';
                $refId = null;
            }
        } else {
            // Payment cancelled
            $order->update(['payment_status' => 'failed']);
            $paymentStatus = 'cancelled';
            $message = 'پرداخت لغو شد';
            $refId = null;
        }

        return view('checkout.result', compact('order', 'paymentStatus', 'message', 'refId'));
    }

    /**
     * Quick guest registration form
     */
    public function guestRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'role' => 'customer',
                'status' => 'active'
            ]);

            // Log the user in
            Auth::login($user);

            // Transfer session cart to user cart
            Cart::where('session_id', session()->getId())
                ->whereNull('user_id')
                ->update(['user_id' => $user->id, 'session_id' => null]);

            return redirect()->route('checkout.index')->with('success', 'حساب کاربری شما ایجاد شد');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'خطا در ایجاد حساب کاربری');
        }
    }
}
