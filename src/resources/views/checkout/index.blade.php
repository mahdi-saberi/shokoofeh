@extends('layouts.shop')

@section('title', 'تکمیل خرید')

@push('styles')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    .checkout-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
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

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-family: 'Vazirmatn', sans-serif;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .required {
        color: #dc3545;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        margin-left: 1rem;
    }

    .item-info {
        flex: 1;
        margin-left: 1rem;
    }

    .item-name {
        font-weight: 500;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .item-quantity {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .item-price {
        font-weight: 600;
        color: #ef394e;
        font-size: 0.9rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.1rem;
        color: #ef394e;
    }

    .guest-register {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #dee2e6;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .submit-btn {
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
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .submit-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-grid">
        <!-- Customer Information Form -->
        <div class="checkout-card">
            <div class="card-header">
                <h2 style="margin: 0;">📋 اطلاعات مشتری</h2>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-right: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                    @csrf

                    <!-- Customer Information -->
                    <div class="form-group">
                        <label for="customer_name" class="form-label">
                            نام و نام خانوادگی <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                               value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="customer_phone" class="form-label">
                                شماره تماس <span class="required">*</span>
                            </label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                   placeholder="09123456789" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_email" class="form-label">ایمیل</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email"
                                   value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                   placeholder="example@email.com">
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <h4 style="margin: 2rem 0 1rem 0; color: #2c3e50;">📦 اطلاعات ارسال</h4>

                    <div class="form-group">
                        <label for="shipping_address" class="form-label">
                            آدرس کامل <span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address"
                                  rows="3" placeholder="آدرس کامل خود را وارد کنید..." required>{{ old('shipping_address', auth()->user()->shipping_address ?? '') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="postal_code" class="form-label">
                                کد پستی <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                   value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}" placeholder="1234567890" required>
                        </div>

                        <div class="form-group">
                            <label for="province" class="form-label">
                                استان <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="province" name="province"
                                   value="{{ old('province', auth()->user()->province ?? '') }}" placeholder="تهران" required>
                        </div>

                        <div class="form-group">
                            <label for="city" class="form-label">
                                شهر <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="city" name="city"
                                   value="{{ old('city', auth()->user()->city ?? '') }}" placeholder="تهران" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">یادداشت سفارش</label>
                        <textarea class="form-control" id="notes" name="notes"
                                  rows="2" placeholder="توضیحات اضافی (اختیاری)">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Guest Registration -->
                    @guest
                    <div class="guest-register">
                        <div class="checkbox-group">
                            <input type="checkbox" id="create_account" name="create_account" value="1">
                            <label for="create_account" style="margin: 0;">ایجاد حساب کاربری (اختیاری)</label>
                        </div>
                        <div id="password-fields" style="display: none;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label for="password" class="form-label">رمز عبور</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="حداقل 8 کاراکتر">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" placeholder="تکرار رمز عبور">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endguest

                    <button type="submit" class="submit-btn" id="submitBtn">
                        🛒 ادامه و پرداخت
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="checkout-card">
            <div class="card-header">
                <h3 style="margin: 0;">📄 خلاصه سفارش</h3>
            </div>
            <div class="card-body">
                <!-- Order Items -->
                @foreach($cartItems as $item)
                    <div class="order-item">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="item-image">
                        @else
                            <div class="item-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 0.8rem;">
                                📦
                            </div>
                        @endif

                        <div class="item-info">
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="item-quantity">تعداد: {{ $item->quantity }}</div>
                        </div>

                        <div class="item-price">
                            {{ number_format($item->total_price) }} تومان
                        </div>
                    </div>
                @endforeach

                <hr style="margin: 1.5rem 0;">

                <!-- Order Summary -->
                <div class="summary-row">
                    <span>مجموع کالاها:</span>
                    <span>{{ number_format($cartTotal) }} تومان</span>
                </div>

                <div class="summary-row">
                    <span>هزینه ارسال:</span>
                    <span>
                        @if($shippingCost > 0)
                            {{ number_format($shippingCost) }} تومان
                        @else
                            <span style="color: #28a745;">رایگان</span>
                        @endif
                    </span>
                </div>

                <div class="summary-row">
                    <span>مجموع نهایی:</span>
                    <span>{{ number_format($finalTotal) }} تومان</span>
                </div>

                @if($cartTotal < 500000)
                    <div style="background: #e7f3ff; border: 1px solid #b3d7ff; border-radius: 6px; padding: 1rem; margin-top: 1rem; font-size: 0.9rem; color: #0066cc;">
                        💡 برای ارسال رایگان {{ number_format(500000 - $cartTotal) }} تومان تا هدف باقی مانده
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createAccountCheckbox = document.getElementById('create_account');
    const passwordFields = document.getElementById('password-fields');
    const submitBtn = document.getElementById('submitBtn');

    // Toggle password fields
    if (createAccountCheckbox) {
        createAccountCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.style.display = 'block';
                document.getElementById('password').required = true;
                document.getElementById('password_confirmation').required = true;
            } else {
                passwordFields.style.display = 'none';
                document.getElementById('password').required = false;
                document.getElementById('password_confirmation').required = false;
            }
        });
    }

    // Form submission
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.textContent = '⏳ در حال پردازش...';
    });

    // Postal code validation
    document.getElementById('postal_code').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 10);
    });

    // Phone validation
    document.getElementById('customer_phone').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 11);
    });
});
</script>
@endpush
@endsection
