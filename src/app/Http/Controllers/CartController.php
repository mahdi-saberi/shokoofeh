<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index(): View
    {
        $cartItems = Cart::getCurrentCart(Auth::user(), session()->getId());
        $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());
        $cartCount = Cart::getCartCount(Auth::user(), session()->getId());
        $siteSettings = SiteSetting::current();

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount', 'siteSettings'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        try {
            $product = Product::findOrFail($productId);

            // Check stock
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'موجودی کافی نیست. موجودی فعلی: ' . $product->stock
                ], 400);
            }

            $cartItem = Cart::addItem(
                $productId,
                $quantity,
                Auth::user(),
                session()->getId()
            );

            $cartCount = Cart::getCartCount(Auth::user(), session()->getId());
            $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());

            return response()->json([
                'success' => true,
                'message' => 'محصول به سبد خرید اضافه شد',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal),
                'item' => [
                    'id' => $cartItem->id,
                    'product_name' => $product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => number_format($cartItem->price),
                    'total_price' => number_format($cartItem->total_price)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در افزودن محصول به سبد خرید'
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        try {
            $cartItem = Cart::where('id', $itemId)
                ->where(function($query) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', session()->getId());
                    }
                })
                ->firstOrFail();

            $quantity = $request->input('quantity');
            $product = $cartItem->product;

            // Check stock
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'موجودی کافی نیست. موجودی فعلی: ' . $product->stock
                ], 400);
            }

            $cartItem->update(['quantity' => $quantity]);

            $cartCount = Cart::getCartCount(Auth::user(), session()->getId());
            $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());

            return response()->json([
                'success' => true,
                'message' => 'تعداد محصول بروزرسانی شد',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal),
                'item_total' => number_format($cartItem->total_price)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در بروزرسانی سبد خرید'
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId): JsonResponse
    {
        try {
            $cartItem = Cart::where('id', $itemId)
                ->where(function($query) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', session()->getId());
                    }
                })
                ->firstOrFail();

            $cartItem->delete();

            $cartCount = Cart::getCartCount(Auth::user(), session()->getId());
            $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());

            return response()->json([
                'success' => true,
                'message' => 'محصول از سبد خرید حذف شد',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف محصول از سبد خرید'
            ], 500);
        }
    }

    /**
     * Clear all cart items
     */
    public function clear(): JsonResponse
    {
        try {
            Cart::clearCart(Auth::user(), session()->getId());

            return response()->json([
                'success' => true,
                'message' => 'سبد خرید خالی شد',
                'cart_count' => 0,
                'cart_total' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در خالی کردن سبد خرید'
            ], 500);
        }
    }

    /**
     * Get cart data (for AJAX requests)
     */
    public function data(): JsonResponse
    {
        $cartItems = Cart::getCurrentCart(Auth::user(), session()->getId());
        $cartTotal = Cart::getCartTotal(Auth::user(), session()->getId());
        $cartCount = Cart::getCartCount(Auth::user(), session()->getId());

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal),
            'items' => $cartItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => number_format($item->price),
                    'total_price' => number_format($item->total_price),
                    'product_image' => $item->product->image ? asset('storage/' . $item->product->image) : null
                ];
            })
        ]);
    }
}
