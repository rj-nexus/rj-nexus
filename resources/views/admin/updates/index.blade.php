@extends('admin.layouts.app')

@section('title', __('Updates'))

@section('content')

@php
    $release   = $data['lastRelease'] ?? null;
    $hasUpdate = !empty($release['has_update']);
    $hasInfo   = !empty($release);

    $nxFacts = [
        __('Altair comes from the Arabic "al-nasr al-ta\'ir" — the flying eagle.'),
        __('Altair spins once in about 9 hours. Our Sun needs roughly 25 days.'),
        __('At 16.7 light-years, Altair is one of the nearest stars you can see with the naked eye.'),
        __('Altair shines about 11 times brighter than the Sun.'),
        __('Altair is the brightest star in Aquila, the Eagle.'),
        __('Its fast spin squashes it: Altair is roughly 14% wider at the equator than pole to pole.'),
        __('Altair, Vega and Deneb form the famous Summer Triangle.'),
    ];
    $nxVega  = __('Vega — 25 light-years away. The first star (after the Sun) ever photographed, in 1850.');
    $nxDeneb = __('Deneb — about 2,600 light-years away, yet still bright in our sky. Far more luminous than Altair.');
@endphp

<script>document.documentElement.classList.add('nx-js');</script>

<style>
    /* =====================================================
       RJ NEXUS CORE 1  ·  "Altair"
       ===================================================== */
    .nx-page { --nx-p:#a78bfa; --nx-k:#f472b6; --nx-b:#93c5fd; --nx-bg:#0b0922; }
    .nx-page.nx-new { --nx-p:#f472b6; --nx-k:#fbbf24; }

    /* ---------- HERO ---------- */
    .nx-hero {
        position:relative; overflow:hidden; border-radius:1.25rem; color:#fff; isolation:isolate;
        min-height:600px; display:flex; flex-direction:column; align-items:center; justify-content:flex-start;
        padding:56px 20px 36px; text-align:center; user-select:none; -webkit-tap-highlight-color:transparent;
        background:
            radial-gradient(120% 90% at 50% 0%, #251a5e 0%, #120d33 45%, #07061a 100%);
        box-shadow:0 20px 60px -20px rgba(80,50,200,.55), inset 0 0 0 1px rgba(255,255,255,.06);
        --mx:0; --my:0;
    }
    .nx-nebula { position:absolute; inset:-20%; z-index:-2; opacity:.9; filter:blur(10px);
        background:
            radial-gradient(40% 35% at 25% 30%, rgba(167,139,250,.28), transparent 70%),
            radial-gradient(35% 30% at 78% 22%, rgba(244,114,182,.22), transparent 70%),
            radial-gradient(45% 40% at 60% 85%, rgba(96,165,250,.20), transparent 70%);
        animation:nx-neb 40s ease-in-out infinite alternate; }
    @keyframes nx-neb { from { transform:translate3d(-2%,0,0) rotate(0deg) scale(1); } to { transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12); } }

    .nx-canvas { position:absolute; inset:0; width:100%; height:100%; z-index:-1; display:block; }

    .nx-flash { position:absolute; inset:0; z-index:5; pointer-events:none; opacity:0;
        background:radial-gradient(circle at 50% 24%, rgba(255,255,255,.95), rgba(190,200,255,.35) 35%, transparent 70%); }
    .nx-hero.nx-boom .nx-flash { animation:nx-flash 1s ease-out; }
    @keyframes nx-flash { 0% { opacity:.95; } 100% { opacity:0; } }
    .nx-hero.nx-boom { animation:nx-shake .6s ease-out; }
    @keyframes nx-shake { 0%,100% { transform:translate(0,0); } 20% { transform:translate(-3px,2px); } 40% { transform:translate(3px,-2px); } 60% { transform:translate(-2px,-1px); } 80% { transform:translate(2px,1px); } }

    /* ---------- ALTAIR ---------- */
    .nx-altair { position:relative; width:190px; height:190px; flex:none; cursor:pointer;
        transform:translate3d(calc(var(--mx) * 16px), calc(var(--my) * 10px), 0); transition:transform .25s ease-out; }
    .nx-altair:hover .nx-core { transform:scale(1.15); }
    .nx-glow { position:absolute; inset:-140px; border-radius:9999px; pointer-events:none;
        background:radial-gradient(circle, rgba(200,215,255,.55) 0%, rgba(150,130,255,.22) 28%, rgba(0,0,0,0) 62%);
        animation:nx-breathe 5s ease-in-out infinite; }
    @keyframes nx-breathe { 0%,100% { transform:scale(.88); opacity:.75; } 50% { transform:scale(1.12); opacity:1; } }

    .nx-rays { position:absolute; inset:0; pointer-events:none; animation:nx-spin 20s linear infinite; }
    .nx-rays::before, .nx-rays::after { content:""; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); }
    .nx-rays::before { width:420px; height:2px; background:linear-gradient(90deg, transparent, rgba(255,255,255,.95), transparent); }
    .nx-rays::after  { width:2px; height:420px; background:linear-gradient(180deg, transparent, rgba(255,255,255,.95), transparent); }
    .nx-rays.r2 { animation-duration:34s; animation-direction:reverse; opacity:.55; transform:scale(.72); }

    .nx-ring { position:absolute; border-radius:9999px; pointer-events:none; animation:nx-spin 26s linear infinite; }
    .nx-ring.a { inset:22px; border:1px dashed rgba(190,200,255,.4); }
    .nx-ring.b { inset:-16px; border:1px solid rgba(244,114,182,.22); animation-duration:40s; animation-direction:reverse; }
    .nx-ring.c { inset:-60px; border:1px dashed rgba(147,197,253,.18); animation-duration:60s; }
    .nx-ring::after { content:""; position:absolute; top:-3.5px; left:50%; width:7px; height:7px; margin-left:-3.5px; border-radius:9999px; background:var(--nx-p); box-shadow:0 0 12px 3px var(--nx-p); }
    .nx-ring.b::after { background:var(--nx-k); box-shadow:0 0 12px 3px var(--nx-k); }
    .nx-ring.c::after { background:var(--nx-b); box-shadow:0 0 12px 3px var(--nx-b); width:5px; height:5px; }

    /* Altair spins so fast it is flattened at the poles */
    .nx-core { position:absolute; left:50%; top:50%; width:62px; height:54px; margin:-27px 0 0 -31px; border-radius:9999px;
        background:radial-gradient(circle at 40% 36%, #fff 0%, #eef3ff 42%, #b6c9ff 100%);
        box-shadow:0 0 26px 10px rgba(255,255,255,.85), 0 0 80px 32px rgba(150,180,255,.6);
        animation:nx-pulse 4s ease-in-out infinite; transition:transform .3s; }
    @keyframes nx-pulse { 0%,100% { filter:brightness(1); } 50% { filter:brightness(1.18); } }
    @keyframes nx-spin { to { transform:rotate(360deg); } }

    .nx-altair.nx-hyper .nx-rays { animation-duration:1.4s; }
    .nx-altair.nx-hyper .nx-rays.r2 { animation-duration:2.4s; }
    .nx-altair.nx-hyper .nx-ring { animation-duration:3s; }
    .nx-altair.nx-hyper .nx-core { animation:nx-hyper .35s ease-in-out infinite; }
    @keyframes nx-hyper { 0%,100% { transform:scale(1); } 50% { transform:scale(1.35); } }

    /* ---------- TEXT ---------- */
    .nx-content { position:relative; z-index:3; display:flex; flex-direction:column; align-items:center; margin-top:22px; pointer-events:none; }
    .nx-content > * { pointer-events:auto; }
    .nx-label { font-size:12px; letter-spacing:.42em; text-transform:uppercase; color:#c4b5fd; font-weight:600; }
    .nx-title { font-size:clamp(48px,9vw,92px); font-weight:800; line-height:1; margin-top:10px; letter-spacing:.02em;
        background:linear-gradient(90deg,#e0e7ff,#fff,#fbcfe8,#c4b5fd,#e0e7ff); background-size:300% 100%;
        -webkit-background-clip:text; background-clip:text; color:transparent; animation:nx-shine 7s linear infinite;
        filter:drop-shadow(0 0 22px rgba(167,139,250,.55)); }
    @keyframes nx-shine { to { background-position:-300% 0; } }
    .nx-ver { margin-top:8px; font-size:15px; color:#cbd5e1; letter-spacing:.08em; }
    .nx-ver b { color:#fff; font-weight:700; }
    .nx-sub { margin-top:6px; font-size:13px; color:#94a3b8; }

    .nx-status { margin-top:18px; display:inline-flex; align-items:center; gap:10px; padding:8px 18px; border-radius:9999px; font-size:13px; font-weight:600; backdrop-filter:blur(8px); }
    .nx-status.ok   { background:rgba(34,197,94,.14);  color:#86efac; border:1px solid rgba(34,197,94,.4);  box-shadow:0 0 28px -6px rgba(34,197,94,.55); }
    .nx-status.new  { background:rgba(244,114,182,.16); color:#fbcfe8; border:1px solid rgba(244,114,182,.5); box-shadow:0 0 34px -4px rgba(244,114,182,.7); animation:nx-statpulse 2s ease-in-out infinite; }
    .nx-status.none { background:rgba(255,255,255,.07); color:#cbd5e1; border:1px solid rgba(255,255,255,.18); }
    @keyframes nx-statpulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.04); } }
    .nx-status .dot { width:8px; height:8px; border-radius:9999px; background:currentColor; box-shadow:0 0 10px currentColor; }
    .nx-status.new .dot { animation:nx-ping 1.2s ease-out infinite; }
    @keyframes nx-ping { 0% { box-shadow:0 0 0 0 rgba(244,114,182,.9); } 100% { box-shadow:0 0 0 12px rgba(244,114,182,0); } }
    .nx-status a { color:inherit; text-decoration:underline; text-underline-offset:3px; }

    .nx-chips { margin-top:16px; display:flex; flex-wrap:wrap; gap:8px; justify-content:center; }
    .nx-chip { padding:4px 12px; border-radius:9999px; font-size:11px; color:rgba(226,232,255,.82); background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); backdrop-filter:blur(4px); }

    /* ---------- CHECK BUTTON (over the animation) ---------- */
    .nx-btn { position:relative; overflow:hidden; margin-top:26px; border-radius:9999px; padding:2px; border:0; cursor:pointer; color:#fff;
        box-shadow:0 0 40px -6px var(--nx-p); transition:transform .2s, box-shadow .2s; }
    .nx-btn::before { content:""; position:absolute; inset:-160%; background:conic-gradient(from 0deg, transparent 0 55%, var(--nx-p), var(--nx-k), transparent); animation:nx-spin 3.5s linear infinite; }
    .nx-btn:hover { transform:translateY(-2px) scale(1.04); box-shadow:0 0 60px -4px var(--nx-k); }
    .nx-btn:active { transform:scale(.97); }
    .nx-btn .in { position:relative; display:flex; align-items:center; gap:10px; padding:14px 32px; border-radius:9999px; background:#0d0a26; font-size:15px; font-weight:600; letter-spacing:.03em; }
    .nx-btn svg { transition:transform .6s; }
    .nx-btn:hover svg { transform:rotate(180deg); }
    .nx-btn.nx-loading { pointer-events:none; }
    .nx-btn.nx-loading svg { animation:nx-spin .8s linear infinite; }
    .nx-checked { margin-top:12px; font-size:12px; color:#94a3b8; }

    /* ---------- FACT TOAST + HINT ---------- */
    .nx-fact { position:absolute; z-index:4; top:16px; left:50%; max-width:min(560px,90%); transform:translate(-50%,-14px); opacity:0; pointer-events:none;
        padding:10px 18px; border-radius:14px; font-size:13px; line-height:1.45; color:#e0e7ff; text-align:center;
        background:rgba(15,12,45,.72); border:1px solid rgba(167,139,250,.4); backdrop-filter:blur(10px);
        box-shadow:0 10px 40px -10px rgba(120,90,255,.7); transition:opacity .35s, transform .35s; }
    .nx-fact.show { opacity:1; transform:translate(-50%,0); }
    .nx-fact i { font-style:normal; color:#fbbf24; margin-right:6px; }
    .nx-hint { position:absolute; z-index:3; right:18px; bottom:14px; font-size:11px; letter-spacing:.12em; color:rgba(203,213,225,.55); text-transform:uppercase; animation:nx-hint 3s ease-in-out infinite; pointer-events:none; }
    @keyframes nx-hint { 0%,100% { opacity:.35; } 50% { opacity:.9; } }

    /* ---------- CARDS ---------- */
    .nx-card { position:relative; border-radius:1rem; color:#e2e8f0; overflow:hidden;
        background:linear-gradient(160deg, #15113a 0%, #0d0a26 100%);
        border:1px solid rgba(255,255,255,.08); box-shadow:0 14px 40px -20px rgba(60,40,160,.7);
        transition:transform .3s, box-shadow .3s, border-color .3s; }
    .nx-card:hover { transform:translateY(-3px); border-color:rgba(167,139,250,.35); box-shadow:0 22px 50px -18px rgba(120,90,255,.6); }
    .nx-card-h { padding:18px 24px; border-bottom:1px solid rgba(255,255,255,.07); }
    .nx-card-h h2 { font-size:16px; font-weight:600; color:#fff; }
    .nx-card-h p { font-size:13px; color:#94a3b8; margin-top:4px; }

    .nx-newcard { border:1px solid transparent; background:
        linear-gradient(160deg,#1b1244,#0d0a26) padding-box,
        linear-gradient(120deg, #f472b6, #a78bfa, #fbbf24, #f472b6) border-box;
        background-size:auto, 300% 300%; animation:nx-border 6s linear infinite;
        box-shadow:0 0 60px -14px rgba(244,114,182,.7); }
    @keyframes nx-border { to { background-position:0 0, 300% 0; } }
    .nx-newcard:hover { transform:none; }
    .nx-badge-new { display:inline-flex; align-items:center; gap:6px; padding:3px 10px; border-radius:9999px; font-size:11px; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:#1b1244; background:linear-gradient(90deg,#fbbf24,#f472b6); }
    .nx-bigver { font-size:44px; font-weight:800; line-height:1; color:#fff; text-shadow:0 0 26px rgba(244,114,182,.6); }
    .nx-path { display:flex; align-items:center; gap:12px; margin-top:14px; font-size:13px; color:#cbd5e1; }
    .nx-path .line { position:relative; height:2px; width:90px; background:rgba(255,255,255,.14); overflow:hidden; border-radius:2px; }
    .nx-path .line::after { content:""; position:absolute; top:0; left:-40%; width:40%; height:100%; background:linear-gradient(90deg,transparent,#f472b6,transparent); animation:nx-travel 1.6s linear infinite; }
    @keyframes nx-travel { to { left:100%; } }
    .nx-notes { max-height:260px; overflow:auto; font-size:13px; line-height:1.65; color:#cbd5e1; padding-right:6px; }
    .nx-notes::-webkit-scrollbar { width:6px; } .nx-notes::-webkit-scrollbar-thumb { background:rgba(255,255,255,.18); border-radius:6px; }

    .nx-act { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:600; color:#fff; border:0; cursor:pointer;
        background:linear-gradient(90deg,#a78bfa,#f472b6); transition:transform .2s, box-shadow .2s, filter .2s; box-shadow:0 8px 24px -8px rgba(244,114,182,.7); }
    .nx-act:hover { transform:translateY(-2px); filter:brightness(1.1); }
    .nx-ghost { display:inline-flex; align-items:center; gap:6px; padding:10px 16px; border-radius:10px; font-size:13px; color:#c4b5fd; border:1px solid rgba(196,181,253,.35); transition:background .2s; }
    .nx-ghost:hover { background:rgba(196,181,253,.12); }

    .nx-input { width:100%; border-radius:10px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.16); color:#fff; font-size:13px; padding:10px 14px; font-family:ui-monospace,monospace; outline:none; transition:border-color .2s, box-shadow .2s; }
    .nx-input:focus { border-color:#a78bfa; box-shadow:0 0 0 3px rgba(167,139,250,.25); }
    .nx-input::placeholder { color:#64748b; }
    .nx-lbl { display:block; font-size:13px; font-weight:500; color:#e2e8f0; margin-bottom:6px; }
    .nx-help { font-size:12px; color:#94a3b8; margin-top:6px; }
    .nx-check { accent-color:#a78bfa; width:16px; height:16px; margin-top:2px; }

    /* ---------- TIMELINE ---------- */
    .nx-steps { position:relative; padding:24px 24px 24px 24px; }
    .nx-steps::before { content:""; position:absolute; left:41px; top:34px; bottom:34px; width:2px; background:rgba(255,255,255,.1); }
    .nx-prog { position:absolute; left:41px; top:34px; width:2px; height:0; background:linear-gradient(180deg,#a78bfa,#f472b6); box-shadow:0 0 12px #f472b6; transition:height .5s ease-out; }
    .nx-step { position:relative; display:flex; gap:18px; padding:10px 0; font-size:14px; color:#94a3b8; transition:color .4s; }
    .nx-step .num { position:relative; z-index:1; width:36px; height:36px; flex:none; border-radius:9999px; display:flex; align-items:center; justify-content:center;
        font-size:13px; font-weight:700; background:#15113a; border:1px solid rgba(255,255,255,.18); color:#94a3b8; transition:all .4s; }
    .nx-step.nx-in { color:#e2e8f0; }
    .nx-step.nx-in .num { color:#fff; border-color:#a78bfa; background:linear-gradient(135deg,#7c3aed,#db2777); box-shadow:0 0 22px rgba(167,139,250,.8); }
    .nx-step .t { padding-top:7px; }
    .nx-step .t b { color:#fff; font-weight:600; }
    .nx-cmd { margin-top:10px; border-radius:10px; background:#05040f; border:1px solid rgba(255,255,255,.08); padding:6px; font-family:ui-monospace,monospace; font-size:12px; color:#86efac; }
    .nx-cmd button { display:flex; width:100%; align-items:center; justify-content:space-between; gap:12px; text-align:left; padding:7px 10px; border-radius:7px; background:transparent; border:0; color:inherit; font:inherit; cursor:pointer; transition:background .2s; }
    .nx-cmd button:hover { background:rgba(255,255,255,.07); }
    .nx-cmd button span.cp { font-size:10px; letter-spacing:.12em; text-transform:uppercase; color:#64748b; }
    .nx-cmd button.done span.cp { color:#86efac; }

    /* ---------- REVEAL ---------- */
    .nx-js .nx-reveal { opacity:0; transform:translateY(22px); transition:opacity .7s ease-out, transform .7s ease-out; }
    .nx-js .nx-reveal.nx-in { opacity:1; transform:none; }

    .nx-intro { opacity:0; transform:translateY(12px); animation:nx-intro .9s ease-out forwards; }
    .nx-intro.d1 { animation-delay:.15s; } .nx-intro.d2 { animation-delay:.3s; } .nx-intro.d3 { animation-delay:.45s; } .nx-intro.d4 { animation-delay:.6s; } .nx-intro.d5 { animation-delay:.75s; }
    @keyframes nx-intro { to { opacity:1; transform:none; } }

    @media (max-width:640px) {
        .nx-hero { min-height:560px; padding-top:64px; }
        .nx-altair { width:150px; height:150px; }
        .nx-hint { display:none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nx-hero *, .nx-hero, .nx-card, .nx-newcard, .nx-intro { animation:none !important; }
        .nx-intro { opacity:1; transform:none; }
        .nx-js .nx-reveal { opacity:1; transform:none; }
    }
</style>

<div class="nx-page space-y-6 {{ $hasUpdate ? 'nx-new' : '' }}">

    {{-- ===================== HERO ===================== --}}
    <section id="nxHero" class="nx-hero"
             data-update="{{ $hasUpdate ? '1' : '0' }}"
             data-facts="{{ json_encode($nxFacts, JSON_UNESCAPED_UNICODE) }}"
             data-vega="{{ $nxVega }}"
             data-deneb="{{ $nxDeneb }}">

        <div class="nx-nebula" aria-hidden="true"></div>
        <canvas id="nxCanvas" class="nx-canvas" aria-hidden="true"></canvas>
        <div class="nx-flash" aria-hidden="true"></div>
        <div id="nxFact" class="nx-fact" role="status" aria-live="polite"></div>

        <div id="nxAltair" class="nx-altair nx-intro" title="Altair" aria-label="Altair">
            <div class="nx-glow"></div>
            <div class="nx-ring c"></div>
            <div class="nx-ring b"></div>
            <div class="nx-ring a"></div>
            <div class="nx-rays"></div>
            <div class="nx-rays r2"></div>
            <div class="nx-core"></div>
        </div>

        <div class="nx-content">
            <div class="nx-label nx-intro d1">{{ __('RJ NEXUS CORE 1') }}</div>
            <h1 class="nx-title nx-intro d2">Altair</h1>
            <div class="nx-ver nx-intro d3">RJ CMS <b>v{{ $data['currentVersion'] }}</b></div>

            {{-- Status lives on the hero --}}
            <div class="nx-intro d3">
                @if ($hasUpdate)
                    <div class="nx-status new">
                        <span class="dot"></span>
                        {{ __('Update available') }} · v{{ $release['version'] }}
                        <a href="#nxNewVersion">{{ __('See below') }} ↓</a>
                    </div>
                @elseif ($hasInfo)
                    <div class="nx-status ok">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ __('You are on the latest version') }}
                    </div>
                @else
                    <div class="nx-status none">
                        <span class="dot"></span>
                        {{ __('No update information yet.') }}
                    </div>
                @endif
            </div>

            <div class="nx-chips nx-intro d4">
                <span class="nx-chip">α Aquilae</span>
                <span class="nx-chip">{{ __('Constellation') }}: Aquila</span>
                <span class="nx-chip">16.7 {{ __('light-years') }}</span>
                <span class="nx-chip">{{ __('Spins in ~9 hours') }}</span>
            </div>

            {{-- Check for updates, right over the animation --}}
            <form method="POST" action="{{ route('admin.updates.check') }}" id="nxCheckForm" class="nx-intro d5">
                @csrf
                <button type="submit" id="nxCheckBtn" class="nx-btn">
                    <span class="in">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span id="nxCheckText">{{ __('Check for Updates') }}</span>
                    </span>
                </button>
            </form>

            @if (!empty($data['lastChecked']))
                <div class="nx-checked nx-intro d5">{{ __('Last checked') }}: {{ $data['lastChecked'] }}</div>
            @endif
        </div>

        <div class="nx-hint">✦ {{ __('Click the star') }}</div>
    </section>

    {{-- ===================== NEW VERSION (only when there is one) ===================== --}}
    @if ($hasUpdate)
        <section id="nxNewVersion" class="nx-card nx-newcard nx-reveal">
            <div class="p-6 flex items-start justify-between gap-6 flex-wrap">
                <div class="min-w-0">
                    <span class="nx-badge-new">★ {{ __('New version') }}</span>
                    <div class="nx-bigver mt-3">v{{ $release['version'] }}</div>
                    <div class="mt-2 text-sm text-slate-300">
                        {{ $release['name'] ?? $release['version'] }}
                        @if (!empty($release['published_at']))
                            <span class="text-slate-500"> · {{ \Carbon\Carbon::parse($release['published_at'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="nx-path">
                        <span>v{{ $data['currentVersion'] }}</span>
                        <span class="line"></span>
                        <b class="text-white">v{{ $release['version'] }}</b>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    @if (!empty($release['url']))
                        <a href="{{ $release['url'] }}" target="_blank" rel="noopener" class="nx-ghost">
                            {{ __('View on GitHub') }}
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.updates.run') }}">
                        @csrf
                        <button type="submit" class="nx-act">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            {{ __('Prepare Update') }}
                        </button>
                    </form>
                </div>
            </div>

            @if (!empty($release['body']))
                <div class="px-6 pb-6">
                    <div class="text-xs uppercase tracking-wider text-slate-500 font-medium mb-3">{{ __('Release Notes') }}</div>
                    <div class="nx-notes">{!! nl2br(e($release['body'])) !!}</div>
                </div>
            @endif

            <div class="px-6 py-3 border-t border-white/10 text-xs text-slate-400">
                {{ __('A newer version is available. Follow the installation steps below.') }}
            </div>
        </section>
    @endif

    {{-- ===================== MANUAL STEPS ===================== --}}
    <section class="nx-card nx-reveal">
        <div class="nx-card-h">
            <h2>{{ __('Manual Update Instructions') }}</h2>
            <p>{{ __('Follow these steps to update RJ CMS manually.') }}</p>
        </div>

        <div class="nx-steps" id="nxSteps">
            <div class="nx-prog" id="nxProg"></div>

            <div class="nx-step"><div class="num">1</div>
                <div class="t"><b>{{ __('Backup your site') }}</b> — {{ __('Always backup database and files before updating.') }}</div></div>

            <div class="nx-step"><div class="num">2</div>
                <div class="t"><b>{{ __('Enable maintenance mode') }}</b> — {{ __('Settings → Advanced → Enable maintenance mode.') }}</div></div>

            <div class="nx-step"><div class="num">3</div>
                <div class="t"><b>{{ __('Download the update') }}</b> — {{ __('Get the latest release from GitHub.') }}</div></div>

            <div class="nx-step"><div class="num">4</div>
                <div class="t"><b>{{ __('Replace files') }}</b> — {{ __('Upload new files, keeping .env and storage/ folders.') }}</div></div>

            <div class="nx-step"><div class="num">5</div>
                <div class="t w-full">
                    <b>{{ __('Run commands') }}</b>
                    <div class="nx-cmd">
                        <button type="button" data-copy="composer install --no-dev"><span>composer install --no-dev</span><span class="cp">{{ __('Copy') }}</span></button>
                        <button type="button" data-copy="php artisan migrate --force"><span>php artisan migrate --force</span><span class="cp">{{ __('Copy') }}</span></button>
                        <button type="button" data-copy="php artisan optimize:clear"><span>php artisan optimize:clear</span><span class="cp">{{ __('Copy') }}</span></button>
                    </div>
                </div>
            </div>

            <div class="nx-step"><div class="num">6</div>
                <div class="t"><b>{{ __('Disable maintenance mode') }}</b> — {{ __('Your site is now updated.') }}</div></div>
        </div>
    </section>

</div>

<script>
(function () {
    var hero   = document.getElementById('nxHero');
    var cv     = document.getElementById('nxCanvas');
    if (!hero || !cv || !cv.getContext) return;

    var ctx     = cv.getContext('2d');
    var star    = document.getElementById('nxAltair');
    var factEl  = document.getElementById('nxFact');
    var reduce  = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var hasUpd  = hero.dataset.update === '1';
    var facts   = [];
    try { facts = JSON.parse(hero.dataset.facts || '[]'); } catch (e) {}
    var factIdx = 0, clicks = 0, factTimer = null;

    var colors = hasUpd ? ['#ffffff', '#f9a8d4', '#fde68a', '#c4b5fd'] : ['#ffffff', '#c4b5fd', '#93c5fd', '#f9a8d4'];

    var W = 0, H = 0, dpr = 1, t = 0, mx = 0, my = 0, tmx = 0, tmy = 0;
    var stars = [], parts = [], rings = [], shoots = [], nodes = [];
    var running = true, visible = true, lastShoot = 0;

    function rand(a, b) { return a + Math.random() * (b - a); }

    function resize() {
        var r = hero.getBoundingClientRect();
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        W = r.width; H = r.height;
        cv.width = W * dpr; cv.height = H * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        var n = Math.round(Math.min(260, Math.max(110, W * H / 2600)));
        stars = [];
        for (var i = 0; i < n; i++) {
            stars.push({ x: Math.random(), y: Math.random(), z: rand(.15, 1), r: rand(.4, 1.6), sp: rand(.6, 2.6), ph: rand(0, 6.28), c: Math.random() < .12 ? colors[(Math.random() * colors.length) | 0] : '#ffffff' });
        }
    }

    function starCenter() {
        var hr = hero.getBoundingClientRect(), sr = star.getBoundingClientRect();
        return { x: sr.left - hr.left + sr.width / 2, y: sr.top - hr.top + sr.height / 2, r: sr.width / 2 };
    }

    function layoutNodes() {
        var c = starCenter();
        if (W < 720) { nodes = []; return c; }
        nodes = [
            { name: 'Vega',  x: Math.max(60, c.x - W * .27),        y: Math.min(H - 60, c.y + H * .10), msg: hero.dataset.vega,  hot: 0 },
            { name: 'Deneb', x: Math.min(W - 60, c.x + W * .29),    y: Math.min(H - 60, c.y + H * .20), msg: hero.dataset.deneb, hot: 0 }
        ];
        return c;
    }

    function burst(x, y, n, power) {
        for (var i = 0; i < n; i++) {
            var a = rand(0, 6.283), s = rand(.4, 1) * power;
            parts.push({ x: x, y: y, vx: Math.cos(a) * s, vy: Math.sin(a) * s, life: 0, max: rand(50, 110), r: rand(.8, 2.4), c: colors[(Math.random() * colors.length) | 0] });
        }
        if (parts.length > 700) parts.splice(0, parts.length - 700);
    }
    function ring(x, y, max, speed, col) { rings.push({ x: x, y: y, r: 6, max: max, sp: speed, c: col || 'rgba(196,181,253,' }); }

    function showFact(text) {
        if (!text) return;
        factEl.innerHTML = '<i>✦</i>' + text.replace(/</g, '&lt;');
        factEl.classList.add('show');
        clearTimeout(factTimer);
        factTimer = setTimeout(function () { factEl.classList.remove('show'); }, 6500);
    }

    function supernova(c) {
        clicks++;
        burst(c.x, c.y, 170, 4.2);
        ring(c.x, c.y, Math.max(W, H) * .8, 7, 'rgba(255,255,255,');
        ring(c.x, c.y, Math.max(W, H) * .6, 5, hasUpd ? 'rgba(244,114,182,' : 'rgba(167,139,250,');
        ring(c.x, c.y, Math.max(W, H) * .45, 3.4, 'rgba(147,197,253,');
        hero.classList.remove('nx-boom'); void hero.offsetWidth; hero.classList.add('nx-boom');
        star.classList.add('nx-hyper');
        setTimeout(function () { star.classList.remove('nx-hyper'); }, 2200);
        if (clicks % 7 === 0) {
            showFact('Nexus Core engaged. ★ Altair rises.');
        } else {
            showFact(facts[factIdx % facts.length]); factIdx++;
        }
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
            if (s.r > 1.35 && a > .8) {
                ctx.globalAlpha = a * .35; ctx.strokeStyle = s.c; ctx.lineWidth = .6;
                ctx.beginPath(); ctx.moveTo(px - 5, py); ctx.lineTo(px + 5, py); ctx.moveTo(px, py - 5); ctx.lineTo(px, py + 5); ctx.stroke();
            }
        }
        ctx.globalAlpha = 1;
    }

    function drawConstellation(c) {
        if (!nodes.length) return;
        ctx.save();
        ctx.setLineDash([6, 8]); ctx.lineDashOffset = -t * 14; ctx.lineWidth = 1;
        ctx.strokeStyle = 'rgba(190,210,255,.28)';
        ctx.beginPath();
        ctx.moveTo(c.x, c.y); ctx.lineTo(nodes[0].x, nodes[0].y);
        ctx.lineTo(nodes[1].x, nodes[1].y); ctx.lineTo(c.x, c.y);
        ctx.stroke();
        ctx.restore();
        for (var i = 0; i < nodes.length; i++) {
            var n = nodes[i];
            n.hot += ((n.near ? 1 : 0) - n.hot) * .12;
            var tw = .6 + .4 * Math.sin(t * 2 + i);
            ctx.globalAlpha = tw; ctx.fillStyle = '#dbe6ff';
            ctx.shadowColor = '#b4c8ff'; ctx.shadowBlur = 10 + n.hot * 16;
            ctx.beginPath(); ctx.arc(n.x, n.y, 2.6 + n.hot * 2, 0, 6.283); ctx.fill();
            ctx.shadowBlur = 0; ctx.globalAlpha = .45 + n.hot * .55;
            ctx.fillStyle = '#cfdcff'; ctx.font = '600 10px system-ui, sans-serif';
            ctx.fillText(n.name.toUpperCase(), n.x + 10, n.y + 3);
            ctx.globalAlpha = 1;
        }
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
        var c = layoutNodes();
        drawStars(); drawConstellation(c); drawShoots(); drawFx();
        if (!reduce) requestAnimationFrame(frame);
    }

    function start() { if (!running && visible && !document.hidden) { running = true; requestAnimationFrame(frame); } }
    function stop()  { running = false; }

    // pointer: parallax + hover on nodes/star
    hero.addEventListener('mousemove', function (e) {
        var r = hero.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top;
        tmx = (x / W - .5) * 2; tmy = (y / H - .5) * 2;
        var c = starCenter(), overStar = Math.hypot(x - c.x, y - c.y) < c.r * .55, overNode = false;
        for (var i = 0; i < nodes.length; i++) { nodes[i].near = Math.hypot(x - nodes[i].x, y - nodes[i].y) < 26; if (nodes[i].near) overNode = true; }
        hero.style.cursor = (overStar || overNode) ? 'pointer' : 'crosshair';
    });
    hero.addEventListener('mouseleave', function () { tmx = 0; tmy = 0; for (var i = 0; i < nodes.length; i++) nodes[i].near = false; });

    // click: star = supernova, node = fact, anywhere = star burst
    hero.addEventListener('click', function (e) {
        if (e.target.closest('button, a, form, input')) return;
        var r = hero.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top, c = starCenter();
        if (Math.hypot(x - c.x, y - c.y) < c.r * .6) { supernova(c); }
        else {
            for (var i = 0; i < nodes.length; i++) {
                if (Math.hypot(x - nodes[i].x, y - nodes[i].y) < 28) { burst(nodes[i].x, nodes[i].y, 50, 2.6); ring(nodes[i].x, nodes[i].y, 120, 3, 'rgba(147,197,253,'); showFact(nodes[i].msg); return; }
            }
            burst(x, y, 36, 2.4); ring(x, y, 70, 2.2, hasUpd ? 'rgba(244,114,182,' : 'rgba(196,181,253,');
        }
        if (reduce) { ctx.clearRect(0, 0, W, H); drawStars(); }
    });

    // touch parallax (gentle)
    hero.addEventListener('touchmove', function (e) {
        var tch = e.touches[0]; if (!tch) return;
        var r = hero.getBoundingClientRect();
        tmx = ((tch.clientX - r.left) / W - .5) * 2; tmy = ((tch.clientY - r.top) / H - .5) * 2;
    }, { passive: true });

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (en) { visible = en[0].isIntersecting; visible ? start() : stop(); }, { threshold: .05 }).observe(hero);
    }
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
    window.addEventListener('resize', function () { resize(); });

    resize();
    requestAnimationFrame(frame);

    // "Check for updates" button: scanning state + hyperdrive on submit
    var form = document.getElementById('nxCheckForm'), btn = document.getElementById('nxCheckBtn'), txt = document.getElementById('nxCheckText');
    if (form) form.addEventListener('submit', function () {
        btn.classList.add('nx-loading');
        if (txt) txt.textContent = @json(__('Scanning the stars...'));
        star.classList.add('nx-hyper');
        var c = starCenter(); burst(c.x, c.y, 90, 3.4); ring(c.x, c.y, Math.max(W, H) * .6, 5, 'rgba(255,255,255,');
    });

    // ---------- reveal on scroll + timeline progress ----------
    var reveals = document.querySelectorAll('.nx-reveal');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (en) {
            en.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('nx-in'); io.unobserve(x.target); } });
        }, { threshold: .12 });
        reveals.forEach(function (el) { io.observe(el); });
    } else { reveals.forEach(function (el) { el.classList.add('nx-in'); }); }

    var steps = document.querySelectorAll('#nxSteps .nx-step'), prog = document.getElementById('nxProg');
    function updSteps() {
        var lit = 0, wrap = document.getElementById('nxSteps');
        if (!wrap) return;
        var line = window.innerHeight * .78;
        steps.forEach(function (s, i) {
            if (s.getBoundingClientRect().top < line) { s.classList.add('nx-in'); lit = i + 1; } else { s.classList.remove('nx-in'); }
        });
        if (lit > 0 && prog) {
            var first = steps[0].querySelector('.num').offsetTop + 18, last = steps[lit - 1].querySelector('.num').offsetTop + 18;
            prog.style.top = first + 'px'; prog.style.height = (last - first) + 'px';
        } else if (prog) { prog.style.height = '0'; }
    }
    window.addEventListener('scroll', updSteps, { passive: true }); window.addEventListener('resize', updSteps); updSteps();
    var sc = document.querySelector('main, .overflow-y-auto'); if (sc) sc.addEventListener('scroll', updSteps, { passive: true });

    // ---------- click-to-copy commands ----------
    document.querySelectorAll('.nx-cmd button').forEach(function (b) {
        b.addEventListener('click', function () {
            var text = b.getAttribute('data-copy'), label = b.querySelector('.cp');
            function done() {
                b.classList.add('done'); var old = label.textContent; label.textContent = @json(__('Copied'));
                setTimeout(function () { b.classList.remove('done'); label.textContent = old; }, 1400);
            }
            if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(text).then(done, done); }
            else { var ta = document.createElement('textarea'); ta.value = text; document.body.appendChild(ta); ta.select(); try { document.execCommand('copy'); } catch (e) {} document.body.removeChild(ta); done(); }
        });
    });
})();
</script>
@endsection
