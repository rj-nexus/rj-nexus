@php
    $url = $settings['url'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $rawColor = ltrim($settings['color'] ?? '#ff5500', '#');
    if (!preg_match('/^[0-9a-fA-F]{6}$/', $rawColor)) {
        $rawColor = 'ff5500';
    }
    $color = $rawColor;
    $rgb = implode(',', [
        hexdec(substr($color, 0, 2)),
        hexdec(substr($color, 2, 2)),
        hexdec(substr($color, 4, 2)),
    ]);

    $visual = $settings['visual'] ?? true;
    $autoplay = $settings['autoplay'] ?? false;
    $hideRelated = $settings['hide_related'] ?? false;
    $showComments = $settings['show_comments'] ?? true;
    $showUser = $settings['show_user'] ?? true;
    $height = (int) ($settings['height'] ?? 166);
    if ($height < 120) {
        $height = 166;
    }

    $embedUrl = '';
    if (!empty($url)) {
        $params = http_build_query([
            'url' => $url,
            'color' => '#' . $color,
            'auto_play' => $autoplay ? 'true' : 'false',
            'hide_related' => $hideRelated ? 'true' : 'false',
            'show_comments' => $showComments ? 'true' : 'false',
            'show_user' => $showUser ? 'true' : 'false',
            'visual' => $visual ? 'true' : 'false',
        ]);
        $embedUrl = 'https://w.soundcloud.com/player/?' . $params;
    }
@endphp

@once
<style>
    @keyframes rjScFade {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjScBar {
        0%, 100% { transform: scaleY(.25); }
        50%      { transform: scaleY(1); }
    }
    @keyframes rjScGlow {
        0%, 100% { opacity: .55; transform: scale(1); }
        50%      { opacity: .85; transform: scale(1.04); }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        position: relative;
        width: 100%;
        padding: 32px 16px;
    }

    #{{ $uid }} .rj-sc-head {
        text-align: center;
        margin-bottom: 32px;
    }
    #{{ $uid }} .rj-sc-sub {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--a);
        margin: 0 0 10px;
        animation: rjScFade .8s ease backwards;
    }
    #{{ $uid }} .rj-sc-title {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
        animation: rjScFade .8s .1s ease backwards;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-sc-title { font-size: 40px; }
    }

    #{{ $uid }} .rj-sc-eq {
        display: inline-flex;
        align-items: flex-end;
        gap: 3px;
        height: 16px;
    }
    #{{ $uid }} .rj-sc-eq i {
        display: block;
        width: 3px;
        height: 100%;
        border-radius: 3px;
        background: var(--a);
        transform-origin: bottom;
        animation: rjScBar 1s ease-in-out infinite;
    }
    #{{ $uid }} .rj-sc-eq i:nth-child(1) { animation-delay: -.9s; }
    #{{ $uid }} .rj-sc-eq i:nth-child(2) { animation-delay: -.6s; }
    #{{ $uid }} .rj-sc-eq i:nth-child(3) { animation-delay: -.3s; }
    #{{ $uid }} .rj-sc-eq i:nth-child(4) { animation-delay: -.75s; }

    #{{ $uid }} .rj-sc-stage {
        position: relative;
        width: min(100%, 880px);
        margin: 0 auto;
        animation: rjScFade .9s .15s cubic-bezier(.2,.8,.2,1) backwards;
    }

    #{{ $uid }} .rj-sc-glow {
        position: absolute;
        inset: 8% 4% -6%;
        z-index: 0;
        border-radius: 40px;
        background: radial-gradient(ellipse at 50% 60%, rgba(var(--rgb), .55), rgba(var(--rgb), 0) 70%);
        filter: blur(28px);
        animation: rjScGlow 5s ease-in-out infinite;
        pointer-events: none;
    }

    #{{ $uid }} .rj-sc-card {
        position: relative;
        z-index: 1;
        padding: 12px;
        border-radius: 32px;
        background: linear-gradient(145deg, #ffffff, rgba(var(--rgb), .07));
        border: 1px solid rgba(var(--rgb), .28);
        box-shadow: 0 30px 60px -30px rgba(15,23,42,.45), inset 0 1px 0 rgba(255,255,255,.9);
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), box-shadow .5s ease, border-color .5s ease;
    }
    #{{ $uid }} .rj-sc-stage:hover .rj-sc-card {
        transform: translateY(-6px);
        border-color: rgba(var(--rgb), .55);
        box-shadow: 0 40px 70px -28px rgba(var(--rgb), .55), inset 0 1px 0 rgba(255,255,255,.9);
    }
    #{{ $uid }} .rj-sc-stage:hover .rj-sc-glow {
        filter: blur(34px);
    }

    #{{ $uid }} .rj-sc-frame {
        position: relative;
        width: 100%;
        overflow: hidden;
        border-radius: 22px;
        background: #0f172a;
    }

    #{{ $uid }} .rj-sc-load {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f172a, rgba(var(--rgb), .35));
        transition: opacity .6s ease, visibility .6s ease;
    }
    #{{ $uid }} .rj-sc-load .rj-sc-eq {
        height: 36px;
        gap: 5px;
    }
    #{{ $uid }} .rj-sc-load .rj-sc-eq i {
        width: 6px;
        background: #fff;
    }

    #{{ $uid }} .rj-sc-frame iframe {
        position: relative;
        z-index: 0;
        display: block;
        width: 100%;
        height: 100%;
        border: 0;
        opacity: 0;
        transform: scale(.985);
        transition: opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-sc-frame.is-loaded iframe {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }} .rj-sc-frame.is-loaded .rj-sc-load {
        opacity: 0;
        visibility: hidden;
    }

    #{{ $uid }} .rj-sc-empty {
        max-width: 640px;
        margin: 0 auto;
        padding: 40px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 24px;
    }
    #{{ $uid }} .rj-sc-empty .rj-sc-eq {
        height: 28px;
        margin-bottom: 14px;
    }
    #{{ $uid }} .rj-sc-empty .rj-sc-eq i {
        width: 5px;
        background: #cbd5e1;
        animation-play-state: paused;
        transform: scaleY(.5);
    }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 24px 10px; }
        #{{ $uid }} .rj-sc-card { padding: 8px; border-radius: 24px; }
        #{{ $uid }} .rj-sc-frame { border-radius: 16px; }
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

<div id="{{ $uid }}" style="--a: #{{ $color }}; --rgb: {{ $rgb }};">
    @if($title || $subtitle)
        <header class="rj-sc-head">
            @if($subtitle)
                <p class="rj-sc-sub">
                    <span class="rj-sc-eq" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                    {{ $subtitle }}
                </p>
            @endif
            @if($title)
                <h2 class="rj-sc-title">{{ $title }}</h2>
            @endif
        </header>
    @endif

    @if($embedUrl)
        <div class="rj-sc-stage">
            <div class="rj-sc-glow"></div>
            <div class="rj-sc-card">
                <div class="rj-sc-frame" style="height: {{ $height }}px;">
                    <div class="rj-sc-load" aria-hidden="true">
                        <span class="rj-sc-eq"><i></i><i></i><i></i><i></i></span>
                    </div>
                    <iframe
                        title="SoundCloud"
                        scrolling="no"
                        frameborder="no"
                        loading="lazy"
                        allow="autoplay"
                        src="{{ $embedUrl }}">
                    </iframe>
                </div>
            </div>
        </div>
    @else
        <div class="rj-sc-empty">
            <span class="rj-sc-eq" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
            <div>{{ __('Please enter a valid SoundCloud URL to display the player.') }}</div>
        </div>
    @endif
</div>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var frame = root.querySelector('.rj-sc-frame');
    var iframe = frame ? frame.querySelector('iframe') : null;
    if (!frame || !iframe) return;

    var done = false;
    function ready() {
        if (done) return;
        done = true;
        frame.classList.add('is-loaded');
    }

    iframe.addEventListener('load', ready);
    setTimeout(ready, 6000);
})();
</script>
