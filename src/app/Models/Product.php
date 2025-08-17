<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'image', 'age_group', 'game_type', 'category', 'gender', 'product_code', 'brand_id', 'price', 'description', 'stock'
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * رابطه با برند
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * رابطه با رسانه‌های محصول
     */
    public function media()
    {
        return $this->hasMany(ProductMedia::class)->ordered();
    }

    /**
     * رابطه با تصاویر محصول
     */
    public function images()
    {
        return $this->hasMany(ProductMedia::class)->images()->ordered();
    }

    /**
     * رابطه با ویدیوهای محصول
     */
    public function videos()
    {
        return $this->hasMany(ProductMedia::class)->videos()->ordered();
    }

    /**
     * تصویر اصلی محصول
     */
    public function mainImage()
    {
        return $this->hasOne(ProductMedia::class)->mainImage();
    }

    /**
     * دریافت برند مرتبط با محصول (برای backward compatibility)
     */
    public function brandObject()
    {
        return $this->brand;
    }

    /**
     * دریافت تمام برندهای موجود
     */
    public static function getAvailableBrands()
    {
        return \App\Models\Brand::where('status', true)->orderBy('title')->get();
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

    // Accessor for age_group - تبدیل ID به عنوان
    public function getAgeGroupAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $ageGroupTitles = [];
                foreach ($decoded as $ageGroupId) {
                    if (is_numeric($ageGroupId)) {
                        $ageGroup = \App\Models\AgeGroup::find($ageGroupId);
                        if ($ageGroup) {
                            $ageGroupTitles[] = $ageGroup->title;
                        }
                    } else {
                        $ageGroupTitles[] = $ageGroupId;
                    }
                }
                return $ageGroupTitles;
            }
            return [$value];
        }
        return is_array($value) ? $value : [$value];
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

    // Accessor for game_type - تبدیل ID به عنوان
    public function getGameTypeAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $gameTypeTitles = [];
                foreach ($decoded as $gameTypeId) {
                    if (is_numeric($gameTypeId)) {
                        $gameType = \App\Models\GameType::find($gameTypeId);
                        if ($gameType) {
                            $gameTypeTitles[] = $gameType->title;
                        }
                    } else {
                        $gameTypeTitles[] = $gameTypeId;
                    }
                }
                return $gameTypeTitles;
            }
            return [$value];
        }
        return is_array($value) ? $value : [$value];
    }

    // Mutator for game_type to ensure it's stored as JSON
    public function setGameTypeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['game_type'] = json_encode($value);
        } else {
            $this->attributes['game_type'] = $value;
        }
    }

    // Helper method to get category title (backward compatible)
    public function getCategoryTitleAttribute()
    {
        if (empty($this->category)) {
            return 'نامشخص';
        }

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
        if (empty($this->game_type)) {
            return 'نامشخص';
        }

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

    // Scope برای فیلتر برند
    public function scopeByBrand($query, $brand)
    {
        if (is_numeric($brand)) {
            return $query->where('brand_id', $brand);
        }
        return $query->whereHas('brand', function($q) use ($brand) {
            $q->where('title', 'like', "%{$brand}%");
        });
    }

    /**
     * دریافت Category مرتبط با محصول
     */
    public function getCategoryAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $categoryTitles = [];
                foreach ($decoded as $categoryId) {
                    if (is_numeric($categoryId)) {
                        $category = \App\Models\Category::find($categoryId);
                        if ($category) {
                            $categoryTitles[] = $category->title;
                        }
                    } else {
                        $categoryTitles[] = $categoryId;
                    }
                }
                return $categoryTitles;
            }
            return [$value];
        }
        return is_array($value) ? $value : [$value];
    }

    // Mutator for category to ensure it's stored as JSON
    public function setCategoryAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['category'] = json_encode($value);
        } else {
            $this->attributes['category'] = $value;
        }
    }

    /**
     * دریافت AgeGroup مرتبط با محصول
     */
    public function getAgeGroupObjectAttribute()
    {
        $ageGroups = $this->age_group;
        if (is_array($ageGroups) && count($ageGroups) > 0 && is_numeric($ageGroups[0])) {
            return AgeGroup::find($ageGroups[0]);
        }
        return null;
    }

    /**
     * دریافت GameType مرتبط با محصول
     */
    public function getGameTypeObjectAttribute()
    {
        $gameTypes = json_decode($this->attributes['game_type'] ?? '[]', true);
        if (is_array($gameTypes) && count($gameTypes) > 0 && is_numeric($gameTypes[0])) {
            return GameType::find($gameTypes[0]);
        }
        return null;
    }

    /**
     * Accessor برای URL تصویر
     */
    public function getImageUrlAttribute()
    {
        // ابتدا تصویر اصلی را از جدول media بررسی می‌کنیم
        $mainImage = $this->mainImage;
        if ($mainImage && $mainImage->file_url) {
            return $mainImage->file_url;
        }

        // اگر تصویر اصلی وجود نداشت، اولین تصویر را بررسی می‌کنیم
        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->file_url) {
            return $firstImage->file_url;
        }

        // اگر هیچ تصویری وجود نداشت، تصویر قدیمی را بررسی می‌کنیم
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // تصویر پیش‌فرض برای اسباب بازی
        return 'https://via.placeholder.com/300x200/FFE66D/333333?text=' . urlencode('🧸 ' . ($this->title ?? 'محصول'));
    }
}
