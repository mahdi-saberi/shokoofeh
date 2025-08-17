<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'title',
        'description',
        'logo',
        'website',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * دریافت محصولات مرتبط با این برند
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * دریافت محصولات فعال مرتبط با این برند
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('stock', '>', 0);
    }

    /**
     * دریافت تعداد محصولات فعال
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->count();
    }

    /**
     * دریافت وضعیت برند
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? 'فعال' : 'غیرفعال';
    }

    /**
     * دریافت رنگ وضعیت
     */
    public function getStatusColorAttribute()
    {
        return $this->status ? 'success' : 'danger';
    }
}
