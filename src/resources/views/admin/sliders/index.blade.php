@extends('layouts.dashboard')

@section('title', 'مدیریت اسلایدرها')

@push('styles')
<style>
    .slider-image {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
    }

    .order-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 30px;
        text-align: center;
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-primary { background: #007bff; color: white; }
    .btn-info { background: #17a2b8; color: white; }
    .btn-warning { background: #ffc107; color: #212529; }
    .btn-danger { background: #dc3545; color: white; }
    .btn-success { background: #28a745; color: white; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">🖼️ مدیریت اسلایدرها</h1>
                    <p style="color: #6c757d; margin: 0;">مدیریت اسلایدرهای صفحه اصلی فروشگاه</p>
                </div>
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                    ➕ افزودن اسلایدر جدید
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters & Search -->
            <div class="card mb-4" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.sliders.index') }}">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control"
                                       placeholder="جستجو در عنوان یا توضیحات..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">🔍 جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sliders Table -->
            <div class="card" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="card-body p-0">
                    @if($sliders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th style="border: none; padding: 1rem;">ترتیب</th>
                                        <th style="border: none; padding: 1rem;">تصویر</th>
                                        <th style="border: none; padding: 1rem;">عنوان</th>
                                        <th style="border: none; padding: 1rem;">توضیحات</th>
                                        <th style="border: none; padding: 1rem;">دکمه</th>
                                        <th style="border: none; padding: 1rem;">وضعیت</th>
                                        <th style="border: none; padding: 1rem;">تاریخ ایجاد</th>
                                        <th style="border: none; padding: 1rem;">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sliders as $slider)
                                        <tr style="border-bottom: 1px solid #f1f3f4;">
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <span class="order-badge">{{ $slider->order }}</span>
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="slider-image">
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <strong style="color: #2c3e50;">{{ $slider->title }}</strong>
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                @if($slider->description)
                                                    <span style="color: #6c757d;">{{ Str::limit($slider->description, 50) }}</span>
                                                @else
                                                    <span style="color: #adb5bd; font-style: italic;">بدون توضیحات</span>
                                                @endif
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                @if($slider->button_text)
                                                    <span style="color: #007bff;">{{ $slider->button_text }}</span>
                                                @else
                                                    <span style="color: #adb5bd; font-style: italic;">بدون دکمه</span>
                                                @endif
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <span class="status-badge" style="background: {{ $slider->status_color }};">
                                                    {{ $slider->status_text }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <span style="color: #6c757d; font-size: 0.9rem;">{{ persian_date($slider->created_at) }}</span>
                                                <br><small style="color: #adb5bd;">{{ $slider->created_at->format('H:i') }}</small>
                                            </td>
                                            <td style="padding: 1rem; vertical-align: middle;">
                                                <div class="table-actions">
                                                    <a href="{{ route('admin.sliders.show', $slider) }}" class="btn-sm btn-info">
                                                        👁️ نمایش
                                                    </a>
                                                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn-sm btn-warning">
                                                        ✏️ ویرایش
                                                    </a>

                                                    <form action="{{ route('admin.sliders.toggle-status', $slider) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn-sm {{ $slider->is_active ? 'btn-danger' : 'btn-success' }}">
                                                            {{ $slider->is_active ? '🚫 غیرفعال' : '✅ فعال' }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('آیا از حذف این اسلایدر اطمینان دارید؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn-danger">
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

                        <!-- Pagination -->
                        @if($sliders->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $sliders->withQueryString()->links('pagination.custom') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 4rem; margin-bottom: 1rem;">🖼️</div>
                            <h3 style="color: #6c757d;">هیچ اسلایدری یافت نشد</h3>
                            <p style="color: #adb5bd;">اولین اسلایدر خود را ایجاد کنید</p>
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary mt-3">
                                ➕ افزودن اسلایدر
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
