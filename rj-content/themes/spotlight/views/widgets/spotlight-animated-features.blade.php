@php
    $uid = 'anf_' . substr(md5(uniqid('', true)), 0, 8);

    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $coreIcon = $settings['core_icon'] ?? 'ph:atom';

    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_slice(array_values($features), 0, 6);

    $count = count($features);
    $ringCounts = [(int) ceil($count / 2), (int) floor($count / 2)];
    $orbits = [];
    foreach ($features as $i => $item) {
        $ring = $i % 2;
        $idx = intdiv($i, 2);
        $dur = $ring === 0 ? 46 : 32;
        $n = max(1, $ringCounts[$ring]);
        $offset = $ring === 1 ? 0.5 / $n : 0;
        $orbits[] = [
            'ring' => $ring,
            'dur' => $dur,
            'delay' => -round($dur * ($idx / $n + $offset), 2),
            'icon' => $item['icon'] ?? 'ph:sparkle',
            'label' => $item['feature_title'] ?? '',
        ];
    }
@endphp

<section class="rj-anf-section" id="{{ $uid }}">
    <div class="rj-anf-bg" aria-hidden="true">
        <span class="rj-anf-grid-bg"></span>
        <span class="rj-anf-blob rj-anf-blob-a"></span>
        <span class="rj-anf-blob rj-anf-blob-b"></span>
    </div>

    <div class="rj-anf-inner">

        <div class="rj-anf-stage-wrap rj-anf-reveal" style="--i:0;">
            <div class="rj-anf-stage">
                <span class="rj-anf-glow"></span>
                <span class="rj-anf-ring" style="--sz:92%;"></span>
                <span class="rj-anf-ring is-dash" style="--sz:60%;"></span>
                <span class="rj-anf-ring is-faint" style="--sz:34%;"></span>
                <span class="rj-anf-sweep"></span>

                @foreach($orbits as $o)
                    <div class="rj-anf-orbit {{ $o['ring'] ? 'is-rev' : '' }}" style="--sz: {{ $o['ring'] ? '60%' : '92%' }}; --dur: {{ $o['dur'] }}s; --dly: {{ $o['delay'] }}s;">
                        <div class="rj-anf-node">
                            <div class="rj-anf-node-i" data-label="{{ $o['label'] }}">
                                <iconify-icon icon="{{ $o['icon'] }}"></iconify-icon>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="rj-anf-core">
                    <span class="rj-anf-pulse"></span>
                    <span class="rj-anf-pulse" style="animation-delay:-2s;"></span>
                    <iconify-icon icon="{{ $coreIcon }}"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="rj-anf-content">

            @if($badge)
                <div class="rj-anf-badge rj-anf-reveal" style="--i:1;">
                    <span class="rj-anf-dot"></span>
                    <span class="rj-anf-badge-t">{{ $badge }}</span>
                </div>
            @endif

            <div class="rj-anf-text">
                @if($title)
                    <h2 class="rj-anf-title rj-anf-reveal" style="--i:2;">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-anf-sub rj-anf-reveal" style="--i:3;">{{ $subtitle }}</p>
                @endif
            </div>

            @if(!empty($features))
                <div class="rj-anf-grid">
                    @foreach($features as $i => $item)
                        <article class="rj-anf-card rj-anf-reveal" style="--i: {{ $i + 2 }};">
                            <div class="rj-anf-icon">
                                <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                            </div>
                            <h3 class="rj-anf-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                            <p class="rj-anf-card-desc">{{ $item['feature_text'] ?? '' }}</p>
                        </article>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

    <style>
        @property --rj-anf-angle {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }

        #{{ $uid }}.rj-anf-section {
            --a1: #3b82f6;
            --a2: #6366f1;
            --a3: #22d3ee;
            position: relative;
            width: 100%;
            background: transparent;
            padding: 48px 24px;
            overflow: hidden;
            isolation: isolate;
            contain: paint;
        }

        #{{ $uid }} .rj-anf-bg {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: min(100%, var(--rj-container));
            transform: translateX(-50%);
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
            -webkit-mask-image: radial-gradient(ellipse 85% 95% at 50% 50%, #000 35%, transparent 100%);
            mask-image: radial-gradient(ellipse 85% 95% at 50% 50%, #000 35%, transparent 100%);
        }
        #{{ $uid }} .rj-anf-grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .045) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: rjAnfGridDrift 14s linear infinite;
        }
        #{{ $uid }} .rj-anf-blob {
            position: absolute;
            width: min(380px, 55%);
            aspect-ratio: 1;
            border-radius: 50%;
            mix-blend-mode: screen;
        }
        #{{ $uid }} .rj-anf-blob-a {
            top: 12%;
            left: 6%;
            background: radial-gradient(circle, rgba(59, 130, 246, .26), transparent 65%);
            animation: rjAnfDriftA 18s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-anf-blob-b {
            bottom: 12%;
            right: 6%;
            background: radial-gradient(circle, rgba(139, 92, 246, .22), transparent 65%);
            animation: rjAnfDriftB 22s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-anf-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(260px, 340px) minmax(0, 1fr);
            gap: 56px;
            align-items: center;
        }

        #{{ $uid }}.rj-anf-ready .rj-anf-reveal:not(.is-in) { opacity: 0; }
        #{{ $uid }} .rj-anf-reveal.is-in {
            animation: rjAnfReveal .8s cubic-bezier(.2, .7, .2, 1) backwards;
            animation-delay: calc(var(--i, 0) * 80ms);
        }

        #{{ $uid }} .rj-anf-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
        }

        #{{ $uid }} .rj-anf-badge {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 7px 16px 7px 12px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .12);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .12);
            overflow: hidden;
        }
        #{{ $uid }} .rj-anf-badge::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 40%;
            left: -60%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .18), transparent);
            animation: rjAnfSheen 5s ease-in-out infinite;
        }
        #{{ $uid }} .rj-anf-dot {
            position: relative;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--a3);
            box-shadow: 0 0 10px var(--a3);
        }
        #{{ $uid }} .rj-anf-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px solid var(--a3);
            animation: rjAnfPing 2s ease-out infinite;
        }
        #{{ $uid }} .rj-anf-badge-t {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .16em;
            color: rgba(255, 255, 255, .78);
            text-transform: uppercase;
        }

        #{{ $uid }} .rj-anf-stage-wrap {
            width: 100%;
            max-width: 340px;
            justify-self: center;
            perspective: 1100px;
        }
        #{{ $uid }} .rj-anf-stage {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            transform-style: preserve-3d;
            transform: rotateX(var(--rj-anf-ry, 0deg)) rotateY(var(--rj-anf-rx, 0deg));
            transition: transform .35s ease-out;
        }

        #{{ $uid }} .rj-anf-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 78%;
            aspect-ratio: 1;
            margin: -39% 0 0 -39%;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, .3), rgba(99, 102, 241, .1) 45%, transparent 68%);
            animation: rjAnfBreathe 5s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-anf-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            width: var(--sz);
            aspect-ratio: 1;
            margin: calc(var(--sz) / -2) 0 0 calc(var(--sz) / -2);
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .1);
        }
        #{{ $uid }} .rj-anf-ring.is-dash {
            border: 1px dashed rgba(129, 140, 248, .28);
            animation: rjAnfSpin 90s linear infinite;
        }
        #{{ $uid }} .rj-anf-ring.is-faint {
            border-color: rgba(255, 255, 255, .06);
            background: radial-gradient(circle, rgba(255, 255, 255, .03), transparent 70%);
        }

        #{{ $uid }} .rj-anf-sweep {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 92%;
            aspect-ratio: 1;
            margin: -46% 0 0 -46%;
            border-radius: 50%;
            background: conic-gradient(from 0deg, rgba(34, 211, 238, 0) 0deg, rgba(34, 211, 238, 0) 280deg, rgba(59, 130, 246, .28) 358deg, rgba(34, 211, 238, 0) 360deg);
            -webkit-mask-image: radial-gradient(circle, transparent 14%, #000 40%);
            mask-image: radial-gradient(circle, transparent 14%, #000 40%);
            animation: rjAnfSpin 7s linear infinite;
        }

        #{{ $uid }} .rj-anf-orbit {
            position: absolute;
            top: 50%;
            left: 50%;
            width: var(--sz);
            aspect-ratio: 1;
            margin: calc(var(--sz) / -2) 0 0 calc(var(--sz) / -2);
            pointer-events: none;
            animation: rjAnfSpin var(--dur) linear infinite;
            animation-delay: var(--dly);
        }
        #{{ $uid }} .rj-anf-orbit.is-rev { animation-direction: reverse; }

        #{{ $uid }} .rj-anf-node {
            position: absolute;
            top: 0;
            left: 50%;
            width: 42px;
            height: 42px;
            margin: -21px 0 0 -21px;
        }
        #{{ $uid }} .rj-anf-node-i {
            position: relative;
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            border-radius: 14px;
            font-size: 20px;
            color: #bfdbfe;
            background: linear-gradient(145deg, rgba(30, 41, 80, .85), rgba(10, 14, 30, .85));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: 0 8px 22px rgba(0, 0, 0, .45), 0 0 20px rgba(59, 130, 246, .28), inset 0 1px 0 rgba(255, 255, 255, .18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            pointer-events: auto;
            cursor: default;
            animation: rjAnfSpinBack var(--dur) linear infinite;
            animation-delay: var(--dly);
            transition: color .3s, box-shadow .3s;
        }
        #{{ $uid }} .rj-anf-orbit.is-rev .rj-anf-node-i { animation-direction: reverse; }
        #{{ $uid }} .rj-anf-node-i:hover {
            color: #fff;
            z-index: 6;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .45), 0 0 30px rgba(34, 211, 238, .55), inset 0 1px 0 rgba(255, 255, 255, .25);
        }
        #{{ $uid }} .rj-anf-node-i::after {
            content: attr(data-label);
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translate(-50%, 4px);
            white-space: nowrap;
            padding: 5px 10px;
            border-radius: 8px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 10.5px;
            letter-spacing: .04em;
            color: #e5e7eb;
            background: rgba(8, 10, 22, .94);
            border: 1px solid rgba(255, 255, 255, .14);
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s, transform .25s;
        }
        #{{ $uid }} .rj-anf-node-i[data-label=""]::after { display: none; }
        #{{ $uid }} .rj-anf-node-i:hover::after {
            opacity: 1;
            transform: translate(-50%, 0);
        }
        #{{ $uid }} .rj-anf-stage:hover .rj-anf-orbit,
        #{{ $uid }} .rj-anf-stage:hover .rj-anf-node-i { animation-play-state: paused; }

        #{{ $uid }} .rj-anf-core {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 92px;
            height: 92px;
            margin: -46px 0 0 -46px;
            display: grid;
            place-items: center;
            border-radius: 28px;
            font-size: 38px;
            color: #fff;
            background: linear-gradient(145deg, rgba(255, 255, 255, .16), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .28), 0 0 60px rgba(59, 130, 246, .4), 0 20px 40px rgba(0, 0, 0, .5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: rjAnfFloat 6s ease-in-out infinite;
        }
        #{{ $uid }} .rj-anf-core iconify-icon { position: relative; z-index: 2; filter: drop-shadow(0 0 12px rgba(147, 197, 253, .8)); }
        #{{ $uid }} .rj-anf-core::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 1px;
            border-radius: inherit;
            background: conic-gradient(from var(--rj-anf-angle), transparent 0deg, transparent 60deg, var(--a1) 120deg, var(--a3) 170deg, transparent 230deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
            animation: rjAnfAngle 5s linear infinite;
        }
        #{{ $uid }} .rj-anf-pulse {
            position: absolute;
            inset: 0;
            border-radius: 28px;
            border: 1px solid rgba(96, 165, 250, .55);
            animation: rjAnfRipple 4s ease-out infinite;
            pointer-events: none;
        }

        #{{ $uid }} .rj-anf-text {
            max-width: 600px;
            margin-bottom: 26px;
        }
        #{{ $uid }} .rj-anf-title {
            font-size: clamp(26px, 3.2vw, 40px);
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: -.03em;
            margin: 0 0 12px;
            color: transparent;
            background: linear-gradient(110deg, #fff 25%, #93c5fd 40%, #c4b5fd 50%, #67e8f9 60%, #fff 75%);
            background-size: 250% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            animation: rjAnfTitle 9s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-anf-title.is-in {
            animation: rjAnfReveal .8s cubic-bezier(.2, .7, .2, 1) backwards, rjAnfTitle 9s ease-in-out .8s infinite alternate;
            animation-delay: calc(var(--i, 0) * 80ms), 0s;
        }
        #{{ $uid }} .rj-anf-sub {
            font-size: 15px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0;
        }

        #{{ $uid }} .rj-anf-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            width: 100%;
        }
        #{{ $uid }} .rj-anf-card {
            position: relative;
            isolation: isolate;
            display: grid;
            grid-template-columns: 44px minmax(0, 1fr);
            column-gap: 14px;
            row-gap: 3px;
            align-items: start;
            padding: 15px 18px;
            border-radius: 18px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .015));
            border: 1px solid rgba(255, 255, 255, .09);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: translate .4s cubic-bezier(.2, .7, .2, 1), background .4s, box-shadow .4s;
        }
        #{{ $uid }} .rj-anf-card:hover {
            translate: 0 -3px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .09), rgba(255, 255, 255, .025));
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .16), 0 16px 34px rgba(0, 0, 0, .4), 0 0 36px rgba(59, 130, 246, .12);
        }
        #{{ $uid }} .rj-anf-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 1px;
            border-radius: inherit;
            background: conic-gradient(from var(--rj-anf-angle), transparent 0deg, transparent 40deg, var(--a2) 90deg, var(--a1) 130deg, var(--a3) 170deg, transparent 220deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
            opacity: 0;
            transition: opacity .4s;
            animation: rjAnfAngle 5s linear infinite;
            pointer-events: none;
        }
        #{{ $uid }} .rj-anf-card:hover::before { opacity: 1; }
        #{{ $uid }} .rj-anf-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(260px circle at var(--mx, 50%) var(--my, 0%), rgba(99, 102, 241, .18), transparent 62%);
            opacity: 0;
            transition: opacity .4s;
            pointer-events: none;
            z-index: 0;
        }
        #{{ $uid }} .rj-anf-card:hover::after { opacity: 1; }

        #{{ $uid }} .rj-anf-icon,
        #{{ $uid }} .rj-anf-card-title,
        #{{ $uid }} .rj-anf-card-desc { position: relative; z-index: 1; }

        #{{ $uid }} .rj-anf-icon {
            grid-row: 1 / span 2;
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            font-size: 22px;
            color: #93c5fd;
            background: linear-gradient(145deg, rgba(59, 130, 246, .24), rgba(99, 102, 241, .06));
            border: 1px solid rgba(129, 140, 248, .3);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .14);
            transition: box-shadow .4s, color .4s, transform .5s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-anf-card:hover .rj-anf-icon {
            color: #fff;
            transform: scale(1.06) rotate(-4deg);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .2), 0 0 26px rgba(59, 130, 246, .5);
        }
        #{{ $uid }} .rj-anf-card-title {
            font-size: 15px;
            font-weight: 600;
            letter-spacing: -.01em;
            color: #fff;
            margin: 0;
            line-height: 1.3;
        }
        #{{ $uid }} .rj-anf-card-desc {
            font-size: 13px;
            line-height: 1.5;
            color: var(--rj-muted);
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes rjAnfReveal {
            from { opacity: 0; transform: translateY(18px); filter: blur(6px); }
            to { opacity: 1; transform: none; filter: blur(0); }
        }
        @keyframes rjAnfSpin { to { transform: rotate(360deg); } }
        @keyframes rjAnfSpinBack { to { transform: rotate(-360deg); } }
        @keyframes rjAnfAngle { to { --rj-anf-angle: 360deg; } }
        @keyframes rjAnfFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }
        @keyframes rjAnfBreathe {
            from { transform: scale(.9); opacity: .6; }
            to { transform: scale(1.08); opacity: 1; }
        }
        @keyframes rjAnfRipple {
            from { transform: scale(1); opacity: .6; }
            to { transform: scale(2.4); opacity: 0; }
        }
        @keyframes rjAnfPing {
            from { transform: scale(1); opacity: .9; }
            to { transform: scale(3); opacity: 0; }
        }
        @keyframes rjAnfSheen {
            0%, 55% { left: -60%; }
            100% { left: 130%; }
        }
        @keyframes rjAnfTitle {
            from { background-position: 0% 50%; }
            to { background-position: 100% 50%; }
        }
        @keyframes rjAnfGridDrift {
            from { background-position: 0 0; }
            to { background-position: 48px 48px; }
        }
        @keyframes rjAnfDriftA {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(40px, 24px) scale(1.1); }
        }
        @keyframes rjAnfDriftB {
            from { transform: translate(0, 0) scale(1.05); }
            to { transform: translate(-36px, -20px) scale(.95); }
        }

        @media (max-width: 860px) {
            #{{ $uid }}.rj-anf-section { padding: 40px 20px; }
            #{{ $uid }} .rj-anf-inner { grid-template-columns: 1fr; gap: 32px; }
            #{{ $uid }} .rj-anf-stage-wrap { max-width: 280px; }
            #{{ $uid }} .rj-anf-content { align-items: center; text-align: center; }
            #{{ $uid }} .rj-anf-text { margin-left: auto; margin-right: auto; }
            #{{ $uid }} .rj-anf-card { text-align: left; }
        }
        @media (max-width: 560px) {
            #{{ $uid }} .rj-anf-grid { grid-template-columns: 1fr; }
            #{{ $uid }} .rj-anf-stage-wrap { max-width: 240px; }
            #{{ $uid }} .rj-anf-node { width: 36px; height: 36px; margin: -18px 0 0 -18px; }
            #{{ $uid }} .rj-anf-node-i { font-size: 17px; border-radius: 12px; }
            #{{ $uid }} .rj-anf-core { width: 72px; height: 72px; margin: -36px 0 0 -36px; font-size: 30px; border-radius: 22px; }
            #{{ $uid }} .rj-anf-pulse { border-radius: 22px; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *,
            #{{ $uid }} *::before,
            #{{ $uid }} *::after { animation: none !important; transition: none !important; }
            #{{ $uid }}.rj-anf-ready .rj-anf-reveal:not(.is-in) { opacity: 1; }
            #{{ $uid }} .rj-anf-title { color: #fff; background: none; }
        }
    </style>

    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <script>
        (function () {
            var root = document.getElementById('{{ $uid }}');
            if (!root) return;
            root.classList.add('rj-anf-ready');

            var items = root.querySelectorAll('.rj-anf-reveal');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('is-in'); });
            } else {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-in');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });
                items.forEach(function (el) { io.observe(el); });
            }

            root.querySelectorAll('.rj-anf-card').forEach(function (card) {
                card.addEventListener('pointermove', function (e) {
                    var r = card.getBoundingClientRect();
                    card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    card.style.setProperty('--my', (e.clientY - r.top) + 'px');
                });
            });

            var stage = root.querySelector('.rj-anf-stage');
            if (stage) {
                var raf = null;
                root.addEventListener('pointermove', function (e) {
                    if (raf) return;
                    raf = requestAnimationFrame(function () {
                        raf = null;
                        var r = root.getBoundingClientRect();
                        var x = (e.clientX - r.left) / r.width - 0.5;
                        var y = (e.clientY - r.top) / r.height - 0.5;
                        stage.style.setProperty('--rj-anf-rx', (x * 6).toFixed(2) + 'deg');
                        stage.style.setProperty('--rj-anf-ry', (-y * 5).toFixed(2) + 'deg');
                    });
                });
                root.addEventListener('pointerleave', function () {
                    stage.style.setProperty('--rj-anf-rx', '0deg');
                    stage.style.setProperty('--rj-anf-ry', '0deg');
                });
            }
        })();
    </script>
</section>
