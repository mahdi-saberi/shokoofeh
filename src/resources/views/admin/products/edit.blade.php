@extends('layouts.dashboard')

@section('title', 'ویرایش محصول')

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
        background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
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
        border-color: #f39c12;
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1);
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

    .current-image-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
    }

    .current-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        border-color: #f39c12;
        background: #fff3e0;
    }

    .file-upload-area.dragover {
        border-color: #f39c12;
        background: #ffe0b2;
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

    .existing-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .media-item {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.5rem;
        background: white;
        transition: border-color 0.3s ease;
        position: relative;
    }

    .media-item:hover {
        border-color: #f39c12;
    }

    .media-preview {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .media-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
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
        border-color: #f39c12;
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
        color: #f39c12;
    }

    .video-name {
        font-size: 0.875rem;
        color: #495057;
        font-weight: 500;
        text-align: center;
    }

    .file-upload-area.multiple,
    .file-upload-area.video {
        border: 2px dashed #f39c12;
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.05) 0%, rgba(231, 76, 60, 0.05) 100%);
    }

    .file-upload-area.multiple:hover,
    .file-upload-area.video:hover {
        border-color: #e74c3c;
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.1) 0%, rgba(231, 76, 60, 0.1) 100%);
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
        background: #fff;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .multi-select option:checked {
        background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
        color: white;
        border-color: #f39c12;
    }

    .multi-select option:hover {
        background: #f8f9fa;
        border-color: #f39c12;
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
        border-color: #f39c12;
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
        background: #f39c12;
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

    .product-info-section {
        background: #e8f5e8;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border-left: 4px solid #28a745;
    }

    .product-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #c3e6c3;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #155724;
    }

    .info-value {
        color: #2d5a31;
    }

    .stock-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .stock-available { background: #d4edda; color: #155724; }
    .stock-low { background: #fff3cd; color: #856404; }
    .stock-out { background: #f8d7da; color: #721c24; }

    .form-actions {
        margin-top: 2rem;
        padding: 2rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
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
        background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(243, 156, 18, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
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

        .product-info-grid {
            grid-template-columns: 1fr;
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

        .product-info-section {
            padding: 1rem;
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

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
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
</style>

<div class="product-form-container">
    <div class="form-header">
        <h1>✏️ ویرایش محصول</h1>
        <p>{{ $product->title }}</p>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

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

            <!-- اطلاعات فعلی محصول -->
            <div class="product-info-section">
                <h3 class="section-title">📊 اطلاعات فعلی محصول</h3>
                <div class="product-info-grid">
                    <div class="info-item">
                        <span class="info-label">موجودی فعلی:</span>
                        <span class="info-value">
                            <span class="stock-badge {{ $product->stock > 10 ? 'stock-available' : ($product->stock > 0 ? 'stock-low' : 'stock-out') }}">
                                {{ $product->stock }} عدد
                            </span>
                        </span>
                    </div>
                    @if($product->price)
                        <div class="info-item">
                            <span class="info-label">قیمت فعلی:</span>
                            <span class="info-value">{{ number_format($product->price) }} تومان</span>
                        </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">تاریخ ایجاد:</span>
                        <span class="info-value">{{ persian_date($product->created_at, 'Y/m/d H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">آخرین بروزرسانی:</span>
                        <span class="info-value">{{ $product->updated_at->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>

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
                               value="{{ old('title', $product->title) }}"
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
                               value="{{ old('price', $product->price) }}"
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
                        <label for="stock">موجودی انبار *</label>
                        <input type="number"
                               id="stock"
                               name="stock"
                               class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                               value="{{ old('stock', $product->stock) }}"
                               min="0"
                               required
                               placeholder="0">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">تعداد موجودی در انبار</div>
                    </div>

                    <div class="form-group">
                        <label for="category">دسته‌بندی *</label>
                        <div class="multi-select-container">
                            <select id="category"
                                    name="category[]"
                                    class="form-control multi-select {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($categories as $category)
                                    @php
                                        $productCategories = old('category', $product->category ?? []);
                                        $isSelected = is_array($productCategories) && in_array($category->title, $productCategories);
                                    @endphp
                                    <option value="{{ $category->title }}" {{ $isSelected ? 'selected' : '' }}>
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
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="game_type">نوع بازی *</label>
                        <div class="multi-select-container">
                            <select id="game_type"
                                    name="game_type[]"
                                    class="form-control multi-select {{ $errors->has('game_type') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($gameTypes as $gameType)
                                    @php
                                        $productGameTypes = old('game_type', $product->game_type ?? []);
                                        $isSelected = is_array($productGameTypes) && in_array($gameType->title, $productGameTypes);
                                    @endphp
                                    <option value="{{ $gameType->title }}" {{ $isSelected ? 'selected' : '' }}>
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

                    <div class="form-group">
                        <label for="age_group">گروه‌های سنی *</label>
                        <div class="multi-select-container">
                            <select id="age_group"
                                    name="age_group[]"
                                    class="form-control multi-select {{ $errors->has('age_group') ? 'is-invalid' : '' }}"
                                    multiple
                                    required>
                                @foreach($ageGroups as $ageGroup)
                                    @php
                                        $productAgeGroups = old('age_group', $product->age_group ?? []);
                                        $isSelected = is_array($productAgeGroups) && in_array($ageGroup->title, $productAgeGroups);
                                    @endphp
                                    <option value="{{ $ageGroup->title }}" {{ $isSelected ? 'selected' : '' }}>
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
                                @foreach($product->tags as $tag)
                                    <div class="selected-tag"
                                         data-tag-id="{{ $tag->id }}"
                                         style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                        <span>{{ $tag->name }}</span>
                                        <button type="button" class="remove-tag" onclick="removeTag({{ $tag->id }})">×</button>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="tags" id="tagsInput" value="{{ $product->tags->pluck('id')->implode(',') }}">
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
                            <option value="دختر" {{ old('gender', $product->gender) == 'دختر' ? 'selected' : '' }}>👧 دختر</option>
                            <option value="پسر" {{ old('gender', $product->gender) == 'پسر' ? 'selected' : '' }}>👦 پسر</option>
                            <option value="هردو" {{ old('gender', $product->gender) == 'هردو' ? 'selected' : '' }}>👫 هردو</option>
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
                               value="{{ old('product_code', $product->product_code) }}"
                               placeholder="کد محصول"
                               maxlength="20">
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">کد منحصر به فرد محصول</div>
                    </div>

                    <div class="form-group">
                        <label for="brand">برند</label>
                        <select id="brand"
                                name="brand"
                                class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}">
                            <option value="">انتخاب کنید</option>
                            @foreach(\App\Models\Brand::where('status', true)->orderBy('title')->get() as $brandOption)
                                <option value="{{ $brandOption->id }}" {{ old('brand_id', $product->brand_id) == $brandOption->id ? 'selected' : '' }}>
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

                @if($product->image)
                    <div class="current-image-section">
                        <h4 style="margin-bottom: 1rem; color: #495057;">تصویر فعلی:</h4>
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->title }}"
                             class="current-image">
                        <p style="margin-top: 0.5rem; color: #6c757d; font-size: 0.9rem;">
                            برای تغییر تصویر، فایل جدید انتخاب کنید
                        </p>
                    </div>
                @endif

                <div class="form-group">
                    <label>تصویر اصلی (اختیاری)</label>
                    <div class="file-upload-area" onclick="document.getElementById('image').click()">
                        <div class="file-upload-icon">📷</div>
                        <div class="file-upload-text">برای انتخاب تصویر جدید کلیک کنید</div>
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
                        <img id="previewImg" class="preview-image" alt="پیش‌نمایش تصویر جدید">
                    </div>
                </div>

                <!-- نمایش رسانه‌های موجود -->
                @if($product->media->count() > 0)
                    <div class="form-group">
                        <label>رسانه‌های موجود:</label>
                        <div class="existing-media-grid">
                            @foreach($product->media->sortBy('sort_order') as $media)
                                <div class="media-item" data-media-id="{{ $media->id }}">
                                    @if($media->isImage())
                                        <img src="{{ $media->file_url }}" alt="تصویر محصول" class="media-preview">
                                    @else
                                        <div class="video-preview">
                                            <div class="video-icon">🎥</div>
                                            <span class="video-name">{{ $media->original_name }}</span>
                                        </div>
                                    @endif
                                    <div class="media-actions">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteMedia({{ $media->id }})">
                                            🗑️ حذف
                                        </button>
                                        @if($media->isImage())
                                            <button type="button" class="btn btn-sm btn-primary" onclick="setMainImage({{ $media->id }})">
                                                {{ $media->is_main ? '✅ اصلی' : '⭐ اصلی' }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
                            {!! old('description', $product->description) !!}
                        </div>
                    </div>
                    <input type="hidden" name="description" id="descriptionInput" value="{{ old('description', $product->description) }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-help">از ابزارهای بالا برای فرمت‌دهی متن استفاده کنید</div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 بروزرسانی محصول
            </button>
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
                👁️ مشاهده محصول
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                ↩️ بازگشت به لیست
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

        // Form submission handler
        document.getElementById('productForm').addEventListener('submit', function() {
            updateHiddenInput();
        });

        // Initialize toolbar state
        updateToolbarState();
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

    // Media management functions
    function deleteMedia(mediaId) {
        if (confirm('آیا از حذف این رسانه اطمینان دارید؟')) {
            fetch(`/admin/media/${mediaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the media item from DOM
                    const mediaItem = document.querySelector(`[data-media-id="${mediaId}"]`);
                    if (mediaItem) {
                        mediaItem.remove();
                    }
                    // Show success message
                    alert('رسانه با موفقیت حذف شد');
                } else {
                    alert('خطا در حذف رسانه');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('خطا در حذف رسانه');
            });
        }
    }

    function setMainImage(mediaId) {
        fetch(`/admin/media/${mediaId}/set-main`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all main image buttons
                document.querySelectorAll('.btn-primary').forEach(btn => {
                    btn.textContent = '⭐ اصلی';
                });
                // Update the clicked button
                const clickedBtn = document.querySelector(`[data-media-id="${mediaId}"] .btn-primary`);
                if (clickedBtn) {
                    clickedBtn.textContent = '✅ اصلی';
                }
                alert('تصویر اصلی با موفقیت تنظیم شد');
            } else {
                alert('خطا در تنظیم تصویر اصلی');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در تنظیم تصویر اصلی');
        });
    }

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

    // Initialize selected tags from existing tags
    document.querySelectorAll('#selectedTags .selected-tag').forEach(tagElement => {
        const tagId = parseInt(tagElement.dataset.tagId);
        selectedTagIds.push(tagId);
    });

        // Show suggestions
    function showSuggestions(query) {
        if (!query.trim()) {
            tagSuggestions.style.display = 'none';
            return;
        }

        const filteredTags = availableTags.filter(tag =>
            tag.name.toLowerCase().includes(query.toLowerCase()) &&
            !selectedTagIds.includes(tag.id)
        );

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

        // Add "create new tag" option if query doesn't match any existing tag
        const exactMatch = availableTags.some(tag =>
            tag.name.toLowerCase() === query.toLowerCase()
        );

        if (!exactMatch && query.trim().length > 1) {
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
        }
    });
</script>
@endsection
