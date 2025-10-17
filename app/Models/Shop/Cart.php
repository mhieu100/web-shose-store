<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    /**
     * @var string
     */
    protected $table = 'shop_carts';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shop_product_id',
        'quantity',
        'price',
        'color',
        'color_code',
        'size',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that belongs to the cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }

    /**
     * Get the total price for this cart item (quantity * price)
     */
    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}
