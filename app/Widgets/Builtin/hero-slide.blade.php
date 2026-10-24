@php
    $bgUrl = $settings['image'] ?? '';
    $height = $settings['height'] ?? 'min-h-[70vh]';
    $overlayColor = $settings['overlay_color'] ?? '#000000';
    $overlayOpacity = ($settings['overlay_opacity'] ?? 40) / 100;

    $titleColor = $settings['title_color'] ?? '#ffffff';
    $subtitleColor = $settings['subtitle_color'] ?? '#f3f4f6';

    $btnBg = $settings['btn_bg'] ?? '#111827';
    $btnText = $settings['btn_text_color'] ?? '#ffffff';
    $btnHoverBg = $settings['btn_hover_bg'] ?? '#374151';
    $btnHoverText = $settings['btn_hover_text_color'] ?? '#ffffff';

    $uid = 'hero_' . substr(md5(uniqid()), 0, 6);
@endphp

<style>
    #{{ $uid }} .rj-hero-btn {
        background-color: {{ $btnBg }} !important;
        color: {{ $btnText }} !important;
        transition: all 0.3s ease;
    }
    #{{ $uid }} .rj-hero-btn:hover {
        background-color: {{ $btnHoverBg }} !important;
        color: {{ $btnHoverText }} !important;
    }
</style>

<section id="{{ $uid }}" class="relative w-full flex items-center justify-center {{ $height }} bg-gray-900 overflow-hidden">
    @if($bgUrl)
        <img src="{{ $bgUrl }}" class="absolute inset-0 w-full h-full object-cover object-center" alt="{{ $settings['title'] ?? '' }}">
    @endif

    <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto space-y-6">
        @if(!empty($settings['title']))
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight" style="color: {{ $titleColor }};">
                {{ $settings['title'] }}
            </h1>
        @endif

        @if(!empty($settings['subtitle']))
            <p class="text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed" style="color: {{ $subtitleColor }};">
                {{ $settings['subtitle'] }}
            </p>
        @endif

        @if(!empty($settings['btn_text']) && !empty($settings['btn_url']))
            <div class="pt-6">
                <a href="{{ $settings['btn_url'] }}" class="inline-block px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase rj-hero-btn shadow-xl">
                    {{ $settings['btn_text'] }}
                </a>
            </div>
        @endif
    </div>
</section>
