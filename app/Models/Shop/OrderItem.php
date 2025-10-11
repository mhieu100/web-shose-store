<?php

namespace App\Models\Shop;

use Database\Factories\Shop\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<OrderItemFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_order_items';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_order_id',
        'shop_product_id', 
        'qty',
        'unit_price',
        'sort',
    ];

    /**
     * Get the total price for this item (qty * unit_price)
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->qty * $this->unit_price;
    }

    /**
     * Get the product relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }

    /**
     * Get the order relationship  
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'shop_order_id');
    }
}
