@php
    $uid = 'testi_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft  = $settings['hud_left'] ?? '[ 07 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ TESTIMONIALS ]';
    $badge    = $settings['badge_text'] ?? 'Real feedback from creators and power users.';
    $title    = $settings['title'] ?? 'What people say about RJ Nexus.';
    $subtitle = $settings['subtitle'] ?? '';
    $speed    = max(3, (float) ($settings['speed'] ?? 9)); // seconds per card; bigger = slower

    $raw = $settings['testimonials'] ?? $settings['items'] ?? $settings['reviews'] ?? [];

    /*
     * Accepts either:
     *  - an array of arrays (name / handle / text  — also author, username, quote, content, review)
     *  - plain text, one testimonial per line:  Name | @handle | Text
     */
    $items = [];
    if (is_string($raw)) {
        foreach (preg_split('/\r\n|\r|\n/', trim($raw)) as $line) {
            $parts = array_map('trim', explode('|', $line, 3));
            if (count($parts) === 3 && $parts[0] !== '') {
                $items[] = ['name' => $parts[0], 'handle' => $parts[1], 'text' => $parts[2]];
            }
        }
    } elseif (is_array($raw)) {
        foreach ($raw as $it) {
            if (!is_array($it)) continue;
            $name = $it['name'] ?? $it['author'] ?? '';
            $text = $it['text'] ?? $it['quote'] ?? $it['content'] ?? $it['review'] ?? $it['message'] ?? '';
            if ($name === '' || $text === '') continue;
            $items[] = [
                'name'   => $name,
                'handle' => $it['handle'] ?? $it['username'] ?? $it['role'] ?? '',
                'text'   => $text,
            ];
        }
    }

    if (empty($items)) {
        $items = [
            ['name' => 'Ethan Moore', 'handle' => '@ethanmoore', 'text' => "Started with the free plan on @rjnexus and didn't expect to ship this fast. Upgraded within a week."],
            ['name' => 'Sarah Chen',  'handle' => '@sarahchen',  'text' => '@rjnexus helps me organize creative tasks way faster than anything I used before.'],
            ['name' => 'Olivia Tran', 'handle' => '@oliviatran', 'text' => 'As a marketer, I rely on @rjnexus daily. It cuts the time I spend on first drafts in half.'],
            ['name' => 'Daniel Park', 'handle' => '@danielpark', 'text' => 'The multi-model engine in @rjnexus is the first tool my whole team actually agreed on.'],
            ['name' => 'Mia Alvarez', 'handle' => '@miaalvarez', 'text' => 'Clean, quick and reliable. @rjnexus replaced three separate tools in my workflow.'],
            ['name' => 'Noah Bauer',  'handle' => '@noahbauer',  'text' => 'Support answered in minutes and the exports are exactly what I need for client work.'],
        ];
    }

    $clean = fn($s) => str_replace(['Qore', 'qore'], 'RJ Nexus', (string) $s);
    $dur = max(40, round(count($items) * $speed));
@endphp

<section class="rj-t" id="{{ $uid }}">

    {{-- Planet + light: soft radial edges, no clipping anywhere --}}
    <div class="rj-t-bg" aria-hidden="true">
        <span class="rj-t-planet"></span>
    </div>

    @if($showHud)
        <span class="rj-t-line"><i></i><i></i></span>
        <div class="rj-t-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-t-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-t-inner">
        <div class="rj-t-header">
            @if($badge)
                <div class="rj-t-badge">
                    <span class="rj-t-bars"><i></i><i></i><i></i></span>
                    <span class="rj-t-badge-t">{{ $badge }}</span>
                    <span class="rj-t-bars"><i></i><i></i><i></i></span>
                </div>
            @endif
            @if($title)<h2 class="rj-t-title">{{ $clean($title) }}</h2>@endif
            @if($subtitle)<p class="rj-t-sub">{{ $clean($subtitle) }}</p>@endif
        </div>
    </div>

    <div class="rj-t-marquee">
        <div class="rj-t-track" style="--dur: {{ $dur }}s;">
            @foreach([0, 1] as $copy)
                <div class="rj-t-group" @if($copy) aria-hidden="true" @endif>
                    @foreach($items as $it)
                        @php
                            $safe = e($clean($it['text']));
                            $safe = preg_replace('/@([\p{L}\p{N}_]+)/u', '<span class="rj-t-m">@$1</span>', $safe);
                            $initial = mb_strtoupper(mb_substr(trim($it['name']), 0, 1));
                        @endphp
                        <article class="rj-t-card">
                            <header class="rj-t-who">
                                <span class="rj-t-avatar">{{ $initial }}</span>
                                <span class="rj-t-id">
                                    <strong>{{ $it['name'] }}</strong>
                                    @if($it['handle'] !== '')<small>{{ $it['handle'] }}</small>@endif
                                </span>
                            </header>
                            <p class="rj-t-text">{!! $safe !!}</p>
                        </article>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-t {
            position: relative; width: 100%; background: transparent; color: #fff;
            padding: 150px 0 130px;
            overflow-x: clip;      /* only sideways: nothing is ever cut at the top or bottom */
            overflow-y: visible;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== Planet + light (every edge is feathered to transparent) ===== */
        #{{ $uid }} .rj-t-bg {
            position: absolute; left: 0; right: 0; top: 0; height: 100%; z-index: 0; pointer-events: none;
        }
        #{{ $uid }} .rj-t-planet {
            position: absolute; left: 50%; top: 34%;
            width: min(920px, 92vw); aspect-ratio: 1 / 1; translate: -50% -50%; border-radius: 50%;
            background:
                repeating-linear-gradient(45deg, rgba(150,180,255,.07) 0 1px, transparent 1px 46px),
                repeating-linear-gradient(-45deg, rgba(150,180,255,.07) 0 1px, transparent 1px 46px),
                radial-gradient(circle at 50% 40%, rgba(70,115,200,.34) 0%, rgba(40,75,150,.22) 45%, rgba(30,60,120,.0) 100%);
            /* soft radial fade: the circle dissolves, so there is no hard rim and nothing to clip */
            -webkit-mask-image: radial-gradient(circle, #000 38%, rgba(0,0,0,.55) 54%, transparent 71%);
                    mask-image: radial-gradient(circle, #000 38%, rgba(0,0,0,.55) 54%, transparent 71%);
        }

        /* ===== HUD ===== */
        #{{ $uid }} .rj-t-line { position: absolute; left: 0; right: 0; top: 60px; height: 1px; background: rgba(255,255,255,.14); z-index: 2; }
        #{{ $uid }} .rj-t-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-t-line i::before, #{{ $uid }} .rj-t-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-t-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-t-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-t-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-t-line i:last-child { right: 24px; }
        #{{ $uid }} .rj-t-hud {
            position: absolute; top: 20px; z-index: 3; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; } #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-t-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* ===== Header ===== */
        #{{ $uid }} .rj-t-inner { position: relative; z-index: 1; max-width: 1000px; margin: 0 auto; padding: 0 24px; }
        #{{ $uid }} .rj-t-header { display: flex; flex-direction: column; align-items: center; text-align: center; }
        #{{ $uid }} .rj-t-badge {
            display: inline-flex; align-items: center; gap: 12px; margin-bottom: 26px; padding: 8px 16px; border-radius: 999px;
            background: rgba(255,255,255,.06);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.14);
            -webkit-backdrop-filter: blur(20px) saturate(180%); backdrop-filter: blur(20px) saturate(180%);
        }
        #{{ $uid }} .rj-t-bars { display: inline-flex; gap: 3px; height: 10px; align-items: center; }
        #{{ $uid }} .rj-t-bars i { width: 2px; height: 100%; background: rgba(255,255,255,.55); }
        #{{ $uid }} .rj-t-bars i:nth-child(2) { height: 60%; }
        #{{ $uid }} .rj-t-bars i:nth-child(3) { height: 30%; }
        #{{ $uid }} .rj-t-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-t-badge-t { font: 600 11px/1.3 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.78); }
        #{{ $uid }} .rj-t-title { margin: 0; font-size: clamp(34px, 5.4vw, 64px); font-weight: 600; line-height: 1.06; letter-spacing: -.042em; color: #fff; }
        #{{ $uid }} .rj-t-sub { margin: 20px 0 0; max-width: 560px; font-size: clamp(16px, 1.8vw, 19px); line-height: 1.6; color: rgba(255,255,255,.6); }

        /* ===== Marquee ===== */
        #{{ $uid }} .rj-t-marquee {
            position: relative; z-index: 1; margin-top: 84px; overflow-x: clip;
            -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 9%, #000 91%, transparent 100%);
                    mask-image: linear-gradient(90deg, transparent 0, #000 9%, #000 91%, transparent 100%);
        }
        #{{ $uid }} .rj-t-track { display: flex; width: max-content; animation: rjTMarquee var(--dur, 60s) linear infinite; will-change: transform; }
        #{{ $uid }} .rj-t-group { display: flex; gap: 20px; padding-right: 20px; }
        @keyframes rjTMarquee { to { transform: translateX(-50%); } }
        #{{ $uid }} .rj-t-marquee:hover .rj-t-track { animation-play-state: paused; }
        #{{ $uid }}.rj-idle .rj-t-track { animation-play-state: paused; }

        /* ===== Glass card (no backdrop-filter on moving cards: keeps scrolling smooth) ===== */
        #{{ $uid }} .rj-t-card {
            flex: none; width: 400px; display: flex; flex-direction: column; gap: 18px; padding: 28px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,.085) 0%, rgba(255,255,255,.04) 100%);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.15), inset 0 1px 0 rgba(255,255,255,.22);
            transition: background .4s ease;
        }
        #{{ $uid }} .rj-t-card:hover { background: linear-gradient(180deg, rgba(255,255,255,.115) 0%, rgba(255,255,255,.055) 100%); }
        #{{ $uid }} .rj-t-who { display: flex; align-items: center; gap: 14px; }
        #{{ $uid }} .rj-t-avatar {
            flex: none; width: 46px; height: 46px; display: flex; align-items: center; justify-content: center; border-radius: 50%;
            font-size: 18px; font-weight: 600; color: rgba(255,255,255,.95);
            background: linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.06));
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.22), inset 0 1px 0 rgba(255,255,255,.28);
        }
        #{{ $uid }} .rj-t-id { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
        #{{ $uid }} .rj-t-id strong { font-size: 16px; font-weight: 600; letter-spacing: -.01em; color: #fff; }
        #{{ $uid }} .rj-t-id small { font-size: 14px; color: rgba(255,255,255,.5); }
        #{{ $uid }} .rj-t-text { margin: 0; font-size: 16px; line-height: 1.6; letter-spacing: -.005em; color: rgba(255,255,255,.72); }
        #{{ $uid }} .rj-t-m { color: rgba(255,255,255,.95); font-weight: 500; }

        /* ===== Mobile / motion ===== */
        @media (max-width: 720px) {
            #{{ $uid }}.rj-t { padding: 110px 0 90px; }
            #{{ $uid }} .rj-t-bars { display: none; }
            #{{ $uid }} .rj-t-line { top: 40px; }
            #{{ $uid }} .rj-t-hud { top: 10px; }
            #{{ $uid }} .rj-t-marquee { margin-top: 56px; }
            #{{ $uid }} .rj-t-card { width: 300px; padding: 22px; }
            #{{ $uid }} .rj-t-text { font-size: 15px; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} .rj-t-track { animation: none !important; }
            #{{ $uid }} .rj-t-marquee { overflow-x: auto; }
            #{{ $uid }} .rj-t-group[aria-hidden="true"] { display: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;
        // pause the marquee while the section is off-screen
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) {
                root.classList.toggle('rj-idle', !e[0].isIntersecting);
            }, { threshold: 0.02 }).observe(root);
        }
    })();
    </script>
</section>
