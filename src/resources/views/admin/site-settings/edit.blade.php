@extends('layouts.dashboard')

@section('title', 'تنظیمات سایت')

@push('styles')
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

            @if ($errors->any())
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
                                    <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                           id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}"
                                           placeholder="نام فروشگاه" required>
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="site_description" class="form-label">توضیحات سایت</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror"
                                              id="site_description" name="site_description" rows="3"
                                              placeholder="توضیحات کوتاه در مورد سایت...">{{ old('site_description', $settings->site_description) }}</textarea>
                                    <div class="help-text">این متن در header و صفحات SEO استفاده می‌شود</div>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="file" class="form-control @error('site_logo') is-invalid @enderror mt-2"
                                           id="site_logo" name="site_logo" accept="image/*">
                                    <div class="help-text">فرمت‌های مجاز: JPG, PNG, SVG - حداکثر 2MB</div>
                                    @error('site_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                           id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}"
                                           placeholder="09123456789">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact_email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                           id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}"
                                           placeholder="info@example.com">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_address" class="form-label">آدرس</label>
                                    <textarea class="form-control @error('contact_address') is-invalid @enderror"
                                              id="contact_address" name="contact_address" rows="3"
                                              placeholder="آدرس کامل...">{{ old('contact_address', $settings->contact_address) }}</textarea>
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="working_hours" class="form-label">ساعات کاری</label>
                                    <input type="text" class="form-control @error('working_hours') is-invalid @enderror"
                                           id="working_hours" name="working_hours" value="{{ old('working_hours', $settings->working_hours) }}"
                                           placeholder="شنبه تا پنجشنبه: ۹ صبح تا ۱۸ عصر">
                                    @error('working_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="url" class="form-control @error('social_instagram') is-invalid @enderror"
                                           id="social_instagram" name="social_instagram" value="{{ old('social_instagram', $settings->social_instagram) }}"
                                           placeholder="https://instagram.com/username">
                                    @error('social_instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="social_telegram" class="form-label">📱 Telegram</label>
                                    <input type="url" class="form-control @error('social_telegram') is-invalid @enderror"
                                           id="social_telegram" name="social_telegram" value="{{ old('social_telegram', $settings->social_telegram) }}"
                                           placeholder="https://t.me/username">
                                    @error('social_telegram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="social_whatsapp" class="form-label">💬 WhatsApp</label>
                                    <input type="url" class="form-control @error('social_whatsapp') is-invalid @enderror"
                                           id="social_whatsapp" name="social_whatsapp" value="{{ old('social_whatsapp', $settings->social_whatsapp) }}"
                                           placeholder="https://wa.me/989123456789">
                                    @error('social_whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                    <textarea class="form-control @error('footer_text') is-invalid @enderror"
                                              id="footer_text" name="footer_text" rows="4"
                                              placeholder="متن توضیحی برای فوتر سایت...">{{ old('footer_text', $settings->footer_text) }}</textarea>
                                    @error('footer_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="copyright_text" class="form-label">متن کپی‌رایت</label>
                                    <input type="text" class="form-control @error('copyright_text') is-invalid @enderror"
                                           id="copyright_text" name="copyright_text" value="{{ old('copyright_text', $settings->copyright_text) }}"
                                           placeholder="تمامی حقوق محفوظ است">
                                    @error('copyright_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <textarea class="form-control @error('meta_keywords') is-invalid @enderror"
                                              id="meta_keywords" name="meta_keywords" rows="3"
                                              placeholder="اسباب بازی، کودک، لگو، عروسک">{{ old('meta_keywords', $settings->meta_keywords) }}</textarea>
                                    <div class="help-text">کلمات را با کاما جدا کنید</div>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="meta_description" class="form-label">توضیحات متا</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              id="meta_description" name="meta_description" rows="3"
                                              placeholder="توضیحات مختصری که در نتایج جستجو نمایش داده می‌شود...">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                    <div class="help-text">حداکثر ۱۶۰ کاراکتر توصیه می‌شود</div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
<script>
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
const metaHelpText = metaDescInput.nextElementSibling;

metaDescInput.addEventListener('input', function() {
    const length = this.value.length;
    const color = length > 160 ? '#dc3545' : length > 140 ? '#ffc107' : '#28a745';
    metaHelpText.innerHTML = `حداکثر ۱۶۰ کاراکتر توصیه می‌شود (فعلی: <span style="color: ${color}">${length}</span>)`;
});
</script>
@endpush
@endsection
