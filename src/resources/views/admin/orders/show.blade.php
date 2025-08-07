@extends('layouts.dashboard')

@section('title', 'جزئیات سفارش')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders-admin.css') }}">
@endpush

@section('content')
<div class="orders-admin orders-fade-in">
    <!-- Header Section -->
    <div class="orders-table-container mb-4">
        <div class="orders-table-header">
            <h3 class="orders-table-title">
                <i class="fas fa-receipt me-2"></i>
                جزئیات سفارش {{ $order->order_number }}
            </h3>
            <div class="orders-table-actions">
                <a href="{{ route('admin.orders.edit', $order) }}" class="orders-btn orders-btn-warning">
                    <i class="fas fa-edit me-1"></i>
                    ویرایش سفارش
                </a>
                <a href="{{ route('admin.orders.index') }}" class="orders-btn orders-btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i>
                    بازگشت به لیست
                </a>
            </div>
        </div>
    </div>

    <!-- Order Overview Stats -->
    <div class="orders-stats-grid">
        <div class="orders-stat-card orders-stat-card-primary">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ $order->status_text }}</h4>
                    <small>وضعیت سفارش</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card orders-stat-card-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ $order->payment_status_text }}</h4>
                    <small>وضعیت پرداخت</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card orders-stat-card-info-variant">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ number_format($order->total) }}</h4>
                    <small>مبلغ کل (تومان)</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ $order->items->count() }}</h4>
                    <small>تعداد آیتم‌ها</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="orders-form-row">
        <!-- Customer Information -->
        <div class="orders-form-col">
            <div class="orders-card orders-card-customer orders-slide-up">
                <div class="orders-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        اطلاعات سفارش‌دهنده
                    </h6>
                </div>
                <div class="orders-card-body">
                    <div class="orders-info-grid">
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">نام و نام خانوادگی:</label>
                            <span class="orders-info-item-value">{{ $order->customer_name }}</span>
                        </div>

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">شماره موبایل:</label>
                            <span class="orders-info-item-value">
                                <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $order->customer_phone }}
                                </a>
                            </span>
                        </div>

                        @if($order->customer_email)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">ایمیل:</label>
                            <span class="orders-info-item-value">
                                <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $order->customer_email }}
                                </a>
                            </span>
                        </div>
                        @endif

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">آدرس تحویل:</label>
                            <span class="orders-info-item-value">{{ $order->shipping_address }}</span>
                        </div>

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">کدپستی:</label>
                            <span class="orders-info-item-value monospace">{{ $order->postal_code }}</span>
                        </div>

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">شهر:</label>
                            <span class="orders-info-item-value">{{ $order->city }}</span>
                        </div>

                        @if($order->province)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">استان:</label>
                            <span class="orders-info-item-value">{{ $order->province }}</span>
                        </div>
                        @endif

                        @if($order->notes)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">یادداشت مشتری:</label>
                            <span class="orders-info-item-value">{{ $order->notes }}</span>
                        </div>
                        @endif

                        @if($order->tracking_code)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">کد رهگیری پستی:</label>
                            <span class="orders-info-item-value">
                                <span class="orders-badge orders-badge-info">
                                    <i class="fas fa-truck me-1"></i>{{ $order->tracking_code }}
                                </span>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="orders-form-col">
            <div class="orders-card orders-card-payment orders-slide-up">
                <div class="orders-card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        اطلاعات پرداخت
                    </h6>
                </div>
                <div class="orders-card-body">
                    <div class="orders-info-grid">
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">وضعیت پرداخت:</label>
                            <span class="orders-badge orders-badge-payment-{{ $order->payment_status }}">
                                {{ $order->payment_status_text }}
                            </span>
                        </div>

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">مبلغ کل:</label>
                            <span class="orders-info-item-value orders-payment-amount">
                                {{ number_format($order->total) }} تومان
                            </span>
                        </div>

                        @if($order->payment_reference_id)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">کد پیگیری زرین‌پال:</label>
                            <span class="orders-info-item-value monospace">{{ $order->payment_reference_id }}</span>
                        </div>
                        @endif

                        @if($order->paid_at)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">تاریخ پرداخت:</label>
                            <span class="orders-info-item-value">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ jdate($order->paid_at)->format('Y/m/d H:i') }}
                            </span>
                        </div>
                        @endif

                        @if($order->card_pan)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">شماره کارت:</label>
                            <span class="orders-info-item-value monospace">{{ $order->card_pan }}</span>
                        </div>
                        @endif

                        @if($order->payment_message)
                        <div class="orders-info-item">
                            <label class="orders-info-item-label">پیام درگاه:</label>
                            <span class="orders-info-item-value">{{ $order->payment_message }}</span>
                        </div>
                        @endif

                        <div class="orders-info-item">
                            <label class="orders-info-item-label">تاریخ ثبت سفارش:</label>
                            <span class="orders-info-item-value">
                                <i class="fas fa-calendar-plus me-1"></i>
                                {{ jdate($order->created_at)->format('Y/m/d H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="orders-card orders-card-items orders-slide-up">
        <div class="orders-card-header">
            <h6 class="mb-0">
                <i class="fas fa-shopping-cart me-2"></i>
                آیتم‌های سفارش ({{ $order->items->count() }} قلم)
            </h6>
        </div>
        <div class="orders-card-body p-0">
            <div class="orders-table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th style="width: 35%;">محصول</th>
                            <th style="width: 15%;">کد محصول</th>
                            <th style="width: 10%;">تعداد</th>
                            <th style="width: 20%;">قیمت واحد</th>
                            <th style="width: 20%;">جمع کل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="orders-fade-in">
                                <td>
                                    <div class="orders-product-info">
                                        <span class="orders-product-name">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($item->product_code)
                                        <span class="orders-product-code">{{ $item->product_code }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="orders-badge orders-badge-info">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->unit_price) }} تومان</span>
                                </td>
                                <td>
                                    <span class="orders-payment-amount">{{ number_format($item->total_price) }} تومان</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">جمع فرعی:</td>
                            <td class="fw-bold">{{ number_format($order->subtotal) }} تومان</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">هزینه ارسال:</td>
                            <td class="fw-bold">{{ number_format($order->shipping_cost) }} تومان</td>
                            <td></td>
                        </tr>
                        @if($order->discount_amount > 0)
                        <tr>
                            <td colspan="3" class="text-end fw-bold">تخفیف:</td>
                            <td class="fw-bold text-danger">-{{ number_format($order->discount_amount) }} تومان</td>
                            <td></td>
                        </tr>
                        @endif
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold fs-lg">مبلغ نهایی:</td>
                            <td class="fw-bold text-success fs-lg">{{ number_format($order->total) }} تومان</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('admin.orders.edit', $order) }}" class="orders-btn orders-btn-warning orders-btn-lg">
            <i class="fas fa-edit me-2"></i>
            ویرایش سفارش
        </a>
        <a href="{{ route('admin.orders.index') }}" class="orders-btn orders-btn-secondary orders-btn-lg">
            <i class="fas fa-list me-2"></i>
            بازگشت به لیست
        </a>
        <button onclick="window.print()" class="orders-btn orders-btn-info orders-btn-lg">
            <i class="fas fa-print me-2"></i>
            چاپ سفارش
        </button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add print styles when printing
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });

    // Add hover effects for better interaction feedback
    document.querySelectorAll('.orders-info-item-value a').forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush
@endsection
