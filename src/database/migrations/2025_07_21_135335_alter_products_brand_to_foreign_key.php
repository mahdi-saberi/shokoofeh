<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ابتدا فیلد brand را به brand_id تغییر می‌دهیم
            $table->unsignedBigInteger('brand_id')->nullable();

            // اضافه کردن foreign key
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });

        // انتقال داده‌ها از فیلد brand به brand_id
        // $products = \App\Models\Product::whereNotNull('brand')->get();
        // foreach ($products as $product) {
        //     $brand = \App\Models\Brand::where('title', $product->brand)->first();
        //     if ($brand) {
        //         $product->brand_id = $brand->id;
        //         $product->save();
        //     }
        // }

        // حذف فیلد brand قدیمی
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropColumn('brand');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // اضافه کردن فیلد brand قدیمی
            $table->string('brand')->nullable();

            // انتقال داده‌ها از brand_id به brand
            $products = \App\Models\Product::whereNotNull('brand_id')->get();
            foreach ($products as $product) {
                $brand = \App\Models\Brand::find($product->brand_id);
                if ($brand) {
                    $product->brand = $brand->title;
                    $product->save();
                }
            }

            // حذف foreign key و فیلد brand_id
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
