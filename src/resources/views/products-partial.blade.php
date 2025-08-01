@if($products->count() > 0)
    <!-- Products Header -->
    <div style="background: white; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="color: #666; font-size: 14px;">
                {{ $products->total() }} محصول یافت شد
                @if(request()->hasAny(['search', 'category', 'age_group', 'game_type', 'gender']))
                    (با فیلترهای انتخابی)
                @endif
            </div>
        </div>
    </div>

    <!-- All Products Grid -->
    <section class="category-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-th-large"></i>
                </div>
                @if(request()->filled('category'))
                    محصولات {{ request('category') }}
                @elseif(request()->filled('search'))
                    نتایج جستجو: {{ request('search') }}
                @else
                    همه محصولات
                @endif
            </div>
        </div>

        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-container">
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                        @else
                            <div class="product-image placeholder">🧸</div>
                        @endif

                        <div class="product-badges">
                            @if($product->hasDiscount())
                                <span class="badge discount">{{ $product->discount_percentage }}%</span>
                            @endif
                            <span class="badge stock {{ $product->stock_status_color === 'green' ? '' : ($product->stock_status_color === 'orange' ? 'low' : 'out') }}">
                                @if($product->stock > 10) موجود @elseif($product->stock > 0) کم @else ناموجود @endif
                            </span>
                        </div>
                    </div>

                    <div class="product-info">
                        <h3 class="product-title">{{ $product->title }}</h3>

                        @if($product->price)
                            <div class="product-price">
                                @if($product->hasDiscount())
                                    <span class="current-price">{{ number_format($product->discounted_price) }} تومان</span>
                                    <span class="original-price">{{ number_format($product->price) }}</span>
                                @else
                                    <span class="current-price">{{ number_format($product->price) }} تومان</span>
                                @endif
                            </div>
                        @endif

                        <div class="product-tags">
                            @if($product->category_title)
                                <span class="product-tag">{{ $product->category_title }}</span>
                            @endif
                            @foreach($product->age_group_titles as $ageTitle)
                                <span class="product-tag">{{ $ageTitle }}</span>
                            @endforeach
                            @if($product->game_type_title)
                                <span class="product-tag">{{ $product->game_type_title }}</span>
                            @endif
                            @if($product->gender)
                                <span class="product-tag">{{ $product->gender }}</span>
                            @endif
                        </div>

                        <div class="product-actions">
                            <a href="/product/{{ $product->id }}" class="btn btn-secondary" style="margin-left: 0.5rem;">
                                <i class="fas fa-eye"></i> مشاهده جزئیات
                            </a>
                            @if($product->stock > 0)
                                <button class="btn btn-primary add-to-cart-btn"
                                        onclick="addToCart({{ $product->id }}, {{ json_encode($product->title) }})"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->title }}">
                                    <i class="fas fa-shopping-cart"></i> افزودن به سبد
                                </button>
                            @else
                                <button class="btn" disabled>ناموجود</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->hasPages())
            <div style="margin-top: 2rem; display: flex; justify-content: center;" id="paginationContainer">
                {{ $products->appends(request()->query())->links('pagination.custom') }}
            </div>
        @endif
    </section>
@else
    <div style="text-align: center; padding: 4rem 0; color: #666;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
        <h3>نتیجه‌ای یافت نشد</h3>
        <p>متأسفانه محصولی با فیلترهای انتخابی شما پیدا نشد.</p>
        <button onclick="clearAllFilters()" class="btn btn-primary" style="margin-top: 1rem;">
            مشاهده همه محصولات
        </button>
    </div>
@endif
