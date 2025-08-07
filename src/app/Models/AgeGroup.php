<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = [
        'title'
    ];

    /**
     * دریافت محصولات مرتبط با این گروه سنی
     * از آنجایی که age_group در products به صورت JSON ذخیره می‌شود،
     * از query builder استفاده می‌کنیم
     */
    public function products()
    {
        return \App\Models\Product::whereJsonContains('age_group', (string)$this->id)
                                  ->orWhereJsonContains('age_group', $this->id);
    }
}
