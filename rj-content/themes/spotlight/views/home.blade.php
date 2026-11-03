@extends('theme::layout')

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
        <div class="rj-container" style="padding-top:120px;padding-bottom:120px;text-align:center;">
            <h1 style="font-size:clamp(32px, 5vw, 48px);font-weight:800;margin-bottom:16px;">{{ rj_get_option('site_name', config('app.name')) }}</h1>
            <p style="font-size:18px;color:var(--rj-muted);margin-bottom:32px;">{{ __('Welcome to your new site. Create a builder page or set a front page to get started.') }}</p>
            <a href="{{ url('/admin') }}" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:var(--rj-radius);color:var(--rj-bg);text-decoration:none;font-weight:600;background:linear-gradient(135deg,var(--rj-primary),var(--rj-secondary));">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('Go to Admin') }}
            </a>
        </div>
    @endif
</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
