// Brand Slider Initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Brand Logo Slider
    const brandSlider = new Swiper('.brand-logo-slider-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.brand-area .swiper-btn-next',
            prevEl: '.brand-area .swiper-btn-prev',
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            }
        }
    });
});