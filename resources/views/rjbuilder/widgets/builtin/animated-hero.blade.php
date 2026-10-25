@php
    $totalSlides = count($images);
    $endImage = end($images);
    $finalBg = !empty($settings['final_bg_image']) ? $settings['final_bg_image'] : $endImage;
    $isBlurred = empty($settings['final_bg_image']);
@endphp

<style>
    #{{ $uid }} {
        position: relative;
        z-index: 0;
        isolation: isolate;
    }
    #{{ $uid }} .sc-stage {
        height: 100vh;
        height: 100svh;
        top: 0;
    }
    #{{ $uid }} .sc-slide {
        will-change: clip-path;
        backface-visibility: hidden;
    }
    #{{ $uid }} .sc-slide:not(:first-child) {
        visibility: hidden;
    }
    #{{ $uid }} .sc-image {
        transform-origin: 50% 50%;
        will-change: transform;
    }
    #{{ $uid }} .sc-dim {
        background: #020617;
        opacity: 0;
        pointer-events: none;
    }
    #{{ $uid }} .sc-cta-shade {
        background: radial-gradient(ellipse at center, rgba(15, 23, 42, 0.55) 0%, rgba(15, 23, 42, 0.92) 100%);
    }
    #{{ $uid }} .sc-content {
        will-change: transform, opacity;
    }
    #{{ $uid }} .sc-ghost {
        position: absolute;
        top: 10%;
        right: 4vw;
        font-size: clamp(8rem, 28vw, 26rem);
        font-weight: 900;
        line-height: .8;
        letter-spacing: -.04em;
        color: transparent;
        -webkit-text-stroke: 2px rgba(255, 255, 255, .2);
        pointer-events: none;
        user-select: none;
        will-change: transform, opacity;
    }
    #{{ $uid }} .sc-word {
        display: inline-block;
        overflow: hidden;
        vertical-align: top;
        padding-bottom: .12em;
        margin-bottom: -.12em;
    }
    #{{ $uid }} .sc-word > span {
        display: inline-block;
        will-change: transform;
    }
    #{{ $uid }}.sc-ready [data-reveal] {
        opacity: 0;
        will-change: transform, opacity;
    }
    #{{ $uid }} .sc-hud {
        position: absolute;
        inset: 0;
        z-index: 50;
        pointer-events: none;
    }
    #{{ $uid }} .sc-progress {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 3px;
        background: rgba(255, 255, 255, .12);
    }
    #{{ $uid }} .sc-progress > span {
        display: block;
        height: 100%;
        background: #fff;
        transform-origin: 0 50%;
        transform: scaleX(0);
    }
    #{{ $uid }} .sc-dots {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 14px;
        pointer-events: auto;
    }
    #{{ $uid }} .sc-dot {
        width: 10px;
        height: 10px;
        padding: 0;
        border-radius: 999px;
        border: 1.5px solid rgba(255, 255, 255, .7);
        background: transparent;
        cursor: pointer;
        transition: height .5s cubic-bezier(.4, 0, .2, 1), background .3s ease;
    }
    #{{ $uid }} .sc-dot.is-active {
        height: 28px;
        background: #fff;
    }
    #{{ $uid }} .sc-counter {
        position: absolute;
        right: 1.5rem;
        bottom: 2.5rem;
        display: flex;
        align-items: baseline;
        gap: .5rem;
        color: #fff;
        transition: opacity .4s ease;
    }
    #{{ $uid }} .sc-current {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    #{{ $uid }} .sc-total {
        font-size: .875rem;
        font-weight: 600;
        color: rgba(255, 255, 255, .55);
    }
    @media (min-width: 768px) {
        #{{ $uid }} .sc-dots, #{{ $uid }} .sc-counter { right: 2.5rem; }
    }
</style>

<section id="{{ $uid }}" class="relative bg-slate-950" style="height: {{ ($totalSlides + 1) * 140 }}vh;">
    <div class="sc-stage sticky w-full overflow-hidden">

        @foreach ($images as $i => $img)
            <article class="sc-slide absolute inset-0" style="z-index: {{ $i + 1 }};">
                <img src="{{ $img }}" class="sc-image absolute inset-0 w-full h-full object-cover" alt="Slide {{ $i + 1 }}">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                <div class="sc-ghost" aria-hidden="true">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="sc-dim absolute inset-0"></div>
            </article>
        @endforeach

        <article class="sc-slide absolute inset-0" style="z-index: {{ $totalSlides + 1 }};">
            <img src="{{ $finalBg }}" class="sc-image absolute inset-0 w-full h-full object-cover {{ $isBlurred ? 'blur-2xl scale-110 opacity-60' : '' }}" alt="Final Slide">

            <div class="sc-cta-shade absolute inset-0"></div>

            <div class="sc-content absolute inset-0 flex items-center justify-center">
                <div class="text-center px-6 max-w-4xl mx-auto">
                    <div data-reveal="0">
                        <div class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-6">
                            {{ $settings['final_subtitle'] ?? __('Premium Collection') }}
                        </div>
                    </div>

                    <h2 data-split class="text-4xl md:text-7xl font-black text-white leading-tight mb-8">{{ $settings['final_title'] ?? __('Discover More') }}</h2>

                    @if(!empty($settings['final_btn_text']) && !empty($settings['final_btn_url']))
                        <div data-reveal="2">
                            <a href="{{ $settings['final_btn_url'] }}" class="inline-flex items-center gap-3 px-10 py-5 rounded-full bg-white text-slate-900 font-bold hover:bg-slate-100 transition shadow-2xl">
                                {{ $settings['final_btn_text'] }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </article>

        <div class="sc-hud">
            <div class="sc-counter">
                <span class="sc-current">01</span>
                <span class="sc-total">/ {{ str_pad($totalSlides, 2, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="sc-dots">
                @for ($k = 0; $k < $totalSlides; $k++)
                    <button type="button" class="sc-dot" aria-label="{{ $k + 1 }}"></button>
                @endfor
            </div>

            <div class="sc-progress"><span></span></div>
        </div>
    </div>
</section>

<script>
(function() {
    function initScrollShowcase() {
        const root = document.getElementById('{{ $uid }}');
        if (!root) return;

        const slideEls = Array.from(root.querySelectorAll('.sc-slide'));
        const S = slideEls.length;
        if (S < 2) return;

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const clamp = function (v, a, b) { return Math.min(Math.max(v, a === undefined ? 0 : a), b === undefined ? 1 : b); };
        const easeOut = function (t) { return 1 - Math.pow(1 - t, 3); };
        const easeInOut = function (t) { return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; };
        const easeOutExpo = function (t) { return t === 1 ? 1 : 1 - Math.pow(2, -10 * t); };
        const pad = function (n) { return n < 10 ? '0' + n : String(n); };

        root.querySelectorAll('[data-split]').forEach(function (el) {
            const text = el.textContent.trim();
            el.setAttribute('aria-label', text);
            el.textContent = '';
            text.split(/\s+/).forEach(function (word, idx, arr) {
                const outer = document.createElement('span');
                outer.className = 'sc-word';
                outer.setAttribute('aria-hidden', 'true');
                const inner = document.createElement('span');
                inner.textContent = word;
                outer.appendChild(inner);
                el.appendChild(outer);
                if (idx < arr.length - 1) el.appendChild(document.createTextNode(' '));
            });
        });

        root.classList.add('sc-ready');

        const items = slideEls.map(function (el, i) {
            return {
                el: el,
                i: i,
                mode: i % 2 === 0 ? 'inset' : 'circle',
                image: el.querySelector('.sc-image'),
                dim: el.querySelector('.sc-dim'),
                ghost: el.querySelector('.sc-ghost'),
                content: el.querySelector('.sc-content'),
                words: Array.from(el.querySelectorAll('.sc-word > span')),
                reveals: Array.from(el.querySelectorAll('[data-reveal]'))
            };
        });

        const bar = root.querySelector('.sc-progress > span');
        const dots = Array.from(root.querySelectorAll('.sc-dot'));
        const counter = root.querySelector('.sc-counter');
        const currentLabel = root.querySelector('.sc-current');

        let target = 0;
        let current = 0;
        let introT = reduceMotion ? 1 : 0;
        let introStart = null;
        let rafId = null;

        function readTarget() {
            const rect = root.getBoundingClientRect();
            const total = root.offsetHeight - window.innerHeight;
            if (total <= 0) { target = 0; return; }
            const raw = clamp(-rect.top / total) * (S - 1);
            const base = Math.min(Math.floor(raw), S - 1);
            const frac = raw - base;
            target = base + easeInOut(clamp((frac - 0.1) / 0.8));
        }

        function render(pos) {
            const intro = easeOutExpo(introT);
            items.forEach(function (it) {
                const d = pos - it.i;
                if (d <= -1.05 || d >= 1.05) {
                    it.el.style.visibility = 'hidden';
                    it.el.style.pointerEvents = 'none';
                    return;
                }
                it.el.style.visibility = 'visible';
                it.el.style.pointerEvents = Math.abs(d) < 0.5 ? 'auto' : 'none';

                const enter = it.i === 0 ? intro : clamp(1 + d);
                const exit = clamp(d);

                let clip = 'none';
                if (it.i > 0 && enter < 1) {
                    if (it.mode === 'circle') {
                        const r = easeOut(enter) * 150;
                        clip = 'circle(' + r.toFixed(2) + '% at 50% 100%)';
                    } else {
                        const off = (1 - easeOut(enter)) * 100;
                        const rad = ((1 - enter) * 80).toFixed(1);
                        clip = 'inset(0 0 0 ' + off.toFixed(2) + '% round ' + rad + 'px 0 0 ' + rad + 'px)';
                    }
                }
                it.el.style.clipPath = clip;
                it.el.style.webkitClipPath = clip;

                if (it.image) {
                    const scale = (1.25 - 0.25 * enter) * (1 + exit * 0.15);
                    let tx = 0, ty = -exit * 6;
                    if (it.i > 0) {
                        if (it.mode === 'circle') ty += (1 - enter) * 10;
                        else tx = (1 - enter) * 12;
                    }
                    const blurAmt = exit * 14 + (it.i > 0 ? (1 - enter) * 6 : 0);
                    const bright = 1 - exit * 0.45 - (it.i > 0 ? (1 - enter) * 0.25 : 0);
                    const sat = 1 - exit * 0.3;
                    it.image.style.transform = 'translate3d(' + tx.toFixed(2) + '%,' + ty.toFixed(2) + '%,0) scale(' + scale.toFixed(4) + ')';
                    it.image.style.filter = 'blur(' + blurAmt.toFixed(2) + 'px) brightness(' + bright.toFixed(3) + ') saturate(' + sat.toFixed(3) + ')';
                }

                if (it.dim) it.dim.style.opacity = (exit * 0.7).toFixed(3);
                if (it.ghost) {
                    it.ghost.style.transform = 'translate3d(' + (-d * 30).toFixed(2) + 'vw,0,0)';
                    it.ghost.style.opacity = ((1 - Math.abs(d)) * (it.i === 0 ? intro : 1) * 0.9).toFixed(3);
                }
                if (it.content) {
                    const co = 1 - clamp(exit * 1.8);
                    it.content.style.opacity = co.toFixed(3);
                    it.content.style.transform = 'translate3d(0,' + (-exit * 80).toFixed(1) + 'px,0)';
                    it.content.style.filter = 'blur(' + (exit * 6).toFixed(2) + 'px)';
                }

                const wl = it.words.length;
                const step = 0.25 / Math.max(wl, 1);
                it.words.forEach(function (w, k) {
                    const local = clamp((enter - 0.35 - k * step) / 0.35);
                    const e = easeOutExpo(local);
                    w.style.transform = 'translate3d(0,' + ((1 - e) * 120).toFixed(2) + '%,0)';
                    w.style.opacity = e.toFixed(3);
                });

                it.reveals.forEach(function (r) {
                    const idx = parseInt(r.getAttribute('data-reveal'), 10) || 0;
                    const local = clamp((enter - 0.55 - idx * 0.05) / 0.3);
                    const e = easeOut(local);
                    r.style.opacity = e.toFixed(3);
                    r.style.transform = 'translate3d(0,' + ((1 - e) * 35).toFixed(1) + 'px,0)';
                    r.style.filter = 'blur(' + ((1 - e) * 4).toFixed(2) + 'px)';
                });
            });

            const idx = clamp(Math.round(pos), 0, S - 1);
            if (bar) bar.style.transform = 'scaleX(' + (pos / (S - 1)).toFixed(4) + ')';
            dots.forEach(function (dot, k) { dot.classList.toggle('is-active', k === idx); });
            if (counter) {
                const onSculpture = idx < S - 1;
                counter.style.opacity = onSculpture ? '1' : '0';
                if (onSculpture && currentLabel) currentLabel.textContent = pad(idx + 1);
            }
        }

        function tick(now) {
            rafId = null;
            if (introT < 1) {
                if (introStart === null) introStart = now;
                introT = clamp((now - introStart) / 1600);
            }
            const k = reduceMotion ? 1 : 0.085;
            current += (target - current) * k;
            if (Math.abs(target - current) < 0.0004) current = target;
            render(current);
            if (current !== target || introT < 1) {
                rafId = requestAnimationFrame(tick);
            }
        }

        function request() { if (rafId === null) rafId = requestAnimationFrame(tick); }
        function onScroll() { readTarget(); request(); }

        dots.forEach(function (dot, k) {
            dot.addEventListener('click', function () {
                const total = root.offsetHeight - window.innerHeight;
                const top = root.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({ top: top + (k / (S - 1)) * total, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        });

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);

        readTarget();
        current = target;
        if (target > 0.01 || root.getBoundingClientRect().top < -50) introT = 1;

        render(current);
        request();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollShowcase);
    } else {
        initScrollShowcase();
    }
})();
</script>
