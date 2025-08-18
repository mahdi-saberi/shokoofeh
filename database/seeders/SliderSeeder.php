<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'فروش ویژه اسباب بازی‌های آموزشی',
                'description' => 'تا ۵۰٪ تخفیف روی محصولات آموزشی و کارتی',
                'image' => 'https://via.placeholder.com/1200x400/667eea/ffffff?text=فروش+ویژه+اسباب+بازی‌های+آموزشی',
                'button_text' => 'مشاهده محصولات',
                'button_url' => '#',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'جدیدترین محصولات لگو',
                'description' => 'کشف کنید جدیدترین ست‌های لگو برای کودکان',
                'image' => 'https://via.placeholder.com/1200x400/764ba2/ffffff?text=جدیدترین+محصولات+لگو',
                'button_text' => 'خرید لگو',
                'button_url' => '#',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'عروسک‌های محبوب کودکان',
                'description' => 'مجموعه‌ای از زیباترین عروسک‌ها برای کودکان',
                'image' => 'https://via.placeholder.com/1200x400/28a745/ffffff?text=عروسک‌های+محبوب+کودکان',
                'button_text' => 'مشاهده عروسک‌ها',
                'button_url' => '#',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'پازل‌های چالش برانگیز',
                'description' => 'پازل‌هایی برای تقویت قدرت تفکر و تمرکز کودکان',
                'image' => 'https://via.placeholder.com/1200x400/ffc107/000000?text=پازل‌های+چالش+برانگیز',
                'button_text' => 'انتخاب پازل',
                'button_url' => '#',
                'order' => 4,
                'is_active' => false,
            ],
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }

        echo "✅ Successfully created " . count($sliders) . " sample sliders!\n";
    }
}
