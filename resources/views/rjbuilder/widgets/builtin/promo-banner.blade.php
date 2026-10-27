@php
    $pick = function ($v, $allowed, $d) {
        return in_array($v, $allowed, true) ? $v : $d;
    };
    $safeUrl = function ($v) {
        $v = trim((string) $v);
        return ($v === '' || preg_match('/^\s*(javascript|data|vbscript):/i', $v)) ? '#' : $v;
    };
    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v)) return $d;
        if (strlen($v) === 4) {
            $v = '#' . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3];
        }
        return $v;
    };

    $layout       = $pick($settings['layout'] ?? 'split', ['split', 'centered', 'ribbon'], 'split');
    $bgStyle      = $pick($settings['bg_style'] ?? 'gradient', ['gradient', 'solid', 'dark', 'image'], 'gradient');
    $radius       = $pick($settings['radius'] ?? 'xl', ['none', 'md', 'xl', '2xl'], 'xl');
    $badge        = trim((string) ($settings['badge'] ?? ''));
    $title        = trim((string) ($settings['title'] ?? ''));
    $highlight    = trim((string) ($settings['highlight'] ?? ''));
    $desc         = trim((string) ($settings['desc'] ?? ''));
    $btnLabel     = trim((string) ($settings['btn_label'] ?? ''));
    $btnUrl       = $safeUrl($settings['btn_url'] ?? '#');
    $image        = trim((string) ($settings['image'] ?? ''));
    $countdown    = !empty($settings['countdown'] ?? false);
    $countdownEnd = trim((string) ($settings['countdown_end'] ?? ''));
    $coupon       = trim((string) ($settings['coupon'] ?? ''));
    $couponHint   = trim((string) ($settings['coupon_hint'] ?? ''));
    $accent       = $hexOk($settings['accent'] ?? '', '#8b5cf6');
    $accent2      = $hexOk($settings['accent2'] ?? '', '#ec4899');
    $showShapes   = !empty($settings['show_shapes'] ?? true);
    $animate      = !empty($settings['animate'] ?? true);
    $paddingY     = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));

    $bgImage = trim((string) ($settings['bg_image'] ?? ''));
    if ($bgImage !== '' && (!preg_match('/^(https?:)?\/\/|^\//i', $bgImage) || preg_match('/[\'"()\\\\\s<>]/', $bgImage))) {
        $bgImage = '';
    }
    if ($image !== '') $image = $safeUrl($image);
    if ($image === '#') $image = '';

    $radiusMap = ['none' => '0px', 'md' => '14px', 'xl' => '22px', '2xl' => '32px'];
    $radiusCss = $radiusMap[$radius];

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(e($highlight), '<span class="rj-pb-hl">' . e($highlight) . '</span>', $titleHtml);
    }

    $isRibbon = $layout === 'ribbon';
    $isSplit  = $layout === 'split';
    $palette  = [$accent, $accent2, '#ffffff', '#fde047'];

    $countdownTs = 0;
    if ($countdownEnd !== '') {
        $ts = strtotime($countdownEnd);
        if ($ts !== false) $countdownTs = $ts * 1000;
    }
@endphp

<style>
    #{{ $uid }} {
        --pb-a: {{ $accent }};
        --pb-b: {{ $accent2 }};
        --pb-glow: color-mix(in srgb, var(--pb-a) 55%, transparent);
        --sx: 50%;
        --sy: 50%;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }}[data-bg="gradient"],
    #{{ $uid }}[data-bg="dark"],
    #{{ $uid }}[data-bg="image"] { --pb-glow: rgba(255, 255, 255, .5); }

    #{{ $uid }} .rj-pb-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        padding: {{ $isRibbon ? '20px 28px' : '52px 44px' }};
        isolation: isolate;
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-pb-wrap { padding: {{ $isRibbon ? '18px 20px' : '38px 22px' }}; }
    }

    #{{ $uid }}[data-bg="gradient"] .rj-pb-wrap {
        background: linear-gradient(125deg, var(--pb-a), var(--pb-b));
        color: #fff;
        box-shadow: 0 30px 60px -30px color-mix(in srgb, var(--pb-a) 55%, transparent);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-wrap {
        background: #fff;
        color: #0f172a;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 48px -24px rgba(15, 23, 42, .15);
    }
    #{{ $uid }}[data-bg="dark"] .rj-pb-wrap {
        background: #0f172a;
        color: #fff;
        box-shadow: 0 30px 60px -30px rgba(0, 0, 0, .6);
    }
    #{{ $uid }}[data-bg="image"] .rj-pb-wrap {
        color: #fff;
        background-color: #0f172a;
    }
    @if($bgImage !== '')
    #{{ $uid }}[data-bg="image"] .rj-pb-wrap {
        background-image: linear-gradient(120deg, rgba(15, 23, 42, .78), rgba(15, 23, 42, .55)), url('{{ $bgImage }}');
        background-size: cover;
        background-position: center;
    }
    @endif

    #{{ $uid }} .rj-pb-shapes {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
        border-radius: inherit;
    }
    #{{ $uid }} .rj-pb-shape {
        position: absolute;
        border-radius: 50%;
        opacity: .3;
        filter: blur(48px);
    }
    #{{ $uid }} .rj-pb-shape.s1 { width: 280px; height: 280px; background: rgba(255, 255, 255, .35); top: -80px; left: -60px; }
    #{{ $uid }} .rj-pb-shape.s2 { width: 220px; height: 220px; background: rgba(255, 255, 255, .22); bottom: -70px; right: -50px; animation-delay: -4s; }
    #{{ $uid }} .rj-pb-shape.s3 { width: 160px; height: 160px; background: rgba(255, 255, 255, .28); top: 30%; right: 25%; animation-delay: -8s; }

    #{{ $uid }} .rj-pb-spot {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        opacity: 0;
        transition: opacity .5s ease;
        background: radial-gradient(380px circle at var(--sx) var(--sy), rgba(255, 255, 255, .18), transparent 70%);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-spot {
        background: radial-gradient(380px circle at var(--sx) var(--sy), color-mix(in srgb, var(--pb-a) 12%, transparent), transparent 70%);
    }
    #{{ $uid }} .rj-pb-wrap:hover .rj-pb-spot { opacity: 1; }

    #{{ $uid }} .rj-pb-wrap::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background: linear-gradient(105deg, transparent 42%, rgba(255, 255, 255, .3) 50%, transparent 58%);
        transform: translateX(-130%);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-wrap::after {
        background: linear-gradient(105deg, transparent 42%, color-mix(in srgb, var(--pb-a) 14%, transparent) 50%, transparent 58%);
    }

    #{{ $uid }} .rj-pb-inner {
        position: relative;
        z-index: 1;
    }
    #{{ $uid }} .rj-pb-split {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 44px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .rj-pb-split { grid-template-columns: 1fr; gap: 28px; text-align: center; }
        #{{ $uid }} .rj-pb-split .rj-pb-actions,
        #{{ $uid }} .rj-pb-split .rj-pb-coupon-row,
        #{{ $uid }} .rj-pb-split .rj-pb-countdown { justify-content: center; }
        #{{ $uid }} .rj-pb-split .rj-pb-desc { margin-left: auto; margin-right: auto; }
    }
    #{{ $uid }} .rj-pb-centered {
        text-align: center;
        max-width: 760px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-pb-centered .rj-pb-actions,
    #{{ $uid }} .rj-pb-centered .rj-pb-coupon-row,
    #{{ $uid }} .rj-pb-centered .rj-pb-countdown { justify-content: center; }
    #{{ $uid }} .rj-pb-centered .rj-pb-desc { margin-left: auto; margin-right: auto; }

    #{{ $uid }} .rj-pb-ribbon {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        justify-content: center;
        text-align: center;
    }
    @media (min-width: 860px) {
        #{{ $uid }} .rj-pb-ribbon { justify-content: space-between; text-align: left; }
    }

    #{{ $uid }} .rj-pb-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        margin-bottom: 16px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1;
        color: var(--pb-a);
        background: color-mix(in srgb, var(--pb-a) 12%, transparent);
        border: 1px solid color-mix(in srgb, var(--pb-a) 28%, transparent);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-badge,
    #{{ $uid }}[data-bg="dark"] .rj-pb-badge,
    #{{ $uid }}[data-bg="image"] .rj-pb-badge {
        background: rgba(255, 255, 255, .16);
        border-color: rgba(255, 255, 255, .3);
        color: #fff;
    }
    #{{ $uid }} .rj-pb-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    #{{ $uid }} .rj-pb-title {
        font-size: clamp(26px, 4.2vw, 48px);
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.1;
        margin: 0 0 14px;
        text-wrap: balance;
    }

    #{{ $uid }} .rj-pb-w {
        display: inline-block;
        overflow: hidden;
        vertical-align: top;
        padding: 0 .04em .1em;
        margin: 0 -.04em -.1em;
    }
    #{{ $uid }} .rj-pb-wi {
        display: inline-block;
        padding-bottom: .08em;
        transform-origin: 0 100%;
    }

    #{{ $uid }} .rj-pb-hl {
        display: inline-block;
        background-image: linear-gradient(90deg, var(--pb-a), var(--pb-b), var(--pb-a));
        background-size: 250% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        font-weight: 900;
        padding: 0 .04em;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-hl,
    #{{ $uid }}[data-bg="dark"] .rj-pb-hl,
    #{{ $uid }}[data-bg="image"] .rj-pb-hl,
    #{{ $uid }}[data-bg="gradient"] .rj-pb-hl .rj-pb-wi,
    #{{ $uid }}[data-bg="dark"] .rj-pb-hl .rj-pb-wi,
    #{{ $uid }}[data-bg="image"] .rj-pb-hl .rj-pb-wi {
        background-image: linear-gradient(90deg, #fff, rgba(255, 255, 255, .6), #fff);
    }
    #{{ $uid }} .rj-pb-hl.is-split {
        display: inline;
        background: none;
        padding: 0;
        color: inherit;
        -webkit-text-fill-color: initial;
    }
    #{{ $uid }} .rj-pb-hl.is-split .rj-pb-wi {
        background-image: linear-gradient(90deg, var(--pb-a), var(--pb-b), var(--pb-a));
        background-size: 250% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    #{{ $uid }} .rj-pb-desc {
        font-size: 15.5px;
        line-height: 1.7;
        margin: 0 0 24px;
        opacity: .85;
        max-width: 56ch;
    }

    #{{ $uid }} .rj-pb-countdown {
        display: flex;
        gap: 8px;
        margin: 0 0 24px;
    }
    #{{ $uid }} .rj-pb-cd-item {
        min-width: 66px;
        padding: 11px 8px 9px;
        border-radius: 12px;
        background: rgba(15, 23, 42, .06);
        border: 1px solid rgba(15, 23, 42, .08);
        text-align: center;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-cd-item,
    #{{ $uid }}[data-bg="dark"] .rj-pb-cd-item,
    #{{ $uid }}[data-bg="image"] .rj-pb-cd-item {
        background: rgba(255, 255, 255, .16);
        border-color: rgba(255, 255, 255, .24);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }
    #{{ $uid }} .rj-pb-cd-num {
        position: relative;
        display: block;
        height: 1.1em;
        overflow: hidden;
        font-size: 24px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        line-height: 1.1;
    }
    #{{ $uid }} .rj-pb-n {
        position: absolute;
        inset: 0;
        display: block;
        text-align: center;
    }
    #{{ $uid }} .rj-pb-n.is-start { transform: translateY(100%); opacity: 0; }
    #{{ $uid }} .rj-pb-n.is-out   { transform: translateY(-100%); opacity: 0; }
    #{{ $uid }} .rj-pb-cd-lbl {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        font-weight: 600;
        opacity: .7;
    }
    #{{ $uid }} .rj-pb-countdown.is-urgent .rj-pb-cd-item { border-color: var(--pb-glow); }

    #{{ $uid }} .rj-pb-coupon-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin: 0 0 22px;
    }
    #{{ $uid }} .rj-pb-coupon,
    #{{ $uid }} .rj-pb-ribbon-coupon {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 2px dashed currentColor;
        background: transparent;
        color: inherit;
        font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace;
        font-weight: 800;
        cursor: pointer;
    }
    #{{ $uid }} .rj-pb-coupon {
        padding: 11px 16px;
        border-radius: 10px;
        font-size: 14px;
        letter-spacing: .1em;
        transition: transform .2s ease, background .25s ease;
    }
    #{{ $uid }} .rj-pb-coupon:hover { transform: translateY(-1px); background: rgba(255, 255, 255, .1); }
    #{{ $uid }}[data-bg="solid"] .rj-pb-coupon:hover { background: color-mix(in srgb, var(--pb-a) 8%, transparent); }
    #{{ $uid }} .rj-pb-coupon:focus-visible,
    #{{ $uid }} .rj-pb-ribbon-coupon:focus-visible,
    #{{ $uid }} .rj-pb-btn:focus-visible { outline: 3px solid currentColor; outline-offset: 3px; }
    #{{ $uid }} .rj-pb-coupon::after,
    #{{ $uid }} .rj-pb-ribbon-coupon::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(105deg, transparent 35%, rgba(255, 255, 255, .4) 50%, transparent 65%);
        transform: translateX(-130%);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-coupon::after,
    #{{ $uid }}[data-bg="solid"] .rj-pb-ribbon-coupon::after {
        background: linear-gradient(105deg, transparent 35%, color-mix(in srgb, var(--pb-a) 22%, transparent) 50%, transparent 65%);
    }
    #{{ $uid }} .rj-pb-coupon-icon { width: 16px; height: 16px; opacity: .75; flex-shrink: 0; }
    #{{ $uid }} .rj-pb-coupon-hint { font-size: 12.5px; opacity: .75; font-weight: 500; }
    #{{ $uid }} .rj-pb-copied {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 700;
        color: #10b981;
        opacity: 0;
        transition: opacity .25s ease;
    }
    #{{ $uid }} .rj-pb-copied.is-on { opacity: 1; }

    #{{ $uid }} .rj-pb-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    #{{ $uid }} .rj-pb-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: 999px;
        font-size: 14.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        background: #0f172a;
        color: #fff;
        transition: transform .25s cubic-bezier(.2, .8, .2, 1), box-shadow .25s ease, background .25s ease;
        will-change: transform;
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-btn { background: var(--pb-a); color: #fff; }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-btn,
    #{{ $uid }}[data-bg="dark"] .rj-pb-btn,
    #{{ $uid }}[data-bg="image"] .rj-pb-btn {
        background: #fff;
        color: #0f172a;
        box-shadow: 0 14px 28px -12px rgba(0, 0, 0, .4);
    }
    #{{ $uid }} .rj-pb-btn:hover { box-shadow: 0 18px 32px -14px rgba(0, 0, 0, .5); }
    #{{ $uid }} .rj-pb-btn:active { transform: scale(.97) !important; }
    #{{ $uid }} .rj-pb-btn::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(105deg, transparent 35%, rgba(255, 255, 255, .45) 50%, transparent 65%);
        transform: translateX(-130%);
        transition: transform .8s ease;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-btn::after,
    #{{ $uid }}[data-bg="dark"] .rj-pb-btn::after,
    #{{ $uid }}[data-bg="image"] .rj-pb-btn::after {
        background: linear-gradient(105deg, transparent 35%, color-mix(in srgb, var(--pb-a) 30%, transparent) 50%, transparent 65%);
    }
    #{{ $uid }} .rj-pb-btn:hover::after { transform: translateX(130%); }

    #{{ $uid }} .rj-pb-media {
        position: relative;
        perspective: 1000px;
    }
    #{{ $uid }} .rj-pb-tilt {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        border-radius: 18px;
        box-shadow: 0 24px 48px -20px rgba(0, 0, 0, .45);
        transform-style: preserve-3d;
        transition: transform .35s cubic-bezier(.2, .8, .2, 1);
        will-change: transform;
    }
    #{{ $uid }} .rj-pb-tilt img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-pb-tilt::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(300px circle at var(--gx, 50%) var(--gy, 0%), rgba(255, 255, 255, .32), transparent 60%);
        opacity: 0;
        transition: opacity .3s ease;
    }
    #{{ $uid }} .rj-pb-media:hover .rj-pb-tilt::after { opacity: 1; }

    #{{ $uid }} .rj-pb-ribbon-text {
        font-size: clamp(17px, 2.2vw, 24px);
        font-weight: 800;
        letter-spacing: -.02em;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    #{{ $uid }} .rj-pb-ribbon-coupon {
        padding: 7px 13px;
        border-radius: 8px;
        font-size: 13px;
        letter-spacing: .08em;
    }
    #{{ $uid }} .rj-pb-ribbon .rj-pb-actions { gap: 10px; }
    #{{ $uid }} .rj-pb-ribbon .rj-pb-btn { padding: 11px 22px; font-size: 13.5px; }

    @keyframes rjPbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(25px, -30px) scale(1.08); }
    }
    @keyframes rjPbFloaty {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }
    @keyframes rjPbPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%      { opacity: .35; transform: scale(1.6); }
    }
    @keyframes rjPbFlow {
        to { background-position: 250% 50%; }
    }
    @keyframes rjPbShine {
        0%, 55% { transform: translateX(-130%); }
        100%    { transform: translateX(130%); }
    }
    @keyframes rjPbSweep {
        to { transform: translateX(130%); }
    }
    @keyframes rjPbUrgent {
        0%, 100% { box-shadow: 0 0 0 0 transparent; }
        50%      { box-shadow: 0 0 22px -2px var(--pb-glow); }
    }

    @media (prefers-reduced-motion: no-preference) {
        #{{ $uid }} .rj-pb-shape { animation: rjPbFloat 14s ease-in-out infinite; }
        #{{ $uid }} .rj-pb-badge::before { animation: rjPbPulse 1.6s ease-in-out infinite; }
        #{{ $uid }} .rj-pb-media { animation: rjPbFloaty 6s ease-in-out infinite; }
        #{{ $uid }} .rj-pb-coupon::after,
        #{{ $uid }} .rj-pb-ribbon-coupon::after { animation: rjPbShine 3.8s ease-in-out infinite; }
        #{{ $uid }} .rj-pb-hl,
        #{{ $uid }} .rj-pb-hl.is-split .rj-pb-wi { animation: rjPbFlow 6s linear infinite; }
        #{{ $uid }} .rj-pb-countdown.is-urgent .rj-pb-cd-item { animation: rjPbUrgent 1.6s ease-in-out infinite; }
        #{{ $uid }} .rj-pb-n { transition: transform .5s cubic-bezier(.2, .8, .2, 1), opacity .5s ease; }

        #{{ $uid }}.rj-pb-js[data-animate="1"] .rj-pb-anim {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .8s cubic-bezier(.2, .8, .2, 1);
        }
        #{{ $uid }}.rj-pb-js[data-animate="1"].is-in .rj-pb-anim { opacity: 1; transform: none; }

        #{{ $uid }}.rj-pb-js[data-animate="1"] .rj-pb-wi {
            transform: translateY(115%) rotate(5deg);
            transition: transform 1s cubic-bezier(.2, .9, .2, 1) var(--d, 0ms);
        }
        #{{ $uid }}.rj-pb-js[data-animate="1"].is-in .rj-pb-wi { transform: none; }

        #{{ $uid }}.rj-pb-js[data-animate="1"] .rj-pb-tilt img {
            transform: scale(1.3);
            transition: transform 1.8s cubic-bezier(.2, .8, .2, 1) .2s;
        }
        #{{ $uid }}.rj-pb-js[data-animate="1"].is-in .rj-pb-tilt img { transform: none; }

        #{{ $uid }}.rj-pb-js[data-animate="1"].is-in .rj-pb-wrap::after { animation: rjPbSweep 1.5s .6s ease-in-out forwards; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}" data-layout="{{ $layout }}" data-animate="{{ $animate ? '1' : '0' }}">
    <div class="rj-pb-wrap">
        @if($showShapes)
            <div class="rj-pb-shapes" aria-hidden="true">
                <span class="rj-pb-shape s1"></span>
                <span class="rj-pb-shape s2"></span>
                <span class="rj-pb-shape s3"></span>
            </div>
        @endif
        <div class="rj-pb-spot" aria-hidden="true"></div>

        <div class="rj-pb-inner rj-pb-anim">
            @if($isRibbon)
                <div class="rj-pb-ribbon">
                    <div>
                        @if($badge !== '')
                            <span class="rj-pb-badge">{{ $badge }}</span>
                        @endif
                        @if($title !== '')
                            <p class="rj-pb-ribbon-text">
                                <span data-title>{!! $titleHtml !!}</span>
                                @if($coupon !== '')
                                    <button type="button" class="rj-pb-ribbon-coupon" data-coupon="{{ $coupon }}">
                                        <svg class="rj-pb-coupon-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <span data-coupon-text>{{ $coupon }}</span>
                                    </button>
                                @endif
                            </p>
                        @endif
                    </div>
                    @if($btnLabel !== '')
                        <div class="rj-pb-actions">
                            <a href="{{ $btnUrl }}" class="rj-pb-btn" data-magnet>
                                <span>{{ $btnLabel }}</span>
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="{{ $isSplit ? 'rj-pb-split' : 'rj-pb-centered' }}">
                    <div>
                        @if($badge !== '')
                            <span class="rj-pb-badge">{{ $badge }}</span>
                        @endif
                        @if($title !== '')
                            <h2 class="rj-pb-title" data-title>{!! $titleHtml !!}</h2>
                        @endif
                        @if($desc !== '')
                            <p class="rj-pb-desc">{{ $desc }}</p>
                        @endif

                        @if($countdown && $countdownTs > 0)
                            <div class="rj-pb-countdown" data-countdown="{{ $countdownTs }}">
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-d>00</span><span class="rj-pb-cd-lbl">{{ __('Days') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-h>00</span><span class="rj-pb-cd-lbl">{{ __('Hours') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-m>00</span><span class="rj-pb-cd-lbl">{{ __('Mins') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-s>00</span><span class="rj-pb-cd-lbl">{{ __('Secs') }}</span></div>
                            </div>
                        @endif

                        @if($coupon !== '')
                            <div class="rj-pb-coupon-row">
                                <button type="button" class="rj-pb-coupon" data-coupon="{{ $coupon }}">
                                    <svg class="rj-pb-coupon-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                    <span data-coupon-text>{{ $coupon }}</span>
                                </button>
                                @if($couponHint !== '')
                                    <span class="rj-pb-coupon-hint">{{ $couponHint }}</span>
                                @endif
                                <span class="rj-pb-copied" data-copied>
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ __('Copied') }}</span>
                                </span>
                            </div>
                        @endif

                        @if($btnLabel !== '')
                            <div class="rj-pb-actions">
                                <a href="{{ $btnUrl }}" class="rj-pb-btn" data-magnet>
                                    <span>{{ $btnLabel }}</span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($isSplit && $image !== '')
                        <div class="rj-pb-media" data-media>
                            <div class="rj-pb-tilt" data-tilt>
                                <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var wrap    = root.querySelector('.rj-pb-wrap');
    var animate = root.getAttribute('data-animate') === '1';
    var reduce  = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var fine    = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    var live    = animate && !reduce;
    var palette = @json($palette);

    root.classList.add('rj-pb-js');

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
                o.className = 'rj-pb-w';
                i.className = 'rj-pb-wi';
                i.style.setProperty('--d', (200 + ctr.n * 70) + 'ms');
                i.textContent = p;
                ctr.n++;
                o.appendChild(i);
                frag.appendChild(o);
            });
            node.parentNode.replaceChild(frag, node);
        } else if (node.nodeType === 1) {
            if (node.classList.contains('rj-pb-hl')) node.classList.add('is-split');
            [].slice.call(node.childNodes).forEach(function (c) { splitWords(c, ctr); });
        }
    }
    if (live) {
        [].slice.call(root.querySelectorAll('[data-title]')).forEach(function (el) {
            splitWords(el, { n: 0 });
        });
    }

    var cdEl = root.querySelector('[data-countdown]');
    if (cdEl) {
        var endTs = parseInt(cdEl.getAttribute('data-countdown'), 10);
        var cells = {
            d: cdEl.querySelector('[data-d]'),
            h: cdEl.querySelector('[data-h]'),
            m: cdEl.querySelector('[data-m]'),
            s: cdEl.querySelector('[data-s]')
        };

        var pad = function (n) { return n < 10 ? '0' + n : '' + n; };

        var setNum = function (el, val) {
            if (!el || el.getAttribute('data-v') === val) return;
            var first = !el.hasAttribute('data-v');
            el.setAttribute('data-v', val);
            if (!live) {
                el.textContent = val;
                return;
            }
            var nu = document.createElement('span');
            nu.textContent = val;
            if (first) {
                el.textContent = '';
                nu.className = 'rj-pb-n is-cur';
                el.appendChild(nu);
                return;
            }
            var old = el.querySelector('.rj-pb-n.is-cur');
            nu.className = 'rj-pb-n is-start';
            el.appendChild(nu);
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    nu.className = 'rj-pb-n is-cur';
                    if (old) old.className = 'rj-pb-n is-out';
                });
            });
            setTimeout(function () {
                if (old && old.parentNode) old.parentNode.removeChild(old);
            }, 600);
        };

        var tick = function () {
            var diff = Math.max(0, endTs - Date.now());
            var sec  = Math.floor(diff / 1000);
            setNum(cells.d, pad(Math.floor(sec / 86400)));
            setNum(cells.h, pad(Math.floor((sec % 86400) / 3600)));
            setNum(cells.m, pad(Math.floor((sec % 3600) / 60)));
            setNum(cells.s, pad(sec % 60));
            cdEl.classList.toggle('is-urgent', diff > 0 && diff < 3600000);
        };
        tick();
        setInterval(tick, 1000);
    }

    function burst(x, y) {
        if (reduce) return;
        var cv  = document.createElement('canvas');
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        var vw  = window.innerWidth;
        var vh  = window.innerHeight;
        cv.style.cssText = 'position:fixed;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:99999';
        cv.width  = Math.round(vw * dpr);
        cv.height = Math.round(vh * dpr);
        var c = cv.getContext('2d');
        if (!c) return;
        c.scale(dpr, dpr);
        document.body.appendChild(cv);

        var bits = [];
        for (var i = 0; i < 90; i++) {
            bits.push({
                x: x,
                y: y,
                vx: (Math.random() - .5) * 13,
                vy: -(Math.random() * 10 + 4),
                w: 5 + Math.random() * 6,
                h: 3 + Math.random() * 5,
                r: Math.random() * 6.28,
                vr: (Math.random() - .5) * .45,
                col: palette[Math.floor(Math.random() * palette.length)]
            });
        }
        var f = 0;
        (function frame() {
            c.clearRect(0, 0, vw, vh);
            for (var k = 0; k < bits.length; k++) {
                var b = bits[k];
                b.vy += .34;
                b.vx *= .992;
                b.x += b.vx;
                b.y += b.vy;
                b.r += b.vr;
                c.save();
                c.globalAlpha = Math.max(0, 1 - Math.max(0, f - 55) / 55);
                c.translate(b.x, b.y);
                c.rotate(b.r);
                c.fillStyle = b.col;
                c.fillRect(-b.w / 2, -b.h / 2, b.w, b.h);
                c.restore();
            }
            f++;
            if (f < 115) {
                requestAnimationFrame(frame);
            } else if (cv.parentNode) {
                cv.parentNode.removeChild(cv);
            }
        })();
    }

    var copied = root.querySelector('[data-copied]');
    [].slice.call(root.querySelectorAll('[data-coupon]')).forEach(function (btn) {
        btn.addEventListener('click', function () {
            var code = btn.getAttribute('data-coupon') || '';
            if (!code) return;

            var done = function () {
                var r = btn.getBoundingClientRect();
                burst(r.left + r.width / 2, r.top + r.height / 2);
                if (copied) {
                    copied.classList.add('is-on');
                    setTimeout(function () { copied.classList.remove('is-on'); }, 1800);
                }
                var txtEl = btn.querySelector('[data-coupon-text]');
                if (txtEl) {
                    var prev = txtEl.textContent;
                    txtEl.textContent = @js(__('Copied!'));
                    setTimeout(function () { txtEl.textContent = prev; }, 1600);
                }
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(code).then(done).catch(function () {});
            } else {
                var ta = document.createElement('textarea');
                ta.value = code;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        });
    });

    if (live && fine) {
        wrap.addEventListener('pointermove', function (e) {
            var r = wrap.getBoundingClientRect();
            root.style.setProperty('--sx', (e.clientX - r.left) + 'px');
            root.style.setProperty('--sy', (e.clientY - r.top) + 'px');
        });

        [].slice.call(root.querySelectorAll('[data-magnet]')).forEach(function (b) {
            b.addEventListener('pointermove', function (e) {
                var r = b.getBoundingClientRect();
                var x = (e.clientX - r.left - r.width / 2) * .22;
                var y = (e.clientY - r.top - r.height / 2) * .38;
                b.style.transform = 'translate(' + x + 'px,' + y + 'px)';
            });
            b.addEventListener('pointerleave', function () { b.style.transform = ''; });
        });

        var media = root.querySelector('[data-media]');
        var tilt  = root.querySelector('[data-tilt]');
        if (media && tilt) {
            media.addEventListener('pointermove', function (e) {
                var r  = media.getBoundingClientRect();
                var px = (e.clientX - r.left) / r.width;
                var py = (e.clientY - r.top) / r.height;
                tilt.style.transform = 'rotateY(' + ((px - .5) * 14) + 'deg) rotateX(' + ((.5 - py) * 14) + 'deg)';
                tilt.style.setProperty('--gx', (px * 100) + '%');
                tilt.style.setProperty('--gy', (py * 100) + '%');
            });
            media.addEventListener('pointerleave', function () { tilt.style.transform = ''; });
        }
    }

    var show = function () { root.classList.add('is-in'); };
    if (typeof IntersectionObserver === 'undefined') {
        show();
    } else {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                show();
                io.disconnect();
            }
        }, { threshold: 0.15 });
        io.observe(wrap);
    }
})();
</script>
