@php
    $subtitle   = $settings['subtitle'] ?? '';
    $title      = $settings['title'] ?? '';
    $desc       = $settings['desc'] ?? '';
    $layoutRaw  = $settings['layout'] ?? 'cards';
    $layout     = in_array($layoutRaw, ['cards', 'rows', 'icon-left'], true) ? $layoutRaw : 'cards';
    $columns    = (int) ($settings['columns'] ?? 3);
    $columns    = max(1, min(4, $columns));
    $align      = ($settings['align'] ?? 'center') === 'left' ? 'left' : 'center';
    $cardStyleR = $settings['card_style'] ?? 'card';
    $cardStyle  = in_array($cardStyleR, ['card', 'bordered', 'minimal', 'gradient', 'glass'], true) ? $cardStyleR : 'card';
    $iconStyleR = $settings['icon_style'] ?? 'rounded';
    $iconStyle  = in_array($iconStyleR, ['circle', 'rounded', 'square', 'soft'], true) ? $iconStyleR : 'rounded';
    $showFooter = !empty($settings['show_footer_cta']);
    $footerLabel = $settings['footer_label'] ?? __('Contact Us');
    $footerUrl  = trim((string) ($settings['footer_url'] ?? '/contact'));
    $paddingY   = max(0, min(200, (int) ($settings['padding_y'] ?? 60)));

    $norm = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $v)) {
            $v = $d;
        }
        $h = ltrim($v, '#');
        if (strlen($h) === 3) {
            $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
        } elseif (strlen($h) === 8) {
            $h = substr($h, 0, 6);
        }
        return '#' . strtolower($h);
    };
    $toRgb = function ($hex) {
        $h = ltrim($hex, '#');
        return hexdec(substr($h, 0, 2)) . ',' . hexdec(substr($h, 2, 2)) . ',' . hexdec(substr($h, 4, 2));
    };

    $accent  = $norm($settings['accent'] ?? '', '#8b5cf6');
    $accent2 = $norm($settings['accent2'] ?? '', '#ec4899');
    $textCol = $norm($settings['text_color'] ?? '', '#0f172a');
    $muteCol = $norm($settings['muted_color'] ?? '', '#64748b');
    $accentRgb = $toRgb($accent);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '22px', 'xl' => '32px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'lg'] ?? '22px';
    $iconShape = ['circle' => '999px', 'rounded' => '38px', 'square' => '0px', 'soft' => '56px 22px 56px 22px'];
    $iconRadius = $iconShape[$iconStyle];

    $safeUrl = function ($u) {
        $u = trim((string) $u);
        if ($u !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $u)) {
            return '';
        }
        return $u;
    };
    $footerUrl = $safeUrl($footerUrl);

    $typeIcons = [
        'address'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>',
        'phone'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>',
        'email'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M3.5 7.5l8.5 6 8.5-6"/></svg>',
        'hours'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>',
        'whatsapp' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21l1.6-4.6A8.5 8.5 0 1 1 8 19.5L3 21z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.3-2-1-.8.6a3.5 3.5 0 0 1-1.6-1.6l.6-.8-1-2z"/></svg>',
        'telegram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 4L3 11l6 2 2 6 3-4 5 4 2-15z"/><path d="M9 13l7-5"/></svg>',
        'website'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/></svg>',
        'custom'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2.4 5.6L20 9.5l-4.2 3.9 1.2 6L12 16.6 7 19.4l1.2-6L4 9.5l5.6-.9L12 3z"/></svg>',
    ];

    $cards = [];
    if (!empty($settings['cards']) && is_array($settings['cards'])) {
        foreach ($settings['cards'] as $row) {
            if (!is_array($row)) {
                continue;
            }
            if (empty($row['title']) && empty($row['value'])) {
                continue;
            }
            $type = $row['type'] ?? 'custom';
            if (!isset($typeIcons[$type])) {
                $type = 'custom';
            }
            $cards[] = [
                'type'  => $type,
                'title' => (string) ($row['title'] ?? ''),
                'value' => (string) ($row['value'] ?? ''),
                'desc'  => (string) ($row['desc'] ?? ''),
                'link'  => trim((string) ($row['link'] ?? '')),
                'icon'  => trim((string) ($row['icon'] ?? '')),
            ];
        }
    }

    $autoLink = function (string $type, string $value, string $link) use ($safeUrl): string {
        if ($link !== '') {
            return $safeUrl($link);
        }
        $v = trim($value);
        if ($v === '') {
            return '';
        }
        switch ($type) {
            case 'phone':
                return 'tel:' . preg_replace('/[^\d+]/', '', $v);
            case 'email':
                return 'mailto:' . $v;
            case 'whatsapp':
                return 'https://wa.me/' . preg_replace('/\D+/', '', $v);
            case 'telegram':
                return 'https://t.me/' . ltrim($v, '@');
            case 'website':
                return $safeUrl(preg_match('#^https?://#i', $v) ? $v : 'https://' . $v);
        }
        return '';
    };

    $iconHtml = function (array $card) use ($typeIcons): string {
        if ($card['icon'] !== '' && function_exists('rj_icon')) {
            return rj_icon($card['icon'], 'w-10 h-10');
        }
        return $typeIcons[$card['type']] ?? $typeIcons['custom'];
    };

    $rootClass = 'rj-cx rj-cx--' . $layout . ' rj-cx--s-' . $cardStyle . ' rj-cx--a-' . $align;
    $tabletCols = $columns > 2 ? 2 : $columns;
    $rowCols = min(2, $columns);
@endphp

@once
<style>
    @keyframes rjCxIn {
        from { opacity: 0; transform: translateY(34px) scale(.96); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjCxFade {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjCxFloat {
        0%   { translate: 0 0; }
        100% { translate: 0 -10px; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --a2: {{ $accent2 }};
        --ar: {{ $accentRgb }};
        --tx: {{ $textCol }};
        --mu: {{ $muteCol }};
        --r: {{ $radiusCss }};
        --ir: {{ $iconRadius }};
        --cols: {{ $columns }};
        box-sizing: border-box;
        display: block;
        position: relative;
        width: 100%;
        flex: 0 0 auto;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *,
    #{{ $uid }} *::before,
    #{{ $uid }} *::after {
        box-sizing: border-box;
    }
    #{{ $uid }} .rj-cx-inner {
        display: block;
        max-width: 1200px;
        margin: 0 auto;
    }

    #{{ $uid }} .rj-cx-head {
        display: block;
        max-width: 660px;
        margin-bottom: 48px;
    }
    #{{ $uid }}.rj-cx--a-center .rj-cx-head {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
    #{{ $uid }}.rj-cx--a-left .rj-cx-head {
        text-align: left;
    }
    #{{ $uid }} .rj-cx-sub {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 14px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--a);
    }
    #{{ $uid }} .rj-cx-sub::before {
        content: "";
        display: block;
        width: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--a);
        transition: width .9s cubic-bezier(.2,.8,.2,1) .2s;
    }
    #{{ $uid }}.is-in .rj-cx-sub::before {
        width: 32px;
    }
    #{{ $uid }} .rj-cx-title {
        margin: 0;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.025em;
        color: var(--tx);
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cx-title { font-size: 46px; }
    }
    #{{ $uid }} .rj-cx-lead {
        margin: 16px 0 0;
        font-size: 15px;
        line-height: 1.75;
        color: var(--mu);
    }
    #{{ $uid }}:not(.is-in) .rj-cx-head { opacity: 0; }
    #{{ $uid }}.is-in .rj-cx-head { animation: rjCxFade .8s cubic-bezier(.2,.8,.2,1) backwards; }

    #{{ $uid }} .rj-cx-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
    }
    #{{ $uid }}.rj-cx--rows .rj-cx-grid,
    #{{ $uid }}.rj-cx--icon-left .rj-cx-grid {
        grid-template-columns: repeat({{ $rowCols }}, minmax(0, 1fr));
    }

    #{{ $uid }} .rj-cx-tile {
        --bg: #fff;
        --bd: #e8edf4;
        --sh: 0 20px 40px -28px rgba(15,23,42,.38);
        --fg: var(--tx);
        --mut: var(--mu);
        --wipe: linear-gradient(135deg, var(--a), var(--a2));
        --orb: rgba(var(--ar), .1);
        --orb-c: var(--a);
        --ox: 100%;
        --oy: 100%;
        position: relative;
        isolation: isolate;
        display: block;
        min-height: 200px;
        padding: 30px 28px;
        overflow: hidden;
        border-radius: var(--r);
        background: var(--bg);
        border: 1px solid var(--bd);
        box-shadow: var(--sh);
        color: var(--fg);
        text-decoration: none;
        outline: none;
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), box-shadow .5s ease, border-color .5s ease;
    }
    #{{ $uid }}:not(.is-in) .rj-cx-tile { opacity: 0; }
    #{{ $uid }}.is-in .rj-cx-tile {
        animation: rjCxIn .85s cubic-bezier(.2,.8,.2,1) calc(var(--i) * 100ms) backwards;
    }
    #{{ $uid }}.rj-cx--a-center .rj-cx-tile { text-align: center; }
    #{{ $uid }}.rj-cx--a-left .rj-cx-tile { text-align: left; }

    #{{ $uid }}.rj-cx--rows .rj-cx-tile {
        --oy: 50%;
        min-height: 150px;
        display: flex;
        align-items: center;
        padding: 28px 150px 28px 32px;
    }
    #{{ $uid }}.rj-cx--icon-left .rj-cx-tile {
        --ox: 0%;
        --oy: 50%;
        min-height: 150px;
        display: flex;
        align-items: center;
        padding: 28px 28px 28px 112px;
        text-align: left;
    }
    #{{ $uid }}.rj-cx--rows .rj-cx-tile { text-align: left; }

    #{{ $uid }}.rj-cx--s-bordered .rj-cx-tile {
        --bg: #fff;
        --bd: rgba(var(--ar), .4);
        --sh: none;
    }
    #{{ $uid }}.rj-cx--s-minimal .rj-cx-tile {
        --bg: transparent;
        --bd: #e2e8f0;
        --sh: none;
        border-width: 0 0 1px 0;
        border-radius: 0;
    }
    #{{ $uid }}.rj-cx--s-gradient .rj-cx-tile {
        --bg: linear-gradient(135deg, var(--a), var(--a2));
        --bd: transparent;
        --sh: 0 26px 46px -26px rgba(var(--ar), .7);
        --fg: #fff;
        --mut: rgba(255,255,255,.82);
        --wipe: linear-gradient(135deg, #0f172a, #1e293b);
        --orb: rgba(255,255,255,.16);
        --orb-c: #fff;
    }
    #{{ $uid }}.rj-cx--s-glass .rj-cx-tile {
        --bg: rgba(255,255,255,.55);
        --bd: rgba(255,255,255,.85);
        --sh: 0 20px 40px -28px rgba(15,23,42,.3);
        -webkit-backdrop-filter: blur(16px);
        backdrop-filter: blur(16px);
    }

    #{{ $uid }} .rj-cx-wipe {
        position: absolute;
        inset: 0;
        z-index: -1;
        background: var(--wipe);
        clip-path: circle(0 at var(--ox) var(--oy));
        transition: clip-path .85s cubic-bezier(.7,0,.2,1);
        pointer-events: none;
    }

    #{{ $uid }} .rj-cx-orb {
        position: absolute;
        z-index: 0;
        display: block;
        width: 150px;
        height: 150px;
        right: -42px;
        bottom: -42px;
        border-radius: var(--ir);
        background: var(--orb);
        color: var(--orb-c);
        transition: transform .8s cubic-bezier(.34,1.56,.64,1), background-color .5s ease, color .5s ease;
        animation: rjCxFloat 5s ease-in-out infinite alternate;
        animation-delay: calc(var(--i) * -1.3s);
        pointer-events: none;
    }
    #{{ $uid }}.rj-cx--rows .rj-cx-orb {
        top: 50%;
        bottom: auto;
        margin-top: -75px;
    }
    #{{ $uid }}.rj-cx--icon-left .rj-cx-orb {
        right: auto;
        left: -42px;
        top: 50%;
        bottom: auto;
        margin-top: -75px;
    }
    #{{ $uid }} .rj-cx-ico {
        position: absolute;
        display: block;
        width: 42px;
        height: 42px;
        top: 30px;
        left: 30px;
    }
    #{{ $uid }}.rj-cx--rows .rj-cx-ico {
        top: 54px;
    }
    #{{ $uid }}.rj-cx--icon-left .rj-cx-ico {
        top: 54px;
        left: auto;
        right: 30px;
    }
    #{{ $uid }} .rj-cx-ico svg {
        display: block;
        width: 100%;
        height: 100%;
    }

    #{{ $uid }} .rj-cx-body {
        position: relative;
        z-index: 2;
        display: block;
        min-width: 0;
        width: 100%;
    }
    #{{ $uid }} .rj-cx-no {
        display: block;
        margin: 0;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--mut);
        transition: color .5s ease;
    }
    #{{ $uid }} .rj-cx-no b {
        display: inline-block;
        margin-right: 10px;
        font-weight: 800;
        color: var(--a);
        transition: color .5s ease;
    }
    #{{ $uid }}.rj-cx--s-gradient .rj-cx-no b { color: #fff; }
    #{{ $uid }} .rj-cx-val {
        display: block;
        margin: 16px 0 0;
        font-size: 21px;
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: -.01em;
        word-break: break-word;
        color: var(--fg);
        transition: color .5s ease;
    }
    #{{ $uid }} .rj-cx-bar {
        display: block;
        width: 26px;
        height: 3px;
        margin: 14px 0 0;
        border-radius: 3px;
        background: var(--a);
        transition: width .7s cubic-bezier(.34,1.4,.64,1), background-color .5s ease;
    }
    #{{ $uid }}.rj-cx--s-gradient .rj-cx-bar { background: #fff; }
    #{{ $uid }}.rj-cx--a-center:not(.rj-cx--rows):not(.rj-cx--icon-left) .rj-cx-bar {
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-cx-desc {
        display: block;
        margin: 14px 0 0;
        font-size: 13.5px;
        line-height: 1.65;
        color: var(--mut);
        transition: color .5s ease;
    }

    #{{ $uid }} .rj-cx-go {
        position: absolute;
        z-index: 3;
        top: 18px;
        right: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        color: var(--a);
        background: #fff;
        box-shadow: 0 10px 22px -10px rgba(15,23,42,.5);
        opacity: 0;
        transform: translate(-14px, 14px) scale(.6);
        transition: opacity .4s ease, transform .6s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }}.rj-cx--rows .rj-cx-go {
        top: 18px;
    }
    #{{ $uid }} .rj-cx-go svg {
        display: block;
        width: 16px;
        height: 16px;
    }

    #{{ $uid }} .rj-cx-tile:hover,
    #{{ $uid }} .rj-cx-tile:focus-visible {
        transform: translateY(-8px);
        border-color: rgba(var(--ar), .55);
        box-shadow: 0 34px 56px -26px rgba(var(--ar), .65);
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-wipe,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-wipe {
        clip-path: circle(160% at var(--ox) var(--oy));
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-orb,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-orb {
        transform: rotate(-10deg) scale(1.16);
        background: rgba(255,255,255,.18);
        color: #fff;
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-no,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-no,
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-desc,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-desc {
        color: rgba(255,255,255,.82);
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-no b,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-no b,
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-val,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-val {
        color: #fff;
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-bar,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-bar {
        width: 64px;
        background: #fff;
    }
    #{{ $uid }} .rj-cx-tile:hover .rj-cx-go,
    #{{ $uid }} .rj-cx-tile:focus-visible .rj-cx-go {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }} .rj-cx-tile:focus-visible {
        outline: 3px solid var(--a);
        outline-offset: 3px;
    }

    #{{ $uid }} .rj-cx-foot {
        display: block;
        margin-top: 40px;
    }
    #{{ $uid }}.rj-cx--a-center .rj-cx-foot { text-align: center; }
    #{{ $uid }}.rj-cx--a-left .rj-cx-foot { text-align: left; }
    #{{ $uid }} .rj-cx-cta {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        padding: 8px 8px 8px 28px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
        background: linear-gradient(135deg, var(--a), var(--a2));
        box-shadow: 0 18px 32px -16px rgba(var(--ar), .8);
        transition: transform .5s cubic-bezier(.34,1.4,.64,1), box-shadow .4s ease;
    }
    #{{ $uid }} .rj-cx-cta i {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        background: #fff;
        color: var(--a);
        transition: transform .5s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .rj-cx-cta svg {
        display: block;
        width: 16px;
        height: 16px;
    }
    #{{ $uid }} .rj-cx-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 26px 40px -16px rgba(var(--ar), .85);
    }
    #{{ $uid }} .rj-cx-cta:hover i {
        transform: translateX(4px) rotate(-45deg);
    }

    #{{ $uid }} .rj-cx-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        font-size: 14px;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
    }

    @media (max-width: 960px) {
        #{{ $uid }} .rj-cx-grid {
            grid-template-columns: repeat({{ $tabletCols }}, minmax(0, 1fr));
        }
        #{{ $uid }}.rj-cx--rows .rj-cx-grid,
        #{{ $uid }}.rj-cx--icon-left .rj-cx-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        #{{ $uid }} .rj-cx-grid,
        #{{ $uid }}.rj-cx--rows .rj-cx-grid,
        #{{ $uid }}.rj-cx--icon-left .rj-cx-grid {
            grid-template-columns: 1fr;
        }
        #{{ $uid }} .rj-cx-tile { padding: 26px 22px; min-height: 170px; }
        #{{ $uid }}.rj-cx--rows .rj-cx-tile { padding: 24px 112px 24px 22px; }
        #{{ $uid }}.rj-cx--icon-left .rj-cx-tile { padding: 24px 22px 24px 100px; }
        #{{ $uid }} .rj-cx-val { font-size: 19px; }
        #{{ $uid }} .rj-cx-go {
            opacity: 1;
            transform: none;
        }
    }
    @media (hover: none) {
        #{{ $uid }} .rj-cx-go {
            opacity: 1;
            transform: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }},
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-cx-tile,
        #{{ $uid }} .rj-cx-head {
            opacity: 1 !important;
        }
    }
</style>

<div id="{{ $uid }}" class="{{ $rootClass }}">
    <div class="rj-cx-inner">
        @if($title || $subtitle || $desc)
            <header class="rj-cx-head">
                @if($subtitle)
                    <p class="rj-cx-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-cx-title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="rj-cx-lead">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($cards))
            <div class="rj-cx-grid">
                @foreach($cards as $i => $card)
                    @php
                        $href = $autoLink($card['type'], $card['value'], $card['link']);
                        $tag = $href !== '' ? 'a' : 'div';
                        $external = $href !== '' && preg_match('#^https?://#i', $href);
                    @endphp
                    <{{ $tag }} class="rj-cx-tile" style="--i: {{ $i }};"
                        @if($href !== '')
                            href="{{ $href }}"
                            @if($external) target="_blank" rel="noopener noreferrer" @endif
                        @endif
                    >
                        <span class="rj-cx-wipe" aria-hidden="true"></span>
                        <span class="rj-cx-orb" aria-hidden="true">
                            <span class="rj-cx-ico">{!! $iconHtml($card) !!}</span>
                        </span>

                        <span class="rj-cx-body">
                            <span class="rj-cx-no"><b>{{ sprintf('%02d', $i + 1) }}</b>{{ $card['title'] }}</span>
                            @if($card['value'] !== '')
                                <span class="rj-cx-val">{{ $card['value'] }}</span>
                            @endif
                            <span class="rj-cx-bar"></span>
                            @if($card['desc'] !== '')
                                <span class="rj-cx-desc">{{ $card['desc'] }}</span>
                            @endif
                        </span>

                        @if($href !== '')
                            <span class="rj-cx-go" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M9 7h8v8"/></svg>
                            </span>
                        @endif
                    </{{ $tag }}>
                @endforeach
            </div>
        @else
            <div class="rj-cx-empty">{{ __('Please add at least one contact card.') }}</div>
        @endif

        @if($showFooter && $footerLabel !== '' && $footerUrl !== '')
            <div class="rj-cx-foot">
                <a href="{{ $footerUrl }}" class="rj-cx-cta">
                    <span>{{ $footerLabel }}</span>
                    <i aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </i>
                </a>
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    function go() {
        root.classList.add('is-in');
    }

    if (!('IntersectionObserver' in window)) {
        go();
        return;
    }

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                go();
                io.disconnect();
            }
        });
    }, { threshold: 0.12 });

    io.observe(root);
    setTimeout(go, 2500);
})();
</script>
