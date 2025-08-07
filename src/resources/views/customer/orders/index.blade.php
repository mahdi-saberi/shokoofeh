@extends('layouts.shop')

@section('title', 'سفارشات من')

@push('styles')
<link href="{{ asset('css/shokoofeh-modern.css') }}" rel="stylesheet" />
<style>
    .customer-orders {
        padding: var(--space-xl) 0;
        min-height: 70vh;
    }

    .orders-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-lg);
        margin-bottom: var(--space-xxl);
    }

    .stat-card {
        background: var(--gradient-card);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        text-align: center;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
        transition: all var(--transition-medium);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: var(--transition-medium);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: var(--space-md);
        color: var(--primary-color);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-xs);
    }

    .stat-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .orders-filters {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        margin-bottom: var(--space-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-lg);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .filter-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .filter-input {
        padding: var(--space-sm) var(--space-md);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: all var(--transition-medium);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
    }

    .orders-table {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .table {
        width: 100%;
        margin: 0;
    }

    .table th {
        background: var(--gradient-card);
        padding: var(--space-lg);
        font-weight: 600;
        color: var(--text-primary);
        border: none;
        text-align: right;
    }

    .table td {
        padding: var(--space-lg);
        border-top: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: var(--neutral-50);
    }

    .order-number {
        font-family: monospace;
        font-weight: 600;
        color: var(--primary-color);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-md);
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d1ecf1; color: #0c5460; }
    .status-shipped { background: #d4edda; color: #155724; }
    .status-delivered { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .payment-paid { background: #d4edda; color: #155724; }
    .payment-pending { background: #fff3cd; color: #856404; }
    .payment-failed { background: #f8d7da; color: #721c24; }

    .action-buttons {
        display: flex;
        gap: var(--space-xs);
    }

    .btn-action {
        padding: var(--space-xs) var(--space-sm);
        border: none;
        border-radius: var(--radius-md);
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all var(--transition-medium);
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: var(--danger-color);
        color: white;
    }

    .btn-cancel:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: var(--space-xxl);
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: var(--space-lg);
        color: var(--neutral-300);
    }

    @media (max-width: 768px) {
        .orders-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="container customer-orders">
    <div class="row">
        <div class="col-12">
            <h1 class="section-title">
                <i class="fas fa-shopping-bag me-2"></i>
                سفارشات من
            </h1>

            <!-- Statistics -->
            <div class="orders-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-number">{{ $totalOrders }}</div>
                    <div class="stat-label">کل سفارشات</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $pendingOrders }}</div>
                    <div class="stat-label">در انتظار بررسی</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $completedOrders }}</div>
                    <div class="stat-label">تحویل شده</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-number">{{ number_format($totalSpent) }}</div>
                    <div class="stat-label">کل خرید (تومان)</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="orders-filters">
                <h5 class="mb-3">
                    <i class="fas fa-filter me-2"></i>
                    فیلتر و جستجو
                </h5>

                <form method="GET" action="{{ route('customer.orders.index') }}">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">شماره سفارش</label>
                            <input type="text" name="order_number" class="filter-input"
                                   value="{{ request('order_number') }}"
                                   placeholder="مثال: ORD-2024-001">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">وضعیت سفارش</label>
                            <select name="status" class="filter-input">
                                <option value="">همه</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار بررسی</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>در حال پردازش</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>ارسال شده</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تحویل شده</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">وضعیت پرداخت</label>
                            <select name="payment_status" class="filter-input">
                                <option value="">همه</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>پرداخت ناموفق</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">از تاریخ</label>
                            <input type="date" name="date_from" class="filter-input"
                                   value="{{ request('date_from') }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">تا تاریخ</label>
                            <input type="date" name="date_to" class="filter-input"
                                   value="{{ request('date_to') }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="btn-action btn-view">
                                <i class="fas fa-search"></i>
                                جستجو
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="orders-table">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>وضعیت سفارش</th>
                                    <th>وضعیت پرداخت</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="order-number">{{ $order->order_number }}</div>
                                            @if($order->tracking_code)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-truck me-1"></i>
                                                    کد رهگیری: {{ $order->tracking_code }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                @switch($order->status)
                                                    @case('pending')
                                                        <i class="fas fa-clock"></i>
                                                        در انتظار بررسی
                                                        @break
                                                    @case('processing')
                                                        <i class="fas fa-cog"></i>
                                                        در حال پردازش
                                                        @break
                                                    @case('shipped')
                                                        <i class="fas fa-shipping-fast"></i>
                                                        ارسال شده
                                                        @break
                                                    @case('delivered')
                                                        <i class="fas fa-check-circle"></i>
                                                        تحویل شده
                                                        @break
                                                    @case('cancelled')
                                                        <i class="fas fa-times-circle"></i>
                                                        لغو شده
                                                        @break
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge payment-{{ $order->payment_status }}">
                                                @switch($order->payment_status)
                                                    @case('pending')
                                                        <i class="fas fa-clock"></i>
                                                        در انتظار پرداخت
                                                        @break
                                                    @case('paid')
                                                        <i class="fas fa-check"></i>
                                                        پرداخت شده
                                                        @break
                                                    @case('failed')
                                                        <i class="fas fa-times"></i>
                                                        پرداخت ناموفق
                                                        @break
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($order->total) }} تومان</strong>
                                        </td>
                                        <td>
                                            {{ jdate($order->created_at)->format('Y/m/d H:i') }}
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('customer.orders.show', $order) }}"
                                                   class="btn-action btn-view">
                                                    <i class="fas fa-eye"></i>
                                                    مشاهده
                                                </a>

                                                @if($order->status === 'pending')
                                                    <form method="POST"
                                                          action="{{ route('customer.orders.cancel', $order) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('آیا از لغو این سفارش اطمینان دارید؟')">
                                                        @csrf
                                                        <button type="submit" class="btn-action btn-cancel">
                                                            <i class="fas fa-times"></i>
                                                            لغو
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->appends(request()->query())->links('pagination.persian') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4>هیچ سفارشی یافت نشد</h4>
                        <p>شما هنوز هیچ سفارشی ثبت نکرده‌اید یا فیلترهای انتخابی هیچ نتیجه‌ای ندارد.</p>
                        <a href="{{ route('welcome') }}" class="btn-action btn-view mt-3">
                            <i class="fas fa-shopping-bag"></i>
                            شروع خرید
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
