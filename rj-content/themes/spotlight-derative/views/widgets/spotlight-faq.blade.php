@php
    $uid = 'faq_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $showBottomLine = filter_var($settings['show_bottom_line'] ?? false, FILTER_VALIDATE_BOOLEAN);
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

    {{-- Yalnız neytral, sabit yumşaq işıq: şüşənin arxasında görünsün deyə. Kənarları sönür, kəsilmir. --}}
    <div class="rj-faq-bg" aria-hidden="true"></div>

    @if($showHud)
        <span class="rj-faq-line rj-line-top"><i></i><i></i></span>
        @if($showBottomLine)<span class="rj-faq-line rj-line-bottom"><i></i><i></i></span>@endif
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
            <div class="rj-faq-glass">
                @foreach($faqs as $index => $faq)
                    @php $isOpen = $openFirst && $index === $firstKey; @endphp
                    <div class="rj-faq-item {{ $isOpen ? 'is-active' : '' }}">
                        <button type="button" class="rj-faq-q" id="{{ $uid }}_q{{ $loop->index }}"
                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="{{ $uid }}_a{{ $loop->index }}">
                            <span class="rj-faq-q-text">{{ str_replace(['Qore', 'qore'], 'RJ Nexus', $faq['question'] ?? '') }}</span>
                            <span class="rj-faq-chev">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                            </span>
                        </button>
                        <div class="rj-faq-a" id="{{ $uid }}_a{{ $loop->index }}" role="region" aria-labelledby="{{ $uid }}_q{{ $loop->index }}">
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
            display: flex;
            justify-content: center;
            overflow-x: clip;
            overflow-y: visible;
        }

        /* ===== Neytral arxa işıq (rəngsiz, hərəkətsiz, kənarları sönür) ===== */
        #{{ $uid }} .rj-faq-bg {
            position: absolute; left: 0; right: 0; top: -200px; bottom: -200px;
            z-index: 0; pointer-events: none;
            background: radial-gradient(ellipse 52% 38% at 50% 52%, rgba(255,255,255,.075), rgba(255,255,255,0) 72%);
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 28%, #000 72%, transparent 100%);
                    mask-image: linear-gradient(180deg, transparent 0%, #000 28%, #000 72%, transparent 100%);
        }

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

        /* ===== İç ===== */
        #{{ $uid }} .rj-faq-inner {
            position: relative; z-index: 1;
            max-width: 760px; width: 100%; margin: 0 auto;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        #{{ $uid }} .rj-faq-header { text-align: center; margin-bottom: 52px; }

        #{{ $uid }} .rj-faq-badge {
            display: inline-flex; align-items: center; gap: 12px; margin-bottom: 24px;
            padding: 8px 16px; border-radius: 999px;
            background: rgba(255,255,255,.06);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.14);
            -webkit-backdrop-filter: blur(20px) saturate(180%); backdrop-filter: blur(20px) saturate(180%);
        }
        #{{ $uid }} .rj-faq-bars { display: inline-flex; gap: 3px; height: 10px; align-items: center; }
        #{{ $uid }} .rj-faq-bars i { width: 2px; height: 100%; background: rgba(255,255,255,.55); }
        #{{ $uid }} .rj-faq-bars i:nth-child(2) { height: 60%; }
        #{{ $uid }} .rj-faq-bars i:nth-child(3) { height: 30%; }
        #{{ $uid }} .rj-faq-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-faq-badge-t {
            font: 600 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.78);
        }

        #{{ $uid }} .rj-faq-title {
            margin: 0; color: #fff;
            font-size: clamp(34px, 5vw, 56px); font-weight: 600; line-height: 1.08; letter-spacing: -.04em;
        }

        /* ===== Şüşə panel (iOS qruplaşdırılmış siyahı kimi) ===== */
        #{{ $uid }} .rj-faq-glass {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,.09) 0%, rgba(255,255,255,.05) 100%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
                    backdrop-filter: blur(30px) saturate(180%);
            box-shadow:
                inset 0 0 0 .5px rgba(255,255,255,.16),
                inset 0 1px 0 rgba(255,255,255,.24);
        }
        /* yuxarıdan düşən yumşaq parıltı (şüşənin üzündəki əks) */
        #{{ $uid }} .rj-faq-glass::before {
            content: ""; position: absolute; left: 0; right: 0; top: 0; height: 160px;
            background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,0));
            pointer-events: none; z-index: 0;
        }

        /* Giriş: bir dəfə, sakit */
        #{{ $uid }}.rj-ready .rj-faq-glass {
            opacity: 0; transform: translateY(18px);
            transition: opacity .9s cubic-bezier(.32,.72,0,1), transform .9s cubic-bezier(.32,.72,0,1);
        }
        #{{ $uid }}.rj-ready.rj-in .rj-faq-glass { opacity: 1; transform: none; }

        /* ===== Sətir ===== */
        #{{ $uid }} .rj-faq-item { position: relative; z-index: 1; transition: background .4s ease; }
        #{{ $uid }} .rj-faq-item + .rj-faq-item::before {
            content: ""; position: absolute; top: 0; left: 28px; right: 28px; height: 1px;
            background: rgba(255,255,255,.09);
        }
        #{{ $uid }} .rj-faq-item.is-active { background: rgba(255,255,255,.035); }

        #{{ $uid }} .rj-faq-q {
            width: 100%;
            display: flex; align-items: center; justify-content: space-between;
            padding: 24px 28px;
            background: none; border: 0; cursor: pointer; text-align: left;
            font: inherit; font-size: 17px; font-weight: 500; letter-spacing: -.012em;
            color: rgba(255,255,255,.92);
            transition: background .25s ease, color .25s ease;
            -webkit-tap-highlight-color: transparent;
        }
        #{{ $uid }} .rj-faq-q:hover { background: rgba(255,255,255,.035); }
        #{{ $uid }} .rj-faq-q:active { background: rgba(255,255,255,.07); }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-q { color: #fff; }
        #{{ $uid }} .rj-faq-q:focus-visible { outline: 2px solid rgba(255,255,255,.6); outline-offset: -4px; border-radius: 20px; }
        #{{ $uid }} .rj-faq-q-text { flex: 1; padding-right: 24px; line-height: 1.4; }

        #{{ $uid }} .rj-faq-chev {
            width: 22px; height: 22px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.45);
            transition: transform .55s cubic-bezier(.32,.72,0,1), color .3s ease;
        }
        #{{ $uid }} .rj-faq-chev svg { width: 20px; height: 20px; }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-chev { transform: rotate(180deg); color: rgba(255,255,255,.9); }

        /* ===== Cavab ===== */
        #{{ $uid }} .rj-faq-a {
            display: grid; grid-template-rows: 0fr;
            transition: grid-template-rows .55s cubic-bezier(.32,.72,0,1);
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a { grid-template-rows: 1fr; }
        #{{ $uid }} .rj-faq-a-inner {
            overflow: hidden; min-height: 0; opacity: 0;
            transition: opacity .3s ease;
        }
        #{{ $uid }} .rj-faq-item.is-active .rj-faq-a-inner { opacity: 1; transition: opacity .45s ease .1s; }
        #{{ $uid }} .rj-faq-a-inner p {
            margin: 0; padding: 0 28px 26px; max-width: 620px;
            font-size: 15.5px; line-height: 1.65; letter-spacing: -.005em;
            color: rgba(255,255,255,.62);
        }

        /* ===== Mobil ===== */
        @media (max-width: 640px) {
            #{{ $uid }}.rj-faq-section { padding: 100px 16px 80px; }
            #{{ $uid }} .rj-faq-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-faq-hud { top: 10px; }
            #{{ $uid }} .rj-faq-glass { border-radius: 24px; }
            #{{ $uid }} .rj-faq-item + .rj-faq-item::before { left: 20px; right: 20px; }
            #{{ $uid }} .rj-faq-q { padding: 20px; font-size: 16px; }
            #{{ $uid }} .rj-faq-a-inner p { padding: 0 20px 22px; font-size: 15px; }
        }

        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *, #{{ $uid }} *::before { transition: none !important; }
            #{{ $uid }}.rj-ready .rj-faq-glass { opacity: 1; transform: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var items = root.querySelectorAll('.rj-faq-item');
        var panel = root.querySelector('.rj-faq-glass');

        /* Bir dəfəlik sakit giriş */
        root.classList.add('rj-ready');
        if ('IntersectionObserver' in window && panel) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) { root.classList.add('rj-in'); io.disconnect(); }
            }, { threshold: 0.1 });
            io.observe(panel);
        } else {
            root.classList.add('rj-in');
        }

        /* Accordion: eyni anda bir sətir açıq */
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
