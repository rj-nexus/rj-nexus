@php
    $title         = $settings['title'] ?? __('Opening Hours');
    $subtitle      = $settings['subtitle'] ?? '';
    $timezone      = $settings['timezone'] ?? 'auto';
    $timeFormat    = $settings['time_format'] ?? '24h';
    $showStatus    = $settings['show_status'] ?? true;
    $showWeek      = $settings['show_week'] ?? true;
    $highlightToday= $settings['highlight_today'] ?? true;
    $layout        = $settings['layout'] ?? 'card';
    $accent        = $settings['accent'] ?? '#8b5cf6';
    $textColor     = $settings['text_color'] ?? '#0f172a';
    $mutedColor    = $settings['muted_color'] ?? '#64748b';
    $closedLabel   = $settings['closed_label'] ?? __('Closed');
    $openLabel     = $settings['open_label'] ?? __('Open Now');
    $closedNowLabel= $settings['closed_now_label'] ?? __('Closed Now');
    $footerNote    = $settings['footer_note'] ?? '';
    $radius        = $settings['radius'] ?? 'lg';
    $paddingY      = (int) ($settings['padding_y'] ?? 40);

    $radiusMap = ['none' => '0px', 'md' => '10px', 'lg' => '16px', 'xl' => '24px'];
    $radiusCss = $radiusMap[$radius] ?? '16px';

    $dayOrder   = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    $dayLabels  = [
        'mon' => __('Monday'), 'tue' => __('Tuesday'), 'wed' => __('Wednesday'),
        'thu' => __('Thursday'), 'fri' => __('Friday'), 'sat' => __('Saturday'),
        'sun' => __('Sunday'),
    ];
    $dayShort = [
        'mon' => __('Mon'), 'tue' => __('Tue'), 'wed' => __('Wed'),
        'thu' => __('Thu'), 'fri' => __('Fri'), 'sat' => __('Sat'),
        'sun' => __('Sun'),
    ];

    $scheduleByDay = [];
    foreach ($dayOrder as $d) {
        $scheduleByDay[$d] = null;
    }
    if (!empty($settings['schedule']) && is_array($settings['schedule'])) {
        foreach ($settings['schedule'] as $row) {
            if (!is_array($row)) continue;
            $day = $row['day'] ?? '';
            if (!in_array($day, $dayOrder, true)) continue;
            $closed = !empty($row['closed']) && (string) $row['closed'] === '1';
            $scheduleByDay[$day] = [
                'open'   => trim((string) ($row['open'] ?? '')),
                'close'  => trim((string) ($row['close'] ?? '')),
                'closed' => $closed,
                'note'   => trim((string) ($row['note'] ?? '')),
            ];
        }
    }

    $hasAnySchedule = false;
    foreach ($scheduleByDay as $s) {
        if ($s !== null) { $hasAnySchedule = true; break; }
    }

    $jsSchedule = [];
    foreach ($dayOrder as $d) {
        $s = $scheduleByDay[$d] ?? null;
        if ($s === null) {
            $jsSchedule[$d] = ['closed' => true, 'open' => '', 'close' => ''];
        } else {
            $jsSchedule[$d] = [
                'closed' => $s['closed'],
                'open'   => $s['open'],
                'close'  => $s['close'],
            ];
        }
    }
@endphp

<style>
    #{{ $uid }} {
        --bh-accent: {{ $accent }};
        --bh-text: {{ $textColor }};
        --bh-muted: {{ $mutedColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-bh-wrap {
        max-width: 560px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-bh-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: {{ $radiusCss }};
        padding: 28px 26px;
        box-shadow: 0 20px 40px -24px rgba(15,23,42,.15);
    }
    #{{ $uid }}[data-layout="minimal"] .rj-bh-card {
        background: transparent;
        border: 0;
        box-shadow: none;
        padding: 0;
    }
    #{{ $uid }}[data-layout="split"] .rj-bh-card {
        padding: 30px 26px;
    }

    #{{ $uid }} .rj-bh-head {
        margin-bottom: 20px;
        text-align: center;
    }
    #{{ $uid }}[data-layout="minimal"] .rj-bh-head { text-align: left; }
    #{{ $uid }} .rj-bh-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--bh-text);
        letter-spacing: -.01em;
        margin: 0;
    }
    #{{ $uid }} .rj-bh-sub {
        font-size: 13px;
        color: var(--bh-muted);
        margin: 6px 0 0;
    }

    #{{ $uid }} .rj-bh-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        margin: 0 auto 20px;
    }
    #{{ $uid }} .rj-bh-status.is-open {
        background: rgba(16,185,129,.12);
        color: #059669;
    }
    #{{ $uid }} .rj-bh-status.is-closed {
        background: rgba(239,68,68,.1);
        color: #dc2626;
    }
    #{{ $uid }} .rj-bh-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 0 3px currentColor;
        opacity: .35;
        animation: rjBhPulse 2s ease-in-out infinite;
    }
    @keyframes rjBhPulse {
        0%, 100% { opacity: .35; transform: scale(1); }
        50%      { opacity: 1; transform: scale(1.15); }
    }

    #{{ $uid }} .rj-bh-list {
        display: flex;
        flex-direction: column;
    }
    #{{ $uid }}[data-layout="split"] .rj-bh-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 24px;
        row-gap: 0;
    }
    @media (max-width: 480px) {
        #{{ $uid }}[data-layout="split"] .rj-bh-list {
            grid-template-columns: 1fr;
            column-gap: 0;
        }
    }

    #{{ $uid }} .rj-bh-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 12px;
        border-radius: 10px;
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-bh-row + .rj-bh-row {
        border-top: 1px solid #f1f5f9;
    }
    #{{ $uid }}[data-layout="split"] .rj-bh-row + .rj-bh-row {
        border-top: 0;
    }
    #{{ $uid }}[data-layout="split"] .rj-bh-row {
        border-top: 1px solid #f1f5f9;
    }
    #{{ $uid }}[data-layout="split"] .rj-bh-row:nth-child(1),
    #{{ $uid }}[data-layout="split"] .rj-bh-row:nth-child(2) {
        border-top: 0;
    }

    #{{ $uid }} .rj-bh-row.is-today {
        background: color-mix(in srgb, var(--bh-accent) 7%, transparent);
    }
    #{{ $uid }} .rj-bh-row.is-today .rj-bh-day {
        color: var(--bh-accent);
        font-weight: 800;
    }
    #{{ $uid }} .rj-bh-row.is-today::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--bh-accent);
        position: absolute;
        left: 4px;
    }
    #{{ $uid }} .rj-bh-row { position: relative; }

    #{{ $uid }} .rj-bh-day {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--bh-text);
    }
    #{{ $uid }} .rj-bh-day-full { display: inline; }
    #{{ $uid }} .rj-bh-day-short { display: none; }
    @media (max-width: 400px) {
        #{{ $uid }} .rj-bh-day-full { display: none; }
        #{{ $uid }} .rj-bh-day-short { display: inline; }
    }

    #{{ $uid }} .rj-bh-hours {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--bh-text);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
        letter-spacing: .01em;
    }
    #{{ $uid }} .rj-bh-hours.is-closed {
        color: var(--bh-muted);
        font-weight: 500;
        opacity: .75;
    }
    #{{ $uid }} .rj-bh-note {
        display: block;
        font-size: 11px;
        color: var(--bh-muted);
        font-weight: 500;
        margin-top: 2px;
        text-align: right;
    }

    #{{ $uid }} .rj-bh-footer {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
        color: var(--bh-muted);
        text-align: center;
        line-height: 1.5;
    }

    #{{ $uid }} .rj-bh-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        color: var(--bh-muted);
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}"
     data-layout="{{ $layout }}"
     data-tz="{{ $timezone }}"
     data-fmt="{{ $timeFormat }}"
     data-schedule='@json($jsSchedule)'
     data-open-label="{{ $openLabel }}"
     data-closed-label="{{ $closedNowLabel }}"
     data-status-on="{{ $showStatus ? '1' : '0' }}"
     data-highlight="{{ $highlightToday ? '1' : '0' }}">

    @if($hasAnySchedule)
        <div class="rj-bh-wrap">
            <div class="rj-bh-card">
                @if($title || $subtitle)
                    <header class="rj-bh-head">
                        @if($title)
                            <h2 class="rj-bh-title">{{ $title }}</h2>
                        @endif
                        @if($subtitle)
                            <p class="rj-bh-sub">{{ $subtitle }}</p>
                        @endif
                    </header>
                @endif

                @if($showStatus)
                    <div style="text-align:center;">
                        <div class="rj-bh-status is-closed" data-status>
                            <span class="rj-bh-status-dot"></span>
                            <span data-status-text>{{ $closedNowLabel }}</span>
                        </div>
                    </div>
                @endif

                @if($showWeek)
                    <div class="rj-bh-list">
                        @foreach($dayOrder as $d)
                            @php
                                $s = $scheduleByDay[$d] ?? null;
                                $isClosed = $s === null || $s['closed'] || $s['open'] === '' || $s['close'] === '';
                            @endphp
                            <div class="rj-bh-row" data-day="{{ $d }}">
                                <span class="rj-bh-day">
                                    <span class="rj-bh-day-full">{{ $dayLabels[$d] }}</span>
                                    <span class="rj-bh-day-short">{{ $dayShort[$d] }}</span>
                                </span>
                                <span>
                                    <span class="rj-bh-hours {{ $isClosed ? 'is-closed' : '' }}">
                                        @if($isClosed)
                                            {{ $closedLabel }}
                                        @else
                                            {{ $s['open'] }} – {{ $s['close'] }}
                                        @endif
                                    </span>
                                    @if($s !== null && $s['note'] !== '')
                                        <span class="rj-bh-note">{{ $s['note'] }}</span>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($footerNote !== '')
                    <div class="rj-bh-footer">{{ $footerNote }}</div>
                @endif
            </div>
        </div>

        <script>
        (function () {
            var root = document.getElementById(@js($uid));
            if (!root) return;

            var schedule    = JSON.parse(root.getAttribute('data-schedule') || '{}');
            var tzAttr      = root.getAttribute('data-tz') || 'auto';
            var fmt         = root.getAttribute('data-fmt') || '24h';
            var statusOn    = root.getAttribute('data-status-on') === '1';
            var highlightOn = root.getAttribute('data-highlight') === '1';
            var openLabel   = root.getAttribute('data-open-label') || '';
            var closedLabel = root.getAttribute('data-closed-label') || '';

            var dayKeys = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            var statusEl = root.querySelector('[data-status]');
            var statusTxt = root.querySelector('[data-status-text]');

            function getNowParts() {
                var now = new Date();
                var tz = tzAttr === 'auto' ? undefined : tzAttr;
                try {
                    var fmtDate = new Intl.DateTimeFormat('en-US', {
                        timeZone: tz,
                        weekday: 'short',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });
                    var parts = fmtDate.formatToParts(now);
                    var map = {};
                    parts.forEach(function (p) { map[p.type] = p.value; });
                    var weekdayMap = { Sun: 'sun', Mon: 'mon', Tue: 'tue', Wed: 'wed', Thu: 'thu', Fri: 'fri', Sat: 'sat' };
                    var day = weekdayMap[map.weekday] || 'mon';
                    var hour = parseInt(map.hour, 10);
                    var minute = parseInt(map.minute, 10);
                    if (hour === 24) hour = 0;
                    return { day: day, hour: hour, minute: minute };
                } catch (e) {
                    return { day: dayKeys[now.getDay()], hour: now.getHours(), minute: now.getMinutes() };
                }
            }

            function toMinutes(hhmm) {
                if (!hhmm) return null;
                var parts = String(hhmm).trim().split(':');
                if (parts.length < 2) return null;
                var h = parseInt(parts[0], 10);
                var m = parseInt(parts[1], 10);
                if (isNaN(h) || isNaN(m)) return null;
                return h * 60 + m;
            }

            function isOpenNow(nowDay, nowMin) {
                var today = schedule[nowDay];
                if (!today || today.closed) return false;
                var o = toMinutes(today.open);
                var c = toMinutes(today.close);
                if (o === null || c === null) return false;

                if (c > o) {
                    return nowMin >= o && nowMin < c;
                } else {
                    return nowMin >= o || nowMin < c;
                }
            }

            function applyHighlight(nowDay) {
                if (!highlightOn) return;
                root.querySelectorAll('.rj-bh-row').forEach(function (row) {
                    if (row.getAttribute('data-day') === nowDay) {
                        row.classList.add('is-today');
                    } else {
                        row.classList.remove('is-today');
                    }
                });
            }

            function updateStatus() {
                var n = getNowParts();
                applyHighlight(n.day);

                if (!statusOn || !statusEl || !statusTxt) return;

                var open = isOpenNow(n.day, n.hour * 60 + n.minute);
                statusEl.classList.toggle('is-open', open);
                statusEl.classList.toggle('is-closed', !open);
                statusTxt.textContent = open ? openLabel : closedLabel;
            }

            updateStatus();
            setInterval(updateStatus, 60000);
        })();
        </script>
    @else
        <div class="rj-bh-empty">{{ __('Please add at least one day to the schedule.') }}</div>
    @endif
</div>
