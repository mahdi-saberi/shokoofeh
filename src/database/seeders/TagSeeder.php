<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'پرفروش',
                'slug' => 'best-seller',
                'color' => '#FF6B35',
                'description' => 'محصولات پرفروش و محبوب'
            ],
            [
                'name' => 'جدید',
                'slug' => 'new',
                'color' => '#2ED573',
                'description' => 'محصولات جدید و تازه'
            ],
            [
                'name' => 'تخفیف ویژه',
                'slug' => 'special-offer',
                'color' => '#FF4757',
                'description' => 'محصولات با تخفیف ویژه'
            ],
            [
                'name' => 'آموزشی',
                'slug' => 'educational',
                'color' => '#4ECDC4',
                'description' => 'اسباب بازی‌های آموزشی'
            ],
            [
                'name' => 'خلاقیت',
                'slug' => 'creative',
                'color' => '#A55EEA',
                'description' => 'اسباب بازی‌های خلاقانه'
            ],
            [
                'name' => 'هوشمند',
                'slug' => 'smart',
                'color' => '#26DE81',
                'description' => 'اسباب بازی‌های هوشمند'
            ],
            [
                'name' => 'موسیقی',
                'slug' => 'music',
                'color' => '#FD79A8',
                'description' => 'اسباب بازی‌های موسیقی'
            ],
            [
                'name' => 'ورزشی',
                'slug' => 'sports',
                'color' => '#FDCB6E',
                'description' => 'اسباب بازی‌های ورزشی'
            ],
            [
                'name' => 'ساختمانی',
                'slug' => 'construction',
                'color' => '#6C5CE7',
                'description' => 'اسباب بازی‌های ساختمانی'
            ],
            [
                'name' => 'ماشین',
                'slug' => 'cars',
                'color' => '#00B894',
                'description' => 'اسباب بازی‌های ماشین'
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
