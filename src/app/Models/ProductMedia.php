<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductMedia extends Model
{
    protected $fillable = [
        'product_id',
        'file_path',
        'file_type',
        'mime_type',
        'original_name',
        'file_size',
        'is_main',
        'sort_order'
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'file_size' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * رابطه با محصول
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * دریافت URL فایل
     */
    public function getFileUrlAttribute()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            // در container از مسیر نسبی استفاده می‌کنیم
            return '/storage/' . $this->file_path;
        }
        return null;
    }

    /**
     * بررسی اینکه آیا فایل تصویر است
     */
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    /**
     * بررسی اینکه آیا فایل ویدیو است
     */
    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    /**
     * دریافت نوع MIME فایل
     */
    public function getMimeTypeAttribute($value)
    {
        return $value ?: $this->getMimeTypeFromFile();
    }

    /**
     * تشخیص نوع MIME از فایل
     */
    private function getMimeTypeFromFile()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            $fullPath = Storage::disk('public')->path($this->file_path);
            return mime_content_type($fullPath);
        }
        return 'application/octet-stream';
    }

    /**
     * حذف فایل از storage
     */
    public function deleteFile()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    /**
     * Scope برای تصاویر
     */
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    /**
     * Scope برای ویدیوها
     */
    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    /**
     * Scope برای تصویر اصلی
     */
    public function scopeMainImage($query)
    {
        return $query->where('is_main', true)->where('file_type', 'image');
    }

    /**
     * Scope برای مرتب‌سازی
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
