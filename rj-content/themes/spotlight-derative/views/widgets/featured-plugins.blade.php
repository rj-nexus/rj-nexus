<section class="py-16" style="background: var(--rj-bg);">
    <div class="rj-container">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-3xl font-bold" style="color: var(--rj-text);">{{ $settings['title'] ?? __('Featured Plugins') }}</h2>
            <a href="/plugins" class="text-sm font-semibold hover:underline" style="color: var(--rj-primary);">Bütün plaqinlər &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plugins as $plugin)
                <div class="rounded-2xl p-6 border transition-transform hover:-translate-y-1" style="background: var(--rj-surface); border-color: var(--rj-border);">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $plugin['logo'] ?? '' }}" class="w-12 h-12 rounded-lg bg-gray-800 object-cover" alt="">
                        <div>
                            <h3 class="font-bold" style="color: var(--rj-text);">{{ $plugin['name'] }}</h3>
                            <p class="text-xs" style="color: var(--rj-muted);">v{{ $plugin['version'] }}</p>
                        </div>
                    </div>
                    <p class="text-sm line-clamp-2 mb-6" style="color: var(--rj-muted);">{{ $plugin['description'] }}</p>
                    <div class="flex gap-2">
                        <a href="/plugins/{{ $plugin['slug'] }}" class="flex-1 text-center py-2 rounded-lg text-sm font-medium transition" style="background: rgba(255,255,255,0.05); color: var(--rj-text); border: 1px solid var(--rj-border);">Ətraflı</a>
                        <a href="{{ $plugin['zip_url'] }}" class="flex-1 text-center py-2 rounded-lg text-sm font-medium text-white transition" style="background: var(--rj-primary);">Yüklə</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>