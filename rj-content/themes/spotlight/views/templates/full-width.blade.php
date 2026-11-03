@extends('theme::layout')

@push('styles')
    <style>
        .rj-fw-main {
            width: 100%;
            max-width: 100%;
        }
        .rj-fw-main > * {
            width: 100%;
            max-width: 100%;
        }
        .rj-fw-header {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 72px 24px 40px;
        }
        .rj-fw-title {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0;
            color: var(--rj-text);
        }
        .rj-fw-excerpt {
            font-size: 17px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 16px 0 0;
            max-width: 680px;
        }
        .rj-fw-content {
            width: 100%;
            max-width: 100%;
        }
        .rj-fw-content-text {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 0 24px 96px;
            font-size: 17px;
            line-height: 1.75;
            color: var(--rj-text);
        }
        .rj-fw-content-text > * { margin: 0 0 24px; }
        .rj-fw-content-text > *:last-child { margin-bottom: 0; }
        .rj-fw-content-text h2 {
            font-size: 28px;
            line-height: 1.25;
            margin: 48px 0 20px;
            letter-spacing: -.02em;
        }
        .rj-fw-content-text h3 {
            font-size: 22px;
            line-height: 1.3;
            margin: 36px 0 16px;
        }
        .rj-fw-content-text a {
            color: var(--rj-link);
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .rj-fw-content-text a:hover { color: var(--rj-secondary); }
        .rj-fw-content-text img {
            border-radius: var(--rj-radius);
            max-width: 100%;
            height: auto;
        }
        .rj-fw-empty {
            max-width: 640px;
            margin: 0 auto;
            padding: 120px 24px;
            text-align: center;
        }
        .rj-fw-empty h2 {
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 12px;
            color: var(--rj-text);
        }
        .rj-fw-empty p {
            font-size: 15px;
            color: var(--rj-muted);
            margin: 0;
        }
        @media (max-width: 768px) {
            .rj-fw-header { padding: 48px 20px 28px; }
            .rj-fw-content-text { padding: 0 20px 64px; font-size: 16px; }
            .rj-fw-content-text h2 { font-size: 24px; margin-top: 36px; }
            .rj-fw-content-text h3 { font-size: 20px; margin-top: 28px; }
        }
    </style>
@endpush

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main rj-fw-main">

    @if($page)

        @if(!empty($page->title))
            <div class="rj-fw-header">
                <h1 class="rj-fw-title">{{ $page->title }}</h1>
                @if(!empty($page->excerpt))
                    <p class="rj-fw-excerpt">{{ $page->excerpt }}</p>
                @endif
            </div>
        @endif

        @if($page->isBuilderMode() && $page->hasBlocks())
            <div class="rj-fw-content">
                {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
            </div>
        @elseif($page->content)
            <div class="rj-fw-content-text">
                {!! $page->content !!}
            </div>
        @endif

    @else
        <div class="rj-fw-empty">
            <h2>{{ __('Page not found') }}</h2>
            <p>{{ __('The page you are looking for does not exist or has been moved.') }}</p>
        </div>
    @endif

</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
