@extends('layouts.dashboard')

@section('title', 'ایجاد محصول جدید')

@section('content')
<style>
    .product-form-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .form-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .form-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .form-body {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-grid.single-column {
        grid-template-columns: 1fr;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fff;
        box-sizing: border-box;
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

    /* Tags Autocomplete Styles */
    .tags-autocomplete-container {
        position: relative;
    }

    .tags-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .tag-suggestion {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .tag-suggestion:hover {
        background-color: #f8f9fa;
    }

    .tag-suggestion.selected {
        background-color: #e3f2fd;
    }

    .tag-suggestion.create-new-tag {
        background-color: #f8f9fa;
        border-left: 3px solid #6c757d;
    }

    .tag-suggestion.create-new-tag:hover {
        background-color: #e9ecef;
    }

    .tag-color-preview {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
        min-height: 40px;
        padding: 0.5rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .selected-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid;
    }

    .selected-tag:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .remove-tag {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        font-size: 1.2rem;
        line-height: 1;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .remove-tag:hover {
        opacity: 1;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }

    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .file-upload-area.dragover {
        border-color: #667eea;
        background: #e8f0ff;
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #495057;
        font-weight: 500;
    }

    .file-upload-subtext {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .image-preview {
        margin-top: 1rem;
        display: none;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .multiple-images-preview,
    .videos-preview {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .preview-item {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.5rem;
        background: white;
        transition: border-color 0.3s ease;
    }

    .preview-item:hover {
        border-color: #667eea;
    }

    .preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .preview-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .preview-name {
        font-size: 0.875rem;
        color: #495057;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .preview-size {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .video-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem;
        text-align: center;
    }

    .video-icon {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        color: #667eea;
    }

    .file-upload-area.multiple,
    .file-upload-area.video {
        border: 2px dashed #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    }

    .file-upload-area.multiple:hover,
    .file-upload-area.video:hover {
        border-color: #764ba2;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .multi-select-container {
        position: relative;
    }

    .multi-select {
        min-height: 120px;
        padding: 0.5rem;
    }

    .multi-select option {
        padding: 0.5rem;
        margin: 0.25rem 0;
        border-radius: 4px;
    }

    .multi-select option:checked {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .form-help {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .rich-editor-container {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        transition: border-color 0.3s ease;
    }

    .rich-editor-container:focus-within {
        border-color: #667eea;
    }

    .editor-toolbar {
        background: #f8f9fa;
        padding: 0.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .editor-btn {
        padding: 0.5rem;
        border: none;
        background: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.875rem;
        color: #495057;
        transition: background-color 0.2s ease;
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .editor-btn:hover {
        background: #e9ecef;
    }

    .editor-btn.active {
        background: #667eea;
        color: white;
    }

    .editor-content {
        min-height: 150px;
        padding: 1rem;
        outline: none;
        direction: rtl;
        text-align: right;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }

    .form-actions {
        margin-top: 2rem;
        padding: 2rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn {
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border: 1px solid transparent;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert ul {
        margin: 0;
        padding-right: 1.5rem;
    }

    .alert li {
        margin-bottom: 0.25rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-form-container {
            margin: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .form-header {
            padding: 1.5rem 1rem;
        }

        .form-header h1 {
            font-size: 1.5rem;
        }

        .form-body {
            padding: 1.5rem 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            padding: 1rem;
            font-size: 16px; /* Prevents zoom on iOS */
        }

        .file-upload-area {
            padding: 1.5rem 1rem;
        }

        .file-upload-icon {
            font-size: 2rem;
        }

        .editor-toolbar {
            padding: 0.25rem;
            gap: 0.125rem;
        }

        .editor-btn {
            min-width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        .editor-content {
            min-height: 120px;
            padding: 0.75rem;
        }

        .form-actions {
            padding: 1.5rem 1rem;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            margin: 0.25rem 0;
        }
    }

    @media (max-width: 480px) {
        .form-header {
            padding: 1rem 0.75rem;
        }

        .form-header h1 {
            font-size: 1.3rem;
        }

        .form-body {
            padding: 1rem 0.75rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .form-control {
            padding: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }

        .editor-content {
            min-height: 100px;
            padding: 0.5rem;
        }
    }

    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .form-control {
            min-height: 48px;
            font-size: 16px;
        }

        .btn {
            min-height: 48px;
        }

        .editor-btn {
            min-width: 36px;
            height: 36px;
        }

        .file-upload-area:hover {
            border-color: #dee2e6;
            background: #f8f9fa;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .form-control {
            border-width: 2px;
        }

        .btn {
            border: 2px solid;
        }

        .rich-editor-container {
            border-width: 2px;
        }
    }
</style>

<div class="product-form-container">
    <div class="form-header">
        <h1>🧸 ایجاد محصول جدید</h1>
        <p>اطلاعات محصول جدید را وارد کنید</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

        <div class="form-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>خطاهای زیر رخ داده است:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- اطلاعات اصلی -->
            <div class="form-section">
                <h3 class="section-title">📋 اطلاعات اصلی محصول</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">عنوان محصول *</label>
                        <input type="text"
                               id="title"
                               name="title"
                               class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               value="{{ old('title') }}"
                               required
                               placeholder="نام محصول را وارد کنید">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">قیمت (تومان)</label>
                        <input type="number"
                               id="price"
                               name="price"
                               class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                               value="{{ old('price') }}"
                               min="0"
                               step="1000"
                               placeholder="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">قیمت را به تومان وارد کنید</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="category">دسته‌بندی *</label>
                        <div class="multi-select-container">
                            <select id="category"
                                    name="category[]"
                                    class="form-control multi-select {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->title }}"
                                            {{ is_array(old('category')) && in_array($category->title, old('category')) ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">برای انتخاب چند دسته‌بندی، Ctrl/Cmd را نگه دارید</div>
                    </div>

                    <div class="form-group">
                        <label for="game_type">نوع بازی *</label>
                        <div class="multi-select-container">
                            <select id="game_type"
                                    name="game_type[]"
                                    class="form-control multi-select {{ $errors->has('game_type') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($gameTypes as $gameType)
                                    <option value="{{ $gameType->title }}"
                                            {{ is_array(old('game_type')) && in_array($gameType->title, old('game_type')) ? 'selected' : '' }}>
                                        {{ $gameType->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('game_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">برای انتخاب چند نوع بازی، Ctrl/Cmd را نگه دارید</div>
                    </div>
                </div>

                <div class="form-grid single-column">
                    <div class="form-group">
                        <label for="age_group">گروه‌های سنی *</label>
                        <div class="multi-select-container">
                            <select id="age_group"
                                    name="age_group[]"
                                    class="form-control multi-select {{ $errors->has('age_group') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($ageGroups as $ageGroup)
                                    <option value="{{ $ageGroup->title }}"
                                            {{ is_array(old('age_group')) && in_array($ageGroup->title, old('age_group')) ? 'selected' : '' }}>
                                        {{ $ageGroup->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('age_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">برای انتخاب چند گروه سنی، Ctrl/Cmd را نگه دارید</div>
                    </div>
                </div>

                <div class="form-grid single-column">
                    <div class="form-group">
                        <label for="tags">برچسب‌ها (تگ‌ها)</label>
                        <div class="tags-autocomplete-container">
                            <input type="text"
                                   id="tagInput"
                                   class="form-control"
                                   placeholder="برای جستجو تایپ کنید..."
                                   autocomplete="off">
                            <div class="tags-suggestions" id="tagSuggestions"></div>
                            <div class="selected-tags" id="selectedTags">
                                <!-- Selected tags will be displayed here -->
                            </div>
                            <input type="hidden" name="tags" id="tagsInput" value="">
                        </div>
                        <div class="form-help">برچسب‌های مرتبط با محصول را انتخاب کنید</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="gender">جنسیت هدف *</label>
                        <select id="gender"
                                name="gender"
                                class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                required>
                            <option value="">انتخاب کنید</option>
                            <option value="دختر" {{ old('gender') == 'دختر' ? 'selected' : '' }}>👧 دختر</option>
                            <option value="پسر" {{ old('gender') == 'پسر' ? 'selected' : '' }}>👦 پسر</option>
                            <option value="هردو" {{ old('gender') == 'هردو' ? 'selected' : '' }}>👫 هردو</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">جنسیت هدف این محصول</div>
                    </div>

                    <div class="form-group">
                        <label for="product_code">کد محصول</label>
                        <input type="text"
                               id="product_code"
                               name="product_code"
                               class="form-control {{ $errors->has('product_code') ? 'is-invalid' : '' }}"
                               value="{{ old('product_code') }}"
                               placeholder="در صورت خالی بودن، خودکار تولید می‌شود"
                               maxlength="20">
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">کد منحصر به فرد محصول (اختیاری)</div>
                    </div>

                    <div class="form-group">
                        <label for="brand">برند</label>
                        <select id="brand"
                                name="brand"
                                class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}">
                            <option value="">انتخاب کنید</option>
                            @foreach(\App\Models\Brand::where('status', true)->orderBy('title')->get() as $brandOption)
                                <option value="{{ $brandOption->id }}" {{ old('brand_id') == $brandOption->id ? 'selected' : '' }}>
                                    {{ $brandOption->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">برند محصول (اختیاری)</div>
                    </div>
                </div>
            </div>

            <!-- تصویر محصول -->
            <div class="form-section">
                <h3 class="section-title">🖼️ تصویر محصول</h3>

                <div class="form-group">
                    <label>تصویر اصلی (اختیاری)</label>
                    <div class="file-upload-area" onclick="document.getElementById('image').click()">
                        <div class="file-upload-icon">📷</div>
                        <div class="file-upload-text">برای انتخاب تصویر اصلی کلیک کنید</div>
                        <div class="file-upload-subtext">یا فایل را اینجا بکشید و رها کنید</div>
                        <div class="file-upload-subtext">فرمت‌های مجاز: JPG, PNG, GIF, WEBP (حداکثر 2MB)</div>
                        <input type="file"
                               id="image"
                               name="image"
                               class="file-input"
                               accept="image/*">
                    </div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="image-preview" id="imagePreview">
                        <img id="previewImg" class="preview-image" alt="پیش‌نمایش تصویر">
                    </div>
                </div>

                <div class="form-group">
                    <label>تصاویر اضافی (چند تصویر)</label>
                    <div class="file-upload-area multiple" onclick="document.getElementById('images').click()">
                        <div class="file-upload-icon">🖼️</div>
                        <div class="file-upload-text">برای انتخاب تصاویر اضافی کلیک کنید</div>
                        <div class="file-upload-subtext">می‌توانید چندین تصویر انتخاب کنید</div>
                        <div class="file-upload-subtext">فرمت‌های مجاز: JPG, PNG, GIF, WEBP (حداکثر 2MB)</div>
                        <input type="file"
                               id="images"
                               name="images[]"
                               class="file-input"
                               multiple
                               accept="image/*">
                    </div>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="multiple-images-preview" id="multipleImagesPreview"></div>
                </div>

                <div class="form-group">
                    <label>ویدیوهای محصول (اختیاری)</label>
                    <div class="file-upload-area video" onclick="document.getElementById('videos').click()">
                        <div class="file-upload-icon">🎥</div>
                        <div class="file-upload-text">برای انتخاب ویدیو کلیک کنید</div>
                        <div class="file-upload-subtext">می‌توانید چندین ویدیو انتخاب کنید</div>
                        <div class="file-upload-subtext">فرمت‌های مجاز: MP4, AVI, MOV, WMV, FLV, WEBM (حداکثر 10MB)</div>
                        <input type="file"
                               id="videos"
                               name="videos[]"
                               class="file-input"
                               multiple
                               accept="video/*">
                    </div>
                    @error('videos.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="videos-preview" id="videosPreview"></div>
                </div>
            </div>

            <!-- توضیحات -->
            <div class="form-section">
                <h3 class="section-title">📝 توضیحات محصول</h3>

                <div class="form-group">
                    <label for="description">توضیحات تکمیلی</label>
                    <div class="rich-editor-container">
                        <div class="editor-toolbar">
                            <button type="button" class="editor-btn" data-command="bold" title="متن ضخیم">
                                <strong>B</strong>
                            </button>
                            <button type="button" class="editor-btn" data-command="italic" title="متن کج">
                                <em>I</em>
                            </button>
                            <button type="button" class="editor-btn" data-command="underline" title="متن زیرخط‌دار">
                                <u>U</u>
                            </button>
                            <button type="button" class="editor-btn" data-command="insertUnorderedList" title="لیست نقطه‌ای">
                                •
                            </button>
                            <button type="button" class="editor-btn" data-command="insertOrderedList" title="لیست شماره‌دار">
                                1.
                            </button>
                            <button type="button" class="editor-btn" data-command="justifyRight" title="راست‌چین">
                                ←
                            </button>
                            <button type="button" class="editor-btn" data-command="justifyCenter" title="وسط‌چین">
                                ↔
                            </button>
                            <button type="button" class="editor-btn" data-command="justifyLeft" title="چپ‌چین">
                                →
                            </button>
                            <button type="button" class="editor-btn" onclick="clearEditor()" title="پاک کردن">
                                🗑️
                            </button>
                        </div>
                        <div class="editor-content"
                             contenteditable="true"
                             id="descriptionEditor"
                             data-placeholder="توضیحات تکمیلی محصول را اینجا بنویسید...">
                            {{ old('description') }}
                        </div>
                    </div>
                    <input type="hidden" name="description" id="descriptionInput">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-help">از ابزارهای بالا برای فرمت‌دهی متن استفاده کنید</div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 ذخیره محصول
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                ↩️ انصراف
            </a>
        </div>
    </form>
</div>

<script>
    // Rich Text Editor Functions
    document.addEventListener('DOMContentLoaded', function() {
        const editor = document.getElementById('descriptionEditor');
        const hiddenInput = document.getElementById('descriptionInput');
        const toolbarButtons = document.querySelectorAll('.editor-btn[data-command]');

        // Initialize editor
        if (editor.textContent.trim() === '') {
            editor.innerHTML = '';
        }

        // Toolbar button handlers
        toolbarButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const command = this.dataset.command;

                // Set focus to editor
                editor.focus();

                // Execute command
                document.execCommand(command, false, null);

                // Update button state
                updateToolbarState();

                // Update hidden input
                updateHiddenInput();
            });
        });

        // Update toolbar button states
        function updateToolbarState() {
            toolbarButtons.forEach(button => {
                const command = button.dataset.command;
                if (document.queryCommandState(command)) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });
        }

        // Update hidden input with editor content
        function updateHiddenInput() {
            hiddenInput.value = editor.innerHTML;
        }

        // Editor event handlers
        editor.addEventListener('input', updateHiddenInput);
        editor.addEventListener('keyup', function() {
            updateToolbarState();
            updateHiddenInput();
        });

        editor.addEventListener('mouseup', function() {
            updateToolbarState();
        });

        // Handle empty editor placeholder
        editor.addEventListener('focus', function() {
            if (this.innerHTML === '') {
                this.style.color = '#495057';
            }
        });

        editor.addEventListener('blur', function() {
            if (this.innerHTML.trim() === '') {
                this.innerHTML = '';
            }
            updateHiddenInput();
        });

        // Form submission handler
        document.getElementById('productForm').addEventListener('submit', function() {
            updateHiddenInput();
        });
    });

    // Clear editor function
    function clearEditor() {
        const editor = document.getElementById('descriptionEditor');
        const hiddenInput = document.getElementById('descriptionInput');

        if (confirm('آیا می‌خواهید محتوای توضیحات پاک شود؟')) {
            editor.innerHTML = '';
            hiddenInput.value = '';
            editor.focus();
        }
    }

    // Image upload preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Multiple images preview
    document.getElementById('images').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const preview = document.getElementById('multipleImagesPreview');
        preview.innerHTML = '';

        files.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'preview-item';
                    imgContainer.innerHTML = `
                        <img src="${e.target.result}" alt="تصویر ${index + 1}" class="preview-image">
                        <div class="preview-info">
                            <span class="preview-name">${file.name}</span>
                            <span class="preview-size">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        </div>
                    `;
                    preview.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Videos preview
    document.getElementById('videos').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const preview = document.getElementById('videosPreview');
        preview.innerHTML = '';

        files.forEach((file, index) => {
            if (file.type.startsWith('video/')) {
                const videoContainer = document.createElement('div');
                videoContainer.className = 'preview-item video';
                videoContainer.innerHTML = `
                    <div class="video-preview">
                        <div class="video-icon">🎥</div>
                        <div class="preview-info">
                            <span class="preview-name">${file.name}</span>
                            <span class="preview-size">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        </div>
                    </div>
                `;
                preview.appendChild(videoContainer);
            }
        });
    });

    // Drag and drop functionality
    const uploadArea = document.querySelector('.file-upload-area');
    const fileInput = document.getElementById('image');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        uploadArea.classList.add('dragover');
    }

    function unhighlight(e) {
        uploadArea.classList.remove('dragover');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    }

    // Tags Autocomplete Functionality
    const tagInput = document.getElementById('tagInput');
    const tagSuggestions = document.getElementById('tagSuggestions');
    const selectedTags = document.getElementById('selectedTags');
    const tagsInput = document.getElementById('tagsInput');

    // Available tags data
    const availableTags = @json($tags);
    let selectedTagIds = [];

    // Show suggestions with better matching
    function showSuggestions(query) {
        if (!query.trim()) {
            tagSuggestions.style.display = 'none';
            return;
        }

        const queryLower = query.toLowerCase().trim();

        // First, find exact matches
        const exactMatches = availableTags.filter(tag =>
            tag.name.toLowerCase() === queryLower &&
            !selectedTagIds.includes(tag.id)
        );

        // Then, find partial matches starting with the query
        const startsWithMatches = availableTags.filter(tag =>
            tag.name.toLowerCase().startsWith(queryLower) &&
            !selectedTagIds.includes(tag.id) &&
            tag.name.toLowerCase() !== queryLower
        );

        // Finally, find partial matches containing the query
        const containsMatches = availableTags.filter(tag =>
            tag.name.toLowerCase().includes(queryLower) &&
            !selectedTagIds.includes(tag.id) &&
            !tag.name.toLowerCase().startsWith(queryLower) &&
            tag.name.toLowerCase() !== queryLower
        );

        // Combine all matches in priority order
        const filteredTags = [...exactMatches, ...startsWithMatches, ...containsMatches];

        let suggestionsHTML = '';

        // Add existing tag suggestions
        if (filteredTags.length > 0) {
            suggestionsHTML += filteredTags.map(tag => `
                <div class="tag-suggestion" data-tag-id="${tag.id}" data-tag-name="${tag.name}" data-tag-color="${tag.color}">
                    <div class="tag-color-preview" style="background-color: ${tag.color}"></div>
                    <span>${tag.name}</span>
                </div>
            `).join('');
        }

        // Add "create new tag" option only if no exact match exists and query is meaningful
        const hasExactMatch = availableTags.some(tag =>
            tag.name.toLowerCase() === queryLower
        );

        if (!hasExactMatch && queryLower.length > 2) {
            suggestionsHTML += `
                <div class="tag-suggestion create-new-tag" data-tag-name="${query.trim()}" data-is-new="true">
                    <div class="tag-color-preview" style="background-color: #6c757d"></div>
                    <span>➕ ایجاد تگ جدید: "${query.trim()}"</span>
                </div>
            `;
        }

        if (suggestionsHTML) {
            tagSuggestions.innerHTML = suggestionsHTML;
            tagSuggestions.style.display = 'block';
        } else {
            tagSuggestions.style.display = 'none';
        }
    }

    // Add tag to selected tags
    function addTag(tagId, tagName, tagColor, isNew = false) {
        // For new tags, we'll use a temporary ID
        const actualTagId = isNew ? `new_${Date.now()}` : tagId;

        if (selectedTagIds.includes(actualTagId)) return;

        selectedTagIds.push(actualTagId);

        const tagElement = document.createElement('div');
        tagElement.className = 'selected-tag';
        tagElement.style.backgroundColor = tagColor + '20';
        tagElement.style.color = tagColor;
        tagElement.style.borderColor = tagColor + '40';
        tagElement.dataset.tagId = actualTagId;
        tagElement.dataset.tagName = tagName;
        tagElement.dataset.isNew = isNew;

        tagElement.innerHTML = `
            <span>${tagName}</span>
            <button type="button" class="remove-tag" onclick="removeTag('${actualTagId}')">×</button>
        `;

        selectedTags.appendChild(tagElement);
        updateTagsInput();
    }

    // Remove tag from selected tags
    function removeTag(tagId) {
        selectedTagIds = selectedTagIds.filter(id => id !== tagId);
        const tagElement = selectedTags.querySelector(`[data-tag-id="${tagId}"]`);
        if (tagElement) {
            tagElement.remove();
        }
        updateTagsInput();
    }

    // Update hidden input with selected tag IDs and new tags
    function updateTagsInput() {
        const tagData = [];

        selectedTagIds.forEach(tagId => {
            const tagElement = selectedTags.querySelector(`[data-tag-id="${tagId}"]`);
            if (tagElement) {
                const isNew = tagElement.dataset.isNew === 'true';
                const tagName = tagElement.dataset.tagName;

                if (isNew) {
                    tagData.push(`new:${tagName}`);
                } else {
                    tagData.push(tagId);
                }
            }
        });

        tagsInput.value = tagData.join(',');
    }

    // Event listeners
    tagInput.addEventListener('input', function() {
        showSuggestions(this.value);
    });

    tagInput.addEventListener('focus', function() {
        if (this.value.trim()) {
            showSuggestions(this.value);
        }
    });

    // Handle suggestion clicks
    tagSuggestions.addEventListener('click', function(e) {
        const suggestion = e.target.closest('.tag-suggestion');
        if (suggestion) {
            const isNewTag = suggestion.classList.contains('create-new-tag');

            if (isNewTag) {
                const tagName = suggestion.dataset.tagName;
                addTag(null, tagName, '#6c757d', true);
            } else {
                const tagId = parseInt(suggestion.dataset.tagId);
                const tagName = suggestion.dataset.tagName;
                const tagColor = suggestion.dataset.tagColor;

                addTag(tagId, tagName, tagColor, false);
            }

            tagInput.value = '';
            tagSuggestions.style.display = 'none';
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!tagInput.contains(e.target) && !tagSuggestions.contains(e.target)) {
            tagSuggestions.style.display = 'none';
        }
    });

    // Handle keyboard navigation
    tagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const firstSuggestion = tagSuggestions.querySelector('.tag-suggestion');
            if (firstSuggestion) {
                const isNewTag = firstSuggestion.classList.contains('create-new-tag');

                if (isNewTag) {
                    const tagName = firstSuggestion.dataset.tagName;
                    addTag(null, tagName, '#6c757d', true);
                } else {
                    const tagId = parseInt(firstSuggestion.dataset.tagId);
                    const tagName = firstSuggestion.dataset.tagName;
                    const tagColor = firstSuggestion.dataset.tagColor;

                    addTag(tagId, tagName, tagColor, false);
                }

                this.value = '';
                tagSuggestions.style.display = 'none';
            }
        } else if (e.key === 'Escape') {
            tagSuggestions.style.display = 'none';
            tagInput.blur();
        }
    });

    // Add debounced search for better performance
    let searchTimeout;
    tagInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            showSuggestions(this.value);
        }, 150);
    });
</script>
@endsection
