@php
    $allowedLayouts = ['centered', 'split'];
    $allowedBg      = ['gradient', 'solid', 'dark', 'glass'];
    $allowedRadius  = ['md', 'xl', '2xl', '3xl'];

    $layout    = in_array($settings['layout'] ?? 'centered', $allowedLayouts, true) ? $settings['layout'] : 'centered';
    $bgStyle   = in_array($settings['bg_style'] ?? 'dark', $allowedBg, true) ? $settings['bg_style'] : 'dark';
    $radius    = in_array($settings['radius'] ?? 'xl', $allowedRadius, true) ? $settings['radius'] : 'xl';
    $paddingY  = max(0, min(240, (int) ($settings['padding_y'] ?? 80)));
    $animateOn = !empty($settings['animate'] ?? true);
    $showAura  = !empty($settings['show_shapes'] ?? true);

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
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $accent     = $hexOk($settings['accent'] ?? '', '#8b5cf6');
    $accent2    = $hexOk($settings['accent2'] ?? '', '#ec4899');
    $titleColor = $hexOk($settings['title_color'] ?? '', '#0f172a');
    $textColor  = $hexOk($settings['text_color'] ?? '', '#475569');

    $isDarkBg   = in_array($bgStyle, ['gradient', 'dark'], true);
    $finalTitle = $isDarkBg ? '#ffffff' : $titleColor;
    $finalText  = $isDarkBg ? 'rgba(255,255,255,.75)' : $textColor;

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(
            e($highlight),
            '<mark class="cx-hl">' . e($highlight) . '</mark>',
            $titleHtml
        );
    }

    $radiusCss = ['md' => '16px', 'xl' => '24px', '2xl' => '32px', '3xl' => '44px'][$radius];

    $accentHex = ltrim($accent, '#');
    $ar = hexdec(substr($accentHex, 0, 2));
    $ag = hexdec(substr($accentHex, 2, 2));
    $ab = hexdec(substr($accentHex, 4, 2));

    $accent2Hex = ltrim($accent2, '#');
    $br2 = hexdec(substr($accent2Hex, 0, 2));
    $bg2 = hexdec(substr($accent2Hex, 2, 2));
    $bb2 = hexdec(substr($accent2Hex, 4, 2));
@endphp

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --b: {{ $accent2 }};
        --ar: {{ $ar }};
        --ag: {{ $ag }};
        --ab: {{ $ab }};
        --br: {{ $br2 }};
        --bg2: {{ $bg2 }};
        --bb: {{ $bb2 }};
        --ti: {{ $finalTitle }};
        --tx: {{ $finalText }};
        --rx: 50%;
        --ry: 50%;
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .cx-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        isolation: isolate;
    }

    #{{ $uid }} .cx-canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    #{{ $uid }} .cx-bg {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    #{{ $uid }}[data-bg="dark"] .cx-bg    { background: #080c18; }
    #{{ $uid }}[data-bg="gradient"] .cx-bg { background: linear-gradient(135deg, var(--a), var(--b)); }
    #{{ $uid }}[data-bg="solid"] .cx-bg   { background: #ffffff; }
    #{{ $uid }}[data-bg="glass"] .cx-bg   {
        background: rgba(255,255,255,.12);
        -webkit-backdrop-filter: blur(20px);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,.22);
    }

    #{{ $uid }} .cx-noise {
        position: absolute;
        inset: 0;
        z-index: 2;
        opacity: .055;
        pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='f'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23f)'/%3E%3C/svg%3E");
        mix-blend-mode: overlay;
    }

    #{{ $uid }} .cx-glow {
        position: absolute;
        inset: 0;
        z-index: 3;
        pointer-events: none;
        opacity: 0;
        transition: opacity .6s ease;
        background: radial-gradient(600px circle at var(--rx) var(--ry), rgba(var(--ar),var(--ag),var(--ab),.18), transparent 55%);
    }
    #{{ $uid }} .cx-wrap:hover .cx-glow { opacity: 1; }

    #{{ $uid }}[data-bg="dark"] .cx-grid-lines {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background-image:
            linear-gradient(rgba(var(--ar),var(--ag),var(--ab),.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(var(--ar),var(--ag),var(--ab),.06) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, #000 40%, transparent 100%);
    }

    #{{ $uid }} .cx-body {
        position: relative;
        z-index: 10;
        padding: {{ $layout === 'split' ? '64px 56px' : '80px 40px' }};
    }
    @media (max-width: 720px) {
        #{{ $uid }} .cx-body { padding: 52px 24px; }
    }

    #{{ $uid }} .cx-inner-centered {
        max-width: 760px;
        margin: 0 auto;
        text-align: center;
    }
    #{{ $uid }} .cx-inner-split {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 52px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .cx-inner-split {
            grid-template-columns: 1fr;
            gap: 36px;
            text-align: center;
        }
        #{{ $uid }} .cx-inner-split .cx-actions,
        #{{ $uid }} .cx-inner-split .cx-chips { justify-content: center; }
    }

    /* Badge */
    #{{ $uid }} .cx-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px 6px 8px;
        margin-bottom: 24px;
        border-radius: 999px;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        border: 1px solid rgba(var(--ar),var(--ag),var(--ab),.45);
        background: rgba(var(--ar),var(--ag),var(--ab),.12);
        color: var(--a);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-badge,
    #{{ $uid }}[data-bg="dark"] .cx-badge {
        border-color: rgba(255,255,255,.28);
        background: rgba(255,255,255,.1);
        color: #fff;
    }
    #{{ $uid }} .cx-badge-ring {
        position: relative;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--a);
        box-shadow: 0 0 0 0 rgba(var(--ar),var(--ag),var(--ab),.6);
        animation: cxPulse 2s ease-out infinite;
    }
    #{{ $uid }}[data-bg="gradient"] .cx-badge-ring,
    #{{ $uid }}[data-bg="dark"] .cx-badge-ring { background: #fff; box-shadow: 0 0 0 0 rgba(255,255,255,.5); }

    /* Title */
    #{{ $uid }} .cx-title {
        margin: 0 0 18px;
        font-size: clamp(28px, 4vw, 52px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -.03em;
        color: var(--ti);
    }
    #{{ $uid }} .cx-char {
        display: inline-block;
        opacity: 0;
        transform: translateY(40px) rotate(8deg);
        transition: opacity .5s ease, transform .6s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .cx-char.is-in {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }} .cx-char-space { display: inline-block; width: .28em; }

    /* Highlight */
    #{{ $uid }} .cx-hl {
        position: relative;
        display: inline;
        background: none;
        color: inherit;
        font-style: normal;
        white-space: nowrap;
    }
    #{{ $uid }} .cx-hl .cx-char {
        background: linear-gradient(120deg, var(--a), var(--b));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    #{{ $uid }}[data-bg="gradient"] .cx-hl .cx-char,
    #{{ $uid }}[data-bg="dark"] .cx-hl .cx-char {
        background: linear-gradient(120deg, #fff, rgba(255,255,255,.7));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .cx-hl::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -.1em;
        height: 3px;
        border-radius: 4px;
        background: linear-gradient(90deg, var(--a), var(--b));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .9s .8s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-hl::after,
    #{{ $uid }}[data-bg="dark"] .cx-hl::after { background: rgba(255,255,255,.6); }
    #{{ $uid }} .cx-title.is-in .cx-hl::after { transform: scaleX(1); }

    /* Desc */
    #{{ $uid }} .cx-desc {
        margin: 0 0 32px;
        max-width: 620px;
        font-size: 16px;
        line-height: 1.75;
        color: var(--tx);
        opacity: 0;
        transform: translateY(16px);
        transition: opacity .7s .35s ease, transform .7s .35s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .cx-desc.is-in { opacity: 1; transform: none; }
    #{{ $uid }} .cx-inner-centered .cx-desc { margin-left: auto; margin-right: auto; }

    /* Actions */
    #{{ $uid }} .cx-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 28px;
        opacity: 0;
        transform: translateY(16px);
        transition: opacity .7s .5s ease, transform .7s .5s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .cx-actions.is-in { opacity: 1; transform: none; }
    #{{ $uid }} .cx-inner-centered .cx-actions { justify-content: center; }

    #{{ $uid }} .cx-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 28px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        letter-spacing: -.01em;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .35s ease;
    }
    #{{ $uid }} .cx-btn:active { transform: scale(.96) !important; }
    #{{ $uid }} .cx-btn-icon {
        display: inline-flex;
        width: 16px;
        height: 16px;
        transition: transform .35s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .cx-btn:hover .cx-btn-icon { transform: translateX(5px); }

    #{{ $uid }} .cx-btn-p {
        background: linear-gradient(120deg, var(--a), var(--b));
        color: #fff;
        box-shadow: 0 16px 36px -14px rgba(var(--ar),var(--ag),var(--ab),.7);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-btn-p,
    #{{ $uid }}[data-bg="dark"] .cx-btn-p {
        background: #fff;
        color: var(--a);
        box-shadow: 0 16px 36px -14px rgba(0,0,0,.35);
    }
    #{{ $uid }} .cx-btn-p::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform .7s ease;
    }
    #{{ $uid }} .cx-btn-p:hover { transform: translateY(-4px); }
    #{{ $uid }} .cx-btn-p:hover::before { transform: translateX(100%); }
    #{{ $uid }} .cx-btn-p:hover { box-shadow: 0 24px 48px -16px rgba(var(--ar),var(--ag),var(--ab),.8); }

    #{{ $uid }} .cx-btn-s {
        background: transparent;
        color: var(--ti);
        border: 1.5px solid rgba(var(--ar),var(--ag),var(--ab),.4);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-btn-s,
    #{{ $uid }}[data-bg="dark"] .cx-btn-s {
        border-color: rgba(255,255,255,.35);
        color: #fff;
    }
    #{{ $uid }} .cx-btn-s:hover {
        background: rgba(var(--ar),var(--ag),var(--ab),.12);
        border-color: var(--a);
        transform: translateY(-4px);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-btn-s:hover,
    #{{ $uid }}[data-bg="dark"] .cx-btn-s:hover {
        background: rgba(255,255,255,.14);
        border-color: rgba(255,255,255,.7);
    }

    /* Chips */
    #{{ $uid }} .cx-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        opacity: 0;
        transform: translateY(12px);
        transition: opacity .6s .65s ease, transform .6s .65s ease;
    }
    #{{ $uid }} .cx-chips.is-in { opacity: 1; transform: none; }
    #{{ $uid }} .cx-inner-centered .cx-chips { justify-content: center; }
    #{{ $uid }} .cx-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: var(--ti);
        background: rgba(var(--ar),var(--ag),var(--ab),.08);
        border: 1px solid rgba(var(--ar),var(--ag),var(--ab),.2);
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), background .3s ease, box-shadow .3s ease;
    }
    #{{ $uid }}[data-bg="gradient"] .cx-chip,
    #{{ $uid }}[data-bg="dark"] .cx-chip {
        background: rgba(255,255,255,.08);
        border-color: rgba(255,255,255,.2);
        color: rgba(255,255,255,.9);
    }
    #{{ $uid }} .cx-chip:hover {
        transform: translateY(-3px);
        background: rgba(var(--ar),var(--ag),var(--ab),.18);
        box-shadow: 0 8px 20px -8px rgba(var(--ar),var(--ag),var(--ab),.4);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-chip:hover,
    #{{ $uid }}[data-bg="dark"] .cx-chip:hover {
        background: rgba(255,255,255,.18);
        box-shadow: 0 8px 20px -8px rgba(0,0,0,.3);
    }
    #{{ $uid }} .cx-chip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--a);
        flex-shrink: 0;
    }
    #{{ $uid }}[data-bg="gradient"] .cx-chip-dot,
    #{{ $uid }}[data-bg="dark"] .cx-chip-dot { background: #fff; }

    /* Image */
    #{{ $uid }} .cx-img-wrap {
        position: relative;
        opacity: 0;
        transform: translateX(24px);
        transition: opacity .8s .25s ease, transform .9s .25s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .cx-img-wrap.is-in { opacity: 1; transform: none; }
    #{{ $uid }} .cx-img-ring {
        position: absolute;
        inset: -10px;
        border-radius: 30px;
        background: conic-gradient(from 0deg, var(--a), var(--b), rgba(255,255,255,.2), var(--a));
        animation: cxSpin 8s linear infinite;
        z-index: -1;
    }
    #{{ $uid }} .cx-img-inner {
        border-radius: 22px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #111827;
    }
    #{{ $uid }} .cx-img-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 1.4s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .cx-wrap:hover .cx-img-inner img { transform: scale(1.07); }
    #{{ $uid }} .cx-img-float {
        position: absolute;
        top: -18px;
        right: -18px;
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--a), var(--b));
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 14px 28px -10px rgba(var(--ar),var(--ag),var(--ab),.6);
        animation: cxBob 4s ease-in-out infinite;
        z-index: 2;
    }
    #{{ $uid }} .cx-img-float svg { width: 26px; height: 26px; color: #fff; }

    /* Keyframes */
    @keyframes cxPulse {
        0%   { box-shadow: 0 0 0 0 rgba(var(--ar),var(--ag),var(--ab),.6); }
        70%  { box-shadow: 0 0 0 8px rgba(var(--ar),var(--ag),var(--ab),0); }
        100% { box-shadow: 0 0 0 0 rgba(var(--ar),var(--ag),var(--ab),0); }
    }
    @keyframes cxSpin { to { transform: rotate(360deg); } }
    @keyframes cxBob {
        0%, 100% { transform: translateY(0) rotate(0); }
        50%      { transform: translateY(-8px) rotate(6deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .cx-char { opacity: 1 !important; transform: none !important; transition: none !important; }
        #{{ $uid }} .cx-desc,
        #{{ $uid }} .cx-actions,
        #{{ $uid }} .cx-chips,
        #{{ $uid }} .cx-img-wrap { opacity: 1 !important; transform: none !important; transition: none !important; }
        #{{ $uid }} .cx-title.is-in .cx-hl::after { transform: scaleX(1); }
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after { animation: none !important; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}">
    <div class="cx-wrap">
        <canvas class="cx-canvas" aria-hidden="true"></canvas>
        <div class="cx-bg" aria-hidden="true"></div>
        @if($bgStyle === 'dark')
            <div class="cx-grid-lines" aria-hidden="true"></div>
        @endif
        <div class="cx-noise" aria-hidden="true"></div>
        <div class="cx-glow" aria-hidden="true"></div>

        <div class="cx-body">
            <div class="cx-inner-{{ $layout === 'split' ? 'split' : 'centered' }}">
                <div class="cx-content-col">
                    @if($badge !== '')
                        <div>
                            <span class="cx-badge">
                                <span class="cx-badge-ring"></span>
                                <span>{{ $badge }}</span>
                            </span>
                        </div>
                    @endif

                    @if($title !== '')
                        <h2 class="cx-title" data-title>{!! $titleHtml !!}</h2>
                    @endif

                    @if($desc !== '')
                        <p class="cx-desc" data-desc>{{ $desc }}</p>
                    @endif

                    @if($btn1Label !== '' || $btn2Label !== '')
                        <div class="cx-actions" data-actions>
                            @if($btn1Label !== '')
                                <a href="{{ $btn1Url }}" class="cx-btn cx-btn-p">
                                    <span>{{ $btn1Label }}</span>
                                    <span class="cx-btn-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </a>
                            @endif
                            @if($btn2Label !== '')
                                <a href="{{ $btn2Url }}" class="cx-btn cx-btn-s">
                                    <span>{{ $btn2Label }}</span>
                                </a>
                            @endif
                        </div>
                    @endif

                    @if(!empty($chips))
                        <div class="cx-chips" data-chips>
                            @foreach($chips as $chip)
                                <span class="cx-chip">
                                    <span class="cx-chip-dot"></span>
                                    <span>{{ $chip }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($layout === 'split' && $image !== '')
                    <div class="cx-img-wrap" data-img>
                        <span class="cx-img-ring"></span>
                        <div class="cx-img-inner">
                            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                        </div>
                        <span class="cx-img-float" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root   = document.getElementById(@js($uid));
    if (!root) return;

    var wrap    = root.querySelector('.cx-wrap');
    var canvas  = root.querySelector('.cx-canvas');
    var glow    = root.querySelector('.cx-glow');
    var titleEl = root.querySelector('[data-title]');
    var descEl  = root.querySelector('[data-desc]');
    var actEl   = root.querySelector('[data-actions]');
    var chipsEl = root.querySelector('[data-chips]');
    var imgEl   = root.querySelector('[data-img]');

    var reduce  = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isMouse = window.matchMedia('(hover: hover)').matches;

    /* ------- Letter-by-letter title split ------- */
    if (titleEl) {
        titleEl.querySelectorAll('.cx-hl, .cx-title').forEach(function () {});
        var wrapNode = function (node) {
            if (node.nodeType === 3) {
                var frag = document.createDocumentFragment();
                var chars = node.textContent.split('');
                chars.forEach(function (ch) {
                    if (ch === ' ') {
                        var s = document.createElement('span');
                        s.className = 'cx-char-space';
                        frag.appendChild(s);
                    } else {
                        var s = document.createElement('span');
                        s.className = 'cx-char';
                        s.textContent = ch;
                        frag.appendChild(s);
                    }
                });
                node.parentNode.replaceChild(frag, node);
            } else if (node.nodeType === 1) {
                [].slice.call(node.childNodes).forEach(wrapNode);
            }
        };
        wrapNode(titleEl);
    }

    /* ------- Intersection reveal ------- */
    var revealed = false;
    function reveal() {
        if (revealed) return;
        revealed = true;

        if (titleEl) {
            titleEl.classList.add('is-in');
            var chars = [].slice.call(titleEl.querySelectorAll('.cx-char'));
            chars.forEach(function (ch, i) {
                if (reduce) {
                    ch.classList.add('is-in');
                } else {
                    setTimeout(function () { ch.classList.add('is-in'); }, i * 38);
                }
            });
        }
        var delay = titleEl ? Math.min(titleEl.querySelectorAll('.cx-char').length * 38 + 80, 700) : 0;
        if (reduce) delay = 0;

        setTimeout(function () {
            if (descEl)  descEl.classList.add('is-in');
        }, reduce ? 0 : delay);
        setTimeout(function () {
            if (actEl)   actEl.classList.add('is-in');
        }, reduce ? 0 : delay + 120);
        setTimeout(function () {
            if (chipsEl) chipsEl.classList.add('is-in');
        }, reduce ? 0 : delay + 240);
        setTimeout(function () {
            if (imgEl)   imgEl.classList.add('is-in');
        }, reduce ? 0 : 120);
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) { reveal(); io.disconnect(); }
        }, { threshold: 0.12 });
        io.observe(wrap);
    } else {
        reveal();
    }

    /* ------- Particle canvas ------- */
    if (canvas && !reduce) {
        var ctx  = canvas.getContext('2d');
        var dots = [];
        var W, H, RAF;
        var bg = @json($bgStyle);

        var colors = bg === 'dark' || bg === 'gradient'
            ? ['rgba({{ $ar }},{{ $ag }},{{ $ab }},.55)', 'rgba({{ $br2 }},{{ $bg2 }},{{ $bb2 }},.45)', 'rgba(255,255,255,.25)']
            : ['rgba({{ $ar }},{{ $ag }},{{ $ab }},.35)', 'rgba({{ $br2 }},{{ $bg2 }},{{ $bb2 }},.3)'];

        function resize() {
            W = canvas.width  = wrap.offsetWidth;
            H = canvas.height = wrap.offsetHeight;
            if (!dots.length) init();
        }

        function init() {
            dots = [];
            var n = Math.floor((W * H) / 10000);
            n = Math.max(14, Math.min(n, 60));
            for (var i = 0; i < n; i++) {
                dots.push({
                    x: Math.random() * W,
                    y: Math.random() * H,
                    r: Math.random() * 1.6 + .4,
                    vx: (Math.random() - .5) * .35,
                    vy: (Math.random() - .5) * .35,
                    c: colors[Math.floor(Math.random() * colors.length)],
                    o: Math.random() * .6 + .2,
                    phase: Math.random() * Math.PI * 2,
                    speed: Math.random() * .02 + .008
                });
            }
        }

        function draw(ts) {
            ctx.clearRect(0, 0, W, H);
            dots.forEach(function (d) {
                d.x += d.vx;
                d.y += d.vy;
                if (d.x < -4) d.x = W + 4;
                if (d.x > W + 4) d.x = -4;
                if (d.y < -4) d.y = H + 4;
                if (d.y > H + 4) d.y = -4;
                var pulse = Math.sin(ts * d.speed + d.phase) * .3 + .7;
                ctx.beginPath();
                ctx.arc(d.x, d.y, d.r * pulse, 0, Math.PI * 2);
                ctx.fillStyle = d.c;
                ctx.globalAlpha = d.o * pulse;
                ctx.fill();
            });
            ctx.globalAlpha = 1;
            RAF = requestAnimationFrame(draw);
        }

        resize();
        RAF = requestAnimationFrame(draw);

        var ro = new ResizeObserver(function () { cancelAnimationFrame(RAF); resize(); RAF = requestAnimationFrame(draw); });
        ro.observe(wrap);
    }

    /* ------- Cursor glow + spotlight ------- */
    if (isMouse && wrap && !reduce) {
        wrap.addEventListener('pointermove', function (e) {
            var r = wrap.getBoundingClientRect();
            root.style.setProperty('--rx', (e.clientX - r.left) + 'px');
            root.style.setProperty('--ry', (e.clientY - r.top) + 'px');
        });
    }
})();
</script>
