@php
    $count = count($slides);
    $sectionHeight = ($count + 1) * $o['step_vh'];
    $pad = fn ($n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
@endphp

<style>
    #{{ $uid }} { position: relative; z-index: 0; isolation: isolate; width: 100%; height: {{ $sectionHeight }}vh; height: {{ $sectionHeight }}svh; background: #020617; overflow-anchor: none; --rjsc-accent: {{ $o['accent'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Pinned stage ---------- */
    #{{ $uid }} .rjsc-stage { position: sticky; top: 0; width: 100%; height: 100vh; height: 100svh; overflow: hidden; }

    /* ---------- Slides ---------- */
    #{{ $uid }} .rjsc-slide { position: absolute; inset: 0; overflow: hidden; will-change: clip-path; backface-visibility: hidden; }
    #{{ $uid }} .rjsc-slide:not(:first-child) { visibility: hidden; }
    #{{ $uid }} .rjsc-image { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; object-fit: cover; display: block; transform-origin: 50% 50%; will-change: transform; }
    #{{ $uid }} .rjsc-image.rjsc-blurred { filter: blur(22px); opacity: .6; }
    #{{ $uid }} .rjsc-shade { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to top, #020617 0%, rgba(2, 6, 23, .25) 50%, transparent 100%); }
    #{{ $uid }} .rjsc-side { position: absolute; inset: 0; pointer-events: none; }
    #{{ $uid }} .rjsc-slide[data-align="left"] .rjsc-side { background: linear-gradient(90deg, rgba(2, 6, 23, .82) 0%, rgba(2, 6, 23, .4) 42%, transparent 78%); }
    #{{ $uid }} .rjsc-slide[data-align="right"] .rjsc-side { background: linear-gradient(270deg, rgba(2, 6, 23, .82) 0%, rgba(2, 6, 23, .4) 42%, transparent 78%); }
    #{{ $uid }} .rjsc-slide[data-align="center"] .rjsc-side { background: radial-gradient(ellipse at center, rgba(2, 6, 23, .55) 0%, transparent 78%); }
    #{{ $uid }} .rjsc-dim { position: absolute; inset: 0; background: #020617; opacity: 0; pointer-events: none; }

    #{{ $uid }} .rjsc-final .rjsc-shade { background: radial-gradient(ellipse at center, rgba(15, 23, 42, .55) 0%, rgba(15, 23, 42, .92) 100%); }
    #{{ $uid }} .rjsc-final .rjsc-side { display: none; }

    /* Ghost number */
    #{{ $uid }} .rjsc-ghost { position: absolute; top: 10%; right: 4vw; font-size: clamp(8rem, 28vw, 26rem); font-weight: 900; line-height: .8; letter-spacing: -.04em; color: transparent; -webkit-text-stroke: 2px rgba(255, 255, 255, .2); pointer-events: none; user-select: none; will-change: transform, opacity; }
    #{{ $uid }} .rjsc-slide[data-align="right"] .rjsc-ghost { right: auto; left: 4vw; }

    /* ---------- Content ---------- */
    #{{ $uid }} .rjsc-content { position: absolute; inset: 0; z-index: 3; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 64px max(88px, 7vw) 96px max(24px, 7vw); will-change: transform, opacity; }
    #{{ $uid }} .rjsc-slide[data-align="left"] .rjsc-content { align-items: flex-start; text-align: left; }
    #{{ $uid }} .rjsc-slide[data-align="right"] .rjsc-content { align-items: flex-end; text-align: right; }
    #{{ $uid }} .rjsc-card { display: flex; flex-direction: column; align-items: inherit; gap: 20px; width: 100%; max-width: 48rem; }

    #{{ $uid }} .rjsc-label { display: inline-flex; align-items: center; gap: 14px; margin: 0; font-size: .75rem; font-weight: 700; letter-spacing: .28em; text-transform: uppercase; color: var(--rjsc-accent); }
    #{{ $uid }} .rjsc-label::before { content: ""; width: 36px; height: 2px; background: var(--rjsc-accent); }
    #{{ $uid }} .rjsc-title { margin: 0; padding: 0; font-size: clamp(2.25rem, 6vw, 5.5rem); font-weight: 900; line-height: 1.04; letter-spacing: -.03em; color: #fff; text-shadow: 0 2px 30px rgba(0, 0, 0, .35); }
    #{{ $uid }} .rjsc-final .rjsc-title { font-size: clamp(2.5rem, 7vw, 6rem); }
    #{{ $uid }} .rjsc-accent { color: var(--rjsc-accent); }
    #{{ $uid }} .rjsc-text { margin: 0; max-width: 36rem; font-size: clamp(1rem, 1.6vw, 1.3rem); line-height: 1.65; color: rgba(255, 255, 255, .85); text-shadow: 0 1px 14px rgba(0, 0, 0, .35); }
    #{{ $uid }} .rjsc-btn { display: inline-flex; align-items: center; gap: 12px; margin-top: 8px; padding: 16px 32px; border-radius: 999px; background: #fff; color: #0f172a !important; font-size: .85rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; text-decoration: none !important; box-shadow: 0 18px 40px rgba(0, 0, 0, .35); transition: background-color .3s ease, color .3s ease, transform .3s ease; }
    #{{ $uid }} .rjsc-btn:hover, #{{ $uid }} .rjsc-btn:focus-visible { background: var(--rjsc-accent); color: #fff !important; transform: translateY(-3px); }
    #{{ $uid }} .rjsc-btn svg { width: 18px; height: 18px; transition: transform .3s ease; }
    #{{ $uid }} .rjsc-btn:hover svg { transform: translateX(5px); }

    #{{ $uid }} .rjsc-word { display: inline-block; overflow: hidden; vertical-align: top; padding-bottom: .12em; margin-bottom: -.12em; }
    #{{ $uid }} .rjsc-word > span { display: inline-block; will-change: transform; }
    #{{ $uid }}.rjsc-ready [data-reveal] { opacity: 0; will-change: transform, opacity; }

    /* ---------- HUD ---------- */
    #{{ $uid }} .rjsc-hud { position: absolute; inset: 0; z-index: 50; pointer-events: none; }
    #{{ $uid }} .rjsc-progress { position: absolute; left: 0; right: 0; bottom: 0; height: 3px; background: rgba(255, 255, 255, .12); }
    #{{ $uid }} .rjsc-progress > span { display: block; height: 100%; background: var(--rjsc-accent); transform-origin: 0 50%; transform: scaleX(0); }
    #{{ $uid }} .rjsc-dots { position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 14px; pointer-events: auto; }
    #{{ $uid }} .rjsc-dot { width: 10px; height: 10px; margin: 0; padding: 0; border-radius: 999px; border: 1.5px solid rgba(255, 255, 255, .7); background: transparent; cursor: pointer; transition: height .5s cubic-bezier(.4, 0, .2, 1), background .3s ease; }
    #{{ $uid }} .rjsc-dot.rjsc-active { height: 28px; background: #fff; }
    #{{ $uid }} .rjsc-counter { position: absolute; right: 1.5rem; bottom: 2.5rem; display: flex; align-items: baseline; gap: .5rem; color: #fff; transition: opacity .4s ease; }
    #{{ $uid }} .rjsc-current { font-size: 2.5rem; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rjsc-total { font-size: .875rem; font-weight: 600; color: rgba(255, 255, 255, .55); }
    #{{ $uid }} .rjsc-hint { position: absolute; left: 50%; bottom: 28px; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 10px; color: rgba(255, 255, 255, .8); font-size: .7rem; font-weight: 600; letter-spacing: .3em; text-transform: uppercase; }
    #{{ $uid }} .rjsc-hint i { display: block; width: 1px; height: 38px; background: linear-gradient(to bottom, #fff, transparent); transform-origin: top; animation: rjsc-hint 1.8s ease-in-out infinite; }
    @keyframes rjsc-hint { 0% { transform: scaleY(0); } 50% { transform: scaleY(1); } 100% { transform: scaleY(0); transform-origin: bottom; } }

    @media (min-width: 768px) {
        #{{ $uid }} .rjsc-dots { right: 2.5rem; }
        #{{ $uid }} .rjsc-counter { right: 2.5rem; }
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rjsc-content { padding: 48px 56px 88px 24px; }
        #{{ $uid }} .rjsc-counter { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjsc-hint i { animation: none; }
    }
</style>

<section id="{{ $uid }}" aria-roledescription="carousel" aria-label="{{ __('Animated Scroll Hero') }}">
    <div class="rjsc-stage">

        @foreach ($slides as $i => $s)
            @php
                $hasBtn = $s['btn_text'] !== '' && $s['btn_url'] !== '';
                $hasText = $s['label'] !== '' || $s['title_html'] !== '' || $s['text'] !== '' || $hasBtn;
            @endphp
            <article class="rjsc-slide" data-align="{{ $s['align'] }}" style="z-index: {{ $i + 1 }};">
                <img class="rjsc-image" src="{{ $s['image'] }}" alt="{{ $s['title'] }}" decoding="async" @if($i === 0) fetchpriority="high" @endif>
                <div class="rjsc-shade"></div>
                @if ($hasText)
                    <div class="rjsc-side"></div>
                @endif
                <div class="rjsc-ghost" aria-hidden="true">{{ $pad($i + 1) }}</div>

                @if ($hasText)
                    <div class="rjsc-content">
                        <div class="rjsc-card">
                            @if ($s['label'] !== '')
                                <div data-reveal="0" data-start=".2"><span class="rjsc-label">{{ $s['label'] }}</span></div>
                            @endif

                            @if ($s['title_html'] !== '')
                                <h2 data-split class="rjsc-title">{!! $s['title_html'] !!}</h2>
                            @endif

                            @if ($s['text'] !== '')
                                <div data-reveal="1" data-start=".6"><p class="rjsc-text">{!! nl2br(e($s['text'])) !!}</p></div>
                            @endif

                            @if ($hasBtn)
                                <div data-reveal="2" data-start=".68">
                                    <a href="{{ $s['btn_url'] }}" class="rjsc-btn">
                                        <span>{{ $s['btn_text'] }}</span>
                                        <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="rjsc-dim"></div>
            </article>
        @endforeach

        <article class="rjsc-slide rjsc-final" data-align="center" style="z-index: {{ $count + 1 }};">
            <img class="rjsc-image {{ $final['blurred'] ? 'rjsc-blurred' : '' }}" src="{{ $final['image'] }}" alt="{{ $final['title'] }}" decoding="async">
            <div class="rjsc-shade"></div>

            <div class="rjsc-content">
                <div class="rjsc-card">
                    @if ($final['label'] !== '')
                        <div data-reveal="0" data-start=".2"><span class="rjsc-label">{{ $final['label'] }}</span></div>
                    @endif

                    @if ($final['title_html'] !== '')
                        <h2 data-split class="rjsc-title">{!! $final['title_html'] !!}</h2>
                    @endif

                    @if ($final['btn_text'] !== '' && $final['btn_url'] !== '')
                        <div data-reveal="2" data-start=".68">
                            <a href="{{ $final['btn_url'] }}" class="rjsc-btn">
                                <span>{{ $final['btn_text'] }}</span>
                                <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </article>

        <div class="rjsc-hud">
            @if ($o['show_counter'])
                <div class="rjsc-counter" aria-hidden="true">
                    <span class="rjsc-current">01</span>
                    <span class="rjsc-total">/ {{ $pad($count) }}</span>
                </div>
            @endif

            @if ($o['show_dots'])
                <div class="rjsc-dots">
                    @for ($k = 0; $k < $count; $k++)
                        <button type="button" class="rjsc-dot" aria-label="{{ __('Go to slide') }} {{ $k + 1 }}"></button>
                    @endfor
                </div>
            @endif

            @if ($o['show_hint'])
                <div class="rjsc-hint" aria-hidden="true"><span>{{ __('Scroll') }}</span><i></i></div>
            @endif

            <div class="rjsc-progress"><span></span></div>
        </div>
    </div>
</section>

<script>
(function () {
    function init() {
        var root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.ready) { return; }
        root.dataset.ready = '1';

        var stage = root.querySelector('.rjsc-stage');
        var slideEls = Array.prototype.slice.call(root.querySelectorAll('.rjsc-slide'));
        var S = slideEls.length;
        if (S < 2) { return; }

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var revealMode = '{{ $o['reveal'] }}';

        function clamp(v, a, b) { return Math.min(Math.max(v, a === undefined ? 0 : a), b === undefined ? 1 : b); }
        function easeOut(t) { return 1 - Math.pow(1 - t, 3); }
        function easeInOut(t) { return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; }
        function easeOutExpo(t) { return t === 1 ? 1 : 1 - Math.pow(2, -10 * t); }
        function pad(n) { return n < 10 ? '0' + n : String(n); }

        // ---------- Split titles into words (keeps highlighted words) ----------
        root.querySelectorAll('[data-split]').forEach(function (el) {
            var label = el.textContent.trim();
            var tokens = [];
            Array.prototype.forEach.call(el.childNodes, function (node) {
                var cls = node.nodeType === 1 ? node.className : '';
                node.textContent.trim().split(/\s+/).forEach(function (w) {
                    if (w) { tokens.push({ w: w, cls: cls }); }
                });
            });
            el.setAttribute('aria-label', label);
            el.textContent = '';
            tokens.forEach(function (t, idx) {
                var outer = document.createElement('span');
                outer.className = 'rjsc-word';
                outer.setAttribute('aria-hidden', 'true');
                var inner = document.createElement('span');
                inner.textContent = t.w;
                if (t.cls) { inner.className = t.cls; }
                outer.appendChild(inner);
                el.appendChild(outer);
                if (idx < tokens.length - 1) { el.appendChild(document.createTextNode(' ')); }
            });
        });

        root.classList.add('rjsc-ready');

        var items = slideEls.map(function (el, i) {
            var image = el.querySelector('.rjsc-image');
            return {
                el: el,
                i: i,
                mode: revealMode === 'mixed' ? (i % 2 === 0 ? 'inset' : 'circle') : revealMode,
                image: image,
                baseScale: image && image.classList.contains('rjsc-blurred') ? 1.15 : 1,
                dim: el.querySelector('.rjsc-dim'),
                ghost: el.querySelector('.rjsc-ghost'),
                content: el.querySelector('.rjsc-content'),
                words: Array.prototype.slice.call(el.querySelectorAll('.rjsc-word > span')),
                reveals: Array.prototype.slice.call(el.querySelectorAll('[data-reveal]'))
            };
        });

        var bar = root.querySelector('.rjsc-progress > span');
        var dots = Array.prototype.slice.call(root.querySelectorAll('.rjsc-dot'));
        var counter = root.querySelector('.rjsc-counter');
        var currentLabel = root.querySelector('.rjsc-current');
        var hint = root.querySelector('.rjsc-hint');

        var target = 0;
        var current = 0;
        var introT = reduceMotion ? 1 : 0;
        var introStart = null;
        var rafId = null;

        // ---------- Pinning ----------
        // 1) Ancestors with overflow:hidden break position:sticky -> turn them into overflow:clip right away.
        // 2) If a real scroll container remains, fall back to position:fixed (no JS transform = no jitter).
        var pinMode = 'sticky';
        var fixedState = '';
        var badFrames = 0;

        function relaxAncestors() {
            var html = document.documentElement;
            var htmlVisible = getComputedStyle(html).overflowX === 'visible' && getComputedStyle(html).overflowY === 'visible';
            var clipOk = !!(window.CSS && CSS.supports && CSS.supports('overflow', 'clip'));
            var blocked = false;

            for (var el = root.parentElement; el && el !== html; el = el.parentElement) {
                var cs = getComputedStyle(el);
                var ox = cs.overflowX, oy = cs.overflowY;
                if (ox === 'visible' && oy === 'visible') { continue; }
                if (ox === 'clip' && oy === 'clip') { continue; }
                if (el === document.body && htmlVisible) { continue; }

                var scrolls = (oy === 'auto' || oy === 'scroll') && el.scrollHeight > el.clientHeight + 1;
                if (scrolls) { blocked = true; continue; }

                el.style.overflow = clipOk ? 'clip' : 'visible';
            }

            return blocked;
        }

        function useFixed() {
            pinMode = 'fixed';
            fixedState = '';
        }

        function applyFixed(rect, total) {
            var state = rect.top > 0 ? 'before' : (rect.top < -total ? 'after' : 'during');

            if (state !== fixedState) {
                fixedState = state;
                stage.style.position = state === 'during' ? 'fixed' : 'absolute';
                stage.style.top = state === 'after' ? 'auto' : '0';
                stage.style.bottom = state === 'after' ? '0' : 'auto';
                stage.style.left = state === 'during' ? rect.left + 'px' : '0';
                stage.style.width = state === 'during' ? rect.width + 'px' : '100%';
            } else if (state === 'during') {
                stage.style.left = rect.left + 'px';
                stage.style.width = rect.width + 'px';
            }
        }

        if (relaxAncestors()) { useFixed(); }

        function readTarget() {
            var rect = root.getBoundingClientRect();
            var vh = stage.offsetHeight;
            var total = root.offsetHeight - vh;
            if (total <= 0) { target = 0; return; }

            if (pinMode === 'fixed') {
                applyFixed(rect, total);
            } else if (rect.top < -8 && rect.top > -total + 8) {
                // Safety net: sticky is expected to hold the stage at top:0
                if (Math.abs(stage.getBoundingClientRect().top) > 2) {
                    badFrames++;
                    if (badFrames > 3) { useFixed(); applyFixed(rect, total); }
                } else {
                    badFrames = 0;
                }
            }

            var raw = clamp(-rect.top / total) * (S - 1);
            var base = Math.min(Math.floor(raw), S - 1);
            var frac = raw - base;
            target = base + easeInOut(clamp((frac - 0.1) / 0.8));
        }

        // ---------- Render (transform / opacity / clip-path only) ----------
        function render(pos) {
            var intro = easeOutExpo(introT);

            items.forEach(function (it) {
                var d = pos - it.i;
                if (d <= -1.05 || d >= 1.05) {
                    it.el.style.visibility = 'hidden';
                    it.el.style.pointerEvents = 'none';
                    return;
                }
                it.el.style.visibility = 'visible';
                it.el.style.pointerEvents = Math.abs(d) < 0.5 ? 'auto' : 'none';

                var enter = it.i === 0 ? intro : clamp(1 + d);
                var exit = clamp(d);

                var clip = 'none';
                if (it.i > 0 && enter < 1) {
                    if (it.mode === 'circle') {
                        var r = easeOut(enter) * 150;
                        clip = 'circle(' + r.toFixed(2) + '% at 50% 100%)';
                    } else {
                        var off = (1 - easeOut(enter)) * 100;
                        var rad = ((1 - enter) * 80).toFixed(1);
                        clip = 'inset(0 0 0 ' + off.toFixed(2) + '% round ' + rad + 'px 0 0 ' + rad + 'px)';
                    }
                }
                it.el.style.clipPath = clip;
                it.el.style.webkitClipPath = clip;

                if (it.image) {
                    var scale = (1.25 - 0.25 * enter) * (1 + exit * 0.15) * it.baseScale;
                    var tx = 0, ty = -exit * 6;
                    if (it.i > 0) {
                        if (it.mode === 'circle') { ty += (1 - enter) * 10; }
                        else { tx = (1 - enter) * 12; }
                    }
                    it.image.style.transform = 'translate3d(' + tx.toFixed(2) + '%,' + ty.toFixed(2) + '%,0) scale(' + scale.toFixed(4) + ')';
                }

                if (it.dim) {
                    var dimV = exit * 0.7 + (it.i > 0 ? (1 - enter) * 0.25 : 0);
                    it.dim.style.opacity = clamp(dimV).toFixed(3);
                }

                if (it.ghost) {
                    it.ghost.style.transform = 'translate3d(' + (-d * 30).toFixed(2) + 'vw,0,0)';
                    it.ghost.style.opacity = ((1 - Math.abs(d)) * (it.i === 0 ? intro : 1) * 0.9).toFixed(3);
                }

                if (it.content) {
                    var co = 1 - clamp(exit * 1.8);
                    it.content.style.opacity = co.toFixed(3);
                    it.content.style.transform = 'translate3d(0,' + (-exit * 80).toFixed(1) + 'px,0)';
                }

                var wl = it.words.length;
                var step = 0.25 / Math.max(wl, 1);
                it.words.forEach(function (w, k) {
                    var local = clamp((enter - 0.35 - k * step) / 0.35);
                    var e = easeOutExpo(local);
                    w.style.transform = 'translate3d(0,' + ((1 - e) * 120).toFixed(2) + '%,0)';
                    w.style.opacity = e.toFixed(3);
                });

                it.reveals.forEach(function (rv) {
                    var idx = parseInt(rv.getAttribute('data-reveal'), 10) || 0;
                    var start = parseFloat(rv.getAttribute('data-start')) || 0.55;
                    var local = clamp((enter - start - idx * 0.04) / 0.3);
                    var e = easeOut(local);
                    rv.style.opacity = e.toFixed(3);
                    rv.style.transform = 'translate3d(0,' + ((1 - e) * 35).toFixed(1) + 'px,0)';
                });
            });

            var idx = clamp(Math.round(pos), 0, S - 1);
            if (bar) { bar.style.transform = 'scaleX(' + (pos / (S - 1)).toFixed(4) + ')'; }
            dots.forEach(function (dot, k) { dot.classList.toggle('rjsc-active', k === idx); });
            if (counter) {
                var onSlides = idx < S - 1;
                counter.style.opacity = onSlides ? '1' : '0';
                if (onSlides && currentLabel) { currentLabel.textContent = pad(idx + 1); }
            }
            if (hint) { hint.style.opacity = (clamp(1 - pos * 4) * intro).toFixed(3); }
        }

        function tick(now) {
            rafId = null;
            if (introT < 1) {
                if (introStart === null) { introStart = now; }
                introT = clamp((now - introStart) / 1600);
            }
            var k = reduceMotion ? 1 : 0.1;
            current += (target - current) * k;
            if (Math.abs(target - current) < 0.0004) { current = target; }
            render(current);
            if (current !== target || introT < 1) {
                rafId = requestAnimationFrame(tick);
            }
        }

        function request() { if (rafId === null) { rafId = requestAnimationFrame(tick); } }
        function onScroll() {
            if (!root.isConnected) {
                window.removeEventListener('scroll', onScroll, true);
                window.removeEventListener('resize', onScroll);
                return;
            }
            readTarget();
            request();
        }

        dots.forEach(function (dot, k) {
            dot.addEventListener('click', function () {
                var total = root.offsetHeight - stage.offsetHeight;
                var top = root.getBoundingClientRect().top + window.scrollY;
                window.scrollTo({ top: top + (k / (S - 1)) * total, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        });

        // capture = true also catches scrolling inside inner scroll containers
        window.addEventListener('scroll', onScroll, { passive: true, capture: true });
        window.addEventListener('resize', onScroll);

        readTarget();
        current = target;
        if (target > 0.01 || root.getBoundingClientRect().top < -50) { introT = 1; }

        render(current);
        request();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
