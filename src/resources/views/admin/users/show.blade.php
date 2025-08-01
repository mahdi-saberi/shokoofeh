@extends('layouts.dashboard')

@section('title', 'جزئیات کاربر')

@section('content')
    <div class="header">
        <h1>جزئیات کاربر</h1>
        <p>مشاهده اطلاعات کامل کاربر: {{ $user->name }}</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- اطلاعات کاربر -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3>اطلاعات کاربر</h3>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">ویرایش</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">بازگشت</a>
                </div>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>نام و نام خانوادگی:</strong><br>
                    <span style="font-size: 1.2rem;">{{ $user->name }}</span>
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>ایمیل:</strong><br>
                    <span style="font-size: 1.1rem;">{{ $user->email }}</span>
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>نقش:</strong><br>
                    <span class="badge" style="background-color:
                        @if($user->role === 'super_admin') #e74c3c
                        @else #3498db @endif; color: white; font-size: 1rem; padding: 0.5rem 1rem;">
                        {{ $user->role_display }}
                    </span>
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>وضعیت:</strong><br>
                    @if($user->is_active)
                        <span class="badge" style="background-color: #27ae60; color: white; font-size: 1rem; padding: 0.5rem 1rem;">فعال</span>
                    @else
                        <span class="badge" style="background-color: #e74c3c; color: white; font-size: 1rem; padding: 0.5rem 1rem;">غیرفعال</span>
                    @endif
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>تاریخ عضویت:</strong><br>
                    {{ persian_date($user->created_at, 'Y/m/d H:i') }}<br>
                    <small style="color: #666;">{{ persian_date_for_humans($user->created_at) }}</small>
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>آخرین بروزرسانی:</strong><br>
                    {{ persian_date($user->updated_at, 'Y/m/d H:i') }}<br>
                    <small style="color: #666;">{{ persian_date_for_humans($user->updated_at) }}</small>
                </div>
            </div>
        </div>

        <!-- آمار فعالیت -->
        <div class="card">
            <div class="card-header">
                <h3>آمار فعالیت</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <div style="text-align: center; padding: 1.5rem; background: #e3f2fd; border-radius: 8px;">
                        <div style="font-size: 2rem; font-weight: bold; color: #1976d2;">{{ $activities->count() }}</div>
                        <div style="color: #666;">فعالیت در لیست</div>
                    </div>
                    <div style="text-align: center; padding: 1.5rem; background: #f3e5f5; border-radius: 8px;">
                        <div style="font-size: 2rem; font-weight: bold; color: #7b1fa2;">{{ $user->activityLogs()->count() }}</div>
                        <div style="color: #666;">کل فعالیت‌ها</div>
                    </div>
                </div>

                @php
                    $actionCounts = $user->activityLogs()->selectRaw('action, COUNT(*) as count')->groupBy('action')->get();
                @endphp

                @if($actionCounts->count() > 0)
                    <h5 style="margin-bottom: 1rem;">توزیع فعالیت‌ها:</h5>
                    @foreach($actionCounts as $actionCount)
                        <div style="margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <span class="badge" style="background-color:
                                @if($actionCount->action === 'create') #27ae60
                                @elseif($actionCount->action === 'update') #f39c12
                                @elseif($actionCount->action === 'delete') #e74c3c
                                @elseif($actionCount->action === 'login') #3498db
                                @elseif($actionCount->action === 'logout') #95a5a6
                                @else #2c3e50 @endif; color: white;">
                                {{ match($actionCount->action) {
                                    'create' => 'ایجاد',
                                    'update' => 'ویرایش',
                                    'delete' => 'حذف',
                                    'login' => 'ورود',
                                    'logout' => 'خروج',
                                    default => $actionCount->action
                                } }}
                            </span>
                            <strong>{{ $actionCount->count }} مورد</strong>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- آخرین فعالیت‌ها -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>آخرین فعالیت‌ها ({{ $activities->count() }} مورد)</h3>
        </div>
        <div class="card-body">
            @if($activities->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>عملیات</th>
                            <th>مدل</th>
                            <th>نام</th>
                            <th>IP</th>
                            <th>تاریخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    <span class="badge" style="background-color:
                                        @if($activity->action === 'create') #27ae60
                                        @elseif($activity->action === 'update') #f39c12
                                        @elseif($activity->action === 'delete') #e74c3c
                                        @elseif($activity->action === 'login') #3498db
                                        @elseif($activity->action === 'logout') #95a5a6
                                        @else #2c3e50 @endif; color: white;">
                                        {{ $activity->action_display }}
                                    </span>
                                </td>
                                <td>{{ $activity->model_display }}</td>
                                <td>{{ $activity->model_name }}</td>
                                <td>
                                    <small>{{ $activity->ip_address }}</small>
                                </td>
                                <td>
                                    {{ persian_date($activity->created_at, 'm/d H:i') }}<br>
                                    <small style="color: #666;">{{ $activity->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="text-align: center; margin-top: 1rem;">
                    <a href="{{ route('admin.activity-logs.index', ['user_id' => $user->id]) }}" class="btn btn-info">مشاهده همه فعالیت‌های این کاربر</a>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <p>هیچ فعالیتی برای این کاربر ثبت نشده است.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
