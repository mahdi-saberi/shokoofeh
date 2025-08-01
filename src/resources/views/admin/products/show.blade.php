@extends('layouts.dashboard')

@section('title', 'نمایش محصول')

@section('content')
    <div class="header">
        <h1>جزئیات محصول</h1>
        <p>مشاهده اطلاعات کامل محصول: {{ $product->title }}</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>{{ $product->title }}</h3>
            <div>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">ویرایش محصول</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
            </div>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; align-items: start;">
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; max-width: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    @else
                        <div style="width: 100%; max-width: 300px; height: 200px; background-color: #f8f9fa; border: 2px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                            <div style="text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📷</div>
                                <p>بدون تصویر</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">عنوان:</strong>
                            <span style="margin-right: 1rem;">{{ $product->title }}</span>
                        </li>
                        @if($product->image)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">تصویر:</strong>
                                <a href="{{ asset('storage/' . $product->image) }}" target="_blank" style="color: #3498db; text-decoration: none; margin-right: 1rem;">مشاهده تصویر در تب جدید</a>
                            </li>
                        @endif
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">گروه سنی:</strong>
                            <div style="margin-top: 0.5rem;">
                                @if($product->age_group && count($product->age_group) > 0)
                                    @foreach($product->age_group as $age)
                                        <span class="badge" style="background-color: #3498db; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.9rem; margin: 2px;">
                                            {{ is_array($age) ? implode(', ', $age) : $age }}
                                        </span>
                                    @endforeach
                                @else
                                    <span style="color: #999;">تعیین نشده</span>
                                @endif
                            </div>
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">نوع بازی:</strong>
                            <span style="margin-right: 1rem;">{{ (is_array($product->game_type) ? implode(', ', $product->game_type) : $product->game_type) ?: 'تعیین نشده' }}</span>
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">دسته‌بندی:</strong>
                            <span class="badge" style="background-color: #27ae60; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.9rem; margin-right: 1rem;">
                                {{ (is_array($product->category) ? implode(', ', $product->category) : $product->category) ?: 'تعیین نشده' }}
                            </span>
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">کد محصول:</strong>
                            @if($product->product_code)
                                <code style="background: #e9ecef; padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; color: #495057; margin-right: 1rem;">{{ $product->product_code }}</code>
                            @else
                                <span style="color: #999; margin-right: 1rem;">تعیین نشده</span>
                            @endif
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">جنسیت هدف:</strong>
                            @if($product->gender)
                                <span class="badge" style="background: {{ $product->gender_color }}; color: white; padding: 6px 12px; border-radius: 12px; font-size: 0.9rem; margin-right: 1rem; display: inline-flex; align-items: center; gap: 6px;">
                                    {{ $product->gender_icon }} {{ $product->gender }}
                                </span>
                            @else
                                <span style="color: #999; margin-right: 1rem;">تعیین نشده</span>
                            @endif
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">تاریخ ایجاد:</strong>
                            <span style="margin-right: 1rem;">{{ persian_date($product->created_at, 'Y/m/d H:i') }}</span>
                        </li>
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">آخرین بروزرسانی:</strong>
                            <span style="margin-right: 1rem;">{{ persian_date($product->updated_at, 'Y/m/d H:i') }}</span>
                        </li>
                    </ul>

                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                        <div class="actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">ویرایش محصول</a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف محصول</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
