@php
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $height = $settings['height'] ?? 'aspect-video';
    $borderRadius = $settings['border_radius'] ?? 'rounded-3xl';
    $boxShadow = $settings['box_shadow'] ?? 'shadow-xl';
    $hoverEffect = $settings['hover_effect'] ?? true;
    $overlayColor = $settings['overlay_color'] ?? '';

    $borderStyle = $overlayColor ? "border: 4px solid {$overlayColor};" : '';
@endphp

<section id="{{ $uid }}" class="w-full py-16 px-4 bg-slate-50/50">
    <div class="max-w-6xl mx-auto">

        @if($title || $subtitle)
            <div class="text-center mb-12">
                @if($subtitle)
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">
                        {{ $subtitle }}
                    </p>
                @endif
                @if($title)
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                        {{ $title }}
                    </h2>
                @endif
            </div>
        @endif

        <div class="relative w-full {{ $height }} {{ $borderRadius }} {{ $boxShadow }} overflow-hidden group bg-slate-200" style="{{ $borderStyle }}">
            <div class="absolute inset-0 w-full h-full {{ $hoverEffect ? 'transition-transform duration-700 ease-out group-hover:scale-105' : '' }}">
                <iframe
                    src="{{ $iframeUrl }}"
                    class="w-full h-full border-0"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="absolute inset-0 pointer-events-none ring-1 ring-inset ring-black/10 {{ $borderRadius }}"></div>
        </div>

    </div>
</section>
