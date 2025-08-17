<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index(): View
    {
        $products = Product::latest()->take(5)->get();

        // داده‌های نمودار سفارش‌ها (فقط سفارش‌های پرداخت شده)
        $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as total_amount')
            ->where('created_at', '>=', now()->subDays(30))
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // آمار کلی
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'delivered')->count();

        // آمارهای زمانی
        $todayRevenue = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->whereDate('created_at', today())
            ->sum('total');

        $weekRevenue = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->startOfWeek())
            ->sum('total');

        $monthRevenue = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total');

        $todayOrders = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->whereDate('created_at', today())
            ->count();

        $weekOrders = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->startOfWeek())
            ->count();

        $monthOrders = Order::where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        return view('admin.dashboard', compact(
            'products',
            'orders',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'completedOrders',
            'todayRevenue',
            'weekRevenue',
            'monthRevenue',
            'todayOrders',
            'weekOrders',
            'monthOrders'
        ));
    }
}
