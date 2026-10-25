@once
<style>
    @keyframes rjAlertPop   { 0% { opacity: 0; transform: translateY(14px) scale(.85); } 60% { opacity: 1; transform: translateY(-3px) scale(1.03); } 100% { opacity: 1; transform: none; } }
    @keyframes rjAlertSlide { from { opacity: 0; transform: translateY(-16px); } to { opacity: 1; transform: none; } }
    @keyframes rjAlertFade  { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjAlertIcon  { 0% { transform: scale(0) rotate(-25deg); } 65% { transform: scale(1.18) rotate(6deg); } 100% { transform: scale(1) rotate(0); } }
    @keyframes rjAlertShine { from { transform: translateX(-130%) skewX(-20deg); } to { transform: translateX(260%) skewX(-20deg); } }
    @keyframes rjAlertRing  { 0% { transform: scale(1); opacity: .6; } 100% { transform: scale(1.9); opacity: 0; } }
    @keyframes rjAlertBar   { from { transform: scaleX(1); } to { transform: scaleX(0); } }
</style>
@endonce

<style>
    #{{ $uid }} {
        --al-color: {{ $cfg['color'] }};
        --al-rgb: {{ $cfg['rgb'] }};
        --al-strong: {{ $cfg['strong'] }};
        --al-on: {{ $cfg['on_color'] }};
        --al-duration: {{ $cfg['auto_dismiss'] }}s;
        display: flex;
        justify-content: center;
        padding: 1rem;
    }

    /* Kart: kompakt, mərkəzdə */
    #{{ $uid }} .al-card {
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 380px;
        display: flex;
        align-items: center;
        gap: .875rem;
        padding: 1rem 1.125rem;
        border-radius: 1.25rem;
        border: 1px solid transparent;
        box-shadow: 0 12px 30px -12px rgba(var(--al-rgb), .45), 0 2px 6px rgba(0,0,0,.05);
        transition: opacity .35s ease, transform .35s ease;
    }
    #{{ $uid }} .al-card.al-hide { opacity: 0; transform: translateY(-8px) scale(.96); }

    /* Üslublar */
    #{{ $uid }} .al-soft {
        background: linear-gradient(135deg, rgba(var(--al-rgb), .16), rgba(var(--al-rgb), .06));
        border-color: rgba(var(--al-rgb), .28);
    }
    #{{ $uid }} .al-outline {
        background: rgba(255,255,255,.6);
        border: 1.5px solid var(--al-color);
    }
    #{{ $uid }} .al-filled {
        background: linear-gradient(135deg, var(--al-color), rgba(var(--al-rgb), .8));
        color: var(--al-on);
        box-shadow: 0 14px 32px -12px rgba(var(--al-rgb), .75);
    }
    #{{ $uid }} .al-soft .al-title,
    #{{ $uid }} .al-outline .al-title { color: var(--al-strong); }
    #{{ $uid }} .al-soft .al-text,
    #{{ $uid }} .al-outline .al-text  { color: var(--al-strong); opacity: .85; }
    #{{ $uid }} .al-filled .al-title  { color: var(--al-on); }
    #{{ $uid }} .al-filled .al-text   { color: var(--al-on); opacity: .9; }

    /* Mətn */
    #{{ $uid }} .al-body { flex: 1; min-width: 0; }
    #{{ $uid }} .al-title { font-size: .95rem; font-weight: 700; line-height: 1.3; margin: 0 0 .15rem; }
    #{{ $uid }} .al-text  { font-size: .8125rem; line-height: 1.5; }

    /* İkon */
    #{{ $uid }} .al-icon {
        position: relative;
        flex-shrink: 0;
        width: 2.5rem;
        height: 2.5rem;
        display: grid;
        place-items: center;
        border-radius: 999px;
        background: var(--al-color);
        color: #fff;
        box-shadow: 0 6px 16px -4px rgba(var(--al-rgb), .6);
    }
    #{{ $uid }} .al-filled .al-icon { background: rgba(255,255,255,.22); color: var(--al-on); box-shadow: none; }
    #{{ $uid }} .al-icon svg { width: 1.25rem; height: 1.25rem; }

    /* Pulse halqası */
    #{{ $uid }} .al-pulse::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: var(--al-color);
        animation: rjAlertRing 1.8s ease-out infinite;
    }

    /* Bağlama düyməsi */
    #{{ $uid }} .al-close {
        position: absolute;
        top: .5rem;
        right: .5rem;
        padding: .25rem;
        border-radius: 999px;
        color: var(--al-color);
        opacity: .5;
        transition: opacity .2s ease, transform .3s ease;
    }
    #{{ $uid }} .al-close:hover { opacity: 1; transform: rotate(90deg); }
    #{{ $uid }} .al-filled .al-close { color: var(--al-on); }

    /* CTA */
    #{{ $uid }} .al-btn {
        display: inline-flex;
        margin-top: .6rem;
        padding: .4rem .9rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
        text-decoration: none;
        background: var(--al-color);
        color: var(--al-on);
        transition: transform .15s ease, filter .15s ease;
    }
    #{{ $uid }} .al-btn:hover { transform: translateY(-1px); filter: brightness(1.08); }
    #{{ $uid }} .al-filled .al-btn { background: var(--al-on); color: var(--al-color); }

    /* Parıltı (bir dəfə) */
    #{{ $uid }} .al-card::after {
        content: "";
        position: absolute;
        top: 0; bottom: 0; left: 0;
        width: 45%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.4), transparent);
        pointer-events: none;
        animation: rjAlertShine 1.1s ease .45s 1 both;
    }

    /* Giriş animasiyaları */
    #{{ $uid }} .al-anim-pop   { animation: rjAlertPop .6s cubic-bezier(.34,1.4,.64,1) backwards; }
    #{{ $uid }} .al-anim-slide { animation: rjAlertSlide .5s cubic-bezier(.2,.8,.2,1) backwards; }
    #{{ $uid }} .al-anim-fade  { animation: rjAlertFade .4s ease-out backwards; }
    #{{ $uid }} .al-anim-pop .al-icon { animation: rjAlertIcon .6s .15s cubic-bezier(.34,1.56,.64,1) backwards; }
    #{{ $uid }} .al-anim-none::after { display: none; }

    /* Auto-hide progress */
    #{{ $uid }} .al-progress {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 3px;
        background: var(--al-color);
        opacity: .6;
        transform-origin: left;
        animation: rjAlertBar var(--al-duration) linear forwards;
    }
    #{{ $uid }} .al-filled .al-progress { background: var(--al-on); }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} * { animation: none !important; transition: none !important; }
    }
</style>

<div id="{{ $uid }}" role="alert" aria-live="polite">
    <div class="al-card al-{{ $cfg['style'] }} al-anim-{{ $cfg['animation'] }}">

        @if($cfg['show_icon'] && $cfg['icon'])
            <div class="al-icon {{ $cfg['pulse_icon'] ? 'al-pulse' : '' }}">
                {!! rj_icon($cfg['icon'], 'w-5 h-5') !!}
            </div>
        @endif

        <div class="al-body">
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
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
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

    var card       = el.querySelector('.al-card');
    var storageKey = @json($cfg['remember'] ? 'rj_alert_dismissed_' . $cfg['remember_key'] : null);
    var autoHide   = @json((int) $cfg['auto_dismiss']);

    try {
        if (storageKey && localStorage.getItem(storageKey)) {
            el.style.display = 'none';
            return;
        }
    } catch (e) {}

    function hide(userClosed) {
        if (card.classList.contains('al-hide')) return;
        card.classList.add('al-hide');
        if (userClosed && storageKey) {
            try { localStorage.setItem(storageKey, '1'); } catch (e) {}
        }
        setTimeout(function () { el.style.display = 'none'; }, 350);
    }

    var closeBtn = el.querySelector('.al-close');
    if (closeBtn) closeBtn.addEventListener('click', function () { hide(true); });

    if (autoHide > 0) setTimeout(function () { hide(false); }, autoHide * 1000);
})();
</script>
