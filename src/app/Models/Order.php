<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'postal_code',
        'city',
        'province',
        'subtotal',
        'shipping_cost',
        'discount_amount',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference_id',
        'paid_at',
        'notes',
        'admin_notes'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    /**
     * Get the user for this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = date('Ym'); // YYYYMM format

        // Get last order number for this month
        $lastOrder = static::where('order_number', 'like', "{$prefix}-{$date}-%")
                          ->orderBy('order_number', 'desc')
                          ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "{$prefix}-{$date}-{$newNumber}";
    }

    /**
     * Boot method to generate order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    /**
     * Get status color for admin display
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'secondary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get payment status color for admin display
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get status text in Persian
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'در انتظار تایید',
            'confirmed' => 'تایید شده',
            'processing' => 'در حال پردازش',
            'shipped' => 'ارسال شده',
            'delivered' => 'تحویل داده شده',
            'cancelled' => 'لغو شده',
            default => 'نامشخص'
        };
    }

    /**
     * Get payment status text in Persian
     */
    public function getPaymentStatusTextAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'در انتظار پرداخت',
            'paid' => 'پرداخت شده',
            'failed' => 'پرداخت ناموفق',
            'refunded' => 'بازگشت داده شده',
            default => 'نامشخص'
        };
    }

    /**
     * Calculate shipping cost based on total
     */
    public static function calculateShippingCost($subtotal): float
    {
        // Free shipping over 500,000 Toman
        if ($subtotal >= 500000) {
            return 0;
        }

        // Fixed shipping cost
        return 50000; // 50,000 Toman
    }

    /**
     * Create order from cart
     */
    public static function createFromCart($cartItems, $customerData, $user = null)
    {
        $subtotal = $cartItems->sum('total_price');
        $shippingCost = static::calculateShippingCost($subtotal);
        $total = $subtotal + $shippingCost;

        $orderData = array_merge($customerData, [
            'user_id' => $user?->id,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        $order = static::create($orderData);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->title,
                'product_code' => $cartItem->product->product_code,
                'unit_price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
                'total_price' => $cartItem->total_price,
                'product_details' => [
                    'name' => $cartItem->product->title,
                    'description' => $cartItem->product->description,
                    'category' => $cartItem->product->category,
                    'age_group' => $cartItem->product->age_group,
                    'game_type' => $cartItem->product->game_type
                ]
            ]);
        }

        return $order;
    }
}
