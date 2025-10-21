@props(['product', 'class' => 'btn-wishlist-custom'])

@auth
    @if(auth()->user()->hasInWishlist($product->id))
        <button class="remove-from-wishlist {{ $class }}"
                data-product-id="{{ $product->id }}"
                title="Xóa khỏi danh sách yêu thích">
            <i class="bx bxs-heart"></i>
        </button>
    @else
        <button class="add-to-wishlist {{ $class }}"
                data-product-id="{{ $product->id }}"
                title="Thêm vào danh sách yêu thích">
            <i class="bx bx-heart"></i>
        </button>
    @endif
@else
    <a href="{{ route('login') }}" class="{{ $class }}" title="Đăng nhập để thêm vào wishlist">
        <i class="bx bx-heart"></i>
    </a>
@endauth
