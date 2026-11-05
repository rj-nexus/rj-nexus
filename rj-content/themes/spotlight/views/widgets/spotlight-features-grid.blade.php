@php
    $uid = 'anf_' . substr(md5(uniqid('', true)), 0, 8);

    $badge = $settings['badge_text'] ?? 'Why RJ Nexus works smarter.';
    $title = $settings['title'] ?? 'Built for modern teams. Backed by cutting-edge AI.';
    $subtitle = $settings['subtitle'] ?? '';

    $features = $settings['features'] ?? [];
    if (!is_array($features) || empty($features)) {
        $features = [
            ['icon' => 'ph:device-mobile', 'title' => 'All-in-one platform', 'desc' => 'No more juggling tools. We unify content, design, code, and video.'],
            ['icon' => 'ph:cpu', 'title' => 'Multi-model AI core', 'desc' => 'ChatGPT, Claude, Gemini — we pick the smartest engine for every task.'],
            ['icon' => 'ph:desktop', 'title' => 'Prompt-level control', 'desc' => 'Every feature is prompt-optimized, giving you control without overwhelm.'],
            ['icon' => 'ph:rocket-launch', 'title' => 'Speed that scales', 'desc' => 'From solo to teams, we deliver fast outputs — even under heavy loads.'],
            ['icon' => 'ph:shield-check', 'title' => 'Secure by design', 'desc' => 'Your content and code stay private. We never store sensitive data.'],
            ['icon' => 'ph:arrows-clockwise', 'title' => 'Always evolving', 'desc' => 'We improve weekly with better prompts, UI, and models — for free.'],
        ];
    }
    $features = array_slice(array_values($features), 0, 6);

    $orbits = [];
    for ($i = 0; $i < 6; $i++) {
        $ring = $i % 2;
        $idx = intdiv($i, 2);
        $dur = $ring === 0 ? 46 : 32;
        $offset = $ring === 1 ? 0.5 / 3 : 0;
        $orbits[] = [
            'ring' => $ring,
            'dur' => $dur,
            'delay' => -round($dur * ($idx / 3 + $offset), 2),
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
                <span class="rj-anf-ticks"></span>
                <span class="rj-anf-ring is-arc" style="--sz:92%; --spin:9s;"></span>
                <span class="rj-anf-ring is-dash is-rev" style="--sz:60%;"></span>
                <span class="rj-anf-ring is-arc is-violet is-rev" style="--sz:34%; --spin:5s;"></span>
                <span class="rj-anf-sweep"></span>

                @foreach($orbits as $o)
                    <div class="rj-anf-orbit {{ $o['ring'] ? 'is-rev' : '' }}" style="--sz: {{ $o['ring'] ? '60%' : '92%' }}; --dur: {{ $o['dur'] }}s; --dly: {{ $o['delay'] }}s;">
                        <span class="rj-anf-node"></span>
                    </div>
                @endforeach

                <div class="rj-anf-core">
                    <span class="rj-anf-pulse"></span>
                    <span class="rj-anf-pulse" style="animation-delay:-2s;"></span>
                    <span class="rj-anf-orb"></span>
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
<<<<<<<< HEAD:views/widgets/spotlight-features-grid.blade.php
                            <div class="rj-anf-card-icon">
                                <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                            </div>
                            <h3 class="rj-anf-card-title">{{ $item['title'] ?? '' }}</h3>
                            <p class="rj-anf-card-desc">{{ $item['desc'] ?? '' }}</p>
========
<<<<<<< HEAD
=======
                            {{-- BURADA İKONU EKRANA ÇIXARIRIQ --}}
                            <div class="rj-anf-card-icon">
                                <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                            </div>
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
                            <h3 class="rj-anf-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                            <p class="rj-anf-card-desc">{{ $item['feature_text'] ?? '' }}</p>
>>>>>>>> e24e31ee674847c9f1a29f3c3e8f3fa88c22d693:views/widgets/spotlight-animated-features.blade.php
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
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            -webkit-mask-composite: source-in;
            mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            mask-composite: intersect;
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
            border: 1px dashed rgba(129, 140, 248, .34);
            animation: rjAnfSpin 26s linear infinite;
        }
        #{{ $uid }} .rj-anf-ring.is-rev { animation-direction: reverse; }
        #{{ $uid }} .rj-anf-ring.is-arc::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 2px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent 0deg, transparent 240deg, var(--a3) 335deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
            animation: rjAnfSpin var(--spin) linear infinite;
        }
        #{{ $uid }} .rj-anf-ring.is-arc.is-violet::before {
            background: conic-gradient(from 0deg, transparent 0deg, transparent 240deg, var(--a2) 335deg, transparent 360deg);
            animation-direction: reverse;
        }
        #{{ $uid }} .rj-anf-ticks {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: repeating-conic-gradient(rgba(255, 255, 255, .38) 0deg .6deg, transparent .6deg 6deg);
            -webkit-mask-image: radial-gradient(circle closest-side, transparent 95.5%, #000 96%);
            mask-image: radial-gradient(circle closest-side, transparent 95.5%, #000 96%);
            animation: rjAnfSpin 60s linear infinite;
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
            width: 10px;
            height: 10px;
            margin: -5px 0 0 -5px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 10px 2px rgba(34, 211, 238, .85), 0 0 26px rgba(59, 130, 246, .6);
        }
        #{{ $uid }} .rj-anf-orbit.is-rev .rj-anf-node {
            background: #e0e7ff;
            box-shadow: 0 0 10px 2px rgba(129, 140, 248, .9), 0 0 26px rgba(99, 102, 241, .6);
        }

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
            background: linear-gradient(145deg, rgba(255, 255, 255, .16), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .28), 0 0 60px rgba(59, 130, 246, .4), 0 20px 40px rgba(0, 0, 0, .5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: rjAnfFloat 6s ease-in-out infinite;
        }
        #{{ $uid }} .rj-anf-orb {
            position: relative;
            z-index: 2;
            width: 34%;
            aspect-ratio: 1;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, #fff, #60a5fa 45%, #1d4ed8 100%);
            box-shadow: 0 0 30px rgba(96, 165, 250, .9), 0 0 60px rgba(59, 130, 246, .5);
            animation: rjAnfBreathe 3.5s ease-in-out infinite alternate;
        }
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
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 16px 20px;
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

        #{{ $uid }} .rj-anf-card-title,
<<<<<<< HEAD
        #{{ $uid }} .rj-anf-card-desc { position: relative; z-index: 1; }

\1            display: flex;
            align-items: center;
            gap: 10px;
\2
=======
        #{{ $uid }} .rj-anf-card-desc,
        #{{ $uid }} .rj-anf-card-icon { position: relative; z-index: 1; }

        #{{ $uid }} .rj-anf-card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 4px;
            font-size: 24px;
            color: var(--a3);
            filter: drop-shadow(0 0 10px rgba(34, 211, 238, 0.4));
        }

        #{{ $uid }} .rj-anf-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
            font-weight: 600;
            letter-spacing: -.01em;
            color: #fff;
            margin: 0;
            line-height: 1.3;
        }
<<<<<<<< HEAD:views/widgets/spotlight-features-grid.blade.php
========
<<<<<<< HEAD
>>>>>>>> e24e31ee674847c9f1a29f3c3e8f3fa88c22d693:views/widgets/spotlight-animated-features.blade.php
        #{{ $uid }} .rj-anf-card-title::before {
            content: '';
            flex-shrink: 0;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--a3);
            box-shadow: 0 0 10px var(--a3);
        }
<<<<<<<< HEAD:views/widgets/spotlight-features-grid.blade.php
========
=======
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
>>>>>>>> e24e31ee674847c9f1a29f3c3e8f3fa88c22d693:views/widgets/spotlight-animated-features.blade.php
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
<<<<<<< HEAD
=======
            #{{ $uid }} .rj-anf-card-icon { justify-content: center; }
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
        }
        @media (max-width: 560px) {
            #{{ $uid }} .rj-anf-grid { grid-template-columns: 1fr; }
            #{{ $uid }} .rj-anf-stage-wrap { max-width: 240px; }
            #{{ $uid }} .rj-anf-node { width: 8px; height: 8px; margin: -4px 0 0 -4px; }
            #{{ $uid }} .rj-anf-core { width: 72px; height: 72px; margin: -36px 0 0 -36px; border-radius: 22px; }
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
<<<<<<<< HEAD:views/widgets/spotlight-features-grid.blade.php
========
<<<<<<< HEAD
=======

    {{-- İKONLARIN YÜKLƏNMƏSİ ÜÇÜN --}}
    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
>>>>>>>> e24e31ee674847c9f1a29f3c3e8f3fa88c22d693:views/widgets/spotlight-animated-features.blade.php
</section>
