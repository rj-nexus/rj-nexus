@php
    $uid = 'pricing_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft  = $settings['hud_left'] ?? '[ 05 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ PRICING ]';
    $badge    = $settings['badge_text'] ?? '';
    $title    = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $note     = $settings['note'] ?? '';
    $cur      = $settings['currency'] ?? '$';
    $toggleOn = filter_var($settings['billing_toggle'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $lblM     = $settings['monthly_label'] ?? 'Monthly';
    $lblY     = $settings['yearly_label'] ?? 'Yearly';
    $saveText = $settings['save_text'] ?? 'Save 20%';

    $raw = $settings['plans'] ?? '';

    // Əgər köhnə versiyadan qalan massiv (array) formasındadırsa, onu mətnə çeviririk
    if (is_array($raw)) {
        $built = [];
        foreach ($raw as $item) {
            if (is_array($item)) {
                $b = "";
                if (!empty($item['plan_name'])) $b .= "Name: " . $item['plan_name'] . "\n";
                if (isset($item['price'])) $b .= "Price: " . str_replace('$', '', $item['price']) . "\n";
                if (!empty($item['period'])) $b .= "Period: " . $item['period'] . "\n";
                if (!empty($item['description'])) $b .= "Desc: " . $item['description'] . "\n";
                if (!empty($item['is_popular'])) $b .= "Featured: yes\n";
                if (!empty($item['button_text'])) $b .= "Button: " . $item['button_text'] . " | " . ($item['button_url'] ?? '#') . "\n";
                if (!empty($item['features'])) {
                    if (is_string($item['features'])) {
                        $b .= "- " . str_replace("\n", "\n- ", trim($item['features'])) . "\n";
                    } elseif (is_array($item['features'])) {
                        $b .= "- " . implode("\n- ", $item['features']) . "\n";
                    }
                }
                $built[] = trim($b);
            } else {
                $built[] = (string) $item;
            }
        }
        $raw = implode("\n---\n", $built);
    } else {
        $raw = trim((string) $raw);
    }

    if ($raw === '') {
        $raw = "Name: Starter\nPrice: 0\nDesc: Everything you need to start creating.\nButton: Get started | /register\n- 50 AI generations / month\n- 1 workspace\n- Community support\n- ~Priority generation\n- ~Custom models\n---\nName: Pro\nBadge: Most popular\nFeatured: yes\nPrice: 29\nYearly: 24\nDesc: For creators and teams who ship every week.\nButton: Start free trial | /register\n- Unlimited generations\n- Multi-model engine\n- 10 workspaces\n- Priority support\n- Export in 4K\n---\nName: Business\nPrice: 99\nYearly: 79\nDesc: Advanced control for growing companies.\nButton: Contact sales | /contact\n- Everything in Pro\n- Unlimited seats\n- Custom model tuning\n- SSO and audit logs\n- Dedicated manager";
    }

    /*
     * Plan format (blocks separated by a line with only ---):
     *   Name: Pro            Price: 29        Yearly: 24      Period: /month
     *   Desc: short text     Badge: Popular   Featured: yes   Hue: 265
     *   Button: Text | URL
     *   - feature            - ~feature that is NOT included
     */
    $plans = [];
    foreach (preg_split('/^\s*---\s*$/m', $raw) as $block) {
        $p = ['name' => '', 'price' => '', 'yearly' => '', 'period' => '/month', 'desc' => '', 'badge' => '',
              'featured' => false, 'btn' => '', 'url' => '#', 'hue' => null, 'features' => []];
        foreach (preg_split('/\r\n|\r|\n/', $block) as $line) {
            $line = trim($line);
            if ($line === '') continue;
            if ($line[0] === '-') {
                $t = trim(substr($line, 1));
                $off = $t !== '' && $t[0] === '~';
                if ($off) $t = trim(substr($t, 1));
                if ($t !== '') $p['features'][] = ['t' => $t, 'off' => $off];
                continue;
            }
            if (preg_match('/^([A-Za-z]+)\s*:\s*(.*)$/u', $line, $m)) {
                $k = strtolower($m[1]); $v = trim($m[2]);
                if ($k === 'name') $p['name'] = $v;
                elseif ($k === 'price') $p['price'] = $v;
                elseif ($k === 'yearly') $p['yearly'] = $v;
                elseif ($k === 'period') $p['period'] = $v;
                elseif ($k === 'desc') $p['desc'] = $v;
                elseif ($k === 'badge') $p['badge'] = $v;
                elseif ($k === 'featured') $p['featured'] = in_array(strtolower($v), ['yes', 'true', '1', 'on'], true);
                elseif ($k === 'hue') $p['hue'] = max(0, min(360, (int) $v));
                elseif ($k === 'button') { $b = array_pad(array_map('trim', explode('|', $v, 2)), 2, '#'); $p['btn'] = $b[0]; $p['url'] = $b[1] ?: '#'; }
            }
        }
        if ($p['name'] !== '') $plans[] = $p;
    }
    $plans = array_slice($plans, 0, 4);

    $defaultHues = [217, 265, 160, 30];
    $decimals = fn($v) => str_contains((string) $v, '.') ? strlen(explode('.', (string) $v)[1]) : 0;
    $hasYearly = collect($plans)->contains(fn($p) => is_numeric($p['yearly']));
    $showToggle = $toggleOn && $hasYearly;
@endphp

<section class="rj-pr" id="{{ $uid }}" data-mode="m">

    <div class="rj-pr-inner">

        @if($badge || $title || $subtitle)
            <div class="rj-pr-header">
                @if($badge)
                    <div class="rj-pr-badge-top">
                        <span class="rj-pr-bars"><i></i><i></i><i></i></span>
                        <span class="rj-pr-badge-t">{{ $badge }}</span>
                        <span class="rj-pr-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif
                @if($title)<h2 class="rj-pr-title">{{ $title }}</h2>@endif
                @if($subtitle)<p class="rj-pr-sub">{{ $subtitle }}</p>@endif

                @if($showToggle)
                    <div class="rj-pr-toggle" role="group" aria-label="Billing period">
                        <span class="rj-pr-thumb"></span>
                        <button type="button" class="rj-pr-tbtn is-on" data-mode="m" aria-pressed="true">{{ $lblM }}</button>
                        <button type="button" class="rj-pr-tbtn" data-mode="y" aria-pressed="false">
                            {{ $lblY }} @if($saveText)<em>{{ $saveText }}</em>@endif
                        </button>
                    </div>
                @endif
            </div>
        @endif

        <div class="rj-pr-grid" style="--n: {{ max(1, count($plans)) }};">
            @foreach($plans as $i => $p)
                @php
                    $hue = $p['hue'] ?? $defaultHues[$i % 4];
                    $numeric = is_numeric($p['price']);
                    $yNum = is_numeric($p['yearly']);
                    $dec = max($decimals($p['price']), $decimals($p['yearly']));
                    $fmt = fn($v) => number_format((float) $v, $dec);
                @endphp
                <article class="rj-pr-card {{ $p['featured'] ? 'is-featured' : '' }}" style="--h: {{ $hue }}; --i: {{ $i }};">
                    <span class="rj-pr-fx">
                        <span class="rj-pr-glow"></span>
                        <span class="rj-pr-cone"></span>
                        @for($s = 0; $s < 5; $s++)
                            <span class="rj-pr-spark" style="--x: {{ ($s * 19 + 10) % 90 }}%; --d: {{ number_format($s * 0.6, 2) }}s; --t: {{ 3.8 + ($s % 3) * 0.9 }}s;"></span>
                        @endfor
                    </span>
                    <span class="rj-pr-lamp"></span>
                    @if($p['featured'])<span class="rj-pr-ring"></span>@endif

                    <div class="rj-pr-in">
                        @if($p['badge'])<span class="rj-pr-tag">{{ $p['badge'] }}</span>@endif
                        <h3 class="rj-pr-name">{{ $p['name'] }}</h3>
                        @if($p['desc'])<p class="rj-pr-desc">{{ $p['desc'] }}</p>@endif

                        <div class="rj-pr-price {{ $numeric ? '' : 'is-text' }}">
                            @if($numeric)
                                <span class="rj-pr-cur">{{ $cur }}</span>
                                <span class="rj-pr-amount" data-dec="{{ $dec }}" data-now="{{ (float) $p['price'] }}"
                                      data-m="{{ (float) $p['price'] }}" data-y="{{ $yNum ? (float) $p['yearly'] : (float) $p['price'] }}">{{ $fmt($p['price']) }}</span>
                                <span class="rj-pr-per">{{ $p['period'] }}</span>
                            @else
                                <span class="rj-pr-amount-text">{{ $p['price'] }}</span>
                            @endif
                        </div>
                        <div class="rj-pr-billed">
                            @if($numeric && $yNum)<span class="rj-pr-billed-y">Billed {{ $cur }}{{ number_format((float) $p['yearly'] * 12, $dec) }} yearly</span>@endif
                        </div>

                        @if($p['btn'])
                            <a href="{{ $p['url'] }}" class="rj-pr-btn">
                                <span>{{ $p['btn'] }}</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endif

                        <ul class="rj-pr-list">
                            @foreach($p['features'] as $k => $f)
                                <li class="{{ $f['off'] ? 'is-off' : '' }}" style="--k: {{ $k }};">
                                    <i>
                                        @if($f['off'])
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" d="M7 7l10 10M17 7L7 17"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5l4.2 4.2L19 7"/></svg>
                                        @endif
                                    </i>
                                    <span>{{ $f['t'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>

        @if($note)<p class="rj-pr-note">{{ $note }}</p>@endif
    </div>

    {{-- Line, + marks and HUD only at the bottom --}}
    @if($showHud)
        <div class="rj-pr-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-pr-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif
    <span class="rj-pr-line"><i></i><i></i></span>

    <style>
        #{{ $uid }}.rj-pr { position: relative; width: 100%; overflow: hidden; background: transparent; color: #fff; padding: 120px 24px 150px; }
        #{{ $uid }}.rj-pr::before { /* light falling from above */
            content: ''; position: absolute; left: 50%; top: -10%; width: 90%; height: 70%; translate: -50% 0; pointer-events: none;
            background: radial-gradient(ellipse at 50% 0%, hsl(217 90% 55% / .16), transparent 65%);
        }
        #{{ $uid }} .rj-pr-inner { position: relative; z-index: 1; max-width: var(--rj-container, 1200px); margin: 0 auto; }

        /* Section off-screen: pause every infinite animation (big CPU/GPU saver) */
        #{{ $uid }}.rj-idle *, #{{ $uid }}.rj-idle *::before, #{{ $uid }}.rj-idle *::after { animation-play-state: paused !important; }

        /* ---------- Header ---------- */
        #{{ $uid }} .rj-pr-header { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 72px; }
        #{{ $uid }} .rj-pr-badge-top { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-pr-bars { display: inline-flex; align-items: center; gap: 3px; height: 15px; }
        #{{ $uid }} .rj-pr-bars i { width: 3px; height: 100%; background: #fff; animation: rjPrBar 2.2s ease-in-out infinite; }
        #{{ $uid }} .rj-pr-bars i:nth-child(2) { animation-delay: .18s; }
        #{{ $uid }} .rj-pr-bars i:nth-child(3) { animation-delay: .36s; }
        #{{ $uid }} .rj-pr-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjPrBar { 0%, 100% { transform: scaleY(.3); opacity: .45; } 50% { transform: scaleY(1); opacity: 1; } }
        #{{ $uid }} .rj-pr-badge-t { font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .1em; text-transform: uppercase; color: #fff; }
        #{{ $uid }} .rj-pr-title {
            margin: 0 0 20px; font-size: clamp(34px, 5vw, 58px); font-weight: 500; line-height: 1.08; letter-spacing: -.035em;
            background: linear-gradient(180deg, #fff, hsl(217 70% 86%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px hsl(217 90% 60% / .3));
        }
        #{{ $uid }} .rj-pr-sub { margin: 0; max-width: 620px; font-size: clamp(16px, 1.8vw, 19px); line-height: 1.6; color: rgba(255,255,255,.68); }

        /* Billing toggle */
        #{{ $uid }} .rj-pr-toggle {
            position: relative; display: inline-flex; margin-top: 36px; padding: 5px; border-radius: 999px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.12); box-shadow: inset 0 1px 0 rgba(255,255,255,.12);
            -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);
        }
        #{{ $uid }} .rj-pr-thumb {
            position: absolute; left: 0; top: 5px; bottom: 5px; width: 0; border-radius: 999px; pointer-events: none;
            background: linear-gradient(160deg, rgba(255,255,255,.2), rgba(255,255,255,.08)); border: 1px solid rgba(255,255,255,.22);
            box-shadow: 0 0 24px hsl(217 90% 60% / .35); transition: transform .5s cubic-bezier(.2,.8,.2,1), width .5s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-pr-tbtn {
            position: relative; z-index: 1; display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border: 0; border-radius: 999px; cursor: pointer;
            background: none; color: rgba(255,255,255,.6); font-family: inherit; font-size: 14px; font-weight: 500; line-height: 1; transition: color .3s;
        }
        #{{ $uid }} .rj-pr-tbtn.is-on, #{{ $uid }} .rj-pr-tbtn:hover { color: #fff; }
        #{{ $uid }} .rj-pr-tbtn em {
            font: 700 10px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-style: normal; letter-spacing: .06em; text-transform: uppercase;
            padding: 4px 7px; border-radius: 999px; color: #04130b; background: hsl(150 85% 62%); box-shadow: 0 0 14px hsl(150 90% 55% / .6);
        }

        /* ---------- Grid + cards ---------- */
        #{{ $uid }} .rj-pr-grid { display: grid; grid-template-columns: repeat(var(--n), minmax(0, 1fr)); gap: 26px; align-items: stretch; }
        #{{ $uid }} .rj-pr-card {
            --mx: 50%; --my: 0%; --rx: 0deg; --ry: 0deg;
            position: relative; display: flex; flex-direction: column; border-radius: 26px; overflow: hidden; isolation: isolate;
            background: linear-gradient(160deg, rgba(255,255,255,.075), rgba(255,255,255,.015) 45%, rgba(255,255,255,.035));
            border: 1px solid rgba(255,255,255,.1);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.13);
            -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);   /* saturate() removed: it is the most expensive part */
            transform: perspective(1100px) rotateX(var(--rx)) rotateY(var(--ry));
            contain: layout style;
            transition: transform .35s cubic-bezier(.2,.8,.2,1), translate .5s cubic-bezier(.2,.8,.2,1), scale .5s cubic-bezier(.2,.8,.2,1), opacity .5s, box-shadow .5s;
        }
        #{{ $uid }} .rj-pr-card.is-featured { translate: 0 -14px; box-shadow: inset 0 1px 0 rgba(255,255,255,.18), inset 0 0 90px -30px hsl(var(--h) 90% 55% / .28); }
        #{{ $uid }} .rj-pr-card:hover { translate: 0 -8px; box-shadow: inset 0 1px 0 rgba(255,255,255,.2), inset 0 0 100px -30px hsl(var(--h) 90% 55% / .35); }
        #{{ $uid }} .rj-pr-card.is-featured:hover { translate: 0 -20px; }
        /* when one card is hovered, the others step back (class set by JS instead of :has + filter) */
        #{{ $uid }} .rj-pr-grid.is-dim .rj-pr-card:not(.is-hover) { opacity: .55; scale: .985; }

        /* border light that follows the cursor */
        #{{ $uid }} .rj-pr-card::before {
            content: ''; position: absolute; inset: 0; z-index: 4; border-radius: inherit; padding: 1px; pointer-events: none;
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor;
                    mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
            background: radial-gradient(260px circle at var(--mx) var(--my), hsl(var(--h) 100% 82%), hsl(var(--h) 95% 62% / .55) 40%, transparent 70%);
            opacity: 0; transition: opacity .4s;
        }
        #{{ $uid }} .rj-pr-card:hover::before { opacity: 1; }

        /* rotating beam (featured card): now a transform rotation, so it runs on the GPU instead of repainting every frame */
        #{{ $uid }} .rj-pr-ring {
            position: absolute; inset: 0; z-index: 4; border-radius: inherit; padding: 1px; overflow: hidden; pointer-events: none;
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor;
                    mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
        }
        #{{ $uid }} .rj-pr-ring::before {
            content: ''; position: absolute; left: 50%; top: 50%; width: 240%; aspect-ratio: 1 / 1; translate: -50% -50%;
            background: conic-gradient(transparent 0 62%, hsl(var(--h) 95% 60% / .9) 82%, #fff 92%, transparent 100%);
            will-change: transform; animation: rjPrSpin 9s linear infinite; /* beam speed: change 9s */
        }
        @keyframes rjPrSpin { to { rotate: 360deg; } }

        /* effects layer: clipped to the card and faded out near the edges, so nothing is cut sharply or leaves the card */
        #{{ $uid }} .rj-pr-fx {
            position: absolute; inset: 0; z-index: 0; pointer-events: none; border-radius: inherit; overflow: hidden;
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 48px, #000 calc(100% - 48px), transparent), linear-gradient(180deg, #000 calc(100% - 80px), transparent);
            -webkit-mask-composite: source-in;
                    mask-image: linear-gradient(90deg, transparent, #000 48px, #000 calc(100% - 48px), transparent), linear-gradient(180deg, #000 calc(100% - 80px), transparent);
                    mask-composite: intersect;
        }

        /* light inside the card: a fixed-size glow moved with transform (no gradient repaint on mouse move) */
        #{{ $uid }} .rj-pr-glow {
            position: absolute; left: 0; top: 0; width: 520px; height: 520px; z-index: 0; pointer-events: none; opacity: 0; transition: opacity .45s;
            translate: calc(var(--mx) - 260px) calc(var(--my) - 260px); will-change: translate, opacity;
            background: radial-gradient(circle, hsl(var(--h) 90% 60% / .2), transparent 60%);
        }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-glow { opacity: 1; }
        #{{ $uid }} .rj-pr-cone {
            position: absolute; top: 0; left: 50%; width: 100%; height: 180px; translate: -50% 0; scale: .7 1; z-index: 0; pointer-events: none; opacity: .35; filter: blur(14px);
            background: linear-gradient(to bottom, hsl(var(--h) 95% 70% / .5), transparent); clip-path: polygon(42% 0, 58% 0, 100% 100%, 0 100%);
            transition: opacity .5s, scale .6s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-pr-card.is-featured .rj-pr-cone { opacity: .55; }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-cone { opacity: .95; scale: .9 1; }
        #{{ $uid }} .rj-pr-lamp {
            position: absolute; top: -1px; left: 50%; width: 74%; height: 2px; translate: -50% 0; scale: .405 1; z-index: 5; pointer-events: none;
            background: linear-gradient(90deg, transparent, hsl(var(--h) 100% 88%), transparent); box-shadow: 0 0 22px 3px hsl(var(--h) 95% 65% / .85);
            transition: scale .6s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-lamp { scale: 1 1; }

        /* sparks that rise on hover (only run while hovering) */
        #{{ $uid }} .rj-pr-spark { position: absolute; bottom: -6px; left: var(--x); width: 3px; height: 3px; border-radius: 50%; z-index: 1; opacity: 0; pointer-events: none; background: hsl(var(--h) 100% 85%); box-shadow: 0 0 8px 2px hsl(var(--h) 95% 65%); }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-spark { animation: rjPrRise var(--t) ease-out var(--d) infinite; }
        @keyframes rjPrRise { 0% { transform: translateY(0) scale(.6); opacity: 0; } 15% { opacity: 1; } 100% { transform: translateY(-300px) scale(1.1); opacity: 0; } }

        /* ---------- Card content ---------- */
        #{{ $uid }} .rj-pr-in { position: relative; z-index: 2; display: flex; flex-direction: column; flex: 1; padding: 34px 30px 32px; }
        #{{ $uid }} .rj-pr-tag {
            position: absolute; top: 24px; right: 24px; padding: 6px 11px; border-radius: 999px; overflow: hidden;
            font: 700 10px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .1em; text-transform: uppercase; color: #fff;
            background: linear-gradient(120deg, hsl(var(--h) 85% 48%), hsl(calc(var(--h) + 30) 85% 55%)); box-shadow: 0 0 20px hsl(var(--h) 90% 55% / .55);
        }
        #{{ $uid }} .rj-pr-tag::after { content: ''; position: absolute; inset: 0; background: linear-gradient(100deg, transparent 30%, rgba(255,255,255,.55) 50%, transparent 70%); translate: -120% 0; animation: rjPrShine 4.8s ease-in-out infinite; }
        @keyframes rjPrShine { 0%, 55% { translate: -120% 0; } 100% { translate: 120% 0; } }

        #{{ $uid }} .rj-pr-name { margin: 0 0 8px; font: 700 13px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .16em; text-transform: uppercase; color: hsl(var(--h) 90% 78%); }
        #{{ $uid }} .rj-pr-desc { margin: 0 0 26px; min-height: 3.1em; font-size: 14.5px; line-height: 1.55; color: rgba(255,255,255,.62); }

        #{{ $uid }} .rj-pr-price { display: flex; align-items: baseline; gap: 4px; }
        #{{ $uid }} .rj-pr-cur { font-size: 26px; font-weight: 500; color: rgba(255,255,255,.7); align-self: flex-start; margin-top: 10px; }
        #{{ $uid }} .rj-pr-amount, #{{ $uid }} .rj-pr-amount-text {
            font-size: 60px; font-weight: 500; line-height: 1; letter-spacing: -.045em; font-variant-numeric: tabular-nums;
            background: linear-gradient(180deg, #fff 20%, hsl(var(--h) 80% 82%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 16px hsl(var(--h) 90% 60% / .28));
        }
        #{{ $uid }} .rj-pr-price.is-text .rj-pr-amount-text { font-size: 44px; }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-amount, #{{ $uid }} .rj-pr-card:hover .rj-pr-amount-text { filter: drop-shadow(0 0 26px hsl(var(--h) 95% 65% / .65)); }
        #{{ $uid }} .rj-pr-per { font-size: 15px; color: rgba(255,255,255,.5); }
        #{{ $uid }} .rj-pr-billed { height: 20px; margin: 8px 0 22px; font: 600 11px/20px ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .06em; color: hsl(150 80% 70%); }
        #{{ $uid }} .rj-pr-billed-y { opacity: 0; transform: translateY(6px); display: inline-block; transition: opacity .4s, transform .4s; }
        #{{ $uid }}[data-mode="y"] .rj-pr-billed-y { opacity: 1; transform: none; }

        /* button with shimmer sweep */
        #{{ $uid }} .rj-pr-btn {
            position: relative; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 22px; border-radius: 12px;
            font-size: 15px; font-weight: 600; text-decoration: none; color: #fff; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.16);
            transition: transform .3s, box-shadow .3s, background .3s, border-color .3s;
        }
        #{{ $uid }} .rj-pr-btn svg { width: 17px; height: 17px; transition: transform .3s; }
        #{{ $uid }} .rj-pr-btn::after { content: ''; position: absolute; inset: 0; background: linear-gradient(100deg, transparent 30%, rgba(255,255,255,.4) 50%, transparent 70%); translate: -130% 0; }
        #{{ $uid }} .rj-pr-btn:hover { transform: translateY(-2px); border-color: hsl(var(--h) 90% 70% / .7); background: hsl(var(--h) 90% 60% / .22); box-shadow: 0 10px 30px hsl(var(--h) 95% 55% / .45); color: #fff; }
        #{{ $uid }} .rj-pr-btn:hover::after { translate: 130% 0; transition: translate .8s ease; }
        #{{ $uid }} .rj-pr-btn:hover svg { transform: translateX(4px); }
        #{{ $uid }} .is-featured .rj-pr-btn { background: #fff; color: #05070d; border-color: #fff; }
        #{{ $uid }} .is-featured .rj-pr-btn:hover { background: hsl(var(--h) 90% 66%); border-color: hsl(var(--h) 90% 66%); color: #fff; }

        /* feature list */
        #{{ $uid }} .rj-pr-list { list-style: none; margin: 30px 0 0; padding: 26px 0 0; border-top: 1px solid rgba(255,255,255,.09); display: flex; flex-direction: column; gap: 14px; }
        #{{ $uid }} .rj-pr-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 14.5px; line-height: 1.45; color: rgba(255,255,255,.78); transition: translate .35s, color .35s; }
        #{{ $uid }} .rj-pr-list li i {
            flex: none; width: 20px; height: 20px; margin-top: 1px; display: flex; align-items: center; justify-content: center; border-radius: 50%;
            color: hsl(var(--h) 95% 80%); background: hsl(var(--h) 90% 60% / .16); border: 1px solid hsl(var(--h) 90% 70% / .35);
        }
        #{{ $uid }} .rj-pr-list li i svg { width: 11px; height: 11px; }
        #{{ $uid }} .rj-pr-list li.is-off { opacity: .4; }
        #{{ $uid }} .rj-pr-list li.is-off i { color: rgba(255,255,255,.6); background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.14); }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-list li:not(.is-off) { translate: 4px 0; color: #fff; }
        #{{ $uid }} .rj-pr-card:hover .rj-pr-list li:not(.is-off) i { animation: rjPrPing .7s ease both; animation-delay: calc(var(--k) * .07s); }
        @keyframes rjPrPing { 0% { transform: scale(1); } 40% { transform: scale(1.3); box-shadow: 0 0 16px hsl(var(--h) 95% 65% / .9); } 100% { transform: scale(1); box-shadow: 0 0 8px hsl(var(--h) 95% 65% / .35); } }

        #{{ $uid }} .rj-pr-note { margin: 56px 0 0; text-align: center; font: 700 11px/1.6 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.55); }

        /* reveal */
        #{{ $uid }}.rj-js:not(.is-in) .rj-pr-card { opacity: 0; }
        #{{ $uid }}.is-in .rj-pr-card { animation: rjPrIn .9s cubic-bezier(.2,.8,.2,1) calc(var(--i) * .12s) backwards; }
        @keyframes rjPrIn { from { opacity: 0; translate: 0 40px; } }

        /* Bottom line + HUD */
        #{{ $uid }} .rj-pr-line { position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background: rgba(255,255,255,.14); z-index: 2; }
        #{{ $uid }} .rj-pr-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-pr-line i::before, #{{ $uid }} .rj-pr-line i::after { content: ''; position: absolute; background: #fff; }
        #{{ $uid }} .rj-pr-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-pr-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-pr-line i:first-child { left: 18px; }
        #{{ $uid }} .rj-pr-line i:last-child { right: 18px; }
        #{{ $uid }} .rj-pr-hud { position: absolute; bottom: 22px; z-index: 3; display: flex; align-items: center; gap: 14px; font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.75); }
        #{{ $uid }} .rj-hl { left: 22px; } #{{ $uid }} .rj-hr { right: 22px; }
        #{{ $uid }} .rj-pr-hud b { display: block; width: 3px; height: 26px; background: #fff; }

        @media (max-width: 1100px) {
            #{{ $uid }} .rj-pr-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 720px) {
            #{{ $uid }}.rj-pr { padding: 90px 20px 130px; }
            #{{ $uid }} .rj-pr-grid { grid-template-columns: 1fr; max-width: 460px; margin: 0 auto; }
            #{{ $uid }} .rj-pr-card { -webkit-backdrop-filter: none; backdrop-filter: none; background: linear-gradient(160deg, rgba(255,255,255,.09), rgba(255,255,255,.03)); }
            #{{ $uid }} .rj-pr-card.is-featured { translate: 0 0; }
            #{{ $uid }} .rj-pr-bars { display: none; }
            #{{ $uid }} .rj-pr-desc { min-height: 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition: none !important; }
            #{{ $uid }}.rj-js:not(.is-in) .rj-pr-card { opacity: 1; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;
        root.classList.add('rj-js');

        // reveal once, and pause all infinite animations while the section is off-screen
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) {
                var on = e[0].isIntersecting;
                if (on) root.classList.add('is-in');
                root.classList.toggle('rj-idle', !on);
            }, { threshold: 0.05 }).observe(root);
        } else { root.classList.add('is-in'); }

        // monthly / yearly toggle with rolling numbers
        var btns = Array.prototype.slice.call(root.querySelectorAll('.rj-pr-tbtn'));
        var thumb = root.querySelector('.rj-pr-thumb');
        var amounts = root.querySelectorAll('.rj-pr-amount');
        var active = btns[0];

        function fmt(v, d) { return v.toLocaleString('en-US', { minimumFractionDigits: d, maximumFractionDigits: d }); }
        function tween(el, to) {
            var d = parseInt(el.getAttribute('data-dec'), 10) || 0;
            var from = parseFloat(el.getAttribute('data-now')), t0 = performance.now();
            el.setAttribute('data-now', to);
            (function step(t) {
                var k = Math.min(1, (t - t0) / 600), e = 1 - Math.pow(1 - k, 3);
                el.textContent = fmt(from + (to - from) * e, d);
                if (k < 1) requestAnimationFrame(step);
            })(t0);
        }
        function place() { if (thumb && active) { thumb.style.width = active.offsetWidth + 'px'; thumb.style.transform = 'translateX(' + active.offsetLeft + 'px)'; } }

        btns.forEach(function (b) {
            b.addEventListener('click', function () {
                if (b === active) return;
                active = b;
                var m = b.getAttribute('data-mode');
                root.setAttribute('data-mode', m);
                btns.forEach(function (x) { x.classList.toggle('is-on', x === b); x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
                place();
                amounts.forEach(function (el) { tween(el, parseFloat(el.getAttribute('data-' + m))); });
            });
        });
        if (btns.length) {
            if ('ResizeObserver' in window) new ResizeObserver(place).observe(root.querySelector('.rj-pr-toggle'));
            window.addEventListener('load', place);
            place();
        }

        // cursor spotlight + 3D tilt (only on devices with a real hover), throttled to one update per frame
        if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
            var grid = root.querySelector('.rj-pr-grid');
            root.querySelectorAll('.rj-pr-card').forEach(function (c) {
                var px = 0, py = 0, queued = false;

                function frame() {
                    queued = false;
                    var r = c.getBoundingClientRect(), x = px - r.left, y = py - r.top;
                    c.style.setProperty('--mx', x.toFixed(1) + 'px');
                    c.style.setProperty('--my', y.toFixed(1) + 'px');
                    c.style.setProperty('--ry', ((x / r.width - 0.5) * 9).toFixed(2) + 'deg');
                    c.style.setProperty('--rx', ((0.5 - y / r.height) * 7).toFixed(2) + 'deg');
                }

                c.addEventListener('pointerenter', function () {
                    c.classList.add('is-hover');
                    if (grid) grid.classList.add('is-dim');
                });
                c.addEventListener('pointermove', function (e) {
                    px = e.clientX; py = e.clientY;
                    if (!queued) { queued = true; requestAnimationFrame(frame); }
                });
                c.addEventListener('pointerleave', function () {
                    c.classList.remove('is-hover');
                    if (grid) grid.classList.remove('is-dim');
                    c.style.setProperty('--rx', '0deg');
                    c.style.setProperty('--ry', '0deg');
                });
            });
        }
    })();
    </script>
</section>
