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
        Schema::table('site_settings', function (Blueprint $table) {
            // Header Announcement Settings
            $table->boolean('header_announcement_enabled')->default(false);
            $table->text('header_announcement_text')->nullable();
            $table->string('header_announcement_bg_color')->default('#667eea');
            $table->string('header_announcement_text_color')->default('#ffffff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'header_announcement_enabled',
                'header_announcement_text',
                'header_announcement_bg_color',
                'header_announcement_text_color'
            ]);
        });
    }
};
