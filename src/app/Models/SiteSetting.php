<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'site_logo',
        'contact_phone',
        'contact_email',
        'contact_address',
        'working_hours',
        'social_instagram',
        'social_telegram',
        'social_whatsapp',
        'footer_text',
        'copyright_text',
        'meta_keywords',
        'meta_description',
        'header_announcement_enabled',
        'header_announcement_text',
        'header_announcement_bg_color',
        'header_announcement_text_color',
        'feature_box_1_title',
        'feature_box_1_description',
        'feature_box_1_icon',
        'feature_box_1_enabled',
        'feature_box_2_title',
        'feature_box_2_description',
        'feature_box_2_icon',
        'feature_box_2_enabled',
        'feature_box_3_title',
        'feature_box_3_description',
        'feature_box_3_icon',
        'feature_box_3_enabled',
        'feature_box_4_title',
        'feature_box_4_description',
        'feature_box_4_icon',
        'feature_box_4_enabled'
    ];

    /**
     * Get the site logo URL
     */
    public function getLogoUrlAttribute(): string
    {
        if (!$this->site_logo) {
            return asset('images/logo-placeholder.png');
        }

        if (str_starts_with($this->site_logo, 'http')) {
            return $this->site_logo;
        }

        return asset('storage/' . $this->site_logo);
    }

    /**
     * Get the current site settings (singleton pattern)
     */
    public static function current(): self
    {
        return Cache::remember('site_settings', 3600, function () {
            $settings = self::first();

            if (!$settings) {
                // Create default settings if none exist
                $settings = self::create([
                    'site_name' => 'فروشگاه شکوفه',
                    'site_description' => 'بهترین اسباب بازی‌ها برای کودکان عزیز',
                    'footer_text' => 'فروشگاه شکوفه، مرجع خرید اسباب بازی کودکان',
                    'copyright_text' => 'تمامی حقوق محفوظ است',
                    'working_hours' => 'شنبه تا پنجشنبه: ۹ صبح تا ۱۸ عصر',
                    'feature_box_1_title' => 'ارسال رایگان',
                    'feature_box_1_description' => 'برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور',
                    'feature_box_1_icon' => '🚚',
                    'feature_box_1_enabled' => true,
                    'feature_box_2_title' => 'خرید امن',
                    'feature_box_2_description' => 'پرداخت آنلاین با بالاترین سطح امنیت',
                    'feature_box_2_icon' => '🔒',
                    'feature_box_2_enabled' => true,
                    'feature_box_3_title' => 'ضمانت کیفیت',
                    'feature_box_3_description' => 'تمام محصولات دارای گارانتی اصالت و کیفیت',
                    'feature_box_3_icon' => '🏆',
                    'feature_box_3_enabled' => true,
                    'feature_box_4_title' => 'پشتیبانی ۲۴/۷',
                    'feature_box_4_description' => 'آماده پاسخگویی در تمام ساعات شبانه‌روز',
                    'feature_box_4_icon' => '📞',
                    'feature_box_4_enabled' => true
                ]);
            }

            return $settings;
        });
    }

    /**
     * Clear the cache when updating
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('site_settings');
        });

        static::deleted(function () {
            Cache::forget('site_settings');
        });
    }

    /**
     * Format phone number for display
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->contact_phone) {
            return '';
        }

        // Simple Persian phone formatting
        $phone = preg_replace('/[^0-9]/', '', $this->contact_phone);

        if (strlen($phone) === 11 && str_starts_with($phone, '09')) {
            return substr($phone, 0, 4) . '-' . substr($phone, 4, 3) . '-' . substr($phone, 7);
        }

        return $this->contact_phone;
    }

    /**
     * Get social media links as array
     */
    public function getSocialLinksAttribute(): array
    {
        $links = [];

        if ($this->social_instagram) {
            $links['instagram'] = [
                'url' => $this->social_instagram,
                'icon' => '📷',
                'name' => 'Instagram'
            ];
        }

        if ($this->social_telegram) {
            $links['telegram'] = [
                'url' => $this->social_telegram,
                'icon' => '📱',
                'name' => 'Telegram'
            ];
        }

        if ($this->social_whatsapp) {
            $links['whatsapp'] = [
                'url' => $this->social_whatsapp,
                'icon' => '💬',
                'name' => 'WhatsApp'
            ];
        }

        return $links;
    }

    /**
     * Get all feature boxes as array
     */
    public function getFeatureBoxesAttribute(): array
    {
        $boxes = [];

        if ($this->feature_box_1_enabled) {
            $boxes[] = [
                'title' => $this->feature_box_1_title ?: 'ارسال رایگان',
                'description' => $this->feature_box_1_description ?: 'برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور',
                'icon' => $this->feature_box_1_icon ?: '🚚'
            ];
        }

        if ($this->feature_box_2_enabled) {
            $boxes[] = [
                'title' => $this->feature_box_2_title ?: 'خرید امن',
                'description' => $this->feature_box_2_description ?: 'پرداخت آنلاین با بالاترین سطح امنیت',
                'icon' => $this->feature_box_2_icon ?: '🔒'
            ];
        }

        if ($this->feature_box_3_enabled) {
            $boxes[] = [
                'title' => $this->feature_box_3_title ?: 'ضمانت کیفیت',
                'description' => $this->feature_box_3_description ?: 'تمام محصولات دارای گارانتی اصالت و کیفیت',
                'icon' => $this->feature_box_3_icon ?: '🏆'
            ];
        }

        if ($this->feature_box_4_enabled) {
            $boxes[] = [
                'title' => $this->feature_box_4_title ?: 'پشتیبانی ۲۴/۷',
                'description' => $this->feature_box_4_description ?: 'آماده پاسخگویی در تمام ساعات شبانه‌روز',
                'icon' => $this->feature_box_4_icon ?: '📞'
            ];
        }

        return $boxes;
    }
}
