<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'پنل مدیریت') - فروشگاه اسباب بازی شکوفه</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid #34495e;
            margin-bottom: 2rem;
        }

        .sidebar-header h2 {
            color: #3498db;
            font-size: 1.5rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: block;
            padding: 1rem 2rem;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s;
            border-right: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #34495e;
            color: white;
            border-right-color: #3498db;
        }

        .main-content {
            flex: 1;
            margin-right: 250px;
            padding: 2rem;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border-radius: 10px;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Mobile Navigation Toggle */
        .mobile-nav-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1001;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .mobile-nav-toggle:hover {
            background: #34495e;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-right: 220px;
                padding: 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 280px;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                box-shadow: -4px 0 8px rgba(0,0,0,0.1);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 1rem;
                padding-top: 4rem;
            }

            .mobile-nav-toggle {
                display: block;
            }

            .header {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .header h1 {
                font-size: 1.3rem;
                margin-bottom: 0.25rem;
            }

            .header p {
                font-size: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-label {
                font-size: 0.9rem;
            }

            .nav-link {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }

            .recent-products {
                margin-top: 1rem;
            }

            .recent-products h3 {
                font-size: 1.2rem;
                margin-bottom: 1rem;
            }

            .products-list {
                gap: 1rem;
            }

            .product-item {
                padding: 1rem;
            }

            .product-item h4 {
                font-size: 1rem;
            }

            .product-item p {
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
                min-height: 44px;
            }

            .alert {
                padding: 1rem;
                margin-bottom: 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                height: 100vh;
            }

            .main-content {
                padding: 0.75rem;
                padding-top: 4rem;
            }

            .header {
                padding: 0.75rem;
                border-radius: 6px;
            }

            .header h1 {
                font-size: 1.1rem;
            }

            .header p {
                font-size: 0.9rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }

            .stat-card {
                padding: 0.75rem;
            }

            .stat-number {
                font-size: 1.3rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .nav-link {
                padding: 1rem;
                font-size: 0.9rem;
            }

            .recent-products h3 {
                font-size: 1.1rem;
            }

            .products-list {
                flex-direction: column;
            }

            .product-item {
                padding: 0.75rem;
            }

            .product-item h4 {
                font-size: 0.9rem;
            }

            .product-item p {
                font-size: 0.8rem;
            }

            .btn {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
                min-height: 42px;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .nav-link {
                min-height: 48px;
                display: flex;
                align-items: center;
            }

            .nav-link:hover {
                background: #34495e;
            }

            .nav-link:active {
                background: #34495e;
            }

            .stat-card:hover {
                transform: none;
            }

            .stat-card:active {
                transform: scale(0.98);
                transition: transform 0.1s ease;
            }

            .btn {
                min-height: 48px;
            }

            .mobile-nav-toggle {
                min-height: 48px;
                min-width: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Accessibility improvements */
        .mobile-nav-toggle:focus {
            outline: 2px solid #3498db;
            outline-offset: 2px;
        }

        .nav-link:focus {
            outline: 2px solid #3498db;
            outline-offset: -2px;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .sidebar {
                transition: none;
            }

            .stat-card:hover {
                transform: none;
            }

            .mobile-overlay {
                transition: none;
            }
        }

        /* Table Styles for Admin Panel */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            margin: 2rem 0;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }

        .table-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .table-content {
            padding: 0;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
            min-width: 600px;
        }

        .admin-table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 1rem 1.25rem;
            text-align: right;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .admin-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-actions-cell {
            white-space: nowrap;
            text-align: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 36px;
            white-space: nowrap;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
            min-height: 32px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-1px);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .btn-group {
            display: flex;
            gap: 0.25rem;
        }

        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-primary {
            background: #d6e9ff;
            color: #004085;
        }

        .pagination-container {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            background: white;
            border: 1px solid #dee2e6;
            color: #495057;
            text-decoration: none;
            transition: all 0.2s ease;
            min-width: 40px;
            height: 40px;
        }

        .pagination .page-link:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .empty-state-text {
            margin-bottom: 2rem;
        }

        /* Search and Filter Styles */
        .table-filters {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .filter-control {
            padding: 0.5rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.875rem;
            min-width: 150px;
        }

        .filter-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        /* Responsive Table Design */
        @media (max-width: 768px) {
            .table-header {
                padding: 1rem;
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .table-title {
                font-size: 1.1rem;
            }

            .table-actions {
                justify-content: center;
            }

            .table-filters {
                padding: 1rem;
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .filter-control {
                min-width: auto;
                width: 100%;
            }

            .table-content {
                padding: 0;
            }

            .admin-table {
                font-size: 0.875rem;
                min-width: 500px;
            }

            .admin-table th,
            .admin-table td {
                padding: 0.75rem 0.5rem;
            }

            .btn-group {
                flex-direction: column;
                gap: 0.25rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }

            .pagination-container {
                padding: 1rem;
            }

            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                min-width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .table-header {
                padding: 0.75rem;
            }

            .table-title {
                font-size: 1rem;
            }

            .admin-table {
                min-width: 400px;
            }

            .admin-table th,
            .admin-table td {
                padding: 0.5rem 0.375rem;
                font-size: 0.8rem;
            }

            .btn {
                font-size: 0.75rem;
                padding: 0.375rem 0.5rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
            }

            .admin-table tbody tr:hover {
                background-color: transparent;
            }

            .admin-table tbody tr:active {
                background-color: #f8f9fa;
            }

            .pagination .page-link {
                min-height: 44px;
            }

            .filter-control {
                min-height: 44px;
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }

        /* Form Controls in Tables */
        .table-form-control {
            padding: 0.375rem 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.875rem;
            width: 100%;
            max-width: 200px;
        }

        .table-form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        .table-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Card Style for Mobile Tables */
        @media (max-width: 576px) {
            .admin-table,
            .admin-table thead,
            .admin-table tbody,
            .admin-table th,
            .admin-table td,
            .admin-table tr {
                display: block;
            }

            .admin-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .admin-table tr {
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 1rem;
                padding: 1rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .admin-table td {
                border: none;
                padding: 0.5rem 0;
                position: relative;
                padding-right: 50% !important;
            }

            .admin-table td:before {
                content: attr(data-label) ": ";
                position: absolute;
                right: 6px;
                width: 45%;
                padding-left: 10px;
                white-space: nowrap;
                font-weight: 600;
                color: #495057;
            }

            .table-actions-cell:before {
                content: "عملیات: ";
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Navigation Toggle -->
    <button class="mobile-nav-toggle" onclick="toggleMobileNav()" aria-label="Toggle navigation">
        ☰
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="closeMobileNav()"></div>

    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>🧸 پنل مدیریت</h2>
                <p>سلام {{ auth()->user()->name }}!</p>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            📊 داشبورد
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            🧸 محصولات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.age-groups.index') }}" class="nav-link {{ request()->routeIs('admin.age-groups.*') ? 'active' : '' }}">
                            👶 گروه‌های سنی
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.game-types.index') }}" class="nav-link {{ request()->routeIs('admin.game-types.*') ? 'active' : '' }}">
                            🎮 انواع بازی
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            📂 دسته‌بندی‌ها
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.discounts.index') }}" class="nav-link {{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                            🏷️ تخفیفات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                            🖼️ اسلایدرها
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.site-settings.edit') }}" class="nav-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}">
                            ⚙️ تنظیمات سایت
                        </a>
                    </li>

                    <li class="nav-item" style="border-top: 1px solid #34495e; margin-top: 1rem; padding-top: 1rem;">
                        <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                            👤 پروفایل من
                        </a>
                    </li>

                    @if(auth()->user()->role === 'super_admin')
                        <li class="nav-item" style="border-top: 1px solid #34495e; margin-top: 1rem; padding-top: 1rem;">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                👥 مدیریت کاربران
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                                📋 گزارش فعالیت‌ها
                            </a>
                        </li>
                    @endif

                    <li class="nav-item" style="border-top: 1px solid #34495e; margin-top: 1rem; padding-top: 1rem;">
                        <a href="{{ route('welcome') }}" class="nav-link" target="_blank">
                            🌐 مشاهده سایت
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; text-align: right; background: none; border: none; color: #bdc3c7; cursor: pointer;">
                                🚪 خروج
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleMobileNav() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            const toggle = document.querySelector('.mobile-nav-toggle');

            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');

            // Update toggle button text
            toggle.innerHTML = sidebar.classList.contains('active') ? '✕' : '☰';

            // Update aria-label
            toggle.setAttribute('aria-label',
                sidebar.classList.contains('active') ? 'Close navigation' : 'Open navigation'
            );
        }

        function closeMobileNav() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            const toggle = document.querySelector('.mobile-nav-toggle');

            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            toggle.innerHTML = '☰';
            toggle.setAttribute('aria-label', 'Open navigation');
        }

        // Close mobile nav when clicking on nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeMobileNav();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMobileNav();
            }
        });

        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMobileNav();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
