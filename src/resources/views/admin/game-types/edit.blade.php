@extends('layouts.dashboard')

@section('title', 'ویرایش نوع بازی')

@section('content')
    <div class="header">
        <h1>ویرایش نوع بازی</h1>
        <p>ویرایش اطلاعات نوع بازی: {{ $gameType->title }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>ویرایش اطلاعات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.game-types.update', $gameType->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">عنوان نوع بازی:</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $gameType->title) }}" class="form-control" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div class="actions">
                        <button type="submit" class="btn btn-success">بروزرسانی نوع بازی</button>
                        <a href="{{ route('admin.game-types.index') }}" class="btn btn-secondary">انصراف</a>
                        <a href="{{ route('admin.game-types.show', $gameType->id) }}" class="btn btn-info">نمایش</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
