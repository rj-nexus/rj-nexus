@php
    $icon = $settings['icon'] ?? '';
    $title = $settings['title'] ?? '';
    $description = $settings['description'] ?? '';
    $linkUrl = trim($settings['link_url'] ?? '');
    $layout = in_array($settings['layout'] ?? 'top', ['top', 'left', 'right'], true) ? $settings['layout'] : 'top';
    $align = in_array($settings['align'] ?? 'center', ['left', 'center', 'right'], true) ? $settings['align'] : 'center';
    $iconStyle = in_array($settings['icon_style'] ?? 'circle', ['circle', 'square', 'none'], true) ? $settings['icon_style'] : 'circle';
    $hoverAnimation = in_array($settings['hover_animation'] ?? 'rotate', ['none', 'rotate', 'bounce', 'float', 'pulse'], true) ? $settings['hover_animation'] : 'rotate';
    $boxStyle = ($settings['box_style'] ?? 'card') === 'card' ? 'card' : 'minimal';

    $hexOk = function ($v) {
        return is_string($v) && preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', trim($v));
    };

    $iconColorRaw = $hexOk($settings['icon_color'] ?? '') ? trim($settings['icon_color']) : '#8b5cf6';
    $hex = ltrim($iconColorRaw, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    } elseif (strlen($hex) === 8) {
        $hex = substr($hex, 0, 6);
    }
    $color = '#' . $hex;
    $rgb = hexdec(substr($hex, 0, 2)) . ',' . hexdec(substr($hex, 2, 2)) . ',' . hexdec(substr($hex, 4, 2));
    $iconBg = $hexOk($settings['icon_bg'] ?? '') ? trim($settings['icon_bg']) : 'rgba(' . $rgb . ',.1)';

    $radiusMap = [
        'rounded-none' => '0px',
        'rounded-xl'   => '12px',
        'rounded-2xl'  => '20px',
        'rounded-3xl'  => '30px',
    ];
    $radius = $radiusMap[$settings['border_radius'] ?? 'rounded-2xl'] ?? '20px';
    $iconRadius = $iconStyle === 'circle' ? '999px' : ($iconStyle === 'square' ? '18px' : '0px');

    if ($linkUrl !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $linkUrl)) {
        $linkUrl = '';
    }
    $isLink = $linkUrl !== '';
    $tag = $isLink ? 'a' : 'div';

    $rootClass = 'rj-ib rj-ib--' . $boxStyle . ' rj-ib--' . $layout . ' rj-ib--' . $align . ' rj-ib--ico-' . $iconStyle . ' rj-ib--anim-' . $hoverAnimation;
@endphp

@once
<style>
    @keyframes rjIbFade {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjIbBounce {
        0%, 100% { transform: translateY(0) scale(1.08); }
        50%      { transform: translateY(-9px) scale(1.08); }
    }
    @keyframes rjIbFloat {
        0%, 100% { transform: translateY(0) scale(1.06); }
        50%      { transform: translateY(-5px) scale(1.06); }
    }
    @keyframes rjIbPulse {
        0%   { box-shadow: 0 0 0 0 rgba(var(--rgb), .5); }
        70%  { box-shadow: 0 0 0 16px rgba(var(--rgb), 0); }
        100% { box-shadow: 0 0 0 0 rgba(var(--rgb), 0); }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --c: {{ $color }};
        --rgb: {{ $rgb }};
        --bg: {{ $iconBg }};
        --r: {{ $radius }};
        --ir: {{ $iconRadius }};
        position: relative;
        display: block;
        width: 100%;
        color: inherit;
        text-decoration: none;
        outline: none;
        animation: rjIbFade .8s cubic-bezier(.2,.8,.2,1) backwards;
    }

    #{{ $uid }}.rj-ib--card {
        padding: 32px;
        overflow: hidden;
        border-radius: var(--r);
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 40px -28px rgba(15,23,42,.4);
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), box-shadow .5s ease, border-color .5s ease;
    }
    #{{ $uid }}.rj-ib--minimal {
        padding: 8px;
    }

    #{{ $uid }}.rj-ib--card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--c), rgba(var(--rgb), .15));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .7s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}.rj-ib--card::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 180px;
        height: 180px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(var(--rgb), .22), rgba(var(--rgb), 0) 70%);
        opacity: 0;
        transform: scale(.6);
        transition: opacity .6s ease, transform .8s cubic-bezier(.2,.8,.2,1);
        pointer-events: none;
    }

    #{{ $uid }} .rj-ib-inner {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 22px;
        width: 100%;
    }
    #{{ $uid }}.rj-ib--top .rj-ib-inner { flex-direction: column; }
    #{{ $uid }}.rj-ib--left .rj-ib-inner { flex-direction: row; align-items: flex-start; }
    #{{ $uid }}.rj-ib--right .rj-ib-inner { flex-direction: row-reverse; align-items: flex-start; }

    #{{ $uid }}.rj-ib--top.rj-ib--left .rj-ib-inner { align-items: flex-start; }
    #{{ $uid }}.rj-ib--top.rj-ib--center .rj-ib-inner { align-items: center; }
    #{{ $uid }}.rj-ib--top.rj-ib--right .rj-ib-inner { align-items: flex-end; }

    #{{ $uid }}.rj-ib--top.rj-ib--left .rj-ib-text { text-align: left; }
    #{{ $uid }}.rj-ib--top.rj-ib--center .rj-ib-text { text-align: center; }
    #{{ $uid }}.rj-ib--top.rj-ib--right .rj-ib-text { text-align: right; }
    #{{ $uid }}.rj-ib--left .rj-ib-text { text-align: left; }
    #{{ $uid }}.rj-ib--right .rj-ib-text { text-align: right; }

    #{{ $uid }} .rj-ib-icon {
        position: relative;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        color: var(--c);
        background: var(--bg);
        border-radius: var(--ir);
        transition: transform .6s cubic-bezier(.34,1.56,.64,1), background-color .4s ease, color .4s ease, box-shadow .4s ease;
    }
    #{{ $uid }}.rj-ib--ico-none .rj-ib-icon {
        background: transparent;
        width: auto;
        height: auto;
    }
    #{{ $uid }} .rj-ib-icon::before {
        content: "";
        position: absolute;
        inset: -6px;
        border-radius: inherit;
        border: 1.5px dashed rgba(var(--rgb), .35);
        opacity: 0;
        transform: scale(.85) rotate(-20deg);
        transition: opacity .5s ease, transform .8s cubic-bezier(.34,1.56,.64,1);
        pointer-events: none;
    }
    #{{ $uid }}.rj-ib--ico-none .rj-ib-icon::before { display: none; }
    #{{ $uid }} .rj-ib-icon svg {
        width: 32px;
        height: 32px;
        display: block;
        transition: transform .5s cubic-bezier(.34,1.56,.64,1);
    }

    #{{ $uid }} .rj-ib-text {
        flex: 1 1 auto;
        min-width: 0;
        width: 100%;
    }
    #{{ $uid }} .rj-ib-title {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -.01em;
        line-height: 1.25;
        color: #0f172a;
        transition: color .4s ease;
    }
    #{{ $uid }} .rj-ib-line {
        display: block;
        width: 28px;
        height: 3px;
        margin: 12px 0 0;
        border-radius: 3px;
        background: var(--c);
        transition: width .6s cubic-bezier(.34,1.4,.64,1);
    }
    #{{ $uid }}.rj-ib--top.rj-ib--center .rj-ib-line { margin-left: auto; margin-right: auto; }
    #{{ $uid }}.rj-ib--top.rj-ib--right .rj-ib-line,
    #{{ $uid }}.rj-ib--right .rj-ib-line { margin-left: auto; margin-right: 0; }
    #{{ $uid }}.rj-ib--left .rj-ib-line { margin-left: 0; margin-right: auto; }

    #{{ $uid }} .rj-ib-desc {
        margin: 12px 0 0;
        font-size: 14.5px;
        line-height: 1.7;
        color: #64748b;
    }

    #{{ $uid }} .rj-ib-arrow {
        position: absolute;
        right: 18px;
        bottom: 18px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        color: #fff;
        background: var(--c);
        box-shadow: 0 10px 22px -8px var(--c);
        opacity: 0;
        transform: translate(-10px, 10px) scale(.7);
        transition: opacity .4s ease, transform .6s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }}.rj-ib--minimal .rj-ib-arrow { right: 0; bottom: 0; }

    #{{ $uid }}:hover,
    #{{ $uid }}:focus-visible {
        transform: translateY(-6px);
    }
    #{{ $uid }}.rj-ib--card:hover,
    #{{ $uid }}.rj-ib--card:focus-visible {
        border-color: rgba(var(--rgb), .6);
        box-shadow: 0 32px 54px -26px rgba(var(--rgb), .6);
    }
    #{{ $uid }}.rj-ib--card:hover::before,
    #{{ $uid }}.rj-ib--card:focus-visible::before { transform: scaleX(1); }
    #{{ $uid }}.rj-ib--card:hover::after,
    #{{ $uid }}.rj-ib--card:focus-visible::after { opacity: 1; transform: scale(1); }

    #{{ $uid }}:hover .rj-ib-icon::before,
    #{{ $uid }}:focus-visible .rj-ib-icon::before {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
    #{{ $uid }}:not(.rj-ib--anim-none):hover .rj-ib-icon,
    #{{ $uid }}:not(.rj-ib--anim-none):focus-visible .rj-ib-icon {
        background: var(--c);
        color: #fff;
        box-shadow: 0 16px 28px -12px var(--c);
    }
    #{{ $uid }}.rj-ib--ico-none:not(.rj-ib--anim-none):hover .rj-ib-icon,
    #{{ $uid }}.rj-ib--ico-none:not(.rj-ib--anim-none):focus-visible .rj-ib-icon {
        background: transparent;
        color: var(--c);
        box-shadow: none;
    }
    #{{ $uid }}.rj-ib--anim-rotate:hover .rj-ib-icon,
    #{{ $uid }}.rj-ib--anim-rotate:focus-visible .rj-ib-icon {
        transform: rotate(-10deg) scale(1.12);
    }
    #{{ $uid }}.rj-ib--anim-bounce:hover .rj-ib-icon,
    #{{ $uid }}.rj-ib--anim-bounce:focus-visible .rj-ib-icon {
        animation: rjIbBounce .8s ease-in-out infinite;
    }
    #{{ $uid }}.rj-ib--anim-float:hover .rj-ib-icon,
    #{{ $uid }}.rj-ib--anim-float:focus-visible .rj-ib-icon {
        animation: rjIbFloat 1.6s ease-in-out infinite;
    }
    #{{ $uid }}.rj-ib--anim-pulse:hover .rj-ib-icon,
    #{{ $uid }}.rj-ib--anim-pulse:focus-visible .rj-ib-icon {
        animation: rjIbPulse 1.5s cubic-bezier(.4,0,.6,1) infinite;
    }
    #{{ $uid }}:hover .rj-ib-icon svg,
    #{{ $uid }}:focus-visible .rj-ib-icon svg {
        transform: scale(1.1);
    }
    #{{ $uid }}:hover .rj-ib-title,
    #{{ $uid }}:focus-visible .rj-ib-title {
        color: var(--c);
    }
    #{{ $uid }}:hover .rj-ib-line,
    #{{ $uid }}:focus-visible .rj-ib-line {
        width: 64px;
    }
    #{{ $uid }}:hover .rj-ib-arrow,
    #{{ $uid }}:focus-visible .rj-ib-arrow {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }}:focus-visible {
        box-shadow: 0 0 0 3px #fff, 0 0 0 6px var(--c);
    }

    @media (hover: none) {
        #{{ $uid }} .rj-ib-arrow {
            opacity: 1;
            transform: none;
        }
    }

    @media (max-width: 640px) {
        #{{ $uid }}.rj-ib--card { padding: 24px; }
        #{{ $uid }}.rj-ib--left .rj-ib-inner,
        #{{ $uid }}.rj-ib--right .rj-ib-inner {
            flex-direction: column;
            align-items: center;
        }
        #{{ $uid }}.rj-ib--left .rj-ib-text,
        #{{ $uid }}.rj-ib--right .rj-ib-text { text-align: center; }
        #{{ $uid }}.rj-ib--left .rj-ib-line,
        #{{ $uid }}.rj-ib--right .rj-ib-line { margin-left: auto; margin-right: auto; }
        #{{ $uid }} .rj-ib-title { font-size: 19px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }},
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<{{ $tag }} id="{{ $uid }}" class="{{ $rootClass }}"
    @if($isLink)
        href="{{ $linkUrl }}"
    @endif
>
    <span class="rj-ib-inner">
        @if($icon)
            <span class="rj-ib-icon" aria-hidden="true">
                {!! rj_icon($icon, 'w-8 h-8') !!}
            </span>
        @endif

        @if($title || $description)
            <span class="rj-ib-text" style="display:block;">
                @if($title)
                    <span class="rj-ib-title" role="heading" aria-level="3" style="display:block;">{{ $title }}</span>
                    <span class="rj-ib-line"></span>
                @endif
                @if($description)
                    <span class="rj-ib-desc" style="display:block;">{{ $description }}</span>
                @endif
            </span>
        @endif
    </span>

    @if($isLink)
        <span class="rj-ib-arrow" aria-hidden="true">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M9 7h8v8"/></svg>
        </span>
    @endif
</{{ $tag }}>
