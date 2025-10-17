<?php

namespace App\Models\Shop;

use App\Models\User;
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
        'user_id',
        'shop_customer_id', // Keep for backward compatibility
        'number',
        'order_number',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'total_price',
        'status',
        'currency',
        'payment_method',
        'payment_status',
        'shipping_price',
        'shipping_method',
        'notes',
        'affiliate_user_id',
        'affiliate_code',
        'affiliate_link_code',
        'billing_address',
        'shipping_address',
        'coupon_code',
        'coupon_discount',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

    /** @return BelongsTo<Coupon, $this> */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
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

    /**
     * Get the order's formatted total
     */
    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get the order's formatted subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Get the order's status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            OrderStatus::New => 'primary',
            OrderStatus::Processing => 'warning',
            OrderStatus::Shipped => 'info',
            OrderStatus::Delivered => 'success',
            OrderStatus::Cancelled => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the order's payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'refunded' => 'dark',
            default => 'secondary',
        };
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [OrderStatus::New, OrderStatus::Processing]) &&
               !$this->cancelled_at;
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }

    /**
     * Check if order is shipped
     */
    public function isShipped(): bool
    {
        return $this->status === OrderStatus::Shipped && $this->shipped_at;
    }

    /**
     * Check if order is delivered
     */
    public function isDelivered(): bool
    {
        return $this->status === OrderStatus::Delivered && $this->delivered_at;
    }

    /**
     * Scope for orders by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for orders by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for orders by payment status
     */
    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }
}
