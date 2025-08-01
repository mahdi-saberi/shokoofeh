@extends('layouts.dashboard')

@section('title', 'ویرایش کاربر')

@section('content')
    <div class="header">
        <h1>ویرایش کاربر</h1>
        <p>ویرایش اطلاعات کاربر: {{ $user->name }}</p>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- ویرایش اطلاعات -->
        <div class="card">
            <div class="card-header">
                <h3>اطلاعات کاربر</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">نام و نام خانوادگی:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">نقش:</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>مدیر</option>
                            <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>مدیر کل</option>
                        </select>
                        @error('role')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_active">وضعیت:</label>
                        <select id="is_active" name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                        <div class="actions">
                            <button type="submit" class="btn btn-success">بروزرسانی اطلاعات</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- تغییر رمز عبور -->
        <div class="card">
            <div class="card-header">
                <h3>تغییر رمز عبور</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.password.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="password">رمز عبور جدید:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">تکرار رمز عبور:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                        <button type="submit" class="btn btn-warning">تغییر رمز عبور</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- اطلاعات اضافی -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>اطلاعات کاربر</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>تاریخ عضویت:</strong><br>
                    {{ persian_date($user->created_at, 'Y/m/d H:i') }}
                </div>
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>آخرین بروزرسانی:</strong><br>
                    {{ $user->updated_at->format('Y/m/d H:i') }}
                </div>
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>تعداد فعالیت‌ها:</strong><br>
                    {{ $user->activityLogs()->count() }} مورد
                </div>
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <strong>آخرین فعالیت:</strong><br>
                    @if($user->activityLogs()->latest()->first())
                        {{ $user->activityLogs()->latest()->first()->created_at->diffForHumans() }}
                    @else
                        هیچ فعالیتی ثبت نشده
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
