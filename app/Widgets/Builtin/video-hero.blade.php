@php
    $height = $settings['height'] ?? 'h-screen';
    $align = $settings['align'] ?? 'center';
    $alignClass = match($align) {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };

    $overlayColor = $settings['overlay_color'] ?? '#000000';
    $overlayOpacity = ($settings['overlay_opacity'] ?? 40) / 100;

    $titleColor = $settings['title_color'] ?? '#ffffff';
    $subtitleColor = $settings['subtitle_color'] ?? '#f3f4f6';

    $btnBg = $settings['btn_bg'] ?? '#ffffff';
    $btnText = $settings['btn_text_color'] ?? '#111827';
    $btnHoverBg = $settings['btn_hover_bg'] ?? '#f3f4f6';

    $fallbackImage = $settings['fallback_image'] ?? '';
    $uid = 'vhero_' . substr(md5(uniqid()), 0, 6);
@endphp

<style>
    #{{ $uid }} .rj-video-btn {
        background-color: {{ $btnBg }} !important;
        color: {{ $btnText }} !important;
        transition: all 0.3s ease;
    }
    #{{ $uid }} .rj-video-btn:hover {
        background-color: {{ $btnHoverBg }} !important;
    }
</style>

<section id="{{ $uid }}" class="relative w-full {{ $height }} bg-slate-900 overflow-hidden flex items-center justify-center">

    @if($finalVideoUrl)
        @if($isIframe)
            <iframe
                src="{{ $finalVideoUrl }}"
                class="absolute inset-0 w-full h-full object-cover pointer-events-none"
                frameborder="0"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else
            <video
                class="absolute inset-0 w-full h-full object-cover"
                autoplay
                muted
                loop
                playsinline
                @if($fallbackImage) poster="{{ $fallbackImage }}" @endif>
                <source src="{{ $finalVideoUrl }}" type="video/mp4">
            </video>
        @endif
    @else
        @if($fallbackImage)
            <img src="{{ $fallbackImage }}" class="absolute inset-0 w-full h-full object-cover" alt="Fallback">
        @else
            <div class="absolute inset-0 bg-slate-900"></div>
        @endif
    @endif

    <div class="absolute inset-0" style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }};"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 flex flex-col justify-center {{ $alignClass }}">
        @if(!empty($settings['title']))
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-6" style="color: {{ $titleColor }};">
                {{ $settings['title'] }}
            </h1>
        @endif

        @if(!empty($settings['subtitle']))
            <p class="text-lg md:text-xl lg:text-2xl max-w-2xl mb-10" style="color: {{ $subtitleColor }};">
                {{ $settings['subtitle'] }}
            </p>
        @endif

        @if(!empty($settings['btn_text']) && !empty($settings['btn_url']))
            <div>
                <a href="{{ $settings['btn_url'] }}" class="inline-flex items-center justify-center px-10 py-4 rounded-full font-bold text-sm tracking-widest uppercase rj-video-btn shadow-xl">
                    {{ $settings['btn_text'] }}
                </a>
            </div>
        @endif
    </div>
</section>
