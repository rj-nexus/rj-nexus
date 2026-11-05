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

        @if($badge)
            <div class="rj-anf-badge rj-anf-reveal" style="--i:0;">
                <span class="rj-anf-dot"></span>
                <span class="rj-anf-badge-t">{{ $badge }}</span>
            </div>
        @endif

        <div class="rj-anf-stage-wrap rj-anf-reveal" style="--i:1;">
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

        <span class="rj-anf-beam" aria-hidden="true"></span>

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
                    <article class="rj-anf-card rj-anf-reveal" style="--i: {{ $i }};">
                        <span class="rj-anf-num">{{ sprintf('%02d', $i + 1) }}</span>
                        <div class="rj-anf-icon">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                        </div>
                        <h3 class="rj-anf-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                        <p class="rj-anf-card-desc">{{ $item['feature_text'] ?? '' }}</p>
                        <span class="rj-anf-card-line"></span>
                    </article>
                @endforeach
            </div>
        @endif

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
            padding: 140px 24px 150px;
            overflow: hidden;
            isolation: isolate;
        }

        #{{ $uid }} .rj-anf-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        #{{ $uid }} .rj-anf-grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .045) 1px, transparent 1px);
            background-size: 64px 64px;
            -webkit-mask-image: radial-gradient(ellipse 75% 60% at 50% 30%, #000 15%, transparent 75%);
            mask-image: radial-gradient(ellipse 75% 60% at 50% 30%, #000 15%, transparent 75%);
            animation: rjAnfGridDrift 14s linear infinite;
        }
        #{{ $uid }} .rj-anf-blob {
            position: absolute;
            width: min(780px, 90vw);
            aspect-ratio: 1;
            border-radius: 50%;
            mix-blend-mode: screen;
        }
        #{{ $uid }} .rj-anf-blob-a {
            top: -18%;
            left: -14%;
            background: radial-gradient(circle, rgba(59, 130, 246, .26), transparent 65%);
            animation: rjAnfDriftA 22s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-anf-blob-b {
            bottom: -26%;
            right: -16%;
            background: radial-gradient(circle, rgba(139, 92, 246, .22), transparent 65%);
            animation: rjAnfDriftB 26s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-anf-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #{{ $uid }}.rj-anf-ready .rj-anf-reveal:not(.is-in) { opacity: 0; }
        #{{ $uid }} .rj-anf-reveal.is-in {
            animation: rjAnfReveal .9s cubic-bezier(.2, .7, .2, 1) backwards;
            animation-delay: calc(var(--i, 0) * 90ms);
        }

        #{{ $uid }} .rj-anf-badge {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 9px 18px 9px 14px;
            margin-bottom: 40px;
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
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--a3);
            box-shadow: 0 0 12px var(--a3);
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
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .18em;
            color: rgba(255, 255, 255, .78);
            text-transform: uppercase;
        }

        #{{ $uid }} .rj-anf-stage-wrap {
            width: min(460px, 84vw);
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
            width: 48px;
            height: 48px;
            margin: -24px 0 0 -24px;
        }
        #{{ $uid }} .rj-anf-node-i {
            position: relative;
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            border-radius: 16px;
            font-size: 22px;
            color: #bfdbfe;
            background: linear-gradient(145deg, rgba(30, 41, 80, .85), rgba(10, 14, 30, .85));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .45), 0 0 24px rgba(59, 130, 246, .28), inset 0 1px 0 rgba(255, 255, 255, .18);
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
            box-shadow: 0 10px 28px rgba(0, 0, 0, .45), 0 0 34px rgba(34, 211, 238, .55), inset 0 1px 0 rgba(255, 255, 255, .25);
        }
        #{{ $uid }} .rj-anf-node-i::after {
            content: attr(data-label);
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translate(-50%, 4px);
            white-space: nowrap;
            padding: 6px 11px;
            border-radius: 9px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            letter-spacing: .04em;
            color: #e5e7eb;
            background: rgba(8, 10, 22, .92);
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
            width: 112px;
            height: 112px;
            margin: -56px 0 0 -56px;
            display: grid;
            place-items: center;
            border-radius: 34px;
            font-size: 46px;
            color: #fff;
            background: linear-gradient(145deg, rgba(255, 255, 255, .16), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .28), 0 0 70px rgba(59, 130, 246, .4), 0 24px 50px rgba(0, 0, 0, .5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: rjAnfFloat 6s ease-in-out infinite;
        }
        #{{ $uid }} .rj-anf-core iconify-icon { position: relative; z-index: 2; filter: drop-shadow(0 0 14px rgba(147, 197, 253, .8)); }
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
            border-radius: 34px;
            border: 1px solid rgba(96, 165, 250, .55);
            animation: rjAnfRipple 4s ease-out infinite;
            pointer-events: none;
        }

        #{{ $uid }} .rj-anf-beam {
            position: relative;
            display: block;
            width: 1px;
            height: 84px;
            margin: 6px 0 36px;
            background: linear-gradient(180deg, rgba(59, 130, 246, 0), rgba(99, 102, 241, .45), rgba(34, 211, 238, 0));
            overflow: hidden;
        }
        #{{ $uid }} .rj-anf-beam::after {
            content: '';
            position: absolute;
            left: 0;
            width: 100%;
            height: 34px;
            background: linear-gradient(180deg, transparent, #fff, transparent);
            animation: rjAnfBeam 2.6s ease-in-out infinite;
        }

        #{{ $uid }} .rj-anf-text {
            text-align: center;
            max-width: 780px;
            margin-bottom: 80px;
        }
        #{{ $uid }} .rj-anf-title {
            font-size: clamp(34px, 5.2vw, 60px);
            font-weight: 600;
            line-height: 1.06;
            letter-spacing: -.035em;
            margin: 0 0 22px;
            color: transparent;
            background: linear-gradient(110deg, #fff 25%, #93c5fd 40%, #c4b5fd 50%, #67e8f9 60%, #fff 75%);
            background-size: 250% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            animation: rjAnfTitle 9s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-anf-title.is-in {
            animation: rjAnfReveal .9s cubic-bezier(.2, .7, .2, 1) backwards, rjAnfTitle 9s ease-in-out .9s infinite alternate;
            animation-delay: calc(var(--i, 0) * 90ms), 0s;
        }
        #{{ $uid }} .rj-anf-sub {
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.7;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 620px;
        }

        #{{ $uid }} .rj-anf-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            width: 100%;
        }
        #{{ $uid }} .rj-anf-card {
            position: relative;
            isolation: isolate;
            padding: 34px 30px 30px;
            border-radius: 26px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .015));
            border: 1px solid rgba(255, 255, 255, .09);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: translate .45s cubic-bezier(.2, .7, .2, 1), background .4s, box-shadow .4s;
        }
        #{{ $uid }} .rj-anf-card:hover {
            translate: 0 -8px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .09), rgba(255, 255, 255, .025));
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .16), 0 30px 60px rgba(0, 0, 0, .4), 0 0 50px rgba(59, 130, 246, .12);
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
            background: radial-gradient(380px circle at var(--mx, 50%) var(--my, 0%), rgba(99, 102, 241, .18), transparent 62%);
            opacity: 0;
            transition: opacity .4s;
            pointer-events: none;
            z-index: 0;
        }
        #{{ $uid }} .rj-anf-card:hover::after { opacity: 1; }

        #{{ $uid }} .rj-anf-num {
            position: absolute;
            top: 28px;
            right: 30px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 12px;
            letter-spacing: .12em;
            color: rgba(255, 255, 255, .28);
            transition: color .3s;
        }
        #{{ $uid }} .rj-anf-card:hover .rj-anf-num { color: var(--a3); }

        #{{ $uid }} .rj-anf-icon,
        #{{ $uid }} .rj-anf-card-title,
        #{{ $uid }} .rj-anf-card-desc,
        #{{ $uid }} .rj-anf-card-line { position: relative; z-index: 1; }

        #{{ $uid }} .rj-anf-icon {
            display: grid;
            place-items: center;
            width: 56px;
            height: 56px;
            margin-bottom: 26px;
            border-radius: 18px;
            font-size: 28px;
            color: #93c5fd;
            background: linear-gradient(145deg, rgba(59, 130, 246, .24), rgba(99, 102, 241, .06));
            border: 1px solid rgba(129, 140, 248, .3);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .14);
            transition: box-shadow .4s, color .4s, transform .5s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-anf-card:hover .rj-anf-icon {
            color: #fff;
            transform: scale(1.08) rotate(-4deg);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .2), 0 0 32px rgba(59, 130, 246, .5);
        }
        #{{ $uid }} .rj-anf-card-title {
            font-size: 19px;
            font-weight: 600;
            letter-spacing: -.015em;
            color: #fff;
            margin: 0 0 12px;
        }
        #{{ $uid }} .rj-anf-card-desc {
            font-size: 15px;
            line-height: 1.7;
            color: var(--rj-muted);
            margin: 0;
        }
        #{{ $uid }} .rj-anf-card-line {
            display: block;
            width: 0;
            height: 2px;
            margin-top: 26px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--a1), var(--a3));
            transition: width .5s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-anf-card:hover .rj-anf-card-line { width: 64px; }

        @keyframes rjAnfReveal {
            from { opacity: 0; transform: translateY(28px); filter: blur(8px); }
            to { opacity: 1; transform: none; filter: blur(0); }
        }
        @keyframes rjAnfSpin { to { transform: rotate(360deg); } }
        @keyframes rjAnfSpinBack { to { transform: rotate(-360deg); } }
        @keyframes rjAnfAngle { to { --rj-anf-angle: 360deg; } }
        @keyframes rjAnfFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes rjAnfBreathe {
            from { transform: scale(.88); opacity: .6; }
            to { transform: scale(1.12); opacity: 1; }
        }
        @keyframes rjAnfRipple {
            from { transform: scale(1); opacity: .6; }
            to { transform: scale(2.7); opacity: 0; }
        }
        @keyframes rjAnfPing {
            from { transform: scale(1); opacity: .9; }
            to { transform: scale(3); opacity: 0; }
        }
        @keyframes rjAnfSheen {
            0%, 55% { left: -60%; }
            100% { left: 130%; }
        }
        @keyframes rjAnfBeam {
            from { top: -40px; }
            to { top: 100%; }
        }
        @keyframes rjAnfTitle {
            from { background-position: 0% 50%; }
            to { background-position: 100% 50%; }
        }
        @keyframes rjAnfGridDrift {
            from { background-position: 0 0; }
            to { background-position: 64px 64px; }
        }
        @keyframes rjAnfDriftA {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(120px, 70px) scale(1.15); }
        }
        @keyframes rjAnfDriftB {
            from { transform: translate(0, 0) scale(1.1); }
            to { transform: translate(-110px, -60px) scale(.95); }
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-anf-section { padding: 110px 24px 120px; }
            #{{ $uid }} .rj-anf-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-anf-section { padding: 80px 20px 90px; }
            #{{ $uid }} .rj-anf-grid { grid-template-columns: 1fr; gap: 18px; }
            #{{ $uid }} .rj-anf-text { margin-bottom: 56px; }
            #{{ $uid }} .rj-anf-node { width: 40px; height: 40px; margin: -20px 0 0 -20px; }
            #{{ $uid }} .rj-anf-node-i { font-size: 19px; border-radius: 13px; }
            #{{ $uid }} .rj-anf-core { width: 88px; height: 88px; margin: -44px 0 0 -44px; font-size: 36px; border-radius: 28px; }
            #{{ $uid }} .rj-anf-pulse { border-radius: 28px; }
            #{{ $uid }} .rj-anf-card { padding: 28px 24px 26px; }
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
                }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
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
                        stage.style.setProperty('--rj-anf-rx', (x * 10).toFixed(2) + 'deg');
                        stage.style.setProperty('--rj-anf-ry', (-y * 8).toFixed(2) + 'deg');
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
