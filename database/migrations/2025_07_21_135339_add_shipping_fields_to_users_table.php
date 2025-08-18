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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->text('shipping_address')->nullable()->after('phone');
            $table->string('postal_code', 20)->nullable()->after('shipping_address');
            $table->string('city', 100)->nullable()->after('postal_code');
            $table->string('province', 100)->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'shipping_address', 'postal_code', 'city', 'province']);
        });
    }
};
