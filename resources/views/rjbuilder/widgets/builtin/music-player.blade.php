@php
    $hex = function ($v, $d) {
        $v = is_string($v) ? trim($v) : '';
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $inkFor = function ($c) {
        $c = ltrim($c, '#');
        if (strlen($c) === 3) { $c = $c[0].$c[0].$c[1].$c[1].$c[2].$c[2]; }
        $rgb = array_map('hexdec', str_split($c, 2));
        return (0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2]) > 150 ? '#0f172a' : '#ffffff';
    };
    $bool = fn ($v, $d = false) => $v === null ? $d : filter_var($v, FILTER_VALIDATE_BOOLEAN);

    $title        = $settings['title'] ?? __('Now Playing');
    $source       = in_array(($settings['source'] ?? 'audius'), ['audius', 'jamendo', 'deezer', 'itunes', 'local', 'custom'], true) ? $settings['source'] : 'audius';
    $visualizer   = in_array(($settings['visualizer'] ?? 'all'), ['all', 'bars', 'circular', 'wave', 'none'], true) ? ($settings['visualizer'] ?? 'all') : 'all';
    $accent       = $hex($settings['accent'] ?? null, '#8b5cf6');
    $accent2      = $hex($settings['accent2'] ?? null, '#fb923c');
    $theme        = ($settings['theme'] ?? 'paper') === 'night' ? 'night' : 'paper';
    $height       = max(320, (int) ($settings['height'] ?? 400));
    $showPlaylist = $bool($settings['show_playlist'] ?? null, true);
    $autoplay     = $bool($settings['autoplay'] ?? null, false);
    $shuffle      = $bool($settings['shuffle'] ?? null, false);
    $shadow       = $bool($settings['shadow'] ?? null, true);
    $paddingY     = (int) ($settings['padding_y'] ?? 40);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'xl' => '20px', '2xl' => '28px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'xl'] ?? '20px';

    $vars = $theme === 'night'
        ? ['bg' => '#0f172a', 'bg2' => '#1e293b', 'ink' => '#f1f5f9', 'muted' => '#94a3b8', 'line' => '#334155', 'glow' => 'rgba(255, 255, 255, .08)']
        : ['bg' => '#ffffff', 'bg2' => '#f8fafc', 'ink' => '#0f172a', 'muted' => '#64748b', 'line' => '#e2e8f0', 'glow' => 'rgba(255, 255, 255, .75)'];

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
        --accent: {{ $accent }};
        --accent2: {{ $accent2 }};
        --a-ink: {{ $inkFor($accent) }};
        --r: {{ $radiusCss }};
        --bg: {{ $vars['bg'] }};
        --bg2: {{ $vars['bg2'] }};
        --ink: {{ $vars['ink'] }};
        --muted: {{ $vars['muted'] }};
        --line: {{ $vars['line'] }};
        --glow: {{ $vars['glow'] }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        color: var(--ink);
        font-family: inherit;

        *, *::before, *::after { box-sizing: border-box; }
        [hidden] { display: none !important; }

        .mp-card { display: grid; grid-template-columns: minmax(300px, 5fr) 6fr; max-width: 1040px; min-height: {{ $height }}px; margin: 0 auto; overflow: hidden; border: 1px solid var(--line); border-radius: var(--r); background: var(--bg); box-shadow: {{ $shadow ? '0 40px 80px -36px rgba(15, 23, 42, .35)' : 'none' }}; }

        /* ---------- Stage: orbs, equalizer canvas and the 4 characters ---------- */
        .mp-stage { position: relative; container-type: inline-size; overflow: hidden; border-right: 1px solid var(--line); background: radial-gradient(circle at 18% 12%, var(--glow), transparent 42%), linear-gradient(160deg, color-mix(in srgb, var(--accent) 12%, var(--bg)), color-mix(in srgb, var(--accent) 34%, var(--bg))); }
        .mp-orb { position: absolute; border-radius: 50%; background: color-mix(in srgb, var(--accent) 20%, transparent); animation: rj-mp-drift 12s ease-in-out infinite alternate;
            &:nth-of-type(1) { top: -8cqw; right: -10cqw; width: 44cqw; height: 44cqw; }
            &:nth-of-type(2) { bottom: 22cqw; left: -12cqw; width: 30cqw; height: 30cqw; animation-delay: -5s; }
        }
        .mp-canvas { position: absolute; inset: 0; z-index: 1; width: 100%; height: 100%; pointer-events: none; }

        .mp-tag { position: absolute; top: clamp(16px, 6cqw, 40px); left: clamp(16px, 6cqw, 32px); z-index: 6; display: inline-flex; align-items: center; gap: 8px; max-width: 80%; padding: 9px 16px; border-radius: 999px; background: var(--bg); color: var(--ink); font-size: 13.5px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; box-shadow: 0 14px 28px -14px rgba(15, 23, 42, .4);
            &::before { content: ""; flex-shrink: 0; width: 8px; height: 8px; border-radius: 50%; background: var(--muted); opacity: .45; }
        }
        &.is-playing .mp-tag::before { background: var(--accent); opacity: 1; animation: rj-mp-blink 1s steps(2) infinite; }

        .mp-zz { position: absolute; z-index: 6; left: 54cqw; bottom: 50cqw; pointer-events: none;
            i { position: absolute; left: 0; bottom: 0; font-style: normal; font-size: 5cqw; font-weight: 900; color: var(--accent); opacity: 0; }
            i:nth-child(2) { left: 4cqw; }
            i:nth-child(3) { left: 8cqw; }
        }
        &.is-paused .mp-zz i { animation: rj-mp-z 3s ease-in-out infinite; }
        &.is-paused .mp-zz i:nth-child(2) { animation-delay: 1s; }
        &.is-paused .mp-zz i:nth-child(3) { animation-delay: 2s; }

        .mp-cast { position: absolute; inset: auto 0 0; z-index: 3; height: 66cqw; cursor: pointer; touch-action: manipulation; -webkit-tap-highlight-color: transparent; }

        .c { position: absolute; bottom: 0; transform-origin: 50% 100%; transform: skewX(calc(var(--lx, 0) * -1.8deg)); translate: 0 calc(var(--hop, 0) * 1cqw); scale: 1 var(--sq, 1); rotate: calc(var(--rot, 0) * 1deg);
            .eyes { position: absolute; top: var(--et); left: 50%; display: flex; gap: var(--eg); translate: -50% 0; }
            .eye { display: block; transition: transform .3s; animation: rj-mp-blink-eye 5.5s infinite var(--d); }
            .eye.w { display: grid; place-items: center; width: var(--es, 6cqw); height: var(--es, 6cqw); border-radius: 50%; background: #fff;
                i { width: 46%; height: 46%; border-radius: 50%; background: #0f172a; translate: calc(var(--lx, 0) * 1.1cqw) calc(var(--ly, 0) * 1.1cqw); }
            }
            .eye.d { width: 2.6cqw; height: 3.6cqw; border-radius: 50%; background: #0f172a; translate: calc(var(--lx, 0) * 1.4cqw) calc(var(--ly, 0) * 1cqw); }
            .m { position: absolute; top: var(--mt); left: 50%; width: var(--mw, 6cqw); height: calc(var(--mh, 0) * 1cqw); translate: -50% 0; border: .55cqw solid var(--mc, #0f172a); border-top: 0; border-radius: 0 0 6cqw 6cqw; }
        }
        .c-p { z-index: 1; left: 17cqw; width: 31cqw; height: 62cqw; border-radius: 3.5cqw 3.5cqw 0 0; background: var(--accent); --et: 9cqw; --eg: 4.5cqw; --es: 6.5cqw; --mt: 21cqw; --mw: 7cqw; --mc: rgba(255, 255, 255, .85); }
        .c-b { z-index: 2; left: 46cqw; width: 21cqw; height: 46cqw; border-radius: 3cqw 3cqw 0 0; background: #1f2937; --et: 8cqw; --eg: 3.5cqw; --es: 5.5cqw; --mt: 17cqw; --mw: 5cqw; --mc: rgba(255, 255, 255, .85); }
        .c-o { z-index: 3; left: 3cqw; width: 41cqw; height: 31cqw; border-radius: 20.5cqw 20.5cqw 0 0; background: #fb923c; --et: 13cqw; --eg: 9cqw; --mt: 20cqw; --mw: 7cqw; }
        .c-y { z-index: 4; left: 62cqw; width: 25cqw; height: 37cqw; border-radius: 12.5cqw 12.5cqw 0 0; background: #facc15; --et: 10cqw; --eg: 5.5cqw; --mt: 19cqw; --mw: 6cqw; }

        &.is-paused .eye { transform: scaleY(.08); }

        /* ---------- Panel ---------- */
        .mp-panel { display: flex; flex-direction: column; justify-content: center; gap: 18px; min-width: 0; padding: clamp(24px, 4vw, 44px); }

        .mp-now { display: flex; align-items: center; gap: 16px; min-width: 0; }
        .mp-cover { flex-shrink: 0; width: 84px; height: 84px; overflow: hidden; border: 1px solid var(--line); border-radius: 16px; background: var(--bg2); box-shadow: 0 14px 28px -16px rgba(15, 23, 42, .45);
            img { display: block; width: 100%; height: 100%; object-fit: cover; }
        }
        .mp-meta { min-width: 0; }
        .mp-now-title { display: -webkit-box; margin: 0 0 6px; overflow: hidden; overflow-wrap: anywhere; -webkit-box-orient: vertical; -webkit-line-clamp: 2; font-size: clamp(22px, 3vw, 30px); font-weight: 800; line-height: 1.15; letter-spacing: -.02em; }
        .mp-now-artist { margin: 0; overflow: hidden; color: var(--muted); font-size: 14px; white-space: nowrap; text-overflow: ellipsis; }
        .mp-status { margin: -6px 0 0; color: var(--muted); font-size: 13px;
            &:empty { display: none; }
        }

        .mp-seek { display: flex; align-items: center; gap: 12px; color: var(--muted); font-size: 12px; font-weight: 600; font-variant-numeric: tabular-nums; }

        input[type="range"] { -webkit-appearance: none; appearance: none; flex: 1; min-width: 0; height: 22px; margin: 0; background: transparent; cursor: pointer;
            &:disabled { cursor: default; opacity: .5; }
            &::-webkit-slider-runnable-track { height: 6px; border-radius: 999px; background: linear-gradient(to right, var(--accent) var(--p, 0%), var(--line) var(--p, 0%)); }
            &::-webkit-slider-thumb { -webkit-appearance: none; width: 16px; height: 16px; margin-top: -5px; border: 3px solid var(--accent); border-radius: 50%; background: var(--bg); box-shadow: 0 4px 10px -3px color-mix(in srgb, var(--accent) 60%, transparent); }
            &::-moz-range-track { height: 6px; border-radius: 999px; background: var(--line); }
            &::-moz-range-progress { height: 6px; border-radius: 999px; background: var(--accent); }
            &::-moz-range-thumb { width: 10px; height: 10px; border: 3px solid var(--accent); border-radius: 50%; background: var(--bg); }
            &:focus-visible { outline: 3px solid color-mix(in srgb, var(--accent) 35%, transparent); outline-offset: 2px; border-radius: 999px; }
        }

        .mp-controls { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }
        .mp-btn { position: relative; display: grid; place-items: center; width: 44px; height: 44px; padding: 0; border: 1.5px solid var(--line); border-radius: 12px; background: var(--bg); color: var(--muted); cursor: pointer; transition: .2s;
            svg { width: 22px; height: 22px; fill: currentColor; }
            &:hover { border-color: var(--accent); color: var(--accent); }
            &:active { transform: scale(.95); }
            &:focus-visible { outline: 3px solid color-mix(in srgb, var(--accent) 35%, transparent); outline-offset: 2px; }
            &[aria-pressed="true"], &[data-state="all"], &[data-state="one"] { border-color: var(--accent); background: color-mix(in srgb, var(--accent) 12%, var(--bg)); color: var(--accent); }
            &[data-state="one"]::after { content: "1"; position: absolute; right: 5px; bottom: 3px; font-size: 10px; font-weight: 800; }
        }
        .mp-play { position: relative; overflow: hidden; width: 60px; height: 60px; border: 0; border-radius: 16px; background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 70%, #0f172a)); color: var(--a-ink); box-shadow: 0 16px 28px -14px var(--accent);
            svg { width: 28px; height: 28px; }
            &:hover { color: var(--a-ink); filter: brightness(1.07); }
            &::after { content: ""; position: absolute; top: 0; bottom: 0; left: -60%; width: 40%; background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .4), transparent); transform: skewX(-20deg); animation: rj-mp-shine 3.6s ease-in-out infinite; }
            .ic-pause { display: none; }
        }
        &.is-playing .mp-play .ic-play { display: none; }
        &.is-playing .mp-play .ic-pause { display: block; }

        .mp-vol { display: flex; align-items: center; gap: 8px; width: 150px; margin-left: auto;
            .mp-btn { flex-shrink: 0; width: 38px; height: 38px; border-color: transparent; }
            .mp-btn svg { width: 20px; height: 20px; }
            .ic-mute { display: none; }
        }
        &.is-muted .mp-vol .ic-vol { display: none; }
        &.is-muted .mp-vol .ic-mute { display: block; }

        .mp-list { flex: 1; min-height: 120px; max-height: 240px; margin: 0; padding: 0; overflow-y: auto; border: 1px solid var(--line); border-radius: 16px; background: var(--bg); list-style: none; scrollbar-width: thin;
            li + li .mp-row { border-top: 1px solid var(--line); }
        }
        .mp-row { display: flex; align-items: center; gap: 12px; width: 100%; padding: 10px 16px; border: 0; background: transparent; color: inherit; font: inherit; text-align: left; cursor: pointer; transition: background .2s;
            &:hover { background: var(--bg2); }
            &:focus-visible { outline: 3px solid color-mix(in srgb, var(--accent) 35%, transparent); outline-offset: -3px; }
            &.is-active { background: color-mix(in srgb, var(--accent) 10%, var(--bg)); color: var(--accent); }
            &.is-active .mp-num { display: none; }
            &.is-active .mp-eq { display: flex; }
        }
        .mp-num { width: 24px; flex-shrink: 0; color: var(--muted); font-size: 13px; font-weight: 700; text-align: center; font-variant-numeric: tabular-nums; }
        .mp-eq { display: none; align-items: flex-end; justify-content: center; gap: 2px; width: 24px; height: 16px; flex-shrink: 0;
            i { display: block; width: 4px; height: 100%; border-radius: 2px; background: currentColor; transform: scaleY(.35); transform-origin: bottom; }
        }
        &.is-playing .mp-row.is-active .mp-eq i { animation: rj-mp-eq .7s ease-in-out infinite alternate; }
        &.is-playing .mp-row.is-active .mp-eq i:nth-child(2) { animation-delay: .2s; }
        &.is-playing .mp-row.is-active .mp-eq i:nth-child(3) { animation-delay: .4s; }
        .mp-rowinfo { display: flex; flex: 1; flex-direction: column; min-width: 0;
            strong { overflow: hidden; font-size: 14px; font-weight: 700; white-space: nowrap; text-overflow: ellipsis; }
            small { overflow: hidden; color: var(--muted); font-size: 12px; white-space: nowrap; text-overflow: ellipsis; }
        }
        .mp-dur { color: var(--muted); font-size: 12px; font-variant-numeric: tabular-nums; }
        .mp-empty { padding: 22px 16px; color: var(--muted); font-size: 14px; }

        @media (max-width: 820px) {
            .mp-card { grid-template-columns: 1fr; min-height: 0; }
            .mp-stage { aspect-ratio: 4 / 3; border-right: 0; border-bottom: 1px solid var(--line); }
            .mp-cast { scale: .78; transform-origin: 50% 100%; }
            .mp-zz { bottom: 44cqw; }
            .mp-vol { width: 100%; margin-left: 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    }

    @keyframes rj-mp-eq { to { transform: scaleY(1); } }
    @keyframes rj-mp-blink { 50% { opacity: .25; } }
    @keyframes rj-mp-blink-eye { 0%, 93%, 100% { scale: 1 1; } 96% { scale: 1 .1; } }
    @keyframes rj-mp-drift { to { translate: 4cqw 3cqw; } }
    @keyframes rj-mp-shine { 0%, 55% { left: -60%; } 100% { left: 130%; } }
    @keyframes rj-mp-z {
        0%   { opacity: 0; translate: 0 6px; }
        25%  { opacity: 1; }
        80%  { opacity: 0; translate: 8px -18px; }
        100% { opacity: 0; }
    }
</style>

<div id="{{ $uid }}" class="is-paused">
    <div class="mp-card">

        <div class="mp-stage" aria-hidden="false">
            <span class="mp-orb"></span><span class="mp-orb"></span>
            <canvas class="mp-canvas" data-canvas aria-hidden="true"></canvas>
            @if($title !== '')
                <span class="mp-tag">{{ $title }}</span>
            @endif
            <div class="mp-zz" aria-hidden="true"><i>z</i><i>z</i><i>z</i></div>

            <div class="mp-cast" data-cast aria-hidden="true">
                <div class="c c-p" style="--d:0s">
                    <div class="eyes"><span class="eye w"><i></i></span><span class="eye w"><i></i></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-b" style="--d:.4s">
                    <div class="eyes"><span class="eye w"><i></i></span><span class="eye w"><i></i></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-o" style="--d:.8s">
                    <div class="eyes"><span class="eye d"></span><span class="eye d"></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-y" style="--d:1.2s">
                    <div class="eyes"><span class="eye d"></span><span class="eye d"></span></div>
                    <span class="m"></span>
                </div>
            </div>
        </div>

        <div class="mp-panel">
            <div class="mp-now">
                <div class="mp-cover" data-cover hidden><img alt="" data-cover-img></div>
                <div class="mp-meta">
                    <h3 class="mp-now-title" data-now-title>{{ __('Pick a track to start') }}</h3>
                    <p class="mp-now-artist" data-now-artist></p>
                </div>
            </div>

            <p class="mp-status" data-status role="status" aria-live="polite"></p>

            <div class="mp-seek">
                <span data-time-cur>0:00</span>
                <input type="range" min="0" max="1000" step="1" value="0" data-seek aria-label="{{ __('Seek') }}">
                <span data-time-total>0:00</span>
            </div>

            <div class="mp-controls">
                <button type="button" class="mp-btn" data-shuffle aria-pressed="false" aria-label="{{ __('Shuffle') }}">
                    <svg viewBox="0 0 24 24"><path d="M10.59 9.17L5.41 4 4 5.41l5.17 5.17 1.42-1.41zM14.5 4l2.04 2.04L4 18.59 5.41 20 17.96 7.46 20 9.5V4h-5.5zm.33 9.41l-1.41 1.41 3.13 3.13L14.5 20H20v-5.5l-2.04 2.04-3.13-3.13z"/></svg>
                </button>
                <button type="button" class="mp-btn" data-prev aria-label="{{ __('Previous track') }}">
                    <svg viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/></svg>
                </button>
                <button type="button" class="mp-btn mp-play" data-play aria-label="{{ __('Play') }}">
                    <svg class="ic-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg class="ic-pause" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>
                <button type="button" class="mp-btn" data-next aria-label="{{ __('Next track') }}">
                    <svg viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/></svg>
                </button>
                <button type="button" class="mp-btn" data-repeat data-state="off" aria-label="{{ __('Repeat: off') }}">
                    <svg viewBox="0 0 24 24"><path d="M7 7h10v3l4-4-4-4v3H5v6h2V7zm10 10H7v-3l-4 4 4 4v-3h12v-6h-2v4z"/></svg>
                </button>

                <div class="mp-vol">
                    <button type="button" class="mp-btn" data-mute aria-label="{{ __('Mute') }}">
                        <svg class="ic-vol" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                        <svg class="ic-mute" viewBox="0 0 24 24"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51A8.8 8.8 0 0021 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06a8.99 8.99 0 003.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                    </button>
                    <input type="range" min="0" max="1" step="0.01" value="0.8" data-volume aria-label="{{ __('Volume') }}">
                </div>
            </div>

            @if($showPlaylist)
                <ol class="mp-list" data-list aria-label="{{ __('Playlist') }}"></ol>
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
    var canvas = q('[data-canvas]'), castEl = q('[data-cast]');
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
            var li = document.createElement('li'); li.className = 'mp-empty'; li.textContent = T.loading; listEl.appendChild(li); return;
        }
        if (!tracks.length) {
            var li2 = document.createElement('li'); li2.className = 'mp-empty'; li2.textContent = T.empty; listEl.appendChild(li2); return;
        }
        tracks.forEach(function (t, i) {
            var li = document.createElement('li'), b = document.createElement('button');
            b.type = 'button'; b.className = 'mp-row';
            var num = document.createElement('span'); num.className = 'mp-num'; num.textContent = String(i + 1);
            var eq = document.createElement('span'); eq.className = 'mp-eq'; eq.setAttribute('aria-hidden', 'true'); eq.innerHTML = '<i></i><i></i><i></i>';
            var info = document.createElement('span'); info.className = 'mp-rowinfo';
            var s1 = document.createElement('strong'); s1.textContent = t.title || '';
            var s2 = document.createElement('small'); s2.textContent = t.artist || '';
            info.appendChild(s1); info.appendChild(s2);
            b.appendChild(num); b.appendChild(eq); b.appendChild(info);
            if (t.duration) { var d = document.createElement('span'); d.className = 'mp-dur'; d.textContent = fmt(t.duration); b.appendChild(d); }
            b.addEventListener('click', function () { wantPlay = true; loadTrack(i, true); });
            li.appendChild(b); listEl.appendChild(li);
        });
        markActive();
    }
    function markActive() {
        if (!listEl) return;
        var rows = listEl.querySelectorAll('.mp-row');
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
            // Server has no CORS headers: play it natively without the analyser (characters keep dancing in simulated mode)
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
    /*  The 4 characters: hop on the beat, eyes follow the pointer,        */
    /*  mouths open with the bass, they fall asleep when paused            */
    /* ------------------------------------------------------------------ */
    var SIZE = [0.7, 0.55, 1, 0.9];
    var CH = Array.prototype.map.call(root.querySelectorAll('.c'), function (el, i) {
        return { el: el, size: SIZE[i] || 0.8, hop: 0, hv: 0, land: 0, sway: 0, lx: 0, ly: 0, mouth: 0 };
    });
    var beatN = 0, boop = 0;
    var mouse = { x: 0, y: 0, t: 0, on: false };
    var wander = { x: 0, y: 0, t: 0 };

    function onBeat(strength) {
        beatN++;
        CH.forEach(function (c, i) {
            if ((i + beatN) % 2 === 0 || strength > 0.7) {
                c.hv = -(38 + 48 * strength * c.size) * mo;
                c.sway = (i % 2 ? 1 : -1) * (1 + 3 * strength) * mo;
            }
        });
    }

    function onPointer(e) { mouse.x = e.clientX; mouse.y = e.clientY; mouse.t = performance.now() / 1000; mouse.on = true; }
    window.addEventListener('pointermove', onPointer, { passive: true });
    castEl.addEventListener('click', function () {
        boop = 1;
        CH.forEach(function (c) { c.hv = -(60 + 20 * c.size) * mo; });
    });

    function cast(dt, t) {
        var now = performance.now() / 1000;
        var active = mouse.on && (now - mouse.t) < 4;

        if (!active && now > wander.t) { wander.t = now + 1.4 + Math.random() * 2; wander.x = Math.random() * 2 - 1; wander.y = Math.random() * 0.9 - 0.3; }

        // read first, write after (avoids layout thrash)
        var rects = CH.map(function (c) { return c.el.getBoundingClientRect(); });

        boop *= Math.exp(-dt * 4);

        CH.forEach(function (c, i) {
            var r = rects[i], tx, ty;
            if (active) {
                var dx = mouse.x - (r.left + r.width / 2), dy = mouse.y - (r.top + r.height * 0.2);
                var d = Math.sqrt(dx * dx + dy * dy) || 1, k = Math.min(1, d / 160);
                tx = dx / d * k; ty = dy / d * k;
            } else { tx = wander.x * 0.8; ty = wander.y * 0.7; }
            c.lx += (tx - c.lx) * ease(dt, 12);
            c.ly += (ty - c.ly) * ease(dt, 12);

            // hop physics (units: cqw)
            c.hv += 400 * dt;
            c.hop += c.hv * dt;
            if (c.hop > 0) { if (c.hv > 25) c.land = Math.min(1, c.hv / 80); c.hop = 0; c.hv = 0; }
            c.land *= Math.exp(-dt * 12);
            c.sway *= Math.exp(-dt * 3);

            var sq = 1 + Math.sin(t * 2.2 + i) * 0.012 - 0.035 * bassS * mo - 0.07 * c.land * mo + (c.hop < -0.5 ? Math.min(0.04, -c.hop / 100) : 0);
            var rot = c.sway + Math.sin(t * 2.6 + i) * midS * 1.5 * mo;

            var open = playing ? clamp(bassS * 1.0 + midS * 0.6 + boop, 0, 1) : boop;
            c.mouth += (open - c.mouth) * ease(dt, 18);
            var mh = (playing ? 2 : 0) + c.mouth * 4;

            var st = c.el.style;
            st.setProperty('--lx', c.lx.toFixed(3));
            st.setProperty('--ly', c.ly.toFixed(3));
            st.setProperty('--hop', c.hop.toFixed(2));
            st.setProperty('--sq', sq.toFixed(3));
            st.setProperty('--rot', rot.toFixed(2));
            st.setProperty('--mh', mh.toFixed(2));
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Stage canvas: soft equalizer bars, ring, layered waves             */
    /* ------------------------------------------------------------------ */
    var c2 = (mode !== 'none' && canvas.getContext) ? canvas.getContext('2d') : null;
    function resize() {
        dpr = Math.min(2, window.devicePixelRatio || 1);
        canvas.width = Math.max(1, Math.round(canvas.clientWidth * dpr));
        canvas.height = Math.max(1, Math.round(canvas.clientHeight * dpr));
    }

    function levelAt(u) {
        var d = Math.abs(u - 0.5) * 2;
        return lv[clamp(Math.floor((1 - d) * (N - 1)), 0, N - 1)];
    }

    function drawBars(W, H) {
        var n = 36, gap = W * 0.012, margin = W * 0.06, bw = (W - 2 * margin - gap * (n - 1)) / n;
        c2.fillStyle = cfg.accent;
        for (var k = 0; k < n; k++) {
            var l = levelAt((k + 0.5) / n), h = (0.04 + l * 0.62) * H, x = margin + k * (bw + gap);
            c2.globalAlpha = 0.18 + l * 0.3;
            c2.beginPath();
            if (c2.roundRect) c2.roundRect(x, H - h, bw, h, bw / 2); else c2.rect(x, H - h, bw, h);
            c2.fill();
        }
        c2.globalAlpha = 1;
    }

    function drawRing(W, H) {
        var cx = W / 2, cy = H * 0.5, R = Math.min(W, H) * 0.3, n = 2 * N, pts = [], j;
        for (j = 0; j < n; j++) {
            var a = Math.PI / 2 + (j / n) * Math.PI * 2, l = lv[j < N ? j : n - 1 - j], r = R + l * R * 0.45;
            pts.push([cx + Math.cos(a) * r, cy + Math.sin(a) * r]);
        }
        c2.beginPath();
        c2.moveTo((pts[n - 1][0] + pts[0][0]) / 2, (pts[n - 1][1] + pts[0][1]) / 2);
        for (j = 0; j < n; j++) {
            var p = pts[j], nx = pts[(j + 1) % n];
            c2.quadraticCurveTo(p[0], p[1], (p[0] + nx[0]) / 2, (p[1] + nx[1]) / 2);
        }
        c2.closePath();
        c2.globalAlpha = 0.18; c2.fillStyle = cfg.accent; c2.fill();
        c2.globalAlpha = 0.7; c2.lineWidth = 3 * dpr; c2.strokeStyle = cfg.accent2; c2.stroke();
        c2.globalAlpha = 1;
    }

    function drawWave(W, H, t) {
        var layers = [
            { c: cfg.accent,  a: 0.22, amp: 10, f: 0.012, sp: 1.1,  off: 0,   dy: 14, stroke: false },
            { c: cfg.accent2, a: 0.3,  amp: 14, f: 0.017, sp: -1.6, off: 1.7, dy: 0,  stroke: true }
        ];
        var base = H * 0.78 - energy * H * 0.05;
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
            if (L.stroke) { c2.globalAlpha = 0.8; c2.lineWidth = 2 * dpr; c2.strokeStyle = L.c; c2.stroke(); }
            c2.globalAlpha = 1;
        });
    }

    function stageDraw(t) {
        if (!c2) return;
        var W = canvas.width, H = canvas.height;
        c2.clearRect(0, 0, W, H);
        if (mode === 'wave' || mode === 'all') drawWave(W, H, t);
        if (mode === 'bars' || mode === 'all') drawBars(W, H);
        if (mode === 'circular') drawRing(W, H);
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
        cast(dt, t);
        stageDraw(t);
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
