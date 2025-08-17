@extends('layouts.dashboard')

@section('title', 'تنظیمات سایت')

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }

    .settings-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .logo-preview {
        max-width: 200px;
        max-height: 100px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }

    .section-divider {
        border-top: 2px solid #f1f3f4;
        margin: 2rem 0;
        padding-top: 2rem;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .required {
        color: #dc3545;
    }

    .help-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .color-picker {
        width: 100%;
        height: 40px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
    }

    .feature-box-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
    }

    .feature-box-section h5 {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .feature-box-section .switch {
        margin: 0;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #667eea;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* Quill Editor Styles */
    .ql-editor {
        direction: rtl;
        text-align: right;
        font-family: 'Vazirmatn', sans-serif;
        font-size: 14px;
        min-height: 150px;
        line-height: 1.6;
        padding: 1rem;
    }

    .ql-toolbar {
        direction: rtl;
        text-align: right;
        border-radius: 8px 8px 0 0;
        border: 2px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .ql-container {
        border-radius: 0 0 8px 8px;
        border: 2px solid #e9ecef;
        border-top: 1px solid #e9ecef;
        background: white;
    }

    .ql-container:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .ql-toolbar .ql-stroke {
        stroke: #495057;
    }

    .ql-toolbar .ql-fill {
        fill: #495057;
    }

    .ql-toolbar .ql-picker {
        color: #495057;
    }

    .ql-toolbar button:hover .ql-stroke,
    .ql-toolbar button:focus .ql-stroke {
        stroke: #667eea;
    }

    .ql-toolbar button:hover .ql-fill,
    .ql-toolbar button:focus .ql-fill {
        fill: #667eea;
    }

    .ql-toolbar button.ql-active .ql-stroke {
        stroke: #667eea;
    }

    .ql-toolbar button.ql-active .ql-fill {
        fill: #667eea;
    }

    .ql-toolbar .ql-picker-options {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
                    <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">⚙️ تنظیمات سایت</h1>
                    <p style="color: #6c757d; margin: 0;">مدیریت اطلاعات header، footer و تنظیمات کلی سایت</p>
                </div>
                <a href="{{ route('admin.site-settings.show') }}" class="btn btn-outline-info">
                    👁️ پیش‌نمایش
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors && $errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Site Information -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">🏠 اطلاعات کلی سایت</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_name" class="form-label">
                                        نام سایت <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}"
                                           placeholder="نام فروشگاه" required>
                                </div>

                                <div class="form-group">
                                    <label for="site_description" class="form-label">توضیحات سایت</label>
                                    <textarea class="form-control"
                                              id="site_description" name="site_description" rows="3"
                                              placeholder="توضیحات کوتاه در مورد سایت...">{{ old('site_description', $settings->site_description) }}</textarea>
                                    <div class="help-text">این متن در header و صفحات SEO استفاده می‌شود</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_logo" class="form-label">لوگو سایت</label>
                                    @if($settings->site_logo)
                                        <div>
                                            <img src="{{ $settings->logo_url }}" alt="لوگو فعلی" class="logo-preview">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control  mt-2"
                                           id="site_logo" name="site_logo" accept="image/*">
                                    <div class="help-text">فرمت‌های مجاز: JPG, PNG, SVG - حداکثر 2MB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header Announcement -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">📢 تنظیمات هدر سایت</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label d-flex align-items-center">
                                        <span>فعال‌سازی نوار اعلان هدر</span>
                                        <label class="switch ms-3">
                                            <input type="checkbox" name="header_announcement_enabled" value="1"
                                                   {{ old('header_announcement_enabled', $settings->header_announcement_enabled) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </label>
                                    <div class="help-text">این گزینه نوار اعلان بالای سایت را فعال یا غیرفعال می‌کند</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="header_announcement_text" class="form-label">متن اعلان هدر</label>
                                    <textarea class="form-control "
                                              id="header_announcement_text" name="header_announcement_text" rows="3"
                                              placeholder="🎉 ویژه عید نوروز - تخفیف ویژه تمام اسباب بازی‌ها تا ۵۰٪ 🎁">{{ old('header_announcement_text', $settings->header_announcement_text) }}</textarea>
                                    <div class="help-text">متن اعلانی که در نوار بالای سایت نمایش داده می‌شود</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="header_announcement_bg_color" class="form-label">رنگ پس‌زمینه</label>
                                    <input type="color" class="color-picker "
                                           id="header_announcement_bg_color" name="header_announcement_bg_color"
                                           value="{{ old('header_announcement_bg_color', $settings->header_announcement_bg_color ?? '#667eea') }}">
                                </div>

                                <div class="form-group">
                                    <label for="header_announcement_text_color" class="form-label">رنگ متن</label>
                                    <input type="color" class="color-picker "
                                           id="header_announcement_text_color" name="header_announcement_text_color"
                                           value="{{ old('header_announcement_text_color', $settings->header_announcement_text_color ?? '#ffffff') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">📞 اطلاعات تماس</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_phone" class="form-label">شماره تلفن</label>
                                    <input type="text" class="form-control "
                                           id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}"
                                           placeholder="09123456789">
                                </div>

                                <div class="form-group">
                                    <label for="contact_email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control "
                                           id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}"
                                           placeholder="info@example.com">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_address" class="form-label">آدرس</label>
                                    <textarea class="form-control "
                                              id="contact_address" name="contact_address" rows="3"
                                              placeholder="آدرس کامل...">{{ old('contact_address', $settings->contact_address) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="working_hours" class="form-label">ساعات کاری</label>
                                    <input type="text" class="form-control "
                                           id="working_hours" name="working_hours" value="{{ old('working_hours', $settings->working_hours) }}"
                                           placeholder="شنبه تا پنجشنبه: ۹ صبح تا ۱۸ عصر">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">📱 شبکه‌های اجتماعی</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="social_instagram" class="form-label">📷 Instagram</label>
                                    <input type="url" class="form-control "
                                           id="social_instagram" name="social_instagram" value="{{ old('social_instagram', $settings->social_instagram) }}"
                                           placeholder="https://instagram.com/username">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="social_telegram" class="form-label">📱 Telegram</label>
                                    <input type="url" class="form-control "
                                           id="social_telegram" name="social_telegram" value="{{ old('social_telegram', $settings->social_telegram) }}"
                                           placeholder="https://t.me/username">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="social_whatsapp" class="form-label">💬 WhatsApp</label>
                                    <input type="url" class="form-control "
                                           id="social_whatsapp" name="social_whatsapp" value="{{ old('social_whatsapp', $settings->social_whatsapp) }}"
                                           placeholder="https://wa.me/989123456789">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Boxes -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">🎯 باکس‌های راهنمای صفحه فروشگاه</h3>
                    </div>
                    <div class="settings-body">
                        <div class="help-text mb-3">
                            این باکس‌ها در پایین صفحه اصلی فروشگاه نمایش داده می‌شوند و می‌توانید محتوای آن‌ها را شخصی‌سازی کنید.
                        </div>

                        <!-- Feature Box 1 -->
                        <div class="feature-box-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 style="color: #2c3e50; margin: 0;">باکس اول - ارسال رایگان</h5>
                                <label class="switch">
                                    <input type="checkbox" name="feature_box_1_enabled" value="1"
                                           {{ old('feature_box_1_enabled', $settings->feature_box_1_enabled) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="feature_box_1_icon" class="form-label">آیکون</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_1_icon" name="feature_box_1_icon"
                                               value="{{ old('feature_box_1_icon', $settings->feature_box_1_icon) }}"
                                               placeholder="🚚">
                                        <div class="help-text">می‌توانید از ایموجی یا متن استفاده کنید</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="feature_box_1_title" class="form-label">عنوان</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_1_title" name="feature_box_1_title"
                                               value="{{ old('feature_box_1_title', $settings->feature_box_1_title) }}"
                                               placeholder="ارسال رایگان">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feature_box_1_description" class="form-label">توضیحات</label>
                                <textarea class="form-control "
                                          id="feature_box_1_description" name="feature_box_1_description" rows="2"
                                          placeholder="برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور">{{ old('feature_box_1_description', $settings->feature_box_1_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Feature Box 2 -->
                        <div class="feature-box-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 style="color: #2c3e50; margin: 0;">باکس دوم - خرید امن</h5>
                                <label class="switch">
                                    <input type="checkbox" name="feature_box_2_enabled" value="1"
                                           {{ old('feature_box_2_enabled', $settings->feature_box_2_enabled) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="feature_box_2_icon" class="form-label">آیکون</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_2_icon" name="feature_box_2_icon"
                                               value="{{ old('feature_box_2_icon', $settings->feature_box_2_icon) }}"
                                               placeholder="🔒">
                                        <div class="help-text">می‌توانید از ایموجی یا متن استفاده کنید</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="feature_box_2_title" class="form-label">عنوان</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_2_title" name="feature_box_2_title"
                                               value="{{ old('feature_box_2_title', $settings->feature_box_2_title) }}"
                                               placeholder="خرید امن">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feature_box_2_description" class="form-label">توضیحات</label>
                                <textarea class="form-control "
                                          id="feature_box_2_description" name="feature_box_2_description" rows="2"
                                          placeholder="پرداخت آنلاین با بالاترین سطح امنیت">{{ old('feature_box_2_description', $settings->feature_box_2_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Feature Box 3 -->
                        <div class="feature-box-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 style="color: #2c3e50; margin: 0;">باکس سوم - ضمانت کیفیت</h5>
                                <label class="switch">
                                    <input type="checkbox" name="feature_box_3_enabled" value="1"
                                           {{ old('feature_box_3_enabled', $settings->feature_box_3_enabled) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="feature_box_3_icon" class="form-label">آیکون</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_3_icon" name="feature_box_3_icon"
                                               value="{{ old('feature_box_3_icon', $settings->feature_box_3_icon) }}"
                                               placeholder="🏆">
                                        <div class="help-text">می‌توانید از ایموجی یا متن استفاده کنید</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="feature_box_3_title" class="form-label">عنوان</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_3_title" name="feature_box_3_title"
                                               value="{{ old('feature_box_3_title', $settings->feature_box_3_title) }}"
                                               placeholder="ضمانت کیفیت">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feature_box_3_description" class="form-label">توضیحات</label>
                                <textarea class="form-control "
                                          id="feature_box_3_description" name="feature_box_3_description" rows="2"
                                          placeholder="تمام محصولات دارای گارانتی اصالت و کیفیت">{{ old('feature_box_3_description', $settings->feature_box_3_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Feature Box 4 -->
                        <div class="feature-box-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 style="color: #2c3e50; margin: 0;">باکس چهارم - پشتیبانی ۲۴/۷</h5>
                                <label class="switch">
                                    <input type="checkbox" name="feature_box_4_enabled" value="1"
                                           {{ old('feature_box_4_enabled', $settings->feature_box_4_enabled) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="feature_box_4_icon" class="form-label">آیکون</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_4_icon" name="feature_box_4_icon"
                                               value="{{ old('feature_box_4_icon', $settings->feature_box_4_icon) }}"
                                               placeholder="📞">
                                        <div class="help-text">می‌توانید از ایموجی یا متن استفاده کنید</div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="feature_box_4_title" class="form-label">عنوان</label>
                                        <input type="text" class="form-control "
                                               id="feature_box_4_title" name="feature_box_4_title"
                                               value="{{ old('feature_box_4_title', $settings->feature_box_4_title) }}"
                                               placeholder="پشتیبانی ۲۴/۷">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="feature_box_4_description" class="form-label">توضیحات</label>
                                <textarea class="form-control "
                                          id="feature_box_4_description" name="feature_box_4_description" rows="2"
                                          placeholder="آماده پاسخگویی در تمام ساعات شبانه‌روز">{{ old('feature_box_4_description', $settings->feature_box_4_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Content -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">📄 محتوای فوتر</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="footer_text" class="form-label">متن فوتر</label>
                                    <textarea class="form-control "
                                              id="footer_text" name="footer_text" rows="4"
                                              placeholder="متن توضیحی برای فوتر سایت...">{{ old('footer_text', $settings->footer_text) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="copyright_text" class="form-label">متن کپی‌رایت</label>
                                    <input type="text" class="form-control "
                                           id="copyright_text" name="copyright_text" value="{{ old('copyright_text', $settings->copyright_text) }}"
                                           placeholder="تمامی حقوق محفوظ است">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3 style="margin: 0;">🔍 تنظیمات SEO</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="meta_keywords" class="form-label">کلمات کلیدی</label>
                                    <textarea class="form-control "
                                              id="meta_keywords" name="meta_keywords" rows="3"
                                              placeholder="اسباب بازی، کودک، لگو، عروسک">{{ old('meta_keywords', $settings->meta_keywords) }}</textarea>
                                    <div class="help-text">کلمات را با کاما جدا کنید</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="meta_description" class="form-label">توضیحات متا</label>
                                    <textarea class="form-control "
                                              id="meta_description" name="meta_description" rows="3"
                                              placeholder="توضیحات مختصری که در نتایج جستجو نمایش داده می‌شود...">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                    <div class="help-text">حداکثر ۱۶۰ کاراکتر توصیه می‌شود</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        💾 ذخیره تنظیمات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<!-- Quill Editor -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
// Quill Editor Configuration for RTL support
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill for each textarea
    const editors = ['site_description', 'footer_text', 'contact_address'];

    editors.forEach(function(editorId) {
        const textarea = document.getElementById(editorId);
        if (textarea) {
            // Create a div for Quill
            const quillContainer = document.createElement('div');
            quillContainer.id = 'quill-' + editorId;
            quillContainer.style.marginBottom = '1rem';

            // Insert the container before the textarea
            textarea.parentNode.insertBefore(quillContainer, textarea);

            // Hide the original textarea
            textarea.style.display = 'none';

            // Initialize Quill
            const quill = new Quill('#quill-' + editorId, {
                theme: 'snow',
                direction: 'rtl',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link'],
                        ['clean']
                    ],
                    history: {
                        delay: 500,
                        maxStack: 100,
                        userOnly: true
                    }
                },
                placeholder: 'لطفاً متن را در اینجا وارد کنید...',
                formats: ['bold', 'italic', 'underline', 'list', 'bullet', 'align', 'link']
            });

            // Set initial content
            if (textarea.value) {
                quill.root.innerHTML = textarea.value;
            }

            // Update textarea on content change
            quill.on('text-change', function() {
                textarea.value = quill.root.innerHTML;
            });
        }
    });
});

// Logo preview
document.getElementById('site_logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Remove existing preview
            const existingPreview = document.querySelector('.logo-preview');
            if (existingPreview) {
                existingPreview.remove();
            }

            // Create new preview
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.className = 'logo-preview';
            preview.alt = 'پیش‌نمایش لوگو';

            // Insert after file input
            const fileInput = document.getElementById('site_logo');
            fileInput.parentNode.insertBefore(preview, fileInput.nextSibling);
        };
        reader.readAsDataURL(file);
    }
});

// Character counter for meta description
const metaDescInput = document.getElementById('meta_description');
if (metaDescInput) {
    const metaHelpText = metaDescInput.nextElementSibling;

    metaDescInput.addEventListener('input', function() {
        const length = this.value.length;
        const color = length > 160 ? '#dc3545' : length > 140 ? '#ffc107' : '#28a745';
        metaHelpText.innerHTML = `حداکثر ۱۶۰ کاراکتر توصیه می‌شود (فعلی: <span style="color: ${color}">${length}</span>)`;
    });
}
</script>
@endpush
@endsection
