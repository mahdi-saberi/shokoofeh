@extends('layouts.dashboard')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
    <div class="header">
        <h1>ویرایش دسته‌بندی</h1>
        <p>ویرایش اطلاعات دسته‌بندی: {{ $category->title }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>ویرایش اطلاعات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">عنوان دسته‌بندی:</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $category->title) }}" class="form-control" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">بروزرسانی دسته‌بندی</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">انصراف</a>
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info">نمایش</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- اطلاعات اضافی -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>اطلاعات دسته‌بندی</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>تاریخ ایجاد:</strong><br>
                    {{ persian_date($category->created_at, 'Y/m/d H:i') }}
                </div>
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>آخرین بروزرسانی:</strong><br>
                    {{ $category->updated_at->format('Y/m/d H:i') }}
                </div>
            </div>
        </div>
    </div>
@endsection
