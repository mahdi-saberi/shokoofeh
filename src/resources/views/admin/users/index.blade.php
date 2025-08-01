@extends('layouts.dashboard')

@section('title', 'مدیریت کاربران')

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

    .table-badge.role-super { background: linear-gradient(135deg, #e74c3c, #c0392b); }
    .table-badge.role-admin { background: linear-gradient(135deg, #3498db, #2980b9); }
    .table-badge.status-active { background: linear-gradient(135deg, #27ae60, #229954); }
    .table-badge.status-inactive { background: linear-gradient(135deg, #e74c3c, #c0392b); }

    /* استایل دکمه‌های عملیات */
    .table-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
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
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .table-btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .table-btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .table-btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
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

    /* responsive */
    @media (max-width: 768px) {
        .modern-table {
            font-size: 12px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
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
</style>
@endpush

@section('content')
    <div class="header">
        <h1>مدیریت کاربران</h1>
        <p>مشاهده و مدیریت لیست کاربران سیستم</p>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>لیست کاربران</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">ایجاد کاربر جدید</a>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام کاربر</th>
                                <th>ایمیل</th>
                                <th>نقش</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <span style="background: linear-gradient(135deg, #6f42c1, #5a32a3); color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">
                                            #{{ $user->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: #2c3e50;">👤 {{ $user->name }}</strong>
                                    </td>
                                    <td>
                                        <span style="color: #6c757d; font-size: 0.9rem;">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="table-badge {{ $user->role === 'super_admin' ? 'role-super' : 'role-admin' }}">
                                            @if($user->role === 'super_admin') 👑 @else 🛡️ @endif
                                            {{ $user->role_display ?? ($user->role === 'super_admin' ? 'مدیر کل' : 'مدیر') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="table-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $user->is_active ? '✅ فعال' : '❌ غیرفعال' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color: #6c757d; font-size: 0.9rem;">{{ persian_date($user->created_at) }}</span>
                                        <br><small style="color: #adb5bd;">{{ $user->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="table-btn table-btn-info">👁️ نمایش</a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="table-btn table-btn-warning">✏️ ویرایش</a>

                                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="table-btn {{ $user->is_active ? 'table-btn-danger' : 'table-btn-success' }}">
                                                    {{ $user->is_active ? '🚫 غیرفعال' : '✅ فعال' }}
                                                </button>
                                            </form>

                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا از حذف این کاربر اطمینان دارید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="table-btn table-btn-danger">🗑️ حذف</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem; display: flex; justify-content: center;">
                    {{ $users->links() }}
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
                    ">👥</div>
                    <p style="
                        color: #6c757d;
                        font-size: 1.1rem;
                        margin-bottom: 1.5rem;
                        font-weight: 500;
                    ">هیچ کاربری یافت نشد!</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="
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
                        ➕ ایجاد اولین کاربر
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
