@extends('admin.layouts.app')

@section('title', __('RJ About'))

@section('content')
@php
    $version = config('rj.version', '1.0.0');

    // Patreon linki. Link düzgün deyilsə null yaz, "Coming soon" göstərilər:
    // $patreonUrl = null;
    $patreonUrl = 'https://www.patreon.com/c/mr_ruhid';

    $quickLinks = [
        [
            'title' => __('Documentation'),
            'sub' => __('Official RJ Nexus docs'),
            'url' => 'https://rj-nexus.github.io/documents/',
            'external' => true,
            'color' => '#a78bfa',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'title' => __('Services'),
            'sub' => __('Order custom development'),
            'url' => url('/admin/services'),
            'external' => false,
            'color' => '#93c5fd',
            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        [
            'title' => __('Personal Blog'),
            'sub' => __('Updates & tutorials'),
            'url' => 'https://ruhidjavadoff.blogspot.com',
            'external' => true,
            'color' => '#fbbf24',
            'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z M14 4v6h6M8 13h8M8 17h5',
        ],
        [
            'title' => __('RJ Nexus Blog'),
            'sub' => __('Development updates'),
            'url' => 'https://ruhidjavadoff.blogspot.com/search/label/rj%20nexus',
            'external' => true,
            'color' => '#f472b6',
            'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z M14 4v6h6M8 13h8M8 17h5',
        ],
    ];
@endphp

<style>
    .ab-hero {
        position: relative; overflow: hidden; isolation: isolate; border-radius: 1.25rem; color: #fff;
        min-height: 520px; display: flex; flex-direction: column; align-items: center; justify-content: flex-start;
        padding: 52px 20px 40px; text-align: center; user-select: none; -webkit-tap-highlight-color: transparent;
        background: radial-gradient(120% 90% at 50% 0%, #251a5e 0%, #120d33 45%, #07061a 100%);
        box-shadow: 0 20px 60px -20px rgba(80, 50, 200, .55), inset 0 0 0 1px rgba(255, 255, 255, .06);
        --mx: 0; --my: 0;
    }
    .ab-nebula {
        position: absolute; inset: -20%; z-index: -2; opacity: .9; filter: blur(10px);
        background:
            radial-gradient(40% 35% at 25% 30%, rgba(167, 139, 250, .28), transparent 70%),
            radial-gradient(35% 30% at 78% 22%, rgba(244, 114, 182, .22), transparent 70%),
            radial-gradient(45% 40% at 60% 85%, rgba(96, 165, 250, .20), transparent 70%);
        animation: ab-neb 40s ease-in-out infinite alternate;
    }
    @keyframes ab-neb { from { transform: translate3d(-2%, 0, 0) rotate(0deg) scale(1); } to { transform: translate3d(3%, -2%, 0) rotate(8deg) scale(1.12); } }
    .ab-canvas { position: absolute; inset: 0; width: 100%; height: 100%; z-index: -1; display: block; }

    .ab-flash {
        position: absolute; inset: 0; z-index: 5; pointer-events: none; opacity: 0;
        background: radial-gradient(circle at 50% 24%, rgba(255, 255, 255, .95), rgba(190, 200, 255, .35) 35%, transparent 70%);
    }
    .ab-hero.ab-boom .ab-flash { animation: ab-flash 1s ease-out; }
    @keyframes ab-flash { 0% { opacity: .95; } 100% { opacity: 0; } }
    .ab-hero.ab-boom { animation: ab-shake .6s ease-out; }
    @keyframes ab-shake { 0%, 100% { transform: translate(0, 0); } 20% { transform: translate(-3px, 2px); } 40% { transform: translate(3px, -2px); } 60% { transform: translate(-2px, -1px); } 80% { transform: translate(2px, 1px); } }

    .ab-star {
        position: relative; width: 170px; height: 170px; flex: none; cursor: pointer;
        transform: translate3d(calc(var(--mx) * 16px), calc(var(--my) * 10px), 0); transition: transform .25s ease-out;
    }
    .ab-glow {
        position: absolute; inset: -130px; border-radius: 9999px; pointer-events: none;
        background: radial-gradient(circle, rgba(200, 215, 255, .55) 0%, rgba(150, 130, 255, .22) 28%, rgba(0, 0, 0, 0) 62%);
        animation: ab-breathe 5s ease-in-out infinite;
    }
    @keyframes ab-breathe { 0%, 100% { transform: scale(.88); opacity: .75; } 50% { transform: scale(1.12); opacity: 1; } }
    .ab-rays { position: absolute; inset: 0; pointer-events: none; animation: ab-spin 20s linear infinite; }
    .ab-rays::before, .ab-rays::after { content: ""; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); }
    .ab-rays::before { width: 380px; height: 2px; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .95), transparent); }
    .ab-rays::after { width: 2px; height: 380px; background: linear-gradient(180deg, transparent, rgba(255, 255, 255, .95), transparent); }
    .ab-rays.r2 { animation-duration: 34s; animation-direction: reverse; opacity: .55; transform: scale(.72); }
    .ab-ring { position: absolute; border-radius: 9999px; pointer-events: none; animation: ab-spin 26s linear infinite; }
    .ab-ring.a { inset: 20px; border: 1px dashed rgba(190, 200, 255, .4); }
    .ab-ring.b { inset: -14px; border: 1px solid rgba(244, 114, 182, .22); animation-duration: 40s; animation-direction: reverse; }
    .ab-ring::after { content: ""; position: absolute; top: -3.5px; left: 50%; width: 7px; height: 7px; margin-left: -3.5px; border-radius: 9999px; background: #a78bfa; box-shadow: 0 0 12px 3px #a78bfa; }
    .ab-ring.b::after { background: #f472b6; box-shadow: 0 0 12px 3px #f472b6; }
    .ab-core {
        position: absolute; left: 50%; top: 50%; width: 56px; height: 50px; margin: -25px 0 0 -28px; border-radius: 9999px;
        background: radial-gradient(circle at 40% 36%, #fff 0%, #eef3ff 42%, #b6c9ff 100%);
        box-shadow: 0 0 26px 10px rgba(255, 255, 255, .85), 0 0 80px 32px rgba(150, 180, 255, .6);
        animation: ab-pulse 4s ease-in-out infinite; transition: transform .3s;
    }
    .ab-star:hover .ab-core { transform: scale(1.15); }
    @keyframes ab-pulse { 0%, 100% { filter: brightness(1); } 50% { filter: brightness(1.18); } }
    @keyframes ab-spin { to { transform: rotate(360deg); } }
    .ab-star.ab-hyper .ab-rays { animation-duration: 1.4s; }
    .ab-star.ab-hyper .ab-ring { animation-duration: 3s; }
    .ab-star.ab-hyper .ab-core { animation: ab-hyper .35s ease-in-out infinite; }
    @keyframes ab-hyper { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.35); } }

    .ab-content { position: relative; z-index: 3; display: flex; flex-direction: column; align-items: center; margin-top: 22px; pointer-events: none; }
    .ab-content > * { pointer-events: auto; }
    .ab-label { font-size: 12px; letter-spacing: .42em; text-transform: uppercase; color: #c4b5fd; font-weight: 600; }
    .ab-title {
        font-size: clamp(40px, 8vw, 76px); font-weight: 800; line-height: 1; margin-top: 10px; letter-spacing: .02em;
        background: linear-gradient(90deg, #e0e7ff, #fff, #fbcfe8, #c4b5fd, #e0e7ff); background-size: 300% 100%;
        -webkit-background-clip: text; background-clip: text; color: transparent; animation: ab-shine 7s linear infinite;
        filter: drop-shadow(0 0 22px rgba(167, 139, 250, .55));
    }
    @keyframes ab-shine { to { background-position: -300% 0; } }
    .ab-desc { margin-top: 14px; max-width: 620px; font-size: 14px; line-height: 1.65; color: #aab4c8; }
    .ab-chips { margin-top: 16px; display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
    .ab-chip { padding: 4px 12px; border-radius: 9999px; font-size: 11px; color: rgba(226, 232, 255, .82); background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .12); backdrop-filter: blur(4px); }
    .ab-chip.hot { color: #ddd6fe; border-color: rgba(167, 139, 250, .5); background: rgba(167, 139, 250, .14); font-weight: 600; }

    .ab-btn {
        position: relative; overflow: hidden; margin-top: 24px; display: inline-block; border-radius: 9999px; padding: 2px; color: #fff;
        text-decoration: none; box-shadow: 0 0 40px -6px #a78bfa; transition: transform .2s, box-shadow .2s;
    }
    .ab-btn::before { content: ""; position: absolute; inset: -160%; background: conic-gradient(from 0deg, transparent 0 55%, #a78bfa, #f472b6, transparent); animation: ab-spin 3.5s linear infinite; }
    .ab-btn:hover { transform: translateY(-2px) scale(1.04); box-shadow: 0 0 60px -4px #f472b6; }
    .ab-btn .in { position: relative; display: flex; align-items: center; gap: 10px; padding: 13px 30px; border-radius: 9999px; background: #0d0a26; font-size: 14px; font-weight: 600; letter-spacing: .03em; }

    .ab-fact {
        position: absolute; z-index: 4; top: 16px; left: 50%; max-width: min(520px, 90%); transform: translate(-50%, -14px); opacity: 0; pointer-events: none;
        padding: 10px 18px; border-radius: 14px; font-size: 13px; line-height: 1.45; color: #e0e7ff; text-align: center;
        background: rgba(15, 12, 45, .72); border: 1px solid rgba(167, 139, 250, .4); backdrop-filter: blur(10px);
        box-shadow: 0 10px 40px -10px rgba(120, 90, 255, .7); transition: opacity .35s, transform .35s;
    }
    .ab-fact.show { opacity: 1; transform: translate(-50%, 0); }
    .ab-hint { position: absolute; z-index: 3; right: 18px; bottom: 14px; font-size: 11px; letter-spacing: .12em; color: rgba(203, 213, 225, .55); text-transform: uppercase; pointer-events: none; }

    .ab-intro { opacity: 0; transform: translateY(12px); animation: ab-intro .9s ease-out forwards; }
    .ab-intro.d1 { animation-delay: .15s; } .ab-intro.d2 { animation-delay: .3s; } .ab-intro.d3 { animation-delay: .45s; } .ab-intro.d4 { animation-delay: .6s; }
    @keyframes ab-intro { to { opacity: 1; transform: none; } }

    .ab-card {
        position: relative; display: flex; align-items: center; gap: 16px; padding: 18px 20px; border-radius: 1rem; overflow: hidden; text-decoration: none; color: #e2e8f0;
        background: linear-gradient(160deg, #15113a 0%, #0d0a26 100%); border: 1px solid rgba(255, 255, 255, .08);
        box-shadow: 0 14px 40px -20px rgba(60, 40, 160, .7); transition: transform .3s, box-shadow .3s, border-color .3s;
    }
    .ab-card:hover { transform: translateY(-3px); border-color: var(--c); box-shadow: 0 22px 50px -18px var(--c); }
    .ab-card .ic {
        width: 46px; height: 46px; flex: none; border-radius: 12px; display: flex; align-items: center; justify-content: center;
        color: var(--c); background: rgba(255, 255, 255, .05); border: 1px solid rgba(255, 255, 255, .1); transition: transform .3s;
    }
    .ab-card:hover .ic { transform: scale(1.1) rotate(-4deg); }
    .ab-card h3 { font-size: 14px; font-weight: 700; color: #fff; }
    .ab-card p { font-size: 12px; color: #94a3b8; margin-top: 2px; }

    @media (max-width: 640px) {
        .ab-hero { min-height: 480px; padding-top: 60px; }
        .ab-star { width: 140px; height: 140px; }
        .ab-hint { display: none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ab-hero, .ab-hero *, .ab-card, .ab-intro { animation: none !important; }
        .ab-intro { opacity: 1; transform: none; }
    }
</style>

{{-- Hero: Altair ulduzu (Updates səhifəsindəki kimi) --}}
<section id="abHero" class="ab-hero mb-8"
         data-facts="{{ json_encode([
             __('Altair is the brightest star in Aquila, the Eagle.'),
             __('Altair spins once in about 9 hours. Our Sun needs roughly 25 days.'),
             __('At 16.7 light-years, Altair is one of the nearest stars you can see with the naked eye.'),
             __('Altair, Vega and Deneb form the famous Summer Triangle.'),
         ], JSON_UNESCAPED_UNICODE) }}">
    <div class="ab-nebula" aria-hidden="true"></div>
    <canvas id="abCanvas" class="ab-canvas" aria-hidden="true"></canvas>
    <div class="ab-flash" aria-hidden="true"></div>
    <div id="abFact" class="ab-fact" role="status" aria-live="polite"></div>

    <div id="abStar" class="ab-star ab-intro" title="Altair" aria-label="Altair">
        <div class="ab-glow"></div>
        <div class="ab-ring b"></div>
        <div class="ab-ring a"></div>
        <div class="ab-rays"></div>
        <div class="ab-rays r2"></div>
        <div class="ab-core"></div>
    </div>

    <div class="ab-content">
        <div class="ab-label ab-intro d1">{{ __('RJ NEXUS CORE 1') }}</div>
        <h1 class="ab-title ab-intro d2">RJ Nexus CMS</h1>

        <div class="ab-chips ab-intro d3">
            <span class="ab-chip hot">{{ __('Version') }} {{ $version }}</span>
            <span class="ab-chip">Altair Series</span>
            <span class="ab-chip">α Aquilae</span>
        </div>

        <p class="ab-desc ab-intro d3">
            {{ __('Modern, fast, and fully self-hosted content management system. Build stunning websites with RJBuilder, manage multilingual content, and scale your business globally.') }}
        </p>

        <a href="https://rjnexus.org" target="_blank" rel="noopener" class="ab-btn ab-intro d4">
            <span class="in">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                {{ __('Official Website') }}
            </span>
        </a>
    </div>

    <div class="ab-hint">✦ {{ __('Click the star') }}</div>
</section>

{{-- Sürətli linklər --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach ($quickLinks as $link)
        <a href="{{ $link['url'] }}" @if ($link['external']) target="_blank" rel="noopener" @endif class="ab-card" style="--c: {{ $link['color'] }};">
            <span class="ic">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/></svg>
            </span>
            <span class="min-w-0">
                <h3 class="truncate">{{ $link['title'] }}</h3>
                <p class="truncate">{{ $link['sub'] }}</p>
            </span>
        </a>
    @endforeach
</div>

{{-- Dəstək / Donate bölməsi (standart dizayn) --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8 mb-8 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-br from-pink-500/10 to-orange-500/10 rounded-full blur-3xl -z-10"></div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Support the Project') }}</h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                {{ __('If this project has been useful to you, consider supporting its continued development and maintenance.') }}
            </p>

            <div class="flex flex-wrap gap-4 items-center mb-6">
                <a href="https://kofe.al/@ruhidjavadoff" target="_blank" rel="noopener" class="hover:-translate-y-1 transition-transform">
                    <img src="https://github.com/mr-ruhid/rare-logos-vault/blob/main/logo/monetization/kofe.al/kofe.al_logo.svg?raw=true" alt="Support on Kofe.al"
                         style="height:40px; width:auto; max-width:100%; background-color:#ffffff; padding:6px; border-radius:8px; border:1px solid #e5e7eb;">
                </a>
                <a href="https://cayvoy.com/donate/ruhid4715" target="_blank" rel="noopener" class="hover:-translate-y-1 transition-transform">
                    <img src="https://github.com/mr-ruhid/rare-logos-vault/blob/main/logo/monetization/cayvoy/cayvoy_logo.svg?raw=true" alt="Donate via Çayvoy"
                         style="height:40px; width:auto; max-width:100%;">
                </a>
                <a href="https://www.paypal.com/paypalme/ruhidjavadoff" target="_blank" rel="noopener" class="hover:-translate-y-1 transition-transform">
                    <img src="https://img.shields.io/badge/Donate-PayPal-00457C?style=for-the-badge&logo=paypal&logoColor=white" alt="Donate via PayPal"
                         style="height:40px; width:auto; max-width:100%; border-radius:8px;">
                </a>
                @if ($patreonUrl)
                    <a href="{{ $patreonUrl }}" target="_blank" rel="noopener" class="hover:-translate-y-1 transition-transform">
                        <img src="https://img.shields.io/badge/Support-Patreon-F96854?style=for-the-badge&logo=patreon&logoColor=white" alt="Support on Patreon"
                             style="height:40px; width:auto; max-width:100%; border-radius:8px;">
                    </a>
                @else
                    <span class="inline-flex items-center gap-2 px-4 rounded-lg bg-gray-100 text-gray-500 text-sm font-semibold border border-gray-200" style="height:40px;">
                        Patreon · {{ __('Coming soon') }}
                    </span>
                @endif
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100/50">
                        <tr>
                            <th class="px-3 py-2 rounded-l-lg">{{ __('Method') }}</th>
                            <th class="px-3 py-2 rounded-r-lg">{{ __('Details') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">Kofe.al</td>
                            <td class="px-3 py-2"><a href="https://kofe.al/@ruhidjavadoff" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">@ruhidjavadoff</a></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">Çayvoy</td>
                            <td class="px-3 py-2"><a href="https://cayvoy.com/donate/ruhid4715" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">ruhid4715</a></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">PayPal</td>
                            <td class="px-3 py-2 text-gray-600">ruhidjavadoff@gmail.com</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">Patreon</td>
                            <td class="px-3 py-2">
                                @if ($patreonUrl)
                                    <a href="{{ $patreonUrl }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">mr_ruhid</a>
                                @else
                                    <span class="text-gray-500">{{ __('Coming soon') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">{{ __('Crypto (USDT, BEP20)') }}</td>
                            <td class="px-3 py-2 font-mono text-xs break-all text-gray-600">0x9a4AD41762D6B07B8C266b312Cf0dBe31FAd890</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-start gap-2 text-xs text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-100">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <strong>Crypto Warning:</strong> {{ __('Send only USDT on the BNB Smart Chain (BEP20) network. Funds sent on other networks may be lost.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var hero = document.getElementById('abHero');
    var cv = document.getElementById('abCanvas');
    if (!hero || !cv || !cv.getContext) return;

    var ctx = cv.getContext('2d');
    var star = document.getElementById('abStar');
    var factEl = document.getElementById('abFact');
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var facts = [];
    try { facts = JSON.parse(hero.dataset.facts || '[]'); } catch (e) {}

    var colors = ['#ffffff', '#c4b5fd', '#93c5fd', '#f9a8d4'];
    var W = 0, H = 0, t = 0, mx = 0, my = 0, tmx = 0, tmy = 0, clicks = 0, factIdx = 0, factTimer = null;
    var stars = [], parts = [], rings = [], shoots = [], lastShoot = 0;
    var running = true, visible = true;

    function rand(a, b) { return a + Math.random() * (b - a); }

    function resize() {
        var r = hero.getBoundingClientRect(), dpr = Math.min(window.devicePixelRatio || 1, 2);
        W = r.width; H = r.height;
        cv.width = W * dpr; cv.height = H * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        var n = Math.round(Math.min(240, Math.max(100, W * H / 2600)));
        stars = [];
        for (var i = 0; i < n; i++) {
            stars.push({ x: Math.random(), y: Math.random(), z: rand(.15, 1), r: rand(.4, 1.6), sp: rand(.6, 2.6), ph: rand(0, 6.28),
                         c: Math.random() < .12 ? colors[(Math.random() * colors.length) | 0] : '#ffffff' });
        }
    }

    function center() {
        var hr = hero.getBoundingClientRect(), sr = star.getBoundingClientRect();
        return { x: sr.left - hr.left + sr.width / 2, y: sr.top - hr.top + sr.height / 2, r: sr.width / 2 };
    }

    function burst(x, y, n, power) {
        for (var i = 0; i < n; i++) {
            var a = rand(0, 6.283), s = rand(.4, 1) * power;
            parts.push({ x: x, y: y, vx: Math.cos(a) * s, vy: Math.sin(a) * s, life: 0, max: rand(50, 110), r: rand(.8, 2.4), c: colors[(Math.random() * colors.length) | 0] });
        }
        if (parts.length > 600) parts.splice(0, parts.length - 600);
    }
    function ring(x, y, max, speed, col) { rings.push({ x: x, y: y, r: 6, max: max, sp: speed, c: col }); }

    function showFact(text) {
        if (!text) return;
        factEl.textContent = '✦ ' + text;
        factEl.classList.add('show');
        clearTimeout(factTimer);
        factTimer = setTimeout(function () { factEl.classList.remove('show'); }, 6000);
    }

    function supernova(c) {
        clicks++;
        burst(c.x, c.y, 160, 4.2);
        ring(c.x, c.y, Math.max(W, H) * .8, 7, 'rgba(255,255,255,');
        ring(c.x, c.y, Math.max(W, H) * .55, 4.5, 'rgba(167,139,250,');
        hero.classList.remove('ab-boom'); void hero.offsetWidth; hero.classList.add('ab-boom');
        star.classList.add('ab-hyper');
        setTimeout(function () { star.classList.remove('ab-hyper'); }, 2000);
        if (facts.length) { showFact(facts[factIdx % facts.length]); factIdx++; }
    }

    function drawStars() {
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
    }

    function drawShoots() {
        if (!reduce && t - lastShoot > rand(4, 8)) {
            lastShoot = t;
            shoots.push({ x: rand(W * .3, W), y: rand(0, H * .35), vx: -rand(7, 11), vy: rand(3.5, 6), life: 0, max: 46 });
        }
        for (var i = shoots.length - 1; i >= 0; i--) {
            var s = shoots[i]; s.x += s.vx; s.y += s.vy; s.life++;
            var a = 1 - s.life / s.max;
            if (a <= 0) { shoots.splice(i, 1); continue; }
            var g = ctx.createLinearGradient(s.x, s.y, s.x - s.vx * 9, s.y - s.vy * 9);
            g.addColorStop(0, 'rgba(255,255,255,' + a + ')'); g.addColorStop(1, 'rgba(255,255,255,0)');
            ctx.strokeStyle = g; ctx.lineWidth = 1.6;
            ctx.beginPath(); ctx.moveTo(s.x, s.y); ctx.lineTo(s.x - s.vx * 9, s.y - s.vy * 9); ctx.stroke();
        }
    }

    function drawFx() {
        ctx.globalCompositeOperation = 'lighter';
        for (var i = rings.length - 1; i >= 0; i--) {
            var r = rings[i]; r.r += r.sp; r.sp *= .985;
            var a = 1 - r.r / r.max;
            if (a <= 0) { rings.splice(i, 1); continue; }
            ctx.strokeStyle = r.c + (a * .8) + ')'; ctx.lineWidth = 2 + a * 3;
            ctx.beginPath(); ctx.arc(r.x, r.y, r.r, 0, 6.283); ctx.stroke();
        }
        for (var j = parts.length - 1; j >= 0; j--) {
            var p = parts[j]; p.x += p.vx; p.y += p.vy; p.vx *= .975; p.vy = p.vy * .975 + .015; p.life++;
            var k = 1 - p.life / p.max;
            if (k <= 0) { parts.splice(j, 1); continue; }
            ctx.globalAlpha = k; ctx.fillStyle = p.c;
            ctx.beginPath(); ctx.arc(p.x, p.y, p.r * (.4 + k), 0, 6.283); ctx.fill();
        }
        ctx.globalAlpha = 1; ctx.globalCompositeOperation = 'source-over';
    }

    function frame() {
        if (!running) return;
        t += 1 / 60;
        mx += (tmx - mx) * .06; my += (tmy - my) * .06;
        hero.style.setProperty('--mx', mx.toFixed(3));
        hero.style.setProperty('--my', my.toFixed(3));
        ctx.clearRect(0, 0, W, H);
        drawStars(); drawShoots(); drawFx();
        if (!reduce) requestAnimationFrame(frame);
    }

    function start() { if (!running && visible && !document.hidden) { running = true; requestAnimationFrame(frame); } }
    function stop() { running = false; }

    hero.addEventListener('mousemove', function (e) {
        var r = hero.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top, c = center();
        tmx = (x / W - .5) * 2; tmy = (y / H - .5) * 2;
        hero.style.cursor = Math.hypot(x - c.x, y - c.y) < c.r * .55 ? 'pointer' : 'crosshair';
    });
    hero.addEventListener('mouseleave', function () { tmx = 0; tmy = 0; });
    hero.addEventListener('click', function (e) {
        if (e.target.closest('a, button')) return;
        var r = hero.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top, c = center();
        if (Math.hypot(x - c.x, y - c.y) < c.r * .6) { supernova(c); }
        else { burst(x, y, 36, 2.4); ring(x, y, 70, 2.2, 'rgba(196,181,253,'); }
        if (reduce) { ctx.clearRect(0, 0, W, H); drawStars(); }
    });
    hero.addEventListener('touchmove', function (e) {
        var tch = e.touches[0]; if (!tch) return;
        var r = hero.getBoundingClientRect();
        tmx = ((tch.clientX - r.left) / W - .5) * 2; tmy = ((tch.clientY - r.top) / H - .5) * 2;
    }, { passive: true });

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (en) { visible = en[0].isIntersecting; visible ? start() : stop(); }, { threshold: .05 }).observe(hero);
    }
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
    window.addEventListener('resize', resize);

    resize();
    requestAnimationFrame(frame);
})();
</script>
@endsection