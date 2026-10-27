@php
    $first = $o['words'][0] ?? '';
@endphp

<style>
    @keyframes rjahBlink-{{ $uid }} { 0%, 49% { opacity: 1; } 50%, 100% { opacity: 0; } }
    @keyframes rjahFlow-{{ $uid }} { from { background-position: 0% 50%; } to { background-position: 100% 50%; } }
    @keyframes rjahGlow-{{ $uid }} {
        0%, 100% { text-shadow: 0 0 .12em var(--ah-cur), 0 0 .3em var(--ah-cur); }
        50% { text-shadow: 0 0 .22em var(--ah-cur), 0 0 .65em var(--ah-cur); }
    }
    @keyframes rjahHop-{{ $uid }} { 0%, 100% { transform: none; } 40% { transform: translateY(-.32em) scale(1.12); } }

    #{{ $uid }} { width: 100%; padding: {{ $o['padding'] }}px 16px; text-align: {{ $o['align'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-ah-text { --ah-color: {{ $o['color'] }}; --ah-accent: {{ $o['accent'] }}; --ah-accent2: {{ $o['accent2'] }}; --ah-hover: {{ $o['hover_color'] }}; --ah-cur: var(--ah-accent); --ah-speed: {{ $o['speed'] }}; --ah-origin: {{ $o['origin'] }}; display: block; margin: 0; padding: 0; font-size: {{ $o['size'] }}; font-weight: {{ $o['weight'] }}; line-height: 1.15; letter-spacing: -.02em; color: var(--ah-color); text-align: inherit; text-wrap: balance; overflow-wrap: break-word; }
    #{{ $uid }} .rj-ah-text.rj-ah-hover-on:hover { --ah-cur: var(--ah-hover); }

    #{{ $uid }} .rj-ah-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
    #{{ $uid }} .rj-ah-part { display: inline-block; }

    #{{ $uid }} .rj-ah-word { position: relative; display: inline-block; padding: 0 .06em; }
    #{{ $uid }} .rj-ah-highlight { position: relative; z-index: 2; display: inline-block; color: var(--ah-cur); transition: color .3s ease, opacity .28s ease, transform .28s ease, filter .28s ease; }

    #{{ $uid }} .rj-ah-svg { position: absolute; z-index: 1; pointer-events: none; }
    #{{ $uid }} .rj-ah-svg[data-k="u"] { left: -3%; right: -3%; bottom: -.17em; height: .5em; }
    #{{ $uid }} .rj-ah-svg[data-k="c"] { left: -9%; right: -9%; top: -.22em; bottom: -.24em; }
    #{{ $uid }} .rj-ah-svg svg { display: block; width: 100%; height: 100%; max-width: none; overflow: visible; }
    #{{ $uid }} .rj-ah-svg path { fill: none; stroke: var(--ah-cur); stroke-linecap: round; stroke-linejoin: round; transition: stroke .3s ease; }
    #{{ $uid }} .rj-ah-svg[data-k="c"] path { stroke-width: max(2px, .045em); vector-effect: non-scaling-stroke; }

    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before { content: ""; position: absolute; z-index: -1; left: -.12em; right: -.12em; top: 14%; bottom: 6%; border-radius: .18em; background: var(--ah-cur); opacity: .22; transform-origin: var(--ah-origin); transition: background .3s ease; }

    #{{ $uid }} .rj-ah-word[data-effect="gradient"] .rj-ah-highlight { background: linear-gradient(90deg, var(--ah-accent) 0%, var(--ah-accent2) 25%, var(--ah-accent) 50%, var(--ah-accent2) 75%, var(--ah-accent) 100%); background-size: 200% 100%; -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; animation: rjahFlow-{{ $uid }} 4s linear infinite; }
    #{{ $uid }} .rj-ah-text:hover .rj-ah-word[data-effect="gradient"] .rj-ah-highlight { animation-duration: 1.1s; }

    #{{ $uid }} .rj-ah-word[data-effect="glow"] .rj-ah-highlight { animation: rjahGlow-{{ $uid }} 2.6s ease-in-out infinite; }

    #{{ $uid }} .rj-ah-g { display: inline-block; white-space: nowrap; }
    #{{ $uid }} .rj-ah-l { display: inline-block; }
    #{{ $uid }} .rj-ah-text:hover .rj-ah-word.is-on[data-effect="letters"] .rj-ah-l { animation: rjahHop-{{ $uid }} .6s ease calc(var(--i) * 35ms) both; }

    #{{ $uid }} .rj-ah-typed-wrap { display: inline-grid; justify-items: start; color: var(--ah-cur); transition: color .3s ease; }
    #{{ $uid }} .rj-ah-ghost { grid-area: 1 / 1; visibility: hidden; white-space: nowrap; }
    #{{ $uid }} .rj-ah-line { grid-area: 1 / 1; white-space: nowrap; }
    #{{ $uid }} .rj-ah-cursor { display: inline-block; width: .07em; height: .9em; margin-left: .06em; vertical-align: -.1em; border-radius: 2px; background: currentColor; animation: rjahBlink-{{ $uid }} 1s steps(1) infinite; }

    #{{ $uid }}.js .rj-ah-part { opacity: 0; transform: translateY(.45em); filter: blur(6px); }
    #{{ $uid }}.js.in .rj-ah-part { opacity: 1; transform: none; filter: blur(0); transition: opacity calc(.8s * var(--ah-speed)) ease calc(var(--p) * 120ms * var(--ah-speed)), transform calc(.9s * var(--ah-speed)) cubic-bezier(.2,.8,.2,1) calc(var(--p) * 120ms * var(--ah-speed)), filter calc(.8s * var(--ah-speed)) ease calc(var(--p) * 120ms * var(--ah-speed)); }

    #{{ $uid }}.js .rj-ah-svg svg { clip-path: inset(-30% 100% -30% -5%); }
    #{{ $uid }}.js .rj-ah-svg[data-dir="right"] svg { clip-path: inset(-30% -5% -30% 100%); }
    #{{ $uid }}.js .rj-ah-svg[data-dir="both"] svg { clip-path: inset(-30% 50% -30% 50%); }
    #{{ $uid }}.js .rj-ah-word.is-on .rj-ah-svg svg { clip-path: inset(-30% -5% -30% -5%); transition: clip-path calc(1.2s * var(--ah-speed)) cubic-bezier(.65,0,.35,1) .1s; }

    #{{ $uid }}.js .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before { transform: scaleX(0); }
    #{{ $uid }}.js .rj-ah-word.is-on[data-effect="highlight"] .rj-ah-highlight::before { transform: none; transition: transform calc(1s * var(--ah-speed)) cubic-bezier(.65,0,.35,1) .1s, background .3s ease; }

    #{{ $uid }}.js .rj-ah-word[data-effect="gradient"] .rj-ah-highlight,
    #{{ $uid }}.js .rj-ah-word[data-effect="glow"] .rj-ah-highlight { opacity: 0; filter: blur(12px); transform: translateY(.25em); }
    #{{ $uid }}.js .rj-ah-word.is-on[data-effect="gradient"] .rj-ah-highlight,
    #{{ $uid }}.js .rj-ah-word.is-on[data-effect="glow"] .rj-ah-highlight { opacity: 1; filter: blur(0); transform: none; transition: opacity calc(1s * var(--ah-speed)) ease, filter calc(1s * var(--ah-speed)) ease, transform calc(1s * var(--ah-speed)) cubic-bezier(.2,.8,.2,1), color .3s ease; }

    #{{ $uid }}.js .rj-ah-word[data-effect="letters"] .rj-ah-l { opacity: 0; transform: translateY(.7em) rotate(10deg) scale(.6); }
    #{{ $uid }}.js .rj-ah-word.is-on[data-effect="letters"] .rj-ah-l { opacity: 1; transform: none; transition: opacity calc(.5s * var(--ah-speed)) ease calc(var(--i) * 40ms * var(--ah-speed) + .1s), transform calc(.8s * var(--ah-speed)) cubic-bezier(.34,1.56,.64,1) calc(var(--i) * 40ms * var(--ah-speed) + .1s); }

    #{{ $uid }} .rj-ah-highlight.is-out { opacity: 0 !important; transform: translateY(-.4em) !important; filter: blur(6px) !important; transition: opacity .28s ease, transform .28s ease, filter .28s ease !important; }
    #{{ $uid }} .is-reset, #{{ $uid }} .is-reset *, #{{ $uid }} .is-reset *::before, #{{ $uid }} .is-reset *::after, #{{ $uid }} .is-reset::before, #{{ $uid }} .is-reset::after { transition: none !important; }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition: none !important; }
        #{{ $uid }} .rj-ah-cursor { display: none; }
    }
</style>

<div id="{{ $uid }}" data-animate="{{ $o['animate'] ? 1 : 0 }}" data-loop="{{ $o['loop'] ? 1 : 0 }}" data-replay="{{ $o['replay'] ? 1 : 0 }}" data-speed="{{ $o['speed'] }}">
    <{{ $o['tag'] }} class="rj-ah-text{{ $o['hover'] ? ' rj-ah-hover-on' : '' }}">
        @foreach ($o['parts'] as $p)
            @if ($p['type'] === 'text')
                <span class="rj-ah-part" style="--p: {{ $loop->index }};">{{ $p['text'] }}</span>
            @else
                <span class="rj-ah-word rj-ah-part" style="--p: {{ $loop->index }};" data-effect="{{ $o['effect'] }}" data-words="{{ json_encode($o['words'], JSON_UNESCAPED_UNICODE) }}">@if ($o['effect'] === 'typing')<span class="rj-ah-sr">{{ $first }}</span><span class="rj-ah-typed-wrap" aria-hidden="true"><span class="rj-ah-ghost">{{ $o['ghost'] }}</span><span class="rj-ah-line"><span class="rj-ah-typed">{{ $first }}</span><span class="rj-ah-cursor"></span></span></span>@else<span class="rj-ah-highlight">{{ $first }}</span>@if ($o['effect'] === 'underline')<span class="rj-ah-svg" data-k="u" data-dir="{{ $o['direction'] }}" aria-hidden="true"><svg viewBox="0 0 200 20" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">@foreach ($o['paths'] as $pt)<path d="{{ $pt['d'] }}" stroke-width="{{ $pt['w'] }}" opacity="{{ $pt['o'] }}" @if ($pt['dash'] !== '') stroke-dasharray="{{ $pt['dash'] }}" @endif />@endforeach</svg></span>@elseif ($o['effect'] === 'circle')<span class="rj-ah-svg" data-k="c" data-dir="{{ $o['direction'] }}" aria-hidden="true"><svg viewBox="0 0 200 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="{{ $o['circle'] }}"/></svg></span>@endif @endif</span>
            @endif
        @endforeach
    </{{ $o['tag'] }}>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (root.dataset.animate !== '1' || reduce) { return; }

    var word = root.querySelector('.rj-ah-word');
    var hl = root.querySelector('.rj-ah-highlight');
    var typed = root.querySelector('.rj-ah-typed');
    var effect = word ? word.dataset.effect : 'none';
    var speed = parseFloat(root.dataset.speed) || 1;
    var loop = root.dataset.loop === '1';
    var replay = root.dataset.replay === '1';
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;

    var words = [];
    if (word) {
        try { words = JSON.parse(word.dataset.words) || []; } catch (e) { words = []; }
    }

    var idx = 0;
    var timer = 0;
    var visible = false;
    var started = false;
    var swapping = false;
    var hold = 3200 * speed;
    var gap = 4200 * speed;

    function setText(t) {
        if (effect !== 'letters') { hl.textContent = t; return; }

        hl.textContent = '';
        var sr = document.createElement('span');
        sr.className = 'rj-ah-sr';
        sr.textContent = t;
        hl.appendChild(sr);

        var box = document.createElement('span');
        box.setAttribute('aria-hidden', 'true');
        var n = 0;
        var parts = t.split(' ');

        parts.forEach(function (w, wi) {
            var g = document.createElement('span');
            g.className = 'rj-ah-g';
            Array.from(w).forEach(function (ch) {
                var s = document.createElement('span');
                s.className = 'rj-ah-l';
                s.style.setProperty('--i', n++);
                s.textContent = ch;
                g.appendChild(s);
            });
            box.appendChild(g);
            if (wi < parts.length - 1) { box.appendChild(document.createTextNode(' ')); }
        });

        hl.appendChild(box);
    }

    function wait(ms, fn) {
        clearTimeout(timer);
        timer = setTimeout(function () {
            if (!root.isConnected) { return; }
            if (!visible || document.hidden) { wait(500, fn); return; }
            fn();
        }, ms);
    }

    function play() {
        word.classList.add('is-reset');
        if (hl) { hl.classList.remove('is-out'); }
        word.classList.remove('is-on');
        void word.offsetWidth;
        word.classList.remove('is-reset');
        word.classList.add('is-on');
    }

    function swap(text) {
        swapping = true;
        hl.classList.add('is-out');
        setTimeout(function () {
            if (!root.isConnected) { return; }
            setText(text);
            play();
            swapping = false;
            nextStatic();
        }, 300);
    }

    function nextStatic() {
        if (words.length > 1) {
            wait(hold, function () {
                idx = (idx + 1) % words.length;
                swap(words[idx]);
            });
        } else if (loop) {
            wait(gap, function () {
                play();
                nextStatic();
            });
        }
    }

    function typeWord(t, done) {
        var i = 0;
        (function step() {
            if (!root.isConnected) { return; }
            i++;
            typed.textContent = t.slice(0, i);
            if (i < t.length) {
                timer = setTimeout(step, (55 + Math.random() * 60) * speed);
            } else if (done) {
                done();
            }
        })();
    }

    function erase(done) {
        var t = typed.textContent;
        (function step() {
            if (!root.isConnected) { return; }
            t = t.slice(0, -1);
            typed.textContent = t;
            if (t.length) {
                timer = setTimeout(step, 28 * speed);
            } else if (done) {
                done();
            }
        })();
    }

    function typeLoop() {
        typeWord(words[idx], function () {
            if (words.length > 1) {
                wait(hold, function () {
                    erase(function () {
                        idx = (idx + 1) % words.length;
                        typeLoop();
                    });
                });
            } else if (loop) {
                wait(hold, function () { erase(typeLoop); });
            }
        });
    }

    function start() {
        root.classList.add('in');
        if (!word) { return; }

        setTimeout(function () {
            if (effect === 'typing') {
                typeLoop();
            } else if (effect !== 'none') {
                play();
                nextStatic();
            }
        }, 450 * speed);
    }

    root.classList.add('js');

    if (word && words.length) {
        if (effect === 'typing' && typed) { typed.textContent = ''; }
        if (effect === 'letters' && hl) { setText(words[0]); }
    }

    if (word && replay && canHover && (effect === 'underline' || effect === 'circle' || effect === 'highlight')) {
        var cool = false;
        word.addEventListener('mouseenter', function () {
            if (cool || !started || swapping) { return; }
            cool = true;
            play();
            setTimeout(function () { cool = false; }, 1600 * speed);
        });
    }

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) {
            visible = entries[0].isIntersecting;
            if (visible && !started) {
                started = true;
                start();
            }
        }, { threshold: 0.3 }).observe(root);
    } else {
        visible = true;
        started = true;
        start();
    }
})();
</script>
