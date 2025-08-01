@extends('layouts.dashboard')

@section('title', 'دسته‌بندی‌ها')

@section('content')
    <div class="header">
        <h1>مدیریت دسته‌بندی‌ها</h1>
        <p>مدیریت دسته‌بندی‌ها برای طبقه‌بندی محصولات</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>لیست دسته‌بندی‌ها</h3>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">ایجاد دسته‌بندی جدید</a>
        </div>
        <div class="card-body">
            @if($categories->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->title }}</td>
                                <td>{{ persian_date($category->created_at) }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning" style="font-size: 0.8rem; padding: 4px 8px;">ویرایش</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.8rem; padding: 4px 8px;">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <p>هیچ دسته‌بندی یافت نشد.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="margin-top: 1rem;">ایجاد اولین دسته‌بندی</a>
                </div>
            @endif
        </div>
    </div>
@endsection
