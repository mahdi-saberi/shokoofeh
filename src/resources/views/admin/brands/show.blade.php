@extends('layouts.dashboard')

@section('title', 'نمایش برند')

@push('styles')
<style>
    .brand-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .brand-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        text-align: center;
        position: relative;
    }

    .brand-header h1 {
        margin: 0 0 10px 0;
        font-size: 2.5rem;
        font-weight: 600;
    }

    .brand-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .brand-logo-large {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin: 0 auto 20px;
        display: block;
        background: white;
    }

    .brand-logo-placeholder-large {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .brand-content {
        padding: 40px;
    }

    .info-section {
        margin-bottom: 30px;
    }

    .info-section h3 {
        color: #2c3e50;
        font-size: 1.3rem;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #2c3e50;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        min-width: 100px;
    }

    .status-active {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-inactive {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .products-section {
        margin-top: 30px;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .products-table thead {
        background: linear-gradient(135deg, #6c757d, #545b62);
        color: white;
    }

    .products-table thead th {
        padding: 15px;
        text-align: right;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .products-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.3s ease;
    }

    .products-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .products-table tbody td {
        padding: 15px;
        font-size: 0.9rem;
        color: #2c3e50;
    }

    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #e9ecef;
    }

    .product-image-placeholder {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        border-radius: 6px;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.2rem;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #545b62);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    .actions-bar {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .empty-products {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .empty-products i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-products h4 {
        margin-bottom: 10px;
        color: #495057;
    }

    @media (max-width: 768px) {
        .brand-container {
            margin: 10px;
        }

        .brand-header {
            padding: 30px 20px;
        }

        .brand-header h1 {
            font-size: 2rem;
        }

        .brand-content {
            padding: 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .actions-bar {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="brand-container">
    <div class="brand-header">
        @if($brand->logo)
            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->title }}" class="brand-logo-large">
        @else
            <div class="brand-logo-placeholder-large">
                <i class="fas fa-tag"></i>
            </div>
        @endif

        <h1>{{ $brand->title }}</h1>
        <p>{{ $brand->description ?: 'بدون توضیحات' }}</p>
    </div>

    <div class="brand-content">
        <div class="info-section">
            <h3>📋 اطلاعات کلی</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">وضعیت</div>
                    <div class="info-value">
                        <span class="status-badge {{ $brand->status ? 'status-active' : 'status-inactive' }}">
                            {{ $brand->status_text }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">تعداد محصولات</div>
                    <div class="info-value">{{ $brand->products->count() }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">تاریخ ایجاد</div>
                    <div class="info-value">{{ $brand->created_at->format('Y/m/d H:i') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">آخرین بروزرسانی</div>
                    <div class="info-value">{{ $brand->updated_at->format('Y/m/d H:i') }}</div>
                </div>
            </div>
        </div>

        @if($brand->website)
        <div class="info-section">
            <h3>🌐 وب‌سایت</h3>
            <div class="info-item">
                <div class="info-label">آدرس وب‌سایت</div>
                <div class="info-value">
                    <a href="{{ $brand->website }}" target="_blank" class="text-primary">
                        {{ $brand->website }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="products-section">
            <h3>📦 محصولات این برند</h3>

            @if($brand->products->count() > 0)
                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>تصویر</th>
                                <th>نام محصول</th>
                                <th>کد محصول</th>
                                <th>قیمت</th>
                                <th>موجودی</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brand->products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                                    @else
                                        <div class="product-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->title }}</strong>
                                </td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ number_format($product->price) }} تومان</td>
                                <td>
                                    <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stock > 0 ? $product->stock : 'ناموجود' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-primary btn-sm">
                                        👁️ نمایش
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                        ✏️ ویرایش
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-products">
                    <i class="fas fa-box-open"></i>
                    <h4>هیچ محصولی یافت نشد</h4>
                    <p>هنوز هیچ محصولی برای این برند ثبت نشده است.</p>
                </div>
            @endif
        </div>

        <div class="actions-bar">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                🔙 بازگشت به لیست
            </a>
            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning">
                ✏️ ویرایش برند
            </a>
        </div>
    </div>
</div>
@endsection
