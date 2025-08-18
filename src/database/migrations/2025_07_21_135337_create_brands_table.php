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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('نام برند');
            $table->text('description')->nullable()->comment('توضیحات برند');
            $table->string('logo')->nullable()->comment('لوگوی برند');
            $table->string('website')->nullable()->comment('وب‌سایت برند');
            $table->boolean('status')->default(true)->comment('وضعیت فعال/غیرفعال');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
