@extends('layouts.dashboard')

@section('title', 'مدیریت تیکت‌ها')

@push('styles')
<style>
    /* استایل مدرن برای صفحه تیکت‌ها */
    .tickets-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .tickets-header {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .tickets-header h2 {
        color: #2c3e50;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .tickets-header p {
        color: #7f8c8d;
        font-size: 1.1rem;
        margin: 0;
    }

    .filters-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filters-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .filters-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .filters-body {
        padding: 2rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .filter-control {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .filter-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        align-items: end;
    }

    .btn-modern {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-modern {
        background: #6c757d;
        color: white;
    }

    .btn-secondary-modern:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        color: white;
        text-decoration: none;
    }

    .tickets-table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .tickets-table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tickets-table-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .tickets-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .tickets-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .tickets-table th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        padding: 1.25rem 1rem;
        text-align: right;
        border-bottom: 2px solid #e9ecef;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tickets-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .tickets-table tbody tr {
        transition: all 0.3s ease;
    }

    .tickets-table tbody tr:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .ticket-number {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #667eea;
        background: #f8f9fa;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .user-email {
        color: #7f8c8d;
        font-size: 0.8rem;
    }

    .ticket-subject {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .ticket-description {
        color: #7f8c8d;
        font-size: 0.8rem;
        line-height: 1.4;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-open { background: linear-gradient(135deg, #ffc107, #ff9800); color: white; }
    .status-in_progress { background: linear-gradient(135deg, #17a2b8, #138496); color: white; }
    .status-answered { background: linear-gradient(135deg, #28a745, #20c997); color: white; }
    .status-closed { background: linear-gradient(135deg, #6c757d, #5a6268); color: white; }

    .priority-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .priority-low { background: linear-gradient(135deg, #28a745, #20c997); color: white; }
    .priority-medium { background: linear-gradient(135deg, #17a2b8, #138496); color: white; }
    .priority-high { background: linear-gradient(135deg, #ffc107, #ff9800); color: white; }
    .priority-urgent { background: linear-gradient(135deg, #dc3545, #c82333); color: white; }

    .category-badge {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .date-main {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.85rem;
    }

    .date-time {
        color: #7f8c8d;
        font-size: 0.75rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
    }

    .btn-view {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-reply {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-reply:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 20px;
        margin: 2rem;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #7f8c8d;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #7f8c8d;
        margin: 0;
    }

    .pagination-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    @media (max-width: 768px) {
        .tickets-header h2 {
            font-size: 2rem;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .tickets-table {
            font-size: 0.8rem;
        }

        .tickets-table th,
        .tickets-table td {
            padding: 0.75rem 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="tickets-container">
    <div class="container-fluid">
        <!-- Header -->
        <div class="tickets-header">
            <h2>🎫 مدیریت تیکت‌ها</h2>
            <p>مدیریت و پاسخ‌دهی به درخواست‌های کاربران</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-header">
                <h5><i class="fas fa-search me-2"></i>فیلتر و جستجو</h5>
            </div>
            <div class="filters-body">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <label for="search">🔍 جستجو</label>
                        <input type="text" class="filter-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="شماره تیکت، موضوع یا نام کاربر...">
                    </div>
                    <div class="filter-group">
                        <label for="status">📊 وضعیت</label>
                        <select class="filter-control" id="status" name="status">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>باز</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>در حال بررسی</option>
                            <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>پاسخ داده شده</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>بسته شده</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="priority">⚡ اولویت</label>
                        <select class="filter-control" id="priority" name="priority">
                            <option value="">همه اولویت‌ها</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>کم</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسط</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>زیاد</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>فوری</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="category">📁 دسته‌بندی</label>
                        <select class="filter-control" id="category" name="category">
                            <option value="">همه دسته‌ها</option>
                            <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>عمومی</option>
                            <option value="technical" {{ request('category') == 'technical' ? 'selected' : '' }}>فنی</option>
                            <option value="order" {{ request('category') == 'order' ? 'selected' : '' }}>سفارش</option>
                            <option value="payment" {{ request('category') == 'payment' ? 'selected' : '' }}>پرداخت</option>
                            <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>سایر</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-modern btn-primary-modern">
                            <i class="fas fa-search"></i>
                            اعمال فیلتر
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="btn-modern btn-secondary-modern">
                            <i class="fas fa-times"></i>
                            پاک کردن
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tickets Table -->
        <div class="tickets-table-card">
            <div class="tickets-table-header">
                <h5><i class="fas fa-list me-2"></i>لیست تیکت‌ها</h5>
                <div class="tickets-count">
                    <i class="fas fa-ticket-alt me-1"></i>
                    {{ $tickets->total() }} تیکت
                </div>
            </div>

            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="tickets-table">
                        <thead>
                            <tr>
                                <th>شماره تیکت</th>
                                <th>کاربر</th>
                                <th>موضوع</th>
                                <th>وضعیت</th>
                                <th>اولویت</th>
                                <th>دسته‌بندی</th>
                                <th>تاریخ ایجاد</th>
                                <th>آخرین پاسخ</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>
                                        <span class="ticket-number">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-name">{{ $ticket->user->name }}</div>
                                            <div class="user-email">{{ $ticket->user->email }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ticket-subject">{{ $ticket->subject }}</div>
                                        <div class="ticket-description">{{ Str::limit($ticket->description, 60) }}</div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $ticket->status }}">
                                            {{ $ticket->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="priority-badge priority-{{ $ticket->priority }}">
                                            {{ $ticket->priority_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="category-badge">
                                            {{ $ticket->category_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="date-main">{{ persian_date($ticket->created_at) }}</div>
                                            <div class="date-time">{{ $ticket->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($ticket->last_reply_at)
                                            <div class="date-info">
                                                <div class="date-main">{{ persian_date($ticket->last_reply_at) }}</div>
                                                <div class="date-time">{{ $ticket->last_reply_at->format('H:i') }}</div>
                                            </div>
                                        @else
                                            <span class="text-muted">بدون پاسخ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                                               class="btn-action btn-view" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($ticket->isOpen())
                                                <a href="{{ route('admin.tickets.show', $ticket) }}#reply"
                                                   class="btn-action btn-reply" title="پاسخ">
                                                    <i class="fas fa-reply"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h5>هیچ تیکتی یافت نشد</h5>
                    <p>با استفاده از فیلترهای بالا می‌توانید جستجو کنید.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
