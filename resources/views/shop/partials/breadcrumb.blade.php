<!-- Breadcrumb Partial -->
<ul class="breadcrumb">
    <li><a href="{{ route('home') }}">Trang chủ</a></li>
    <li class="breadcrumb-sep">//</li>
    <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
    @if ($currentBrand)
        <li class="breadcrumb-sep">//</li>
        <li>{{ $currentBrand->name }}</li>
    @endif
    @if ($currentCategory)
        <li class="breadcrumb-sep">//</li>
        <li>{{ $currentCategory->name }}</li>
    @endif
</ul>