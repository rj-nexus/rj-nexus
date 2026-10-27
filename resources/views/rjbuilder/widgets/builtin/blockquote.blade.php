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

    $sparks = [['-46px', '-38px', '0s'], ['48px', '-34px', '.05s'], ['-54px', '10px', '.1s'], ['56px', '14px', '.15s'], ['-20px', '52px', '.08s'], ['24px', '-54px', '.12s']];
@endphp

<style>
    @keyframes rqFloat-{{ $uid }} { 0%, 100% { translate: 0 0; } 50% { translate: 0 -6px; } }
    @keyframes rqPop-{{ $uid }} { from { opacity: 0; scale: .2; rotate: -40deg; } }
    @keyframes rqRipple-{{ $uid }} { 0% { transform: scale(1); opacity: .6; } 100% { transform: scale(1.9); opacity: 0; } }
    @keyframes rqL-{{ $uid }} { 0%, 100% { transform: translate(0, 0) rotate(0) scale(1); } 50% { transform: translate(-2px, -2.5px) rotate(-14deg) scale(1.14); } }
    @keyframes rqR-{{ $uid }} { 0%, 100% { transform: translate(0, 0) rotate(0) scale(1); } 50% { transform: translate(2px, 2.5px) rotate(14deg) scale(1.14); } }
    @keyframes rqBurst-{{ $uid }} { 0% { opacity: 0; transform: translate(0, 0) scale(.3); } 20% { opacity: 1; } 100% { opacity: 0; transform: translate(var(--x), var(--y)) scale(1); } }
    @keyframes rqDrawY-{{ $uid }} { from { transform: scaleY(0); } to { transform: scaleY(1); } }
    @keyframes rqDrawX-{{ $uid }} { from { transform: scaleX(0); } to { transform: scaleX(1); } }
    @keyframes rqTY-{{ $uid }} { 0% { top: 0; opacity: 0; } 12% { opacity: 1; } 88% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
    @keyframes rqTX-{{ $uid }} { 0% { left: 0; opacity: 0; } 12% { opacity: 1; } 88% { opacity: 1; } 100% { left: 100%; opacity: 0; } }
    @keyframes rqBlink-{{ $uid }} { 0%, 49% { opacity: 1; } 50%, 100% { opacity: 0; } }
    @keyframes rqFlow-{{ $uid }} { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
    @keyframes rqBlobA-{{ $uid }} { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(50px, 30px) scale(1.2); } }
    @keyframes rqBlobB-{{ $uid }} { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(-60px, -24px) scale(1.15); } }
    @keyframes rqRing-{{ $uid }} { to { transform: rotate(360deg); } }
    @keyframes rqUp-{{ $uid }} { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }

    #{{ $uid }} { --a: {{ $accent }}; --b: {{ $accent2 }}; --t: {{ $textColor }}; --rq-size: {{ $sizeCss }}; width: 100%; padding: {{ $paddingY }}px 16px; overflow-x: clip; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Layout ---------- */
    #{{ $uid }} .rq { --rx: 0deg; --ry: 0deg; --mx: 50%; --my: 50%; --mpx: 0; --mpy: 0; position: relative; display: flex; gap: 28px; align-items: stretch; max-width: 860px; margin: 0 auto; text-align: {{ $align }}; isolation: isolate; }
    #{{ $uid }} .rq[data-align="right"] { flex-direction: row-reverse; }
    #{{ $uid }} .rq[data-align="center"] { flex-direction: column; align-items: center; gap: 20px; }
    #{{ $uid }} .rq-main { position: relative; z-index: 3; flex: 1; min-width: 0; align-self: center; }
    #{{ $uid }} .rq-side { position: relative; z-index: 3; flex: none; width: 64px; display: flex; flex-direction: column; align-items: center; gap: 14px; }
    #{{ $uid }} .rq[data-align="center"] .rq-side { width: auto; flex-direction: row; justify-content: center; }

    /* ---------- Side line ---------- */
    #{{ $uid }} .rq-line { position: relative; flex: 1; width: 3px; min-height: 50px; border-radius: 3px; background: color-mix(in srgb, var(--a) 16%, transparent); }
    #{{ $uid }} .rq-line.l1 { display: none; }
    #{{ $uid }} .rq-line::before { content: ""; position: absolute; inset: 0; border-radius: inherit; background: linear-gradient(180deg, var(--a), var(--b)); transform-origin: top; box-shadow: 0 0 18px -3px var(--a); }
    #{{ $uid }} .rq-line i { position: absolute; left: 50%; top: 0; width: 11px; height: 11px; margin: -5px 0 0 -5px; border-radius: 50%; background: #fff; box-shadow: 0 0 0 3px var(--a), 0 0 14px 2px var(--a); animation: rqTY-{{ $uid }} 3.4s ease-in-out infinite; }
    #{{ $uid }} .rq[data-align="center"] .rq-line { flex: none; width: 90px; height: 3px; min-height: 0; }
    #{{ $uid }} .rq[data-align="center"] .rq-line.l1 { display: block; }
    #{{ $uid }} .rq[data-align="center"] .rq-line::before { transform-origin: left; background: linear-gradient(90deg, var(--a), var(--b)); }
    #{{ $uid }} .rq[data-align="center"] .rq-line.l1::before { transform-origin: right; background: linear-gradient(270deg, var(--a), var(--b)); }
    #{{ $uid }} .rq[data-align="center"] .rq-line i { left: 0; top: 50%; margin: -5px 0 0 -5px; animation-name: rqTX-{{ $uid }}; }

    /* ---------- Quote icon ---------- */
    #{{ $uid }} .rq-icon { position: relative; flex: none; display: grid; place-items: center; width: 64px; height: 64px; border-radius: 50%; color: var(--a); background: color-mix(in srgb, var(--a) 12%, #fff); box-shadow: inset 0 0 0 1.5px color-mix(in srgb, var(--a) 30%, transparent); transition: transform .9s cubic-bezier(.34,1.56,.64,1), background .4s ease, color .4s ease, box-shadow .4s ease; animation: rqFloat-{{ $uid }} 5s ease-in-out infinite; }
    #{{ $uid }} .rq-icon svg { position: relative; z-index: 2; width: 30px; height: 30px; display: block; overflow: visible; }
    #{{ $uid }} .rq-icon .m1, #{{ $uid }} .rq-icon .m2 { transform-box: fill-box; transform-origin: center; }
    #{{ $uid }} .rq-icon::before, #{{ $uid }} .rq-icon::after { content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--a); opacity: 0; pointer-events: none; }
    #{{ $uid }} .rq-sp { position: absolute; left: 50%; top: 50%; width: 7px; height: 7px; margin: -3.5px 0 0 -3.5px; border-radius: 50%; background: var(--b); opacity: 0; pointer-events: none; }
    #{{ $uid }} .rq-sp:nth-child(odd) { background: var(--a); }

    #{{ $uid }} .rq:hover .rq-icon { transform: rotate(360deg) scale(1.14); color: #fff; background: linear-gradient(135deg, var(--a), var(--b)); box-shadow: 0 18px 34px -10px var(--a); }
    #{{ $uid }} .rq:hover .rq-icon .m1 { animation: rqL-{{ $uid }} 1.1s ease-in-out infinite; }
    #{{ $uid }} .rq:hover .rq-icon .m2 { animation: rqR-{{ $uid }} 1.1s ease-in-out .15s infinite; }
    #{{ $uid }} .rq:hover .rq-icon::before { animation: rqRipple-{{ $uid }} 1.6s ease-out infinite; }
    #{{ $uid }} .rq:hover .rq-icon::after { animation: rqRipple-{{ $uid }} 1.6s ease-out .8s infinite; }
    #{{ $uid }} .rq:hover .rq-sp { animation: rqBurst-{{ $uid }} 1s ease-out var(--d) both; }

    /* ---------- Text ---------- */
    #{{ $uid }} .rq-text { margin: 0 0 26px; padding: 0; border: 0; background: transparent; font-size: var(--rq-size); font-weight: 600; line-height: 1.5; letter-spacing: -.012em; color: var(--t); quotes: none; }
    #{{ $uid }} .rq-text::before, #{{ $uid }} .rq-text::after { content: none; }
    #{{ $uid }} .rq-w, #{{ $uid }} .rq-w > span { display: inline-block; }
    #{{ $uid }} .rq-caret { display: inline-block; width: 3px; height: 1em; margin-left: 4px; vertical-align: -.12em; border-radius: 2px; background: var(--a); animation: rqBlink-{{ $uid }} .9s steps(1) infinite; }

    #{{ $uid }} .rq.js .rq-w > span { opacity: 0; transform: translateY(14px); filter: blur(8px); transition: opacity .5s ease, transform .6s cubic-bezier(.2,.8,.2,1), filter .5s ease; }
    #{{ $uid }} .rq.js .rq-w.on > span { opacity: 1; transform: none; filter: blur(0); }
    #{{ $uid }} .rq.js .rq-author { opacity: 0; transform: translateY(14px); transition: opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq.js.done .rq-author { opacity: 1; transform: none; }

    /* ---------- Author ---------- */
    #{{ $uid }} .rq-author { display: inline-flex; align-items: center; gap: 14px; }
    #{{ $uid }} .rq-ring { position: relative; flex: none; width: 52px; height: 52px; padding: 3px; border-radius: 50%; transition: transform .5s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rq-ring::before { content: ""; position: absolute; inset: 0; border-radius: 50%; background: conic-gradient(from 0deg, var(--a), var(--b), transparent 60%, var(--a)); animation: rqRing-{{ $uid }} 5s linear infinite; }
    #{{ $uid }} .rq:hover .rq-ring { transform: scale(1.08) rotate(-8deg); }
    #{{ $uid }} .rq-avatar { position: relative; display: grid; place-items: center; width: 100%; height: 100%; overflow: hidden; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg, var(--a), var(--b)); color: #fff; font-size: 17px; font-weight: 800; }
    #{{ $uid }} .rq-avatar img { display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; }
    #{{ $uid }} .rq-meta { display: flex; flex-direction: column; text-align: left; }
    #{{ $uid }} .rq-name { font-size: 15px; font-weight: 800; letter-spacing: -.01em; color: var(--t); }
    #{{ $uid }} .rq-role { margin-top: 2px; font-size: 12.5px; font-weight: 500; color: #64748b; }
    #{{ $uid }} .rq[data-align="center"] .rq-author { justify-content: center; }
    #{{ $uid }} .rq[data-align="right"] .rq-author { flex-direction: row-reverse; }
    #{{ $uid }} .rq[data-align="right"] .rq-meta { text-align: right; }

    /* ---------- Extras hidden by default ---------- */
    #{{ $uid }} .rq-blob, #{{ $uid }} .rq-mark, #{{ $uid }} .rq-ln, #{{ $uid }} .rq-glow { display: none; }
    #{{ $uid }} .rq-mark { font-family: Georgia, 'Times New Roman', serif; font-weight: 900; line-height: 1; pointer-events: none; user-select: none; }

    /* ---------- Style: accent-bar ---------- */
    #{{ $uid }} .rq[data-style="accent-bar"] { padding: 6px 0; }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-main { transition: transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq[data-style="accent-bar"]:hover .rq-main { transform: translateX(6px); }
    #{{ $uid }} .rq[data-style="accent-bar"][data-align="right"]:hover .rq-main { transform: translateX(-6px); }
    #{{ $uid }} .rq[data-style="accent-bar"][data-align="center"]:hover .rq-main { transform: none; }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-line { width: 5px; }

    /* ---------- Style: card ---------- */
    #{{ $uid }} .rq[data-style="card"] { padding: clamp(28px, 4vw, 48px); border-radius: 28px; background: #fff; border: 1px solid #e7e9f3; box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 30px 60px -34px rgba(15,23,42,.3); transform: perspective(1200px) rotateX(var(--rx)) rotateY(var(--ry)); transition: transform .3s ease-out, box-shadow .5s ease; }
    #{{ $uid }} .rq[data-style="card"]:hover { box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 40px 70px -34px color-mix(in srgb, var(--a) 55%, transparent); }
    #{{ $uid }} .rq[data-style="card"] .rq-glow { display: block; position: absolute; inset: 0; z-index: 0; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(420px circle at var(--mx) var(--my), color-mix(in srgb, var(--a) 10%, transparent), transparent 70%); }
    #{{ $uid }} .rq[data-style="card"]:hover .rq-glow { opacity: 1; }
    #{{ $uid }} .rq[data-style="card"]::after { content: ""; position: absolute; top: -1px; left: 36px; right: 36px; z-index: 2; height: 3px; border-radius: 3px; background: linear-gradient(90deg, var(--a), var(--b)); transform: scaleX(.15); transform-origin: left; transition: transform .7s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq[data-style="card"]:hover::after { transform: scaleX(1); }

    /* ---------- Style: gradient ---------- */
    #{{ $uid }} .rq[data-style="gradient"] { padding: clamp(30px, 4.5vw, 54px); border-radius: 32px; overflow: hidden; background: #f5f3ff; background: linear-gradient(120deg, color-mix(in srgb, var(--a) 14%, #fff), color-mix(in srgb, var(--b) 14%, #fff), color-mix(in srgb, var(--a) 9%, #fff)); background-size: 250% 250%; border: 1px solid color-mix(in srgb, var(--a) 22%, transparent); animation: rqFlow-{{ $uid }} 10s ease-in-out infinite; transition: box-shadow .5s ease; }
    #{{ $uid }} .rq[data-style="gradient"]:hover { box-shadow: 0 34px 60px -36px color-mix(in srgb, var(--a) 60%, transparent); }
    #{{ $uid }} .rq[data-style="gradient"] .rq-blob { display: block; position: absolute; z-index: 0; width: 280px; height: 280px; border-radius: 50%; filter: blur(55px); pointer-events: none; opacity: .3; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-blob.a { top: -100px; left: -70px; background: var(--a); animation: rqBlobA-{{ $uid }} 11s ease-in-out infinite; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-blob.b { right: -90px; bottom: -110px; background: var(--b); animation: rqBlobB-{{ $uid }} 14s ease-in-out infinite; }

    /* ---------- Style: big-marks ---------- */
    #{{ $uid }} .rq[data-style="big-marks"] { padding: 40px 0 14px; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-text { font-weight: 800; letter-spacing: -.028em; line-height: 1.3; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark { display: block; position: absolute; z-index: 1; transition: translate .5s ease-out; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.open { top: -34px; left: -6px; font-size: 280px; color: transparent; -webkit-text-stroke: 3px var(--a); opacity: .3; translate: calc(var(--mpx) * 40px) calc(var(--mpy) * 40px); }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.close { right: -4px; bottom: -120px; font-size: 260px; opacity: .16; background: linear-gradient(135deg, var(--a), var(--b)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; translate: calc(var(--mpx) * -52px) calc(var(--mpy) * -52px); }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="right"] .rq-mark.open { left: auto; right: -6px; }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="right"] .rq-mark.close { right: auto; left: -4px; }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="center"] .rq-mark.open { left: 50%; margin-left: -90px; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-name { position: relative; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-name::after { content: ""; position: absolute; left: 0; right: 0; bottom: -3px; height: 3px; border-radius: 3px; background: linear-gradient(90deg, var(--a), var(--b)); transform: scaleX(.3); transform-origin: left; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq[data-style="big-marks"]:hover .rq-name::after { transform: scaleX(1); }

    /* ---------- Style: minimal ---------- */
    #{{ $uid }} .rq[data-style="minimal"] { padding: 36px 0; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-text { font-family: Georgia, 'Times New Roman', serif; font-style: italic; font-weight: 400; letter-spacing: 0; line-height: 1.6; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-name { font-size: 12.5px; letter-spacing: .16em; text-transform: uppercase; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-line { width: 2px; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ln { display: block; position: absolute; left: 0; right: 0; z-index: 1; height: 1px; background: color-mix(in srgb, var(--t) 16%, transparent); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ln.t { top: 0; transform-origin: left; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ln.b { bottom: 0; transform-origin: right; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ln::after { content: ""; position: absolute; top: -1px; left: 0; width: 56px; height: 3px; border-radius: 3px; background: var(--a); transition: width .7s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ln.b::after { left: auto; right: 0; background: var(--b); }
    #{{ $uid }} .rq[data-style="minimal"]:hover .rq-ln::after { width: 45%; }

    /* ---------- Entrance ---------- */
    #{{ $uid }} .rq.js:not(.vis) .rq-icon { opacity: 0; }
    #{{ $uid }} .rq.js:not(.vis) .rq-line::before { transform: scale(0); }
    #{{ $uid }} .rq.js:not(.vis) .rq-ln { transform: scaleX(0); }
    #{{ $uid }} .rq.vis .rq-icon { animation: rqPop-{{ $uid }} .9s cubic-bezier(.34,1.56,.64,1) backwards, rqFloat-{{ $uid }} 5s ease-in-out .9s infinite; }
    #{{ $uid }} .rq.vis .rq-line::before { animation: rqDrawY-{{ $uid }} 1.3s cubic-bezier(.2,.8,.2,1) .2s backwards; }
    #{{ $uid }} .rq.vis[data-align="center"] .rq-line::before { animation-name: rqDrawX-{{ $uid }}; }
    #{{ $uid }} .rq.vis .rq-ln { animation: rqDrawX-{{ $uid }} 1.2s cubic-bezier(.2,.8,.2,1) .1s backwards; }
    #{{ $uid }} .rq.vis .rq-mark { animation: rqUp-{{ $uid }} 1.1s ease .2s backwards; }

    @media (max-width: 639px) {
        #{{ $uid }} .rq { gap: 16px; }
        #{{ $uid }} .rq-side { width: 52px; }
        #{{ $uid }} .rq-icon { width: 52px; height: 52px; }
        #{{ $uid }} .rq-icon svg { width: 25px; height: 25px; }
        #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.open { font-size: 190px; }
        #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.close { font-size: 160px; bottom: -80px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rq" data-style="{{ $style }}" data-align="{{ $align }}" data-animate="{{ $animate ? 1 : 0 }}">

        <span class="rq-blob a" aria-hidden="true"></span>
        <span class="rq-blob b" aria-hidden="true"></span>
        <span class="rq-glow" aria-hidden="true"></span>

        @if ($style === 'minimal')
            <span class="rq-ln t" aria-hidden="true"></span>
            <span class="rq-ln b" aria-hidden="true"></span>
        @endif

        @if ($style === 'big-marks' && $showMarks)
            <span class="rq-mark open" aria-hidden="true">&ldquo;</span>
            <span class="rq-mark close" aria-hidden="true">&rdquo;</span>
        @endif

        <div class="rq-side" aria-hidden="true">
            <span class="rq-line l1"><i></i></span>
            @if ($showMarks)
                <div class="rq-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path class="m1" d="M6 17h3l2-4V7H5v6h3z"/><path class="m2" d="M14 17h3l2-4V7h-6v6h3z"/></svg>
                    @foreach ($sparks as $s)
                        <span class="rq-sp" style="--x: {{ $s[0] }}; --y: {{ $s[1] }}; --d: {{ $s[2] }};"></span>
                    @endforeach
                </div>
            @endif
            <span class="rq-line l2"><i></i></span>
        </div>

        <div class="rq-main">
            @if ($quote !== '')
                <blockquote class="rq-text">@foreach ($lines as $line)@foreach (preg_split('/\s+/u', trim($line), -1, PREG_SPLIT_NO_EMPTY) ?: [] as $word)<span class="rq-w"><span>{{ $word }}</span></span> @endforeach @if (!$loop->last)<br>@endif @endforeach</blockquote>
            @endif

            @if ($author !== '')
                <div class="rq-author">
                    <div class="rq-ring">
                        <div class="rq-avatar">
                            @if ($avatar !== '')
                                <img src="{{ $avatar }}" alt="{{ $author }}" loading="lazy" decoding="async">
                            @else
                                {{ mb_strtoupper(mb_substr($author, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <div class="rq-meta">
                        <span class="rq-name">{{ $author }}</span>
                        @if ($role !== '')
                            <span class="rq-role">{{ $role }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var el = root.querySelector('.rq');
    if (!el) { return; }

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
    var style = el.getAttribute('data-style');
    var words = [].slice.call(el.querySelectorAll('.rq-w'));
    var timer = 0;
    var typing = false;

    function typeIt() {
        clearTimeout(timer);
        typing = true;
        el.classList.remove('done');
        words.forEach(function (w) { w.classList.remove('on'); });

        var old = el.querySelector('.rq-caret');
        if (old) { old.remove(); }
        var caret = document.createElement('span');
        caret.className = 'rq-caret';
        caret.setAttribute('aria-hidden', 'true');

        var i = 0;
        (function step() {
            if (i >= words.length) {
                typing = false;
                el.classList.add('done');
                timer = setTimeout(function () { caret.remove(); }, 1600);
                return;
            }
            var w = words[i++];
            w.classList.add('on');
            w.parentNode.insertBefore(caret, w.nextSibling);
            timer = setTimeout(step, 45 + w.textContent.length * 24);
        })();
    }

    function start() {
        el.classList.add('vis');
        setTimeout(typeIt, 350);
    }

    if (el.dataset.animate === '1' && !reduce) {
        el.classList.add('js');

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) { start(); io.disconnect(); }
            }, { threshold: 0.25 });
            io.observe(el);
        } else {
            start();
        }

        el.addEventListener('click', function () { if (!typing) { typeIt(); } });
    }

    if (canHover && !reduce) {
        if (style === 'card') {
            el.addEventListener('pointermove', function (e) {
                var r = el.getBoundingClientRect();
                var x = e.clientX - r.left, y = e.clientY - r.top;
                el.style.setProperty('--mx', x + 'px');
                el.style.setProperty('--my', y + 'px');
                el.style.setProperty('--ry', ((x / r.width - 0.5) * 5).toFixed(2) + 'deg');
                el.style.setProperty('--rx', ((0.5 - y / r.height) * 5).toFixed(2) + 'deg');
            });
            el.addEventListener('pointerleave', function () {
                el.style.setProperty('--rx', '0deg');
                el.style.setProperty('--ry', '0deg');
            });
        }

        if (style === 'big-marks') {
            el.addEventListener('pointermove', function (e) {
                var r = el.getBoundingClientRect();
                el.style.setProperty('--mpx', ((e.clientX - r.left) / r.width - 0.5).toFixed(3));
                el.style.setProperty('--mpy', ((e.clientY - r.top) / r.height - 0.5).toFixed(3));
            });
            el.addEventListener('pointerleave', function () {
                el.style.setProperty('--mpx', '0');
                el.style.setProperty('--mpy', '0');
            });
        }
    }
})();
</script>
