@php
    $uid = 'tabs_' . substr(md5(uniqid('', true)), 0, 8);

    $tabs = $settings['tabs'] ?? [];
    if (!is_array($tabs)) $tabs = [];
    $tabs = array_slice(array_values($tabs), 0, 9);

    if (empty($tabs)) {
        $tabs = [
            ['tab_title' => 'Tab 1', 'content_title' => 'Title 1', 'content_text' => 'Text 1'],
            ['tab_title' => 'Tab 2', 'content_title' => 'Title 2', 'content_text' => 'Text 2'],
            ['tab_title' => 'Tab 3', 'content_title' => 'Title 3', 'content_text' => 'Text 3'],
        ];
    }

    $hues    = [262, 195, 330, 155, 32, 220, 290, 95, 355];
    $hueList = array_slice($hues, 0, count($tabs));
    $total   = str_pad((string) count($tabs), 2, '0', STR_PAD_LEFT);

    $hudLeft  = $settings['hud_left'] ?? '[ 03 / 09 ]';
    $hudRight = $settings['hud_right_format'] ?? '[ {current} / {total} ]';
@endphp

<section class="rj-tabs-section" id="{{ $uid }}" data-side="left" data-hud-right="{{ $hudRight }}">
    <div class="rj-pl-wrap" aria-hidden="true">
        <div class="rj-pl"><div class="rj-pl-sphere"></div></div>
    </div>

    <div class="rj-tabs-inner">
        <div class="rj-tabs-nav" role="tablist">
            <span class="rj-tabs-ind"></span>
            @foreach($tabs as $index => $tab)
                <button class="rj-tabs-btn {{ $index === 0 ? 'is-active' : '' }}" role="tab" type="button"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        tabindex="{{ $index === 0 ? '0' : '-1' }}"
                        aria-controls="{{ $uid }}_panel_{{ $index }}">
                    {{ $tab['tab_title'] ?? '' }}
                </button>
            @endforeach
        </div>

        <div class="rj-tabs-content">
            @foreach($tabs as $index => $tab)
                <div class="rj-tabs-panel {{ $index === 0 ? 'is-active' : '' }}" id="{{ $uid }}_panel_{{ $index }}" role="tabpanel">
                    <span class="rj-tabs-eye">[ {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} ]</span>
                    <h2 class="rj-tabs-title">{{ $tab['content_title'] ?? '' }}</h2>
                    <p class="rj-tabs-desc">{{ $tab['content_text'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="rj-tabs-hud rj-hl"><b></b>{{ $hudLeft }}</div>
    <div class="rj-tabs-hud rj-hr"><span class="rj-tabs-count">[ 01 / {{ $total }} ]</span><b></b></div>
    <span class="rj-tabs-line"><i></i><i></i></span>

    <style>
        @property --rj-h { syntax: '<number>'; inherits: true; initial-value: 262; }

        #{{ $uid }}.rj-tabs-section {
            --rj-h: {{ $hueList[0] }};
            --pl: clamp(200px, 27vw, 420px);
            position: relative; width: 100%; overflow: hidden; background: transparent; color: #fff;
            padding: 110px 24px 130px; display: flex; justify-content: center;
            transition: --rj-h 1s ease;
        }

        #{{ $uid }} .rj-pl-wrap {
            position: absolute; top: 50%; left: 13%; width: var(--pl); aspect-ratio: 1; translate: -50% -50%;
            z-index: 0; pointer-events: none; transition: left 1.1s cubic-bezier(.65, 0, .25, 1);
        }
        #{{ $uid }}[data-side="right"] .rj-pl-wrap { left: 87%; }
        #{{ $uid }} .rj-pl-wrap.is-switching { animation: rjPlIn .9s cubic-bezier(.2, .8, .2, 1) both; }
        #{{ $uid }} .rj-pl { position: absolute; inset: 0; animation: rjPlFloat 10s ease-in-out infinite; }

        #{{ $uid }} .rj-pl::before, #{{ $uid }} .rj-pl::after {
            content: ''; position: absolute; inset: -45%; border-radius: 50%;
            border: calc(var(--pl) * .03) solid hsl(var(--rj-h) 70% 75% / .5);
            box-shadow: 0 0 0 calc(var(--pl) * .05) hsl(var(--rj-h) 70% 75% / .14), 0 0 40px hsl(var(--rj-h) 90% 60% / .25);
            transform: rotateZ(-18deg) rotateX(74deg);
        }
        #{{ $uid }} .rj-pl::before { z-index: 0; }
        #{{ $uid }} .rj-pl::after { z-index: 2; clip-path: inset(50% 0 0 0); }

        #{{ $uid }} .rj-pl-sphere {
            position: absolute; inset: 0; z-index: 1; border-radius: 50%; overflow: hidden;
            background: hsl(var(--rj-h) 55% 16%);
            box-shadow: 0 0 90px hsl(var(--rj-h) 90% 55% / .35), inset -28px -18px 60px rgba(0,0,0,.85);
        }
        #{{ $uid }} .rj-pl-sphere::before {
            content: ''; position: absolute; top: 0; bottom: 0; left: 0; width: 200%; background-size: 50% 100%;
            background:
                radial-gradient(ellipse 16% 5% at 28% 34%, rgba(255,255,255,.35), transparent),
                radial-gradient(ellipse 12% 4% at 70% 58%, rgba(255,255,255,.28), transparent),
                radial-gradient(ellipse 20% 6% at 45% 78%, rgba(0,0,0,.35), transparent),
                repeating-linear-gradient(180deg,
                    hsl(var(--rj-h) 75% 58% / .75) 0 6%,
                    hsl(calc(var(--rj-h) + 28) 70% 40% / .75) 6% 14%,
                    hsl(calc(var(--rj-h) - 18) 65% 66% / .55) 14% 17%,
                    hsl(var(--rj-h) 60% 30% / .8) 17% 25%);
            background-size: 50% 100%;
            animation: rjPlSpin 48s linear infinite;
        }
        #{{ $uid }} .rj-pl-sphere::after {
            content: ''; position: absolute; inset: 0; border-radius: 50%;
            background:
                radial-gradient(circle at 30% 26%, rgba(255,255,255,.35), transparent 38%),
                radial-gradient(circle at 76% 80%, rgba(0,0,0,.78), transparent 64%);
            box-shadow: inset 0 0 calc(var(--pl) * .12) rgba(0,0,0,.6);
        }

        @keyframes rjPlSpin { to { transform: translateX(-50%); } }
        @keyframes rjPlFloat { 0%, 100% { transform: translateY(-10px) rotate(-3deg); } 50% { transform: translateY(10px) rotate(3deg); } }
        @keyframes rjPlIn { from { scale: .7; opacity: .2; } to { scale: 1; opacity: 1; } }

        #{{ $uid }} .rj-tabs-inner { position: relative; z-index: 1; max-width: 1000px; width: 100%; display: flex; flex-direction: column; align-items: center; }

        #{{ $uid }} .rj-tabs-nav {
            position: relative; display: flex; flex-wrap: wrap; justify-content: center; gap: 6px; margin-bottom: 60px; padding: 6px;
            background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.1); border-radius: 12px;
            -webkit-backdrop-filter: blur(14px) saturate(150%); backdrop-filter: blur(14px) saturate(150%);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.12);
        }
        #{{ $uid }} .rj-tabs-ind {
            position: absolute; left: 0; top: 0; width: 0; height: 0; opacity: 0; border-radius: 8px; pointer-events: none;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
            transition: transform .5s cubic-bezier(.2,.8,.2,1), width .5s cubic-bezier(.2,.8,.2,1), height .5s cubic-bezier(.2,.8,.2,1), opacity .3s;
        }
        #{{ $uid }} .rj-tabs-ind::after {
            content: ''; position: absolute; left: 20%; right: 20%; bottom: -1px; height: 2px; border-radius: 2px;
            background: hsl(var(--rj-h) 90% 65%); box-shadow: 0 0 14px hsl(var(--rj-h) 90% 60%);
        }
        #{{ $uid }} .rj-tabs-btn {
            position: relative; z-index: 1; padding: 12px 24px; font-family: inherit; font-size: 14px; font-weight: 500; line-height: 1.2;
            color: rgba(255,255,255,.6); background: none; border: 0; border-radius: 8px; cursor: pointer; transition: color .3s;
        }
        #{{ $uid }} .rj-tabs-btn:hover { color: #fff; }
        #{{ $uid }} .rj-tabs-btn.is-active { color: #fff; }
        #{{ $uid }} .rj-tabs-btn:focus-visible { outline: 2px solid hsl(var(--rj-h) 90% 65%); outline-offset: 2px; }

        #{{ $uid }} .rj-tabs-content { width: 100%; display: grid; text-align: center; }
        #{{ $uid }} .rj-tabs-panel {
            grid-area: 1 / 1; display: flex; flex-direction: column; align-items: center; width: 100%;
            visibility: hidden; transition: visibility 0s linear .5s;
        }
        #{{ $uid }} .rj-tabs-panel.is-active { visibility: visible; transition-delay: 0s; z-index: 2; }
        #{{ $uid }} .rj-tabs-panel > * {
            opacity: 0; transform: translateY(18px); filter: blur(8px);
            transition: opacity .4s ease, transform .4s ease, filter .4s ease;
        }
        #{{ $uid }} .rj-tabs-panel.is-active > * {
            opacity: 1; transform: none; filter: none;
            transition: opacity .8s cubic-bezier(.2,.8,.2,1), transform .8s cubic-bezier(.2,.8,.2,1), filter .8s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .is-active > :nth-child(2) { transition-delay: .1s; }
        #{{ $uid }} .is-active > :nth-child(3) { transition-delay: .2s; }

        #{{ $uid }} .rj-tabs-eye {
            margin-bottom: 18px; font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .14em; color: hsl(var(--rj-h) 90% 78%);
        }
        #{{ $uid }} .rj-tabs-title {
            margin: 0 0 24px; max-width: 900px; font-size: clamp(32px, 5vw, 56px); font-weight: 500; line-height: 1.12; letter-spacing: -.035em;
            background: linear-gradient(180deg, #fff 0%, hsl(var(--rj-h) 70% 84%) 100%);
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 18px hsl(var(--rj-h) 90% 60% / .3));
        }
        #{{ $uid }} .rj-tabs-desc { margin: 0; max-width: 680px; font-size: clamp(16px, 1.8vw, 20px); line-height: 1.6; color: rgba(255,255,255,.68); }

        #{{ $uid }} .rj-tabs-line { position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background: rgba(255,255,255,.14); }
        #{{ $uid }} .rj-tabs-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-tabs-line i::before, #{{ $uid }} .rj-tabs-line i::after { content: ''; position: absolute; background: #fff; }
        #{{ $uid }} .rj-tabs-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-tabs-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-tabs-line i:first-child { left: 18px; }
        #{{ $uid }} .rj-tabs-line i:last-child { right: 18px; }
        #{{ $uid }} .rj-tabs-hud {
            position: absolute; bottom: 22px; z-index: 2; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.75);
        }
        #{{ $uid }} .rj-hl { left: 22px; } #{{ $uid }} .rj-hr { right: 22px; }
        #{{ $uid }} .rj-tabs-hud b { display: block; width: 3px; height: 26px; background: #fff; }

        @media (max-width: 900px) {
            #{{ $uid }}.rj-tabs-section { --pl: 210px; }
            #{{ $uid }} .rj-pl { opacity: .5; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-tabs-section { padding: 70px 20px 110px; }
            #{{ $uid }} .rj-tabs-nav { flex-direction: column; width: 100%; }
            #{{ $uid }} .rj-tabs-btn { width: 100%; text-align: center; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var nav = root.querySelector('.rj-tabs-nav');
        var btns = Array.prototype.slice.call(root.querySelectorAll('.rj-tabs-btn'));
        var panels = root.querySelectorAll('.rj-tabs-panel');
        var ind = root.querySelector('.rj-tabs-ind');
        var count = root.querySelector('.rj-tabs-count');
        var planet = root.querySelector('.rj-pl-wrap');
        var hues = @js($hueList);
        var hudRightFormat = root.getAttribute('data-hud-right') || '[ {current} / {total} ]';
        var cur = 0;

        function pad(n) { return (n < 10 ? '0' : '') + n; }

        function moveInd() {
            var b = btns[cur];
            ind.style.width = b.offsetWidth + 'px';
            ind.style.height = b.offsetHeight + 'px';
            ind.style.transform = 'translate(' + b.offsetLeft + 'px,' + b.offsetTop + 'px)';
            ind.style.opacity = 1;
        }

        function select(i, focus) {
            cur = i;
            btns.forEach(function (b, k) {
                var on = k === i;
                b.classList.toggle('is-active', on);
                b.setAttribute('aria-selected', on ? 'true' : 'false');
                b.tabIndex = on ? 0 : -1;
                panels[k].classList.toggle('is-active', on);
            });
            root.style.setProperty('--rj-h', hues[i]);
            root.setAttribute('data-side', i % 2 ? 'right' : 'left');

            // HUD mətnini formatla əvəz edirik
            var txt = hudRightFormat.replace('{current}', pad(i + 1)).replace('{total}', pad(btns.length));
            count.textContent = txt;

            planet.classList.remove('is-switching'); void planet.offsetWidth; planet.classList.add('is-switching');
            moveInd();
            if (focus) btns[i].focus();
        }

        btns.forEach(function (b, i) {
            b.addEventListener('click', function () { select(i); });
            b.addEventListener('keydown', function (e) {
                var n = btns.length;
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') { e.preventDefault(); select((i + 1) % n, true); }
                else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { e.preventDefault(); select((i - 1 + n) % n, true); }
            });
        });

        if ('ResizeObserver' in window) new ResizeObserver(moveInd).observe(nav);
        window.addEventListener('load', moveInd);
        moveInd();
    })();
    </script>
</section>
