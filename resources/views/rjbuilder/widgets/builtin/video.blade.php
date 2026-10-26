@php
    $source = $settings['source'] ?? 'youtube';
    $url = $settings['video_url'] ?? '';
    $videoFile = $settings['video_file'] ?? '';
    $poster = $settings['poster_image'] ?? '';
    $behavior = $settings['behavior'] ?? 'static';
    $aspect = $settings['aspect_ratio'] ?? 'aspect-video';
    $radius = $settings['border_radius'] ?? 'rounded-2xl';
    $playBg = $settings['play_btn_bg'] ?? '#8b5cf6';
    $playColor = $settings['play_btn_color'] ?? '#ffffff';
    $loop = $settings['loop'] ?? false;
    $mute = $settings['mute'] ?? false;
    $controls = $settings['show_controls'] ?? true;

    $embedUrl = '';
    $ytId = '';

    if ($source === 'youtube') {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match);
        $ytId = $match[1] ?? '';
        $embedUrl = 'https://www.youtube.com/embed/' . $ytId;
    } elseif ($source === 'vimeo') {
        preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $url, $match);
        $vimeoId = $match[1] ?? '';
        $embedUrl = 'https://player.vimeo.com/video/' . $vimeoId;
    } elseif ($source === 'dailymotion') {
        preg_match('/dailymotion\.com\/video\/([a-z0-9]+)/i', $url, $match);
        $dmId = $match[1] ?? '';
        $embedUrl = 'https://www.dailymotion.com/embed/video/' . $dmId;
    }

    if (empty($poster) && $source === 'youtube' && $ytId) {
        $poster = 'https://img.youtube.com/vi/' . $ytId . '/maxresdefault.jpg';
    }

    if ($source === 'self_hosted' && empty($videoFile)) {
        return '<div class="p-8 text-center text-red-500 bg-red-50 rounded-xl">' . __('Please upload a video file.') . '</div>';
    }
    if ($source !== 'self_hosted' && empty($embedUrl)) {
        return '<div class="p-8 text-center text-red-500 bg-red-50 rounded-xl">' . __('Invalid video URL. Please check the link.') . '</div>';
    }
@endphp

<div id="{{ $uid }}" class="w-full relative group" data-behavior="{{ $behavior }}" data-source="{{ $source }}" data-url="{{ $embedUrl }}" data-file="{{ $videoFile }}" data-mute="{{ $mute ? 1 : 0 }}" data-loop="{{ $loop ? 1 : 0 }}" data-controls="{{ $controls ? 1 : 0 }}">
    <div class="relative w-full {{ $aspect }} {{ $radius }} overflow-hidden bg-slate-900 shadow-sm">

        @if($behavior !== 'autoplay')
            <div class="rj-facade absolute inset-0 z-20 flex items-center justify-center cursor-pointer transition-opacity duration-300 group">
                @if($poster)
                    <img src="{{ $poster }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 bg-slate-800"></div>
                @endif
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors"></div>
                <button type="button" class="relative z-30 w-16 h-16 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300" style="background-color: {{ $playBg }}; color: {{ $playColor }};">
                    <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>
        @endif

        <div class="rj-video-container absolute inset-0 z-10 w-full h-full {{ $behavior === 'autoplay' ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
            @if($behavior === 'autoplay')
                @if($source === 'self_hosted')
                    <video src="{{ $videoFile }}" class="w-full h-full object-cover" autoplay muted loop playsinline {{ $controls ? 'controls' : '' }}></video>
                @else
                    <iframe src="{{ $embedUrl }}?autoplay=1&mute=1&{{ $loop ? 'loop=1&' : '' }}{{ $controls ? 'controls=1' : 'controls=0' }}" class="w-full h-full border-0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                @endif
            @endif
        </div>

    </div>
</div>

<script>
(function() {
    function initVideo_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.ready) return;
        root.dataset.ready = '1';

        const facade = root.querySelector('.rj-facade');
        const container = root.querySelector('.rj-video-container');
        const behavior = root.dataset.behavior;
        const source = root.dataset.source;
        const embedUrl = root.dataset.url;
        const videoFile = root.dataset.file;
        const mute = root.dataset.mute === '1';
        const loop = root.dataset.loop === '1';
        const controls = root.dataset.controls === '1';

        if (behavior === 'autoplay') return;

        function play() {
            if (facade) facade.classList.add('opacity-0', 'pointer-events-none');
            container.classList.remove('opacity-0', 'pointer-events-none');

            if (!container.dataset.loaded) {
                let html = '';
                if (source === 'self_hosted') {
                    html = `<video src="${videoFile}" class="w-full h-full object-cover" autoplay ${mute ? 'muted' : ''} ${loop ? 'loop' : ''} ${controls ? 'controls' : ''} playsinline></video>`;
                } else {
                    let params = `autoplay=1&${mute ? 'mute=1&' : ''}${loop ? 'loop=1&' : ''}${controls ? 'controls=1' : 'controls=0'}`;
                    html = `<iframe src="${embedUrl}?${params}" class="w-full h-full border-0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
                }
                container.innerHTML = html;
                container.dataset.loaded = 'true';
            } else {
                const vid = container.querySelector('video');
                if (vid) vid.play();
            }
        }

        function pause() {
            if (facade) facade.classList.remove('opacity-0', 'pointer-events-none');
            container.classList.add('opacity-0', 'pointer-events-none');

            const vid = container.querySelector('video');
            if (vid) {
                vid.pause();
            } else {
                container.innerHTML = '';
                container.dataset.loaded = 'false';
            }
        }

        if (behavior === 'static' && facade) {
            facade.addEventListener('click', play);
        } else if (behavior === 'hover') {
            root.addEventListener('mouseenter', play);
            root.addEventListener('mouseleave', pause);
        }
    }

    initVideo_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVideo_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
