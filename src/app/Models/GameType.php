<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    protected $fillable = [
        'title'
    ];

    /**
     * دریافت محصولات مرتبط با این نوع بازی
     * از آنجایی که game_type در products به صورت JSON ذخیره می‌شود،
     * از query builder استفاده می‌کنیم
     */
    public function products()
    {
        return \App\Models\Product::whereJsonContains('game_type', (string)$this->id)
                                  ->orWhereJsonContains('game_type', $this->id);
    }
}
