<!-- Search Sidebar -->
<aside class="aside-search-box-wrapper offcanvas offcanvas-top" tabindex="-1" id="AsideOffcanvasSearch">
  <div class="offcanvas-header">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ route('shop.search') }}" method="GET">
      <input type="search" name="q" placeholder="Tìm kiếm sản phẩm..." class="form-control">
      <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
  </div>
</aside>