@php
    $subtitle     = $settings['subtitle'] ?? '';
    $title        = $settings['title'] ?? '';
    $desc         = $settings['desc'] ?? '';
    $layout       = $settings['layout'] ?? 'cards';
    $columns      = (int) ($settings['columns'] ?? 3);
    $align        = $settings['align'] ?? 'center';
    $cardStyle    = $settings['card_style'] ?? 'card';
    $iconStyle    = $settings['icon_style'] ?? 'rounded';
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $accent2      = $settings['accent2'] ?? '#ec4899';
    $textColor    = $settings['text_color'] ?? '#0f172a';
    $mutedColor   = $settings['muted_color'] ?? '#64748b';
    $radius       = $settings['radius'] ?? 'lg';
    $showFooterCta= $settings['show_footer_cta'] ?? false;
    $footerLabel  = $settings['footer_label'] ?? __('Contact Us');
    $footerUrl    = $settings['footer_url'] ?? '/contact';
    $paddingY     = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '10px', 'lg' => '16px', 'xl' => '24px'];
    $radiusCss = $radiusMap[$radius] ?? '16px';

    $iconShapeMap = [
        'circle'  => '9999px',
        'rounded' => '12px',
        'square'  => '0px',
        'soft'    => '14px',
    ];
    $iconRadius = $iconShapeMap[$iconStyle] ?? '12px';

    $isGradient = $cardStyle === 'gradient';
    $isGlass = $cardStyle === 'glass';
    $finalTitle = $isGradient ? '#ffffff' : $textColor;
    $finalMuted = $isGradient ? 'rgba(255,255,255,.85)' : $mutedColor;

    $typeIcons = [
        'address' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'phone'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>',
        'email'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6"/></svg>',
        'hours'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>',
        'whatsapp'=> '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.693.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>',
        'telegram'=> '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
        'website' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
        'custom'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8M8 12h8"/></svg>',
    ];

    $cards = [];
    if (!empty($settings['cards']) && is_array($settings['cards'])) {
        foreach ($settings['cards'] as $row) {
            if (!is_array($row)) continue;
            if (empty($row['title']) && empty($row['value'])) continue;
            $type = $row['type'] ?? 'custom';
            if (!isset($typeIcons[$type])) $type = 'custom';
            $cards[] = [
                'type'  => $type,
                'title' => $row['title'] ?? '',
                'value' => $row['value'] ?? '',
                'desc'  => $row['desc'] ?? '',
                'link'  => trim((string) ($row['link'] ?? '')),
                'icon'  => trim((string) ($row['icon'] ?? '')),
            ];
        }
    }

    $autoLink = function (string $type, string $value, string $link): string {
        if ($link !== '') return $link;
        $v = trim($value);
        if ($v === '') return '';
        switch ($type) {
            case 'phone':   return 'tel:' . preg_replace('/[^\d+]/', '', $v);
            case 'email':   return 'mailto:' . $v;
            case 'whatsapp':return 'https://wa.me/' . preg_replace('/\D+/', '', $v);
            case 'telegram':return 'https://t.me/' . ltrim($v, '@');
            case 'website': return preg_match('#^https?://#i', $v) ? $v : 'https://' . $v;
        }
        return '';
    };

    $iconSvg = function (array $card) use ($typeIcons): string {
        if ($card['icon'] !== '') {
            return '<img src="https://api.iconify.design/' . e(str_replace(':', '/', $card['icon'])) . '.svg?color=%23ffffff" alt="" style="width:55%;height:55%;object-fit:contain;" loading="lazy">';
        }
        return $typeIcons[$card['type']] ?? $typeIcons['custom'];
    };

    $isIconLeft = $layout === 'icon-left';
    $isRows = $layout === 'rows';
@endphp

<style>
    #{{ $uid }} {
        --ci-accent: {{ $accent }};
        --ci-accent2: {{ $accent2 }};
        --ci-text: {{ $finalTitle }};
        --ci-muted: {{ $finalMuted }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-ci-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-ci-head {
        margin-bottom: 40px;
        max-width: 640px;
        text-align: {{ $align }};
    }
    #{{ $uid }}[data-align="center"] .rj-ci-head {
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-ci-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--ci-accent);
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-ci-title {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-ci-title { font-size: 40px; }
    }
    #{{ $uid }} .rj-ci-desc {
        font-size: 14px;
        color: #64748b;
        line-height: 1.7;
        margin: 12px 0 0;
    }

    #{{ $uid }} .rj-ci-grid {
        display: grid;
        gap: 18px;
    }
    #{{ $uid }}[data-layout="cards"] .rj-ci-grid {
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
    }
    #{{ $uid }}[data-layout="rows"] .rj-ci-grid,
    #{{ $uid }}[data-layout="icon-left"] .rj-ci-grid {
        grid-template-columns: repeat({{ min(2, $columns) }}, minmax(0, 1fr));
    }
    @media (max-width: 960px) {
        #{{ $uid }}[data-layout="cards"] .rj-ci-grid {
            grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr));
        }
        #{{ $uid }}[data-layout="rows"] .rj-ci-grid,
        #{{ $uid }}[data-layout="icon-left"] .rj-ci-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-ci-grid { grid-template-columns: 1fr !important; }
    }

    #{{ $uid }} .rj-ci-card {
        position: relative;
        border-radius: {{ $radiusCss }};
        padding: 28px 24px;
        text-align: {{ $align }};
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .3s ease, background .3s ease;
        overflow: hidden;
    }
    #{{ $uid }}[data-layout="icon-left"] .rj-ci-card,
    #{{ $uid }}[data-layout="rows"] .rj-ci-card {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        gap: 18px;
        text-align: left;
        padding: 22px 24px;
    }
    @media (max-width: 560px) {
        #{{ $uid }}[data-layout="icon-left"] .rj-ci-card,
        #{{ $uid }}[data-layout="rows"] .rj-ci-card {
            grid-template-columns: 1fr;
            text-align: {{ $align }};
        }
    }

    #{{ $uid }} .rj-ci-card.is-link {
        cursor: pointer;
    }
    #{{ $uid }} .rj-ci-card.is-link:hover {
        transform: translateY(-4px);
    }

    /* ---------- CARD STYLES ---------- */
    #{{ $uid }}[data-card="card"] .rj-ci-card {
        background: #fff;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 32px -20px rgba(15,23,42,.22);
    }
    #{{ $uid }}[data-card="card"] .rj-ci-card.is-link:hover {
        box-shadow: 0 22px 40px -20px rgba(15,23,42,.28);
        border-color: color-mix(in srgb, var(--ci-accent) 30%, #eef2f7);
    }
    #{{ $uid }}[data-card="bordered"] .rj-ci-card {
        background: #fff;
        border: 1.5px solid #e5e7eb;
    }
    #{{ $uid }}[data-card="bordered"] .rj-ci-card.is-link:hover {
        border-color: var(--ci-accent);
    }
    #{{ $uid }}[data-card="minimal"] .rj-ci-card {
        background: transparent;
        border: 0;
        padding: 8px 4px;
    }
    #{{ $uid }}[data-card="gradient"] .rj-ci-card {
        background: linear-gradient(135deg, var(--ci-accent), var(--ci-accent2));
        color: #fff;
        box-shadow: 0 18px 40px -20px color-mix(in srgb, var(--ci-accent) 55%, transparent);
    }
    #{{ $uid }}[data-card="gradient"] .rj-ci-card-title { color: #fff; }
    #{{ $uid }}[data-card="gradient"] .rj-ci-card-value { color: #fff; }
    #{{ $uid }}[data-card="gradient"] .rj-ci-card-desc { color: rgba(255,255,255,.85); }
    #{{ $uid }}[data-card="gradient"] .rj-ci-icon {
        background: rgba(255,255,255,.2);
        color: #fff;
        border: 1px solid rgba(255,255,255,.3);
    }
    #{{ $uid }}[data-card="glass"] .rj-ci-card {
        background: rgba(255,255,255,.55);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,.7);
        box-shadow: 0 14px 32px -20px rgba(15,23,42,.2);
    }
    #{{ $uid }}[data-card="glass"] .rj-ci-card.is-link:hover {
        background: rgba(255,255,255,.7);
    }

    /* ---------- ICON ---------- */
    #{{ $uid }} .rj-ci-icon {
        width: 56px;
        height: 56px;
        border-radius: {{ $iconRadius }};
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        background: linear-gradient(135deg, var(--ci-accent), var(--ci-accent2));
        color: #fff;
        flex-shrink: 0;
        transition: transform .35s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 10px 24px -10px color-mix(in srgb, var(--ci-accent) 55%, transparent);
    }
    #{{ $uid }}[data-icon-style="soft"] .rj-ci-icon {
        background: color-mix(in srgb, var(--ci-accent) 12%, transparent);
        color: var(--ci-accent);
        box-shadow: none;
        border: 1px solid color-mix(in srgb, var(--ci-accent) 22%, transparent);
    }
    #{{ $uid }} .rj-ci-icon svg {
        width: 26px;
        height: 26px;
        display: block;
    }
    #{{ $uid }}[data-icon-style="soft"] .rj-ci-icon svg {
        color: var(--ci-accent);
    }
    #{{ $uid }}[data-layout="icon-left"] .rj-ci-icon,
    #{{ $uid }}[data-layout="rows"] .rj-ci-icon {
        margin: 0;
        width: 52px;
        height: 52px;
    }
    @media (max-width: 560px) {
        #{{ $uid }}[data-layout="icon-left"] .rj-ci-icon,
        #{{ $uid }}[data-layout="rows"] .rj-ci-icon {
            margin: 0 auto 14px;
        }
    }
    #{{ $uid }} .rj-ci-card:hover .rj-ci-icon {
        transform: scale(1.06) rotate(-3deg);
    }

    /* ---------- CONTENT ---------- */
    #{{ $uid }} .rj-ci-card-body {
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-ci-card-title {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--ci-muted);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-ci-card-value {
        font-size: 15.5px;
        font-weight: 700;
        color: var(--ci-text);
        margin: 0 0 6px;
        line-height: 1.4;
        word-break: break-word;
    }
    #{{ $uid }} .rj-ci-card-value a {
        color: inherit;
        text-decoration: none;
    }
    #{{ $uid }} .rj-ci-card-value a:hover {
        text-decoration: underline;
    }
    #{{ $uid }} .rj-ci-card-desc {
        font-size: 12.5px;
        color: var(--ci-muted);
        line-height: 1.55;
        margin: 0;
    }

    /* ---------- FOOTER CTA ---------- */
    #{{ $uid }} .rj-ci-footer {
        text-align: {{ $align }};
        margin-top: 32px;
    }
    #{{ $uid }} .rj-ci-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 12px;
        background: var(--ci-accent);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 12px 24px -12px color-mix(in srgb, var(--ci-accent) 65%, transparent);
        transition: transform .15s ease, opacity .2s ease;
    }
    #{{ $uid }} .rj-ci-cta:hover { opacity: .92; transform: translateY(-2px); }
    #{{ $uid }} .rj-ci-cta:active { transform: scale(.98); }
    #{{ $uid }} .rj-ci-cta svg { width: 14px; height: 14px; }

    #{{ $uid }} .rj-ci-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}" data-layout="{{ $layout }}" data-card="{{ $cardStyle }}" data-icon-style="{{ $iconStyle }}" data-align="{{ $align }}">
    <div class="rj-ci-inner">
        @if($title || $subtitle || $desc)
            <header class="rj-ci-head">
                @if($subtitle)
                    <p class="rj-ci-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-ci-title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="rj-ci-desc">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($cards))
            <div class="rj-ci-grid">
                @foreach($cards as $card)
                    @php
                        $href = $autoLink($card['type'], $card['value'], $card['link']);
                        $tag = $href !== '' ? 'a' : 'div';
                        $isExternal = $href !== '' && preg_match('#^https?://#i', $href);
                    @endphp
                    <{{ $tag }} class="rj-ci-card {{ $href !== '' ? 'is-link' : '' }}"
                            @if($href !== '') href="{{ $href }}" @endif
                            @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                        <div class="rj-ci-icon">
                            {!! $iconSvg($card) !!}
                        </div>
                        <div class="rj-ci-card-body">
                            @if($card['title'] !== '')
                                <p class="rj-ci-card-title">{{ $card['title'] }}</p>
                            @endif
                            @if($card['value'] !== '')
                                <p class="rj-ci-card-value">{{ $card['value'] }}</p>
                            @endif
                            @if($card['desc'] !== '')
                                <p class="rj-ci-card-desc">{{ $card['desc'] }}</p>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @else
            <div class="rj-ci-empty">{{ __('Please add at least one contact card.') }}</div>
        @endif

        @if($showFooterCta && $footerLabel !== '')
            <div class="rj-ci-footer">
                <a href="{{ $footerUrl }}" class="rj-ci-cta">
                    <span>{{ $footerLabel }}</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>
</div>
