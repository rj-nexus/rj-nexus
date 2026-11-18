<style>
    .rj-theme-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--rj-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .rj-theme-card:hover {
        border-color: rgba(167, 139, 250, 0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8), 0 0 20px -5px rgba(167, 139, 250, 0.2);
    }
    .rj-theme-img {
        width: 100%; height: 200px; object-fit: cover; background: var(--rj-surface);
        border-bottom: 1px solid var(--rj-border);
    }
</style>

<section style="padding: 80px 0; background: var(--rj-bg);">
    <div class="rj-container">
        
        <!-- Başlıq və Axtarış Hissəsi -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <h2 style="font-size: 32px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">
                {{ $settings['title'] ?? __('Featured Themes') }}
            </h2>
            
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <form action="/themes" method="GET" class="rj-widget-search">
                    <input type="text" name="search" placeholder="{{ __('Search themes...') }}" value="{{ request('search') }}">
                    <button type="submit">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <a href="/themes" style="font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none; display: flex; align-items: center; gap: 6px; white-space: nowrap;">
                    {{ __('View all themes') }} <span>&rarr;</span>
                </a>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            @foreach($themes as $theme)
                <div class="rj-theme-card">
                    <img src="{{ $theme['logo'] ?? '' }}" class="rj-theme-img" alt="">
                    <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
                        <h3 style="font-size: 20px; font-weight: 700; color: var(--rj-text); margin: 0 0 8px 0;">{{ $theme['name'] }}</h3>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $theme['description'] }}
                        </p>
                        <a href="/themes/{{ $theme['slug'] }}" class="rj-btn-secondary" style="display: block; width: 100%;">{{ __('View Theme') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>