@extends('theme::layout')

@push('styles')
    <style>
        .rj-landing-hero {
            position: relative;
            padding: 140px 24px 120px;
            text-align: center;
            overflow: hidden;
            background: var(--rj-bg);
        }
        .rj-landing-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 50% at 50% 0%, color-mix(in srgb, var(--rj-primary) 32%, transparent), transparent 70%),
                radial-gradient(circle at 15% 70%, color-mix(in srgb, var(--rj-accent) 18%, transparent), transparent 50%),
                radial-gradient(circle at 85% 30%, color-mix(in srgb, var(--rj-secondary) 20%, transparent), transparent 50%);
            pointer-events: none;
        }
        .rj-landing-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 55% 55% at 50% 40%, #000 30%, transparent 80%);
            pointer-events: none;
        }
        .rj-landing-hero-inner {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .rj-landing-badge {
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
        .rj-landing-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--rj-accent);
            box-shadow: 0 0 12px var(--rj-accent);
            animation: rjLandingPulse 2.4s ease-in-out infinite;
        }
        @keyframes rjLandingPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }
        .rj-landing-title {
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
        .rj-landing-title .rj-grad {
            background: linear-gradient(135deg, var(--rj-primary) 0%, var(--rj-secondary) 50%, var(--rj-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .rj-landing-subtitle {
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 620px;
        }
        .rj-landing-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 48px;
            flex-wrap: wrap;
        }
        .rj-landing-cta a {
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
        .rj-landing-cta-primary {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: #0a0a0f;
            box-shadow: 0 14px 44px -12px color-mix(in srgb, var(--rj-primary) 60%, transparent);
        }
        .rj-landing-cta-primary:hover {
            color: #0a0a0f;
            transform: translateY(-2px);
            box-shadow: 0 20px 52px -12px color-mix(in srgb, var(--rj-primary) 75%, transparent);
        }
        .rj-landing-cta-secondary {
            background: color-mix(in srgb, var(--rj-surface) 80%, transparent);
            color: var(--rj-text);
            border: 1px solid var(--rj-border);
            backdrop-filter: blur(12px);
        }
        .rj-landing-cta-secondary:hover {
            background: var(--rj-surface);
            border-color: color-mix(in srgb, var(--rj-primary) 50%, var(--rj-border));
            color: var(--rj-text);
            transform: translateY(-2px);
        }

        .rj-landing-features {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 96px 24px;
        }
        .rj-landing-features-header {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 64px;
        }
        .rj-landing-features-header h2 {
            font-size: clamp(28px, 3.5vw, 42px);
            font-weight: 800;
            letter-spacing: -.025em;
            margin: 0 0 16px;
            color: var(--rj-text);
        }
        .rj-landing-features-header p {
            font-size: 16px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0;
        }
        .rj-landing-features-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
        }
        .rj-landing-feature {
            padding: 36px 32px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            transition: border-color .2s, transform .2s;
        }
        .rj-landing-feature:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 45%, var(--rj-border));
            transform: translateY(-4px);
        }
        .rj-landing-feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            border-radius: var(--rj-radius);
            background: color-mix(in srgb, var(--rj-primary) 14%, transparent);
            border: 1px solid color-mix(in srgb, var(--rj-primary) 30%, transparent);
            color: var(--rj-primary);
            margin-bottom: 24px;
        }
        .rj-landing-feature h3 {
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -.015em;
            margin: 0 0 10px;
            color: var(--rj-text);
        }
        .rj-landing-feature p {
            font-size: 14px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0;
        }

        .rj-landing-cta-banner {
            max-width: var(--rj-container);
            margin: 0 auto 96px;
            padding: 0 24px;
        }
        .rj-landing-cta-banner-inner {
            position: relative;
            padding: 72px 40px;
            text-align: center;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            overflow: hidden;
        }
        .rj-landing-cta-banner-inner::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 80% at 50% 0%, color-mix(in srgb, var(--rj-primary) 25%, transparent), transparent 70%),
                radial-gradient(circle at 90% 90%, color-mix(in srgb, var(--rj-secondary) 15%, transparent), transparent 50%);
            pointer-events: none;
        }
        .rj-landing-cta-banner-inner > * { position: relative; z-index: 1; }
        .rj-landing-cta-banner h2 {
            font-size: clamp(26px, 3.5vw, 40px);
            font-weight: 800;
            letter-spacing: -.025em;
            margin: 0 0 14px;
            color: var(--rj-text);
        }
        .rj-landing-cta-banner p {
            font-size: 16px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 auto 32px;
            max-width: 520px;
        }

        @media (max-width: 968px) {
            .rj-landing-features-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 768px) {
            .rj-landing-hero { padding: 90px 20px 80px; }
            .rj-landing-cta { margin-top: 36px; gap: 10px; }
            .rj-landing-cta a { padding: 13px 24px; font-size: 14px; }
            .rj-landing-features { padding: 64px 20px; }
            .rj-landing-features-header { margin-bottom: 40px; }
            .rj-landing-features-grid { grid-template-columns: minmax(0, 1fr); gap: 20px; }
            .rj-landing-cta-banner { margin-bottom: 64px; }
            .rj-landing-cta-banner-inner { padding: 48px 24px; }
        }
    </style>
@endpush

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    @if($page && $page->isBuilderMode() && $page->hasBlocks())
        {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
    @elseif($page && $page->content)
        <div class="rj-container" style="padding-top:64px;padding-bottom:64px;">
            <div class="rj-page-content">
                {!! strip_tags($page->content, '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><img><blockquote><pre><code><span><div><table><thead><tbody><tr><th><td>') !!}
            </div>
        </div>
    @else

        <section class="rj-landing-hero">
            <div class="rj-landing-hero-inner">
                <span class="rj-landing-badge">
                    <span class="rj-landing-badge-dot"></span>
                    {{ __('Launch ready') }}
                </span>

                <h1 class="rj-landing-title">
                    {{ $page->title ?? rj_get_option('site_name', config('app.name')) }}
                    <br>
                    <span class="rj-grad">{{ rj_get_option('site_tagline', __('Built to shine.')) }}</span>
                </h1>

                <p class="rj-landing-subtitle">{{ __('A focused landing page with everything you need to turn visitors into customers — no clutter, just impact.') }}</p>

                <div class="rj-landing-cta">
                    <a href="{{ route('frontend.posts.index') }}" class="rj-landing-cta-primary">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        {{ __('Get started') }}
                    </a>
                    <a href="#features" class="rj-landing-cta-secondary">
                        {{ __('Learn more') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="rj-landing-features" id="features">
            <div class="rj-landing-features-header">
                <h2>{{ __('Everything you need') }}</h2>
                <p>{{ __('Three pillars that make this landing page a conversion machine — simple, fast, and beautiful.') }}</p>
            </div>

            <div class="rj-landing-features-grid">
                <div class="rj-landing-feature">
                    <div class="rj-landing-feature-icon">
                        <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3>{{ __('Lightning fast') }}</h3>
                    <p>{{ __('Optimized rendering, lazy images, and minimal JavaScript keep your page snappy on every device.') }}</p>
                </div>

                <div class="rj-landing-feature">
                    <div class="rj-landing-feature-icon">
                        <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    </div>
                    <h3>{{ __('Fully customizable') }}</h3>
                    <p>{{ __('Every color, font, and spacing value is driven by the customizer — make it yours in seconds.') }}</p>
                </div>

                <div class="rj-landing-feature">
                    <div class="rj-landing-feature-icon">
                        <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3>{{ __('Secure by default') }}</h3>
                    <p>{{ __('CSRF protection, sanitized inputs, and secure form handling are built into every interaction.') }}</p>
                </div>
            </div>
        </section>

        <section class="rj-landing-cta-banner">
            <div class="rj-landing-cta-banner-inner">
                <h2>{{ __('Ready to launch?') }}</h2>
                <p>{{ __('Start building your next landing page in minutes — no code, no friction, just results.') }}</p>
                <a href="{{ url('/admin') }}" class="rj-landing-cta-primary" style="display:inline-flex;align-items:center;gap:8px;padding:15px 32px;border-radius:var(--rj-radius);color:#0a0a0f;text-decoration:none;font-weight:600;background:linear-gradient(135deg,var(--rj-primary),var(--rj-secondary));box-shadow:0 14px 44px -12px color-mix(in srgb,var(--rj-primary) 60%,transparent);">
                    {{ __('Open the builder') }}
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </section>

    @endif

</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection