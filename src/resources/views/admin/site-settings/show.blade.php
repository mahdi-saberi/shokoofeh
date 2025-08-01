@extends('layouts.dashboard')

@section('title', 'پیش‌نمایش تنظیمات سایت')

@push('styles')
<style>
    .preview-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .preview-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
    }

    .preview-body {
        padding: 2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #2c3e50;
        min-width: 150px;
    }

    .info-value {
        color: #6c757d;
        flex: 1;
        margin-right: 1rem;
        word-wrap: break-word;
    }

    .logo-display {
        max-width: 200px;
        max-height: 100px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .social-links {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border-radius: 20px;
        text-decoration: none;
        color: #495057;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #e9ecef;
        color: #495057;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .empty-value {
        color: #adb5bd;
        font-style: italic;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
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
                    <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">👁️ پیش‌نمایش تنظیمات سایت</h1>
                    <p style="color: #6c757d; margin: 0;">نمایش کامل تنظیمات فعلی سایت</p>
                </div>
                <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-warning">
                    ✏️ ویرایش تنظیمات
                </a>
            </div>

            <!-- Site Information -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">🏠 اطلاعات کلی سایت</h3>
                </div>
                <div class="preview-body">
                    <div class="info-item">
                        <div class="info-label">نام سایت:</div>
                        <div class="info-value">
                            <strong>{{ $settings->site_name }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">توضیحات سایت:</div>
                        <div class="info-value">
                            @if($settings->site_description)
                                {{ $settings->site_description }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">لوگو سایت:</div>
                        <div class="info-value">
                            @if($settings->site_logo)
                                <img src="{{ $settings->logo_url }}" alt="لوگو سایت" class="logo-display">
                            @else
                                <span class="empty-value">لوگو آپلود نشده</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">📞 اطلاعات تماس</h3>
                </div>
                <div class="preview-body">
                    <div class="info-item">
                        <div class="info-label">شماره تلفن:</div>
                        <div class="info-value">
                            @if($settings->contact_phone)
                                <strong>{{ $settings->formatted_phone }}</strong>
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">ایمیل:</div>
                        <div class="info-value">
                            @if($settings->contact_email)
                                <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">آدرس:</div>
                        <div class="info-value">
                            @if($settings->contact_address)
                                {{ $settings->contact_address }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">ساعات کاری:</div>
                        <div class="info-value">
                            @if($settings->working_hours)
                                {{ $settings->working_hours }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">📱 شبکه‌های اجتماعی</h3>
                </div>
                <div class="preview-body">
                    @if(count($settings->social_links) > 0)
                        <div class="social-links">
                            @foreach($settings->social_links as $platform => $link)
                                <a href="{{ $link['url'] }}" target="_blank" class="social-link">
                                    <span>{{ $link['icon'] }}</span>
                                    <span>{{ $link['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <span class="empty-value">هیچ شبکه اجتماعی تعیین نشده</span>
                    @endif
                </div>
            </div>

            <!-- Footer Content -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">📄 محتوای فوتر</h3>
                </div>
                <div class="preview-body">
                    <div class="info-item">
                        <div class="info-label">متن فوتر:</div>
                        <div class="info-value">
                            @if($settings->footer_text)
                                {{ $settings->footer_text }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">متن کپی‌رایت:</div>
                        <div class="info-value">
                            @if($settings->copyright_text)
                                {{ $settings->copyright_text }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">🔍 تنظیمات SEO</h3>
                </div>
                <div class="preview-body">
                    <div class="info-item">
                        <div class="info-label">کلمات کلیدی:</div>
                        <div class="info-value">
                            @if($settings->meta_keywords)
                                {{ $settings->meta_keywords }}
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">توضیحات متا:</div>
                        <div class="info-value">
                            @if($settings->meta_description)
                                {{ $settings->meta_description }}
                                <small style="display: block; margin-top: 0.5rem; color: #adb5bd;">
                                    ({{ strlen($settings->meta_description) }} کاراکتر)
                                </small>
                            @else
                                <span class="empty-value">تعیین نشده</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3 style="margin: 0;">ℹ️ اطلاعات سیستم</h3>
                </div>
                <div class="preview-body">
                    <div class="info-item">
                        <div class="info-label">آخرین بروزرسانی:</div>
                        <div class="info-value">
                            {{ persian_date($settings->updated_at, 'Y/m/d H:i') }}
                            <small style="display: block; margin-top: 0.25rem; color: #adb5bd;">
                                ({{ persian_date_for_humans($settings->updated_at) }})
                            </small>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">تاریخ ایجاد:</div>
                        <div class="info-value">
                            {{ persian_date($settings->created_at, 'Y/m/d H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-center">
                <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-primary btn-lg">
                    ✏️ ویرایش تنظیمات
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
