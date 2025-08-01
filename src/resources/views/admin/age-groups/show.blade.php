@extends('layouts.dashboard')

@section('title', 'جزئیات گروه سنی')

@section('content')
    <div class="header">
        <h1>جزئیات گروه سنی</h1>
        <p>مشاهده اطلاعات کامل گروه سنی: {{ $ageGroup->title }}</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>اطلاعات گروه سنی</h3>
            <div>
                <a href="{{ route('admin.age-groups.edit', $ageGroup->id) }}" class="btn btn-warning">ویرایش</a>
                <a href="{{ route('admin.age-groups.index') }}" class="btn btn-secondary">بازگشت</a>
            </div>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 2rem; padding: 2rem; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <h2 style="color: #2c3e50; margin: 0;">{{ $ageGroup->title }}</h2>
                <p style="color: #666; margin: 0.5rem 0 0 0;">شناسه: {{ $ageGroup->id }}</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="padding: 1rem; background: #e3f2fd; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #1976d2;">{{ $ageGroup->id }}</div>
                    <div style="color: #666;">شناسه</div>
                </div>
                <div style="padding: 1rem; background: #f3e5f5; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #7b1fa2;">{{ persian_date($ageGroup->created_at) }}</div>
                    <div style="color: #666;">تاریخ ایجاد</div>
                </div>
                <div style="padding: 1rem; background: #e8f5e8; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #2e7d32;">{{ persian_date($ageGroup->updated_at) }}</div>
                    <div style="color: #666;">آخرین بروزرسانی</div>
                </div>
                <div style="padding: 1rem; background: #fff3e0; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ef6c00;">{{ persian_date_for_humans($ageGroup->created_at) }}</div>
                    <div style="color: #666;">قدمت</div>
                </div>
            </div>
        </div>
    </div>
@endsection
