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
        from { opacity: 0; transform: translateY(22px) rotateX(-40deg); filter: blur(8px); }
        to   { opacity: 1; transform: none; filter: blur(0); }
    }
    @keyframes bqUp-{{ $uid }} {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes bqDraw-{{ $uid }} {
        from { transform: scaleY(0); }
        to   { transform: scaleY(1); }
    }
    @keyframes bqDrawX-{{ $uid }} {
        from { transform: scaleX(0); }
        to   { transform: scaleX(1); }
    }
    @keyframes bqTravel-{{ $uid }} {
        0%   { top: 0; opacity: 0; }
        12%  { opacity: 1; }
        88%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    @keyframes bqSpin-{{ $uid }} { to { --bq-angle: 360deg; } }
    @keyframes bqRotate-{{ $uid }} { to { transform: rotate(360deg); } }
    @keyframes bqBlobA-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(70px, 40px) scale(1.25); }
    }
    @keyframes bqBlobB-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(-80px, -30px) scale(1.18); }
    }
    @keyframes bqRise-{{ $uid }} {
        from { background-position: 0 0; }
        to   { background-position: 0 -240px; }
    }
    @keyframes bqDrop-{{ $uid }} {
        0%   { opacity: 0; transform: translateY(-80px) scale(1.3) rotate(-8deg); }
        60%  { opacity: .22; transform: translateY(8px) scale(.98) rotate(2deg); }
        100% { opacity: .2; transform: none; }
    }
    @keyframes bqPop-{{ $uid }} {
        0%   { opacity: 0; transform: scale(.2) rotate(-40deg); }
        100% { opacity: 1; transform: none; }
    }
    @keyframes bqPulse-{{ $uid }} {
        0%   { box-shadow: 0 0 0 0 color-mix(in srgb, var(--bq-accent) 45%, transparent); }
        100% { box-shadow: 0 0 0 16px transparent; }
    }

    #{{ $uid }} { --bq-accent: {{ $accent }}; --bq-accent2: {{ $accent2 }}; --bq-text: {{ $textColor }}; --bq-size: {{ $sizeCss }}; width: 100%; padding: {{ $paddingY }}px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-bq-wrap { --rx: 0deg; --ry: 0deg; --mx: 50%; --my: 50%; position: relative; max-width: 840px; margin: 0 auto; text-align: {{ $align }}; isolation: isolate; transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .5s ease; }
    #{{ $uid }} .rj-bq-quote, #{{ $uid }} .rj-bq-author { position: relative; z-index: 3; }

    #{{ $uid }} .rj-bq-quote { margin: 0 0 28px; padding: 0; border: 0; background: transparent; font-size: var(--bq-size); font-weight: 600; line-height: 1.5; letter-spacing: -.012em; color: var(--bq-text); quotes: none; perspective: 700px; }
    #{{ $uid }} .rj-bq-quote::before, #{{ $uid }} .rj-bq-quote::after { content: none; }
    #{{ $uid }} .rj-w { display: inline-block; transform-origin: 50% 100%; }

    #{{ $uid }} .rj-bq-author { display: inline-flex; align-items: center; gap: 14px; }
    #{{ $uid }} .rj-bq-ring { position: relative; flex: none; width: 56px; height: 56px; padding: 3px; border-radius: 50%; transition: transform .5s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rj-bq-ring::before { content: ""; position: absolute; inset: 0; border-radius: 50%; background: conic-gradient(from 0deg, var(--bq-accent), var(--bq-accent2), transparent 60%, var(--bq-accent)); animation: bqRotate-{{ $uid }} 5s linear infinite; }
    #{{ $uid }} .rj-bq-wrap:hover .rj-bq-ring { transform: scale(1.1) rotate(-8deg); }
    #{{ $uid }} .rj-bq-avatar { position: relative; display: grid; place-items: center; width: 100%; height: 100%; overflow: hidden; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); color: #fff; font-size: 18px; font-weight: 800; }
    #{{ $uid }} .rj-bq-avatar img { display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; }
    #{{ $uid }} .rj-bq-meta { display: flex; flex-direction: column; text-align: left; }
    #{{ $uid }} .rj-bq-name { font-size: 15px; font-weight: 800; letter-spacing: -.01em; color: var(--bq-text); }
    #{{ $uid }} .rj-bq-role { margin-top: 2px; font-size: 12.5px; font-weight: 500; color: #64748b; }
    #{{ $uid }} .rj-bq-wrap[data-align="center"] .rj-bq-author { justify-content: center; }
    #{{ $uid }} .rj-bq-wrap[data-align="right"] .rj-bq-author { flex-direction: row-reverse; }
    #{{ $uid }} .rj-bq-wrap[data-align="right"] .rj-bq-meta { text-align: right; }

    #{{ $uid }} .rj-bq-rail, #{{ $uid }} .rj-bq-badge, #{{ $uid }} .rj-bq-glow, #{{ $uid }} .rj-bq-blob, #{{ $uid }} .rj-bq-dots, #{{ $uid }} .rj-bq-ln, #{{ $uid }} .rj-bq-mark { display: none; }
    #{{ $uid }} .rj-bq-mark { font-family: Georgia, 'Times New Roman', serif; font-weight: 900; line-height: 1; pointer-events: none; user-select: none; }

    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] { padding: 10px 0 10px 44px; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"]::before { content: ""; position: absolute; z-index: 0; inset: -10px -20px -10px -20px; border-radius: 24px; background: linear-gradient(90deg, color-mix(in srgb, var(--bq-accent) 9%, transparent), transparent 70%); opacity: .8; transition: opacity .5s ease; pointer-events: none; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"]:hover::before { opacity: 1; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-rail { display: block; position: absolute; z-index: 2; left: 0; top: 0; bottom: 0; width: 4px; border-radius: 4px; background: color-mix(in srgb, var(--bq-accent) 16%, transparent); }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-rail::before { content: ""; position: absolute; inset: 0; border-radius: inherit; background: linear-gradient(180deg, var(--bq-accent), var(--bq-accent2)); transform-origin: top; box-shadow: 0 0 24px -2px var(--bq-accent); }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-rail::after { content: ""; position: absolute; left: 50%; top: 0; width: 14px; height: 14px; margin: -7px 0 0 -7px; background: #fff; transform: rotate(45deg); border-radius: 3px; box-shadow: 0 0 0 3px var(--bq-accent), 0 0 20px 4px var(--bq-accent); animation: bqTravel-{{ $uid }} 3.6s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="right"] { padding: 10px 44px 10px 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="right"] .rj-bq-rail { left: auto; right: 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="center"] { padding: 10px 44px; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-mark.open { display: block; position: relative; z-index: 3; font-size: 72px; height: 38px; margin-bottom: 6px; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; transform-origin: left bottom; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"][data-align="center"] .rj-bq-mark.open { transform-origin: center bottom; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] .rj-bq-quote { transition: transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"]:hover .rj-bq-quote { transform: translateX(6px); }

    #{{ $uid }} .rj-bq-wrap[data-style="card"] { margin-top: 30px; padding: clamp(40px, 5vw, 60px) clamp(26px, 4.5vw, 56px) clamp(30px, 4vw, 48px); border-radius: 30px; background: #fff; transform: perspective(1200px) rotateX(var(--rx)) rotateY(var(--ry)); box-shadow: 0 1px 2px rgba(15,23,42,.05), 0 34px 60px -30px rgba(15,23,42,.3); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]::before, #{{ $uid }} .rj-bq-wrap[data-style="card"]::after { content: ""; position: absolute; z-index: -1; inset: 0; border-radius: inherit; transition: transform .7s cubic-bezier(.34,1.3,.64,1), opacity .5s ease; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]::before { background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); transform: rotate(-2.5deg) translateY(6px); opacity: .85; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]::after { background: color-mix(in srgb, var(--bq-accent2) 35%, #fff); transform: rotate(2.5deg) translateY(10px); opacity: .6; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]:hover::before { transform: rotate(-6deg) translate(-14px, 8px); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]:hover::after { transform: rotate(5deg) translate(14px, 12px); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"] .rj-bq-glow { display: block; position: absolute; z-index: 1; inset: 0; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(380px circle at var(--mx) var(--my), color-mix(in srgb, var(--bq-accent) 14%, transparent), transparent 70%); }
    #{{ $uid }} .rj-bq-wrap[data-style="card"]:hover .rj-bq-glow { opacity: 1; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"] .rj-bq-badge { display: grid; place-items: center; position: absolute; z-index: 4; top: -30px; left: 50%; width: 62px; height: 62px; margin-left: -31px; border-radius: 50%; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); border: 4px solid #fff; color: #fff; font-family: Georgia, serif; font-size: 44px; font-weight: 900; line-height: 1; padding-top: 14px; box-shadow: 0 16px 30px -10px var(--bq-accent); animation: bqPulse-{{ $uid }} 2.2s ease-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"][data-align="left"] .rj-bq-badge { left: 40px; margin-left: 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="card"][data-align="right"] .rj-bq-badge { left: auto; right: 40px; margin-left: 0; }

    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] { padding: clamp(34px, 5vw, 60px) clamp(26px, 5vw, 60px); border-radius: 32px; overflow: hidden; background: #0a0d1f; border: 1px solid rgba(255,255,255,.12); transform: perspective(1200px) rotateX(var(--rx)) rotateY(var(--ry)); box-shadow: 0 40px 80px -36px color-mix(in srgb, var(--bq-accent) 65%, transparent); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-quote, #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-name { color: #fff; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-role { color: rgba(255,255,255,.65); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-avatar { border-color: #0a0d1f; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob { display: block; position: absolute; z-index: 0; width: 340px; height: 340px; border-radius: 50%; filter: blur(70px); pointer-events: none; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob.a { top: -130px; left: -90px; background: var(--bq-accent); opacity: .55; animation: bqBlobA-{{ $uid }} 12s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-blob.b { right: -110px; bottom: -140px; background: var(--bq-accent2); opacity: .5; animation: bqBlobB-{{ $uid }} 15s ease-in-out infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-dots { display: block; position: absolute; z-index: 1; inset: 0; pointer-events: none; opacity: .5; background-image: radial-gradient(circle, rgba(255,255,255,.55) 1px, transparent 1.6px), radial-gradient(circle, rgba(255,255,255,.35) 1px, transparent 1.6px); background-size: 120px 120px, 77px 77px; background-position: 0 0, 30px 40px; animation: bqRise-{{ $uid }} 14s linear infinite; -webkit-mask-image: linear-gradient(to bottom, transparent, #000 25%, #000 75%, transparent); mask-image: linear-gradient(to bottom, transparent, #000 25%, #000 75%, transparent); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-glow { display: block; position: absolute; z-index: 1; inset: 0; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(360px circle at var(--mx) var(--my), rgba(255,255,255,.12), transparent 70%); }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"]:hover .rj-bq-glow { opacity: 1; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-mark.open { display: block; position: absolute; z-index: 2; top: 6px; right: 26px; font-size: 170px; color: #fff; opacity: .1; }

    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] { padding: 54px 10px 10px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-quote { font-weight: 800; letter-spacing: -.025em; line-height: 1.32; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.open { display: block; position: absolute; z-index: 1; top: -30px; left: -6px; font-size: 300px; opacity: .2; background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; filter: drop-shadow(0 20px 30px color-mix(in srgb, var(--bq-accent) 30%, transparent)); }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.close { display: block; position: absolute; z-index: 1; right: -4px; bottom: -120px; font-size: 260px; color: transparent; -webkit-text-stroke: 2px var(--bq-accent); opacity: .35; transition: opacity .4s ease, transform .6s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"]:hover .rj-bq-mark.close { opacity: .7; transform: translate(-8px, -8px) rotate(-4deg); }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="center"] .rj-bq-mark.open { left: 50%; margin-left: -80px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="right"] .rj-bq-mark.open { left: auto; right: -6px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="right"] .rj-bq-mark.close { right: auto; left: -4px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-ln.b { display: block; position: relative; z-index: 3; width: 110px; height: 5px; margin: 0 0 26px; border-radius: 5px; background: linear-gradient(90deg, var(--bq-accent), var(--bq-accent2)); transform-origin: left; transition: width .5s ease; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"]:hover .rj-bq-ln.b { width: 180px; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="center"] .rj-bq-ln.b { margin-inline: auto; transform-origin: center; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"][data-align="right"] .rj-bq-ln.b { margin-left: auto; transform-origin: right; }

    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] { padding: 36px 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote { font-family: Georgia, 'Times New Roman', serif; font-weight: 400; font-style: italic; line-height: 1.55; letter-spacing: 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ln { display: block; position: absolute; z-index: 1; left: 0; right: 0; height: 1px; background: color-mix(in srgb, var(--bq-text) 18%, transparent); transform-origin: left; transition: background .5s ease; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ln.t { top: 0; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ln.b { bottom: 0; transform-origin: right; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ln::after { content: ""; position: absolute; top: -2px; left: 0; width: 56px; height: 5px; background: var(--bq-accent); transition: width .6s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ln.b::after { left: auto; right: 0; background: var(--bq-accent2); }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"]:hover .rj-bq-ln::after { width: 45%; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-name { font-size: 12.5px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-role { font-size: 12px; letter-spacing: .04em; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ring { width: 46px; height: 46px; padding: 2px; }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-ring::before { background: conic-gradient(from 0deg, var(--bq-accent), transparent 70%, var(--bq-accent)); }

    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-w,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-author,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-mark,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-badge,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-rail,
    #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-ln { opacity: 0; }

    #{{ $uid }} .rj-bq-wrap.is-visible .rj-w { animation: bqWord-{{ $uid }} .85s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--w, 0) * 50ms + 300ms); }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-author { animation: bqUp-{{ $uid }} .8s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--total, 0) * 50ms + 550ms); }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-rail::before { animation: bqDraw-{{ $uid }} 1.2s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-ln { animation: bqDrawX-{{ $uid }} 1.1s cubic-bezier(.2,.8,.2,1) .15s backwards; }
    #{{ $uid }} .rj-bq-wrap.is-visible .rj-bq-badge { animation: bqPop-{{ $uid }} .8s cubic-bezier(.34,1.56,.64,1) .1s backwards, bqPulse-{{ $uid }} 2.2s ease-out .9s infinite; }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"].is-visible .rj-bq-mark.open { animation: bqPop-{{ $uid }} .8s cubic-bezier(.34,1.56,.64,1) .1s backwards; }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"].is-visible .rj-bq-mark.open { animation: bqUp-{{ $uid }} 1.1s ease .2s backwards; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"].is-visible .rj-bq-mark.open { animation: bqDrop-{{ $uid }} 1.1s cubic-bezier(.3,1.2,.5,1) backwards; }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"].is-visible .rj-bq-mark.close { animation: bqUp-{{ $uid }} 1s ease .6s backwards; }

    @media (max-width: 639px) {
        #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] { padding-left: 28px; }
        #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.open { font-size: 200px; }
        #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.close { font-size: 160px; bottom: -80px; }
        #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-mark.open { font-size: 110px; }
        #{{ $uid }} .rj-bq-ring { width: 48px; height: 48px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-w,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-author,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-mark,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-badge,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-rail,
        #{{ $uid }} .rj-bq-wrap.rj-bq-js:not(.is-visible) .rj-bq-ln { opacity: 1; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-bq-wrap" data-style="{{ $style }}" data-align="{{ $align }}" data-animate="{{ $animate ? 1 : 0 }}">

        <span class="rj-bq-rail" aria-hidden="true"></span>
        <span class="rj-bq-blob a" aria-hidden="true"></span>
        <span class="rj-bq-blob b" aria-hidden="true"></span>
        <span class="rj-bq-dots" aria-hidden="true"></span>
        <span class="rj-bq-glow" aria-hidden="true"></span>

        @if ($style === 'minimal')
            <span class="rj-bq-ln t" aria-hidden="true"></span>
            <span class="rj-bq-ln b" aria-hidden="true"></span>
        @endif

        @if ($showMarks)
            @if ($style === 'card')
                <span class="rj-bq-badge" aria-hidden="true">&ldquo;</span>
            @elseif ($style === 'big-marks')
                <span class="rj-bq-mark open" aria-hidden="true">&ldquo;</span>
                <span class="rj-bq-mark close" aria-hidden="true">&rdquo;</span>
            @elseif ($style === 'accent-bar' || $style === 'gradient')
                <span class="rj-bq-mark open" aria-hidden="true">&ldquo;</span>
            @endif
        @endif

        @if ($quote !== '')
            <blockquote class="rj-bq-quote">@foreach ($lines as $line)@foreach (preg_split('/\s+/u', trim($line), -1, PREG_SPLIT_NO_EMPTY) ?: [] as $word)<span class="rj-w" style="--w: {{ min($n++, 80) }};">{{ $word }}</span> @endforeach @if (!$loop->last)<br>@endif @endforeach</blockquote>
        @endif

        @if ($style === 'big-marks')
            <span class="rj-bq-ln b" aria-hidden="true"></span>
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
            el.style.setProperty('--ry', ((x / r.width - 0.5) * 6).toFixed(2) + 'deg');
            el.style.setProperty('--rx', ((0.5 - y / r.height) * 6).toFixed(2) + 'deg');
        });
        el.addEventListener('pointerleave', function () {
            el.style.setProperty('--rx', '0deg');
            el.style.setProperty('--ry', '0deg');
        });
    }
})();
</script>
