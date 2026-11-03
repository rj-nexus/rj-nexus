@extends('theme::layout')

@push('styles')
    <style>
        .rj-contact-hero {
            position: relative;
            padding: 96px 24px 64px;
            text-align: center;
            overflow: hidden;
            background: var(--rj-bg);
            border-bottom: 1px solid var(--rj-border);
        }
        .rj-contact-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 50% 60% at 50% 0%, color-mix(in srgb, var(--rj-primary) 24%, transparent), transparent 70%),
                radial-gradient(circle at 80% 20%, color-mix(in srgb, var(--rj-secondary) 14%, transparent), transparent 50%);
            pointer-events: none;
        }
        .rj-contact-hero-inner {
            max-width: 640px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .rj-contact-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .rj-contact-label-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rj-accent);
            box-shadow: 0 0 10px var(--rj-accent);
        }
        .rj-contact-title {
            font-size: clamp(32px, 4.5vw, 52px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0 0 16px;
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 70%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .rj-contact-subtitle {
            font-size: 16px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0;
        }

        .rj-contact-body {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 72px 24px 96px;
        }
        .rj-contact-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
            gap: 40px;
            align-items: start;
        }

        .rj-contact-card {
            padding: 40px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            position: relative;
        }
        .rj-contact-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, color-mix(in srgb, var(--rj-primary) 40%, transparent), transparent 40%, transparent 60%, color-mix(in srgb, var(--rj-secondary) 40%, transparent));
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        .rj-contact-card-header {
            margin-bottom: 28px;
        }
        .rj-contact-card-header h2 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -.02em;
            margin: 0 0 8px;
            color: var(--rj-text);
        }
        .rj-contact-card-header p {
            font-size: 14px;
            color: var(--rj-muted);
            margin: 0;
            line-height: 1.6;
        }

        .rj-contact-card .rj-form-input,
        .rj-contact-card .rj-form textarea,
        .rj-contact-card .rj-form select {
            background: var(--rj-bg);
        }
        .rj-contact-card .rj-form-submit {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: var(--rj-bg);
        }

        .rj-contact-hint {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 48px 24px;
            background: var(--rj-bg);
            border: 1px dashed var(--rj-border);
            border-radius: var(--rj-radius);
            gap: 16px;
        }
        .rj-contact-hint-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--rj-primary) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--rj-primary) 30%, transparent);
            color: var(--rj-primary);
        }
        .rj-contact-hint h3 {
            font-size: 17px;
            font-weight: 700;
            color: var(--rj-text);
            margin: 0;
        }
        .rj-contact-hint p {
            font-size: 13px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            max-width: 420px;
        }
        .rj-contact-hint a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-text);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .15s;
        }
        .rj-contact-hint a:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 60%, var(--rj-border));
            color: var(--rj-primary);
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-surface));
        }

        .rj-contact-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .rj-contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius);
            transition: border-color .18s;
        }
        .rj-contact-info-item:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 40%, var(--rj-border));
        }
        .rj-contact-info-icon {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: var(--rj-radius-sm);
            background: color-mix(in srgb, var(--rj-primary) 14%, transparent);
            border: 1px solid color-mix(in srgb, var(--rj-primary) 30%, transparent);
            color: var(--rj-primary);
        }
        .rj-contact-info-text {
            flex: 1;
            min-width: 0;
        }
        .rj-contact-info-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--rj-muted);
            margin-bottom: 6px;
        }
        .rj-contact-info-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--rj-text);
            text-decoration: none;
            word-break: break-word;
            transition: color .15s;
        }
        .rj-contact-info-value:hover { color: var(--rj-primary); }

        .rj-contact-social {
            padding: 24px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius);
        }
        .rj-contact-social h3 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--rj-muted);
            margin: 0 0 16px;
        }
        .rj-contact-social-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .rj-contact-social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-bg);
            border: 1px solid var(--rj-border);
            color: var(--rj-muted);
            text-decoration: none;
            transition: all .15s;
        }
        .rj-contact-social-link:hover {
            color: var(--rj-primary);
            border-color: color-mix(in srgb, var(--rj-primary) 50%, var(--rj-border));
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-bg));
        }

        @media (max-width: 968px) {
            .rj-contact-grid { grid-template-columns: minmax(0, 1fr); gap: 28px; }
        }
        @media (max-width: 640px) {
            .rj-contact-hero { padding: 64px 20px 44px; }
            .rj-contact-body { padding: 44px 20px 64px; }
            .rj-contact-card { padding: 28px 24px; }
            .rj-contact-info-item { padding: 16px; }
        }
    </style>
@endpush

@php
    $socialLinks = array_filter([
        'facebook' => rj_theme_mod('facebook', '', 'social'),
        'twitter' => rj_theme_mod('twitter', '', 'social'),
        'instagram' => rj_theme_mod('instagram', '', 'social'),
        'youtube' => rj_theme_mod('youtube', '', 'social'),
        'linkedin' => rj_theme_mod('linkedin', '', 'social'),
        'github' => rj_theme_mod('github', '', 'social'),
    ]);

    $hasBuilderContent = $page && $page->isBuilderMode() && $page->hasBlocks();
    $hasClassicContent = $page && !$hasBuilderContent && !empty($page->content);
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    <section class="rj-contact-hero">
        <div class="rj-contact-hero-inner">
            <span class="rj-contact-label">
                <span class="rj-contact-label-dot"></span>
                {{ __('Contact') }}
            </span>
            <h1 class="rj-contact-title">{{ $page->title ?? __('Get in touch') }}</h1>
            <p class="rj-contact-subtitle">{{ __('Have a project, question, or just want to say hi? Drop us a line — we usually reply within one business day.') }}</p>
        </div>
    </section>

    <div class="rj-contact-body">
        <div class="rj-contact-grid">

            <div class="rj-contact-card">
                <div class="rj-contact-card-header">
                    <h2>{{ __('Send a message') }}</h2>
                    <p>{{ __('Fill out the form below and we will get back to you as soon as possible.') }}</p>
                </div>

                @if($hasBuilderContent)
                    {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
                @elseif($hasClassicContent)
                    <div class="rj-single-content">
                        {!! $page->content !!}
                    </div>
                @else
                    <div class="rj-contact-hint">
                        <div class="rj-contact-hint-icon">
                            <svg style="width:26px;height:26px;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h3>{{ __('No form added yet') }}</h3>
                        <p>{{ __('Open the page in RJBuilder and add a Form widget to display your contact form here.') }}</p>
                        <a href="{{ url('/admin/posts/' . ($page->id ?? 0) . '/edit') }}">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            {{ __('Edit in Builder') }}
                        </a>
                    </div>
                @endif
            </div>

            <aside class="rj-contact-info">
                @if(rj_get_option('site_email'))
                    <div class="rj-contact-info-item">
                        <div class="rj-contact-info-icon">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="rj-contact-info-text">
                            <span class="rj-contact-info-label">{{ __('Email') }}</span>
                            <a href="mailto:{{ rj_get_option('site_email') }}" class="rj-contact-info-value">{{ rj_get_option('site_email') }}</a>
                        </div>
                    </div>
                @endif

                @if(rj_get_option('site_phone'))
                    <div class="rj-contact-info-item">
                        <div class="rj-contact-info-icon">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="rj-contact-info-text">
                            <span class="rj-contact-info-label">{{ __('Phone') }}</span>
                            <a href="tel:{{ rj_get_option('site_phone') }}" class="rj-contact-info-value">{{ rj_get_option('site_phone') }}</a>
                        </div>
                    </div>
                @endif

                @if(rj_get_option('site_address'))
                    <div class="rj-contact-info-item">
                        <div class="rj-contact-info-icon">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="rj-contact-info-text">
                            <span class="rj-contact-info-label">{{ __('Address') }}</span>
                            <span class="rj-contact-info-value">{{ rj_get_option('site_address') }}</span>
                        </div>
                    </div>
                @endif

                @if(!empty($socialLinks))
                    <div class="rj-contact-social">
                        <h3>{{ __('Follow us') }}</h3>
                        <div class="rj-contact-social-list">
                            @foreach($socialLinks as $key => $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rj-contact-social-link" aria-label="{{ ucfirst($key) }}">
                                    @if($key === 'facebook')
                                        <svg style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                                    @elseif($key === 'twitter')
                                        <svg style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    @elseif($key === 'instagram')
                                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
                                    @elseif($key === 'youtube')
                                        <svg style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @elseif($key === 'linkedin')
                                        <svg style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    @elseif($key === 'github')
                                        <svg style="width:18px;height:18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

        </div>
    </div>

</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
