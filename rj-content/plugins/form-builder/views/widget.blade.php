@php
    $layoutClass = match($layout ?? 'stack') {
        'grid-2' => 'rj-form-grid-2',
        'inline' => 'rj-form-inline',
        default => 'rj-form-stack',
    };

    $preset     = in_array($designPreset ?? 'modern', ['default', 'modern', 'minimal', 'dark'], true) ? ($designPreset ?? 'modern') : 'modern';
    $fid        = 'rjf-' . substr(md5(uniqid('', true)), 0, 8);
    $showMascot = filter_var($showMascot ?? true, FILTER_VALIDATE_BOOLEAN);
    $stageSide  = ($stageSide ?? 'right') === 'left' ? 'left' : 'right';
    $fieldCount = count($form->fields);
    $hasErrors  = isset($errors) && $errors->any();

    $texts = [
        'idle'    => __('Hi there!'),
        'focus'   => __('Go on, I’m listening'),
        'email'   => __('Nice, an email!'),
        'reading' => __('I’m reading along...'),
        'curious' => __('Hmm, let me see...'),
        'happy'   => __('Great choice!'),
        'done'    => __('All set, ready to send!'),
        'wait'    => __('Sending...'),
        'success' => __('Sent! Thank you!'),
        'error'   => __('Oops, check the fields'),
    ];
@endphp

<style>
    #{{ $fid }} {
        --accent: #7c3aed;
        --accent2: #ec4899;
        --accent-d: color-mix(in srgb, var(--accent) 75%, #0f172a);
        --card: #ffffff;
        --fg: #0f172a;
        --muted: #64748b;
        --line: #e2e8f0;
        --field: #f8fafc;
        --field-f: #ffffff;
        --label: #334155;
        --stage-a: color-mix(in srgb, var(--accent) 10%, #ffffff);
        --stage-b: color-mix(in srgb, var(--accent) 30%, #ffffff);
        --shadow: 0 30px 60px -34px rgba(15, 23, 42, .35);
        --r: 24px;
        --bt: 64px;
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        padding: clamp(14px, 4vw, 40px);
        container-name: rjf-w;
        container-type: inline-size;
    }
    #{{ $fid }}[data-preset="modern"] {
        --shadow: 0 40px 80px -36px rgba(124, 58, 237, .38);
        --stage-b: color-mix(in srgb, var(--accent2) 24%, #ffffff);
    }
    #{{ $fid }}[data-preset="minimal"] {
        --card: transparent;
        --shadow: none;
        --r: 20px;
        --stage-a: color-mix(in srgb, var(--accent) 5%, #ffffff);
        --stage-b: color-mix(in srgb, var(--accent) 15%, #ffffff);
    }
    #{{ $fid }}[data-preset="dark"] {
        --card: #0f172a;
        --fg: #f1f5f9;
        --muted: #94a3b8;
        --line: #243044;
        --field: #1e293b;
        --field-f: #1e293b;
        --label: #cbd5e1;
        --stage-a: color-mix(in srgb, var(--accent) 30%, #0f172a);
        --stage-b: color-mix(in srgb, var(--accent2) 24%, #0b1120);
        --shadow: 0 40px 80px -30px rgba(0, 0, 0, .6);
        color-scheme: dark;
    }

    #{{ $fid }} .rjf-card {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr);
        max-width: 980px;
        margin: 0 auto;
        overflow: hidden;
        background: var(--card);
        color: var(--fg);
        border: 1px solid var(--line);
        border-radius: var(--r);
        box-shadow: var(--shadow);
        animation: rjf-in .6s cubic-bezier(.16, 1, .3, 1) both;
    }
    #{{ $fid }}[data-side="left"] .rjf-stage { order: -1; }
    #{{ $fid }}[data-mascot="0"] .rjf-card { grid-template-columns: minmax(0, 1fr); max-width: 640px; }

    #{{ $fid }} .rjf-main {
        position: relative;
        min-width: 0;
        padding: clamp(22px, 4vw, 44px);
        container-name: rjf-m;
        container-type: inline-size;
    }

    /* Form Title */
    #{{ $fid }} .rjf-header {
        margin-bottom: 24px;
    }
    #{{ $fid }} .rjf-title {
        margin: 0 0 6px;
        font-size: clamp(20px, 4vw, 26px);
        font-weight: 800;
        color: var(--fg);
        letter-spacing: -0.02em;
    }
    #{{ $fid }} .rjf-desc {
        margin: 0;
        font-size: 14.5px;
        color: var(--muted);
        line-height: 1.5;
    }

    #{{ $fid }} .rjf-progress {
        height: 4px;
        margin-bottom: 24px;
        overflow: hidden;
        border-radius: 999px;
        background: var(--line);
    }
    #{{ $fid }} .rjf-progress i {
        display: block;
        width: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, var(--accent), var(--accent2));
        transition: width .45s cubic-bezier(.16, 1, .3, 1);
    }

    #{{ $fid }} .rjf-in { animation: rjf-in .6s cubic-bezier(.16, 1, .3, 1) both var(--d, 0s); }

    #{{ $fid }} .rj-form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .01em;
        color: var(--label);
        transition: color .2s;
    }
    #{{ $fid }} .rj-form-field:focus-within .rj-form-label { color: var(--accent); }
    #{{ $fid }} .rj-form-req { margin-left: 2px; color: #ef4444; }
    #{{ $fid }} .rj-form-help { margin-top: 6px; font-size: 11.5px; line-height: 1.4; color: var(--muted); }

    /* Unified Input Styles */
    #{{ $fid }} .rj-form-input,
    #{{ $fid }} .rj-form textarea,
    #{{ $fid }} .rj-form select {
        box-sizing: border-box;
        width: 100%;
        padding: 13px 16px;
        border: 1.5px solid var(--line);
        border-radius: 12px;
        background-color: var(--field);
        color: var(--fg);
        font: inherit;
        font-size: 14.5px;
        outline: 0;
        transition: border-color .2s, box-shadow .2s, background-color .2s;
    }
    #{{ $fid }} .rj-form-input::placeholder,
    #{{ $fid }} .rj-form textarea::placeholder { color: #94a3b8; }
    #{{ $fid }} .rj-form-input:focus,
    #{{ $fid }} .rj-form textarea:focus,
    #{{ $fid }} .rj-form select:focus {
        border-color: var(--accent);
        background-color: var(--field-f);
        box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent) 16%, transparent);
    }
    #{{ $fid }} .rj-form textarea { min-height: 120px; line-height: 1.5; resize: vertical; }
    #{{ $fid }} .rj-form select {
        padding-right: 42px;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        cursor: pointer;
    }

    /* Minimal Preset Overrides */
    #{{ $fid }}[data-preset="minimal"] .rj-form-label { font-size: 11px; letter-spacing: .08em; text-transform: uppercase; }
    #{{ $fid }}[data-preset="minimal"] .rj-form-input,
    #{{ $fid }}[data-preset="minimal"] .rj-form textarea,
    #{{ $fid }}[data-preset="minimal"] .rj-form select {
        padding-left: 0;
        padding-right: 0;
        border-width: 0 0 2px;
        border-radius: 0;
        background-color: transparent;
        box-shadow: none;
    }
    #{{ $fid }}[data-preset="minimal"] .rj-form select { padding-right: 28px; background-position: right 2px center; }
    #{{ $fid }}[data-preset="minimal"] .rj-form-input:focus,
    #{{ $fid }}[data-preset="minimal"] .rj-form textarea:focus,
    #{{ $fid }}[data-preset="minimal"] .rj-form select:focus { background-color: transparent; box-shadow: none; }

    #{{ $fid }} .rj-form-checkbox-group { display: flex; flex-direction: column; gap: 10px; margin-top: 4px; }
    #{{ $fid }} .rj-form-checkbox {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 14.5px;
        line-height: 1.4;
        color: var(--muted);
        cursor: pointer;
    }
    #{{ $fid }} .rj-form-checkbox input { flex-shrink: 0; width: 18px; height: 18px; margin: 0; accent-color: var(--accent); }

    /* Layouts */
    #{{ $fid }} .rj-form-stack .rj-form-field { margin-bottom: 18px; }
    #{{ $fid }} .rj-form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    #{{ $fid }} .rj-form-grid-2 .rj-form-field-full,
    #{{ $fid }} .rj-form-grid-2 .rj-form-actions,
    #{{ $fid }} .rj-form-grid-2 .rj-form-message { grid-column: 1 / -1; }
    #{{ $fid }} .rj-form-inline { display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; }
    #{{ $fid }} .rj-form-inline .rj-form-field { flex: 1 1 180px; min-width: 0; }
    #{{ $fid }} .rj-form-inline .rj-form-actions { flex: 0 0 auto; }
    #{{ $fid }} .rj-form-inline .rj-form-message { flex: 1 0 100%; }

    /* Submit Button */
    #{{ $fid }} .rj-form-actions { margin-top: 6px; }
    #{{ $fid }} .rj-form-submit {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 26px;
        border: 0;
        border-radius: 12px;
        background: var(--accent);
        color: #fff;
        font: inherit;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 14px 26px -14px var(--accent);
        transition: transform .18s, filter .2s, box-shadow .2s;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $fid }} .rj-form-submit::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -60%;
        width: 40%;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .4), transparent);
        transform: skewX(-20deg);
        animation: rjf-shine 3.8s ease-in-out infinite;
        pointer-events: none;
    }
    #{{ $fid }} .rj-form-submit:hover { filter: brightness(1.07); transform: translateY(-1px); }
    #{{ $fid }} .rj-form-submit:active { transform: scale(.98); }
    #{{ $fid }} .rj-form-submit svg { width: 17px; height: 17px; flex-shrink: 0; transition: transform .25s; }
    #{{ $fid }} .rj-form-submit:hover svg { transform: translate(3px, -3px); }
    #{{ $fid }} .rj-form-submit.is-loading { cursor: wait; }
    #{{ $fid }} .rj-form-submit.is-loading svg { display: none; }
    #{{ $fid }} .rj-form-submit.is-loading::before {
        content: "";
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, .4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: rjf-spin .7s linear infinite;
    }

    /* Submit Button Presets */
    #{{ $fid }}[data-preset="modern"] .rj-form-submit { width: 100%; background: linear-gradient(135deg, var(--accent), var(--accent2)); }
    #{{ $fid }}[data-preset="dark"] .rj-form-submit { width: 100%; }
    #{{ $fid }}[data-preset="minimal"] .rj-form-submit {
        padding: 12px 0;
        border-radius: 0;
        border-bottom: 2px solid var(--accent);
        background: transparent;
        color: var(--accent);
        box-shadow: none;
    }
    #{{ $fid }}[data-preset="minimal"] .rj-form-submit::after { display: none; }
    #{{ $fid }}[data-preset="minimal"] .rj-form-submit.is-loading::before { border-color: color-mix(in srgb, var(--accent) 30%, transparent); border-top-color: var(--accent); }

    /* Stage & Mascot */
    #{{ $fid }} .rjf-stage {
        position: relative;
        overflow: hidden;
        min-height: 380px;
        background:
            radial-gradient(circle at 18% 12%, rgba(255, 255, 255, .7), transparent 45%),
            linear-gradient(160deg, var(--stage-a), var(--stage-b));
    }
    #{{ $fid }}[data-preset="dark"] .rjf-stage {
        background:
            radial-gradient(circle at 18% 12%, rgba(255, 255, 255, .08), transparent 45%),
            linear-gradient(160deg, var(--stage-a), var(--stage-b));
    }
    #{{ $fid }} .rjf-orb {
        position: absolute;
        border-radius: 50%;
        background: color-mix(in srgb, var(--accent) 22%, transparent);
        animation: rjf-drift 12s ease-in-out infinite alternate;
    }
    #{{ $fid }} .rjf-orb:nth-child(1) { top: -40px; right: -40px; width: 170px; height: 170px; }
    #{{ $fid }} .rjf-orb:nth-child(2) { bottom: 90px; left: -50px; width: 120px; height: 120px; animation-delay: -5s; }

    #{{ $fid }} .rjf-bubble {
        position: absolute;
        top: 18px;
        left: 50%;
        z-index: 3;
        max-width: 88%;
        margin: 0;
        padding: 8px 16px;
        translate: -50% 0;
        overflow: hidden;
        border-radius: 999px;
        background: #fff;
        color: #0f172a;
        font-size: 13px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
        box-shadow: 0 12px 24px -12px rgba(15, 23, 42, .4);
    }
    #{{ $fid }} .rjf-bubble.is-pop { animation: rjf-pop .4s cubic-bezier(.34, 1.56, .64, 1); }

    #{{ $fid }} .rjf-svg {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: var(--bt);
        width: 100%;
        height: calc(100% - var(--bt));
        overflow: hidden;
    }
    #{{ $fid }} .rjf-svg .shadow { fill: rgba(15, 23, 42, .16); }
    #{{ $fid }} .rjf-svg .shine { fill: none; stroke: rgba(255, 255, 255, .4); stroke-width: 8; stroke-linecap: round; }
    #{{ $fid }} .rjf-svg .hand { fill: var(--accent-d); }
    #{{ $fid }} .rjf-svg .sc { fill: #fff; stroke: rgba(15, 23, 42, .12); stroke-width: 2; }
    #{{ $fid }} .rjf-svg .cheek { fill: #fda4af; opacity: .45; }
    #{{ $fid }} .rjf-svg .brow {
        fill: none;
        stroke: rgba(255, 255, 255, .92);
        stroke-width: 5;
        stroke-linecap: round;
        transform-box: fill-box;
        transform-origin: center;
        transition: transform .25s;
    }
    #{{ $fid }} .rjf-svg .pupil {
        transform: translate(calc(var(--px, 0) * 1px), calc(var(--py, 0) * 1px));
        transition: transform .14s ease-out;
    }
    #{{ $fid }} .rjf-svg .pupil circle:first-child { fill: #0f172a; }
    #{{ $fid }} .rjf-svg .pupil circle:last-child { fill: #fff; }
    #{{ $fid }} .rjf-svg .eye {
        transform-box: fill-box;
        transform-origin: center;
        animation: rjf-blink 5.2s infinite;
    }
    #{{ $fid }} .rjf-svg .char,
    #{{ $fid }} .rjf-svg .breath,
    #{{ $fid }} .rjf-svg .act { transform-origin: 160px 278px; }
    #{{ $fid }} .rjf-svg .char {
        transform: rotate(calc(var(--lean, 0) * 1deg + var(--tilt, 0) * 1deg));
        transition: transform .35s ease-out;
    }
    #{{ $fid }} .rjf-svg .breath { animation: rjf-breathe 4s ease-in-out infinite; }

    #{{ $fid }} .rjf-svg .m { display: none; }
    #{{ $fid }} .rjf-svg .m-line { fill: none; stroke: rgba(255, 255, 255, .95); stroke-width: 5; stroke-linecap: round; stroke-linejoin: round; }
    #{{ $fid }} .rjf-svg .m-o { fill: #1e1b4b; }
    #{{ $fid }} .rjf-svg .m-happy .mouth-in { fill: #1e1b4b; }
    #{{ $fid }} .rjf-svg .m-happy .tongue { fill: #fb7185; }
    #{{ $fid }}:is([data-state="idle"], [data-state="focus"]) .rjf-svg .m-idle { display: inline; }
    #{{ $fid }}:is([data-state="email"], [data-state="curious"]) .rjf-svg .m-o { display: inline; }
    #{{ $fid }}[data-state="reading"] .rjf-svg .m-flat { display: inline; }
    #{{ $fid }}:is([data-state="happy"], [data-state="success"]) .rjf-svg .m-happy { display: inline; }
    #{{ $fid }}[data-state="error"] .rjf-svg .m-sad { display: inline; }
    #{{ $fid }}[data-state="wait"] .rjf-svg .m-wait { display: inline; }

    #{{ $fid }}:is([data-state="email"], [data-state="curious"]) .rjf-svg .brow { transform: translateY(-7px); }
    #{{ $fid }}[data-state="error"] .rjf-svg .bl { transform: rotate(-13deg) translateY(1px); }
    #{{ $fid }}[data-state="error"] .rjf-svg .br { transform: rotate(13deg) translateY(1px); }
    #{{ $fid }}[data-state="curious"] .rjf-svg { --tilt: -5; }
    #{{ $fid }}[data-state="email"] .rjf-svg { --tilt: 3; }
    #{{ $fid }}:is([data-state="happy"], [data-state="success"]) .rjf-svg .eye { animation: none; transform: scaleY(.5); }

    #{{ $fid }}.is-typing .rjf-svg .hl { animation: rjf-type .26s ease-in-out infinite alternate; }
    #{{ $fid }}.is-typing .rjf-svg .hr { animation: rjf-type .26s ease-in-out infinite alternate .13s; }
    #{{ $fid }} .rjf-svg .hr { transform-box: fill-box; transform-origin: 50% 90%; }
    #{{ $fid }}:is([data-state="happy"], [data-state="success"]) .rjf-svg .hr { animation: rjf-wave .5s ease-in-out infinite alternate; }
    #{{ $fid }}:is([data-state="happy"], [data-state="success"]) .rjf-svg .act { animation: rjf-jump .8s ease-in-out infinite; }
    #{{ $fid }}[data-state="error"] .rjf-svg .act { animation: rjf-shake .5s; }

    #{{ $fid }} .rjf-svg .plane { fill: #fff; stroke: var(--accent); stroke-width: 3; stroke-linejoin: round; animation: rjf-float 3.2s ease-in-out infinite; }
    #{{ $fid }} .rjf-svg .plane .fold { fill: none; }
    #{{ $fid }}[data-state="wait"] .rjf-svg .plane { animation: rjf-fly 1.2s ease-in infinite; }
    #{{ $fid }}[data-state="success"] .rjf-svg .plane { animation: rjf-fly 1.2s ease-in 1 forwards; }

    #{{ $fid }} .rjf-svg .sp {
        fill: #fbbf24;
        opacity: 0;
        transform-box: fill-box;
        transform-origin: center;
    }
    #{{ $fid }}:is([data-state="happy"], [data-state="success"]) .rjf-svg .sp { animation: rjf-spark 1.4s ease-out infinite var(--d, 0s); }

    /* Media Queries */
    @container rjf-w (max-width: 760px) {
        #{{ $fid }} .rjf-card { grid-template-columns: minmax(0, 1fr); border-radius: min(var(--r), 20px); }
        #{{ $fid }} .rjf-stage { order: -1; height: 176px; min-height: 0; --bt: 44px; }
        #{{ $fid }} .rjf-orb:nth-child(2) { display: none; }
        #{{ $fid }} .rjf-bubble { top: 10px; padding: 6px 13px; font-size: 12px; }
        #{{ $fid }} .rjf-main { padding: 20px 18px 22px; }
        #{{ $fid }} .rjf-header { margin-bottom: 18px; text-align: center; }
        #{{ $fid }} .rjf-progress { margin-bottom: 18px; }
    }

    @container rjf-m (max-width: 460px) {
        #{{ $fid }} .rj-form-grid-2 { grid-template-columns: 1fr; }
        #{{ $fid }} .rj-form-inline { flex-direction: column; align-items: stretch; }
        #{{ $fid }} .rj-form-inline .rj-form-field { flex: 0 0 auto; }
        #{{ $fid }} .rj-form-submit { width: 100%; }
        #{{ $fid }}[data-preset="minimal"] .rj-form-submit { width: auto; }
    }

    @media (max-width: 640px) {
        #{{ $fid }} .rj-form-input,
        #{{ $fid }} .rj-form textarea,
        #{{ $fid }} .rj-form select { padding-top: 12px; padding-bottom: 12px; font-size: 16px; }
        #{{ $fid }}[data-preset="minimal"] .rj-form-input,
        #{{ $fid }}[data-preset="minimal"] .rj-form textarea,
        #{{ $fid }}[data-preset="minimal"] .rj-form select { padding-left: 0; padding-right: 0; }
        #{{ $fid }} .rj-form-stack .rj-form-field { margin-bottom: 15px; }
    }

    /* Keyframes */
    @keyframes rjf-in { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes rjf-pop { from { opacity: 0; scale: .85; } }
    @keyframes rjf-shine { 0%, 55% { left: -60%; } 100% { left: 130%; } }
    @keyframes rjf-spin { to { rotate: 360deg; } }
    @keyframes rjf-drift { to { translate: 14px 10px; } }
    @keyframes rjf-breathe { 50% { transform: scaleY(1.025); } }
    @keyframes rjf-blink { 0%, 93%, 100% { transform: scaleY(1); } 96% { transform: scaleY(.08); } }
    @keyframes rjf-float { 50% { transform: translateY(-6px) rotate(-5deg); } }
    @keyframes rjf-fly {
        0% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 1; }
        100% { transform: translate(80px, -56px) rotate(10deg) scale(.6); opacity: 0; }
    }
    @keyframes rjf-type { to { transform: translateY(-9px); } }
    @keyframes rjf-wave { from { transform: rotate(-22deg); } to { transform: rotate(24deg); } }
    @keyframes rjf-jump { 0%, 100% { transform: translateY(0); } 45% { transform: translateY(-14px); } }
    @keyframes rjf-shake { 20%, 60% { transform: rotate(-3deg); } 40%, 80% { transform: rotate(3deg); } }
    @keyframes rjf-spark {
        0% { opacity: 0; transform: translateY(0) scale(.3); }
        25% { opacity: 1; }
        100% { opacity: 0; transform: translateY(-34px) scale(1) rotate(90deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $fid }} *, #{{ $fid }} *::before, #{{ $fid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $fid }}"
     class="rj-form-wrap rj-form-preset-{{ $preset }}"
     data-preset="{{ $preset }}"
     data-side="{{ $stageSide }}"
     data-mascot="{{ $showMascot ? 1 : 0 }}"
     data-state="idle">
    <div class="rjf-card">
        <section class="rjf-main">
            @if($form->name)
                <div class="rjf-header rjf-in" style="--d: 0s;">
                    <h2 class="rjf-title">{{ __($form->name) }}</h2>
                    @if($form->description ?? $form->excerpt ?? false)
                        <p class="rjf-desc">{{ __($form->description ?? $form->excerpt) }}</p>
                    @endif
                </div>
            @endif

            <div class="rjf-progress" aria-hidden="true"><i></i></div>

            <form method="POST" action="{{ route('plugin.form.submit', $form->slug) }}" class="rj-form {{ $layoutClass }}">
                @csrf

                @foreach($form->fields as $index => $field)
                    @php
                        $required = $field->is_required ? 'required' : '';
                        $reqMark  = $field->is_required ? '<span class="rj-form-req">*</span>' : '';
                        // Header varsa animasiya gecikməsini 1 addım artırırıq
                        $delay    = number_format(($index + ($form->name ? 1 : 0)) * 0.07, 2, '.', '');
                    @endphp

                    @if($field->type === 'textarea')
                        <div class="rj-form-field rj-form-field-textarea rj-form-field-full rjf-in" style="--d: {{ $delay }}s;">
                            <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                            <textarea name="{{ $field->name }}" placeholder="{{ __($field->placeholder) }}" {{ $required }} rows="5">{{ old($field->name) }}</textarea>
                            @if($field->help_text)
                                <div class="rj-form-help">{{ __($field->help_text) }}</div>
                            @endif
                        </div>

                    @elseif($field->type === 'select')
                        <div class="rj-form-field rjf-in" style="--d: {{ $delay }}s;">
                            <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                            <select name="{{ $field->name }}" {{ $required }}>
                                <option value="">{{ __($field->placeholder ?: 'Select an option') }}</option>
                                @if(is_array($field->options))
                                    @foreach($field->options as $option)
                                        <option value="{{ $option }}" {{ old($field->name) === (string) $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($field->help_text)
                                <div class="rj-form-help">{{ __($field->help_text) }}</div>
                            @endif
                        </div>

                    @elseif($field->type === 'checkbox')
                        <div class="rj-form-field rjf-in" style="--d: {{ $delay }}s;">
                            <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                            <div class="rj-form-checkbox-group">
                                @if(is_array($field->options))
                                    @foreach($field->options as $option)
                                        <label class="rj-form-checkbox">
                                            <input type="checkbox" name="{{ $field->name }}[]" value="{{ $option }}" {{ $required }}>
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <label class="rj-form-checkbox">
                                        <input type="checkbox" name="{{ $field->name }}" value="1" {{ $required }}>
                                        <span>{{ __($field->placeholder ?: $field->label) }}</span>
                                    </label>
                                @endif
                            </div>
                            @if($field->help_text)
                                <div class="rj-form-help">{{ __($field->help_text) }}</div>
                            @endif
                        </div>

                    @else
                        @php
                            $type = in_array($field->type, ['text', 'email', 'tel', 'url', 'number', 'date', 'time']) ? $field->type : 'text';
                        @endphp
                        <div class="rj-form-field rjf-in" style="--d: {{ $delay }}s;">
                            <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                            <input type="{{ $type }}" name="{{ $field->name }}" value="{{ old($field->name) }}" placeholder="{{ __($field->placeholder) }}" class="rj-form-input" {{ $required }}>
                            @if($field->help_text)
                                <div class="rj-form-help">{{ __($field->help_text) }}</div>
                            @endif
                        </div>
                    @endif
                @endforeach

                <div class="rj-form-actions rjf-in" style="--d: {{ number_format(($fieldCount + ($form->name ? 1 : 0)) * 0.07, 2, '.', '') }}s;">
                    <button type="submit" class="rj-form-submit">
                        <span>{{ __('Submit') }}</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg>
                    </button>
                </div>

                <div class="rj-form-message" style="display: none; padding: 14px 16px; border-radius: 10px; font-size: 14px; margin-top: 20px; font-weight: 500;"></div>
            </form>
        </section>

        @if($showMascot)
            <aside class="rjf-stage" aria-hidden="true">
                <span class="rjf-orb"></span><span class="rjf-orb"></span>
                <p class="rjf-bubble"></p>

                <svg class="rjf-svg" viewBox="0 0 320 300" preserveAspectRatio="xMidYMax meet" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="{{ $fid }}-g" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" style="stop-color: var(--accent)"/>
                            <stop offset="1" style="stop-color: var(--accent2)"/>
                        </linearGradient>
                    </defs>

                    <ellipse class="shadow" cx="160" cy="280" rx="104" ry="9"/>

                    <g transform="translate(226 60)">
                        <g class="plane">
                            <path d="M0 0 L46 -16 L30 20 L19 8 Z"/>
                            <path class="fold" d="M19 8 L46 -16"/>
                        </g>
                    </g>

                    <g>
                        <g transform="translate(52 112)"><path class="sp" style="--d: 0s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                        <g transform="translate(270 104)"><path class="sp" style="--d: .25s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                        <g transform="translate(36 192)"><path class="sp" style="--d: .5s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                        <g transform="translate(286 184)"><path class="sp" style="--d: .75s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                        <g transform="translate(108 40)"><path class="sp" style="--d: .35s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                        <g transform="translate(208 34)"><path class="sp" style="--d: .6s" d="M0 -9 L2.4 -2.4 L9 0 L2.4 2.4 L0 9 L-2.4 2.4 L-9 0 L-2.4 -2.4Z"/></g>
                    </g>

                    <g class="char">
                        <g class="breath">
                            <g class="act">
                                <path d="M56 278 C46 152 86 56 160 56 C234 56 274 152 264 278 Z" fill="url(#{{ $fid }}-g)"/>
                                <path class="shine" d="M94 126 C104 92 128 74 150 70"/>

                                <ellipse class="hand hl" cx="60" cy="238" rx="15" ry="19"/>
                                <ellipse class="hand hr" cx="260" cy="238" rx="15" ry="19"/>

                                <path class="brow bl" d="M102 108 Q126 96 150 108"/>
                                <path class="brow br" d="M170 108 Q194 96 218 108"/>

                                <g class="eye">
                                    <circle class="sc" cx="126" cy="142" r="24"/>
                                    <g class="pupil"><circle cx="126" cy="142" r="11"/><circle cx="130" cy="137" r="3.6"/></g>
                                </g>
                                <g class="eye">
                                    <circle class="sc" cx="194" cy="142" r="24"/>
                                    <g class="pupil"><circle cx="194" cy="142" r="11"/><circle cx="198" cy="137" r="3.6"/></g>
                                </g>

                                <ellipse class="cheek" cx="96" cy="178" rx="13" ry="7"/>
                                <ellipse class="cheek" cx="224" cy="178" rx="13" ry="7"/>

                                <path class="m m-line m-idle" d="M142 184 Q160 200 178 184"/>
                                <ellipse class="m m-o" cx="160" cy="190" rx="9" ry="11"/>
                                <path class="m m-line m-flat" d="M146 190 H174"/>
                                <g class="m m-happy">
                                    <path class="mouth-in" d="M134 178 Q160 216 186 178 Z"/>
                                    <path class="tongue" d="M148 194 Q160 206 172 194 Q160 188 148 194 Z"/>
                                </g>
                                <path class="m m-line m-sad" d="M144 198 Q160 182 176 198"/>
                                <path class="m m-line m-wait" d="M140 190 q7 -9 14 0 t14 0 t14 0"/>
                            </g>
                        </g>
                    </g>
                </svg>
            </aside>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($fid));
    if (!root) return;

    var T         = @js($texts);
    var hasErrors = @js($hasErrors);

    var form   = root.querySelector('form');
    var stage  = root.querySelector('.rjf-stage');
    var svg    = root.querySelector('.rjf-svg');
    var bubble = root.querySelector('.rjf-bubble');
    var bar    = root.querySelector('.rjf-progress i');
    var msgEl  = root.querySelector('.rj-form-message');
    var submit = root.querySelector('.rj-form-submit');
    if (!form) return;

    var mascot = !!(stage && svg);
    var focusEl = null, flash = '', flashT = 0, busy = false, busyT = 0;
    var typeT = 0, pointer = null, frame = 0, ready = false, lastP = 0, seen = '';

    function kind(el) {
        var tag = el.tagName, t = (el.type || '').toLowerCase();
        if (tag === 'TEXTAREA') return 'reading';
        if (tag === 'SELECT') return 'curious';
        if (t === 'email') return 'email';
        if (t === 'date' || t === 'time') return 'curious';
        return 'focus';
    }

    function current() {
        if (flash) return flash;
        if (busy) return 'wait';
        if (focusEl) return kind(focusEl);
        return 'idle';
    }

    function say(s, text) {
        if (!bubble) return;
        bubble.textContent = text || T[s] || '';
        bubble.classList.remove('is-pop');
        void bubble.offsetWidth;
        bubble.classList.add('is-pop');
    }

    function target(el) {
        var r = el.getBoundingClientRect();
        var tag = el.tagName, t = (el.type || '').toLowerCase();
        var x = r.left + r.width / 2, y = r.top + r.height / 2;
        if (tag === 'TEXTAREA') {
            var rows = el.value.split('\n');
            x = r.left + Math.min(r.width - 24, 20 + rows[rows.length - 1].length * 7.5);
            y = r.top + Math.min(r.height - 20, 20 + (rows.length - 1) * 22);
        } else if (tag === 'INPUT' && t !== 'checkbox' && t !== 'radio') {
            x = r.left + Math.min(r.width - 24, 20 + el.value.length * 8);
        }
        return [x, y];
    }

    function aim() {
        if (!mascot) return;
        var s = root.dataset.state, x = 0, y = 0, tx = null, ty = null;
        var r = svg.getBoundingClientRect();
        var cx = r.left + r.width / 2, cy = r.top + r.height * .45;

        if (s === 'wait') { x = 8; y = -8; }
        else if (s === 'success' || s === 'happy') { x = 0; y = -4; }
        else if (s === 'error') { x = 0; y = 3; }
        else if (focusEl) { var t = target(focusEl); tx = t[0]; ty = t[1]; }
        else if (pointer) { tx = pointer.x; ty = pointer.y; }

        if (tx !== null) {
            var dx = tx - cx, dy = ty - cy, d = Math.hypot(dx, dy) || 1, k = Math.min(1, d / 240);
            x = dx / d * k * 10;
            y = dy / d * k * 10;
        }

        svg.style.setProperty('--px', x.toFixed(2));
        svg.style.setProperty('--py', y.toFixed(2));
        svg.style.setProperty('--lean', (x * .35).toFixed(2));
    }

    function queue() {
        if (!frame) frame = requestAnimationFrame(function () { frame = 0; aim(); });
    }

    function sync(force, text) {
        var s = current();
        if (force || root.dataset.state !== s) {
            root.dataset.state = s;
            say(s, text);
        }
        aim();
    }

    function pulse(s, ms, text) {
        flash = s;
        clearTimeout(flashT);
        flashT = setTimeout(function () { flash = ''; sync(); }, ms);
        sync(true, text);
    }

    function release() {
        busy = false;
        clearTimeout(busyT);
        if (submit) submit.classList.remove('is-loading');
    }

    function progress() {
        var els = Array.prototype.slice.call(form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]), textarea, select'));
        var req = els.filter(function (el) { return el.required; });
        var list = req.length ? req : els;
        var groups = {};

        list.forEach(function (el, i) {
            var key = el.name || el.id || ('f' + i);
            var filled = (el.type === 'checkbox' || el.type === 'radio') ? el.checked : String(el.value).trim() !== '';
            groups[key] = groups[key] || filled;
        });

        var keys = Object.keys(groups);
        var done = keys.filter(function (k) { return groups[k]; }).length;
        var p = keys.length ? done / keys.length : 0;

        if (bar) bar.style.width = (p * 100).toFixed(0) + '%';
        if (ready && p === 1 && lastP < 1 && mascot) pulse('happy', 2200, T.done);
        lastP = p;
    }

    function isError() {
        if (/err|danger|fail|invalid|warn/i.test(msgEl.className)) return true;
        var m = getComputedStyle(msgEl).color.match(/\d+/g);
        if (!m) return false;
        var r = +m[0], g = +m[1], b = +m[2];
        return r > g + 40 && r > b + 40;
    }

    form.addEventListener('focusin', function (e) {
        if (!e.target.matches('input, textarea, select')) return;
        focusEl = e.target;
        sync();
    });

    form.addEventListener('focusout', function () {
        focusEl = null;
        sync();
    });

    form.addEventListener('input', function () {
        root.classList.add('is-typing');
        clearTimeout(typeT);
        typeT = setTimeout(function () { root.classList.remove('is-typing'); }, 650);
        progress();
        queue();
    });

    form.addEventListener('change', function (e) {
        if (e.target.type === 'checkbox' && e.target.checked && mascot) pulse('happy', 1100, T.happy);
        progress();
    });

    form.addEventListener('invalid', function () {
        if (mascot) pulse('error', 1700);
    }, true);

    form.addEventListener('submit', function () {
        busy = true;
        if (submit) submit.classList.add('is-loading');
        clearTimeout(busyT);
        busyT = setTimeout(function () { release(); sync(); }, 9000);
        sync();
    });

    if (msgEl && window.MutationObserver) {
        new MutationObserver(function () {
            var c = getComputedStyle(msgEl);
            var text = msgEl.textContent.trim();
            if (c.display === 'none' || !text) { seen = ''; return; }
            var key = text + '|' + c.display;
            if (key === seen) return;
            seen = key;
            release();
            pulse(isError() ? 'error' : 'success', 3500);
        }).observe(msgEl, { attributes: true, childList: true, characterData: true, subtree: true });
    }

    document.addEventListener('pointermove', function (e) { pointer = { x: e.clientX, y: e.clientY }; queue(); });
    document.addEventListener('pointerdown', function (e) { pointer = { x: e.clientX, y: e.clientY }; queue(); });
    window.addEventListener('scroll', queue, { passive: true });
    window.addEventListener('resize', queue);

    progress();
    ready = true;
    sync(true);
    if (hasErrors && mascot) pulse('error', 2600);
})();
</script>
