@php
    $layout       = $settings['layout'] ?? 'centered';
    $badge        = $settings['badge'] ?? '';
    $title        = $settings['title'] ?? '';
    $highlight    = trim($settings['highlight'] ?? '');
    $desc         = $settings['desc'] ?? '';
    $btn1Label    = $settings['btn1_label'] ?? '';
    $btn1Url      = $settings['btn1_url'] ?? '#';
    $btn2Label    = $settings['btn2_label'] ?? '';
    $btn2Url      = $settings['btn2_url'] ?? '#';
    $image        = $settings['image'] ?? '';
    $chipsRaw     = $settings['chips'] ?? '';
    $bgStyle      = $settings['bg_style'] ?? 'gradient';
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $accent2      = $settings['accent2'] ?? '#ec4899';
    $titleColor   = $settings['title_color'] ?? '#0f172a';
    $textColor    = $settings['text_color'] ?? '#475569';
    $radius       = $settings['radius'] ?? 'xl';
    $paddingY     = (int) ($settings['padding_y'] ?? 80);
    $showShapes   = $settings['show_shapes'] ?? true;
    $animate      = $settings['animate'] ?? true;

    $radiusMap = ['md' => '14px', 'xl' => '22px', '2xl' => '30px', '3xl' => '40px'];
    $radiusCss = $radiusMap[$radius] ?? '22px';

    $chips = [];
    if ($chipsRaw !== '') {
        foreach (preg_split('/\r\n|\r|\n/', (string) $chipsRaw) as $c) {
            $c = trim($c);
            if ($c !== '') $chips[] = $c;
        }
    }

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(
            e($highlight),
            '<span class="rj-cta-hl">' . e($highlight) . '</span>',
            $titleHtml
        );
    }

    $isDark  = $bgStyle === 'dark';
    $isSplit = $layout === 'split';

    if (in_array($bgStyle, ['gradient', 'dark', 'glass'], true)) {
        $finalTitleColor = $isDark ? '#ffffff' : $titleColor;
        $finalTextColor  = $isDark ? 'rgba(255,255,255,.75)' : $textColor;
    } else {
        $finalTitleColor = $titleColor;
        $finalTextColor  = $textColor;
    }
@endphp

<style>
    #{{ $uid }} {
        --cta-a: {{ $accent }};
        --cta-b: {{ $accent2 }};
        --cta-title: {{ $finalTitleColor }};
        --cta-text: {{ $finalTextColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-cta-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        padding: {{ $isSplit ? '52px 44px' : '64px 32px' }};
        isolation: isolate;
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-cta-wrap { padding: 44px 22px; }
    }

    #{{ $uid }}[data-bg="gradient"] .rj-cta-wrap {
        background: linear-gradient(125deg, var(--cta-a), var(--cta-b));
        box-shadow: 0 30px 60px -30px color-mix(in srgb, var(--cta-a) 55%, transparent);
    }
    #{{ $uid }}[data-bg="solid"] .rj-cta-wrap {
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 40px -20px rgba(15,23,42,.15);
    }
    #{{ $uid }}[data-bg="dark"] .rj-cta-wrap {
        background: #0f172a;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.6);
    }
    #{{ $uid }}[data-bg="glass"] .rj-cta-wrap {
        background: linear-gradient(125deg, color-mix(in srgb, var(--cta-a) 20%, #fff), color-mix(in srgb, var(--cta-b) 20%, #fff));
        border: 1px solid rgba(255,255,255,.6);
        backdrop-filter: blur(12px);
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.2);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-title,
    #{{ $uid }}[data-bg="gradient"] .rj-cta-desc,
    #{{ $uid }}[data-bg="dark"] .rj-cta-title,
    #{{ $uid }}[data-bg="dark"] .rj-cta-desc {
        color: #fff;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-desc { opacity: .88; }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-badge,
    #{{ $uid }}[data-bg="dark"] .rj-cta-badge {
        background: rgba(255,255,255,.15);
        color: #fff;
        border-color: rgba(255,255,255,.28);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-chip,
    #{{ $uid }}[data-bg="dark"] .rj-cta-chip {
        background: rgba(255,255,255,.12);
        color: rgba(255,255,255,.92);
        border-color: rgba(255,255,255,.22);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-btn-ghost,
    #{{ $uid }}[data-bg="dark"] .rj-cta-btn-ghost {
        background: rgba(255,255,255,.12);
        color: #fff;
        border-color: rgba(255,255,255,.35);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-btn-ghost:hover,
    #{{ $uid }}[data-bg="dark"] .rj-cta-btn-ghost:hover {
        background: rgba(255,255,255,.22);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-btn-primary,
    #{{ $uid }}[data-bg="dark"] .rj-cta-btn-primary {
        background: #fff;
        color: var(--cta-a);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-btn-primary:hover,
    #{{ $uid }}[data-bg="dark"] .rj-cta-btn-primary:hover {
        background: rgba(255,255,255,.9);
    }

    #{{ $uid }} .rj-cta-shapes {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
        border-radius: inherit;
    }
    #{{ $uid }} .rj-cta-shape {
        position: absolute;
        border-radius: 50%;
        opacity: .35;
        filter: blur(40px);
        animation: rjCtaFloat 12s ease-in-out infinite;
    }
    #{{ $uid }} .rj-cta-shape.s1 {
        width: 260px; height: 260px;
        background: rgba(255,255,255,.35);
        top: -80px; left: -60px;
    }
    #{{ $uid }} .rj-cta-shape.s2 {
        width: 200px; height: 200px;
        background: rgba(255,255,255,.25);
        bottom: -60px; right: -40px;
        animation-delay: -3s;
    }
    #{{ $uid }} .rj-cta-shape.s3 {
        width: 140px; height: 140px;
        background: rgba(255,255,255,.3);
        top: 40%; right: 22%;
        animation-delay: -6s;
    }
    @keyframes rjCtaFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(20px, -30px) scale(1.1); }
    }

    #{{ $uid }} .rj-cta-inner {
        position: relative;
        z-index: 1;
    }
    #{{ $uid }} .rj-cta-centered {
        text-align: center;
        max-width: 720px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-cta-split {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        gap: 44px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .rj-cta-split { grid-template-columns: 1fr; gap: 32px; text-align: center; }
        #{{ $uid }} .rj-cta-split .rj-cta-actions,
        #{{ $uid }} .rj-cta-split .rj-cta-chips { justify-content: center; }
    }

    #{{ $uid }} .rj-cta-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        background: color-mix(in srgb, var(--cta-a) 12%, transparent);
        color: var(--cta-a);
        border: 1px solid color-mix(in srgb, var(--cta-a) 25%, transparent);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 18px;
    }
    #{{ $uid }} .rj-cta-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: rjCtaPulse 1.8s ease-in-out infinite;
    }
    @keyframes rjCtaPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .4; transform: scale(1.4); }
    }

    #{{ $uid }} .rj-cta-title {
        font-size: clamp(24px, 3.4vw, 40px);
        font-weight: 800;
        color: var(--cta-title);
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0 0 14px;
    }
    #{{ $uid }} .rj-cta-hl {
        background: linear-gradient(90deg, var(--cta-a), var(--cta-b));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        position: relative;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-hl,
    #{{ $uid }}[data-bg="dark"] .rj-cta-hl {
        background: linear-gradient(90deg, #fff, rgba(255,255,255,.7));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #{{ $uid }} .rj-cta-desc {
        font-size: 15px;
        color: var(--cta-text);
        line-height: 1.7;
        margin: 0 0 26px;
        max-width: 620px;
    }
    #{{ $uid }} .rj-cta-centered .rj-cta-desc { margin-left: auto; margin-right: auto; }

    #{{ $uid }} .rj-cta-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }
    #{{ $uid }} .rj-cta-centered .rj-cta-actions { justify-content: center; }

    #{{ $uid }} .rj-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, background .25s ease, box-shadow .25s ease;
        border: 1.5px solid transparent;
    }
    #{{ $uid }} .rj-cta-btn:hover { transform: translateY(-2px); }
    #{{ $uid }} .rj-cta-btn:active { transform: scale(.98); }

    #{{ $uid }} .rj-cta-btn-primary {
        background: var(--cta-a);
        color: #fff;
        box-shadow: 0 12px 24px -12px color-mix(in srgb, var(--cta-a) 60%, transparent);
    }
    #{{ $uid }} .rj-cta-btn-primary:hover {
        background: color-mix(in srgb, var(--cta-a) 88%, #000);
        box-shadow: 0 16px 32px -12px color-mix(in srgb, var(--cta-a) 70%, transparent);
    }
    #{{ $uid }} .rj-cta-btn-ghost {
        background: transparent;
        color: var(--cta-title);
        border-color: color-mix(in srgb, var(--cta-title) 20%, transparent);
    }
    #{{ $uid }} .rj-cta-btn-ghost:hover {
        background: color-mix(in srgb, var(--cta-title) 6%, transparent);
    }

    #{{ $uid }} .rj-cta-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    #{{ $uid }} .rj-cta-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: color-mix(in srgb, var(--cta-a) 8%, transparent);
        color: var(--cta-text);
        border: 1px solid color-mix(in srgb, var(--cta-a) 18%, transparent);
        font-size: 11.5px;
        font-weight: 600;
    }
    #{{ $uid }} .rj-cta-chip svg {
        color: var(--cta-a);
        flex-shrink: 0;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-cta-chip svg,
    #{{ $uid }}[data-bg="dark"] .rj-cta-chip svg {
        color: #fff;
    }

    #{{ $uid }} .rj-cta-media {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: rgba(0,0,0,.05);
        box-shadow: 0 24px 48px -20px rgba(15,23,42,.35);
    }
    #{{ $uid }} .rj-cta-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    #{{ $uid }} .rj-cta-anim-on {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity .8s ease, transform .8s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-cta-anim-on.is-visible {
        opacity: 1;
        transform: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-cta-shape { animation: none; }
        #{{ $uid }} .rj-cta-anim-on { opacity: 1; transform: none; transition: none; }
        #{{ $uid }} .rj-cta-badge::before { animation: none; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}">
    <div class="rj-cta-wrap">
        @if($showShapes)
            <div class="rj-cta-shapes" aria-hidden="true">
                <span class="rj-cta-shape s1"></span>
                <span class="rj-cta-shape s2"></span>
                <span class="rj-cta-shape s3"></span>
            </div>
        @endif

        <div class="rj-cta-inner {{ $animate ? 'rj-cta-anim-on' : '' }}" data-anim>
            @if($isSplit)
                <div class="rj-cta-split">
                    <div>
                        @if($badge !== '')
                            <span class="rj-cta-badge">{{ $badge }}</span>
                        @endif
                        @if($title !== '')
                            <h2 class="rj-cta-title">{!! $titleHtml !!}</h2>
                        @endif
                        @if($desc !== '')
                            <p class="rj-cta-desc">{{ $desc }}</p>
                        @endif

                        <div class="rj-cta-actions">
                            @if($btn1Label !== '')
                                <a href="{{ $btn1Url }}" class="rj-cta-btn rj-cta-btn-primary">
                                    <span>{{ $btn1Label }}</span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                            @if($btn2Label !== '')
                                <a href="{{ $btn2Url }}" class="rj-cta-btn rj-cta-btn-ghost">
                                    <span>{{ $btn2Label }}</span>
                                </a>
                            @endif
                        </div>

                        @if(!empty($chips))
                            <div class="rj-cta-chips">
                                @foreach($chips as $chip)
                                    <span class="rj-cta-chip">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $chip }}</span>
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($image !== '')
                        <div class="rj-cta-media">
                            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                        </div>
                    @endif
                </div>
            @else
                <div class="rj-cta-centered">
                    @if($badge !== '')
                        <span class="rj-cta-badge">{{ $badge }}</span>
                    @endif
                    @if($title !== '')
                        <h2 class="rj-cta-title">{!! $titleHtml !!}</h2>
                    @endif
                    @if($desc !== '')
                        <p class="rj-cta-desc">{{ $desc }}</p>
                    @endif

                    <div class="rj-cta-actions">
                        @if($btn1Label !== '')
                            <a href="{{ $btn1Url }}" class="rj-cta-btn rj-cta-btn-primary">
                                <span>{{ $btn1Label }}</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                        @if($btn2Label !== '')
                            <a href="{{ $btn2Url }}" class="rj-cta-btn rj-cta-btn-ghost">
                                <span>{{ $btn2Label }}</span>
                            </a>
                        @endif
                    </div>

                    @if(!empty($chips))
                        <div class="rj-cta-chips" style="justify-content: center;">
                            @foreach($chips as $chip)
                                <span class="rj-cta-chip">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $chip }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@if($animate)
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var el = root.querySelector('[data-anim]');
    if (!el || typeof IntersectionObserver === 'undefined') {
        if (el) el.classList.add('is-visible');
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                el.classList.add('is-visible');
                io.unobserve(el);
            }
        });
    }, { threshold: 0.15 });
    io.observe(el);
})();
</script>
@endif
