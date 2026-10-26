@php
    $first = $o['first'];
    $mapsUrl = 'https://www.google.com/maps/search/?api=1&amp;query=' . $first['lat'] . ',' . $first['lng'];
@endphp

<style>
    #{{ $uid }} { position: relative; isolation: isolate; z-index: 0; width: 100%; overflow: hidden; border-radius: {{ $o['radius_px'] }}px; border: 1px solid var(--gbc); @if($o['shadow']) box-shadow: 0 1px 2px rgba(15, 23, 42, .05), 0 24px 48px -20px rgba(15, 23, 42, .3); @endif --h: {{ $o['height'] }}; --acc: {{ $o['accent'] }}; --rgb: {{ $o['accent_rgb'] }}; --accfg: {{ $o['accent_fg'] }}; --glass: rgba(255, 255, 255, .86); --gbc: rgba(15, 23, 42, .1); --fg: #0f172a; --muted: #64748b; --chip: rgba(15, 23, 42, .06); --mapbg: #e5e7eb; font-family: inherit; color: var(--fg); }
    #{{ $uid }}[data-theme="dark"] { --glass: rgba(15, 23, 42, .82); --gbc: rgba(255, 255, 255, .14); --fg: #f8fafc; --muted: #94a3b8; --chip: rgba(255, 255, 255, .08); --mapbg: #0b1220; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }
    #{{ $uid }} button { font-family: inherit; }
    #{{ $uid }} svg { display: block; }

    /* ---------- Stage ---------- */
    #{{ $uid }} .rjm-stage { position: relative; width: 100%; height: var(--h); background: var(--mapbg); overflow: hidden; }
    #{{ $uid }} .rjm-map { position: absolute; inset: 0; z-index: 0; isolation: isolate; }
    #{{ $uid }} .leaflet-container { font-family: inherit; background: var(--mapbg); outline: 0; }
    #{{ $uid }} .leaflet-container:focus-visible { outline: 2px solid var(--acc); outline-offset: -2px; }

    #{{ $uid }} .leaflet-control-attribution { margin: 0; padding: 3px 9px; border-radius: 10px 0 0 0; background: var(--glass) !important; color: var(--muted) !important; font-size: 10px; -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    #{{ $uid }} .leaflet-control-attribution a { color: inherit !important; }

    /* ---------- Placeholder ---------- */
    #{{ $uid }} .rjm-ph { position: absolute; inset: 0; z-index: 5; display: grid; place-items: center; padding: 24px; text-align: center; background-color: var(--mapbg); background-image: linear-gradient(rgba(148, 163, 184, .2) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, .2) 1px, transparent 1px); background-size: 34px 34px; transition: opacity .7s ease, visibility .7s ease; }
    #{{ $uid }} .rjm-ph::after { content: ""; position: absolute; inset: 0; background: linear-gradient(100deg, transparent 30%, rgba(255, 255, 255, .25) 50%, transparent 70%); background-size: 220% 100%; animation: rjm-shimmer 1.8s linear infinite; pointer-events: none; }
    #{{ $uid }}[data-theme="dark"] .rjm-ph::after { background: linear-gradient(100deg, transparent 30%, rgba(255, 255, 255, .06) 50%, transparent 70%); background-size: 220% 100%; }
    #{{ $uid }}.rjm-ready .rjm-ph { opacity: 0; visibility: hidden; pointer-events: none; }
    #{{ $uid }} .rjm-ph-in { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; max-width: 320px; }
    #{{ $uid }} .rjm-ph-pin { width: 54px; height: 54px; margin-bottom: 8px; display: grid; place-items: center; border-radius: 50%; background: var(--acc); color: var(--accfg); box-shadow: 0 0 0 0 rgba(var(--rgb), .5); animation: rjm-ping 1.8s ease-out infinite; }
    #{{ $uid }} .rjm-ph-pin svg { width: 26px; height: 26px; }
    #{{ $uid }} .rjm-ph-title { margin: 0; font-size: 1.05rem; font-weight: 800; }
    #{{ $uid }} .rjm-ph-addr { margin: 0; color: var(--muted); font-size: .9rem; }
    #{{ $uid }} .rjm-ph-link { margin-top: 10px; padding: 9px 18px; border-radius: 999px; background: var(--acc); color: var(--accfg) !important; font-size: .78rem; font-weight: 700; text-decoration: none !important; }

    /* ---------- Switcher ---------- */
    #{{ $uid }} .rjm-switch { position: absolute; top: 14px; left: 14px; z-index: 800; display: flex; gap: 2px; max-width: calc(100% - 76px); padding: 4px; overflow-x: auto; scrollbar-width: none; border-radius: 999px; background: var(--glass); border: 1px solid var(--gbc); -webkit-backdrop-filter: blur(14px) saturate(160%); backdrop-filter: blur(14px) saturate(160%); box-shadow: 0 8px 24px -8px rgba(15, 23, 42, .25); animation: rjm-fade-down .7s cubic-bezier(.2, .8, .2, 1) .35s backwards; }
    #{{ $uid }} .rjm-switch::-webkit-scrollbar { display: none; }
    #{{ $uid }} .rjm-sw { flex: none; margin: 0; padding: 8px 14px; border: 0; border-radius: 999px; background: transparent; color: var(--fg); font-size: .74rem; font-weight: 700; line-height: 1; cursor: pointer; transition: background-color .25s ease, color .25s ease; }
    #{{ $uid }} .rjm-sw:hover { background: var(--chip); }
    #{{ $uid }} .rjm-sw.rjm-on { background: var(--acc); color: var(--accfg); }

    /* ---------- Controls ---------- */
    #{{ $uid }} .rjm-ctrls { position: absolute; top: 14px; right: 14px; z-index: 800; display: flex; flex-direction: column; gap: 8px; }
    #{{ $uid }} .rjm-btn { width: 40px; height: 40px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid var(--gbc); border-radius: 12px; background: var(--glass); color: var(--fg); cursor: pointer; -webkit-backdrop-filter: blur(14px) saturate(160%); backdrop-filter: blur(14px) saturate(160%); box-shadow: 0 8px 24px -8px rgba(15, 23, 42, .25); transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), background-color .2s ease, color .2s ease; animation: rjm-fade-left .6s cubic-bezier(.2, .8, .2, 1) backwards; animation-delay: calc(var(--k, 0) * 70ms + 400ms); }
    #{{ $uid }} .rjm-btn:hover { background: var(--acc); color: var(--accfg); transform: scale(1.08); }
    #{{ $uid }} .rjm-btn:focus-visible, #{{ $uid }} .rjm-sw:focus-visible, #{{ $uid }} .rjm-dir:focus-visible, #{{ $uid }} .rjm-mini:focus-visible { outline: 2px solid var(--acc); outline-offset: 2px; }
    #{{ $uid }} .rjm-btn svg { width: 18px; height: 18px; }
    #{{ $uid }}.rjm-locating .rjm-b-locate svg { animation: rjm-spin 1s linear infinite; }
    #{{ $uid }} .rjm-b-fs .rjm-i-exit { display: none; }
    #{{ $uid }}.rjm-fs .rjm-b-fs .rjm-i-exit { display: block; }
    #{{ $uid }}.rjm-fs .rjm-b-fs .rjm-i-enter { display: none; }

    /* ---------- Hint ---------- */
    #{{ $uid }} .rjm-hint { position: absolute; inset: 0; z-index: 900; display: grid; place-items: center; padding: 20px; text-align: center; background: rgba(2, 6, 23, .5); color: #fff; font-size: 1rem; font-weight: 700; opacity: 0; pointer-events: none; transition: opacity .3s ease; }
    #{{ $uid }} .rjm-hint.rjm-show { opacity: 1; }

    /* ---------- Markers ---------- */
    #{{ $uid }} .rjm-marker { background: transparent; border: 0; }
    #{{ $uid }} .rjm-pin { position: relative; width: 44px; height: 54px; transform-origin: 50% 100%; transition: transform .4s cubic-bezier(.34, 1.56, .64, 1); animation: rjm-drop .85s cubic-bezier(.34, 1.56, .64, 1) backwards; animation-delay: var(--d, 0ms); }
    #{{ $uid }} .rjm-pin.rjm-active { transform: scale(1.22); }
    #{{ $uid }} .rjm-head { position: absolute; z-index: 2; top: 0; left: 50%; width: 42px; height: 42px; margin-left: -21px; display: grid; place-items: center; border-radius: 50%; background: var(--acc); color: var(--accfg); border: 3px solid #fff; box-shadow: 0 8px 18px rgba(0, 0, 0, .32); }
    #{{ $uid }} .rjm-head > * { width: 22px; height: 22px; max-width: 22px; max-height: 22px; display: block; }
    #{{ $uid }} .rjm-tail { position: absolute; z-index: 1; left: 50%; top: 33px; width: 14px; height: 14px; margin-left: -7px; background: var(--acc); border-right: 3px solid #fff; border-bottom: 3px solid #fff; border-radius: 0 0 4px 0; transform: rotate(45deg); box-shadow: 4px 4px 8px rgba(0, 0, 0, .18); }
    #{{ $uid }} .rjm-pulse { position: absolute; left: 50%; bottom: -1px; width: 34px; height: 14px; margin-left: -17px; border-radius: 50%; background: var(--acc); opacity: 0; }
    #{{ $uid }} .rjm-pin.rjm-active .rjm-pulse { animation: rjm-radar 2.2s ease-out infinite; }

    #{{ $uid }} .leaflet-tooltip.rjm-tip { padding: 7px 12px; border: 1px solid var(--gbc); border-radius: 10px; background: var(--glass); color: var(--fg); font-size: .78rem; font-weight: 700; box-shadow: 0 10px 24px -8px rgba(15, 23, 42, .35); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); }
    #{{ $uid }} .leaflet-tooltip.rjm-tip::before { display: none; }

    #{{ $uid }} .rjm-user span { display: block; width: 18px; height: 18px; border-radius: 50%; background: #2563eb; border: 3px solid #fff; box-shadow: 0 0 0 0 rgba(37, 99, 235, .55); animation: rjm-user 2s ease-out infinite; }

    /* ---------- Card ---------- */
    #{{ $uid }} .rjm-card { position: absolute; z-index: 850; left: 16px; bottom: 32px; width: min(340px, calc(100% - 32px)); max-height: calc(100% - 100px); display: flex; flex-direction: column; overflow: hidden; border-radius: 20px; background: var(--glass); border: 1px solid var(--gbc); color: var(--fg); -webkit-backdrop-filter: blur(18px) saturate(170%); backdrop-filter: blur(18px) saturate(170%); box-shadow: 0 20px 48px -14px rgba(15, 23, 42, .4); }
    #{{ $uid }}[data-cardpos="right"] .rjm-card { left: auto; right: 16px; }
    #{{ $uid }}:not(.rjm-ready) .rjm-card { display: none; }
    #{{ $uid }}.rjm-ready .rjm-card { animation: rjm-card-in .85s cubic-bezier(.2, .8, .2, 1) .15s backwards; }

    #{{ $uid }} .rjm-top { display: flex; align-items: center; gap: 8px; padding: 12px 12px 4px 18px; }
    #{{ $uid }} .rjm-badge { display: inline-flex; align-items: center; gap: 8px; margin-right: auto; color: var(--muted); font-size: .68rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rjm-badge i { width: 8px; height: 8px; border-radius: 50%; background: var(--acc); box-shadow: 0 0 0 0 rgba(var(--rgb), .5); animation: rjm-ping 2s ease-out infinite; }
    #{{ $uid }} .rjm-mini { width: 30px; height: 30px; margin: 0; padding: 0; display: grid; place-items: center; border: 0; border-radius: 50%; background: var(--chip); color: var(--fg); cursor: pointer; transition: background-color .2s ease, color .2s ease, transform .3s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }} .rjm-mini:hover { background: var(--acc); color: var(--accfg); transform: scale(1.1); }
    #{{ $uid }} .rjm-mini svg { width: 16px; height: 16px; }
    #{{ $uid }} .rjm-toggle svg { transition: transform .4s ease; }
    #{{ $uid }}.rjm-min .rjm-toggle svg { transform: rotate(180deg); }

    #{{ $uid }} .rjm-body { display: grid; grid-template-rows: 1fr; min-height: 0; overflow-y: auto; transition: grid-template-rows .45s cubic-bezier(.2, .8, .2, 1); }
    #{{ $uid }}.rjm-min .rjm-body { grid-template-rows: 0fr; overflow: hidden; }
    #{{ $uid }} .rjm-body > div { min-height: 0; overflow: hidden; }
    #{{ $uid }} .rjm-swap { padding: 6px 18px 18px; }
    #{{ $uid }} .rjm-swap.rjm-anim { animation: rjm-swap .5s cubic-bezier(.2, .8, .2, 1); }

    #{{ $uid }} .rjm-title { margin: 4px 0 0; padding: 0; font-size: 1.15rem; font-weight: 800; line-height: 1.25; letter-spacing: -.01em; color: var(--fg); }
    #{{ $uid }} .rjm-text { margin: 8px 0 0; color: var(--muted); font-size: .88rem; line-height: 1.6; white-space: pre-line; }
    #{{ $uid }} .rjm-rows { margin: 12px 0 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 8px; }
    #{{ $uid }} .rjm-rows li { display: flex; align-items: flex-start; gap: 10px; margin: 0; padding: 0; color: var(--fg); font-size: .84rem; line-height: 1.5; }
    #{{ $uid }} .rjm-rows svg { flex: none; width: 16px; height: 16px; margin-top: 3px; color: var(--acc); }
    #{{ $uid }} .rjm-rows a { color: inherit; text-decoration: none; }
    #{{ $uid }} .rjm-rows a:hover { color: var(--acc); }
    #{{ $uid }} .rjm-hours { white-space: pre-line; }

    #{{ $uid }} .rjm-dist { display: inline-flex; margin-top: 12px; padding: 5px 12px; border-radius: 999px; background: rgba(var(--rgb), .14); color: var(--acc); font-size: .74rem; font-weight: 800; }
    #{{ $uid }} .rjm-dir { display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 14px; padding: 13px 18px; border-radius: 14px; background: var(--acc); color: var(--accfg) !important; font-size: .82rem; font-weight: 800; letter-spacing: .04em; text-decoration: none !important; box-shadow: 0 10px 22px -8px rgba(var(--rgb), .6); transition: transform .3s cubic-bezier(.34, 1.56, .64, 1), box-shadow .3s ease; }
    #{{ $uid }} .rjm-dir:hover { transform: translateY(-2px); box-shadow: 0 16px 28px -8px rgba(var(--rgb), .7); }
    #{{ $uid }} .rjm-dir svg { width: 16px; height: 16px; transition: transform .3s ease; }
    #{{ $uid }} .rjm-dir:hover svg { transform: translateX(4px); }

    /* ---------- Fullscreen ---------- */
    #{{ $uid }}.rjm-fs { position: fixed; inset: 0; z-index: 99999; width: 100%; max-width: none; margin: 0; height: 100vh; height: 100dvh; border-radius: 0; border: 0; display: flex; flex-direction: column; }
    #{{ $uid }}.rjm-fs .rjm-stage { flex: 1; height: auto; }

    /* ---------- Keyframes ---------- */
    @keyframes rjm-shimmer { from { background-position: 220% 0; } to { background-position: -120% 0; } }
    @keyframes rjm-ping { 0% { box-shadow: 0 0 0 0 rgba(var(--rgb), .5); } 80%, 100% { box-shadow: 0 0 0 16px rgba(var(--rgb), 0); } }
    @keyframes rjm-drop { from { opacity: 0; transform: translateY(-46px) scale(.6); } to { opacity: 1; transform: none; } }
    @keyframes rjm-radar { 0% { opacity: .55; transform: scale(.3); } 100% { opacity: 0; transform: scale(2.6); } }
    @keyframes rjm-user { 0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, .55); } 80%, 100% { box-shadow: 0 0 0 16px rgba(37, 99, 235, 0); } }
    @keyframes rjm-card-in { from { opacity: 0; transform: translate3d(0, 26px, 0) scale(.97); } to { opacity: 1; transform: none; } }
    @keyframes rjm-fade-down { from { opacity: 0; transform: translateY(-14px); } to { opacity: 1; transform: none; } }
    @keyframes rjm-fade-left { from { opacity: 0; transform: translateX(14px); } to { opacity: 1; transform: none; } }
    @keyframes rjm-swap { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
    @keyframes rjm-spin { to { transform: rotate(360deg); } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjm-stage { height: min(var(--h), 420px); }
        #{{ $uid }}.rjm-fs .rjm-stage { height: auto; }
        #{{ $uid }} .rjm-card, #{{ $uid }}[data-cardpos="right"] .rjm-card { position: relative; left: auto; right: auto; bottom: auto; width: auto; max-height: none; border: 0; border-top: 1px solid var(--gbc); border-radius: 0; box-shadow: none; animation: none; }
        #{{ $uid }}.rjm-fs .rjm-card { max-height: 46%; }
        #{{ $uid }} .rjm-sw { padding: 7px 11px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation-duration: .01ms !important; animation-delay: 0ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
    }
</style>

<template id="{{ $uid }}-pin">{!! $o['icon_html'] !!}</template>

<div id="{{ $uid }}" class="rjm" data-theme="{{ $o['theme'] }}" data-style="{{ $o['style'] }}" data-cardpos="{{ $o['card_pos'] }}" data-config="{{ $o['config_json'] }}">
    <div class="rjm-stage">
        <div class="rjm-map" role="region" aria-label="{{ $first['title'] !== '' ? $first['title'] : __('Map') }}"></div>

        <div class="rjm-ph">
            <div class="rjm-ph-in">
                <span class="rjm-ph-pin" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 119.5 9 2.5 2.5 0 0112 11.5z"/></svg>
                </span>
                @if ($first['title'] !== '')
                    <p class="rjm-ph-title">{{ $first['title'] }}</p>
                @endif
                @if ($first['address'] !== '')
                    <p class="rjm-ph-addr">{{ $first['address'] }}</p>
                @endif
                <a class="rjm-ph-link" href="{!! $mapsUrl !!}" target="_blank" rel="noopener noreferrer">{{ __('Open in Maps') }}</a>
            </div>
        </div>

        @if ($o['show_switcher'] && count($o['styles']) > 1)
            <div class="rjm-switch" role="group" aria-label="{{ __('Map style') }}">
                @foreach ($o['styles'] as $st)
                    <button type="button" class="rjm-sw {{ $st['key'] === $o['style'] ? 'rjm-on' : '' }}" data-style="{{ $st['key'] }}" aria-pressed="{{ $st['key'] === $o['style'] ? 'true' : 'false' }}">{{ $st['label'] }}</button>
                @endforeach
            </div>
        @endif

        @if ($o['show_controls'])
            <div class="rjm-ctrls">
                <button type="button" class="rjm-btn rjm-b-in" style="--k:0" aria-label="{{ __('Zoom in') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                </button>
                <button type="button" class="rjm-btn rjm-b-out" style="--k:1" aria-label="{{ __('Zoom out') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M5 12h14"/></svg>
                </button>
                <button type="button" class="rjm-btn rjm-b-locate" style="--k:2" aria-label="{{ __('Show my location') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="7.5"/><path d="M12 2v2.5M12 19.5V22M2 12h2.5M19.5 12H22"/></svg>
                </button>
                <button type="button" class="rjm-btn rjm-b-home" style="--k:3" aria-label="{{ __('Show all locations') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
                </button>
                <button type="button" class="rjm-btn rjm-b-fs" style="--k:4" aria-label="{{ __('Fullscreen') }}" aria-pressed="false">
                    <svg class="rjm-i-enter" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                    <svg class="rjm-i-exit" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 3v3a2 2 0 01-2 2H3m18 0h-3a2 2 0 01-2-2V3m0 18v-3a2 2 0 012-2h3M3 16h3a2 2 0 012 2v3"/></svg>
                </button>
            </div>
        @endif

        <div class="rjm-hint" aria-hidden="true"></div>
    </div>

    @if ($o['show_card'])
        <aside class="rjm-card" aria-label="{{ __('Location details') }}" aria-live="polite">
            <div class="rjm-top">
                <span class="rjm-badge"><i aria-hidden="true"></i><span class="rjm-count">{{ __('Location') }}</span></span>

                @if ($o['many'])
                    <button type="button" class="rjm-mini rjm-prev" aria-label="{{ __('Previous location') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg>
                    </button>
                    <button type="button" class="rjm-mini rjm-next" aria-label="{{ __('Next location') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg>
                    </button>
                @endif

                <button type="button" class="rjm-mini rjm-toggle" aria-label="{{ __('Hide details') }}" aria-expanded="true">
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                </button>
            </div>

            <div class="rjm-body">
                <div>
                    <div class="rjm-swap">
                        <h3 class="rjm-title" hidden></h3>
                        <p class="rjm-text" hidden></p>

                        <ul class="rjm-rows">
                            <li class="rjm-r-addr" hidden>
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span></span>
                            </li>
                            <li class="rjm-r-phone" hidden>
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.8 19.8 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0122 16.92z"/></svg>
                                <a href="#"></a>
                            </li>
                            <li class="rjm-r-hours" hidden>
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                <span class="rjm-hours"></span>
                            </li>
                        </ul>

                        <span class="rjm-dist" hidden></span>

                        @if ($o['directions'])
                            <a class="rjm-dir" href="#" target="_blank" rel="noopener noreferrer">
                                <span>{{ __('Get directions') }}</span>
                                <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14m-6-6l6 6-6 6"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </aside>
    @endif
</div>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config')); } catch (e) { return; }

    var S = cfg.strings;
    var locs = cfg.locations;
    var n = locs.length;

    var stage = root.querySelector('.rjm-stage');
    var mapEl = root.querySelector('.rjm-map');
    var card = root.querySelector('.rjm-card');
    var hintEl = root.querySelector('.rjm-hint');
    var tpl = document.getElementById('{{ $uid }}-pin');
    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

    var FALLBACK_ICON = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 119.5 9 2.5 2.5 0 0112 11.5z"/></svg>';

    var TILES = {
        light: { url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', attr: '&copy; OpenStreetMap contributors &copy; CARTO', sub: 'abcd', max: 19, theme: 'light' },
        dark: { url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', attr: '&copy; OpenStreetMap contributors &copy; CARTO', sub: 'abcd', max: 19, theme: 'dark' },
        voyager: { url: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', attr: '&copy; OpenStreetMap contributors &copy; CARTO', sub: 'abcd', max: 19, theme: 'light' },
        streets: { url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', attr: '&copy; OpenStreetMap contributors', sub: 'abc', max: 19, theme: 'light' },
        satellite: { url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', attr: 'Tiles &copy; Esri', sub: 'abc', max: 19, native: 18, theme: 'dark' }
    };

    // ---------- Leaflet loader (shared by every map on the page) ----------
    function loadLeaflet() {
        if (window.L && window.L.map) { return Promise.resolve(window.L); }
        if (window.__rjLeafletP) { return window.__rjLeafletP; }

        window.__rjLeafletP = new Promise(function (resolve, reject) {
            function addCss(href, integrity, onDone) {
                var l = document.createElement('link');
                l.rel = 'stylesheet';
                l.href = href;
                l.setAttribute('data-rj-leaflet', '1');
                if (integrity) { l.integrity = integrity; l.crossOrigin = ''; }
                l.onload = function () { onDone(true); };
                l.onerror = function () { l.parentNode && l.parentNode.removeChild(l); onDone(false); };
                document.head.appendChild(l);
            }

            var cssDone = false;
            function cssFinish() { cssDone = true; }

            if (!document.querySelector('link[data-rj-leaflet]')) {
                addCss('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=', function (ok) {
                    if (ok) { cssFinish(); return; }
                    addCss('https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css', '', cssFinish);
                });
            } else {
                cssDone = true;
            }

            var sources = [
                { src: 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', integrity: 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=' },
                { src: 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js', integrity: '' }
            ];
            var idx = 0;

            function waitCss(cb) {
                var waited = 0;
                (function poll() {
                    if (cssDone || waited > 3500) { cb(); return; }
                    waited += 60;
                    setTimeout(poll, 60);
                })();
            }

            (function next() {
                if (idx >= sources.length) { reject(new Error('leaflet')); return; }
                var item = sources[idx++];
                var s = document.createElement('script');
                s.src = item.src;
                s.async = true;
                if (item.integrity) { s.integrity = item.integrity; s.crossOrigin = ''; }
                s.onload = function () {
                    if (window.L && window.L.map) { waitCss(function () { resolve(window.L); }); } else { next(); }
                };
                s.onerror = function () { s.parentNode && s.parentNode.removeChild(s); next(); };
                document.head.appendChild(s);
            })();
        });

        window.__rjLeafletP.catch(function () { window.__rjLeafletP = null; });
        return window.__rjLeafletP;
    }

    function pad2(v) { return v < 10 ? '0' + v : String(v); }

    function distanceText(a, b) {
        var R = 6371;
        var dLat = (b.lat - a.lat) * Math.PI / 180;
        var dLng = (b.lng - a.lng) * Math.PI / 180;
        var x = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(a.lat * Math.PI / 180) * Math.cos(b.lat * Math.PI / 180) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        var km = R * 2 * Math.atan2(Math.sqrt(x), Math.sqrt(1 - x));
        if (km < 1) { return Math.round(km * 1000) + ' m'; }
        return (km < 100 ? km.toFixed(1) : String(Math.round(km))) + ' km';
    }

    function build(L) {
        var pts = locs.map(function (l) { return L.latLng(l.lat, l.lng); });
        var bounds = L.latLngBounds(pts);
        var touchDevice = !!L.Browser.mobile;
        var flyIn = cfg.intro && !reduce;

        var map = L.map(mapEl, {
            zoomControl: false,
            attributionControl: false,
            scrollWheelZoom: false,
            dragging: !touchDevice,
            worldCopyJump: true
        });

        map.setView(bounds.getCenter(), Math.max(2, cfg.zoom - (flyIn ? 5 : 0)), { animate: false });
        L.control.attribution({ prefix: false, position: 'bottomright' }).addTo(map);

        var active = 0;
        var userPos = null;
        var userMarker = null;
        var layer = null;
        var introDone = false;
        var hintTimer = 0;

        // ---------- Helpers ----------
        function showHint(text) {
            if (!hintEl) { return; }
            hintEl.textContent = text;
            hintEl.classList.add('rjm-show');
            clearTimeout(hintTimer);
            hintTimer = setTimeout(function () { hintEl.classList.remove('rjm-show'); }, 1400);
        }

        function pads() {
            var desktop = window.innerWidth > 640 && cfg.showCard && card && !root.classList.contains('rjm-fs-m');
            var cw = desktop ? Math.min(340, stage.clientWidth - 32) + 32 : 0;
            return {
                tl: [(cfg.cardPos === 'left' ? cw : 0) + 40, 70],
                br: [(cfg.cardPos === 'right' ? cw : 0) + 60, 50]
            };
        }

        function fitTo(b, dur, maxZoom) {
            var p = pads();
            var opt = { paddingTopLeft: p.tl, paddingBottomRight: p.br, maxZoom: maxZoom || cfg.zoom };
            if (reduce || !dur) { opt.animate = false; map.fitBounds(b, opt); }
            else { opt.duration = dur; map.flyToBounds(b, opt); }
        }

        function focusOn(i) {
            var p = pts[i];
            fitTo(L.latLngBounds([p, p]), 1.2);
        }

        function home(dur) { fitTo(bounds, dur); }

        // ---------- Tiles ----------
        var switchBtns = Array.prototype.slice.call(root.querySelectorAll('.rjm-sw'));

        function setStyle(name) {
            var t = TILES[name] || TILES.light;
            if (layer) { map.removeLayer(layer); }

            var opts = { attribution: t.attr, subdomains: t.sub, maxZoom: t.max };
            if (t.native) { opts.maxNativeZoom = t.native; }
            layer = L.tileLayer(t.url, opts).addTo(map);

            root.setAttribute('data-theme', t.theme);
            root.setAttribute('data-style', name);
            switchBtns.forEach(function (b) {
                var on = b.getAttribute('data-style') === name;
                b.classList.toggle('rjm-on', on);
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
        }

        setStyle(cfg.style);

        switchBtns.forEach(function (b) {
            b.addEventListener('click', function () { setStyle(b.getAttribute('data-style')); });
        });

        // ---------- Markers ----------
        function makeIcon() {
            var holder = document.createElement('span');
            holder.style.display = 'contents';
            if (tpl && tpl.content && tpl.content.childNodes.length) {
                holder.appendChild(tpl.content.cloneNode(true));
            } else {
                holder.innerHTML = FALLBACK_ICON;
            }
            return holder;
        }

        var markers = locs.map(function (loc, i) {
            var pin = document.createElement('div');
            pin.className = 'rjm-pin';
            pin.style.setProperty('--d', (i * 140 + 250) + 'ms');

            var pulse = document.createElement('span');
            pulse.className = 'rjm-pulse';
            var tail = document.createElement('span');
            tail.className = 'rjm-tail';
            var head = document.createElement('span');
            head.className = 'rjm-head';
            head.appendChild(makeIcon());

            pin.appendChild(pulse);
            pin.appendChild(tail);
            pin.appendChild(head);

            var icon = L.divIcon({ html: pin, className: 'rjm-marker', iconSize: [44, 54], iconAnchor: [22, 52] });
            var label = loc.title || loc.address || '';

            var marker = L.marker(pts[i], { icon: icon, title: label, alt: label, keyboard: true, riseOnHover: true }).addTo(map);

            if (loc.title) {
                var tip = document.createElement('span');
                tip.textContent = loc.title;
                marker.bindTooltip(tip, { direction: 'top', offset: [0, -50], opacity: 1, className: 'rjm-tip' });
            }

            marker.on('click', function () { select(i, true); });

            return { marker: marker, pin: pin };
        });

        // ---------- Card ----------
        function setText(node, text) {
            if (!node) { return; }
            node.textContent = text || '';
            node.hidden = !text;
        }

        function fillCard(i, animate) {
            if (!card) { return; }
            var loc = locs[i];

            setText(card.querySelector('.rjm-title'), loc.title);
            setText(card.querySelector('.rjm-text'), loc.text);

            var addr = card.querySelector('.rjm-r-addr');
            addr.hidden = !loc.address;
            addr.querySelector('span').textContent = loc.address || '';

            var phone = card.querySelector('.rjm-r-phone');
            phone.hidden = !loc.phone;
            var a = phone.querySelector('a');
            a.textContent = loc.phone || '';
            a.setAttribute('href', 'tel:' + (loc.phone_href || ''));

            var hours = card.querySelector('.rjm-r-hours');
            hours.hidden = !loc.hours;
            hours.querySelector('.rjm-hours').textContent = loc.hours || '';

            var dist = card.querySelector('.rjm-dist');
            if (userPos) {
                dist.hidden = false;
                dist.textContent = S.away.replace(':distance', distanceText(userPos, loc));
            } else {
                dist.hidden = true;
            }

            var dir = card.querySelector('.rjm-dir');
            if (dir) { dir.setAttribute('href', 'https://www.google.com/maps/dir/?api=1&destination=' + loc.lat + ',' + loc.lng); }

            var count = card.querySelector('.rjm-count');
            count.textContent = n > 1 ? pad2(i + 1) + ' / ' + pad2(n) : S.location;

            if (animate) {
                var sw = card.querySelector('.rjm-swap');
                sw.classList.remove('rjm-anim');
                void sw.offsetWidth;
                sw.classList.add('rjm-anim');
            }
        }

        function select(i, fly) {
            i = ((i % n) + n) % n;
            var changed = i !== active;
            active = i;

            markers.forEach(function (m, k) {
                m.pin.classList.toggle('rjm-active', k === i);
                m.marker.setZIndexOffset(k === i ? 1000 : 0);
            });

            fillCard(i, changed);
            if (fly) { focusOn(i); }
        }

        var prev = root.querySelector('.rjm-prev');
        var next = root.querySelector('.rjm-next');
        if (prev) { prev.addEventListener('click', function () { select(active - 1, true); }); }
        if (next) { next.addEventListener('click', function () { select(active + 1, true); }); }

        var toggle = root.querySelector('.rjm-toggle');
        if (toggle) {
            toggle.addEventListener('click', function () {
                var min = root.classList.toggle('rjm-min');
                toggle.setAttribute('aria-expanded', min ? 'false' : 'true');
                toggle.setAttribute('aria-label', min ? S.expand : S.collapse);
            });
        }

        select(0, false);

        // ---------- Controls ----------
        var bIn = root.querySelector('.rjm-b-in');
        var bOut = root.querySelector('.rjm-b-out');
        var bLoc = root.querySelector('.rjm-b-locate');
        var bHome = root.querySelector('.rjm-b-home');
        var bFs = root.querySelector('.rjm-b-fs');

        if (bIn) { bIn.addEventListener('click', function () { map.zoomIn(); }); }
        if (bOut) { bOut.addEventListener('click', function () { map.zoomOut(); }); }

        if (bHome) {
            bHome.addEventListener('click', function () {
                if (n > 1) { home(1.4); } else { focusOn(0); }
            });
        }

        if (bLoc) {
            bLoc.addEventListener('click', function () {
                if (!navigator.geolocation) { showHint(S.locateFail); return; }
                root.classList.add('rjm-locating');

                navigator.geolocation.getCurrentPosition(function (pos) {
                    root.classList.remove('rjm-locating');
                    userPos = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                    var ll = L.latLng(userPos.lat, userPos.lng);

                    if (userMarker) { userMarker.setLatLng(ll); }
                    else {
                        userMarker = L.marker(ll, {
                            icon: L.divIcon({ className: 'rjm-user', html: '<span></span>', iconSize: [18, 18] }),
                            interactive: false,
                            keyboard: false
                        }).addTo(map);
                    }

                    fillCard(active, false);
                    fitTo(L.latLngBounds([ll, pts[active]]), 1.4, 16);
                }, function () {
                    root.classList.remove('rjm-locating');
                    showHint(S.locateFail);
                }, { timeout: 10000, maximumAge: 60000 });
            });
        }

        // ---------- Pseudo fullscreen (works on iOS too) ----------
        var htmlOverflow = '';

        function setFs(on) {
            root.classList.toggle('rjm-fs', on);
            if (on) { htmlOverflow = document.documentElement.style.overflow; document.documentElement.style.overflow = 'hidden'; }
            else { document.documentElement.style.overflow = htmlOverflow; }

            if (bFs) {
                bFs.setAttribute('aria-pressed', on ? 'true' : 'false');
                bFs.setAttribute('aria-label', on ? S.exitFs : S.fs);
            }

            if (touchDevice) { if (on) { map.dragging.enable(); } else { map.dragging.disable(); } }
            setTimeout(function () { map.invalidateSize(); focusOn(active); }, 80);
        }

        if (bFs) { bFs.addEventListener('click', function () { setFs(!root.classList.contains('rjm-fs')); }); }

        function onKey(e) {
            if (!root.isConnected) { document.removeEventListener('keydown', onKey); return; }
            if (e.key === 'Escape' && root.classList.contains('rjm-fs')) { setFs(false); }
        }
        document.addEventListener('keydown', onKey);

        // ---------- Scroll guard ----------
        var isMac = /Mac|iPhone|iPad|iPod/.test(navigator.platform || navigator.userAgent || '');

        stage.addEventListener('wheel', function (e) {
            if (root.classList.contains('rjm-fs') || !cfg.guard) {
                map.scrollWheelZoom.enable();
                return;
            }
            if (e.ctrlKey || e.metaKey) {
                map.scrollWheelZoom.enable();
                e.preventDefault();
            } else {
                map.scrollWheelZoom.disable();
                showHint(S.guardKey.replace(':key', isMac ? '\u2318' : 'Ctrl'));
            }
        }, { capture: true, passive: false });

        if (touchDevice) {
            var lastHint = 0;
            stage.addEventListener('touchmove', function (e) {
                if (root.classList.contains('rjm-fs') || e.touches.length !== 1) { return; }
                if (e.target.closest && e.target.closest('.rjm-card, .rjm-switch, .rjm-ctrls')) { return; }
                var now = Date.now();
                if (now - lastHint > 2500) { lastHint = now; showHint(S.twoFingers); }
            }, { passive: true });
        }

        // ---------- Resize ----------
        if ('ResizeObserver' in window) {
            var ro = new ResizeObserver(function () {
                if (!root.isConnected) { ro.disconnect(); return; }
                map.invalidateSize();
            });
            ro.observe(stage);
        }

        // ---------- Ready + intro ----------
        function ready() { root.classList.add('rjm-ready'); }

        layer.once('load', ready);
        setTimeout(ready, 3200);

        function runIntro() {
            if (introDone) { return; }
            introDone = true;
            map.invalidateSize();
            home(flyIn ? 2.4 : 0);
        }

        if (flyIn && 'IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    io.disconnect();
                    setTimeout(runIntro, 300);
                }
            }, { threshold: 0.4 });
            io.observe(stage);
        } else {
            runIntro();
        }
    }

    function start() {
        loadLeaflet().then(build).catch(function () {
            root.classList.add('rjm-failed');
        });
    }

    if ('IntersectionObserver' in window) {
        var pre = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                pre.disconnect();
                start();
            }
        }, { rootMargin: '300px 0px' });
        pre.observe(root);
    } else {
        start();
    }
})();
</script>
