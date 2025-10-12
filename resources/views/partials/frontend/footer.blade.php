<footer class="footer-area">
    <!--== Start Footer Main ==-->
    <div class="footer-main">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <!--== Start widget Item ==-->
            <div class="widget-item">
              <div class="about-widget-wrap">
                <div class="widget-logo-area">
                  <a href="{{ route('home') }}">
                    <img class="logo-main" src="{{ asset('img/logo-light.webp') }}" width="131" height="34" alt="Logo" />
                  </a>
                </div>
                <p class="desc">Cửa hàng giày online chất lượng cao, phong cách thời trang hiện đại với dịch vụ tận tâm.</p>
                <div class="social-icons">
                  <a href="https://www.facebook.com/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                  <a href="https://dribbble.com/" target="_blank" rel="noopener"><i class="fa fa-dribbble"></i></a>
                  <a href="https://www.pinterest.com/" target="_blank" rel="noopener"><i class="fa fa-pinterest-p"></i></a>
                  <a href="https://twitter.com/" target="_blank" rel="noopener"><i class="fa fa-twitter"></i></a>
                </div>
              </div>
            </div>
            <!--== End widget Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start widget Item ==-->
            <div class="widget-item widget-services-item">
              <h4 class="widget-title">Dịch vụ</h4>
              <h4 class="widget-collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#widgetId-1">Dịch vụ</h4>
              <div id="widgetId-1" class="collapse widget-collapse-body">
                <div class="collapse-body">
                  <div class="widget-menu-wrap">
                    <ul class="nav-menu">
                      <li><a href="{{ route('contact') }}">Giao hàng tận nơi</a></li>
                      <li><a href="{{ route('contact') }}">Đổi trả miễn phí</a></li>
                      <li><a href="{{ route('contact') }}">Bảo hành chính hãng</a></li>
                      <li><a href="{{ route('contact') }}">Tư vấn chuyên nghiệp</a></li>
                      <li><a href="{{ route('contact') }}">Thanh toán an toàn</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!--== End widget Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start widget Item ==-->
            <div class="widget-item widget-account-item">
              <h4 class="widget-title">Tài khoản</h4>
              <h4 class="widget-collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#widgetId-2">Tài khoản</h4>
              <div id="widgetId-2" class="collapse widget-collapse-body">
                <div class="collapse-body">
                  <div class="widget-menu-wrap">
                    <ul class="nav-menu">
                      <li><a href="{{ route('account') }}">Tài khoản của tôi</a></li>
                      <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                      <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
                      <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                      <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!--== End widget Item ==-->
          </div>
          <div class="col-md-6 col-lg-3">
            <!--== Start widget Item ==-->
            <div class="widget-item">
              <h4 class="widget-title">Thông tin liên hệ</h4>
              <h4 class="widget-collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#widgetId-3">Thông tin liên hệ</h4>
              <div id="widgetId-3" class="collapse widget-collapse-body">
                <div class="collapse-body">
                  <div class="widget-contact-wrap">
                    <ul>
                      <li><span>Địa chỉ:</span> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                      <li><span>Điện thoại:</span> <a href="tel://0123456789">0123456789</a></li>
                      <li><span>Email:</span> <a href="mailto://info@shoestore.com">info@shoestore.com</a></li>
                      <li><a target="_blank" href="{{ route('home') }}">www.shoestore.com</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!--== End widget Item ==-->
          </div>
        </div>
      </div>
    </div>
    <!--== End Footer Main ==-->

    <!--== Start Footer Bottom ==-->
    <div class="footer-bottom">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-md-7 col-lg-6">
            <p class="copyright">© {{ date('Y') }} Shoe Store. Made with <i class="fa fa-heart"></i> by <a target="_blank" href="#">Your Company</a></p>
          </div>
          <div class="col-md-5 col-lg-6">
            <div class="payment">
              <a href="{{ route('account') }}"><img src="{{ asset('img/photos/payment-card.webp') }}" width="192" height="21" alt="Payment Logo"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Footer Bottom ==-->
  </footer>