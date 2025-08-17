@extends('layouts.dashboard')

@section('title', 'مدیریت برچسب‌ها')

@section('content')
    <div class="header">
        <h1>مدیریت برچسب‌ها</h1>
        <p>ایجاد، ویرایش و مدیریت برچسب‌های محصولات</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>لیست برچسب‌ها</h3>
            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">➕ ایجاد برچسب جدید</a>
        </div>
        <div class="card-body">
            @if($tags->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                <th style="padding: 1rem; text-align: right; border-bottom: 1px solid #dee2e6;">نام برچسب</th>
                                <th style="padding: 1rem; text-align: center; border-bottom: 1px solid #dee2e6;">رنگ</th>
                                <th style="padding: 1rem; text-align: center; border-bottom: 1px solid #dee2e6;">وضعیت</th>
                                <th style="padding: 1rem; text-align: center; border-bottom: 1px solid #dee2e6;">تعداد محصولات</th>
                                <th style="padding: 1rem; text-align: center; border-bottom: 1px solid #dee2e6;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <div style="width: 16px; height: 16px; background-color: {{ $tag->color ?: '#95a5a6' }}; border-radius: 50%;"></div>
                                            <strong>{{ $tag->name }}</strong>
                                        </div>
                                        @if($tag->description)
                                            <div style="font-size: 0.9rem; color: #6c757d; margin-top: 0.25rem;">
                                                {{ Str::limit($tag->description, 50) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <div style="width: 24px; height: 24px; background-color: {{ $tag->color ?: '#95a5a6' }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                                            <code style="font-size: 0.8rem;">{{ $tag->color ?: '#95a5a6' }}</code>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="badge" style="background-color: {{ $tag->is_active ? '#27ae60' : '#e74c3c' }}; color: white; padding: 6px 12px; border-radius: 12px; font-size: 0.9rem;">
                                            {{ $tag->is_active ? 'فعال' : 'غیرفعال' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="badge" style="background-color: #3498db; color: white; padding: 6px 12px; border-radius: 12px; font-size: 0.9rem;">
                                            {{ $tag->products()->count() }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                            <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-info" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                👁️ مشاهده
                                            </a>
                                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                ✏️ ویرایش
                                            </a>
                                            <form action="{{ route('admin.tags.toggle-status', $tag) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn {{ $tag->is_active ? 'btn-secondary' : 'btn-success' }}" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                    {{ $tag->is_active ? '🔒 غیرفعال' : '✅ فعال' }}
                                                </button>
                                            </form>
                                            @if($tag->products()->count() == 0)
                                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا از حذف این برچسب اطمینان دارید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                        🗑️ حذف
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($tags->hasPages())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $tags->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 3rem 0; color: #6c757d;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🏷️</div>
                    <h3>هیچ برچسبی یافت نشد</h3>
                    <p>برای شروع، اولین برچسب را ایجاد کنید</p>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        ایجاد برچسب جدید
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
