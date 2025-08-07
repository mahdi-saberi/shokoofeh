@extends('layouts.shop')

@section('title', 'جزئیات سفارش ' . $order->order_number)

@push('styles')
<link href="{{ asset('css/shokoofeh-modern.css') }}" rel="stylesheet" />
<style>
    .order-detail {
        padding: var(--space-xl) 0;
        min-height: 70vh;
    }

    .order-header {
        background: var(--gradient-card);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        margin-bottom: var(--space-xl);
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--space-lg);
    }

    .order-info h1 {
        margin: 0;
        color: var(--text-primary);
        font-size: 1.8rem;
    }

    .order-status {
        display: flex;
        gap: var(--space-md);
        flex-wrap: wrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d1ecf1; color: #0c5460; }
    .status-shipped { background: #d4edda; color: #155724; }
    .status-delivered { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .payment-paid { background: #d4edda; color: #155724; }
    .payment-pending { background: #fff3cd; color: #856404; }
    .payment-failed { background: #f8d7da; color: #721c24; }

    .order-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-xl);
        margin-bottom: var(--space-xl);
    }

    .info-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .info-card h3 {
        margin: 0 0 var(--space-lg) 0;
        color: var(--text-primary);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: var(--space-sm) 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .info-value {
        color: var(--text-primary);
        font-weight: 600;
    }

    .items-table {
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

    .product-info {
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .product-details h5 {
        margin: 0 0 var(--space-xs) 0;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .product-code {
        color: var(--text-secondary);
        font-size: 0.8rem;
        font-family: monospace;
    }

    .price-cell {
        text-align: left;
        direction: ltr;
    }

    .summary-table {
        width: 100%;
        margin-top: var(--space-lg);
    }

    .summary-table td {
        padding: var(--space-sm) var(--space-lg);
        border: none;
    }

    .summary-row {
        border-top: 1px solid var(--border-color);
    }

    .total-row {
        background: var(--gradient-card);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .action-buttons {
        display: flex;
        gap: var(--space-md);
        justify-content: center;
        margin-top: var(--space-xl);
    }

    .btn-action {
        padding: var(--space-sm) var(--space-lg);
        border: none;
        border-radius: var(--radius-md);
        font-weight: 500;
        text-decoration: none;
        transition: all var(--transition-medium);
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--neutral-200);
        color: var(--text-primary);
    }

    .btn-secondary:hover {
        background: var(--neutral-300);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            text-align: center;
        }

        .order-grid {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container order-detail">
    <div class="row">
        <div class="col-12">
            <!-- Order Header -->
            <div class="order-header">
                <div class="order-info">
                    <h1>سفارش {{ $order->order_number }}</h1>
                    <p class="mb-0 text-muted">
                        ثبت شده در {{ jdate($order->created_at)->format('Y/m/d H:i') }}
                    </p>
                </div>

                <div class="order-status">
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
                </div>
            </div>

            <!-- Order Information Grid -->
            <div class="order-grid">
                <!-- Customer Information -->
                <div class="info-card">
                    <h3>
                        <i class="fas fa-user text-primary"></i>
                        اطلاعات مشتری
                    </h3>

                    <div class="info-row">
                        <span class="info-label">نام:</span>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">ایمیل:</span>
                        <span class="info-value">{{ $order->customer_email }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">تلفن:</span>
                        <span class="info-value">{{ $order->customer_phone }}</span>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="info-card">
                    <h3>
                        <i class="fas fa-shipping-fast text-primary"></i>
                        اطلاعات ارسال
                    </h3>

                    <div class="info-row">
                        <span class="info-label">آدرس:</span>
                        <span class="info-value">{{ $order->shipping_address }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">کد پستی:</span>
                        <span class="info-value">{{ $order->postal_code }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">شهر:</span>
                        <span class="info-value">{{ $order->city }}</span>
                    </div>

                    @if($order->tracking_code)
                        <div class="info-row">
                            <span class="info-label">کد رهگیری:</span>
                            <span class="info-value">
                                <strong class="text-primary">{{ $order->tracking_code }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="items-table">
                <h3 style="padding: var(--space-lg); margin: 0; background: var(--gradient-card);">
                    <i class="fas fa-list-alt text-primary me-2"></i>
                    آیتم‌های سفارش
                </h3>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>محصول</th>
                                <th style="width: 10%;">تعداد</th>
                                <th style="width: 15%;">قیمت واحد</th>
                                <th style="width: 15%;">جمع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <img src="{{ $item->product->image_url ?: 'https://via.placeholder.com/60x60?text=تصویر' }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="product-image">
                                            <div class="product-details">
                                                <h5>{{ $item->product_name }}</h5>
                                                @if($item->product_code)
                                                    <div class="product-code">کد: {{ $item->product_code }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="price-cell">{{ number_format($item->unit_price) }} تومان</td>
                                    <td class="price-cell">{{ number_format($item->total_price) }} تومان</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Order Summary -->
                    <table class="summary-table">
                        <tr class="summary-row">
                            <td style="width: 70%;"></td>
                            <td><strong>جمع کل محصولات:</strong></td>
                            <td class="price-cell"><strong>{{ number_format($order->subtotal) }} تومان</strong></td>
                        </tr>
                        <tr class="summary-row">
                            <td></td>
                            <td><strong>هزینه ارسال:</strong></td>
                            <td class="price-cell"><strong>{{ number_format($order->shipping_cost) }} تومان</strong></td>
                        </tr>
                        @if($order->discount_amount > 0)
                            <tr class="summary-row">
                                <td></td>
                                <td><strong>تخفیف:</strong></td>
                                <td class="price-cell"><strong class="text-success">-{{ number_format($order->discount_amount) }} تومان</strong></td>
                            </tr>
                        @endif
                        <tr class="summary-row total-row">
                            <td></td>
                            <td><strong>مبلغ نهایی:</strong></td>
                            <td class="price-cell"><strong>{{ number_format($order->total) }} تومان</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('customer.orders.index') }}" class="btn-action btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    بازگشت به لیست سفارشات
                </a>

                @if($order->status === 'pending')
                    <form method="POST"
                          action="{{ route('customer.orders.cancel', $order) }}"
                          style="display: inline;"
                          onsubmit="return confirm('آیا از لغو این سفارش اطمینان دارید؟')">
                        @csrf
                        <button type="submit" class="btn-action btn-danger">
                            <i class="fas fa-times"></i>
                            لغو سفارش
                        </button>
                    </form>
                @endif

                <button onclick="window.print()" class="btn-action btn-primary">
                    <i class="fas fa-print"></i>
                    چاپ سفارش
                </button>
            </div>
        </div>
    </div>
</div>

<style media="print">
    .action-buttons,
    .order-status,
    .navbar,
    .footer,
    .btn-action {
        display: none !important;
    }

    .container {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .order-detail {
        padding: 0 !important;
    }

    .order-header {
        border: 1px solid #ddd !important;
        margin-bottom: 20px !important;
    }

    .info-card,
    .items-table {
        border: 1px solid #ddd !important;
        break-inside: avoid;
    }
</style>
@endsection
