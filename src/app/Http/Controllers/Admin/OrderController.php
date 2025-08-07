<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // لیست سفارشات
    public function index(Request $request)
    {
        $query = Order::query();

        // فیلتر بر اساس نام مشتری
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', "%{$request->customer_name}%");
        }

        // فیلتر بر اساس موبایل
        if ($request->filled('customer_phone')) {
            $query->where('customer_phone', 'like', "%{$request->customer_phone}%");
        }

        // فیلتر بر اساس ایمیل
        if ($request->filled('customer_email')) {
            $query->where('customer_email', 'like', "%{$request->customer_email}%");
        }

        // فیلتر بر اساس کد سفارش
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', "%{$request->order_number}%");
        }

        // فیلتر بر اساس کد رهگیری پستی
        if ($request->filled('tracking_code')) {
            $query->where('tracking_code', 'like', "%{$request->tracking_code}%");
        }

        // فیلتر بر اساس وضعیت سفارش
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فیلتر بر اساس وضعیت پرداخت
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // فیلتر بر اساس تاریخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // فیلتر بر اساس مبلغ
        if ($request->filled('amount_min')) {
            $query->where('total', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('total', '<=', $request->amount_max);
        }

        // مرتب‌سازی
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['created_at', 'total', 'customer_name', 'order_number'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $orders = $query->with('items')->paginate(20)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    // نمایش جزییات سفارش
    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    // فرم ویرایش سفارش
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // بروزرسانی سفارش
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'tracking_code' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'سفارش با موفقیت بروزرسانی شد.');
    }
}
