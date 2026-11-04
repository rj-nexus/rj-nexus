@php
    $uid = 'hero_' . substr(md5(uniqid('', true)), 0, 8);

    // ---- Media resolver -------------------------------------------------
    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $bgVideo = $resolve($settings['bg_video_url'] ?? '', $settings['bg_video'] ?? '')
        ?: 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgImage = $resolve($settings['bg_image_url'] ?? '', $settings['bg_image'] ?? '');

    // ---- Settings -------------------------------------------------------
    $tintColor    = !empty($settings['tint_color']) ? $settings['tint_color'] : '#3f6fbe';
    $tintStrength = max(0, min(100, (int) ($settings['tint_strength'] ?? 100)));
    $overlay      = max(0, min(100, (int) ($settings['overlay_opacity'] ?? 35)));
    $showHud      = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $interval     = max(2, (int) ($settings['interval'] ?? 5)) * 1000;

    $badge    = $settings['badge_text'] ?? '';
    $hudLeft  = $settings['hud_left'] ?? '[ 01 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ HERO ]';

    // ---- Rotating texts: one per line "Title | Subtitle" -----------------
    $slides = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['texts'] ?? '')) as $line) {
        $line = trim($line);
        if ($line === '') continue;
        [$t, $s] = array_pad(explode('|', $line, 2), 2, '');
        $slides[] = ['title' => trim($t), 'sub' => trim($s)];
    }
    if (!$slides) {
        $slides[] = [
            'title' => $settings['title'] ?? 'Create Smarter. Launch Faster.',
            'sub'   => $settings['subtitle'] ?? '',
        ];
    }

    // Split a title into animated words; "✦" becomes an inline sparkle icon
    $sparkle = '<svg class="rj-sp" viewBox="0 0 24 24" aria-hidden="true"><path fill="#fff" d="M12 0c.6 6.6 5.4 11.4 12 12-6.6.6-11.4 5.4-12 12-.6-6.6-5.4-11.4-12-12C6.6 11.4 11.4 6.6 12 0z"/></svg>';
    $words = function ($text) use ($sparkle) {
        $i = 0; $out = '';
        foreach (preg_split('/\s+/u', trim($text)) as $w) {
            if ($w === '') continue;
            $inner = $w === '✦' ? $sparkle : e($w);
            $out .= '<span class="w" style="--i:' . $i++ . '"><span>' . $inner . '</span></span> ';
        }
        return $out;
    };
@endphp

<section class="rj-hero" id="{{ $uid }}">
    <div class="rj-bg">
        @if($bgVideo)
            <video id="{{ $uid }}_v" class="rj-media" src="{{ $bgVideo }}" autoplay loop muted playsinline preload="auto"
                   @if($bgImage) poster="{{ $bgImage }}" @endif></video>
        @elseif($bgImage)
            <img class="rj-media" src="{{ $bgImage }}" alt="">
        @endif
        {{-- Everything below forces ANY video into a blue monochrome look --}}
        <div class="rj-tint" style="background: {{ $tintColor }}; opacity: {{ $tintStrength / 100 }};"></div>
        <div class="rj-depth"></div>
        <div class="rj-dim" style="opacity: {{ $overlay / 100 }};"></div>
        <div class="rj-vignette"></div>
        <div class="rj-dots"></div>
    </div>

    <span class="rj-line rj-l1"></span>
    <span class="rj-line rj-l2"><i></i><i></i></span>

    @if($showHud)
        <div class="rj-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    {{-- FIXED top text --}}
    @if($badge)
        <div class="rj-badge">
            <span class="rj-bars"><i></i><i></i><i></i></span>
            <span class="rj-badge-t">{{ $badge }}</span>
            <span class="rj-bars"><i></i><i></i><i></i></span>
        </div>
    @endif

    {{-- CHANGING bottom text --}}
    <div class="rj-stage" id="{{ $uid }}_stage">
        @foreach($slides as $n => $s)
            <div class="rj-slide {{ $n === 0 ? 'is-active' : '' }}">
                <h1 class="rj-title">{!! $words($s['title']) !!}</h1>
                @if($s['sub'])
                    <p class="rj-sub">{{ $s['sub'] }}</p>
                @endif
            </div>
        @endforeach
    </div>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        var video = document.getElementById(@js($uid) + '_v');

        // Pause video off-screen
        if (video && 'IntersectionObserver' in window) {
            new IntersectionObserver(function (es) {
                es.forEach(function (e) {
                    if (e.isIntersecting) { var p = video.play(); if (p) p.catch(function () {}); }
                    else video.pause();
                });
            }, { threshold: 0.05 }).observe(root);
        }

        // Rotate bottom texts
        var slides = root.querySelectorAll('.rj-slide');
        if (slides.length < 2) return;
        var cur = 0;
        setInterval(function () {
            if (document.hidden) return;
            var old = slides[cur];
            cur = (cur + 1) % slides.length;
            old.classList.remove('is-active');
            old.classList.add('is-leaving');
            setTimeout(function () {
                old.classList.remove('is-leaving');
                slides[cur].classList.add('is-active');
            }, 550);
        }, {{ $interval }});
    })();
    </script>

    <style>
        #{{ $uid }}.rj-hero {
            position: relative; width: 100%; min-height: 100vh; overflow: hidden; isolation: isolate;
            display: flex; flex-direction: column; justify-content: flex-end; align-items: center;
            padding: 140px 24px 110px; background: #04070f; color: #fff;
        }
        #{{ $uid }} .rj-bg { position: absolute; inset: 0; z-index: 0; isolation: isolate; }
        #{{ $uid }} .rj-media {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
            filter: grayscale(1) contrast(1.12) brightness(.95);
        }
        #{{ $uid }} .rj-tint { position: absolute; inset: 0; mix-blend-mode: color; }
        #{{ $uid }} .rj-depth {
            position: absolute; inset: 0; mix-blend-mode: multiply;
            background: radial-gradient(ellipse at 65% 45%, #fff 0%, #8aa3d6 55%, #1b2f66 100%);
        }
        #{{ $uid }} .rj-dim { position: absolute; inset: 0; background: #030712; }
        #{{ $uid }} .rj-vignette {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,.6) 100%),
                linear-gradient(to bottom, rgba(0,0,0,.7) 0%, transparent 26%, transparent 68%, rgba(0,0,0,.55) 100%);
        }
        #{{ $uid }} .rj-dots {
            position: absolute; inset: 0; opacity: .3; mix-blend-mode: overlay;
            background-image: radial-gradient(rgba(255,255,255,.2) 1px, transparent 1px); background-size: 4px 4px;
        }

        /* Lines */
        #{{ $uid }} .rj-line { position: absolute; left: 0; right: 0; height: 1px; background: rgba(255,255,255,.14); z-index: 1; }
        #{{ $uid }} .rj-l1 { top: 58px; }
        #{{ $uid }} .rj-l2 { top: 180px; }
        #{{ $uid }} .rj-l2 i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-l2 i::before, #{{ $uid }} .rj-l2 i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-l2 i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-l2 i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-l2 i:first-child { left: 18px; }
        #{{ $uid }} .rj-l2 i:last-child { right: 18px; }

        /* HUD */
        #{{ $uid }} .rj-hud {
            position: absolute; top: 14px; z-index: 2; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.9);
        }
        #{{ $uid }} .rj-hl { left: 22px; } #{{ $uid }} .rj-hr { right: 22px; }
        #{{ $uid }} .rj-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Fixed badge */
        #{{ $uid }} .rj-badge {
            position: absolute; top: 118px; left: 50%; transform: translateX(-50%); z-index: 2;
            display: flex; align-items: center; gap: 14px; white-space: nowrap;
        }
        #{{ $uid }} .rj-bars { display: inline-flex; gap: 3px; height: 15px; }
        #{{ $uid }} .rj-bars i { width: 3px; background: #fff; }
        #{{ $uid }} .rj-bars i:nth-child(3) { opacity: .35; }
        #{{ $uid }} .rj-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-badge-t {
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .1em; text-transform: uppercase; color: #fff;
        }

        /* Rotating stage: slides stacked in one grid cell, so height never jumps */
        #{{ $uid }} .rj-stage { position: relative; z-index: 2; display: grid; width: 100%; max-width: 1340px; text-align: center; }
        #{{ $uid }} .rj-slide { grid-area: 1 / 1; visibility: hidden; display: flex; flex-direction: column; align-items: center; }
        #{{ $uid }} .rj-slide.is-active, #{{ $uid }} .rj-slide.is-leaving { visibility: visible; }

        #{{ $uid }} .rj-title {
            margin: 0 0 26px; font-size: clamp(36px, 4.6vw, 88px); line-height: 1.08; font-weight: 500;
            letter-spacing: -.035em; text-wrap: balance;
            filter: drop-shadow(0 0 16px rgba(140,185,255,.35));
        }
        #{{ $uid }} .rj-slide.is-active .rj-title { animation: rjGlow 3.2s ease-in-out infinite; }
        #{{ $uid }} .w { display: inline-block; opacity: 0; }
        #{{ $uid }} .w > span {
            display: inline-block;
            background: linear-gradient(100deg, #fff 38%, #9cc3ff 50%, #fff 62%);
            background-size: 300% 100%; background-position: 100% 0;
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        #{{ $uid }} .rj-sp { display: inline-block; width: .78em; height: .78em; margin: 0 .04em; vertical-align: -.02em; }

        #{{ $uid }} .is-active .w { animation: rjIn .9s cubic-bezier(.2,.8,.2,1) calc(var(--i) * .09s) both; }
        #{{ $uid }} .is-active .w > span { animation: rjShine 1.8s ease-in-out calc(.5s + var(--i) * .12s) both; }
        #{{ $uid }} .is-leaving .w { opacity: 1; animation: rjOut .5s ease both; }

        #{{ $uid }} .rj-sub {
            margin: 0; max-width: 860px; font-size: clamp(15px, 1.3vw, 24px); line-height: 1.55; color: rgba(255,255,255,.72);
            opacity: 0; text-wrap: pretty;
        }
        #{{ $uid }} .is-active .rj-sub { animation: rjIn 1s cubic-bezier(.2,.8,.2,1) .45s both; }
        #{{ $uid }} .is-leaving .rj-sub { opacity: 1; animation: rjOut .5s ease both; }

        @keyframes rjIn { from { opacity: 0; transform: translateY(.35em); filter: blur(12px); } to { opacity: 1; transform: none; filter: blur(0); } }
        @keyframes rjOut { from { opacity: 1; filter: blur(0); } to { opacity: 0; transform: translateY(-.2em); filter: blur(10px); } }
        @keyframes rjShine { from { background-position: 100% 0; } to { background-position: 0% 0; } }
        @keyframes rjGlow {
            0%, 100% { filter: drop-shadow(0 0 14px rgba(140,185,255,.30)); }
            50% { filter: drop-shadow(0 0 30px rgba(160,200,255,.65)); }
        }

        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} .w, #{{ $uid }} .rj-sub { animation: none !important; opacity: 1 !important; filter: none !important; }
            #{{ $uid }} .rj-title { animation: none !important; }
        }
        @media (max-width: 768px) {
            #{{ $uid }}.rj-hero { padding: 120px 20px 90px; }
            #{{ $uid }} .rj-l2 { top: 150px; }
            #{{ $uid }} .rj-badge { top: 98px; gap: 8px; }
            #{{ $uid }} .rj-badge-t { font-size: 9px; }
            #{{ $uid }} .rj-bars { display: none; }
        }
    </style>
</section>
