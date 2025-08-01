<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سبد خرید - {{ $siteSettings->site_name ?? 'فروشگاه شکوفه' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Vazirmatn', sans-serif;
        min-height: 100vh;
        line-height: 1.6;
    }

    /* Header Styles */
    .top-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .top-bar .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .header {
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 2rem;
        font-weight: 900;
        color: #667eea;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 2rem;
        align-items: center;
    }

    .nav-menu a {
        color: #2c3e50;
        text-decoration: none;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-menu a:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .cart-icon {
        position: relative;
        color: #667eea;
        font-size: 1.5rem;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef394e;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .cart-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        min-height: 100vh;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .cart-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    .cart-main {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .cart-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="1" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .cart-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .cart-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    .cart-body {
        padding: 0;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto auto;
        gap: 1.5rem;
        align-items: center;
        padding: 2rem;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 1rem;
            padding: 1.5rem;
        }

        .cart-item-mobile {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
    }

    .product-image-container {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .cart-item:hover .product-image {
        transform: scale(1.05);
    }

    .product-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1rem;
        color: #ef394e;
        font-weight: 600;
        margin: 0;
    }

    .product-stock {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .quantity-btn {
        background: white;
        border: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #667eea;
        font-size: 1.2rem;
    }

    .quantity-btn:hover {
        background: #667eea;
        color: white;
        transform: scale(1.1);
    }

    .quantity-btn:active {
        transform: scale(0.95);
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        padding: 0.5rem;
    }

    .quantity-input:focus {
        outline: none;
    }

    .item-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        text-align: center;
        min-width: 120px;
    }

    .remove-btn {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        color: white;
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        font-size: 1rem;
    }

    .remove-btn:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    }

    .remove-btn:active {
        transform: scale(0.95);
    }

    /* Cart Summary Sidebar */
    .cart-summary {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        position: sticky;
        top: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .summary-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 1.5rem 0;
        text-align: center;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f3f4;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
        font-size: 1rem;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-size: 1.2rem;
        font-weight: 700;
        color: #ef394e;
        padding-top: 1.5rem;
        margin-top: 1rem;
        border-top: 2px solid #f1f3f4;
    }

    .summary-label {
        color: #6c757d;
        font-weight: 500;
    }

    .summary-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .free-shipping {
        color: #28a745 !important;
        font-weight: 600;
    }

    .shipping-notice {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 1px solid #90caf9;
        border-radius: 12px;
        padding: 1rem;
        margin: 1.5rem 0;
        font-size: 0.9rem;
        color: #1565c0;
        text-align: center;
        line-height: 1.5;
    }

    .checkout-btn {
        width: 100%;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin: 1.5rem 0;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .checkout-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
        color: white;
        text-decoration: none;
    }

    .checkout-btn:active {
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .action-btn {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 50px;
        border: 2px solid;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-clear {
        border-color: #dc3545;
        color: #dc3545;
        background: white;
    }

    .btn-clear:hover {
        background: #dc3545;
        color: white;
        text-decoration: none;
    }

    .btn-continue {
        border-color: #667eea;
        color: #667eea;
        background: white;
    }

    .btn-continue:hover {
        background: #667eea;
        color: white;
        text-decoration: none;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .empty-cart-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.6;
    }

    .empty-cart h3 {
        font-size: 1.8rem;
        color: #2c3e50;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .empty-cart p {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .continue-shopping {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .continue-shopping:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin: 1rem 2rem;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-error {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Animations */
    .cart-item {
        animation: slideInUp 0.5s ease;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .header .container {
            padding: 1rem;
        }

        .top-bar .container {
            padding: 0 1rem;
        }

        .cart-container {
            padding: 1rem 0.5rem;
        }

        .cart-title {
            font-size: 1.5rem;
        }

        .product-image-container {
            width: 80px;
            height: 80px;
        }

        .product-name {
            font-size: 1rem;
        }

        .summary-title {
            font-size: 1.3rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .nav-menu {
            display: none;
        }
    }

    /* Footer */
    .footer {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 2rem 0 1rem;
        margin-top: 3rem;
    }

    .footer .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        text-align: center;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .footer-section h3 {
        color: #ecf0f1;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .footer-section p, .footer-section a {
        color: #bdc3c7;
        text-decoration: none;
        line-height: 1.8;
    }

    .footer-section a:hover {
        color: #667eea;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1rem;
    }

    .social-links a {
        display: inline-flex;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background: #667eea;
        transform: translateY(-3px);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1rem;
        text-align: center;
        color: #95a5a6;
        font-size: 0.9rem;
    }
</style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div>📞 {{ $siteSettings->contact_phone ?? '09123456789' }}</div>
            <div>🚚 ارسال رایگان بالای 500 هزار تومان</div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="{{ route('welcome') }}" class="logo">
                @if($siteSettings->logo_url ?? false)
                    <img src="{{ $siteSettings->logo_url }}" alt="{{ $siteSettings->site_name }}" style="height: 50px;">
                @else
                    🧸 {{ $siteSettings->site_name ?? 'فروشگاه شکوفه' }}
                @endif
            </a>

            <nav>
                <ul class="nav-menu">
                    <li><a href="{{ route('welcome') }}">🏠 خانه</a></li>
                    <li><a href="{{ route('cart.index') }}">🛒 سبد خرید</a></li>
                    @auth
                        <li><a href="{{ route('profile.edit') }}">👤 پروفایل</a></li>
                    @else
                        <li><a href="{{ route('login') }}">ورود</a></li>
                        <li><a href="{{ route('register') }}">ثبت نام</a></li>
                    @endauth
                    <li>
                        <a href="{{ route('cart.index') }}" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count" id="cart-count">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="cart-container">
        @if($cartItems->count() > 0)
            <div class="cart-grid">
                <!-- Cart Items -->
                <div class="cart-main">
                    <div class="cart-header">
                        <div class="cart-header-content">
                            <h1 class="cart-title">🛒 سبد خرید شما</h1>
                            <p class="cart-subtitle">{{ $cartCount }} محصول در سبد خرید</p>
                        </div>
                    </div>

                    <div id="alerts-container"></div>

                    <div class="cart-body" id="cart-items">
                        @foreach($cartItems as $item)
                            <div class="cart-item" data-item-id="{{ $item->id }}">
                                <div class="product-image-container">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             alt="{{ $item->product->title }}"
                                             class="product-image">
                                    @else
                                        <div class="product-placeholder">📦</div>
                                    @endif
                                </div>

                                <div class="product-info">
                                    <h3 class="product-name">{{ $item->product->title }}</h3>
                                    <p class="product-price">{{ number_format($item->price) }} تومان</p>
                                    @if($item->product->stock < 5)
                                        <p class="product-stock">⚠️ تنها {{ $item->product->stock }} عدد باقی مانده</p>
                                    @endif
                                </div>

                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">−</button>
                                    <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                           min="1" max="{{ $item->product->stock }}"
                                           onchange="updateQuantity({{ $item->id }}, this.value)">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                </div>

                                <div class="item-total">
                                    <span class="item-total-price">{{ number_format($item->total_price) }}</span> تومان
                                </div>

                                <button class="remove-btn" onclick="removeItem({{ $item->id }})" title="حذف محصول">
                                    🗑️
                                </button>

                                <!-- Mobile Layout -->
                                <div class="cart-item-mobile" style="display: none;">
                                    <div class="quantity-controls">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">−</button>
                                        <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                               min="1" max="{{ $item->product->stock }}"
                                               onchange="updateQuantity({{ $item->id }}, this.value)">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                    </div>
                                    <div class="item-total">
                                        <span class="item-total-price">{{ number_format($item->total_price) }}</span> تومان
                                    </div>
                                    <button class="remove-btn" onclick="removeItem({{ $item->id }})" title="حذف محصول">🗑️</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h3 class="summary-title">💰 خلاصه سفارش</h3>

                    <div class="summary-row">
                        <span class="summary-label">مجموع کالاها:</span>
                        <span class="summary-value"><span id="cart-total">{{ number_format($cartTotal) }}</span> تومان</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">هزینه ارسال:</span>
                        @if($cartTotal >= 500000)
                            <span class="free-shipping">رایگان</span>
                        @else
                            <span class="summary-value">{{ number_format(50000) }} تومان</span>
                        @endif
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">مجموع نهایی:</span>
                        <span class="summary-value">
                            {{ number_format($cartTotal >= 500000 ? $cartTotal : $cartTotal + 50000) }} تومان
                        </span>
                    </div>

                    @if($cartTotal < 500000)
                        <div class="shipping-notice">
                            🚚 برای ارسال رایگان {{ number_format(500000 - $cartTotal) }} تومان تا هدف باقی مانده
                        </div>
                    @else
                        <div class="shipping-notice" style="background: linear-gradient(135deg, #e8f5e8 0%, #d4f4d4 100%); border-color: #90ee90; color: #2d5016;">
                            ✅ شما مشمول ارسال رایگان هستید!
                        </div>
                    @endif

                    <a href="{{ route('checkout.index') }}" class="checkout-btn">
                        <span>🛒</span>
                        <span>تکمیل خرید</span>
                    </a>

                    <div class="action-buttons">
                        <button type="button" class="action-btn btn-clear" onclick="clearCart()">
                            🗑️ خالی کردن سبد
                        </button>
                        <a href="{{ route('welcome') }}" class="action-btn btn-continue">
                            🛍️ ادامه خرید
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>سبد خرید شما خالی است</h3>
                <p>هنوز محصولی به سبد خرید خود اضافه نکرده‌اید.<br>محصولات فوق‌العاده ما را کشف کنید!</p>
                <a href="{{ route('welcome') }}" class="continue-shopping">
                    <span>🛍️</span>
                    <span>شروع خرید</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ $siteSettings->site_name ?? 'فروشگاه شکوفه' }}</h3>
                    <p>{{ $siteSettings->footer_text ?? 'بهترین اسباب‌بازی‌ها برای کودکان عزیز شما' }}</p>
                </div>

                <div class="footer-section">
                    <h3>اطلاعات تماس</h3>
                    <p>📞 {{ $siteSettings->contact_phone ?? '09123456789' }}</p>
                    <p>📧 {{ $siteSettings->contact_email ?? 'info@shokoofeh.com' }}</p>
                    <p>🕒 {{ $siteSettings->working_hours ?? 'شنبه تا پنج‌شنبه: 9 تا 18' }}</p>
                </div>

                <div class="footer-section">
                    <h3>شبکه‌های اجتماعی</h3>
                    <div class="social-links">
                        @if($siteSettings->social_instagram ?? false)
                            <a href="{{ $siteSettings->social_instagram }}" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if($siteSettings->social_telegram ?? false)
                            <a href="{{ $siteSettings->social_telegram }}" target="_blank">
                                <i class="fab fa-telegram"></i>
                            </a>
                        @endif
                        @if($siteSettings->social_whatsapp ?? false)
                            <a href="{{ $siteSettings->social_whatsapp }}" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>{{ $siteSettings->copyright_text ?? '© ۱۴۰۳ فروشگاه شکوفه. تمامی حقوق محفوظ است.' }}</p>
            </div>
        </div>
    </footer>

<script>
// CSRF token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Show alert function
function showAlert(message, type = 'success') {
    const alertsContainer = document.getElementById('alerts-container');
    const alertHtml = `
        <div class="alert alert-${type}">
            ${message}
        </div>
    `;
    alertsContainer.innerHTML = alertHtml;

    // Auto remove after 5 seconds
    setTimeout(() => {
        alertsContainer.innerHTML = '';
    }, 5000);
}

// Update quantity function
function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) return;

    const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
    cartItem.classList.add('loading');

    fetch(`/cart/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update quantity inputs
            cartItem.querySelectorAll('.quantity-input').forEach(input => {
                input.value = newQuantity;
            });

            // Update item total
            cartItem.querySelectorAll('.item-total-price').forEach(element => {
                element.textContent = data.item_total;
            });

            // Update cart total
            document.getElementById('cart-total').textContent = data.cart_total;

            // Update cart count in header if exists
            updateCartHeaderCount(data.cart_count);

            showAlert('✅ ' + data.message);
        } else {
            showAlert('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showAlert('❌ خطا در بروزرسانی سبد خرید', 'error');
    })
    .finally(() => {
        cartItem.classList.remove('loading');
    });
}

// Remove item function
function removeItem(itemId) {
    if (!confirm('آیا از حذف این محصول اطمینان دارید؟')) return;

    const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
    cartItem.style.transform = 'translateX(-100%)';
    cartItem.style.opacity = '0';

    setTimeout(() => {
        fetch(`/cart/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM
                cartItem.remove();

                // Update cart total
                document.getElementById('cart-total').textContent = data.cart_total;

                // Update cart count
                updateCartHeaderCount(data.cart_count);

                // Check if cart is empty
                if (data.cart_count === 0) {
                    setTimeout(() => location.reload(), 1000);
                }

                showAlert('✅ ' + data.message);
            } else {
                showAlert('❌ ' + data.message, 'error');
                // Restore item if failed
                cartItem.style.transform = '';
                cartItem.style.opacity = '';
            }
        })
        .catch(error => {
            showAlert('❌ خطا در حذف محصول', 'error');
            // Restore item if failed
            cartItem.style.transform = '';
            cartItem.style.opacity = '';
        });
    }, 300);
}

// Clear cart function
function clearCart() {
    if (!confirm('آیا از خالی کردن کامل سبد خرید اطمینان دارید؟')) return;

    fetch('/cart', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('✅ ' + data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('❌ ' + data.message, 'error');
        }
    })
    .catch(error => {
        showAlert('❌ خطا در خالی کردن سبد خرید', 'error');
    });
}

// Update cart count in header (if cart component exists in header)
function updateCartHeaderCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'inline-block' : 'none';
    });
}

// Mobile responsive behavior
function handleMobileLayout() {
    if (window.innerWidth <= 768) {
        document.querySelectorAll('.cart-item').forEach(item => {
            const mobileSection = item.querySelector('.cart-item-mobile');
            if (mobileSection) {
                mobileSection.style.display = 'flex';
            }
        });
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', handleMobileLayout);
window.addEventListener('resize', handleMobileLayout);
</script>
</body>
</html>

