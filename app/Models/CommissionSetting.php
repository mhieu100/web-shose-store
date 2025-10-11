<?php

namespace App\Models;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CommissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'target_id',
        'target_type',
        'commission_rate',
        'min_order_amount',
        'max_commission',
        'is_active',
        'priority',
        'valid_from',
        'valid_until',
        'description',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_commission' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    // Polymorphic relationship
    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('valid_from')
                          ->orWhere('valid_from', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', now());
                    });
    }

    // Static method for commission calculation
    public static function calculateCommission(User $user, $orderAmount, Product $product = null): array
    {
        $settings = self::active()->orderBy('priority', 'desc')->get();
        
        $applicableRate = 0;
        $maxCommission = null;
        $appliedSetting = null;

        foreach ($settings as $setting) {
            $isApplicable = false;

            switch ($setting->type) {
                case 'global':
                    $isApplicable = true;
                    break;
                    
                case 'user':
                    $isApplicable = $setting->target_id == $user->id;
                    break;
                    
                case 'product':
                    $isApplicable = $product && $setting->target_id == $product->id;
                    break;
                    
                case 'category':
                    $isApplicable = $product && $product->categories()->where('id', $setting->target_id)->exists();
                    break;
            }

            if ($isApplicable && $orderAmount >= $setting->min_order_amount) {
                $applicableRate = $setting->commission_rate;
                $maxCommission = $setting->max_commission;
                $appliedSetting = $setting;
                break;
            }
        }

        $commissionAmount = ($orderAmount * $applicableRate) / 100;
        
        if ($maxCommission && $commissionAmount > $maxCommission) {
            $commissionAmount = $maxCommission;
        }

        return [
            'rate' => $applicableRate,
            'amount' => round($commissionAmount, 2),
            'max_commission' => $maxCommission,
            'applied_setting' => $appliedSetting,
        ];
    }
}
