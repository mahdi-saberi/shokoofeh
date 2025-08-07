<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'subject',
        'description',
        'priority',
        'status',
        'category',
        'last_reply_at',
        'closed_at'
    ];

    protected $casts = [
        'last_reply_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    // روابط
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at', 'asc');
    }

    public function latestReply(): BelongsTo
    {
        return $this->belongsTo(TicketReply::class)->latest();
    }

    // Accessors
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'open' => 'باز',
            'in_progress' => 'در حال بررسی',
            'answered' => 'پاسخ داده شده',
            'closed' => 'بسته شده',
            default => 'نامشخص'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'warning',
            'in_progress' => 'info',
            'answered' => 'success',
            'closed' => 'secondary',
            default => 'light'
        };
    }

    public function getPriorityTextAttribute(): string
    {
        return match($this->priority) {
            'low' => 'کم',
            'medium' => 'متوسط',
            'high' => 'زیاد',
            'urgent' => 'فوری',
            default => 'متوسط'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'info'
        };
    }

    public function getCategoryTextAttribute(): string
    {
        return match($this->category) {
            'general' => 'عمومی',
            'technical' => 'فنی',
            'order' => 'سفارش',
            'payment' => 'پرداخت',
            'other' => 'سایر',
            default => 'عمومی'
        };
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', '!=', 'closed');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // متدهای کمکی
    public function isOpen(): bool
    {
        return $this->status !== 'closed';
    }

    public function hasUnreadReplies(): bool
    {
        return $this->replies()
            ->where('is_admin_reply', true)
            ->where('created_at', '>', $this->last_reply_at ?? $this->created_at)
            ->exists();
    }

    public function markAsAnswered(): void
    {
        $this->update([
            'status' => 'answered',
            'last_reply_at' => now()
        ]);
    }

    public function close(): void
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now()
        ]);
    }

    // تولید شماره تیکت منحصر به فرد
    public static function generateTicketNumber(): string
    {
        do {
            $number = 'TKT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('ticket_number', $number)->exists());

        return $number;
    }
}
