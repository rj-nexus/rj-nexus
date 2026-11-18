@extends('theme::layout')

@section('content')
<header class="rj-frontend-header">
    @php $headerTmpl = app(\App\Services\ThemeResolver::class)->header(); @endphp
    @if($headerTmpl)
        {!! rj_render_template($headerTmpl) !!}
    @endif
</header>

<main class="rj-frontend-main">
    <style>
        .rj-theme-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
            border: 1px solid var(--rj-border);
            border-radius: 24px;
            overflow: hidden;
            backdrop-filter: blur(12px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
        }
        .rj-theme-card:hover {
            border-color: rgba(167, 139, 250, 0.5);
            transform: translateY(-6px);
            box-shadow: 0 30px 60px -20px rgba(0,0,0,0.9), 0 0 30px -10px rgba(167, 139, 250, 0.3);
        }
        .rj-theme-img-wrap {
            width: 100%; height: 220px; overflow: hidden; position: relative;
            border-bottom: 1px solid var(--rj-border);
            background: var(--rj-surface);
        }
        .rj-theme-img {
            width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;
        }
        .rj-theme-card:hover .rj-theme-img { transform: scale(1.05); }
        
        .rj-glass-search {
            display: flex; align-items: center; background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 999px;
            padding: 4px 4px 4px 20px; transition: all 0.3s ease;
            box-shadow: 0 4px 20px -10px rgba(0,0,0,0.5);
        }
        .rj-glass-search:focus-within {
            border-color: rgba(167, 139, 250, 0.5); background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 20px -5px rgba(167, 139, 250, 0.3), inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .rj-glass-search input {
            background: transparent; border: none; color: var(--rj-text);
            font-size: 14px; width: 220px; outline: none;
        }
        .rj-glass-search input::placeholder { color: var(--rj-muted); opacity: 0.7; }
        .rj-glass-search button {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: #fff; border: none; border-radius: 999px;
            width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease;
        }
        .rj-btn-secondary {
            flex: 1; text-align: center; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: rgba(255,255,255,0.03); color: var(--rj-text); border: 1px solid var(--rj-border);
            text-decoration: none; transition: all 0.2s;
        }
        .rj-btn-secondary:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .rj-btn-primary {
            flex: 1; text-align: center; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; border: none;
            text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 15px -5px var(--rj-primary);
        }
        .rj-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>

    <div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; min-height: 100vh;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; flex-wrap: wrap; gap: 24px;">
            <div>
                <h1 style="font-size: 40px; font-weight: 800; color: var(--rj-text); margin: 0 0 12px 0; letter-spacing: -0.03em; background: linear-gradient(to right, #fff, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ __('Themes') }}
                </h1>
                <p style="font-size: 16px; color: var(--rj-muted); margin: 0;">{{ __('Beautiful themes for your RJ Nexus site.') }}</p>
            </div>

            <form action="{{ url(app()->getLocale() . '/themes') }}" method="GET" class="rj-glass-search">
                <input type="text" name="search" placeholder="{{ __('Search themes...') }}" value="{{ request('search') }}">
                <button type="submit">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 32px;">
            @forelse($themes as $theme)
                <div class="rj-theme-card">
                    <div class="rj-theme-img-wrap">
                        <!-- DÜZƏLİŞ: Yenidən logo istifadə olunur -->
                        <img src="{{ $theme['logo'] ?? '' }}" class="rj-theme-img" alt="">
                    </div>
                    <div style="padding: 28px; display: flex; flex-direction: column; flex-grow: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <h2 style="font-size: 22px; font-weight: 700; color: var(--rj-text); margin: 0; display: flex; align-items: center; gap: 8px;">
                                {{ $theme['name'] }}
                                @if($theme['verified'] ?? false)
                                    <svg style="width: 18px; height: 18px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                @endif
                            </h2>
                            <span style="font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 99px; background: rgba(167, 139, 250, 0.1); color: var(--rj-primary); border: 1px solid rgba(167, 139, 250, 0.2);">v{{ $theme['version'] }}</span>
                        </div>
                        <p style="font-size: 12px; color: var(--rj-muted); margin: 0 0 16px 0;">{{ __('By') }} {{ $theme['author'] }}</p>
                        
                        <p style="font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $theme['description'] }}
                        </p>
                        
                        <div style="display: flex; gap: 12px;">
                            <a href="{{ url(app()->getLocale() . '/themes/' . $theme['slug']) }}" class="rj-btn-secondary">{{ __('Details') }}</a>
                            @if($theme['release_available'] ?? false)
                                <a href="{{ $theme['zip_url'] }}" class="rj-btn-primary">{{ __('Download') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: var(--rj-surface); border-radius: 20px; border: 1px dashed var(--rj-border);">
                    <h3 style="font-size: 20px; font-weight: 600; color: var(--rj-text); margin: 0 0 8px 0;">{{ __('No themes found') }}</h3>
                    <p style="font-size: 14px; color: var(--rj-muted); margin: 0;">{{ __('Try adjusting your search criteria.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</main>

<footer class="rj-frontend-footer">
    @php $footerTmpl = app(\App\Services\ThemeResolver::class)->footer(); @endphp
    @if($footerTmpl)
        {!! rj_render_template($footerTmpl) !!}
    @endif
</footer>
@endsection