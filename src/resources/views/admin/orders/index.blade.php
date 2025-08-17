@extends('layouts.dashboard')

@section('title', 'مدیریت سفارشات')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders-admin.css') }}">
@endpush

@section('content')
<div class="orders-admin orders-fade-in">
    <!-- Search Filters Card -->
    <div class="orders-card orders-card-filters mb-4">
        <div class="orders-card-header">
            <h6 class="mb-0">
                <i class="fas fa-search me-2"></i>
                جستجو و فیلتر سفارشات
            </h6>
        </div>
        <div class="orders-card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="orders-form-row">
                    <div class="orders-form-col">
                        <label class="orders-form-label">نام مشتری</label>
                        <input type="text" name="customer_name" class="orders-form-control"
                               value="{{ request('customer_name') }}"
                               placeholder="جستجو بر اساس نام مشتری...">
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">موبایل</label>
                        <input type="text" name="customer_phone" class="orders-form-control"
                               value="{{ request('customer_phone') }}"
                               placeholder="جستجو بر اساس شماره موبایل...">
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">کد سفارش</label>
                        <input type="text" name="order_number" class="orders-form-control"
                               value="{{ request('order_number') }}"
                               placeholder="مثال: ORD-202501-001">
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">کد رهگیری پستی</label>
                        <input type="text" name="tracking_code" class="orders-form-control"
                               value="{{ request('tracking_code') }}"
                               placeholder="کد رهگیری پست...">
                    </div>
                </div>

                <div class="orders-form-row mt-3">
                    <div class="orders-form-col">
                        <label class="orders-form-label">وضعیت سفارش</label>
                        <select name="status" class="orders-form-control orders-form-select">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="pending" @selected(request('status')=='pending')>در انتظار تایید</option>
                            <option value="confirmed" @selected(request('status')=='confirmed')>تایید شده</option>
                            <option value="processing" @selected(request('status')=='processing')>در حال پردازش</option>
                            <option value="shipped" @selected(request('status')=='shipped')>ارسال شده</option>
                            <option value="delivered" @selected(request('status')=='delivered')>تحویل شده</option>
                            <option value="cancelled" @selected(request('status')=='cancelled')>لغو شده</option>
                        </select>
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">وضعیت پرداخت</label>
                        <select name="payment_status" class="orders-form-control orders-form-select">
                            <option value="">همه پرداخت‌ها</option>
                            <option value="pending" @selected(request('payment_status')=='pending')>در انتظار پرداخت</option>
                            <option value="paid" @selected(request('payment_status')=='paid')>پرداخت شده</option>
                            <option value="failed" @selected(request('payment_status')=='failed')>ناموفق</option>
                            <option value="refunded" @selected(request('payment_status')=='refunded')>بازگشت داده شده</option>
                        </select>
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">تاریخ از</label>
                        <input type="date" name="date_from" class="orders-form-control"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="orders-form-col">
                        <label class="orders-form-label">تاریخ تا</label>
                        <input type="date" name="date_to" class="orders-form-control"
                               value="{{ request('date_to') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="orders-btn-group">
                        <button type="submit" class="orders-btn orders-btn-primary">
                            <i class="fas fa-search me-1"></i>
                            اعمال فیلتر
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="orders-btn orders-btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            حذف فیلتر
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="orders-badge orders-badge-info">
                            {{ $orders->total() }} سفارش یافت شد
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="orders-stats-grid">
        <div class="orders-stat-card orders-stat-card-primary">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ number_format($orders->total()) }}</h4>
                    <small>کل سفارشات</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card orders-stat-card-warning">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ $orders->where('status', 'pending')->count() }}</h4>
                    <small>در انتظار تایید</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card orders-stat-card-success">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ $orders->where('payment_status', 'paid')->count() }}</h4>
                    <small>پرداخت موفق</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="orders-stat-card orders-stat-card-info-variant">
            <div class="orders-stat-card-content">
                <div class="orders-stat-card-info">
                    <h4>{{ number_format($orders->sum('total')) }}</h4>
                    <small>مجموع فروش (تومان)</small>
                </div>
                <div class="orders-stat-card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="orders-table-container orders-slide-up">
        <div class="orders-table-header">
            <h3 class="orders-table-title">
                <i class="fas fa-list-alt me-2"></i>
                لیست سفارشات
            </h3>
            <div class="orders-table-actions">
                <div class="dropdown">
                    <button class="orders-btn orders-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i>
                        مرتب‌سازی
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => 'desc']) }}">جدیدترین</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => 'asc']) }}">قدیمی‌ترین</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort_by' => 'total', 'sort_order' => 'desc']) }}">بیشترین مبلغ</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort_by' => 'total', 'sort_order' => 'asc']) }}">کمترین مبلغ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="orders-table-content">
            <div class="orders-table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">کد سفارش</th>
                            <th style="width: 20%;">مشتری</th>
                            <th style="width: 12%;">وضعیت سفارش</th>
                            <th style="width: 15%;">وضعیت پرداخت</th>
                            <th style="width: 12%;">مبلغ</th>
                            <th style="width: 12%;">تاریخ ثبت</th>
                            <th style="width: 14%;" class="orders-table-actions-cell">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="orders-fade-in">
                                <td>
                                    <div class="orders-info-item">
                                        <span class="orders-info-item-value monospace">{{ $order->order_number }}</span>
                                        @if($order->tracking_code)
                                            <div class="mt-1">
                                                <span class="orders-badge orders-badge-info">
                                                    <i class="fas fa-truck me-1"></i>
                                                    {{ $order->tracking_code }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="orders-customer-info">
                                        <div class="orders-customer-name">{{ $order->customer_name }}</div>
                                        <div class="orders-customer-contact">{{ $order->customer_phone }}</div>
                                        @if($order->customer_email)
                                            <div class="orders-customer-contact small">{{ $order->customer_email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="orders-badge orders-badge-{{ $order->status }}">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <div class="orders-payment-info">
                                        <span class="orders-badge orders-badge-payment-{{ $order->payment_status }}">
                                            {{ $order->payment_status_text }}
                                        </span>
                                        @if($order->payment_reference_id)
                                            <div class="mt-1">
                                                <small class="text-muted">کد: {{ $order->payment_reference_id }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="orders-payment-amount">
                                        {{ number_format($order->total) }} تومان
                                    </div>
                                </td>
                                <td>
                                    <div class="orders-date-info">
                                        <div class="orders-date-main">{{ jdate($order->created_at)->format('Y/m/d') }}</div>
                                        <div class="orders-date-time">{{ jdate($order->created_at)->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td class="orders-table-actions-cell">
                                    <div class="orders-btn-group">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="orders-btn orders-btn-info orders-btn-sm"
                                           title="مشاهده جزئیات"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}"
                                           class="orders-btn orders-btn-warning orders-btn-sm"
                                           title="ویرایش سفارش"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="orders-empty-state">
                                        <div class="orders-empty-state-icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <h5>هیچ سفارشی یافت نشد</h5>
                                        <p>با استفاده از فیلترهای بالا می‌توانید جستجو کنید یا منتظر ثبت سفارش جدید باشید.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="orders-pagination-container">
                {{ $orders->appends(request()->query())->links('pagination.custom') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Form Submission for Filters
    const filterForm = document.querySelector('form[method="GET"]');
    const submitButton = filterForm.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال پردازش...';
        submitButton.disabled = true;

        // Get form data
        const formData = new FormData(filterForm);
        const queryString = new URLSearchParams(formData).toString();

        // Make AJAX request
        fetch(`${filterForm.action}?${queryString}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html, application/xhtml+xml, application/xml;q=0.9, image/webp, */*;q=0.8'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            // Extract the orders table content
            const newTableContent = tempDiv.querySelector('.orders-table-content');
            const newStatsGrid = tempDiv.querySelector('.orders-stats-grid');
            const newPagination = tempDiv.querySelector('.orders-pagination-container');
            const newBadge = tempDiv.querySelector('.orders-badge-info');

            // Update the content
            if (newTableContent) {
                const currentTableContent = document.querySelector('.orders-table-content');
                if (currentTableContent) {
                    currentTableContent.innerHTML = newTableContent.innerHTML;
                }
            }

            if (newStatsGrid) {
                const currentStatsGrid = document.querySelector('.orders-stats-grid');
                if (currentStatsGrid) {
                    currentStatsGrid.innerHTML = newStatsGrid.innerHTML;
                }
            }

            if (newPagination) {
                const currentPagination = document.querySelector('.orders-pagination-container');
                if (currentPagination) {
                    currentPagination.innerHTML = newPagination.innerHTML;
                } else {
                    const tableContainer = document.querySelector('.orders-table-container');
                    if (tableContainer) {
                        tableContainer.appendChild(newPagination);
                    }
                }
            } else {
                const currentPagination = document.querySelector('.orders-pagination-container');
                if (currentPagination) {
                    currentPagination.remove();
                }
            }

            if (newBadge) {
                const currentBadge = document.querySelector('.orders-badge-info');
                if (currentBadge) {
                    currentBadge.innerHTML = newBadge.innerHTML;
                }
            }

            // Update URL without page reload
            const newUrl = `${window.location.pathname}?${queryString}`;
            window.history.pushState({}, '', newUrl);

            // Reinitialize interactive elements
            initializeInteractiveElements();

            // Show success message
            showNotification('فیلترها با موفقیت اعمال شد', 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('خطا در اعمال فیلترها. لطفاً دوباره تلاش کنید.', 'error');
        })
        .finally(() => {
            // Reset button state
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
        });
    });

    // Function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    // Function to reinitialize interactive elements
    function initializeInteractiveElements() {
        // Reinitialize tooltips
        const tooltipButtons = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipButtons.forEach(button => {
            const title = button.getAttribute('title');
            if (title) {
                button.classList.add('persian-tooltip');
                button.setAttribute('data-tooltip', title);
                button.removeAttribute('title');
            }
        });

        // Reinitialize table row hover effects
        const tableRows = document.querySelectorAll('.orders-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'scale(1.005)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });

        // Reinitialize badge animations
        const badges = document.querySelectorAll('.orders-badge');
        badges.forEach((badge, index) => {
            setTimeout(() => {
                badge.style.opacity = '1';
                badge.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    // Dropdown functionality
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open dropdowns
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        const otherMenu = otherDropdown.querySelector('.dropdown-menu');
                        if (otherMenu) {
                            otherMenu.classList.remove('show');
                        }
                    }
                });

                // Toggle current dropdown
                menu.classList.toggle('show');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        dropdowns.forEach(dropdown => {
            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                menu.classList.remove('show');
            }
        });
    });

    // Prevent dropdown close when clicking inside menu
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Custom tooltip functionality
    const tooltipButtons = document.querySelectorAll('[data-bs-toggle="tooltip"]');

    tooltipButtons.forEach(button => {
        const title = button.getAttribute('title');
        if (title) {
            button.classList.add('persian-tooltip');
            button.setAttribute('data-tooltip', title);
            button.removeAttribute('title');
        }
    });

    // Enhanced button interactions
    const actionButtons = document.querySelectorAll('.orders-btn');

    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Table row hover effects
    const tableRows = document.querySelectorAll('.orders-table tbody tr');

    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.transform = 'scale(1.005)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });

        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });

    // Auto-refresh functionality
    let refreshInterval;
    const refreshButton = document.createElement('button');
    refreshButton.className = 'orders-btn orders-btn-secondary orders-btn-sm';
    refreshButton.innerHTML = '<i class="fas fa-sync-alt"></i> <span>تازه‌سازی</span>';
    refreshButton.title = 'تازه‌سازی خودکار هر 30 ثانیه';

    const actionsContainer = document.querySelector('.orders-table-actions');
    if (actionsContainer) {
        actionsContainer.appendChild(refreshButton);

        refreshButton.addEventListener('click', function() {
            this.classList.add('rotating');
            setTimeout(() => {
                window.location.reload();
            }, 500);
        });
    }

    // Badge animations
    const badges = document.querySelectorAll('.orders-badge');
    badges.forEach((badge, index) => {
        setTimeout(() => {
            badge.style.opacity = '1';
            badge.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Additional animations
const style = document.createElement('style');
style.textContent = `
    .rotating {
        animation: rotate 0.5s linear;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .orders-badge {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .orders-table tbody tr {
        transition: all 0.2s ease;
    }

    .orders-btn {
        transition: all 0.2s ease;
    }

    .alert {
        animation: slideInRight 0.3s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
