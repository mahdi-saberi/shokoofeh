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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Like: ORD-202507-001
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Customer information (for guest checkout)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            // Shipping information
            $table->text('shipping_address');
            $table->string('postal_code', 20);
            $table->string('city', 100);
            $table->string('province', 100)->nullable();

            // Order details
            $table->decimal('subtotal', 10, 2); // Sum of items
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2); // Final amount

            // Status
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            // Payment information
            $table->string('payment_method')->nullable(); // zarinpal, etc.
            $table->string('payment_reference_id')->nullable(); // Transaction ID from gateway
            $table->timestamp('paid_at')->nullable();

            // Notes
            $table->text('notes')->nullable(); // Customer notes
            $table->text('admin_notes')->nullable(); // Admin notes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
