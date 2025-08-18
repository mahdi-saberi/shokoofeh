<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing products to have JSON age_group
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $ageGroup = $product->age_group;

            // If it's already JSON, skip
            if (is_string($ageGroup) && (str_starts_with($ageGroup, '[') || str_starts_with($ageGroup, '{'))) {
                continue;
            }

            // If it's a simple string, convert to array
            if (is_string($ageGroup) && !empty($ageGroup)) {
                $ageGroupArray = [$ageGroup];
            } else {
                // Default value
                $ageGroupArray = ['6-8'];
            }

            // Update the record
            DB::table('products')
                ->where('id', $product->id)
                ->update(['age_group' => json_encode($ageGroupArray)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back from JSON to string (take first element)
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $ageGroup = $product->age_group;

            if (is_string($ageGroup) && (str_starts_with($ageGroup, '[') || str_starts_with($ageGroup, '{'))) {
                $ageGroupArray = json_decode($ageGroup, true);
                $firstAge = !empty($ageGroupArray) ? $ageGroupArray[0] : '6-8';

                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['age_group' => $firstAge]);
            }
        }
    }
};
