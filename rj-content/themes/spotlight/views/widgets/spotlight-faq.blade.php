@php
    $uid = 'faq_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 08 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ FAQS ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';

    $faqs = $settings['faqs'] ?? [];
    if (!is_array($faqs)) $faqs = [];
@endphp

<section class="rj-faq-section" id="{{ $uid }}">

    {{-- Arxadakı işıq (Glow) effekti --}}
    <div class="rj-faq-glow" aria-hidden="true"></div>

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
                    @php
                        $q = str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['question'] ?? '');
                        $a = str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['answer'] ?? '');
                    @endphp
                    <div class="rj-faq-item" style="--i: {{ $index }};">
                        {{-- Aktiv olanda üst hissədə yaranan işıq xətti --}}
                        <div class="rj-faq-item-glow"></div>

                        <button class="rj-faq-q" aria-expanded="false">
                            <span class="rj-faq-q-text">{{ $q }}</span>
                            <span class="rj-faq-icon-wrap">
                                <span class="rj-faq-icon">
                                    <span class="rj-line-h"></span>
                                    <span class="rj-line-v"></span>
                                </span>
                            </span>
                        </button>
                        <div class="rj-faq-a">
                            <div class="rj-faq-a-inner">
                                <p>{{ $a }}</p>
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
            padding: 140px 24px 120px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* Mərkəzdən yuxarıya yayılan əsas işıq */
        #{{ $uid }} .rj-faq-glow {
            position: absolute;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 600px;
            background: radial-gradient(ellipse at center, rgba(59, 130, 246, 0.15) 0%, transparent 60%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-faq-line {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255, 255, 255, 0.14); z-index: 2;
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
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-faq-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Inner Layout */
        #{{ $uid }} .rj-faq-inner {
            position: relative; z-index: 1;
            max-width: 900px; width: 100%; margin: 0 auto;
        }

        #{{ $uid }} .rj-faq-header { text-align: center; margin-bottom: 56px; }
        #{{ $uid }} .rj-faq-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-faq-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-faq-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjFaqBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-faq-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-faq-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-faq-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjFaqBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-faq-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        #{{ $uid }} .rj-faq-title { font-size: clamp(32px, 5vw, 48px); font-weight: 600; line-height: 1.15; letter-spacing: -0.03em; color: #fff; margin: 0; text-shadow: 0 0 30px rgba(59, 130, 246, 0.3); }

        /* FAQ List */
        #{{ $uid }} .rj-faq-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* FAQ Item (Şüşə effektli) */
        #{{ $uid }} .rj-faq-item {
            position: relative;
            background: rgba(15, 15, 22, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            overflow: hidden;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-faq-item:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(20, 20, 28, 0.8);
        }

        /* Aktiv olanda arxa fon və kənarlıq */
        #{{ $uid }} .rj-faq-item.is-active {
            border-color: rgba(59, 130, 246, 0.4);
            background: linear-gradient(180deg, rgba(20, 30, 50, 0.8) 0%, rgba(10, 10, 15, 0.9) 100%);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.7);
        }

        /* Aktiv olanda yuxarıda görünən mavi işıq */
        #{{ $uid }} .rj-faq-item-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.15) 0%, transparent 60%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
            z-index: 0;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-item-glow {
            opacity: 1;
        }

        /* Button */
        #{{ $uid }} .rj-faq-q {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 28px;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            font-size: 16px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            transition: color 0.3s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-q,
        #{{ $uid }} .rj-faq-q:hover {
            color: #fff;
        }

        #{{ $uid }} .rj-faq-q-text {
            flex: 1;
            padding-right: 20px;
            line-height: 1.4;
        }

        /* Sağ tərəfdəki işıqlı düymə (İkon) */
        #{{ $uid }} .rj-faq-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        #{{ $uid }} .rj-faq-icon {
            position: relative;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s ease;
        }

        /* Xətlər (Artı və Çıx işarəsi üçün) */
        #{{ $uid }} .rj-line-h,
        #{{ $uid }} .rj-line-v {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #{{ $uid }} .rj-line-h { width: 12px; height: 1.5px; }
        #{{ $uid }} .rj-line-v { width: 1.5px; height: 12px; }

        /* Aktiv olanda ikonun rəngi və işığı dəyişir */
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* Şaquli xətti fırladırıq ki, çıx (-) işarəsi olsun */
        #{{ $uid }} .rj-faq-item.is-active .rj-line-v {
            transform: rotate(90deg) scaleX(0);
            opacity: 0;
        }

        #{{ $uid }} .rj-faq-item.is-active .rj-line-h {
            background: #fff;
            box-shadow: 0 0 10px #3b82f6;
        }

        /* Cavab Hissəsi */
        #{{ $uid }} .rj-faq-a {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a {
            grid-template-rows: 1fr;
        }

        #{{ $uid }} .rj-faq-a-inner {
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a-inner {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.1s;
        }

        #{{ $uid }} .rj-faq-a-inner p {
            margin: 0;
            padding: 0 28px 24px 28px;
            font-size: 14.5px;
            line-height: 1.6;
            color: var(--rj-muted);
        }

        @media (max-width: 640px) {
            #{{ $uid }}.rj-faq-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-faq-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-faq-hud { top: 10px; }
            #{{ $uid }} .rj-faq-q { padding: 20px; font-size: 15px; }
            #{{ $uid }} .rj-faq-a-inner p { padding: 0 20px 20px 20px; font-size: 14px; }
            #{{ $uid }} .rj-faq-glow { width: 400px; height: 400px; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var buttons = root.querySelectorAll('.rj-faq-q');

        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var item = this.parentElement;
                var isActive = item.classList.contains('is-active');

                // Bütün digər açıq olanları bağla (akkordeon prinsipi)
                root.querySelectorAll('.rj-faq-item').forEach(function(el) {
                    el.classList.remove('is-active');
                    var b = el.querySelector('.rj-faq-q');
                    if (b) b.setAttribute('aria-expanded', 'false');
                });

                // Əgər kliklənən əvvəl açıq deyildisə, onu aç
                if (!isActive) {
                    item.classList.add('is-active');
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });
    })();
    </script>
</section>
