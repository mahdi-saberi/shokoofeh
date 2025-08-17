@extends('layouts.dashboard')

@section('title', 'داشبورد مدیریت')

@push('styles')
<style>
    /* استایل مدرن و زیبا برای جداول */
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .modern-table thead th {
        padding: 18px 15px;
        text-align: right;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: none;
        position: relative;
    }

    .modern-table thead th:first-child {
        padding-right: 25px;
    }

    .modern-table thead th:last-child {
        padding-left: 25px;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .modern-table tbody tr:nth-child(even) {
        background-color: #fafbfc;
    }

    .modern-table tbody tr:hover {
        background-color: #e8f4fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modern-table tbody td {
        padding: 16px 15px;
        border: none;
        vertical-align: middle;
        font-size: 14px;
        color: #2c3e50;
        line-height: 1.4;
    }

    .modern-table tbody td:first-child {
        padding-right: 25px;
    }

    .modern-table tbody td:last-child {
        padding-left: 25px;
    }

    /* استایل تصاویر در جدول */
    .table-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .table-image:hover {
        transform: scale(1.1);
    }

    .table-image-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border: 2px dashed #bdc3c7;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7f8c8d;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .table-image-placeholder:hover {
        background: linear-gradient(135deg, #dfe9f3 0%, #b4c6d8 100%);
        border-color: #95a5a6;
    }

    /* استایل بج‌ها */
    .table-badge {
        display: inline-block;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin: 2px;
        box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
        transition: all 0.3s ease;
    }

    .table-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
    }

    /* استایل دکمه‌های عملیات */
    .table-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .table-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .table-btn-info:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
        color: white;
        text-decoration: none;
    }

    .table-btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .table-btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
        color: #212529;
        text-decoration: none;
    }

    /* استایل متن "تعیین نشده" */
    .table-undefined {
        color: #95a5a6;
        font-style: italic;
        font-weight: 500;
    }

    /* استایل responsive */
    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
            border-radius: 8px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
        }

        .table-image,
        .table-image-placeholder {
            width: 45px;
            height: 45px;
        }

        .table-actions {
            flex-direction: column;
            gap: 4px;
        }

        .table-btn {
            padding: 6px 12px;
            font-size: 0.7rem;
        }
    }

    /* انیمیشن loading برای جدول */
    .table-loading {
        position: relative;
        overflow: hidden;
    }

    .table-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        animation: loading 1.5s infinite;
    }

         @keyframes loading {
         0% { left: -100%; }
         100% { left: 100%; }
     }

     /* انیمیشن ورود جدول */
     .modern-table {
         animation: fadeInUp 0.6s ease-out;
     }

     @keyframes fadeInUp {
         from {
             opacity: 0;
             transform: translateY(30px);
         }
         to {
             opacity: 1;
             transform: translateY(0);
         }
     }

     /* انیمیشن ورود ردیف‌ها */
     .modern-table tbody tr {
         animation: fadeInRow 0.5s ease-out backwards;
     }

     .modern-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
     .modern-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
     .modern-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
     .modern-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
     .modern-table tbody tr:nth-child(5) { animation-delay: 0.5s; }

     @keyframes fadeInRow {
         from {
             opacity: 0;
             transform: translateX(-20px);
         }
         to {
             opacity: 1;
             transform: translateX(0);
         }
     }

     /* افکت pulse برای badge ها */
     .table-badge {
         animation: pulse 2s infinite;
     }

     @keyframes pulse {
         0% {
             box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
         }
         50% {
             box-shadow: 0 2px 4px rgba(52, 152, 219, 0.5);
         }
         100% {
             box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
         }
     }

     /* افکت شینی برای header جدول */
     .modern-table thead th::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
         transition: left 0.5s;
     }

     .modern-table:hover thead th::before {
         left: 100%;
     }

     /* افکت زوم برای کل جدول در hover */
     .card:hover .modern-table {
         transform: scale(1.01);
         transition: transform 0.3s ease;
     }

     /* رنگ‌های مختلف برای badge های گروه سنی */
     .table-badge.age-1 { background: linear-gradient(135deg, #e74c3c, #c0392b); }
     .table-badge.age-2 { background: linear-gradient(135deg, #3498db, #2980b9); }
     .table-badge.age-3 { background: linear-gradient(135deg, #f39c12, #d68910); }
     .table-badge.age-4 { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
     .table-badge.age-5 { background: linear-gradient(135deg, #1abc9c, #16a085); }

     /* افکت loading skeleton */
     .table-skeleton {
         background: linear-gradient(90deg, #f0f0f0 25%, transparent 37%, #f0f0f0 63%);
         background-size: 400% 100%;
         animation: skeleton 1.5s ease-in-out infinite;
     }

     @keyframes skeleton {
         0% { background-position: 100% 50%; }
         100% { background-position: 0% 50%; }
     }

     /* افکت tooltip ساده */
     .table-tooltip {
         position: relative;
         cursor: help;
     }

     .table-tooltip:hover::after {
         content: attr(data-tooltip);
         position: absolute;
         bottom: 100%;
         left: 50%;
         transform: translateX(-50%);
         background: #2c3e50;
         color: white;
         padding: 8px 12px;
         border-radius: 6px;
         white-space: nowrap;
         font-size: 0.8rem;
         z-index: 1000;
         box-shadow: 0 2px 8px rgba(0,0,0,0.2);
     }

     /* بهبود scroll افقی در موبایل */
     .table-container {
         overflow-x: auto;
         -webkit-overflow-scrolling: touch;
     }

     .table-container::-webkit-scrollbar {
         height: 8px;
     }

     .table-container::-webkit-scrollbar-track {
         background: #f1f1f1;
         border-radius: 10px;
     }

     .table-container::-webkit-scrollbar-thumb {
         background: linear-gradient(135deg, #667eea, #764ba2);
         border-radius: 10px;
     }

     .table-container::-webkit-scrollbar-thumb:hover {
         background: linear-gradient(135deg, #5a6fd8, #6a4190);
     }

     /* استایل نمودار */
     .chart-container {
         position: relative;
         height: 400px;
         margin: 20px 0;
         background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
         border-radius: 15px;
         padding: 20px;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
     }

     .chart-container canvas {
         max-height: 100% !important;
         width: 100% !important;
     }

     /* انیمیشن نمودار */
     .chart-container {
         animation: fadeInUp 0.8s ease-out;
     }

     @keyframes fadeInUp {
         from {
             opacity: 0;
             transform: translateY(30px);
         }
         to {
             opacity: 1;
             transform: translateY(0);
         }
     }

     /* افکت hover برای نمودار */
     .chart-container:hover {
         transform: translateY(-5px);
         box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
         transition: all 0.3s ease;
     }

     /* استایل کارت‌های آمار اضافی */
     .stats-grid-secondary {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
         gap: 1.5rem;
         margin: 2rem 0;
     }

     .stat-card-secondary {
         background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
         border-radius: 15px;
         padding: 1.5rem;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
         border: 1px solid #e9ecef;
         transition: all 0.3s ease;
         display: flex;
         align-items: center;
         gap: 1rem;
     }

     .stat-card-secondary:hover {
         transform: translateY(-5px);
         box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
         border-color: #667eea;
     }

     .stat-icon {
         font-size: 2.5rem;
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.3));
     }

     .stat-content {
         flex: 1;
     }

     .stat-card-secondary .stat-number {
         font-size: 1.8rem;
         font-weight: 700;
         color: #2c3e50;
         margin-bottom: 0.5rem;
         font-family: 'Instrument Sans', sans-serif;
     }

     .stat-card-secondary .stat-label {
         color: #6c757d;
         font-size: 0.9rem;
         font-weight: 500;
     }

     /* انیمیشن ورود کارت‌های آمار */
     .stat-card-secondary {
         animation: fadeInUp 0.6s ease-out backwards;
     }

     .stat-card-secondary:nth-child(1) { animation-delay: 0.1s; }
     .stat-card-secondary:nth-child(2) { animation-delay: 0.2s; }
     .stat-card-secondary:nth-child(3) { animation-delay: 0.3s; }
     .stat-card-secondary:nth-child(4) { animation-delay: 0.4s; }

     /* responsive برای کارت‌های آمار */
     @media (max-width: 768px) {
         .stats-grid-secondary {
             grid-template-columns: 1fr;
             gap: 1rem;
         }

         .stat-card-secondary {
             padding: 1rem;
         }

         .stat-icon {
             font-size: 2rem;
         }

         .stat-card-secondary .stat-number {
             font-size: 1.5rem;
         }
     }
 </style>
@endpush

@section('content')
    <div class="header">
        <h1>داشبورد مدیریت</h1>
        <p>خوش آمدید! اینجا می‌توانید تمام بخش‌های سایت را مدیریت کنید.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\Product::count() }}</div>
            <div class="stat-label">تعداد محصولات</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $totalOrders }}</div>
            <div class="stat-label">کل سفارش‌ها</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ format_currency($totalRevenue) }}</div>
            <div class="stat-label">درآمد کل (پرداخت شده)</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $pendingOrders }}</div>
            <div class="stat-label">سفارش‌های در انتظار</div>
        </div>
    </div>

    <!-- آمار اضافی -->
    <div class="stats-grid-secondary">
        <div class="stat-card-secondary">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <div class="stat-number">{{ $completedOrders }}</div>
                <div class="stat-label">سفارش‌های تکمیل شده</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <div class="stat-number">{{ format_currency($todayRevenue) }}</div>
                <div class="stat-label">درآمد امروز</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-number">{{ format_currency($weekRevenue) }}</div>
                <div class="stat-label">درآمد این هفته</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">🎯</div>
            <div class="stat-content">
                <div class="stat-number">{{ format_currency($monthRevenue) }}</div>
                <div class="stat-label">درآمد این ماه</div>
            </div>
        </div>
    </div>

    <!-- آمار سفارش‌های زمانی -->
    <div class="stats-grid-secondary">
        <div class="stat-card-secondary">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <div class="stat-number">{{ $todayOrders }}</div>
                <div class="stat-label">سفارش‌های امروز (پرداخت شده)</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">📈</div>
            <div class="stat-content">
                <div class="stat-number">{{ $weekOrders }}</div>
                <div class="stat-label">سفارش‌های این هفته (پرداخت شده)</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-number">{{ $monthOrders }}</div>
                <div class="stat-label">سفارش‌های این ماه (پرداخت شده)</div>
            </div>
        </div>
        <div class="stat-card-secondary">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalOrders > 0 ? number_format(($completedOrders / $totalOrders) * 100, 1) : 0 }}%</div>
                <div class="stat-label">نرخ تکمیل سفارش</div>
            </div>
        </div>
    </div>

    <!-- نمودار سفارش‌ها -->
    <div class="card">
        <div class="card-header">
            <h3>📊 نمودار سفارش‌های پرداخت شده (۳۰ روز گذشته)</h3>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="ordersChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>محصولات اخیر</h3>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>عنوان</th>
                            <th>گروه سنی</th>
                            <th>نوع بازی</th>
                            <th>دسته‌بندی</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="table-image">
                                    @else
                                        <div class="table-image-placeholder">
                                            📷 عکس
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->title }}</strong>
                                </td>
                                <td>
                                    @if($product->age_group && count($product->age_group) > 0)
                                        @foreach($product->age_group as $index => $age)
                                            <span class="table-badge age-{{ ($index % 5) + 1 }}" data-tooltip="گروه سنی: {{ is_array($age) ? implode(', ', $age) : $age }}">
                                                {{ is_array($age) ? implode(', ', $age) : $age }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($product->game_type) ? count($product->game_type) > 0 : !empty($product->game_type))
                                        {{ is_array($product->game_type) ? implode(', ', $product->game_type) : $product->game_type }}
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($product->category) ? count($product->category) > 0 : !empty($product->category))
                                        @if(is_array($product->category))
                                            {{ implode(', ', $product->category) }}
                                        @elseif(is_string($product->category))
                                            {{ $product->category }}
                                        @elseif(is_object($product->category))
                                            {{ $product->category->title ?? 'نامشخص' }}
                                        @else
                                            نامشخص
                                        @endif
                                    @else
                                        <span class="table-undefined">تعیین نشده</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="color: #6c757d; font-size: 0.9rem;">{{ persian_date($product->created_at) }}</span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="table-btn table-btn-info">👁️ نمایش</a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="table-btn table-btn-warning">✏️ ویرایش</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem; text-align: center; padding-top: 1.5rem; border-top: 1px solid #e9ecef;">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary" style="
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border: none;
                        padding: 12px 30px;
                        border-radius: 25px;
                        color: white;
                        text-decoration: none;
                        font-weight: 600;
                        font-size: 0.95rem;
                        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                        transition: all 0.3s ease;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                    " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.3)'">
                        📋 مشاهده همه محصولات
                    </a>
                </div>
            @else
                <div style="
                    text-align: center;
                    padding: 4rem 2rem;
                    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                    border-radius: 15px;
                    border: 2px dashed #dee2e6;
                ">
                    <div style="
                        font-size: 4rem;
                        margin-bottom: 1rem;
                        opacity: 0.6;
                        background: linear-gradient(135deg, #667eea, #764ba2);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                    ">📦</div>
                    <p style="
                        color: #6c757d;
                        font-size: 1.1rem;
                        margin-bottom: 1.5rem;
                        font-weight: 500;
                    ">هیچ محصولی یافت نشد!</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="
                        background: linear-gradient(135deg, #28a745, #20c997);
                        border: none;
                        padding: 12px 30px;
                        border-radius: 25px;
                        color: white;
                        text-decoration: none;
                        font-weight: 600;
                        font-size: 0.95rem;
                        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                        transition: all 0.3s ease;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                    " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(40, 167, 69, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(40, 167, 69, 0.3)'">
                        ➕ ایجاد اولین محصول
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // داده‌های نمودار از سرور
        const chartData = @json($orders);

        // تبدیل تاریخ‌ها به فرمت فارسی
        const persianDates = chartData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('fa-IR', {
                month: 'short',
                day: 'numeric'
            });
        });

        // داده‌های نمودار
        const orderCounts = chartData.map(item => item.count);
        const orderAmounts = chartData.map(item => parseFloat(item.total_amount || 0));

        // ایجاد نمودار
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: persianDates,
                datasets: [
                    {
                        label: 'تعداد سفارش‌ها',
                        data: orderCounts,
                        borderColor: 'rgba(102, 126, 234, 1)',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        yAxisID: 'y'
                    },
                    {
                        label: 'مبلغ سفارش‌ها (میلیون تومان)',
                        data: orderAmounts.map(amount => (amount / 1000000).toFixed(1)),
                        borderColor: 'rgba(118, 75, 162, 1)',
                        backgroundColor: 'rgba(118, 75, 162, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(118, 75, 162, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    title: {
                        display: true,
                        text: '📊 آمار سفارش‌های پرداخت شده در ۳۰ روز گذشته',
                        font: {
                            size: 16,
                            family: 'Instrument Sans, sans-serif'
                        },
                        color: '#2c3e50'
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(44, 62, 80, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(102, 126, 234, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return `تعداد سفارش: ${context.parsed.y} عدد`;
                                } else {
                                    return `مبلغ: ${context.parsed.y} میلیون تومان`;
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'تاریخ',
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'تعداد سفارش‌ها',
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 10
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'مبلغ (میلیون تومان)',
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 12
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Instrument Sans, sans-serif',
                                size: 10
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: 'rgba(102, 126, 234, 0.8)',
                        hoverBorderColor: '#fff'
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // انیمیشن ورود نمودار
        setTimeout(() => {
            ordersChart.update('none');
        }, 500);
    </script>
    @endpush
@endsection
