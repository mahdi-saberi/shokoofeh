@extends('layouts.dashboard')

@section('title', 'ایجاد برچسب جدید')

@section('content')
    <div class="header">
        <h1>ایجاد برچسب جدید</h1>
        <p>افزودن برچسب جدید به سیستم</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>فرم ایجاد برچسب</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">
                        نام برچسب <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem;"
                           placeholder="مثال: اسباب بازی آموزشی"
                           required>
                    @error('name')
                        <div style="color: #e74c3c; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="color" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">
                        رنگ برچسب
                    </label>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <input type="color"
                               id="color"
                               name="color"
                               value="{{ old('color', '#95a5a6') }}"
                               style="width: 60px; height: 40px; border: none; border-radius: 6px; cursor: pointer;">
                        <input type="text"
                               value="{{ old('color', '#95a5a6') }}"
                               style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; font-family: monospace;"
                               placeholder="#95a5a6"
                               onchange="document.getElementById('color').value = this.value">
                    </div>
                    @error('color')
                        <div style="color: #e74c3c; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2c3e50;">
                        توضیحات
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; resize: vertical;"
                              placeholder="توضیحات اختیاری درباره این برچسب">{{ old('description') }}</textarea>
                    @error('description')
                        <div style="color: #e74c3c; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               style="width: 18px; height: 18px;">
                        <span style="font-weight: 600; color: #2c3e50;">برچسب فعال باشد</span>
                    </label>
                    <div style="font-size: 0.9rem; color: #6c757d; margin-top: 0.25rem;">
                        برچسب‌های غیرفعال در سایت نمایش داده نمی‌شوند
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                        ❌ انصراف
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 ایجاد برچسب
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sync color input with text input
        document.getElementById('color').addEventListener('input', function() {
            document.querySelector('input[type="text"]').value = this.value;
        });

        document.querySelector('input[type="text"]').addEventListener('input', function() {
            if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                document.getElementById('color').value = this.value;
            }
        });
    </script>
@endsection
