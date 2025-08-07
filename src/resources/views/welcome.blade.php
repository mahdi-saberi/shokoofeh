<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $siteSettings->site_name }}@if($siteSettings->site_description) | {{ $siteSettings->site_description }}@endif</title>

    @if($siteSettings->meta_description)
        <meta name="description" content="{{ $siteSettings->meta_description }}">
    @endif

    @if($siteSettings->meta_keywords)
        <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=vazirmatn:300,400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/shokoofeh-modern.css') }}" rel="stylesheet" />
</head>
<body>
    <!-- Header -->
    <header class="modern-header">
        <!-- Announcement Bar -->
        @if($siteSettings->header_announcement_enabled && $siteSettings->header_announcement_text)
            <div class="header-announcement" style="background: {{ $siteSettings->header_announcement_bg_color ?? '#667eea' }}; color: {{ $siteSettings->header_announcement_text_color ?? '#ffffff' }};">
                <div class="container">
                    {!! $siteSettings->header_announcement_text !!}
                </div>
            </div>
        @endif

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <a href="{{ route('welcome') }}" class="modern-logo">
                        <span class="logo-icon">🧸</span>
                        <span>{{ $siteSettings->site_name ?: 'شکوفه' }}</span>
                    </a>

                    <!-- Search -->
                    <div class="modern-search">
                        <form action="{{ route('welcome') }}" method="GET" class="search-form">
                            <input type="text"
                                   name="search"
                                   class="search-input"
                                   placeholder="دنبال چه اسباب بازی‌ای هستی؟ 🔍"
                                   value="{{ request('search') }}">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="header-action-btn">
                                <span class="action-icon">👤</span>
                                <span class="action-label">پروفیل</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="header-action-btn">
                                <span class="action-icon">🔑</span>
                                <span class="action-label">ورود</span>
                            </a>
                        @endauth

                        <a href="{{ route('cart.index') }}" class="header-action-btn cart-btn">
                            <span class="action-icon">🛒</span>
                            <span class="action-label">سبد خرید</span>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="modern-nav">
            <div class="container">
                <div class="nav-categories">
                    <a href="{{ route('welcome') }}" class="nav-category {{ !request('category') && !request('age_group') && !request('game_type') ? 'active' : '' }}">
                        <span class="category-icon">🏠</span>
                        <span>همه محصولات</span>
                    </a>
                    @foreach($categories->take(8) as $category)
                        <a href="{{ route('welcome', ['category' => $category->id]) }}"
                           class="nav-category {{ request('category') == $category->id ? 'active' : '' }}">
                            <span class="category-icon">
                                @switch($category->id)
                                    @case(1) 🧩 @break
                                    @case(2) 🚗 @break
                                    @case(3) 🎭 @break
                                    @case(4) 🎨 @break
                                    @case(5) 🔬 @break
                                    @case(6) 🎯 @break
                                    @case(7) 🎵 @break
                                    @case(8) ⚽ @break
                                    @default 🎲
                                @endswitch
                            </span>
                            <span>{{ $category->title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="container">
        @if($sliders && $sliders->count() > 0)
            <section class="modern-hero">
                <div class="hero-slider">
                    @foreach($sliders as $index => $slider)
                        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                             style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8)), url('{{ $slider->image_url }}') center/cover;">
                            <div class="hero-content fade-in-up">
                                <h1 class="hero-title">{{ $slider->title }}</h1>
                                <p class="hero-subtitle">{{ $slider->description }}</p>
                                @if($slider->link_url)
                                    <a href="{{ $slider->link_url }}" class="hero-cta">
                                        <span>مشاهده محصولات</span>
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($sliders->count() > 1)
                    <div class="hero-indicators">
                        @foreach($sliders as $index => $slider)
                            <span class="hero-indicator {{ $index === 0 ? 'active' : '' }}"
                                  data-slide="{{ $index }}"></span>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        <!-- Categories Section -->
        <section class="categories-section">
            <h2 class="section-title">🎨 دسته‌بندی‌های محبوب</h2>
            <div class="categories-grid">
                @foreach($categories->take(6) as $category)
                    <a href="{{ route('welcome', ['category' => $category->id]) }}" class="category-card scale-in">
                        <span class="category-icon">
                            @switch($category->id)
                                @case(1) 🧩 @break
                                @case(2) 🚗 @break
                                @case(3) 🎭 @break
                                @case(4) 🎨 @break
                                @case(5) 🔬 @break
                                @default 🎯
                            @endswitch
                        </span>
                        <h3 class="category-title">{{ $category->title }}</h3>
                        <p class="category-count">
                            @php
                                $productsCount = \App\Models\Product::whereJsonContains('category', (string)$category->id)
                                                                   ->orWhereJsonContains('category', $category->id)
                                                                   ->count();
                            @endphp
                            {{ $productsCount }} محصول
                        </p>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Filters Section -->
        <section class="filters-section">
            <h3 class="filters-title">🔍 جستجوی پیشرفته</h3>
            <form id="filter-form" action="{{ route('welcome') }}" method="GET">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div class="filter-group">
                        <label class="filter-label">دسته‌بندی</label>
                        <select name="category" class="filter-select">
                            <option value="">همه دسته‌ها</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">گروه سنی</label>
                        <select name="age_group" class="filter-select">
                            <option value="">همه سنین</option>
                            @foreach($ageGroups as $ageGroup)
                                <option value="{{ $ageGroup->id }}"
                                        {{ request('age_group') == $ageGroup->id ? 'selected' : '' }}>
                                    {{ $ageGroup->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">نوع بازی</label>
                        <select name="game_type" class="filter-select">
                            <option value="">همه انواع</option>
                            @foreach($gameTypes as $gameType)
                                <option value="{{ $gameType->id }}"
                                        {{ request('game_type') == $gameType->id ? 'selected' : '' }}>
                                    {{ $gameType->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">مرتب‌سازی</label>
                        <select name="sort" class="filter-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>جدیدترین</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>نام (الف-ی)</option>
                            <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>نام (ی-الف)</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>ارزان‌ترین</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>گران‌ترین</option>
                        </select>
                    </div>
                </div>
            </form>
        </section>

        <!-- Products Section -->
        <section id="products" class="products-section">
            <h2 class="section-title">🎁 محصولات ویژه</h2>

            <div class="products-grid" id="products-container">
                @foreach($products as $product)
                    <div class="product-card fade-in-up">
                        <a href="{{ route('product.show', $product->id) }}" class="product-link">
                            <img src="{{ $product->image_url ?: 'https://via.placeholder.com/300x200?text=تصویر+محصول' }}"
                                 alt="{{ $product->title }}"
                                 class="product-image">

                            <div class="product-info">
                                <h3 class="product-title">{{ $product->title }}</h3>
                                <p class="product-description">{{ Str::limit($product->description, 100) }}</p>

                                <div class="product-price">
                                    {{ number_format($product->price) }}
                                    <span class="price-currency">تومان</span>
                                </div>
                            </div>
                        </a>

                        <div class="product-actions">
                            <button class="btn-add-cart" onclick="addToCart({{ $product->id }}); event.stopPropagation();">
                                <i class="fas fa-shopping-cart"></i>
                                <span>افزودن به سبد</span>
                            </button>
                            <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }}); event.stopPropagation();">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                {{ $products->appends(request()->query())->links('pagination.persian') }}
            @endif
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">🚚</div>
                    <h3 class="feature-title">ارسال رایگان</h3>
                    <p class="feature-description">برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">خرید امن</h3>
                    <p class="feature-description">پرداخت آنلاین با بالاترین سطح امنیت</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title">ضمانت کیفیت</h3>
                    <p class="feature-description">تمام محصولات دارای گارانتی اصالت و کیفیت</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📞</div>
                    <h3 class="feature-title">پشتیبانی ۲۴/۷</h3>
                    <p class="feature-description">آماده پاسخگویی در تمام ساعات شبانه‌روز</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ $siteSettings->site_name ?: 'فروشگاه شکوفه' }}</h3>
                    <p>{{ $siteSettings->site_description ?: 'مرجع خرید اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان' }}</p>
                    <p>با کیفیت برتر و قیمت مناسب</p>
                </div>

                <div class="footer-section">
                    <h3>تماس با ما</h3>
                    <p><i class="fas fa-phone"></i> {{ $siteSettings->contact_phone ?: '۰۲۱-۱۲۳۴۵۶۷۸' }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $siteSettings->contact_email ?: 'info@shokoofeh.com' }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $siteSettings->contact_address ?: 'تهران، خیابان ولیعصر' }}</p>
                </div>

                <div class="footer-section">
                    <h3>خدمات مشتریان</h3>
                    <p><a href="#">راهنمای خرید</a></p>
                    <p><a href="#">شیوه‌های پرداخت</a></p>
                    <p><a href="#">ارسال و تحویل</a></p>
                    <p><a href="#">ضمانت و بازگشت</a></p>
                </div>

                <div class="footer-section">
                    <h3>دسترسی سریع</h3>
                    <p><a href="{{ route('welcome') }}">صفحه اصلی</a></p>
                    <p><a href="{{ route('welcome') }}#products">فروشگاه</a></p>
                    <p><a href="#">درباره ما</a></p>
                    <p><a href="{{ route('cart.index') }}">سبد خرید</a></p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $siteSettings->site_name ?: 'فروشگاه اسباب بازی شکوفه' }}. تمامی حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>

    <script>
        // CSRF token
        window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.hero-indicator');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-advance slides
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }

        // Manual slide control
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Auto-submit filters
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('filter-form').submit();
            });
        });

        // Add to cart function
        function addToCart(productId) {
            const button = event.target.closest('.btn-add-cart');
            button.classList.add('loading');

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
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
                    // Update cart count
                    updateCartCount();
                    // Show success message
                    showMessage('محصول به سبد خرید اضافه شد! 🎉', 'success');
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

            // Toggle heart icon
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

        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.count") }}', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.cart-count').textContent = data.count || 0;
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
            `;

            document.body.appendChild(messageEl);

            setTimeout(() => {
                messageEl.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => messageEl.remove(), 300);
            }, 3000);
        }

        // Add CSS for message animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Initialize cart count on page load
        updateCartCount();

        // Add scroll animations
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

        // Observe all product cards
        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
