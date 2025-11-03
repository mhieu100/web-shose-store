<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
        'affiliate_code',
        'commission_rate',
        'is_affiliate_active',
        'is_active',
        'last_login_at',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'commission_rate' => 'decimal:2',
        'is_affiliate_active' => 'boolean',
    ];

    /**
     * Get the role that owns the user
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Chỉ cho phép admin truy cập admin panel
        return $this->role?->name === 'admin' && $this->is_active;
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return in_array($this->role?->name, $roleNames);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role?->hasPermission($permission) ?? false;
    }

    /**
     * Get user's role label
     */
    public function getRoleLabel(): string
    {
        return $this->role?->label ?? 'Không có vai trò';
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for users by role
     */
    public function scopeByRole($query, string $roleName)
    {
        return $query->whereHas('role', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return true;
    }

    /** @return Collection<int,Team> */
    public function getTenants(Panel $panel): Collection
    {
        return Team::all();
    }

    /**
     * Get the user's wishlist items
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(\App\Models\Shop\Wishlist::class);
    }

    /**
     * Get the products in the user's wishlist
     */
    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Shop\Product::class, 'shop_wishlists', 'user_id', 'shop_product_id')
                    ->withTimestamps();
    }

    /**
     * Check if a product is in the user's wishlist
     */
    public function hasInWishlist($productId): bool
    {
        return $this->wishlistProducts()->where('shop_product_id', $productId)->exists();
    }

    /**
     * Get the user's cart items
     */
    public function carts(): HasMany
    {
        return $this->hasMany(\App\Models\Shop\Cart::class);
    }

    /**
     * Get the products in the user's cart
     */
    public function cartProducts(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Shop\Product::class, 'shop_carts', 'user_id', 'shop_product_id')
                    ->withPivot(['quantity', 'price'])
                    ->withTimestamps();
    }

    /**
     * Check if a product is in the user's cart
     */
    public function hasInCart($productId): bool
    {
        return $this->cartProducts()->where('shop_product_id', $productId)->exists();
    }

    /**
     * Get total cart items count
     */
    public function getCartCountAttribute(): int
    {
        return $this->carts()->sum('quantity');
    }

    /**
     * Get total cart amount
     * Temporarily disabled to fix stripos error
     */
    // public function getCartTotalAttribute(): float
    // {
    //     try {
    //         return (float) $this->carts()->with('product')->get()->sum(function ($cartItem) {
    //             return (float) ($cartItem->quantity * $cartItem->price);
    //         });
    //     } catch (\Exception $e) {
    //         \Log::error('Cart total calculation error: ' . $e->getMessage());
    //         return 0.0;
    //     }
    // }

    /**
     * Get the user's affiliate links
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(\App\Models\AffiliateLink::class);
    }

    /**
     * Get the user's commissions
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(\App\Models\Commission::class);
    }

    /**
     * Generate a unique affiliate code for the user
     */
    public function generateAffiliateCode(): string
    {
        do {
            $code = 'CTV' . strtoupper(substr(uniqid(), -6));
        } while (self::where('affiliate_code', $code)->exists());

        return $code;
    }

    /**
     * Check if user is an active affiliate
     */
    public function isActiveAffiliate(): bool
    {
        return $this->hasRole('ctv') && $this->is_affiliate_active && !empty($this->affiliate_code);
    }

    /**
     * Create affiliate link for a product
     */
    public function createAffiliateLink($productId): ?\App\Models\AffiliateLink
    {
        if (!$this->isActiveAffiliate()) {
            return null;
        }

        // Check if link already exists
        $existingLink = $this->affiliateLinks()->where('shop_product_id', $productId)->first();
        if ($existingLink) {
            return $existingLink;
        }

        $product = \App\Models\Shop\Product::find($productId);
        if (!$product) {
            return null;
        }

        $linkCode = \App\Models\AffiliateLink::generateLinkCode();
        $originalUrl = route('product.show', $product->id);
        $affiliateUrl = route('product.show', ['id' => $product->id, 'ref' => $this->affiliate_code]);

        return $this->affiliateLinks()->create([
            'shop_product_id' => $productId,
            'link_code' => $linkCode,
            'original_url' => $originalUrl,
            'affiliate_url' => $affiliateUrl,
        ]);
    }

    /**
     * Get total pending commissions
     */
    public function getTotalPendingCommissions(): float
    {
        return $this->commissions()->where('status', 'pending')->sum('commission_amount');
    }

    /**
     * Get total approved commissions
     */
    public function getTotalApprovedCommissions(): float
    {
        return $this->commissions()->where('status', 'approved')->sum('commission_amount');
    }

    /**
     * Get total paid commissions
     */
    public function getTotalPaidCommissions(): float
    {
        return $this->commissions()->where('status', 'paid')->sum('commission_amount');
    }

    /**
     * Get the user's orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(\App\Models\Shop\Order::class);
    }

    /**
     * Get the user's wallet
     */
    public function wallet()
    {
        return $this->hasOne(\App\Models\Shop\UserWallet::class);
    }

    /**
     * Get the user's wallet transactions
     */
    public function walletTransactions(): HasMany
    {
        return $this->hasMany(\App\Models\Shop\WalletTransaction::class);
    }

    /**
     * Get the user's addresses
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(\App\Models\Address::class, 'addressable');
    }
}
