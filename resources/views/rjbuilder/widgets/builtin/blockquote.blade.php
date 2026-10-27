@php
    $style      = in_array($settings['style'] ?? 'accent-bar', ['accent-bar', 'card', 'gradient', 'big-marks', 'minimal'], true) ? $settings['style'] : 'accent-bar';
    $quote      = trim((string) ($settings['quote'] ?? ''));
    $author     = trim((string) ($settings['author'] ?? ''));
    $role       = trim((string) ($settings['role'] ?? ''));
    $avatar     = trim((string) ($settings['avatar'] ?? ''));
    $align      = in_array($settings['align'] ?? 'left', ['left', 'center', 'right'], true) ? $settings['align'] : 'left';
    $size       = $settings['size'] ?? 'lg';
    $hex        = fn ($v, $d) => preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', trim((string) $v)) ? trim((string) $v) : $d;
    $accent     = $hex($settings['accent'] ?? null, '#8b5cf6');
    $accent2    = $hex($settings['accent2'] ?? null, '#ec4899');
    $textColor  = $hex($settings['text_color'] ?? null, '#0f172a');
    $showMarks  = filter_var($settings['show_marks'] ?? true, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
    $animate    = filter_var($settings['animate'] ?? true, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
    $paddingY   = max(0, min(200, (int) ($settings['padding_y'] ?? 40)));

    $sizeMap = [
        'md' => 'clamp(17px, 1.7vw, 21px)',
        'lg' => 'clamp(21px, 2.3vw, 28px)',
        'xl' => 'clamp(25px, 3vw, 38px)',
    ];
    $sizeCss = $sizeMap[$size] ?? $sizeMap['lg'];

    $lines = preg_split('/\R/u', $quote) ?: [];
    $n = 0;
@endphp

<style>
    @property --bq-angle { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    @keyframes bqWord-{{ $uid }} {
        from { opacity: 0; transform: translateY(18px) scale(.96); filter: blur(10px); }
        to   { opacity: 1; transform: none; filter: blur(0); }
    }
    @keyframes bqUp-{{ $uid }} {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes bqBar-{{ $uid }} {
        from { transform: scaleY(0); }
        to   { transform: scaleY(1); }
    }
    @keyframes bqDot-{{ $uid }} {
        0%   { top: 0; opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    @keyframes bqSpin-{{ $uid }} { to { --bq-angle: 360deg; } }
    @keyframes bqRotate-{{ $uid }} { to { transform: rotate(360deg); } }
    @keyframes bqFlow-{{ $uid }} {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes bqFloat-{{ $uid }} {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-12px) rotate(4deg); }
    }
    @keyframes bqBlobA-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(50px, 30px) scale(1.2); }
    }
    @keyframes bqBlobB-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(-60px, -20px) scale(1.15); }
    }
    @keyframes bqShine-{{ $uid }} {
        0%   { transform: translateX(-160%) skewX(-18deg); }
        60%, 100% { transform: translateX(260%) skewX(-18deg); }
    }
    @keyframes bqMark-{{ $uid }} {
        from { opacity: 0; transform: scale(.3) rotate(-25deg); }
        to   { opacity: .95; transform: none; }
    }
    @keyframes bqLine-{{ $uid }} {
        from { transform: scaleX(0); }
        to   { transform: scaleX(1); }
    }

    #{{ $uid }} { --bq-accent: {{ $accent }}; --bq-accent2: {{ $accent2 }}; --bq-text: {{ $textColor }}; --bq-size: {{ $sizeCss }}; width: 100%; padding: {{ $paddingY }}px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-bq-wrap { --rx: 0deg; --ry: 0deg; --mx: 50%; --my: 50%; position: relative; max-width: 820px; margin: 0 auto; text-align: {{ $align }}; isolation: isolate; transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .5s ease; }
    #{{ $uid }} .rj-bq-wrap > * { position: relative; z-index: 2; }

    #{{ $uid }} .rj-bq-quote { margin: 0 0 24px; padding: 0; border: 0; background: transparent; font-size: var(--bq-size); font-weight: 600; line-height: 1.5; letter-spacing: -.012em; color: var(--bq-text); quotes: none; }
    #{{ $uid }} .rj-bq-quote::before, #{{ $uid }} .rj-bq-quote::after { content: none; }
    #{{ $uid }} .rj-w { display: inline-block; }

    #{{ $uid }} .rj-bq-author { display: inline-flex; align-items: center; gap: 14px; }
    #{{ $uid }} .rj-bq-ring { position: relative; flex: none; width: 56px; height: 56px; padding: 3px; border-radius: 50%; transition: transform .5s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rj-bq-ring::before { content: ""; position: absolute; inset: 0; border-radius: 50%; background: conic-gradient(from 0deg, var(--bq-accent), var(--bq-accent2), var(--bq-accent)); animation: bqRotate-{{ $uid }} 6s linear infinite; }
    #{{ $uid }} .rj-bq-wrap:hover .rj-bq-ring { transform: scale(1.1) rotate(-6deg); }
    #{{ $uid }} .rj-bq-ring::before { transition: filter .4s ease; }
    #{{ $uid }} .rj-bq-wrap:hover .rj-bq-ring::before { filter: blur(1.5px) saturate(1.4); animation-duration: 2s; }
    #{{ $uid }} .rj-bq-avatar { position: relative; display: grid; place-items: center; width: 100%; height: 100%; overflow: hidden; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); color: #fff; font-size: 18px; font-weight: 800; }
    #{{ $uid }} .rj-bq-avatar img { display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; }
    #{{ $uid }} .rj-bq-meta { display: flex; flex-direction: column; text-align: left; }
    #{{ $uid }} .rj-bq-name { font-size: 15px; font-weight: 800; letter-spacing: -.01em; color: var(--bq-text); }
    #{{ $uid }} .rj-bq-role { margin-top: 2px; font-size: 12.5px; font-weight: 500; color: #64748b; }
    #{{ $uid }} .rj-bq-wrap[data-align="center"] .rj-bq-author { justify-content: center; }
    #{{ $uid }} .rj-bq-wrap[data-align="right"] .rj-bq-author { flex-direction: row-reverse; }
    #{{ $uid }} .rj-bq-wrap[data-align="right"] .rj-bq-meta { text-align: right; }

    #{{ $uid }} .rj-bq-mark { position: absolute; z-index: 1; font-family: Georgia, 'Times New Roman', serif; font-size: 130px; line-height: 1; font-weight: 900; color: var(--bq-accent); opacity: .13; pointer-events: none; user-select: none; animation: bqFloat-{{ $uid }} 7s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-mark.open { top: -34px; left: 6px; }
    #{{ $uid }} .rj-bq-mark.close { right: 6px; bottom: -64px; animation-delay: -3.5s; }

    #{{ $uid }} .rj-bq-bar, #{{ $uid }} .rj-bq-blob, #{{ $uid }} .rj-bq-shine, #{{ $uid }} .rj-bq-glow, #{{ $uid }} .rj-bq-line { display: none; }

    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] { padding: 6px 0 6px 32px; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-bar { display: block; position: absolute; z-index: 1; left: 0; top: 0; bottom: 0; width: 5px; border-radius: 5px; background: linear-gradient(180deg, var(--bq-accent), var(--bq-accent2)); transform-origin: top; box-shadow: 0 0 22px -2px var(--bq-accent); }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-bar::after { content: ""; position: absolute; left: 50%; top: 0; width: 13px; height: 13px; margin: -6px 0 0 -6.5px; border-radius: 50%; background: #fff; box-shadow: 0 0 0 3px var(--bq-accent), 0 0 18px 4px var(--bq-accent); animation: bqDot-{{ $uid }} 3.4s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"]:hover .rj-bq-bar { width: 8px; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-bar { transition: width .4s ease; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-mark.open { top: -44px; left: 22px; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="right"] { padding: 6px 32px 6px 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="right"] .rj-bq-bar { left: auto; right: 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="center"] { padding: 6px 32px; }

    #{{ $uid }} .rj-bq-wrap[data-style="card"],
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] { padding: clamp(28px, 4.5vw, 52px) clamp(24px, 4.5vw, 52px); border-radius: 26px; transform: perspective(1100px) rotateX(var(--rx)) rotateY(var(--ry)); }

    #{{ $uid }} .rj-bq-wrap[data-style="card"] { background: #fff; box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 30px 60px -30px rgba(15,23,42,.28); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]::before { content: ""; position: absolute; inset: -2px; z-index: 0; border-radius: inherit; padding: 2px; background: conic-gradient(from var(--bq-angle), transparent 0 50%, var(--bq-accent) 72%, var(--bq-accent2) 88%, transparent 100%); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0); mask-composite: exclude; animation: bqSpin-{{ $uid }} 5s linear infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"] .rj-bq-glow { display: block; position: absolute; inset: 0; z-index: 1; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(420px circle at var(--mx) var(--my), color-mix(in srgb, var(--bq-accent) 14%, transparent), transparent 70%); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]:hover .rj-bq-glow { opacity: 1; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]:hover { box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 40px 70px -30px color-mix(in srgb, var(--bq-accent) 55%, transparent); }

    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] { overflow: hidden; background: linear-gradient(120deg, var(--bq-accent), var(--bq-accent2), color-mix(in srgb, var(--bq-accent) 60%, #06b6d4), var(--bq-accent)); background-size: 300% 300%; animation: bqFlow-{{ $uid }} 12s ease-in-out infinite; box-shadow: 0 40px 70px -34px color-mix(in srgb, var(--bq-accent) 70%, transparent); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-quote,
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-name { color: #fff; text-shadow: 0 2px 20px rgba(0,0,0,.18); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-role { color: rgba(255,255,255,.8); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-mark { color: #fff; opacity: .2; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-ring::before { background: conic-gradient(from 0deg, #fff, rgba(255,255,255,.2), #fff); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-avatar { border-color: transparent; background: rgba(255,255,255,.22); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob { display: block; position: absolute; z-index: 0; width: 260px; height: 260px; border-radius: 50%; background: rgba(255,255,255,.28); filter: blur(60px); pointer-events: none; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob.a { top: -90px; left: -60px; animation: bqBlobA-{{ $uid }} 11s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob.b { right: -80px; bottom: -100px; background: rgba(255,255,255,.2); animation: bqBlobB-{{ $uid }} 14s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-shine { display: block; position: absolute; z-index: 1; top: 0; bottom: 0; left: 0; width: 38%; background: linear-gradient(100deg, transparent, rgba(255,255,255,.28), transparent); animation: bqShine-{{ $uid }} 5.5s ease-in-out infinite; pointer-events: none; }

    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] { padding: 20px 10px 14px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.open { position: relative; top: auto; left: auto; display: inline-block; margin: 0 0 -34px; font-size: 118px; line-height: .9; opacity: .95; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; filter: drop-shadow(0 12px 18px color-mix(in srgb, var(--bq-accent) 35%, transparent)); transform-origin: 30% 70%; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.close { display: none; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-line { display: block; width: 90px; height: 4px; margin: 4px 0 22px; border-radius: 4px; background: linear-gradient(90deg, var(--bq-accent), var(--bq-accent2)); transform-origin: left; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="center"] .rj-bq-line { margin-inline: auto; transform-origin: center; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="right"] .rj-bq-line { margin-left: auto; transform-origin: right; }

    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] { padding: 10px 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote { font-weight: 500; font-style: italic; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote::before { content: '\201C'; display: inline-block; margin-right: 6px; font-family: Georgia, serif; font-style: normal; font-weight: 900; font-size: 1.5em; line-height: 0; vertical-align: -.25em; color: var(--bq-accent); }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote::after { content: '\201D'; display: inline-block; margin-left: 4px; font-family: Georgia, serif; font-style: normal; font-weight: 900; font-size: 1.5em; line-height: 0; vertical-align: -.25em; color: var(--bq-accent); }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-line { display: block; width: 56px; height: 2px; margin: 0 0 22px; background: var(--bq-accent); transform-origin: left; transition: width .5s ease; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"]:hover .rj-bq-line { width: 120px; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"][data-align="center"] .rj-bq-line { margin-inline: auto; transform-origin: center; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"][data-align="right"] .rj-bq-line { margin-left: auto; transform-origin: right; }

    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-w { opacity: 0; }
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-author,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-mark,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-bar,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-line { opacity: 0; }

    #{{ $uid }} .rj-bq-wrap.is-visible .rj-w { animation: bqWord-{{ $uid }} .8s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--w, 0) * 45ms + 250ms); }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-author { animation: bqUp-{{ $uid }} .8s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--total, 0) * 45ms + 500ms); }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-bar { animation: bqBar-{{ $uid }} 1.1s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-line { animation: bqLine-{{ $uid }} .9s cubic-bezier(.2,.8,.2,1) .2s backwards; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"].is-visible .rj-bq-mark.open { animation: bqMark-{{ $uid }} .9s cubic-bezier(.34,1.56,.64,1) backwards, bqFloat-{{ $uid }} 7s ease-in-out .9s infinite; }

    @media (max-width: 639px) {
        #{{ $uid }} .rj-bq-mark { font-size: 90px; }
        #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] { padding-left: 24px; }
        #{{ $uid }} .rj-bq-ring { width: 48px; height: 48px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-w,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-author,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-mark,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-bar,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-line { opacity: 1; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-bq-wrap" data-style="{{ $style }}" data-align="{{ $align }}" data-animate="{{ $animate ? 1 : 0 }}">

        <span class="rj-bq-bar" aria-hidden="true"></span>
        <span class="rj-bq-blob a" aria-hidden="true"></span>
        <span class="rj-bq-blob b" aria-hidden="true"></span>
        <span class="rj-bq-glow" aria-hidden="true"></span>
        <span class="rj-bq-shine" aria-hidden="true"></span>

        @if ($showMarks && $style !== 'minimal')
            <span class="rj-bq-mark open" aria-hidden="true">&ldquo;</span>
            @if ($style !== 'big-marks')
                <span class="rj-bq-mark close" aria-hidden="true">&rdquo;</span>
            @endif
        @endif

        @if ($style === 'big-marks' || $style === 'minimal')
            <span class="rj-bq-line" aria-hidden="true"></span>
        @endif

        @if ($quote !== '')
            <blockquote class="rj-bq-quote">@foreach ($lines as $line)@foreach (preg_split('/\s+/u', trim($line), -1, PREG_SPLIT_NO_EMPTY) ?: [] as $word)<span class="rj-w" style="--w: {{ min($n++, 80) }};">{{ $word }}</span> @endforeach @if (!$loop->last)<br>@endif @endforeach</blockquote>
        @endif

        @if ($author !== '')
            <div class="rj-bq-author">
                <div class="rj-bq-ring">
                    <div class="rj-bq-avatar">
                        @if ($avatar !== '')
                            <img src="{{ $avatar }}" alt="{{ $author }}" loading="lazy" decoding="async">
                        @else
                            {{ mb_strtoupper(mb_substr($author, 0, 1)) }}
                        @endif
                    </div>
                </div>
                <div class="rj-bq-meta">
                    <span class="rj-bq-name">{{ $author }}</span>
                    @if ($role !== '')
                        <span class="rj-bq-role">{{ $role }}</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var el = root.querySelector('.rj-bq-wrap');
    if (!el) { return; }

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
    var style = el.getAttribute('data-style');
    var words = el.querySelectorAll('.rj-w').length;

    el.style.setProperty('--total', Math.min(words, 80));

    if (el.dataset.animate === '1' && !reduce) {
        el.classList.add('rj-bq-js');

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    el.classList.add('is-visible');
                    io.disconnect();
                }
            }, { threshold: 0.2 });
            io.observe(el);
        } else {
            el.classList.add('is-visible');
        }
    }

    if (canHover && !reduce && (style === 'card' || style === 'gradient')) {
        el.addEventListener('pointermove', function (e) {
            var r = el.getBoundingClientRect();
            var x = e.clientX - r.left;
            var y = e.clientY - r.top;
            el.style.setProperty('--mx', x + 'px');
            el.style.setProperty('--my', y + 'px');
            el.style.setProperty('--ry', ((x / r.width - 0.5) * 7).toFixed(2) + 'deg');
            el.style.setProperty('--rx', ((0.5 - y / r.height) * 7).toFixed(2) + 'deg');
        });
        el.addEventListener('pointerleave', function () {
            el.style.setProperty('--rx', '0deg');
            el.style.setProperty('--ry', '0deg');
        });
    }
})();
</script>
