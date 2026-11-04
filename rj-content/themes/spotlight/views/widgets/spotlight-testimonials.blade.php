@php
    $uid = 'testi_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 07 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ TESTIMONIALS ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';

    $testimonials = $settings['testimonials'] ?? [];
    if (!is_array($testimonials)) $testimonials = [];

    // Fallback əgər məlumat yoxdursa
    if (count($testimonials) < 6) {
        $fallback = [
            ['name' => 'Ethan Moore', 'username' => '@ethanmoore', 'text' => 'Started with the free plan on @qore and didn\'t expect much.', 'image' => ''],
            ['name' => 'Sarah Chen', 'username' => '@sarahchen', 'text' => '@qore helps me organize creative tasks way faster.', 'image' => ''],
            ['name' => 'Olivia Tran', 'username' => '@oliviatran', 'text' => 'As a marketer, I rely on @qore daily.', 'image' => ''],
            ['name' => 'Lucas Bennett', 'username' => '@lucasbennett', 'text' => 'The image prompt support is smooth and the AI responses feel human.', 'image' => ''],
            ['name' => 'James Wilson', 'username' => '@jameswilson', 'text' => '@qore helps me organize creative tasks way faster.', 'image' => ''],
            ['name' => 'Elena Rossi', 'username' => '@elenarossi', 'text' => 'I use @qore to generate ideas for my startup.', 'image' => ''],
        ];
        $testimonials = array_merge($testimonials, array_slice($fallback, count($testimonials)));
    }

    // İlk 3 yuxarı, son 3 aşağı
    $topRow = array_slice($testimonials, 0, 3);
    $bottomRow = array_slice($testimonials, 3, 3);

    // Sonsuz dövrə üçün kartları çoxaldırıq (təkrarlayırıq)
    $topRowLoop = array_merge($topRow, $topRow, $topRow, $topRow);
    $bottomRowLoop = array_merge($bottomRow, $bottomRow, $bottomRow, $bottomRow);
@endphp

<section class="rj-testi-section" id="{{ $uid }}">

    {{-- Fırlanan Planet Arxa Fon --}}
    <div class="rj-testi-globe-wrap">
        <div class="rj-testi-globe"></div>
        <div class="rj-testi-globe-glow"></div>
    </div>

    @if($showHud)
        <span class="rj-testi-line rj-line-top"><i></i><i></i></span>
        <span class="rj-testi-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-testi-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-testi-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-testi-inner">

        <div class="rj-testi-header">
            @if($badge)
                <div class="rj-testi-badge">
                    <span class="rj-testi-bars"><i></i><i></i><i></i></span>
                    <span class="rj-testi-badge-t">{{ $badge }}</span>
                    <span class="rj-testi-bars"><i></i><i></i><i></i></span>
                </div>
            @endif
            @if($title)
                <h2 class="rj-testi-title">{{ $title }}</h2>
            @endif
        </div>

        <div class="rj-testi-marquee-wrap">

            {{-- Yuxarı sıra (Soldan Sağa) --}}
            <div class="rj-testi-row">
                <div class="rj-testi-track track-ltr">
                    @foreach($topRowLoop as $index => $t)
                        @php
                            $initial = mb_substr($t['name'] ?? 'A', 0, 1);
                            $text = preg_replace('/(@\w+)/', '<span class="rj-tag-mention">$1</span>', e($t['text'] ?? ''));
                        @endphp
                        <div class="rj-testi-card">
                            <div class="rj-testi-card-inner">
                                <div class="rj-testi-user">
                                    @if(!empty($t['image']))
                                        <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}" class="rj-testi-avatar">
                                    @else
                                        <div class="rj-testi-avatar rj-avatar-fallback">{{ $initial }}</div>
                                    @endif
                                    <div class="rj-testi-user-info">
                                        <span class="rj-testi-name">{{ $t['name'] ?? '' }}</span>
                                        <span class="rj-testi-username">{{ $t['username'] ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="rj-testi-text">{!! $text !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aşağı sıra (Sağdan Sola) --}}
            <div class="rj-testi-row">
                <div class="rj-testi-track track-rtl">
                    @foreach($bottomRowLoop as $index => $t)
                        @php
                            $initial = mb_substr($t['name'] ?? 'A', 0, 1);
                            $text = preg_replace('/(@\w+)/', '<span class="rj-tag-mention">$1</span>', e($t['text'] ?? ''));
                        @endphp
                        <div class="rj-testi-card">
                            <div class="rj-testi-card-inner">
                                <div class="rj-testi-user">
                                    @if(!empty($t['image']))
                                        <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}" class="rj-testi-avatar">
                                    @else
                                        <div class="rj-testi-avatar rj-avatar-fallback">{{ $initial }}</div>
                                    @endif
                                    <div class="rj-testi-user-info">
                                        <span class="rj-testi-name">{{ $t['name'] ?? '' }}</span>
                                        <span class="rj-testi-username">{{ $t['username'] ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="rj-testi-text">{!! $text !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        #{{ $uid }}.rj-testi-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 0 120px; /* Yanlardan padding sildik ki, lent kənara çıxsın */
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* Fırlanan Planet */
        #{{ $uid }} .rj-testi-globe-wrap {
            position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%);
            width: 600px; height: 600px; pointer-events: none; z-index: 0;
        }
        #{{ $uid }} .rj-testi-globe {
            position: absolute; inset: 0; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(59,130,246,0.15), transparent 60%);
            border: 1px solid rgba(59,130,246,0.1);
            box-shadow: inset 0 0 80px rgba(59,130,246,0.1);
            animation: rotateGlobe 30s linear infinite;
        }
        #{{ $uid }} .rj-testi-globe::before {
            content: ''; position: absolute; inset: 0; border-radius: 50%;
            background-image:
                linear-gradient(rgba(59,130,246,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, #000 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(circle at center, #000 30%, transparent 70%);
        }
        #{{ $uid }} .rj-testi-globe-glow {
            position: absolute; inset: -20%;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 60%);
            filter: blur(40px); animation: pulseGlow 4s ease-in-out infinite alternate;
        }
        @keyframes rotateGlobe { 100% { transform: rotate(360deg); } }
        @keyframes pulseGlow { 0% { opacity: 0.5; transform: scale(0.9); } 100% { opacity: 1; transform: scale(1.1); } }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-testi-line { position: absolute; left: 0; right: 0; height: 1px; background: rgba(255, 255, 255, 0.14); z-index: 2; }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }
        #{{ $uid }} .rj-testi-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-testi-line i::before, #{{ $uid }} .rj-testi-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-testi-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-testi-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-testi-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-testi-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-testi-hud {
            position: absolute; top: 20px; z-index: 3; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-testi-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Inner */
        #{{ $uid }} .rj-testi-inner {
            position: relative; z-index: 1; max-width: 1200px; width: 100%; margin: 0 auto;
        }

        #{{ $uid }} .rj-testi-header { text-align: center; margin-bottom: 64px; }
        #{{ $uid }} .rj-testi-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-testi-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-testi-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjTestiBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-testi-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-testi-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-testi-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjTestiBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-testi-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        #{{ $uid }} .rj-testi-title { font-size: clamp(32px, 5vw, 52px); font-weight: 600; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin: 0; }

        /* Marquee Lentləri */
        #{{ $uid }} .rj-testi-marquee-wrap {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 24px;
            width: 100vw;
            left: 50%;
            transform: translateX(-50%);
            /* Kənarları yumşaq itirmək üçün mask */
            mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
        }

        #{{ $uid }} .rj-testi-row {
            overflow: hidden;
            display: flex;
            width: 100%;
        }

        #{{ $uid }} .rj-testi-track {
            display: flex;
            gap: 24px;
            width: max-content;
            will-change: transform;
        }

        #{{ $uid }} .rj-testi-track.track-ltr {
            animation: scrollLTR 40s linear infinite;
        }

        #{{ $uid }} .rj-testi-track.track-rtl {
            animation: scrollRTL 40s linear infinite;
        }

        /* Üzərinə gələndə dayansın ki, oxumaq mümkün olsun */
        #{{ $uid }} .rj-testi-row:hover .rj-testi-track {
            animation-play-state: paused;
        }

        @keyframes scrollLTR {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        @keyframes scrollRTL {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Card - Tünd Fon */
        #{{ $uid }} .rj-testi-card {
            position: relative;
            width: 360px;
            flex-shrink: 0;
            background: linear-gradient(180deg, rgba(20, 20, 28, 0.85) 0%, rgba(10, 10, 15, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            transition: border-color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }

        #{{ $uid }} .rj-testi-card:hover {
            border-color: rgba(59, 130, 246, 0.4);
            background: linear-gradient(180deg, rgba(30, 32, 45, 0.95) 0%, rgba(15, 15, 22, 1) 100%);
            box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.7), 0 0 20px rgba(59, 130, 246, 0.1);
        }

        #{{ $uid }} .rj-testi-card-inner { padding: 28px; display: flex; flex-direction: column; height: 100%; }

        #{{ $uid }} .rj-testi-user { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        #{{ $uid }} .rj-testi-avatar {
            width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
            object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1);
        }
        #{{ $uid }} .rj-avatar-fallback {
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(59,130,246,0.8), rgba(147,51,234,0.8));
            color: #fff; font-size: 18px; font-weight: 700;
        }

        #{{ $uid }} .rj-testi-user-info { display: flex; flex-direction: column; }
        #{{ $uid }} .rj-testi-name { font-size: 15px; font-weight: 600; color: #fff; line-height: 1.2; }
        #{{ $uid }} .rj-testi-username { font-size: 13px; color: var(--rj-muted); margin-top: 2px; }

        #{{ $uid }} .rj-testi-text {
            font-size: 14px; line-height: 1.6; color: rgba(255, 255, 255, 0.7);
            flex: 1;
        }
        #{{ $uid }} .rj-tag-mention { color: #3b82f6; font-weight: 600; }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-testi-globe-wrap { width: 400px; height: 400px; }
            #{{ $uid }} .rj-testi-card { width: 300px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-testi-section { padding: 100px 0 80px; }
            #{{ $uid }} .rj-testi-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-testi-hud { top: 10px; }
            #{{ $uid }} .rj-testi-globe-wrap { width: 300px; height: 300px; }
            #{{ $uid }} .rj-testi-marquee-wrap { gap: 16px; }
            #{{ $uid }} .rj-testi-card { width: 260px; }
            #{{ $uid }} .rj-testi-track.track-ltr,
            #{{ $uid }} .rj-testi-track.track-rtl { animation-duration: 30s; }
        }
    </style>
</section>
