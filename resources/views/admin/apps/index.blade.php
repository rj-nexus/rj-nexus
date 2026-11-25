@extends('admin.layouts.app')

@section('title', __('RJ Apps'))

@section('content')
@php
    $apps = [
        [
            'id' => 'nexus-app',
            'name' => 'RJ Nexus App',
            'tag' => __('Your site, in your pocket'),
            'desc' => __('Manage your RJ Nexus website from your phone: publish, moderate and stay on top of what is happening, wherever you are.'),
            'platforms' => [__('Mobile')],
            'color' => '#a78bfa',
            'features' => [
                __('Create and edit posts and pages'),
                __('Moderate comments and reply on the go'),
                __('Upload photos straight to the media library'),
                __('Push notifications for new activity'),
            ],
            'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
        ],
        [
            'id' => 'nexus-dock',
            'name' => 'Nexus Dock',
            'tag' => __('Local server, made simple'),
            'desc' => __('A modern desktop app for running RJ Nexus locally. Think XAMPP or Docker, but easier to use, clearer to read and built for RJ Nexus.'),
            'platforms' => [__('PC')],
            'color' => '#93c5fd',
            'features' => [
                __('One-click local environment for your sites'),
                __('Clean, guided interface instead of config files'),
                __('Connect your domain and hosting from the app'),
                __('Start, stop and monitor every project'),
            ],
            'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        [
            'id' => 'rj-desk',
            'name' => 'RJ Desk',
            'tag' => __('Run your store from your phone'),
            'desc' => __('The store management companion for RJ Commerce. Handle orders, products and stock without opening a laptop.'),
            'platforms' => [__('Mobile')],
            'color' => '#fbbf24',
            'features' => [
                __('Track and fulfil orders in real time'),
                __('Edit products, prices and stock'),
                __('Sales overview at a glance'),
                __('Alerts for new orders and low stock'),
            ],
            'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
        ],
        [
            'id' => 'kovraq',
            'name' => 'Kovraq',
            'tag' => __('Build your own apps'),
            'desc' => __('A standalone builder in the spirit of RJBuilder. Assemble your own programs from widgets, with the same visual logic you already know.'),
            'platforms' => [__('Mobile'), __('PC')],
            'color' => '#f472b6',
            'features' => [
                __('Widget-based visual builder'),
                __('Create your own programs without heavy coding'),
                __('Works on both mobile and desktop'),
                __('Shares the RJ Nexus ecosystem'),
            ],
            'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z',
        ],
    ];

    $supportUrl = route('admin.about.index') . '#support';
@endphp

<style>
    .ap-hero {
        position: relative; overflow: hidden; isolation: isolate; border-radius: 1.25rem; color: #fff;
        padding: 48px 20px 44px; text-align: center; user-select: none;
        background: radial-gradient(120% 90% at 50% 0%, #251a5e 0%, #120d33 45%, #07061a 100%);
        box-shadow: 0 20px 60px -20px rgba(80, 50, 200, .55), inset 0 0 0 1px rgba(255, 255, 255, .06);
        --mx: 0; --my: 0;
    }
    .ap-nebula {
        position: absolute; inset: -20%; z-index: -2; opacity: .9; filter: blur(10px);
        background:
            radial-gradient(40% 35% at 22% 30%, rgba(167, 139, 250, .28), transparent 70%),
            radial-gradient(35% 30% at 80% 25%, rgba(244, 114, 182, .22), transparent 70%),
            radial-gradient(45% 40% at 60% 88%, rgba(96, 165, 250, .20), transparent 70%);
        animation: ap-neb 40s ease-in-out infinite alternate;
    }
    @keyframes ap-neb { from { transform: translate3d(-2%, 0, 0) rotate(0) scale(1); } to { transform: translate3d(3%, -2%, 0) rotate(8deg) scale(1.12); } }
    .ap-canvas { position: absolute; inset: 0; width: 100%; height: 100%; z-index: -1; display: block; }

    .ap-badge {
        display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 9999px; font-size: 12px; font-weight: 700;
        letter-spacing: .2em; text-transform: uppercase; color: #fbcfe8; background: rgba(244, 114, 182, .14); border: 1px solid rgba(244, 114, 182, .45);
    }
    .ap-badge i { width: 7px; height: 7px; border-radius: 9999px; background: #f472b6; box-shadow: 0 0 10px #f472b6; animation: ap-ping 1.6s ease-out infinite; }
    @keyframes ap-ping { 0% { box-shadow: 0 0 0 0 rgba(244, 114, 182, .9); } 100% { box-shadow: 0 0 0 10px rgba(244, 114, 182, 0); } }

    .ap-title {
        margin-top: 16px; font-size: clamp(44px, 9vw, 84px); font-weight: 800; line-height: 1; letter-spacing: .02em;
        background: linear-gradient(90deg, #e0e7ff, #fff, #fbcfe8, #c4b5fd, #e0e7ff); background-size: 300% 100%;
        -webkit-background-clip: text; background-clip: text; color: transparent; animation: ap-shine 7s linear infinite;
        filter: drop-shadow(0 0 22px rgba(167, 139, 250, .55));
    }
    @keyframes ap-shine { to { background-position: -300% 0; } }
    .ap-lead { margin: 14px auto 0; max-width: 560px; font-size: 14px; line-height: 1.65; color: #aab4c8; }

    .ap-stage {
        --s: min(440px, 84vw); position: relative; width: var(--s); height: var(--s); margin: 30px auto 0;
        transform: translate3d(calc(var(--mx) * 10px), calc(var(--my) * 8px), 0); transition: transform .25s ease-out;
    }
    .ap-sun {
        position: absolute; left: 50%; top: 50%; width: 22%; height: 22%; transform: translate(-50%, -50%); border-radius: 9999px;
        background: radial-gradient(circle at 40% 36%, #fff 0%, #eef3ff 42%, #b6c9ff 100%);
        box-shadow: 0 0 26px 10px rgba(255, 255, 255, .8), 0 0 90px 36px rgba(150, 180, 255, .55);
        display: flex; align-items: center; justify-content: center; color: #1b1244; font-size: 13px; font-weight: 800; letter-spacing: .04em;
        animation: ap-pulse 4s ease-in-out infinite;
    }
    @keyframes ap-pulse { 0%, 100% { filter: brightness(1); } 50% { filter: brightness(1.18); } }
    .ap-orbit {
        position: absolute; left: 50%; top: 50%; border-radius: 9999px; border: 1px dashed rgba(190, 200, 255, .22);
        width: var(--d); height: var(--d); margin: calc(var(--d) / -2) 0 0 calc(var(--d) / -2); animation: ap-spin var(--t) linear infinite;
    }
    .ap-orbit.o1 { --d: 42%; --t: 18s; }
    .ap-orbit.o2 { --d: 62%; --t: 26s; animation-direction: reverse; }
    .ap-orbit.o3 { --d: 82%; --t: 36s; }
    .ap-orbit.o4 { --d: 100%; --t: 48s; animation-direction: reverse; }
    @keyframes ap-spin { to { transform: rotate(360deg); } }
    .ap-planet {
        position: absolute; left: 50%; top: 0; width: 46px; height: 46px; margin: -23px 0 0 -23px; border: 0; padding: 0; cursor: pointer;
        border-radius: 9999px; display: flex; align-items: center; justify-content: center; color: var(--c);
        background: radial-gradient(circle at 35% 30%, rgba(255, 255, 255, .22), rgba(13, 10, 38, .92) 70%);
        box-shadow: 0 0 0 1px var(--c), 0 0 24px -2px var(--c); animation: ap-spin var(--t) linear infinite reverse; transition: transform .2s;
    }
    .ap-orbit.o2 .ap-planet, .ap-orbit.o4 .ap-planet { animation-direction: normal; }
    .ap-planet:hover { transform: scale(1.2); }
    .ap-planet:focus-visible { outline: 2px solid #fff; outline-offset: 3px; }

    .ap-grid { display: grid; gap: 16px; grid-template-columns: 1fr; margin-top: 24px; }
    @media (min-width: 768px) { .ap-grid { grid-template-columns: repeat(2, 1fr); } }
    .ap-card {
        position: relative; padding: 24px; border-radius: 1rem; overflow: hidden; color: #e2e8f0; scroll-margin-top: 90px;
        background: linear-gradient(160deg, #15113a 0%, #0d0a26 100%); border: 1px solid rgba(255, 255, 255, .08);
        box-shadow: 0 14px 40px -20px rgba(60, 40, 160, .7); transition: transform .3s, box-shadow .3s, border-color .3s;
    }
    .ap-card::before {
        content: ""; position: absolute; width: 220px; height: 220px; right: -80px; top: -90px; border-radius: 9999px; pointer-events: none;
        background: radial-gradient(circle, var(--c), transparent 70%); opacity: .22;
    }
    .ap-card:hover { transform: translateY(-3px); border-color: var(--c); box-shadow: 0 22px 50px -18px var(--c); }
    .ap-card.ap-flash { animation: ap-flash 1.4s ease-out; }
    @keyframes ap-flash { 0% { box-shadow: 0 0 0 0 var(--c), 0 0 60px 0 var(--c); } 100% { box-shadow: 0 0 0 14px transparent, 0 14px 40px -20px rgba(60, 40, 160, .7); } }
    .ap-ic {
        width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: var(--c);
        background: rgba(255, 255, 255, .05); border: 1px solid rgba(255, 255, 255, .1);
    }
    .ap-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .ap-status { padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; color: #fbcfe8; background: rgba(244, 114, 182, .12); border: 1px solid rgba(244, 114, 182, .35); }
    .ap-card h2 { margin-top: 16px; font-size: 20px; font-weight: 800; color: #fff; }
    .ap-tag { margin-top: 2px; font-size: 13px; font-weight: 600; color: var(--c); }
    .ap-card p.d { margin-top: 10px; font-size: 13px; line-height: 1.65; color: #94a3b8; }
    .ap-plat { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 14px; }
    .ap-plat span { padding: 3px 10px; border-radius: 9999px; font-size: 11px; color: #e2e8f0; background: rgba(255, 255, 255, .07); border: 1px solid rgba(255, 255, 255, .14); }
    .ap-list { list-style: none; margin: 16px 0 0; padding: 0; display: flex; flex-direction: column; gap: 8px; }
    .ap-list li { position: relative; padding-left: 18px; font-size: 13px; color: #cbd5e1; }
    .ap-list li::before { content: ""; position: absolute; left: 2px; top: .62em; width: 6px; height: 6px; border-radius: 9999px; background: var(--c); box-shadow: 0 0 8px var(--c); }

    .ap-support {
        position: relative; overflow: hidden; margin-top: 24px; padding: 32px 24px; border-radius: 1.25rem; text-align: center; color: #fff;
        background: linear-gradient(135deg, #1b1244, #0d0a26); border: 1px solid transparent;
        background-image: linear-gradient(135deg, #1b1244, #0d0a26), linear-gradient(120deg, #f472b6, #a78bfa, #fbbf24, #f472b6);
        background-origin: border-box; background-clip: padding-box, border-box; background-size: auto, 300% 300%; animation: ap-border 6s linear infinite;
        box-shadow: 0 0 60px -16px rgba(244, 114, 182, .6);
    }
    @keyframes ap-border { to { background-position: 0 0, 300% 0; } }
    .ap-support h2 { font-size: 24px; font-weight: 800; }
    .ap-support p { margin: 10px auto 0; max-width: 560px; font-size: 14px; line-height: 1.65; color: #aab4c8; }
    .ap-cta {
        display: inline-flex; align-items: center; gap: 10px; margin-top: 22px; padding: 12px 26px; border-radius: 9999px; color: #fff; font-size: 14px; font-weight: 700;
        text-decoration: none; background: linear-gradient(90deg, #a78bfa, #f472b6); box-shadow: 0 10px 30px -8px rgba(244, 114, 182, .7); transition: transform .2s, filter .2s;
    }
    .ap-cta:hover { transform: translateY(-2px); filter: brightness(1.1); }

    @media (prefers-reduced-motion: reduce) {
        .ap-hero *, .ap-planet, .ap-orbit, .ap-support, .ap-card { animation: none !important; }
    }
</style>

<div class="space-y-6">

    <section id="apHero" class="ap-hero">
        <div class="ap-nebula" aria-hidden="true"></div>
        <canvas id="apCanvas" class="ap-canvas" aria-hidden="true"></canvas>

        <span class="ap-badge"><i></i>{{ __('Coming soon') }}</span>
        <h1 class="ap-title">RJ Apps</h1>
        <p class="ap-lead">
            {{ __('The RJ Nexus ecosystem is growing beyond the browser. Four apps are planned for mobile and desktop, built to work together around your site.') }}
        </p>

        <div class="ap-stage" aria-label="{{ __('Planned apps') }}">
            <div class="ap-sun">RJ</div>
            @foreach ($apps as $i => $app)
                <div class="ap-orbit o{{ $i + 1 }}">
                    <button type="button" class="ap-planet" style="--c: {{ $app['color'] }};" data-target="{{ $app['id'] }}" title="{{ $app['name'] }}" aria-label="{{ $app['name'] }}">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $app['icon'] }}"/></svg>
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    <div class="ap-grid">
        @foreach ($apps as $app)
            <article id="{{ $app['id'] }}" class="ap-card" style="--c: {{ $app['color'] }};">
                <div class="ap-head">
                    <span class="ap-ic">
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $app['icon'] }}"/></svg>
                    </span>
                    <span class="ap-status">{{ __('Planned') }}</span>
                </div>

                <h2>{{ $app['name'] }}</h2>
                <div class="ap-tag">{{ $app['tag'] }}</div>
                <p class="d">{{ $app['desc'] }}</p>

                <div class="ap-plat">
                    @foreach ($app['platforms'] as $platform)
                        <span>{{ $platform }}</span>
                    @endforeach
                </div>

                <ul class="ap-list">
                    @foreach ($app['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </article>
        @endforeach
    </div>

    <section class="ap-support">
        <h2>{{ __('Help us build these faster') }}</h2>
        <p>
            {{ __('RJ Nexus is built by a very small team. Your support goes straight into development time, so these apps can reach you sooner. Features are planned and may change as we build.') }}
        </p>
        <a href="{{ $supportUrl }}" class="ap-cta">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            {{ __('Support the project') }}
        </a>
    </section>

</div>

<script>
(function () {
    var hero = document.getElementById('apHero');
    var cv = document.getElementById('apCanvas');
    if (!hero || !cv || !cv.getContext) return;

    var ctx = cv.getContext('2d');
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var colors = ['#ffffff', '#c4b5fd', '#93c5fd', '#f9a8d4'];
    var W = 0, H = 0, t = 0, mx = 0, my = 0, tmx = 0, tmy = 0, lastShoot = 0;
    var stars = [], shoots = [], running = true, visible = true;

    function rand(a, b) { return a + Math.random() * (b - a); }

    function resize() {
        var r = hero.getBoundingClientRect(), dpr = Math.min(window.devicePixelRatio || 1, 2);
        W = r.width; H = r.height;
        cv.width = W * dpr; cv.height = H * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        var n = Math.round(Math.min(240, Math.max(100, W * H / 2800)));
        stars = [];
        for (var i = 0; i < n; i++) {
            stars.push({ x: Math.random(), y: Math.random(), z: rand(.15, 1), r: rand(.4, 1.6), sp: rand(.6, 2.6), ph: rand(0, 6.28),
                         c: Math.random() < .12 ? colors[(Math.random() * colors.length) | 0] : '#ffffff' });
        }
    }

    function frame() {
        if (!running) return;
        t += 1 / 60;
        mx += (tmx - mx) * .06; my += (tmy - my) * .06;
        hero.style.setProperty('--mx', mx.toFixed(3));
        hero.style.setProperty('--my', my.toFixed(3));
        ctx.clearRect(0, 0, W, H);

        for (var i = 0; i < stars.length; i++) {
            var s = stars[i];
            var px = s.x * W + mx * s.z * 26 + Math.sin(t * .05 * s.z + s.ph) * 4 * s.z;
            var py = s.y * H + my * s.z * 16;
            var a = .3 + .7 * (.5 + .5 * Math.sin(t * s.sp + s.ph));
            ctx.globalAlpha = a * (.4 + s.z * .6);
            ctx.fillStyle = s.c;
            ctx.beginPath(); ctx.arc(px, py, s.r * (.6 + s.z * .6), 0, 6.283); ctx.fill();
        }
        ctx.globalAlpha = 1;

        if (!reduce && t - lastShoot > rand(4, 8)) {
            lastShoot = t;
            shoots.push({ x: rand(W * .3, W), y: rand(0, H * .35), vx: -rand(7, 11), vy: rand(3.5, 6), life: 0, max: 46 });
        }
        for (var j = shoots.length - 1; j >= 0; j--) {
            var o = shoots[j]; o.x += o.vx; o.y += o.vy; o.life++;
            var k = 1 - o.life / o.max;
            if (k <= 0) { shoots.splice(j, 1); continue; }
            var g = ctx.createLinearGradient(o.x, o.y, o.x - o.vx * 9, o.y - o.vy * 9);
            g.addColorStop(0, 'rgba(255,255,255,' + k + ')'); g.addColorStop(1, 'rgba(255,255,255,0)');
            ctx.strokeStyle = g; ctx.lineWidth = 1.6;
            ctx.beginPath(); ctx.moveTo(o.x, o.y); ctx.lineTo(o.x - o.vx * 9, o.y - o.vy * 9); ctx.stroke();
        }
        if (!reduce) requestAnimationFrame(frame);
    }

    function start() { if (!running && visible && !document.hidden) { running = true; requestAnimationFrame(frame); } }
    function stop() { running = false; }

    hero.addEventListener('mousemove', function (e) {
        var r = hero.getBoundingClientRect();
        tmx = ((e.clientX - r.left) / W - .5) * 2; tmy = ((e.clientY - r.top) / H - .5) * 2;
    });
    hero.addEventListener('mouseleave', function () { tmx = 0; tmy = 0; });

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (en) { visible = en[0].isIntersecting; visible ? start() : stop(); }, { threshold: .05 }).observe(hero);
    }
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
    window.addEventListener('resize', resize);

    document.querySelectorAll('.ap-planet').forEach(function (b) {
        b.addEventListener('click', function () {
            var card = document.getElementById(b.getAttribute('data-target'));
            if (!card) return;
            card.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' });
            card.classList.remove('ap-flash'); void card.offsetWidth; card.classList.add('ap-flash');
        });
    });

    resize();
    if (reduce) { frame(); } else { requestAnimationFrame(frame); }
})();
</script>
@endsection