@extends('layouts.dashboard')

@section('title', 'جزئیات دسته‌بندی')

@section('content')
    <div class="header">
        <h1>جزئیات دسته‌بندی</h1>
        <p>مشاهده اطلاعات کامل دسته‌بندی: {{ $category->title }}</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>اطلاعات دسته‌بندی</h3>
            <div>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">ویرایش</a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">بازگشت</a>
            </div>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 2rem; padding: 2rem; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <h2 style="color: #2c3e50; margin: 0;">{{ $category->title }}</h2>
                <p style="color: #666; margin: 0.5rem 0 0 0;">شناسه: {{ $category->id }}</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="padding: 1rem; background: #e3f2fd; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #1976d2;">{{ $category->id }}</div>
                    <div style="color: #666;">شناسه</div>
                </div>
                <div style="padding: 1rem; background: #f3e5f5; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #7b1fa2;">{{ persian_date($category->created_at) }}</div>
                    <div style="color: #666;">تاریخ ایجاد</div>
                </div>
                <div style="padding: 1rem; background: #e8f5e8; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #2e7d32;">{{ persian_date($category->updated_at) }}</div>
                    <div style="color: #666;">آخرین بروزرسانی</div>
                </div>
                <div style="padding: 1rem; background: #fff3e0; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ef6c00;">{{ persian_date_for_humans($category->created_at) }}</div>
                    <div style="color: #666;">قدمت</div>
                </div>
            </div>
        </div>
    </div>

    <!-- عملیات -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>عملیات</h3>
        </div>
        <div class="card-body" style="text-align: center;">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning" style="margin: 0.5rem;">✏️ ویرایش دسته‌بندی</a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success" style="margin: 0.5rem;">➕ ایجاد دسته‌بندی جدید</a>
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline; margin: 0.5rem;" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑️ حذف دسته‌بندی</button>
            </form>
        </div>
    </div>
@endsection
