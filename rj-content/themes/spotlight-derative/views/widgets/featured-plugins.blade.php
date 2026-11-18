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

    /* GLASSMORPHISM AXTARIŞ QUTUSU */
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
        font-size: 14px; width: 200px; outline: none;
    }
    .rj-glass-search input::placeholder { color: var(--rj-muted); opacity: 0.7; }
    .rj-glass-search button {
        background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
        color: #fff; border: none; border-radius: 999px;
        width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px -3px var(--rj-primary);
    }
    .rj-glass-search button:hover { transform: scale(1.05); box-shadow: 0 6px 16px -3px var(--rj-primary); }
</style>

<section style="padding: 80px 0; background: var(--rj-bg); position: relative;">
    <div class="rj-container">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <h2 style="font-size: 32px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">
                {{ $settings['title'] ?? __('Featured Plugins') }}
            </h2>
            
            <!-- Axtarış Formu (Dil dəstəyi ilə) -->
            <form action="{{ url(app()->getLocale() . '/plugins') }}" method="GET" class="rj-glass-search">
                <input type="text" name="search" placeholder="{{ __('Search plugins...') }}" value="{{ request('search') }}">
                <button type="submit">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
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
                            <!-- Details Linki (Dil dəstəyi ilə) -->
                            <a href="{{ url(app()->getLocale() . '/plugins/' . $plugin['slug']) }}" class="rj-btn-secondary">{{ __('Details') }}</a>
                            
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