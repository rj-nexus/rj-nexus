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
    @property --rq-ang { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    @keyframes rq-flip-{{ $uid }} { from { opacity: 0; transform: translateY(26px) rotateX(-70deg); } to { opacity: 1; transform: none; } }
    @keyframes rq-blur-{{ $uid }} { from { opacity: 0; transform: translateY(28px) scale(.9); filter: blur(14px); } to { opacity: 1; transform: none; filter: blur(0); } }
    @keyframes rq-mask-{{ $uid }} { from { transform: translateY(118%) rotate(6deg); } to { transform: none; } }
    @keyframes rq-up-{{ $uid }} { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: none; } }
    @keyframes rq-pop-{{ $uid }} { from { opacity: 0; scale: .2; rotate: -30deg; } }
    @keyframes rq-sweep-{{ $uid }} { 0% { left: 0; opacity: 1; } 92% { opacity: 1; } 100% { left: 100%; opacity: 0; } }
    @keyframes rq-clip-{{ $uid }} { from { clip-path: inset(-30% 100% -30% 0); } to { clip-path: inset(-30% 0 -30% 0); } }
    @keyframes rq-grid-{{ $uid }} { to { background-position: 44px 44px; } }
    @keyframes rq-bracket-{{ $uid }} { 0%, 100% { opacity: .35; } 50% { opacity: 1; } }
    @keyframes rq-float-{{ $uid }} { 0%, 100% { translate: 0 0; } 50% { translate: 0 -10px; } }
    @keyframes rq-foil-{{ $uid }} { from { background-position: 0% 20%; } to { background-position: 100% 80%; } }
    @keyframes rq-twinkle-{{ $uid }} { 0%, 100% { opacity: 0; scale: .3; } 50% { opacity: 1; scale: 1; } }
    @keyframes rq-pulse-{{ $uid }} { 0% { box-shadow: 0 16px 30px -10px var(--a), 0 0 0 0 color-mix(in srgb, var(--a) 50%, transparent); } 100% { box-shadow: 0 16px 30px -10px var(--a), 0 0 0 18px transparent; } }
    @keyframes rq-spin-{{ $uid }} { to { rotate: 360deg; } }
    @keyframes rq-ring-{{ $uid }} { to { transform: rotate(360deg); } }
    @keyframes rq-angle-{{ $uid }} { to { --rq-ang: 360deg; } }
    @keyframes rq-rise-{{ $uid }} { 0% { transform: translateY(0); opacity: 0; } 15% { opacity: .9; } 100% { transform: translateY(-520px); opacity: 0; } }
    @keyframes rq-glow-{{ $uid }} { from { text-shadow: 0 0 18px color-mix(in srgb, var(--a) 35%, transparent); } to { text-shadow: 0 0 40px color-mix(in srgb, var(--b) 75%, transparent); } }
    @keyframes rq-drift-{{ $uid }} { 0%, 100% { scale: 1; } 50% { scale: 1.25; } }
    @keyframes rq-blink-{{ $uid }} { 0%, 49% { opacity: 1; } 50%, 100% { opacity: 0; } }

    #{{ $uid }} { --a: {{ $accent }}; --b: {{ $accent2 }}; --t: {{ $textColor }}; --rq-size: {{ $sizeCss }}; width: 100%; padding: {{ $paddingY }}px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rq { --rx: 0deg; --ry: 0deg; --mx: 50%; --my: 50%; --px: 50; --py: 50; --bx: 30%; --by: 35%; --mpx: 0; --mpy: 0; position: relative; max-width: 860px; margin: 0 auto; text-align: {{ $align }}; isolation: isolate; }
    #{{ $uid }} .rq-grid, #{{ $uid }} .rq-aur, #{{ $uid }} .rq-foil, #{{ $uid }} .rq-glare, #{{ $uid }} .rq-beam, #{{ $uid }} .rq-blob, #{{ $uid }} .rq-badge, #{{ $uid }} .rq-tape, #{{ $uid }} .rq-mark, #{{ $uid }} .rq-star, #{{ $uid }} .rq-p, #{{ $uid }} .rq-caret { display: none; }
    #{{ $uid }} .rq-mark { font-family: Georgia, 'Times New Roman', serif; font-weight: 900; line-height: 1; pointer-events: none; user-select: none; }

    #{{ $uid }} .rq-body { position: relative; z-index: 3; }
    #{{ $uid }} .rq-text { margin: 0 0 28px; padding: 0; border: 0; background: transparent; font-size: var(--rq-size); font-weight: 600; line-height: 1.5; letter-spacing: -.012em; color: var(--t); quotes: none; perspective: 800px; }
    #{{ $uid }} .rq-text::before, #{{ $uid }} .rq-text::after { content: none; }
    #{{ $uid }} .rq-w, #{{ $uid }} .rq-w > span { display: inline-block; }

    #{{ $uid }} .rq-author { position: relative; z-index: 3; display: inline-flex; align-items: center; gap: 14px; }
    #{{ $uid }} .rq-ring { position: relative; flex: none; width: 56px; height: 56px; padding: 3px; border-radius: 50%; transition: transform .5s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rq-ring::before { content: ""; position: absolute; inset: 0; border-radius: 50%; background: conic-gradient(from 0deg, var(--a), var(--b), transparent 60%, var(--a)); animation: rq-ring-{{ $uid }} 5s linear infinite; }
    #{{ $uid }} .rq:hover .rq-ring { transform: scale(1.1) rotate(-8deg); }
    #{{ $uid }} .rq-avatar { position: relative; display: grid; place-items: center; width: 100%; height: 100%; overflow: hidden; border-radius: 50%; border: 3px solid #fff; background: linear-gradient(135deg, var(--a), var(--b)); color: #fff; font-size: 18px; font-weight: 800; }
    #{{ $uid }} .rq-avatar img { display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; }
    #{{ $uid }} .rq-meta { display: flex; flex-direction: column; text-align: left; }
    #{{ $uid }} .rq-name { font-size: 15px; font-weight: 800; letter-spacing: -.01em; color: var(--t); }
    #{{ $uid }} .rq-role { margin-top: 2px; font-size: 12.5px; font-weight: 500; color: #64748b; }
    #{{ $uid }} .rq[data-align="center"] .rq-author { justify-content: center; }
    #{{ $uid }} .rq[data-align="right"] .rq-author { flex-direction: row-reverse; }
    #{{ $uid }} .rq[data-align="right"] .rq-meta { text-align: right; }

    #{{ $uid }} .rq[data-style="accent-bar"] { padding: clamp(34px, 5vw, 64px); border-radius: 28px; overflow: hidden; background: #05060f; box-shadow: 0 0 0 1px rgba(255,255,255,.08), 0 40px 90px -40px var(--a); }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-grid { display: block; position: absolute; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px); background-size: 44px 44px; -webkit-mask-image: radial-gradient(ellipse at center, #000 30%, transparent 80%); mask-image: radial-gradient(ellipse at center, #000 30%, transparent 80%); animation: rq-grid-{{ $uid }} 12s linear infinite; }
    #{{ $uid }} .rq[data-style="accent-bar"]::before, #{{ $uid }} .rq[data-style="accent-bar"]::after { content: ""; position: absolute; z-index: 2; width: 34px; height: 34px; border: 2px solid var(--a); pointer-events: none; animation: rq-bracket-{{ $uid }} 2.4s ease-in-out infinite; }
    #{{ $uid }} .rq[data-style="accent-bar"]::before { top: 16px; left: 16px; border-right: 0; border-bottom: 0; }
    #{{ $uid }} .rq[data-style="accent-bar"]::after { right: 16px; bottom: 16px; border-left: 0; border-top: 0; animation-delay: 1.2s; }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-beam { display: block; position: absolute; top: -24px; bottom: -24px; left: 0; z-index: 4; width: 2px; opacity: 0; pointer-events: none; background: linear-gradient(transparent, var(--b) 15%, #fff 50%, var(--a) 85%, transparent); box-shadow: 0 0 18px 3px var(--a), 0 0 60px 12px color-mix(in srgb, var(--a) 55%, transparent); }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-beam::before { content: ""; position: absolute; top: 0; bottom: 0; right: 2px; width: 140px; background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--a) 28%, transparent)); }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-text { color: #fff; text-shadow: 0 0 28px color-mix(in srgb, var(--a) 45%, transparent); }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-name { color: #fff; }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-role { color: rgba(255,255,255,.6); }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-avatar { border-color: #05060f; }
    #{{ $uid }} .rq[data-style="accent-bar"] .rq-mark.open { display: block; position: relative; z-index: 3; height: 40px; margin-bottom: 8px; font-size: 72px; background: linear-gradient(135deg, var(--a), var(--b)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; filter: drop-shadow(0 0 14px var(--a)); }

    #{{ $uid }} .rq[data-style="card"] { margin-top: 12px; padding: clamp(44px, 5vw, 64px) clamp(26px, 4.5vw, 56px) clamp(30px, 4vw, 48px); border-radius: 30px; background: linear-gradient(145deg, #13162e, #0a0b1a); border: 1px solid rgba(255,255,255,.14); transform: perspective(1100px) rotateX(var(--rx)) rotateY(var(--ry)); transition: transform .25s ease-out; animation: rq-float-{{ $uid }} 6s ease-in-out infinite; box-shadow: 0 50px 80px -40px color-mix(in srgb, var(--a) 60%, transparent), 0 2px 0 rgba(255,255,255,.08) inset; }
    #{{ $uid }} .rq[data-style="card"] .rq-foil { display: block; position: absolute; inset: 0; z-index: 1; border-radius: inherit; pointer-events: none; mix-blend-mode: color-dodge; opacity: .5; background: linear-gradient(115deg, transparent 10%, rgba(255,0,128,.45), rgba(255,200,0,.4), rgba(0,255,170,.4), rgba(0,140,255,.45), transparent 90%); background-size: 240% 240%; animation: rq-foil-{{ $uid }} 6s ease-in-out infinite alternate; }
    #{{ $uid }} .rq[data-style="card"]:hover .rq-foil { animation: none; background-position: calc(var(--px) * 1%) calc(var(--py) * 1%); }
    #{{ $uid }} .rq[data-style="card"] .rq-glare { display: block; position: absolute; inset: 0; z-index: 2; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .3s ease; background: radial-gradient(circle at var(--mx) var(--my), rgba(255,255,255,.26), transparent 55%); }
    #{{ $uid }} .rq[data-style="card"]:hover .rq-glare { opacity: 1; }
    #{{ $uid }} .rq[data-style="card"] .rq-text, #{{ $uid }} .rq[data-style="card"] .rq-name { color: #fff; }
    #{{ $uid }} .rq[data-style="card"] .rq-role { color: rgba(255,255,255,.62); }
    #{{ $uid }} .rq[data-style="card"] .rq-avatar { border-color: #0a0b1a; }
    #{{ $uid }} .rq[data-style="card"] .rq-star { display: block; position: absolute; z-index: 3; left: var(--l); top: var(--t2); width: 14px; height: 14px; background: #fff; clip-path: polygon(50% 0, 60% 40%, 100% 50%, 60% 60%, 50% 100%, 40% 60%, 0 50%, 40% 40%); filter: drop-shadow(0 0 6px #fff); opacity: 0; animation: rq-twinkle-{{ $uid }} 3s ease-in-out infinite; animation-delay: var(--d); pointer-events: none; }
    #{{ $uid }} .rq[data-style="card"] .rq-badge { display: grid; place-items: center; position: absolute; z-index: 5; top: -30px; left: 50%; width: 62px; height: 62px; margin-left: -31px; padding-top: 14px; border: 4px solid #fff; border-radius: 50%; background: linear-gradient(135deg, var(--a), var(--b)); color: #fff; font-family: Georgia, serif; font-size: 44px; font-weight: 900; line-height: 1; animation: rq-pulse-{{ $uid }} 2.2s ease-out infinite; }
    #{{ $uid }} .rq[data-style="card"][data-align="left"] .rq-badge { left: 40px; margin-left: 0; }
    #{{ $uid }} .rq[data-style="card"][data-align="right"] .rq-badge { left: auto; right: 40px; margin-left: 0; }

    #{{ $uid }} .rq[data-style="gradient"] { padding: clamp(40px, 6vw, 76px) clamp(28px, 5vw, 72px); border-radius: 36px; overflow: hidden; background: #070816; transform: perspective(1200px) rotateX(var(--rx)) rotateY(var(--ry)); transition: transform .25s ease-out; box-shadow: 0 50px 100px -45px var(--a); }
    #{{ $uid }} .rq[data-style="gradient"] .rq-aur { display: block; position: absolute; z-index: 0; left: 50%; top: 50%; width: max(900px, 170%); aspect-ratio: 1; translate: -50% -50%; pointer-events: none; opacity: .6; filter: blur(80px); background: conic-gradient(from 0deg, var(--a), var(--b), #06b6d4, var(--a)); animation: rq-spin-{{ $uid }} 18s linear infinite; }
    #{{ $uid }} .rq[data-style="gradient"]::after { content: ""; position: absolute; inset: 0; z-index: 1; border-radius: inherit; pointer-events: none; background: radial-gradient(ellipse at 50% 50%, rgba(7,8,22,.72), rgba(7,8,22,.15) 80%); }
    #{{ $uid }} .rq[data-style="gradient"]::before { content: ""; position: absolute; inset: 0; z-index: 5; border-radius: inherit; padding: 1.5px; pointer-events: none; background: conic-gradient(from var(--rq-ang), transparent 0 55%, var(--a) 75%, #fff 88%, transparent 100%); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0); mask-composite: exclude; animation: rq-angle-{{ $uid }} 6s linear infinite; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-p { display: block; position: absolute; z-index: 2; left: var(--l); bottom: -12px; width: 5px; height: 5px; border-radius: 50%; background: #fff; opacity: 0; box-shadow: 0 0 12px 2px var(--a); animation: rq-rise-{{ $uid }} var(--s) linear infinite; animation-delay: var(--d); pointer-events: none; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-text { color: #fff; animation: rq-glow-{{ $uid }} 4s ease-in-out infinite alternate; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-name { color: #fff; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-role { color: rgba(255,255,255,.65); }
    #{{ $uid }} .rq[data-style="gradient"] .rq-avatar { border-color: #070816; }
    #{{ $uid }} .rq[data-style="gradient"] .rq-mark.open { display: block; position: absolute; z-index: 2; top: 4px; right: 28px; font-size: 180px; color: #fff; opacity: .1; }

    #{{ $uid }} .rq[data-style="big-marks"] { padding: 70px 12px 20px; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-blob { display: block; position: absolute; z-index: 0; left: var(--bx); top: var(--by); width: 460px; height: 460px; translate: -50% -50%; border-radius: 50%; pointer-events: none; background: radial-gradient(circle, color-mix(in srgb, var(--a) 32%, transparent), color-mix(in srgb, var(--b) 12%, transparent) 45%, transparent 68%); transition: left .9s cubic-bezier(.2,.8,.2,1), top .9s cubic-bezier(.2,.8,.2,1); animation: rq-drift-{{ $uid }} 7s ease-in-out infinite; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-text { font-weight: 800; letter-spacing: -.028em; line-height: 1.3; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-w { overflow: hidden; vertical-align: top; padding: .05em 0 .16em; margin-bottom: -.16em; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark { display: block; position: absolute; z-index: 1; transition: translate .5s ease-out; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.open { top: -34px; left: -8px; font-size: 300px; color: transparent; -webkit-text-stroke: 3px var(--a); opacity: .55; translate: calc(var(--mpx) * 46px) calc(var(--mpy) * 46px); }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.close { right: -6px; bottom: -130px; font-size: 280px; opacity: .22; background: linear-gradient(135deg, var(--a), var(--b)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; translate: calc(var(--mpx) * -60px) calc(var(--mpy) * -60px); }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="center"] .rq-mark.open { left: 50%; margin-left: -80px; }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="right"] .rq-mark.open { left: auto; right: -8px; }
    #{{ $uid }} .rq[data-style="big-marks"][data-align="right"] .rq-mark.close { right: auto; left: -6px; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-name { position: relative; }
    #{{ $uid }} .rq[data-style="big-marks"] .rq-name::after { content: ""; position: absolute; left: 0; right: 0; bottom: -3px; height: 3px; border-radius: 3px; background: linear-gradient(90deg, var(--a), var(--b)); transform: scaleX(.35); transform-origin: left; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rq[data-style="big-marks"]:hover .rq-name::after { transform: scaleX(1); }

    #{{ $uid }} .rq[data-style="minimal"] { margin-top: 14px; padding: 48px clamp(26px, 5vw, 56px) 38px clamp(54px, 8vw, 88px); border: 1px solid #ece6d3; border-radius: 6px; background: #fffdf7; rotate: -.6deg; box-shadow: 0 1px 1px rgba(60,50,20,.06), 0 2px 4px rgba(60,50,20,.05), 0 20px 40px -18px rgba(60,50,20,.32); transition: rotate .6s cubic-bezier(.2,.8,.2,1), translate .6s cubic-bezier(.2,.8,.2,1), box-shadow .6s ease; }
    #{{ $uid }} .rq[data-style="minimal"]:hover { rotate: 0deg; translate: 0 -6px; box-shadow: 0 1px 1px rgba(60,50,20,.06), 0 2px 4px rgba(60,50,20,.05), 0 34px 54px -20px rgba(60,50,20,.38); }
    #{{ $uid }} .rq[data-style="minimal"]::before { content: ""; position: absolute; top: 0; bottom: 0; left: clamp(40px, 6vw, 68px); width: 1px; background: rgba(239,68,68,.35); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-tape { display: block; position: absolute; z-index: 4; top: -15px; left: 50%; width: 120px; height: 30px; margin-left: -60px; rotate: -3deg; background: color-mix(in srgb, var(--a) 30%, rgba(255,255,255,.65)); box-shadow: 0 2px 6px rgba(0,0,0,.12); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-text { font-family: Georgia, 'Times New Roman', serif; font-style: italic; font-weight: 400; letter-spacing: 0; line-height: 1.75; background: linear-gradient(to bottom, transparent calc(100% - 1px), color-mix(in srgb, var(--a) 28%, transparent) 0) 0 0 / 100% calc(var(--rq-size) * 1.75); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-name { font-family: Georgia, serif; font-style: italic; text-decoration: underline wavy var(--a); text-decoration-thickness: 1px; text-underline-offset: 5px; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ring { width: 46px; height: 46px; padding: 2px; }
    #{{ $uid }} .rq[data-style="minimal"] .rq-ring::before { background: conic-gradient(from 0deg, var(--a), transparent 70%, var(--a)); }
    #{{ $uid }} .rq[data-style="minimal"] .rq-caret { display: inline-block; width: 2px; height: 1.05em; margin-left: 3px; vertical-align: -.15em; background: var(--a); animation: rq-blink-{{ $uid }} 1s steps(1) infinite; }

    #{{ $uid }} .rq.js:not(.vis):is([data-style="card"], [data-style="gradient"], [data-style="big-marks"]) .rq-w > span { opacity: 0; }
    #{{ $uid }} .rq.js:not(.vis) :is(.rq-author, .rq-mark, .rq-badge) { opacity: 0; }
    #{{ $uid }} .rq[data-style="accent-bar"].js:not(.vis) .rq-text { clip-path: inset(-30% 100% -30% 0); }
    #{{ $uid }} .rq[data-style="minimal"].js .rq-w > span { opacity: 0; }
    #{{ $uid }} .rq[data-style="minimal"].js .rq-w.on > span { opacity: 1; }
    #{{ $uid }} .rq[data-style="minimal"].js .rq-author { opacity: 0; transition: opacity .8s ease .1s; }
    #{{ $uid }} .rq[data-style="minimal"].js.done .rq-author { opacity: 1; }

    #{{ $uid }} .rq.vis[data-style="card"] .rq-w > span { animation: rq-flip-{{ $uid }} .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--w, 0) * 50ms + 300ms); }
    #{{ $uid }} .rq.vis[data-style="gradient"] .rq-w > span { animation: rq-blur-{{ $uid }} 1s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--w, 0) * 55ms + 300ms); }
    #{{ $uid }} .rq.vis[data-style="big-marks"] .rq-w > span { animation: rq-mask-{{ $uid }} .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--w, 0) * 60ms + 300ms); }
    #{{ $uid }} .rq.vis[data-style="accent-bar"] .rq-text { animation: rq-clip-{{ $uid }} 1.9s cubic-bezier(.65,0,.35,1) backwards; }
    #{{ $uid }} .rq.vis[data-style="accent-bar"] .rq-beam { animation: rq-sweep-{{ $uid }} 1.9s cubic-bezier(.65,0,.35,1) forwards; }
    #{{ $uid }} .rq.vis:not([data-style="minimal"]) .rq-author { animation: rq-up-{{ $uid }} .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--total, 0) * 55ms + 650ms); }
    #{{ $uid }} .rq.vis[data-style="accent-bar"] .rq-author { animation-delay: 1.8s; }
    #{{ $uid }} .rq.vis .rq-mark.open { animation: rq-pop-{{ $uid }} .9s cubic-bezier(.34,1.56,.64,1) .1s backwards; }
    #{{ $uid }} .rq.vis .rq-mark.close { animation: rq-up-{{ $uid }} 1s ease .7s backwards; }
    #{{ $uid }} .rq.vis .rq-badge { animation: rq-pop-{{ $uid }} .8s cubic-bezier(.34,1.56,.64,1) .1s backwards, rq-pulse-{{ $uid }} 2.2s ease-out .9s infinite; }

    @media (max-width: 639px) {
        #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.open { font-size: 200px; }
        #{{ $uid }} .rq[data-style="big-marks"] .rq-mark.close { font-size: 170px; bottom: -80px; }
        #{{ $uid }} .rq[data-style="gradient"] .rq-mark.open { font-size: 110px; }
        #{{ $uid }} .rq[data-style="minimal"] { padding-left: 48px; }
        #{{ $uid }} .rq-ring { width: 48px; height: 48px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rq" data-style="{{ $style }}" data-align="{{ $align }}" data-animate="{{ $animate ? 1 : 0 }}">

        <span class="rq-grid" aria-hidden="true"></span>
        <span class="rq-aur" aria-hidden="true"></span>
        <span class="rq-blob" aria-hidden="true"></span>
        <span class="rq-foil" aria-hidden="true"></span>
        <span class="rq-glare" aria-hidden="true"></span>
        <span class="rq-tape" aria-hidden="true"></span>

        @if ($style === 'card')
            @foreach ([['8%', '14%', '0s'], ['90%', '22%', '.9s'], ['82%', '78%', '1.8s'], ['12%', '70%', '2.4s']] as $s)
                <span class="rq-star" style="--l: {{ $s[0] }}; --t2: {{ $s[1] }}; --d: {{ $s[2] }};" aria-hidden="true"></span>
            @endforeach
        @endif

        @if ($style === 'gradient')
            @foreach ([['6%', '0s', '9s'], ['18%', '3s', '12s'], ['31%', '1s', '10s'], ['44%', '5s', '13s'], ['58%', '2s', '9s'], ['71%', '6s', '11s'], ['84%', '4s', '14s'], ['94%', '7s', '10s']] as $p)
                <span class="rq-p" style="--l: {{ $p[0] }}; --d: {{ $p[1] }}; --s: {{ $p[2] }};" aria-hidden="true"></span>
            @endforeach
        @endif

        @if ($showMarks)
            @if ($style === 'card')
                <span class="rq-badge" aria-hidden="true">&ldquo;</span>
            @elseif ($style === 'big-marks')
                <span class="rq-mark open" aria-hidden="true">&ldquo;</span>
                <span class="rq-mark close" aria-hidden="true">&rdquo;</span>
            @elseif ($style === 'accent-bar' || $style === 'gradient')
                <span class="rq-mark open" aria-hidden="true">&ldquo;</span>
            @endif
        @endif

        <div class="rq-body">
            <span class="rq-beam" aria-hidden="true"></span>
            @if ($quote !== '')
                <blockquote class="rq-text">@foreach ($lines as $line)@foreach (preg_split('/\s+/u', trim($line), -1, PREG_SPLIT_NO_EMPTY) ?: [] as $word)<span class="rq-w" style="--w: {{ min($n++, 80) }};"><span>{{ $word }}</span></span> @endforeach @if (!$loop->last)<br>@endif @endforeach</blockquote>
            @endif
        </div>

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

    el.style.setProperty('--total', Math.min(words.length, 80));

    function typeIt() {
        clearTimeout(timer);
        el.classList.remove('done');
        words.forEach(function (w) { w.classList.remove('on'); });
        var caret = el.querySelector('.rq-caret');
        if (!caret) {
            caret = document.createElement('span');
            caret.className = 'rq-caret';
            caret.setAttribute('aria-hidden', 'true');
        }
        var i = 0;
        (function step() {
            if (i >= words.length) { el.classList.add('done'); return; }
            var w = words[i++];
            w.classList.add('on');
            w.parentNode.insertBefore(caret, w.nextSibling);
            timer = setTimeout(step, 55 + w.textContent.length * 30);
        })();
    }

    function start() {
        el.classList.add('vis');
        if (style === 'minimal') { typeIt(); }
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

        if (style === 'minimal') { el.addEventListener('click', typeIt); }
    }

    if (canHover && !reduce) {
        if (style === 'card' || style === 'gradient') {
            var k = style === 'card' ? 8 : 5;
            el.addEventListener('pointermove', function (e) {
                var r = el.getBoundingClientRect();
                var x = e.clientX - r.left, y = e.clientY - r.top;
                el.style.setProperty('--mx', x + 'px');
                el.style.setProperty('--my', y + 'px');
                el.style.setProperty('--px', (x / r.width * 100).toFixed(1));
                el.style.setProperty('--py', (y / r.height * 100).toFixed(1));
                el.style.setProperty('--ry', ((x / r.width - 0.5) * k).toFixed(2) + 'deg');
                el.style.setProperty('--rx', ((0.5 - y / r.height) * k).toFixed(2) + 'deg');
            });
            el.addEventListener('pointerleave', function () {
                el.style.setProperty('--rx', '0deg');
                el.style.setProperty('--ry', '0deg');
            });
        }

        if (style === 'big-marks') {
            el.addEventListener('pointermove', function (e) {
                var r = el.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
                el.style.setProperty('--bx', (x * 100).toFixed(1) + '%');
                el.style.setProperty('--by', (y * 100).toFixed(1) + '%');
                el.style.setProperty('--mpx', (x - 0.5).toFixed(3));
                el.style.setProperty('--mpy', (y - 0.5).toFixed(3));
            });
            el.addEventListener('pointerleave', function () {
                el.style.setProperty('--mpx', '0');
                el.style.setProperty('--mpy', '0');
            });
        }
    }
})();
</script>
