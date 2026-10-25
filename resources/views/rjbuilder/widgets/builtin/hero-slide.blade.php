@php
    $total = count($slides);
    $multi = $total > 1;
    $bleed = $o['image_blur'] * 3;
    $c = $o['overlay_color'];
    $pad = fn ($n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
    $arrows = $multi && $o['show_arrows'];
@endphp

<style>
    #{{ $uid }} { position: relative; width: 100%; overflow: hidden; background: #000; isolation: isolate; {{ $o['height_css'] }} --rjhs-d: {{ $o['transition'] }}ms; --rjhs-ap: {{ $o['autoplay'] }}ms; --rjhs-kb: {{ $o['kb_ms'] }}ms; --rjhs-accent: {{ $o['accent'] }}; --dir: 1; --px: 0px; --py: 0px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}:focus-visible { outline: 2px solid #fff; outline-offset: -4px; }

    /* ---------- Slide layers ---------- */
    #{{ $uid }} .rjhs-slide { position: absolute; inset: 0; z-index: 0; visibility: hidden; overflow: hidden; background: #000; }
    #{{ $uid }} .rjhs-slide.rjhs-leaving { visibility: visible; z-index: 1; }
    #{{ $uid }} .rjhs-slide.rjhs-on { visibility: visible; z-index: 2; }

    /* Fade */
    #{{ $uid }}[data-effect="fade"] .rjhs-slide { opacity: 0; }
    #{{ $uid }}[data-effect="fade"] .rjhs-slide.rjhs-leaving { opacity: 1; }
    #{{ $uid }}[data-effect="fade"] .rjhs-slide.rjhs-on { opacity: 1; transition: opacity var(--rjhs-d) ease-in-out; }

    /* Slide */
    #{{ $uid }}[data-effect="slide"] .rjhs-slide { transform: translate3d(calc(var(--dir) * 100%), 0, 0); }
    #{{ $uid }}[data-effect="slide"] .rjhs-slide.rjhs-leaving { transform: translate3d(calc(var(--dir) * -100%), 0, 0); transition: transform var(--rjhs-d) cubic-bezier(.65, 0, .35, 1); }
    #{{ $uid }}[data-effect="slide"] .rjhs-slide.rjhs-on { transform: none; transition: transform var(--rjhs-d) cubic-bezier(.65, 0, .35, 1); }

    /* ---------- Image ---------- */
    #{{ $uid }} .rjhs-bg { position: absolute; top: -{{ $bleed }}px; left: -{{ $bleed }}px; width: calc(100% + {{ $bleed * 2 }}px); height: calc(100% + {{ $bleed * 2 }}px); max-width: none; object-fit: cover; object-position: {{ $o['image_position'] }}; filter: blur({{ $o['image_blur'] }}px); display: block; will-change: transform; }
    #{{ $uid }}[data-kb="1"] .rjhs-slide.rjhs-on .rjhs-bg,
    #{{ $uid }}[data-kb="1"] .rjhs-slide.rjhs-leaving .rjhs-bg { animation: rjhs-kb var(--rjhs-kb) linear forwards; }
    @keyframes rjhs-kb {
        from { transform: scale(1) translate3d(0, 0, 0); }
        to { transform: scale(1.12) translate3d(var(--kx, 0), var(--ky, 0), 0); }
    }

    /* ---------- Overlay ---------- */
    #{{ $uid }} .rjhs-overlay { position: absolute; inset: 0; pointer-events: none; background: {{ $c }}; opacity: {{ $o['overlay_opacity'] }}; }
    #{{ $uid }}[data-overlay="gradient"] .rjhs-overlay { background: linear-gradient(to top, {{ $c }} 0%, {{ $c }} 30%, transparent 100%); opacity: {{ $o['overlay_opacity_g'] }}; }
    #{{ $uid }}[data-overlay="side"] .rjhs-overlay { opacity: {{ $o['overlay_opacity_g'] }}; }
    #{{ $uid }}[data-overlay="side"] .rjhs-slide[data-align="left"] .rjhs-overlay { background: linear-gradient(90deg, {{ $c }} 0%, {{ $c }} 25%, transparent 85%); }
    #{{ $uid }}[data-overlay="side"] .rjhs-slide[data-align="right"] .rjhs-overlay { background: linear-gradient(270deg, {{ $c }} 0%, {{ $c }} 25%, transparent 85%); }
    #{{ $uid }}[data-overlay="side"] .rjhs-slide[data-align="center"] .rjhs-overlay { background: radial-gradient(ellipse at center, {{ $c }} 0%, {{ $c }} 30%, transparent 100%); }
    #{{ $uid }} .rjhs-slide::after { content: ""; position: absolute; left: 0; right: 0; bottom: 0; height: 160px; background: linear-gradient(to top, rgba(0, 0, 0, .4), transparent); pointer-events: none; }

    /* ---------- Content ---------- */
    #{{ $uid }} .rjhs-content { position: relative; z-index: 3; width: 100%; max-width: 1400px; height: 100%; margin: 0 auto; padding: 64px clamp(56px, 7vw, 120px) 100px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; transform: translate3d(var(--px), var(--py), 0); transition: transform .35s ease-out; }
    #{{ $uid }}[data-arrows="0"] .rjhs-content { padding-left: clamp(24px, 7vw, 120px); padding-right: clamp(24px, 7vw, 120px); }
    #{{ $uid }} .rjhs-slide[data-align="left"] .rjhs-content { align-items: flex-start; text-align: left; }
    #{{ $uid }} .rjhs-slide[data-align="center"] .rjhs-content { align-items: center; text-align: center; }
    #{{ $uid }} .rjhs-slide[data-align="right"] .rjhs-content { align-items: flex-end; text-align: right; }
    #{{ $uid }} .rjhs-slide[data-valign="top"] .rjhs-content { justify-content: flex-start; padding-top: 96px; }
    #{{ $uid }} .rjhs-slide[data-valign="center"] .rjhs-content { justify-content: center; }
    #{{ $uid }} .rjhs-slide[data-valign="bottom"] .rjhs-content { justify-content: flex-end; }

    #{{ $uid }} .rjhs-card { display: flex; flex-direction: column; align-items: inherit; gap: 20px; width: 100%; max-width: 52rem; background: transparent; }
    #{{ $uid }}[data-content="glass"] .rjhs-card { width: auto; padding: clamp(24px, 3.5vw, 48px); border-radius: 28px; background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .2); -webkit-backdrop-filter: blur(18px) saturate(140%); backdrop-filter: blur(18px) saturate(140%); box-shadow: 0 20px 60px rgba(0, 0, 0, .25); }

    #{{ $uid }} .rjhs-eyebrow { display: inline-flex; align-items: center; gap: 10px; margin: 0; padding: 7px 16px; border-radius: 999px; font-size: .72rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: {{ $o['title_color'] }}; background: rgba(255, 255, 255, .1); border: 1px solid rgba(255, 255, 255, .25); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    #{{ $uid }} .rjhs-eyebrow::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: var(--rjhs-accent); box-shadow: 0 0 12px var(--rjhs-accent); }

    #{{ $uid }} .rjhs-title { margin: 0; padding: 0; background: transparent; font-size: {{ $o['title_font'] }}; font-weight: 800; line-height: 1.08; letter-spacing: -0.025em; color: {{ $o['title_color'] }}; text-shadow: 0 2px 28px rgba(0, 0, 0, .3); }
    #{{ $uid }} .rjhs-accent { color: var(--rjhs-accent); background: linear-gradient(var(--rjhs-accent), var(--rjhs-accent)) left 94% / 100% .07em no-repeat; padding-bottom: .04em; }
    #{{ $uid }} .rjhs-subtitle { margin: 0; padding: 0; max-width: 40rem; background: transparent; font-size: clamp(1rem, 1.7vw, 1.35rem); line-height: 1.65; color: {{ $o['subtitle_color'] }}; text-shadow: 0 1px 14px rgba(0, 0, 0, .3); }

    #{{ $uid }} .rjhs-actions { display: flex; flex-wrap: wrap; gap: 14px; padding: 12px 0 0; background: transparent; justify-content: center; }
    #{{ $uid }} .rjhs-slide[data-align="left"] .rjhs-actions { justify-content: flex-start; }
    #{{ $uid }} .rjhs-slide[data-align="right"] .rjhs-actions { justify-content: flex-end; }

    #{{ $uid }} .rjhs-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 34px; border-radius: {{ $o['btn_radius'] }}; font-size: .8rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; text-decoration: none !important; line-height: 1; cursor: pointer; transition: background-color .3s ease, color .3s ease, border-color .3s ease, transform .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rjhs-btn svg { width: 16px; height: 16px; transition: transform .3s ease; }
    #{{ $uid }} .rjhs-btn:hover svg, #{{ $uid }} .rjhs-btn:focus-visible svg { transform: translateX(5px); }
    #{{ $uid }} .rjhs-btn-primary { background-color: {{ $o['btn_bg'] }} !important; color: {{ $o['btn_text'] }} !important; border: 1.5px solid transparent; box-shadow: 0 12px 28px rgba(0, 0, 0, .3); }
    #{{ $uid }} .rjhs-btn-primary:hover, #{{ $uid }} .rjhs-btn-primary:focus-visible { background-color: {{ $o['btn_hover_bg'] }} !important; color: {{ $o['btn_hover_text'] }} !important; transform: translateY(-3px); box-shadow: 0 18px 36px rgba(0, 0, 0, .35); }
    #{{ $uid }} .rjhs-btn-ghost { background-color: rgba(255, 255, 255, .08) !important; color: {{ $o['title_color'] }} !important; border: 1.5px solid rgba(255, 255, 255, .55); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    #{{ $uid }} .rjhs-btn-ghost:hover, #{{ $uid }} .rjhs-btn-ghost:focus-visible { background-color: {{ $o['title_color'] }} !important; color: {{ $o['btn_text'] }} !important; border-color: {{ $o['title_color'] }}; transform: translateY(-3px); }

    /* ---------- Text animation ---------- */
    #{{ $uid }} .rjhs-in { opacity: 0; }
    #{{ $uid }} .rjhs-slide.rjhs-on .rjhs-in,
    #{{ $uid }} .rjhs-slide.rjhs-leaving .rjhs-in { animation-name: {{ $o['text_anim'] }}; animation-duration: .95s; animation-timing-function: cubic-bezier(.2, .8, .2, 1); animation-fill-mode: both; animation-delay: calc(var(--i, 0) * 140ms + 250ms); }
    @keyframes rjhs-rise { from { opacity: 0; transform: translate3d(0, 28px, 0); } to { opacity: 1; transform: none; } }
    @keyframes rjhs-fade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjhs-zoom { from { opacity: 0; transform: scale(.9); } to { opacity: 1; transform: none; } }
    @keyframes rjhs-blur { from { opacity: 0; filter: blur(14px); transform: translate3d(0, 10px, 0); } to { opacity: 1; filter: blur(0); transform: none; } }

    /* ---------- Controls ---------- */
    #{{ $uid }} .rjhs-nav { position: absolute; top: 50%; z-index: 10; width: 48px; height: 48px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .25); border-radius: 999px; background: rgba(0, 0, 0, .25); color: #fff; -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); cursor: pointer; opacity: 0; transform: translateY(-50%); transition: opacity .3s ease, background .3s ease, transform .3s ease; }
    #{{ $uid }} .rjhs-prev { left: 16px; }
    #{{ $uid }} .rjhs-next { right: 16px; }
    #{{ $uid }}:hover .rjhs-nav, #{{ $uid }}:focus-within .rjhs-nav { opacity: 1; }
    #{{ $uid }} .rjhs-nav:hover { background: rgba(0, 0, 0, .6); transform: translateY(-50%) scale(1.08); }
    #{{ $uid }} .rjhs-nav svg { width: 22px; height: 22px; }
    @media (hover: none) { #{{ $uid }} .rjhs-nav { opacity: .85; } }

    #{{ $uid }} .rjhs-dots { position: absolute; left: 0; right: 0; bottom: 26px; z-index: 10; display: flex; justify-content: center; gap: 12px; }
    #{{ $uid }} .rjhs-dot { width: 10px; height: 10px; margin: 0; padding: 0; border: 0; border-radius: 999px; background: rgba(255, 255, 255, .4); cursor: pointer; transition: width .35s ease, background-color .3s ease; }
    #{{ $uid }} .rjhs-dot:hover { background: rgba(255, 255, 255, .75); }
    #{{ $uid }} .rjhs-dot.rjhs-on { width: 30px; background: #fff; }
    #{{ $uid }}[data-dots="lines"] .rjhs-dot { width: 38px; height: 3px; border-radius: 2px; }
    #{{ $uid }}[data-dots="lines"] .rjhs-dot.rjhs-on { width: 38px; background: var(--rjhs-accent); }

    #{{ $uid }} .rjhs-progress { position: absolute; left: 0; right: 0; bottom: 0; z-index: 10; height: 3px; background: rgba(255, 255, 255, .15); }
    #{{ $uid }}[data-progress="0"] .rjhs-progress { opacity: 0; }
    #{{ $uid }} .rjhs-progress-bar { width: 100%; height: 100%; background: var(--rjhs-accent); transform: scaleX(0); transform-origin: left center; }
    #{{ $uid }} .rjhs-progress-bar.rjhs-running { animation: rjhs-progress var(--rjhs-ap) linear forwards; }
    #{{ $uid }}.rjhs-paused .rjhs-progress-bar { animation-play-state: paused; }
    @keyframes rjhs-progress { to { transform: scaleX(1); } }

    #{{ $uid }} .rjhs-counter { position: absolute; right: 24px; bottom: 20px; z-index: 10; color: #fff; font-size: .85rem; letter-spacing: .15em; font-variant-numeric: tabular-nums; opacity: .85; }
    #{{ $uid }} .rjhs-counter-cur { font-weight: 800; color: var(--rjhs-accent); }
    #{{ $uid }} .rjhs-toggle { position: absolute; left: 24px; bottom: 16px; z-index: 10; width: 34px; height: 34px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .3); border-radius: 999px; background: rgba(0, 0, 0, .25); color: #fff; cursor: pointer; transition: background .3s ease; }
    #{{ $uid }} .rjhs-toggle:hover { background: rgba(0, 0, 0, .6); }
    #{{ $uid }} .rjhs-toggle svg { width: 14px; height: 14px; }
    #{{ $uid }} .rjhs-toggle .rjhs-i-play { display: none; }
    #{{ $uid }}.rjhs-user-paused .rjhs-toggle .rjhs-i-play { display: block; }
    #{{ $uid }}.rjhs-user-paused .rjhs-toggle .rjhs-i-pause { display: none; }

    @media (max-width: 640px) {
        #{{ $uid }} .rjhs-nav { width: 38px; height: 38px; }
        #{{ $uid }} .rjhs-prev { left: 8px; }
        #{{ $uid }} .rjhs-next { right: 8px; }
        #{{ $uid }} .rjhs-content { padding-top: 48px; padding-bottom: 88px; }
        #{{ $uid }} .rjhs-btn { padding: 14px 24px; }
        #{{ $uid }} .rjhs-counter { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjhs-bg { animation: none !important; }
        #{{ $uid }} .rjhs-in { animation-duration: .01ms !important; animation-delay: 0ms !important; }
        #{{ $uid }} .rjhs-content { transition: none; transform: none; }
    }
</style>

<section id="{{ $uid }}"
         data-effect="{{ $o['effect'] }}"
         data-kb="{{ $o['kenburns'] ? 1 : 0 }}"
         data-overlay="{{ $o['overlay_style'] }}"
         data-content="{{ $o['content_style'] }}"
         data-dots="{{ $o['dots_style'] }}"
         data-arrows="{{ $arrows ? 1 : 0 }}"
         data-progress="{{ $o['show_progress'] ? 1 : 0 }}"
         role="region"
         aria-roledescription="carousel"
         aria-label="{{ __('Hero Slider') }}"
         @if($multi) tabindex="0" @endif>

    @foreach ($slides as $index => $slide)
        @php $n = 0; $isFirst = $index === 0; @endphp
        <div class="rjhs-slide {{ $isFirst ? 'rjhs-on' : '' }}"
             data-align="{{ $slide['align'] }}"
             data-valign="{{ $slide['valign'] }}"
             role="group"
             aria-roledescription="slide"
             aria-label="{{ $index + 1 }} / {{ $total }}"
             @if(!$isFirst) aria-hidden="true" @endif
             style="--kx: {{ $index % 2 ? '-1.6%' : '1.6%' }}; --ky: {{ $index % 2 ? '1.2%' : '-1.2%' }};">

            <img class="rjhs-bg" src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" decoding="async" @if($isFirst) fetchpriority="high" @endif>
            <div class="rjhs-overlay"></div>

            <div class="rjhs-content">
                <div class="rjhs-card">
                    @if ($slide['eyebrow'] !== '')
                        <span class="rjhs-eyebrow rjhs-in" style="--i: {{ $n++ }};">{{ $slide['eyebrow'] }}</span>
                    @endif

                    @if ($slide['title_html'] !== '')
                        <h2 class="rjhs-title rjhs-in" style="--i: {{ $n++ }};">{!! $slide['title_html'] !!}</h2>
                    @endif

                    @if ($slide['subtitle'] !== '')
                        <p class="rjhs-subtitle rjhs-in" style="--i: {{ $n++ }};">{!! nl2br(e($slide['subtitle'])) !!}</p>
                    @endif

                    @php
                        $hasBtn1 = $slide['btn_text'] !== '' && $slide['btn_url'] !== '';
                        $hasBtn2 = $slide['btn2_text'] !== '' && $slide['btn2_url'] !== '';
                    @endphp

                    @if ($hasBtn1 || $hasBtn2)
                        <div class="rjhs-actions rjhs-in" style="--i: {{ $n++ }};">
                            @if ($hasBtn1)
                                <a href="{{ $slide['btn_url'] }}" class="rjhs-btn rjhs-btn-primary" @if($o['btn_new_tab']) target="_blank" rel="noopener noreferrer" @endif>
                                    <span>{{ $slide['btn_text'] }}</span>
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                </a>
                            @endif
                            @if ($hasBtn2)
                                <a href="{{ $slide['btn2_url'] }}" class="rjhs-btn rjhs-btn-ghost" @if($o['btn_new_tab']) target="_blank" rel="noopener noreferrer" @endif>
                                    <span>{{ $slide['btn2_text'] }}</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @if ($multi)
        @if ($o['show_arrows'])
            <button type="button" class="rjhs-nav rjhs-prev" aria-label="{{ __('Previous slide') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button type="button" class="rjhs-nav rjhs-next" aria-label="{{ __('Next slide') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        @endif

        @if ($o['show_dots'])
            <div class="rjhs-dots">
                @foreach ($slides as $index => $slide)
                    <button type="button" class="rjhs-dot {{ $index === 0 ? 'rjhs-on' : '' }}" aria-label="{{ __('Go to slide') }} {{ $index + 1 }}" @if($index === 0) aria-current="true" @endif></button>
                @endforeach
            </div>
        @endif

        @if ($o['show_counter'])
            <div class="rjhs-counter" aria-hidden="true"><span class="rjhs-counter-cur">{{ $pad(1) }}</span> / {{ $pad($total) }}</div>
        @endif

        @if ($o['autoplay'] > 0)
            <button type="button" class="rjhs-toggle" aria-label="{{ __('Pause / play autoplay') }}">
                <svg class="rjhs-i-pause" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
                <svg class="rjhs-i-play" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4l13 8-13 8z"/></svg>
            </button>
            <div class="rjhs-progress"><div class="rjhs-progress-bar"></div></div>
        @endif
    @endif
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Mouse parallax on text
    @if ($o['parallax'])
    if (!reduceMotion && window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        var raf = 0, tx = 0, ty = 0;
        var applyParallax = function () {
            raf = 0;
            root.style.setProperty('--px', tx.toFixed(1) + 'px');
            root.style.setProperty('--py', ty.toFixed(1) + 'px');
        };
        root.addEventListener('pointermove', function (e) {
            if (e.pointerType !== 'mouse') { return; }
            var r = root.getBoundingClientRect();
            tx = ((e.clientX - r.left) / r.width - 0.5) * -18;
            ty = ((e.clientY - r.top) / r.height - 0.5) * -12;
            if (!raf) { raf = requestAnimationFrame(applyParallax); }
        });
        root.addEventListener('pointerleave', function () {
            tx = 0; ty = 0;
            if (!raf) { raf = requestAnimationFrame(applyParallax); }
        });
    }
    @endif

    var slides = Array.prototype.slice.call(root.querySelectorAll('.rjhs-slide'));
    if (slides.length < 2) { return; }

    var duration = {{ $o['transition'] }};
    var autoplay = {{ $o['autoplay'] }};
    var pauseOnHover = {{ $o['pause_on_hover'] ? 'true' : 'false' }};

    var dots = Array.prototype.slice.call(root.querySelectorAll('.rjhs-dot'));
    var bar = root.querySelector('.rjhs-progress-bar');
    var counter = root.querySelector('.rjhs-counter-cur');
    var toggle = root.querySelector('.rjhs-toggle');
    var prevBtn = root.querySelector('.rjhs-prev');
    var nextBtn = root.querySelector('.rjhs-next');

    var current = 0;
    var locked = false;
    var reasons = { hover: false, hidden: false, offscreen: false, user: false };
    var io = null;

    function syncPause() {
        var paused = reasons.hover || reasons.hidden || reasons.offscreen || reasons.user;
        root.classList.toggle('rjhs-paused', paused);
    }

    function restartProgress() {
        if (!bar || !autoplay) { return; }
        bar.classList.remove('rjhs-running');
        void bar.offsetWidth;
        bar.classList.add('rjhs-running');
    }

    function updateUi(index) {
        dots.forEach(function (d, i) {
            d.classList.toggle('rjhs-on', i === index);
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

        root.style.setProperty('--dir', dir);
        void root.offsetWidth;

        from.classList.remove('rjhs-on');
        from.classList.add('rjhs-leaving');
        from.setAttribute('aria-hidden', 'true');

        to.classList.add('rjhs-on');
        to.removeAttribute('aria-hidden');

        current = target;
        updateUi(current);
        restartProgress();

        setTimeout(function () {
            from.classList.remove('rjhs-leaving');
            locked = false;
        }, duration + 60);

        return true;
    }

    function next() { return goTo(current + 1, 1); }
    function prev() { return goTo(current - 1, -1); }

    if (nextBtn) { nextBtn.addEventListener('click', next); }
    if (prevBtn) { prevBtn.addEventListener('click', prev); }
    dots.forEach(function (d, i) { d.addEventListener('click', function () { goTo(i); }); });

    if (bar && autoplay) {
        bar.addEventListener('animationend', function () {
            if (!next()) { restartProgress(); }
        });
    }

    if (toggle) {
        toggle.addEventListener('click', function () {
            reasons.user = !reasons.user;
            root.classList.toggle('rjhs-user-paused', reasons.user);
            syncPause();
        });
    }

    if (pauseOnHover) {
        root.addEventListener('pointerenter', function (e) {
            if (e.pointerType === 'mouse') { reasons.hover = true; syncPause(); }
        });
        root.addEventListener('pointerleave', function () { reasons.hover = false; syncPause(); });
    }

    root.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') { next(); }
        if (e.key === 'ArrowLeft') { prev(); }
    });

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
