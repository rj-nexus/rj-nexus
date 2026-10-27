@php
    $hex = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $v) ? $v : $d;
    };

    $title       = trim((string) ($settings['title'] ?? __('Try your luck!')));
    $subtitle    = trim((string) ($settings['subtitle'] ?? ''));
    $spinLabel   = trim((string) ($settings['spin_label'] ?? __('SPIN'))) ?: __('SPIN');
    $duration    = max(2000, min(15000, (int) ($settings['duration'] ?? 5000)));
    $sizePx      = ['sm' => 280, 'md' => 360, 'lg' => 440, 'xl' => 520][$settings['size'] ?? 'lg'] ?? 440;
    $pointer     = $hex($settings['pointer_color'] ?? '', '#0f172a');
    $rim         = $hex($settings['rim_color'] ?? '', '#0f172a');
    $hub         = $hex($settings['hub_color'] ?? '', '#8b5cf6');
    $hubText     = $hex($settings['hub_text_color'] ?? '', '#ffffff');
    $confettiOn  = !empty($settings['show_confetti'] ?? true);
    $modalOn     = !empty($settings['show_result_modal'] ?? true);
    $oneTime     = !empty($settings['one_time'] ?? false);
    $oneTimeMsg  = (string) ($settings['one_time_message'] ?? __('You have already spun the wheel!'));
    $claimed     = (string) ($settings['claimed_label'] ?? __('You won:'));
    $paddingY    = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));

    $palette  = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#84cc16', '#d946ef', '#f43f5e'];
    $segments = [];
    foreach ((array) ($settings['segments'] ?? []) as $i => $row) {
        if (!is_array($row) || trim((string) ($row['label'] ?? '')) === '') continue;
        $c = '#' . ltrim(trim((string) ($row['color'] ?? '')), '#');
        $segments[] = [
            'label'       => trim((string) $row['label']),
            'color'       => $hex($c, $palette[count($segments) % count($palette)]),
            'weight'      => (isset($row['weight']) && is_numeric($row['weight']) && (float) $row['weight'] > 0) ? (float) $row['weight'] : 1.0,
            'description' => trim((string) ($row['description'] ?? '')),
        ];
    }

    $n    = count($segments);
    $ok   = $n >= 2;
    $A    = $ok ? 360 / $n : 0;
    $pt   = fn ($r, $deg) => [200 + $r * sin(deg2rad($deg)), 200 - $r * cos(deg2rad($deg))];
    $geo  = [];
    $segJson = [];

    foreach ($segments as $i => $seg) {
        [$x1, $y1] = $pt(185, $i * $A);
        [$x2, $y2] = $pt(185, ($i + 1) * $A);
        $mid  = ($i + .5) * $A;
        $left = $mid > 180;
        $fs   = min(19, max(9, $A * .4));
        $max  = max(4, (int) floor(135 / ($fs * .6)));
        $geo[] = [
            'd'      => sprintf('M200 200L%.2F %.2F A185 185 0 %d 1 %.2F %.2F Z', $x1, $y1, $A > 180 ? 1 : 0, $x2, $y2),
            'peg'    => $pt(179, $i * $A),
            'x'      => $left ? 24 : 376,
            'anchor' => $left ? 'start' : 'end',
            'rot'    => round($left ? $mid - 270 : $mid - 90, 2),
            'fs'     => round($fs, 1),
            'text'   => mb_strlen($seg['label']) > $max ? mb_substr($seg['label'], 0, $max - 1) . '…' : $seg['label'],
        ];
        $segJson[] = [
            'label'       => $seg['label'],
            'color'       => $seg['color'],
            'weight'      => $seg['weight'],
            'description' => $seg['description'],
            'mid'         => $mid,
        ];
    }
@endphp

<style>
    #{{ $uid }} { --h: {{ $hub }}; width: 100%; padding: {{ $paddingY }}px 16px; display: flex; flex-direction: column; align-items: center; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .wf-head { max-width: 640px; margin-bottom: 36px; text-align: center; }
    #{{ $uid }} .wf-sub { margin: 0 0 10px; font-size: 13px; font-weight: 700; color: var(--h); }
    #{{ $uid }} .wf-title { margin: 0; font-size: clamp(30px, 5vw, 44px); font-weight: 800; letter-spacing: -.03em; color: #0f172a; }

    #{{ $uid }} .wf-stage { position: relative; width: min(100%, {{ $sizePx }}px); aspect-ratio: 1; user-select: none; filter: drop-shadow(0 30px 36px rgba(15, 23, 42, .28)); }
    #{{ $uid }} .wf-svg { display: block; width: 100%; height: 100%; overflow: visible; }
    #{{ $uid }} .wf-seg { transition: opacity .5s ease; }
    #{{ $uid }}.has-win .wf-seg:not(.is-win) { opacity: .35; }
    #{{ $uid }} .wf-seg.is-win { stroke: #fff; stroke-width: 3; stroke-linejoin: round; filter: brightness(1.12); }
    #{{ $uid }} .wf-t { fill: #fff; font-family: -apple-system, 'Segoe UI', sans-serif; font-weight: 800; paint-order: stroke fill; stroke: rgba(0, 0, 0, .28); stroke-width: 2px; pointer-events: none; }
    #{{ $uid }} .wf-peg { fill: #fff; stroke: rgba(0, 0, 0, .35); stroke-width: 1; }
    #{{ $uid }} .wf-pointer { transform-box: view-box; transform-origin: 200px 6px; filter: drop-shadow(0 4px 5px rgba(0, 0, 0, .4)); }
    #{{ $uid }} .wf-bulb { fill: #fde68a; opacity: .35; animation: wfChase 1.2s linear infinite; animation-delay: calc(var(--i) * -50ms); }
    #{{ $uid }}.is-spinning .wf-bulb { animation-duration: .45s; animation-delay: calc(var(--i) * -18.75ms); }
    #{{ $uid }}.is-celebrate .wf-bulb { animation: wfBlink .35s steps(1) infinite; }
    @keyframes wfChase { 0% { opacity: 1; filter: drop-shadow(0 0 5px #fbbf24); } 14%, 100% { opacity: .3; } }
    @keyframes wfBlink { 0% { opacity: 1; filter: drop-shadow(0 0 6px #fbbf24); } 50% { opacity: .3; } }

    #{{ $uid }} .wf-hub {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 24%;
        height: 24%;
        transform: translate(-50%, -50%);
        border: 4px solid #fff;
        border-radius: 50%;
        background: radial-gradient(circle at 35% 30%, color-mix(in srgb, var(--h) 70%, #fff), var(--h) 65%);
        color: {{ $hubText }};
        font-family: inherit;
        font-size: clamp(11px, 2.2vw, 18px);
        font-weight: 900;
        letter-spacing: .06em;
        cursor: pointer;
        box-shadow: 0 10px 26px rgba(0, 0, 0, .4);
        transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
    }
    #{{ $uid }} .wf-hub:hover:not(:disabled) { transform: translate(-50%, -50%) scale(1.08); }
    #{{ $uid }} .wf-hub:active:not(:disabled) { transform: translate(-50%, -50%) scale(.95); }
    #{{ $uid }} .wf-hub:disabled { cursor: wait; opacity: .85; }
    #{{ $uid }} .wf-hub:focus-visible { outline: 3px solid #0f172a; outline-offset: 4px; }
    #{{ $uid }} .wf-hub::after { content: ""; position: absolute; inset: -8px; border-radius: 50%; border: 2px solid var(--h); opacity: 0; }
    #{{ $uid }} .wf-hub:not(:disabled)::after { animation: wfPing 2.2s ease-out infinite; }
    @keyframes wfPing { 0% { transform: scale(.92); opacity: .7; } 100% { transform: scale(1.35); opacity: 0; } }

    #{{ $uid }} .wf-empty { max-width: 480px; padding: 40px 24px; text-align: center; color: #64748b; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; font-size: 14px; }

    #{{ $uid }} .wf-modal { position: fixed; inset: 0; z-index: 99990; display: none; align-items: center; justify-content: center; padding: 24px; background: rgba(2, 6, 23, .72); }
    #{{ $uid }} .wf-modal.is-open { display: flex; animation: wfFade .25s ease both; }
    #{{ $uid }} .wf-box { width: 100%; max-width: 400px; padding: 40px 32px 28px; text-align: center; background: #fff; border-radius: 24px; box-shadow: 0 40px 80px -20px rgba(0, 0, 0, .6); animation: wfPop .45s cubic-bezier(.34, 1.56, .64, 1) both; }
    @keyframes wfFade { from { opacity: 0; } }
    @keyframes wfPop { from { opacity: 0; transform: scale(.85) translateY(20px); } }
    #{{ $uid }} .wf-emoji { margin-bottom: 10px; font-size: 52px; line-height: 1; }
    #{{ $uid }} .wf-label { margin: 0 0 8px; font-size: 13px; font-weight: 700; color: var(--h); }
    #{{ $uid }} .wf-prize { margin: 0 0 10px; font-size: 28px; font-weight: 800; line-height: 1.2; color: #0f172a; }
    #{{ $uid }} .wf-desc { margin: 0 0 24px; font-size: 14px; line-height: 1.6; color: #64748b; }
    #{{ $uid }} .wf-close { padding: 12px 32px; border: 0; border-radius: 12px; background: var(--h); color: #fff; font-family: inherit;
        font-size: 14px;
        font-weight: 700; cursor: pointer; }
    #{{ $uid }} .wf-close:focus-visible { outline: 3px solid #0f172a; outline-offset: 3px; }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition: none !important; }
        #{{ $uid }} .wf-bulb { opacity: .9; }
    }
</style>

<div id="{{ $uid }}">
    @if($ok)
        @if($title !== '' || $subtitle !== '')
            <header class="wf-head">
                @if($subtitle !== '') <p class="wf-sub">{{ $subtitle }}</p> @endif
                @if($title !== '') <h2 class="wf-title">{{ $title }}</h2> @endif
            </header>
        @endif

        <div class="wf-stage">
            <svg class="wf-svg" viewBox="0 0 400 400" role="img" aria-label="{{ $title }}">
                <defs>
                    <radialGradient id="{{ $uid }}-gl" cx=".35" cy=".3" r=".85">
                        <stop offset="0" stop-color="#fff" stop-opacity=".35"/>
                        <stop offset=".55" stop-color="#fff" stop-opacity="0"/>
                        <stop offset="1" stop-color="#000" stop-opacity=".28"/>
                    </radialGradient>
                </defs>
                <circle cx="200" cy="200" r="193" fill="none" stroke="{{ $rim }}" stroke-width="16"/>
                <g data-wheel>
                    @foreach($geo as $i => $g)
                        <path class="wf-seg" d="{{ $g['d'] }}" fill="{{ $segments[$i]['color'] }}"/>
                    @endforeach
                    @foreach($geo as $g)
                        <text class="wf-t" x="{{ $g['x'] }}" y="200" text-anchor="{{ $g['anchor'] }}" dominant-baseline="middle" font-size="{{ $g['fs'] }}" transform="rotate({{ $g['rot'] }} 200 200)">{{ $g['text'] }}</text>
                    @endforeach
                    @foreach($geo as $g)
                        <circle class="wf-peg" cx="{{ number_format($g['peg'][0], 2, '.', '') }}" cy="{{ number_format($g['peg'][1], 2, '.', '') }}" r="4"/>
                    @endforeach
                </g>
                <circle cx="200" cy="200" r="185" fill="url(#{{ $uid }}-gl)" pointer-events="none"/>
                @for($b = 0; $b < 24; $b++)
                    @php [$bx, $by] = $pt(193, $b * 15); @endphp
                    <circle class="wf-bulb" style="--i:{{ $b }}" cx="{{ number_format($bx, 2, '.', '') }}" cy="{{ number_format($by, 2, '.', '') }}" r="3.6"/>
                @endfor
                <g class="wf-pointer" data-pointer>
                    <path d="M187 -8H213L200 40Z" fill="{{ $pointer }}" stroke="#fff" stroke-width="2.5" stroke-linejoin="round"/>
                </g>
            </svg>
            <button type="button" class="wf-hub" data-spin aria-label="{{ $spinLabel }}">{{ $spinLabel }}</button>
        </div>

        @if($modalOn)
            <div class="wf-modal" data-modal role="dialog" aria-modal="true">
                <div class="wf-box">
                    <div class="wf-emoji" aria-hidden="true">🎉</div>
                    <p class="wf-label" data-label>{{ $claimed }}</p>
                    <h3 class="wf-prize" data-prize></h3>
                    <p class="wf-desc" data-desc></p>
                    <button type="button" class="wf-close" data-close>{{ __('Got it!') }}</button>
                </div>
            </div>
        @endif

        <script>
        (function () {
            var root = document.getElementById(@js($uid));
            if (!root) return;

            var segs    = @json($segJson);
            var dur     = @json($duration);
            var oneTime = @json($oneTime);
            var confOn  = @json($confettiOn);
            var claimed = @js($claimed);
            var onceMsg = @js($oneTimeMsg);
            var n       = segs.length;
            var A       = 360 / n;
            var reduce  = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            var wheel = root.querySelector('[data-wheel]');
            var ptr   = root.querySelector('[data-pointer]');
            var btn   = root.querySelector('[data-spin]');
            var modal = root.querySelector('[data-modal]');
            var paths = [].slice.call(root.querySelectorAll('.wf-seg'));

            var rot = 0, spinning = false, idle = !reduce, visible = true;

            var key = 'rj_wf_' + (function (s) {
                var h = 0;
                for (var i = 0; i < s.length; i++) h = (h * 31 + s.charCodeAt(i)) | 0;
                return Math.abs(h);
            })(segs.map(function (s) { return s.label + s.color; }).join('|'));

            function played() {
                try { return oneTime && !!localStorage.getItem(key); } catch (e) { return false; }
            }
            function markPlayed() {
                try { if (oneTime) localStorage.setItem(key, String(Date.now())); } catch (e) {}
            }

            function draw() { wheel.setAttribute('transform', 'rotate(' + rot.toFixed(2) + ' 200 200)'); }
            function slot(r) { return Math.floor((((-r % 360) + 360) % 360) / A); }

            function flick() {
                if (ptr.animate) ptr.animate([{ transform: 'rotate(-26deg)' }, { transform: 'rotate(0deg)' }], { duration: 130, easing: 'ease-out' });
            }

            function pick() {
                var total = 0, i;
                segs.forEach(function (s) { total += s.weight; });
                var r = Math.random() * total;
                for (i = 0; i < n; i++) { r -= segs[i].weight; if (r <= 0) return i; }
                return n - 1;
            }

            function openModal(text, desc, label) {
                if (!modal) { alert(text); return; }
                modal.querySelector('[data-label]').textContent = label;
                modal.querySelector('[data-prize]').textContent = text;
                var d = modal.querySelector('[data-desc]');
                d.textContent = desc || '';
                d.style.display = desc ? 'block' : 'none';
                modal.classList.add('is-open');
                modal.querySelector('[data-close]').focus();
            }
            function closeModal() {
                if (!modal || !modal.classList.contains('is-open')) return;
                modal.classList.remove('is-open');
                btn.focus();
            }
            if (modal) {
                modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
                modal.querySelector('[data-close]').addEventListener('click', closeModal);
                document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
            }

            function confetti() {
                if (!confOn || reduce) return;
                var cv = document.createElement('canvas'), w = innerWidth, h = innerHeight;
                cv.width = w;
                cv.height = h;
                cv.style.cssText = 'position:fixed;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:99995';
                document.body.appendChild(cv);
                var c = cv.getContext('2d'), r = btn.getBoundingClientRect(), bits = [], f = 0;
                var cols = segs.map(function (s) { return s.color; }).concat(['#ffffff', '#fde047']);
                for (var i = 0; i < 160; i++) {
                    var a = -Math.PI / 2 + (Math.random() - .5) * 2.2, v = 8 + Math.random() * 14;
                    bits.push({ x: r.left + r.width / 2, y: r.top + r.height / 2, vx: Math.cos(a) * v, vy: Math.sin(a) * v, r: Math.random() * 6, vr: (Math.random() - .5) * .5, round: i % 4 === 0, col: cols[i % cols.length] });
                }
                (function frame() {
                    c.clearRect(0, 0, w, h);
                    bits.forEach(function (b) {
                        b.vy += .3; b.vx *= .99; b.x += b.vx; b.y += b.vy; b.r += b.vr;
                        c.save();
                        c.globalAlpha = Math.max(0, 1 - Math.max(0, f - 100) / 60);
                        c.translate(b.x, b.y);
                        c.rotate(b.r);
                        c.fillStyle = b.col;
                        if (b.round) { c.beginPath(); c.arc(0, 0, 3.5, 0, 6.3); c.fill(); } else { c.fillRect(-4.5, -2.5, 9, 5); }
                        c.restore();
                    });
                    if (++f < 160) requestAnimationFrame(frame); else cv.remove();
                })();
            }

            function finish(w) {
                markPlayed();
                spinning = false;
                btn.disabled = false;
                root.classList.remove('is-spinning');
                root.classList.add('has-win', 'is-celebrate');
                paths[w].classList.add('is-win');
                confetti();
                setTimeout(function () { root.classList.remove('is-celebrate'); }, 2600);
                setTimeout(function () { openModal(segs[w].label, segs[w].description, claimed); }, reduce ? 0 : 900);
            }

            function spin() {
                if (spinning) return;
                if (played()) { openModal(onceMsg, '', ''); return; }

                spinning = true;
                idle = false;
                btn.disabled = true;
                root.classList.remove('has-win');
                root.classList.add('is-spinning');
                paths.forEach(function (p) { p.classList.remove('is-win'); });

                var w      = pick();
                var jitter = (Math.random() - .5) * A * .7;
                var cur    = ((rot % 360) + 360) % 360;
                var tgt    = (((-segs[w].mid + jitter) % 360) + 360) % 360;
                var from   = rot;
                var to     = rot + (5 + Math.floor(Math.random() * 3)) * 360 + ((tgt - cur + 360) % 360);

                if (reduce) { rot = to; draw(); finish(w); return; }

                var t0 = performance.now(), last = slot(rot);
                (function frame(now) {
                    var p = Math.min(1, (now - t0) / dur);
                    rot = from + (to - from) * (1 - Math.pow(1 - p, 4));
                    draw();
                    var s = slot(rot);
                    if (s !== last) { last = s; flick(); }
                    if (p < 1) requestAnimationFrame(frame); else finish(w);
                })(t0);
            }

            (function drift() {
                if (!idle) return;
                if (visible) { rot += .1; draw(); }
                requestAnimationFrame(drift);
            })();

            if ('IntersectionObserver' in window) {
                new IntersectionObserver(function (e) { visible = e[0].isIntersecting; }).observe(root);
            }

            btn.addEventListener('click', spin);
        })();
        </script>
    @else
        <div class="wf-empty">{{ __('Please add at least two wheel segments to spin.') }}</div>
    @endif
</div>
