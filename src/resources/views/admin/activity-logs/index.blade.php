@extends('layouts.dashboard')

@section('title', 'لاگ فعالیت‌ها')

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

    /* استایل بج‌ها */
    .table-badge {
        display: inline-block;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin: 2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .table-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }

    .table-badge.action-create { background: linear-gradient(135deg, #27ae60, #229954); }
    .table-badge.action-update { background: linear-gradient(135deg, #f39c12, #d68910); }
    .table-badge.action-delete { background: linear-gradient(135deg, #e74c3c, #c0392b); }
    .table-badge.action-login { background: linear-gradient(135deg, #3498db, #2980b9); }
    .table-badge.action-logout { background: linear-gradient(135deg, #95a5a6, #7f8c8d); }

    /* استایل دکمه‌های عملیات */
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
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .table-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: inherit;
    }

    /* انیمیشن ورود */
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

    /* Container برای scroll */
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

    /* استایل فیلترها */
    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9rem;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    }

    /* استایل pagination */
    .pagination-container {
        margin-top: 3rem;
        padding: 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        min-width: 44px;
        min-height: 44px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
        position: relative;
    }

    .pagination .page-link:hover {
        background: #f8f9fa;
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-1px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
        font-weight: 600;
    }

    .pagination .page-item.active .page-link:hover {
        background: linear-gradient(135deg, #764ba2, #8b5cf6);
        transform: translateY(-1px);
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none;
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .pagination-info {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        background: #f8f9fa;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 500;
    }

    /* responsive */
    @media (max-width: 1200px) {
        .filters-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .filters-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
        }

        .table-btn {
            padding: 6px 12px;
            font-size: 0.7rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .btn {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            min-height: 48px;
        }

        .form-control {
            min-height: 48px;
            font-size: 16px; /* جلوگیری از zoom در iOS */
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="header">
        <h1>لاگ فعالیت‌های سیستم</h1>
        <p>مشاهده و بررسی تمام فعالیت‌های انجام شده در سیستم</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>فیلتر فعالیت‌ها</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="filters-form">
                <div class="filters-grid">
                    <div class="form-group">
                        <label for="user_id">👤 کاربر:</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">همه کاربران</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="action">⚡ عملیات:</label>
                        <select name="action" id="action" class="form-control">
                            <option value="">همه عملیات</option>
                            <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>➕ ایجاد</option>
                            <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>✏️ ویرایش</option>
                            <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>🗑️ حذف</option>
                            <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>🔓 ورود</option>
                            <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>🔒 خروج</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="model_type">📊 نوع مدل:</label>
                        <select name="model_type" id="model_type" class="form-control">
                            <option value="">همه مدل‌ها</option>
                            <option value="App\Models\Product" {{ request('model_type') == 'App\Models\Product' ? 'selected' : '' }}>📦 محصولات</option>
                            <option value="App\Models\User" {{ request('model_type') == 'App\Models\User' ? 'selected' : '' }}>👤 کاربران</option>
                            <option value="App\Models\AgeGroup" {{ request('model_type') == 'App\Models\AgeGroup' ? 'selected' : '' }}>👶 گروه‌های سنی</option>
                            <option value="App\Models\GameType" {{ request('model_type') == 'App\Models\GameType' ? 'selected' : '' }}>🎮 انواع بازی</option>
                            <option value="App\Models\Category" {{ request('model_type') == 'App\Models\Category' ? 'selected' : '' }}>📂 دسته‌بندی‌ها</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_from">📅 از تاریخ:</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="date_to">📅 تا تاریخ:</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">🔍 اعمال فیلترها</button>
                    @if(request()->hasAny(['user_id', 'action', 'model_type', 'date_from', 'date_to']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">🗑️ پاک کردن فیلترها</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>لیست فعالیت‌ها ({{ $logs->total() }} مورد)</h3>
        </div>
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>کاربر</th>
                                <th>عملیات</th>
                                <th>مدل</th>
                                <th>نام</th>
                                <th>آدرس IP</th>
                                <th>تاریخ</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <strong style="color: #2c3e50;">👤 {{ $log->user->name ?? 'حذف شده' }}</strong>
                                        @if($log->user)
                                            <br>
                                            <small style="color: #6c757d;">{{ $log->user->email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $actionClass = 'action-' . $log->action;
                                            $actionIcon = match($log->action) {
                                                'create' => '➕',
                                                'update' => '✏️',
                                                'delete' => '🗑️',
                                                'login' => '🔓',
                                                'logout' => '🔒',
                                                default => '📝'
                                            };
                                        @endphp
                                        <span class="table-badge {{ $actionClass }}">
                                            {{ $actionIcon }} {{ $log->action_display ?? ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color: #6c757d; font-size: 0.9rem;">{{ $log->model_display ?? class_basename($log->model_type) }}</span>
                                    </td>
                                    <td>
                                        <strong style="color: #495057;">{{ $log->model_name ?: 'نامشخص' }}</strong>
                                    </td>
                                    <td>
                                        <code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">{{ $log->ip_address }}</code>
                                    </td>
                                    <td>
                                        <span style="color: #6c757d; font-size: 0.9rem;">{{ persian_date($log->created_at) }}</span>
                                        <br><small style="color: #adb5bd;">{{ $log->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="table-btn table-btn-info">👁️ مشاهده</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    {{ $logs->appends(request()->query())->links('pagination.custom') }}
                    <div class="pagination-info">
                        نمایش {{ $logs->firstItem() }} تا {{ $logs->lastItem() }} از {{ $logs->total() }} فعالیت
                    </div>
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
                    ">📋</div>
                    <p style="
                        color: #6c757d;
                        font-size: 1.1rem;
                        margin-bottom: 1.5rem;
                        font-weight: 500;
                    ">هیچ فعالیتی با این فیلترها یافت نشد!</p>
                    <a href="{{ route('admin.activity-logs.index') }}" style="
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
                    ">
                        🔄 پاک کردن فیلترها
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
