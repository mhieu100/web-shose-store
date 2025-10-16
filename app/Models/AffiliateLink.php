<?php

namespace App\Models;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_product_id',
        'link_code',
        'original_url',
        'affiliate_url',
        'clicks',
        'conversions',
        'total_commission',
        'is_active',
        'last_clicked_at',
    ];

    protected $casts = [
        'total_commission' => 'decimal:2',
        'is_active' => 'boolean',
        'last_clicked_at' => 'datetime',
    ];

    /**
     * Get the user that owns the affiliate link
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the affiliate link
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }

    /**
     * Generate a unique link code
     */
    public static function generateLinkCode(): string
    {
        do {
            $code = 'AF' . strtoupper(uniqid());
        } while (self::where('link_code', $code)->exists());

        return $code;
    }

    /**
     * Record a click on this affiliate link
     */
    public function recordClick(): void
    {
        $this->increment('clicks');
        $this->update(['last_clicked_at' => now()]);
    }

    /**
     * Record a conversion for this affiliate link
     */
    public function recordConversion(float $commissionAmount): void
    {
        $this->increment('conversions');
        $this->increment('total_commission', $commissionAmount);
    }

    /**
     * Get conversion rate as percentage
     */
    public function getConversionRateAttribute(): float
    {
        if ($this->clicks === 0) {
            return 0;
        }

        return round(($this->conversions / $this->clicks) * 100, 2);
    }
}