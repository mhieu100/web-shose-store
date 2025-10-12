<?php

namespace App\Models\Shop;

use App\Models\Address;
use Database\Factories\Shop\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Brand extends Model implements HasMedia
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;

    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'shop_brands';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /** @return MorphToMany<Address, $this> */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable', 'addressables');
    }

    /** @return HasMany<Product, $this> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shop_brand_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('brand-images')
            ->useDisk('brand-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile()
            ->registerMediaConversions(function (Media $media): void {
                $this
                    ->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150);
            });
    }
}
