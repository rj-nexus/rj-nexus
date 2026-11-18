@php
    $uid = $uid ?? ('ct_' . substr(md5(uniqid('', true)), 0, 8));

    $plans = $settings['plans'] ?? [];
    if (!is_array($plans)) $plans = [];
    $plans = array_slice(array_values($plans), 0, 4);
    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_values($features);

    $n = max(1, count($plans));
    $keys = ['p1', 'p2', 'p3', 'p4'];

    // on phones the popular plan is shown first
    $active = 0;
    foreach ($plans as $pi => $pl) { if (!empty($pl['is_popular'])) { $active = $pi; break; } }

    // "$29/mo" -> big "$29" + small "/mo"
    $splitPrice = function ($price) {
        $price = (string) $price;
        if (preg_match('/^(.*?)(\s*\/\s*\S.*)$/u', $price, $m)) return [trim($m[1]), trim($m[2])];
        return [$price, ''];
    };
@endphp

<style>
    /*
     * Glass without backdrop-filter (the panel is large and sits over an animated background):
     * translucent layers, hairline edges, one cursor light moved with transform.
     */
    #{{ $uid }} {
        width: 100%; padding: 96px 24px; background: transparent; color: #fff;
        font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
        -webkit-font-smoothing: antialiased;
    }
    #{{ $uid }} .rj-ct-inner { max-width: min(var(--rj-container, 1200px), 1080px); margin: 0 auto; }

    #{{ $uid }} .rj-ct-header { text-align: center; max-width: 640px; margin: 0 auto 52px; }
    #{{ $uid }} .rj-ct-title { margin: 0 0 14px; font-size: clamp(30px, 4.4vw, 46px); font-weight: 600; line-height: 1.1; letter-spacing: -.04em; color: #fff; }
    #{{ $uid }} .rj-ct-subtitle { margin: 0; font-size: clamp(15px, 1.8vw, 17px); line-height: 1.6; color: rgba(255,255,255,.62); }

    #{{ $uid }} .rj-sr { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0; }

    /* ---------- Panel ---------- */
    #{{ $uid }} .rj-ct-panel {
        position: relative; isolation: isolate; overflow: hidden; border-radius: 28px;   /* everything stays inside */
        background: linear-gradient(180deg, rgba(255,255,255,.085) 0%, rgba(255,255,255,.04) 100%);
        box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.24);
    }
    #{{ $uid }} .rj-ct-panel::before {
        content: ''; position: absolute; left: 0; right: 0; top: 0; height: 200px; z-index: 0; pointer-events: none;
        background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,0));
    }
    #{{ $uid }}.rj-js:not(.is-in) .rj-ct-panel { opacity: 0; transform: translateY(22px); }
    #{{ $uid }} .rj-ct-panel { transition: opacity 1s cubic-bezier(.32,.72,0,1), transform 1s cubic-bezier(.32,.72,0,1); }

    /* cursor light */
    #{{ $uid }} .rj-ct-light {
        position: absolute; left: 0; top: 0; width: 420px; height: 420px; z-index: 0; pointer-events: none; opacity: 0; will-change: transform, opacity;
        transform: translate3d(-100px, -100px, 0); background: radial-gradient(circle closest-side, rgba(255,255,255,.1), rgba(255,255,255,0)); transition: opacity .5s ease;
    }
    #{{ $uid }} .rj-ct-panel:hover .rj-ct-light { opacity: 1; }

    /* ---------- Rows ---------- */
    #{{ $uid }} .rj-ct-row {
        position: relative; z-index: 1; display: grid; align-items: stretch;
        grid-template-columns: minmax(170px, 1.35fr) repeat(var(--n), minmax(0, 1fr));
        transition: background .3s ease;
    }
    #{{ $uid }} .rj-ct-row + .rj-ct-row::before {
        content: ''; position: absolute; top: 0; left: 24px; right: 24px; height: 1px; background: rgba(255,255,255,.08); pointer-events: none;
    }
    #{{ $uid }} .rj-ct-head + .rj-ct-row::before { left: 0; right: 0; background: rgba(255,255,255,.12); }
    @media (hover: hover) {
        #{{ $uid }} .rj-ct-row:not(.rj-ct-head):hover { background: rgba(255,255,255,.045); }
        #{{ $uid }} .rj-ct-row:not(.rj-ct-head):hover .rj-ct-fn { color: #fff; }
    }

    #{{ $uid }} .rj-ct-cell { position: relative; display: flex; align-items: center; justify-content: center; text-align: center; padding: 20px 16px; min-width: 0; }
    #{{ $uid }} .rj-ct-fn { justify-content: flex-start; text-align: left; padding-left: 28px; font-size: 15.5px; font-weight: 500; letter-spacing: -.01em; color: rgba(255,255,255,.82); transition: color .3s ease; }

    /* popular column: one continuous glass pillar */
    #{{ $uid }} .rj-ct-cell.is-pop {
        background: linear-gradient(180deg, rgba(255,255,255,.075), rgba(255,255,255,.045));
        box-shadow: inset .5px 0 0 rgba(255,255,255,.2), inset -.5px 0 0 rgba(255,255,255,.2);
    }

    /* ---------- Plan header ---------- */
    #{{ $uid }} .rj-ct-ph { flex-direction: column; gap: 6px; padding: 46px 18px 30px; }
    #{{ $uid }} .rj-ct-ph.is-pop { box-shadow: inset .5px 0 0 rgba(255,255,255,.2), inset -.5px 0 0 rgba(255,255,255,.2), inset 0 .5px 0 rgba(255,255,255,.2); }
    #{{ $uid }} .rj-ct-ph.is-pop::before {
        content: ''; position: absolute; top: 0; left: 18%; right: 18%; height: 1px; pointer-events: none;
        background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,.9), rgba(255,255,255,0));
    }
    #{{ $uid }} .rj-ct-tag {
        position: absolute; top: 14px; left: 50%; transform: translateX(-50%); display: inline-flex; align-items: center; gap: 6px; padding: 5px 11px; border-radius: 999px; white-space: nowrap;
        font: 700 10px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.92);
        background: rgba(255,255,255,.12); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.3), inset 0 1px 0 rgba(255,255,255,.3);
    }
    #{{ $uid }} .rj-ct-tag::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #fff; }
    #{{ $uid }} .rj-ct-plan-name { font: 700 12px/1.3 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.6); }
    #{{ $uid }} .rj-ct-plan-price { display: flex; align-items: baseline; justify-content: center; gap: 3px; font-size: clamp(28px, 3.2vw, 38px); font-weight: 600; line-height: 1.05; letter-spacing: -.04em; font-variant-numeric: tabular-nums; color: #fff; }
    #{{ $uid }} .rj-ct-plan-price small { font-size: 14px; font-weight: 500; letter-spacing: 0; color: rgba(255,255,255,.5); }

    #{{ $uid }} .rj-ct-btn {
        display: inline-flex; align-items: center; justify-content: center; width: 100%; max-width: 200px; height: 42px; margin-top: 14px; padding: 0 18px; border-radius: 13px;
        font-size: 14px; font-weight: 600; letter-spacing: -.01em; text-decoration: none; color: #fff;
        background: linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.08));
        box-shadow: inset 0 0 0 .5px rgba(255,255,255,.26), inset 0 1px 0 rgba(255,255,255,.34);
        transition: background .3s ease, transform .3s cubic-bezier(.32,.72,0,1), color .3s ease;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-ct-btn:hover { background: linear-gradient(180deg, rgba(255,255,255,.24), rgba(255,255,255,.13)); }
    #{{ $uid }} .rj-ct-btn:active { transform: scale(.97); }
    #{{ $uid }} .rj-ct-btn:focus-visible { outline: 2px solid rgba(255,255,255,.75); outline-offset: 3px; }
    #{{ $uid }} .is-pop .rj-ct-btn { color: #0a0b14; background: #fff; box-shadow: none; }
    #{{ $uid }} .is-pop .rj-ct-btn:hover { background: rgba(255,255,255,.86); }

    /* ---------- Values ---------- */
    #{{ $uid }} .rj-ct-ok {
        display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; color: #fff;
        background: rgba(255,255,255,.1); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.28), inset 0 1px 0 rgba(255,255,255,.3);
    }
    #{{ $uid }} .is-pop .rj-ct-ok { background: rgba(255,255,255,.18); }
    #{{ $uid }} .rj-ct-ok svg { width: 14px; height: 14px; }
    #{{ $uid }} .rj-ct-ok path { stroke-dasharray: 1; stroke-dashoffset: 1; }
    #{{ $uid }}.is-in .rj-ct-ok path { animation: rjCtDraw .55s cubic-bezier(.32,.72,0,1) calc(.35s + var(--r) * .07s + var(--c) * .05s) forwards; }
    #{{ $uid }}.is-in .rj-ct-ok { animation: rjCtPop .5s cubic-bezier(.32,.72,0,1) calc(.3s + var(--r) * .07s + var(--c) * .05s) backwards; }
    @keyframes rjCtDraw { to { stroke-dashoffset: 0; } }
    @keyframes rjCtPop { from { transform: scale(.4); opacity: 0; } }
    #{{ $uid }} .rj-ct-no { display: block; width: 12px; height: 2px; border-radius: 2px; background: rgba(255,255,255,.2); }
    #{{ $uid }} .rj-ct-txt { font-size: 14px; font-weight: 600; letter-spacing: -.01em; color: rgba(255,255,255,.88); }

    /* ---------- Mobile plan switcher ---------- */
    #{{ $uid }} .rj-ct-seg {
        display: none; position: relative; grid-template-columns: repeat(var(--n), minmax(0, 1fr)); max-width: 520px; margin: 0 auto 16px; padding: 4px; border-radius: 16px;
        background: rgba(255,255,255,.06); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.14);
    }
    #{{ $uid }} .rj-ct-thumb {
        position: absolute; left: 4px; top: 4px; bottom: 4px; width: calc((100% - 8px) / var(--n)); border-radius: 12px; pointer-events: none;
        background: linear-gradient(180deg, rgba(255,255,255,.2), rgba(255,255,255,.1)); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.3), inset 0 1px 0 rgba(255,255,255,.38);
        transform: translateX(calc(var(--a) * 100%)); transition: transform .55s cubic-bezier(.32,.72,0,1);
    }
    #{{ $uid }} .rj-ct-seg button {
        position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 6px; height: 40px; padding: 0 6px; border: 0; border-radius: 12px; cursor: pointer; background: none;
        font: inherit; font-size: 14px; font-weight: 600; letter-spacing: -.01em; color: rgba(255,255,255,.58); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: color .3s ease;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-ct-seg button[aria-pressed="true"] { color: #fff; }
    #{{ $uid }} .rj-ct-seg button:focus-visible { outline: 2px solid rgba(255,255,255,.7); outline-offset: -2px; }
    #{{ $uid }} .rj-ct-seg i { width: 5px; height: 5px; border-radius: 50%; background: #fff; opacity: .8; flex: none; }

    @keyframes rjCtSwapA { from { opacity: 0; transform: translateY(8px); } }
    @keyframes rjCtSwapB { from { opacity: 0; transform: translateY(8px); } }

    @media (max-width: 860px) {
        #{{ $uid }} { padding: 56px 16px; }
        #{{ $uid }} .rj-ct-header { margin-bottom: 32px; }
        #{{ $uid }} .rj-ct-seg { display: grid; }
        #{{ $uid }} .rj-ct-panel { border-radius: 24px; touch-action: pan-y; }
        #{{ $uid }} .rj-ct-light { display: none; }

        /* only the selected plan is shown */
        #{{ $uid }}[data-active="0"] [data-col]:not([data-col="0"]),
        #{{ $uid }}[data-active="1"] [data-col]:not([data-col="1"]),
        #{{ $uid }}[data-active="2"] [data-col]:not([data-col="2"]),
        #{{ $uid }}[data-active="3"] [data-col]:not([data-col="3"]) { display: none; }

        #{{ $uid }} .rj-ct-row { grid-template-columns: minmax(0, 1fr) auto; }
        #{{ $uid }} .rj-ct-head { grid-template-columns: minmax(0, 1fr); }
        #{{ $uid }} .rj-ct-corner { display: none; }
        #{{ $uid }} .rj-ct-row + .rj-ct-row::before { left: 18px; right: 18px; }
        #{{ $uid }} .rj-ct-ph { padding: 52px 20px 28px; }
        #{{ $uid }} .rj-ct-btn { max-width: none; height: 46px; border-radius: 14px; }
        #{{ $uid }} .rj-ct-fn { padding: 17px 8px 17px 20px; font-size: 15px; }
        #{{ $uid }} .rj-ct-cell:not(.rj-ct-fn):not(.rj-ct-ph) { justify-content: flex-end; padding: 17px 20px 17px 8px; min-width: 64px; }
        #{{ $uid }} .rj-ct-cell.is-pop:not(.rj-ct-ph) { background: none; box-shadow: none; }
        #{{ $uid }} .rj-ct-ph.is-pop { box-shadow: none; }
        #{{ $uid }} .is-pop .rj-ct-ok { background: rgba(255,255,255,.1); }

        #{{ $uid }}[data-swap="a"] [data-col] { animation: rjCtSwapA .45s cubic-bezier(.32,.72,0,1) both; }
        #{{ $uid }}[data-swap="b"] [data-col] { animation: rjCtSwapB .45s cubic-bezier(.32,.72,0,1) both; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; }
        #{{ $uid }}.rj-js:not(.is-in) .rj-ct-panel { opacity: 1; transform: none; }
        #{{ $uid }} .rj-ct-ok path { stroke-dashoffset: 0; }
    }
</style>

<div id="{{ $uid }}" data-active="{{ $active }}">
    <div class="rj-ct-inner">

        @if(!empty($settings['title']) || !empty($settings['subtitle']))
            <div class="rj-ct-header">
                @if(!empty($settings['title']))<h2 class="rj-ct-title">{{ $settings['title'] }}</h2>@endif
                @if(!empty($settings['subtitle']))<p class="rj-ct-subtitle">{{ $settings['subtitle'] }}</p>@endif
            </div>
        @endif

        @if(count($plans) > 1)
            {{-- phones: pick the plan to look at (swipe also works) --}}
            <div class="rj-ct-seg" data-seg style="--n: {{ $n }}; --a: {{ $active }};" role="group" aria-label="{{ __('Plans') }}">
                <span class="rj-ct-thumb"></span>
                @foreach($plans as $pi => $pl)
                    <button type="button" data-pick="{{ $pi }}" aria-pressed="{{ $pi === $active ? 'true' : 'false' }}">
                        @if(!empty($pl['is_popular']))<i></i>@endif{{ $pl['name'] ?? '' }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="rj-ct-panel" data-panel style="--n: {{ $n }};">
            <span class="rj-ct-light" data-light></span>

            {{-- header row --}}
            <div class="rj-ct-row rj-ct-head" role="row">
                <div class="rj-ct-cell rj-ct-corner"></div>
                @foreach($plans as $pi => $plan)
                    @php [$pBig, $pSmall] = $splitPrice($plan['price'] ?? ''); @endphp
                    <div class="rj-ct-cell rj-ct-ph {{ !empty($plan['is_popular']) ? 'is-pop' : '' }}" data-col="{{ $pi }}">
                        @if(!empty($plan['is_popular']))<span class="rj-ct-tag">{{ __('Popular') }}</span>@endif
                        <div class="rj-ct-plan-name">{{ $plan['name'] ?? '' }}</div>
                        <div class="rj-ct-plan-price">{{ $pBig }}@if($pSmall !== '')<small>{{ $pSmall }}</small>@endif</div>
                        @if(!empty($plan['button_text']))
                            <a href="{{ $plan['button_url'] ?? '#' }}" class="rj-ct-btn">{{ $plan['button_text'] }}</a>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- feature rows --}}
            @foreach($features as $fi => $feature)
                <div class="rj-ct-row" role="row" style="--r: {{ $fi }};">
                    <div class="rj-ct-cell rj-ct-fn" role="rowheader">{{ $feature['name'] ?? '' }}</div>

                    @foreach($plans as $pi => $plan)
                        @php
                            $val = $feature[$keys[$pi]] ?? null;
                            if (is_string($val)) $val = trim($val);
                            $low = is_string($val) ? mb_strtolower($val) : $val;
                            $isNo  = !is_scalar($val) || in_array($low, [null, false, '', 0, '0', 'false', 'no', 'off', 'n', '-', '—'], true);
                            $isYes = !$isNo && in_array($low, [true, 1, '1', 'true', 'yes', 'on', 'y', '✓', '✔'], true);
                        @endphp
                        <div class="rj-ct-cell {{ !empty($plan['is_popular']) ? 'is-pop' : '' }}" role="cell" data-col="{{ $pi }}" style="--c: {{ $pi }};">
                            @if($isNo)
                                <span class="rj-ct-no" aria-hidden="true"></span><span class="rj-sr">{{ __('Not included') }}</span>
                            @elseif($isYes)
                                <span class="rj-ct-ok" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path pathLength="1" d="M5 12.5l4.2 4.2L19 7"/></svg></span><span class="rj-sr">{{ __('Included') }}</span>
                            @else
                                <span class="rj-ct-txt">{{ $val }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    root.classList.add('rj-js');

    var panel = root.querySelector('[data-panel]');
    var light = root.querySelector('[data-light]');
    var seg = root.querySelector('[data-seg]');
    var picks = seg ? Array.prototype.slice.call(seg.querySelectorAll('[data-pick]')) : [];
    var count = picks.length;
    var current = parseInt(root.getAttribute('data-active'), 10) || 0;
    var swapFlip = false;

    /* entrance: the panel appears, then the checks draw themselves row by row */
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e, o) {
            if (e[0].isIntersecting) { root.classList.add('is-in'); o.disconnect(); }
        }, { threshold: 0.12 }).observe(panel);
    } else { root.classList.add('is-in'); }

    /* cursor light, one transform write per frame (desktop only) */
    if (window.matchMedia && window.matchMedia('(hover: hover)').matches && light) {
        var raf = 0, px = 0, py = 0;
        function frame() {
            raf = 0;
            var r = panel.getBoundingClientRect();
            light.style.transform = 'translate3d(' + (px - r.left - 210) + 'px,' + (py - r.top - 210) + 'px,0)';
        }
        panel.addEventListener('pointermove', function (e) { px = e.clientX; py = e.clientY; if (!raf) raf = requestAnimationFrame(frame); });
    }

    /* phones: switch the visible plan */
    function select(i) {
        if (!count) return;
        i = Math.max(0, Math.min(count - 1, i));
        if (i === current) return;
        current = i;
        root.setAttribute('data-active', String(i));
        root.setAttribute('data-swap', (swapFlip = !swapFlip) ? 'a' : 'b');   // alternating names replay the fade
        seg.style.setProperty('--a', String(i));
        picks.forEach(function (b, k) { b.setAttribute('aria-pressed', k === i ? 'true' : 'false'); });
    }
    picks.forEach(function (b) {
        b.addEventListener('click', function () { select(parseInt(b.getAttribute('data-pick'), 10)); });
    });

    /* swipe left / right on the table to change plan */
    var sx = 0, sy = 0, tracking = false;
    panel.addEventListener('touchstart', function (e) {
        if (e.touches.length !== 1) return;
        tracking = true; sx = e.touches[0].clientX; sy = e.touches[0].clientY;
    }, { passive: true });
    panel.addEventListener('touchend', function (e) {
        if (!tracking) return; tracking = false;
        var t = e.changedTouches[0], dx = t.clientX - sx, dy = t.clientY - sy;
        if (Math.abs(dx) > 56 && Math.abs(dx) > Math.abs(dy) * 1.5) select(current + (dx < 0 ? 1 : -1));
    }, { passive: true });
})();
</script>