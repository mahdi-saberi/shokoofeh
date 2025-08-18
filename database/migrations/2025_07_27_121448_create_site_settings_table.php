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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Site Information
            $table->string('site_name')->default('فروشگاه شکوفه');
            $table->text('site_description')->nullable();
            $table->string('site_logo')->nullable();

            // Contact Information
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('working_hours')->nullable();

            // Social Media
            $table->string('social_instagram')->nullable();
            $table->string('social_telegram')->nullable();
            $table->string('social_whatsapp')->nullable();

            // Footer Content
            $table->text('footer_text')->nullable();
            $table->string('copyright_text')->nullable();

            // SEO Settings
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
