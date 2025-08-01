<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'صفحه اصلی')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #f8f9fa;
                color: #333;
                line-height: 1.6;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .header {
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                padding: 1rem 0;
                margin-bottom: 2rem;
            }

            .header h1 {
                color: #2c3e50;
                font-size: 1.8rem;
                font-weight: 600;
            }

            .btn {
                display: inline-block;
                padding: 0.5rem 1rem;
                background-color: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                border: none;
                cursor: pointer;
                font-size: 0.9rem;
                transition: background-color 0.3s;
            }

            .btn:hover {
                background-color: #2980b9;
            }

            .btn-success {
                background-color: #27ae60;
            }

            .btn-success:hover {
                background-color: #229954;
            }

            .btn-warning {
                background-color: #f39c12;
            }

            .btn-warning:hover {
                background-color: #e67e22;
            }

            .btn-danger {
                background-color: #e74c3c;
            }

            .btn-danger:hover {
                background-color: #c0392b;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .table th,
            .table td {
                padding: 1rem;
                text-align: right;
                border-bottom: 1px solid #eee;
            }

            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                color: #2c3e50;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 500;
                color: #2c3e50;
            }

            .form-control {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 1rem;
                transition: border-color 0.3s;
            }

            .form-control:focus {
                outline: none;
                border-color: #3498db;
                box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            }

            .card {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                padding: 2rem;
                margin-bottom: 2rem;
            }

            .card h2 {
                color: #2c3e50;
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }

            .actions {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .product-details {
                list-style: none;
            }

            .product-details li {
                padding: 0.5rem 0;
                border-bottom: 1px solid #eee;
            }

            .product-details li:last-child {
                border-bottom: none;
            }

            .product-details strong {
                color: #2c3e50;
                margin-left: 0.5rem;
            }

            .alert {
                padding: 1rem;
                border-radius: 4px;
                margin-bottom: 1rem;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .text-center {
                text-align: center;
            }

            .mb-3 {
                margin-bottom: 1rem;
            }

            .mt-3 {
                margin-top: 1rem;
            }
        </style>
    @endif
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>فروشگاه اسباب بازی شکوفه</h1>
            <nav style="margin-top: 1rem;">
                <a href="{{ route('admin.products.index') }}" class="btn">محصولات</a>
                <a href="{{ route('admin.age-groups.index') }}" class="btn">گروه‌های سنی</a>
                <a href="{{ route('admin.game-types.index') }}" class="btn">انواع بازی</a>
                <a href="{{ route('admin.categories.index') }}" class="btn">دسته‌بندی‌ها</a>
            </nav>
        </div>
    </header>

    <main class="container">
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

    <footer class="text-center" style="margin-top: 3rem; padding: 2rem 0; color: #666;">
        <div class="container">
            <p>&copy; {{ date('Y') }} فروشگاه اسباب بازی شکوفه. تمامی حقوق محفوظ است.</p>
        </div>
    </footer>
</body>
</html>
