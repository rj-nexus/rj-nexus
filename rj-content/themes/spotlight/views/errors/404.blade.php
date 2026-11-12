@extends('theme::layout')

@section('content')

<main class="rj-404-main" id="rj-404">
    <div class="rj-404-bg" aria-hidden="true">
        <div class="rj-404-glow"></div>
        <div class="rj-404-cursor"></div>
        @for($i = 0; $i < 28; $i++)
            <span class="rj-404-dot" style="left: {{ mt_rand(0, 100) }}%; --s: {{ mt_rand(2, 4) }}px; --d: {{ mt_rand(9, 20) }}s; --delay: -{{ mt_rand(0, 20) }}s; --o: {{ mt_rand(25, 70) / 100 }};"></span>
        @endfor
    </div>

    <div class="rj-404-inner">
        <div class="rj-404-code" aria-label="404">
            <span class="rj-404-digit" style="--n: 0;">4</span>
            <span class="rj-404-digit rj-404-zero" style="--n: 1;">
                <i class="rj-404-orbit rj-404-orbit-a"></i>
                <i class="rj-404-orbit rj-404-orbit-b"></i>
                <i class="rj-404-core"></i>
            </span>
            <span class="rj-404-digit" style="--n: 2;">4</span>
        </div>

        <h2 class="rj-404-title rj-404-rise" style="--n: 3;">{{ __('Page not found') }}</h2>
        <p class="rj-404-desc rj-404-rise" style="--n: 4;">
            {{ __('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.') }}
        </p>

        <div class="rj-404-actions rj-404-rise" style="--n: 5;">
            <a href="{{ url('/') }}" class="rj-404-btn rj-404-btn-main">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                {{ __('Back to Home') }}
            </a>
            <a href="javascript:history.back()" class="rj-404-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/></svg>
                {{ __('Go Back') }}
            </a>
        </div>
    </div>
</main>

<style>
    .rj-404-main {
        --mx: 50%;
        --my: 50%;
        position: relative;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 120px 24px;
        overflow: hidden;
        isolation: isolate;
    }

    .rj-404-bg {
        position: absolute;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        overflow: hidden;
    }

    .rj-404-glow {
        position: absolute;
        width: 800px;
        height: 800px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 60%);
        animation: rj404Pulse 4s ease-in-out infinite alternate;
    }

    .rj-404-cursor {
        position: absolute;
        inset: 0;
        background: radial-gradient(420px circle at var(--mx) var(--my), rgba(59, 130, 246, 0.04), transparent 65%);
        transition: background 0.1s;
    }

    .rj-404-dot {
        position: absolute;
        bottom: -10px;
        width: var(--s);
        height: var(--s);
        border-radius: 50%;
        background: #fff;
        opacity: 0;
        animation: rj404Float var(--d) linear var(--delay) infinite;
    }

    .rj-404-inner {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 640px;
    }

    .rj-404-code {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: clamp(4px, 1.5vw, 14px);
        margin: 0 0 28px;
        perspective: 900px;
        transform: rotateX(var(--ry, 0deg)) rotateY(var(--rx, 0deg));
        transition: transform 0.25s ease-out;
    }

    .rj-404-digit {
        position: relative;
        display: inline-block;
        font-size: clamp(100px, 16vw, 190px);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.05em;
        background: linear-gradient(180deg, #ffffff 0%, #7c8aa3 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 0 28px rgba(255, 255, 255, 0.18));
        opacity: 0;
        animation: rj404Drop 0.9s cubic-bezier(0.2, 0.9, 0.3, 1.2) calc(var(--n) * 0.14s + 0.1s) forwards;
    }

    .rj-404-zero {
        width: 0.78em;
        height: 0.78em;
        -webkit-text-fill-color: initial;
        background: none;
        filter: none;
    }

    .rj-404-core {
        position: absolute;
        inset: 28%;
        border-radius: 50%;
        background: #000;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.85), 0 0 40px 6px rgba(59, 130, 246, 0.4);
    }

    .rj-404-orbit {
        position: absolute;
        border-radius: 50%;
        border: 3px solid transparent;
    }

    .rj-404-orbit-a {
        inset: 0;
        border-top-color: #fff;
        border-right-color: rgba(255, 255, 255, 0.25);
        animation: rj404Spin 3.2s linear infinite;
    }

    .rj-404-orbit-b {
        inset: 10%;
        border-bottom-color: #3b82f6;
        border-left-color: rgba(59, 130, 246, 0.2);
        animation: rj404Spin 2s linear infinite reverse;
    }

    .rj-404-rise {
        opacity: 0;
        transform: translateY(18px);
        animation: rj404Rise 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) calc(var(--n) * 0.14s + 0.1s) forwards;
    }

    .rj-404-title {
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 500;
        color: #fff;
        margin: 0 0 16px;
        letter-spacing: -0.02em;
    }

    .rj-404-desc {
        font-size: 16px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.6);
        margin: 0 auto 40px;
        max-width: 480px;
    }

    .rj-404-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Şəffaf arxa plan, mavi kənar və mətn */
    .rj-404-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.03); /* Çox açıq mavi şüşə fon */
        border: 1px solid rgba(59, 130, 246, 0.3); /* Mavi kənar */
        color: #60a5fa; /* Mavi mətn */
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
        transition: background 0.25s, border-color 0.25s, transform 0.25s, box-shadow 0.25s, color 0.25s;
    }

    .rj-404-btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: -80%;
        width: 50%;
        height: 100%;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }

    .rj-404-btn:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.8);
        color: #93c5fd;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -8px rgba(59, 130, 246, 0.4);
    }

    .rj-404-btn:hover::after { left: 130%; }

    /* Əsas düymə daha qabarıq, amma hələ də şəffaf */
    .rj-404-btn-main {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.5);
        color: #fff;
    }

    .rj-404-btn-main:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        box-shadow: 0 12px 26px -12px rgba(59, 130, 246, 0.6);
    }

    .rj-404-btn svg {
        width: 18px;
        height: 18px;
        flex: none;
    }

    @keyframes rj404Pulse {
        from { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
        to { opacity: 1; transform: translate(-50%, -50%) scale(1.1); }
    }

    @keyframes rj404Float {
        0% { transform: translateY(0); opacity: 0; }
        10% { opacity: var(--o); }
        90% { opacity: var(--o); }
        100% { transform: translateY(-105vh); opacity: 0; }
    }

    @keyframes rj404Drop {
        from { opacity: 0; transform: translateY(-60px) scale(0.9); filter: blur(10px); }
        to { opacity: 1; transform: none; filter: blur(0); }
    }

    @keyframes rj404Rise {
        to { opacity: 1; transform: none; }
    }

    @keyframes rj404Spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 640px) {
        .rj-404-main { padding: 80px 20px; min-height: 60vh; }
        .rj-404-btn { width: 100%; }
        .rj-404-actions { flex-direction: column; }
    }

    @media (prefers-reduced-motion: reduce) {
        .rj-404-dot, .rj-404-glow, .rj-404-orbit { animation: none; }
        .rj-404-digit, .rj-404-rise { animation-duration: 0.01s; animation-delay: 0s; }
    }
</style>

<script>
(function () {
    var main = document.getElementById('rj-404');
    if (!main) return;
    var code = main.querySelector('.rj-404-code');

    main.addEventListener('pointermove', function (e) {
        var r = main.getBoundingClientRect();
        var x = e.clientX - r.left;
        var y = e.clientY - r.top;
        main.style.setProperty('--mx', x + 'px');
        main.style.setProperty('--my', y + 'px');
        code.style.setProperty('--rx', ((x / r.width - 0.5) * 14) + 'deg');
        code.style.setProperty('--ry', ((0.5 - y / r.height) * 10) + 'deg');
    });

    main.addEventListener('pointerleave', function () {
        code.style.setProperty('--rx', '0deg');
        code.style.setProperty('--ry', '0deg');
    });
})();
</script>

@endsection