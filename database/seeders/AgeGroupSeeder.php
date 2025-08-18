<?php

namespace Database\Seeders;

use App\Models\AgeGroup;
use Illuminate\Database\Seeder;

class AgeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ageGroups = [
            ['title' => 'نوزاد (0-12 ماه)'],
            ['title' => 'نوپا (1-3 سال)'],
            ['title' => 'پیش دبستان (3-6 سال)'],
            ['title' => 'دبستانی (6-12 سال)'],
            ['title' => 'نوجوان (12-18 سال)'],
            ['title' => 'بزرگسال (18+ سال)'],
        ];

        foreach ($ageGroups as $ageGroup) {
            AgeGroup::firstOrCreate($ageGroup);
        }
    }
}
