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
     */
    public function getCartTotalAttribute(): float
    {
        return $this->carts()->with('product')->get()->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->price;
        });
    }
}
