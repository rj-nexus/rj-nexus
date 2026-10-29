@extends('admin.layouts.app')

@section('title', __('RJ AI Assistant'))

@section('content')
@php
    $statsData = [
        'posts'    => (int) ($stats['posts'] ?? 0),
        'pages'    => (int) ($stats['pages'] ?? 0),
        'users'    => (int) ($stats['users'] ?? 0),
        'comments' => (int) ($stats['comments'] ?? 0),
        'media'    => (int) ($stats['media'] ?? 0),
    ];

    $quick = [
        ['key' => 'posts', 'q' => __('How many posts do I have?'), 'label' => __('Posts'), 'color' => '#6366f1', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z'],
        ['key' => 'pages', 'q' => __('How many pages do I have?'), 'label' => __('Pages'), 'color' => '#10b981', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['key' => 'users', 'q' => __('How many users are there?'), 'label' => __('Users'), 'color' => '#3b82f6', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['key' => 'comments', 'q' => __('How many comments do I have?'), 'label' => __('Comments'), 'color' => '#f59e0b', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
        ['key' => 'media', 'q' => __('How many media files do I have?'), 'label' => __('Media'), 'color' => '#a855f7', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['key' => 'overview', 'q' => __('Give me an overview of my site.'), 'label' => __('Site Overview'), 'color' => '#f43f5e', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
    ];

    $T = [
        'posts'    => __('You have :count posts on your site.'),
        'pages'    => __('You have :count pages on your site.'),
        'users'    => __('There are :count registered users.'),
        'comments' => __('You have :count comments in total.'),
        'media'    => __('There are :count files in the media library.'),
        'overview' => __('Site Overview:'),
        'lPosts'    => __('Posts'),
        'lPages'    => __('Pages'),
        'lUsers'    => __('Users'),
        'lComments' => __('Comments'),
        'lMedia'    => __('Media'),
        'error'    => __('An error occurred.'),
        'network'  => __('Network error. Check your connection.'),
        'online'   => __('Online & Ready to help'),
        'thinking' => __('Thinking...'),
        'typing'   => __('Writing...'),
        'all'      => __('All stats'),
        'copy'     => __('Copy'),
        'copied'   => __('Copied'),
        'retry'    => __('Regenerate'),
        'stop'     => __('Stop'),
        'status'   => [__('Reading your question...'), __('Checking site data...'), __('Preparing the answer...')],
    ];

    $sparkle = 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z';
    $orb = fn (int $s, bool $live = false) => '<span class="rjai-orb' . ($live ? ' live' : '') . '" style="--s:' . $s . 'px"><i></i><b></b><em></em><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="' . $sparkle . '"/></svg></span>';
@endphp

<style>
    [x-cloak] { display: none !important; }

    @property --rjai-a {
        syntax: '<angle>';
        inherits: false;
        initial-value: 0deg;
    }

    .rjai {
        --mx: 0;
        --my: 0;
        position: relative;
        isolation: isolate;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 8rem);
        height: calc(100dvh - 8rem);
        min-height: 480px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 24px 60px -34px rgba(15, 23, 42, .35);
    }
    .rjai-bg { position: absolute; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
    .rjai-bg i { position: absolute; border-radius: 50%; filter: blur(70px); animation: rjai-drift 16s ease-in-out infinite alternate; }
    .rjai-bg i:nth-child(1) { top: -120px; left: -80px; width: 340px; height: 340px; background: rgba(34, 197, 94, .16); }
    .rjai-bg i:nth-child(2) { right: -100px; bottom: 60px; width: 380px; height: 380px; background: rgba(139, 92, 246, .13); animation-delay: -6s; }
    .rjai-bg i:nth-child(3) { top: 40%; left: 45%; width: 260px; height: 260px; background: rgba(34, 211, 238, .12); animation-delay: -11s; }

    .rjai-orb {
        position: relative;
        isolation: isolate;
        display: inline-grid;
        place-items: center;
        flex-shrink: 0;
        width: var(--s, 40px);
        height: var(--s, 40px);
    }
    .rjai-orb::before {
        content: "";
        position: absolute;
        inset: -16%;
        z-index: -2;
        border-radius: 50%;
        background: conic-gradient(from var(--rjai-a), #22c55e, #22d3ee, #8b5cf6, #22c55e);
        filter: blur(calc(var(--s, 40px) * .3));
        opacity: .5;
        animation: rjai-ang 6s linear infinite;
    }
    .rjai-orb i {
        position: absolute;
        inset: 0;
        z-index: -1;
        border-radius: 50%;
        background: conic-gradient(from var(--rjai-a), #16a34a, #22c55e, #22d3ee, #3b82f6, #8b5cf6, #16a34a);
        box-shadow: inset 0 0 calc(var(--s, 40px) * .25) rgba(255, 255, 255, .4);
        animation: rjai-ang 5s linear infinite;
    }
    .rjai-orb b {
        position: absolute;
        inset: 8%;
        border-radius: 50%;
        background: radial-gradient(circle at calc(50% + var(--mx) * 16%) calc(34% + var(--my) * 16%), rgba(255, 255, 255, .85), rgba(255, 255, 255, .12) 52%, transparent 68%);
    }
    .rjai-orb em {
        position: absolute;
        inset: 0;
        border: 2px solid #22c55e;
        border-radius: 50%;
        opacity: 0;
        pointer-events: none;
    }
    .rjai-orb svg { position: relative; width: 46%; height: 46%; filter: drop-shadow(0 1px 3px rgba(0, 0, 0, .25)); animation: rjai-spark 2.6s ease-in-out infinite; }
    .rjai-orb.live { animation: rjai-breathe 4s ease-in-out infinite; }
    .rjai[data-state="thinking"] .rjai-orb.live { animation: rjai-think .9s ease-in-out infinite; }
    .rjai[data-state="thinking"] .rjai-orb.live i { animation-duration: 1.1s; }
    .rjai[data-state="speaking"] .rjai-orb.live { animation: rjai-talk .5s ease-in-out infinite alternate; }
    .rjai[data-state="thinking"] .rjai-orb.live em,
    .rjai[data-state="speaking"] .rjai-orb.live em { animation: rjai-ring 1.4s ease-out infinite; }

    .rjai-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-bottom: 1px solid rgba(226, 232, 240, .8);
        background: rgba(255, 255, 255, .72);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
    .rjai-ht { flex: 1; min-width: 0; }
    .rjai-ht h2 { margin: 0; font-size: 17px; font-weight: 800; line-height: 1.2; color: #0f172a; }
    .rjai-st { display: flex; align-items: center; gap: 7px; margin: 2px 0 0; color: #64748b; font-size: 12px; }
    .rjai-st i { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; animation: rjai-dot 2s ease-out infinite; }
    .rjai[data-state="thinking"] .rjai-st i { background: #f59e0b; }
    .rjai[data-state="speaking"] .rjai-st i { background: #3b82f6; }
    .rjai-clear {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #64748b;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, color .2s;
    }
    .rjai-clear:hover { background: #fef2f2; color: #dc2626; }
    .rjai-clear svg { width: 16px; height: 16px; }

    .rjai-body { flex: 1; overflow-y: auto; padding: 22px 18px; overscroll-behavior: contain; }
    .rjai-wrap { max-width: 780px; margin: 0 auto; }

    .rjai-welcome { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100%; padding: 8px 0; text-align: center; }
    .rjai-welcome .rjai-orb { margin-bottom: 26px; animation-name: rjai-breathe; }
    .rjai-title {
        margin: 0 0 8px;
        font-size: clamp(24px, 4vw, 34px);
        font-weight: 800;
        letter-spacing: -.02em;
        background: linear-gradient(90deg, #16a34a, #22c55e, #3b82f6, #8b5cf6, #16a34a);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rjai-up .6s cubic-bezier(.22, 1, .36, 1) both, rjai-flow 6s linear infinite;
    }
    .rjai-sub { max-width: 460px; margin: 0 0 28px; color: #64748b; font-size: 14px; line-height: 1.6; animation: rjai-up .6s .1s cubic-bezier(.22, 1, .36, 1) both; }

    .rjai-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; width: 100%; max-width: 640px; }
    .rjai-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        overflow: hidden;
        padding: 16px;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: rgba(255, 255, 255, .85);
        font: inherit;
        text-align: start;
        cursor: pointer;
        opacity: 0;
        animation: rjai-up .5s cubic-bezier(.22, 1, .36, 1) forwards;
        animation-delay: calc(.2s + var(--d, 0ms));
        transition: transform .2s, box-shadow .2s, border-color .2s;
        -webkit-tap-highlight-color: transparent;
    }
    .rjai-card::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 0 0, color-mix(in srgb, var(--c) 18%, transparent), transparent 60%);
        opacity: 0;
        transition: opacity .25s;
    }
    .rjai-card:hover { transform: translateY(-3px); border-color: var(--c); box-shadow: 0 14px 28px -14px var(--c); }
    .rjai-card:hover::after { opacity: 1; }
    .rjai-card:active { transform: scale(.97); }
    .rjai-card:disabled { opacity: .6; cursor: wait; }
    .rjai-card-ic {
        position: relative;
        z-index: 1;
        display: grid;
        place-items: center;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: color-mix(in srgb, var(--c) 14%, #fff);
        color: var(--c);
        transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
    }
    .rjai-card:hover .rjai-card-ic { transform: scale(1.12) rotate(-6deg); }
    .rjai-card-ic svg { width: 18px; height: 18px; }
    .rjai-card-tx { position: relative; z-index: 1; display: block; min-width: 0; }
    .rjai-card-tx small { display: block; color: #64748b; font-size: 12px; font-weight: 600; }
    .rjai-card-tx b { display: block; margin-top: 2px; color: #0f172a; font-size: 22px; font-weight: 800; line-height: 1.15; font-variant-numeric: tabular-nums; }
    .rjai-card.is-wide .rjai-card-tx b { font-size: 15px; }

    .rjai-list > * + * { margin-top: 20px; }
    .rjai-msg { display: flex; gap: 10px; animation: rjai-msg .35s cubic-bezier(.22, 1, .36, 1) both; }
    .rjai-msg.is-user { flex-direction: row-reverse; }
    .rjai-av { flex-shrink: 0; margin-top: 2px; }
    .rjai-av.user { display: grid; place-items: center; width: 30px; height: 30px; border: 1px solid #e5e7eb; border-radius: 50%; background: #f3f4f6; color: #6b7280; }
    .rjai-av.user svg { width: 15px; height: 15px; }
    .rjai-col { min-width: 0; max-width: min(86%, 640px); }
    .rjai-bub {
        padding: 12px 16px;
        border: 1px solid #d1fae5;
        border-radius: 4px 18px 18px 18px;
        background: rgba(255, 255, 255, .92);
        color: #1f2937;
        font-size: 15px;
        line-height: 1.65;
        box-shadow: 0 6px 16px -12px rgba(15, 23, 42, .3);
        overflow-wrap: anywhere;
    }
    .is-user .rjai-bub {
        border-color: transparent;
        border-radius: 18px 4px 18px 18px;
        background: linear-gradient(135deg, #16a34a, #0ea5e9);
        color: #fff;
    }
    .rjai-bub.is-typing > div::after {
        content: "";
        display: inline-block;
        width: 2px;
        height: 1em;
        margin-inline-start: 2px;
        vertical-align: -2px;
        background: #22c55e;
        animation: rjai-caret .8s step-end infinite;
    }
    .rjai-bub p { margin: 0 0 8px; }
    .rjai-bub p:last-child { margin-bottom: 0; }
    .rjai-bub ul, .rjai-bub ol { margin: 6px 0 8px; padding-inline-start: 22px; }
    .rjai-bub li { margin: 3px 0; }
    .rjai-bub a { color: #16a34a; font-weight: 600; text-decoration: underline; }
    .rjai-bub code { padding: 1px 6px; border-radius: 6px; background: #f1f5f9; font-size: 13px; }
    .rjai-bub pre { margin: 8px 0; padding: 12px; overflow-x: auto; border-radius: 12px; background: #0f172a; color: #e2e8f0; font-size: 13px; }
    .rjai-bub pre code { padding: 0; background: transparent; color: inherit; }

    .rjai-chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .rjai-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 11px;
        border: 1px solid color-mix(in srgb, var(--c) 30%, #fff);
        border-radius: 10px;
        background: color-mix(in srgb, var(--c) 10%, #fff);
        color: color-mix(in srgb, var(--c) 82%, #000);
        font-size: 12.5px;
        font-weight: 700;
    }

    .rjai-act { display: flex; gap: 6px; margin-top: 6px; }
    .rjai-act button {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #94a3b8;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s, color .15s;
    }
    .rjai-act button:hover { background: #ecfdf5; color: #16a34a; }
    .rjai-act svg { width: 14px; height: 14px; }

    .rjai-think { display: flex; align-items: flex-start; gap: 12px; animation: rjai-msg .35s ease both; }
    .rjai-think-b { flex: 1; max-width: 420px; padding-top: 4px; }
    .rjai-think-t { display: block; min-height: 20px; margin-bottom: 10px; color: #16a34a; font-size: 13px; font-weight: 700; animation: rjai-fade .4s ease both; }
    .rjai-line {
        height: 10px;
        margin-top: 8px;
        border-radius: 999px;
        background: linear-gradient(90deg, #f3f4f6 0%, #bbf7d0 20%, #dcfce7 40%, #f3f4f6 60%);
        background-size: 800px 100%;
        animation: rjai-shimmer 1.4s linear infinite;
    }

    .rjai-foot { padding: 12px 18px 14px; border-top: 1px solid rgba(226, 232, 240, .8); background: rgba(255, 255, 255, .78); -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px); }
    .rjai-follow { display: flex; gap: 8px; max-width: 780px; margin: 0 auto 10px; overflow-x: auto; padding-bottom: 2px; scrollbar-width: none; }
    .rjai-follow::-webkit-scrollbar { display: none; }
    .rjai-fc {
        flex-shrink: 0;
        padding: 6px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        background: #fff;
        color: #475569;
        font: inherit;
        font-size: 12.5px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
        transition: border-color .15s, color .15s, transform .15s;
    }
    .rjai-fc:hover { border-color: #22c55e; color: #16a34a; transform: translateY(-1px); }

    .rjai-box {
        position: relative;
        isolation: isolate;
        display: flex;
        align-items: flex-end;
        gap: 8px;
        max-width: 780px;
        margin: 0 auto;
        padding: 6px 6px 6px 16px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 8px 22px -14px rgba(15, 23, 42, .35);
    }
    .rjai-box::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        border-radius: inherit;
        background: #d1d5db;
        transition: opacity .25s;
    }
    .rjai-box::after {
        content: "";
        position: absolute;
        inset: -1.5px;
        z-index: -2;
        border-radius: 21px;
        background: conic-gradient(from var(--rjai-a), #22c55e, #22d3ee, #8b5cf6, #ec4899, #22c55e);
        opacity: 0;
        animation: rjai-ang 4s linear infinite;
        transition: opacity .25s;
    }
    .rjai-box:focus-within::after { opacity: 1; }
    .rjai-box:focus-within { box-shadow: 0 14px 30px -14px rgba(34, 197, 94, .55); }
    .rjai-box-in { position: absolute; inset: 1px; z-index: -1; border-radius: 19px; background: #fff; }
    .rjai-field {
        flex: 1;
        min-width: 0;
        max-height: 140px;
        padding: 10px 0 !important;
        border: 0 !important;
        outline: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        color: #0f172a;
        font: inherit;
        font-size: 15px;
        line-height: 1.5;
        resize: none;
    }
    .rjai-field::placeholder { color: #94a3b8; }
    .rjai-send {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 42px;
        height: 42px;
        border: 0;
        border-radius: 14px;
        background: linear-gradient(135deg, #16a34a, #22c55e 55%, #0ea5e9);
        color: #fff;
        cursor: pointer;
        box-shadow: 0 10px 18px -10px #16a34a;
        transition: transform .15s, opacity .2s;
        -webkit-tap-highlight-color: transparent;
    }
    .rjai-send:hover { transform: scale(1.06); }
    .rjai-send:active { transform: scale(.94); }
    .rjai-send:disabled { opacity: .45; cursor: not-allowed; transform: none; }
    .rjai-send.is-stop { background: linear-gradient(135deg, #475569, #0f172a); box-shadow: 0 10px 18px -10px #0f172a; }
    .rjai-send svg { width: 20px; height: 20px; }
    .rjai-note { margin: 8px 0 0; color: #94a3b8; font-size: 11px; text-align: center; }

    @media (max-width: 640px) {
        .rjai { height: calc(100vh - 7.5rem); height: calc(100dvh - 7.5rem); border-radius: 16px; }
        .rjai-head { padding: 10px 12px; gap: 10px; }
        .rjai-ht h2 { font-size: 15px; }
        .rjai-clear span { display: none; }
        .rjai-clear { padding: 8px; }
        .rjai-body { padding: 14px 12px; }
        .rjai-welcome .rjai-orb { --s: 84px !important; margin-bottom: 18px; }
        .rjai-sub { margin-bottom: 20px; font-size: 13px; }
        .rjai-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .rjai-card { flex-direction: row; align-items: center; gap: 10px; padding: 12px; }
        .rjai-card-ic { flex-shrink: 0; width: 30px; height: 30px; }
        .rjai-card-tx b { font-size: 18px; }
        .rjai-col { max-width: 88%; }
        .rjai-bub { padding: 10px 13px; font-size: 14.5px; }
        .rjai-foot { padding: 10px 12px 12px; }
        .rjai-field { font-size: 16px; }
        .rjai-send { width: 40px; height: 40px; }
        .rjai-note { display: none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .rjai *, .rjai *::before, .rjai *::after { animation: none !important; transition-duration: .01ms !important; }
        .rjai-card { opacity: 1; }
    }

    @keyframes rjai-ang { to { --rjai-a: 360deg; } }
    @keyframes rjai-drift { to { transform: translate(60px, 40px) scale(1.12); } }
    @keyframes rjai-breathe { 50% { transform: scale(1.06); } }
    @keyframes rjai-think { 0%, 100% { transform: scale(.94); } 50% { transform: scale(1.1); } }
    @keyframes rjai-talk { from { transform: scale(.97); } to { transform: scale(1.08); } }
    @keyframes rjai-ring { 0% { opacity: .7; transform: scale(1); } 100% { opacity: 0; transform: scale(1.7); } }
    @keyframes rjai-spark { 50% { transform: scale(1.18) rotate(12deg); } }
    @keyframes rjai-dot { 0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, .5); } 100% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); } }
    @keyframes rjai-up { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes rjai-msg { from { opacity: 0; transform: translateY(8px) scale(.98); } to { opacity: 1; transform: none; } }
    @keyframes rjai-fade { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: none; } }
    @keyframes rjai-flow { to { background-position: 200% 50%; } }
    @keyframes rjai-shimmer { from { background-position: -400px 0; } to { background-position: 400px 0; } }
    @keyframes rjai-caret { 50% { opacity: 0; } }
</style>

<script>
    window.aiChat = function (stats, T, quick) {
        const esc = function (str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        };

        return {
            stats: stats,
            T: T,
            quick: quick,
            counts: { posts: 0, pages: 0, users: 0, comments: 0, media: 0 },
            messages: [],
            input: '',
            loading: false,
            typing: false,
            stopFlag: false,
            statusIdx: 0,
            statusTimer: null,
            uid: 0,

            get busy() {
                return this.loading || this.typing;
            },

            get orbState() {
                if (this.loading) return 'thinking';
                if (this.typing) return 'speaking';
                return 'idle';
            },

            get stateText() {
                if (this.loading) return this.T.thinking;
                if (this.typing) return this.T.typing;
                return this.T.online;
            },

            init() {
                this.animateCounts();

                const root = this.$el;
                root.addEventListener('pointermove', (e) => {
                    const r = root.getBoundingClientRect();
                    root.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 2 - 1).toFixed(2));
                    root.style.setProperty('--my', ((e.clientY - r.top) / r.height * 2 - 1).toFixed(2));
                });

                if (window.matchMedia('(min-width: 768px)').matches && this.$refs.field) {
                    this.$refs.field.focus();
                }
            },

            animateCounts() {
                const start = performance.now();
                const dur = 1000;
                const keys = Object.keys(this.counts);
                const tick = (now) => {
                    const t = Math.min(1, (now - start) / dur);
                    const e = 1 - Math.pow(1 - t, 3);
                    keys.forEach((k) => { this.counts[k] = Math.round((this.stats[k] || 0) * e); });
                    if (t < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            },

            sleep(ms) {
                return new Promise(r => setTimeout(r, ms));
            },

            clearChat() {
                if (this.busy) return;
                this.messages = [];
                this.$nextTick(() => this.animateCounts());
            },

            chip(color, n, label, path) {
                return '<span class="rjai-chip" style="--c:' + color + '"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="' + path + '"/></svg>' + n + ' ' + label + '</span>';
            },

            localAnswer(lower) {
                const s = this.stats;
                const T = this.T;
                const fill = (tpl, n) => tpl.replace(':count', '<strong>' + n + '</strong>');
                const has = (list) => list.some(w => lower.includes(w));

                if (has(['post', 'yazı', 'запис'])) return fill(T.posts, s.posts);
                if (has(['page', 'səhifə', 'страниц'])) return fill(T.pages, s.pages);
                if (has(['user', 'istifadəçi', 'пользовател'])) return fill(T.users, s.users);
                if (has(['comment', 'şərh', 'коммент'])) return fill(T.comments, s.comments);
                if (has(['media', 'fayl', 'файл'])) return fill(T.media, s.media);

                if (has(['overview', 'ümumi', 'обзор'])) {
                    const q = this.quick;
                    const p = (k) => (q.find(x => x.key === k) || {}).icon || '';
                    return T.overview + '<br><br><div class="rjai-chips">'
                        + this.chip('#6366f1', s.posts, T.lPosts, p('posts'))
                        + this.chip('#10b981', s.pages, T.lPages, p('pages'))
                        + this.chip('#3b82f6', s.users, T.lUsers, p('users'))
                        + this.chip('#f59e0b', s.comments, T.lComments, p('comments'))
                        + this.chip('#a855f7', s.media, T.lMedia, p('media'))
                        + '</div>';
                }
                return null;
            },

            startStatus() {
                this.statusIdx = 0;
                clearInterval(this.statusTimer);
                this.statusTimer = setInterval(() => {
                    this.statusIdx = (this.statusIdx + 1) % this.T.status.length;
                }, 1500);
            },

            stopStatus() {
                clearInterval(this.statusTimer);
            },

            async sendMessage(override) {
                const text = (typeof override === 'string' ? override : this.input).trim();
                if (!text || this.busy) return;

                this.messages.push({ id: ++this.uid, role: 'user', text: esc(text) });
                this.input = '';
                this.resize();
                this.loading = true;
                this.startStatus();
                this.scrollToBottom();

                const lower = text.toLowerCase();
                let answer = this.localAnswer(lower);

                if (answer !== null) {
                    await this.sleep(1300);
                } else {
                    try {
                        const res = await fetch(@js(route('admin.ask-ai')), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ question: text })
                        });

                        const data = await res.json();
                        answer = data.success
                            ? data.answer
                            : (data.answer || data.message || this.T.error);
                    } catch (e) {
                        answer = this.T.network;
                    }
                }

                this.loading = false;
                this.stopStatus();
                await this.typeAnswer(String(answer || this.T.error), text);

                if (window.matchMedia('(min-width: 768px)').matches && this.$refs.field) {
                    this.$refs.field.focus();
                }
            },

            async typeAnswer(html, q) {
                this.typing = true;
                this.stopFlag = false;
                this.messages.push({ id: ++this.uid, role: 'assistant', text: '', typing: true, q: q, copied: false });
                const msg = this.messages[this.messages.length - 1];

                const step = html.length > 900 ? 4 : html.length > 300 ? 2 : 1;
                let i = 0;
                let n = 0;

                while (i < html.length && !this.stopFlag) {
                    if (html[i] === '<') {
                        const end = html.indexOf('>', i);
                        i = end === -1 ? html.length : end + 1;
                        msg.text = html.slice(0, i);
                        continue;
                    }
                    if (html[i] === '&') {
                        const end = html.indexOf(';', i);
                        i = (end !== -1 && end - i < 9) ? end + 1 : i + 1;
                    } else {
                        i++;
                    }
                    n++;
                    msg.text = html.slice(0, i);
                    if (n % step === 0) {
                        this.scrollToBottom(true);
                        await this.sleep(16);
                    }
                }

                msg.text = html;
                msg.typing = false;
                this.typing = false;
                this.scrollToBottom();
            },

            stop() {
                this.stopFlag = true;
            },

            ask(text) {
                if (this.busy) return;
                this.sendMessage(text);
            },

            onEnter(e) {
                if (e.shiftKey || e.isComposing) return;
                e.preventDefault();
                this.sendMessage();
            },

            resize() {
                this.$nextTick(() => {
                    const el = this.$refs.field;
                    if (!el) return;
                    el.style.height = 'auto';
                    el.style.height = Math.min(el.scrollHeight, 140) + 'px';
                });
            },

            copy(msg) {
                const tmp = document.createElement('div');
                tmp.innerHTML = msg.text;
                const text = tmp.textContent || '';
                const done = () => {
                    msg.copied = true;
                    setTimeout(() => { msg.copied = false; }, 1500);
                };
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(done, () => {});
                } else {
                    const a = document.createElement('textarea');
                    a.value = text;
                    a.style.cssText = 'position:fixed;opacity:0';
                    document.body.appendChild(a);
                    a.select();
                    try { document.execCommand('copy'); done(); } catch (e) {}
                    document.body.removeChild(a);
                }
            },

            regenerate(index) {
                if (this.busy) return;
                const m = this.messages[index];
                if (!m || !m.q) return;
                this.messages.splice(index - 1, 2);
                this.sendMessage(m.q);
            },

            scrollToBottom(instant) {
                this.$nextTick(() => {
                    const el = this.$refs.chatContainer;
                    if (!el) return;
                    if (instant) el.scrollTop = el.scrollHeight;
                    else el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
                });
            }
        };
    };
</script>

<div class="rjai" x-data="aiChat(@js($statsData), @js($T), @js($quick))" :data-state="orbState">
    <div class="rjai-bg" aria-hidden="true"><i></i><i></i><i></i></div>

    <div class="rjai-head">
        {!! $orb(42, true) !!}
        <div class="rjai-ht">
            <h2>{{ __('RJ AI Assistant') }}</h2>
            <p class="rjai-st"><i></i><span x-text="stateText"></span></p>
        </div>
        <button type="button" class="rjai-clear" x-cloak x-show="messages.length > 0" x-transition.opacity @click="clearChat()" :disabled="busy">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
            <span>{{ __('Clear Chat') }}</span>
        </button>
    </div>

    <div class="rjai-body" x-ref="chatContainer">
        <div class="rjai-wrap">

            <div class="rjai-welcome" x-show="messages.length === 0 && !loading">
                {!! $orb(112, true) !!}
                <h3 class="rjai-title">{{ __('How can I help you today?') }}</h3>
                <p class="rjai-sub">{{ __('Ask me anything about managing your site or click one of the suggestions below to get instant stats.') }}</p>

                <div class="rjai-grid">
                    <template x-for="(c, i) in quick" :key="c.key">
                        <button type="button" class="rjai-card" :class="c.key === 'overview' ? 'is-wide' : ''" :style="'--c:' + c.color + ';--d:' + (i * 70) + 'ms'" :disabled="busy" @click="ask(c.q)">
                            <span class="rjai-card-ic">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" :d="c.icon"/></svg>
                            </span>
                            <span class="rjai-card-tx">
                                <small x-text="c.label"></small>
                                <b x-text="c.key === 'overview' ? T.all : counts[c.key]"></b>
                            </span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="rjai-list">
                <template x-for="(msg, index) in messages" :key="msg.id">
                    <div class="rjai-msg" :class="msg.role === 'user' ? 'is-user' : ''">
                        <template x-if="msg.role === 'user'">
                            <span class="rjai-av user">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                        </template>
                        <template x-if="msg.role === 'assistant'">
                            <span class="rjai-av">{!! $orb(30) !!}</span>
                        </template>

                        <div class="rjai-col">
                            <div class="rjai-bub" :class="msg.typing ? 'is-typing' : ''">
                                <div x-html="msg.text"></div>
                            </div>
                            <div class="rjai-act" x-show="msg.role === 'assistant' && !msg.typing">
                                <button type="button" @click="copy(msg)">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                                    <span x-text="msg.copied ? T.copied : T.copy"></span>
                                </button>
                                <button type="button" x-show="index === messages.length - 1" @click="regenerate(index)" :disabled="busy">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 11-3-6.7M21 4v5h-5"/></svg>
                                    <span x-text="T.retry"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="rjai-think" x-cloak x-show="loading">
                    {!! $orb(30) !!}
                    <div class="rjai-think-b">
                        <template x-for="(s, i) in T.status" :key="i">
                            <span class="rjai-think-t" x-show="statusIdx === i" x-text="s"></span>
                        </template>
                        <div class="rjai-line" style="width:92%"></div>
                        <div class="rjai-line" style="width:76%; animation-delay:.15s"></div>
                        <div class="rjai-line" style="width:52%; animation-delay:.3s"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rjai-foot">
        <div class="rjai-follow" x-cloak x-show="messages.length > 0 && !busy">
            <template x-for="c in quick" :key="'f' + c.key">
                <button type="button" class="rjai-fc" @click="ask(c.q)" x-text="c.label"></button>
            </template>
        </div>

        <form class="rjai-box" @submit.prevent="busy ? stop() : sendMessage()">
            <span class="rjai-box-in"></span>
            <textarea x-ref="field"
                      x-model="input"
                      rows="1"
                      class="rjai-field"
                      :readonly="busy"
                      @input="resize()"
                      @keydown.enter="onEnter($event)"
                      placeholder="{{ __('Message RJ AI Assistant...') }}"></textarea>
            <button type="submit" class="rjai-send" :class="typing ? 'is-stop' : ''" :disabled="!typing && (!input.trim() || busy)" :aria-label="typing ? T.stop : '{{ __('Send') }}'">
                <svg x-show="!typing" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                <svg x-show="typing" x-cloak fill="currentColor" viewBox="0 0 24 24"><rect x="7" y="7" width="10" height="10" rx="2"/></svg>
            </button>
        </form>
        <p class="rjai-note">{{ __('RJ AI can make mistakes. Verify important information.') }}</p>
    </div>
</div>
@endsection