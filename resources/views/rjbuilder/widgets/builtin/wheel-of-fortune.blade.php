@php
    $title           = $settings['title'] ?? __('Try your luck!');
    $subtitle        = $settings['subtitle'] ?? '';
    $spinLabel       = $settings['spin_label'] ?? __('SPIN');
    $duration        = (int) ($settings['duration'] ?? 5000);
    $size            = $settings['size'] ?? 'lg';
    $pointerColor    = $settings['pointer_color'] ?? '#0f172a';
    $rimColor        = $settings['rim_color'] ?? '#0f172a';
    $hubColor        = $settings['hub_color'] ?? '#8b5cf6';
    $hubTextColor    = $settings['hub_text_color'] ?? '#ffffff';
    $showConfetti    = $settings['show_confetti'] ?? true;
    $showResultModal = $settings['show_result_modal'] ?? true;
    $oneTime         = $settings['one_time'] ?? false;
    $oneTimeMsg      = $settings['one_time_message'] ?? __('You have already spun the wheel!');
    $claimedLabel    = $settings['claimed_label'] ?? __('You won:');
    $paddingY        = (int) ($settings['padding_y'] ?? 60);

    $sizeMap = ['sm' => 280, 'md' => 360, 'lg' => 440, 'xl' => 520];
    $sizePx  = $sizeMap[$size] ?? 440;

    $palette = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#84cc16', '#d946ef', '#f43f5e'];

    $segments = [];
    if (!empty($settings['segments']) && is_array($settings['segments'])) {
        foreach ($settings['segments'] as $i => $row) {
            if (!is_array($row)) continue;
            $label = trim((string) ($row['label'] ?? ''));
            if ($label === '') continue;
            $weight = (isset($row['weight']) && is_numeric($row['weight']) && (float) $row['weight'] > 0)
                ? (float) $row['weight']
                : 1.0;
            $color = trim((string) ($row['color'] ?? ''));
            if ($color === '' || !preg_match('/^#?[0-9a-fA-F]{3,8}$/', $color)) {
                $color = $palette[$i % count($palette)];
            } elseif ($color[0] !== '#') {
                $color = '#' . $color;
            }
            $segments[] = [
                'label'       => $label,
                'color'       => $color,
                'weight'      => $weight,
                'description' => trim((string) ($row['description'] ?? '')),
            ];
        }
    }

    $hasSegments = count($segments) >= 2;
    $n = count($segments);
    $segAngle = $n > 0 ? 360 / $n : 0;

    $cx = 200.0;
    $cy = 200.0;
    $rSeg = 185.0;

    $paths = [];
    $labels = [];
    if ($hasSegments) {
        $labelMaxChars = $n > 12 ? 8 : ($n > 8 ? 10 : ($n > 6 ? 12 : 16));
        $fontSize      = min(20.0, max(9.0, $segAngle * 0.38));

        foreach ($segments as $i => $seg) {
            $startAngle = $i * $segAngle;
            $endAngle   = ($i + 1) * $segAngle;
            $midAngle   = ($i + 0.5) * $segAngle;

            $startRad = deg2rad($startAngle);
            $endRad   = deg2rad($endAngle);
            $midRad   = deg2rad($midAngle);

            $x1 = $cx + $rSeg * sin($startRad);
            $y1 = $cy - $rSeg * cos($startRad);
            $x2 = $cx + $rSeg * sin($endRad);
            $y2 = $cy - $rSeg * cos($endRad);

            $largeArc = $segAngle > 180 ? 1 : 0;
            $pathD = sprintf(
                'M %.2F %.2F L %.2F %.2F A %.2F %.2F 0 %d 1 %.2F %.2F Z',
                $cx, $cy, $x1, $y1, $rSeg, $rSeg, $largeArc, $x2, $y2
            );

            $textR = $rSeg * 0.66;
            $tx = $cx + $textR * sin($midRad);
            $ty = $cy - $textR * cos($midRad);

            $textRotation = $midAngle;
            if ($midAngle > 90 && $midAngle < 270) {
                $textRotation += 180;
            }

            $labelDisplay = mb_strlen($seg['label']) > $labelMaxChars
                ? mb_substr($seg['label'], 0, $labelMaxChars - 1) . '…'
                : $seg['label'];

            $paths[] = [
                'd'     => $pathD,
                'color' => $seg['color'],
                'index' => $i,
            ];
            $labels[] = [
                'x'        => $tx,
                'y'        => $ty,
                'rotation' => $textRotation,
                'text'     => $labelDisplay,
                'size'     => $fontSize,
            ];
        }
    }

    $segmentsJson = array_map(function ($s, $i) use ($segAngle) {
        return [
            'label'       => $s['label'],
            'color'       => $s['color'],
            'weight'      => $s['weight'],
            'description' => $s['description'],
            'midAngle'    => ($i + 0.5) * $segAngle,
        ];
    }, $segments, array_keys($segments));
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #{{ $uid }} .rj-wf-head {
        text-align: center;
        margin-bottom: 32px;
        max-width: 640px;
    }
    #{{ $uid }} .rj-wf-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: {{ $hubColor }};
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-wf-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-wf-title { font-size: 40px; }
    }

    #{{ $uid }} .rj-wf-stage {
        position: relative;
        width: min(100%, {{ $sizePx }}px);
        aspect-ratio: 1 / 1;
        user-select: none;
    }
    #{{ $uid }} .rj-wf-svg {
        width: 100%;
        height: 100%;
        display: block;
        overflow: visible;
    }
    #{{ $uid }} .rj-wf-rotate {
        transform-origin: 200px 200px;
        transform-box: view-box;
        will-change: transform;
    }
    #{{ $uid }} .rj-wf-seg-text {
        fill: #fff;
        font-weight: 800;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        letter-spacing: .02em;
        paint-order: stroke fill;
        stroke: rgba(0,0,0,.18);
        stroke-width: 1.5px;
        pointer-events: none;
        user-select: none;
    }
    #{{ $uid }} .rj-wf-rim {
        pointer-events: none;
    }
    #{{ $uid }} .rj-wf-pointer {
        pointer-events: none;
        filter: drop-shadow(0 3px 6px rgba(0,0,0,.3));
    }

    #{{ $uid }} .rj-wf-hub {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 22%;
        height: 22%;
        border-radius: 50%;
        border: 4px solid #fff;
        background: {{ $hubColor }};
        color: {{ $hubTextColor }};
        font-size: clamp(10px, 1.7vw, 16px);
        font-weight: 900;
        letter-spacing: .08em;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 8px 24px rgba(0,0,0,.35), 0 0 0 0 {{ $hubColor }};
        transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-family: inherit;
    }
    #{{ $uid }} .rj-wf-hub:hover:not(:disabled) {
        transform: translate(-50%, -50%) scale(1.08);
        box-shadow: 0 12px 32px rgba(0,0,0,.4), 0 0 0 6px {{ $hubColor }}22;
    }
    #{{ $uid }} .rj-wf-hub:active:not(:disabled) {
        transform: translate(-50%, -50%) scale(.96);
    }
    #{{ $uid }} .rj-wf-hub:disabled {
        cursor: wait;
        opacity: .85;
    }
    #{{ $uid }} .rj-wf-hub::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 2px solid {{ $hubColor }};
        opacity: 0;
        transition: opacity .3s ease;
        animation: rjWfHubPulse 2.5s ease-in-out infinite;
    }
    #{{ $uid }} .rj-wf-hub:not(:disabled)::after {
        opacity: .5;
    }
    @keyframes rjWfHubPulse {
        0%, 100% { transform: scale(1); opacity: .5; }
        50%      { transform: scale(1.15); opacity: .1; }
    }

    #{{ $uid }} .rj-wf-empty {
        max-width: 480px;
        padding: 40px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    /* ---------- MODAL ---------- */
    #{{ $uid }} .rj-wf-modal {
        position: fixed;
        inset: 0;
        z-index: 99990;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    #{{ $uid }} .rj-wf-modal.is-open {
        display: flex;
    }
    #{{ $uid }} .rj-wf-modal-back {
        position: absolute;
        inset: 0;
        background: rgba(2,6,23,.72);
        backdrop-filter: blur(6px);
        animation: rjWfFade .25s ease both;
    }
    #{{ $uid }} .rj-wf-modal-box {
        position: relative;
        background: #fff;
        border-radius: 24px;
        padding: 40px 32px 28px;
        text-align: center;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.6);
        animation: rjWfPop .4s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes rjWfFade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjWfPop {
        from { opacity: 0; transform: scale(.85) translateY(20px); }
        to   { opacity: 1; transform: none; }
    }
    #{{ $uid }} .rj-wf-modal-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 14px;
        color: #fbbf24;
        animation: rjWfBounce 1.2s ease-in-out infinite;
    }
    @keyframes rjWfBounce {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }
    #{{ $uid }} .rj-wf-modal-label {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: {{ $hubColor }};
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-wf-modal-prize {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.01em;
        margin: 0 0 10px;
        line-height: 1.2;
    }
    #{{ $uid }} .rj-wf-modal-desc {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 24px;
    }
    #{{ $uid }} .rj-wf-modal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 32px;
        border-radius: 12px;
        background: {{ $hubColor }};
        color: #fff;
        border: 0;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s ease, opacity .2s ease;
        font-family: inherit;
    }
    #{{ $uid }} .rj-wf-modal-btn:hover { opacity: .92; }
    #{{ $uid }} .rj-wf-modal-btn:active { transform: scale(.97); }

    /* ---------- CONFETTI ---------- */
    #{{ $uid }} .rj-wf-confetti {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 99995;
        overflow: hidden;
    }
    #{{ $uid }} .rj-wf-confetti-piece {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 9px;
        height: 14px;
        opacity: 1;
        will-change: transform, opacity;
        animation: rjWfConfetti 2.4s cubic-bezier(.2,.7,.4,1) forwards;
    }
    @keyframes rjWfConfetti {
        0% {
            transform: translate(-50%, -50%) rotate(0deg) scale(1);
            opacity: 1;
        }
        100% {
            transform: translate(calc(-50% + var(--tx, 0px)), calc(-50% + var(--ty, 400px))) rotate(var(--rot, 720deg)) scale(.4);
            opacity: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}" data-duration="{{ $duration }}" data-one-time="{{ $oneTime ? '1' : '0' }}" data-confetti="{{ $showConfetti ? '1' : '0' }}" data-modal="{{ $showResultModal ? '1' : '0' }}" data-hub-color="{{ $hubColor }}">
    @if($hasSegments)
        @if($title || $subtitle)
            <header class="rj-wf-head">
                @if($subtitle)
                    <p class="rj-wf-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-wf-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        <div class="rj-wf-stage">
            <svg class="rj-wf-svg" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <g class="rj-wf-rotate" data-rotate>
                    @foreach($paths as $p)
                        <path d="{{ $p['d'] }}" fill="{{ $p['color'] }}" />
                    @endforeach
                    @foreach($labels as $lbl)
                        <text class="rj-wf-seg-text"
                              x="{{ number_format($lbl['x'], 2, '.', '') }}"
                              y="{{ number_format($lbl['y'], 2, '.', '') }}"
                              text-anchor="middle"
                              dominant-baseline="middle"
                              font-size="{{ number_format($lbl['size'], 1, '.', '') }}"
                              transform="rotate({{ number_format($lbl['rotation'], 2, '.', '') }} {{ number_format($lbl['x'], 2, '.', '') }} {{ number_format($lbl['y'], 2, '.', '') }})">{{ $lbl['text'] }}</text>
                    @endforeach
                </g>
                <circle class="rj-wf-rim" cx="200" cy="200" r="190" fill="none" stroke="{{ $rimColor }}" stroke-width="10" />
                <polygon class="rj-wf-pointer" points="182,5 218,5 200,42" fill="{{ $pointerColor }}" />
            </svg>

            <button type="button" class="rj-wf-hub" data-spin aria-label="{{ $spinLabel }}">{{ $spinLabel }}</button>
        </div>

        @if($showResultModal)
            <div class="rj-wf-modal" data-modal-box role="dialog" aria-modal="true">
                <div class="rj-wf-modal-back" data-modal-close></div>
                <div class="rj-wf-modal-box">
                    <div class="rj-wf-modal-icon">
                        <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-4v4m-5-4h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2zm3-6a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="rj-wf-modal-label">{{ $claimedLabel }}</p>
                    <h3 class="rj-wf-modal-prize" data-prize>—</h3>
                    <p class="rj-wf-modal-desc" data-desc></p>
                    <button type="button" class="rj-wf-modal-btn" data-modal-close>{{ __('Got it!') }}</button>
                </div>
            </div>
        @endif

        <div class="rj-wf-confetti" data-confetti-box></div>

        <script>
        (function () {
            var root = document.getElementById(@js($uid));
            if (!root) return;

            var segments     = @json($segmentsJson);
            var duration     = parseInt(root.getAttribute('data-duration'), 10) || 5000;
            var oneTime      = root.getAttribute('data-one-time') === '1';
            var confettiOn   = root.getAttribute('data-confetti') === '1';
            var modalOn      = root.getAttribute('data-modal') === '1';

            var wheelEl      = root.querySelector('[data-rotate]');
            var spinBtn      = root.querySelector('[data-spin]');
            var modalBox     = root.querySelector('[data-modal-box]');
            var prizeEl      = root.querySelector('[data-prize]');
            var descEl       = root.querySelector('[data-desc]');
            var confettiBox  = root.querySelector('[data-confetti-box]');

            var oneTimeMsg   = @js($oneTimeMsg);
            var spinning     = false;
            var currentRotation = 0;

            var lsKey = (function () {
                var sig = segments.map(function (s) { return s.label + s.color; }).join('|');
                var h = 0;
                for (var i = 0; i < sig.length; i++) {
                    h = ((h << 5) - h) + sig.charCodeAt(i);
                    h |= 0;
                }
                return 'rj_wf_' + Math.abs(h);
            })();

            function alreadyPlayed() {
                if (!oneTime) return null;
                try {
                    var raw = localStorage.getItem(lsKey);
                    if (!raw) return null;
                    return JSON.parse(raw);
                } catch (e) { return null; }
            }

            function markPlayed(idx) {
                if (!oneTime) return;
                try {
                    localStorage.setItem(lsKey, JSON.stringify({ idx: idx, ts: Date.now() }));
                } catch (e) {}
            }

            function weightedPick() {
                var total = 0;
                segments.forEach(function (s) { total += s.weight; });
                if (total <= 0) return Math.floor(Math.random() * segments.length);
                var pick = Math.random() * total;
                for (var i = 0; i < segments.length; i++) {
                    pick -= segments[i].weight;
                    if (pick <= 0) return i;
                }
                return segments.length - 1;
            }

            function showModal(seg) {
                if (!modalOn) return;
                prizeEl.textContent = seg.label;
                if (seg.description) {
                    descEl.textContent = seg.description;
                    descEl.style.display = 'block';
                } else {
                    descEl.style.display = 'none';
                }
                modalBox.classList.add('is-open');
            }

            function showMessage(text) {
                if (!modalOn) { alert(text); return; }
                prizeEl.textContent = text;
                descEl.style.display = 'none';
                modalBox.classList.add('is-open');
            }

            function closeModal() {
                if (modalBox) modalBox.classList.remove('is-open');
            }

            if (modalBox) {
                root.querySelectorAll('[data-modal-close]').forEach(function (el) {
                    el.addEventListener('click', closeModal);
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeModal();
                });
            }

            function launchConfetti() {
                if (!confettiOn || !confettiBox) return;
                confettiBox.innerHTML = '';
                var colors = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#fbbf24'];
                for (var i = 0; i < 70; i++) {
                    var piece = document.createElement('div');
                    piece.className = 'rj-wf-confetti-piece';
                    piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    piece.style.animationDelay = (Math.random() * 0.35) + 's';
                    var angle = Math.random() * Math.PI * 2;
                    var dist = 250 + Math.random() * 500;
                    var tx = Math.cos(angle) * dist;
                    var ty = Math.sin(angle) * dist + 300;
                    piece.style.setProperty('--tx', tx.toFixed(1) + 'px');
                    piece.style.setProperty('--ty', ty.toFixed(1) + 'px');
                    piece.style.setProperty('--rot', ((Math.random() - 0.5) * 1440).toFixed(0) + 'deg');
                    confettiBox.appendChild(piece);
                }
                setTimeout(function () {
                    if (confettiBox) confettiBox.innerHTML = '';
                }, 2800);
            }

            function spin() {
                if (spinning) return;

                var prev = alreadyPlayed();
                if (prev) {
                    showMessage(oneTimeMsg);
                    return;
                }

                spinning = true;
                spinBtn.disabled = true;

                var winner = weightedPick();
                var seg = segments[winner];
                var segAngle = 360 / segments.length;
                var jitter = (Math.random() - 0.5) * segAngle * 0.7;
                var desiredR = -seg.midAngle + jitter;

                var currentMod = ((currentRotation % 360) + 360) % 360;
                var targetMod  = ((desiredR % 360) + 360) % 360;
                var delta      = ((targetMod - currentMod) + 360) % 360;

                var fullSpins = 5 + Math.floor(Math.random() * 3);
                var finalRotation = currentRotation + fullSpins * 360 + delta;

                wheelEl.style.transition = 'transform ' + duration + 'ms cubic-bezier(.17,.67,.17,1)';
                wheelEl.style.transform = 'rotate(' + finalRotation + 'deg)';
                currentRotation = finalRotation;

                markPlayed(winner);

                setTimeout(function () {
                    spinning = false;
                    spinBtn.disabled = false;
                    if (confettiOn) launchConfetti();
                    showModal(seg);
                }, duration + 120);
            }

            spinBtn.addEventListener('click', spin);
        })();
        </script>
    @else
        <div class="rj-wf-empty">{{ __('Please add at least two wheel segments to spin.') }}</div>
    @endif
</div>
