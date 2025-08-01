@extends('layouts.dashboard')

@section('title', 'جزئیات اسلایدر')

@push('styles')
<style>
    .slider-preview {
        max-width: 100%;
        max-height: 400px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        object-fit: cover;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0;
    }

    .info-value {
        color: #6c757d;
        text-align: left;
        flex: 1;
        margin-right: 1rem;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        color: white;
    }

    .order-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
    }

    .preview-container {
        position: relative;
        text-align: center;
        margin-bottom: 2rem;
    }

    .button-preview {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.9);
        padding: 10px 20px;
        border-radius: 25px;
        color: #007bff;
        font-weight: 600;
        text-decoration: none;
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">👁️ جزئیات اسلایدر</h1>
                    <p style="color: #6c757d; margin: 0;">نمایش کامل اطلاعات اسلایدر "{{ $slider->title }}"</p>
                </div>
                <div>
                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning me-2">
                        ✏️ ویرایش
                    </a>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
                        ← بازگشت به لیست
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <!-- Image Preview -->
                <div class="col-lg-8">
                    <div class="info-card">
                        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">🖼️ پیش‌نمایش اسلایدر</h3>
                        <div class="preview-container">
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="slider-preview">

                            @if($slider->button_text && $slider->button_url)
                                <a href="{{ $slider->button_url }}" class="button-preview" target="_blank">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>

                        @if($slider->description)
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                                <h5 style="color: #495057; margin-bottom: 0.5rem;">📝 توضیحات:</h5>
                                <p style="color: #6c757d; margin: 0; line-height: 1.6;">{{ $slider->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Slider Info -->
                <div class="col-lg-4">
                    <div class="info-card">
                        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">ℹ️ اطلاعات اسلایدر</h3>

                        <div class="info-item">
                            <div class="info-label">شناسه:</div>
                            <div class="info-value">
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 12px; border-radius: 12px; font-weight: 600;">
                                    #{{ $slider->id }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">عنوان:</div>
                            <div class="info-value">
                                <strong style="color: #2c3e50;">{{ $slider->title }}</strong>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">ترتیب نمایش:</div>
                            <div class="info-value">
                                <span class="order-badge">{{ $slider->order }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">وضعیت:</div>
                            <div class="info-value">
                                <span class="status-badge" style="background: {{ $slider->status_color }};">
                                    {{ $slider->status_text }}
                                </span>
                            </div>
                        </div>

                        @if($slider->button_text)
                            <div class="info-item">
                                <div class="info-label">متن دکمه:</div>
                                <div class="info-value">
                                    <span style="color: #007bff; font-weight: 600;">{{ $slider->button_text }}</span>
                                </div>
                            </div>
                        @endif

                        @if($slider->button_url)
                            <div class="info-item">
                                <div class="info-label">لینک دکمه:</div>
                                <div class="info-value">
                                    <a href="{{ $slider->button_url }}" target="_blank" style="color: #007bff; word-break: break-all;">
                                        {{ Str::limit($slider->button_url, 30) }}
                                        <i class="fas fa-external-link-alt" style="font-size: 0.8rem; margin-right: 0.25rem;"></i>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="info-item">
                            <div class="info-label">تاریخ ایجاد:</div>
                            <div class="info-value">
                                <div>{{ persian_date($slider->created_at, 'Y/m/d H:i') }}</div>
                                <small style="color: #adb5bd;">{{ persian_date_for_humans($slider->created_at) }}</small>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">آخرین بروزرسانی:</div>
                            <div class="info-value">
                                <div>{{ persian_date($slider->updated_at, 'Y/m/d H:i') }}</div>
                                <small style="color: #adb5bd;">{{ persian_date_for_humans($slider->updated_at) }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="info-card">
                        <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">⚡ عملیات</h3>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning">
                                ✏️ ویرایش اسلایدر
                            </a>

                            <form action="{{ route('admin.sliders.toggle-status', $slider) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $slider->is_active ? 'btn-danger' : 'btn-success' }} w-100">
                                    {{ $slider->is_active ? '🚫 غیرفعال کردن' : '✅ فعال کردن' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                  onsubmit="return confirm('آیا از حذف این اسلایدر اطمینان دارید؟ این عمل قابل بازگشت نیست.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    🗑️ حذف اسلایدر
                                </button>
                            </form>

                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                                ➕ اسلایدر جدید
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
