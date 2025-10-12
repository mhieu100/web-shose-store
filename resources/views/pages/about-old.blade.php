@extends('layouts.frontend')

@section('title', 'Về chúng tôi - Shoe Store')
@section('description', 'Tìm hiểu về cửa hàng giày uy tín với nhiều năm kinh nghiệm')

@section('content')
<main class="main-content">
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg1.webp') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Về chúng tôi</h2>
              <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                <ul class="breadcrumb">
                  <li><a href="{{ route('home') }}">Trang chủ</a></li>
                  <li class="breadcrumb-sep">//</li>
                  <li>Về chúng tôi</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start About Area Wrapper ==-->
    <section class="about-area about-default-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="about-content">
              <div class="section-title">
                <h2 class="title">Chúng tôi đam mê thời trang giày dép</h2>
                <div class="desc">
                  <p>Shoe Store được thành lập với sứ mệnh mang đến cho khách hàng những đôi giày chất lượng cao, phong cách thời trang và giá cả hợp lý.</p>
                  <p>Với nhiều năm kinh nghiệm trong ngành, chúng tôi cam kết cung cấp sản phẩm chính hãng, dịch vụ tận tâm và trải nghiệm mua sắm tuyệt vời nhất cho khách hàng.</p>
                </div>
              </div>
              <div class="about-btn-wrap">
                <a class="btn-theme btn-white" href="{{ route('contact') }}">Liên hệ với chúng tôi</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="about-thumb" data-aos="fade-left" data-aos-duration="1000">
              <img src="{{ asset('img/about/1.webp') }}" width="570" height="350" alt="Về chúng tôi">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End About Area Wrapper ==-->

    <!--== Start Feature Area Wrapper ==-->
    <section class="feature-area feature-about-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Tại sao chọn chúng tôi?</h3>
              <div class="desc">
                <p>Chúng tôi luôn đặt khách hàng làm trung tâm và cam kết mang đến trải nghiệm tốt nhất</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <!--== Start Feature Item ==-->
            <div class="feature-item" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/1.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Chất lượng cao</h4>
                <p class="desc">Tất cả sản phẩm đều được tuyển chọn kỹ lưỡng, đảm bảo chất lượng tốt nhất</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
          <div class="col-md-6 col-lg-4">
            <!--== Start Feature Item ==-->
            <div class="feature-item" data-aos="fade-up" data-aos-duration="1200">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/2.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Giá cả hợp lý</h4>
                <p class="desc">Chúng tôi cam kết mang đến mức giá tốt nhất trên thị trường</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
          <div class="col-md-6 col-lg-4">
            <!--== Start Feature Item ==-->
            <div class="feature-item" data-aos="fade-up" data-aos-duration="1400">
              <div class="feature-icon">
                <img src="{{ asset('img/icons/3.webp') }}" width="65" height="65" alt="Icon">
              </div>
              <div class="feature-content">
                <h4 class="title">Dịch vụ tận tâm</h4>
                <p class="desc">Đội ngũ nhân viên được đào tạo chuyên nghiệp, luôn sẵn sàng hỗ trợ</p>
              </div>
            </div>
            <!--== End Feature Item ==-->
          </div>
        </div>
      </div>
    </section>
    <!--== End Feature Area Wrapper ==-->

    <!--== Start Team Area Wrapper ==-->
    <section class="team-area team-default-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h3 class="title">Đội ngũ của chúng tôi</h3>
              <div class="desc">
                <p>Những con người tài năng và nhiệt huyết đằng sau thành công của Shoe Store</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @for($i = 1; $i <= 4; $i++)
          <div class="col-sm-6 col-lg-3">
            <!--== Start Team Item ==-->
            <div class="team-item" data-aos="fade-up" data-aos-duration="{{ 1000 + ($i * 200) }}">
              <div class="team-thumb">
                <img src="{{ asset('img/team/' . $i . '.webp') }}" width="270" height="274" alt="Team {{ $i }}">
              </div>
              <div class="team-content">
                <h4 class="name">{{ ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Thị D'][$i-1] }}</h4>
                <h5 class="designation">{{ ['Giám đốc', 'Trưởng phòng kinh doanh', 'Chuyên viên tư vấn', 'Nhân viên bán hàng'][$i-1] }}</h5>
                <div class="team-social-icons">
                  <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                  <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                  <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                </div>
              </div>
            </div>
            <!--== End Team Item ==-->
          </div>
          @endfor
        </div>
      </div>
    </section>
    <!--== End Team Area Wrapper ==-->
</main>
@endsection