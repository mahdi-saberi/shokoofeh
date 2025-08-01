<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    protected $fillable = [
        'title',
        'type',
        'discount_type',
        'value',
        'product_id',
        'target_type',
        'target_value',
        'start_date',
        'end_date',
        'is_active',
        'minimum_amount',
        'maximum_discount',
        'description'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // روابط
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeProductDiscounts($query)
    {
        return $query->where('type', 'product');
    }

    public function scopeCampaignDiscounts($query)
    {
        return $query->where('type', 'campaign');
    }

    // Helper Methods
    public function isActive()
    {
        return $this->is_active &&
               Carbon::parse($this->start_date)->lte(now()) &&
               Carbon::parse($this->end_date)->gte(now());
    }

    public function getTypeDisplayAttribute()
    {
        return $this->type === 'product' ? 'تخفیف موردی' : 'کمپین تخفیف';
    }

    public function getDiscountTypeDisplayAttribute()
    {
        return $this->discount_type === 'percentage' ? 'درصدی' : 'مبلغ ثابت';
    }

    public function getTargetTypeDisplayAttribute()
    {
        switch($this->target_type) {
            case 'category':
                return 'دسته‌بندی';
            case 'age_group':
                return 'گروه سنی';
            case 'game_type':
                return 'نوع بازی';
            default:
                return 'نامشخص';
        }
    }

    public function getStatusDisplayAttribute()
    {
        if (!$this->is_active) {
            return 'غیرفعال';
        }

        $now = now();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($start->gt($now)) {
            return 'در انتظار شروع';
        } elseif ($end->lt($now)) {
            return 'منقضی شده';
        } else {
            return 'فعال';
        }
    }

    // محاسبه مبلغ تخفیف
    public function calculateDiscount($originalPrice, $quantity = 1)
    {
        if (!$this->isActive()) {
            return 0;
        }

        $totalAmount = $originalPrice * $quantity;

        // بررسی حداقل مبلغ خرید
        if ($this->minimum_amount && $totalAmount < $this->minimum_amount) {
            return 0;
        }

        $discountAmount = 0;

        if ($this->discount_type === 'percentage') {
            $discountAmount = ($totalAmount * $this->value) / 100;
        } else {
            $discountAmount = $this->value * $quantity;
        }

        // بررسی حداکثر تخفیف
        if ($this->maximum_discount && $discountAmount > $this->maximum_discount) {
            $discountAmount = $this->maximum_discount;
        }

        return min($discountAmount, $totalAmount);
    }

    // بررسی اینکه آیا تخفیف برای محصول خاصی قابل اعمال است
    public function isApplicableToProduct(Product $product)
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->type === 'product') {
            return $this->product_id == $product->id;
        }

        if ($this->type === 'campaign') {
            switch ($this->target_type) {
                case 'category':
                    return $product->category == $this->target_value;
                case 'age_group':
                    $productAgeGroups = is_array($product->age_group) ? $product->age_group : json_decode($product->age_group, true);
                    return in_array($this->target_value, $productAgeGroups ?? []);
                case 'game_type':
                    return $product->game_type == $this->target_value;
            }
        }

        return false;
    }

    // گرفتن تمام تخفیفات قابل اعمال برای یک محصول
    public static function getApplicableDiscounts(Product $product)
    {
        return static::active()
            ->where(function($query) use ($product) {
                $query->where(function($q) use ($product) {
                    // تخفیف موردی
                    $q->where('type', 'product')
                      ->where('product_id', $product->id);
                })->orWhere(function($q) use ($product) {
                    // کمپین تخفیف
                    $q->where('type', 'campaign')
                      ->where(function($subQuery) use ($product) {
                          $subQuery->where(function($categoryQuery) use ($product) {
                              $categoryQuery->where('target_type', 'category')
                                           ->where('target_value', $product->category);
                          })->orWhere(function($gameTypeQuery) use ($product) {
                              $gameTypeQuery->where('target_type', 'game_type')
                                           ->where('target_value', $product->game_type);
                          })->orWhere(function($ageGroupQuery) use ($product) {
                              $productAgeGroups = is_array($product->age_group) ? $product->age_group : json_decode($product->age_group, true);
                              if ($productAgeGroups) {
                                  $ageGroupQuery->where('target_type', 'age_group')
                                               ->whereIn('target_value', $productAgeGroups);
                              }
                          });
                      });
                });
            })
            ->orderBy('value', 'desc')
            ->get();
    }
}
