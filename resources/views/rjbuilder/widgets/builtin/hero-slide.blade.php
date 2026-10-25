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

    $jsSlides = json_encode($slides);
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
    #{{ $uid }} .rj-slide-content {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-slide-active .rj-slide-content {
        opacity: 1;
        transform: translateY(0);
    }
    #{{ $uid }} .rj-slide-active .rj-slide-content:nth-child(1) { transition-delay: 100ms; }
    #{{ $uid }} .rj-slide-active .rj-slide-content:nth-child(2) { transition-delay: 300ms; }
    #{{ $uid }} .rj-slide-active .rj-slide-content:nth-child(3) { transition-delay: 500ms; }
</style>

<section id="{{ $uid }}"
         class="relative w-full {{ $height }} bg-gray-900 overflow-hidden group"
         data-autoplay="{{ $autoplaySpeed }}"
         data-slides="{{ $jsSlides }}">

    <!-- Slides Container -->
    <div class="rj-slides-container absolute inset-0"></div>

    <!-- Navigation Arrows -->
    <div class="rj-nav-arrows absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
        <button class="rj-prev p-3 rounded-full bg-black/30 text-white hover:bg-black/60 backdrop-blur-sm transition-all focus:outline-none pointer-events-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button class="rj-next p-3 rounded-full bg-black/30 text-white hover:bg-black/60 backdrop-blur-sm transition-all focus:outline-none pointer-events-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <!-- Dots -->
    <div class="rj-dots absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-30"></div>
</section>

<script>
(function() {
    function initHeroSlider() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const slidesData = JSON.parse(root.dataset.slides);
        const autoplaySpeed = parseInt(root.dataset.autoplay);
        const container = root.querySelector('.rj-slides-container');
        const dotsContainer = root.querySelector('.rj-dots');
        const prevBtn = root.querySelector('.rj-prev');
        const nextBtn = root.querySelector('.rj-next');
        const navArrows = root.querySelector('.rj-nav-arrows');

        let activeIndex = 0;
        let timer = null;

        if (slidesData.length === 0) return;

        // Render slides
        slidesData.forEach((slide, index) => {
            const slideEl = document.createElement('div');
            slideEl.className = `absolute inset-0 transition-opacity duration-1000 ease-in-out ${index === 0 ? 'rj-slide-active opacity-100 z-10' : 'opacity-0 z-0'}`;

            slideEl.innerHTML = `
                <img src="${slide.image}" class="absolute inset-0 w-full h-full object-cover object-center" alt="">
                <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>
                <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto space-y-6">
                    ${slide.title ? `<h1 class="rj-slide-content text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight" style="color: {{ $titleColor }};">${slide.title}</h1>` : ''}
                    ${slide.subtitle ? `<p class="rj-slide-content text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed" style="color: {{ $subtitleColor }};">${slide.subtitle}</p>` : ''}
                    ${slide.btn_text && slide.btn_url ? `<div class="rj-slide-content pt-6"><a href="${slide.btn_url}" class="inline-block px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase rj-hero-btn shadow-xl">${slide.btn_text}</a></div>` : ''}
                </div>
            `;
            container.appendChild(slideEl);
        });

        const slides = Array.from(container.children);

        // Render dots
        if (slides.length > 1) {
            slidesData.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `w-3 h-3 rounded-full transition-all duration-300 focus:outline-none ${index === 0 ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'}`;
                dot.addEventListener('click', () => goToSlide(index));
                dotsContainer.appendChild(dot);
            });
        } else {
            navArrows.style.display = 'none';
        }

        const dots = Array.from(dotsContainer.children);

        function updateUI() {
            slides.forEach((slide, i) => {
                if (i === activeIndex) {
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('rj-slide-active', 'opacity-100', 'z-10');
                } else {
                    slide.classList.remove('rj-slide-active', 'opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });

            dots.forEach((dot, i) => {
                if (i === activeIndex) {
                    dot.classList.remove('bg-white/40', 'hover:bg-white/70');
                    dot.classList.add('bg-white', 'scale-125');
                } else {
                    dot.classList.remove('bg-white', 'scale-125');
                    dot.classList.add('bg-white/40', 'hover:bg-white/70');
                }
            });
        }

        function goToSlide(index) {
            activeIndex = index;
            updateUI();
            resetTimer();
        }

        function nextSlide() {
            activeIndex = (activeIndex + 1) % slides.length;
            updateUI();
        }

        function prevSlide() {
            activeIndex = (activeIndex - 1 + slides.length) % slides.length;
            updateUI();
        }

        function startTimer() {
            if (autoplaySpeed > 0 && slides.length > 1) {
                timer = setInterval(nextSlide, autoplaySpeed);
            }
        }

        function resetTimer() {
            if (timer) clearInterval(timer);
            startTimer();
        }

        nextBtn.addEventListener('click', () => { nextSlide(); resetTimer(); });
        prevBtn.addEventListener('click', () => { prevSlide(); resetTimer(); });

        root.addEventListener('mouseenter', () => { if (timer) clearInterval(timer); });
        root.addEventListener('mouseleave', startTimer);

        startTimer();
    }

    // Run immediately for the builder canvas
    initHeroSlider();

    // Also run on DOMContentLoaded for the live frontend
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroSlider);
    }
})();
</script>
