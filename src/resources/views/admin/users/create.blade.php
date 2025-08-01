@extends('layouts.dashboard')

@section('title', 'ایجاد کاربر جدید')

@section('content')
    <div class="header">
        <h1>ایجاد کاربر جدید</h1>
        <p>افزودن کاربر جدید به سیستم</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>اطلاعات کاربر جدید</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                        <div class="form-group">
                            <label for="name">نام و نام خانوادگی:</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">ایمیل:</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="role">نقش:</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">انتخاب کنید</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>مدیر</option>
                                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>مدیر کل</option>
                            </select>
                            @error('role')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">رمز عبور:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">تکرار رمز عبور:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">ایجاد کاربر</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
