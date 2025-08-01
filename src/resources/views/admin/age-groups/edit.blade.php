@extends('layouts.dashboard')

@section('title', 'ویرایش گروه سنی')

@section('content')
    <div class="header">
        <h1>ویرایش گروه سنی</h1>
        <p>ویرایش اطلاعات گروه سنی: {{ $ageGroup->title }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>ویرایش اطلاعات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.age-groups.update', $ageGroup->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">عنوان گروه سنی:</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $ageGroup->title) }}" class="form-control" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">بروزرسانی گروه سنی</button>
                        <a href="{{ route('admin.age-groups.index') }}" class="btn btn-secondary">انصراف</a>
                        <a href="{{ route('admin.age-groups.show', $ageGroup->id) }}" class="btn btn-info">نمایش</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
