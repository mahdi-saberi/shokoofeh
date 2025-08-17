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
        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_type'); // 'image' or 'video'
            $table->string('mime_type');
            $table->string('original_name');
            $table->integer('file_size');
            $table->boolean('is_main')->default(false); // برای تصویر اصلی
            $table->integer('sort_order')->default(0); // ترتیب نمایش
            $table->timestamps();

            // Index for faster queries
            $table->index(['product_id', 'file_type']);
            $table->index(['product_id', 'is_main']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_media');
    }
};
