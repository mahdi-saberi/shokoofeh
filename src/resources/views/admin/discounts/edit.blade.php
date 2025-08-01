@extends('layouts.dashboard')

@section('title', 'ویرایش تخفیف')

@section('content')
<style>
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }
    .form-row {
        display: flex;
        gap: 20px;
    }
    .form-row .form-group {
        flex: 1;
    }
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .checkbox-group input[type="checkbox"] {
        width: auto;
    }
    .btn {
        padding: 12px 24px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-left: 10px;
    }
    .btn-primary { background: #007bff; color: white; }
    .btn-secondary { background: #6c757d; color: white; }
    .btn:hover { opacity: 0.8; }
    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    .header-section {
        margin-bottom: 30px;
    }
    .section-divider {
        border-top: 1px solid #dee2e6;
        margin: 30px 0;
        padding-top: 30px;
    }
    .conditional-field {
        display: none;
    }
    .conditional-field.show {
        display: block;
    }
    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <div class="header-section">
        <h2>ویرایش تخفیف</h2>
        <p style="color: #666;">ویرایش اطلاعات تخفیف موجود</p>
    </div>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.discounts.update', $discount) }}" id="discountForm">
        @csrf
        @method('PUT')

        <!-- اطلاعات اصلی -->
        <div class="form-group">
            <label for="title">عنوان تخفیف <span style="color: red;">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $discount->title) }}" required>
            <div class="help-text">عنوان توضیحی برای تخفیف</div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="type">نوع تخفیف <span style="color: red;">*</span></label>
                <select id="type" name="type" required onchange="toggleDiscountFields()">
                    <option value="">انتخاب کنید</option>
                    <option value="product" {{ old('type', $discount->type) == 'product' ? 'selected' : '' }}>تخفیف موردی (برای محصول خاص)</option>
                    <option value="campaign" {{ old('type', $discount->type) == 'campaign' ? 'selected' : '' }}>کمپین تخفیف (برای گروه محصولات)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="discount_type">نوع محاسبه تخفیف <span style="color: red;">*</span></label>
                <select id="discount_type" name="discount_type" required onchange="toggleValueField()">
                    <option value="">انتخاب کنید</option>
                    <option value="percentage" {{ old('discount_type', $discount->discount_type) == 'percentage' ? 'selected' : '' }}>درصدی</option>
                    <option value="fixed" {{ old('discount_type', $discount->discount_type) == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="value">مقدار تخفیف <span style="color: red;">*</span></label>
            <input type="number" id="value" name="value" value="{{ old('value', $discount->value) }}" step="0.01" min="0" required>
            <div class="help-text" id="valueHelp">مقدار تخفیف را وارد کنید</div>
        </div>

        <!-- فیلدهای تخفیف موردی -->
        <div id="productFields" class="conditional-field section-divider {{ old('type', $discount->type) == 'product' ? 'show' : '' }}">
            <h4>تنظیمات تخفیف موردی</h4>
            <div class="form-group">
                <label for="product_id">محصول <span style="color: red;">*</span></label>
                <select id="product_id" name="product_id">
                    <option value="">انتخاب محصول</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $discount->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->title }} - {{ number_format($product->price) }} تومان
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- فیلدهای کمپین تخفیف -->
        <div id="campaignFields" class="conditional-field section-divider {{ old('type', $discount->type) == 'campaign' ? 'show' : '' }}">
            <h4>تنظیمات کمپین تخفیف</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="target_type">نوع هدف <span style="color: red;">*</span></label>
                    <select id="target_type" name="target_type" onchange="updateTargetOptions()">
                        <option value="">انتخاب کنید</option>
                        <option value="category" {{ old('target_type', $discount->target_type) == 'category' ? 'selected' : '' }}>دسته‌بندی</option>
                        <option value="age_group" {{ old('target_type', $discount->target_type) == 'age_group' ? 'selected' : '' }}>گروه سنی</option>
                        <option value="game_type" {{ old('target_type', $discount->target_type) == 'game_type' ? 'selected' : '' }}>نوع بازی</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="target_value">مقدار هدف <span style="color: red;">*</span></label>
                    <select id="target_value" name="target_value">
                        <option value="">در حال بارگذاری...</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- تاریخ‌ها -->
        <div class="section-divider">
            <h4>بازه زمانی تخفیف</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">تاریخ شروع <span style="color: red;">*</span></label>
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date', $discount->start_date->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="form-group">
                    <label for="end_date">تاریخ پایان <span style="color: red;">*</span></label>
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date', $discount->end_date->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>
        </div>

        <!-- تنظیمات پیشرفته -->
        <div class="section-divider">
            <h4>تنظیمات پیشرفته</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="minimum_amount">حداقل مبلغ خرید (اختیاری)</label>
                    <input type="number" id="minimum_amount" name="minimum_amount" value="{{ old('minimum_amount', $discount->minimum_amount) }}" step="0.01" min="0">
                    <div class="help-text">حداقل مبلغ خرید برای اعمال تخفیف</div>
                </div>
                <div class="form-group">
                    <label for="maximum_discount">حداکثر مبلغ تخفیف (اختیاری)</label>
                    <input type="number" id="maximum_discount" name="maximum_discount" value="{{ old('maximum_discount', $discount->maximum_discount) }}" step="0.01" min="0">
                    <div class="help-text">حداکثر مبلغ تخفیف قابل اعمال</div>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                    <label for="is_active">تخفیف فعال باشد</label>
                </div>
            </div>

            <div class="form-group">
                <label for="description">توضیحات (اختیاری)</label>
                <textarea id="description" name="description">{{ old('description', $discount->description) }}</textarea>
                <div class="help-text">توضیحات اضافی در مورد تخفیف</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">بروزرسانی تخفیف</button>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">لغو</a>
        </div>
    </form>
</div>

<script>
    // تنظیمات اولیه
    document.addEventListener('DOMContentLoaded', function() {
        toggleDiscountFields();
        toggleValueField();
        updateTargetOptions();
    });

    function toggleDiscountFields() {
        const type = document.getElementById('type').value;
        const productFields = document.getElementById('productFields');
        const campaignFields = document.getElementById('campaignFields');

        // پنهان کردن همه فیلدها
        productFields.classList.remove('show');
        campaignFields.classList.remove('show');

        // نمایش فیلدهای مربوطه
        if (type === 'product') {
            productFields.classList.add('show');
            document.getElementById('product_id').required = true;
            document.getElementById('target_type').required = false;
            document.getElementById('target_value').required = false;
        } else if (type === 'campaign') {
            campaignFields.classList.add('show');
            document.getElementById('product_id').required = false;
            document.getElementById('target_type').required = true;
            document.getElementById('target_value').required = true;
        }
    }

    function toggleValueField() {
        const discountType = document.getElementById('discount_type').value;
        const valueHelp = document.getElementById('valueHelp');
        const valueField = document.getElementById('value');

        if (discountType === 'percentage') {
            valueHelp.textContent = 'درصد تخفیف (0 تا 100)';
            valueField.max = '100';
        } else if (discountType === 'fixed') {
            valueHelp.textContent = 'مبلغ تخفیف (تومان)';
            valueField.removeAttribute('max');
        } else {
            valueHelp.textContent = 'مقدار تخفیف را وارد کنید';
            valueField.removeAttribute('max');
        }
    }

    async function updateTargetOptions() {
        const targetType = document.getElementById('target_type').value;
        const targetValue = document.getElementById('target_value');
        const currentValue = '{{ old('target_value', $discount->target_value) }}';

        // پاک کردن گزینه‌های قبلی
        targetValue.innerHTML = '<option value="">در حال بارگذاری...</option>';

        if (!targetType) {
            targetValue.innerHTML = '<option value="">ابتدا نوع هدف را انتخاب کنید</option>';
            return;
        }

        try {
            const response = await fetch(`{{ route('admin.discounts.target-options') }}?target_type=${targetType}`);
            const options = await response.json();

            targetValue.innerHTML = '<option value="">انتخاب کنید</option>';

            Object.entries(options).forEach(([key, value]) => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = value;
                if (key === currentValue) {
                    option.selected = true;
                }
                targetValue.appendChild(option);
            });
        } catch (error) {
            console.error('خطا در دریافت گزینه‌ها:', error);
            targetValue.innerHTML = '<option value="">خطا در دریافت اطلاعات</option>';
        }
    }
</script>
@endsection
