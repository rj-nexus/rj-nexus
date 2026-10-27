@php
    $text     = trim((string) ($settings['text'] ?? ''));
    $text     = $text !== '' ? $text : 'CREATIVE';
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $rawUrl   = trim((string) ($settings['video_url'] ?? ''));
    $poster   = trim((string) ($settings['poster'] ?? ''));
    $weight   = in_array((string) ($settings['font_weight'] ?? '900'), ['700', '800', '900'], true)
                    ? (string) $settings['font_weight'] : '900';
    $align    = in_array($settings['align'] ?? 'center', ['left', 'center', 'right'], true)
                    ? $settings['align'] : 'center';
    $hoverOn   = !empty($settings['hover_accent'] ?? true);
    $overlayOn = !empty($settings['overlay'] ?? false);
    $paddingY  = max(0, min(200, (int) ($settings['padding_y'] ?? 60)));

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $fallbackColor = $hexOk($settings['fallback_color'] ?? '', '#0f172a');
    $hoverColor    = $hexOk($settings['hover_color'] ?? '', '#8b5cf6');
    $overlayColor  = $hexOk($settings['overlay_color'] ?? '', '#8b5cf6');
    $subtitleColor = $hexOk($settings['subtitle_color'] ?? '', '#64748b');

    $mediaType = '';
    $mediaSrc  = '';
    $mediaMime = '';

    if ($rawUrl !== '' && preg_match('#^https?://#i', $rawUrl)) {
        $path  = (string) (parse_url($rawUrl, PHP_URL_PATH) ?? '');
        $query = (string) (parse_url($rawUrl, PHP_URL_QUERY) ?? '');
        $host  = strtolower((string) (parse_url($rawUrl, PHP_URL_HOST) ?? ''));
        $host  = preg_replace('/^(www|m)\./', '', $host);

        if (preg_match('/\.(mp4|webm|ogg)$/i', $path, $ext)) {
            $mediaType = 'video';
            $mediaSrc  = $rawUrl;
            $mediaMime = ['mp4' => 'video/mp4', 'webm' => 'video/webm', 'ogg' => 'video/ogg'][strtolower($ext[1])];
        } elseif (in_array($host, ['youtube.com', 'youtu.be', 'youtube-nocookie.com'], true)) {
            $id = null;
            if ($host === 'youtu.be') {
                $id = trim($path, '/');
            } else {
                parse_str($query, $q);
                if (!empty($q['v'])) {
                    $id = (string) $q['v'];
                } elseif (preg_match('#^/(embed|shorts|live)/([^/?]+)#', $path, $m)) {
                    $id = $m[2];
                }
            }
            if ($id && preg_match('/^[A-Za-z0-9_-]{6,20}$/', $id)) {
                $mediaType = 'iframe';
                $mediaSrc  = 'https://www.youtube-nocookie.com/embed/' . $id
                    . '?autoplay=1&mute=1&loop=1&playlist=' . $id
                    . '&controls=0&playsinline=1&rel=0&modestbranding=1&iv_load_policy=3&disablekb=1&fs=0';
            }
        } elseif ($host === 'vimeo.com' || $host === 'player.vimeo.com') {
            if (preg_match('#/(\d+)#', $path, $m)) {
                $mediaType = 'iframe';
                $mediaSrc  = 'https://player.vimeo.com/video/' . $m[1] . '?background=1&autoplay=1&loop=1&muted=1';
            }
        } else {
            $mediaType = 'iframe';
            $mediaSrc  = $rawUrl;
        }
    }

    $x      = match ($align) { 'left' => 40, 'right' => 1160, default => 600 };
    $anchor = match ($align) { 'left' => 'start', 'right' => 'end', default => 'middle' };
    $safe   = htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $svg    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 240">'
            . '<text x="' . $x . '" y="185" text-anchor="' . $anchor . '"'
            . ' font-family="Arial Black, Helvetica Neue, Arial, sans-serif"'
            . ' font-weight="' . $weight . '" font-size="200"'
            . ' textLength="1120" lengthAdjust="spacingAndGlyphs" fill="#000">'
            . $safe . '</text></svg>';
    $maskUrl = 'data:image/svg+xml;base64,' . base64_encode($svg);
@endphp

<style>
    #{{ $uid }} {
        --vmt-mask: url("{{ $maskUrl }}");
        --vmt-fallback: {{ $fallbackColor }};
        --vmt-hover: {{ $hoverColor }};
        --vmt-overlay: {{ $overlayColor }};
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .vmt-stage {
        position: relative;
        width: 100%;
        max-width: 1200px;
        aspect-ratio: 1200 / 240;
        margin: 0 auto;
        filter: drop-shadow(0 6px 14px rgba(15, 23, 42, .22));
    }

    #{{ $uid }} .vmt-mask {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
        -webkit-mask-image: var(--vmt-mask);
        mask-image: var(--vmt-mask);
        -webkit-mask-size: 100% 100%;
        mask-size: 100% 100%;
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-position: center;
        mask-position: center;
    }

    #{{ $uid }} .vmt-base {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, var(--vmt-hover), var(--vmt-fallback) 50%, var(--vmt-hover));
    }

    #{{ $uid }} .vmt-media {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }
    #{{ $uid }} .vmt-video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        pointer-events: none;
        filter: brightness(1.25) contrast(1.1) saturate(1.2);
    }
    #{{ $uid }} .vmt-video::-webkit-media-controls,
    #{{ $uid }} .vmt-video::-webkit-media-controls-enclosure,
    #{{ $uid }} .vmt-video::-webkit-media-controls-overlay-play-button,
    #{{ $uid }} .vmt-video::-webkit-media-controls-start-playback-button {
        display: none !important;
        -webkit-appearance: none;
    }
    #{{ $uid }} .vmt-iframe {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 100%;
        height: 100%;
        min-width: 177.78%;
        min-height: 100%;
        transform: translate(-50%, -50%);
        border: 0;
        pointer-events: none;
    }

    #{{ $uid }} .vmt-tint {
        position: absolute;
        inset: 0;
        background: var(--vmt-overlay);
        opacity: .35;
        mix-blend-mode: overlay;
        pointer-events: none;
    }

    #{{ $uid }} .vmt-hover {
        position: absolute;
        inset: 0;
        background: var(--vmt-hover);
        opacity: 0;
        transition: opacity .35s ease;
    }
    @media (hover: hover) {
        #{{ $uid }} .vmt-stage:hover .vmt-hover { opacity: 1; }
    }

    #{{ $uid }} .vmt-sr {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        white-space: nowrap;
        margin: -1px;
        padding: 0;
        border: 0;
    }

    #{{ $uid }} .vmt-subtitle {
        margin: 20px auto 0;
        max-width: 720px;
        text-align: {{ $align }};
        font-size: clamp(14px, 1.4vw, 18px);
        font-weight: 500;
        line-height: 1.6;
        color: {{ $subtitleColor }};
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .vmt-hover { transition: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="vmt-stage">
        <h2 class="vmt-sr">{{ $text }}</h2>

        <div class="vmt-mask" aria-hidden="true">
            <div class="vmt-base"></div>

            @if($mediaType === 'video')
                <div class="vmt-media">
                    <video class="vmt-video"
                           muted
                           loop
                           playsinline
                           autoplay
                           disablePictureInPicture
                           controlsList="nodownload nofullscreen noremoteplayback"
                           preload="auto"
                           @if($poster !== '') poster="{{ $poster }}" @endif>
                        <source src="{{ $mediaSrc }}" type="{{ $mediaMime }}">
                    </video>
                </div>
            @elseif($mediaType === 'iframe')
                <div class="vmt-media">
                    <iframe class="vmt-iframe"
                            src="{{ $mediaSrc }}"
                            title=""
                            tabindex="-1"
                            allow="autoplay; encrypted-media"
                            referrerpolicy="strict-origin-when-cross-origin"
                            loading="lazy"></iframe>
                </div>
            @endif

            @if($mediaType !== '' && $overlayOn)
                <span class="vmt-tint"></span>
            @endif

            @if($hoverOn)
                <span class="vmt-hover"></span>
            @endif
        </div>
    </div>

    @if($subtitle !== '')
        <p class="vmt-subtitle">{{ $subtitle }}</p>
    @endif
</div>

@if($mediaType === 'video')
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var video = root.querySelector('video');
    if (!video) return;

    video.controls = false;

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) { video.pause(); return; }

    function play() {
        var p = video.play();
        if (p && p.catch) p.catch(function () {});
    }

    function restart() {
        try { video.currentTime = 0; } catch (e) {}
        play();
    }

    if (video.readyState >= 2) restart();
    else video.addEventListener('loadeddata', restart, { once: true });

    video.addEventListener('ended', restart);

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) play();
                else video.pause();
            });
        }, { threshold: 0.1 });
        io.observe(root);
    }
})();
</script>
@endif
