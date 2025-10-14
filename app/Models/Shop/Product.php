<?php

namespace App\Models\Shop;

use App\Models\Comment;
use App\Models\Shop\Coupon;
use Database\Factories\Shop\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'qty',
        'security_stock',
        'featured',
        'is_visible',
        'old_price',
        'price',
        'cost',
        'type',
        'backorder',
        'requires_shipping',
        'published_at',
        'seo_title',
        'seo_description',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'volume_unit',
        'sizes',
        'colors',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'date',
        'sizes' => 'array',
        'colors' => 'array',
    ];

    /** @return BelongsTo<Brand, $this> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'shop_brand_id');
    }

    /** @return BelongsToMany<Category, $this> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'shop_product_id', 'shop_category_id')->withTimestamps();
    }

    /** @return MorphMany<Comment, $this> */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /** @return BelongsToMany<Coupon, $this> */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'shop_coupon_product', 'shop_product_id', 'shop_coupon_id')->withTimestamps();
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<OrderItem, $this> */
    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_product_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product-images')
            ->useDisk('product-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
            ->registerMediaConversions(function (Media $media): void {
                $this
                    ->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300)
                    ->sharpen(10)
                    ->format('webp')
                    ->optimize()
                    ->nonQueued();
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->optimize()
            ->nonQueued(); // Process immediately for better UX
    }

    /** @return HasMany<Wishlist, $this> */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'shop_product_id');
    }

    /** @return BelongsToMany<\App\Models\User, $this> */
    public function wishlistUsers(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'shop_wishlists', 'shop_product_id', 'user_id')
                    ->withTimestamps();
    }
}
