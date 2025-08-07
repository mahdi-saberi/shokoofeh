<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title'
    ];

    /**
     * دریافت محصولات مرتبط با این دسته‌بندی
     * از آنجایی که category در products به صورت JSON ذخیره می‌شود،
     * از query builder استفاده می‌کنیم
     */
    public function products()
    {
        return \App\Models\Product::whereJsonContains('category', (string)$this->id)
                                  ->orWhereJsonContains('category', $this->id);
    }
}
