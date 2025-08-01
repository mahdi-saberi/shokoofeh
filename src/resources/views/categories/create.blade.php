@extends('layouts.dashboard')

@section('title', 'ایجاد دسته‌بندی جدید')

@section('content')
    <div class="header">
        <h1>ایجاد دسته‌بندی جدید</h1>
        <p>افزودن دسته‌بندی جدید برای طبقه‌بندی محصولات</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>اطلاعات دسته‌بندی</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">عنوان دسته‌بندی:</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">ایجاد دسته‌بندی</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
