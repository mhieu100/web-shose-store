<!-- Products Grid View -->
    @forelse($products as $product)
        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <!--== Start Product Item ==-->
            <div class="product-item">
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
                        @if ($product->old_price && $product->old_price > $product->price)
                            @php
                                $discount = round((($product->old_price - $product->price) / $product->old_price) * 100);
                            @endphp
                            <span class="flag-new sale">-{{ $discount }}%</span>
                        @endif
                        <div class="product-action">
                            <button type="button" class="btn-product-cart add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->sale_price ?? $product->price }}"
                                    data-product-colors="{{ $product->colors ? json_encode($product->colors) : '[]' }}"
                                    data-product-sizes="{{ $product->sizes ? json_encode($product->sizes) : '[]' }}"
                                    title="Thêm vào giỏ hàng">
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                            <x-wishlist-button :product="$product" class="btn-product-wishlist" />
                            <button type="button" class="btn-product-quick-view-open" title="Xem nhanh">
                                <i class="fa fa-arrows-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="category-list">
                            @foreach ($product->categories as $category)
                                <a href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                @if (!$loop->last)
                                    <span>/</span>
                                @endif
                            @endforeach
                        </div>
                        <h4 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h4>
                        <div class="prices">
                            @if ($product->old_price && $product->old_price > $product->price)
                                <span class="price-old">{{ number_format($product->old_price, 0, ',', '.') }} VNĐ</span>
                                <span class="sep">-</span>
                            @endif
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
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