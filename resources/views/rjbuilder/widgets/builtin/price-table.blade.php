@php
    $subtitle    = $settings['subtitle'] ?? '';
    $title       = $settings['title'] ?? __('Pricing Plans');
    $desc        = $settings['desc'] ?? '';
    $columns     = (int) ($settings['columns'] ?? 3);
    $accent      = $settings['accent'] ?? '#8b5cf6';
    $accent2     = $settings['accent2'] ?? '#ec4899';
    $cardRadius  = $settings['card_radius'] ?? 'xl';
    $hoverLift   = $settings['hover_lift'] ?? true;
    $paddingY    = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['md' => '14px', 'xl' => '20px', '2xl' => '28px'];
    $radiusCss = $radiusMap[$cardRadius] ?? '20px';

    $plans = [];
    if (!empty($settings['plans']) && is_array($settings['plans'])) {
        foreach ($settings['plans'] as $row) {
            if (!is_array($row) || empty($row['name'])) continue;
            $features = [];
            if (!empty($row['features'])) {
                $lines = preg_split('/\r\n|\r|\n/', (string) $row['features']);
                foreach ($lines as $l) {
                    $l = trim($l);
                    if ($l !== '') $features[] = $l;
                }
            }
            $plans[] = [
                'name'      => $row['name'],
                'tagline'   => $row['tagline'] ?? '',
                'price'     => $row['price'] ?? '',
                'period'    => $row['period'] ?? '',
                'features'  => $features,
                'cta_label' => $row['cta_label'] ?? __('Get Started'),
                'cta_url'   => $row['cta_url'] ?? '#',
                'badge'     => $row['badge'] ?? '',
                'featured'  => !empty($row['featured']) && (string) $row['featured'] === '1',
            ];
        }
    }
@endphp

<style>
    #{{ $uid }} {
        --pt-accent: {{ $accent }};
        --pt-accent2: {{ $accent2 }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-pt-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-pt-head {
        text-align: center;
        margin-bottom: 44px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-pt-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--pt-accent);
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-pt-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-pt-title { font-size: 42px; }
    }
    #{{ $uid }} .rj-pt-desc {
        font-size: 14px;
        color: #64748b;
        margin: 12px 0 0;
        line-height: 1.65;
    }

    #{{ $uid }} .rj-pt-grid {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: 20px;
        align-items: stretch;
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-pt-grid { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 620px) {
        #{{ $uid }} .rj-pt-grid { grid-template-columns: 1fr; }
    }

    #{{ $uid }} .rj-pt-card {
        position: relative;
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: {{ $radiusCss }};
        padding: 30px 24px;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .3s ease;
    }
    @if($hoverLift)
    #{{ $uid }} .rj-pt-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px -20px rgba(15,23,42,.25);
    }
    @endif

    #{{ $uid }} .rj-pt-card.is-featured {
        border: 0;
        background: linear-gradient(160deg, var(--pt-accent), var(--pt-accent2));
        color: #fff;
        box-shadow: 0 24px 48px -18px color-mix(in srgb, var(--pt-accent) 60%, transparent);
    }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-name,
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-price,
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-tagline { color: #fff; }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-period { color: rgba(255,255,255,.75); }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-feat { color: rgba(255,255,255,.92); }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-feat svg { color: #fff; }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-divider { background: rgba(255,255,255,.22); }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-cta {
        background: #fff;
        color: var(--pt-accent);
    }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-cta:hover {
        background: rgba(255,255,255,.9);
    }

    #{{ $uid }} .rj-pt-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 14px;
        border-radius: 999px;
        background: #0f172a;
        color: #fff;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        box-shadow: 0 6px 14px -4px rgba(0,0,0,.3);
        white-space: nowrap;
    }
    #{{ $uid }} .rj-pt-card.is-featured .rj-pt-badge {
        background: #fff;
        color: var(--pt-accent);
    }

    #{{ $uid }} .rj-pt-name {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
    }
    #{{ $uid }} .rj-pt-tagline {
        font-size: 12.5px;
        color: #64748b;
        margin: 0 0 18px;
        line-height: 1.5;
        min-height: 19px;
    }

    #{{ $uid }} .rj-pt-price-row {
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin-bottom: 22px;
    }
    #{{ $uid }} .rj-pt-price {
        font-size: 38px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        line-height: 1;
    }
    #{{ $uid }} .rj-pt-period {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
    }

    #{{ $uid }} .rj-pt-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0 0 18px;
    }

    #{{ $uid }} .rj-pt-feats {
        list-style: none;
        margin: 0 0 24px;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }
    #{{ $uid }} .rj-pt-feat {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 13.5px;
        color: #334155;
        line-height: 1.5;
    }
    #{{ $uid }} .rj-pt-feat svg {
        flex-shrink: 0;
        margin-top: 2px;
        color: var(--pt-accent);
    }

    #{{ $uid }} .rj-pt-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 12px 18px;
        border-radius: 10px;
        background: #0f172a;
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        transition: background .25s ease, transform .15s ease;
    }
    #{{ $uid }} .rj-pt-cta:hover {
        background: #1e293b;
    }
    #{{ $uid }} .rj-pt-cta:active {
        transform: scale(.98);
    }
    #{{ $uid }} .rj-pt-card:not(.is-featured) .rj-pt-cta:hover {
        background: var(--pt-accent);
    }

    #{{ $uid }} .rj-pt-empty {
        max-width: 560px;
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
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-pt-inner">
        @if($title || $subtitle || $desc)
            <header class="rj-pt-head">
                @if($subtitle)
                    <p class="rj-pt-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-pt-title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="rj-pt-desc">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($plans))
            <div class="rj-pt-grid">
                @foreach($plans as $plan)
                    <div class="rj-pt-card {{ $plan['featured'] ? 'is-featured' : '' }}">
                        @if($plan['badge'] !== '')
                            <span class="rj-pt-badge">{{ $plan['badge'] }}</span>
                        @endif

                        <h3 class="rj-pt-name">{{ $plan['name'] }}</h3>
                        @if($plan['tagline'] !== '')
                            <p class="rj-pt-tagline">{{ $plan['tagline'] }}</p>
                        @else
                            <p class="rj-pt-tagline">&nbsp;</p>
                        @endif

                        @if($plan['price'] !== '')
                            <div class="rj-pt-price-row">
                                <span class="rj-pt-price">{{ $plan['price'] }}</span>
                                @if($plan['period'] !== '')
                                    <span class="rj-pt-period">{{ $plan['period'] }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="rj-pt-divider"></div>

                        @if(!empty($plan['features']))
                            <ul class="rj-pt-feats">
                                @foreach($plan['features'] as $feat)
                                    <li class="rj-pt-feat">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if($plan['cta_label'] !== '')
                            <a href="{{ $plan['cta_url'] }}" class="rj-pt-cta">
                                <span>{{ $plan['cta_label'] }}</span>
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="rj-pt-empty">{{ __('Please add at least one plan.') }}</div>
        @endif
    </div>
</div>
