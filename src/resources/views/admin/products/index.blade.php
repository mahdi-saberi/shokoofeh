@extends('layouts.dashboard')

@section('title', 'مدیریت محصولات')

@push('styles')
<style>
    /* استایل مدرن و زیبا برای جداول - کپی شده از dashboard */
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

    /* استایل تصاویر در جدول */
    .table-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .table-image:hover {
        transform: scale(1.1);
    }

    .table-image-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border: 2px dashed #bdc3c7;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7f8c8d;
        font-size: 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    /* استایل بج‌ها */
    .table-badge {
        display: inline-block;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin: 2px;
        box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
        transition: all 0.3s ease;
    }

    .table-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
    }

    /* بج جنسیت */
    .gender-badge {
        background: var(--gender-color);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* رنگ‌های مختلف برای badge های گروه سنی */
    .table-badge.age-1 { background: linear-gradient(135deg, #e74c3c, #c0392b); }
    .table-badge.age-2 { background: linear-gradient(135deg, #3498db, #2980b9); }
    .table-badge.age-3 { background: linear-gradient(135deg, #f39c12, #d68910); }
    .table-badge.age-4 { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
    .table-badge.age-5 { background: linear-gradient(135deg, #1abc9c, #16a085); }

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

    .table-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    /* استایل متن "تعیین نشده" */
    .table-undefined {
        color: #95a5a6;
        font-style: italic;
        font-weight: 500;
    }

    /* انیمیشن ورود جدول */
    .modern-table {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* responsive */
    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
            border-radius: 8px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
        }

        .table-image,
        .table-image-placeholder {
            width: 45px;
            height: 45px;
        }

        .table-actions {
            flex-direction: column;
            gap: 4px;
        }
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

    /* استایل فیلترها */
    .table-filters {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .filters-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .filters-header h3 {
        color: #2c3e50;
        font-size: 1.4rem;
        font-weight: 600;
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .search-section {
        display: flex;
        align-items: end;
        gap: 1rem;
        flex: 1;
    }

    .search-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
        min-width: 200px;
    }

    .search-section label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .search-input {
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .search-input:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(150px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .filter-control {
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9rem;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .filter-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    }

    /* استایل pagination زیبا */
    .pagination-container {
        margin-top: 3rem;
        padding: 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        min-width: 44px;
        min-height: 44px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
        position: relative;
    }

    .pagination .page-link:hover {
        background: #f8f9fa;
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-1px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
        font-weight: 600;
    }

    .pagination .page-item.active .page-link:hover {
        background: linear-gradient(135deg, #764ba2, #8b5cf6);
        transform: translateY(-1px);
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none;
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .pagination-info {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        background: #f8f9fa;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 500;
    }

    /* Responsive Design برای فیلترها */
    @media (max-width: 1400px) {
        .filters-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 1200px) {
        .filters-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 900px) {
        .filters-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .table-filters {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filters-header h3 {
            font-size: 1.2rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .search-group {
            min-width: unset;
        }

        .filter-actions {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            min-height: 48px;
        }

        .search-input,
        .filter-control {
            min-height: 48px;
            font-size: 16px; /* جلوگیری از zoom در iOS */
            padding: 1rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            min-width: 40px;
            min-height: 40px;
            font-size: 0.9rem;
        }

        .pagination-info {
            padding: 0.75rem 1.5rem;
            font-size: 0.8rem;
        }

        .pagination-container {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .table-filters {
            padding: 1rem;
        }

        .pagination .page-link {
            padding: 0.4rem 0.6rem;
            min-width: 36px;
            min-height: 36px;
            font-size: 0.8rem;
        }

        .pagination-info {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="table-container">
    <div class="table-header">
        <h2 class="table-title">📦 مدیریت محصولات</h2>
        <div class="table-actions">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                ➕ افزودن محصول جدید
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem 2rem; margin: 0; border-bottom: 1px solid #c3e6cb;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem 2rem; margin: 0; border-bottom: 1px solid #f5c6cb;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="table-filters">
        <div class="filters-header">
            <h3>🔍 فیلتر و جستجوی محصولات</h3>
        </div>

                <form method="GET" action="{{ route('admin.products.index') }}" class="filters-form">
            <div class="filters-grid">
                <div class="search-group">
                    <label for="search">جستجو در محصولات:</label>
                    <input type="text"
                           id="search"
                           name="search"
                           class="search-input"
                           value="{{ request('search') }}"
                           placeholder="نام یا توضیحات محصول...">
                </div>

                <div class="filter-group">
                    <label for="category">دسته‌بندی:</label>
                    <select name="category" id="category" class="filter-control">
                        <option value="">همه دسته‌ها</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->title }}" {{ request('category') == $category->title ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="game_type">نوع بازی:</label>
                    <select name="game_type" id="game_type" class="filter-control">
                        <option value="">همه انواع</option>
                        @foreach($gameTypes as $gameType)
                            <option value="{{ $gameType->title }}" {{ request('game_type') == $gameType->title ? 'selected' : '' }}>
                                {{ $gameType->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="gender">جنسیت:</label>
                    <select name="gender" id="gender" class="filter-control">
                        <option value="">همه جنسیت‌ها</option>
                        <option value="دختر" {{ request('gender') == 'دختر' ? 'selected' : '' }}>👧 دختر</option>
                        <option value="پسر" {{ request('gender') == 'پسر' ? 'selected' : '' }}>👦 پسر</option>
                        <option value="هردو" {{ request('gender') == 'هردو' ? 'selected' : '' }}>👫 هردو</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="stock_status">وضعیت موجودی:</label>
                    <select name="stock_status" id="stock_status" class="filter-control">
                        <option value="">همه محصولات</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>📦 موجود</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>⚠️ کم</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>❌ ناموجود</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort">مرتب‌سازی:</label>
                    <select name="sort" id="sort" class="filter-control">
                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>🆕 جدیدترین</option>
                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>⏰ قدیمی‌ترین</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>📝 نام (الف-ی)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>📝 نام (ی-الف)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💰 قیمت (کم به زیاد)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💰 قیمت (زیاد به کم)</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>📊 موجودی (کم به زیاد)</option>
                        <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>📊 موجودی (زیاد به کم)</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">🔍 اعمال فیلترها</button>
                @if(request()->hasAny(['search', 'category', 'game_type', 'gender', 'stock_status', 'sort']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">🗑️ پاک کردن فیلترها</a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-content">
        @if($products->count() > 0)
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>نام محصول</th>
                            <th>کد محصول</th>
                            <th>جنسیت</th>
                            <th>دسته‌بندی</th>
                            <th>نوع بازی</th>
                            <th>گروه‌های سنی</th>
                            <th>قیمت</th>
                            <th>موجودی</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="table-image">
                                    @else
                                        <div class="table-image-placeholder">
                                            🧸
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->title }}</strong>
                                    @if($product->description)
                                        <br><small style="color: #6c757d;">{{ Str::limit(strip_tags($product->description), 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($product->product_code)
                                        <code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; color: #495057;">{{ $product->product_code }}</code>
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->gender)
                                        <span class="gender-badge" style="--gender-color: {{ $product->gender_color }}">
                                            {{ $product->gender_icon }} {{ $product->gender }}
                                        </span>
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($product->category) && count($product->category) > 0)
                                        @foreach($product->category as $category)
                                            <span class="table-badge" style="background: linear-gradient(135deg, #28a745, #20c997);">{{ $category }}</span>
                                        @endforeach
                                    @elseif($product->category)
                                        <span class="table-badge" style="background: linear-gradient(135deg, #28a745, #20c997);">{{ $product->category }}</span>
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($product->game_type) && count($product->game_type) > 0)
                                        @foreach($product->game_type as $gameType)
                                            <span class="table-badge" style="background: linear-gradient(135deg, #007bff, #0056b3);">{{ $gameType }}</span>
                                        @endforeach
                                    @elseif($product->game_type)
                                        <span class="table-badge" style="background: linear-gradient(135deg, #007bff, #0056b3);">{{ $product->game_type }}</span>
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($product->age_group) && count($product->age_group) > 0)
                                        @foreach($product->age_group as $index => $age)
                                            <span class="table-badge age-{{ ($index % 5) + 1 }}">{{ $age }}</span>
                                        @endforeach
                                    @elseif($product->age_group)
                                        <span class="table-badge age-1">{{ $product->age_group }}</span>
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->price)
                                        <strong style="color: #28a745;">{{ number_format($product->price) }} تومان</strong>
                                    @else
                                        <span class="table-undefined">قیمت تعین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $stockColor = $product->stock > 10 ? '#28a745' : ($product->stock > 0 ? '#ffc107' : '#dc3545');
                                        $stockText = $product->stock > 10 ? 'موجود' : ($product->stock > 0 ? 'کم' : 'ناموجود');
                                    @endphp
                                    <span class="table-badge" style="background: {{ $stockColor }}; color: white;">
                                        {{ $product->stock }} {{ $stockText }}
                                    </span>
                                </td>
                                <td>
                                    <span style="color: #6c757d; font-size: 0.9rem;">{{ persian_date($product->created_at) }}</span>
                                    <br><small style="color: #adb5bd;">{{ $product->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.products.show', $product) }}" class="table-btn table-btn-info">👁️ نمایش</a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="table-btn table-btn-warning">✏️ ویرایش</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="table-btn table-btn-danger">🗑️ حذف</button>
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
                <div class="empty-state-icon">📦</div>
                <h3 class="empty-state-title">محصولی یافت نشد</h3>
                <p class="empty-state-text">
                    @if(request()->hasAny(['search', 'category', 'game_type', 'gender', 'stock_status']))
                        هیچ محصولی با فیلترهای انتخابی یافت نشد.<br>
                        لطفاً فیلترها را تغییر دهید یا پاک کنید.
                    @else
                        هنوز محصولی ثبت نشده است.
                    @endif
                </p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    ➕ افزودن اولین محصول
                </a>
            </div>
        @endif
    </div>

    @if($products->hasPages())
        <div class="pagination-container">
            {{ $products->appends(request()->query())->links('pagination.custom') }}
            <div class="pagination-info">
                نمایش {{ $products->firstItem() }} تا {{ $products->lastItem() }} از {{ $products->total() }} محصول
            </div>
        </div>
    @endif
</div>

<script>
    // Auto-submit form on filter change
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.table-filters form');
        const selects = form.querySelectorAll('select:not([name="sort"])');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                form.submit();
            });
        });

        // Sort change handler
        const sortSelect = form.querySelector('select[name="sort"]');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                form.submit();
            });
        }

        // Search input handler with debounce
        const searchInput = form.querySelector('input[name="search"]');
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        form.submit();
                    }
                }, 500);
            });
        }
    });
</script>
@endsection
