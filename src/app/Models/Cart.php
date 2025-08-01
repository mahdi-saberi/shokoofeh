<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Get the product for this cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user for this cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get total price for this cart item
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Scope for session-based cart items
     */
    public function scopeForSession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    /**
     * Scope for user-based cart items
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId)->whereNull('session_id');
    }

    /**
     * Get cart items for current user or session
     */
    public static function getCurrentCart($user = null, $sessionId = null)
    {
        if ($user) {
            return static::forUser($user->id)->with('product')->get();
        }

        if ($sessionId) {
            return static::forSession($sessionId)->with('product')->get();
        }

        return collect();
    }

    /**
     * Add or update item in cart
     */
    public static function addItem($productId, $quantity = 1, $user = null, $sessionId = null)
    {
        $product = Product::findOrFail($productId);

        $cartData = [
            'product_id' => $productId,
            'price' => $product->price,
        ];

        if ($user) {
            $cartData['user_id'] = $user->id;
            $cartData['session_id'] = null;
            $existingItem = static::forUser($user->id)->where('product_id', $productId)->first();
        } else {
            $cartData['session_id'] = $sessionId;
            $cartData['user_id'] = null;
            $existingItem = static::forSession($sessionId)->where('product_id', $productId)->first();
        }

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem;
        }

        $cartData['quantity'] = $quantity;
        return static::create($cartData);
    }

    /**
     * Get cart total
     */
    public static function getCartTotal($user = null, $sessionId = null)
    {
        $cartItems = static::getCurrentCart($user, $sessionId);
        return $cartItems->sum('total_price');
    }

    /**
     * Get cart count
     */
    public static function getCartCount($user = null, $sessionId = null)
    {
        $cartItems = static::getCurrentCart($user, $sessionId);
        return $cartItems->sum('quantity');
    }

    /**
     * Clear cart
     */
    public static function clearCart($user = null, $sessionId = null)
    {
        if ($user) {
            static::forUser($user->id)->delete();
        } elseif ($sessionId) {
            static::forSession($sessionId)->delete();
        }
    }
}
