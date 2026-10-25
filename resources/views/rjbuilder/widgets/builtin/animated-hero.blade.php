@php
    $height = $settings['height'] ?? 'aspect-[21/9]';
    $transitionDuration = (int)($settings['transition_duration'] ?? 1000);
    $autoplaySpeed = (int)($settings['autoplay_speed'] ?? 5000);
    $imageBlur = (int)($settings['image_blur'] ?? 0);
    $imagePosition = $settings['image_position'] ?? 'center';

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
    #{{ $uid }} {
        position: relative;
        width: 100%;
        overflow: hidden;
        background-color: #000;
    }

    #{{ $uid }} .rj-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity {{ $transitionDuration }}ms ease-in-out;
        z-index: 1;
    }

    #{{ $uid }} .rj-slide.is-active {
        opacity: 1;
        pointer-events: auto;
        z-index: 2;
    }

    /* Şəkil: Blur, Fokus və Rəvan Zoom (Ken Burns) */
    #{{ $uid }} .rj-slide-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: {{ $imagePosition }};
        filter: blur({{ $imageBlur }}px);
        transform: scale(1);
        /* 10 saniyə ərzində çox yavaş böyüyür */
        transition: transform 10s ease-out, opacity {{ $transitionDuration }}ms ease-in-out;
    }

    #{{ $uid }} .rj-slide.is-active .rj-slide-bg {
        transform: scale(1.08);
    }

    /* Yazıların zərif çıxışı */
    #{{ $uid }} .rj-slide-content {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    #{{ $uid }} .rj-slide.is-active .rj-slide-content {
        opacity: 1;
        transform: translateY(0);
    }

    #{{ $uid }} .rj-slide.is-active .rj-slide-content:nth-child(1) { transition-delay: 200ms; }
    #{{ $uid }} .rj-slide.is-active .rj-slide-content:nth-child(2) { transition-delay: 400ms; }
    #{{ $uid }} .rj-slide.is-active .rj-slide-content:nth-child(3) { transition-delay: 600ms; }

    #{{ $uid }} .rj-hero-btn {
        background-color: {{ $btnBg }} !important;
        color: {{ $btnText }} !important;
        transition: all 0.3s ease;
    }
    #{{ $uid }} .rj-hero-btn:hover {
        background-color: {{ $btnHoverBg }} !important;
        color: {{ $btnHoverText }} !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    #{{ $uid }} .rj-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background-color: rgba(255,255,255,0.4);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    #{{ $uid }} .rj-dot.is-active {
        width: 30px;
        background-color: #fff;
    }
</style>

<section id="{{ $uid }}"
         class="w-full {{ $height }} group"
         data-autoplay="{{ $autoplaySpeed }}">

    @foreach ($slides as $index => $slide)
        <div class="rj-slide {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
            <img src="{{ $slide['image'] }}" class="rj-slide-bg" alt="">

            <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>

            <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto space-y-6">
                @if(!empty($slide['title']))
                    <h1 class="rj-slide-content text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight" style="color: {{ $titleColor }};">
                        {{ $slide['title'] }}
                    </h1>
                @endif

                @if(!empty($slide['subtitle']))
                    <p class="rj-slide-content text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed" style="color: {{ $subtitleColor }};">
                        {{ $slide['subtitle'] }}
                    </p>
                @endif

                @if(!empty($slide['btn_text']) && !empty($slide['btn_url']))
                    <div class="rj-slide-content pt-6">
                        <a href="{{ $slide['btn_url'] }}" class="inline-block px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase rj-hero-btn shadow-xl">
                            {{ $slide['btn_text'] }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if(count($slides) > 1)
        <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            <button class="rj-prev p-3 rounded-full bg-black/20 text-white hover:bg-black/60 backdrop-blur-md transition-all focus:outline-none pointer-events-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="rj-next p-3 rounded-full bg-black/20 text-white hover:bg-black/60 backdrop-blur-md transition-all focus:outline-none pointer-events-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-3 z-30">
            @foreach ($slides as $index => $slide)
                <button class="rj-dot {{ $index === 0 ? 'is-active' : '' }}" data-slide-to="{{ $index }}"></button>
            @endforeach
        </div>
    @endif
</section>

<script>
(function() {
    function initSlider_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const slides = root.querySelectorAll('.rj-slide');
        const dots = root.querySelectorAll('.rj-dot');
        const prevBtn = root.querySelector('.rj-prev');
        const nextBtn = root.querySelector('.rj-next');
        const autoplaySpeed = parseInt(root.dataset.autoplay);

        let activeIndex = 0;
        let timer = null;

        if (slides.length <= 1) return;

        function goTo(index) {
            slides.forEach((s, i) => {
                if (i === index) {
                    s.classList.add('is-active');
                } else {
                    s.classList.remove('is-active');
                }
            });

            dots.forEach((d, i) => {
                if (i === index) {
                    d.classList.add('is-active');
                } else {
                    d.classList.remove('is-active');
                }
            });

            activeIndex = index;
        }

        function next() { goTo((activeIndex + 1) % slides.length); }
        function prev() { goTo((activeIndex - 1 + slides.length) % slides.length); }

        if (nextBtn) nextBtn.addEventListener('click', () => { next(); resetTimer(); });
        if (prevBtn) prevBtn.addEventListener('click', () => { prev(); resetTimer(); });

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                goTo(parseInt(dot.dataset.slideTo));
                resetTimer();
            });
        });

        function startTimer() {
            if (autoplaySpeed > 0) {
                timer = setInterval(next, autoplaySpeed);
            }
        }

        function resetTimer() {
            if (timer) clearInterval(timer);
            startTimer();
        }

        root.addEventListener('mouseenter', () => { if (timer) clearInterval(timer); });
        root.addEventListener('mouseleave', startTimer);

        startTimer();
    }

    initSlider_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSlider_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
