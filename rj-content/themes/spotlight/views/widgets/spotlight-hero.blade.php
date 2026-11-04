@php
    $badgeText = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $primaryText = $settings['primary_btn_text'] ?? '';
    $primaryUrl = $settings['primary_btn_url'] ?? '#';
    $secondaryText = $settings['secondary_btn_text'] ?? '';
    $secondaryUrl = $settings['secondary_btn_url'] ?? '#';
@endphp

<section class="rj-hero">
    <div class="rj-hero-bg"></div>
    <div class="rj-hero-grid"></div>

    <div class="rj-hero-inner">
        @if($badgeText)
            <span class="rj-hero-badge">
                <span class="rj-hero-badge-dot"></span>
                {{ $badgeText }}
            </span>
        @endif

        @if($title)
            <h1 class="rj-hero-title">
                {!! nl2br(e($title)) !!}
            </h1>
        @endif

        @if($subtitle)
            <p class="rj-hero-subtitle">{{ $subtitle }}</p>
        @endif

        @if($primaryText || $secondaryText)
            <div class="rj-hero-cta">
                @if($primaryText)
                    <a href="{{ $primaryUrl }}" class="rj-hero-btn rj-hero-btn-primary">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        {{ $primaryText }}
                    </a>
                @endif

                @if($secondaryText)
                    <a href="{{ $secondaryUrl }}" class="rj-hero-btn rj-hero-btn-secondary">
                        {{ $secondaryText }}
                    </a>
                @endif
            </div>
        @endif
    </div>

    <style>
        .rj-hero {
            position: relative;
            padding: 140px 24px 120px;
            text-align: center;
            background: var(--rj-bg);
            overflow: hidden;
        }
        .rj-hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 50% at 50% 0%, color-mix(in srgb, var(--rj-primary) 32%, transparent), transparent 70%),
                radial-gradient(circle at 15% 70%, color-mix(in srgb, var(--rj-accent) 18%, transparent), transparent 50%),
                radial-gradient(circle at 85% 30%, color-mix(in srgb, var(--rj-secondary) 20%, transparent), transparent 50%);
            pointer-events: none;
        }
        .rj-hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 55% 55% at 50% 40%, #000 30%, transparent 80%);
            -webkit-mask-image: radial-gradient(ellipse 55% 55% at 50% 40%, #000 30%, transparent 80%);
            pointer-events: none;
        }
        .rj-hero-inner {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .rj-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--rj-surface) 90%, transparent);
            border: 1px solid var(--rj-border);
            color: var(--rj-muted);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 32px;
            backdrop-filter: blur(12px);
        }
        .rj-hero-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--rj-accent);
            box-shadow: 0 0 12px var(--rj-accent);
            animation: rjHeroPulse 2.4s ease-in-out infinite;
        }
        @keyframes rjHeroPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }
        .rj-hero-title {
            font-size: clamp(40px, 6vw, 76px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -.035em;
            margin: 0 0 24px;
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 60%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .rj-hero-subtitle {
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 620px;
        }
        .rj-hero-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 48px;
            flex-wrap: wrap;
        }
        .rj-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 15px 32px;
            border-radius: var(--rj-radius);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .18s, box-shadow .18s, background .18s, border-color .18s;
        }
        .rj-hero-btn-primary {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: var(--rj-bg);
            box-shadow: 0 14px 44px -12px color-mix(in srgb, var(--rj-primary) 60%, transparent);
        }
        .rj-hero-btn-primary:hover {
            color: var(--rj-bg);
            transform: translateY(-2px);
            box-shadow: 0 20px 52px -12px color-mix(in srgb, var(--rj-primary) 75%, transparent);
        }
        .rj-hero-btn-secondary {
            background: color-mix(in srgb, var(--rj-surface) 80%, transparent);
            color: var(--rj-text);
            border: 1px solid var(--rj-border);
            backdrop-filter: blur(12px);
        }
        .rj-hero-btn-secondary:hover {
            background: var(--rj-surface);
            border-color: color-mix(in srgb, var(--rj-primary) 50%, var(--rj-border));
            color: var(--rj-text);
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .rj-hero { padding: 90px 20px 80px; }
            .rj-hero-cta { margin-top: 36px; gap: 10px; }
            .rj-hero-btn { padding: 13px 24px; font-size: 14px; }
        }
    </style>
</section>
