<?php

namespace Database\Seeders;

use App\Models\GameType;
use Illuminate\Database\Seeder;

class GameTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gameTypes = [
            ['title' => 'فکری'],
            ['title' => 'آموزشی'],
            ['title' => 'ساختنی'],
            ['title' => 'ماشین بازی'],
            ['title' => 'عروسک بازی'],
            ['title' => 'پازل'],
            ['title' => 'کارت بازی'],
            ['title' => 'بازی رومیزی'],
            ['title' => 'اسباب بازی موسیقی'],
            ['title' => 'اسباب بازی هنری'],
        ];

        foreach ($gameTypes as $gameType) {
            GameType::firstOrCreate($gameType);
        }
    }
}
