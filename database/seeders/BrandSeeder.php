<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'title' => 'Mattel',
                'description' => 'شرکت معتبر آمریکایی تولید کننده اسباب بازی‌های با کیفیت',
                'website' => 'https://www.mattel.com',
                'status' => true,
            ],
            [
                'title' => 'Hasbro',
                'description' => 'یکی از بزرگترین تولید کنندگان اسباب بازی در جهان',
                'website' => 'https://www.hasbro.com',
                'status' => true,
            ],
            [
                'title' => 'LEGO',
                'description' => 'شرکت دانمارکی معروف در تولید آجرهای ساختمانی و اسباب بازی',
                'website' => 'https://www.lego.com',
                'status' => true,
            ],
            [
                'title' => 'Fisher-Price',
                'description' => 'تخصص در تولید اسباب بازی برای نوزادان و کودکان خردسال',
                'website' => 'https://www.fisher-price.com',
                'status' => true,
            ],
            [
                'title' => 'Hot Wheels',
                'description' => 'برند معروف در تولید ماشین‌های اسباب بازی',
                'website' => 'https://hotwheels.mattel.com',
                'status' => true,
            ],
            [
                'title' => 'Barbie',
                'description' => 'عروسک‌های معروف و محبوب در سراسر جهان',
                'website' => 'https://barbie.mattel.com',
                'status' => true,
            ],
            [
                'title' => 'Nintendo',
                'description' => 'شرکت ژاپنی در زمینه بازی‌های ویدیویی و کنسول',
                'website' => 'https://www.nintendo.com',
                'status' => true,
            ],
            [
                'title' => 'Sony',
                'description' => 'تولید کننده کنسول‌های بازی و محصولات الکترونیکی',
                'website' => 'https://www.playstation.com',
                'status' => true,
            ],
            [
                'title' => 'Microsoft',
                'description' => 'تولید کننده کنسول Xbox و محصولات گیمینگ',
                'website' => 'https://www.xbox.com',
                'status' => true,
            ],
            [
                'title' => 'Disney',
                'description' => 'برند معروف در زمینه کارتون‌ها و محصولات کودکان',
                'website' => 'https://www.disney.com',
                'status' => true,
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }
    }
}
