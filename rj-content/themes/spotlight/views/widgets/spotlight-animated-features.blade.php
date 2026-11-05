@php
    $uid = 'anf_' . substr(md5(uniqid('', true)), 0, 8);

    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_slice(array_values($features), 0, 6);
@endphp

<section class="rj-anf-section" id="{{ $uid }}">
    <div class="rj-anf-inner">

        @if($badge)
            <div class="rj-anf-badge">
                <span class="rj-anf-bars"><i></i><i></i><i></i></span>
                <span class="rj-anf-badge-t">{{ $badge }}</span>
                <span class="rj-anf-bars"><i></i><i></i><i></i></span>
            </div>
        @endif

        {{-- Kvant Nüvəsi Animasiyası --}}
        <div class="rj-anf-core-wrap">
            <div class="rj-anf-core">
                <div class="rj-anf-ring rj-anf-ring-1"></div>
                <div class="rj-anf-ring rj-anf-ring-2"></div>
                <div class="rj-anf-ring rj-anf-ring-3"></div>
                <div class="rj-anf-sphere"></div>
                <div class="rj-anf-glow"></div>
            </div>
            <div class="rj-anf-particles">
                @for ($i = 0; $i < 15; $i++)
                    <div class="rj-anf-particle" style="--delay: {{ $i * 0.3 }}s; --x: {{ rand(-100, 100) }}px; --y: {{ rand(-100, 100) }}px;"></div>
                @endfor
            </div>
        </div>

        <div class="rj-anf-text">
            @if($title)
                <h2 class="rj-anf-title">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="rj-anf-sub">{{ $subtitle }}</p>
            @endif
        </div>

        @if(!empty($features))
            <div class="rj-anf-grid">
                @foreach($features as $i => $item)
                    <div class="rj-anf-card" style="--i: {{ $i }};">
                        <div class="rj-anf-icon">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                        </div>
                        <h3 class="rj-anf-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                        <p class="rj-anf-card-desc">{{ $item['feature_text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-anf-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 120px 24px;
            overflow: hidden;
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

        /* Badge */
        #{{ $uid }} .rj-anf-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 32px; }
        #{{ $uid }} .rj-anf-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-anf-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjAnfBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-anf-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-anf-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-anf-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjAnfBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-anf-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        /* =========================================
           KVANT NÜVƏSİ ANİMASİYASI (Quantum Core)
           ========================================= */
        #{{ $uid }} .rj-anf-core-wrap {
            position: relative;
            width: 300px;
            height: 300px;
            margin-bottom: 56px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #{{ $uid }} .rj-anf-core {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: rjAnfFloat 6s ease-in-out infinite;
        }

        #{{ $uid }} .rj-anf-sphere {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #fff, #3b82f6 50%, #000 100%);
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.8), 0 0 80px rgba(59, 130, 246, 0.4);
            position: relative;
            z-index: 2;
        }

        #{{ $uid }} .rj-anf-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2) inset;
            top: 50%; left: 50%;
            transform-style: preserve-3d;
        }

        #{{ $uid }} .rj-anf-ring-1 {
            width: 200px; height: 200px;
            margin: -100px 0 0 -100px;
            animation: rjAnfSpinX 8s linear infinite;
        }
        #{{ $uid }} .rj-anf-ring-2 {
            width: 260px; height: 260px;
            margin: -130px 0 0 -130px;
            border-color: rgba(236, 72, 153, 0.4);
            box-shadow: 0 0 20px rgba(236, 72, 153, 0.2) inset;
            animation: rjAnfSpinY 12s linear infinite;
        }
        #{{ $uid }} .rj-anf-ring-3 {
            width: 320px; height: 320px;
            margin: -160px 0 0 -160px;
            border-style: dashed;
            border-color: rgba(255, 255, 255, 0.1);
            animation: rjAnfSpinZ 20s linear infinite;
        }

        #{{ $uid }} .rj-anf-glow {
            position: absolute;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(20px);
            z-index: 1;
            animation: rjAnfPulse 4s ease-in-out infinite alternate;
        }

        /* Hissəciklər (Particles) */
        #{{ $uid }} .rj-anf-particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 3;
        }
        #{{ $uid }} .rj-anf-particle {
            position: absolute;
            top: 50%; left: 50%;
            width: 4px; height: 4px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px #3b82f6;
            opacity: 0;
            animation: rjAnfParticle 4s ease-out infinite;
            animation-delay: var(--delay);
        }

        @keyframes rjAnfFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @keyframes rjAnfSpinX {
            0% { transform: rotateX(70deg) rotateZ(0deg); }
            100% { transform: rotateX(70deg) rotateZ(360deg); }
        }
        @keyframes rjAnfSpinY {
            0% { transform: rotateY(70deg) rotateZ(0deg); }
            100% { transform: rotateY(70deg) rotateZ(360deg); }
        }
        @keyframes rjAnfSpinZ {
            0% { transform: rotateZ(0deg); }
            100% { transform: rotateZ(360deg); }
        }
        @keyframes rjAnfPulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.2); opacity: 1; }
        }
        @keyframes rjAnfParticle {
            0% { transform: translate(0, 0) scale(1); opacity: 1; }
            100% { transform: translate(var(--x), var(--y)) scale(0); opacity: 0; }
        }

        /* Text */
        #{{ $uid }} .rj-anf-text { text-align: center; max-width: 800px; margin-bottom: 64px; }
        #{{ $uid }} .rj-anf-title { font-size: clamp(32px, 5vw, 52px); font-weight: 600; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin: 0 0 20px; }
        #{{ $uid }} .rj-anf-sub { font-size: clamp(16px, 2vw, 18px); line-height: 1.6; color: var(--rj-muted); margin: 0; }

        /* Grid */
        #{{ $uid }} .rj-anf-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 48px 32px;
            width: 100%;
        }
        #{{ $uid }} .rj-anf-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: rjAnfIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }
        @keyframes rjAnfIn { to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-anf-icon { display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; margin-bottom: 20px; color: #3b82f6; }
        #{{ $uid }} .rj-anf-icon iconify-icon { font-size: 32px; stroke-width: 1.5; }
        #{{ $uid }} .rj-anf-card-title { font-size: 16px; font-weight: 600; color: #fff; margin: 0 0 12px; }
        #{{ $uid }} .rj-anf-card-desc { font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0; max-width: 280px; }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-anf-grid { grid-template-columns: repeat(2, 1fr); gap: 40px 24px; }
            #{{ $uid }} .rj-anf-core-wrap { width: 250px; height: 250px; }
            #{{ $uid }} .rj-anf-ring-3 { display: none; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-anf-section { padding: 80px 20px; }
            #{{ $uid }} .rj-anf-grid { grid-template-columns: 1fr; gap: 32px; }
            #{{ $uid }} .rj-anf-bars { display: none; }
            #{{ $uid }} .rj-anf-core-wrap { width: 200px; height: 200px; margin-bottom: 40px; }
            #{{ $uid }} .rj-anf-sphere { width: 80px; height: 80px; }
            #{{ $uid }} .rj-anf-ring-1 { width: 140px; height: 140px; margin: -70px 0 0 -70px; }
            #{{ $uid }} .rj-anf-ring-2 { width: 180px; height: 180px; margin: -90px 0 0 -90px; }
        }
    </style>

    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</section>
