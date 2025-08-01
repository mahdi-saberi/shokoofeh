<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'image', 'age_group', 'game_type', 'category', 'gender', 'product_code', 'price', 'description', 'stock'
    ];

    protected $casts = [
        'age_group' => 'array',
        'game_type' => 'array',
        'category' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    // روابط
    public function discounts()
    {
        return $this->hasMany(Discount::class)->where('type', 'product');
    }

    // Scopes
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    // Accessor for age_group to ensure it's always an array
    public function getAgeGroupAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    // Mutator for age_group to ensure it's stored as JSON
    public function setAgeGroupAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['age_group'] = json_encode($value);
        } else {
            $this->attributes['age_group'] = $value;
        }
    }

    // Helper method to get category title (backward compatible)
    public function getCategoryTitleAttribute()
    {
        if (is_array($this->category)) {
            return implode(', ', $this->category);
        }

        // Try to get from Category model first
        if (is_numeric($this->category)) {
            $category = \App\Models\Category::find($this->category);
            return $category ? $category->title : $this->category;
        }
        return $this->category;
    }

    // Helper method to get game type title (backward compatible)
    public function getGameTypeTitleAttribute()
    {
        if (is_array($this->game_type)) {
            return implode(', ', $this->game_type);
        }

        // Try to get from GameType model first
        if (is_numeric($this->game_type)) {
            $gameType = \App\Models\GameType::find($this->game_type);
            return $gameType ? $gameType->title : $this->game_type;
        }
        return $this->game_type;
    }

    // Helper method to get age group titles (backward compatible)
    public function getAgeGroupTitlesAttribute()
    {
        $ageGroups = $this->age_group;

        if (!is_array($ageGroups)) {
            return [];
        }

        return $ageGroups;
    }

    // متدهای مربوط به موجودی
    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'ناموجود';
        } elseif ($this->stock <= 5) {
            return 'کمیاب';
        } else {
            return 'موجود';
        }
    }

    public function getStockStatusColorAttribute()
    {
        if ($this->stock <= 0) {
            return 'red';
        } elseif ($this->stock <= 5) {
            return 'orange';
        } else {
            return 'green';
        }
    }

    // متدهای مربوط به تخفیف
    public function getActiveDiscounts()
    {
        return \App\Models\Discount::getApplicableDiscounts($this);
    }

    public function getBestDiscount()
    {
        $discounts = $this->getActiveDiscounts();

        if ($discounts->isEmpty()) {
            return null;
        }

        // پیدا کردن بهترین تخفیف (بیشترین مقدار تخفیف)
        $bestDiscount = null;
        $maxDiscountAmount = 0;

        foreach ($discounts as $discount) {
            $discountAmount = $discount->calculateDiscount($this->price);
            if ($discountAmount > $maxDiscountAmount) {
                $maxDiscountAmount = $discountAmount;
                $bestDiscount = $discount;
            }
        }

        return $bestDiscount;
    }

    public function getDiscountedPriceAttribute()
    {
        $bestDiscount = $this->getBestDiscount();

        if (!$bestDiscount) {
            return $this->price;
        }

        $discountAmount = $bestDiscount->calculateDiscount($this->price);
        return $this->price - $discountAmount;
    }

    public function getDiscountAmountAttribute()
    {
        $bestDiscount = $this->getBestDiscount();

        if (!$bestDiscount) {
            return 0;
        }

        return $bestDiscount->calculateDiscount($this->price);
    }

    public function hasDiscount()
    {
        return $this->getBestDiscount() !== null;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount() || $this->price <= 0) {
            return 0;
        }

        return round(($this->discount_amount / $this->price) * 100);
    }

    // کاهش موجودی
    public function reduceStock($quantity = 1)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    // افزایش موجودی
    public function increaseStock($quantity = 1)
    {
        $this->increment('stock', $quantity);
        return true;
    }

    // تولید کد محصول منحصر به فرد
    public static function generateProductCode()
    {
        do {
            $code = 'PRD-' . strtoupper(substr(uniqid(), -8));
        } while (self::where('product_code', $code)->exists());

        return $code;
    }

    // دریافت آیکون جنسیت
    public function getGenderIconAttribute()
    {
        return match($this->gender) {
            'دختر' => '👧',
            'پسر' => '👦',
            'هردو' => '👫',
            default => '👶'
        };
    }

    // دریافت رنگ جنسیت
    public function getGenderColorAttribute()
    {
        return match($this->gender) {
            'دختر' => 'linear-gradient(135deg, #e91e63, #c2185b)',
            'پسر' => 'linear-gradient(135deg, #2196f3, #1976d2)',
            'هردو' => 'linear-gradient(135deg, #9c27b0, #7b1fa2)',
            default => 'linear-gradient(135deg, #607d8b, #455a64)'
        };
    }

    // Scope برای فیلتر جنسیت
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }
}
