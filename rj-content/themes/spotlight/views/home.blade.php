@extends('theme::layout')

@push('styles')
    <style>
        .rj-home-hero {
            position: relative;
            padding: 120px 24px 100px;
            overflow: hidden;
            text-align: center;
            background: var(--rj-bg);
        }
        .rj-home-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, color-mix(in srgb, var(--rj-primary) 30%, transparent), transparent 70%),
                radial-gradient(circle at 20% 80%, color-mix(in srgb, var(--rj-accent) 15%, transparent), transparent 50%),
                radial-gradient(circle at 80% 20%, color-mix(in srgb, var(--rj-secondary) 18%, transparent), transparent 50%);
            pointer-events: none;
        }
        .rj-home-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 60% 60% at 50% 40%, #000 30%, transparent 80%);
            pointer-events: none;
        }
        .rj-home-hero-inner {
            max-width: 860px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .rj-home-badge {
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
        .rj-home-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--rj-accent);
            box-shadow: 0 0 12px var(--rj-accent);
            animation: rjSpotPulse 2.4s ease-in-out infinite;
        }
        @keyframes rjSpotPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }
        .rj-home-hero h1 {
            font-size: clamp(38px, 6vw, 72px);
            line-height: 1.05;
            font-weight: 800;
            margin: 0 0 24px;
            letter-spacing: -.035em;
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 60%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .rj-home-hero h1 .rj-grad {
            background: linear-gradient(135deg, var(--rj-primary) 0%, var(--rj-secondary) 50%, var(--rj-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .rj-home-hero p {
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 580px;
        }
        .rj-home-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 44px;
            flex-wrap: wrap;
        }
        .rj-home-cta a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: var(--rj-radius);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .18s, box-shadow .18s, background .18s, border-color .18s;
        }
        .rj-home-cta-primary {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: var(--rj-bg);
            box-shadow: 0 12px 40px -12px color-mix(in srgb, var(--rj-primary) 60%, transparent);
        }
        .rj-home-cta-primary:hover {
            color: var(--rj-bg);
            transform: translateY(-2px);
            box-shadow: 0 18px 48px -12px color-mix(in srgb, var(--rj-primary) 75%, transparent);
        }
        .rj-home-cta-secondary {
            background: color-mix(in srgb, var(--rj-surface) 80%, transparent);
            color: var(--rj-text);
            border: 1px solid var(--rj-border);
            backdrop-filter: blur(12px);
        }
        .rj-home-cta-secondary:hover {
            background: var(--rj-surface);
            border-color: color-mix(in srgb, var(--rj-primary) 50%, var(--rj-border));
            color: var(--rj-text);
            transform: translateY(-2px);
        }

        .rj-home-section {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 96px 24px;
        }
        .rj-home-section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 48px;
            flex-wrap: wrap;
        }
        .rj-home-section-header-text h2 {
            font-size: clamp(26px, 3vw, 36px);
            font-weight: 800;
            margin: 0 0 10px;
            letter-spacing: -.025em;
            color: var(--rj-text);
        }
        .rj-home-section-header-text p {
            font-size: 15px;
            color: var(--rj-muted);
            margin: 0;
        }
        .rj-home-section-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-text);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all .15s;
        }
        .rj-home-section-link:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 60%, var(--rj-border));
            color: var(--rj-primary);
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-surface));
        }
        .rj-home-section-link svg { transition: transform .15s; }
        .rj-home-section-link:hover svg { transform: translateX(3px); }

        .rj-home-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 28px;
        }

        .rj-home-empty {
            max-width: 640px;
            margin: 0 auto;
            padding: 120px 24px;
            text-align: center;
        }
        .rj-home-empty h2 {
            font-size: clamp(28px, 3vw, 40px);
            font-weight: 800;
            margin: 0 0 14px;
            letter-spacing: -.025em;
            color: var(--rj-text);
        }
        .rj-home-empty p {
            font-size: 16px;
            color: var(--rj-muted);
            line-height: 1.65;
            margin: 0 0 36px;
        }

        @media (max-width: 768px) {
            .rj-home-hero { padding: 80px 20px 64px; }
            .rj-home-cta { margin-top: 36px; gap: 10px; }
            .rj-home-cta a { padding: 12px 22px; font-size: 14px; }
            .rj-home-section { padding: 64px 20px; }
            .rj-home-section-header { margin-bottom: 32px; }
            .rj-home-grid { gap: 20px; grid-template-columns: 1fr; }
            .rj-home-empty { padding: 80px 20px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();
    $blogUrl = route('frontend.posts.index', ['locale' => $locale]);
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    @if($page)
        @if($page->isBuilderMode() && $page->hasBlocks())
            {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
        @elseif($page->content)
            <div class="rj-container" style="padding-top:64px;padding-bottom:64px;">
                {!! $page->content !!}
            </div>
        @endif
    @else

        <section class="rj-home-hero">
            <div class="rj-home-hero-inner">
                <span class="rj-home-badge">
                    <span class="rj-home-badge-dot"></span>
                    {{ __('Now live') }}
                </span>

                <h1>
                    {{ rj_get_option('site_name', config('app.name')) }}
                    <br>
                    <span class="rj-grad">{{ rj_get_option('site_tagline', __('Shine brighter online.')) }}</span>
                </h1>

                <p>{{ __('A modern, dark-first platform built to showcase your work, product, or story with clarity and style.') }}</p>

                <div class="rj-home-cta">
                    <a href="{{ $blogUrl }}" class="rj-home-cta-primary">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        {{ __('Get started') }}
                    </a>
                    <a href="{{ url('/admin') }}" class="rj-home-cta-secondary">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ __('Admin') }}
                    </a>
                </div>
            </div>
        </section>

        @if(isset($latestPosts) && $latestPosts->isNotEmpty())
            <section class="rj-home-section">
                <div class="rj-home-section-header">
                    <div class="rj-home-section-header-text">
                        <h2>{{ __('Latest stories') }}</h2>
                        <p>{{ __('Fresh from the Spotlight') }}</p>
                    </div>
                    <a href="{{ $blogUrl }}" class="rj-home-section-link">
                        {{ __('View all') }}
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="rj-home-grid">
                    @foreach($latestPosts as $post)
                        @include('theme::partials.loop-card', ['post' => $post])
                    @endforeach
                </div>
            </section>
        @else
            <div class="rj-home-empty">
                <h2>{{ rj_get_option('site_name', config('app.name')) }}</h2>
                <p>{{ __('Your stage is ready. Publish your first post to step into the Spotlight.') }}</p>
                <a href="{{ url('/admin/posts/create') }}" class="rj-home-cta-primary" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:var(--rj-radius);color:var(--rj-bg);text-decoration:none;font-weight:600;background:linear-gradient(135deg,var(--rj-primary),var(--rj-secondary));">
                    {{ __('Create your first post') }}
                </a>
            </div>
        @endif

    @endif

</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
