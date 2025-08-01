@extends('layouts.shop')

@section('title', 'پرداخت سفارش')

@push('styles')
<style>
    .payment-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .payment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .card-body {
        padding: 2rem;
    }

    .order-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.1rem;
        color: #ef394e;
        margin-top: 0.5rem;
        padding-top: 1rem;
        border-top: 2px solid #dee2e6;
    }

    .payment-options {
        display: grid;
        gap: 1rem;
    }

    .payment-option {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .payment-option:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .payment-option.selected {
        border-color: #667eea;
        background: #f8f9fa;
    }

    .payment-method {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .payment-icon {
        width: 50px;
        height: 50px;
        background: #667eea;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .payment-info h4 {
        margin: 0 0 0.5rem 0;
        color: #2c3e50;
    }

    .payment-info p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .pay-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 2rem;
    }

    .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .pay-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    .order-details {
        background: #e7f3ff;
        border: 1px solid #b3d7ff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .detail-row:last-child {
        margin-bottom: 0;
    }

    .detail-label {
        color: #0066cc;
        font-weight: 500;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-info {
        background: #cce7ff;
        color: #004085;
        border: 1px solid #99d6ff;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endpush

@section('content')
<div class="payment-container">
    <div class="payment-card">
        <div class="card-header">
            <h1 style="margin: 0;">💳 پرداخت سفارش</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">سفارش #{{ $order->order_number }}</p>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Order Details -->
            <div class="order-details">
                <h4 style="margin: 0 0 1rem 0; color: #0066cc;">📋 جزئیات سفارش</h4>
                <div class="detail-row">
                    <span class="detail-label">نام مشتری:</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">شماره تماس:</span>
                    <span>{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                    <div class="detail-row">
                        <span class="detail-label">ایمیل:</span>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">تعداد آیتم:</span>
                    <span>{{ $order->items->sum('quantity') }} عدد</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">تاریخ سفارش:</span>
                    <span>{{ persian_date($order->created_at, 'Y/m/d H:i') }}</span>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h4 style="margin: 0 0 1rem 0; color: #2c3e50;">💰 خلاصه هزینه‌ها</h4>

                <div class="summary-row">
                    <span>مجموع کالاها:</span>
                    <span>{{ number_format($order->subtotal) }} تومان</span>
                </div>

                <div class="summary-row">
                    <span>هزینه ارسال:</span>
                    <span>
                        @if($order->shipping_cost > 0)
                            {{ number_format($order->shipping_cost) }} تومان
                        @else
                            <span style="color: #28a745;">رایگان</span>
                        @endif
                    </span>
                </div>

                @if($order->discount_amount > 0)
                    <div class="summary-row">
                        <span>تخفیف:</span>
                        <span style="color: #28a745;">-{{ number_format($order->discount_amount) }} تومان</span>
                    </div>
                @endif

                <div class="summary-row">
                    <span>مبلغ قابل پرداخت:</span>
                    <span>{{ number_format($order->total) }} تومان</span>
                </div>
            </div>

            <!-- Payment Methods -->
            <h4 style="margin: 0 0 1rem 0; color: #2c3e50;">💳 روش پرداخت</h4>

            <div class="alert alert-info">
                <strong>توجه:</strong> این درگاه پرداخت در حالت تست (Sandbox) قرار دارد.
                پرداخت واقعی انجام نمی‌شود و تنها برای آزمایش عملکرد سیستم استفاده می‌شود.
            </div>

            <div class="payment-options">
                <div class="payment-option selected" data-method="zarinpal">
                    <div class="payment-method">
                        <div class="payment-icon">💳</div>
                        <div class="payment-info">
                            <h4>درگاه زرین‌پال</h4>
                            <p>پرداخت امن با کارت‌های بانکی • تست ساندباکس</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.process-payment', $order->id) }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="payment_method" value="zarinpal" id="payment_method">

                <button type="submit" class="pay-btn" id="payBtn">
                    🔒 پرداخت امن {{ number_format($order->total) }} تومان
                </button>
            </form>

            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('checkout.index') }}" style="color: #6c757d; text-decoration: none;">
                    ← بازگشت به صفحه قبل
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentMethodInput = document.getElementById('payment_method');
    const payBtn = document.getElementById('payBtn');

    // Payment method selection
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            paymentOptions.forEach(opt => opt.classList.remove('selected'));

            // Add selected class to clicked option
            this.classList.add('selected');

            // Update hidden input
            const method = this.dataset.method;
            paymentMethodInput.value = method;
        });
    });

    // Form submission
    document.getElementById('paymentForm').addEventListener('submit', function() {
        payBtn.disabled = true;
        payBtn.innerHTML = '⏳ در حال انتقال به درگاه پرداخت...';
    });
});
</script>
@endpush
@endsection
