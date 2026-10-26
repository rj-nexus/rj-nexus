@php
    $image = $settings['image'] ?? '';
    $name = $settings['name'] ?? '';
    $position = $settings['position'] ?? '';
    $text = $settings['text'] ?? '';
    $rating = max(1, min(5, (int)($settings['rating'] ?? 5)));
    $style = $settings['style'] ?? 'modern';
    $starColor = $settings['star_color'] ?? '#f59e0b';
    $quoteColor = $settings['quote_color'] ?? '#8b5cf6';
    $imageStyle = $settings['image_style'] ?? 'circle';
    $avatarRadius = $imageStyle === 'circle' ? '9999px' : '1rem';
    $variantClass = in_array($style, ['modern', 'glass', 'minimal']) ? 'tc-' . $style : 'tc-modern';
@endphp

<style>
    #{{ $uid }} {
        --tc-star: {{ $starColor }};
        --tc-accent: {{ $quoteColor }};
        --tc-muted: #cbd5e1;
        position: relative;
        box-sizing: border-box;
        max-width: 56rem;
        margin: 0 auto;
        padding: 2.5rem;
        border-radius: 1.5rem;
        color: #0f172a;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease;
    }
    #{{ $uid }}:hover { transform: translateY(-4px); }

    /* Variants */
    #{{ $uid }}.tc-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 40px -12px rgba(15, 23, 42, .12);
    }
    #{{ $uid }}.tc-glass {
        background: rgba(255, 255, 255, .35);
        -webkit-backdrop-filter: blur(16px);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, .55);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, .18);
    }
    #{{ $uid }}.tc-minimal { background: transparent; }

    /* Layout */
    #{{ $uid }} .tc-row {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2rem;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .tc-row { flex-direction: row; align-items: flex-start; }
    }

    /* Author */
    #{{ $uid }} .tc-author {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 10rem;
        flex-shrink: 0;
    }
    #{{ $uid }} .tc-avatar {
        width: 7rem;
        height: 7rem;
        object-fit: cover;
        border-radius: {{ $avatarRadius }};
        border: 4px solid #ffffff;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, .15);
    }
    #{{ $uid }} .tc-avatar-ph {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
    }
    #{{ $uid }} .tc-avatar-ph svg { width: 2.5rem; height: 2.5rem; color: #cbd5e1; }
    #{{ $uid }} .tc-name {
        margin: 1rem 0 0;
        font-size: 1.125rem;
        font-weight: 800;
        line-height: 1.2;
    }
    #{{ $uid }} .tc-pos {
        margin: .25rem 0 0;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--tc-accent);
    }

    /* Body */
    #{{ $uid }} .tc-body {
        flex: 1;
        min-width: 0;
        text-align: center;
        position: relative;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .tc-body { text-align: left; }
    }
    #{{ $uid }} .tc-quote-icon {
        position: absolute;
        top: -1.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 4rem;
        height: 4rem;
        color: var(--tc-accent);
        opacity: .12;
        pointer-events: none;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .tc-quote-icon { left: 0; transform: none; }
    }
    #{{ $uid }} .tc-text {
        position: relative;
        z-index: 1;
        margin: 0 0 1.5rem;
        padding-top: .5rem;
        font-size: 1.125rem;
        line-height: 1.7;
        font-style: italic;
        font-weight: 500;
        color: #475569;
    }
    #{{ $uid }} .tc-stars {
        display: flex;
        gap: .25rem;
        justify-content: center;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .tc-stars { justify-content: flex-start; }
    }
    #{{ $uid }} .tc-stars svg { width: 1.25rem; height: 1.25rem; }
    #{{ $uid }} .tc-stars .on { fill: var(--tc-star); }
    #{{ $uid }} .tc-stars .off { fill: var(--tc-muted); }

    /* Review badge (top-right) */
    #{{ $uid }} .tc-badge {
        position: absolute;
        top: -14px;
        right: 18px;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .8rem;
        border-radius: 9999px;
        background: var(--tc-accent);
        color: #ffffff;
        font-size: .7rem;
        font-weight: 700;
        box-shadow: 0 8px 18px -6px var(--tc-accent);
        animation: tc-{{ $uid }}-pop 3s ease-in-out infinite;
    }
    #{{ $uid }} .tc-badge svg { width: 14px; height: 14px; }

    /* Character: review speech bubble mascot */
    #{{ $uid }} .tc-char {
        display: none;
        flex-shrink: 0;
        width: 6.5rem;
        height: 6.5rem;
        overflow: visible;
        animation: tc-{{ $uid }}-bob 3s ease-in-out infinite;
    }
    @media (min-width: 900px) {
        #{{ $uid }} .tc-char { display: block; }
    }
    #{{ $uid }} .tc-bubble { fill: var(--tc-accent); }
    #{{ $uid }} .tc-limb { stroke: var(--tc-accent); }
    #{{ $uid }} .tc-arm {
        transform-origin: 86px 56px;
    }
    #{{ $uid }}:hover .tc-arm {
        animation: tc-{{ $uid }}-wave .7s ease-in-out 2;
    }
    #{{ $uid }} .tc-cheek { fill: var(--tc-star); opacity: .5; }
    #{{ $uid }} .tc-mouth { stroke: #0f172a; }
    #{{ $uid }} .tc-spark {
        fill: var(--tc-star);
        transform-box: fill-box;
        transform-origin: center;
        animation: tc-{{ $uid }}-spark 2.4s ease-in-out infinite;
    }
    #{{ $uid }} .tc-spark.b { animation-delay: 1.2s; }
    #{{ $uid }} .tc-pupil { transition: transform .12s linear; fill: #0f172a; }
    #{{ $uid }} .tc-lid {
        fill: var(--tc-accent);
        transform-box: fill-box;
        transform-origin: top center;
        animation: tc-{{ $uid }}-blink 4.5s infinite;
    }

    /* Keyframes */
    @keyframes tc-{{ $uid }}-bob {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    @keyframes tc-{{ $uid }}-blink {
        0%, 92%, 100% { transform: scaleY(0); }
        96% { transform: scaleY(1); }
    }
    @keyframes tc-{{ $uid }}-wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-25deg); }
        50% { transform: rotate(5deg); }
        75% { transform: rotate(-20deg); }
    }
    @keyframes tc-{{ $uid }}-pop {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    @keyframes tc-{{ $uid }}-spark {
        0%, 100% { opacity: .2; transform: scale(.6); }
        50% { opacity: 1; transform: scale(1); }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} * { animation: none !important; transition: none !important; }
    }
</style>

<div id="{{ $uid }}" class="{{ $variantClass }}">
    <div class="tc-row">

        <div class="tc-author">
            @if($image)
                <img src="{{ $image }}" alt="{{ $name }}" class="tc-avatar">
            @else
                <div class="tc-avatar tc-avatar-ph" style="border-radius: {{ $avatarRadius }};">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            @endif

            @if($name)
                <h4 class="tc-name">{{ $name }}</h4>
            @endif
            @if($position)
                <p class="tc-pos">{{ $position }}</p>
            @endif
        </div>

        <div class="tc-body">
            <span class="tc-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                {{ __('Customer Review') }}
            </span>

            <svg class="tc-quote-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>

            @if($text)
                <p class="tc-text">"{{ $text }}"</p>
            @endif

            <div class="tc-stars">
                @for($i = 1; $i <= 5; $i++)
                    <svg viewBox="0 0 20 20" class="{{ $i <= $rating ? 'on' : 'off' }}">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
        </div>

        <svg class="tc-char" viewBox="0 0 100 100" aria-hidden="true">
            <ellipse cx="50" cy="96" rx="26" ry="4" fill="rgba(15,23,42,.08)"/>

            <path class="tc-bubble" d="M22 62 L16 84 L40 70 Z"/>
            <rect class="tc-bubble" x="12" y="14" width="76" height="58" rx="28"/>

            <path class="tc-limb" d="M14 56 Q4 62 8 74" stroke-width="6" stroke-linecap="round" fill="none"/>
            <g class="tc-arm">
                <path class="tc-limb" d="M86 56 Q98 50 94 38" stroke-width="6" stroke-linecap="round" fill="none"/>
            </g>

            <g class="tc-eye">
                <ellipse cx="36" cy="40" rx="7.5" ry="8.5" fill="#ffffff"/>
                <circle class="tc-pupil" cx="36" cy="41" r="3.8"/>
                <ellipse class="tc-lid" cx="36" cy="40" rx="7.5" ry="8.5"/>
            </g>
            <g class="tc-eye">
                <ellipse cx="64" cy="40" rx="7.5" ry="8.5" fill="#ffffff"/>
                <circle class="tc-pupil" cx="64" cy="41" r="3.8"/>
                <ellipse class="tc-lid" cx="64" cy="40" rx="7.5" ry="8.5"/>
            </g>

            <circle class="tc-cheek" cx="25" cy="53" r="4"/>
            <circle class="tc-cheek" cx="75" cy="53" r="4"/>
            <path class="tc-mouth" d="M43 53 Q50 60 57 53" stroke-width="2.5" fill="none" stroke-linecap="round"/>

            <circle class="tc-spark" cx="92" cy="12" r="3"/>
            <circle class="tc-spark b" cx="6" cy="22" r="2.2"/>
        </svg>

    </div>
</div>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.tcInit) return;
    root.dataset.tcInit = '1';

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var pupils = root.querySelectorAll('.tc-pupil');
    var mx = 0, my = 0, ticking = false;

    function update() {
        ticking = false;
        for (var i = 0; i < pupils.length; i++) {
            var eye = pupils[i].parentNode.getBoundingClientRect();
            var cx = eye.left + eye.width / 2;
            var cy = eye.top + eye.height / 2;
            var dx = mx - cx, dy = my - cy;
            var d = Math.sqrt(dx * dx + dy * dy) || 1;
            var m = Math.min(d, 300) / 300 * 3.5;
            pupils[i].style.transform = 'translate(' + (dx / d * m).toFixed(2) + 'px,' + (dy / d * m).toFixed(2) + 'px)';
        }
    }

    document.addEventListener('mousemove', function (e) {
        mx = e.clientX;
        my = e.clientY;
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });
})();
</script>
