@extends('layouts.dashboard')

@section('title', 'مدیریت تخفیفات')

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

    /* استایل بج‌ها */
    .table-badge {
        display: inline-block;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin: 2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .table-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }

    .table-badge.type-product { background: linear-gradient(135deg, #3498db, #2980b9); }
    .table-badge.type-campaign { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
    .table-badge.status-active { background: linear-gradient(135deg, #27ae60, #229954); }
    .table-badge.status-inactive { background: linear-gradient(135deg, #95a5a6, #7f8c8d); }
    .table-badge.status-expired { background: linear-gradient(135deg, #e74c3c, #c0392b); }
    .table-badge.status-upcoming { background: linear-gradient(135deg, #f39c12, #d68910); }

    /* استایل دکمه‌های عملیات */
    .table-actions {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
    }

    .table-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.75rem;
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

    .table-btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .table-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    /* Container برای scroll */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
    }

    .filter-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .discount-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .discount-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .discount-table th {
        background: #f8f9fa;
        padding: 15px;
        text-align: right;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    .discount-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }
    .discount-table tr:hover {
        background: #f8f9fa;
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
    .btn-success { background: #28a745; color: white; }
    .btn-warning { background: #ffc107; color: #212529; }
    .btn-danger { background: #dc3545; color: white; }
    .btn-info { background: #17a2b8; color: white; }
    .btn-secondary { background: #6c757d; color: white; }
    .btn:hover { opacity: 0.8; }
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .filters {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .filter-group label {
        font-size: 12px;
        font-weight: 500;
        color: #666;
    }
    .filter-group select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        min-width: 120px;
    }
    .actions-cell {
        white-space: nowrap;
    }

    /* Mobile optimizations */
    @media (max-width: 1024px) {
        .filters {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .discount-table {
            overflow-x: auto;
        }

        .discount-table table {
            min-width: 800px;
        }
    }

    @media (max-width: 768px) {
        .header-actions {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .header-actions h2 {
            font-size: 1.3rem;
            text-align: center;
        }

        .filter-card {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .filters {
            gap: 1rem;
        }

        .filter-group select {
            padding: 1rem;
            font-size: 16px; /* Prevents zoom on iOS */
            min-height: 48px;
        }

        .discount-table {
            box-shadow: none;
            border-radius: 4px;
        }

        .discount-table th,
        .discount-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
        }

        .discount-table th {
            font-size: 0.8rem;
        }

        .actions-cell {
            white-space: normal;
        }

        .actions-cell .btn {
            display: block;
            width: 100%;
            margin: 0.25rem 0;
            padding: 0.5rem;
            font-size: 0.8rem;
            min-height: 40px;
        }

        .actions-cell form {
            margin: 0.25rem 0;
        }

        .status-badge,
        .discount-type-badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        /* Card-based layout for mobile */
        .discount-table table,
        .discount-table thead,
        .discount-table tbody,
        .discount-table th,
        .discount-table td,
        .discount-table tr {
            display: block;
        }

        .discount-table thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        .discount-table tr {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 1rem;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .discount-table td {
            border: none;
            padding: 0.5rem 0;
            position: relative;
        }

        .discount-table td:before {
            content: attr(data-label) ": ";
            font-weight: bold;
            color: #495057;
            display: inline-block;
            min-width: 100px;
        }

        .actions-cell:before {
            content: "عملیات: ";
        }
    }

    @media (max-width: 480px) {
        .header-actions {
            padding: 0 0.5rem;
        }

        .filter-card {
            margin: 0.5rem;
            padding: 0.75rem;
        }

        .filter-group label {
            font-size: 0.9rem;
        }

        .filter-group select {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .discount-table {
            margin: 0.5rem;
        }

        .discount-table tr {
            padding: 0.75rem;
        }

        .discount-table td {
            padding: 0.25rem 0;
            font-size: 0.9rem;
        }

        .discount-table td:before {
            min-width: 80px;
            font-size: 0.8rem;
        }

        .actions-cell .btn {
            padding: 0.5rem;
            font-size: 0.8rem;
            min-height: 36px;
        }
    }

    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .btn {
            min-height: 48px;
        }

        .filter-group select {
            min-height: 48px;
            font-size: 16px;
        }

        .discount-table tr:hover {
            background: white;
        }

        .discount-table tr:active {
            background: #f8f9fa;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .discount-table {
            border: 2px solid #000;
        }

        .discount-table th,
        .discount-table td {
            border: 1px solid #000;
        }

        .status-badge,
        .discount-type-badge {
            border: 1px solid #000;
        }
    }
</style>
@endpush

@section('content')
<div class="header-actions">
    <h2>مدیریت تخفیفات</h2>
    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
        افزودن تخفیف جدید
    </a>
</div>

@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div class="filter-card">
    <form method="GET" action="{{ route('admin.discounts.index') }}">
        <div class="filters">
            <div class="filter-group">
                <label>نوع تخفیف:</label>
                <select name="type" onchange="this.form.submit()">
                    <option value="">همه</option>
                    <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>تخفیف موردی</option>
                    <option value="campaign" {{ request('type') == 'campaign' ? 'selected' : '' }}>کمپین تخفیف</option>
                </select>
            </div>
            <div class="filter-group">
                <label>وضعیت:</label>
                <select name="status" onchange="this.form.submit()">
                    <option value="">همه</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>منقضی شده</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>در انتظار شروع</option>
                </select>
            </div>
            <div class="filter-group">
                <label>مرتب‌سازی:</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاریخ ایجاد</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>عنوان</option>
                    <option value="value" {{ request('sort') == 'value' ? 'selected' : '' }}>مقدار تخفیف</option>
                    <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>تاریخ شروع</option>
                    <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>تاریخ پایان</option>
                </select>
            </div>
        </div>
    </form>
</div>

<div class="table-container">
    <table class="modern-table">
        <thead>
            <tr>
                <th>عنوان</th>
                <th>نوع</th>
                <th>مقدار تخفیف</th>
                <th>محصول/هدف</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($discounts as $discount)
                <tr>
                    <td>
                        <strong style="color: #2c3e50;">💰 {{ $discount->title }}</strong>
                        @if($discount->description)
                            <br><small style="color: #6c757d;">{{ Str::limit($discount->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="table-badge {{ $discount->type === 'product' ? 'type-product' : 'type-campaign' }}">
                            @if($discount->type === 'product') 🎯 @else 📢 @endif
                            {{ $discount->type_display ?? ($discount->type === 'product' ? 'تخفیف موردی' : 'کمپین تخفیف') }}
                        </span>
                    </td>
                    <td>
                        <strong style="color: #e74c3c;">
                            {{ $discount->discount_type === 'percentage' ? $discount->value . '%' : number_format($discount->value) . ' تومان' }}
                        </strong>
                        @if($discount->maximum_discount)
                            <br><small style="color: #6c757d;">حداکثر: {{ number_format($discount->maximum_discount) }} تومان</small>
                        @endif
                    </td>
                    <td>
                        @if($discount->type === 'product')
                            <span style="color: #6c757d;">{{ $discount->product ? $discount->product->title : 'محصول حذف شده' }}</span>
                        @else
                            <span style="color: #6c757d;">{{ $discount->target_type_display ?? 'همه' }}: {{ $discount->target_value ?? '' }}</span>
                        @endif
                    </td>
                    <td>
                        <span style="color: #6c757d; font-size: 0.9rem;">{{ $discount->start_date->format('Y/m/d') }}</span>
                        <br><small style="color: #adb5bd;">{{ $discount->start_date->format('H:i') }}</small>
                    </td>
                    <td>
                        <span style="color: #6c757d; font-size: 0.9rem;">{{ $discount->end_date->format('Y/m/d') }}</span>
                        <br><small style="color: #adb5bd;">{{ $discount->end_date->format('H:i') }}</small>
                    </td>
                    <td>
                        @php
                            $statusClass = 'status-inactive';
                            $statusIcon = '❌';
                            $statusText = 'غیرفعال';

                            if($discount->status_display === 'فعال' || $discount->is_active) {
                                $statusClass = 'status-active';
                                $statusIcon = '✅';
                                $statusText = 'فعال';
                            } elseif($discount->status_display === 'منقضی شده') {
                                $statusClass = 'status-expired';
                                $statusIcon = '⏰';
                                $statusText = 'منقضی شده';
                            } elseif($discount->status_display === 'در انتظار شروع') {
                                $statusClass = 'status-upcoming';
                                $statusIcon = '🕐';
                                $statusText = 'در انتظار شروع';
                            }
                        @endphp
                        <span class="table-badge {{ $statusClass }}">
                            {{ $statusIcon }} {{ $statusText }}
                        </span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.discounts.show', $discount) }}" class="table-btn table-btn-info">👁️ نمایش</a>
                            <a href="{{ route('admin.discounts.edit', $discount) }}" class="table-btn table-btn-warning">✏️ ویرایش</a>

                            <form method="POST" action="{{ route('admin.discounts.toggle-status', $discount) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="table-btn {{ $discount->is_active ? 'table-btn-secondary' : 'table-btn-success' }}">
                                    {{ $discount->is_active ? '🚫 غیرفعال' : '✅ فعال' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}" style="display: inline;"
                                  onsubmit="return confirm('آیا از حذف این تخفیف اطمینان دارید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-btn table-btn-danger">🗑️ حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="
                        text-align: center;
                        padding: 4rem 2rem;
                        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                        border-radius: 15px;
                        border: 2px dashed #dee2e6;
                    ">
                        <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.6;">💸</div>
                        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 1.5rem; font-weight: 500;">
                            هیچ تخفیفی یافت نشد!
                        </p>
                        <a href="{{ route('admin.discounts.create') }}" style="
                            background: linear-gradient(135deg, #28a745, #20c997);
                            border: none;
                            padding: 12px 30px;
                            border-radius: 25px;
                            color: white;
                            text-decoration: none;
                            font-weight: 600;
                            font-size: 0.95rem;
                            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                            transition: all 0.3s ease;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                        ">
                            ➕ ایجاد اولین تخفیف
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($discounts->hasPages())
    <div style="margin-top: 20px; text-align: center;">
        {{ $discounts->appends(request()->query())->links() }}
    </div>
@endif
@endsection
