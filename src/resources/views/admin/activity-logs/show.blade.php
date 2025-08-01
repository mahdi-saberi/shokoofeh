@extends('layouts.dashboard')

@section('title', 'جزئیات فعالیت')

@push('styles')
<style>
    /* استایل‌های مدرن برای صفحه جزئیات فعالیت */
    .activity-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .activity-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .activity-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }

    .activity-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .activity-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .activity-actions {
        position: absolute;
        top: 2rem;
        right: 2rem;
        z-index: 2;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .detail-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #dee2e6;
        position: relative;
        overflow: hidden;
    }

    .detail-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .detail-card-header h4 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-card-body {
        padding: 2rem;
    }

    .detail-item {
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 12px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .detail-item strong {
        display: block;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #495057;
        line-height: 1.4;
    }

    .detail-value small {
        color: #6c757d;
        font-size: 0.9rem;
        display: block;
        margin-top: 0.25rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        color: white;
        margin-top: 0.5rem;
    }

    .badge-success { background: linear-gradient(135deg, #10b981, #059669); }
    .badge-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .badge-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .badge-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .badge-info { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    .badge-secondary { background: linear-gradient(135deg, #6b7280, #4b5563); }

    .changes-section {
        margin-top: 3rem;
    }

    .changes-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .changes-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    .change-section {
        padding: 2rem;
    }

    .change-section.old {
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
        border-right: 3px solid #ef4444;
    }

    .change-section.new {
        background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        border-right: 3px solid #10b981;
    }

    .change-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .change-title.old { color: #dc2626; }
    .change-title.new { color: #059669; }

    .change-content {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .change-content pre {
        margin: 0;
        white-space: pre-wrap;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #374151;
        font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
    }

    .info-message {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        border: 2px dashed #dee2e6;
        margin-top: 2rem;
    }

    .info-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .info-text {
        color: #6b7280;
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .activity-container {
            padding: 1rem;
        }

        .activity-header {
            padding: 1.5rem;
        }

        .activity-header h1 {
            font-size: 2rem;
        }

        .activity-header p {
            font-size: 1rem;
        }

        .activity-actions {
            position: static;
            text-align: center;
            margin-top: 1rem;
        }

        .details-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .detail-card-header,
        .detail-card-body {
            padding: 1.5rem;
        }

        .changes-grid {
            grid-template-columns: 1fr;
        }

        .change-section {
            padding: 1.5rem;
        }

        .change-section.old {
            border-right: none;
            border-bottom: 3px solid #ef4444;
        }

        .change-section.new {
            border-right: none;
            border-top: 3px solid #10b981;
        }
    }
</style>
@endpush

@section('content')
<div class="activity-container">
    <div class="activity-header">
        <div class="activity-actions">
            <a href="{{ route('admin.activity-logs.index') }}" class="btn-back">
                ← بازگشت به لیست
            </a>
        </div>
        <h1>🔍 جزئیات فعالیت</h1>
        <p>مشاهده کامل اطلاعات فعالیت انجام شده در سیستم</p>
    </div>

    <div class="details-grid">
        <!-- اطلاعات کلی -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h4>📋 اطلاعات کلی</h4>
            </div>
            <div class="detail-card-body">
                <div class="detail-item">
                    <strong>👤 کاربر:</strong>
                    <div class="detail-value">
                        @if($activityLog->user)
                            {{ $activityLog->user->name }}
                            <small>{{ $activityLog->user->email }}</small>
                            <span class="badge {{ $activityLog->user->role === 'super_admin' ? 'badge-danger' : 'badge-primary' }}">
                                {{ $activityLog->user->role_display }}
                            </span>
                        @else
                            <span style="color: #ef4444;">کاربر حذف شده</span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <strong>⚡ عملیات:</strong>
                    <div class="detail-value">
                        @php
                            $badgeClass = match($activityLog->action) {
                                'create' => 'badge-success',
                                'update' => 'badge-warning',
                                'delete' => 'badge-danger',
                                'login' => 'badge-info',
                                'logout' => 'badge-secondary',
                                default => 'badge-primary'
                            };
                            $icon = match($activityLog->action) {
                                'create' => '➕',
                                'update' => '✏️',
                                'delete' => '🗑️',
                                'login' => '🔓',
                                'logout' => '🔒',
                                default => '📝'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $icon }} {{ $activityLog->action_display }}
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <strong>📊 مدل:</strong>
                    <div class="detail-value">
                        {{ $activityLog->model_display }}
                        <small>{{ $activityLog->model_type }}</small>
                    </div>
                </div>

                <div class="detail-item">
                    <strong>📝 نام/عنوان:</strong>
                    <div class="detail-value">{{ $activityLog->model_name }}</div>
                </div>
            </div>
        </div>

        <!-- اطلاعات فنی -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h4>⚙️ اطلاعات فنی</h4>
            </div>
            <div class="detail-card-body">
                <div class="detail-item">
                    <strong>🌐 آدرس IP:</strong>
                    <div class="detail-value">
                        <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.9rem;">{{ $activityLog->ip_address }}</code>
                    </div>
                </div>

                <div class="detail-item">
                    <strong>🖥️ User Agent:</strong>
                    <div class="detail-value">
                        <small style="word-break: break-all; color: #6b7280;">{{ $activityLog->user_agent }}</small>
                    </div>
                </div>

                <div class="detail-item">
                    <strong>🕐 تاریخ و زمان:</strong>
                    <div class="detail-value">
                        {{ persian_date($activityLog->created_at, 'Y/m/d H:i:s') }}
                        <small>{{ persian_date_for_humans($activityLog->created_at) }}</small>
                    </div>
                </div>

                <div class="detail-item">
                    <strong>🆔 شناسه مدل:</strong>
                    <div class="detail-value">
                        <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.9rem;">#{{ $activityLog->model_id }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($activityLog->old_values || $activityLog->new_values)
        <div class="changes-section">
            <div class="changes-card">
                <div class="detail-card-header">
                    <h4>🔄 تغییرات انجام شده</h4>
                </div>
                <div class="changes-grid">
                    @if($activityLog->old_values)
                        <div class="change-section old">
                            <h5 class="change-title old">📤 مقادیر قبل از تغییر</h5>
                            <div class="change-content">
                                <pre>{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif

                    @if($activityLog->new_values)
                        <div class="change-section new">
                            <h5 class="change-title new">📥 مقادیر بعد از تغییر</h5>
                            <div class="change-content">
                                <pre>{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if(!$activityLog->old_values && !$activityLog->new_values && in_array($activityLog->action, ['login', 'logout', 'create', 'delete']))
        <div class="info-message">
            <div class="info-icon">
                @if($activityLog->action === 'login')
                    🔐
                @elseif($activityLog->action === 'logout')
                    🚪
                @elseif($activityLog->action === 'create')
                    ✅
                @elseif($activityLog->action === 'delete')
                    🗑️
                @endif
            </div>
            <div class="info-text">
                @if($activityLog->action === 'login')
                    کاربر وارد سیستم شد
                @elseif($activityLog->action === 'logout')
                    کاربر از سیستم خارج شد
                @elseif($activityLog->action === 'create')
                    آیتم جدید ایجاد شد
                @elseif($activityLog->action === 'delete')
                    آیتم حذف شد
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
