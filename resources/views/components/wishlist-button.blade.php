@props(['product', 'class' => 'btn-wishlist-custom'])

@auth
    @if(auth()->user()->hasInWishlist($product->id))
        <button class="remove-from-wishlist {{ $class }}" 
                data-product-id="{{ $product->id }}" 
                title="Xóa khỏi danh sách yêu thích">
            <i class="fa fa-heart"></i>
        </button>
    @else
        <button class="add-to-wishlist {{ $class }}" 
                data-product-id="{{ $product->id }}" 
                title="Thêm vào danh sách yêu thích">
            <i class="fa fa-heart-o"></i>
        </button>
    @endif
@else
    <a href="{{ route('login') }}" class="{{ $class }}" title="Đăng nhập để thêm vào wishlist">
        <i class="fa fa-heart-o"></i>
    </a>
@endauth