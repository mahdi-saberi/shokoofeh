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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان تخفیف
            $table->enum('type', ['product', 'campaign']); // نوع تخفیف: موردی یا کمپین
            $table->enum('discount_type', ['percentage', 'fixed']); // نوع تخفیف: درصدی یا مبلغ ثابت
            $table->decimal('value', 10, 2); // مقدار تخفیف (درصد یا مبلغ)

            // برای تخفیف موردی
            $table->unsignedBigInteger('product_id')->nullable();

            // برای کمپین تخفیف
            $table->string('target_type')->nullable(); // category, age_group, game_type
            $table->string('target_value')->nullable(); // مقدار هدف (نام دسته‌بندی یا...)

            // تاریخ شروع و پایان
            $table->timestamp('start_date');
            $table->timestamp('end_date');

            // وضعیت فعال/غیرفعال
            $table->boolean('is_active')->default(true);

            // حداقل مبلغ خرید برای اعمال تخفیف
            $table->decimal('minimum_amount', 10, 2)->nullable();

            // حداکثر مبلغ تخفیف
            $table->decimal('maximum_discount', 10, 2)->nullable();

            // توضیحات
            $table->text('description')->nullable();

            $table->timestamps();

            // ایندکس‌ها
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['type', 'is_active']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
