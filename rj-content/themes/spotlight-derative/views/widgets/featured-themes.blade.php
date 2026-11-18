<section class="py-16" style="background: var(--rj-bg);">
    <div class="rj-container">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-3xl font-bold" style="color: var(--rj-text);">{{ $settings['title'] ?? __('Featured Themes') }}</h2>
            <a href="/themes" class="text-sm font-semibold hover:underline" style="color: var(--rj-primary);">Bütün temalar &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($themes as $theme)
                <div class="rounded-2xl overflow-hidden border" style="background: var(--rj-surface); border-color: var(--rj-border);">
                    <img src="{{ $theme['logo'] ?? '' }}" class="w-full h-48 object-cover bg-gray-800" alt="">
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2" style="color: var(--rj-text);">{{ $theme['name'] }}</h3>
                        <p class="text-sm line-clamp-2 mb-4" style="color: var(--rj-muted);">{{ $theme['description'] }}</p>
                        <a href="/themes/{{ $theme['slug'] }}" class="block text-center py-2 rounded-lg text-sm font-medium" style="background: rgba(255,255,255,0.05); color: var(--rj-text); border: 1px solid var(--rj-border);">Temaya bax</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>