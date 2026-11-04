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
@endphp

<section class="rj-faq-section" id="{{ $uid }}">

    <div class="rj-faq-frame">

        @if($showHud)
            <div class="rj-faq-hudrow">
                <div class="rj-faq-hud rj-hl"><b></b>{{ $hudLeft }}</div>
                <div class="rj-faq-hud rj-hr">{{ $hudRight }}<b></b></div>
            </div>
        @endif

        @if($badge)
            <div class="rj-faq-badgerow">
                <i class="rj-cross rj-cross-l"></i>
                <i class="rj-cross rj-cross-r"></i>
                <div class="rj-faq-badge">
                    <span class="rj-faq-bars"><i></i><i></i><i></i></span>
                    <span class="rj-faq-badge-t">{{ $badge }}</span>
                    <span class="rj-faq-bars"><i></i><i></i><i></i></span>
                </div>
            </div>
        @endif

        <div class="rj-faq-header">
            @if($title)
                <h2 class="rj-faq-title">{!! nl2br(e($title)) !!}</h2>
            @endif
        </div>

        @if(!empty($faqs))
            <div class="rj-faq-list">
                @foreach($faqs as $index => $faq)
                    @php $isOpen = $openFirst && $index === array_key_first($faqs); @endphp
                    <div class="rj-faq-item {{ $isOpen ? 'is-active' : '' }}">
                        <div class="rj-faq-glow"></div>
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
        #{{ $uid }}.rj-faq-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 60px 24px 100px;
            display: flex;
            justify-content: center;
        }

        /* Frame: sol/sağ şaquli xətlər */
        #{{ $uid }} .rj-faq-frame {
            position: relative;
            width: 100%;
            max-width: 972px;
            border-left: 1px solid rgba(255, 255, 255, 0.14);
            border-right: 1px solid rgba(255, 255, 255, 0.14);
        }

        /* HUD sırası */
        #{{ $uid }} .rj-faq-hudrow {
            position: relative;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            /* xətlər frame-dən kənara çıxsın */
            box-shadow: -200px 0 0 -0px transparent;
        }
        #{{ $uid }} .rj-faq-hudrow::before,
        #{{ $uid }} .rj-faq-hudrow::after {
            content: ""; position: absolute; top: -1px; bottom: -1px; width: 100vw;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            pointer-events: none;
        }
        #{{ $uid }} .rj-faq-hudrow::before { right: 100%; }
        #{{ $uid }} .rj-faq-hudrow::after { left: 100%; }

        #{{ $uid }} .rj-faq-hud {
            display: flex; align-items: center; gap: 10px;
            font: 700 9px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { margin-left: -1px; }
        #{{ $uid }} .rj-hr { margin-right: -1px; }
        #{{ $uid }} .rj-faq-hud b { display: block; width: 2px; height: 14px; background: #fff; }

        /* Badge sırası */
        #{{ $uid }} .rj-faq-badgerow {
            position: relative;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
        }
        #{{ $uid }} .rj-faq-badgerow::before,
        #{{ $uid }} .rj-faq-badgerow::after {
            content: ""; position: absolute; bottom: -1px; height: 1px; width: 100vw;
            background: rgba(255, 255, 255, 0.14); pointer-events: none;
        }
        #{{ $uid }} .rj-faq-badgerow::before { right: 100%; }
        #{{ $uid }} .rj-faq-badgerow::after { left: 100%; }

        #{{ $uid }} .rj-cross { position: absolute; bottom: -7px; width: 13px; height: 13px; z-index: 2; }
        #{{ $uid }} .rj-cross::before, #{{ $uid }} .rj-cross::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-cross::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-cross::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-cross-l { left: -7px; }
        #{{ $uid }} .rj-cross-r { right: -7px; }

        #{{ $uid }} .rj-faq-badge { display: inline-flex; align-items: center; gap: 12px; }
        #{{ $uid }} .rj-faq-bars { display: inline-flex; gap: 3px; height: 10px; align-items: center; }
        #{{ $uid }} .rj-faq-bars i { width: 2px; height: 100%; background: var(--rj-muted, #9ca3af); opacity: 0.5; animation: rjFaqBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-faq-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-faq-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-faq-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjFaqBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-faq-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 9px; font-weight: 700; letter-spacing: 0.15em; color: #fff; text-transform: uppercase; }

        /* Başlıq */
        #{{ $uid }} .rj-faq-header { text-align: center; padding: 56px 20px 72px; }
        #{{ $uid }} .rj-faq-title { font-size: clamp(30px, 4.5vw, 38px); font-weight: 500; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin: 0; }

        /* Siyahı */
        #{{ $uid }} .rj-faq-list { display: flex; flex-direction: column; gap: 10px; }

        /* Kart */
        #{{ $uid }} .rj-faq-item {
            position: relative;
            isolation: isolate;
            overflow: hidden;               /* effektlər kartdan çıxmır */
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(10, 14, 28, 0.85) 0%, rgba(5, 7, 14, 0.95) 100%);
            border: 1px solid rgba(80, 120, 255, 0.14);
            transition: border-color 0.3s ease, background 0.3s ease;
        }
        /* sol mavi xətt */
        #{{ $uid }} .rj-faq-item::before {
            content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 2px;
            background: #2f5bff; z-index: 2; border-radius: 12px 0 0 12px;
        }
        #{{ $uid }} .rj-faq-item:hover { border-color: rgba(80, 120, 255, 0.3); }
        #{{ $uid }} .rj-faq-item.is-active { border-color: rgba(80, 120, 255, 0.4); }

        /* İşıq effekti: yalnız kartın daxilində */
        #{{ $uid }} .rj-faq-glow {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            border-radius: inherit;
            background:
                radial-gradient(ellipse 38% 130% at 100% 100%, rgba(47, 91, 255, 0.55) 0%, rgba(47, 91, 255, 0) 70%),
                radial-gradient(ellipse 30% 90% at 82% 0%, rgba(47, 91, 255, 0.18) 0%, rgba(47, 91, 255, 0) 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            clip-path: inset(0 round 12px);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-glow { opacity: 1; }

        /* Sual */
        #{{ $uid }} .rj-faq-q {
            position: relative; z-index: 1;
            width: 100%;
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 24px;
            background: none; border: none;
            border-bottom: 1px solid transparent;
            cursor: pointer; text-align: left;
            font-family: inherit; font-size: 13px; font-weight: 500;
            color: #8fb0ff;
            transition: border-color 0.3s ease, color 0.3s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-q { border-bottom-color: rgba(255, 255, 255, 0.9); color: #a9c1ff; }
        #{{ $uid }} .rj-faq-q:focus-visible { outline: 2px solid #3b82f6; outline-offset: -4px; border-radius: 10px; }
        #{{ $uid }} .rj-faq-q-text { flex: 1; padding-right: 20px; line-height: 1.4; }

        /* İkon: bağlı = +, açıq = − */
        #{{ $uid }} .rj-faq-icon { position: relative; width: 14px; height: 14px; flex-shrink: 0; }
        #{{ $uid }} .rj-faq-icon-line,
        #{{ $uid }} .rj-faq-icon-line::after {
            content: ""; position: absolute; left: 0; top: 50%;
            width: 14px; height: 2px; margin-top: -1px;
            background: #fff; border-radius: 2px;
        }
        #{{ $uid }} .rj-faq-icon-line { display: block; }
        #{{ $uid }} .rj-faq-icon-line::after {
            top: 0; margin-top: 0;
            transform: rotate(90deg);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.35s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon-line::after { transform: rotate(0deg); opacity: 0; }

        /* Cavab */
        #{{ $uid }} .rj-faq-a {
            position: relative; z-index: 1;
            display: grid; grid-template-rows: 0fr;
            transition: grid-template-rows 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a { grid-template-rows: 1fr; }
        #{{ $uid }} .rj-faq-a-inner {
            overflow: hidden; min-height: 0;
            opacity: 0; transition: opacity 0.35s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a-inner { opacity: 1; transition-delay: 0.1s; }
        #{{ $uid }} .rj-faq-a-inner p {
            margin: 0; padding: 18px 24px 22px;
            font-size: 13px; line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
        }

        @media (max-width: 640px) {
            #{{ $uid }}.rj-faq-section { padding: 40px 16px 70px; }
            #{{ $uid }} .rj-faq-bars { display: none; }
            #{{ $uid }} .rj-faq-header { padding: 40px 16px 48px; }
            #{{ $uid }} .rj-faq-q { padding: 18px 18px; }
            #{{ $uid }} .rj-faq-a-inner p { padding: 16px 18px 18px; }
        }

        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} * { animation: none !important; transition: none !important; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        root.querySelectorAll('.rj-faq-q').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = this.closest('.rj-faq-item');
                var wasActive = item.classList.contains('is-active');

                root.querySelectorAll('.rj-faq-item').forEach(function (el) {
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
