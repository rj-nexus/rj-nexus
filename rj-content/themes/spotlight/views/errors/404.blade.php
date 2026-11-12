@extends('theme::layout')

@section('content')

<main class="rj-404-main">
    <div class="rj-404-bg" aria-hidden="true">
        <div class="rj-404-glow"></div>
    </div>
    
    <div class="rj-404-inner">
        <h1 class="rj-404-code">404</h1>
        <h2 class="rj-404-title">{{ __('Page not found') }}</h2>
        <p class="rj-404-desc">
            {{ __('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.') }}
        </p>
        
        <a href="{{ url('/') }}" class="rj-404-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            {{ __('Back to Home') }}
        </a>
    </div>
</main>

<style>
    .rj-404-main {
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
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .rj-404-glow {
        position: absolute;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 60%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: rj404Pulse 4s ease-in-out infinite alternate;
    }

    .rj-404-inner {
        text-align: center;
        max-width: 600px;
        position: relative;
        z-index: 1;
    }

    .rj-404-code {
        font-size: clamp(100px, 15vw, 180px);
        font-weight: 800;
        line-height: 1;
        margin: 0 0 24px;
        letter-spacing: -0.05em;
        background: linear-gradient(180deg, #ffffff 0%, #94a3b8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 0 30px rgba(255, 255, 255, 0.2));
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

    .rj-404-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.25s ease;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .rj-404-btn:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.4);
    }

    .rj-404-btn svg {
        width: 18px;
        height: 18px;
    }

    @keyframes rj404Pulse {
        from { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
        to { opacity: 1; transform: translate(-50%, -50%) scale(1.1); }
    }

    @media (max-width: 640px) {
        .rj-404-main { padding: 80px 20px; min-height: 60vh; }
        .rj-404-btn { width: 100%; }
    }
</style>

@endsection