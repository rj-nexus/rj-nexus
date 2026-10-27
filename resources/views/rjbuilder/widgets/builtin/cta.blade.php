@php
    $allowedLayouts = ['centered', 'split'];
    $allowedBg      = ['gradient', 'solid', 'dark', 'glass'];
    $allowedRadius  = ['md', 'xl', '2xl', '3xl'];

    $layout    = in_array($settings['layout'] ?? 'centered', $allowedLayouts, true) ? $settings['layout'] : 'centered';
    $bgStyle   = in_array($settings['bg_style'] ?? 'dark', $allowedBg, true) ? $settings['bg_style'] : 'dark';
    $radius    = in_array($settings['radius'] ?? 'xl', $allowedRadius, true) ? $settings['radius'] : 'xl';
    $paddingY  = max(0, min(240, (int) ($settings['padding_y'] ?? 80)));
    $animateOn = !empty($settings['animate'] ?? true);

    $badge     = trim((string) ($settings['badge'] ?? ''));
    $title     = trim((string) ($settings['title'] ?? ''));
    $highlight = trim((string) ($settings['highlight'] ?? ''));
    $desc      = trim((string) ($settings['desc'] ?? ''));
    $image     = trim((string) ($settings['image'] ?? ''));
    $btn1Label = trim((string) ($settings['btn1_label'] ?? ''));
    $btn2Label = trim((string) ($settings['btn2_label'] ?? ''));

    $safeUrl = function ($v) {
        $v = trim((string) $v);
        return ($v === '' || preg_match('/^\s*(javascript|data|vbscript):/i', $v)) ? '#' : $v;
    };
    $btn1Url = $safeUrl($settings['btn1_url'] ?? '#');
    $btn2Url = $safeUrl($settings['btn2_url'] ?? '#');

    $chips = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['chips'] ?? '')) as $c) {
        $c = trim($c);
        if ($c !== '') $chips[] = $c;
    }

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v)) return $d;
        if (strlen($v) === 4) {
            $v = '#' . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3];
        }
        return $v;
    };
    $rgb = function ($hex) {
        $h = ltrim($hex, '#');
        return hexdec(substr($h, 0, 2)) . ',' . hexdec(substr($h, 2, 2)) . ',' . hexdec(substr($h, 4, 2));
    };

    $accent     = $hexOk($settings['accent'] ?? '', '#7c5cff');
    $accent2    = $hexOk($settings['accent2'] ?? '', '#00d4ff');
    $titleColor = $hexOk($settings['title_color'] ?? '', '#0f172a');
    $textColor  = $hexOk($settings['text_color'] ?? '', '#475569');

    $isDarkBg   = in_array($bgStyle, ['gradient', 'dark'], true);
    $finalTitle = $isDarkBg ? '#ffffff' : $titleColor;
    $finalText  = $isDarkBg ? 'rgba(255,255,255,.76)' : $textColor;

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(e($highlight), '<mark class="hx-mark">' . e($highlight) . '</mark>', $titleHtml);
    }

    $radiusCss = ['md' => '14px', 'xl' => '24px', '2xl' => '34px', '3xl' => '46px'][$radius];
    $bodyPad   = $layout === 'split' ? '84px 64px 72px' : '104px 40px 88px';
@endphp

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --b: {{ $accent2 }};
        --ha: var(--a);
        --hb: var(--b);
        --ti: {{ $finalTitle }};
        --tx: {{ $finalText }};
        --px: 50%;
        --py: 40%;
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    @supports (color: color-mix(in srgb, red, blue)) {
        #{{ $uid }}[data-bg="dark"] {
            --ha: color-mix(in srgb, var(--a) 55%, #fff);
            --hb: color-mix(in srgb, var(--b) 55%, #fff);
        }
    }
    #{{ $uid }}[data-bg="gradient"] {
        --ha: #ffffff;
        --hb: rgba(255, 255, 255, .6);
    }

    #{{ $uid }} .hx-wrap {
        position: relative;
        max-width: 1160px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        isolation: isolate;
    }

    #{{ $uid }} .hx-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }
    #{{ $uid }}[data-bg="dark"] .hx-bg {
        background:
            radial-gradient(1000px 500px at 85% -10%, rgba(124, 92, 255, .12), transparent 60%),
            #060914;
    }
    #{{ $uid }}[data-bg="gradient"] .hx-bg {
        background: linear-gradient(120deg, var(--a), var(--b));
    }
    #{{ $uid }}[data-bg="solid"] .hx-bg {
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, .1);
        border-radius: inherit;
    }
    #{{ $uid }}[data-bg="glass"] .hx-bg {
        background: rgba(255, 255, 255, .14);
        -webkit-backdrop-filter: blur(18px);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: inherit;
    }

    #{{ $uid }} .hx-spot {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
        opacity: 0;
        transition: opacity .5s ease;
        background: radial-gradient(420px circle at var(--px) var(--py), rgba(255, 255, 255, .1), transparent 70%);
    }
    #{{ $uid }}[data-bg="solid"] .hx-spot,
    #{{ $uid }}[data-bg="glass"] .hx-spot {
        background: radial-gradient(420px circle at var(--px) var(--py), rgba(124, 92, 255, .1), transparent 70%);
    }
    #{{ $uid }} .hx-wrap:hover .hx-spot { opacity: 1; }

    #{{ $uid }} .hx-canvas {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        width: 100%;
        height: 100%;
    }

    #{{ $uid }} .hx-body {
        position: relative;
        z-index: 3;
        padding: {{ $bodyPad }};
    }
    @media (max-width: 720px) {
        #{{ $uid }} .hx-body { padding: 64px 22px 52px; }
    }

    #{{ $uid }} .hx-inner-centered {
        max-width: 880px;
        margin: 0 auto;
        text-align: center;
    }
    #{{ $uid }} .hx-inner-split {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        gap: 64px;
        align-items: center;
    }
    @media (max-width: 900px) {
        #{{ $uid }} .hx-inner-split {
            grid-template-columns: 1fr;
            gap: 48px;
            text-align: center;
        }
        #{{ $uid }} .hx-inner-split .hx-actions { justify-content: center; }
        #{{ $uid }} .hx-inner-split .hx-desc { margin-left: auto; margin-right: auto; }
    }

    #{{ $uid }} .hx-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 26px;
        padding: 7px 16px 7px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        color: var(--ti);
        border: 1px solid rgba(124, 92, 255, .35);
        background: rgba(124, 92, 255, .08);
    }
    #{{ $uid }}[data-bg="dark"] .hx-badge,
    #{{ $uid }}[data-bg="gradient"] .hx-badge {
        border-color: rgba(255, 255, 255, .22);
        background: rgba(255, 255, 255, .08);
    }
    #{{ $uid }} .hx-badge-dot {
        position: relative;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--b);
    }
    #{{ $uid }}[data-bg="gradient"] .hx-badge-dot { background: #fff; }
    #{{ $uid }} .hx-badge-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: inherit;
        animation: hxPing 2.2s ease-out infinite;
    }

    #{{ $uid }} .hx-title {
        margin: 0 0 26px;
        font-size: {{ $layout === 'split' ? 'clamp(36px, 5.2vw, 72px)' : 'clamp(40px, 7vw, 92px)' }};
        font-weight: 800;
        line-height: 1.04;
        letter-spacing: -.045em;
        color: var(--ti);
        text-wrap: balance;
    }

    #{{ $uid }} .hx-w {
        display: inline-block;
        overflow: hidden;
        vertical-align: top;
        padding: 0 .04em .1em;
        margin: 0 -.04em -.1em;
    }
    #{{ $uid }} .hx-wi {
        display: inline-block;
        padding-bottom: .08em;
        transform-origin: 0 100%;
    }

    #{{ $uid }} .hx-mark {
        background: none;
        color: inherit;
    }
    #{{ $uid }} .hx-mark .hx-wi,
    #{{ $uid }} .hx-mark:not(:has(.hx-wi)) {
        background-image: linear-gradient(100deg, var(--ha), var(--hb), var(--ha));
        background-size: 250% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    #{{ $uid }} .hx-desc {
        margin: 0 0 38px;
        max-width: 54ch;
        font-size: 18px;
        line-height: 1.7;
        color: var(--tx);
    }
    #{{ $uid }} .hx-inner-centered .hx-desc { margin-left: auto; margin-right: auto; }

    #{{ $uid }} .hx-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    #{{ $uid }} .hx-inner-centered .hx-actions { justify-content: center; }

    #{{ $uid }} .hx-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 16px 30px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: transform .25s cubic-bezier(.2, .8, .2, 1), box-shadow .3s ease, background-color .3s ease, border-color .3s ease;
        will-change: transform;
    }
    #{{ $uid }} .hx-btn:focus-visible {
        outline: 3px solid var(--b);
        outline-offset: 4px;
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn:focus-visible,
    #{{ $uid }}[data-bg="gradient"] .hx-btn:focus-visible { outline-color: #fff; }

    #{{ $uid }} .hx-btn-p {
        color: #fff;
        background: linear-gradient(110deg, var(--a), var(--b));
        box-shadow: 0 16px 34px -16px var(--a);
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn-p,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-p {
        color: #060914;
        background: #fff;
        box-shadow: 0 16px 34px -16px rgba(0, 0, 0, .7);
    }
    #{{ $uid }} .hx-btn-p::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(255, 255, 255, .55) 50%, transparent 65%);
        transform: translateX(-120%);
        transition: transform .8s ease;
        pointer-events: none;
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn-p::after,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-p::after {
        background: linear-gradient(105deg, transparent 35%, rgba(124, 92, 255, .28) 50%, transparent 65%);
    }
    #{{ $uid }} .hx-btn-p:hover::after { transform: translateX(120%); }

    #{{ $uid }} .hx-btn-s {
        color: var(--ti);
        background: transparent;
        border: 1.5px solid rgba(124, 92, 255, .4);
    }
    #{{ $uid }} .hx-btn-s:hover { background: rgba(124, 92, 255, .1); border-color: var(--a); }
    #{{ $uid }}[data-bg="dark"] .hx-btn-s,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-s { border-color: rgba(255, 255, 255, .32); }
    #{{ $uid }}[data-bg="dark"] .hx-btn-s:hover,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-s:hover {
        background: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .75);
    }

    #{{ $uid }} .hx-media {
        position: relative;
        margin: 0;
        perspective: 1000px;
    }
    #{{ $uid }} .hx-tilt {
        position: relative;
        transform-style: preserve-3d;
        transition: transform .35s cubic-bezier(.2, .8, .2, 1);
        will-change: transform;
    }
    #{{ $uid }} .hx-media-frame {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 5;
        border-radius: 26px;
        background: #0f1424;
        box-shadow: 0 40px 80px -36px rgba(0, 0, 0, .75);
        border: 1px solid rgba(255, 255, 255, .18);
    }
    #{{ $uid }} .hx-media-frame img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    #{{ $uid }} .hx-media-frame::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(360px circle at var(--gx, 50%) var(--gy, 0%), rgba(255, 255, 255, .28), transparent 60%);
        opacity: 0;
        transition: opacity .3s ease;
    }
    #{{ $uid }} .hx-media:hover .hx-media-frame::after { opacity: 1; }
    @media (max-width: 900px) {
        #{{ $uid }} .hx-media-frame { aspect-ratio: 4 / 3; }
        #{{ $uid }} .hx-media { max-width: 520px; margin: 0 auto; }
    }

    #{{ $uid }} .hx-marquee {
        position: relative;
        z-index: 3;
        overflow: hidden;
        padding: 20px 0;
        border-top: 1px solid rgba(124, 92, 255, .22);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
        mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
    }
    #{{ $uid }}[data-bg="dark"] .hx-marquee,
    #{{ $uid }}[data-bg="gradient"] .hx-marquee { border-top-color: rgba(255, 255, 255, .16); }
    #{{ $uid }} .hx-track {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px 0;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #{{ $uid }} .hx-item {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        margin-right: 44px;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
        color: var(--tx);
    }
    #{{ $uid }} .hx-item svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        color: var(--b);
    }
    #{{ $uid }}[data-bg="gradient"] .hx-item svg { color: #fff; }

    @keyframes hxPing {
        0%   { transform: scale(1); opacity: .7; }
        80%, 100% { transform: scale(3.2); opacity: 0; }
    }
    @keyframes hxFlow {
        0%   { background-position: 0% 50%; }
        100% { background-position: 250% 50%; }
    }
    @keyframes hxScroll {
        to { transform: translateX(var(--shift, -50%)); }
    }

    @media (prefers-reduced-motion: no-preference) {
        #{{ $uid }}.hx-js[data-animate="1"] .hx-wi {
            transform: translateY(115%) rotate(5deg);
            transition: transform 1s cubic-bezier(.2, .9, .2, 1) var(--d, 0ms);
        }
        #{{ $uid }}.hx-js[data-animate="1"].is-in .hx-wi { transform: none; }

        #{{ $uid }}.hx-js[data-animate="1"] .hx-rise {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .8s ease var(--dl, 0ms), transform .9s cubic-bezier(.2, .8, .2, 1) var(--dl, 0ms);
        }
        #{{ $uid }}.hx-js[data-animate="1"].is-in .hx-rise { opacity: 1; transform: none; }

        #{{ $uid }}.hx-js[data-animate="1"] .hx-media-frame {
            clip-path: inset(0 0 100% 0 round 26px);
            transition: clip-path 1.2s cubic-bezier(.7, 0, .2, 1) 350ms;
        }
        #{{ $uid }}.hx-js[data-animate="1"].is-in .hx-media-frame { clip-path: inset(0 0 0 0 round 26px); }
        #{{ $uid }}.hx-js[data-animate="1"] .hx-media-frame img {
            transform: scale(1.35);
            transition: transform 1.8s cubic-bezier(.2, .8, .2, 1) 350ms;
        }
        #{{ $uid }}.hx-js[data-animate="1"].is-in .hx-media-frame img { transform: none; }

        #{{ $uid }}.hx-js[data-animate="1"] .hx-canvas {
            opacity: 0;
            transition: opacity 2s ease .2s;
        }
        #{{ $uid }}.hx-js[data-animate="1"].is-in .hx-canvas { opacity: 1; }

        #{{ $uid }}[data-animate="1"] .hx-mark .hx-wi { animation: hxFlow 7s linear infinite; }

        #{{ $uid }}[data-animate="1"] .hx-track {
            flex-wrap: nowrap;
            justify-content: flex-start;
            width: max-content;
            animation: hxScroll var(--dur, 30s) linear infinite;
        }
        #{{ $uid }}[data-animate="1"] .hx-marquee:hover .hx-track { animation-play-state: paused; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}" data-animate="{{ $animateOn ? '1' : '0' }}">
    <div class="hx-wrap">
        <div class="hx-bg" aria-hidden="true"></div>
        <div class="hx-spot" aria-hidden="true"></div>
        <canvas class="hx-canvas" aria-hidden="true"></canvas>

        <div class="hx-body">
            <div class="hx-inner-{{ $layout === 'split' ? 'split' : 'centered' }}">
                <div class="hx-content">
                    @if($badge !== '')
                        <p class="hx-badge hx-rise" style="--dl:0ms">
                            <span class="hx-badge-dot" aria-hidden="true"></span>
                            <span>{{ $badge }}</span>
                        </p>
                    @endif

                    @if($title !== '')
                        <h2 class="hx-title" data-title>{!! $titleHtml !!}</h2>
                    @endif

                    @if($desc !== '')
                        <p class="hx-desc hx-rise" style="--dl:700ms">{{ $desc }}</p>
                    @endif

                    @if($btn1Label !== '' || $btn2Label !== '')
                        <div class="hx-actions hx-rise" style="--dl:850ms">
                            @if($btn1Label !== '')
                                <a href="{{ $btn1Url }}" class="hx-btn hx-btn-p" data-magnet>{{ $btn1Label }}</a>
                            @endif
                            @if($btn2Label !== '')
                                <a href="{{ $btn2Url }}" class="hx-btn hx-btn-s" data-magnet>{{ $btn2Label }}</a>
                            @endif
                        </div>
                    @endif
                </div>

                @if($layout === 'split' && $image !== '')
                    <figure class="hx-media" data-media>
                        <div class="hx-tilt" data-tilt>
                            <div class="hx-media-frame">
                                <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                            </div>
                        </div>
                    </figure>
                @endif
            </div>
        </div>

        @if(!empty($chips))
            <div class="hx-marquee hx-rise" style="--dl:1000ms" data-marquee>
                <ul class="hx-track" data-track>
                    @foreach($chips as $chip)
                        <li class="hx-item">
                            <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l2.2 7.8L22 12l-7.8 2.2L12 22l-2.2-7.8L2 12l7.8-2.2z"/></svg>
                            <span>{{ $chip }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var wrap    = root.querySelector('.hx-wrap');
    var canvas  = root.querySelector('.hx-canvas');
    var titleEl = root.querySelector('[data-title]');
    var media   = root.querySelector('[data-media]');
    var tilt    = root.querySelector('[data-tilt]');
    var frame   = root.querySelector('.hx-media-frame');
    var marq    = root.querySelector('[data-marquee]');
    var track   = root.querySelector('[data-track]');

    var animate = root.getAttribute('data-animate') === '1';
    var reduce  = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var live    = animate && !reduce;
    var fine    = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    var colA  = @json($rgb($accent));
    var colB  = @json($rgb($accent2));
    var glow  = @json($isDarkBg);

    root.classList.add('hx-js');

    function splitWords(node, ctr) {
        if (node.nodeType === 3) {
            var frag  = document.createDocumentFragment();
            var parts = node.textContent.split(/(\s+)/);
            parts.forEach(function (p) {
                if (!p) return;
                if (/^\s+$/.test(p)) {
                    frag.appendChild(document.createTextNode(' '));
                    return;
                }
                var o = document.createElement('span');
                var i = document.createElement('span');
                o.className = 'hx-w';
                i.className = 'hx-wi';
                i.style.setProperty('--d', (160 + ctr.n * 75) + 'ms');
                i.textContent = p;
                ctr.n++;
                o.appendChild(i);
                frag.appendChild(o);
            });
            node.parentNode.replaceChild(frag, node);
        } else if (node.nodeType === 1) {
            [].slice.call(node.childNodes).forEach(function (c) { splitWords(c, ctr); });
        }
    }
    if (titleEl && live) splitWords(titleEl, { n: 0 });

    function show() { root.classList.add('is-in'); }

    var fieldRunning = false;
    var startField = function () {};
    var stopField = function () {};

    if (canvas && canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var W = 0, H = 0, dpr = 1, t = Math.random() * 100, raf = 0;
        var mx = -9999, my = -9999, mon = false;
        var P = [];
        var C = [
            'rgba(' + colA + ',.8)',
            'rgba(' + colB + ',.8)',
            glow ? 'rgba(255,255,255,.5)' : 'rgba(' + colA + ',.45)'
        ];

        function spawn(p) {
            p.x = Math.random() * W;
            p.y = Math.random() * H;
            p.px = p.x;
            p.py = p.y;
            p.life = 90 + Math.random() * 240;
            p.s = .8 + Math.random() * 1.2;
            p.c = Math.floor(Math.random() * 3);
        }

        function size() {
            dpr = Math.min(window.devicePixelRatio || 1, 2);
            W = wrap.offsetWidth;
            H = wrap.offsetHeight;
            canvas.width = Math.round(W * dpr);
            canvas.height = Math.round(H * dpr);
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            var n = Math.max(90, Math.min(380, Math.round((W * H) / 3200)));
            P = [];
            for (var i = 0; i < n; i++) {
                var p = {};
                spawn(p);
                P.push(p);
            }
        }

        function angle(x, y) {
            var s = .0026;
            return (Math.sin(x * s * 2.1 + t) * Math.cos(y * s * 1.7 - t * .8) + Math.sin((x + y) * s * 1.3 + t * .6) * .6) * Math.PI * 1.35;
        }

        function step() {
            ctx.globalCompositeOperation = 'destination-out';
            ctx.fillStyle = 'rgba(0,0,0,.09)';
            ctx.fillRect(0, 0, W, H);
            ctx.globalCompositeOperation = glow ? 'lighter' : 'source-over';
            ctx.lineWidth = 1.3;
            ctx.lineCap = 'round';

            for (var i = 0; i < P.length; i++) {
                var p = P[i];
                var a = angle(p.x, p.y);
                var vx = Math.cos(a) * p.s;
                var vy = Math.sin(a) * p.s;
                if (mon) {
                    var dx = p.x - mx, dy = p.y - my;
                    var d = Math.sqrt(dx * dx + dy * dy);
                    if (d < 180 && d > .001) {
                        var w = 1 - d / 180;
                        vx += (-dy / d) * w * 3.2 + (dx / d) * w * 1.4;
                        vy += (dx / d) * w * 3.2 + (dy / d) * w * 1.4;
                    }
                }
                p.px = p.x;
                p.py = p.y;
                p.x += vx;
                p.y += vy;
                p.life--;
                if (p.life <= 0 || p.x < -10 || p.x > W + 10 || p.y < -10 || p.y > H + 10) spawn(p);
            }

            for (var c = 0; c < 3; c++) {
                ctx.beginPath();
                for (var j = 0; j < P.length; j++) {
                    var q = P[j];
                    if (q.c !== c) continue;
                    ctx.moveTo(q.px, q.py);
                    ctx.lineTo(q.x, q.y);
                }
                ctx.strokeStyle = C[c];
                ctx.stroke();
            }
            t += .0035;
        }

        function loop() {
            if (!fieldRunning) return;
            step();
            raf = requestAnimationFrame(loop);
        }

        startField = function () {
            if (fieldRunning) return;
            fieldRunning = true;
            raf = requestAnimationFrame(loop);
        };
        stopField = function () {
            fieldRunning = false;
            cancelAnimationFrame(raf);
        };

        function paintStatic() {
            size();
            for (var k = 0; k < 220; k++) step();
        }

        size();

        if (live) {
            var rt = 0;
            if ('ResizeObserver' in window) {
                new ResizeObserver(function () {
                    clearTimeout(rt);
                    rt = setTimeout(size, 150);
                }).observe(wrap);
            }
            if (fine) {
                wrap.addEventListener('pointermove', function (e) {
                    var r = wrap.getBoundingClientRect();
                    mx = e.clientX - r.left;
                    my = e.clientY - r.top;
                    mon = true;
                    root.style.setProperty('--px', mx + 'px');
                    root.style.setProperty('--py', my + 'px');
                });
                wrap.addEventListener('pointerleave', function () { mon = false; });
            }
        } else {
            paintStatic();
        }
    }

    function setupMarquee() {
        if (!track || !live) return;
        [].slice.call(track.querySelectorAll('[data-clone]')).forEach(function (n) { n.remove(); });
        track.style.removeProperty('--shift');
        var originals = [].slice.call(track.children);
        var groupW = track.scrollWidth;
        if (!groupW) return;
        var copies = Math.max(1, Math.ceil(marq.offsetWidth / groupW));
        for (var k = 0; k < copies; k++) {
            originals.forEach(function (li) {
                var cl = li.cloneNode(true);
                cl.setAttribute('aria-hidden', 'true');
                cl.setAttribute('data-clone', '1');
                track.appendChild(cl);
            });
        }
        track.style.setProperty('--shift', '-' + groupW + 'px');
        track.style.setProperty('--dur', Math.max(18, Math.round(groupW / 55)) + 's');
    }
    setupMarquee();
    window.addEventListener('load', setupMarquee);

    if (live && fine) {
        [].slice.call(root.querySelectorAll('[data-magnet]')).forEach(function (b) {
            b.addEventListener('pointermove', function (e) {
                var r = b.getBoundingClientRect();
                var x = (e.clientX - r.left - r.width / 2) * .24;
                var y = (e.clientY - r.top - r.height / 2) * .4;
                b.style.transform = 'translate(' + x + 'px,' + y + 'px)';
            });
            b.addEventListener('pointerleave', function () { b.style.transform = ''; });
        });

        if (media && tilt && frame) {
            media.addEventListener('pointermove', function (e) {
                var r = media.getBoundingClientRect();
                var px = (e.clientX - r.left) / r.width;
                var py = (e.clientY - r.top) / r.height;
                tilt.style.transform = 'rotateY(' + ((px - .5) * 16) + 'deg) rotateX(' + ((.5 - py) * 16) + 'deg)';
                frame.style.setProperty('--gx', (px * 100) + '%');
                frame.style.setProperty('--gy', (py * 100) + '%');
            });
            media.addEventListener('pointerleave', function () { tilt.style.transform = ''; });
        }
    }

    if ('IntersectionObserver' in window) {
        var seen = false;
        new IntersectionObserver(function (entries) {
            var on = entries[0].isIntersecting;
            if (on && !seen) {
                seen = true;
                show();
            }
            if (live) { on ? startField() : stopField(); }
        }, { threshold: 0.12 }).observe(wrap);
    } else {
        show();
        if (live) startField();
    }
})();
</script>
