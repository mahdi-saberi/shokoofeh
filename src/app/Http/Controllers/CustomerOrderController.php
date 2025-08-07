<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of customer's orders.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Build query for orders
        $query = Order::where('customer_email', $user->email)
                     ->with(['orderItems.product']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $orders = $query->paginate(10)->withQueryString();

        // Statistics
        $totalOrders = Order::where('customer_email', $user->email)->count();
        $pendingOrders = Order::where('customer_email', $user->email)
                             ->where('status', 'pending')
                             ->count();
        $completedOrders = Order::where('customer_email', $user->email)
                                ->where('status', 'delivered')
                                ->count();
        $totalSpent = Order::where('customer_email', $user->email)
                          ->where('payment_status', 'paid')
                          ->sum('total');

        return view('customer.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent'
        ));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $user = Auth::user();

        $order = Order::where('customer_email', $user->email)
                     ->with(['orderItems.product'])
                     ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Track order status
     */
    public function track(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('order_number')) {
            $order = Order::where('customer_email', $user->email)
                         ->where('order_number', $request->order_number)
                         ->with(['orderItems.product'])
                         ->first();

            if ($order) {
                return view('customer.orders.track', compact('order'));
            } else {
                return redirect()->back()->with('error', 'سفارشی با این شماره یافت نشد.');
            }
        }

        return view('customer.orders.track');
    }

    /**
     * Cancel an order (if it's still pending)
     */
    public function cancel($id)
    {
        $user = Auth::user();

        $order = Order::where('customer_email', $user->email)
                     ->where('status', 'pending')
                     ->findOrFail($id);

        $order->update([
            'status' => 'cancelled',
            'admin_notes' => 'لغو شده توسط مشتری در تاریخ ' . now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('customer.orders.index')
                        ->with('success', 'سفارش شما با موفقیت لغو شد.');
    }
}
