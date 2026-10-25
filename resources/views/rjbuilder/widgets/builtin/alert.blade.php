@once
<style>
    @keyframes rjAlertFade     { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjAlertSlide    { from { opacity: 0; transform: translateY(-14px); } to { opacity: 1; transform: none; } }
    @keyframes rjAlertZoom     { from { opacity: 0; transform: scale(.92); } to { opacity: 1; transform: none; } }
    @keyframes rjAlertShake    { 0%,100% { transform: translateX(0); } 20% { transform: translateX(-6px); } 40% { transform: translateX(6px); } 60% { transform: translateX(-4px); } 80% { transform: translateX(3px); } }
    @keyframes rjAlertPulse    { 0%,100% { transform: scale(1); } 50% { transform: scale(1.12); } }
    @keyframes rjAlertProgress { from { transform: scaleX(1); } to { transform: scaleX(0); } }
</style>
@endonce

<style>
    #{{ $uid }} {
        --al-color: {{ $cfg['color'] }};
        --al-rgb: {{ $cfg['rgb'] }};
        --al-strong: {{ $cfg['strong'] }};
        --al-on: {{ $cfg['on_color'] }};
        --al-duration: {{ $cfg['auto_dismiss'] }}s;
    }

    /* Box */
    #{{ $uid }} .al-box {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        border: 1px solid transparent;
        border-radius: 1rem;
        box-shadow: 0 1px 2px rgba(0,0,0,.04), 0 10px 25px -15px rgba(var(--al-rgb), .5);
        transition: opacity .35s ease, transform .35s ease;
    }
    #{{ $uid }} .al-box.al-hide {
        opacity: 0;
        transform: translateY(-8px) scale(.98);
    }

    /* Entrance animations (backwards = animation never overrides the .al-hide state) */
    #{{ $uid }} .al-anim-fade  { animation: rjAlertFade .5s ease-out backwards; }
    #{{ $uid }} .al-anim-slide { animation: rjAlertSlide .6s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }} .al-anim-zoom  { animation: rjAlertZoom .5s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }} .al-anim-shake { animation: rjAlertShake .6s ease-in-out backwards; }

    /* Styles */
    #{{ $uid }} .al-soft {
        background: rgba(var(--al-rgb), .1);
        border-color: rgba(var(--al-rgb), .25);
    }
    #{{ $uid }} .al-outline {
        background: transparent;
        border-color: var(--al-color);
    }
    #{{ $uid }} .al-soft .al-title,
    #{{ $uid }} .al-outline .al-title { color: var(--al-strong); }

    #{{ $uid }} .al-soft .al-text,
    #{{ $uid }} .al-outline .al-text { color: var(--al-strong); opacity: .85; }

    #{{ $uid }} .al-filled {
        background: var(--al-color);
        border-color: transparent;
        color: var(--al-on);
    }
    #{{ $uid }} .al-filled .al-title { color: var(--al-on); }
    #{{ $uid }} .al-filled .al-text  { color: var(--al-on); opacity: .9; }

    /* Typography */
    #{{ $uid }} .al-title { font-size: 1rem; font-weight: 700; line-height: 1.3; margin-bottom: .25rem; }
    #{{ $uid }} .al-text  { font-size: .875rem; line-height: 1.6; }

    /* Icon */
    #{{ $uid }} .al-icon {
        flex-shrink: 0;
        display: flex;
        padding: .625rem;
        border-radius: .75rem;
        line-height: 0;
        color: var(--al-color);
        background: rgba(var(--al-rgb), .15);
    }
    #{{ $uid }} .al-outline .al-icon { background: rgba(var(--al-rgb), .08); }
    #{{ $uid }} .al-filled .al-icon {
        color: var(--al-on);
        background: color-mix(in srgb, var(--al-on) 18%, transparent);
    }
    #{{ $uid }} .al-pulse { animation: rjAlertPulse 2s ease-in-out infinite; }

    /* Close button */
    #{{ $uid }} .al-close {
        flex-shrink: 0;
        margin-left: auto;
        padding: .25rem;
        color: var(--al-color);
        opacity: .55;
        transition: opacity .2s ease, transform .3s ease;
    }
    #{{ $uid }} .al-close:hover { opacity: 1; transform: rotate(90deg); }
    #{{ $uid }} .al-filled .al-close { color: var(--al-on); }

    /* CTA button */
    #{{ $uid }} .al-btn {
        display: inline-flex;
        align-items: center;
        margin-top: .75rem;
        padding: .5rem 1rem;
        border-radius: .6rem;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        background: var(--al-color);
        color: var(--al-on);
        transition: transform .15s ease, filter .15s ease;
    }
    #{{ $uid }} .al-btn:hover { transform: translateY(-1px); filter: brightness(1.08); }
    #{{ $uid }} .al-filled .al-btn { background: var(--al-on); color: var(--al-color); }

    /* Auto-hide progress bar */
    #{{ $uid }} .al-progress {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 3px;
        background: var(--al-color);
        opacity: .6;
        transform-origin: left;
        animation: rjAlertProgress var(--al-duration) linear forwards;
    }
    #{{ $uid }} .al-filled .al-progress { background: var(--al-on); }

    /* Responsive + accessibility */
    @media (max-width: 480px) {
        #{{ $uid }} .al-box { padding: 1rem; gap: .75rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} * { animation: none !important; transition: none !important; }
    }
</style>

<div id="{{ $uid }}" class="w-full max-w-4xl mx-auto my-6" role="alert" aria-live="polite">
    <div class="al-box al-{{ $cfg['style'] }} al-anim-{{ $cfg['animation'] }}">

        @if($cfg['show_icon'] && $cfg['icon'])
            <div class="al-icon {{ $cfg['pulse_icon'] ? 'al-pulse' : '' }}">
                {!! rj_icon($cfg['icon'], 'w-6 h-6') !!}
            </div>
        @endif

        <div class="flex-1 min-w-0">
            @if($cfg['title'])
                <h4 class="al-title">{{ $cfg['title'] }}</h4>
            @endif

            @if($cfg['content'])
                <div class="al-text">{!! nl2br(e($cfg['content'])) !!}</div>
            @endif

            @if($cfg['button_text'] && $cfg['button_url'])
                <a href="{{ $cfg['button_url'] }}" class="al-btn">{{ $cfg['button_text'] }}</a>
            @endif
        </div>

        @if($cfg['dismissible'])
            <button type="button" class="al-close" aria-label="Close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif

        @if($cfg['auto_dismiss'] > 0)
            <div class="al-progress"></div>
        @endif
    </div>
</div>

<script>
(function () {
    var el = document.getElementById(@json($uid));
    if (!el) return;

    var box        = el.querySelector('.al-box');
    var storageKey = @json($cfg['remember'] ? 'rj_alert_dismissed_' . $cfg['remember_key'] : null);
    var autoHide   = @json((int) $cfg['auto_dismiss']);

    try {
        if (storageKey && localStorage.getItem(storageKey)) {
            el.style.display = 'none';
            return;
        }
    } catch (e) {}

    function hide(userClosed) {
        if (box.classList.contains('al-hide')) return;
        box.classList.add('al-hide');

        if (userClosed && storageKey) {
            try { localStorage.setItem(storageKey, '1'); } catch (e) {}
        }
        setTimeout(function () { el.style.display = 'none'; }, 350);
    }

    var closeBtn = el.querySelector('.al-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () { hide(true); });
    }

    if (autoHide > 0) {
        setTimeout(function () { hide(false); }, autoHide * 1000);
    }
})();
</script>
