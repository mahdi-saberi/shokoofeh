@extends('layouts.dashboard')

@section('title', 'نمایش برچسب')

@section('content')
    <div class="header">
        <h1>جزئیات برچسب</h1>
        <p>مشاهده اطلاعات کامل برچسب: {{ $tag->name }}</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>{{ $tag->name }}</h3>
            <div>
                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">✏️ ویرایش برچسب</a>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">🔙 بازگشت به لیست</a>
            </div>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; align-items: start;">
                <div>
                    <!-- Tag Color Preview -->
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <div style="width: 120px; height: 120px; background-color: {{ $tag->color ?: '#95a5a6' }}; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            🏷️
                        </div>
                        <h4 style="margin-bottom: 0.5rem; color: #2c3e50;">{{ $tag->name }}</h4>
                        <code style="background: #f8f9fa; padding: 0.5rem; border-radius: 4px; font-size: 0.9rem;">
                            {{ $tag->color ?: '#95a5a6' }}
                        </code>
                    </div>

                    <!-- Tag Status -->
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <span class="badge" style="background-color: {{ $tag->is_active ? '#27ae60' : '#e74c3c' }}; color: white; padding: 0.75rem 1.5rem; border-radius: 12px; font-size: 1rem;">
                            {{ $tag->is_active ? '✅ فعال' : '❌ غیرفعال' }}
                        </span>
                    </div>

                    <!-- Tag Statistics -->
                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; text-align: center;">
                        <h4 style="margin-bottom: 1rem; color: #2c3e50;">آمار برچسب</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <div style="font-size: 2rem; font-weight: bold; color: #3498db;">{{ $tag->products()->count() }}</div>
                                <div style="font-size: 0.9rem; color: #6c757d;">محصول</div>
                            </div>
                            <div>
                                <div style="font-size: 2rem; font-weight: bold; color: #9b59b6;">{{ $tag->created_at->diffForHumans() }}</div>
                                <div style="font-size: 0.9rem; color: #6c757d;">ایجاد شده</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">نام برچسب:</strong>
                            <span style="margin-right: 1rem; font-size: 1.1rem;">{{ $tag->name }}</span>
                        </li>

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">Slug:</strong>
                            <code style="background: #e9ecef; padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; color: #495057; margin-right: 1rem;">{{ $tag->slug }}</code>
                        </li>

                        @if($tag->description)
                            <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <strong style="color: #2c3e50;">توضیحات:</strong>
                                <div style="margin-top: 0.5rem; line-height: 1.6; color: #555;">{{ $tag->description }}</div>
                            </li>
                        @endif

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">رنگ:</strong>
                            <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 40px; background-color: {{ $tag->color ?: '#95a5a6' }}; border-radius: 8px; border: 2px solid #ddd;"></div>
                                <code style="background: #e9ecef; padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; color: #495057;">{{ $tag->color ?: '#95a5a6' }}</code>
                            </div>
                        </li>

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">تاریخ ایجاد:</strong>
                            <span style="margin-right: 1rem;">{{ persian_date($tag->created_at, 'Y/m/d H:i') }}</span>
                        </li>

                        <li style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #2c3e50;">آخرین بروزرسانی:</strong>
                            <span style="margin-right: 1rem;">{{ persian_date($tag->updated_at, 'Y/m/d H:i') }}</span>
                        </li>
                    </ul>

                    <!-- Products using this tag -->
                    @if($tag->products->count() > 0)
                        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                            <h4 style="margin-bottom: 1rem; color: #2c3e50;">📦 محصولات استفاده کننده از این برچسب</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                                @foreach($tag->products->take(6) as $product)
                                    <div style="background: white; border: 1px solid #ddd; border-radius: 8px; padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                     alt="{{ $product->title }}"
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                            @else
                                                <div style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #999;">
                                                    📷
                                                </div>
                                            @endif
                                            <div style="flex: 1;">
                                                <h5 style="margin: 0 0 0.5rem 0; font-size: 1rem;">{{ $product->title }}</h5>
                                                <div style="font-size: 0.9rem; color: #6c757d;">
                                                    {{ number_format($product->price) }} تومان
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 1rem; text-align: center;">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                                مشاهده محصول
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($tag->products->count() > 6)
                                <div style="text-align: center; margin-top: 1rem;">
                                    <span style="color: #6c757d;">و {{ $tag->products->count() - 6 }} محصول دیگر...</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                        <div class="actions">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">✏️ ویرایش برچسب</a>
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">🔙 بازگشت به لیست</a>
                            @if($tag->products()->count() == 0)
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا از حذف این برچسب اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">🗑️ حذف برچسب</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
