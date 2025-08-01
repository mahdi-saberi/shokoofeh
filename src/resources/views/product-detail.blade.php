@extends('layouts.shop')

@section('title', $product->title)

@push('styles')
<style>
    /* Breadcrumb */
    .breadcrumb {
        background: white;
        padding: 1rem;
        margin-bottom: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #666;
        font-size: 0.9rem;
    }

    .breadcrumb-nav a {
        color: #3498db;
        text-decoration: none;
    }

    .breadcrumb-nav a:hover {
        text-decoration: underline;
    }

    /* Product Section */
    .product-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 3rem;
    }

    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    /* Image Section */
    .product-image-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .image-wrapper {
        position: relative;
        width: 100%;
        max-width: 400px;
    }

    .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
    }

    .main-image:hover {
        transform: scale(1.05);
    }

    .main-image-placeholder {
        width: 100%;
        height: 400px;
        background: rgba(255,255,255,0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 6rem;
        color: white;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
    }

    .stock-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        backdrop-filter: blur(10px);
    }

    .stock-available { background: rgba(40, 167, 69, 0.9); }
    .stock-low { background: rgba(255, 193, 7, 0.9); }
    .stock-out { background: rgba(220, 53, 69, 0.9); }

    /* Product Info */
    .product-info {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .product-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .product-tag {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 2px solid;
    }

    .product-tag.category {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border-color: transparent;
    }

    .product-tag.age-group {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border-color: transparent;
    }

    .product-tag.game-type {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
        border-color: transparent;
    }

    .product-price {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 2rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .current-price {
        color: #e74c3c;
    }

    .original-price {
        color: #7f8c8d;
        text-decoration: line-through;
        font-size: 1.8rem;
    }

    .discount-badge {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
    }

    .stock-info {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin: 2rem 0;
        border-right: 4px solid #3498db;
    }

    .stock-info h4 {
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: #2c3e50;
        border: 2px solid #e9ecef;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .btn:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
    }

    /* Description Section */
    .description-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 3rem;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 2rem;
        text-align: center;
    }

    .description-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        text-align: justify;
    }

    /* Related Products */
    .related-section {
        margin-top: 4rem;
    }

    .related-products {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .related-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .related-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-image-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
    }

    .related-info {
        padding: 1.5rem;
    }

    .related-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .related-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: #e74c3c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
        }

        .product-image-section {
            padding: 2rem;
        }

        .main-image,
        .main-image-placeholder {
            height: 300px;
        }

        .main-image-placeholder {
            font-size: 4rem;
        }

        .product-info {
            padding: 2rem;
        }

        .product-title {
            font-size: 2rem;
            text-align: center;
        }

        .product-categories {
            justify-content: center;
        }

        .product-price {
            font-size: 2rem;
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .description-section {
            padding: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .related-products {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .breadcrumb,
        .product-section,
        .description-section {
            border-radius: 12px;
            margin: 0.5rem 0;
        }

        .product-image-section {
            padding: 1.5rem;
        }

        .main-image,
        .main-image-placeholder {
            height: 250px;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.5rem;
        }

        .product-tag {
            font-size: 0.7rem;
            padding: 0.375rem 0.75rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }

        .description-section {
            padding: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .description-content {
            font-size: 1rem;
        }
    }

    /* Touch optimizations */
    @media (hover: none) and (pointer: coarse) {
        .btn {
            min-height: 48px;
        }

        .main-image:hover {
            transform: none;
        }

        .related-card:hover {
            transform: none;
        }

        .related-card:active {
            transform: scale(0.98);
        }

        .btn:active {
            transform: scale(0.98);
        }
    }

    /* Loading animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endpush

@section('content')
<div class="breadcrumb fade-in">
    <div class="breadcrumb-nav">
        <a href="{{ route('welcome') }}">صفحه اصلی</a>
        <span>›</span>
        <a href="{{ route('welcome') }}#products">فروشگاه</a>
        <span>›</span>
        <span>{{ $product->title }}</span>
    </div>
</div>

<section class="product-section fade-in">
    <div class="product-detail">
        <div class="product-image-section">
            <div class="image-wrapper">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->title }}"
                         class="main-image">
                @else
                    <div class="main-image-placeholder">
                        🧸
                    </div>
                @endif

                @php
                    $stockClass = $product->stock > 10 ? 'stock-available' : ($product->stock > 0 ? 'stock-low' : 'stock-out');
                    $stockText = $product->stock > 10 ? 'موجود' : ($product->stock > 0 ? 'کم' : 'ناموجود');
                @endphp
                <div class="stock-indicator {{ $stockClass }}">
                    {{ $stockText }}
                </div>
            </div>
        </div>

        <div class="product-info">
            <h1 class="product-title">{{ $product->title }}</h1>

            <div class="product-categories">
                @if(is_array($product->category))
                    @foreach($product->category as $category)
                        <span class="product-tag category">📂 {{ $category }}</span>
                    @endforeach
                @else
                    <span class="product-tag category">📂 {{ $product->category }}</span>
                @endif

                @if(is_array($product->game_type))
                    @foreach($product->game_type as $gameType)
                        <span class="product-tag game-type">🎮 {{ $gameType }}</span>
                    @endforeach
                @else
                    <span class="product-tag game-type">🎮 {{ $product->game_type }}</span>
                @endif

                @if(is_array($product->age_group))
                    @foreach($product->age_group as $age)
                        <span class="product-tag age-group">👶 {{ $age }}</span>
                    @endforeach
                @else
                    <span class="product-tag age-group">👶 {{ $product->age_group }}</span>
                @endif
            </div>

            @if($product->price)
                <div class="product-price">
                    @if($product->hasDiscount())
                        <span class="current-price">{{ number_format($product->discounted_price) }} تومان</span>
                        <span class="original-price">{{ number_format($product->price) }} تومان</span>
                        <span class="discount-badge">{{ $product->discount_percentage }}% تخفیف</span>
                    @else
                        <span class="current-price">{{ number_format($product->price) }} تومان</span>
                    @endif
                </div>
            @endif

            <div class="stock-info">
                <h4>📦 اطلاعات موجودی</h4>
                <p>موجودی فعلی: <strong>{{ $product->stock }} عدد</strong></p>
                <p>وضعیت: <strong>{{ $stockText }}</strong></p>
                @if($product->stock > 0 && $product->stock <= 10)
                    <p style="color: #e67e22;">⚠️ تعداد محدود! عجله کنید!</p>
                @endif
            </div>

            <div class="action-buttons">
                @if($product->stock > 0)
                    <button class="btn btn-primary add-to-cart-btn"
                            onclick="addToCart({{ $product->id }}, {{ json_encode($product->title) }})"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->title }}">
                        🛒 افزودن به سبد خرید
                    </button>
                @else
                    <button class="btn" disabled>
                        ❌ ناموجود
                    </button>
                @endif
                <a href="{{ route('welcome') }}" class="btn btn-secondary">
                    ↩️ بازگشت به فروشگاه
                </a>
            </div>
        </div>
    </div>
</section>

@if($product->description)
    <section class="description-section fade-in">
        <h2 class="section-title">📝 توضیحات محصول</h2>
        <div class="description-content">
            {!! $product->description !!}
        </div>
    </section>
@endif

@if($relatedProducts->count() > 0)
    <section class="related-section fade-in">
        <h2 class="section-title">🔗 محصولات مشابه</h2>
        <div class="related-products">
            @foreach($relatedProducts as $related)
                <a href="{{ route('product.show', $related->id) }}" class="related-card">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}"
                             alt="{{ $related->title }}"
                             class="related-image">
                    @else
                        <div class="related-image-placeholder">
                            🧸
                        </div>
                    @endif
                    <div class="related-info">
                        <h3 class="related-title">{{ $related->title }}</h3>
                        @if($related->price)
                            <div class="related-price">
                                @if($related->hasDiscount())
                                    {{ number_format($related->discounted_price) }} تومان
                                @else
                                    {{ number_format($related->price) }} تومان
                                @endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif
@endsection

@push('scripts')
<script>
    // Add fade-in animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = '0.1s';
                    entry.target.classList.add('fade-in');
                }
            });
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endpush

