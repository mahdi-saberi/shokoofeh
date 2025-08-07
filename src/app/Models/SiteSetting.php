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
        'header_announcement_text_color'
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
                    'working_hours' => 'شنبه تا پنجشنبه: ۹ صبح تا ۱۸ عصر'
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
}
