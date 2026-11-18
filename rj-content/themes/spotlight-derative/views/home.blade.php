@extends('theme::layout')

@push('styles')
    <style>
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
            border-bottom: 1px solid var(--rj-border);
            padding-bottom: 24px;
        }
        .rj-home-section-header-text h1 {
            font-size: clamp(32px, 4vw, 42px);
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

        @if(isset($latestPosts) && $latestPosts->isNotEmpty())
            <section class="rj-home-section">
                <div class="rj-home-section-header">
                    <div class="rj-home-section-header-text">
                        <h1>{{ __('Latest Stories') }}</h1>
                        <p>{{ __('Fresh insights and updates from our team.') }}</p>
                    </div>
                    <a href="{{ $blogUrl }}" class="rj-home-section-link" style="display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border-radius:var(--rj-radius-sm);background:var(--rj-surface);border:1px solid var(--rj-border);color:var(--rj-text);font-size:14px;font-weight:600;text-decoration:none;">
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
                <a href="{{ url('/admin/posts/create') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:var(--rj-radius);color:var(--rj-bg);text-decoration:none;font-weight:600;background:linear-gradient(135deg,var(--rj-primary),var(--rj-secondary));">
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
