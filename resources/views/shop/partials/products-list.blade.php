<!-- Products List View -->
    @forelse($products as $product)
        <div class="col-12">
            <!--== Start Product Item ==-->
            <div class="product-item product-item-list">
                <div class="inner-content">
                    <div class="product-thumb">
                        <a href="{{ route('product.show', $product->id) }}">
                            @if ($product->getFirstMediaUrl('product-images'))
                                <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                                     width="270" height="274" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('img/shop/placeholder.webp') }}"
                                     width="270" height="274" alt="{{ $product->name }}">
                            @endif
                        </a>
                    </div>
                    <div class="product-info">
                        <h4 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                        <div class="prices">
                            @if ($product->old_price && $product->old_price > $product->price)
                                <span class="price-old">{{ number_format($product->old_price, 0, ',', '.') }} VNĐ</span>
                                <span class="sep">-</span>
                            @endif
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <p>{{ Str::limit($product->description, 100) }}</p>
                        <div class="product-action">
                            <button type="button" class="btn-product-cart add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->sale_price ?? $product->price }}"
                                    data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                                    data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                                    title="Thêm vào giỏ hàng">Thêm vào giỏ</button>
                            <x-wishlist-button :product="$product" class="btn-product-wishlist" />
                        </div>
                    </div>
                </div>
            </div>
            <!--== End Product Item ==-->
        </div>
    @empty
        <div class="col-12">
            <div class="no-products-message">
                <i class="fa fa-search"></i>
                <h3>Không tìm thấy sản phẩm nào</h3>
                <p>
                    @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                        Không có sản phẩm nào phù hợp với các bộ lọc hiện tại.<br>
                        Hãy thử điều chỉnh bộ lọc hoặc xóa tất cả bộ lọc để xem toàn bộ sản phẩm.
                    @else
                        Hiện tại không có sản phẩm nào trong cửa hàng.
                    @endif
                </p>
                @if (request('search') || request('brand') || request('category') || request('min_price') || request('max_price'))
                    <a href="{{ route('shop') }}" class="btn-clear-filters">
                        <i class="fa fa-refresh"></i> Xóa tất cả bộ lọc
                    </a>
                @endif
            </div>
        </div>
    @endforelse