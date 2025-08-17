<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($siteSettings->site_name); ?><?php if($siteSettings->site_description): ?> | <?php echo e($siteSettings->site_description); ?><?php endif; ?></title>

    <?php if($siteSettings->meta_description): ?>
        <meta name="description" content="<?php echo e($siteSettings->meta_description); ?>">
    <?php endif; ?>

    <?php if($siteSettings->meta_keywords): ?>
        <meta name="keywords" content="<?php echo e($siteSettings->meta_keywords); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=vazirmatn:300,400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/shokoofeh-modern.css')); ?>" rel="stylesheet" />

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
        <?php if($siteSettings->header_announcement_enabled && $siteSettings->header_announcement_text): ?>
            <div class="header-announcement" style="background: <?php echo e($siteSettings->header_announcement_bg_color ?? '#667eea'); ?>; color: <?php echo e($siteSettings->header_announcement_text_color ?? '#ffffff'); ?>;">
                <div class="container">
                    <?php echo $siteSettings->header_announcement_text; ?>

                </div>
            </div>
        <?php endif; ?>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <a href="<?php echo e(route('welcome')); ?>" class="modern-logo">
                        <span class="logo-icon">🧸</span>
                        <span><?php echo e($siteSettings->site_name ?: 'شکوفه'); ?></span>
                    </a>

                    <!-- Search -->
                    <div class="modern-search">
                        <form action="<?php echo e(route('welcome')); ?>" method="GET" class="search-form">
                            <input type="text"
                                   name="search"
                                   class="search-input"
                                   placeholder="دنبال چه اسباب بازی‌ای هستی؟ 🔍"
                                   value="<?php echo e(request('search')); ?>">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="header-action-btn">
                                <span class="action-icon">👤</span>
                                <span class="action-label">پروفایل</span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="header-action-btn">
                                <span class="action-icon">🔑</span>
                                <span class="action-label">ورود</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo e(route('cart.index')); ?>" class="header-action-btn cart-btn">
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
                    <a href="<?php echo e(route('welcome')); ?>" class="nav-category <?php echo e(!request('category') && !request('age_group') && !request('game_type') ? 'active' : ''); ?>">
                        <span class="category-icon">🏠</span>
                        <span>همه محصولات</span>
                    </a>
                    <?php $__currentLoopData = $categories->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('welcome', ['category' => $category->id])); ?>"
                           class="nav-category <?php echo e(request('category') == $category->id ? 'active' : ''); ?>">
                            <span class="category-icon">
                                <?php switch($category->id):
                                    case (1): ?> 🧩 <?php break; ?>
                                    <?php case (2): ?> 🚗 <?php break; ?>
                                    <?php case (3): ?> 🎭 <?php break; ?>
                                    <?php case (4): ?> 🎨 <?php break; ?>
                                    <?php case (5): ?> 🔬 <?php break; ?>
                                    <?php case (6): ?> 🎯 <?php break; ?>
                                    <?php case (7): ?> 🎵 <?php break; ?>
                                    <?php case (8): ?> ⚽ <?php break; ?>
                                    <?php default: ?> 🎲
                                <?php endswitch; ?>
                            </span>
                            <span><?php echo e($category->title); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="container">
        <?php if($sliders && $sliders->count() > 0): ?>
            <section class="modern-hero">
                <div class="hero-slider">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="hero-slide <?php echo e($index === 0 ? 'active' : ''); ?>"
                             style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8)), url('<?php echo e($slider->image_url); ?>') center/cover;">
                            <div class="hero-content fade-in-up">
                                <h1 class="hero-title"><?php echo e($slider->title); ?></h1>
                                <p class="hero-subtitle"><?php echo e($slider->description); ?></p>
                                <?php if($slider->link_url): ?>
                                    <a href="<?php echo e($slider->link_url); ?>" class="hero-cta">
                                        <span>مشاهده محصولات</span>
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($sliders->count() > 1): ?>
                    <div class="hero-indicators">
                        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="hero-indicator <?php echo e($index === 0 ? 'active' : ''); ?>"
                                  data-slide="<?php echo e($index); ?>"></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Quick Categories (Age Groups) - Moved above slider -->
        <div class="quick-categories" style="display: flex !important; flex-wrap: nowrap !important; gap: 1rem !important; justify-content: center !important; margin: 2rem 0 !important; overflow-x: auto !important; padding: 0.5rem 0 !important;">
            <?php $__currentLoopData = $ageGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ageGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="quick-category-item" style="background: white !important; border-radius: 0.75rem !important; padding: 1rem !important; text-align: center !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; border: 2px solid #DDD6FE !important; min-width: 120px !important; max-width: 140px !important; margin: 0 !important; display: inline-block !important; vertical-align: top !important; flex-shrink: 0 !important;">
                    <a href="<?php echo e(route('welcome', ['age_group' => $ageGroup->id])); ?>" class="quick-category-link" style="text-decoration: none !important; color: #2F3542 !important; display: flex !important; flex-direction: column !important; align-items: center !important; gap: 0.5rem !important;">
                        <div class="quick-category-icon" style="font-size: 1.5rem !important; margin-bottom: 0.5rem !important;">
                            <?php switch($ageGroup->id):
                                case (1): ?> 👶 <?php break; ?>
                                <?php case (2): ?> 🧒 <?php break; ?>
                                <?php case (3): ?> 👧 <?php break; ?>
                                <?php case (4): ?> 👦 <?php break; ?>
                                <?php case (5): ?> 🧑 <?php break; ?>
                                <?php case (6): ?> 👨 <?php break; ?>
                                <?php default: ?> 🎯
                            <?php endswitch; ?>
                        </div>
                        <span style="font-weight: 600 !important; font-size: 0.875rem !important; line-height: 1.2 !important;"><?php echo e($ageGroup->title); ?></span>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

            <!-- Featured Products Section -->
            <section class="featured-products-section">
                <div class="section-header">
                    <h2 class="section-title">🌟 محصولات ویژه و پرفروش</h2>
                    <p class="section-subtitle">بهترین اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان</p>
                </div>

                <!-- Featured Products Carousel -->
                <?php if($featuredProducts->count() > 0): ?>
                    <div class="featured-products-carousel">
                        <h3 class="featured-subtitle">🎯 محصولات ویژه</h3>
                        <div class="carousel-container">
                            <button class="carousel-arrow carousel-prev" onclick="moveCarousel('prev')">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="products-carousel" id="featured-carousel">
                                <?php $__currentLoopData = $featuredProducts->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="product-card featured-card fade-in-up">
                                        <div class="product-badge">
                                            <?php if($product->stock <= 0): ?>
                                                <span class="badge out-of-stock">ناموجود</span>
                                            <?php elseif($product->stock <= 5): ?>
                                                <span class="badge low-stock">کم موجود</span>
                                            <?php else: ?>
                                                <span class="badge in-stock">موجود</span>
                                            <?php endif; ?>
                                            <?php if($product->hasDiscount()): ?>
                                                <span class="badge discount"><?php echo e($product->discount_percentage); ?>% تخفیف</span>
                                            <?php endif; ?>
                                        </div>

                                        <a href="<?php echo e(route('product.show', $product->id)); ?>" class="product-link">
                                            <div class="product-image-container">
                                                <img src="<?php echo e($product->image_url ?: 'https://via.placeholder.com/300x200?text=تصویر+محصول'); ?>"
                                                     alt="<?php echo e($product->title); ?>"
                                                     class="product-image"
                                                     loading="lazy">
                                            </div>

                                            <div class="product-info">
                                                <h3 class="product-title"><?php echo e($product->title); ?></h3>
                                                <p class="product-description"><?php echo e(Str::limit($product->description, 60)); ?></p>

                                                <div class="product-meta">
                                                    <?php if($product->age_group): ?>
                                                        <span class="product-age">
                                                            <i class="fas fa-baby"></i>
                                                            <?php echo e(is_array($product->age_group) ? implode(', ', $product->age_group) : $product->age_group); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($product->gender): ?>
                                                        <span class="product-gender">
                                                            <?php echo $product->gender_icon; ?>

                                                            <?php echo e($product->gender == 'male' ? 'پسرانه' : ($product->gender == 'female' ? 'دخترانه' : ($product->gender == 'هردو' ? 'عمومی' : $product->gender))); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Product Tags -->
                                                <?php if($product->tags && $product->tags->count() > 0): ?>
                                                    <div class="product-tags-mini">
                                                        <?php $__currentLoopData = $product->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="product-tag-mini"
                                                                  style="background-color: <?php echo e($tag->color); ?>20; color: <?php echo e($tag->color); ?>; border: 1px solid <?php echo e($tag->color); ?>40;">
                                                                <?php echo e($tag->name); ?>

                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($product->tags->count() > 2): ?>
                                                            <span class="product-tag-more">+<?php echo e($product->tags->count() - 2); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="product-price">
                                                    <?php if($product->hasDiscount()): ?>
                                                        <div class="price-discounted">
                                                            <span class="price-original"><?php echo e(number_format($product->price)); ?></span>
                                                            <span class="price-amount"><?php echo e(number_format($product->discounted_price)); ?></span>
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                    <?php elseif($product->price > 0): ?>
                                                        <span class="price-amount"><?php echo e(number_format($product->price)); ?></span>
                                                        <span class="price-currency">تومان</span>
                                                    <?php else: ?>
                                                        <span class="price-free">رایگان</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="product-actions">
                                            <?php if($product->stock > 0): ?>
                                                <button class="btn-add-cart" onclick="addToCart(<?php echo e($product->id); ?>); event.stopPropagation();">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    <span>افزودن به سبد</span>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn-out-of-stock" disabled>
                                                    <i class="fas fa-times"></i>
                                                    <span>ناموجود</span>
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn-wishlist" onclick="toggleWishlist(<?php echo e($product->id); ?>); event.stopPropagation();">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button class="carousel-arrow carousel-next" onclick="moveCarousel('next')">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

            <!-- Discounted Products Grid -->
            <?php if($discountedProducts->count() > 0): ?>
                <div class="discounted-products-grid">
                    <h3 class="featured-subtitle">🏷️ محصولات با تخفیف</h3>
                    <div class="products-grid discounted-grid">
                        <?php $__currentLoopData = $discountedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="product-card discounted-card fade-in-up">
                                <div class="product-badge">
                                    <?php if($product->stock <= 0): ?>
                                        <span class="badge out-of-stock">ناموجود</span>
                                    <?php elseif($product->stock <= 5): ?>
                                        <span class="badge low-stock">کم موجود</span>
                                    <?php else: ?>
                                        <span class="badge in-stock">موجود</span>
                                    <?php endif; ?>
                                    <span class="badge discount"><?php echo e($product->discount_percentage); ?>% تخفیف</span>
                                </div>

                                <a href="<?php echo e(route('product.show', $product->id)); ?>" class="product-link">
                                    <div class="product-image-container">
                                        <img src="<?php echo e($product->image_url ?: 'https://via.placeholder.com/300x200?text=تصویر+محصول'); ?>"
                                             alt="<?php echo e($product->title); ?>"
                                             class="product-image"
                                             loading="lazy">
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-title"><?php echo e($product->title); ?></h3>
                                        <p class="product-description"><?php echo e(Str::limit($product->description, 60)); ?></p>

                                        <div class="product-meta">
                                            <?php if($product->age_group): ?>
                                                <span class="product-age">
                                                    <i class="fas fa-baby"></i>
                                                    <?php echo e(is_array($product->age_group) ? implode(', ', $product->age_group) : $product->age_group); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if($product->gender): ?>
                                                <span class="product-gender">
                                                    <?php echo $product->gender_icon; ?>

                                                    <?php echo e($product->gender == 'male' ? 'پسرانه' : ($product->gender == 'female' ? 'دخترانه' : ($product->gender == 'هردو' ? 'عمومی' : $product->gender))); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Product Tags -->
                                        <?php if($product->tags && $product->tags->count() > 0): ?>
                                            <div class="product-tags-mini">
                                                <?php $__currentLoopData = $product->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="product-tag-mini"
                                                          style="background-color: <?php echo e($tag->color); ?>20; color: <?php echo e($tag->color); ?>; border: 1px solid <?php echo e($tag->color); ?>40;">
                                                        <?php echo e($tag->name); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($product->tags->count() > 2): ?>
                                                    <span class="product-tag-more">+<?php echo e($product->tags->count() - 2); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="product-price">
                                            <div class="price-discounted">
                                                <span class="price-original"><?php echo e(number_format($product->price)); ?></span>
                                                <span class="price-amount"><?php echo e(number_format($product->discounted_price)); ?></span>
                                                <span class="price-currency">تومان</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="product-actions">
                                    <?php if($product->stock > 0): ?>
                                        <button class="btn-add-cart" onclick="addToCart(<?php echo e($product->id); ?>); event.stopPropagation();">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>افزودن به سبد</span>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-out-of-stock" disabled>
                                            <i class="fas fa-times"></i>
                                            <span>ناموجود</span>
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn-wishlist" onclick="toggleWishlist(<?php echo e($product->id); ?>); event.stopPropagation();">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <!-- Smart Filters Section - Single Row -->
        <section class="smart-filters-section" style="background: white !important; border-radius: 1rem !important; padding: 2rem !important; margin: 2rem 0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important; border: 1px solid #DDD6FE !important;">
            <div class="filters-header" style="text-align: center !important; margin-bottom: 2rem !important;">
                <h3 class="filters-title" style="font-size: 1.25rem !important; font-weight: 600 !important; color: #2F3542 !important; margin-bottom: 0.5rem !important;">🔍 جستجوی هوشمند</h3>
                <p class="filters-subtitle" style="font-size: 1rem !important; color: #747D8C !important; line-height: 1.6 !important;">محصول مورد نظرتان را به راحتی پیدا کنید</p>
            </div>
            <form id="filter-form" action="<?php echo e(route('welcome')); ?>" method="GET" class="smart-filter-form">
                <div class="filters-grid" style="display: grid !important; grid-template-columns: repeat(5, 1fr) !important; gap: 1.5rem !important; align-items: end !important;">
                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🎯 دسته‌بندی</label>
                        <select name="category" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه دسته‌ها</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">👶 گروه سنی</label>
                        <select name="age_group" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه سنین</option>
                            <?php $__currentLoopData = $ageGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ageGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ageGroup->id); ?>"
                                        <?php echo e(request('age_group') == $ageGroup->id ? 'selected' : ''); ?>>
                                    <?php echo e($ageGroup->title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🎮 نوع بازی</label>
                        <select name="game_type" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه انواع</option>
                            <?php $__currentLoopData = $gameTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gameType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($gameType->id); ?>"
                                        <?php echo e(request('game_type') == $gameType->id ? 'selected' : ''); ?>>
                                    <?php echo e($gameType->title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">🏷️ برچسب</label>
                        <select name="tag" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="">همه برچسب‌ها</option>
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tag->slug); ?>"
                                        <?php echo e(request('tag') == $tag->slug ? 'selected' : ''); ?>>
                                    <?php echo e($tag->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="filter-group" style="display: flex !important; flex-direction: column !important; gap: 0.5rem !important; margin: 0 !important;">
                        <label class="filter-label" style="font-size: 0.875rem !important; font-weight: 500 !important; color: #2F3542 !important; margin-bottom: 0.25rem !important;">📊 مرتب‌سازی</label>
                        <select name="sort" class="filter-select" style="width: 100% !important; padding: 0.75rem !important; border: 2px solid #DDD6FE !important; border-radius: 0.5rem !important; font-size: 0.875rem !important; background: white !important; transition: all 0.3s ease !important;">
                            <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>جدیدترین</option>
                            <option value="price-asc" <?php echo e(request('sort') == 'price-asc' ? 'selected' : ''); ?>>ارزان‌ترین</option>
                            <option value="price-desc" <?php echo e(request('sort') == 'price-desc' ? 'selected' : ''); ?>>گران‌ترین</option>
                            <option value="name-asc" <?php echo e(request('sort') == 'name-asc' ? 'selected' : ''); ?>>نام (الف-ی)</option>
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
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-card fade-in-up">
                        <div class="product-badge">
                            <?php if($product->stock <= 0): ?>
                                <span class="badge out-of-stock">ناموجود</span>
                            <?php elseif($product->stock <= 5): ?>
                                <span class="badge low-stock">کم موجود</span>
                            <?php else: ?>
                                <span class="badge in-stock">موجود</span>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo e(route('product.show', $product->id)); ?>" class="product-link">
                            <div class="product-image-container">
                                <img src="<?php echo e($product->image_url ?: 'https://via.placeholder.com/300x200?text=تصویر+محصول'); ?>"
                                     alt="<?php echo e($product->title); ?>"
                                     class="product-image"
                                     loading="lazy">
                            </div>

                            <div class="product-info">
                                <h3 class="product-title"><?php echo e($product->title); ?></h3>
                                <p class="product-description"><?php echo e(Str::limit($product->description, 80)); ?></p>

                                <div class="product-meta">
                                    <?php if($product->age_group): ?>
                                        <span class="product-age">
                                            <?php if(is_array($product->age_group)): ?>
                                                <?php echo e(implode(', ', array_slice($product->age_group, 0, 2))); ?>

                                            <?php else: ?>
                                                <?php echo e($product->age_group); ?>

                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if($product->category): ?>
                                        <span class="product-category">
                                            <?php if(is_array($product->category)): ?>
                                                <?php echo e(implode(', ', array_slice($product->category, 0, 1))); ?>

                                            <?php else: ?>
                                                <?php echo e($product->category); ?>

                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Tags -->
                                <?php if($product->tags && $product->tags->count() > 0): ?>
                                    <div class="product-tags-mini">
                                        <?php $__currentLoopData = $product->tags->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="product-tag-mini"
                                                  style="background-color: <?php echo e($tag->color); ?>20; color: <?php echo e($tag->color); ?>; border: 1px solid <?php echo e($tag->color); ?>40;">
                                                <?php echo e($tag->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($product->tags->count() > 3): ?>
                                            <span class="product-tag-more">+<?php echo e($product->tags->count() - 3); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="product-price">
                                    <?php if($product->price > 0): ?>
                                        <span class="price-amount"><?php echo e(number_format($product->price)); ?></span>
                                        <span class="price-currency">تومان</span>
                                    <?php else: ?>
                                        <span class="price-free">رایگان</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>

                        <div class="product-actions">
                            <?php if($product->stock > 0): ?>
                                <button class="btn-add-cart" onclick="addToCart(<?php echo e($product->id); ?>); event.stopPropagation();">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>افزودن به سبد</span>
                                </button>
                            <?php else: ?>
                                <button class="btn-out-of-stock" disabled>
                                    <i class="fas fa-times"></i>
                                    <span>ناموجود</span>
                                </button>
                            <?php endif; ?>
                            <button class="btn-wishlist" onclick="toggleWishlist(<?php echo e($product->id); ?>); event.stopPropagation();">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-products">
                        <div class="empty-icon">🎁</div>
                        <h3>محصولی یافت نشد</h3>
                        <p>با تغییر فیلترها محصولات بیشتری را مشاهده کنید</p>
                        <a href="<?php echo e(route('welcome')); ?>" class="btn-primary">مشاهده همه محصولات</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Load More Button -->
            <?php if($products->hasPages()): ?>
                <div class="load-more-container">
                    <?php echo e($products->appends(request()->query())->links('pagination.persian')); ?>

                </div>
            <?php endif; ?>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-grid">
                <?php $__currentLoopData = $siteSettings->feature_boxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureBox): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="feature-item">
                        <div class="feature-icon"><?php echo e($featureBox['icon']); ?></div>
                        <h3 class="feature-title"><?php echo e($featureBox['title']); ?></h3>
                        <p class="feature-description"><?php echo e($featureBox['description']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo e($siteSettings->site_name ?: 'فروشگاه شکوفه'); ?></h3>
                    <p><?php echo e($siteSettings->site_description ?: 'مرجع خرید اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان'); ?></p>
                    <p>با کیفیت برتر و قیمت مناسب</p>
                </div>

                <div class="footer-section">
                    <h3>تماس با ما</h3>
                    <p><i class="fas fa-phone"></i> <?php echo e($siteSettings->contact_phone ?: '۰۲۱-۱۲۳۴۵۶۷۸'); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo e($siteSettings->contact_email ?: 'info@shokoofeh.com'); ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo e($siteSettings->contact_address ?: 'تهران، خیابان ولیعصر'); ?></p>
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
                    <p><a href="<?php echo e(route('welcome')); ?>">صفحه اصلی</a></p>
                    <p><a href="<?php echo e(route('welcome')); ?>#products">فروشگاه</a></p>
                    <p><a href="#">درباره ما</a></p>
                    <p><a href="<?php echo e(route('cart.index')); ?>">سبد خرید</a></p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($siteSettings->site_name ?: 'فروشگاه اسباب بازی شکوفه'); ?>. تمامی حقوق محفوظ است.</p>
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

            fetch('<?php echo e(route("cart.add")); ?>', {
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
            fetch('<?php echo e(route("cart.count")); ?>', {
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
<?php /**PATH /var/www/resources/views/welcome.blade.php ENDPATH**/ ?>