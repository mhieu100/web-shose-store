<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    /**
     * @var string
     */
    protected $table = 'shop_wishlists';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shop_product_id',
    ];

    /**
     * Get the user that owns the wishlist item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that belongs to the wishlist item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }
}
