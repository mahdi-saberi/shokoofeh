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

    <style>
        /* Responsive styles for quick categories and filters */
        @media (max-width: 768px) {
            .quick-categories {
                gap: 0.75rem !important;
                padding: 0.25rem 0 !important;
            }
            .quick-category-item {
                min-width: 100px !important;
                max-width: 110px !important;
                padding: 0.75rem !important;
            }
            .quick-category-icon {
                font-size: 1.25rem !important;
            }
            .quick-category-link span {
                font-size: 0.75rem !important;
            }
            .filters-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            .filter-group {
                width: 100% !important;
            }
            .smart-filters-section {
                padding: 1.5rem !important;
            }
            .products-section {
                padding: 1.5rem !important;
            }
            .products-stats {
                gap: 1rem !important;
            }
            .stat-item {
                min-width: 100px !important;
                padding: 1rem !important;
            }
            .section-title {
                font-size: 1.25rem !important;
            }
        }

        @media (max-width: 480px) {
            .quick-categories {
                gap: 0.5rem !important;
            }
            .quick-category-item {
                min-width: 90px !important;
                max-width: 100px !important;
                padding: 0.5rem !important;
            }
            .quick-category-icon {
                font-size: 1rem !important;
            }
            .quick-category-link span {
                font-size: 0.7rem !important;
            }
            .smart-filters-section {
                padding: 1rem !important;
            }
            .products-section {
                padding: 1rem !important;
            }
            .filters-title {
                font-size: 1.125rem !important;
            }
            .section-title {
                font-size: 1.125rem !important;
            }
            .products-stats {
                gap: 0.75rem !important;
            }
            .stat-item {
                min-width: 80px !important;
                padding: 0.75rem !important;
            }
            .stat-number {
                font-size: 1.25rem !important;
            }
            .stat-label {
                font-size: 0.75rem !important;
            }
        }

        /* Hover effects for better UX */
        .quick-category-item:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
            border-color: #FF6B35 !important;
        }

        .filter-select:hover {
            border-color: #FF6B35 !important;
        }

        .filter-select:focus {
            border-color: #FF6B35 !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1) !important;
        }

        /* Featured Products Carousel Styles */
        .featured-products-carousel {
            margin: 2rem 0;
        }

        .carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid #DDD6FE;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .carousel-arrow:hover {
            background: #DDD6FE;
            border-color: #A78BFA;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-arrow:active {
            transform: translateY(-50%) scale(0.95);
        }

        .carousel-prev {
            left: -24px;
        }

        .carousel-next {
            right: -24px;
        }

        .carousel-arrow i {
            font-size: 1.25rem;
            color: #6B7280;
        }

        .carousel-arrow:hover i {
            color: #4F46E5;
        }

        .products-carousel {
            display: flex !important;
            overflow-x: auto !important;
            gap: 1.5rem !important;
            padding: 1rem 0 !important;
            scroll-behavior: smooth !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .products-carousel::-webkit-scrollbar {
            display: none;
        }

        .products-carousel .product-card {
            min-width: 280px !important;
            max-width: 320px !important;
            flex-shrink: 0 !important;
        }

        @media (max-width: 768px) {
            .carousel-arrow {
                width: 40px;
                height: 40px;
            }

            .carousel-prev {
                left: -20px;
            }

            .carousel-next {
                right: -20px;
            }

            .products-carousel .product-card {
                min-width: 250px !important;
                max-width: 280px !important;
            }
        }

        @media (max-width: 480px) {
            .carousel-arrow {
                width: 36px;
                height: 36px;
            }

            .carousel-next {
                right: -18px;
            }

            .carousel-prev {
                left: -18px;
            }

            .products-carousel .product-card {
                min-width: 220px !important;
                max-width: 250px !important;
            }
        }
    </style>
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
                                <span class="action-label">پروفایل</span>
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

        <!-- Quick Categories (Age Groups) - Moved above slider -->
        <div class="quick-categories" style="display: flex !important; flex-wrap: nowrap !important; gap: 1rem !important; justify-content: center !important; margin: 2rem 0 !important; overflow-x: auto !important; padding: 0.5rem 0 !important;">
            @foreach($ageGroups as $ageGroup)
                <div class="quick-category-item" style="background: white !important; border-radius: 0.75rem !important; padding: 1rem !important; text-align: center !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; border: 2px solid #DDD6FE !important; min-width: 120px !important; max-width: 140px !important; margin: 0 !important; display: inline-block !important; vertical-align: top !important; flex-shrink: 0 !important;">
                    <a href="{{ route('welcome', ['age_group' => $ageGroup->id]) }}" class="quick-category-link" style="text-decoration: none !important; color: #2F3542 !important; display: flex !important; flex-direction: column !important; align-items: center !important; gap: 0.5rem !important;">
                        <div class="quick-category-icon" style="font-size: 1.5rem !important; margin-bottom: 0.5rem !important;">
                            @switch($ageGroup->id)
                                @case(1) 👶 @break
                                @case(2) 🧒 @break
                                @case(3) 👧 @break
                                @case(4) 👦 @break
                                @case(5) 🧑 @break
                                @case(6) 👨 @break
                                @default 🎯
                            @endswitch
                        </div>
                        <span style="font-weight: 600 !important; font-size: 0.875rem !important; line-height: 1.2 !important;">{{ $ageGroup->title }}</span>
                    </a>
                </div>
            @endforeach
        </div>

            <!-- Featured Products Section -->
            <section class="featured-products-section">
                <div class="section-header">
                    <h2 class="section-title">🌟 محصولات ویژه و پرفروش</h2>
                    <p class="section-subtitle">بهترین اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان</p>
                </div>

                <!-- Featured Products Carousel -->
                @if($featuredProducts->count() > 0)
                    <div class="featured-products-carousel">
                        <h3 class="featured-subtitle">🎯 محصولات ویژه</h3>
                        <div class="carousel-container">
                            <button class="carousel-arrow carousel-prev" onclick="moveCarousel('prev')">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="products-carousel" id="featured-carousel">
                                @foreach($featuredProducts->take(6) as $product)
                                    <div class="product-card featured-card fade-in-up">
                                        <div class="product-badge">
                                            @if($product->stock <= 0)
                                                <span class="badge out-of-stock">ناموجود</span>
                                            @elseif($product->stock <= 5)
                                                <span class="badge low-stock">کم موجود</span>
                                            @else
                                                <span class="badge in-stock">موجود</span>
                                            @endif
                                            @if($product->hasDiscount())
                                                <span class="badge discount">{{ $product->discount_percentage }}% تخفیف</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('product.show', $product->id) }}" class="product-link">
                                            <div class="product-image-container">
                                                <img src="{{ $product->image_url ?: 'https://placehold.co/300x200/EEE/333?text=Product' }}"
                                                     alt="{{ $product->title }}"
                                                     class="product-image"
                                                     loading="lazy">
                                            </div>

                                            <div class="product-info">
                                                <h3 class="product-title">{{ $product->title }}</h3>
                                                <p class="product-description">{{ Str::limit($product->description, 60) }}</p>

                                                <div class="product-meta">
                                                    @if($product->age_group)
                                                        <span class="product-age">
                                                            <i class="fas fa-baby"></i>
                                                            {{ is_array($product->age_group) ? implode(', ', $product->age_group) : $product->age_group }}
                                                        </span>
                                                    @endif
                                                    @if($product->gender)
                                                        <span class="product-gender">
                                                            {!! $product->gender_icon !!}
                                                            {{ $product->gender == 'male' ? 'پسرانه' : ($product->gender == 'female' ? 'دخترانه' : ($product->gender == 'هردو' ? 'عمومی' : $product->gender)) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Product Tags -->
                                                @if($product->tags && $product->tags->count() > 0)
                                                    <div class="product-tags-mini">
                                                        @foreach($product->tags->take(2) as $tag)
                                                            <span class="product-tag-mini"
                                                                  style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                                                {{ $tag->name }}
                                                            </span>
                                                        @endforeach
                                                        @if($product->tags->count() > 2)
                                                            <span class="product-tag-more">+{{ $product->tags->count() - 2 }}</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="product-price">
                                                    @if($product->hasDiscount())
                                                        <div class="price-discounted">
                                                            <span class="price-original">{{ number_format($product->price) }}</span>
                                                            <span class="price-amount">{{ number_format($product->discounted_price) }}</span>
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                    @elseif($product->price > 0)
                                                        <span class="price-amount">{{ number_format($product->price) }}</span>
                                                        <span class="price-currency">تومان</span>
                                                    @else
                                                        <span class="price-free">رایگان</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>

                                        <div class="product-actions">
                                            @if($product->stock > 0)
                                                <button class="btn-add-cart" onclick="addToCart({{ $product->id }}); event.stopPropagation();">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span>افزودن به سبد</span>
                                                </button>
                                            @else
                                                <button class="btn-out-of-stock" disabled>
                                                    <i class="fas fa-times"></i>
                                                    <span>ناموجود</span>
                                                </button>
                                            @endif
                                            <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }}); event.stopPropagation();">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-arrow carousel-next" onclick="moveCarousel('next')">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                    </div>
                @endif

            <!-- Discounted Products Grid -->
            @if($discountedProducts->count() > 0)
                <div class="discounted-products-grid">
                    <h3 class="featured-subtitle">🏷️ محصولات با تخفیف</h3>
                    <div class="products-grid discounted-grid">
                        @foreach($discountedProducts as $product)
                            <div class="product-card discounted-card fade-in-up">
                                <div class="product-badge">
                                    @if($product->stock <= 0)
                                        <span class="badge out-of-stock">ناموجود</span>
                                    @elseif($product->stock <= 5)
                                        <span class="badge low-stock">کم موجود</span>
                                    @else
                                        <span class="badge in-stock">موجود</span>
                                    @endif
                                    <span class="badge discount">{{ $product->discount_percentage }}% تخفیف</span>
                                </div>

                                <a href="{{ route('product.show', $product->id) }}" class="product-link">
                                    <div class="product-image-container">
                                        <img src="{{ $product->image_url ?: 'https://placehold.co/300x200/EEE/333?text=Product' }}"
                                             alt="{{ $product->title }}"
                                             class="product-image"
                                             loading="lazy">
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-title">{{ $product->title }}</h3>
                                        <p class="product-description">{{ Str::limit($product->description, 60) }}</p>

                                        <div class="product-meta">
                                            @if($product->age_group)
                                                <span class="product-age">
                                                    <i class="fas fa-baby"></i>
                                                    {{ is_array($product->age_group) ? implode(', ', $product->age_group) : $product->age_group }}
                                                </span>
                                            @endif
                                            @if($product->gender)
                                                <span class="product-gender">
                                                    {!! $product->gender_icon !!}
                                                    {{ $product->gender == 'male' ? 'پسرانه' : ($product->gender == 'female' ? 'دخترانه' : ($product->gender == 'هردو' ? 'عمومی' : $product->gender)) }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Product Tags -->
                                        @if($product->tags && $product->tags->count() > 0)
                                            <div class="product-tags-mini">
                                                @foreach($product->tags->take(2) as $tag)
                                                    <span class="product-tag-mini"
                                                          style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                                @if($product->tags->count() > 2)
                                                    <span class="product-tag-more">+{{ $product->tags->count() - 2 }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="product-price">
                                            <div class="price-discounted">
                                                <span class="price-original">{{ number_format($product->price) }}</span>
                                                <span class="price-amount">{{ number_format($product->discounted_price) }}</span>
                                                <span class="price-currency">تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="product-actions">
                                    @if($product->stock > 0)
                                        <button class="btn-add-cart" onclick="addToCart({{ $product->id }}); event.stopPropagation();">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>افزودن به سبد</span>
                                        </button>
                                    @else
                                        <button class="btn-out-of-stock" disabled>
                                            <i class="fas fa-times"></i>
                                            <span>ناموجود</span>
                                        </button>
                                    @endif
                                    <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }}); event.stopPropagation();">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <!-- Smart Filters Section - Single Row -->
        <section class="smart-filters-section" style="background: white !important; border-radius: 1rem !important; padding: 2rem !important; margin: 2rem 0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; border: 1px solid #DDD6FE !important;">
            <div class="filters-header" style="text-align: center !important; margin-bottom: 2rem !important;">
                <h3 class="filters-title" style="font-size: 1.25rem !important; font-weight: 600 !important; color: #2F3542 !important; margin-bottom: 0.5rem !important;">🔍 جستجوی هوشمند</h3>
                <p class="filters-subtitle" style="font-size: 1rem !important; color: #747D8C !important; line-height: 1.6 !important;">محصول مورد نظرتان را به راحتی پیدا کنید</p>
            </div>
            <form id="filter-form" action="{{ route('welcome') }}" method="GET" class="smart-filter-form">
                <div class="filters-grid" style="display: grid !important; grid-template-columns: repeat(5, 1fr) !important; gap: 1.5rem !important; align-items: end !important;">
                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🎯 دسته‌بندی</label>
                        <select name="category" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه دسته‌ها</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">👶 گروه سنی</label>
                        <select name="age_group" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه سنین</option>
                            @foreach($ageGroups as $ageGroup)
                                <option value="{{ $ageGroup->id }}"
                                        {{ request('age_group') == $ageGroup->id ? 'selected' : '' }}>
                                    {{ $ageGroup->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🎮 نوع بازی</label>
                        <select name="game_type" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه انواع</option>
                            @foreach($gameTypes as $gameType)
                                <option value="{{ $gameType->id }}"
                                        {{ request('game_type') == $gameType->id ? 'selected' : '' }}>
                                    {{ $gameType->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🏷️ برچسب</label>
                        <select name="tag" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه برچسب‌ها</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->slug }}"
                                        {{ request('tag') == $tag->slug ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">📊 مرتب‌سازی</label>
                        <select name="sort" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>جدیدترین</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>ارزان‌ترین</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>گران‌ترین</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>نام (الف-ی)</option>
                        </select>
                    </div>
                </div>
            </form>
        </section>

        <!-- Products Section -->
        <section id="products" class="products-section" style="background: white !important; border-radius: 1rem !important; padding: 2rem !important; margin: 2rem 0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; border: 1px solid #DDD6FE !important;">
            <div class="section-header" style="text-align: center !important; margin-bottom: 2rem !important;">
                <h2 class="section-title" style="font-size: 1.5rem !important; font-weight: 700 !important; color: #2F3542 !important; margin-bottom: 0.5rem !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 0.5rem !important;">🎁 لیست اسباب بازی ها</h2>
                <p class="section-subtitle" style="font-size: 1rem !important; color: #747D8C !important; line-height: 1.6 !important; margin-bottom: 0 !important;">مجموعه‌ای از بهترین اسباب بازی‌های آموزشی و سرگرم‌کننده</p>
            </div>

            <div class="products-grid" id="products-container">
                @forelse($products as $product)
                    <div class="product-card fade-in-up">
                        <div class="product-badge">
                            @if($product->stock <= 0)
                                <span class="badge out-of-stock">ناموجود</span>
                            @elseif($product->stock <= 5)
                                <span class="badge low-stock">کم موجود</span>
                            @else
                                <span class="badge in-stock">موجود</span>
                            @endif
                        </div>

                        <a href="{{ route('product.show', $product->id) }}" class="product-link">
                            <div class="product-image-container">
                                <img src="{{ $product->image_url ?: 'https://placehold.co/300x200/EEE/333?text=Product' }}"
                                     alt="{{ $product->title }}"
                                     class="product-image"
                                     loading="lazy">
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">{{ $product->title }}</h3>
                                <p class="product-description">{{ Str::limit($product->description, 80) }}</p>

                                <div class="product-meta">
                                    @if($product->age_group)
                                        <span class="product-age">
                                            @if(is_array($product->age_group))
                                                {{ implode(', ', array_slice($product->age_group, 0, 2)) }}
                                            @else
                                                {{ $product->age_group }}
                                            @endif
                                        </span>
                                    @endif

                                    @if($product->category)
                                        <span class="product-category">
                                            @if(is_array($product->category))
                                                {{ implode(', ', array_slice($product->category, 0, 1)) }}
                                            @else
                                                {{ $product->category }}
                                            @endif
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Tags -->
                                @if($product->tags && $product->tags->count() > 0)
                                    <div class="product-tags-mini">
                                        @foreach($product->tags->take(3) as $tag)
                                            <span class="product-tag-mini"
                                                  style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}; border: 1px solid {{ $tag->color }}40;">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                        @if($product->tags->count() > 3)
                                            <span class="product-tag-more">+{{ $product->tags->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="product-price">
                                    @if($product->price > 0)
                                        <span class="price-amount">{{ number_format($product->price) }}</span>
                                        <span class="price-currency">تومان</span>
                                    @else
                                        <span class="price-free">رایگان</span>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <div class="product-actions">
                            @if($product->stock > 0)
                                <button class="btn-add-cart" onclick="addToCart({{ $product->id }}); event.stopPropagation();">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>افزودن به سبد</span>
                                </button>
                            @else
                                <button class="btn-out-of-stock" disabled>
                                    <i class="fas fa-times"></i>
                                    <span>ناموجود</span>
                                </button>
                            @endif
                            <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }}); event.stopPropagation();">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-products">
                        <div class="empty-icon">🎁</div>
                        <h3>محصولی یافت نشد</h3>
                        <p>با تغییر فیلترها محصولات بیشتری را مشاهده کنید</p>
                        <a href="{{ route('welcome') }}" class="btn-primary">مشاهده همه محصولات</a>
                    </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            @if($products->hasPages())
                <div class="load-more-container">
                    {{ $products->appends(request()->query())->links('pagination.persian') }}
                </div>
            @endif
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-grid">
                @foreach($siteSettings->feature_boxes as $featureBox)
                    <div class="feature-item">
                        <div class="feature-icon">{{ $featureBox['icon'] }}</div>
                        <h3 class="feature-title">{{ $featureBox['title'] }}</h3>
                        <p class="feature-description">{{ $featureBox['description'] }}</p>
                    </div>
                @endforeach
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

        // Carousel functionality
        const featuredCarousel = document.getElementById('featured-carousel');
        const carouselItems = featuredCarousel.children;
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');
        const itemWidth = carouselItems[0].getBoundingClientRect().width;

        function moveCarousel(direction) {
            const container = featuredCarousel.parentElement;
            let newScrollLeft;

            if (direction === 'prev') {
                newScrollLeft = featuredCarousel.scrollLeft - itemWidth;
                if (newScrollLeft < 0) {
                    newScrollLeft = 0;
                }
            } else {
                newScrollLeft = featuredCarousel.scrollLeft + itemWidth;
                if (newScrollLeft > featuredCarousel.scrollWidth - featuredCarousel.clientWidth) {
                    newScrollLeft = featuredCarousel.scrollWidth - featuredCarousel.clientWidth;
                }
            }

            featuredCarousel.scrollTo({
                left: newScrollLeft,
                behavior: 'smooth'
            });
        }

        // Add event listeners for carousel arrows
        prevButton.addEventListener('click', () => moveCarousel('prev'));
        nextButton.addEventListener('click', () => moveCarousel('next'));

        // Add event listeners for carousel items to show active indicator
        featuredCarousel.addEventListener('scroll', () => {
            const currentSlide = Math.round(featuredCarousel.scrollLeft / itemWidth);
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });
        });

        // Initial active indicator
        const initialActiveSlide = Math.round(featuredCarousel.scrollLeft / itemWidth);
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === initialActiveSlide);
        });

    </script>
</body>
</html>
