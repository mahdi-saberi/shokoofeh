@extends('layouts.dashboard')

@section('title', 'مشاهده تیکت')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🎫 مشاهده تیکت: {{ $ticket->ticket_number }}</h2>
        <div>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                ← بازگشت به لیست
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- اطلاعات تیکت -->
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">📋 اطلاعات تیکت</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>شماره تیکت:</strong> {{ $ticket->ticket_number }}</p>
                            <p><strong>موضوع:</strong> {{ $ticket->subject }}</p>
                            <p><strong>وضعیت:</strong>
                                <span class="badge bg-{{ $ticket->status_color }}">
                                    {{ $ticket->status_text }}
                                </span>
                            </p>
                            <p><strong>اولویت:</strong>
                                <span class="badge bg-{{ $ticket->priority_color }}">
                                    {{ $ticket->priority_text }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>دسته‌بندی:</strong>
                                <span class="badge bg-info">{{ $ticket->category_text }}</span>
                            </p>
                            <p><strong>تاریخ ایجاد:</strong> {{ persian_date($ticket->created_at) }}</p>
                            <p><strong>آخرین پاسخ:</strong>
                                @if($ticket->last_reply_at)
                                    {{ persian_date($ticket->last_reply_at) }}
                                @else
                                    <span class="text-muted">بدون پاسخ</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>توضیحات:</h6>
                        <div class="border rounded p-3 bg-light">
                            {{ nl2br(e($ticket->description)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- پاسخ‌ها -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💬 پاسخ‌ها</h5>
                </div>
                <div class="card-body">
                    @if($ticket->replies->count() > 0)
                        @foreach($ticket->replies as $reply)
                            <div class="border rounded p-3 mb-3 {{ $reply->is_admin_reply ? 'bg-light' : 'bg-white' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $reply->user->name }}</strong>
                                        <span class="badge {{ $reply->is_admin_reply ? 'bg-primary' : 'bg-secondary' }} ms-2">
                                            {{ $reply->is_admin_reply ? 'ادمین' : 'کاربر' }}
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ persian_date($reply->created_at) }} - {{ $reply->created_at->format('H:i') }}
                                    </small>
                                </div>
                                <div class="mt-2">
                                    {{ nl2br(e($reply->message)) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">هنوز پاسخی برای این تیکت ارسال نشده است.</p>
                    @endif

                    <!-- فرم پاسخ -->
                    @if($ticket->isOpen())
                        <div id="reply" class="mt-4">
                            <h6>💬 ارسال پاسخ</h6>
                            <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" rows="4"
                                              placeholder="پاسخ خود را بنویسید..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    📤 ارسال پاسخ
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            این تیکت بسته شده است و امکان ارسال پاسخ وجود ندارد.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- اطلاعات کاربر و عملیات -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">👤 اطلاعات کاربر</h5>
                </div>
                <div class="card-body">
                    <p><strong>نام:</strong> {{ $ticket->user->name }}</p>
                    <p><strong>ایمیل:</strong> {{ $ticket->user->email }}</p>
                    <p><strong>تاریخ عضویت:</strong> {{ persian_date($ticket->user->created_at) }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">⚙️ عملیات</h5>
                </div>
                <div class="card-body">
                    @if($ticket->isOpen())
                        <form action="{{ route('admin.tickets.update-status', $ticket) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="status" class="form-label">تغییر وضعیت</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>باز</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>در حال بررسی</option>
                                    <option value="answered" {{ $ticket->status == 'answered' ? 'selected' : '' }}>پاسخ داده شده</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>بسته شده</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                🔄 بروزرسانی وضعیت
                            </button>
                        </form>

                        <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('آیا از بستن این تیکت اطمینان دارید؟')">
                                🔒 بستن تیکت
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            این تیکت بسته شده است.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
