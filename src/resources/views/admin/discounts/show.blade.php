@extends('layouts.dashboard')

@section('title', 'مشاهده تخفیف')

@section('content')
<style>
    .discount-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .discount-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }
    .discount-header h1 {
        margin: 0;
        color: #333;
    }
    .info-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .info-card-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    .info-card-header h3 {
        margin: 0;
        color: #495057;
    }
    .info-card-body {
        padding: 1.5rem;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    .info-item {
        margin-bottom: 1rem;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .info-value {
        color: #333;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 4px;
        border-left: 3px solid #007bff;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        color: white;
    }
    .status-active { background: #28a745; }
    .status-inactive { background: #6c757d; }
    .status-expired { background: #dc3545; }
    .status-upcoming { background: #ffc107; color: #212529; }
    .discount-type-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }
    .type-product { background: #e3f2fd; color: #1976d2; }
    .type-campaign { background: #f3e5f5; color: #7b1fa2; }
    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-left: 5px;
    }
    .btn-primary { background: #007bff; color: white; }
    .btn-warning { background: #ffc107; color: #212529; }
    .btn-secondary { background: #6c757d; color: white; }
    .btn:hover { opacity: 0.8; }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }
    .product-card {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .product-card h4 {
        margin: 0 0 0.5rem 0;
        color: #495057;
    }
    .product-card p {
        margin: 0.25rem 0;
        font-size: 0.9rem;
        color: #6c757d;
    }
    .calculations-section {
        background: #e8f5e8;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #28a745;
    }
    .calculation-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    .calculation-item:last-child {
        margin-bottom: 0;
        font-weight: bold;
        border-top: 1px solid #c3e6c3;
        padding-top: 0.5rem;
    }
</style>

<div class="discount-container">
    <div class="discount-header">
        <h1>مشاهده تخفیف: {{ $discount->title }}</h1>
        <div>
            <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-warning">ویرایش</a>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
        </div>
    </div>

    <!-- اطلاعات اصلی تخفیف -->
    <div class="info-card">
        <div class="info-card-header">
            <h3>اطلاعات اصلی تخفیف</h3>
        </div>
        <div class="info-card-body">
            <div class="info-grid">
                <div>
                    <div class="info-item">
                        <div class="info-label">عنوان:</div>
                        <div class="info-value">{{ $discount->title }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">نوع تخفیف:</div>
                        <div class="info-value">
                            <span class="discount-type-badge {{ $discount->type === 'product' ? 'type-product' : 'type-campaign' }}">
                                {{ $discount->type_display }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">نوع محاسبه:</div>
                        <div class="info-value">{{ $discount->discount_type_display }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">مقدار تخفیف:</div>
                        <div class="info-value">
                            {{ $discount->discount_type === 'percentage' ? $discount->value . '%' : number_format($discount->value) . ' تومان' }}
                        </div>
                    </div>
                </div>

                <div>
                    <div class="info-item">
                        <div class="info-label">وضعیت:</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $discount->status_display === 'فعال' ? 'active' : ($discount->status_display === 'غیرفعال' ? 'inactive' : ($discount->status_display === 'منقضی شده' ? 'expired' : 'upcoming')) }}">
                                {{ $discount->status_display }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">تاریخ شروع:</div>
                        <div class="info-value">{{ $discount->start_date->format('Y/m/d H:i') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">تاریخ پایان:</div>
                        <div class="info-value">{{ $discount->end_date->format('Y/m/d H:i') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">تاریخ ایجاد:</div>
                        <div class="info-value">{{ persian_date($discount->created_at, 'Y/m/d H:i') }}</div>
                    </div>
                </div>
            </div>

            @if($discount->description)
                <div class="info-item" style="margin-top: 1rem;">
                    <div class="info-label">توضیحات:</div>
                    <div class="info-value">{{ $discount->description }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- جزئیات تخفیف -->
    <div class="info-card">
        <div class="info-card-header">
            <h3>جزئیات و شرایط تخفیف</h3>
        </div>
        <div class="info-card-body">
            @if($discount->type === 'product')
                <div class="info-item">
                    <div class="info-label">محصول مربوطه:</div>
                    <div class="info-value">
                        @if($discount->product)
                            {{ $discount->product->title }}
                            @if($discount->product->price)
                                ({{ number_format($discount->product->price) }} تومان)
                            @endif
                        @else
                            <span style="color: #dc3545;">محصول حذف شده</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="info-item">
                    <div class="info-label">نوع هدف:</div>
                    <div class="info-value">{{ $discount->target_type_display }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">مقدار هدف:</div>
                    <div class="info-value">{{ $discount->target_value }}</div>
                </div>
            @endif

            <div class="info-grid" style="margin-top: 1rem;">
                <div class="info-item">
                    <div class="info-label">حداقل مبلغ خرید:</div>
                    <div class="info-value">
                        {{ $discount->minimum_amount ? number_format($discount->minimum_amount) . ' تومان' : 'محدودیتی ندارد' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">حداکثر مبلغ تخفیف:</div>
                    <div class="info-value">
                        {{ $discount->maximum_discount ? number_format($discount->maximum_discount) . ' تومان' : 'محدودیتی ندارد' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- محاسبه نمونه تخفیف -->
    @if($discount->isActive())
        <div class="info-card">
            <div class="info-card-header">
                <h3>محاسبه نمونه تخفیف</h3>
            </div>
            <div class="info-card-body">
                <div class="calculations-section">
                    <h4 style="margin-top: 0;">مثال محاسبه تخفیف:</h4>
                    @php
                        $samplePrice = 100000;
                        $sampleQuantity = 1;
                        $discountAmount = $discount->calculateDiscount($samplePrice, $sampleQuantity);
                        $finalPrice = $samplePrice - $discountAmount;
                    @endphp
                    <div class="calculation-item">
                        <span>قیمت اصلی (نمونه):</span>
                        <span>{{ number_format($samplePrice) }} تومان</span>
                    </div>
                    <div class="calculation-item">
                        <span>مبلغ تخفیف:</span>
                        <span>{{ number_format($discountAmount) }} تومان</span>
                    </div>
                    <div class="calculation-item">
                        <span>قیمت نهایی:</span>
                        <span>{{ number_format($finalPrice) }} تومان</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- محصولات قابل اعمال (فقط برای کمپین) -->
    @if($discount->type === 'campaign' && $applicableProducts->count() > 0)
        <div class="info-card">
            <div class="info-card-header">
                <h3>محصولات قابل اعمال تخفیف ({{ $applicableProducts->count() }} محصول)</h3>
            </div>
            <div class="info-card-body">
                <div class="products-grid">
                    @foreach($applicableProducts->take(12) as $product)
                        <div class="product-card">
                            <h4>{{ $product->title }}</h4>
                            @if($product->price)
                                <p><strong>قیمت اصلی:</strong> {{ number_format($product->price) }} تومان</p>
                                @php
                                    $productDiscountAmount = $discount->calculateDiscount($product->price);
                                    $productFinalPrice = $product->price - $productDiscountAmount;
                                @endphp
                                <p><strong>مبلغ تخفیف:</strong> {{ number_format($productDiscountAmount) }} تومان</p>
                                <p><strong>قیمت با تخفیف:</strong> {{ number_format($productFinalPrice) }} تومان</p>
                            @endif
                            <p><strong>موجودی:</strong> {{ $product->stock }} ({{ $product->stock_status }})</p>
                        </div>
                    @endforeach
                </div>
                @if($applicableProducts->count() > 12)
                    <p style="text-align: center; margin-top: 1rem; color: #6c757d;">
                        و {{ $applicableProducts->count() - 12 }} محصول دیگر...
                    </p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
