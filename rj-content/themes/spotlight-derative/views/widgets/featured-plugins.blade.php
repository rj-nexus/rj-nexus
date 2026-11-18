<section style="padding: 60px 0; background: var(--rj-bg);">
    <div class="rj-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <h2 style="font-size: 28px; font-weight: 700; color: var(--rj-text); margin: 0;">{{ $settings['title'] ?? __('Featured Plugins') }}</h2>
            <a href="/plugins" style="font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none;">Bütün plaqinlər &rarr;</a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
            @foreach($plugins as $plugin)
                <div style="background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 16px; padding: 24px; display: flex; flex-direction: column;">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                        <img src="{{ $plugin['logo'] ?? '' }}" style="width: 48px; height: 48px; border-radius: 8px; background: #1f2937; object-fit: cover;" alt="">
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: var(--rj-text); margin: 0 0 4px 0;">{{ $plugin['name'] }}</h3>
                            <p style="font-size: 12px; color: var(--rj-muted); margin: 0;">v{{ $plugin['version'] }}</p>
                        </div>
                    </div>
                    <p style="font-size: 14px; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $plugin['description'] }}</p>
                    <div style="display: flex; gap: 8px;">
                        <a href="/plugins/{{ $plugin['slug'] }}" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; background: rgba(255,255,255,0.05); color: var(--rj-text); border: 1px solid var(--rj-border); text-decoration: none;">Ətraflı</a>
                        @if($plugin['release_available'])
                            <a href="{{ $plugin['zip_url'] }}" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; background: var(--rj-primary); color: #fff; text-decoration: none;">Yüklə</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>