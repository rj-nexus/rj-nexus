<style>
    .rj-plugin-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--rj-border);
        border-radius: 20px;
        overflow: hidden;
        backdrop-filter: blur(12px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .rj-plugin-card:hover {
        border-color: rgba(167, 139, 250, 0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8), 0 0 20px -5px rgba(167, 139, 250, 0.2);
    }
    .rj-plugin-img {
        width: 100%; height: 200px; object-fit: cover; display: block;
        background: var(--rj-surface);
        border-bottom: 1px solid var(--rj-border);
    }
    .rj-btn-secondary {
        flex: 1; text-align: center; padding: 10px; border-radius: 10px; font-size: 14px; font-weight: 600;
        background: rgba(255,255,255,0.03); color: var(--rj-text); border: 1px solid var(--rj-border);
        text-decoration: none; transition: all 0.2s;
    }
    .rj-btn-secondary:hover { background: rgba(255,255,255,0.08); color: #fff; }

    .rj-btn-primary {
        flex: 1; text-align: center; padding: 10px; border-radius: 10px; font-size: 14px; font-weight: 600;
        background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; border: none;
        text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 15px -5px var(--rj-primary);
    }
    .rj-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

    /* AXTARIŞ QUTUSU ÜÇÜN STİL */
    .rj-widget-search {
        display: flex; gap: 8px; width: 100%; max-width: 320px; position: relative;
    }
    .rj-widget-search input {
        width: 100%; padding: 10px 16px; border-radius: 10px; font-size: 14px;
        background: rgba(255,255,255,0.03); border: 1px solid var(--rj-border); color: var(--rj-text);
        outline: none; transition: all 0.3s;
    }
    .rj-widget-search input:focus {
        border-color: var(--rj-primary); background: rgba(255,255,255,0.05);
        box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.15);
    }
    .rj-widget-search button {
        padding: 10px 16px; border-radius: 10px; background: var(--rj-primary); color: #fff;
        border: none; cursor: pointer; font-weight: 600; transition: all 0.2s;
    }
    .rj-widget-search button:hover { opacity: 0.9; }
</style>

<section style="padding: 80px 0; background: var(--rj-bg); position: relative;">
    <div class="rj-container">
        
        <!-- Başlıq və Axtarış Hissəsi -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <h2 style="font-size: 32px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">
                {{ $settings['title'] ?? __('Featured Plugins') }}
            </h2>
            
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <!-- Axtarış Formu -->
                <form action="/plugins" method="GET" class="rj-widget-search">
                    <input type="text" name="search" placeholder="{{ __('Search plugins...') }}" value="{{ request('search') }}">
                    <button type="submit">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <a href="/plugins" style="font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none; display: flex; align-items: center; gap: 6px; white-space: nowrap;">
                    {{ __('View all plugins') }} <span>&rarr;</span>
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            @foreach($plugins as $plugin)
                <div class="rj-plugin-card">
                    <img src="{{ $plugin['logo'] ?? '' }}" class="rj-plugin-img" alt="">
                    <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
                        <h3 style="font-size: 20px; font-weight: 700; color: var(--rj-text); margin: 0 0 4px 0;">{{ $plugin['name'] }}</h3>
                        <p style="font-size: 12px; color: var(--rj-muted); margin: 0 0 12px 0;">v{{ $plugin['version'] }} &bull; {{ $plugin['author'] }}</p>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $plugin['description'] }}
                        </p>
                        <div style="display: flex; gap: 12px;">
                            <a href="/plugins/{{ $plugin['slug'] }}" class="rj-btn-secondary">{{ __('Details') }}</a>
                            @if($plugin['release_available'])
                                <a href="{{ $plugin['zip_url'] }}" class="rj-btn-primary">{{ __('Download') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>