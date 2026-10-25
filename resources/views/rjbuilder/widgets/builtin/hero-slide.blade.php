@php
    $height = $settings['height'] ?? 'h-[70vh]';
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
    /* Ken Burns Animasiyası (Şəkil yavaş-yavaş yaxınlaşır) */
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }

    #{{ $uid }} .rj-slide {
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease-in-out, visibility 1s ease-in-out;
    }

    #{{ $uid }} .rj-slide.is-active {
        opacity: 1;
        visibility: visible;
        z-index: 10;
    }

    #{{ $uid }} .rj-slide.is-active .rj-slide-bg {
        animation: kenburns 12s ease-out forwards;
    }

    /* Yazıların zərif çıxışı */
    #{{ $uid }} .rj-slide-content {
        opacity: 0;
        transform: translateY(30px);
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
        transition: all 0.4s ease;
    }
    #{{ $uid }} .rj-hero-btn:hover {
        background-color: {{ $btnHoverBg }} !important;
        color: {{ $btnHoverText }} !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Naviqasiya Nöqtələri */
    #{{ $uid }} .rj-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background-color: rgba(255,255,255,0.4);
        transition: all 0.4s ease;
        cursor: pointer;
    }
    #{{ $uid }} .rj-dot.is-active {
        width: 32px;
        background-color: #fff;
    }
</style>

<section id="{{ $uid }}"
         class="relative w-full {{ $height }} max-h-[900px] bg-black overflow-hidden group"
         data-autoplay="{{ $autoplaySpeed }}">

    @foreach ($slides as $index => $slide)
        <div class="rj-slide absolute inset-0 {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
            <!-- Şəkil və Ken Burns -->
            <img src="{{ $slide['image'] }}" class="rj-slide-bg absolute inset-0 w-full h-full object-cover object-center" alt="">

            <!-- Overlay (Qaraltı) -->
            <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>

            <!-- Məzmun -->
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
        <!-- Oxlar (Hover zamanı görünür) -->
        <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            <button class="rj-prev p-3 rounded-full bg-black/20 text-white hover:bg-black/60 backdrop-blur-md transition-all focus:outline-none pointer-events-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="rj-next p-3 rounded-full bg-black/20 text-white hover:bg-black/60 backdrop-blur-md transition-all focus:outline-none pointer-events-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <!-- Nöqtələr -->
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
            slides.forEach(s => s.classList.remove('is-active'));
            dots.forEach(d => d.classList.remove('is-active'));

            activeIndex = (index + slides.length) % slides.length;

            slides[activeIndex].classList.add('is-active');
            if (dots[activeIndex]) dots[activeIndex].classList.add('is-active');

            // Reset Ken Burns animation
            const bg = slides[activeIndex].querySelector('.rj-slide-bg');
            bg.style.animation = 'none';
            bg.offsetHeight; // trigger reflow
            bg.style.animation = null;
        }

        function next() { goTo(activeIndex + 1); }
        function prev() { goTo(activeIndex - 1); }

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

    // Builder üçün dərhal işlədirik, Frontend üçün DOM yüklənəndə
    initSlider_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSlider_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
