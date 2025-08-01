@extends('layouts.dashboard')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
    <div class="header">
        <h1>ویرایش دسته‌بندی</h1>
        <p>ویرایش اطلاعات دسته‌بندی: {{ $category->title }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>ویرایش: {{ $category->title }}</h3>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
