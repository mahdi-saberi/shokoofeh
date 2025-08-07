@extends('layouts.shop')

@section('title', $product->title)

@push('styles')
<link href="{{ asset('css/shokoofeh-modern.css') }}" rel="stylesheet" />
<style>
    .product-detail {
        padding: var(--space-xxl) 0;
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-xxl);
        margin-bottom: var(--space-xxl);
    }

    .product-gallery {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .product-main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-lg);
        box-shadow: var(--shadow-sm);
    }

    .product-info {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        padding: var(--space-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .product-title {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-lg);
        line-height: 1.3;
    }

    .product-price {
        font-size: var(--font-size-4xl);
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: var(--space-xl);
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .price-currency {
        font-size: var(--font-size-lg);
        color: var(--text-secondary);
        font-weight: 500;
    }

    .product-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: var(--space-lg);
        margin-bottom: var(--space-xl);
        padding: var(--space-lg);
        background: var(--background-color);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .meta-item {
        text-align: center;
        padding: var(--space-md);
    }

    .meta-label {
        font-size: var(--font-size-sm);
        color: var(--text-secondary);
        margin-bottom: var(--space-xs);
        font-weight: 500;
    }

    .meta-value {
        font-size: var(--font-size-base);
        color: var(--text-primary);
        font-weight: 600;
    }

    .product-description {
        background: var(--background-color);
        padding: var(--space-xl);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-xl);
        border: 1px solid var(--border-color);
    }

    .description-title {
        font-size: var(--font-size-xl);
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-lg);
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .description-text {
        font-size: var(--font-size-base);
        line-height: 1.8;
        color: var(--text-secondary);
    }

    .product-actions {
        display: flex;
        gap: var(--space-lg);
        margin-bottom: var(--space-xl);
    }

    .action-btn {
        flex: 1;
        padding: var(--space-lg) var(--space-xl);
        border: none;
        border-radius: var(--radius-lg);
        font-size: var(--font-size-lg);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-normal);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-sm);
        text-decoration: none;
    }

    .btn-add-cart {
        background: var(--gradient-primary);
        color: white;
    }

    .btn-add-cart:hover {
        background: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: var(--shadow-toy);
    }

    .btn-wishlist {
        background: var(--surface-color);
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-wishlist:hover {
        border-color: var(--danger-color);
        color: var(--danger-color);
        transform: translateY(-3px);
    }

    .related-products {
        margin-top: var(--space-xxl);
    }

    .related-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-xl);
        text-align: center;
        position: relative;
    }

    .related-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: var(--radius-sm);
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: var(--space-lg);
    }

    .related-card {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        transition: var(--transition-normal);
        text-decoration: none;
        color: var(--text-primary);
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .related-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: var(--radius-md);
        margin-bottom: var(--space-md);
    }

    .related-title-text {
        font-size: var(--font-size-base);
        font-weight: 600;
        margin-bottom: var(--space-sm);
        line-height: 1.4;
    }

    .related-price {
        font-size: var(--font-size-lg);
        font-weight: 700;
        color: var(--primary-color);
    }

    .breadcrumb {
        margin-bottom: var(--space-xl);
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: var(--font-size-sm);
        color: var(--text-secondary);
    }

    .breadcrumb a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition-normal);
    }

    .breadcrumb a:hover {
        color: var(--primary-dark);
    }

    .breadcrumb-separator {
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
            gap: var(--space-lg);
        }

        .product-actions {
            flex-direction: column;
        }

        .related-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .product-title {
            font-size: var(--font-size-2xl);
        }

        .product-price {
            font-size: var(--font-size-3xl);
        }
    }
</style>
@endpush

@section('content')
<div class="product-detail">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('welcome') }}">🏠 صفحه اصلی</a>
        <span class="breadcrumb-separator">←</span>
        @if($product->category)
            <a href="{{ route('welcome', ['category' => $product->category->id]) }}">{{ $product->category->title }}</a>
            <span class="breadcrumb-separator">←</span>
        @endif
        <span>{{ $product->title }}</span>
    </nav>

    <!-- Product Detail Grid -->
    <div class="product-detail-grid fade-in-up">
        <!-- Product Gallery -->
        <div class="product-gallery">
            <img src="{{ $product->image_url ?: 'https://via.placeholder.com/400x400?text=تصویر+محصول' }}"
                 alt="{{ $product->title }}"
                 class="product-main-image">
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <h1 class="product-title">{{ $product->title }}</h1>

            <div class="product-price">
                <span>{{ number_format($product->price) }}</span>
                <span class="price-currency">تومان</span>
            </div>

            <!-- Product Meta -->
            <div class="product-meta">
                @if($product->category)
                    <div class="meta-item">
                        <div class="meta-label">🎯 دسته‌بندی</div>
                        <div class="meta-value">{{ $product->category->title ?? 'نامشخص' }}</div>
                    </div>
                @endif

                @if($product->age_group_object)
                    <div class="meta-item">
                        <div class="meta-label">👶 رده سنی</div>
                        <div class="meta-value">{{ $product->age_group_object->title ?? 'نامشخص' }}</div>
                    </div>
                @endif

                @if($product->game_type_object)
                    <div class="meta-item">
                        <div class="meta-label">🎮 نوع بازی</div>
                        <div class="meta-value">{{ $product->game_type_object->title ?? 'نامشخص' }}</div>
                    </div>
                @endif

                <div class="meta-item">
                    <div class="meta-label">📦 موجودی</div>
                    <div class="meta-value">{{ $product->stock > 0 ? 'موجود' : 'ناموجود' }}</div>
                </div>
            </div>

            <!-- Product Actions -->
            <div class="product-actions">
                <button class="action-btn btn-add-cart" onclick="addToCart({{ $product->id }})">
                    <i class="fas fa-shopping-cart"></i>
                    <span>افزودن به سبد خرید</span>
                </button>

                <button class="action-btn btn-wishlist" onclick="toggleWishlist({{ $product->id }})">
                    <i class="far fa-heart"></i>
                    <span>علاقه‌مندی</span>
                </button>
            </div>

            <!-- Social Sharing -->
            <div style="display: flex; align-items: center; gap: var(--space-md); padding: var(--space-lg); background: var(--background-color); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                <span style="font-weight: 600; color: var(--text-primary);">📤 اشتراک‌گذاری:</span>
                <button onclick="shareOnTelegram()" style="background: #0088cc; color: white; border: none; padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; font-size: var(--font-size-sm);">
                    <i class="fab fa-telegram"></i> تلگرام
                </button>
                <button onclick="shareOnWhatsApp()" style="background: #25d366; color: white; border: none; padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); cursor: pointer; font-size: var(--font-size-sm);">
                    <i class="fab fa-whatsapp"></i> واتساپ
                </button>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    @if($product->description)
        <div class="product-description fade-in-up">
            <h2 class="description-title">
                <span>📝</span>
                <span>توضیحات محصول</span>
            </h2>
            <div class="description-text">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    @endif

    <!-- Related Products -->
    @if($relatedProducts && $relatedProducts->count() > 0)
        <section class="related-products fade-in-up">
            <h2 class="related-title">🔗 محصولات مرتبط</h2>
            <div class="related-grid">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('product.show', $relatedProduct->id) }}" class="related-card">
                        <img src="{{ $relatedProduct->image_url ?: 'https://via.placeholder.com/200x150?text=تصویر+محصول' }}"
                             alt="{{ $relatedProduct->title }}"
                             class="related-image">
                        <h3 class="related-title-text">{{ Str::limit($relatedProduct->title, 50) }}</h3>
                        <div class="related-price">{{ number_format($relatedProduct->price) }} تومان</div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Add to cart function
    function addToCart(productId) {
        const button = event.target.closest('.btn-add-cart');
        button.classList.add('loading');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('محصول به سبد خرید اضافه شد! 🎉', 'success');
                updateCartCount();
            } else {
                showMessage(data.message || 'خطایی رخ داد', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('خطایی رخ داد', 'error');
        })
        .finally(() => {
            button.classList.remove('loading');
        });
    }

    // Toggle wishlist function
    function toggleWishlist(productId) {
        const button = event.target.closest('.btn-wishlist');
        const icon = button.querySelector('i');

        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            button.style.color = '#FF4757';
            showMessage('به علاقه‌مندی‌ها اضافه شد! ❤️', 'success');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            button.style.color = '';
            showMessage('از علاقه‌مندی‌ها حذف شد', 'info');
        }
    }

    // Share functions
    function shareOnTelegram() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $product->title }} - فروشگاه شکوفه');
        window.open(`https://t.me/share/url?url=${url}&text=${text}`, '_blank');
    }

    function shareOnWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $product->title }} - فروشگاه شکوفه');
        window.open(`https://wa.me/?text=${text} ${url}`, '_blank');
    }

    // Update cart count
    function updateCartCount() {
        fetch('{{ route("cart.count") }}', {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.count || 0;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
    }

    // Show message function
    function showMessage(message, type = 'info') {
        const messageEl = document.createElement('div');
        messageEl.className = `message-toast message-${type}`;
        messageEl.textContent = message;
        messageEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: ${type === 'success' ? '#2ED573' : type === 'error' ? '#FF4757' : '#4ECDC4'};
            color: white;
            border-radius: 0.5rem;
            z-index: 10000;
            animation: slideInRight 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-weight: 500;
        `;

        document.body.appendChild(messageEl);

        setTimeout(() => {
            messageEl.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => messageEl.remove(), 300);
        }, 3000);
    }

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0.1s';
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    // Observe elements
    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // Initialize cart count
    updateCartCount();
</script>
@endpush

