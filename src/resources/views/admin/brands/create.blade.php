@extends('layouts.dashboard')

@section('title', 'افزودن برند جدید')

@push('styles')
<style>
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .form-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 5px;
        font-size: 12px;
        color: #dc3545;
    }

    .form-text {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: #667eea;
    }

    .checkbox-label {
        margin: 0;
        font-size: 14px;
        color: #2c3e50;
        cursor: pointer;
    }

    .file-upload {
        position: relative;
        display: inline-block;
        cursor: pointer;
        width: 100%;
    }

    .file-upload input[type=file] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        background: #f8f9fa;
        color: #6c757d;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-label:hover {
        border-color: #667eea;
        background: #e8f4fd;
        color: #667eea;
    }

    .file-upload-label i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 15px;
        border: 2px solid #e9ecef;
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

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .required {
        color: #dc3545;
        margin-right: 4px;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
            margin: 10px;
        }

        .form-actions {
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
<div class="form-container">
    <div class="form-header">
        <h1>🏷️ افزودن برند جدید</h1>
        <p>اطلاعات برند جدید را وارد کنید</p>
    </div>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" id="brandForm">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">
                <span class="required">*</span>
                نام برند
            </label>
            <input type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   id="title"
                   name="title"
                   value="{{ old('title') }}"
                   placeholder="نام برند را وارد کنید"
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">نام منحصر به فرد برند (حداکثر 255 کاراکتر)</small>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">توضیحات</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      id="description"
                      name="description"
                      rows="4"
                      placeholder="توضیحات برند را وارد کنید">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">توضیحات اختیاری برند (حداکثر 1000 کاراکتر)</small>
        </div>

        <div class="form-group">
            <label for="logo" class="form-label">لوگوی برند</label>
            <div class="file-upload">
                <input type="file"
                       id="logo"
                       name="logo"
                       accept="image/*"
                       onchange="previewImage(this)">
                <label for="logo" class="file-upload-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>برای انتخاب فایل کلیک کنید یا فایل را اینجا بکشید</span>
                    <br>
                    <small>فرمت‌های مجاز: JPEG, PNG, JPG, GIF (حداکثر 2MB)</small>
                </label>
            </div>
            @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="imagePreview" style="display: none;">
                <img id="previewImg" class="preview-image" alt="پیش‌نمایش لوگو">
            </div>
        </div>

        <div class="form-group">
            <label for="website" class="form-label">وب‌سایت</label>
            <input type="url"
                   class="form-control @error('website') is-invalid @enderror"
                   id="website"
                   name="website"
                   value="{{ old('website') }}"
                   placeholder="https://example.com">
            @error('website')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">آدرس وب‌سایت برند (اختیاری)</small>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox"
                       class="checkbox-input"
                       id="status"
                       name="status"
                       {{ old('status', true) ? 'checked' : '' }}>
                <label for="status" class="checkbox-label">برند فعال است</label>
            </div>
            <small class="form-text">برندهای غیرفعال در فروشگاه نمایش داده نمی‌شوند</small>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                🔙 بازگشت
            </a>
            <button type="submit" class="btn btn-primary">
                💾 ذخیره برند
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Form validation
document.getElementById('brandForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();

    if (!title) {
        e.preventDefault();
        alert('لطفاً نام برند را وارد کنید');
        document.getElementById('title').focus();
        return false;
    }

    return true;
});
</script>
@endsection
