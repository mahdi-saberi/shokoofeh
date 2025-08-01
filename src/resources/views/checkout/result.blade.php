@extends('layouts.shop')

@section('title', 'نتیجه پرداخت')

@push('styles')
<style>
    .result-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .result-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
    }

    .result-header {
        padding: 2rem;
    }

    .result-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .success .result-header {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .failed .result-header,
    .cancelled .result-header,
    .error .result-header {
        background: linear-gradient(135deg, #dc3545, #fd7e14);
        color: white;
    }

    .result-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .result-message {
        margin: 0;
        opacity: 0.9;
    }

    .result-body {
        padding: 2rem;
    }

    .order-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: right;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-top: 0.5rem;
        border-top: 1px solid #dee2e6;
        font-weight: 600;
        color: #ef394e;
    }

    .info-label {
        color: #6c757d;
    }

    .info-value {
        color: #2c3e50;
        font-weight: 500;
    }

    .ref-id {
        background: #e7f3ff;
        border: 1px solid #b3d7ff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
        font-family: monospace;
        font-size: 1.1rem;
        color: #0066cc;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    .payment-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-paid {
        background: #d4edda;
        color: #155724;
    }

    .status-failed {
        background: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')
<div class="result-container">
    <div class="result-card {{ $paymentStatus }}">
        <div class="result-header">
            @if($paymentStatus === 'success')
                <div class="result-icon">✅</div>
                <h1 class="result-title">پرداخت موفق</h1>
                <p class="result-message">{{ $message }}</p>
            @elseif($paymentStatus === 'failed')
                <div class="result-icon">❌</div>
                <h1 class="result-title">پرداخت ناموفق</h1>
                <p class="result-message">{{ $message }}</p>
            @elseif($paymentStatus === 'cancelled')
                <div class="result-icon">⏹️</div>
                <h1 class="result-title">پرداخت لغو شد</h1>
                <p class="result-message">{{ $message }}</p>
            @else
                <div class="result-icon">⚠️</div>
                <h1 class="result-title">خطا در پرداخت</h1>
                <p class="result-message">{{ $message }}</p>
            @endif
        </div>

        <div class="result-body">
            <!-- Reference ID for successful payments -->
            @if($paymentStatus === 'success' && isset($refId))
                <div class="ref-id">
                    <strong>شماره پیگیری:</strong> {{ $refId }}
                </div>
            @endif

            <!-- Order Information -->
            <div class="order-info">
                <h4 style="margin: 0 0 1rem 0; color: #2c3e50; text-align: center;">📋 اطلاعات سفارش</h4>

                <div class="info-row">
                    <span class="info-label">شماره سفارش:</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">نام مشتری:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">تاریخ سفارش:</span>
                    <span class="info-value">{{ persian_date($order->created_at, 'Y/m/d H:i') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">وضعیت پرداخت:</span>
                    <span class="status-badge status-{{ $paymentStatus === 'success' ? 'paid' : 'failed' }}">
                        {{ $order->payment_status_text }}
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">مبلغ:</span>
                    <span class="info-value">{{ number_format($order->total) }} تومان</span>
                </div>
            </div>

            <!-- Payment Details -->
            @if($paymentStatus === 'success')
                <div class="payment-details">
                    <p><strong>✅ پرداخت شما با موفقیت انجام شد.</strong></p>
                    <p>سفارش شما در حال پردازش قرار گرفته و به زودی آماده ارسال خواهد شد.</p>
                    @if($order->customer_email)
                        <p>ایمیل تأیید به آدرس {{ $order->customer_email }} ارسال شد.</p>
                    @endif
                </div>
            @elseif($paymentStatus === 'failed')
                <div class="payment-details">
                    <p><strong>❌ پرداخت ناموفق بود.</strong></p>
                    <p>در صورت کسر وجه از حساب شما، مبلغ طی ۲۴-۷۲ ساعت به حساب شما بازگردانده خواهد شد.</p>
                    <p>می‌توانید مجدداً تلاش کنید یا با پشتیبانی تماس بگیرید.</p>
                </div>
            @elseif($paymentStatus === 'cancelled')
                <div class="payment-details">
                    <p><strong>⏹️ پرداخت توسط شما لغو شد.</strong></p>
                    <p>سفارش شما همچنان در سیستم موجود است و می‌توانید مجدداً اقدام به پرداخت کنید.</p>
                </div>
            @else
                <div class="payment-details">
                    <p><strong>⚠️ خطایی در فرآیند پرداخت رخ داد.</strong></p>
                    <p>لطفاً با پشتیبانی تماس بگیرید یا مجدداً تلاش کنید.</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if($paymentStatus === 'success')
                    <a href="{{ route('welcome') }}" class="btn btn-success">
                        🛍️ ادامه خرید
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        🛒 سبد خرید
                    </a>
                @elseif($paymentStatus === 'failed' || $paymentStatus === 'cancelled')
                    <a href="{{ route('checkout.payment', $order->id) }}" class="btn btn-primary">
                        🔄 تلاش مجدد
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        🛒 سبد خرید
                    </a>
                @else
                    <a href="{{ route('welcome') }}" class="btn btn-secondary">
                        🏠 صفحه اصلی
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        🛒 سبد خرید
                    </a>
                @endif
            </div>

            @if($paymentStatus !== 'success')
                <div style="margin-top: 2rem; text-align: center;">
                    <p style="color: #6c757d; font-size: 0.9rem;">
                        در صورت بروز مشکل با شماره
                        @if($siteSettings ?? null)
                            {{ $siteSettings->contact_phone ?? '۰۲۱-۱۲۳۴۵۶۷۸' }}
                        @else
                            ۰۲۱-۱۲۳۴۵۶۷۸
                        @endif
                        تماس بگیرید.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
