@extends('layouts.frontend')

@section('title', 'Liên hệ - Shoe Store')
@section('description', 'Liên hệ với chúng tôi để được hỗ trợ tốt nhất')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Liên hệ</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Liên hệ</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Contact Area Wrapper ==-->
    <section class="contact-area contact-default-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="contact-form">
              <div class="section-title">
                <h3 class="title">Gửi tin nhắn cho chúng tôi</h3>
                <div class="desc">
                  <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy để lại tin nhắn và chúng tôi sẽ liên hệ sớm nhất.</p>
                </div>
              </div>
              <div class="contact-form-wrap">
                <form class="contact-form-list" action="#" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Họ và tên *" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email *" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="text" name="phone" placeholder="Số điện thoại">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" type="text" name="subject" placeholder="Tiêu đề *" required>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <textarea class="form-control" name="message" rows="7" placeholder="Nội dung tin nhắn *" required></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb--0">
                        <button class="btn-theme btn-black" type="submit">Gửi tin nhắn</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="contact-info">
              <div class="section-title">
                <h3 class="title">Thông tin liên hệ</h3>
                <div class="desc">
                  <p>Liên hệ với chúng tôi qua các thông tin dưới đây</p>
                </div>
              </div>
              <div class="contact-info-items">
                <div class="contact-info-item">
                  <div class="contact-info-icon">
                    <i class="pe-7s-map-marker"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Địa chỉ</h5>
                    <p>123 Đường Nguyễn Huệ<br>Quận 1, TP. Hồ Chí Minh<br>Việt Nam</p>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">
                    <i class="pe-7s-call"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Điện thoại</h5>
                    <p><a href="tel:+84123456789">+84 123 456 789</a></p>
                    <p><a href="tel:+84987654321">+84 987 654 321</a></p>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">
                    <i class="pe-7s-mail"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Email</h5>
                    <p><a href="mailto:info@shoestore.com">info@shoestore.com</a></p>
                    <p><a href="mailto:support@shoestore.com">support@shoestore.com</a></p>
                  </div>
                </div>
                <div class="contact-info-item">
                  <div class="contact-info-icon">
                    <i class="pe-7s-clock"></i>
                  </div>
                  <div class="contact-info-content">
                    <h5>Giờ làm việc</h5>
                    <p>Thứ 2 - Thứ 6: 8:00 - 18:00</p>
                    <p>Thứ 7 - Chủ nhật: 9:00 - 17:00</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Contact Area Wrapper -->

    <!--== Start Contact Map Area ==-->
    <section class="contact-map-area">
      <div class="container-fluid p-0">
        <div class="row g-0">
          <div class="col-12">
            <div class="contact-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4609464144283!2d106.69831431428656!3d10.77625629230208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b5c4e2c3d%3A0x5db4ecbf64958a4!2zTmd1eeG7hW4gSHXhu4MsIEJlbiBOZ2hlLCBRdeG6rW4gMSwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1625745234567!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Contact Map Area ==-->

    <!--== Start Divider Area ==-->
    <section class="divider-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="divider-content" data-aos="fade-right" data-aos-duration="1000">
              <h4 class="sub-title">Cần hỗ trợ ngay?</h4>
              <h2 class="title">Liên hệ hotline 24/7</h2>
              <p class="desc">Đội ngũ chăm sóc khách hàng của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc</p>
              <a class="btn-theme" href="tel:+84123456789">Gọi ngay: +84 123 456 789</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="divider-thumb" data-aos="fade-left" data-aos-duration="1000">
              <img src="{{ asset('img/photos/divider1.webp') }}" width="570" height="350" alt="Support">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Divider Area -->
</main>
@endsection