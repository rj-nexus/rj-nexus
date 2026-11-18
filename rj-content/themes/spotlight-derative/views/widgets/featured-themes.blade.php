<section style="padding: 60px 0; background: var(--rj-bg);">
    <div class="rj-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <h2 style="font-size: 28px; font-weight: 700; color: var(--rj-text); margin: 0;">{{ $settings['title'] ?? __('Featured Themes') }}</h2>
            <a href="/themes" style="font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none;">Bütün temalar &rarr;</a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
            @foreach($themes as $theme)
                <div style="background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 16px; overflow: hidden;">
                    <img src="{{ $theme['logo'] ?? '' }}" style="width: 100%; height: 180px; object-fit: cover; background: #1f2937;" alt="">
                    <div style="padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--rj-text); margin: 0 0 8px 0;">{{ $theme['name'] }}</h3>
                        <p style="font-size: 14px; color: var(--rj-muted); margin: 0 0 16px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $theme['description'] }}</p>
                        <a href="/themes/{{ $theme['slug'] }}" style="display: block; text-align: center; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; background: rgba(255,255,255,0.05); color: var(--rj-text); border: 1px solid var(--rj-border); text-decoration: none;">Temaya bax</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>