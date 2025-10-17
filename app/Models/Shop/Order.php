<?php

namespace App\Models\Shop;

use App\Enums\OrderStatus;
use Database\Factories\Shop\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shop_orders';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'number',
        'total_price',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
        'affiliate_user_id',
        'affiliate_code',
        'affiliate_link_code',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    /** @return MorphOne<OrderAddress, $this> */
    public function address(): MorphOne
    {
        return $this->morphOne(OrderAddress::class, 'addressable');
    }

    /** @return BelongsTo<Customer, $this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'shop_customer_id');
    }

    /** @return HasMany<OrderItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_order_id');
    }

    /** @return HasMany<Payment, $this> */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /** @return BelongsTo<\App\Models\User, $this> */
    public function affiliateUser(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'affiliate_user_id');
    }

    /**
     * Check if this order was referred by an affiliate
     */
    public function hasAffiliate(): bool
    {
        return !empty($this->affiliate_user_id) && !empty($this->affiliate_code);
    }

    /**
     * Calculate commission for affiliate user
     */
    public function calculateAffiliateCommission(): float
    {
        if (!$this->hasAffiliate() || !$this->affiliateUser) {
            return 0;
        }

        return $this->total_price * ($this->affiliateUser->commission_rate / 100);
    }
}
