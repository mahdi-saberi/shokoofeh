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
            $table->boolean('header_announcement_enabled')->default(false)->after('meta_description');
            $table->text('header_announcement_text')->nullable()->after('header_announcement_enabled');
            $table->string('header_announcement_bg_color')->default('#667eea')->after('header_announcement_text');
            $table->string('header_announcement_text_color')->default('#ffffff')->after('header_announcement_bg_color');
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
