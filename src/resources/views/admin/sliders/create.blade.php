@extends('layouts.dashboard')

@section('title', 'افزودن اسلایدر جدید')

@push('styles')
<style>
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

    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-top: 1rem;
        display: none;
    }

    .card {
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
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

    .custom-file-input:lang(fa) ~ .custom-file-label::after {
        content: "انتخاب";
    }

    .required {
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">➕ افزودن اسلایدر جدید</h1>
                    <p style="color: #6c757d; margin: 0;">اسلایدر جدید برای صفحه اصلی ایجاد کنید</p>
                </div>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
                    ← بازگشت به لیست
                </a>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h4 style="margin: 0;">🖼️ اطلاعات اسلایدر</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title" class="form-label">
                                        عنوان اسلایدر <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title') }}"
                                           placeholder="عنوان جذاب برای اسلایدر وارد کنید" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="form-label">توضیحات</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="3"
                                              placeholder="توضیحات کوتاه در مورد اسلایدر...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Button Text -->
                                <div class="form-group">
                                    <label for="button_text" class="form-label">متن دکمه</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                           id="button_text" name="button_text" value="{{ old('button_text') }}"
                                           placeholder="مثال: مشاهده محصولات">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Button URL -->
                                <div class="form-group">
                                    <label for="button_url" class="form-label">لینک دکمه</label>
                                    <input type="url" class="form-control @error('button_url') is-invalid @enderror"
                                           id="button_url" name="button_url" value="{{ old('button_url') }}"
                                           placeholder="https://example.com">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image" class="form-label">
                                        تصویر اسلایدر <span class="required">*</span>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*" required>
                                        <label class="custom-file-label" for="image">انتخاب تصویر...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        فرمت‌های مجاز: JPG, PNG, GIF, WEBP - حداکثر 2MB
                                    </small>
                                    <img id="imagePreview" class="image-preview" alt="پیش‌نمایش تصویر">
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Order -->
                                <div class="form-group">
                                    <label for="order" class="form-label">ترتیب نمایش</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                           id="order" name="order" value="{{ old('order', 0) }}"
                                           min="0" placeholder="0">
                                    <small class="form-text text-muted">
                                        عدد کمتر = نمایش زودتر
                                    </small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                                                <!-- Status -->
                                <div class="form-group">
                                    <input type="hidden" name="is_active" value="0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            <strong>فعال باشد</strong>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        فقط اسلایدرهای فعال در صفحه اصلی نمایش داده می‌شوند
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group mb-0 pt-3" style="border-top: 1px solid #e9ecef;">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
                                    انصراف
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    💾 ذخیره اسلایدر
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);

        // Update file label
        const fileName = file.name;
        const label = document.querySelector('.custom-file-label');
        label.textContent = fileName;
    }
});

// Auto-generate button URL when button text is entered
document.getElementById('button_text').addEventListener('input', function(e) {
    const buttonUrlField = document.getElementById('button_url');
    if (e.target.value && !buttonUrlField.value) {
        // You can add logic here to suggest URLs based on button text
    }
});
</script>
@endpush
@endsection
