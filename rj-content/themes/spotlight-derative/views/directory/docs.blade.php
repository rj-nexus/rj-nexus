@extends('theme::layout')

@section('content')
<header class="rj-frontend-header">
    @php $headerTmpl = app(\App\Services\ThemeResolver::class)->header(); @endphp
    @if($headerTmpl)
        {!! rj_render_template($headerTmpl) !!}
    @endif
</header>

<script src="https://cdn.jsdelivr.net/npm/fuse.js@7.0.0/dist/fuse.min.js"></script>
<script>
    function docsApp() {
        return {
            query: '',
            results: [],
            fuse: null,
            debugInfo: '',
            
            init() {
                const searchIndex = @json($searchIndex ?? []);
                if (window.rjDocsDebug) {
                    console.log('[Docs] searchIndex length:', Array.isArray(searchIndex) ? searchIndex.length : 'not array');
                }
                this.setupFuse(searchIndex, 0);
            },
            
            setupFuse(searchIndex, attempts) {
                if (typeof Fuse === 'undefined') {
                    if (attempts > 100) {
                        this.debugInfo = 'Fuse.js failed to load';
                        console.error('[Docs] Fuse.js not available after 10s');
                        return;
                    }
                    setTimeout(() => this.setupFuse(searchIndex, attempts + 1), 100);
                    return;
                }
                
                if (!Array.isArray(searchIndex) || searchIndex.length === 0) {
                    this.debugInfo = 'Search index is empty';
                    console.warn('[Docs] Search index empty or invalid');
                    return;
                }
                
                this.fuse = new Fuse(searchIndex, {
                    keys: ['title', 'content'],
                    threshold: 0.4,
                    distance: 100,
                    includeMatches: true,
                    minMatchCharLength: 2
                });
                console.log('[Docs] Fuse ready with', searchIndex.length, 'items');
            },
            
            searchDocs() {
                if (this.query.trim().length === 0) {
                    this.results = [];
                    return;
                }
                if (!this.fuse) {
                    this.results = [];
                    return;
                }
                this.results = this.fuse.search(this.query.trim()).slice(0, 10);
            }
        }
    }
</script>

<main class="rj-frontend-main" x-data="docsApp()">
    <style>
        .rj-docs-wrap { display: flex; gap: 40px; padding-top: 80px; padding-bottom: 100px; max-width: 1300px; margin: 0 auto; align-items: flex-start; }
        .rj-docs-sidebar { width: 300px; flex-shrink: 0; position: sticky; top: 100px; background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 24px; padding: 24px; backdrop-filter: blur(20px); }
        .rj-docs-main { flex-grow: 1; min-width: 0; background: linear-gradient(145deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 24px; padding: 48px; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8); }
        
        .rj-docs-search { position: relative; margin-bottom: 24px; }
        .rj-docs-search input { width: 100%; padding: 12px 16px 12px 40px; border-radius: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--rj-border); color: var(--rj-text); font-size: 14px; outline: none; transition: all 0.3s; }
        .rj-docs-search input:focus { border-color: var(--rj-primary); background: rgba(255,255,255,0.06); }
        .rj-docs-search svg { position: absolute; left: 14px; top: 13px; width: 16px; height: 16px; color: var(--rj-muted); }
        
        .rj-docs-menu { list-style: none; padding: 0; margin: 0; }
        .rj-docs-menu li { margin-bottom: 4px; }
        .rj-docs-menu a { display: block; padding: 10px 16px; border-radius: 10px; color: var(--rj-muted); text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border: 1px solid transparent; }
        .rj-docs-menu a:hover { color: var(--rj-text); background: rgba(255,255,255,0.03); }
        .rj-docs-menu a.active { color: var(--rj-primary); background: rgba(167, 139, 250, 0.1); border-color: rgba(167, 139, 250, 0.2); font-weight: 600; }
        
        .rj-markdown { color: var(--rj-muted); font-size: 16px; line-height: 1.8; }
        .rj-markdown h1 { font-size: 36px; font-weight: 800; color: #fff; margin-bottom: 24px; letter-spacing: -0.02em; }
        .rj-markdown h2 { font-size: 26px; font-weight: 700; color: #fff; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--rj-border); padding-bottom: 12px; }
        .rj-markdown h3 { font-size: 20px; font-weight: 600; color: #fff; margin-top: 32px; margin-bottom: 16px; }
        .rj-markdown p { margin-bottom: 20px; }
        .rj-markdown a { color: var(--rj-primary); text-decoration: none; font-weight: 500; }
        .rj-markdown a:hover { text-decoration: underline; }
        .rj-markdown ul, .rj-markdown ol { padding-left: 24px; margin-bottom: 20px; }
        .rj-markdown li { margin-bottom: 8px; }
        .rj-markdown code { background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 6px; font-family: monospace; color: var(--rj-secondary); font-size: 14px; }
        .rj-markdown pre { background: rgba(0,0,0,0.4); padding: 24px; border-radius: 16px; overflow-x: auto; border: 1px solid var(--rj-border); margin-bottom: 24px; }
        .rj-markdown pre code { background: transparent; padding: 0; color: #e5e7eb; }
        
        @media (max-width: 900px) {
            .rj-docs-wrap { flex-direction: column; padding-top: 40px; }
            .rj-docs-sidebar { width: 100%; position: relative; top: 0; }
            .rj-docs-main { padding: 30px 20px; }
        }
    </style>

    <div class="rj-docs-wrap">
        <aside class="rj-docs-sidebar">
            <div class="rj-docs-search">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="query" @input="searchDocs()" placeholder="{{ __('Search documentation...') }}">
            </div>

            <ul class="rj-docs-menu" x-show="query.length === 0">
                @foreach($menu as $item)
                    <li>
                        <a href="{{ url(app()->getLocale() . '/docs/' . $item['slug']) }}" 
                           class="{{ $slug === $item['slug'] ? 'active' : '' }}">
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <ul class="rj-docs-menu" x-show="query.length > 0" x-cloak>
                <template x-for="res in results" :key="res.item.slug">
                    <li>
                        <a :href="'{{ url(app()->getLocale() . '/docs') }}/' + res.item.slug">
                            <span x-text="res.item.title"></span>
                        </a>
                    </li>
                </template>
                <li x-show="results.length === 0 && query.length > 0">
                    <span style="color: var(--rj-muted); font-size: 14px; font-style: italic; padding: 10px 16px; display: block;">
                        {{ __('No results found') }}
                    </span>
                </li>
            </ul>
        </aside>

        <main class="rj-docs-main">
            @if($contentHtml)
                <div class="rj-markdown">
                    {!! $contentHtml !!}
                </div>
            @else
                <div style="text-align: center; padding: 40px;">
                    <h1 style="color: #ef4444; font-size: 32px;">{{ __('404 - Document Not Found') }}</h1>
                    <p style="color: var(--rj-muted); margin-top: 16px;">{{ __('The requested documentation page could not be found or is unavailable.') }}</p>
                    <a href="{{ url(app()->getLocale() . '/docs') }}" style="display: inline-block; margin-top: 24px; padding: 12px 24px; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; border-radius: 12px; text-decoration: none; font-weight: 600;">
                        {{ __('Back to Docs') }}
                    </a>
                </div>
            @endif
        </main>
    </div>
</main>

<footer class="rj-frontend-footer">
    @php $footerTmpl = app(\App\Services\ThemeResolver::class)->footer(); @endphp
    @if($footerTmpl)
        {!! rj_render_template($footerTmpl) !!}
    @endif
</footer>
@endsection