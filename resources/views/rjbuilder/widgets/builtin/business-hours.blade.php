@php
    $title       = $settings['title'] ?? __('Opening Hours');
    $subtitle    = $settings['subtitle'] ?? '';
    $timezone    = trim((string) ($settings['timezone'] ?? 'auto'));
    $timeFormat  = ($settings['time_format'] ?? '24h') === '12h' ? '12h' : '24h';
    $showStatus  = !empty($settings['show_status'] ?? true);
    $showWeek    = !empty($settings['show_week'] ?? true);
    $highlight   = !empty($settings['highlight_today'] ?? true);
    $layoutRaw   = $settings['layout'] ?? 'card';
    $minimal     = $layoutRaw === 'minimal';
    $closedLabel = $settings['closed_label'] ?? __('Closed');
    $openLabel   = $settings['open_label'] ?? __('Open Now');
    $closedNow   = $settings['closed_now_label'] ?? __('Closed Now');
    $footerNote  = trim((string) ($settings['footer_note'] ?? ''));
    $paddingY    = max(0, min(200, (int) ($settings['padding_y'] ?? 40)));

    $norm = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $v)) {
            $v = $d;
        }
        $h = ltrim($v, '#');
        if (strlen($h) === 3) {
            $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
        } elseif (strlen($h) === 8) {
            $h = substr($h, 0, 6);
        }
        return '#' . strtolower($h);
    };

    $accent  = $norm($settings['accent'] ?? '', '#8b5cf6');
    $textCol = $norm($settings['text_color'] ?? '', '#0f172a');
    $muteCol = $norm($settings['muted_color'] ?? '', '#64748b');
    $ah = ltrim($accent, '#');
    $accentRgb = hexdec(substr($ah, 0, 2)) . ',' . hexdec(substr($ah, 2, 2)) . ',' . hexdec(substr($ah, 4, 2));

    $radiusMap = ['none' => '0px', 'md' => '14px', 'lg' => '26px', 'xl' => '38px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'lg'] ?? '26px';

    $dayOrder  = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    $dayLabels = [
        'mon' => __('Monday'), 'tue' => __('Tuesday'), 'wed' => __('Wednesday'),
        'thu' => __('Thursday'), 'fri' => __('Friday'), 'sat' => __('Saturday'),
        'sun' => __('Sunday'),
    ];
    $dayShort = [
        'mon' => __('Mon'), 'tue' => __('Tue'), 'wed' => __('Wed'),
        'thu' => __('Thu'), 'fri' => __('Fri'), 'sat' => __('Sat'),
        'sun' => __('Sun'),
    ];

    $toMin = function ($t) {
        $p = explode(':', trim((string) $t));
        if (count($p) < 2 || !is_numeric($p[0]) || !is_numeric($p[1])) {
            return null;
        }
        return ((int) $p[0]) * 60 + (int) $p[1];
    };
    $fmtTime = function ($t) use ($timeFormat, $toMin) {
        $m = $toMin($t);
        if ($m === null) {
            return (string) $t;
        }
        $h = intdiv($m, 60) % 24;
        $mi = $m % 60;
        if ($timeFormat === '12h') {
            $ap = $h >= 12 ? 'PM' : 'AM';
            $h12 = $h % 12 ?: 12;
            return $h12 . ':' . sprintf('%02d', $mi) . ' ' . $ap;
        }
        return sprintf('%02d:%02d', $h, $mi);
    };

    $byDay = [];
    foreach ($dayOrder as $d) {
        $byDay[$d] = null;
    }
    if (!empty($settings['schedule']) && is_array($settings['schedule'])) {
        foreach ($settings['schedule'] as $row) {
            if (!is_array($row)) {
                continue;
            }
            $day = $row['day'] ?? '';
            if (!in_array($day, $dayOrder, true)) {
                continue;
            }
            $byDay[$day] = [
                'open'   => trim((string) ($row['open'] ?? '')),
                'close'  => trim((string) ($row['close'] ?? '')),
                'closed' => !empty($row['closed']) && (string) $row['closed'] === '1',
                'note'   => trim((string) ($row['note'] ?? '')),
            ];
        }
    }

    $hasAny = false;
    foreach ($byDay as $s) {
        if ($s !== null) {
            $hasAny = true;
            break;
        }
    }

    $days = [];
    $jsSchedule = [];
    foreach ($dayOrder as $d) {
        $s = $byDay[$d];
        $o = $s ? $toMin($s['open']) : null;
        $c = $s ? $toMin($s['close']) : null;
        $closed = $s === null || $s['closed'] || $o === null || $c === null;
        $segs = [];
        if (!$closed) {
            if ($c > $o) {
                $segs[] = [$o / 14.4, ($c - $o) / 14.4];
            } elseif ($c === $o) {
                $segs[] = [0, 100];
            } else {
                $segs[] = [$o / 14.4, 100 - $o / 14.4];
                $segs[] = [0, $c / 14.4];
            }
        }
        $days[$d] = [
            'closed' => $closed,
            'open'   => $closed ? '' : $fmtTime($s['open']),
            'close'  => $closed ? '' : $fmtTime($s['close']),
            'note'   => $s['note'] ?? '',
            'segs'   => $segs,
        ];
        $jsSchedule[$d] = ['closed' => $closed, 'open' => $s['open'] ?? '', 'close' => $s['close'] ?? ''];
    }

    $rootClass = 'rj-oh' . ($minimal ? ' rj-oh--min' : '');
@endphp

@once
<style>
    @keyframes rjOhSweep { to { transform: rotate(360deg); } }
    @keyframes rjOhIn {
        from { opacity: 0; transform: translateY(26px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjOhBlink {
        0%, 90%, 100% { transform: scaleY(0); }
        94%           { transform: scaleY(1); }
    }
    @keyframes rjOhHop {
        0%, 100% { transform: translateY(0) scale(1, 1); }
        15%      { transform: translateY(0) scale(1.08, .9); }
        45%      { transform: translateY(-14px) scale(.94, 1.08); }
        75%      { transform: translateY(0) scale(1.06, .93); }
    }
    @keyframes rjOhBreath {
        0%, 100% { transform: rotate(-5deg) scale(1); }
        50%      { transform: rotate(-5deg) scale(1.035, .97); }
    }
    @keyframes rjOhWave {
        0%, 100% { transform: rotate(0deg); }
        50%      { transform: rotate(-32deg); }
    }
    @keyframes rjOhWob {
        0%, 100% { transform: rotate(-9deg); }
        50%      { transform: rotate(9deg); }
    }
    @keyframes rjOhZ {
        0%   { opacity: 0; transform: translate(0, 8px) scale(.6); }
        30%  { opacity: 1; }
        100% { opacity: 0; transform: translate(10px, -26px) scale(1.15); }
    }
    @keyframes rjOhPulse {
        0%, 100% { box-shadow: 0 0 0 0 currentColor; }
        70%      { box-shadow: 0 0 0 7px transparent; }
    }
    @keyframes rjOhColon {
        0%, 49% { opacity: 1; }
        50%, 100% { opacity: .2; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --ar: {{ $accentRgb }};
        --tx: {{ $textCol }};
        --mu: {{ $muteCol }};
        --r: {{ $radiusCss }};
        box-sizing: border-box;
        display: block;
        position: relative;
        width: 100%;
        flex: 0 0 auto;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-oh-band {
        display: flex;
        align-items: stretch;
        max-width: 1200px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: var(--r);
        background: #fff;
        border: 1px solid rgba(var(--ar), .22);
        box-shadow: 0 30px 60px -34px rgba(var(--ar), .55);
    }
    #{{ $uid }}.rj-oh--min .rj-oh-band {
        background: transparent;
        border-color: transparent;
        box-shadow: none;
    }
    #{{ $uid }}:not(.is-in) .rj-oh-band { opacity: 0; }
    #{{ $uid }}.is-in .rj-oh-band { animation: rjOhIn .9s cubic-bezier(.2,.8,.2,1) backwards; }

    #{{ $uid }} .rj-oh-left {
        position: relative;
        display: flex;
        align-items: center;
        gap: 30px;
        flex: 0 0 auto;
        padding: 34px 38px 34px 30px;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(135deg, var(--a), color-mix(in srgb, var(--a) 52%, #1e1b4b));
        border-radius: var(--r);
    }
    #{{ $uid }} .rj-oh-sweep {
        position: absolute;
        left: -90px;
        top: 50%;
        width: 360px;
        height: 360px;
        margin-top: -180px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, rgba(255,255,255,.2), rgba(255,255,255,0) 28%, rgba(255,255,255,0) 100%);
        animation: rjOhSweep 9s linear infinite;
        pointer-events: none;
    }

    #{{ $uid }} .rj-oh-clock {
        position: relative;
        z-index: 1;
        flex: 0 0 auto;
        width: 168px;
        height: 168px;
        margin-right: 34px;
    }
    #{{ $uid }} .rj-oh-clock > svg.rj-oh-face {
        display: block;
        width: 100%;
        height: 100%;
        overflow: visible;
    }
    #{{ $uid }} .rj-oh-hand { transform-origin: 100px 100px; }
    #{{ $uid }} .rj-oh-hand--h, #{{ $uid }} .rj-oh-hand--m { transition: transform .6s cubic-bezier(.4,1.6,.5,1); }
    #{{ $uid }} .rj-oh-hand--s { transition: transform .35s cubic-bezier(.4,2.4,.5,1); }

    #{{ $uid }} .rj-oh-char {
        position: absolute;
        z-index: 2;
        right: -44px;
        bottom: -10px;
        width: 92px;
        height: 101px;
        cursor: pointer;
    }
    #{{ $uid }} .rj-oh-char svg {
        display: block;
        width: 100%;
        height: 100%;
        overflow: visible;
        transform-origin: 50% 95%;
    }
    #{{ $uid }}.is-open .rj-oh-char svg { animation: rjOhHop 2.4s ease-in-out infinite; }
    #{{ $uid }}.is-sleep .rj-oh-char svg { animation: rjOhBreath 3.6s ease-in-out infinite; }
    #{{ $uid }} .rj-oh-char.is-hop svg { animation: rjOhHop .7s ease-in-out 2 !important; }

    #{{ $uid }} .rj-oh-body { fill: #fcd34d; }
    #{{ $uid }} .rj-oh-lid { fill: #fcd34d; transform-box: fill-box; transform-origin: 50% 0; transform: scaleY(0); }
    #{{ $uid }}.is-open .rj-oh-lid { animation: rjOhBlink 4.2s infinite; }
    #{{ $uid }}.is-sleep .rj-oh-lid { transform: scaleY(1); }
    #{{ $uid }} .rj-oh-pupil { transition: transform .12s ease-out; }
    #{{ $uid }} .rj-oh-zzz-eye, #{{ $uid }} .rj-oh-mouth-sleep { opacity: 0; }
    #{{ $uid }}.is-sleep .rj-oh-zzz-eye, #{{ $uid }}.is-sleep .rj-oh-mouth-sleep { opacity: 1; }
    #{{ $uid }}.is-sleep .rj-oh-mouth-awake { opacity: 0; }
    #{{ $uid }} .rj-oh-ant { transform-box: fill-box; transform-origin: 50% 100%; animation: rjOhWob 2.2s ease-in-out infinite; }
    #{{ $uid }} .rj-oh-arm { transform-box: fill-box; transform-origin: 0% 100%; }
    #{{ $uid }}.is-open .rj-oh-arm { animation: rjOhWave 1.2s ease-in-out infinite; }

    #{{ $uid }} .rj-oh-z {
        position: absolute;
        z-index: 3;
        right: -52px;
        bottom: 74px;
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        opacity: 0;
        pointer-events: none;
    }
    #{{ $uid }}.is-sleep .rj-oh-z { animation: rjOhZ 3s ease-out infinite; }
    #{{ $uid }}.is-sleep .rj-oh-z:nth-of-type(2) { animation-delay: 1s; right: -62px; font-size: 14px; }
    #{{ $uid }}.is-sleep .rj-oh-z:nth-of-type(3) { animation-delay: 2s; right: -42px; font-size: 22px; }

    #{{ $uid }} .rj-oh-info { position: relative; z-index: 1; min-width: 0; }
    #{{ $uid }} .rj-oh-sub {
        margin: 0 0 8px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: rgba(255,255,255,.78);
    }
    #{{ $uid }} .rj-oh-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #fff;
    }
    #{{ $uid }} .rj-oh-digital {
        display: flex;
        align-items: baseline;
        gap: 2px;
        margin: 14px 0 0;
        font-size: 44px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -.02em;
        font-variant-numeric: tabular-nums;
        color: #fff;
    }
    #{{ $uid }} .rj-oh-colon { animation: rjOhColon 1s steps(1) infinite; }
    #{{ $uid }} .rj-oh-ap { margin-left: 8px; font-size: 14px; letter-spacing: .06em; opacity: .8; }
    #{{ $uid }} .rj-oh-status {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-top: 16px;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        color: #fff;
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.3);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }
    #{{ $uid }} .rj-oh-dot {
        display: block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        color: #fca5a5;
        background: currentColor;
        animation: rjOhPulse 2s ease-out infinite;
    }
    #{{ $uid }}.is-open .rj-oh-dot { color: #4ade80; }

    #{{ $uid }} .rj-oh-days {
        flex: 1 1 auto;
        min-width: 0;
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 8px;
        padding: 22px 20px;
    }
    #{{ $uid }} .rj-oh-day {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 14px 4px 12px;
        border-radius: 18px;
        border: 1px solid transparent;
        text-align: center;
        transition: transform .5s cubic-bezier(.34,1.5,.64,1), background-color .4s ease, border-color .4s ease, box-shadow .4s ease;
    }
    #{{ $uid }} .rj-oh-day:hover {
        transform: translateY(-6px);
        background: rgba(var(--ar), .06);
        border-color: rgba(var(--ar), .25);
        box-shadow: 0 18px 28px -20px rgba(var(--ar), .8);
    }
    #{{ $uid }} .rj-oh-day.is-today {
        background: rgba(var(--ar), .09);
        border-color: rgba(var(--ar), .5);
    }
    #{{ $uid }} .rj-oh-day.is-today::before {
        content: "";
        position: absolute;
        top: 7px;
        right: 7px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        color: var(--a);
        background: currentColor;
        animation: rjOhPulse 2s ease-out infinite;
    }
    #{{ $uid }} .rj-oh-dn {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--mu);
    }
    #{{ $uid }} .rj-oh-day.is-today .rj-oh-dn { color: var(--a); }

    #{{ $uid }} .rj-oh-track {
        position: relative;
        width: 16px;
        height: 104px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(var(--ar), .1);
    }
    #{{ $uid }} .rj-oh-day.is-off .rj-oh-track {
        background: repeating-linear-gradient(180deg, rgba(var(--ar), .12) 0 4px, transparent 4px 9px);
    }
    #{{ $uid }} .rj-oh-fill {
        position: absolute;
        left: 0;
        right: 0;
        border-radius: 999px;
        background: linear-gradient(180deg, var(--a), color-mix(in srgb, var(--a) 60%, #fff));
        transform: scaleY(0);
        transform-origin: top;
        transition: transform .9s cubic-bezier(.2,.8,.2,1) calc(var(--i) * 90ms + .3s);
    }
    #{{ $uid }}.is-in .rj-oh-fill { transform: scaleY(1); }
    #{{ $uid }} .rj-oh-now {
        position: absolute;
        left: -2px;
        right: -2px;
        top: 0;
        height: 3px;
        border-radius: 3px;
        background: #f43f5e;
        box-shadow: 0 0 8px #f43f5e;
        display: none;
    }
    #{{ $uid }} .rj-oh-day.is-today .rj-oh-now { display: block; }

    #{{ $uid }} .rj-oh-hrs {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1.45;
        font-variant-numeric: tabular-nums;
        color: var(--tx);
    }
    #{{ $uid }} .rj-oh-hrs i {
        display: block;
        width: 10px;
        height: 1px;
        margin: 3px auto;
        background: var(--mu);
        opacity: .6;
    }
    #{{ $uid }} .rj-oh-day.is-off .rj-oh-hrs { color: var(--mu); font-weight: 500; opacity: .8; }
    #{{ $uid }} .rj-oh-note {
        display: block;
        font-size: 10.5px;
        line-height: 1.3;
        color: var(--mu);
    }

    #{{ $uid }} .rj-oh-foot {
        max-width: 1200px;
        margin: 16px auto 0;
        text-align: center;
        font-size: 12.5px;
        line-height: 1.6;
        color: var(--mu);
    }

    #{{ $uid }} .rj-oh-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        font-size: 14px;
        color: var(--mu);
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
    }

    @media (max-width: 1040px) {
        #{{ $uid }} .rj-oh-band { flex-direction: column; }
        #{{ $uid }} .rj-oh-left { justify-content: center; }
    }
    @media (max-width: 700px) {
        #{{ $uid }} .rj-oh-left {
            flex-direction: column;
            gap: 22px;
            padding: 30px 24px;
            text-align: center;
        }
        #{{ $uid }} .rj-oh-clock { margin-right: 0; }
        #{{ $uid }} .rj-oh-char { right: -30px; }
        #{{ $uid }} .rj-oh-digital { justify-content: center; }
        #{{ $uid }} .rj-oh-days {
            display: flex;
            overflow-x: auto;
            gap: 8px;
            padding: 18px 14px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        #{{ $uid }} .rj-oh-day { flex: 0 0 92px; scroll-snap-align: start; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-oh-band { opacity: 1 !important; }
        #{{ $uid }} .rj-oh-fill { transform: none !important; }
    }
</style>

<div id="{{ $uid }}" class="{{ $rootClass }} is-sleep">
    @if($hasAny)
        <div class="rj-oh-band">
            <div class="rj-oh-left">
                <span class="rj-oh-sweep" aria-hidden="true"></span>

                <div class="rj-oh-clock" aria-hidden="true">
                    <svg class="rj-oh-face" viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="94" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.4)" stroke-width="2"/>
                        @for($t = 0; $t < 12; $t++)
                            <line x1="100" y1="14" x2="100" y2="{{ $t % 3 === 0 ? 30 : 23 }}" stroke="#fff" stroke-opacity="{{ $t % 3 === 0 ? 1 : .6 }}" stroke-width="{{ $t % 3 === 0 ? 4 : 2.5 }}" stroke-linecap="round" transform="rotate({{ $t * 30 }} 100 100)"/>
                        @endfor
                        <g class="rj-oh-hand rj-oh-hand--h" data-hand="h"><line x1="100" y1="106" x2="100" y2="60" stroke="#fff" stroke-width="7" stroke-linecap="round"/></g>
                        <g class="rj-oh-hand rj-oh-hand--m" data-hand="m"><line x1="100" y1="108" x2="100" y2="38" stroke="#fff" stroke-width="4.5" stroke-linecap="round"/></g>
                        <g class="rj-oh-hand rj-oh-hand--s" data-hand="s">
                            <line x1="100" y1="120" x2="100" y2="26" stroke="#fde047" stroke-width="2.2" stroke-linecap="round"/>
                            <circle cx="100" cy="30" r="4" fill="#fde047"/>
                        </g>
                        <circle cx="100" cy="100" r="6" fill="#fff"/>
                        <circle cx="100" cy="100" r="2.6" fill="#fde047"/>
                    </svg>

                    <div class="rj-oh-char" data-char title="Tiktak">
                        <svg viewBox="0 0 100 110">
                            <g class="rj-oh-ant">
                                <line x1="50" y1="22" x2="50" y2="8" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="50" cy="6" r="5" fill="#fff"/>
                            </g>
                            <g class="rj-oh-arm"><ellipse cx="92" cy="74" rx="7" ry="10" class="rj-oh-body"/></g>
                            <ellipse cx="8" cy="76" rx="7" ry="10" class="rj-oh-body"/>
                            <path class="rj-oh-body" d="M14 70 C14 38 30 20 50 20 C70 20 86 38 86 70 C86 92 74 102 50 102 C26 102 14 92 14 70Z"/>
                            <ellipse cx="24" cy="74" rx="6" ry="4" fill="#fb7185" opacity=".45"/>
                            <ellipse cx="76" cy="74" rx="6" ry="4" fill="#fb7185" opacity=".45"/>
                            <circle cx="37" cy="58" r="11" fill="#fff"/>
                            <circle cx="63" cy="58" r="11" fill="#fff"/>
                            <g class="rj-oh-pupil" data-pupil><circle cx="37" cy="58" r="5.5" fill="#1e1b4b"/><circle cx="39" cy="56" r="1.8" fill="#fff"/></g>
                            <g class="rj-oh-pupil" data-pupil><circle cx="63" cy="58" r="5.5" fill="#1e1b4b"/><circle cx="65" cy="56" r="1.8" fill="#fff"/></g>
                            <rect class="rj-oh-lid" x="24" y="45" width="26" height="26" rx="10"/>
                            <rect class="rj-oh-lid" x="50" y="45" width="26" height="26" rx="10"/>
                            <path class="rj-oh-zzz-eye" d="M30 59 Q37 65 44 59 M56 59 Q63 65 70 59" fill="none" stroke="#1e1b4b" stroke-width="2.4" stroke-linecap="round"/>
                            <path class="rj-oh-mouth-awake" d="M40 80 Q50 91 60 80" fill="none" stroke="#1e1b4b" stroke-width="3" stroke-linecap="round"/>
                            <ellipse class="rj-oh-mouth-sleep" cx="50" cy="83" rx="3.4" ry="4" fill="#1e1b4b"/>
                        </svg>
                        <span class="rj-oh-z" aria-hidden="true">z</span>
                        <span class="rj-oh-z" aria-hidden="true">z</span>
                        <span class="rj-oh-z" aria-hidden="true">Z</span>
                    </div>
                </div>

                <div class="rj-oh-info">
                    @if($subtitle !== '')
                        <p class="rj-oh-sub">{{ $subtitle }}</p>
                    @endif
                    @if($title !== '')
                        <h2 class="rj-oh-title">{{ $title }}</h2>
                    @endif
                    <div class="rj-oh-digital" aria-hidden="true">
                        <span data-hh>--</span><span class="rj-oh-colon">:</span><span data-mm>--</span><span class="rj-oh-ap" data-ap></span>
                    </div>
                    @if($showStatus)
                        <div class="rj-oh-status">
                            <span class="rj-oh-dot"></span>
                            <span data-status-text>{{ $closedNow }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($showWeek)
                <div class="rj-oh-days">
                    @foreach($dayOrder as $i => $d)
                        @php $row = $days[$d]; @endphp
                        <div class="rj-oh-day {{ $row['closed'] ? 'is-off' : '' }}" data-day="{{ $d }}" style="--i: {{ $i }};" title="{{ $dayLabels[$d] }}">
                            <span class="rj-oh-dn">{{ $dayShort[$d] }}</span>
                            <span class="rj-oh-track" aria-hidden="true">
                                @foreach($row['segs'] as $seg)
                                    <i class="rj-oh-fill" style="top: {{ number_format($seg[0], 2, '.', '') }}%; height: {{ number_format($seg[1], 2, '.', '') }}%;"></i>
                                @endforeach
                                <b class="rj-oh-now"></b>
                            </span>
                            <span class="rj-oh-hrs">
                                @if($row['closed'])
                                    {{ $closedLabel }}
                                @else
                                    {{ $row['open'] }}<i></i>{{ $row['close'] }}
                                @endif
                            </span>
                            @if($row['note'] !== '')
                                <span class="rj-oh-note">{{ $row['note'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if($footerNote !== '')
            <div class="rj-oh-foot">{{ $footerNote }}</div>
        @endif
    @else
        <div class="rj-oh-empty">{{ __('Please add at least one day to the schedule.') }}</div>
    @endif
</div>

@if($hasAny)
<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var schedule = @json($jsSchedule);
    var tz = @json($timezone === '' ? 'auto' : $timezone);
    var fmt = @json($timeFormat);
    var openLabel = @json($openLabel);
    var closedLabel = @json($closedNow);
    var highlight = @json($highlight);

    var dayKeys = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
    var hands = { h: root.querySelector('[data-hand="h"]'), m: root.querySelector('[data-hand="m"]'), s: root.querySelector('[data-hand="s"]') };
    var hh = root.querySelector('[data-hh]');
    var mm = root.querySelector('[data-mm]');
    var ap = root.querySelector('[data-ap]');
    var statusTxt = root.querySelector('[data-status-text]');
    var char = root.querySelector('[data-char]');
    var pupils = root.querySelectorAll('[data-pupil]');
    var state = {};

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function now() {
        var d = new Date();
        try {
            var f = new Intl.DateTimeFormat('en-US', {
                timeZone: tz === 'auto' ? undefined : tz,
                weekday: 'short', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
            });
            var map = {};
            f.formatToParts(d).forEach(function (p) { map[p.type] = p.value; });
            var wd = { Sun: 'sun', Mon: 'mon', Tue: 'tue', Wed: 'wed', Thu: 'thu', Fri: 'fri', Sat: 'sat' };
            var h = parseInt(map.hour, 10);
            if (h === 24) h = 0;
            return { day: wd[map.weekday] || 'mon', h: h, m: parseInt(map.minute, 10), s: parseInt(map.second, 10) };
        } catch (e) {
            return { day: dayKeys[d.getDay()], h: d.getHours(), m: d.getMinutes(), s: d.getSeconds() };
        }
    }

    function unwrap(key, val) {
        var s = state[key];
        if (!s) { state[key] = { last: val, turns: 0 }; return val; }
        if (val < s.last - 180) s.turns++;
        s.last = val;
        return val + s.turns * 360;
    }

    function toMin(t) {
        if (!t) return null;
        var p = String(t).split(':');
        if (p.length < 2) return null;
        var h = parseInt(p[0], 10), m = parseInt(p[1], 10);
        return isNaN(h) || isNaN(m) ? null : h * 60 + m;
    }

    function isOpen(day, min) {
        var t = schedule[day];
        if (!t || t.closed) return false;
        var o = toMin(t.open), c = toMin(t.close);
        if (o === null || c === null) return false;
        if (c > o) return min >= o && min < c;
        if (c === o) return true;
        return min >= o || min < c;
    }

    function tick() {
        var n = now();
        if (hands.s) hands.s.style.transform = 'rotate(' + unwrap('s', n.s * 6) + 'deg)';
        if (hands.m) hands.m.style.transform = 'rotate(' + unwrap('m', n.m * 6 + n.s * 0.1) + 'deg)';
        if (hands.h) hands.h.style.transform = 'rotate(' + unwrap('h', (n.h % 12) * 30 + n.m * 0.5) + 'deg)';

        if (hh && mm) {
            if (fmt === '12h') {
                hh.textContent = (n.h % 12 || 12);
                if (ap) ap.textContent = n.h >= 12 ? 'PM' : 'AM';
            } else {
                hh.textContent = pad(n.h);
                if (ap) ap.textContent = '';
            }
            mm.textContent = pad(n.m);
        }

        var minutes = n.h * 60 + n.m;
        var open = isOpen(n.day, minutes);
        root.classList.toggle('is-open', open);
        root.classList.toggle('is-sleep', !open);
        if (statusTxt) statusTxt.textContent = open ? openLabel : closedLabel;

        root.querySelectorAll('.rj-oh-day').forEach(function (el) {
            var today = highlight && el.getAttribute('data-day') === n.day;
            el.classList.toggle('is-today', today);
            if (today) {
                var mark = el.querySelector('.rj-oh-now');
                if (mark) mark.style.top = 'calc(' + (minutes / 14.4) + '% - 1px)';
            }
        });
    }

    tick();
    setInterval(tick, 1000);

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (char && pupils.length && !reduce) {
        document.addEventListener('mousemove', function (e) {
            if (root.classList.contains('is-sleep')) {
                pupils.forEach(function (p) { p.style.transform = ''; });
                return;
            }
            var r = char.getBoundingClientRect();
            var dx = e.clientX - (r.left + r.width / 2);
            var dy = e.clientY - (r.top + r.height * 0.55);
            var dist = Math.sqrt(dx * dx + dy * dy) || 1;
            var k = Math.min(1, dist / 160) * 3.6;
            var tx = (dx / dist) * k;
            var ty = (dy / dist) * k;
            pupils.forEach(function (p) { p.style.transform = 'translate(' + tx.toFixed(2) + 'px,' + ty.toFixed(2) + 'px)'; });
        }, { passive: true });
    }

    if (char) {
        char.addEventListener('click', function () {
            char.classList.remove('is-hop');
            void char.offsetWidth;
            char.classList.add('is-hop');
            setTimeout(function () { char.classList.remove('is-hop'); }, 1500);
        });
    }

    function go() { root.classList.add('is-in'); }
    if (!('IntersectionObserver' in window)) { go(); return; }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { go(); io.disconnect(); }
        });
    }, { threshold: 0.15 });
    io.observe(root);
    setTimeout(go, 2500);
})();
</script>
@endif
