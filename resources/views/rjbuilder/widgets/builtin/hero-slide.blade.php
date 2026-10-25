@php
    $height = $settings['height'] ?? 'min-h-[70vh]';
    $autoplaySpeed = (int)($settings['autoplay_speed'] ?? 5000);

    $overlayColor = $settings['overlay_color'] ?? '#000000';
    $overlayOpacity = ($settings['overlay_opacity'] ?? 40) / 100;

    $titleColor = $settings['title_color'] ?? '#ffffff';
    $subtitleColor = $settings['subtitle_color'] ?? '#f3f4f6';

    $btnBg = $settings['btn_bg'] ?? '#111827';
    $btnText = $settings['btn_text_color'] ?? '#ffffff';
    $btnHoverBg = $settings['btn_hover_bg'] ?? '#374151';
    $btnHoverText = $settings['btn_hover_text_color'] ?? '#ffffff';
@endphp

<style>
    #{{ $uid }} .rj-hero-btn {
        background-color: {{ $btnBg }} !important;
        color: {{ $btnText }} !important;
        transition: all 0.3s ease;
    }
    #{{ $uid }} .rj-hero-btn:hover {
        background-color: {{ $btnHoverBg }} !important;
        color: {{ $btnHoverText }} !important;
    }
</style>

<section id="{{ $uid }}"
         class="relative w-full {{ $height }} bg-gray-900 overflow-hidden group"
         x-data="{
            activeSlide: 0,
            slidesCount: {{ count($slides) }},
            timer: null,
            autoplaySpeed: {{ $autoplaySpeed }},
            startAutoplay() {
                if (this.autoplaySpeed > 0 && this.slidesCount > 1) {
                    this.timer = setInterval(() => { this.next() }, this.autoplaySpeed);
                }
            },
            stopAutoplay() {
                if (this.timer) clearInterval(this.timer);
            },
            next() {
                this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
            },
            prev() {
                this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount;
            },
            goTo(index) {
                this.activeSlide = index;
                this.stopAutoplay();
                this.startAutoplay();
            }
         }"
         x-init="startAutoplay()"
         @mouseenter="stopAutoplay()"
         @mouseleave="startAutoplay()">

    <!-- Slides -->
    <template x-for="(slide, index) in {{ json_encode($slides) }}" :key="index">
        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
             :class="activeSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">

            <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover object-center" alt="">

            <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>

            <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto space-y-6">
                <h1 x-show="slide.title" x-text="slide.title"
                    x-transition:enter="transition ease-out duration-700 delay-100"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight"
                    style="color: {{ $titleColor }};"></h1>

                <p x-show="slide.subtitle" x-text="slide.subtitle"
                   x-transition:enter="transition ease-out duration-700 delay-300"
                   x-transition:enter-start="opacity-0 translate-y-8"
                   x-transition:enter-end="opacity-100 translate-y-0"
                   class="text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed"
                   style="color: {{ $subtitleColor }};"></p>

                <div x-show="slide.btn_text && slide.btn_url"
                     x-transition:enter="transition ease-out duration-700 delay-500"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pt-6">
                    <a :href="slide.btn_url" class="inline-block px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase rj-hero-btn shadow-xl" x-text="slide.btn_text"></a>
                </div>
            </div>
        </div>
    </template>

    <!-- Navigation Arrows -->
    <div x-show="slidesCount > 1" class="absolute inset-y-0 left-0 flex items-center pl-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button @click="prev()" class="p-3 rounded-full bg-black/30 text-white hover:bg-black/60 backdrop-blur-sm transition-all focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
    </div>

    <div x-show="slidesCount > 1" class="absolute inset-y-0 right-0 flex items-center pr-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button @click="next()" class="p-3 rounded-full bg-black/30 text-white hover:bg-black/60 backdrop-blur-sm transition-all focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <!-- Dots -->
    <div x-show="slidesCount > 1" class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-30">
        <template x-for="i in slidesCount" :key="i">
            <button @click="goTo(i - 1)"
                    class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none"
                    :class="activeSlide === (i - 1) ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'">
            </button>
        </template>
    </div>
</section>
