<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>504 - {{ __('Gateway Timeout') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,900&display=swap" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #0f0a18;
            --v3: #d8b4fe; --v5: #a855f7; --v7: #6d28d9;
            --p3: #f9a8d4; --p6: #db2777;
            --muted: #a1a1aa; --dim: #71717a;
        }
        html, body { height: 100%; }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--bg);
            background-image:
                linear-gradient(rgba(139, 92, 246, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(139, 92, 246, .06) 1px, transparent 1px),
                radial-gradient(ellipse at 50% 40%, rgba(139, 92, 246, .18), transparent 60%);
            background-size: 48px 48px, 48px 48px, 100% 100%;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            padding: 24px 16px;
            overflow: hidden;
            animation: gridMove 12s linear infinite;
        }
        @keyframes gridMove { to { background-position: 48px 48px, 48px 48px, 0 0; } }

        /* scan line + particles */
        body::after {
            content: ''; position: fixed; left: 0; right: 0; top: 0; height: 140px; z-index: 1; pointer-events: none;
            background: linear-gradient(180deg, transparent, rgba(168, 85, 247, .08), transparent);
            animation: scan 5s linear infinite;
        }
        @keyframes scan { from { transform: translateY(-160px); } to { transform: translateY(110vh); } }
        .particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .pt {
            position: absolute; bottom: -10px; border-radius: 9999px;
            background: var(--v3); opacity: 0;
            animation: rise linear infinite;
        }
        .pt.pink { background: var(--p3); }
        @keyframes rise {
            0%   { transform: translate(0, 0); opacity: 0; }
            10%  { opacity: .7; }
            100% { transform: translate(var(--dx), -110vh); opacity: 0; }
        }

        /* branding */
        .branding {
            position: fixed; top: 24px; right: 24px; z-index: 100;
            display: flex; align-items: center; gap: 10px; padding: 10px 16px;
            background: rgba(255, 255, 255, .03); border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 12px; backdrop-filter: blur(8px);
            text-decoration: none; color: #fff; transition: all .3s ease;
        }
        .branding:hover { background: rgba(255, 255, 255, .06); border-color: rgba(139, 92, 246, .4); }
        .branding svg { width: 24px; height: 24px; color: var(--v5); }
        .branding-text { display: flex; flex-direction: column; text-align: left; }
        .branding-title { font-weight: 900; font-size: 14px; letter-spacing: .1em; background: linear-gradient(to right, #d8b4fe, #f9a8d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .branding-sub { font-size: 10px; color: var(--dim); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }

        /* stage */
        .stage { position: relative; z-index: 2; width: 100%; max-width: 680px; text-align: center; perspective: 900px; }
        .tilt { transition: transform .15s ease-out; transform-style: preserve-3d; }

        /* digits: 5 [clock] 4 */
        .digits {
            display: flex; align-items: center; justify-content: center;
            gap: clamp(.3rem, 2vw, 1.2rem);
            font-size: clamp(5rem, 17vw, 8.5rem); font-weight: 900; line-height: 1;
        }
        .digit { display: inline-block; position: relative; }
        .grad {
            display: inline-block;
            background: linear-gradient(180deg, var(--v3) 0%, var(--v5) 55%, var(--v7) 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent; color: transparent;
            filter: drop-shadow(0 6px 0 rgba(0, 0, 0, .55)) drop-shadow(0 0 28px rgba(168, 85, 247, .4));
        }
        .d5 { animation: bob 3s ease-in-out infinite; }
        .d4 { animation: bob 3s ease-in-out infinite reverse; }
        @keyframes bob {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50%      { transform: translateY(-12px) rotate(2deg); }
        }
        /* 4 slumps when the timer runs out */
        .d4 .grad { animation: slump 4s infinite; transform-origin: 50% 100%; }
        @keyframes slump {
            0%, 90%, 100% { transform: none; }
            93% { transform: skewX(-8deg) scaleY(.94); }
            96% { transform: skewX(5deg) scaleY(1.03); }
        }

        .clock { width: .82em; height: .82em; position: relative; animation: bob 3s ease-in-out infinite; animation-delay: -1s; }
        .clock .face {
            position: absolute; inset: 0; border-radius: 50%;
            background: radial-gradient(circle, rgba(109, 40, 217, .25), rgba(15, 10, 24, .6) 70%);
            border: 4px solid var(--v5);
            box-shadow: 0 0 30px rgba(168, 85, 247, .45), inset 0 0 24px rgba(168, 85, 247, .25);
            animation: rim 4s infinite;
        }
        @keyframes rim {
            0%, 90%, 100% { border-color: var(--v5); box-shadow: 0 0 30px rgba(168, 85, 247, .45), inset 0 0 24px rgba(168, 85, 247, .25); }
            94% { border-color: var(--p6); box-shadow: 0 0 46px rgba(219, 39, 119, .8), inset 0 0 30px rgba(219, 39, 119, .4); }
        }
        .clock svg { position: absolute; inset: 0; width: 100%; height: 100%; }
        .sweep {
            position: absolute; inset: 6%; border-radius: 50%;
            background: conic-gradient(from 0deg, transparent 0 62%, rgba(168, 85, 247, .6) 100%);
            animation: spin 4s linear infinite;
        }
        .sweep::after {
            content: ''; position: absolute; left: 50%; top: 0; width: 3px; height: 50%;
            margin-left: -1.5px; border-radius: 2px;
            background: linear-gradient(180deg, var(--p3), var(--p6));
            box-shadow: 0 0 10px var(--p6);
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .clock .hub { position: absolute; left: 50%; top: 50%; width: 9%; height: 9%; margin: -4.5% 0 0 -4.5%; border-radius: 50%; background: var(--p3); box-shadow: 0 0 12px var(--p6); }
        .clock .alarm {
            position: absolute; inset: -6%; border-radius: 50%;
            border: 2px solid var(--p6); opacity: 0;
            animation: alarm 4s infinite;
        }
        @keyframes alarm {
            0%, 92% { transform: scale(.9); opacity: 0; }
            93%     { opacity: .9; }
            100%    { transform: scale(1.5); opacity: 0; }
        }

        /* request path */
        .path {
            margin: 1.6rem auto 0;
            display: grid; grid-template-columns: auto 1fr auto 1fr auto; align-items: center;
        }
        .node { display: flex; flex-direction: column; align-items: center; gap: 6px; width: 84px; }
        .node-icon {
            position: relative; width: 54px; height: 54px; border-radius: 16px;
            display: grid; place-items: center;
            background: rgba(139, 92, 246, .08); border: 1px solid rgba(168, 85, 247, .45);
            color: var(--v3);
        }
        .node-icon svg { width: 26px; height: 26px; }
        .node-name { font-size: 13px; font-weight: 700; }
        .node-state { font-size: 11px; font-weight: 600; color: var(--v3); }
        .node.hit .node-icon { animation: gwhit .5s ease-out; }
        @keyframes gwhit {
            0%   { box-shadow: 0 0 0 0 rgba(168, 85, 247, .8); transform: scale(1); }
            40%  { transform: scale(1.12); }
            100% { box-shadow: 0 0 0 18px rgba(168, 85, 247, 0); transform: scale(1); }
        }
        .node.lost .node-icon {
            border: 1px dashed rgba(219, 39, 119, .6); color: var(--p3);
            background: rgba(219, 39, 119, .07);
            animation: shiver 2.4s infinite;
        }
        .node.lost .node-state { color: var(--p3); }
        @keyframes shiver {
            0%, 70%, 100% { transform: translate(0, 0); opacity: 1; }
            72% { transform: translate(-2px, 1px); opacity: .5; }
            74% { transform: translate(2px, -1px); opacity: 1; }
            76% { transform: translate(-1px, 0); opacity: .6; }
            78% { transform: translate(0, 0); opacity: 1; }
        }
        .ping {
            position: absolute; inset: 0; border-radius: 16px;
            border: 1px solid var(--p6); opacity: 0;
            animation: ping 2.4s ease-out infinite;
        }
        .ping:nth-child(2) { animation-delay: .8s; }
        .ping:nth-child(3) { animation-delay: 1.6s; }
        @keyframes ping {
            0%   { transform: scale(1); opacity: .8; }
            100% { transform: scale(2.1); opacity: 0; }
        }
        .bubble {
            position: absolute; right: -6px; top: -14px;
            font-size: 18px; font-weight: 900; color: var(--p3);
            animation: bubble 2s ease-in-out infinite;
        }
        .bubble:nth-of-type(2) { animation-delay: 1s; right: 14px; font-size: 13px; }
        @keyframes bubble {
            0%   { transform: translateY(6px) scale(.5); opacity: 0; }
            30%  { opacity: 1; }
            100% { transform: translateY(-16px) scale(1.1); opacity: 0; }
        }

        .link { position: relative; height: 2px; margin: 0 4px 34px; }
        .link.ok { background: linear-gradient(90deg, var(--v7), var(--v5)); border-radius: 2px; }
        .link.broken { background: repeating-linear-gradient(90deg, rgba(219, 39, 119, .6) 0 8px, transparent 8px 16px); animation: dashmove 1s linear infinite; background-size: 16px 2px; }
        @keyframes dashmove { to { background-position: 16px 0; } }
        .packet {
            position: absolute; top: 50%; left: 0; width: 10px; height: 10px; margin: -5px 0 0 -5px;
            border-radius: 9999px; background: var(--v3); box-shadow: 0 0 14px 3px var(--v5);
        }
        .packet.pink { background: var(--p3); box-shadow: 0 0 14px 3px var(--p6); }
        .cut {
            position: absolute; top: 50%; left: 66%; width: 22px; height: 22px; margin: -11px 0 0 -11px;
            display: grid; place-items: center; border-radius: 9999px;
            background: var(--bg); border: 1px solid rgba(219, 39, 119, .7); color: var(--p3);
            opacity: .45; transition: opacity .2s;
        }
        .cut svg { width: 12px; height: 12px; }
        .cut.flash { animation: cutflash .5s ease-out; }
        @keyframes cutflash {
            0%   { opacity: 1; transform: scale(1.5); box-shadow: 0 0 20px var(--p6); }
            100% { opacity: .45; transform: scale(1); box-shadow: none; }
        }
        .spark { position: absolute; width: 4px; height: 4px; margin: -2px; border-radius: 9999px; background: var(--p3); box-shadow: 0 0 8px var(--p6); }

        /* copy */
        .title {
            margin-top: 1.2rem; font-size: clamp(1.5rem, 5vw, 2.3rem); font-weight: 900; letter-spacing: .06em; text-transform: uppercase;
            background: linear-gradient(90deg, #fff 0%, var(--v3) 25%, var(--p3) 50%, var(--v3) 75%, #fff 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer { to { background-position: -200% 0; } }
        .desc { margin: .6rem auto 0; max-width: 32rem; color: var(--muted); font-size: .92rem; line-height: 1.65; }

        /* stopwatch */
        .watch { margin: 1.2rem auto 0; max-width: 26rem; }
        .watch-row { display: flex; justify-content: space-between; align-items: baseline; font-size: 12px; color: var(--dim); font-weight: 600; }
        .watch-time { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 18px; font-weight: 700; color: var(--v3); transition: color .2s; }
        .watch.over .watch-time { color: var(--p6); animation: blink .25s steps(1) 4; }
        @keyframes blink { 50% { opacity: .2; } }
        .bar { margin-top: 6px; height: 8px; border-radius: 9999px; overflow: hidden; background: #18181b; border: 1px solid #3f3f46; }
        .bar i {
            display: block; height: 100%; width: 0;
            background: repeating-linear-gradient(-45deg, var(--v5) 0 10px, var(--v7) 10px 20px);
            background-size: 28px 28px; animation: stripes .5s linear infinite;
        }
        .watch.over .bar i { background: repeating-linear-gradient(-45deg, var(--p6) 0 10px, #7f1d4d 10px 20px); background-size: 28px 28px; }
        @keyframes stripes { to { background-position: 28px 0; } }

        /* actions */
        .actions { margin-top: 1.3rem; display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .btn {
            display: inline-flex; align-items: center; gap: 10px; padding: 10px 18px; border-radius: 12px;
            font: inherit; font-size: 14px; font-weight: 700; text-decoration: none; cursor: pointer; transition: all .25s ease;
        }
        .btn:focus-visible { outline: 2px solid var(--v3); outline-offset: 3px; }
        .btn-primary { color: #fff; border: 0; background: linear-gradient(90deg, var(--v7), var(--p6)); }
        .btn-primary:hover { filter: brightness(1.12); box-shadow: 0 6px 24px rgba(168, 85, 247, .4); transform: translateY(-2px); }
        .btn-ghost { color: var(--v3); background: rgba(255, 255, 255, .03); border: 1px solid rgba(255, 255, 255, .1); }
        .btn-ghost:hover { border-color: rgba(139, 92, 246, .5); background: rgba(255, 255, 255, .06); transform: translateY(-2px); }
        .ring { position: relative; width: 26px; height: 26px; }
        .ring svg { width: 100%; height: 100%; transform: rotate(-90deg); }
        .ring circle { fill: none; stroke-width: 3; }
        .ring .track { stroke: rgba(255, 255, 255, .25); }
        .ring .fill { stroke: #fff; stroke-linecap: round; transition: stroke-dashoffset 1s linear; }
        .ring b { position: absolute; inset: 0; display: grid; place-items: center; font-size: 10px; font-weight: 900; }

        @media (max-height: 740px) { .desc { display: none; } }
        @media (max-width: 480px) {
            .branding { top: 10px; right: 10px; padding: 6px 10px; }
            .branding svg { width: 16px; height: 16px; }
            .branding-title { font-size: 12px; }
            .branding-sub { display: none; }
            .node { width: 64px; }
            .node-icon { width: 44px; height: 44px; border-radius: 13px; }
            .node-icon svg { width: 22px; height: 22px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body>

    <div class="particles" id="particles"></div>

    <a href="/" class="branding">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        <div class="branding-text">
            <span class="branding-title">RJ NEXUS</span>
            <span class="branding-sub">Powered by RJ CMS</span>
        </div>
    </a>

    <main class="stage">
        <div class="tilt" id="tilt">

            <div class="digits" aria-label="504">
                <div class="digit d5"><span class="grad">5</span></div>

                <div class="digit clock" aria-hidden="true">
                    <div class="face"></div>
                    <svg viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="41" stroke="#d8b4fe" stroke-opacity=".7" stroke-width="5" stroke-dasharray="1.2 3.37"/>
                        <circle cx="50" cy="50" r="41" stroke="#f9a8d4" stroke-width="5" stroke-dasharray="1.6 66.7" stroke-dashoffset="1"/>
                    </svg>
                    <div class="sweep"></div>
                    <div class="hub"></div>
                    <div class="alarm"></div>
                </div>

                <div class="digit d4"><span class="grad">4</span></div>
            </div>

            <div class="path" role="img" aria-label="{{ __('The request reached the gateway, but the server did not answer.') }}">
                <div class="node">
                    <div class="node-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="12" rx="2"/><path stroke-linecap="round" d="M8 20h8M12 16v4"/></svg>
                    </div>
                    <span class="node-name">{{ __('You') }}</span>
                    <span class="node-state">{{ __('Sent') }}</span>
                </div>

                <div class="link ok" id="l1"></div>

                <div class="node" id="gw">
                    <div class="node-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M14 6l6 6-6 6"/></svg>
                    </div>
                    <span class="node-name">{{ __('Gateway') }}</span>
                    <span class="node-state">{{ __('Received') }}</span>
                </div>

                <div class="link broken" id="l2">
                    <span class="cut" id="cut"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg></span>
                </div>

                <div class="node lost">
                    <div class="node-icon">
                        <span class="ping"></span><span class="ping"></span><span class="ping"></span>
                        <span class="bubble">?</span><span class="bubble">?</span>
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="6" rx="1.5"/><rect x="3" y="14" width="18" height="6" rx="1.5"/><path stroke-linecap="round" d="M7 7h.01M7 17h.01"/></svg>
                    </div>
                    <span class="node-name">{{ __('Server') }}</span>
                    <span class="node-state">{{ __('No response') }}</span>
                </div>
            </div>

            <h1 class="title">{{ __('Gateway Timeout') }}</h1>
            <p class="desc">{{ __('The server took too long to respond. This is usually temporary - please wait a moment and try again.') }}</p>

            <div class="watch" id="watch">
                <div class="watch-row">
                    <span>{{ __('Waiting for server') }}</span>
                    <span class="watch-time"><span id="t">0.00</span>s / 30s</span>
                </div>
                <div class="bar"><i id="wbar"></i></div>
            </div>

            <div class="actions">
                <button type="button" class="btn btn-primary" id="retry">
                    <span class="ring">
                        <svg viewBox="0 0 26 26"><circle class="track" cx="13" cy="13" r="11"/><circle class="fill" id="fill" cx="13" cy="13" r="11"/></svg>
                        <b id="count">20</b>
                    </span>
                    {{ __('Try again now') }}
                </button>
                <a href="/" class="btn btn-ghost">{{ __('Go to homepage') }}</a>
            </div>
        </div>
    </main>

    <script>
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* floating particles */
        (function () {
            var box = document.getElementById('particles');
            for (var i = 0; i < 26; i++) {
                var p = document.createElement('i');
                var s = 2 + Math.random() * 4;
                p.className = 'pt' + (Math.random() < .3 ? ' pink' : '');
                p.style.cssText = 'left:' + Math.random() * 100 + '%;width:' + s + 'px;height:' + s + 'px;' +
                    '--dx:' + (Math.random() * 120 - 60) + 'px;' +
                    'animation-duration:' + (7 + Math.random() * 9) + 's;animation-delay:-' + Math.random() * 14 + 's';
                box.appendChild(p);
            }
        })();

        /* live packets: you -> gateway -> (lost) */
        (function () {
            if (reduce) return;
            var l1 = document.getElementById('l1'), l2 = document.getElementById('l2');
            var gw = document.getElementById('gw'), cut = document.getElementById('cut');

            function mk(cls) { var e = document.createElement('span'); e.className = cls; return e; }

            function burst(parent, leftPct) {
                for (var i = 0; i < 10; i++) {
                    var s = mk('spark');
                    s.style.left = leftPct + '%'; s.style.top = '50%';
                    parent.appendChild(s);
                    var a = Math.random() * Math.PI * 2, d = 18 + Math.random() * 26;
                    s.animate(
                        [{ transform: 'translate(0,0) scale(1)', opacity: 1 },
                         { transform: 'translate(' + Math.cos(a) * d + 'px,' + Math.sin(a) * d + 'px) scale(0)', opacity: 0 }],
                        { duration: 600 + Math.random() * 300, easing: 'ease-out' }
                    ).onfinish = (function (el) { return function () { el.remove(); }; })(s);
                }
                cut.classList.remove('flash'); void cut.offsetWidth; cut.classList.add('flash');
            }

            function fire() {
                var p = mk('packet'); l1.appendChild(p);
                p.animate([{ left: '0%', opacity: 0 }, { left: '8%', opacity: 1, offset: .12 }, { left: '100%', opacity: 1 }],
                          { duration: 650, easing: 'ease-in' }).onfinish = function () {
                    p.remove();
                    gw.classList.remove('hit'); void gw.offsetWidth; gw.classList.add('hit');
                    var q = mk('packet pink'); l2.appendChild(q);
                    q.animate([{ left: '0%', opacity: 1 }, { left: '66%', opacity: 1 }],
                              { duration: 900, easing: 'cubic-bezier(.2,.7,.3,1)' }).onfinish = function () {
                        q.remove(); burst(l2, 66);
                    };
                };
            }
            fire();
            setInterval(fire, 1500);
        })();

        /* stopwatch: counts to 30s, flashes, starts over */
        (function () {
            var t = document.getElementById('t'), bar = document.getElementById('wbar'), w = document.getElementById('watch');
            if (reduce) { t.textContent = '30.00'; bar.style.width = '100%'; w.classList.add('over'); return; }
            var start = performance.now(), prevOver = false;
            (function loop(now) {
                var c = ((now - start) / 1000 * 3) % 34;
                var over = c >= 30;
                var v = over ? 30 : c;
                t.textContent = v.toFixed(2);
                bar.style.width = (v / 30 * 100) + '%';
                if (over !== prevOver) { w.classList.toggle('over', over); prevOver = over; }
                requestAnimationFrame(loop);
            })(start);
        })();

        /* mouse parallax */
        (function () {
            var el = document.getElementById('tilt');
            document.addEventListener('mousemove', function (e) {
                var x = e.clientX / window.innerWidth - .5, y = e.clientY / window.innerHeight - .5;
                el.style.transform = 'rotateY(' + (x * 12) + 'deg) rotateX(' + (-y * 8) + 'deg)';
            });
            document.addEventListener('mouseleave', function () { el.style.transform = ''; });
        })();

        /* auto retry */
        (function () {
            var total = 20, left = total;
            var c = document.getElementById('count'), f = document.getElementById('fill');
            var circ = 2 * Math.PI * 11;
            f.style.strokeDasharray = circ;
            document.getElementById('retry').addEventListener('click', function () { window.location.reload(); });
            setInterval(function () {
                left--;
                if (left <= 0) { window.location.reload(); return; }
                c.textContent = left;
                f.style.strokeDashoffset = circ * (1 - left / total);
            }, 1000);
        })();
    </script>
</body>
</html>