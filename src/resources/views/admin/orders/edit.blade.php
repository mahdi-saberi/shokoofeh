@extends('layouts.dashboard')

@section('title', 'ویرایش سفارش')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders-admin.css') }}">
@endpush

@section('content')
<div class="orders-admin orders-fade-in">
    <!-- Header Section -->
    <div class="orders-table-container mb-4">
        <div class="orders-table-header">
            <h3 class="orders-table-title">
                <i class="fas fa-edit me-2"></i>
                ویرایش سفارش {{ $order->order_number }}
            </h3>
            <div class="orders-table-actions">
                <a href="{{ route('admin.orders.show', $order) }}" class="orders-btn orders-btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i>
                    بازگشت به جزئیات
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
                    <h4>{{ jdate($order->created_at)->format('Y/m/d') }}</h4>
                    <small>تاریخ ثبت</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="orders-edit-form">
        @csrf
        @method('PUT')

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
                        <div class="orders-form-group">
                            <label class="orders-form-label required">
                                <i class="fas fa-user me-1"></i>
                                نام و نام خانوادگی
                            </label>
                            <input type="text"
                                   name="customer_name"
                                   class="orders-form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', $order->customer_name) }}"
                                   required
                                   placeholder="نام کامل مشتری را وارد کنید">
                            @error('customer_name')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label required">
                                <i class="fas fa-phone me-1"></i>
                                شماره موبایل
                            </label>
                            <input type="text"
                                   name="customer_phone"
                                   class="orders-form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone', $order->customer_phone) }}"
                                   required
                                   placeholder="09xxxxxxxxx">
                            @error('customer_phone')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label">
                                <i class="fas fa-envelope me-1"></i>
                                ایمیل
                            </label>
                            <input type="email"
                                   name="customer_email"
                                   class="orders-form-control @error('customer_email') is-invalid @enderror"
                                   value="{{ old('customer_email', $order->customer_email) }}"
                                   placeholder="example@domain.com">
                            @error('customer_email')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label">
                                <i class="fas fa-sticky-note me-1"></i>
                                یادداشت مشتری
                            </label>
                            <textarea name="notes"
                                      class="orders-form-control @error('notes') is-invalid @enderror"
                                      rows="3"
                                      placeholder="یادداشت‌های مشتری در مورد سفارش...">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label">
                                <i class="fas fa-truck me-1"></i>
                                کد رهگیری پستی
                            </label>
                            <input type="text"
                                   name="tracking_code"
                                   class="orders-form-control @error('tracking_code') is-invalid @enderror"
                                   value="{{ old('tracking_code', $order->tracking_code) }}"
                                   placeholder="کد رهگیری ارسال شده توسط شرکت پست">
                            <div class="orders-form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                کد رهگیری پس از ارسال بسته توسط شرکت پست ارائه می‌شود
                            </div>
                            @error('tracking_code')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="orders-form-col">
                <div class="orders-card orders-card-payment orders-slide-up">
                    <div class="orders-card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            اطلاعات آدرس و ارسال
                        </h6>
                    </div>
                    <div class="orders-card-body">
                        <div class="orders-form-group">
                            <label class="orders-form-label required">
                                <i class="fas fa-home me-1"></i>
                                آدرس کامل
                            </label>
                            <textarea name="shipping_address"
                                      class="orders-form-control @error('shipping_address') is-invalid @enderror"
                                      rows="3"
                                      required
                                      placeholder="آدرس کامل تحویل گیرنده را وارد کنید...">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                            @error('shipping_address')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label required">
                                <i class="fas fa-mail-bulk me-1"></i>
                                کدپستی
                            </label>
                            <input type="text"
                                   name="postal_code"
                                   class="orders-form-control @error('postal_code') is-invalid @enderror"
                                   value="{{ old('postal_code', $order->postal_code) }}"
                                   required
                                   placeholder="مثال: 1234567890"
                                   maxlength="10">
                            @error('postal_code')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label required">
                                <i class="fas fa-city me-1"></i>
                                شهر
                            </label>
                            <input type="text"
                                   name="city"
                                   class="orders-form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city', $order->city) }}"
                                   required
                                   placeholder="نام شهر">
                            @error('city')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="orders-form-group">
                            <label class="orders-form-label">
                                <i class="fas fa-map me-1"></i>
                                استان
                            </label>
                            <input type="text"
                                   name="province"
                                   class="orders-form-control @error('province') is-invalid @enderror"
                                   value="{{ old('province', $order->province) }}"
                                   placeholder="نام استان">
                            @error('province')
                                <div class="orders-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Summary Info (Read-only) -->
                        <div class="mt-4 p-3" style="background: #f8f9fa; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                            <h6 class="mb-3 text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                خلاصه سفارش
                            </h6>
                            <div class="orders-info-grid">
                                <div class="orders-info-item">
                                    <label class="orders-info-item-label">تعداد آیتم‌ها:</label>
                                    <span class="orders-info-item-value">{{ $order->items->count() }} قلم</span>
                                </div>
                                <div class="orders-info-item">
                                    <label class="orders-info-item-label">مبلغ کل:</label>
                                    <span class="orders-info-item-value orders-payment-amount">
                                        {{ number_format($order->total) }} تومان
                                    </span>
                                </div>
                                @if($order->payment_reference_id)
                                <div class="orders-info-item">
                                    <label class="orders-info-item-label">کد پیگیری پرداخت:</label>
                                    <span class="orders-info-item-value monospace">{{ $order->payment_reference_id }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="orders-card mt-4">
            <div class="orders-card-body text-center">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button type="submit" class="orders-btn orders-btn-success orders-btn-lg">
                        <i class="fas fa-save me-2"></i>
                        ذخیره تغییرات
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}" class="orders-btn orders-btn-secondary orders-btn-lg">
                        <i class="fas fa-times me-2"></i>
                        انصراف
                    </a>
                    <button type="button" onclick="resetForm()" class="orders-btn orders-btn-warning orders-btn-lg">
                        <i class="fas fa-undo me-2"></i>
                        بازنشانی فرم
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('.orders-edit-form');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Add loading state to submit button
    form.addEventListener('submit', function() {
        submitBtn.classList.add('orders-loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>در حال ذخیره...';
    });

    // Real-time validation feedback
    const inputs = form.querySelectorAll('.orders-form-control');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.hasAttribute('required') && this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        input.addEventListener('blur', function() {
            validateField(this);
        });
    });

    // Phone number formatting
    const phoneInput = form.querySelector('input[name="customer_phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 11) value = value.substr(0, 11);
            this.value = value;
        });
    }

    // Postal code formatting
    const postalInput = form.querySelector('input[name="postal_code"]');
    if (postalInput) {
        postalInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 10) value = value.substr(0, 10);
            this.value = value;
        });
    }

    // Auto-save draft (optional)
    let autoSaveTimeout;
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveDraft();
            }, 2000);
        });
    });
});

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name');

    // Remove existing validation classes
    field.classList.remove('is-invalid', 'is-valid');

    // Required field validation
    if (field.hasAttribute('required') && value === '') {
        field.classList.add('is-invalid');
        return false;
    }

    // Email validation
    if (fieldName === 'customer_email' && value !== '') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            field.classList.add('is-invalid');
            return false;
        }
    }

    // Phone validation
    if (fieldName === 'customer_phone') {
        const phoneRegex = /^09\d{9}$/;
        if (!phoneRegex.test(value)) {
            field.classList.add('is-invalid');
            return false;
        }
    }

    // Postal code validation
    if (fieldName === 'postal_code') {
        const postalRegex = /^\d{10}$/;
        if (!postalRegex.test(value)) {
            field.classList.add('is-invalid');
            return false;
        }
    }

    field.classList.add('is-valid');
    return true;
}

function resetForm() {
    if (confirm('آیا مطمئن هستید که می‌خواهید فرم را بازنشانی کنید؟ تمام تغییرات از دست خواهد رفت.')) {
        document.querySelector('.orders-edit-form').reset();

        // Remove validation classes
        document.querySelectorAll('.orders-form-control').forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });
    }
}

function saveDraft() {
    // Save form data to localStorage for auto-recovery
    const formData = new FormData(document.querySelector('.orders-edit-form'));
    const draftData = {};

    for (let [key, value] of formData.entries()) {
        draftData[key] = value;
    }

    localStorage.setItem('order_edit_draft_{{ $order->id }}', JSON.stringify(draftData));
}

function loadDraft() {
    const savedDraft = localStorage.getItem('order_edit_draft_{{ $order->id }}');
    if (savedDraft) {
        const draftData = JSON.parse(savedDraft);

        Object.keys(draftData).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field && field.value === '') {
                field.value = draftData[key];
            }
        });
    }
}

// Load draft on page load
document.addEventListener('DOMContentLoaded', loadDraft);

// Clear draft after successful submission
window.addEventListener('beforeunload', function() {
    const form = document.querySelector('.orders-edit-form');
    if (form.querySelector('.orders-loading')) {
        localStorage.removeItem('order_edit_draft_{{ $order->id }}');
    }
});
</script>

<style>
.orders-form-label.required::after {
    content: ' *';
    color: #dc3545;
    font-weight: bold;
}

.orders-form-control.is-valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.orders-form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.orders-form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

@media (max-width: 768px) {
    .orders-form-row {
        flex-direction: column;
    }

    .d-flex.justify-content-center.gap-3 {
        flex-direction: column;
        align-items: center;
    }

    .orders-btn-lg {
        width: 100%;
        max-width: 300px;
    }
}
</style>
@endpush
@endsection
