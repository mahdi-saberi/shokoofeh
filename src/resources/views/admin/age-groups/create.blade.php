@extends('layouts.dashboard')

@section('title', 'ایجاد گروه سنی جدید')

@section('content')
    <div class="header">
        <h1>ایجاد گروه سنی جدید</h1>
        <p>افزودن گروه سنی جدید به سیستم</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>اطلاعات گروه سنی</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.age-groups.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">عنوان گروه سنی:</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">ایجاد گروه سنی</button>
                        <a href="{{ route('admin.age-groups.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
