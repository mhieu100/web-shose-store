<?php

namespace App\Models\Shop;

use App\Enums\CouponType;
use Database\Factories\Shop\CouponFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_coupons';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'type' => CouponType::class,
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /** @return BelongsToMany<Product, $this> */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_coupon_product', 'shop_coupon_id', 'shop_product_id')->withTimestamps();
    }

    /**
     * Check if coupon is valid for use
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->starts_at && $now->isBefore($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->isAfter($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $amount): float
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return 0;
        }

        $discount = match ($this->type) {
            CouponType::Percentage => $amount * ($this->value / 100),
            CouponType::FixedAmount => $this->value,
        };

        if ($this->maximum_amount && $discount > $this->maximum_amount) {
            $discount = $this->maximum_amount;
        }

        return min($discount, $amount);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    /**
     * Scope for active coupons
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid coupons
     */
    public function scopeValid(Builder $query): Builder
    {
        $now = Carbon::now();
        
        return $query->active()
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    /**
     * Scope for coupons that apply to a specific product
     */
    public function scopeForProduct(Builder $query, int $productId): Builder
    {
        return $query->whereHas('products', function ($q) use ($productId) {
            $q->where('shop_product_id', $productId);
        });
    }

    /**
     * Get remaining usage count
     */
    public function getRemainingUsageAttribute(): ?int
    {
        if (!$this->usage_limit) {
            return null;
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    /**
     * Check if coupon has expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Check if coupon has not started yet
     */
    public function getIsNotStartedAttribute(): bool
    {
        return $this->starts_at && Carbon::now()->isBefore($this->starts_at);
    }
}