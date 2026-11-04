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
                    <div class="rj-faq-item" style="--i: {{ $index }};">
                        <button class="rj-faq-q" aria-expanded="false">
                            <span class="rj-faq-q-text">{{ str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['question'] ?? '') }}</span>
                            <span class="rj-faq-icon">
                                <span class="rj-faq-icon-line"></span>
                            </span>
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
            padding: 140px 24px 120px;
            overflow: hidden;
            display: flex;
            justify-content: center;
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

        /* Inner */
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

        #{{ $uid }} .rj-faq-title { font-size: clamp(32px, 5vw, 48px); font-weight: 600; line-height: 1.15; letter-spacing: -0.03em; color: #fff; margin: 0; }

        /* FAQ List */
        #{{ $uid }} .rj-faq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* FAQ Item */
        #{{ $uid }} .rj-faq-item {
            position: relative;
            background: rgba(15, 15, 22, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        #{{ $uid }} .rj-faq-item:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(20, 20, 28, 0.8);
        }

        #{{ $uid }} .rj-faq-item.is-active {
            border-color: rgba(59, 130, 246, 0.3);
            background: linear-gradient(180deg, rgba(20, 25, 35, 0.9) 0%, rgba(10, 10, 15, 0.95) 100%);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(59, 130, 246, 0.05) inset;
        }

        /* Button (Question) */
        #{{ $uid }} .rj-faq-q {
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
            color: #fff;
            transition: color 0.3s ease;
        }

        #{{ $uid }} .rj-faq-q-text {
            flex: 1;
            padding-right: 20px;
            line-height: 1.4;
        }

        /* Parlaq İşıq (Icon) */
        #{{ $uid }} .rj-faq-icon {
            position: relative;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        #{{ $uid }} .rj-faq-icon-line {
            display: block;
            width: 12px;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 10px transparent;
        }

        /* Aktiv olanda işıq yanır */
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }

        #{{ $uid }} .rj-faq-item.is-active .rj-faq-icon-line {
            background: #fff;
            box-shadow: 0 0 12px #3b82f6, 0 0 24px #3b82f6;
        }

        /* Cavab Hissəsi */
        #{{ $uid }} .rj-faq-a {
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
            font-size: 15px;
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

                // Bütün digər açıq olanları bağla
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
