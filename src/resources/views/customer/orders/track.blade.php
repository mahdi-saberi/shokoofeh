@extends('layouts.shop')

@section('title', 'پیگیری سفارش')

@push('styles')
<link href="{{ asset('css/shokoofeh-modern.css') }}" rel="stylesheet" />
<style>
    .track-order {
        padding: var(--space-xl) 0;
        min-height: 70vh;
    }

    .track-form {
        background: var(--gradient-card);
        border-radius: var(--radius-xl);
        padding: var(--space-xxl);
        margin-bottom: var(--space-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        text-align: center;
        max-width: 600px;
        margin: 0 auto var(--space-xl) auto;
    }

    .track-form h1 {
        margin-bottom: var(--space-lg);
        color: var(--text-primary);
        font-size: 2rem;
    }

    .track-form p {
        color: var(--text-secondary);
        margin-bottom: var(--space-xl);
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: var(--space-lg);
    }

    .form-label {
        display: block;
        margin-bottom: var(--space-sm);
        color: var(--text-primary);
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        padding: var(--space-md) var(--space-lg);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        font-size: 1rem;
        transition: all var(--transition-medium);
        text-align: center;
        font-family: monospace;
        font-size: 1.1rem;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
    }

    .btn-track {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: var(--space-md) var(--space-xxl);
        border-radius: var(--radius-lg);
        font-size: 1.1rem;
        font-weight: 600;
        transition: all var(--transition-medium);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .btn-track:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .order-result {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        margin-bottom: var(--space-xl);
    }

    .order-timeline {
        position: relative;
        padding: var(--space-xl);
    }

    .timeline-item {
        position: relative;
        padding-right: 40px;
        margin-bottom: var(--space-lg);
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        right: 0;
        top: 0;
        width: 30px;
        height: 30px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
    }

    .timeline-icon.completed {
        background: var(--success-color);
    }

    .timeline-icon.current {
        background: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.3);
    }

    .timeline-icon.pending {
        background: var(--neutral-300);
        color: var(--text-secondary);
    }

    .timeline-content h4 {
        margin: 0 0 var(--space-xs) 0;
        color: var(--text-primary);
        font-size: 1.1rem;
    }

    .timeline-content p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        right: 14px;
        top: 30px;
        width: 2px;
        height: calc(100% + var(--space-lg));
        background: var(--border-color);
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .alert {
        padding: var(--space-lg);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-lg);
        border: 1px solid;
    }

    .alert-danger {
        background: #f8d7da;
        border-color: #f5c2c7;
        color: #721c24;
    }

    .alert-info {
        background: #d1ecf1;
        border-color: #b8daff;
        color: #0c5460;
    }

    .order-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-lg);
        margin-bottom: var(--space-xl);
    }

    .summary-card {
        background: var(--gradient-card);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .summary-card h5 {
        margin: 0 0 var(--space-sm) 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .summary-card .value {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .track-form {
            padding: var(--space-xl);
        }

        .order-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container track-order">
    <div class="row">
        <div class="col-12">
            <!-- Track Form -->
            <div class="track-form">
                <h1>
                    <i class="fas fa-search text-primary me-2"></i>
                    پیگیری سفارش
                </h1>
                <p>شماره سفارش خود را وارد کنید تا وضعیت آن را بررسی کنید</p>

                <form method="POST" action="{{ route('customer.orders.track.search') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">شماره سفارش</label>
                        <input type="text"
                               name="order_number"
                               class="form-input"
                               placeholder="مثال: ORD-202508-001"
                               value="{{ request('order_number') }}"
                               required>
                        <small class="form-text text-muted">
                            شماره سفارش را می‌توانید در ایمیل تایید سفارش خود پیدا کنید
                        </small>
                    </div>

                    <button type="submit" class="btn-track">
                        <i class="fas fa-search"></i>
                        پیگیری سفارش
                    </button>
                </form>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($order))
                <!-- Order Result -->
                <div class="order-result">
                    <h2 class="mb-4">
                        <i class="fas fa-box text-primary me-2"></i>
                        نتیجه پیگیری سفارش {{ $order->order_number }}
                    </h2>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="summary-card">
                            <h5>وضعیت سفارش</h5>
                            <div class="value">
                                @switch($order->status)
                                    @case('pending') در انتظار بررسی @break
                                    @case('processing') در حال پردازش @break
                                    @case('shipped') ارسال شده @break
                                    @case('delivered') تحویل شده @break
                                    @case('cancelled') لغو شده @break
                                @endswitch
                            </div>
                        </div>

                        <div class="summary-card">
                            <h5>وضعیت پرداخت</h5>
                            <div class="value">
                                @switch($order->payment_status)
                                    @case('pending') در انتظار پرداخت @break
                                    @case('paid') پرداخت شده @break
                                    @case('failed') پرداخت ناموفق @break
                                @endswitch
                            </div>
                        </div>

                        <div class="summary-card">
                            <h5>مبلغ سفارش</h5>
                            <div class="value">{{ number_format($order->total) }} تومان</div>
                        </div>

                        @if($order->tracking_code)
                            <div class="summary-card">
                                <h5>کد رهگیری پستی</h5>
                                <div class="value text-primary">{{ $order->tracking_code }}</div>
                            </div>
                        @endif
                    </div>

                    <!-- Order Timeline -->
                    <div class="order-timeline">
                        <h3 class="mb-4">
                            <i class="fas fa-timeline text-primary me-2"></i>
                            روند پردازش سفارش
                        </h3>

                        <div class="timeline-item">
                            <div class="timeline-icon completed">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>ثبت سفارش</h4>
                                <p>{{ jdate($order->created_at)->format('Y/m/d H:i') }}</p>
                            </div>
                        </div>

                        @if($order->payment_status === 'paid')
                            <div class="timeline-item">
                                <div class="timeline-icon completed">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4>تایید پرداخت</h4>
                                    <p>{{ $order->paid_at ? jdate($order->paid_at)->format('Y/m/d H:i') : 'تایید شده' }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status === 'pending' ? 'current' : 'pending') }}">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>پردازش سفارش</h4>
                                <p>
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        در حال آماده‌سازی
                                    @elseif($order->status === 'pending')
                                        در انتظار بررسی
                                    @else
                                        منتظر تایید
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status === 'processing' ? 'current' : 'pending') }}">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>ارسال سفارش</h4>
                                <p>
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        ارسال شده
                                        @if($order->tracking_code)
                                            - کد رهگیری: {{ $order->tracking_code }}
                                        @endif
                                    @elseif($order->status === 'processing')
                                        آماده ارسال
                                    @else
                                        منتظر ارسال
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-icon {{ $order->status === 'delivered' ? 'completed' : ($order->status === 'shipped' ? 'current' : 'pending') }}">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>تحویل سفارش</h4>
                                <p>
                                    @if($order->status === 'delivered')
                                        تحویل داده شده
                                    @elseif($order->status === 'shipped')
                                        در حال ارسال
                                    @else
                                        منتظر تحویل
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($order->status === 'cancelled')
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            این سفارش لغو شده است.
                            @if($order->admin_notes)
                                <br><strong>علت:</strong> {{ $order->admin_notes }}
                            @endif
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('customer.orders.show', $order) }}" class="btn-track">
                            <i class="fas fa-eye"></i>
                            مشاهده جزئیات کامل سفارش
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    برای پیگیری سفارش، شماره سفارش خود را در فرم بالا وارد کنید.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
