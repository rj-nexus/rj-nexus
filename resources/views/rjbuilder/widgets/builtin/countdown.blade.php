@php
    $targetDate = $settings['target_date'] ?? '2026-12-31 23:59:59';
    $targetDate = str_replace(' ', 'T', $targetDate);

    $bgColor = $settings['bg_color'] ?? '#0f172a';
    $boxBg = $settings['box_bg'] ?? '#1e293b';
    $accentColor = $settings['accent_color'] ?? '#8b5cf6';
    $titleColor = $settings['title_color'] ?? '#ffffff';
    $labelColor = $settings['label_color'] ?? '#94a3b8';
    $style = $settings['style'] ?? 'dark';

    $showDays = $settings['show_days'] ?? true;
    $showHours = $settings['show_hours'] ?? true;
    $showMinutes = $settings['show_minutes'] ?? true;
    $showSeconds = $settings['show_seconds'] ?? true;

    $boxClass = 'flex flex-col items-center justify-center w-20 h-20 md:w-28 md:h-28 rounded-2xl shadow-xl transition-all duration-300';

    if ($style === 'light') {
        $boxClass .= ' bg-white text-slate-900 border border-slate-200';
        $boxBg = '#ffffff';
    } elseif ($style === 'transparent') {
        $boxClass .= ' bg-transparent border border-white/20';
        $boxBg = 'transparent';
    } else {
        $boxClass .= ' border border-white/10';
    }
@endphp

<style>
    #{{ $uid }} .rj-cd-number {
        font-variant-numeric: tabular-nums;
        line-height: 1;
    }
    #{{ $uid }} .rj-cd-box {
        background-color: {{ $boxBg }};
    }
</style>

<section id="{{ $uid }}" class="w-full py-16 px-4 md:py-24" style="background-color: {{ $bgColor }};">
    <div class="max-w-5xl mx-auto text-center">

        @if(!empty($settings['title']))
            <h2 class="text-3xl md:text-5xl font-extrabold mb-12 tracking-tight" style="color: {{ $titleColor }};">
                {{ $settings['title'] }}
            </h2>
        @endif

        <div class="rj-cd-container flex flex-wrap justify-center gap-4 md:gap-6" data-target="{{ $targetDate }}">

            @if($showDays)
                <div class="rj-cd-box {{ $boxClass }}">
                    <span class="rj-cd-number rj-days text-3xl md:text-5xl font-black" style="color: {{ $accentColor }};">00</span>
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest mt-2" style="color: {{ $labelColor }};">{{ __('Days') }}</span>
                </div>
            @endif

            @if($showHours)
                <div class="rj-cd-box {{ $boxClass }}">
                    <span class="rj-cd-number rj-hours text-3xl md:text-5xl font-black" style="color: {{ $accentColor }};">00</span>
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest mt-2" style="color: {{ $labelColor }};">{{ __('Hours') }}</span>
                </div>
            @endif

            @if($showMinutes)
                <div class="rj-cd-box {{ $boxClass }}">
                    <span class="rj-cd-number rj-minutes text-3xl md:text-5xl font-black" style="color: {{ $accentColor }};">00</span>
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest mt-2" style="color: {{ $labelColor }};">{{ __('Minutes') }}</span>
                </div>
            @endif

            @if($showSeconds)
                <div class="rj-cd-box {{ $boxClass }}">
                    <span class="rj-cd-number rj-seconds text-3xl md:text-5xl font-black" style="color: {{ $accentColor }};">00</span>
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest mt-2" style="color: {{ $labelColor }};">{{ __('Seconds') }}</span>
                </div>
            @endif

        </div>

        <div class="rj-cd-expired hidden mt-8 text-xl md:text-2xl font-bold" style="color: {{ $titleColor }};">
            {{ $settings['expired_text'] ?? __('This offer has ended.') }}
        </div>

    </div>
</section>

<script>
(function() {
    function initCountdown_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const container = root.querySelector('.rj-cd-container');
        if (!container) return;

        const targetStr = container.dataset.target;
        const targetDate = new Date(targetStr).getTime();

        if (isNaN(targetDate)) return;

        const elDays = root.querySelector('.rj-days');
        const elHours = root.querySelector('.rj-hours');
        const elMinutes = root.querySelector('.rj-minutes');
        const elSeconds = root.querySelector('.rj-seconds');
        const expiredEl = root.querySelector('.rj-cd-expired');

        let interval = null;

        function pad(num) {
            return num < 10 ? '0' + num : String(num);
        }

        function updateTimer() {
            const now = new Date().getTime();
            const diff = targetDate - now;

            if (diff <= 0) {
                if (interval) clearInterval(interval);
                container.style.display = 'none';
                if (expiredEl) expiredEl.classList.remove('hidden');
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            if (elDays) elDays.innerText = pad(days);
            if (elHours) elHours.innerText = pad(hours);
            if (elMinutes) elMinutes.innerText = pad(minutes);
            if (elSeconds) elSeconds.innerText = pad(seconds);
        }

        updateTimer();
        interval = setInterval(updateTimer, 1000);
    }

    initCountdown_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdown_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
