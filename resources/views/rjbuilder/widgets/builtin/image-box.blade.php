@php
    $image = $settings['image'] ?? '';
    if (is_array($image)) {
        $image = $image['url'] ?? ($image['image'] ?? ($image['src'] ?? (reset($image) ?: '')));
    }
    $image = is_string($image) ? trim($image) : '';

    $title = $settings['title'] ?? '';
    $description = $settings['description'] ?? '';
    $linkUrl = trim($settings['link_url'] ?? '');
    $linkTarget = ($settings['link_target'] ?? '_self') === '_blank' ? '_blank' : '_self';
    $style = in_array($settings['style'] ?? 'card', ['card', 'overlay', 'plain'], true) ? ($settings['style'] ?? 'card') : 'plain';
    $ratioSetting = $settings['image_ratio'] ?? 'aspect-[4/3]';
    $align = ($settings['align'] ?? 'left') === 'center' ? 'center' : 'left';
    $hover = $settings['hover_effect'] ?? true;
    $radius = $settings['border_radius'] ?? 'rounded-2xl';

    $accent = ltrim($settings['accent'] ?? '#6366f1', '#');
    if (!preg_match('/^[0-9a-fA-F]{6}$/', $accent)) {
        $accent = '6366f1';
    }

    $ratioCss = '4 / 3';
    if (preg_match('/aspect-\[(\d+(?:\.\d+)?)\s*\/\s*(\d+(?:\.\d+)?)\]/', $ratioSetting, $m)) {
        $ratioCss = $m[1] . ' / ' . $m[2];
    } elseif (strpos($ratioSetting, 'aspect-square') !== false) {
        $ratioCss = '1 / 1';
    } elseif (strpos($ratioSetting, 'aspect-video') !== false) {
        $ratioCss = '16 / 9';
    } elseif (preg_match('/^(\d+(?:\.\d+)?)\s*[\/:]\s*(\d+(?:\.\d+)?)$/', trim($ratioSetting), $m)) {
        $ratioCss = $m[1] . ' / ' . $m[2];
    }

    if ($linkUrl !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $linkUrl)) {
        $linkUrl = '';
    }
    $isLink = $linkUrl !== '';
    $tag = $isLink ? 'a' : 'div';
    $rel = $linkTarget === '_blank' ? 'noopener noreferrer' : '';

    $mediaClass = $style === 'plain' ? $radius : '';
    $rootClass = 'rj-ic rj-ic--' . $style . ' rj-ic--' . $align . ($hover ? ' rj-ic--hover' : '') . ($style === 'plain' ? '' : ' ' . $radius);
    $rootStyle = $style === 'overlay' ? 'aspect-ratio: ' . $ratioCss . ';' : '';
    $mediaStyle = $style === 'overlay' ? '' : 'aspect-ratio: ' . $ratioCss . ';';
@endphp

@once
<style>
    @keyframes rjIcFade {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --a: #{{ $accent }};
        position: relative;
        display: block;
        width: 100%;
        color: inherit;
        text-decoration: none;
        outline: none;
        animation: rjIcFade .8s cubic-bezier(.2,.8,.2,1) backwards;
    }

    #{{ $uid }}.rj-ic--card {
        background: #fff;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 18px 40px -26px rgba(15,23,42,.4);
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), box-shadow .5s ease, border-color .5s ease;
    }
    #{{ $uid }}.rj-ic--overlay {
        display: flex;
        align-items: flex-end;
        overflow: hidden;
        background: #0f172a;
        box-shadow: 0 24px 50px -28px rgba(15,23,42,.6);
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), box-shadow .5s ease;
    }

    #{{ $uid }} .rj-ic-media {
        position: relative;
        display: block;
        width: 100%;
        min-height: 120px;
        overflow: hidden;
        background: #e2e8f0;
    }
    #{{ $uid }}.rj-ic--overlay .rj-ic-media {
        position: absolute;
        inset: 0;
        height: 100%;
        min-height: 0;
    }

    #{{ $uid }} .rj-ic-media img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .9s cubic-bezier(.2,.8,.2,1), filter .5s ease;
    }

    #{{ $uid }} .rj-ic-empty {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
    }

    #{{ $uid }} .rj-ic-shine {
        position: absolute;
        inset: 0;
        background: linear-gradient(115deg, transparent 35%, rgba(255,255,255,.35) 50%, transparent 65%);
        transform: translateX(-120%);
        transition: transform .9s cubic-bezier(.2,.8,.2,1);
        pointer-events: none;
    }

    #{{ $uid }} .rj-ic-arrow {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 999px;
        color: #fff;
        background: var(--a);
        box-shadow: 0 10px 22px -8px var(--a);
        opacity: 0;
        transform: translate(10px, -10px) scale(.7);
        transition: opacity .4s ease, transform .6s cubic-bezier(.34,1.56,.64,1);
    }

    #{{ $uid }} .rj-ic-body {
        position: relative;
        display: block;
    }
    #{{ $uid }}.rj-ic--card .rj-ic-body {
        padding: 24px;
    }
    #{{ $uid }}.rj-ic--plain .rj-ic-body {
        padding-top: 18px;
    }
    #{{ $uid }}.rj-ic--overlay .rj-ic-body {
        z-index: 2;
        width: 100%;
        padding: 56px 24px 26px;
        color: #fff;
        background: linear-gradient(to top, rgba(2,6,23,.88), rgba(2,6,23,.45) 55%, rgba(2,6,23,0));
        transform: translateY(6px);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }

    #{{ $uid }} .rj-ic-title {
        display: block;
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -.01em;
        line-height: 1.25;
        color: #0f172a;
        transition: color .4s ease;
    }
    #{{ $uid }}.rj-ic--overlay .rj-ic-title {
        color: #fff;
    }

    #{{ $uid }} .rj-ic-line {
        display: block;
        width: 28px;
        height: 3px;
        margin: 12px 0 0;
        border-radius: 3px;
        background: var(--a);
        transition: width .6s cubic-bezier(.34,1.4,.64,1);
    }
    #{{ $uid }}.rj-ic--center .rj-ic-line {
        margin-left: auto;
        margin-right: auto;
    }

    #{{ $uid }} .rj-ic-desc {
        display: block;
        margin: 12px 0 0;
        font-size: 14px;
        line-height: 1.65;
        color: #64748b;
    }
    #{{ $uid }}.rj-ic--overlay .rj-ic-desc {
        color: rgba(255,255,255,.82);
    }

    #{{ $uid }}.rj-ic--hover:hover,
    #{{ $uid }}.rj-ic--hover:focus-visible {
        transform: translateY(-6px);
    }
    #{{ $uid }}.rj-ic--hover.rj-ic--card:hover,
    #{{ $uid }}.rj-ic--hover.rj-ic--card:focus-visible {
        border-color: var(--a);
        box-shadow: 0 30px 50px -24px var(--a);
    }
    #{{ $uid }}.rj-ic--hover.rj-ic--overlay:hover,
    #{{ $uid }}.rj-ic--hover.rj-ic--overlay:focus-visible {
        box-shadow: 0 34px 56px -26px var(--a);
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-media img,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-media img {
        transform: scale(1.1);
        filter: brightness(1.05) saturate(1.08);
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-shine,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-shine {
        transform: translateX(120%);
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-arrow,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-arrow {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-line,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-line {
        width: 60px;
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-title,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-title {
        color: var(--a);
    }
    #{{ $uid }}.rj-ic--hover.rj-ic--overlay:hover .rj-ic-title,
    #{{ $uid }}.rj-ic--hover.rj-ic--overlay:focus-visible .rj-ic-title {
        color: #fff;
    }
    #{{ $uid }}.rj-ic--hover:hover .rj-ic-body,
    #{{ $uid }}.rj-ic--hover:focus-visible .rj-ic-body {
        transform: none;
    }
    #{{ $uid }}:focus-visible {
        box-shadow: 0 0 0 3px #fff, 0 0 0 6px var(--a);
    }

    @media (hover: none) {
        #{{ $uid }} .rj-ic-arrow {
            opacity: 1;
            transform: none;
        }
    }

    @media (max-width: 640px) {
        #{{ $uid }}.rj-ic--card .rj-ic-body { padding: 18px; }
        #{{ $uid }}.rj-ic--overlay .rj-ic-body { padding: 44px 18px 20px; }
        #{{ $uid }} .rj-ic-title { font-size: 19px; }
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

<{{ $tag }} id="{{ $uid }}" class="{{ trim($rootClass) }}" @if($rootStyle) style="{{ $rootStyle }}" @endif
    @if($isLink)
        href="{{ $linkUrl }}"
        target="{{ $linkTarget }}"
        @if($rel) rel="{{ $rel }}" @endif
    @endif
>
    <span class="rj-ic-media {{ trim($mediaClass) }}" @if($mediaStyle) style="{{ $mediaStyle }}" @endif>
        @if($image !== '')
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
        @else
            <span class="rj-ic-empty" aria-hidden="true">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
        @endif
        <span class="rj-ic-shine"></span>
        @if($isLink)
            <span class="rj-ic-arrow" aria-hidden="true">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M9 7h8v8"/></svg>
            </span>
        @endif
    </span>

    @if($title || $description)
        <span class="rj-ic-body">
            @if($title)
                <span class="rj-ic-title" role="heading" aria-level="3">{{ $title }}</span>
                <span class="rj-ic-line"></span>
            @endif
            @if($description)
                <span class="rj-ic-desc">{{ $description }}</span>
            @endif
        </span>
    @endif
</{{ $tag }}>
