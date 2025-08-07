<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'فروشگاه شکوفه') }}</title>

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

        /* Header Styles */
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
        }

        .header-btn.primary:hover {
            background: #d63031;
            color: white;
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            min-width: 200px;
            z-index: 1000;
            display: none;
            direction: rtl;
        }

        .dropdown.show .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e5e5;
            margin: 8px 0;
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

        /* Main Content */
        .main-content {
            margin: 2rem 0;
            min-height: 60vh;
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
        }

        /* Loading Animation */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>🚚 ارسال رایگان برای خریدهای بالای ۵۰۰ هزار تومان</span>
                    <span>📞 مشاوره: ۰۲۱-۱۲۳۴۵۶۷۸</span>
                </div>
            </div>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('welcome') }}" class="logo">
                        🧸 فروشگاه اسباب بازی شکوفه
                    </a>

                    <div class="search-container">
                        <form action="{{ route('welcome') }}" method="GET">
                            <input type="text" name="search" class="search-box"
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
                            @if(auth()->user()->hasAdminPrivileges())
                                <a href="{{ route('admin.dashboard') }}" class="header-btn">
                                    <i class="fas fa-tachometer-alt"></i>
                                    پنل مدیریت
                                </a>
                                <div class="dropdown">
                                    <a href="#" class="header-btn dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-user"></i>
                                        {{ auth()->user()->name }}
                                        <i class="fas fa-chevron-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                            <i class="fas fa-user-edit me-2"></i>
                                            ویرایش پروفایل
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            خروج
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('customer.orders.index') }}" class="header-btn">
                                    <i class="fas fa-shopping-bag"></i>
                                    سفارشات من
                                </a>
                                <div class="dropdown">
                                    <a href="#" class="header-btn dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-user"></i>
                                        {{ auth()->user()->name }}
                                        <i class="fas fa-chevron-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                            <i class="fas fa-user-edit me-2"></i>
                                            ویرایش پروفایل
                                        </a>
                                        <a href="{{ route('customer.orders.index') }}" class="dropdown-item">
                                            <i class="fas fa-shopping-bag me-2"></i>
                                            سفارشات من
                                        </a>
                                        <a href="{{ route('customer.orders.track') }}" class="dropdown-item">
                                            <i class="fas fa-search me-2"></i>
                                            پیگیری سفارش
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            خروج
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endif
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
                    <a href="{{ route('welcome') }}" class="nav-category">
                        <i class="fas fa-home"></i>
                        صفحه اصلی
                    </a>
                    <a href="{{ route('welcome') }}#products" class="nav-category">
                        <i class="fas fa-store"></i>
                        فروشگاه
                    </a>
                    <a href="#" class="nav-category">
                        <i class="fas fa-phone"></i>
                        تماس با ما
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>فروشگاه شکوفه</h3>
                    <p>مرجع خرید اسباب بازی‌های آموزشی و سرگرم‌کننده برای کودکان</p>
                    <p>با کیفیت برتر و قیمت مناسب</p>
                </div>
                <div class="footer-section">
                    <h3>تماس با ما</h3>
                    <p><i class="fas fa-phone"></i> ۰۲۱-۱۲۳۴۵۶۷۸</p>
                    <p><i class="fas fa-envelope"></i> info@shokoofeh.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> تهران، خیابان ولیعصر</p>
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
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} فروشگاه اسباب بازی شکوفه. تمامی حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>

    <script>
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

        // Load initial cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartCount();
        });
    </script>

    <script>
        // Cart count update
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('cart-count').textContent = data.count;
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Dropdown functionality
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdown = this.closest('.dropdown');
                    const isOpen = dropdown.classList.contains('show');

                    // Close all dropdowns
                    document.querySelectorAll('.dropdown').forEach(function(d) {
                        d.classList.remove('show');
                    });

                    // Toggle current dropdown
                    if (!isOpen) {
                        dropdown.classList.add('show');
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                    dropdown.classList.remove('show');
                });
            });

            // Prevent dropdown close when clicking inside
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
