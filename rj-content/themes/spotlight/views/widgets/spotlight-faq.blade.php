@php
    $uid = 'faq_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $openFirst = filter_var($settings['open_first'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 08 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ FAQS ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';

    $faqs = $settings['faqs'] ?? [];
    if (!is_array($faqs)) $faqs = [];
    $firstKey = !empty($faqs) ? array_key_first($faqs) : null;
@endphp

<section class="rj-faq-section" id="{{ $uid }}">

    {{-- Arxa fon işıq effekti (kartlardan ayrı, kənarları yumşaq sönür) --}}
    <div class="rj-faq-bg" aria-hidden="true">
        <span class="rj-orb rj-orb-a"></span>
        <span class="rj-orb rj-orb-b"></span>
        <span class="rj-orb rj-orb-c"></span>
        <span class="rj-beam"></span>
    </div>

    @if($showHud)
        <span class="rj-faq-line rj-line-top"><i></i><i></i></span>
        <span class="rj-faq-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-faq-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-faq-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-faq-inner">

        <div class="rj-faq-header">
            @if($badge)
                <div class="rj-faq-badge">
                    <span class="rj-faq-bars"><i></i><i></i><i></i></span>
                    <span class="rj-faq-badge-t">{{ $badge }}</span>
                    <span class="rj-faq-bars"><i></i><i></i><i></i></span>
                </div>
            @endif
            @if($title)
                <h2 class="rj-faq-title">{!! nl2br(e($title)) !!}</h2>
            @endif
        </div>

        @if(!empty($faqs))
            <div class="rj-faq-list">
                @foreach($faqs as $index => $faq)
                    @php $isOpen = $openFirst && $index === $firstKey; @endphp
                    <div class="rj-faq-item {{ $isOpen ? 'is-active' : '' }}" style="--i: {{ $loop->index }};">
                        <span class="rj-faq-glow"></span>
                        <span class="rj-faq-spot"></span>
                        <button type="button" class="rj-faq-q" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                            <span class="rj-faq-q-text">{{ str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['question'] ?? '') }}</span>
                            <span class="rj-faq-icon"><span class="rj-faq-icon-line"></span></span>
                        </button>
                        <div class="rj-faq-a">
                            <div class="rj-faq-a-inner">
                                <p>{{ str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['answer'] ?? '') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        @property --rj-ang { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

        #{{ $uid }}.rj-faq-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 24px 120px;
            display: flex;
            justify-content: center;
            overflow-x: clip;      /* yan tərəfə səhifə genişlənməsin */
            overflow-y: visible;   /* işıq yuxarı/aşağı kəsilməsin */
        }

        /* ===== ARXA FON İŞIQ ===== */
        #{{ $uid }} .rj-faq-bg {
            position: absolute;
            left: 0; right: 0; top: -160px; bottom: -160px;
            z-index: 0;
            pointer-events: none;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 22%, #000 78%, transparent 100%);
                    mask-image: linear-gradient(180deg, transparent 0%, #000 22%, #000 78%, transparent 100%);
        }
        #{{ $uid }} .rj-orb {
            position: absolute; border-radius: 50%;
            will-change: transform;
        }
        #{{ $uid }} .rj-orb-a {
            width: 620px; height: 620px; left: 6%; top: 18%;
            background: radial-gradient(circle, rgba(59,130,246,.38) 0%, rgba(59,130,246,0) 68%);
            animation: rjOrbA 16s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-orb-b {
            width: 560px; height: 560px; right: 4%; top: 38%;
            background: radial-gradient(circle, rgba(139,92,246,.32) 0%, rgba(139,92,246,0) 68%);
            animation: rjOrbB 19s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-orb-c {
            width: 480px; height: 480px; left: 38%; bottom: 8%;
            background: radial-gradient(circle, rgba(34,211,238,.22) 0%, rgba(34,211,238,0) 68%);
            animation: rjOrbC 22s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-beam {
            position: absolute; left: 50%; top: 8%;
            width: 900px; height: 420px; margin-left: -450px;
            background: radial-gradient(ellipse 50% 60% at 50% 0%, rgba(120,160,255,.28) 0%, rgba(120,160,255,0) 70%);
            animation: rjBeam 7s ease-in-out infinite alternate;
        }
        @keyframes rjOrbA { 0% { transform: translate(0,0) scale(1); } 100% { transform: translate(120px,80px) scale(1.18); } }
        @keyframes rjOrbB { 0% { transform: translate(0,0) scale(1.1); } 100% { transform: translate(-140px,-60px) scale(.92); } }
        @keyframes rjOrbC { 0% { transform: translate(0,0) scale(.95); } 100% { transform: translate(90px,-90px) scale(1.15); } }
        @keyframes rjBeam { 0% { opacity: .55; transform: scaleX(.92); } 100% { opacity: 1; transform: scaleX(1.08); } }

        /* ===== HUD ===== */
        #{{ $uid }} .rj-faq-line {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255,255,255,.14); z-index: 2;
        }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }
        #{{ $uid }} .rj-faq-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-faq-line i::before, #{{ $uid }} .rj-faq-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-faq-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-faq-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-faq-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-faq-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-faq-hud {
            position: absolute; top: 20px; z-index: 3;
            display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .08em; color: rgba(255,255,255,.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-faq-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* ===== İÇ ===== */
        #{{ $uid }} .rj-faq-inner {
            position: relative; z-index: 1;
            max-width: 860px; width: 100%; margin: 0 auto;
        }
        #{{ $uid }} .rj-faq-header { text-align: center; margin-bottom: 56px; }
        #{{ $uid }} .rj-faq-badge {
            display: inline-flex; align-items: center; gap: 14px; margin-bottom: 26px;
            padding: 9px 18px; border-radius: 999px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.12);
            -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.14);
        }
        #{{ $uid }} .rj-faq-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-faq-bars i { width: 2px; height: 100%; background: #8fb0ff; opacity: .5; animation: rjFaqBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-faq-bars i:nth-child(2) { animation-delay: .2s; }
        #{{ $uid }} .rj-faq-bars i:nth-child(3) { animation-delay: .4s; }
        #{{ $uid }} .rj-faq-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjFaqBar { 0% { transform: scaleY(.3); opacity: .2; } 100% { transform: scaleY(1); opacity: .9; } }
        #{{ $uid }} .rj-faq-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: .15em; color: rgba(255,255,255,.85); text-transform: uppercase; }

        #{{ $uid }} .rj-faq-title {
            font-size: clamp(32px, 5vw, 52px); font-weight: 600; line-height: 1.12; letter-spacing: -.035em; margin: 0;
            color: #fff;
            background: linear-gradient(180deg, #fff 30%, rgba(190,210,255,.75) 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ===== LİST ===== */
        #{{ $uid }} .rj-faq-list { display: flex; flex-direction: column; gap: 14px; }

        /* ===== GLASS KART ===== */
        #{{ $uid }} .rj-faq-item {
            position: relative;
            isolation: isolate;
            overflow: hidden;                 /* bütün effektlər kartın daxilində qalır */
            border-radius: 20px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.10) 0%, rgba(255,255,255,.03) 45%, rgba(255,255,255,.05) 100%);
            -webkit-backdrop-filter: blur(22px) saturate(170%);
                    backdrop-filter: blur(22px) saturate(170%);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.22),
                inset 0 -1px 0 rgba(255,255,255,.04),
                inset 0 0 40px rgba(255,255,255,.015);
            transition: background .4s ease, transform .4s cubic-bezier(.2,.8,.2,1);
        }

        /* Giriş animasiyası (scroll-da, ardıcıl) */
        #{{ $uid }}.rj-ready .rj-faq-item {
            opacity: 0; transform: translateY(26px) scale(.985);
            filter: blur(6px);
            transition: opacity .8s cubic-bezier(.2,.8,.2,1), transform .8s cubic-bezier(.2,.8,.2,1), filter .8s ease, background .4s ease;
            transition-delay: calc(var(--i) * 90ms);
        }
        #{{ $uid }}.rj-ready.rj-in .rj-faq-item { opacity: 1; transform: none; filter: none; }
        #{{ $uid }}.rj-ready.rj-in .rj-faq-item:hover { transition-delay: 0s; }

        /* Parıldayan şüşə kənarı */
        #{{ $uid }} .rj-faq-item::before {
            content: ""; position: absolute; inset: 0; z-index: 3; pointer-events: none;
            border-radius: inherit; padding: 1px;
            background: linear-gradient(140deg, rgba(255,255,255,.38) 0%, rgba(255,255,255,.06) 35%, rgba(255,255,255,.02) 65%, rgba(255,255,255,.22) 100%);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
                    mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
            mask-composite: exclude;
        }
        /* Aktiv kartda fırlanan işıqlı kənar */
        #{{ $uid }} .rj-faq-item.is-active::before {
            background: conic-gradient(from var(--rj-ang), rgba(255,255,255,.08) 0deg, rgba(255,255,255,.08) 220deg, #60a5fa 290deg, #a78bfa 320deg, #fff 340deg, rgba(255,255,255,.08) 360deg);
            animation: rjSpin 5s linear infinite;
        }
        @keyframes rjSpin { to { --rj-ang: 360deg; } }

        /* Aktiv kartın daxili işığı (kartdan çıxmır) */
        #{{ $uid }} .rj-faq-glow {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            border-radius: inherit;
            background:
                radial-gradient(ellipse 45% 120% at 100% 0%, rgba(96,165,250,.32) 0%, rgba(96,165,250,0) 70%),
                radial-gradient(ellipse 40% 110% at 0% 100%, rgba(167,139,250,.22) 0%, rgba(167,139,250,0) 70%);
            opacity: 0; transition: opacity .6s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-glow { opacity: 1; }

        /* Maus izləyən parıltı */
        #{{ $uid }} .rj-faq-spot {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            border-radius: inherit;
            background: radial-gradient(260px circle at var(--mx, 50%) var(--my, 50%), rgba(150,185,255,.20), rgba(150,185,255,0) 65%);
            opacity: 0; transition: opacity .35s ease;
        }
        #{{ $uid }} .rj-faq-item:hover .rj-faq-spot { opacity: 1; }
        #{{ $uid }} .rj-faq-item:hover:not(.is-active) { background: linear-gradient(135deg, rgba(255,255,255,.13) 0%, rgba(255,255,255,.04) 45%, rgba(255,255,255,.07) 100%); }

        /* ===== SUAL ===== */
        #{{ $uid }} .rj-faq-q {
            position: relative; z-index: 2;
            width: 100%;
            display: flex; align-items: center; justify-content: space-between;
            padding: 26px 30px;
            background: none; border: none; cursor: pointer; text-align: left;
            font-family: inherit; font-size: 17px; font-weight: 500; letter-spacing: -.01em;
            color: rgba(255,255,255,.92);
            transition: color .3s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-q { color: #fff; }
        #{{ $uid }} .rj-faq-q:focus-visible { outline: 2px solid #60a5fa; outline-offset: -6px; border-radius: 18px; }
        #{{ $uid }} .rj-faq-q-text { flex: 1; padding-right: 24px; line-height: 1.4; }

        /* ===== İKON ===== */
        #{{ $uid }} .rj-faq-icon {
            position: relative; width: 36px; height: 36px; flex-shrink: 0;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.14);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.18);
            transition: background .4s ease, border-color .4s ease, box-shadow .4s ease, transform .5s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-faq-icon-line,
        #{{ $uid }} .rj-faq-icon-line::after {
            content: ""; position: absolute; left: 50%; top: 50%;
            width: 12px; height: 2px; margin: -1px 0 0 -6px;
            background: #fff; border-radius: 2px;
        }
        #{{ $uid }} .rj-faq-icon-line { display: block; transition: box-shadow .4s ease; }
        #{{ $uid }} .rj-faq-icon-line::after {
            left: 0; top: 0; margin: 0;
            transform: rotate(90deg);
            transition: transform .45s cubic-bezier(.2,.8,.2,1), opacity .3s ease;
        }
        #{{ $uid }} .rj-faq-q:hover .rj-faq-icon { background: rgba(255,255,255,.12); }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon {
            transform: rotate(180deg);
            background: rgba(96,165,250,.20);
            border-color: rgba(147,185,255,.55);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.3), 0 0 16px rgba(96,165,250,.55);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon-line { box-shadow: 0 0 10px rgba(147,185,255,.9); }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon-line::after { transform: rotate(0); opacity: 0; }

        /* ===== CAVAB ===== */
        #{{ $uid }} .rj-faq-a {
            position: relative; z-index: 2;
            display: grid; grid-template-rows: 0fr;
            transition: grid-template-rows .55s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a { grid-template-rows: 1fr; }
        #{{ $uid }} .rj-faq-a-inner {
            overflow: hidden; min-height: 0;
            opacity: 0; transform: translateY(-8px);
            transition: opacity .4s ease, transform .5s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a-inner { opacity: 1; transform: none; transition-delay: .12s; }
        #{{ $uid }} .rj-faq-a-inner p {
            margin: 0; padding: 0 30px 28px;
            font-size: 15px; line-height: 1.7;
            color: rgba(214,225,255,.72);
            max-width: 680px;
        }

        /* ===== MOBİL ===== */
        @media (max-width: 640px) {
            #{{ $uid }}.rj-faq-section { padding: 100px 16px 80px; }
            #{{ $uid }} .rj-faq-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-faq-hud { top: 10px; }
            #{{ $uid }} .rj-faq-item { border-radius: 16px; }
            #{{ $uid }} .rj-faq-q { padding: 20px 20px; font-size: 15px; }
            #{{ $uid }} .rj-faq-a-inner p { padding: 0 20px 22px; font-size: 14px; }
            #{{ $uid }} .rj-orb-a, #{{ $uid }} .rj-orb-b, #{{ $uid }} .rj-orb-c { width: 380px; height: 380px; }
        }

        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *, #{{ $uid }} *::before { animation: none !important; transition: none !important; }
            #{{ $uid }}.rj-ready .rj-faq-item { opacity: 1; transform: none; filter: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var items = root.querySelectorAll('.rj-faq-item');

        /* Giriş animasiyası */
        root.classList.add('rj-ready');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { root.classList.add('rj-in'); io.disconnect(); }
                });
            }, { threshold: 0.12 });
            io.observe(root.querySelector('.rj-faq-list') || root);
        } else {
            root.classList.add('rj-in');
        }

        /* Maus parıltısı */
        items.forEach(function (item) {
            item.addEventListener('pointermove', function (e) {
                var r = item.getBoundingClientRect();
                item.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                item.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        });

        /* Accordion */
        root.querySelectorAll('.rj-faq-q').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = this.closest('.rj-faq-item');
                var wasActive = item.classList.contains('is-active');

                items.forEach(function (el) {
                    el.classList.remove('is-active');
                    var b = el.querySelector('.rj-faq-q');
                    if (b) b.setAttribute('aria-expanded', 'false');
                });

                if (!wasActive) {
                    item.classList.add('is-active');
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });
    })();
    </script>
</section>
