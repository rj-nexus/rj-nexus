@php
    $total = count($slides);
    $multi = $total > 1;
    $alignItems = ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'][$o['text_align']];
    $justify = $o['content_valign'] === 'bottom' ? 'flex-end' : 'center';
    $bleed = $o['image_blur'] * 3;
    $overlayBg = $o['overlay_style'] === 'gradient'
        ? 'linear-gradient(to top, ' . $o['overlay_color'] . ' 0%, ' . $o['overlay_color'] . ' 35%, transparent 100%)'
        : $o['overlay_color'];
    $pad = fn ($n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
@endphp

<style>
    #{{ $uid }} { position: relative; width: 100%; overflow: hidden; background: #000; isolation: isolate; {{ $o['height_css'] }} --rj-d: {{ $o['transition'] }}ms; --rj-ap: {{ $o['autoplay'] }}ms; --rj-kb: {{ $o['kb_ms'] }}ms; --dir: 1; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}:focus-visible { outline: 2px solid #fff; outline-offset: -4px; }

    /* Slide qatları */
    #{{ $uid }} .rj-slide { position: absolute; inset: 0; z-index: 0; visibility: hidden; overflow: hidden; background: #000; }
    #{{ $uid }} .rj-slide.is-leaving { visibility: visible; z-index: 1; }
    #{{ $uid }} .rj-slide.is-active { visibility: visible; z-index: 2; }

    /* Fade effekti */
    #{{ $uid }}[data-effect="fade"] .rj-slide { opacity: 0; }
    #{{ $uid }}[data-effect="fade"] .rj-slide.is-leaving { opacity: 1; }
    #{{ $uid }}[data-effect="fade"] .rj-slide.is-active { opacity: 1; transition: opacity var(--rj-d) ease-in-out; }

    /* Slide effekti */
    #{{ $uid }}[data-effect="slide"] .rj-slide { transform: translate3d(calc(var(--dir) * 100%), 0, 0); }
    #{{ $uid }}[data-effect="slide"] .rj-slide.is-leaving { transform: translate3d(calc(var(--dir) * -100%), 0, 0); transition: transform var(--rj-d) cubic-bezier(.65, 0, .35, 1); }
    #{{ $uid }}[data-effect="slide"] .rj-slide.is-active { transform: none; transition: transform var(--rj-d) cubic-bezier(.65, 0, .35, 1); }

    /* Şəkil */
    #{{ $uid }} .rj-bg { position: absolute; top: -{{ $bleed }}px; left: -{{ $bleed }}px; width: calc(100% + {{ $bleed * 2 }}px); height: calc(100% + {{ $bleed * 2 }}px); max-width: none; object-fit: cover; object-position: {{ $o['image_position'] }}; filter: blur({{ $o['image_blur'] }}px); display: block; will-change: transform; }
    #{{ $uid }}[data-kb="1"] .rj-slide.is-active .rj-bg,
    #{{ $uid }}[data-kb="1"] .rj-slide.is-leaving .rj-bg { animation: rj-hero-kb var(--rj-kb) linear forwards; }
    @keyframes rj-hero-kb {
        from { transform: scale(1) translate3d(0, 0, 0); }
        to { transform: scale(1.12) translate3d(var(--kx, 0), var(--ky, 0), 0); }
    }

    /* Overlay */
    #{{ $uid }} .rj-overlay { position: absolute; inset: 0; background: {{ $overlayBg }}; opacity: {{ $o['overlay_opacity'] }}; pointer-events: none; }

    /* Kontent */
    #{{ $uid }} .rj-content { position: relative; z-index: 3; width: 100%; max-width: 1100px; height: 100%; margin: 0 auto; padding: 56px 24px 88px; display: flex; flex-direction: column; justify-content: {{ $justify }}; align-items: {{ $alignItems }}; text-align: {{ $o['text_align'] }}; gap: 20px; }
    #{{ $uid }} .rj-title { margin: 0; padding: 0; font-size: clamp(2rem, 5.5vw, 4.5rem); font-weight: 800; line-height: 1.1; letter-spacing: -0.02em; color: {{ $o['title_color'] }}; text-shadow: 0 2px 24px rgba(0, 0, 0, .25); }
    #{{ $uid }} .rj-subtitle { margin: 0; max-width: 46rem; font-size: clamp(1rem, 1.8vw, 1.5rem); line-height: 1.6; color: {{ $o['subtitle_color'] }}; text-shadow: 0 1px 12px rgba(0, 0, 0, .25); }
    #{{ $uid }} .rj-btn-wrap { padding-top: 12px; }
    #{{ $uid }} .rj-btn { display: inline-block; padding: 16px 40px; border-radius: 12px; font-size: .85rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; text-decoration: none !important; background-color: {{ $o['btn_bg'] }} !important; color: {{ $o['btn_text'] }} !important; box-shadow: 0 10px 25px rgba(0, 0, 0, .25); transition: background-color .3s ease, color .3s ease, transform .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rj-btn:hover, #{{ $uid }} .rj-btn:focus-visible { background-color: {{ $o['btn_hover_bg'] }} !important; color: {{ $o['btn_hover_text'] }} !important; transform: translateY(-2px); box-shadow: 0 14px 28px rgba(0, 0, 0, .3); }

    /* Mətn animasiyası */
    #{{ $uid }} .rj-in { opacity: 0; }
    #{{ $uid }} .rj-slide.is-active .rj-in,
    #{{ $uid }} .rj-slide.is-leaving .rj-in { animation: rj-hero-rise .9s cubic-bezier(.2, .8, .2, 1) both; animation-delay: calc(var(--i, 0) * 150ms + 250ms); }
    @keyframes rj-hero-rise {
        from { opacity: 0; transform: translate3d(0, 26px, 0); }
        to { opacity: 1; transform: none; }
    }

    /* Oxlar */
    #{{ $uid }} .rj-nav { position: absolute; top: 50%; z-index: 10; width: 48px; height: 48px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .25); border-radius: 999px; background: rgba(0, 0, 0, .25); color: #fff; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); cursor: pointer; opacity: 0; transform: translateY(-50%); transition: opacity .3s ease, background .3s ease, transform .3s ease; }
    #{{ $uid }} .rj-prev { left: 16px; }
    #{{ $uid }} .rj-next { right: 16px; }
    #{{ $uid }}:hover .rj-nav, #{{ $uid }}:focus-within .rj-nav { opacity: 1; }
    #{{ $uid }} .rj-nav:hover { background: rgba(0, 0, 0, .6); transform: translateY(-50%) scale(1.08); }
    #{{ $uid }} .rj-nav svg { width: 24px; height: 24px; }
    @media (hover: none) { #{{ $uid }} .rj-nav { opacity: .85; } }

    /* Nöqtələr */
    #{{ $uid }} .rj-dots { position: absolute; left: 0; right: 0; bottom: 26px; z-index: 10; display: flex; justify-content: center; gap: 12px; }
    #{{ $uid }} .rj-dot { width: 10px; height: 10px; margin: 0; padding: 0; border: 0; border-radius: 999px; background: rgba(255, 255, 255, .4); cursor: pointer; transition: width .3s ease, background-color .3s ease; }
    #{{ $uid }} .rj-dot:hover { background: rgba(255, 255, 255, .75); }
    #{{ $uid }} .rj-dot.is-active { width: 30px; background: #fff; }

    /* Progress */
    #{{ $uid }} .rj-progress { position: absolute; left: 0; right: 0; bottom: 0; z-index: 10; height: 3px; background: rgba(255, 255, 255, .15); }
    #{{ $uid }}[data-progress="0"] .rj-progress { opacity: 0; }
    #{{ $uid }} .rj-progress-bar { width: 100%; height: 100%; background: #fff; transform: scaleX(0); transform-origin: left center; }
    #{{ $uid }} .rj-progress-bar.is-running { animation: rj-hero-progress var(--rj-ap) linear forwards; }
    #{{ $uid }}.is-paused .rj-progress-bar { animation-play-state: paused; }
    @keyframes rj-hero-progress { to { transform: scaleX(1); } }

    /* Say + pause */
    #{{ $uid }} .rj-counter { position: absolute; right: 24px; bottom: 20px; z-index: 10; color: #fff; font-size: .85rem; letter-spacing: .15em; font-variant-numeric: tabular-nums; opacity: .85; }
    #{{ $uid }} .rj-toggle { position: absolute; left: 24px; bottom: 16px; z-index: 10; width: 34px; height: 34px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .3); border-radius: 999px; background: rgba(0, 0, 0, .25); color: #fff; cursor: pointer; transition: background .3s ease; }
    #{{ $uid }} .rj-toggle:hover { background: rgba(0, 0, 0, .6); }
    #{{ $uid }} .rj-toggle svg { width: 14px; height: 14px; }
    #{{ $uid }} .rj-toggle .i-play { display: none; }
    #{{ $uid }}.is-user-paused .rj-toggle .i-play { display: block; }
    #{{ $uid }}.is-user-paused .rj-toggle .i-pause { display: none; }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-nav { width: 40px; height: 40px; }
        #{{ $uid }} .rj-prev { left: 8px; }
        #{{ $uid }} .rj-next { right: 8px; }
        #{{ $uid }} .rj-content { padding: 40px 20px 80px; }
        #{{ $uid }} .rj-btn { padding: 14px 28px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-bg { animation: none !important; }
        #{{ $uid }} .rj-in { animation-duration: .01ms !important; animation-delay: 0ms !important; }
    }
</style>

<section id="{{ $uid }}"
         data-effect="{{ $o['effect'] }}"
         data-kb="{{ $o['kenburns'] ? 1 : 0 }}"
         data-progress="{{ $o['show_progress'] ? 1 : 0 }}"
         role="region"
         aria-roledescription="carousel"
         aria-label="{{ __('Hero Slider') }}"
         @if($multi) tabindex="0" @endif>

    @foreach ($slides as $index => $slide)
        @php $n = 0; $isFirst = $index === 0; @endphp
        <div class="rj-slide {{ $isFirst ? 'is-active' : '' }}"
             role="group"
             aria-roledescription="slide"
             aria-label="{{ $index + 1 }} / {{ $total }}"
             @if(!$isFirst) aria-hidden="true" @endif
             style="--kx: {{ $index % 2 ? '-1.6%' : '1.6%' }}; --ky: {{ $index % 2 ? '1.2%' : '-1.2%' }};">

            <img class="rj-bg" src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" decoding="async" @if($isFirst) fetchpriority="high" @endif>
            <div class="rj-overlay"></div>

            <div class="rj-content">
                @if ($slide['title'] !== '')
                    <h2 class="rj-title rj-in" style="--i: {{ $n++ }};">{{ $slide['title'] }}</h2>
                @endif

                @if ($slide['subtitle'] !== '')
                    <p class="rj-subtitle rj-in" style="--i: {{ $n++ }};">{!! nl2br(e($slide['subtitle'])) !!}</p>
                @endif

                @if ($slide['btn_text'] !== '' && $slide['btn_url'] !== '')
                    <div class="rj-btn-wrap rj-in" style="--i: {{ $n++ }};">
                        <a href="{{ $slide['btn_url'] }}" class="rj-btn" @if($o['btn_new_tab']) target="_blank" rel="noopener noreferrer" @endif>{{ $slide['btn_text'] }}</a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if ($multi)
        @if ($o['show_arrows'])
            <button type="button" class="rj-nav rj-prev" aria-label="{{ __('Previous slide') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button type="button" class="rj-nav rj-next" aria-label="{{ __('Next slide') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        @endif

        @if ($o['show_dots'])
            <div class="rj-dots">
                @foreach ($slides as $index => $slide)
                    <button type="button" class="rj-dot {{ $index === 0 ? 'is-active' : '' }}" aria-label="{{ __('Go to slide') }} {{ $index + 1 }}" @if($index === 0) aria-current="true" @endif></button>
                @endforeach
            </div>
        @endif

        @if ($o['show_counter'])
            <div class="rj-counter" aria-hidden="true"><span class="rj-counter-cur">{{ $pad(1) }}</span> / {{ $pad($total) }}</div>
        @endif

        @if ($o['autoplay'] > 0)
            <button type="button" class="rj-toggle" aria-label="{{ __('Pause / play autoplay') }}">
                <svg class="i-pause" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
                <svg class="i-play" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4l13 8-13 8z"/></svg>
            </button>
            <div class="rj-progress"><div class="rj-progress-bar"></div></div>
        @endif
    @endif
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var slides = Array.prototype.slice.call(root.querySelectorAll('.rj-slide'));
    if (slides.length < 2) { return; }

    var duration = {{ $o['transition'] }};
    var autoplay = {{ $o['autoplay'] }};
    var pauseOnHover = {{ $o['pause_on_hover'] ? 'true' : 'false' }};

    var dots = Array.prototype.slice.call(root.querySelectorAll('.rj-dot'));
    var bar = root.querySelector('.rj-progress-bar');
    var counter = root.querySelector('.rj-counter-cur');
    var toggle = root.querySelector('.rj-toggle');
    var prevBtn = root.querySelector('.rj-prev');
    var nextBtn = root.querySelector('.rj-next');

    var current = 0;
    var locked = false;
    var reasons = { hover: false, hidden: false, offscreen: false, user: false };
    var io = null;

    function syncPause() {
        var paused = reasons.hover || reasons.hidden || reasons.offscreen || reasons.user;
        root.classList.toggle('is-paused', paused);
    }

    function restartProgress() {
        if (!bar || !autoplay) { return; }
        bar.classList.remove('is-running');
        void bar.offsetWidth;
        bar.classList.add('is-running');
    }

    function updateUi(index) {
        dots.forEach(function (d, i) {
            d.classList.toggle('is-active', i === index);
            if (i === index) { d.setAttribute('aria-current', 'true'); } else { d.removeAttribute('aria-current'); }
        });
        if (counter) { counter.textContent = String(index + 1).padStart(2, '0'); }
    }

    function goTo(target, dir) {
        target = (target + slides.length) % slides.length;
        if (target === current || locked) { return false; }

        dir = dir || (target > current ? 1 : -1);
        locked = true;

        var from = slides[current];
        var to = slides[target];

        // Slide effekti üçün gələn slaydı başlanğıc mövqeyinə qoy
        root.style.setProperty('--dir', dir);
        void root.offsetWidth;

        from.classList.remove('is-active');
        from.classList.add('is-leaving');
        from.setAttribute('aria-hidden', 'true');

        to.classList.add('is-active');
        to.removeAttribute('aria-hidden');

        current = target;
        updateUi(current);
        restartProgress();

        setTimeout(function () {
            from.classList.remove('is-leaving');
            locked = false;
        }, duration + 60);

        return true;
    }

    function next() { return goTo(current + 1, 1); }
    function prev() { return goTo(current - 1, -1); }

    if (nextBtn) { nextBtn.addEventListener('click', next); }
    if (prevBtn) { prevBtn.addEventListener('click', prev); }
    dots.forEach(function (d, i) { d.addEventListener('click', function () { goTo(i); }); });

    // Autoplay: progress bar bitəndə növbəti slayd
    if (bar && autoplay) {
        bar.addEventListener('animationend', function () {
            if (!next()) { restartProgress(); }
        });
    }

    // Pause / play düyməsi
    if (toggle) {
        toggle.addEventListener('click', function () {
            reasons.user = !reasons.user;
            root.classList.toggle('is-user-paused', reasons.user);
            syncPause();
        });
    }

    // Mouse hover (touch cihazlarda ilişib qalmasın deyə yalnız mouse)
    if (pauseOnHover) {
        root.addEventListener('pointerenter', function (e) {
            if (e.pointerType === 'mouse') { reasons.hover = true; syncPause(); }
        });
        root.addEventListener('pointerleave', function () { reasons.hover = false; syncPause(); });
    }

    // Klaviatura
    root.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') { next(); }
        if (e.key === 'ArrowLeft') { prev(); }
    });

    // Swipe
    var sx = 0, sy = 0;
    root.addEventListener('touchstart', function (e) {
        sx = e.touches[0].clientX;
        sy = e.touches[0].clientY;
    }, { passive: true });
    root.addEventListener('touchend', function (e) {
        var dx = e.changedTouches[0].clientX - sx;
        var dy = e.changedTouches[0].clientY - sy;
        if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5) {
            if (dx < 0) { next(); } else { prev(); }
        }
    }, { passive: true });

    // Tab gizlənəndə / ekrandan çıxanda dayandır
    function onVisibility() {
        if (!root.isConnected) {
            document.removeEventListener('visibilitychange', onVisibility);
            if (io) { io.disconnect(); }
            return;
        }
        reasons.hidden = document.hidden;
        syncPause();
    }
    document.addEventListener('visibilitychange', onVisibility);

    if ('IntersectionObserver' in window) {
        io = new IntersectionObserver(function (entries) {
            reasons.offscreen = !entries[0].isIntersecting;
            syncPause();
        }, { threshold: 0.25 });
        io.observe(root);
    }

    updateUi(0);
    restartProgress();
})();
</script>
