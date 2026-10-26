@php
    $slides = array_map(function ($s) {
        $s['title_html'] = str_replace('rjsc-accent', 'sh-accent', (string) ($s['title_html'] ?? ''));
        return $s;
    }, $slides);
    $final['title_html'] = str_replace('rjsc-accent', 'sh-accent', (string) ($final['title_html'] ?? ''));

    $count = count($slides);
    $sectionHeight = ($count + 1) * $o['step_vh'];
    $pad = fn ($n) => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
@endphp

<style>
    #{{ $uid }} { position: relative; z-index: 0; isolation: isolate; width: 100%; height: {{ $sectionHeight }}vh; height: {{ $sectionHeight }}svh; background: #020617; overflow-anchor: none; --sh-accent: {{ $o['accent'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .sh-stage { position: sticky; top: 0; width: 100%; height: 100vh; height: 100svh; overflow: hidden; }

    #{{ $uid }} .sh-slide { position: absolute; inset: 0; overflow: hidden; will-change: clip-path; backface-visibility: hidden; }
    #{{ $uid }} .sh-slide:not(:first-child) { visibility: hidden; }
    #{{ $uid }} .sh-image { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; object-fit: cover; display: block; transform-origin: 50% 50%; will-change: transform; }
    #{{ $uid }} .sh-image.sh-blurred { filter: blur(22px) saturate(1.15); opacity: .6; }
    #{{ $uid }} .sh-tint { position: absolute; inset: 0; pointer-events: none; background: radial-gradient(120% 90% at 85% 0%, color-mix(in srgb, var(--sh-accent) 34%, transparent) 0%, transparent 60%); mix-blend-mode: screen; }
    #{{ $uid }} .sh-shade { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(to top, rgba(2, 6, 23, .92) 0%, rgba(2, 6, 23, .3) 55%, rgba(2, 6, 23, .05) 100%); }
    #{{ $uid }} .sh-side { position: absolute; inset: 0; pointer-events: none; }
    #{{ $uid }} .sh-slide[data-align="left"] .sh-side { background: linear-gradient(90deg, rgba(2, 6, 23, .85) 0%, rgba(2, 6, 23, .35) 45%, transparent 80%); }
    #{{ $uid }} .sh-slide[data-align="right"] .sh-side { background: linear-gradient(270deg, rgba(2, 6, 23, .85) 0%, rgba(2, 6, 23, .35) 45%, transparent 80%); }
    #{{ $uid }} .sh-slide[data-align="center"] .sh-side { background: radial-gradient(ellipse at center, rgba(2, 6, 23, .6) 0%, transparent 75%); }
    #{{ $uid }} .sh-dim { position: absolute; inset: 0; background: #020617; opacity: 0; pointer-events: none; }

    #{{ $uid }} .sh-frame { position: absolute; inset: 24px; z-index: 2; border: 1px solid rgba(255, 255, 255, .16); border-radius: 28px; pointer-events: none; }
    #{{ $uid }} .sh-final .sh-frame { border-color: color-mix(in srgb, var(--sh-accent) 40%, transparent); }

    #{{ $uid }} .sh-ghost { position: absolute; top: 8%; right: 3vw; z-index: 1; font-size: clamp(9rem, 30vw, 28rem); font-weight: 900; line-height: .8; letter-spacing: -.05em; color: transparent; -webkit-text-stroke: 1.5px rgba(255, 255, 255, .18); pointer-events: none; user-select: none; will-change: transform, opacity; }
    #{{ $uid }} .sh-slide[data-align="right"] .sh-ghost { right: auto; left: 3vw; }

    #{{ $uid }} .sh-content { position: absolute; inset: 0; z-index: 3; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; text-align: center; padding: 72px clamp(28px, 7vw, 96px) clamp(72px, 12vh, 120px); will-change: transform, opacity; }
    #{{ $uid }} .sh-slide[data-align="left"] .sh-content { align-items: flex-start; text-align: left; }
    #{{ $uid }} .sh-slide[data-align="right"] .sh-content { align-items: flex-end; text-align: right; }
    #{{ $uid }} .sh-card { display: flex; flex-direction: column; align-items: inherit; gap: 22px; width: 100%; max-width: 44rem; padding: clamp(24px, 3vw, 44px); border-radius: 28px; background: rgba(2, 6, 23, .28); border: 1px solid rgba(255, 255, 255, .12); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); box-shadow: 0 30px 60px -30px rgba(0, 0, 0, .6); }

    #{{ $uid }} .sh-label { display: inline-flex; align-items: center; gap: 10px; align-self: inherit; padding: 7px 14px; border-radius: 999px; font-size: .7rem; font-weight: 700; letter-spacing: .24em; text-transform: uppercase; color: #fff; background: color-mix(in srgb, var(--sh-accent) 22%, transparent); border: 1px solid color-mix(in srgb, var(--sh-accent) 55%, transparent); }
    #{{ $uid }} .sh-label::before { content: ""; width: 7px; height: 7px; border-radius: 999px; background: var(--sh-accent); box-shadow: 0 0 12px var(--sh-accent); }

    #{{ $uid }} .sh-title { margin: 0; padding: 0; font-size: clamp(2.25rem, 5.6vw, 5rem); font-weight: 900; line-height: 1.02; letter-spacing: -.035em; color: #fff; text-shadow: 0 4px 30px rgba(0, 0, 0, .4); }
    #{{ $uid }} .sh-final .sh-title { font-size: clamp(2.6rem, 8vw, 7rem); }
    #{{ $uid }} .sh-accent { color: var(--sh-accent); text-shadow: 0 0 28px color-mix(in srgb, var(--sh-accent) 60%, transparent); }
    #{{ $uid }} .sh-text { margin: 0; max-width: 34rem; font-size: clamp(1rem, 1.5vw, 1.2rem); line-height: 1.7; color: rgba(255, 255, 255, .82); }

    #{{ $uid }} .sh-btn { position: relative; display: inline-flex; align-items: center; gap: 14px; margin-top: 6px; padding: 8px 8px 8px 28px; border-radius: 999px; background: #fff; color: #0f172a !important; font-size: .8rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; text-decoration: none !important; box-shadow: 0 18px 40px rgba(0, 0, 0, .35); transition: transform .4s cubic-bezier(.34, 1.4, .64, 1), box-shadow .4s ease; }
    #{{ $uid }} .sh-btn::after { content: ""; position: absolute; inset: 0; border-radius: inherit; background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, .6) 50%, transparent 70%); transform: translateX(-120%); transition: transform .8s ease; }
    #{{ $uid }} .sh-btn span { position: relative; z-index: 1; }
    #{{ $uid }} .sh-btn i { position: relative; z-index: 1; display: grid; place-items: center; width: 40px; height: 40px; border-radius: 999px; background: var(--sh-accent); color: #fff; transition: transform .4s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }} .sh-btn i svg { width: 18px; height: 18px; }
    #{{ $uid }} .sh-btn:hover, #{{ $uid }} .sh-btn:focus-visible { transform: translateY(-3px); box-shadow: 0 24px 50px -12px var(--sh-accent); }
    #{{ $uid }} .sh-btn:hover::after { transform: translateX(120%); }
    #{{ $uid }} .sh-btn:hover i { transform: translateX(4px) rotate(-12deg); }

    #{{ $uid }} .sh-word { display: inline-block; overflow: hidden; vertical-align: top; padding-bottom: .12em; margin-bottom: -.12em; }
    #{{ $uid }} .sh-word > span { display: inline-block; will-change: transform; }
    #{{ $uid }}.sh-ready [data-reveal] { opacity: 0; will-change: transform, opacity; }

    #{{ $uid }} .sh-hud { position: absolute; inset: 0; z-index: 50; pointer-events: none; }
    #{{ $uid }} .sh-progress { position: absolute; top: 0; bottom: 0; left: 0; width: 3px; background: rgba(255, 255, 255, .1); }
    #{{ $uid }} .sh-progress > span { display: block; width: 100%; height: 100%; background: linear-gradient(to bottom, #fff, var(--sh-accent)); transform-origin: 50% 0; transform: scaleY(0); }
    #{{ $uid }} .sh-counter { position: absolute; left: 24px; top: 24px; display: flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px; color: #fff; background: rgba(2, 6, 23, .35); border: 1px solid rgba(255, 255, 255, .15); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); font-variant-numeric: tabular-nums; transition: opacity .4s ease; }
    #{{ $uid }} .sh-current { font-size: .95rem; font-weight: 800; color: var(--sh-accent); }
    #{{ $uid }} .sh-total { font-size: .8rem; font-weight: 600; color: rgba(255, 255, 255, .55); }
    #{{ $uid }} .sh-dots { position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 12px; pointer-events: auto; }
    #{{ $uid }} .sh-dot { position: relative; width: 8px; height: 8px; margin: 0; padding: 0; border: 0; border-radius: 999px; background: rgba(255, 255, 255, .35); cursor: pointer; transition: height .5s cubic-bezier(.4, 0, .2, 1), background .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .sh-dot.sh-active { height: 30px; background: var(--sh-accent); box-shadow: 0 0 16px var(--sh-accent); }
    #{{ $uid }} .sh-hint { position: absolute; left: 50%; bottom: 26px; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 10px; color: rgba(255, 255, 255, .8); font-size: .65rem; font-weight: 700; letter-spacing: .32em; text-transform: uppercase; }
    #{{ $uid }} .sh-hint i { display: block; width: 1px; height: 36px; background: linear-gradient(to bottom, #fff, transparent); animation: {{ $uid }}-hint 1.8s ease-in-out infinite; }

    @keyframes {{ $uid }}-hint {
        0% { transform: scaleY(0); transform-origin: top; }
        50% { transform: scaleY(1); transform-origin: top; }
        51% { transform-origin: bottom; }
        100% { transform: scaleY(0); transform-origin: bottom; }
    }

    @media (min-width: 768px) {
        #{{ $uid }} .sh-dots { right: 2.5rem; }
        #{{ $uid }} .sh-counter { left: 40px; top: 40px; }
        #{{ $uid }} .sh-frame { inset: 40px; }
    }

    @media (max-width: 640px) {
        #{{ $uid }} .sh-content { padding: 64px 18px 84px; justify-content: flex-end; }
        #{{ $uid }} .sh-card { padding: 22px; border-radius: 22px; }
        #{{ $uid }} .sh-frame { inset: 12px; border-radius: 20px; }
        #{{ $uid }} .sh-dots { right: .6rem; gap: 9px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .sh-hint i { animation: none; }
    }
</style>

<section id="{{ $uid }}" aria-roledescription="carousel" aria-label="{{ __('Animated Scroll Hero') }}">
    <div class="sh-stage">

        @foreach ($slides as $i => $s)
            @php
                $hasBtn  = $s['btn_text'] !== '' && $s['btn_url'] !== '';
                $hasText = $s['label'] !== '' || $s['title_html'] !== '' || $s['text'] !== '' || $hasBtn;
            @endphp
            <article class="sh-slide" data-align="{{ $s['align'] }}" style="z-index: {{ $i + 1 }};">
                <img class="sh-image" src="{{ $s['image'] }}" alt="{{ $s['title'] }}" decoding="async" @if($i === 0) fetchpriority="high" @endif>
                <div class="sh-tint"></div>
                <div class="sh-shade"></div>
                @if ($hasText)
                    <div class="sh-side"></div>
                @endif
                <div class="sh-ghost" aria-hidden="true">{{ $pad($i + 1) }}</div>
                <span class="sh-frame" aria-hidden="true"></span>

                @if ($hasText)
                    <div class="sh-content">
                        <div class="sh-card">
                            @if ($s['label'] !== '')
                                <div data-reveal="0" data-start=".2"><span class="sh-label">{{ $s['label'] }}</span></div>
                            @endif

                            @if ($s['title_html'] !== '')
                                <h2 data-split class="sh-title">{!! $s['title_html'] !!}</h2>
                            @endif

                            @if ($s['text'] !== '')
                                <div data-reveal="1" data-start=".6"><p class="sh-text">{!! nl2br(e($s['text'])) !!}</p></div>
                            @endif

                            @if ($hasBtn)
                                <div data-reveal="2" data-start=".68">
                                    <a href="{{ $s['btn_url'] }}" class="sh-btn">
                                        <span>{{ $s['btn_text'] }}</span>
                                        <i><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="sh-dim"></div>
            </article>
        @endforeach

        <article class="sh-slide sh-final" data-align="center" style="z-index: {{ $count + 1 }};">
            <img class="sh-image {{ $final['blurred'] ? 'sh-blurred' : '' }}" src="{{ $final['image'] }}" alt="{{ $final['title'] }}" decoding="async">
            <div class="sh-tint"></div>
            <div class="sh-shade"></div>
            <span class="sh-frame" aria-hidden="true"></span>

            <div class="sh-content">
                <div class="sh-card">
                    @if ($final['label'] !== '')
                        <div data-reveal="0" data-start=".2"><span class="sh-label">{{ $final['label'] }}</span></div>
                    @endif

                    @if ($final['title_html'] !== '')
                        <h2 data-split class="sh-title">{!! $final['title_html'] !!}</h2>
                    @endif

                    @if ($final['btn_text'] !== '' && $final['btn_url'] !== '')
                        <div data-reveal="2" data-start=".68">
                            <a href="{{ $final['btn_url'] }}" class="sh-btn">
                                <span>{{ $final['btn_text'] }}</span>
                                <i><svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </article>

        <div class="sh-hud">
            @if ($o['show_counter'])
                <div class="sh-counter" aria-hidden="true">
                    <span class="sh-current">01</span>
                    <span class="sh-total">/ {{ $pad($count) }}</span>
                </div>
            @endif

            @if ($o['show_dots'])
                <div class="sh-dots">
                    @for ($k = 0; $k < $count; $k++)
                        <button type="button" class="sh-dot" aria-label="{{ __('Go to slide') }} {{ $k + 1 }}"></button>
                    @endfor
                </div>
            @endif

            @if ($o['show_hint'])
                <div class="sh-hint" aria-hidden="true"><span>{{ __('Scroll') }}</span><i></i></div>
            @endif

            <div class="sh-progress"><span></span></div>
        </div>
    </div>
</section>

<script>
(function () {
    function init() {
        var root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.ready) { return; }
        root.dataset.ready = '1';

        var stage = root.querySelector('.sh-stage');
        var slideEls = Array.prototype.slice.call(root.querySelectorAll('.sh-slide'));
        var S = slideEls.length;
        if (S < 2) { return; }

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var revealMode = '{{ $o['reveal'] }}';

        function clamp(v, a, b) { return Math.min(Math.max(v, a === undefined ? 0 : a), b === undefined ? 1 : b); }
        function easeOut(t) { return 1 - Math.pow(1 - t, 3); }
        function easeInOut(t) { return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; }
        function easeOutExpo(t) { return t === 1 ? 1 : 1 - Math.pow(2, -10 * t); }
        function pad(n) { return n < 10 ? '0' + n : String(n); }

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
                outer.className = 'sh-word';
                outer.setAttribute('aria-hidden', 'true');
                var inner = document.createElement('span');
                inner.textContent = t.w;
                if (t.cls) { inner.className = t.cls; }
                outer.appendChild(inner);
                el.appendChild(outer);
                if (idx < tokens.length - 1) { el.appendChild(document.createTextNode(' ')); }
            });
        });

        root.classList.add('sh-ready');

        var items = slideEls.map(function (el, i) {
            var image = el.querySelector('.sh-image');
            return {
                el: el,
                i: i,
                mode: revealMode === 'mixed' ? (i % 2 === 0 ? 'inset' : 'circle') : revealMode,
                image: image,
                baseScale: image && image.classList.contains('sh-blurred') ? 1.15 : 1,
                dim: el.querySelector('.sh-dim'),
                ghost: el.querySelector('.sh-ghost'),
                content: el.querySelector('.sh-content'),
                words: Array.prototype.slice.call(el.querySelectorAll('.sh-word > span')),
                reveals: Array.prototype.slice.call(el.querySelectorAll('[data-reveal]'))
            };
        });

        var bar = root.querySelector('.sh-progress > span');
        var dots = Array.prototype.slice.call(root.querySelectorAll('.sh-dot'));
        var counter = root.querySelector('.sh-counter');
        var currentLabel = root.querySelector('.sh-current');
        var hint = root.querySelector('.sh-hint');

        var target = 0;
        var current = 0;
        var introT = reduceMotion ? 1 : 0;
        var introStart = null;
        var rafId = null;

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
            if (bar) { bar.style.transform = 'scaleY(' + (pos / (S - 1)).toFixed(4) + ')'; }
            dots.forEach(function (dot, k) { dot.classList.toggle('sh-active', k === idx); });
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
