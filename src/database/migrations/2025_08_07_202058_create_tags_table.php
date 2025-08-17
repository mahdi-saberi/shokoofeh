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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام تگ
            $table->string('slug')->unique(); // slug برای URL
            $table->string('color', 7)->default('#3B82F6'); // رنگ تگ (hex code)
            $table->text('description')->nullable(); // توضیحات تگ
            $table->boolean('is_active')->default(true); // وضعیت فعال/غیرفعال
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
