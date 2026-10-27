@php
    $title      = $settings['title'] ?? '';
    $subtitle   = $settings['subtitle'] ?? '';
    $layout     = $settings['layout'] ?? 'grid';
    $logoH      = max(20, min(160, (int) ($settings['logo_height'] ?? 60)));
    $grayscale  = !empty($settings['grayscale'] ?? true);
    $hoverRaw   = $settings['hover_effect'] ?? 'color';
    $hover      = in_array($hoverRaw, ['color', 'scale', 'lift', 'glow'], true) ? $hoverRaw : 'color';
    $cardRaw    = $settings['card_style'] ?? 'plain';
    $card       = in_array($cardRaw, ['plain', 'boxed', 'ring'], true) ? $cardRaw : 'plain';
    $alignRaw   = $settings['align'] ?? 'center';
    $align      = in_array($alignRaw, ['left', 'center', 'right'], true) ? $alignRaw : 'center';
    $speed      = max(8, min(120, (int) ($settings['marquee_speed'] ?? 30)));
    $paddingY   = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));

    $hexOf = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v)) {
            $v = $d;
        }
        $h = ltrim($v, '#');
        if (strlen($h) === 3) {
            $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
        }
        return '#' . strtolower($h);
    };
    $bgColor = $hexOf($settings['bg_color'] ?? '', '#ffffff');
    $accent  = $hexOf($settings['accent'] ?? '', '#8b5cf6');
    $ah = ltrim($accent, '#');
    $accentRgb = hexdec(substr($ah, 0, 2)) . ',' . hexdec(substr($ah, 2, 2)) . ',' . hexdec(substr($ah, 4, 2));

    $logos = [];
    if (!empty($settings['logos']) && is_array($settings['logos'])) {
        foreach ($settings['logos'] as $row) {
            if (!is_array($row)) {
                continue;
            }
            $img = $row['image'] ?? '';
            if (is_array($img)) {
                $img = $img['url'] ?? ($img['src'] ?? (reset($img) ?: ''));
            }
            $img = is_string($img) ? trim($img) : '';
            if ($img === '') {
                continue;
            }
            $url = trim((string) ($row['url'] ?? ''));
            if ($url !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $url)) {
                $url = '';
            }
            $logos[] = [
                'image' => $img,
                'name'  => trim((string) ($row['name'] ?? '')),
                'url'   => $url,
            ];
        }
    }

    $count = count($logos);
    $lanes = [];
    $rep = 1;
    if ($count > 0) {
        $rep = max(1, (int) ceil(14 / $count));
        $lanes[] = $logos;
        if ($layout !== 'marquee') {
            $shift = $count > 1 ? intdiv($count, 2) : 0;
            $second = array_merge(array_slice($logos, $shift), array_slice($logos, 0, $shift));
            $lanes[] = array_reverse($second);
        }
    }
    $duration = $speed * $rep;

    $itemHtml = function (array $logo, bool $clone) {
        $has = $logo['name'] !== '';
        $cls = 'rj-lm-item' . ($has ? ' has-name' : '');
        $inner = '<span class="rj-lm-logo"><img src="' . e($logo['image']) . '" alt="' . ($clone ? '' : e($logo['name'])) . '" loading="lazy" draggable="false"></span>';
        if ($has) {
            $inner .= '<span class="rj-lm-name">' . e($logo['name']) . '</span>';
        }
        $aria = $clone ? ' aria-hidden="true"' : '';
        if ($logo['url'] !== '') {
            $extra = $clone ? ' tabindex="-1"' : '';
            return '<a class="' . $cls . '" href="' . e($logo['url']) . '" target="_blank" rel="noopener noreferrer"' . $aria . $extra . '>' . $inner . '</a>';
        }
        return '<div class="' . $cls . '"' . $aria . '>' . $inner . '</div>';
    };
@endphp

@once
<style>
    @keyframes rjLmFlow {
        from { transform: translate3d(0, 0, 0); }
        to   { transform: translate3d(-50%, 0, 0); }
    }
    @keyframes rjLmFade {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjLmDrift {
        0%   { transform: translate(0, 0) scale(1); }
        100% { transform: translate(40px, -24px) scale(1.15); }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --ar: {{ $accentRgb }};
        --lh: {{ $logoH }}px;
        box-sizing: border-box;
        position: relative;
        display: block;
        width: 100%;
        overflow: hidden;
        padding: {{ $paddingY }}px 0;
        background: {{ $bgColor }};
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-lm-blob {
        position: absolute;
        z-index: 0;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(var(--ar), .18), rgba(var(--ar), 0) 70%);
        animation: rjLmDrift 9s ease-in-out infinite alternate;
        pointer-events: none;
    }
    #{{ $uid }} .rj-lm-blob--1 { left: -80px; top: 10%; }
    #{{ $uid }} .rj-lm-blob--2 { right: -80px; bottom: 5%; animation-delay: -4s; }

    #{{ $uid }} .rj-lm-head {
        position: relative;
        z-index: 1;
        max-width: 1240px;
        margin: 0 auto 40px;
        padding: 0 16px;
        text-align: {{ $align }};
    }
    #{{ $uid }} .rj-lm-sub {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--a);
    }
    #{{ $uid }} .rj-lm-sub::before,
    #{{ $uid }} .rj-lm-sub::after {
        content: "";
        display: block;
        width: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--a);
        transition: width .9s cubic-bezier(.2,.8,.2,1) .2s;
    }
    #{{ $uid }}.is-in .rj-lm-sub::before,
    #{{ $uid }}.is-in .rj-lm-sub::after { width: 28px; }
    #{{ $uid }} .rj-lm-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.025em;
        color: #0f172a;
    }
    @media (min-width: 768px) { #{{ $uid }} .rj-lm-title { font-size: 38px; } }
    #{{ $uid }}:not(.is-in) .rj-lm-head,
    #{{ $uid }}:not(.is-in) .rj-lm-lane { opacity: 0; }
    #{{ $uid }}.is-in .rj-lm-head { animation: rjLmFade .8s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }}.is-in .rj-lm-lane { animation: rjLmFade .9s cubic-bezier(.2,.8,.2,1) .15s backwards; }

    #{{ $uid }} .rj-lm-lanes {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    #{{ $uid }} .rj-lm-lane {
        position: relative;
        overflow: hidden;
        padding: 14px 0;
        -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 9%, #000 91%, transparent 100%);
        mask-image: linear-gradient(90deg, transparent 0%, #000 9%, #000 91%, transparent 100%);
    }
    #{{ $uid }} .rj-lm-lane + .rj-lm-lane { animation-delay: .3s; }

    #{{ $uid }} .rj-lm-track {
        display: flex;
        width: max-content;
        will-change: transform;
        animation: rjLmFlow {{ $duration }}s linear infinite;
        animation-play-state: paused;
    }
    #{{ $uid }}.is-run .rj-lm-track { animation-play-state: running; }
    #{{ $uid }} .rj-lm-lane[data-dir="-1"] .rj-lm-track {
        animation-direction: reverse;
        animation-duration: {{ round($duration * 1.25) }}s;
    }
    #{{ $uid }} .rj-lm-group {
        display: flex;
        flex: 0 0 auto;
        gap: 28px;
        padding-right: 28px;
    }

    #{{ $uid }} .rj-lm-item {
        position: relative;
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: calc(var(--lh) * 1.9);
        padding: 22px 34px;
        border-radius: 18px;
        text-decoration: none;
        color: inherit;
        border: 1px solid transparent;
        outline: none;
        transition: transform .5s cubic-bezier(.34,1.4,.64,1), box-shadow .4s ease, border-color .4s ease, background-color .4s ease;
    }
    #{{ $uid }}[data-card="boxed"] .rj-lm-item {
        background: #fff;
        border-color: #e5e7eb;
        box-shadow: 0 14px 28px -24px rgba(15,23,42,.5);
    }
    #{{ $uid }}[data-card="ring"] .rj-lm-item {
        background: #fff;
        border: 2px solid rgba(var(--ar), .25);
    }

    #{{ $uid }} .rj-lm-logo {
        display: block;
        transition: transform .5s cubic-bezier(.34,1.4,.64,1);
    }
    #{{ $uid }} .rj-lm-item img {
        display: block;
        height: var(--lh);
        width: auto;
        max-width: calc(var(--lh) * 3.4);
        object-fit: contain;
        user-select: none;
        -webkit-user-drag: none;
        transition: filter .5s ease, opacity .5s ease, transform .5s cubic-bezier(.34,1.4,.64,1);
        @if($grayscale)
        filter: grayscale(1);
        opacity: .55;
        @else
        opacity: .92;
        @endif
    }
    #{{ $uid }} .rj-lm-name {
        position: absolute;
        left: 8px;
        right: 8px;
        bottom: 8px;
        overflow: hidden;
        text-align: center;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--a);
        opacity: 0;
        transform: translateY(8px);
        transition: opacity .4s ease, transform .5s cubic-bezier(.34,1.4,.64,1);
        pointer-events: none;
    }

    #{{ $uid }} .rj-lm-item:hover,
    #{{ $uid }} .rj-lm-item:focus-visible { z-index: 2; }
    #{{ $uid }} .rj-lm-item:hover img,
    #{{ $uid }} .rj-lm-item:focus-visible img {
        filter: grayscale(0);
        opacity: 1;
    }
    #{{ $uid }} .rj-lm-item.has-name:hover .rj-lm-logo,
    #{{ $uid }} .rj-lm-item.has-name:focus-visible .rj-lm-logo { transform: translateY(-9px); }
    #{{ $uid }} .rj-lm-item:hover .rj-lm-name,
    #{{ $uid }} .rj-lm-item:focus-visible .rj-lm-name { opacity: 1; transform: none; }
    #{{ $uid }} .rj-lm-item:focus-visible { outline: 3px solid var(--a); outline-offset: 2px; }

    #{{ $uid }}[data-hover="scale"] .rj-lm-item:hover { transform: scale(1.1); }
    #{{ $uid }}[data-hover="lift"] .rj-lm-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 36px -20px rgba(15,23,42,.35);
    }
    #{{ $uid }}[data-hover="glow"] .rj-lm-item:hover {
        border-color: rgba(var(--ar), .55);
        background-color: rgba(var(--ar), .06);
        box-shadow: 0 0 0 4px rgba(var(--ar), .14), 0 26px 40px -22px rgba(var(--ar), .7);
    }

    #{{ $uid }} .rj-lm-empty {
        position: relative;
        z-index: 1;
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        font-size: 14px;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-lm-item { padding: 16px 22px; border-radius: 14px; }
        #{{ $uid }} .rj-lm-group { gap: 16px; padding-right: 16px; }
        #{{ $uid }} .rj-lm-item img { height: calc(var(--lh) * .78); max-width: calc(var(--lh) * 2.6); }
        #{{ $uid }} .rj-lm-name { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-lm-head, #{{ $uid }} .rj-lm-lane { opacity: 1 !important; }
        #{{ $uid }} .rj-lm-lane {
            overflow-x: auto;
            -webkit-mask-image: none;
            mask-image: none;
        }
        #{{ $uid }} .rj-lm-group[aria-hidden="true"] { display: none; }
    }
</style>

<div id="{{ $uid }}" data-card="{{ $card }}" data-hover="{{ $hover }}">
    <span class="rj-lm-blob rj-lm-blob--1" aria-hidden="true"></span>
    <span class="rj-lm-blob rj-lm-blob--2" aria-hidden="true"></span>

    @if($title !== '' || $subtitle !== '')
        <header class="rj-lm-head">
            @if($subtitle !== '')
                <p class="rj-lm-sub">{{ $subtitle }}</p>
            @endif
            @if($title !== '')
                <h2 class="rj-lm-title">{{ $title }}</h2>
            @endif
        </header>
    @endif

    @if($count > 0)
        <div class="rj-lm-lanes">
            @foreach($lanes as $li => $laneLogos)
                <div class="rj-lm-lane" data-dir="{{ $li % 2 === 0 ? 1 : -1 }}">
                    <div class="rj-lm-track">
                        @for($g = 0; $g < 2; $g++)
                            <div class="rj-lm-group" @if($g === 1) aria-hidden="true" @endif>
                                @for($r = 0; $r < $rep; $r++)
                                    @foreach($laneLogos as $logo)
                                        {!! $itemHtml($logo, $g === 1 || $r > 0) !!}
                                    @endforeach
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rj-lm-empty">{{ __('Please add at least one logo.') }}</div>
    @endif
</div>

@if($count > 0)
<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var lanes = [].slice.call(root.querySelectorAll('.rj-lm-lane')).map(function (el) {
        return { el: el, track: el.querySelector('.rj-lm-track'), rate: 1, hover: false, anim: null };
    });

    function go() { root.classList.add('is-in'); }

    var visible = false;
    var boost = 0;
    var lastY = window.pageYOffset || 0;
    var raf = null;

    function getAnim(l) {
        if (l.anim) return l.anim;
        if (l.track && l.track.getAnimations) {
            var list = l.track.getAnimations();
            if (list.length) l.anim = list[0];
        }
        return l.anim;
    }

    function frame() {
        raf = null;
        if (!visible) return;
        boost *= 0.94;
        if (boost < 0.01) boost = 0;
        var settled = boost === 0;
        lanes.forEach(function (l) {
            var target = (l.hover ? 0.12 : 1) + (l.hover ? 0 : boost);
            l.rate += (target - l.rate) * 0.08;
            if (Math.abs(target - l.rate) > 0.004) settled = false;
            var a = getAnim(l);
            if (a) {
                try { a.playbackRate = Math.max(0.05, l.rate); } catch (e) {}
            }
        });
        if (!settled) raf = requestAnimationFrame(frame);
    }
    function kick() {
        if (raf === null && visible) raf = requestAnimationFrame(frame);
    }

    if (!reduce) {
        lanes.forEach(function (l) {
            l.el.addEventListener('mouseenter', function () { l.hover = true; kick(); });
            l.el.addEventListener('mouseleave', function () { l.hover = false; kick(); });
        });
        window.addEventListener('scroll', function () {
            var y = window.pageYOffset || 0;
            var d = Math.abs(y - lastY);
            lastY = y;
            if (!visible) return;
            boost = Math.min(4, boost + Math.min(d / 60, 1.2));
            kick();
        }, { passive: true });
    }

    if (!('IntersectionObserver' in window)) {
        go();
        visible = true;
        root.classList.add('is-run');
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                visible = e.isIntersecting;
                root.classList.toggle('is-run', visible);
                if (visible) {
                    go();
                    kick();
                }
            });
        }, { threshold: 0.05 });
        io.observe(root);
        setTimeout(function () {
            if (!root.classList.contains('is-in')) { go(); root.classList.add('is-run'); visible = true; }
        }, 2500);
    }
})();
</script>
@endif
