@props([
    'product',
    'class' => '',
    'showActions' => true,
    'showDiscount' => true,
    'showCategory' => true,
    'showBrand' => true,
    'imageWidth' => 264,
    'imageHeight' => 264,
    'aosAnimation' => 'fade-up',
    'aosDuration' => 1000,
    'aosDelay' => 0
])

<div class="product-item {{ $class }}"
     data-aos="{{ $aosAnimation }}"
     data-aos-duration="{{ $aosDuration + $aosDelay }}">
    <div class="inner-content">
        <div class="product-thumb">
            <a href="{{ route('product.show', $product->id) }}">
                @if ($product->getMedia('product-images')->count() > 0)
                    <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                         width="{{ $imageWidth }}" height="{{ $imageHeight }}"
                         alt="{{ $product->name }}"
                         loading="lazy"
                         style="width: 100%; height: 264px; object-fit: cover; object-position: center;">
                @else
                    <img src="{{ asset('img/shop/placeholder.webp') }}"
                         width="{{ $imageWidth }}" height="{{ $imageHeight }}"
                         alt="{{ $product->name }}"
                         loading="lazy"
                         style="width: 100%; height: 264px; object-fit: cover; object-position: center;">
                @endif
            </a>

            @if ($showDiscount && $product->sale_price && $product->sale_price < $product->price)
                <div class="product-flag">
                    <ul>
                        <li class="discount">
                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                        </li>
                    </ul>
                </div>
            @elseif ($showDiscount && isset($product->old_price) && $product->old_price && $product->old_price > $product->price)
                <div class="product-flag">
                    <ul>
                        <li class="discount">
                            -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                        </li>
                    </ul>
                </div>
            @endif

            @if ($showActions)
                <div class="product-action">
                    <x-wishlist-button :product="$product" class="btn-product-wishlist" />
                    <button type="button"
                            class="btn-product-cart add-to-cart"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}"
                            data-product-price="{{ $product->sale_price ?? $product->price }}"
                            data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                            data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                            title="{{ __('home.add_to_cart') }}">
                        <i class="bx bx-cart"></i>
                    </button>
                    <button type="button" class="btn-product-quick-view-open"
                            title="{{ __('home.quick_view') }}">
                        <i class="bx bx-expand-alt"></i>
                    </button>
                    <a class="btn-product-compare"
                       href="{{ route('compare') }}"
                       title="{{ __('home.compare') }}">
                        <i class="bx bx-git-compare"></i>
                    </a>
                </div>
            @endif
        </div>

        <div class="product-info">
            @if ($showCategory || $showBrand)
                <div class="category">
                    <ul>
                        @if ($showBrand && $product->brand)
                            <li><a href="{{ route('shop') }}?brand={{ $product->brand->slug ?? $product->brand->id }}">{{ $product->brand->name }}</a></li>
                            @if ($showCategory && $product->categories->count() > 0)
                                <li class="sep">/</li>
                            @endif
                        @endif
                        @if ($showCategory && $product->categories->count() > 0)
                            <li><a href="{{ route('shop') }}?category={{ $product->categories->first()->slug ?? $product->categories->first()->id }}">{{ $product->categories->first()->name }}</a></li>
                        @endif
                    </ul>
                </div>
            @endif

            <h4 class="title">
                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
            </h4>

            <div class="prices">
                @if ($product->sale_price && $product->sale_price < $product->price)
                    <span class="price-old">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                    <span class="sep">-</span>
                    <span class="price">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                @elseif (isset($product->old_price) && $product->old_price && $product->old_price > $product->price)
                    <span class="price-old">{{ number_format($product->old_price, 0, ',', '.') }} VNĐ</span>
                    <span class="sep">-</span>
                    <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                @else
                    <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                @endif
            </div>

            @if ($product->colors && count($product->colors) > 0)
                <div class="product-variants-preview mt-2">
                    <small class="text-muted">Màu sắc:</small>
                    <div class="color-preview d-inline-flex ms-1">
                        @foreach(array_slice($product->colors, 0, 4) as $color)
                            @php
                                $colorName = is_array($color) ? ($color['name'] ?? $color) : $color;
                                $colorCode = get_color_code($colorName) ?? '#666';
                            @endphp
                            <span class="color-dot me-1"
                                  style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ $colorCode }}; border: 1px solid #ddd;"
                                  title="{{ $colorName }}"></span>
                        @endforeach
                        @if (count($product->colors) > 4)
                            <small class="text-muted">+{{ count($product->colors) - 4 }}</small>
                        @endif
                    </div>
                </div>
            @endif

            @if ($product->sizes && count($product->sizes) > 0)
                <div class="product-sizes-preview mt-1">
                    <small class="text-muted">Size:</small>
                    @foreach(array_slice($product->sizes, 0, 3) as $size)
                        <span class="size-preview badge bg-light text-dark me-1" style="font-size: 10px;">
                            {{ is_array($size) ? ($size['value'] ?? $size['size'] ?? $size) : $size }}
                        </span>
                    @endforeach
                    @if (count($product->sizes) > 3)
                        <small class="text-muted">+{{ count($product->sizes) - 3 }}</small>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
