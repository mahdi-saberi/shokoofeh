@extends('layouts.dashboard')

@section('title', 'ویرایش پروفایل')

@push('styles')
<style>
    /* استایل‌های مدرن برای صفحه پروفایل */
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .profile-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .profile-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .profile-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #dee2e6;
        position: relative;
        overflow: hidden;
    }

    .profile-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .profile-card-header h3 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .profile-card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-control[readonly] {
        background: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .error-message::before {
        content: '⚠️';
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #0891b2, #0e7490);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(6, 182, 212, 0.4);
    }

    .form-actions {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
        text-align: center;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* استایل activity section */
    .activity-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
        margin-top: 2rem;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .activity-table th,
    .activity-table td {
        padding: 1rem;
        text-align: right;
        border-bottom: 1px solid #e5e7eb;
    }

    .activity-table th {
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .activity-table tbody tr {
        transition: all 0.3s ease;
    }

    .activity-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    .activity-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
    }

    .activity-badge.create { background: linear-gradient(135deg, #10b981, #059669); }
    .activity-badge.update { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .activity-badge.delete { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .activity-badge.default { background: linear-gradient(135deg, #6366f1, #4f46e5); }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem;
        }

        .profile-header h1 {
            font-size: 2rem;
        }

        .profile-header p {
            font-size: 1rem;
        }

        .profile-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .profile-card-header,
        .profile-card-body {
            padding: 1.5rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .activity-table {
            font-size: 0.875rem;
        }

        .activity-table th,
        .activity-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>👤 ویرایش پروفایل</h1>
        <p>مدیریت اطلاعات حساب کاربری و تغییر رمز عبور</p>
    </div>

    @if(session('success'))
        <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 2px solid #34d399; color: #065f46; padding: 1rem 2rem; border-radius: 12px; margin-bottom: 2rem; text-align: center; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: linear-gradient(135deg, #fef2f2, #fecaca); border: 2px solid #f87171; color: #991b1b; padding: 1rem 2rem; border-radius: 12px; margin-bottom: 2rem; text-align: center; font-weight: 600;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="profile-grid">
        <!-- Profile Information Card -->
        <div class="profile-card">
            <div class="profile-card-header">
                <h3>📝 اطلاعات پروفایل</h3>
            </div>
            <div class="profile-card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">👤 نام و نام خانوادگی:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">📧 ایمیل:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">📱 شماره تماس:</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="09123456789">
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">🏠 آدرس کامل:</label>
                        <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3" placeholder="آدرس کامل پستی...">{{ old('shipping_address', $user->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="postal_code">📮 کد پستی:</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-control" placeholder="1234567890">
                            @error('postal_code')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="city">🏙️ شهر:</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" class="form-control" placeholder="تهران">
                            @error('city')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="province">🗺️ استان:</label>
                        <input type="text" id="province" name="province" value="{{ old('province', $user->province) }}" class="form-control" placeholder="تهران">
                        @error('province')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(auth()->user()->role === 'super_admin')
                        <div class="form-group">
                            <label for="role">🎭 نقش:</label>
                            <select id="role" name="role" class="form-control">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👨‍💼 مدیر</option>
                                <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>👨‍💻 مدیر کل</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_active">⚡ وضعیت:</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>✅ فعال</option>
                                <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>❌ غیرفعال</option>
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label>🎭 نقش:</label>
                            <input type="text" value="{{ $user->role_display }}" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>⚡ وضعیت:</label>
                            <input type="text" value="{{ $user->is_active ? 'فعال' : 'غیرفعال' }}" class="form-control" readonly>
                        </div>
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">💾 بروزرسانی اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="profile-card">
            <div class="profile-card-header">
                <h3>🔐 تغییر رمز عبور</h3>
            </div>
            <div class="profile-card-body">
                <form action="{{ route('admin.profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password">🔑 رمز عبور فعلی:</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">🆕 رمز عبور جدید:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">🔄 تکرار رمز عبور جدید:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">🔐 تغییر رمز عبور</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User Activity Section -->
    @if(auth()->user()->role === 'super_admin')
    <div class="activity-card">
        <div class="profile-card-header">
            <h3>📊 آخرین فعالیت‌های شما</h3>
        </div>
        <div class="profile-card-body">
            @php
                $activities = auth()->user()->activityLogs()->latest()->take(10)->get();
            @endphp

            @if($activities->count() > 0)
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>عملیات</th>
                            <th>مدل</th>
                            <th>نام</th>
                            <th>تاریخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    @php
                                        $badgeClass = match($activity->action) {
                                            'create' => 'create',
                                            'update' => 'update',
                                            'delete' => 'delete',
                                            default => 'default'
                                        };
                                        $icon = match($activity->action) {
                                            'create' => '➕',
                                            'update' => '✏️',
                                            'delete' => '🗑️',
                                            default => '📝'
                                        };
                                    @endphp
                                    <span class="activity-badge {{ $badgeClass }}">
                                        {{ $icon }} {{ $activity->action_display }}
                                    </span>
                                </td>
                                <td>{{ $activity->model_display }}</td>
                                <td>{{ $activity->model_name }}</td>
                                <td>
                                    <span style="color: #6b7280;">{{ persian_date($activity->created_at) }}</span>
                                    <br>
                                    <small style="color: #9ca3af;">{{ $activity->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="form-actions">
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-info">📋 مشاهده همه فعالیت‌ها</a>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <p>هنوز فعالیتی انجام نداده‌اید.</p>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
