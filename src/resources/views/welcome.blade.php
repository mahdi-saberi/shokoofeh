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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles - شبیه دیجیکالا */
        .header {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            border-bottom: 1px solid #e5e5e5;
            padding: 8px 0;
            font-size: 13px;
            color: #757575;
        }

        .header-main {
            padding: 16px 0;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 24px;
            font-weight: 700;
            color: #ef394e;
            text-decoration: none;
        }

        .search-container {
            flex: 1;
            max-width: 600px;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 12px 50px 12px 16px;
            border: 2px solid #e5e5e5;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-box:focus {
            outline: none;
            border-color: #ef394e;
        }

        .search-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9e9e9e;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            text-decoration: none;
            color: #424242;
            font-size: 14px;
            transition: all 0.3s;
        }

        .header-btn:hover {
            background: #f5f5f5;
        }

        .header-btn.primary {
            background: #ef394e;
            color: white;
            border-color: #ef394e;
        }

        .header-btn.primary:hover {
            background: #d32f2f;
        }

        /* Navigation Menu */
        .nav-menu {
            background: white;
            border-top: 1px solid #e5e5e5;
            padding: 12px 0;
        }

        .nav-categories {
            display: flex;
            align-items: center;
            gap: 2rem;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .nav-categories::-webkit-scrollbar {
            display: none;
        }

        .nav-category {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            text-decoration: none;
            color: #424242;
            font-size: 14px;
            white-space: nowrap;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-category:hover {
            background: #f5f5f5;
            color: #ef394e;
        }

        /* Hero Banner Slider */
        .hero-slider {
            position: relative;
            height: 400px;
            margin-bottom: 2rem;
            border-radius: 16px;
            overflow: hidden;
        }

        .hero-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .hero-slide:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .hero-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-btn {
            display: inline-block;
            padding: 12px 24px;
            background: white;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        /* Category Sections */
        .category-section {
            margin-bottom: 3rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding: 0 1rem;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: #ef394e;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .view-all-btn {
            color: #ef394e;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .view-all-btn:hover {
            text-decoration: underline;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s;
            position: relative;
            border: 1px solid #f0f0f0;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .product-image-container {
            position: relative;
            height: 200px;
            background: #fafafa;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #e0e0e0;
        }

        .product-badges {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.discount {
            background: #ef394e;
            color: white;
        }

        .badge.stock {
            background: #4caf50;
            color: white;
        }

        .badge.stock.low {
            background: #ff9800;
        }

        .badge.stock.out {
            background: #f44336;
        }

        .product-info {
            padding: 16px;
        }

        .product-title {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
            height: 40px;
            overflow: hidden;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .current-price {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .original-price {
            font-size: 14px;
            color: #9e9e9e;
            text-decoration: line-through;
        }

        .discount-percent {
            background: #ef394e;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .product-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 12px;
        }

        .product-tag {
            background: #f5f5f5;
            color: #666;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #ef394e;
            color: white;
        }

        .btn-primary:hover {
            background: #d32f2f;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e0e0e0;
            color: #666;
        }

        .btn-outline:hover {
            background: #f5f5f5;
        }

        .btn:disabled {
            background: #e0e0e0;
            color: #9e9e9e;
            cursor: not-allowed;
        }

        /* Quick Filters */
        .quick-filters {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .filters-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            min-width: 120px;
        }

        .filter-select:focus {
            outline: none;
            border-color: #ef394e;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 12px;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .search-container {
                order: 3;
                max-width: none;
            }

            .nav-categories {
                gap: 1rem;
                padding: 0 12px;
            }

            .hero-content h2 {
                font-size: 1.8rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 12px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select {
                min-width: auto;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #ef394e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ef394e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            gap: 8px;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
            justify-content: center;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            min-width: 40px;
            min-height: 40px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            background: white;
            cursor: pointer;
        }

        .pagination .page-link:hover {
            background: #f5f5f5;
            border-color: #ef394e;
            color: #ef394e;
        }

        .pagination .page-item.active .page-link {
            background: #ef394e;
            border-color: #ef394e;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            border-color: #e0e0e0;
            color: #9e9e9e;
            cursor: not-allowed;
        }

        .pagination .page-item.disabled .page-link:hover {
            background: #f8f9fa;
            border-color: #e0e0e0;
            color: #9e9e9e;
        }

        /* Footer */
        .footer {
            background: #263238;
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #ef394e;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .footer-section p,
        .footer-section a {
            color: #b0bec5;
            text-decoration: none;
            line-height: 1.8;
            font-size: 14px;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #37474f;
            padding-top: 1rem;
            text-align: center;
            color: #78909c;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>🚚 ارسال رایگان برای خریدهای بالای ۵۰۰ هزار تومان</span>
                    @if($siteSettings->contact_phone)
                        <span>📞 مشاوره: {{ $siteSettings->formatted_phone }}</span>
                    @else
                        <span>📞 مشاوره: ۰۲۱-۱۲۳۴۵۶۷۸</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('welcome') }}" class="logo">
                        @if($siteSettings->site_logo)
                            <img src="{{ $siteSettings->logo_url }}" alt="{{ $siteSettings->site_name }}" style="height: 40px;">
                        @else
                            🧸 {{ $siteSettings->site_name }}
                        @endif
                    </a>

                                         <div class="search-container">
                         <form id="searchForm">
                             <input type="text" id="searchInput" name="search" class="search-box"
                                    placeholder="جستجو در میان هزاران اسباب بازی..."
                                    value="{{ request('search') }}">
                             <button type="submit" class="search-btn">
                                 <i class="fas fa-search"></i>
                             </button>
                         </form>
                     </div>

                    <div class="header-actions">
                        <a href="{{ route('cart.index') }}" class="header-btn" id="cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            سبد خرید
                            <span class="cart-count" id="cart-count">0</span>
                        </a>
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="header-btn">
                                <i class="fas fa-user"></i>
                                {{ auth()->user()->name }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="header-btn">
                                <i class="fas fa-user"></i>
                                ورود
                            </a>
                            <a href="{{ route('register') }}" class="header-btn primary">
                                <i class="fas fa-user-plus"></i>
                                ثبت نام
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="nav-menu">
            <div class="container">
                <div class="nav-categories">
                    @foreach($categories as $category)
                        <a href="{{ route('welcome', ['category' => $category->title]) }}" class="nav-category">
                            @switch($category->title)
                                @case('لگو')
                                    <i class="fas fa-cubes"></i>
                                    @break
                                @case('ماشین')
                                    <i class="fas fa-car"></i>
                                    @break
                                @case('عروسک')
                                    <i class="fas fa-child"></i>
                                    @break
                                @case('پازل')
                                    <i class="fas fa-puzzle-piece"></i>
                                    @break
                                @case('کارت')
                                    <i class="fas fa-id-card"></i>
                                    @break
                                @case('بازی رومیزی')
                                    <i class="fas fa-chess-board"></i>
                                    @break
                                @case('اسباب بازی موسیقی')
                                    <i class="fas fa-music"></i>
                                    @break
                                @case('اسباب بازی هنری')
                                    <i class="fas fa-palette"></i>
                                    @break
                                @case('اسباب بازی ورزشی')
                                    <i class="fas fa-futbol"></i>
                                    @break
                                @default
                                    <i class="fas fa-toys"></i>
                            @endswitch
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Banner Slider -->
    <section class="hero-slider" id="hero">
        <div class="container" style="height: 100%; position: relative;">
            @if($sliders->count() > 0)
                @foreach($sliders as $index => $slider)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $slider->image_url }}'); background-size: cover; background-position: center;">
                        <div class="hero-content">
                            <h2>{{ $slider->title }}</h2>
                            @if($slider->description)
                                <p>{{ $slider->description }}</p>
                            @endif
                            @if($slider->button_text && $slider->button_url)
                                <a href="{{ $slider->button_url }}" class="hero-btn">{{ $slider->button_text }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default slides if no sliders in database -->
                <div class="hero-slide active">
                    <div class="hero-content">
                        <h2>بهترین اسباب بازی‌ها برای کودکان عزیز</h2>
                        <p>مجموعه‌ای کامل از اسباب بازی‌های آموزشی، فکری و سرگرم‌کننده</p>
                        <a href="#products" class="hero-btn">مشاهده محصولات</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

         <!-- Quick Filters -->
     <section class="quick-filters">
         <div class="container">
             <form id="filterForm">
                 <div class="filters-row">
                     <div class="filter-group">
                         <label>دسته‌بندی:</label>
                         <select name="category" class="filter-select ajax-filter">
                             <option value="">همه دسته‌ها</option>
                             @foreach($categories as $category)
                                 <option value="{{ $category->title }}" {{ request('category') == $category->title ? 'selected' : '' }}>
                                     {{ $category->title }}
                                 </option>
                             @endforeach
                         </select>
                     </div>

                     <div class="filter-group">
                         <label>گروه سنی:</label>
                         <select name="age_group" class="filter-select ajax-filter">
                             <option value="">همه سنین</option>
                             @foreach($ageGroups as $ageGroup)
                                 <option value="{{ $ageGroup->title }}" {{ request('age_group') == $ageGroup->title ? 'selected' : '' }}>
                                     {{ $ageGroup->title }}
                                 </option>
                             @endforeach
                         </select>
                     </div>

                     <div class="filter-group">
                         <label>نوع بازی:</label>
                         <select name="game_type" class="filter-select ajax-filter">
                             <option value="">همه انواع</option>
                             @foreach($gameTypes as $gameType)
                                 <option value="{{ $gameType->title }}" {{ request('game_type') == $gameType->title ? 'selected' : '' }}>
                                     {{ $gameType->title }}
                                 </option>
                             @endforeach
                         </select>
                     </div>

                     <div class="filter-group">
                         <label>جنسیت:</label>
                         <select name="gender" class="filter-select ajax-filter">
                             <option value="">همه جنسیت‌ها</option>
                             <option value="دختر" {{ request('gender') == 'دختر' ? 'selected' : '' }}>👧 دختر</option>
                             <option value="پسر" {{ request('gender') == 'پسر' ? 'selected' : '' }}>👦 پسر</option>
                             <option value="هردو" {{ request('gender') == 'هردو' ? 'selected' : '' }}>👫 هردو</option>
                         </select>
                     </div>

                     <div class="filter-group">
                         <label>مرتب‌سازی:</label>
                         <select name="sort" class="filter-select ajax-filter">
                             <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>جدیدترین</option>
                             <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>ارزان‌ترین</option>
                             <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>گران‌ترین</option>
                             <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>نام (الف-ی)</option>
                         </select>
                     </div>

                     <button type="button" id="clearFilters" class="btn btn-outline" style="display: none;">
                         <i class="fas fa-times"></i> پاک کردن فیلترها
                     </button>
                 </div>
             </form>
         </div>
     </section>

             <!-- Loading Overlay -->
     <div class="loading-overlay" id="loadingOverlay">
         <div class="loading-spinner"></div>
     </div>

     <!-- Products Section -->
     <main id="products">
         <div class="container">
             <div id="productsContainer">
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
             </div>
         </div>
     </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ $siteSettings->site_name }}</h3>
                    @if($siteSettings->footer_text)
                        <p>{{ $siteSettings->footer_text }}</p>
                    @else
                        <p>مرجع خرید اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان</p>
                        <p>با کیفیت برتر و قیمت مناسب</p>
                    @endif

                    @if($siteSettings->working_hours)
                        <p><i class="fas fa-clock"></i> {{ $siteSettings->working_hours }}</p>
                    @endif
                </div>
                <div class="footer-section">
                    <h3>تماس با ما</h3>
                    @if($siteSettings->contact_phone)
                        <p><i class="fas fa-phone"></i> {{ $siteSettings->formatted_phone }}</p>
                    @endif
                    @if($siteSettings->contact_email)
                        <p><i class="fas fa-envelope"></i> {{ $siteSettings->contact_email }}</p>
                    @endif
                    @if($siteSettings->contact_address)
                        <p><i class="fas fa-map-marker-alt"></i> {{ $siteSettings->contact_address }}</p>
                    @endif

                    @if(count($siteSettings->social_links) > 0)
                        <div style="margin-top: 1rem;">
                            @foreach($siteSettings->social_links as $platform => $link)
                                <a href="{{ $link['url'] }}" target="_blank" style="margin-left: 10px; color: #b0bec5;">
                                    {{ $link['icon'] }} {{ $link['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="footer-section">
                    <h3>خدمات مشتریان</h3>
                    <p><a href="#">راهنمای خرید</a></p>
                    <p><a href="#">شیوه‌های پرداخت</a></p>
                    <p><a href="#">ارسال و تحویل</a></p>
                    <p><a href="#">ضمانت و بازگشت</a></p>
                </div>
                <div class="footer-section">
                    <h3>دسته‌بندی‌ها</h3>
                    @foreach($categories->take(6) as $category)
                        <p><a href="{{ route('welcome', ['category' => $category->title]) }}">{{ $category->title }}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $siteSettings->site_name }}.
                @if($siteSettings->copyright_text)
                    {{ $siteSettings->copyright_text }}
                @else
                    تمامی حقوق محفوظ است.
                @endif
                </p>
            </div>
        </div>
    </footer>

         <script>
         // Global variables
         let searchTimeout;
         const loadingOverlay = document.getElementById('loadingOverlay');
         const productsContainer = document.getElementById('productsContainer');
         const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

         // Show/Hide Loading
         function showLoading() {
             loadingOverlay.classList.add('show');
         }

         function hideLoading() {
             loadingOverlay.classList.remove('show');
         }

         // Get current filters from form values
         function getCurrentFilters() {
             return {
                 search: document.getElementById('searchInput').value || '',
                 category: document.querySelector('select[name="category"]').value || '',
                 age_group: document.querySelector('select[name="age_group"]').value || '',
                 game_type: document.querySelector('select[name="game_type"]').value || '',
                 gender: document.querySelector('select[name="gender"]').value || '',
                 sort: document.querySelector('select[name="sort"]').value || 'newest'
             };
         }

         // Update URL without page reload
         function updateURL(params) {
             const url = new URL(window.location);
             Object.keys(params).forEach(key => {
                 if (params[key]) {
                     url.searchParams.set(key, params[key]);
                 } else {
                     url.searchParams.delete(key);
                 }
             });
             url.searchParams.delete('page'); // Reset pagination
             window.history.pushState({}, '', url);
         }

                           // Load products via Ajax
         function loadProducts(params = {}) {
             showLoading();

                          const queryString = new URLSearchParams(params).toString();
             const url = `{{ route('welcome') }}?${queryString}`;

             fetch(url, {
                 headers: {
                     'X-Requested-With': 'XMLHttpRequest',
                     'Accept': 'text/html',
                     'Content-Type': 'application/x-www-form-urlencoded'
                 }
             })
                                       .then(response => {
                 if (!response.ok) {
                     throw new Error(`Network response was not ok: ${response.status}`);
                 }
                 return response.text();
             })
             .then(html => {
                 // Update products container with returned HTML
                 productsContainer.innerHTML = html;

                 // Re-attach pagination event listeners
                 attachPaginationListeners();

                 hideLoading();
             })
             .catch(error => {
                 productsContainer.innerHTML = `
                     <div style="text-align: center; padding: 4rem 0; color: #666;">
                         <div style="font-size: 4rem; margin-bottom: 1rem;">⚠️</div>
                         <h3>خطا در بارگذاری</h3>
                         <p>متأسفانه در بارگذاری محصولات خطایی رخ داد.</p>
                         <button onclick="location.reload()" class="btn btn-primary" style="margin-top: 1rem;">
                             تلاش مجدد
                         </button>
                     </div>
                 `;
                 hideLoading();
             });
         }

         // Attach pagination event listeners
         function attachPaginationListeners() {
             const paginationContainer = document.getElementById('paginationContainer');
             if (paginationContainer) {
                 paginationContainer.querySelectorAll('.page-link').forEach(link => {
                     link.addEventListener('click', function(e) {
                         e.preventDefault();
                         const href = this.getAttribute('href');
                         if (href && !this.parentElement.classList.contains('disabled')) {
                             try {
                                 const url = new URL(href, window.location.origin);
                                 const currentFilters = getCurrentFilters();
                                 const pageParam = url.searchParams.get('page');

                                                                  // Merge current filters with page parameter
                                 const params = { ...currentFilters };
                                 if (pageParam) {
                                     params.page = pageParam;
                                 }
                                 loadProducts(params);
                                 updateURL(params);
                                 // Scroll to top of products
                                 document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
                             } catch (error) {
                                 // Silent error handling for pagination
                             }
                         }
                     });
                 });
             }
         }

                  // Check if any filters are active
         function hasActiveFilters() {
             const params = getCurrentFilters();
             return params.search || params.category || params.age_group ||
                    params.game_type || params.gender || (params.sort && params.sort !== 'newest');
         }

         // Update clear filters button visibility
         function updateClearFiltersButton() {
             const clearButton = document.getElementById('clearFilters');
             if (clearButton) {
                 clearButton.style.display = hasActiveFilters() ? 'block' : 'none';
             }
         }

                  // Clear all filters (make it global)
         window.clearAllFilters = function() {
             // Reset all form fields
             document.querySelectorAll('.ajax-filter').forEach(select => {
                 select.value = '';
             });
             document.getElementById('searchInput').value = '';

             // Load products without filters
             loadProducts({});
             updateURL({});
             updateClearFiltersButton();
         }

         // Hero Slider
         document.addEventListener('DOMContentLoaded', function() {
             const slides = document.querySelectorAll('.hero-slide');
             let currentSlide = 0;

             function showSlide(index) {
                 slides.forEach((slide, i) => {
                     slide.classList.toggle('active', i === index);
                 });
             }

             function nextSlide() {
                 currentSlide = (currentSlide + 1) % slides.length;
                 showSlide(currentSlide);
             }

             // Auto advance slides
             setInterval(nextSlide, 5000);

             // Smooth scrolling
             document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                 anchor.addEventListener('click', function (e) {
                     e.preventDefault();
                     const target = document.querySelector(this.getAttribute('href'));
                     if (target) {
                         target.scrollIntoView({
                             behavior: 'smooth',
                             block: 'start'
                         });
                     }
                 });
             });

                          // Filter change events
             document.querySelectorAll('.ajax-filter').forEach(filter => {
                 filter.addEventListener('change', function() {
                     const params = getCurrentFilters();
                     params[this.name] = this.value;
                     loadProducts(params);
                     updateURL(params);
                     updateClearFiltersButton();
                 });
             });

             // Search form submit
             document.getElementById('searchForm').addEventListener('submit', function(e) {
                 e.preventDefault();
                 const searchValue = document.getElementById('searchInput').value;
                 const params = getCurrentFilters();
                 params.search = searchValue;
                 loadProducts(params);
                 updateURL(params);
                 updateClearFiltersButton();
             });

             // Search input with debounce
             document.getElementById('searchInput').addEventListener('input', function() {
                 clearTimeout(searchTimeout);
                 const searchValue = this.value;

                 searchTimeout = setTimeout(() => {
                     if (searchValue.length >= 3 || searchValue.length === 0) {
                         const params = getCurrentFilters();
                         params.search = searchValue;
                         loadProducts(params);
                         updateURL(params);
                         updateClearFiltersButton();
                     }
                 }, 500);
             });

             // Clear filters button
             document.getElementById('clearFilters')?.addEventListener('click', clearAllFilters);

             // Initial pagination listeners
             attachPaginationListeners();

                                       // Handle navigation menu category clicks
             document.querySelectorAll('.nav-category').forEach(link => {
                 link.addEventListener('click', function(e) {
                     e.preventDefault();
                     const href = this.getAttribute('href');

                     try {
                         const url = new URL(href, window.location.origin);
                         const params = Object.fromEntries(url.searchParams);

                         // Update filter select to match the clicked category
                         const categorySelect = document.querySelector('select[name="category"]');
                         if (categorySelect) {
                             categorySelect.value = params.category || '';
                         }

                         // Clear other filters when clicking a category
                         document.querySelectorAll('.ajax-filter').forEach(filter => {
                             if (filter.name !== 'category') {
                                 filter.value = '';
                             }
                         });
                         document.getElementById('searchInput').value = '';

                         // Load products with only the category filter
                         const cleanParams = { category: params.category || '' };
                         loadProducts(cleanParams);
                         updateURL(cleanParams);
                         updateClearFiltersButton();

                         // Scroll to products
                         document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
                     } catch (error) {
                         // Silent error handling for category navigation
                     }
                 });
             });

             // Initial setup
             updateClearFiltersButton();

             // Load initial cart count here in DOMContentLoaded
             loadCartCount();
         });

         // Cart Management Functions - Global scope

         // CSRF token
         window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

         // Load cart count on page load
         function loadCartCount() {
             fetch('/cart/data')
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         updateCartCount(data.cart_count);
                     }
                 })
                 .catch(error => {
                     console.error('Error loading cart count:', error);
                 });
         }

         // Update cart count in header
         function updateCartCount(count) {
             const cartCountElements = document.querySelectorAll('.cart-count');
             cartCountElements.forEach(element => {
                 element.textContent = count || 0;
                 element.style.display = count > 0 ? 'inline-block' : 'none';
             });
         }

         // Add to cart function - Make it global
         window.addToCart = function(productId, productName, quantity = 1) {
             console.log('=== ADD TO CART FUNCTION CALLED ===');
             console.log('Product ID:', productId);
             console.log('Product Name:', productName);
             console.log('Quantity:', quantity);
             console.log('CSRF Token:', window.csrfToken);

             if (!window.csrfToken) {
                 console.error('CSRF token not found');
                 alert('CSRF token not found! Page needs to be refreshed.');
                 return;
             }

             const button = document.querySelector(`button[data-product-id="${productId}"]`);
             console.log('Button found:', button);

             if (!button) {
                 console.error('Button not found for product:', productId);
                 alert('Button not found for product: ' + productId);
                 return;
             }

             const originalText = button.innerHTML;
             console.log('Original button text:', originalText);

             // Disable button and show loading
             button.disabled = true;
             button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> افزودن...';

             console.log('Sending fetch request...');

             fetch('/cart/add', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': window.csrfToken,
                     'Accept': 'application/json'
                 },
                 body: JSON.stringify({
                     product_id: productId,
                     quantity: quantity
                 })
             })
             .then(response => {
                 console.log('Response received:', response);
                 console.log('Response status:', response.status);
                 console.log('Response ok:', response.ok);

                 if (!response.ok) {
                     return response.text().then(text => {
                         console.error('Response error text:', text);
                         throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                     });
                 }
                 return response.json();
             })
             .then(data => {
                 console.log('Response data:', data);
                 if (data.success) {
                     // Update cart count
                     updateCartCount(data.cart_count);

                     // Show success message
                     showCartMessage(`✅ ${productName} به سبد خرید اضافه شد`, 'success');

                     // Temporarily change button text
                     button.innerHTML = '<i class="fas fa-check"></i> اضافه شد';
                     button.style.background = '#28a745';

                     setTimeout(() => {
                         button.innerHTML = originalText;
                         button.style.background = '';
                         button.disabled = false;
                     }, 2000);
                 } else {
                     console.error('Server returned error:', data.message);
                     showCartMessage(`❌ ${data.message}`, 'error');
                     button.innerHTML = originalText;
                     button.disabled = false;
                 }
             })
             .catch(error => {
                 console.error('Fetch error:', error);
                 showCartMessage('❌ خطا در افزودن محصول به سبد خرید: ' + error.message, 'error');
                 button.innerHTML = originalText;
                 button.disabled = false;
             });
         }

         // Show cart message
         function showCartMessage(message, type = 'success') {
             console.log('Showing message:', message, type);

             // Remove existing messages
             const existingMessages = document.querySelectorAll('.cart-message');
             existingMessages.forEach(msg => msg.remove());

             // Create message element
             const messageDiv = document.createElement('div');
             messageDiv.className = `cart-message cart-message-${type}`;
             messageDiv.style.cssText = `
                 position: fixed;
                 top: 20px;
                 right: 20px;
                 z-index: 9999;
                 padding: 1rem 1.5rem;
                 border-radius: 8px;
                 font-weight: 600;
                 box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                 animation: slideInRight 0.3s ease;
                 ${type === 'success' ? 'background: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 'background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'}
             `;
             messageDiv.textContent = message;

             // Add to body
             document.body.appendChild(messageDiv);

             // Auto remove after 4 seconds
             setTimeout(() => {
                 messageDiv.style.animation = 'slideOutRight 0.3s ease forwards';
                 setTimeout(() => messageDiv.remove(), 300);
             }, 4000);
         }

         // Event delegation for add to cart buttons (fallback if onclick doesn't work)
         document.addEventListener('click', function(e) {
             if (e.target.closest('.add-to-cart-btn')) {
                 const button = e.target.closest('.add-to-cart-btn');
                 const productId = button.getAttribute('data-product-id');
                 const productName = button.getAttribute('data-product-name');

                 if (productId && productName && !button.disabled) {
                     console.log('Event delegation triggered for product:', productId);
                     e.preventDefault();
                     e.stopPropagation();
                     window.addToCart(parseInt(productId), productName, 1);
                 }
             }
         });

         // Test function to verify JavaScript is loaded
         window.testCartFunction = function() {
             console.log('Cart JavaScript is loaded and working!');
             console.log('CSRF Token:', window.csrfToken);
             showCartMessage('✅ Cart JavaScript is working!', 'success');
         };

         // Add CSS animations
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
             .cart-count {
                 background: #ef394e;
                 color: white;
                 border-radius: 50%;
                 padding: 0.2rem 0.5rem;
                 font-size: 0.7rem;
                 margin-right: 0.5rem;
                 display: none;
                 min-width: 18px;
                 text-align: center;
             }
         `;
         document.head.appendChild(style);
     </script>
</body>
</html>
