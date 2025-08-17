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
            // Feature Box 1 - Free Shipping
            $table->string('feature_box_1_title')->nullable()->after('header_announcement_text_color');
            $table->text('feature_box_1_description')->nullable()->after('feature_box_1_title');
            $table->string('feature_box_1_icon')->nullable()->after('feature_box_1_description');
            $table->boolean('feature_box_1_enabled')->default(true)->after('feature_box_1_icon');

            // Feature Box 2 - Secure Shopping
            $table->string('feature_box_2_title')->nullable()->after('feature_box_1_enabled');
            $table->text('feature_box_2_description')->nullable()->after('feature_box_2_title');
            $table->string('feature_box_2_icon')->nullable()->after('feature_box_2_description');
            $table->boolean('feature_box_2_enabled')->default(true)->after('feature_box_2_icon');

            // Feature Box 3 - Quality Guarantee
            $table->string('feature_box_3_title')->nullable()->after('feature_box_2_enabled');
            $table->text('feature_box_3_description')->nullable()->after('feature_box_3_title');
            $table->string('feature_box_3_icon')->nullable()->after('feature_box_3_description');
            $table->boolean('feature_box_3_enabled')->default(true)->after('feature_box_3_icon');

            // Feature Box 4 - 24/7 Support
            $table->string('feature_box_4_title')->nullable()->after('feature_box_3_enabled');
            $table->text('feature_box_4_description')->nullable()->after('feature_box_4_title');
            $table->string('feature_box_4_icon')->nullable()->after('feature_box_4_description');
            $table->boolean('feature_box_4_enabled')->default(true)->after('feature_box_4_icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'feature_box_1_title',
                'feature_box_1_description',
                'feature_box_1_icon',
                'feature_box_1_enabled',
                'feature_box_2_title',
                'feature_box_2_description',
                'feature_box_2_icon',
                'feature_box_2_enabled',
                'feature_box_3_title',
                'feature_box_3_description',
                'feature_box_3_icon',
                'feature_box_3_enabled',
                'feature_box_4_title',
                'feature_box_4_description',
                'feature_box_4_icon',
                'feature_box_4_enabled'
            ]);
        });
    }
};
