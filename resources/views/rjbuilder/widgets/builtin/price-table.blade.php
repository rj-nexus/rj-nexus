@php
    $subtitle   = trim((string) ($settings['subtitle'] ?? ''));
    $title      = trim((string) ($settings['title'] ?? __('Pricing Plans')));
    $desc       = trim((string) ($settings['desc'] ?? ''));
    $columns    = max(1, min(4, (int) ($settings['columns'] ?? 3)));
    $cardRadius = in_array($settings['card_radius'] ?? 'xl', ['md', 'xl', '2xl'], true) ? $settings['card_radius'] : 'xl';
    $hoverLift  = !empty($settings['hover_lift'] ?? true);
    $paddingY   = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $accent  = $hexOk($settings['accent'] ?? '', '#8b5cf6');
    $accent2 = $hexOk($settings['accent2'] ?? '', '#ec4899');

    $radiusCss = ['md' => '14px', 'xl' => '22px', '2xl' => '30px'][$cardRadius];

    $plans = [];
    if (!empty($settings['plans']) && is_array($settings['plans'])) {
        foreach ($settings['plans'] as $row) {
            if (!is_array($row) || trim((string) ($row['name'] ?? '')) === '') {
                continue;
            }

            $features = [];
            if (!empty($row['features'])) {
                foreach (preg_split('/\r\n|\r|\n/', (string) $row['features']) as $line) {
                    $line = trim($line);
                    if ($line !== '') {
                        $features[] = $line;
                    }
                }
            }

            $ctaUrl = trim((string) ($row['cta_url'] ?? '#'));
            if ($ctaUrl === '') {
                $ctaUrl = '#';
            } elseif (preg_match('/^\s*(javascript|data|vbscript):/i', $ctaUrl)) {
                $ctaUrl = '#';
            }

            $plans[] = [
                'name'      => trim((string) $row['name']),
                'tagline'   => trim((string) ($row['tagline'] ?? '')),
                'price'     => trim((string) ($row['price'] ?? '')),
                'period'    => trim((string) ($row['period'] ?? '')),
                'features'  => $features,
                'cta_label' => trim((string) ($row['cta_label'] ?? __('Get Started'))),
                'cta_url'   => $ctaUrl,
                'badge'     => trim((string) ($row['badge'] ?? '')),
                'featured'  => !empty($row['featured']) && (string) $row['featured'] === '1',
            ];
        }
    }
@endphp

<style>
    #{{ $uid }} {
        --pt-accent: {{ $accent }};
        --pt-accent2: {{ $accent2 }};
        --pt-ink: #0f172a;
        --pt-muted: #64748b;
        --pt-line: #e2e8f0;
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        position: relative;
        overflow: hidden;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Soft ambient glow behind the section */
    #{{ $uid }}::before {
        content: "";
        position: absolute;
        width: 520px;
        height: 520px;
        left: 50%;
        top: -180px;
        transform: translateX(-50%);
        background: radial-gradient(circle, color-mix(in srgb, var(--pt-accent) 16%, transparent), transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    #{{ $uid }} .pt-inner {
        position: relative;
        z-index: 1;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    #{{ $uid }} .pt-head {
        max-width: 640px;
        margin: 0 auto 48px;
        text-align: center;
    }
    #{{ $uid }} .pt-sub {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--pt-accent);
    }
    #{{ $uid }} .pt-sub::before,
    #{{ $uid }} .pt-sub::after {
        content: "";
        width: 22px;
        height: 2px;
        border-radius: 2px;
        background: var(--pt-accent);
    }
    #{{ $uid }} .pt-title {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.025em;
        color: var(--pt-ink);
        animation: ptFade .8s cubic-bezier(.2,.8,.2,1) both;
    }
    @media (min-width: 768px) { #{{ $uid }} .pt-title { font-size: 42px; } }
    #{{ $uid }} .pt-desc {
        margin: 14px 0 0;
        font-size: 15px;
        line-height: 1.65;
        color: var(--pt-muted);
    }

    /* Grid */
    #{{ $uid }} .pt-grid {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: 28px;
        align-items: stretch;
        padding-bottom: 14px;
    }
    @media (max-width: 960px) {
        #{{ $uid }} .pt-grid { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 620px) {
        #{{ $uid }} .pt-grid { grid-template-columns: 1fr; }
    }

    /* Card */
    #{{ $uid }} .pt-card {
        --mx: 50%;
        --my: 0%;
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 34px 26px 30px;
        border-radius: {{ $radiusCss }};
        background: rgba(255, 255, 255, .85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, .9);
        box-shadow: 0 18px 40px -26px rgba(15, 23, 42, .35);
        animation: ptRise .9s cubic-bezier(.2,.8,.2,1) both;
        animation-delay: calc(.15s + var(--i, 0) * .12s);
        transition: transform .45s cubic-bezier(.2,.8,.2,1), box-shadow .45s ease, border-color .35s ease;
    }
    /* Cursor spotlight */
    #{{ $uid }} .pt-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: radial-gradient(260px circle at var(--mx) var(--my), color-mix(in srgb, var(--pt-accent) 14%, transparent), transparent 70%);
        opacity: 0;
        transition: opacity .4s ease;
        pointer-events: none;
    }
    #{{ $uid }} .pt-card:hover::before { opacity: 1; }

    @if($hoverLift)
    #{{ $uid }} .pt-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 34px 60px -28px color-mix(in srgb, var(--pt-accent) 45%, transparent);
        border-color: color-mix(in srgb, var(--pt-accent) 35%, transparent);
    }
    @endif

    /* Featured card: animated gradient border */
    #{{ $uid }} .pt-card.is-featured {
        background: linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(120deg, var(--pt-accent), var(--pt-accent2), var(--pt-accent)) border-box;
        background-size: 100% 100%, 200% 100%;
        border: 2px solid transparent;
        animation: ptRise .9s cubic-bezier(.2,.8,.2,1) both, ptBorder 4s linear infinite;
        animation-delay: calc(.15s + var(--i, 0) * .12s), 0s;
        box-shadow: 0 30px 60px -28px color-mix(in srgb, var(--pt-accent) 55%, transparent);
    }
    #{{ $uid }} .pt-card.is-featured:hover {
        box-shadow: 0 40px 70px -28px color-mix(in srgb, var(--pt-accent) 65%, transparent);
    }

    /* Badge */
    #{{ $uid }} .pt-badge {
        position: absolute;
        top: -13px;
        left: 26px;
        padding: 6px 14px;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--pt-accent), var(--pt-accent2));
        color: #fff;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        box-shadow: 0 8px 18px -6px color-mix(in srgb, var(--pt-accent) 70%, transparent);
        white-space: nowrap;
    }

    /* Typography */
    #{{ $uid }} .pt-name {
        margin: 0 0 6px;
        font-size: 19px;
        font-weight: 800;
        color: var(--pt-ink);
    }
    #{{ $uid }} .pt-tagline {
        margin: 0 0 22px;
        min-height: 20px;
        font-size: 13px;
        line-height: 1.5;
        color: var(--pt-muted);
    }
    #{{ $uid }} .pt-price-row {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        margin-bottom: 24px;
    }
    #{{ $uid }} .pt-price {
        font-size: 44px;
        font-weight: 900;
        line-height: 1;
        letter-spacing: -.03em;
        color: var(--pt-ink);
        background: linear-gradient(90deg, var(--pt-accent), var(--pt-accent2));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .pt-period {
        padding-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
    }

    #{{ $uid }} .pt-divider {
        position: relative;
        height: 1px;
        margin: 0 0 22px;
        background: var(--pt-line);
        overflow: hidden;
    }
    #{{ $uid }} .pt-divider::after {
        content: "";
        position: absolute;
        top: 0;
        left: -40%;
        width: 40%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--pt-accent), transparent);
        animation: ptSweep 3.2s ease-in-out infinite;
        animation-delay: calc(var(--i, 0) * .4s);
    }

    /* Features */
    #{{ $uid }} .pt-feats {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 0 0 28px;
        padding: 0;
        list-style: none;
        flex: 1;
    }
    #{{ $uid }} .pt-feat {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        line-height: 1.5;
        color: #334155;
    }
    #{{ $uid }} .pt-check {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        margin-top: 1px;
        border-radius: 50%;
        background: color-mix(in srgb, var(--pt-accent) 14%, transparent);
        color: var(--pt-accent);
    }
    #{{ $uid }} .pt-check svg { width: 11px; height: 11px; }

    /* CTA */
    #{{ $uid }} .pt-cta {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 18px;
        border-radius: 12px;
        background: var(--pt-ink);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .3s ease;
        z-index: 0;
    }
    #{{ $uid }} .pt-cta::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background: linear-gradient(90deg, var(--pt-accent), var(--pt-accent2));
        transform: translateX(-101%);
        transition: transform .45s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .pt-cta:hover::before { transform: translateX(0); }
    #{{ $uid }} .pt-cta:hover {
        box-shadow: 0 12px 24px -10px color-mix(in srgb, var(--pt-accent) 70%, transparent);
    }
    #{{ $uid }} .pt-cta:active { transform: scale(.98); }
    #{{ $uid }} .pt-cta svg {
        width: 14px;
        height: 14px;
        transition: transform .3s ease;
    }
    #{{ $uid }} .pt-cta:hover svg { transform: translateX(4px); }

    /* Dollar coin, bottom-right corner of each card */
    #{{ $uid }} .pt-coin {
        position: absolute;
        right: -14px;
        bottom: -16px;
        z-index: 3;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at 30% 25%, #ffffff 0%, transparent 35%),
                    linear-gradient(135deg, var(--pt-accent), var(--pt-accent2));
        color: #fff;
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
        box-shadow: 0 0 0 4px #fff, 0 14px 26px -8px color-mix(in srgb, var(--pt-accent) 70%, transparent);
        transform-style: preserve-3d;
        animation: ptFloat 3.4s ease-in-out infinite;
        transition: transform .9s cubic-bezier(.2,.8,.2,1);
        pointer-events: none;
    }
    #{{ $uid }} .pt-coin span {
        display: block;
        text-shadow: 0 2px 4px rgba(0, 0, 0, .25);
    }
    #{{ $uid }} .pt-card:hover .pt-coin {
        transform: rotateY(360deg) scale(1.08);
    }
    #{{ $uid }} .pt-card.is-featured .pt-coin {
        box-shadow: 0 0 0 4px var(--pt-ink), 0 14px 26px -8px color-mix(in srgb, var(--pt-accent) 70%, transparent);
    }

    /* Empty state */
    #{{ $uid }} .pt-empty {
        max-width: 560px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        font-size: 14px;
        color: var(--pt-muted);
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
    }

    /* Keyframes */
    @keyframes ptFade {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes ptRise {
        from { opacity: 0; transform: translateY(40px) scale(.96); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes ptFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-6px); }
    }
    @keyframes ptBorder {
        0%   { background-position: 0 0, 0% 50%; }
        100% { background-position: 0 0, 200% 50%; }
    }
    @keyframes ptSweep {
        0%   { left: -40%; }
        100% { left: 140%; }
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
    <div class="pt-inner">
        @if($title !== '' || $subtitle !== '' || $desc !== '')
            <header class="pt-head">
                @if($subtitle !== '')
                    <p class="pt-sub">{{ $subtitle }}</p>
                @endif
                @if($title !== '')
                    <h2 class="pt-title">{{ $title }}</h2>
                @endif
                @if($desc !== '')
                    <p class="pt-desc">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($plans))
            <div class="pt-grid">
                @foreach($plans as $i => $plan)
                    <article class="pt-card {{ $plan['featured'] ? 'is-featured' : '' }}" style="--i: {{ $i }};">
                        @if($plan['badge'] !== '')
                            <span class="pt-badge">{{ $plan['badge'] }}</span>
                        @endif

                        <h3 class="pt-name">{{ $plan['name'] }}</h3>
                        <p class="pt-tagline">{{ $plan['tagline'] }}</p>

                        @if($plan['price'] !== '')
                            <div class="pt-price-row">
                                <span class="pt-price">{{ $plan['price'] }}</span>
                                @if($plan['period'] !== '')
                                    <span class="pt-period">{{ $plan['period'] }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="pt-divider"></div>

                        @if(!empty($plan['features']))
                            <ul class="pt-feats">
                                @foreach($plan['features'] as $feat)
                                    <li class="pt-feat">
                                        <span class="pt-check">
                                            <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span>{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if($plan['cta_label'] !== '')
                            <a href="{{ $plan['cta_url'] }}" class="pt-cta">
                                <span>{{ $plan['cta_label'] }}</span>
                                <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif

                        <span class="pt-coin" aria-hidden="true"><span>$</span></span>
                    </article>
                @endforeach
            </div>
        @else
            <div class="pt-empty">{{ __('Please add at least one plan.') }}</div>
        @endif
    </div>
</div>

@if(!empty($plans))
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (!window.matchMedia('(hover: hover)').matches) return;

    root.querySelectorAll('.pt-card').forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            var r = card.getBoundingClientRect();
            card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            card.style.setProperty('--my', (e.clientY - r.top) + 'px');
        });
    });
})();
</script>
@endif
