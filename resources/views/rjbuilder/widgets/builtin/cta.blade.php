@php
    $allowedLayouts = ['centered', 'split'];
    $allowedBg      = ['gradient', 'solid', 'dark', 'glass'];
    $allowedRadius  = ['md', 'xl', '2xl', '3xl'];

    $layout    = in_array($settings['layout'] ?? 'centered', $allowedLayouts, true) ? $settings['layout'] : 'centered';
    $bgStyle   = in_array($settings['bg_style'] ?? 'gradient', $allowedBg, true) ? $settings['bg_style'] : 'gradient';
    $radius    = in_array($settings['radius'] ?? 'xl', $allowedRadius, true) ? $settings['radius'] : 'xl';
    $paddingY  = max(0, min(240, (int) ($settings['padding_y'] ?? 80)));
    $showAura  = !empty($settings['show_shapes'] ?? true);
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
        if ($v === '' || preg_match('/^\s*(javascript|data|vbscript):/i', $v)) {
            return '#';
        }
        return $v;
    };
    $btn1Url = $safeUrl($settings['btn1_url'] ?? '#');
    $btn2Url = $safeUrl($settings['btn2_url'] ?? '#');

    $chips = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['chips'] ?? '')) as $c) {
        $c = trim($c);
        if ($c !== '') {
            $chips[] = $c;
        }
    }

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $accent     = $hexOk($settings['accent'] ?? '', '#8b5cf6');
    $accent2    = $hexOk($settings['accent2'] ?? '', '#ec4899');
    $titleColor = $hexOk($settings['title_color'] ?? '', '#0f172a');
    $textColor  = $hexOk($settings['text_color'] ?? '', '#475569');

    $isDarkBg = in_array($bgStyle, ['gradient', 'dark'], true);
    $finalTitle = $isDarkBg ? '#ffffff' : $titleColor;
    $finalText  = $isDarkBg ? 'rgba(255,255,255,.8)' : $textColor;

    // Title with highlighted part (escaped first, so no HTML injection)
    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(
            e($highlight),
            '<span class="cx-hl">' . e($highlight) . '</span>',
            $titleHtml
        );
    }

    $radiusCss = ['md' => '18px', 'xl' => '26px', '2xl' => '34px', '3xl' => '44px'][$radius];
@endphp

<style>
    #{{ $uid }} {
        --cx-a: {{ $accent }};
        --cx-b: {{ $accent2 }};
        --cx-title: {{ $finalTitle }};
        --cx-text: {{ $finalText }};
        --cx-mx: 50%;
        --cx-my: 50%;
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Card shell ---------- */
    #{{ $uid }} .cx-card {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        isolation: isolate;
        padding: {{ $layout === 'split' ? '60px 52px' : '72px 40px' }};
        transition: transform .6s cubic-bezier(.2,.8,.2,1), box-shadow .6s ease;
    }
    #{{ $uid }} .cx-card:hover { transform: translateY(-4px); }
    @media (max-width: 720px) {
        #{{ $uid }} .cx-card { padding: 48px 24px; }
    }

    #{{ $uid }}[data-bg="gradient"] .cx-card {
        background: linear-gradient(125deg, var(--cx-a), var(--cx-b));
        box-shadow: 0 40px 80px -36px color-mix(in srgb, var(--cx-a) 65%, transparent);
    }
    #{{ $uid }}[data-bg="dark"] .cx-card {
        background: #0b1120;
        box-shadow: 0 40px 80px -36px rgba(0,0,0,.7);
    }
    #{{ $uid }}[data-bg="solid"] .cx-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 50px -28px rgba(15,23,42,.25);
    }
    #{{ $uid }}[data-bg="glass"] .cx-card {
        background: linear-gradient(125deg, color-mix(in srgb, var(--cx-a) 22%, #fff), color-mix(in srgb, var(--cx-b) 22%, #fff));
        border: 1px solid rgba(255,255,255,.7);
        -webkit-backdrop-filter: blur(14px);
        backdrop-filter: blur(14px);
        box-shadow: 0 30px 60px -30px rgba(15,23,42,.25);
    }

    /* ---------- Animated aurora background ---------- */
    #{{ $uid }} .cx-aura {
        position: absolute;
        inset: -20%;
        z-index: -2;
        pointer-events: none;
        display: none;
    }
    @if($showAura)
    #{{ $uid }}[data-bg="gradient"] .cx-aura,
    #{{ $uid }}[data-bg="dark"] .cx-aura,
    #{{ $uid }}[data-bg="glass"] .cx-aura { display: block; }
    @endif
    #{{ $uid }} .cx-blob {
        position: absolute;
        width: 46%;
        height: 60%;
        border-radius: 50%;
        filter: blur(60px);
        opacity: .55;
        animation: cxFloat 14s ease-in-out infinite alternate;
    }
    #{{ $uid }} .cx-blob.b1 { left: -6%; top: -10%; background: #fff; opacity: .28; }
    #{{ $uid }} .cx-blob.b2 { right: -8%; bottom: -14%; background: var(--cx-b); opacity: .6; animation-delay: -5s; }
    #{{ $uid }} .cx-blob.b3 { left: 36%; top: 30%; background: var(--cx-a); opacity: .45; animation-delay: -9s; width: 34%; height: 44%; }
    #{{ $uid }}[data-bg="dark"] .cx-blob.b1 { background: var(--cx-a); opacity: .35; }
    #{{ $uid }}[data-bg="dark"] .cx-blob.b2 { background: var(--cx-b); opacity: .3; }
    #{{ $uid }}[data-bg="dark"] .cx-blob.b3 { opacity: .18; }
    #{{ $uid }}[data-bg="glass"] .cx-blob.b1 { background: var(--cx-a); opacity: .25; }
    #{{ $uid }}[data-bg="glass"] .cx-blob.b2 { background: var(--cx-b); opacity: .25; }
    #{{ $uid }}[data-bg="glass"] .cx-blob.b3 { background: #fff; opacity: .4; }

    /* Film grain for texture */
    #{{ $uid }} .cx-grain {
        position: absolute;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        opacity: .07;
        mix-blend-mode: overlay;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
    }

    /* Cursor spotlight */
    #{{ $uid }} .cx-spot {
        position: absolute;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        opacity: 0;
        transition: opacity .5s ease;
        background: radial-gradient(420px circle at var(--cx-mx) var(--cx-my), rgba(255,255,255,.22), transparent 60%);
    }
    #{{ $uid }} .cx-card:hover .cx-spot { opacity: 1; }
    #{{ $uid }}[data-bg="solid"] .cx-spot {
        background: radial-gradient(420px circle at var(--cx-mx) var(--cx-my), color-mix(in srgb, var(--cx-a) 10%, transparent), transparent 60%);
    }

    /* Solid card: animated top line instead of aurora */
    #{{ $uid }}[data-bg="solid"] .cx-card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--cx-a), var(--cx-b), var(--cx-a));
        background-size: 200% 100%;
        animation: cxFlow 4s linear infinite;
    }

    /* ---------- Layout ---------- */
    #{{ $uid }} .cx-centered { text-align: center; max-width: 740px; margin: 0 auto; }
    #{{ $uid }} .cx-split {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 48px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .cx-split { grid-template-columns: 1fr; gap: 36px; text-align: center; }
        #{{ $uid }} .cx-split .cx-actions,
        #{{ $uid }} .cx-split .cx-chips { justify-content: center; }
    }

    /* ---------- Reveal sequence ---------- */
    #{{ $uid }} .cx-reveal > * {
        opacity: 0;
        transform: translateY(18px);
    }
    #{{ $uid }} .cx-reveal.is-visible > * {
        animation: cxUp .8s cubic-bezier(.2,.8,.2,1) forwards;
        animation-delay: calc(var(--d, 0) * .12s);
    }

    /* ---------- Badge ---------- */
    #{{ $uid }} .cx-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px 7px 9px;
        margin-bottom: 20px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        background: rgba(255,255,255,.14);
        color: var(--cx-title);
        border: 1px solid rgba(255,255,255,.3);
    }
    #{{ $uid }}[data-bg="solid"] .cx-badge {
        background: color-mix(in srgb, var(--cx-a) 10%, transparent);
        color: var(--cx-a);
        border-color: color-mix(in srgb, var(--cx-a) 25%, transparent);
    }
    #{{ $uid }} .cx-badge-dot {
        position: relative;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff;
    }
    #{{ $uid }}[data-bg="solid"] .cx-badge-dot { background: var(--cx-a); }
    #{{ $uid }} .cx-badge-dot::after {
        content: "";
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid currentColor;
        color: inherit;
        opacity: 0;
        animation: cxPing 2s ease-out infinite;
    }

    /* ---------- Title ---------- */
    #{{ $uid }} .cx-title {
        margin: 0 0 16px;
        font-size: clamp(26px, 3.6vw, 44px);
        font-weight: 900;
        line-height: 1.1;
        letter-spacing: -.025em;
        color: var(--cx-title);
    }
    #{{ $uid }} .cx-hl {
        position: relative;
        display: inline-block;
        background: linear-gradient(90deg, #fff, rgba(255,255,255,.75), #fff);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: cxShimmer 4s linear infinite;
    }
    #{{ $uid }}[data-bg="solid"] .cx-hl,
    #{{ $uid }}[data-bg="glass"] .cx-hl {
        background: linear-gradient(90deg, var(--cx-a), var(--cx-b), var(--cx-a));
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .cx-hl::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: .04em;
        height: .14em;
        border-radius: 4px;
        background: currentColor;
        opacity: .0;
        transform-origin: left;
        transform: scaleX(0);
        -webkit-text-fill-color: initial;
    }
    #{{ $uid }} .cx-reveal.is-visible .cx-hl::after {
        opacity: .35;
        animation: cxUnderline 1s .6s cubic-bezier(.2,.8,.2,1) forwards;
    }

    #{{ $uid }} .cx-desc {
        margin: 0 0 28px;
        max-width: 620px;
        font-size: 16px;
        line-height: 1.7;
        color: var(--cx-text);
    }
    #{{ $uid }} .cx-centered .cx-desc { margin-left: auto; margin-right: auto; }

    /* ---------- Buttons ---------- */
    #{{ $uid }} .cx-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 26px;
    }
    #{{ $uid }} .cx-centered .cx-actions { justify-content: center; }

    #{{ $uid }} .cx-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 26px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        isolation: isolate;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .3s ease, background .3s ease, color .3s ease;
    }
    #{{ $uid }} .cx-btn:active { transform: scale(.97); }
    #{{ $uid }} .cx-btn svg {
        width: 15px;
        height: 15px;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .cx-btn:hover svg { transform: translateX(4px); }

    #{{ $uid }} .cx-btn-primary {
        background: #fff;
        color: var(--cx-a);
        box-shadow: 0 14px 30px -14px rgba(15,23,42,.45);
    }
    #{{ $uid }}[data-bg="solid"] .cx-btn-primary {
        background: linear-gradient(120deg, var(--cx-a), var(--cx-b));
        color: #fff;
        box-shadow: 0 14px 30px -14px color-mix(in srgb, var(--cx-a) 70%, transparent);
    }
    #{{ $uid }} .cx-btn-primary::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -60%;
        width: 40%;
        z-index: -1;
        background: linear-gradient(100deg, transparent, rgba(255,255,255,.55), transparent);
        transform: skewX(-20deg);
        animation: cxSweep 3.6s ease-in-out infinite;
    }
    #{{ $uid }} .cx-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 22px 40px -16px rgba(15,23,42,.55);
    }

    #{{ $uid }} .cx-btn-ghost {
        background: rgba(255,255,255,.06);
        color: var(--cx-title);
        border: 1.5px solid color-mix(in srgb, var(--cx-title) 28%, transparent);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }
    #{{ $uid }} .cx-btn-ghost:hover {
        background: var(--cx-title);
        color: #fff;
        border-color: var(--cx-title);
        transform: translateY(-3px);
    }
    #{{ $uid }}[data-bg="gradient"] .cx-btn-ghost:hover,
    #{{ $uid }}[data-bg="dark"] .cx-btn-ghost:hover { color: #0b1120; background: #fff; }
    #{{ $uid }}[data-bg="gradient"] .cx-btn-ghost,
    #{{ $uid }}[data-bg="dark"] .cx-btn-ghost { border-color: rgba(255,255,255,.4); }

    /* ---------- Chips ---------- */
    #{{ $uid }} .cx-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    #{{ $uid }} .cx-centered .cx-chips { justify-content: center; }
    #{{ $uid }} .cx-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 13px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: var(--cx-title);
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), background .3s ease;
    }
    #{{ $uid }}[data-bg="solid"] .cx-chip {
        background: color-mix(in srgb, var(--cx-a) 8%, transparent);
        border-color: color-mix(in srgb, var(--cx-a) 18%, transparent);
    }
    #{{ $uid }} .cx-chip:hover { transform: translateY(-2px); background: rgba(255,255,255,.22); }
    #{{ $uid }} .cx-chip svg { flex-shrink: 0; }
    #{{ $uid }}[data-bg="solid"] .cx-chip svg { color: var(--cx-a); }

    /* ---------- Media ---------- */
    #{{ $uid }} .cx-media {
        position: relative;
        padding: 10px;
        border-radius: 28px;
    }
    #{{ $uid }} .cx-media::before {
        content: "";
        position: absolute;
        inset: -2px;
        border-radius: 30px;
        background: conic-gradient(from 0deg, var(--cx-a), var(--cx-b), #fff, var(--cx-a));
        animation: cxSpin 8s linear infinite;
        z-index: -1;
        opacity: .9;
    }
    #{{ $uid }} .cx-media-inner {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #0b1120;
        animation: cxBob 6s ease-in-out infinite;
    }
    #{{ $uid }} .cx-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 1.2s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .cx-card:hover .cx-media img { transform: scale(1.06); }

    /* ---------- Keyframes ---------- */
    @keyframes cxUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes cxFloat {
        0%   { transform: translate(0, 0) scale(1); }
        100% { transform: translate(50px, -40px) scale(1.18); }
    }
    @keyframes cxFlow {
        0%   { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    @keyframes cxShimmer {
        0%   { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    @keyframes cxUnderline {
        to { transform: scaleX(1); }
    }
    @keyframes cxSweep {
        0%, 60% { left: -60%; }
        100%    { left: 140%; }
    }
    @keyframes cxPing {
        0%   { transform: scale(.6); opacity: .9; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    @keyframes cxSpin {
        to { transform: rotate(360deg); }
    }
    @keyframes cxBob {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .cx-reveal > * { opacity: 1; transform: none; }
        #{{ $uid }} .cx-hl::after { transform: scaleX(1); opacity: .35; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}">
    <div class="cx-card">
        @if($bgStyle !== 'solid')
            <div class="cx-aura" aria-hidden="true">
                <span class="cx-blob b1"></span>
                <span class="cx-blob b2"></span>
                <span class="cx-blob b3"></span>
            </div>
        @endif
        <span class="cx-grain" aria-hidden="true"></span>
        <span class="cx-spot" aria-hidden="true"></span>

        <div class="{{ $animateOn ? 'cx-reveal' : '' }} {{ $layout === 'split' ? 'cx-split' : 'cx-centered' }}" data-reveal>

            <div class="{{ $layout === 'split' ? '' : 'cx-body' }}">
                @if($badge !== '')
                    <span class="cx-badge" style="--d: 0;">
                        <span class="cx-badge-dot"></span>
                        <span>{{ $badge }}</span>
                    </span>
                @endif

                @if($title !== '')
                    <h2 class="cx-title" style="--d: 1;">{!! $titleHtml !!}</h2>
                @endif

                @if($desc !== '')
                    <p class="cx-desc" style="--d: 2;">{{ $desc }}</p>
                @endif

                @if($btn1Label !== '' || $btn2Label !== '')
                    <div class="cx-actions" style="--d: 3;">
                        @if($btn1Label !== '')
                            <a href="{{ $btn1Url }}" class="cx-btn cx-btn-primary">
                                <span>{{ $btn1Label }}</span>
                                <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                        @if($btn2Label !== '')
                            <a href="{{ $btn2Url }}" class="cx-btn cx-btn-ghost">
                                <span>{{ $btn2Label }}</span>
                            </a>
                        @endif
                    </div>
                @endif

                @if(!empty($chips))
                    <div class="cx-chips" style="--d: 4;">
                        @foreach($chips as $chip)
                            <span class="cx-chip" style="--d: {{ 4 + $loop->index * 0.3 }};">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ $chip }}</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($layout === 'split' && $image !== '')
                <div class="cx-media" style="--d: 2;">
                    <div class="cx-media-inner">
                        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var card = root.querySelector('.cx-card');
    var reveal = root.querySelector('[data-reveal]');

    // Reveal the content when it scrolls into view
    if (reveal && reveal.classList.contains('cx-reveal')) {
        if (!('IntersectionObserver' in window)) {
            reveal.classList.add('is-visible');
        } else {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        reveal.classList.add('is-visible');
                        io.disconnect();
                    }
                });
            }, { threshold: 0.15 });
            io.observe(reveal);
        }
    }

    // Cursor spotlight (mouse only)
    if (card && window.matchMedia && window.matchMedia('(hover: hover)').matches
        && !(window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
        card.addEventListener('pointermove', function (e) {
            var r = card.getBoundingClientRect();
            root.style.setProperty('--cx-mx', (e.clientX - r.left) + 'px');
            root.style.setProperty('--cx-my', (e.clientY - r.top) + 'px');
        });
    }
})();
</script>
