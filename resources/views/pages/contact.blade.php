@extends('layouts.frontend')

@section('title', 'Liên hệ - Cửa hàng giày')

@section('content')
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Trang chủ', 'url' => route('home'), 'icon' => 'home'],
        ['label' => 'Liên hệ', 'icon' => 'envelope', 'active' => true]
    ]" />

    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ config('app.page_header_image') }}">
      <div class="container pt--0 pb--0">
        <div class="row">
          <div class="col-12">
            <div class="page-header-content">
              <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Liên hệ</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Contact Area Wrapper ==-->
    <section class="contact-area contact-page-area">
      <div class="container">
        <div class="row contact-page-wrapper">
          <div class="col-xl-9">
            <div class="contact-form-wrap" data-aos="fade-right">
              <div class="contact-form-title">
                <h2 class="title">Chúng tôi luôn sẵn sàng lắng nghe! <br>Hãy gửi câu hỏi cho chúng tôi</h2>
              </div>
              <!--== Start Contact Form ==-->
              <div class="contact-form">
                <form id="contact-form" action="{{ route('contact.send') }}" method="POST">
                  @csrf
                  <div class="row row-gutter-20">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input class="form-control" type="text" name="con_name" placeholder="Họ và tên *" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input class="form-control" type="email" name="con_email" placeholder="Email *" required>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <input class="form-control" type="text" name="con_subject" placeholder="Tiêu đề (Tùy chọn)">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group mb--0">
                        <textarea class="form-control" name="con_message" placeholder="Nội dung tin nhắn" rows="5" required></textarea>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group mb--0">
                        <button class="btn-theme" type="submit" id="submit-btn">
                          <span class="btn-text">Gửi tin nhắn</span>
                          <span class="btn-loading" style="display: none;">Đang gửi...</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!--== End Contact Form ==-->

              <!--== Message Notification ==-->
              <div class="form-message"></div>
              <div class="shape-group-style2">
                <div class="shape-group-one"><img src="{{ asset('img/shape/13.webp') }}" width="193" height="168" alt="Image-HasTech"></div>
                <div class="shape-group-two"><img src="{{ asset('img/shape/15.webp') }}" width="221" height="113" alt="Image-HasTech"></div>
                <div class="shape-group-three"><img src="{{ asset('img/shape/16.webp') }}" width="129" height="147" alt="Image-HasTech"></div>
                <div class="shape-group-four"><img src="{{ asset('img/shape/17.webp') }}" width="493" height="340" alt="Image-HasTech"></div>
              </div>
            </div>
          </div>
          <div class="col-xl-3">
            <div class="contact-info-wrap">
              <div class="contact-info">
                <div class="row">
                  <div class="col-lg-4 col-xl-12">
                    <div class="info-item" data-aos="fade-left">
                      <div class="icon">
                        <img src="{{ asset('img/icons/c1.webp') }}" width="69" height="65" alt="Image-HasTech">
                      </div>
                      <div class="info">
                        <h5 class="title">Địa chỉ</h5>
                        <p>Địa chỉ cửa hàng của bạn. 123 Vị trí của bạn</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-xl-12">
                    <div class="info-item" data-aos="fade-left" data-aos-delay="60">
                      <div class="icon">
                        <img src="{{ asset('img/icons/c2.webp') }}" width="65" height="65" alt="Image-HasTech">
                      </div>
                      <div class="info">
                        <h5 class="title">Số điện thoại</h5>
                        <p>
                          <a href="tel://+00123456789">+00123456789</a><br>
                          <a href="tel://+00123456789">+00123456789</a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-xl-12">
                    <div class="info-item" data-aos="fade-left" data-aos-delay="120">
                      <div class="icon">
                        <img src="{{ asset('img/icons/c3.webp') }}" width="65" height="65" alt="Image-HasTech">
                      </div>
                      <div class="info">
                        <h5 class="title">Email / Website</h5>
                        <p>
                          <a href="mailto://demo@example.com">demo@example.com</a><br>
                          <a href="mailto://www.example.com">www.example.com</a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Contact Area Wrapper ==-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let isSubmitting = false; // Flag để prevent double submit

    $('#contact-form').on('submit', function(e) {
        e.preventDefault();

        // Prevent double submit
        if (isSubmitting) {
            console.log('Form is already submitting, ignoring...');
            return false;
        }

        isSubmitting = true;

        const form = $(this);
        const submitBtn = $('#submit-btn');
        const btnText = submitBtn.find('.btn-text');
        const btnLoading = submitBtn.find('.btn-loading');
        const messageContainer = $('.form-message');

        // Disable button and show loading
        submitBtn.prop('disabled', true);
        btnText.hide();
        btnLoading.show();

        // Clear previous messages
        messageContainer.removeClass('success error').html('');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    messageContainer
                        .addClass('success')
                        .html('<div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-top: 20px;"><strong>Thành công!</strong> ' + response.message + '</div>')
                        .show();

                    // Reset form
                    form[0].reset();

                    // Refresh CSRF token
                    $.get('/csrf-token', function(data) {
                        $('input[name="_token"]').val(data.token);
                    });

                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: messageContainer.offset().top - 100
                    }, 500);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.';

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    const errorList = Object.values(errors).flat();
                    errorMessage = errorList.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                messageContainer
                    .addClass('error')
                    .html('<div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-top: 20px;"><strong>Lỗi!</strong> ' + errorMessage + '</div>')
                    .show();

                // Scroll to message
                $('html, body').animate({
                    scrollTop: messageContainer.offset().top - 100
                }, 500);
            },
            complete: function() {
                // Re-enable button and hide loading
                submitBtn.prop('disabled', false);
                btnText.show();
                btnLoading.hide();

                // Reset submitting flag
                isSubmitting = false;
                console.log('Form submission completed, ready for next submit');
            }
        });
    });
});
</script>
@endpush
