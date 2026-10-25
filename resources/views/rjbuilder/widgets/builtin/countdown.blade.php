@php
    $targetDate  = str_replace(' ', 'T', $settings['target_date'] ?? '2026-12-31 23:59:59');
    $bgColor     = $settings['bg_color'] ?? '#0f172a';
    $accentColor = $settings['accent_color'] ?? '#8b5cf6';
    $titleColor  = $settings['title_color'] ?? '#ffffff';
    $labelColor  = $settings['label_color'] ?? '#94a3b8';
    $style       = $settings['style'] ?? 'dark';
    $title       = $settings['title'] ?? '';
    $expiredText = $settings['expired_text'] ?? __('This offer has ended.');

    $boxBg     = $settings['box_bg'] ?? '#1e293b';
    $boxBorder = 'rgba(255,255,255,.1)';
    $showRing  = true;

    if ($style === 'light') {
        $boxBg     = '#ffffff';
        $boxBorder = '#e2e8f0';
    } elseif ($style === 'transparent') {
        $boxBg     = 'transparent';
        $boxBorder = 'rgba(255,255,255,.25)';
        $showRing  = false;
    }

    $units = array_values(array_filter([
        ($settings['show_days'] ?? true)    ? ['key' => 'days',    'label' => __('Days'),    'icon' => 'ph:calendar-blank']   : null,
        ($settings['show_hours'] ?? true)   ? ['key' => 'hours',   'label' => __('Hours'),   'icon' => 'ph:clock']            : null,
        ($settings['show_minutes'] ?? true) ? ['key' => 'minutes', 'label' => __('Minutes'), 'icon' => 'ph:timer']            : null,
        ($settings['show_seconds'] ?? true) ? ['key' => 'seconds', 'label' => __('Seconds'), 'icon' => 'ph:hourglass-medium'] : null,
    ]));
@endphp

@once
<style>
    @keyframes rjCdDrop {
        0%   { opacity: 0; transform: translateY(-140px) rotate(-14deg) scale(.6); }
        55%  { opacity: 1; transform: translateY(14px) rotate(3deg) scale(1.05); }
        75%  { transform: translateY(-7px) rotate(-1.5deg) scale(.98); }
        90%  { transform: translateY(3px); }
        100% { transform: none; }
    }
    @keyframes rjCdTick {
        0%   { opacity: 0; transform: translateY(-70%) scale(.5); filter: blur(4px); }
        55%  { opacity: 1; transform: translateY(12%) scale(1.18); filter: blur(0); }
        80%  { transform: translateY(-4%) scale(.95); }
        100% { transform: none; }
    }
    @keyframes rjCdSpin    { to { transform: rotate(360deg); } }
    @keyframes rjCdBreathe { 0%,100% { opacity: .45; transform: scale(.9); } 50% { opacity: 1; transform: scale(1.12); } }
    @keyframes rjCdPop     { 0% { opacity: 0; transform: scale(.3); } 60% { opacity: 1; transform: scale(1.12); } 100% { transform: none; } }
    @keyframes rjCdTitle   { from { opacity: 0; transform: translateY(-24px); } to { opacity: 1; transform: none; } }
</style>
@endonce

<style>
    #{{ $uid }} {
        --cd-accent: {{ $accentColor }};
        position: relative;
        overflow: hidden;
        background-color: {{ $bgColor }};
        padding: 4rem 1rem;
        text-align: center;
    }
    @media (min-width: 768px) {
        #{{ $uid }} { padding: 6rem 1rem; }
    }

    /* Arxa plandakı nəfəs alan işıq */
    #{{ $uid }} .rj-cd-glow {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 32rem;
        height: 32rem;
        margin-left: -16rem;
        margin-top: -16rem;
        border-radius: 50%;
        background: radial-gradient(circle, color-mix(in srgb, var(--cd-accent) 35%, transparent), transparent 65%);
        animation: rjCdBreathe 5s ease-in-out infinite;
        pointer-events: none;
    }

    #{{ $uid }} .rj-cd-inner {
        position: relative;
        z-index: 1;
        max-width: 64rem;
        margin: 0 auto;
    }

    /* Başlıq */
    #{{ $uid }} .rj-cd-title {
        font-size: 1.875rem;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.2;
        margin: 0 0 3rem;
        color: {{ $titleColor }};
        animation: rjCdTitle .8s cubic-bezier(.2,.8,.2,1) backwards;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cd-title { font-size: 3rem; margin-bottom: 3.5rem; }
    }

    #{{ $uid }} .rj-cd-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cd-container { gap: 1.5rem; }
    }

    /* Hər vahid: düşmə animasiyası */
    #{{ $uid }} .rj-cd-item {
        animation: rjCdDrop .9s cubic-bezier(.34,1.3,.64,1) backwards;
    }

    /* Qutu */
    #{{ $uid }} .rj-cd-box {
        position: relative;
        isolation: isolate;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 5.25rem;
        height: 5.25rem;
        border-radius: 1.1rem;
        border: 1px solid {{ $boxBorder }};
        box-shadow: 0 18px 35px -14px rgba(0,0,0,.55);
        transition: transform .45s cubic-bezier(.34,1.56,.64,1), box-shadow .45s ease;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cd-box { width: 7rem; height: 7rem; border-radius: 1.4rem; }
    }
    #{{ $uid }} .rj-cd-box::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background-color: {{ $boxBg }};
        z-index: -1;
    }

    /* Fırlanan rəngli halqa */
    #{{ $uid }} .rj-cd-ringed::before {
        content: "";
        position: absolute;
        inset: -3px;
        border-radius: calc(1.1rem + 3px);
        background: conic-gradient(from 0deg, var(--cd-accent), transparent 25%, var(--cd-accent) 50%, transparent 75%, var(--cd-accent));
        opacity: .85;
        z-index: -2;
        animation: rjCdSpin 3.5s linear infinite;
    }

    /* Hover: qalxma və parıltı */
    #{{ $uid }} .rj-cd-item:hover .rj-cd-box {
        transform: translateY(-8px) scale(1.07);
        box-shadow: 0 26px 40px -14px color-mix(in srgb, var(--cd-accent) 60%, transparent);
    }

    /* İkon */
    #{{ $uid }} .rj-cd-icon {
        position: relative;
        z-index: 1;
        display: flex;
        margin-bottom: .2rem;
        color: {{ $labelColor }};
        opacity: .85;
    }

    /* Rəqəm */
    #{{ $uid }} .rj-cd-number {
        position: relative;
        z-index: 1;
        font-size: 1.875rem;
        font-weight: 900;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        color: var(--cd-accent);
        text-shadow: 0 0 18px color-mix(in srgb, var(--cd-accent) 55%, transparent);
        transition: text-shadow .4s ease;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cd-number { font-size: 3rem; }
    }
    #{{ $uid }} .rj-cd-item:hover .rj-cd-number {
        text-shadow: 0 0 26px var(--cd-accent);
    }
    #{{ $uid }} .rj-tick {
        animation: rjCdTick .55s cubic-bezier(.34,1.4,.64,1);
    }

    /* Etiket */
    #{{ $uid }} .rj-cd-label {
        position: relative;
        z-index: 1;
        margin-top: .5rem;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .15em;
        color: {{ $labelColor }};
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-cd-label { font-size: 12px; }
    }

    /* Bitmə mesajı */
    #{{ $uid }} .rj-cd-expired {
        display: none;
        margin-top: 2rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: {{ $titleColor }};
        animation: rjCdPop .7s cubic-bezier(.34,1.56,.64,1) backwards;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }},
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<section id="{{ $uid }}" data-countdown>
    <div class="rj-cd-glow"></div>

    <div class="rj-cd-inner">
        @if($title)
            <h2 class="rj-cd-title">{{ $title }}</h2>
        @endif

        <div class="rj-cd-container" data-target="{{ $targetDate }}">
            @foreach($units as $i => $u)
                <div class="rj-cd-item" style="animation-delay: {{ $i * 0.12 }}s;">
                    <div class="rj-cd-box{{ $showRing ? ' rj-cd-ringed' : '' }}">
                        <span class="rj-cd-icon">{!! rj_icon($u['icon'], 'w-4 h-4') !!}</span>
                        <span class="rj-cd-number" data-unit="{{ $u['key'] }}">00</span>
                        <span class="rj-cd-label">{{ $u['label'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="rj-cd-expired">{{ $expiredText }}</div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root || root.dataset.initialized) return;
    root.dataset.initialized = '1';

    var container = root.querySelector('.rj-cd-container');
    var expiredEl = root.querySelector('.rj-cd-expired');
    var target    = new Date(container.dataset.target).getTime();
    if (isNaN(target)) return;

    var els = {};
    root.querySelectorAll('[data-unit]').forEach(function (el) {
        els[el.dataset.unit] = el;
    });

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    // Dəyər dəyişəndə rəqəm yelləncəklə yenilənir
    function setVal(el, value) {
        if (!el || el.textContent === value) return;
        el.textContent = value;
        el.classList.remove('rj-tick');
        void el.offsetWidth;
        el.classList.add('rj-tick');
    }

    var timer = null;

    function tick() {
        var diff = target - Date.now();

        if (diff <= 0) {
            clearInterval(timer);
            container.style.display = 'none';
            if (expiredEl) expiredEl.style.display = 'block';
            return;
        }

        var days    = Math.floor(diff / 86400000);
        var hours   = Math.floor((diff % 86400000) / 3600000);
        var minutes = Math.floor((diff % 3600000) / 60000);
        var seconds = Math.floor((diff % 60000) / 1000);

        setVal(els.days,    pad(days));
        setVal(els.hours,   pad(hours));
        setVal(els.minutes, pad(minutes));
        setVal(els.seconds, pad(seconds));
    }

    tick();
    timer = setInterval(tick, 1000);
})();
</script>
