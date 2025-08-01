<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'لگو'],
            ['title' => 'ماشین'],
            ['title' => 'عروسک'],
            ['title' => 'پازل'],
            ['title' => 'کارت'],
            ['title' => 'بازی رومیزی'],
            ['title' => 'اسباب بازی موسیقی'],
            ['title' => 'اسباب بازی هنری'],
            ['title' => 'اسباب بازی ورزشی'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
