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
            // Feature Box 1
            $table->string('feature_box_1_title')->nullable();
            $table->text('feature_box_1_description')->nullable();
            $table->string('feature_box_1_icon')->nullable();
            $table->boolean('feature_box_1_enabled')->default(true);

            // Feature Box 2
            $table->string('feature_box_2_title')->nullable();
            $table->text('feature_box_2_description')->nullable();
            $table->string('feature_box_2_icon')->nullable();
            $table->boolean('feature_box_2_enabled')->default(true);

            // Feature Box 3
            $table->string('feature_box_3_title')->nullable();
            $table->text('feature_box_3_description')->nullable();
            $table->string('feature_box_3_icon')->nullable();
            $table->boolean('feature_box_3_enabled')->default(true);

            // Feature Box 4
            $table->string('feature_box_4_title')->nullable();
            $table->text('feature_box_4_description')->nullable();
            $table->string('feature_box_4_icon')->nullable();
            $table->boolean('feature_box_4_enabled')->default(true);
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
                'feature_box_4_enabled',
            ]);
        });
    }
};
