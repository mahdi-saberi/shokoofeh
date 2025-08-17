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

                                        <!-- Product Media Gallery -->
                    @if($product->media->count() > 0)
                        <div style="margin-top: 2rem;">
                            <h4 style="margin-bottom: 1rem; color: #2c3e50;">
                                @if($product->media->where('file_type', 'image')->count() > 0 && $product->media->where('file_type', 'video')->count() > 0)
                                    📸 تصاویر و ویدیوهای محصول
                                @elseif($product->media->where('file_type', 'video')->count() > 0)
                                    🎥 ویدیوهای محصول
                                @else
                                    📸 تصاویر اضافی محصول
                                @endif
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 0.5rem;">
                                @foreach($product->media->sortBy('sort_order') as $media)
                                    <div style="position: relative;">
                                        @if($media->isImage())
                                            <img src="{{ $media->file_url }}"
                                                 alt="{{ $product->title }}"
                                                 style="width: 100%; height: 80px; object-fit: cover; border-radius: 6px; border: 2px solid {{ $media->is_main ? '#3498db' : '#ddd' }};">
                                            @if($media->is_main)
                                                <div style="position: absolute; top: -5px; right: -5px; background: #3498db; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">★</div>
                                            @endif
                                        @else
                                            <div style="width: 100%; height: 80px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #6c757d; border: 2px solid #ddd; position: relative; overflow: hidden;">
                                                <video controls style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                                    <source src="{{ $media->file_url }}" type="{{ $media->mime_type }}">
                                                    مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                                </video>
                                                <div style="position: absolute; top: 5px; right: 5px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">🎥</div>
                                            </div>
                                        @endif
                                        <div style="font-size: 0.7rem; text-align: center; margin-top: 0.25rem; color: #6c757d;">
                                            @if($media->isImage())
                                                {{ $media->is_main ? 'تصویر اصلی' : 'تصویر اضافی' }}
                                            @else
                                                {{ $media->is_main ? 'ویدیو اصلی' : 'ویدیو اضافی' }}
                                            @endif
                                        </div>
                                        <div style="font-size: 0.7rem; text-align: center; color: #6c757d;">
                                            {{ $media->file_type === 'video' ? '🎥' : '📷' }} {{ Str::limit($media->original_name, 15) }}
                                        </div>
                                    </div>
                                @endforeach
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

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">قیمت:</strong>
                            <span style="margin-right: 1rem; font-weight: bold; color: #27ae60;">{{ number_format($product->price) }} تومان</span>
                        </li>

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">موجودی:</strong>
                            <span style="margin-right: 1rem; font-weight: bold; color: {{ $product->stock > 0 ? '#27ae60' : '#e74c3c' }};">
                                {{ $product->stock > 0 ? $product->stock . ' عدد' : 'ناموجود' }}
                            </span>
                        </li>

                        @if($product->description)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">توضیحات:</strong>
                                <div style="margin-top: 0.5rem; line-height: 1.6; color: #555;">{{ $product->description }}</div>
                            </li>
                        @endif

                        @if($product->price_description)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">توضیحات قیمت:</strong>
                                <div style="margin-top: 0.5rem; line-height: 1.6; color: #555;">{{ $product->price_description }}</div>
                            </li>
                        @endif

                        @if($product->brand)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">برند:</strong>
                                <span class="badge" style="background-color: #9b59b6; color: white; padding: 6px 12px; border-radius: 12px; font-size: 0.9rem; margin-right: 1rem;">
                                    {{ $product->brand->title ?? 'نامشخص' }}
                                </span>
                            </li>
                        @endif

                        @if($product->tags && $product->tags->count() > 0)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">برچسب‌ها:</strong>
                                <div style="margin-top: 0.5rem;">
                                    @foreach($product->tags as $tag)
                                        <span class="badge" style="background-color: {{ $tag->color ?: '#95a5a6' }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; margin: 2px; display: inline-block;">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </li>
                        @endif
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
