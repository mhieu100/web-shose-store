@props(['banners' => []])

@if($banners->count() > 0)
<div class="banner-slider" x-data="bannerSlider()" x-init="init()">
    <div class="relative overflow-hidden rounded-lg">
        <div class="flex transition-transform duration-300 ease-in-out" 
             x-bind:style="`transform: translateX(-${currentSlide * 100}%)`">
            @foreach($banners as $banner)
            <div class="w-full flex-none relative">
                <img src="{{ $banner->image_url }}" 
                     alt="{{ $banner->title }}"
                     class="w-full h-64 md:h-96 object-cover">
                
                <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent">
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $banner->title }}</h3>
                        @if($banner->description)
                        <p class="text-lg mb-4 opacity-90">{{ $banner->description }}</p>
                        @endif
                        @if($banner->link_url)
                        <a href="{{ $banner->link_url }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Xem thêm
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($banners->count() > 1)
        <!-- Navigation arrows -->
        <button @click="previousSlide()" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        
        <button @click="nextSlide()" 
                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Dots indicator -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($banners as $index => $banner)
            <button @click="goToSlide({{ $index }})" 
                    class="w-3 h-3 rounded-full transition-colors"
                    x-bind:class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50'">
            </button>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
function bannerSlider() {
    return {
        currentSlide: 0,
        totalSlides: {{ $banners->count() }},
        autoPlayInterval: null,

        init() {
            if (this.totalSlides > 1) {
                this.startAutoPlay();
            }
        },

        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },

        previousSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },

        goToSlide(index) {
            this.currentSlide = index;
        },

        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, 5000); // Change slide every 5 seconds
        },

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
            }
        }
    }
}
</script>
@endif