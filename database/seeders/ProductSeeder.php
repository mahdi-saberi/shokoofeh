<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\GameType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all available options with IDs
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $gameTypes = GameType::all();

        // Create a map of category names to IDs
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category->title] = $category->id;
        }

        // Enhanced product templates matching Categories table
        $productTemplates = [
            'لگو' => [
                'لگو کلاسیک آبی', 'لگو فضایی', 'لگو قلعه', 'لگو ماشین', 'لگو هواپیما',
                'بلوک‌های چوبی رنگی', 'لگو دوپلو', 'بلوک‌های نرم', 'ست ساخت قطار',
                'لگو شهر', 'لگو دوستان', 'لگو نینجاگو', 'لگو تکنیک'
            ],
            'عروسک' => [
                'عروسک باربی', 'عروسک پرنسس', 'عروسک خرس', 'عروسک سوپرمن', 'عروسک اسپایدرمن',
                'فیگور دایناسور', 'عروسک توتو', 'عروسک موی بلند', 'فیگور حیوانات', 'عروسک نوزاد',
                'عروسک پارچه‌ای', 'فیگور اکشن', 'عروسک سخنگو', 'مجموعه عروسک خانواده'
            ],
            'ماشین' => [
                'ماشین کنترلی', 'ماشین پلیس', 'ماشین آتش‌نشانی', 'کامیون باربری', 'هواپیما اسباب بازی',
                'قطار برقی', 'موتور سیکلت', 'دوچرخه کودکانه', 'کشتی اسباب بازی', 'ماشین مسابقه',
                'هلیکوپتر', 'تراکتور کشاورزی', 'اتوبوس مدرسه'
            ],
            'پازل' => [
                'پازل ۱۰۰ تکه', 'پازل ۵۰۰ تکه', 'مکعب روبیک', 'سودوکو کودکانه', 'بازی حافظه',
                'پازل سه بعدی', 'بازی چینش اشکال', 'پازل کلمات', 'بازی منطق', 'پازل تصویری',
                'بازی استراتژی', 'پازل چوبی', 'بازی ریاضی'
            ],
            'بازی رومیزی' => [
                'شطرنج', 'منچ', 'تخته نرد', 'دومینو', 'اسکرابل فارسی',
                'مونوپولی', 'بازی اونو', 'بازی خانواده', 'بازی ۲۹', 'بازی پاسور', 'بازی راز', 'بازی کلمه‌سازی'
            ],
            'کارت' => [
                'کارت‌های بازی', 'کارت پوکمون', 'کارت یوگی یو', 'کارت حیوانات', 'کارت آموزشی',
                'کارت حروف الفبا', 'کارت اعداد', 'کارت رنگ‌ها', 'کارت فلش', 'کارت حافظه'
            ],
            'اسباب بازی هنری' => [
                'مداد رنگی', 'آبرنگ', 'خمیر بازی', 'ست نقاشی', 'صفحه نقاشی', 'مارکر رنگی',
                'ست کاردستی', 'کاغذ اوریگامی', 'ست چاپ دست', 'طراحی روی پارچه',
                'سفالگری کودکانه', 'نقاشی روی شیشه', 'ست طراحی مد'
            ],
            'اسباب بازی موسیقی' => [
                'پیانو کودکانه', 'گیتار اسباب بازی', 'درام کودکانه', 'ساز دهنی', 'زنگوله موزیکال',
                'ارگ الکترونیکی', 'سنتور کودکانه', 'فلوت کودکانه', 'باند موزیکال', 'مایک کودکانه',
                'راه راه کودکانه', 'ست آهنگسازی', 'جعبه موزیک'
            ],
            'اسباب بازی ورزشی' => [
                'توپ فوتبال', 'توپ بسکتبال', 'راکت تنیس', 'دوچرخه کودکانه', 'اسکیت برد',
                'تیر و کمان کودکانه', 'میز پینگ پنگ', 'گلف کودکانه', 'توپ والیبال', 'طناب ورزشی',
                'هولاهوپ', 'وزنه کودکانه', 'ست یوگا کودکانه'
            ]
        ];

        // Generate exactly 100 products
        $productCount = 0;
        $totalProducts = 100;

        // Sample descriptions
        $descriptions = [
            'یک اسباب بازی فوق‌العاده برای تقویت خلاقیت و تخیل کودکان',
            'محصولی باکیفیت و ایمن که به رشد ذهنی کودک کمک می‌کند',
            'بازی سرگرم‌کننده و آموزنده برای ساعات طولانی لذت',
            'ساخته شده با بهترین مواد و استانداردهای ایمنی جهانی',
            'ابزار مناسب برای توسعه مهارت‌های حرکتی و فکری کودک',
            'یکی از محبوب‌ترین اسباب بازی‌های کودکان در سراسر جهان',
            'طراحی زیبا و کارکرد عالی در یک محصول بی‌نظیر',
            'مناسب برای بازی انفرادی و گروهی کودکان',
            'تحریک کنونده حواس و تقویت کننده قدرت تمرکز',
            'اسباب بازی مقاوم و بادوام برای سال‌ها استفاده'
        ];

        // Placeholder images using placehold.co with vibrant random colors
        $placeholderImages = [
            // Small product images (400x400) - Vibrant colors
            'https://placehold.co/400x400/FF6B6B/FFFFFF?text=Product',
            'https://placehold.co/400x400/4ECDC4/FFFFFF?text=Lego',
            'https://placehold.co/400x400/45B7D1/FFFFFF?text=Doll',
            'https://placehold.co/400x400/96CEB4/FFFFFF?text=Car',
            'https://placehold.co/400x400/FFEAA7/31343C?text=Puzzle',
            'https://placehold.co/400x400/DDA0DD/FFFFFF?text=Board+Game',
            'https://placehold.co/400x400/98D8C8/FFFFFF?text=Card',
            'https://placehold.co/400x400/F7DC6F/31343C?text=Art',
            'https://placehold.co/400x400/BB8FCE/FFFFFF?text=Music',
            'https://placehold.co/400x400/85C1E9/FFFFFF?text=Sport',
            
            // Additional vibrant colors
            'https://placehold.co/400x400/FF9F43/FFFFFF?text=Toy',
            'https://placehold.co/400x400/00B894/FFFFFF?text=Game',
            'https://placehold.co/400x400/74B9FF/FFFFFF?text=Fun',
            'https://placehold.co/400x400/FDCB6E/31343C?text=Play',
            'https://placehold.co/400x400/E17055/FFFFFF?text=Learn',
            'https://placehold.co/400x400/6C5CE7/FFFFFF?text=Create',
            'https://placehold.co/400x400/A29BFE/FFFFFF?text=Explore',
            'https://placehold.co/400x400/00CEC9/FFFFFF?text=Discover',
            'https://placehold.co/400x400/FF7675/FFFFFF?text=Imagine',
            'https://placehold.co/400x400/55A3FF/FFFFFF?text=Grow'
        ];

        foreach ($productTemplates as $categoryName => $products) {
            foreach ($products as $productName) {
                if ($productCount >= $totalProducts) break 2;

                // Use ID instead of name for category
                $selectedCategoryId = $categoryMap[$categoryName] ?? $categories->first()->id;
                $selectedCategory = [$selectedCategoryId];

                // Use random IDs for age group and game type
                $selectedAgeGroupId = $ageGroups->random()->id;
                $selectedAgeGroup = [$selectedAgeGroupId];

                $selectedGameTypeId = $gameTypes->random()->id;
                $selectedGameType = [$selectedGameTypeId];

                // Generate random price between 50,000 to 1,000,000 tomans
                $price = rand(50, 1000) * 1000;

                // Generate random stock between 0 to 50
                $stock = rand(0, 50);

                // Select random gender
                $genders = ['دختر', 'پسر', 'هردو'];
                $selectedGender = $genders[array_rand($genders)];

                Product::create([
                    'title' => $productName,
                    'price' => $price,
                    'description' => $descriptions[array_rand($descriptions)],
                    'age_group' => $selectedAgeGroup,
                    'game_type' => $selectedGameType,
                    'category' => $selectedCategory,
                    'gender' => $selectedGender,
                    'image' => $placeholderImages[array_rand($placeholderImages)],
                    'stock' => $stock,
                ]);

                $productCount++;
            }
        }

        // If we still need more products to reach 100, generate random ones
        while ($productCount < $totalProducts) {
            $randomCategoryName = array_rand($productTemplates);
            $randomProducts = $productTemplates[$randomCategoryName];
            $randomProductName = $randomProducts[array_rand($randomProducts)] . ' ' . $productCount;

            // Use ID instead of name for category
            $selectedCategoryId = $categoryMap[$randomCategoryName] ?? $categories->first()->id;
            $selectedCategory = [$selectedCategoryId];

            // Use random IDs for age group and game type
            $selectedAgeGroupId = $ageGroups->random()->id;
            $selectedAgeGroup = [$selectedAgeGroupId];

            $selectedGameTypeId = $gameTypes->random()->id;
            $selectedGameType = [$selectedGameTypeId];

            // Select random gender
            $genders = ['دختر', 'پسر', 'هردو'];
            $selectedGender = $genders[array_rand($genders)];

            $price = rand(50, 1000) * 1000;
            $stock = rand(0, 50);

            Product::create([
                'title' => $randomProductName,
                'price' => $price,
                'description' => $descriptions[array_rand($descriptions)],
                'age_group' => $selectedAgeGroup,
                'game_type' => $selectedGameType,
                'category' => $selectedCategory,
                'gender' => $selectedGender,
                'image' => $placeholderImages[array_rand($placeholderImages)],
                'stock' => $stock,
            ]);

            $productCount++;
        }

        echo "✅ Successfully created {$productCount} products!\n";
    }
}
