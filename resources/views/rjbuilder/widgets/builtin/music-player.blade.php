@php
    $hex = function ($v, $d) {
        $v = is_string($v) ? trim($v) : '';
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $inkFor = function ($c) {
        $c = ltrim($c, '#');
        if (strlen($c) === 3) { $c = $c[0].$c[0].$c[1].$c[1].$c[2].$c[2]; }
        $rgb = array_map('hexdec', str_split($c, 2));
        return (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) > 150 ? '#1d1330' : '#ffffff';
    };
    $bool = fn ($v, $d = false) => $v === null ? $d : filter_var($v, FILTER_VALIDATE_BOOLEAN);

    $title        = $settings['title'] ?? __('Now Playing');
    $source       = in_array(($settings['source'] ?? 'audius'), ['audius', 'jamendo', 'deezer', 'itunes', 'local', 'custom'], true) ? $settings['source'] : 'audius';
    $visualizer   = in_array(($settings['visualizer'] ?? 'all'), ['all', 'bars', 'circular', 'wave', 'none'], true) ? ($settings['visualizer'] ?? 'all') : 'all';
    $accent       = $hex($settings['accent'] ?? null, '#8b5cf6');
    $accent2      = $hex($settings['accent2'] ?? null, '#ec4899');
    $theme        = ($settings['theme'] ?? 'paper') === 'night' ? 'night' : 'paper';
    $height       = max(320, (int) ($settings['height'] ?? 400));
    $showPlaylist = $bool($settings['show_playlist'] ?? null, true);
    $autoplay     = $bool($settings['autoplay'] ?? null, false);
    $shuffle      = $bool($settings['shuffle'] ?? null, false);
    $paddingY     = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '14px', 'xl' => '24px', '2xl' => '34px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'xl'] ?? '24px';

    $vars = $theme === 'night'
        ? ['paper' => '#1a1330', 'paper2' => '#2a2048', 'ink' => '#f4eeff', 'shadow' => '#000000']
        : ['paper' => '#fbf7ff', 'paper2' => '#efe7fb', 'ink' => '#1d1330', 'shadow' => '#1d1330'];

    $localFiles = [];
    if (!empty($settings['local_files']) && is_array($settings['local_files'])) {
        foreach ($settings['local_files'] as $row) {
            if (!is_array($row)) continue;
            $url  = trim((string) ($row['url'] ?? ''));
            $file = $row['file'] ?? '';
            if (is_array($file)) {
                $file = $file['url'] ?? ($file['src'] ?? (reset($file) ?: ''));
            }
            $file = is_string($file) ? trim($file) : '';
            $src  = $url ?: $file;
            if ($src === '') continue;

            $localFiles[] = [
                'title'  => $row['title'] ?: __('Unknown Track'),
                'artist' => $row['artist'] ?: __('Unknown Artist'),
                'url'    => $src,
            ];
        }
    }

    $config = [
        'source'       => $source,
        'jamendoId'    => trim($settings['jamendo_client_id'] ?? ''),
        'jamendoQuery' => trim($settings['jamendo_query'] ?? ''),
        'audius'       => trim($settings['audius_playlist_id'] ?? ''),
        'deezer'       => trim($settings['deezer_playlist_id'] ?? ''),
        'itunes'       => trim($settings['itunes_query'] ?? ''),
        'visualizer'   => $visualizer,
        'accent'       => $accent,
        'accent2'      => $accent2,
        'autoplay'     => $autoplay,
        'shuffle'      => $shuffle,
        'local'        => $localFiles,
        'text'         => [
            'pick'       => __('Pick a track to start'),
            'loading'    => __('Loading tracks…'),
            'empty'      => __('No tracks to play yet.'),
            'failed'     => __('Couldn’t load tracks. Try again later.'),
            'skipping'   => __('This track can’t be played. Skipping…'),
            'shortLink'  => __('Short links can’t be used. Paste the full address from your browser.'),
            'jamendoKey' => __('A Jamendo client ID is needed to load tracks.'),
            'play'       => __('Play'),
            'pause'      => __('Pause'),
            'live'       => __('Live'),
            'repeatOff'  => __('Repeat: off'),
            'repeatAll'  => __('Repeat: all tracks'),
            'repeatOne'  => __('Repeat: this track'),
        ],
    ];
@endphp

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --b: {{ $accent2 }};
        --a-ink: {{ $inkFor($accent) }};
        --b-ink: {{ $inkFor($accent2) }};
        --paper: {{ $vars['paper'] }};
        --paper2: {{ $vars['paper2'] }};
        --ink: {{ $vars['ink'] }};
        --shadow: {{ $vars['shadow'] }};
        --dark: #1d1330;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        color: var(--ink);
        font-family: ui-rounded, "SF Pro Rounded", "Nunito", "Segoe UI", system-ui, sans-serif;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }

    #{{ $uid }} .rj-mp {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(300px, 5fr) 6fr;
        min-height: {{ $height }}px;
        background: var(--paper);
        border: 4px solid var(--ink);
        border-radius: {{ $radiusCss }};
        box-shadow: 10px 10px 0 var(--shadow);
        overflow: hidden;
    }

    /* ---------- Stage (mascot + reactive wave) ---------- */
    #{{ $uid }} .rj-mp-stage {
        position: relative;
        display: grid;
        place-items: end center;
        padding: 64px 16px 14px;
        overflow: hidden;
        border-right: 4px solid var(--ink);
        background-color: var(--paper2);
        background-image: radial-gradient(color-mix(in srgb, var(--ink) 18%, transparent) 1.6px, transparent 2px);
        background-size: 22px 22px;
    }
    #{{ $uid }} .rj-mp-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    #{{ $uid }} .rj-mp-mascot {
        position: relative;
        z-index: 1;
        display: block;
        width: min(100%, 340px);
        height: auto;
        overflow: visible;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-mp-tag {
        position: absolute;
        z-index: 2;
        top: 18px;
        left: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 15px;
        font-size: 14px;
        font-weight: 800;
        color: var(--b-ink);
        background: var(--b);
        border: 3px solid var(--ink);
        border-radius: 999px;
        box-shadow: 3px 3px 0 var(--shadow);
        transform: rotate(-4deg);
    }
    #{{ $uid }} .rj-mp-tag::before {
        content: '';
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: currentColor;
        opacity: .35;
    }
    #{{ $uid }}.is-playing .rj-mp-tag::before { opacity: 1; animation: rjMpBlink 1s steps(2) infinite; }

    #{{ $uid }} .rj-mp-zz text {
        font-weight: 900;
        font-size: 26px;
        fill: var(--ink);
        opacity: 0;
    }
    #{{ $uid }}.is-paused .rj-mp-zz text { animation: rjMpZ 3s ease-in-out infinite; }
    #{{ $uid }}.is-paused .rj-mp-zz text:nth-child(2) { animation-delay: 1s; }
    #{{ $uid }}.is-paused .rj-mp-zz text:nth-child(3) { animation-delay: 2s; }

    /* ---------- Panel ---------- */
    #{{ $uid }} .rj-mp-panel {
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-width: 0;
        padding: 28px 30px;
    }
    #{{ $uid }} .rj-mp-now {
        display: flex;
        align-items: center;
        gap: 18px;
        min-width: 0;
    }
    #{{ $uid }} .rj-mp-cover {
        flex-shrink: 0;
        width: 88px;
        height: 88px;
        overflow: hidden;
        border: 3px solid var(--ink);
        border-radius: 18px;
        box-shadow: 4px 4px 0 var(--shadow);
        transform: rotate(-3deg);
        background: var(--paper2);
    }
    #{{ $uid }} .rj-mp-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
    #{{ $uid }} .rj-mp-meta { min-width: 0; }
    #{{ $uid }} .rj-mp-now-title {
        margin: 0 0 6px;
        font-size: clamp(24px, 3.4vw, 36px);
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: -.03em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        overflow-wrap: anywhere;
    }
    #{{ $uid }} .rj-mp-now-artist {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        opacity: .65;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #{{ $uid }} .rj-mp-status {
        margin: -6px 0 0;
        font-size: 13px;
        font-weight: 700;
        opacity: .7;
    }
    #{{ $uid }} .rj-mp-status:empty { display: none; }

    /* seek + volume sliders */
    #{{ $uid }} .rj-mp-seek {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }
    #{{ $uid }} input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        flex: 1;
        min-width: 0;
        height: 24px;
        margin: 0;
        background: transparent;
        cursor: pointer;
    }
    #{{ $uid }} input[type="range"]:disabled { cursor: default; opacity: .5; }
    #{{ $uid }} input[type="range"]::-webkit-slider-runnable-track {
        height: 14px;
        border: 3px solid var(--ink);
        border-radius: 999px;
        background: linear-gradient(to right, var(--a) var(--p, 0%), var(--paper2) var(--p, 0%));
    }
    #{{ $uid }} input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        margin-top: -6px;
        border: 3px solid var(--ink);
        border-radius: 50%;
        background: var(--b);
    }
    #{{ $uid }} input[type="range"]::-moz-range-track {
        height: 14px;
        border: 3px solid var(--ink);
        border-radius: 999px;
        background: var(--paper2);
    }
    #{{ $uid }} input[type="range"]::-moz-range-progress {
        height: 8px;
        border-radius: 999px;
        background: var(--a);
    }
    #{{ $uid }} input[type="range"]::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border: 3px solid var(--ink);
        border-radius: 50%;
        background: var(--b);
    }
    #{{ $uid }} input[type="range"]:focus-visible { outline: 3px solid var(--b); outline-offset: 3px; border-radius: 999px; }

    /* buttons */
    #{{ $uid }} .rj-mp-controls {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    #{{ $uid }} .rj-mp-btn {
        position: relative;
        display: grid;
        place-items: center;
        width: 48px;
        height: 48px;
        padding: 0;
        color: var(--ink);
        background: var(--paper);
        border: 3px solid var(--ink);
        border-radius: 16px;
        box-shadow: 3px 3px 0 var(--shadow);
        cursor: pointer;
        transition: transform .1s ease, box-shadow .1s ease, background .15s ease;
    }
    #{{ $uid }} .rj-mp-btn:hover { background: var(--paper2); }
    #{{ $uid }} .rj-mp-btn:active { transform: translate(3px, 3px); box-shadow: 0 0 0 var(--shadow); }
    #{{ $uid }} .rj-mp-btn:focus-visible { outline: 3px solid var(--b); outline-offset: 3px; }
    #{{ $uid }} .rj-mp-btn svg { width: 24px; height: 24px; fill: currentColor; }
    #{{ $uid }} .rj-mp-btn[aria-pressed="true"],
    #{{ $uid }} .rj-mp-btn[data-state="all"],
    #{{ $uid }} .rj-mp-btn[data-state="one"] { color: var(--b-ink); background: var(--b); }
    #{{ $uid }} .rj-mp-btn[data-state="one"]::after {
        content: '1';
        position: absolute;
        right: 5px;
        bottom: 3px;
        font-size: 11px;
        font-weight: 900;
    }
    #{{ $uid }} .rj-mp-play {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        color: var(--a-ink);
        background: var(--a);
    }
    #{{ $uid }} .rj-mp-play:hover { background: var(--a); filter: brightness(1.08); }
    #{{ $uid }} .rj-mp-play svg { width: 32px; height: 32px; }
    #{{ $uid }} .rj-mp-play .ic-pause, #{{ $uid }}.is-playing .rj-mp-play .ic-play { display: none; }
    #{{ $uid }}.is-playing .rj-mp-play .ic-pause { display: block; }

    #{{ $uid }} .rj-mp-vol {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        width: 150px;
    }
    #{{ $uid }} .rj-mp-vol .rj-mp-btn { width: 40px; height: 40px; flex-shrink: 0; border-radius: 13px; }
    #{{ $uid }} .rj-mp-vol .rj-mp-btn svg { width: 20px; height: 20px; }
    #{{ $uid }} .rj-mp-vol .ic-mute, #{{ $uid }}.is-muted .rj-mp-vol .ic-vol { display: none; }
    #{{ $uid }}.is-muted .rj-mp-vol .ic-mute { display: block; }

    /* playlist */
    #{{ $uid }} .rj-mp-list {
        flex: 1;
        min-height: 120px;
        max-height: 240px;
        margin: 0;
        padding: 0;
        overflow-y: auto;
        list-style: none;
        background: var(--paper);
        border: 3px solid var(--ink);
        border-radius: 18px;
        scrollbar-width: thin;
    }
    #{{ $uid }} .rj-mp-list li + li .rj-mp-row { border-top: 2px dashed color-mix(in srgb, var(--ink) 22%, transparent); }
    #{{ $uid }} .rj-mp-row {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 16px;
        color: inherit;
        font: inherit;
        text-align: left;
        background: transparent;
        border: 0;
        cursor: pointer;
    }
    #{{ $uid }} .rj-mp-row:hover { background: var(--paper2); }
    #{{ $uid }} .rj-mp-row:focus-visible { outline: 3px solid var(--b); outline-offset: -3px; }
    #{{ $uid }} .rj-mp-row.is-active { color: var(--b-ink); background: var(--b); }
    #{{ $uid }} .rj-mp-num { width: 24px; flex-shrink: 0; font-size: 13px; font-weight: 800; opacity: .5; text-align: center; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rj-mp-eq { display: none; width: 24px; height: 16px; flex-shrink: 0; align-items: flex-end; justify-content: center; gap: 2px; }
    #{{ $uid }} .rj-mp-eq i { display: block; width: 4px; height: 100%; background: currentColor; border-radius: 2px; transform: scaleY(.35); transform-origin: bottom; }
    #{{ $uid }}.is-playing .rj-mp-row.is-active .rj-mp-eq i { animation: rjMpEq .7s ease-in-out infinite alternate; }
    #{{ $uid }}.is-playing .rj-mp-row.is-active .rj-mp-eq i:nth-child(2) { animation-delay: .2s; }
    #{{ $uid }}.is-playing .rj-mp-row.is-active .rj-mp-eq i:nth-child(3) { animation-delay: .4s; }
    #{{ $uid }} .rj-mp-row.is-active .rj-mp-num { display: none; }
    #{{ $uid }} .rj-mp-row.is-active .rj-mp-eq { display: flex; }
    #{{ $uid }} .rj-mp-rowinfo { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    #{{ $uid }} .rj-mp-rowinfo strong { font-size: 14px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    #{{ $uid }} .rj-mp-rowinfo small { font-size: 12px; font-weight: 600; opacity: .65; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    #{{ $uid }} .rj-mp-dur { font-size: 12px; font-weight: 700; opacity: .55; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rj-mp-empty { padding: 22px 16px; font-size: 14px; font-weight: 700; opacity: .7; }

    @keyframes rjMpEq { to { transform: scaleY(1); } }
    @keyframes rjMpBlink { 50% { opacity: .25; } }
    @keyframes rjMpZ {
        0%   { opacity: 0; transform: translate(0, 12px); }
        25%  { opacity: 1; }
        80%  { opacity: 0; transform: translate(10px, -18px); }
        100% { opacity: 0; }
    }

    @media (max-width: 820px) {
        #{{ $uid }} .rj-mp { grid-template-columns: 1fr; }
        #{{ $uid }} .rj-mp-stage { border-right: 0; border-bottom: 4px solid var(--ink); padding-top: 60px; }
        #{{ $uid }} .rj-mp-mascot { width: min(100%, 280px); }
        #{{ $uid }} .rj-mp-panel { padding: 22px 20px; }
        #{{ $uid }} .rj-mp-vol { width: 100%; margin-left: 0; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before { animation: none !important; transition: none !important; }
    }
</style>

<div id="{{ $uid }}" class="is-paused">
    <div class="rj-mp">

        <div class="rj-mp-stage" data-stage>
            <canvas class="rj-mp-canvas" data-canvas aria-hidden="true"></canvas>
            @if($title !== '')
                <span class="rj-mp-tag">{{ $title }}</span>
            @endif

            <svg class="rj-mp-mascot" viewBox="0 -20 320 360" aria-hidden="true" data-svg>
                <defs>
                    <clipPath id="{{ $uid }}-eye-l"><ellipse cx="122" cy="140" rx="26" ry="30"/></clipPath>
                    <clipPath id="{{ $uid }}-eye-r"><ellipse cx="198" cy="140" rx="26" ry="30"/></clipPath>
                    <clipPath id="{{ $uid }}-mouth"><path data-mouth-clip d="M138 188L182 188Q160 202 138 188Z"/></clipPath>
                </defs>

                <ellipse data-shadow cx="160" cy="320" rx="92" ry="11" fill="var(--ink)" opacity=".18"/>

                <g data-foot-l><ellipse cx="116" cy="302" rx="30" ry="15" fill="var(--b)" stroke="var(--ink)" stroke-width="5"/></g>
                <g data-foot-r><ellipse cx="204" cy="302" rx="30" ry="15" fill="var(--b)" stroke="var(--ink)" stroke-width="5"/></g>

                <g data-body>
                    <g data-arm-l>
                        <path d="M66 205Q28 214 24 254" fill="none" stroke="var(--ink)" stroke-width="20" stroke-linecap="round"/>
                        <path d="M66 205Q28 214 24 254" fill="none" stroke="var(--a)" stroke-width="10" stroke-linecap="round"/>
                        <circle cx="24" cy="256" r="13" fill="#fff" stroke="var(--ink)" stroke-width="5"/>
                    </g>
                    <g data-arm-r>
                        <path d="M254 205Q292 214 296 254" fill="none" stroke="var(--ink)" stroke-width="20" stroke-linecap="round"/>
                        <path d="M254 205Q292 214 296 254" fill="none" stroke="var(--a)" stroke-width="10" stroke-linecap="round"/>
                        <circle cx="296" cy="256" r="13" fill="#fff" stroke="var(--ink)" stroke-width="5"/>
                    </g>

                    <g data-ant>
                        <path d="M160 46Q156 20 171 2" fill="none" stroke="var(--ink)" stroke-width="6" stroke-linecap="round"/>
                        <circle cx="172" cy="-3" r="11" fill="var(--b)" stroke="var(--ink)" stroke-width="5"/>
                    </g>

                    <rect x="62" y="56" width="196" height="248" rx="92" fill="var(--a)" stroke="var(--ink)" stroke-width="5"/>
                    <path d="M84 120Q80 160 90 198" fill="none" stroke="#fff" stroke-opacity=".35" stroke-width="8" stroke-linecap="round"/>

                    <g data-woofer>
                        <circle cx="160" cy="252" r="34" fill="var(--dark)"/>
                        <circle cx="160" cy="252" r="25" fill="var(--b)" stroke="var(--dark)" stroke-width="3"/>
                        <g data-cone>
                            <circle cx="160" cy="252" r="12" fill="var(--dark)"/>
                            <circle cx="160" cy="252" r="5" fill="#fff"/>
                        </g>
                    </g>

                    <g clip-path="url(#{{ $uid }}-eye-l)">
                        <ellipse cx="122" cy="140" rx="26" ry="30" fill="#fff"/>
                        <g data-pupil-l><circle cx="122" cy="142" r="11" fill="var(--dark)"/><circle cx="118" cy="137" r="3.5" fill="#fff"/></g>
                        <rect data-lid-l x="94" y="106" width="56" height="0" fill="var(--a)"/>
                        <line data-line-l x1="94" x2="150" y1="106" y2="106" stroke="var(--dark)" stroke-width="5" opacity="0"/>
                    </g>
                    <ellipse cx="122" cy="140" rx="26" ry="30" fill="none" stroke="var(--ink)" stroke-width="5"/>

                    <g clip-path="url(#{{ $uid }}-eye-r)">
                        <ellipse cx="198" cy="140" rx="26" ry="30" fill="#fff"/>
                        <g data-pupil-r><circle cx="198" cy="142" r="11" fill="var(--dark)"/><circle cx="194" cy="137" r="3.5" fill="#fff"/></g>
                        <rect data-lid-r x="170" y="106" width="56" height="0" fill="var(--a)"/>
                        <line data-line-r x1="170" x2="226" y1="106" y2="106" stroke="var(--dark)" stroke-width="5" opacity="0"/>
                    </g>
                    <ellipse cx="198" cy="140" rx="26" ry="30" fill="none" stroke="var(--ink)" stroke-width="5"/>

                    <ellipse cx="90" cy="184" rx="13" ry="8" fill="var(--b)" opacity=".6"/>
                    <ellipse cx="230" cy="184" rx="13" ry="8" fill="var(--b)" opacity=".6"/>

                    <g data-brows stroke="var(--dark)" stroke-width="6" stroke-linecap="round" fill="none">
                        <path d="M100 98L144 94"/>
                        <path d="M176 94L220 98"/>
                    </g>

                    <path data-mouth d="M138 188L182 188Q160 202 138 188Z" fill="var(--dark)" stroke="var(--dark)" stroke-width="4" stroke-linejoin="round"/>
                    <ellipse data-tongue clip-path="url(#{{ $uid }}-mouth)" cx="160" cy="196" rx="12" ry="0" fill="#ff7a9c"/>

                    <path d="M64 142C60 8 260 8 256 142" fill="none" stroke="var(--ink)" stroke-width="14" stroke-linecap="round"/>
                    <path d="M64 142C60 8 260 8 256 142" fill="none" stroke="var(--b)" stroke-width="6" stroke-linecap="round"/>
                    <rect x="44" y="118" width="34" height="68" rx="15" fill="var(--b)" stroke="var(--ink)" stroke-width="5"/>
                    <rect x="242" y="118" width="34" height="68" rx="15" fill="var(--b)" stroke="var(--ink)" stroke-width="5"/>
                </g>

                <g class="rj-mp-zz">
                    <text x="238" y="44">z</text>
                    <text x="258" y="22">z</text>
                    <text x="276" y="2">z</text>
                </g>
            </svg>
        </div>

        <div class="rj-mp-panel">
            <div class="rj-mp-now">
                <div class="rj-mp-cover" data-cover hidden><img alt="" data-cover-img></div>
                <div class="rj-mp-meta">
                    <h3 class="rj-mp-now-title" data-now-title>{{ __('Pick a track to start') }}</h3>
                    <p class="rj-mp-now-artist" data-now-artist></p>
                </div>
            </div>

            <p class="rj-mp-status" data-status role="status" aria-live="polite"></p>

            <div class="rj-mp-seek">
                <span data-time-cur>0:00</span>
                <input type="range" min="0" max="1000" step="1" value="0" data-seek aria-label="{{ __('Seek') }}">
                <span data-time-total>0:00</span>
            </div>

            <div class="rj-mp-controls">
                <button type="button" class="rj-mp-btn" data-shuffle aria-pressed="false" aria-label="{{ __('Shuffle') }}">
                    <svg viewBox="0 0 24 24"><path d="M10.59 9.17L5.41 4 4 5.41l5.17 5.17 1.42-1.41zM14.5 4l2.04 2.04L4 18.59 5.41 20 17.96 7.46 20 9.5V4h-5.5zm.33 9.41l-1.41 1.41 3.13 3.13L14.5 20H20v-5.5l-2.04 2.04-3.13-3.13z"/></svg>
                </button>
                <button type="button" class="rj-mp-btn" data-prev aria-label="{{ __('Previous track') }}">
                    <svg viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/></svg>
                </button>
                <button type="button" class="rj-mp-btn rj-mp-play" data-play aria-label="{{ __('Play') }}">
                    <svg class="ic-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg class="ic-pause" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>
                <button type="button" class="rj-mp-btn" data-next aria-label="{{ __('Next track') }}">
                    <svg viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/></svg>
                </button>
                <button type="button" class="rj-mp-btn" data-repeat data-state="off" aria-label="{{ __('Repeat: off') }}">
                    <svg viewBox="0 0 24 24"><path d="M7 7h10v3l4-4-4-4v3H5v6h2V7zm10 10H7v-3l-4 4 4 4v-3h12v-6h-2v4z"/></svg>
                </button>

                <div class="rj-mp-vol">
                    <button type="button" class="rj-mp-btn" data-mute aria-label="{{ __('Mute') }}">
                        <svg class="ic-vol" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                        <svg class="ic-mute" viewBox="0 0 24 24"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51A8.8 8.8 0 0021 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06a8.99 8.99 0 003.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                    </button>
                    <input type="range" min="0" max="1" step="0.01" value="0.8" data-volume aria-label="{{ __('Volume') }}">
                </div>
            </div>

            @if($showPlaylist)
                <ol class="rj-mp-list" data-list aria-label="{{ __('Playlist') }}"></ol>
            @endif
        </div>

    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var cfg = @json($config);
    var T = cfg.text;
    var uidKey = @js($uid);
    var q = function (s) { return root.querySelector(s); };

    /* ------------------------------------------------------------------ */
    /*  Elements                                                           */
    /* ------------------------------------------------------------------ */
    var svg = q('[data-svg]'), canvas = q('[data-canvas]');
    var E = {
        body: q('[data-body]'), armL: q('[data-arm-l]'), armR: q('[data-arm-r]'), ant: q('[data-ant]'),
        footL: q('[data-foot-l]'), footR: q('[data-foot-r]'), shadow: q('[data-shadow]'),
        woofer: q('[data-woofer]'), cone: q('[data-cone]'),
        pupL: q('[data-pupil-l]'), pupR: q('[data-pupil-r]'),
        lidL: q('[data-lid-l]'), lidR: q('[data-lid-r]'), lineL: q('[data-line-l]'), lineR: q('[data-line-r]'),
        mouth: q('[data-mouth]'), mouthClip: q('[data-mouth-clip]'), tongue: q('[data-tongue]'), brows: q('[data-brows]')
    };
    var titleEl = q('[data-now-title]'), artistEl = q('[data-now-artist]'), statusEl = q('[data-status]');
    var coverEl = q('[data-cover]'), coverImg = q('[data-cover-img]');
    var seekEl = q('[data-seek]'), curEl = q('[data-time-cur]'), totEl = q('[data-time-total]');
    var playBtn = q('[data-play]'), prevBtn = q('[data-prev]'), nextBtn = q('[data-next]');
    var shuffleBtn = q('[data-shuffle]'), repeatBtn = q('[data-repeat]'), muteBtn = q('[data-mute]'), volEl = q('[data-volume]');
    var listEl = q('[data-list]');

    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    var mo = reduce ? 0.3 : 1;
    var mode = cfg.visualizer;
    var dpr = Math.min(2, window.devicePixelRatio || 1);
    var inkColor = (getComputedStyle(root).getPropertyValue('--ink') || '#1d1330').trim();

    /* ------------------------------------------------------------------ */
    /*  State                                                              */
    /* ------------------------------------------------------------------ */
    var tracks = [], cur = -1, audio = null, wantPlay = false, fails = 0, seeking = false;
    var shuffle = !!cfg.shuffle, repeat = 'off', vol = 0.8, muted = false;
    var ctx = null, analyser = null, spectrum = null;
    var visible = true, raf = 0, last = performance.now(), destroyed = false;

    try { var sv = parseFloat(localStorage.getItem('rjmp_vol')); if (!isNaN(sv)) vol = Math.min(1, Math.max(0, sv)); } catch (e) {}
    volEl.value = vol;
    setRange(volEl, vol * 100);
    shuffleBtn.setAttribute('aria-pressed', shuffle ? 'true' : 'false');

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                            */
    /* ------------------------------------------------------------------ */
    function clamp(v, a, b) { return v < a ? a : (v > b ? b : v); }
    function ease(dt, k) { return 1 - Math.exp(-dt * k); }
    function fmt(sec) {
        if (!isFinite(sec) || sec < 0) return '0:00';
        var m = Math.floor(sec / 60), s = Math.floor(sec % 60);
        return m + ':' + (s < 10 ? '0' : '') + s;
    }
    function setRange(input, pct) { input.style.setProperty('--p', clamp(pct, 0, 100) + '%'); }
    function setStatus(msg) { statusEl.textContent = msg || ''; }

    /* ------------------------------------------------------------------ */
    /*  Providers                                                          */
    /* ------------------------------------------------------------------ */
    var jsonpCount = 0;
    function jsonp(url, cbParam) {
        // JSONP works for APIs that block cross-origin fetch (Deezer, iTunes) without any proxy
        return new Promise(function (resolve, reject) {
            var name = 'rjmp_' + uidKey + '_' + (++jsonpCount);
            var s = document.createElement('script');
            var timer = setTimeout(function () { cleanup(); reject(new Error('Request timed out')); }, 12000);
            function cleanup() { clearTimeout(timer); try { delete window[name]; } catch (e) { window[name] = undefined; } if (s.parentNode) s.parentNode.removeChild(s); }
            window[name] = function (data) { cleanup(); resolve(data); };
            s.onerror = function () { cleanup(); reject(new Error('Network error')); };
            s.src = url + (url.indexOf('?') > -1 ? '&' : '?') + cbParam + name;
            document.head.appendChild(s);
        });
    }

    /* ---- Audius: ID, link (playlist / track / profile) or name ---- */
    var AU_HOSTS = ['https://api.audius.co', 'https://discoveryprovider.audius.co'], auHost = null;
    async function auGet(path) {
        var hosts = auHost ? [auHost] : AU_HOSTS, lastErr = null;
        for (var i = 0; i < hosts.length; i++) {
            try {
                var r = await fetch(hosts[i] + '/v1' + path + (path.indexOf('?') > -1 ? '&' : '?') + 'app_name=RJ_CMS');
                if (!r.ok) throw new Error('Audius HTTP ' + r.status);
                var j = await r.json();
                auHost = hosts[i];
                return j.data;
            } catch (e) { lastErr = e; }
        }
        throw lastErr || new Error('Audius unreachable');
    }
    function auMap(list) {
        return (list || []).filter(function (t) { return t && t.is_streamable !== false; }).map(function (t) {
            var art = t.artwork || {};
            return {
                title: t.title,
                artist: t.user ? t.user.name : 'Audius',
                url: auHost + '/v1/tracks/' + t.id + '/stream?app_name=RJ_CMS',
                cover: art['480x480'] || art['150x150'] || null,
                duration: t.duration || null
            };
        });
    }
    async function auFrom(d) {
        if (Array.isArray(d)) d = d[0];
        if (!d) return [];
        if (d.playlist_name !== undefined || d.playlist_contents !== undefined) return auMap(await auGet('/playlists/' + d.id + '/tracks'));
        if (d.title !== undefined) return auMap([d]);
        if (d.handle !== undefined) return auMap(await auGet('/users/' + d.id + '/tracks?limit=50'));
        return [];
    }
    async function audius(input) {
        var v = (input || '').trim();
        if (!v) return auMap(await auGet('/tracks/trending?limit=30'));
        if (/^(https?:\/\/)?(www\.)?audius\.co\//i.test(v)) {
            var u = /^https?:/i.test(v) ? v : 'https://' + v;
            return auFrom(await auGet('/resolve?url=' + encodeURIComponent(u)));
        }
        if (/^[A-Za-z0-9]{3,10}$/.test(v)) {
            try {
                var byId = await auGet('/playlists/' + encodeURIComponent(v) + '/tracks');
                if (byId && byId.length) return auMap(byId);
            } catch (e) { /* not an ID, search by name below */ }
        }
        var pls = await auGet('/playlists/search?query=' + encodeURIComponent(v) + '&limit=1');
        if (pls && pls.length) return auMap(await auGet('/playlists/' + pls[0].id + '/tracks'));
        return auMap(await auGet('/tracks/search?query=' + encodeURIComponent(v) + '&limit=30'));
    }

    /* ---- Deezer: ID, link (playlist / album / track / artist) or name ---- */
    function dzMap(list, cover) {
        return (list || []).filter(function (t) { return t && t.preview; }).map(function (t) {
            return {
                title: t.title_short || t.title,
                artist: t.artist ? t.artist.name : '',
                url: t.preview,
                cover: (t.album && (t.album.cover_medium || t.album.cover)) || cover || null,
                duration: null
            };
        });
    }
    async function deezer(input) {
        var v = (input || '').trim(), D = 'https://api.deezer.com';
        var get = function (p) {
            return jsonp(D + p, 'output=jsonp&callback=').then(function (d) {
                if (d && d.error) throw new Error((d.error.message || 'Deezer error') + ' (' + (d.error.code || '') + ')');
                return d;
            });
        };
        if (!v) return dzMap((await get('/chart/0/tracks?limit=50')).data);
        if (/(link\.deezer\.com|dzr\.page\.link|deezer\.page\.link)/i.test(v)) { var e = new Error(T.shortLink); e.user = true; throw e; }

        var m = v.match(/deezer\.com\/(?:[a-z]{2}(?:-[a-z]{2})?\/)?(playlist|album|track|artist)\/(\d+)/i), type = null, id = null;
        if (m) { type = m[1].toLowerCase(); id = m[2]; }
        else if (/^\d+$/.test(v)) { type = 'playlist'; id = v; }

        if (type === 'playlist') return dzMap((await get('/playlist/' + id + '/tracks?limit=100')).data);
        if (type === 'album') { var al = await get('/album/' + id); return dzMap(al.tracks ? al.tracks.data : [], al.cover_medium); }
        if (type === 'track') return dzMap([await get('/track/' + id)]);
        if (type === 'artist') return dzMap((await get('/artist/' + id + '/top?limit=50')).data);

        var pls = await get('/search/playlist?q=' + encodeURIComponent(v) + '&limit=1');
        if (pls.data && pls.data.length) return dzMap((await get('/playlist/' + pls.data[0].id + '/tracks?limit=100')).data);
        return dzMap((await get('/search?q=' + encodeURIComponent(v) + '&limit=30')).data);
    }

    /* ---- Jamendo: link (playlist / album / artist / track) or search text ---- */
    async function jamendo() {
        if (!cfg.jamendoId) { var e = new Error(T.jamendoKey); e.user = true; throw e; }
        var v = (cfg.jamendoQuery || '').trim(), base = 'https://api.jamendo.com/v3.0/';
        var common = 'client_id=' + encodeURIComponent(cfg.jamendoId) + '&format=json&limit=50&audioformat=mp32';
        var m = v.match(/jamendo\.com\/(?:[a-z]{2}\/)?(playlist|album|artist|track)\/(\d+)/i), url, nested = false;
        if (m) {
            var k = m[1].toLowerCase();
            if (k === 'track') url = base + 'tracks/?' + common + '&id=' + m[2];
            else { nested = true; url = base + (k === 'playlist' ? 'playlists' : (k === 'album' ? 'albums' : 'artists')) + '/tracks/?' + common + '&id=' + m[2]; }
        } else if (v) url = base + 'tracks/?' + common + '&search=' + encodeURIComponent(v) + '&order=popularity_total';
        else url = base + 'tracks/?' + common + '&order=popularity_week';

        var r = await fetch(url), j = await r.json();
        if (j.headers && j.headers.status === 'failed') throw new Error(j.headers.error_message || 'Jamendo error');
        var res = j.results || [], parent = res[0] || {};
        if (nested) res = parent.tracks || [];
        return res.filter(function (t) { return t.audio; }).map(function (t) {
            return {
                title: t.name, artist: t.artist_name || parent.artist_name || '', url: t.audio,
                cover: t.image || t.album_image || parent.image || null, duration: t.duration || null
            };
        });
    }

    /* ---- iTunes / Apple Music previews: search by song or artist name ---- */
    async function itunes() {
        var term = (cfg.itunes || '').trim() || 'lofi';
        var d = await jsonp('https://itunes.apple.com/search?media=music&entity=song&limit=40&term=' + encodeURIComponent(term), 'callback=');
        return (d.results || []).filter(function (r) { return r.previewUrl; }).map(function (r) {
            return { title: r.trackName, artist: r.artistName, url: r.previewUrl, cover: (r.artworkUrl100 || '').replace('100x100', '300x300') || null, duration: null };
        });
    }

    async function loadTracks() {
        setStatus('');
        tracks = cfg.local.slice();
        renderList(true);
        var remote = [], failed = false;
        try {
            if (cfg.source === 'audius') remote = await audius(cfg.audius);
            else if (cfg.source === 'deezer') remote = await deezer(cfg.deezer);
            else if (cfg.source === 'jamendo') remote = await jamendo();
            else if (cfg.source === 'itunes') remote = await itunes();
        } catch (err) {
            failed = true;
            console.error('[music-player] ' + cfg.source + ':', err);
            setStatus(err && err.user ? err.message : T.failed);
        }
        tracks = tracks.concat(remote);
        renderList(false);
        if (tracks.length) {
            if (cfg.shuffle && tracks.length > 1) cur = Math.floor(Math.random() * tracks.length); else cur = 0;
            wantPlay = !!cfg.autoplay;
            loadTrack(cur, wantPlay);
        } else if (!failed) {
            setStatus(T.empty);
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Playlist UI                                                        */
    /* ------------------------------------------------------------------ */
    function renderList(loading) {
        if (!listEl) return;
        listEl.textContent = '';
        if (loading && !tracks.length) {
            var li = document.createElement('li'); li.className = 'rj-mp-empty'; li.textContent = T.loading; listEl.appendChild(li); return;
        }
        if (!tracks.length) {
            var li2 = document.createElement('li'); li2.className = 'rj-mp-empty'; li2.textContent = T.empty; listEl.appendChild(li2); return;
        }
        tracks.forEach(function (t, i) {
            var li = document.createElement('li'), b = document.createElement('button');
            b.type = 'button'; b.className = 'rj-mp-row';
            var num = document.createElement('span'); num.className = 'rj-mp-num'; num.textContent = String(i + 1);
            var eq = document.createElement('span'); eq.className = 'rj-mp-eq'; eq.setAttribute('aria-hidden', 'true'); eq.innerHTML = '<i></i><i></i><i></i>';
            var info = document.createElement('span'); info.className = 'rj-mp-rowinfo';
            var s1 = document.createElement('strong'); s1.textContent = t.title || '';
            var s2 = document.createElement('small'); s2.textContent = t.artist || '';
            info.appendChild(s1); info.appendChild(s2);
            b.appendChild(num); b.appendChild(eq); b.appendChild(info);
            if (t.duration) { var d = document.createElement('span'); d.className = 'rj-mp-dur'; d.textContent = fmt(t.duration); b.appendChild(d); }
            b.addEventListener('click', function () { wantPlay = true; loadTrack(i, true); });
            li.appendChild(b); listEl.appendChild(li);
        });
        markActive();
    }
    function markActive() {
        if (!listEl) return;
        var rows = listEl.querySelectorAll('.rj-mp-row');
        for (var i = 0; i < rows.length; i++) rows[i].classList.toggle('is-active', i === cur);
        var row = rows[cur];
        if (row) {
            var top = row.offsetTop, bottom = top + row.offsetHeight;
            if (top < listEl.scrollTop || bottom > listEl.scrollTop + listEl.clientHeight) listEl.scrollTop = top - (listEl.clientHeight - row.offsetHeight) / 2;
        }
    }

    /* ------------------------------------------------------------------ */
    /*  Audio engine                                                       */
    /* ------------------------------------------------------------------ */
    function ensureCtx() {
        if (ctx) return true;
        var AC = window.AudioContext || window.webkitAudioContext;
        if (!AC) return false;
        try {
            ctx = new AC();
            analyser = ctx.createAnalyser();
            analyser.fftSize = 1024;
            analyser.smoothingTimeConstant = 0.7;
            analyser.minDecibels = -90;
            analyser.maxDecibels = -20;
            analyser.connect(ctx.destination);
            spectrum = new Uint8Array(analyser.frequencyBinCount);
            return true;
        } catch (e) { ctx = null; return false; }
    }

    function makeAudio(url, cors) {
        var a = new Audio();
        a._cors = !!cors; a._url = url; a.preload = 'auto';
        if (cors) a.crossOrigin = 'anonymous';
        a.volume = muted ? 0 : vol;
        a.addEventListener('playing', function () { if (a !== audio) return; fails = 0; root.classList.remove('is-buffering'); setPlayingUI(true); attachAnalyser(a); });
        a.addEventListener('play', function () { if (a === audio) setPlayingUI(true); });
        a.addEventListener('pause', function () { if (a === audio) setPlayingUI(false); });
        a.addEventListener('waiting', function () { if (a === audio) root.classList.add('is-buffering'); });
        a.addEventListener('durationchange', function () { if (a === audio) updateTime(); });
        a.addEventListener('timeupdate', function () { if (a === audio) updateTime(); });
        a.addEventListener('ended', function () { if (a === audio) advance(true); });
        a.addEventListener('error', function () { if (a === audio) onError(a); });
        a.src = url;
        return a;
    }

    function attachAnalyser(a) {
        if (!a._cors || a._node || !ensureCtx()) return;
        ctx.resume().then(function () {
            if (ctx.state !== 'running' || a !== audio || a._node) return;
            try { a._node = ctx.createMediaElementSource(a); a._node.connect(analyser); } catch (e) { /* visuals fall back to simulated motion */ }
        }).catch(function () {});
    }

    function stopAudio() {
        var a = audio;
        audio = null;
        if (!a) return;
        try { if (a._node) a._node.disconnect(); } catch (e) {}
        try { a.pause(); a.removeAttribute('src'); a.load(); } catch (e) {}
    }

    function onError(a) {
        if (a._cors) {
            // Server has no CORS headers: play it natively without the analyser (mascot keeps dancing in simulated mode)
            var na = makeAudio(a._url, false);
            try { a.pause(); a.removeAttribute('src'); a.load(); } catch (e) {}
            audio = na;
            if (wantPlay) startPlay();
            return;
        }
        fails++;
        setPlayingUI(false);
        if (tracks.length > 1 && fails < tracks.length) {
            setStatus(T.skipping);
            setTimeout(function () { if (audio === a) { setStatus(''); advance(true); } }, 900);
        } else {
            setStatus(T.failed);
        }
    }

    function startPlay() {
        if (!audio) return;
        ensureCtx();
        if (ctx && ctx.state === 'suspended') ctx.resume().catch(function () {});
        var p = audio.play();
        if (p && p.catch) p.catch(function (e) { if (!e || e.name !== 'NotAllowedError') console.warn('[music-player] play:', e); });
    }

    function loadTrack(i, play) {
        if (i < 0 || i >= tracks.length) return;
        cur = i;
        var t = tracks[i];
        stopAudio();
        audio = makeAudio(t.url, true);
        titleEl.textContent = t.title || '';
        artistEl.textContent = t.artist || '';
        if (t.cover) { coverImg.src = t.cover; coverEl.hidden = false; } else { coverEl.hidden = true; coverImg.removeAttribute('src'); }
        seekEl.value = 0; setRange(seekEl, 0); seekEl.disabled = false;
        curEl.textContent = '0:00'; totEl.textContent = t.duration ? fmt(t.duration) : '0:00';
        markActive();
        setStatus('');
        setPlayingUI(false);
        mediaSession(t);
        if (play) startPlay();
    }

    function nextIndex(auto) {
        var n = tracks.length;
        if (!n) return -1;
        if (auto && repeat === 'one') return cur;
        if (shuffle && n > 1) { var r; do { r = Math.floor(Math.random() * n); } while (r === cur); return r; }
        var i = cur + 1;
        if (i >= n) { if (auto && repeat === 'off') return -1; i = 0; }
        return i;
    }
    function advance(auto) {
        var i = nextIndex(auto);
        if (i === -1) { wantPlay = false; loadTrack(0, false); return; }
        loadTrack(i, wantPlay || !auto);
        if (!auto) wantPlay = true;
    }
    function previous() {
        if (audio && audio.currentTime > 3) { audio.currentTime = 0; return; }
        var i = cur - 1; if (i < 0) i = tracks.length - 1;
        wantPlay = true; loadTrack(i, true);
    }
    function togglePlay() {
        if (!audio) return;
        if (audio.paused) { wantPlay = true; startPlay(); } else { wantPlay = false; audio.pause(); }
    }

    function setPlayingUI(p) {
        root.classList.toggle('is-playing', p);
        root.classList.toggle('is-paused', !p);
        playBtn.setAttribute('aria-label', p ? T.pause : T.play);
    }
    function updateTime() {
        if (!audio) return;
        var d = audio.duration, c = audio.currentTime;
        if (isFinite(d) && d > 0) {
            seekEl.disabled = false;
            totEl.textContent = fmt(d);
            if (!seeking) { var pct = c / d * 100; seekEl.value = Math.round(pct * 10); setRange(seekEl, pct); curEl.textContent = fmt(c); }
        } else if (d === Infinity) {
            seekEl.disabled = true; totEl.textContent = T.live; curEl.textContent = fmt(c);
        }
    }

    function mediaSession(t) {
        if (!('mediaSession' in navigator) || !window.MediaMetadata) return;
        try {
            navigator.mediaSession.metadata = new MediaMetadata({ title: t.title || '', artist: t.artist || '', artwork: t.cover ? [{ src: t.cover }] : [] });
            navigator.mediaSession.setActionHandler('play', function () { wantPlay = true; startPlay(); });
            navigator.mediaSession.setActionHandler('pause', function () { wantPlay = false; if (audio) audio.pause(); });
            navigator.mediaSession.setActionHandler('previoustrack', previous);
            navigator.mediaSession.setActionHandler('nexttrack', function () { advance(false); });
        } catch (e) {}
    }

    /* ---- Controls ---- */
    playBtn.addEventListener('click', togglePlay);
    prevBtn.addEventListener('click', previous);
    nextBtn.addEventListener('click', function () { advance(false); });
    shuffleBtn.addEventListener('click', function () { shuffle = !shuffle; shuffleBtn.setAttribute('aria-pressed', shuffle ? 'true' : 'false'); });
    repeatBtn.addEventListener('click', function () {
        repeat = repeat === 'off' ? 'all' : (repeat === 'all' ? 'one' : 'off');
        repeatBtn.setAttribute('data-state', repeat);
        repeatBtn.setAttribute('aria-label', repeat === 'off' ? T.repeatOff : (repeat === 'all' ? T.repeatAll : T.repeatOne));
    });
    seekEl.addEventListener('input', function () {
        seeking = true;
        var pct = seekEl.value / 10; setRange(seekEl, pct);
        if (audio && isFinite(audio.duration)) curEl.textContent = fmt(audio.duration * pct / 100);
    });
    seekEl.addEventListener('change', function () {
        if (audio && isFinite(audio.duration)) audio.currentTime = audio.duration * seekEl.value / 1000;
        seeking = false;
    });
    function applyVolume() {
        if (audio) audio.volume = muted ? 0 : vol;
        root.classList.toggle('is-muted', muted || vol === 0);
        setRange(volEl, (muted ? 0 : vol) * 100);
    }
    volEl.addEventListener('input', function () {
        vol = parseFloat(volEl.value); muted = false; applyVolume();
        try { localStorage.setItem('rjmp_vol', String(vol)); } catch (e) {}
    });
    muteBtn.addEventListener('click', function () { muted = !muted; applyVolume(); });
    applyVolume();

    /* ------------------------------------------------------------------ */
    /*  Audio analysis (real spectrum, or simulated when CORS blocks it)   */
    /* ------------------------------------------------------------------ */
    var N = 48, lv = new Float32Array(N), target = new Float32Array(N), edges = [];
    (function () {
        var prev = 0;
        for (var k = 0; k <= N; k++) {
            var e = Math.round(Math.pow(300, k / N));
            if (e <= prev) e = prev + 1;
            edges.push(e); prev = e;
        }
    })();

    var playing = false, flat = 0, avgBass = 0, lastBeat = 0, synthBeat = -1;
    var bassS = 0, midS = 0, energy = 0;

    function sample(dt, t) {
        playing = !!(audio && !audio.paused && !audio.ended);
        var real = false;

        if (playing && analyser && audio._node && ctx && ctx.state === 'running') {
            analyser.getByteFrequencyData(spectrum);
            var sum = 0, i;
            for (i = 0; i < spectrum.length; i++) sum += spectrum[i];
            if (sum > 0) { real = true; flat = 0; } else { flat += dt; real = flat < 1.2; }
            if (real && sum > 0) {
                for (var k = 0; k < N; k++) {
                    var s = edges[k], e = Math.min(edges[k + 1], spectrum.length), acc = 0, c = 0;
                    for (i = s; i < e; i++) { acc += spectrum[i]; c++; }
                    var v = c ? acc / c / 255 : 0;
                    target[k] = clamp(Math.pow(v, 2) * 1.8 * (1 + k / N * 0.5), 0, 1);
                }
            }
        }

        if (playing && !real) {
            // Simulated groove (118 bpm) when the track's server blocks audio analysis
            var bpm = 118, ct = audio.currentTime, ph = (ct * bpm / 60) % 1, kick = Math.exp(-ph * 5);
            for (var j = 0; j < N; j++) {
                var u = j / N;
                var n1 = 0.5 + 0.5 * Math.sin(t * (2.1 + j * 0.37) + j * 1.3);
                var n2 = 0.5 + 0.5 * Math.sin(t * (3.7 + j * 0.21) + j * 0.7);
                target[j] = clamp(0.08 + kick * Math.pow(1 - u, 1.6) * 0.85 + n1 * n2 * 0.38 * (0.35 + u * 0.4), 0, 1);
            }
            var idx = Math.floor(ct * bpm / 60);
            if (idx !== synthBeat) { synthBeat = idx; onBeat(0.6); }
        }

        for (var m = 0; m < N; m++) {
            var tv = playing ? target[m] : 0;
            lv[m] += (tv - lv[m]) * ease(dt, tv > lv[m] ? 30 : 7);
        }

        var bass = (lv[0] + lv[1] + lv[2] + lv[3]) / 4, mid = 0, all = 0;
        for (var a = 12; a < 28; a++) mid += lv[a];
        mid /= 16;
        for (var b = 0; b < N; b++) all += lv[b];
        all /= N;

        if (playing && real && audio._node) {
            avgBass += (bass - avgBass) * ease(dt, 1.5);
            if (bass > avgBass * 1.22 + 0.04 && bass > 0.3 && t - lastBeat > 0.24) {
                lastBeat = t; onBeat(clamp((bass - avgBass) * 3 + 0.25, 0, 1));
            }
        }
        bassS += (bass - bassS) * ease(dt, 12);
        midS += (mid - midS) * ease(dt, 8);
        energy += (all - energy) * ease(dt, 6);
    }

    /* ------------------------------------------------------------------ */
    /*  Mascot                                                             */
    /* ------------------------------------------------------------------ */
    var M = { hop: 0, hv: 0, land: 0, sway: 0, dir: 1, aL: 0, aR: 0, ant: 0, antV: 0, mouth: 0, boop: 0, lid: 32, bp: -1, blinkT: 2.5, brow: 0, lean: 0,
              p: [{ x: 0, y: 0 }, { x: 0, y: 0 }], wander: { x: 0, y: 0, t: 0 } };
    var EYES = [[122, 142], [198, 142]];
    var mouse = { x: 0, y: 0, t: 0, on: false };

    function onBeat(strength) {
        M.hv = -(170 + 260 * strength) * mo;
        M.dir = -M.dir;
        if (M.dir > 0) M.aL = 1; else M.aR = 1;
        M.sway = M.dir * (3 + 7 * strength) * mo;
        M.antV += -M.dir * 90;
        M.brow = 1;
    }

    function onPointer(e) { mouse.x = e.clientX; mouse.y = e.clientY; mouse.t = performance.now() / 1000; mouse.on = true; }
    window.addEventListener('pointermove', onPointer, { passive: true });
    svg.addEventListener('click', function () { M.boop = 1; M.hv = -420 * mo; });

    function mascot(dt, t, r) {
        var s = r.width / 320, now = performance.now() / 1000;
        var active = mouse.on && (now - mouse.t) < 4;

        // Eyes follow the pointer, or wander when it is idle
        if (!active && now > M.wander.t) { M.wander.t = now + 1.4 + Math.random() * 2; M.wander.x = Math.random() * 2 - 1; M.wander.y = Math.random() * 0.9 - 0.3; }
        for (var i = 0; i < 2; i++) {
            var tx, ty;
            if (active) {
                var ex = r.left + EYES[i][0] * s, ey = r.top + (EYES[i][1] + 20) * s;
                var dx = mouse.x - ex, dy = mouse.y - ey, d = Math.sqrt(dx * dx + dy * dy) || 1;
                var amt = Math.min(1, d / (170 * Math.max(0.7, s)));
                tx = dx / d * amt * 12; ty = dy / d * amt * 15;
            } else { tx = M.wander.x * 9; ty = M.wander.y * 11; }
            M.p[i].x += (tx - M.p[i].x) * ease(dt, 16);
            M.p[i].y += (ty - M.p[i].y) * ease(dt, 16);
        }
        var leanT = active ? clamp((mouse.x - (r.left + r.width / 2)) / (r.width * 1.4), -1, 1) * 5 : 0;
        M.lean += (leanT - M.lean) * ease(dt, 6);

        // Hop physics
        M.hv += 2200 * dt;
        M.hop += M.hv * dt;
        if (M.hop > 0) { if (M.hv > 120) M.land = Math.min(1, M.hv / 500); M.hop = 0; M.hv = 0; }
        M.land *= Math.exp(-dt * 12);
        M.boop *= Math.exp(-dt * 4);
        M.brow *= Math.exp(-dt * 7);
        M.aL *= Math.exp(-dt * 5);
        M.aR *= Math.exp(-dt * 5);
        M.sway *= Math.exp(-dt * 3);
        M.antV += ((-M.sway * 2.2 - M.ant) * 160 - M.antV * 9) * dt;
        M.ant += M.antV * dt;

        // Body
        var breathe = Math.sin(t * 2.2) * 0.012;
        var sy = 1 + breathe - 0.075 * bassS * mo - 0.1 * M.land * mo + (M.hop < -2 ? Math.min(0.05, -M.hop / 400) : 0);
        var sx = 1 - (sy - 1) * 0.8;
        var rot = M.sway + M.lean + Math.sin(t * 2.6) * midS * 2 * mo;
        E.body.setAttribute('transform', 'translate(0 ' + M.hop.toFixed(2) + ') translate(160 304) rotate(' + rot.toFixed(2) + ') scale(' + sx.toFixed(3) + ' ' + sy.toFixed(3) + ') translate(-160 -304)');

        // Limbs
        var wob = Math.sin(t * 7) * midS * 10 * mo;
        E.armL.setAttribute('transform', 'rotate(' + (12 + M.aL * 70 * mo + wob).toFixed(1) + ' 66 205)');
        E.armR.setAttribute('transform', 'rotate(' + (-(12 + M.aR * 70 * mo) - wob).toFixed(1) + ' 254 205)');
        E.ant.setAttribute('transform', 'rotate(' + M.ant.toFixed(1) + ' 160 46)');
        E.footL.setAttribute('transform', 'translate(0 ' + (-M.aL * 10 * mo).toFixed(1) + ')');
        E.footR.setAttribute('transform', 'translate(0 ' + (-M.aR * 10 * mo).toFixed(1) + ')');
        var sh = 1 + M.hop / 300;
        E.shadow.setAttribute('transform', 'translate(160 320) scale(' + sh.toFixed(3) + ' 1) translate(-160 -320)');
        E.shadow.setAttribute('opacity', (0.18 + M.hop / 500).toFixed(3));

        // Speaker belly
        E.woofer.setAttribute('transform', 'translate(160 252) scale(' + (1 + bassS * 0.2).toFixed(3) + ') translate(-160 -252)');
        E.cone.setAttribute('transform', 'translate(160 252) scale(' + (1 - bassS * 0.25).toFixed(3) + ') translate(-160 -252)');

        // Face
        var ps = 1 + bassS * 0.18 + M.boop * 0.3;
        E.pupL.setAttribute('transform', 'translate(' + M.p[0].x.toFixed(2) + ' ' + M.p[0].y.toFixed(2) + ') translate(122 142) scale(' + ps.toFixed(3) + ') translate(-122 -142)');
        E.pupR.setAttribute('transform', 'translate(' + M.p[1].x.toFixed(2) + ' ' + M.p[1].y.toFixed(2) + ') translate(198 142) scale(' + ps.toFixed(3) + ') translate(-198 -142)');

        M.blinkT -= dt;
        if (M.blinkT < 0 && M.bp < 0) { M.bp = 0; M.blinkT = 2 + Math.random() * 4; }
        if (M.bp >= 0) { M.bp += dt / 0.16; if (M.bp >= 1) M.bp = -1; }
        M.lid += ((playing ? 0 : 32) - M.lid) * ease(dt, 6);
        var lid = Math.max(M.lid, M.bp >= 0 ? 62 * Math.sin(Math.PI * M.bp) : 0);
        var ly = (106 + lid).toFixed(1);
        E.lidL.setAttribute('height', lid.toFixed(1)); E.lidR.setAttribute('height', lid.toFixed(1));
        E.lineL.setAttribute('y1', ly); E.lineL.setAttribute('y2', ly); E.lineR.setAttribute('y1', ly); E.lineR.setAttribute('y2', ly);
        var lo = lid > 1 ? 1 : 0;
        E.lineL.setAttribute('opacity', lo); E.lineR.setAttribute('opacity', lo);

        E.brows.setAttribute('transform', 'translate(0 ' + (-M.brow * 7 * mo + (playing ? 0 : 3)).toFixed(1) + ')');

        var open = playing ? clamp(bassS * 1.0 + midS * 0.6 + M.boop, 0, 1) : M.boop;
        M.mouth += (open - M.mouth) * ease(dt, 20);
        var w = 22 + M.mouth * 5, depth = 7 + M.mouth * 36;
        var md = 'M' + (160 - w).toFixed(1) + ' 188L' + (160 + w).toFixed(1) + ' 188Q160 ' + (188 + depth * 2).toFixed(1) + ' ' + (160 - w).toFixed(1) + ' 188Z';
        E.mouth.setAttribute('d', md);
        E.mouthClip.setAttribute('d', md);
        E.tongue.setAttribute('cy', (188 + depth * 0.85).toFixed(1));
        E.tongue.setAttribute('ry', clamp((depth - 12) * 0.28, 0, 9).toFixed(1));
    }

    /* ------------------------------------------------------------------ */
    /*  Stage canvas: sunburst rays, ring, liquid wave                     */
    /* ------------------------------------------------------------------ */
    var c2 = (mode !== 'none' && canvas.getContext) ? canvas.getContext('2d') : null;
    function resize() {
        dpr = Math.min(2, window.devicePixelRatio || 1);
        canvas.width = Math.max(1, Math.round(canvas.clientWidth * dpr));
        canvas.height = Math.max(1, Math.round(canvas.clientHeight * dpr));
    }

    function angleFor(j) { return Math.PI / 2 + (j / (2 * N)) * Math.PI * 2; }
    function levelFor(j) { return lv[j < N ? j : 2 * N - 1 - j]; }

    function drawRays(cx, cy, s) {
        c2.lineCap = 'round';
        c2.lineWidth = 6 * s;
        c2.strokeStyle = cfg.accent2;
        var r0 = 132 * s;
        c2.beginPath();
        for (var j = 0; j < 2 * N; j++) {
            var a = angleFor(j), v = levelFor(j) * (j % 2 ? 0.6 : 1);
            var len = (5 + v * 95) * s;
            c2.moveTo(cx + Math.cos(a) * r0, cy + Math.sin(a) * r0);
            c2.lineTo(cx + Math.cos(a) * (r0 + len), cy + Math.sin(a) * (r0 + len));
        }
        c2.stroke();
    }

    function drawRing(cx, cy, s) {
        var pts = [], j;
        for (j = 0; j < 2 * N; j++) {
            var a = angleFor(j), r = (132 + levelFor(j) * 80) * s;
            pts.push([cx + Math.cos(a) * r, cy + Math.sin(a) * r]);
        }
        c2.beginPath();
        var n = pts.length, m0 = [(pts[n - 1][0] + pts[0][0]) / 2, (pts[n - 1][1] + pts[0][1]) / 2];
        c2.moveTo(m0[0], m0[1]);
        for (j = 0; j < n; j++) {
            var p = pts[j], nx = pts[(j + 1) % n];
            c2.quadraticCurveTo(p[0], p[1], (p[0] + nx[0]) / 2, (p[1] + nx[1]) / 2);
        }
        c2.closePath();
        c2.globalAlpha = 0.3; c2.fillStyle = cfg.accent2; c2.fill();
        c2.globalAlpha = 1; c2.lineWidth = 4 * dpr; c2.strokeStyle = inkColor; c2.stroke();
    }

    function drawWave(W, H, t) {
        var layers = [
            { c: cfg.accent,  a: 0.35, amp: 10, f: 0.012, sp: 1.1,  off: 0,   dy: 14, stroke: false },
            { c: cfg.accent2, a: 0.6,  amp: 14, f: 0.017, sp: -1.6, off: 1.7, dy: 0,  stroke: true }
        ];
        var base = H * 0.8 - energy * H * 0.05;
        layers.forEach(function (L) {
            c2.beginPath();
            c2.moveTo(0, H);
            for (var x = 0; x <= W; x += 6) {
                var u = x / W, d = Math.abs(u - 0.5) * 2;
                var idx = clamp(Math.floor((1 - d) * (N - 1)), 1, N - 2);
                var l = (lv[idx - 1] + lv[idx] + lv[idx + 1]) / 3;
                var cssX = x / dpr;
                var y = base + L.dy * dpr - (Math.sin(cssX * L.f + t * L.sp + L.off) * L.amp * 0.6 + l * L.amp * 3.4 * (0.4 + d * 0.8)) * dpr;
                c2.lineTo(x, y);
            }
            c2.lineTo(W, H);
            c2.closePath();
            c2.globalAlpha = L.a; c2.fillStyle = L.c; c2.fill();
            c2.globalAlpha = 1;
            if (L.stroke) { c2.lineWidth = 3 * dpr; c2.strokeStyle = inkColor; c2.stroke(); }
        });
    }

    function stageDraw(t, r) {
        if (!c2) return;
        var cr = canvas.getBoundingClientRect(), W = canvas.width, H = canvas.height;
        c2.clearRect(0, 0, W, H);
        var sc = r.width / 320, s = sc * dpr;
        var cx = (r.left - cr.left + r.width / 2) * dpr, cy = (r.top - cr.top + 200 * sc) * dpr;
        if (mode === 'wave' || mode === 'all') drawWave(W, H, t);
        if (mode === 'bars' || mode === 'all') drawRays(cx, cy, s);
        if (mode === 'circular') drawRing(cx, cy, s);
    }

    /* ------------------------------------------------------------------ */
    /*  Loop + lifecycle                                                   */
    /* ------------------------------------------------------------------ */
    function frame(now) {
        raf = requestAnimationFrame(frame);
        if (!root.isConnected) { destroy(); return; }
        var dt = Math.min(0.05, (now - last) / 1000);
        last = now;
        if (!visible) return;
        var t = now / 1000;
        sample(dt, t);
        var r = svg.getBoundingClientRect();
        mascot(dt, t, r);
        stageDraw(t, r);
    }

    var io = null, ro = null;
    function destroy() {
        if (destroyed) return;
        destroyed = true;
        cancelAnimationFrame(raf);
        stopAudio();
        window.removeEventListener('pointermove', onPointer);
        if (io) io.disconnect();
        if (ro) ro.disconnect();
        if (ctx) { try { ctx.close(); } catch (e) {} }
    }

    if ('IntersectionObserver' in window) {
        io = new IntersectionObserver(function (en) { visible = en[0].isIntersecting; }, { threshold: 0 });
        io.observe(root);
    }
    if ('ResizeObserver' in window) {
        ro = new ResizeObserver(resize);
        ro.observe(canvas);
    } else { window.addEventListener('resize', resize); }
    resize();
    raf = requestAnimationFrame(frame);

    loadTracks();
})();
</script>
