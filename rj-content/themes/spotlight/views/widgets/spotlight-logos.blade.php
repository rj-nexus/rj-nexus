@php
    $uid = 'logos_' . substr(md5(uniqid('', true)), 0, 8);

    $title    = $settings['title_text'] ?? '';
    $marquee  = filter_var($settings['marquee'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $speed    = max(8, (int) ($settings['speed'] ?? 40));          // seconds per full loop
    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft  = $settings['hud_left'] ?? '[ 02 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ PARTNERS ]';

    /**
     * GitHub raw/blob links are served as text/plain + nosniff, so browsers refuse to
     * render SVGs from them. jsDelivr serves the right MIME type:
     *   cdn.jsdelivr.net/gh/{user}/{repo}@{branch}/{path}
     */
    $toCdn = function (string $url): string {
        if (preg_match('#^https?://raw\.githubusercontent\.com/([^/]+)/([^/]+)/([^/]+)/(.+)$#i', $url, $m)
            || preg_match('#^https?://github\.com/([^/]+)/([^/]+)/(?:blob|raw)/([^/]+)/(.+)$#i', $url, $m)) {
            return "https://cdn.jsdelivr.net/gh/{$m[1]}/{$m[2]}@{$m[3]}/{$m[4]}";
        }
        return $url;
    };

    // One logo per line:  URL  or  URL | Name
    $logos = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['logos'] ?? '')) as $line) {
        $line = trim($line);
        if ($line === '') continue;
        [$u, $n] = array_pad(explode('|', $line, 2), 2, '');
        $u = trim($u);
        if ($u === '') continue;
        $logos[] = ['src' => $toCdn($u), 'name' => trim($n) ?: 'LOGO ' . (count($logos) + 1)];
    }

    // Enough copies so the loop never shows a gap on wide screens
    $copies = $marquee && $logos ? max(2, (int) ceil(2600 / max(1, count($logos) * 220)) + 1) : 1;
    $shift  = round(100 / $copies, 4);
@endphp

<section class="rj-lg" id="{{ $uid }}">
    {{-- Glass top edge: frosted band that melts the hero into this section --}}
    <div class="rj-lg-glass" aria-hidden="true"></div>

    <div class="rj-lg-inner">
        @if($title)
            <div class="rj-lg-badge">
                <span class="rj-lg-bars"><i></i><i></i><i></i></span>
                <span class="rj-lg-badge-t">{{ $title }}</span>
                <span class="rj-lg-bars"><i></i><i></i><i></i></span>
            </div>
        @endif

        @if($logos)
            <div class="rj-lg-viewport {{ $marquee ? 'is-marquee' : 'is-static' }}">
                <div class="rj-lg-track">
                    @for($c = 0; $c < $copies; $c++)
                        <div class="rj-lg-set" @if($c > 0) aria-hidden="true" @endif>
                            @foreach($logos as $i => $logo)
                                <div class="rj-lg-item" style="--i: {{ $i }};">
                                    <img src="{{ $logo['src'] }}" alt="{{ $c === 0 ? $logo['name'] : '' }}"
                                         loading="lazy" decoding="async" referrerpolicy="no-referrer"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                    <span class="rj-lg-fallback" style="display:none;">{{ $logo['name'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        @endif
    </div>

    {{-- HUD + line + corner marks live ONLY at the bottom --}}
    @if($showHud)
        <div class="rj-lg-hud rj-lg-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-lg-hud rj-lg-hr">{{ $hudRight }}<b></b></div>
    @endif
    <span class="rj-lg-line"><i></i><i></i></span>

    <style>
        #{{ $uid }}.rj-lg {
            --ov: 48px; /* how far the glass overlaps the bottom of the hero */
            position: relative; z-index: 3; width: 100%;
            margin-top: calc(var(--ov) * -1);
            padding: calc(var(--ov) + 64px) 0 96px;
            overflow: hidden; background: none; color: #fff;
            pointer-events: none; /* never block the hero's buttons under the overlap */
        }
        #{{ $uid }} .rj-lg-inner, #{{ $uid }} .rj-lg-hud { pointer-events: auto; }

        /* ---------- Glass top ---------- */
        #{{ $uid }} .rj-lg-glass {
            position: absolute; left: 0; right: 0; top: 0; height: 190px; z-index: 0;
            background:
                linear-gradient(to bottom, rgba(255,255,255,.12) 0%, rgba(255,255,255,.05) 45%, rgba(255,255,255,0) 100%);
            -webkit-backdrop-filter: blur(16px) saturate(160%);
                    backdrop-filter: blur(16px) saturate(160%);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.28);
            -webkit-mask-image: linear-gradient(to bottom, #000 0%, #000 40%, transparent 100%);
                    mask-image: linear-gradient(to bottom, #000 0%, #000 40%, transparent 100%);
        }

        #{{ $uid }} .rj-lg-inner {
            position: relative; z-index: 1;
            display: flex; flex-direction: column; align-items: center; gap: 52px;
        }

        #{{ $uid }} .rj-lg-badge { display: flex; align-items: center; gap: 14px; padding: 0 20px; text-align: center; }
        #{{ $uid }} .rj-lg-bars { display: inline-flex; gap: 3px; height: 15px; flex: none; }
        #{{ $uid }} .rj-lg-bars i { width: 3px; background: #fff; }
        #{{ $uid }} .rj-lg-bars i:nth-child(3) { opacity: .35; }
        #{{ $uid }} .rj-lg-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-lg-badge-t {
            font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .1em; text-transform: uppercase; color: #fff;
        }

        #{{ $uid }} .rj-lg-viewport { width: 100%; }
        #{{ $uid }} .rj-lg-set { display: flex; align-items: center; flex: none; gap: 90px; padding-right: 90px; }
        #{{ $uid }} .rj-lg-item { display: flex; align-items: center; justify-content: center; flex: none; min-height: 34px; }

        /* Logos are ALWAYS white, whatever color the source file is */
        #{{ $uid }} .rj-lg-item img {
            display: block; height: 30px; max-width: 150px; width: auto; object-fit: contain;
            filter: brightness(0) invert(1); opacity: .6;
            transition: opacity .3s ease, transform .3s cubic-bezier(.2,.8,.2,1), filter .3s ease;
        }
        #{{ $uid }} .rj-lg-item:hover img {
            opacity: 1; transform: scale(1.08);
            filter: brightness(0) invert(1) drop-shadow(0 0 10px rgba(255,255,255,.6));
        }
        #{{ $uid }} .rj-lg-fallback {
            align-items: center; padding: 8px 14px; border: 1px dashed rgba(255,255,255,.3);
            font: 700 12px/1 ui-monospace, Menlo, Consolas, monospace; letter-spacing: .1em; color: #fff; white-space: nowrap;
        }

        /* ---------- Marquee: always runs, never pauses ---------- */
        #{{ $uid }} .is-marquee {
            overflow: hidden;
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent);
                    mask-image: linear-gradient(90deg, transparent, #000 12%, #000 88%, transparent);
        }
        #{{ $uid }} .is-marquee .rj-lg-track {
            display: flex; width: max-content; will-change: transform;
            animation: rjLgScroll {{ $speed }}s linear infinite;
            animation-play-state: running;
        }

        /* Static grid (only when marquee is switched off) */
        #{{ $uid }} .is-static .rj-lg-track { display: flex; justify-content: center; padding: 0 24px; }
        #{{ $uid }} .is-static .rj-lg-set { flex-wrap: wrap; justify-content: center; gap: 56px 80px; padding-right: 0; }
        #{{ $uid }} .is-static .rj-lg-item { opacity: 0; animation: rjLgIn .8s ease forwards; animation-delay: calc(var(--i) * .1s); }

        @keyframes rjLgScroll {
            from { transform: translate3d(0, 0, 0); }
            to   { transform: translate3d(-{{ $shift }}%, 0, 0); }
        }
        @keyframes rjLgIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }

        /* ---------- Bottom line, + marks and HUD ---------- */
        #{{ $uid }} .rj-lg-line { position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background: rgba(255,255,255,.14); }
        #{{ $uid }} .rj-lg-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-lg-line i::before, #{{ $uid }} .rj-lg-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-lg-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-lg-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-lg-line i:first-child { left: 18px; }
        #{{ $uid }} .rj-lg-line i:last-child { right: 18px; }

        #{{ $uid }} .rj-lg-hud {
            position: absolute; bottom: 22px; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.75);
        }
        #{{ $uid }} .rj-lg-hl { left: 22px; } #{{ $uid }} .rj-lg-hr { right: 22px; }
        #{{ $uid }} .rj-lg-hud b { display: block; width: 3px; height: 26px; background: #fff; }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-lg { --ov: 32px; padding: calc(var(--ov) + 48px) 0 80px; }
            #{{ $uid }} .rj-lg-glass { height: 140px; }
            #{{ $uid }} .rj-lg-inner { gap: 36px; }
            #{{ $uid }} .rj-lg-bars { display: none; }
            #{{ $uid }} .rj-lg-set { gap: 56px; padding-right: 56px; }
            #{{ $uid }} .rj-lg-item img { height: 22px; max-width: 110px; }
        }
    </style>
</section>
