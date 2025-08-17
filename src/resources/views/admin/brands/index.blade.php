@extends('layouts.dashboard')

@section('title', 'مدیریت برندها')

@push('styles')
<style>
    /* استایل مدرن و زیبا برای جداول */
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .modern-table thead th {
        padding: 18px 15px;
        text-align: right;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: none;
        position: relative;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .modern-table tbody tr:nth-child(even) {
        background-color: #fafbfc;
    }

    .modern-table tbody tr:hover {
        background-color: #e8f4fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modern-table tbody td {
        padding: 16px 15px;
        border: none;
        vertical-align: middle;
        font-size: 14px;
        color: #2c3e50;
        line-height: 1.4;
    }

    /* استایل دکمه‌های عملیات */
    .table-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .table-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .table-btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .table-btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .table-btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .table-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    /* استایل لوگو */
    .brand-logo {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }

    .brand-logo-placeholder {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 12px;
        border: 2px solid #e9ecef;
    }

    /* استایل وضعیت */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-align: center;
        min-width: 80px;
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

    /* استایل دکمه‌های اصلی */
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

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    /* استایل هدر صفحه */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
    }

    .page-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .page-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    /* استایل آمار */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* استایل پیام‌های موفقیت و خطا */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* استایل خالی بودن */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        color: #495057;
    }

    .empty-state p {
        margin-bottom: 20px;
        opacity: 0.8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
        }

        .table-actions {
            flex-direction: column;
            gap: 4px;
        }

        .table-btn {
            padding: 6px 12px;
            font-size: 0.7rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>🏷️ مدیریت برندها</h1>
    <p>مدیریت و کنترل برندهای موجود در سیستم</p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-number">{{ $brands->count() }}</div>
        <div class="stat-label">کل برندها</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $brands->where('status', true)->count() }}</div>
        <div class="stat-label">برندهای فعال</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $brands->sum('products_count') }}</div>
        <div class="stat-label">کل محصولات</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $brands->sum('active_products_count') }}</div>
        <div class="stat-label">محصولات موجود</div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>لیست برندها</h2>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        ➕ افزودن برند جدید
    </a>
</div>

@if($brands->count() > 0)
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>لوگو</th>
                    <th>نام برند</th>
                    <th>توضیحات</th>
                    <th>وب‌سایت</th>
                    <th>تعداد محصولات</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td>
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->title }}" class="brand-logo">
                        @else
                            <div class="brand-logo-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $brand->title }}</strong>
                    </td>
                    <td>
                        @if($brand->description)
                            {{ Str::limit($brand->description, 50) }}
                        @else
                            <span class="text-muted">بدون توضیحات</span>
                        @endif
                    </td>
                    <td>
                        @if($brand->website)
                            <a href="{{ $brand->website }}" target="_blank" class="text-primary">
                                {{ Str::limit($brand->website, 30) }}
                            </a>
                        @else
                            <span class="text-muted">بدون وب‌سایت</span>
                        @endif
                    </td>
                    <td>
                        <div class="products-count-info">
                            <span class="badge badge-info">{{ $brand->products_count }}</span>
                            @if($brand->active_products_count > 0)
                                <br>
                                <small class="text-success">موجود: {{ $brand->active_products_count }}</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="status-badge {{ $brand->status ? 'status-active' : 'status-inactive' }}">
                            {{ $brand->status_text }}
                        </span>
                    </td>
                    <td>
                        {{ $brand->created_at->format('Y/m/d') }}
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.brands.show', $brand) }}" class="table-btn table-btn-info">
                                👁️ نمایش
                            </a>
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="table-btn table-btn-warning">
                                ✏️ ویرایش
                            </a>
                            <form method="POST" action="{{ route('admin.brands.toggle-status', $brand) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="table-btn table-btn-success">
                                    {{ $brand->status ? '🔴 غیرفعال' : '🟢 فعال' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" style="display: inline;" onsubmit="return confirm('آیا از حذف این برند اطمینان دارید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-btn table-btn-danger">
                                    🗑️ حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-tags"></i>
        <h3>هیچ برندی یافت نشد</h3>
        <p>هنوز هیچ برندی در سیستم ثبت نشده است.</p>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            ➕ افزودن اولین برند
        </a>
    </div>
@endif
@endsection
