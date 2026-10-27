@php
    $allowedLayouts = ['centered', 'split'];
    $allowedBg      = ['gradient', 'solid', 'dark', 'glass'];
    $allowedRadius  = ['md', 'xl', '2xl', '3xl'];

    $layout    = in_array($settings['layout'] ?? 'centered', $allowedLayouts, true) ? $settings['layout'] : 'centered';
    $bgStyle   = in_array($settings['bg_style'] ?? 'dark', $allowedBg, true) ? $settings['bg_style'] : 'dark';
    $radius    = in_array($settings['radius'] ?? 'xl', $allowedRadius, true) ? $settings['radius'] : 'xl';
    $paddingY  = max(0, min(240, (int) ($settings['padding_y'] ?? 80)));
    $animateOn = !empty($settings['animate'] ?? true);

    $badge     = trim((string) ($settings['badge'] ?? ''));
    $title     = trim((string) ($settings['title'] ?? ''));
    $highlight = trim((string) ($settings['highlight'] ?? ''));
    $desc      = trim((string) ($settings['desc'] ?? ''));
    $image     = trim((string) ($settings['image'] ?? ''));
    $btn1Label = trim((string) ($settings['btn1_label'] ?? ''));
    $btn2Label = trim((string) ($settings['btn2_label'] ?? ''));

    $safeUrl = function ($v) {
        $v = trim((string) $v);
        return ($v === '' || preg_match('/^\s*(javascript|data|vbscript):/i', $v)) ? '#' : $v;
    };
    $btn1Url = $safeUrl($settings['btn1_url'] ?? '#');
    $btn2Url = $safeUrl($settings['btn2_url'] ?? '#');

    $chips = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['chips'] ?? '')) as $c) {
        $c = trim($c);
        if ($c !== '') $chips[] = $c;
    }

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v)) return $d;
        if (strlen($v) === 4) {
            $v = '#' . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3];
        }
        return $v;
    };
    $rgb = function ($hex) {
        $h = ltrim($hex, '#');
        return hexdec(substr($h, 0, 2)) . ',' . hexdec(substr($h, 2, 2)) . ',' . hexdec(substr($h, 4, 2));
    };

    $accent     = $hexOk($settings['accent'] ?? '', '#6366f1');
    $accent2    = $hexOk($settings['accent2'] ?? '', '#f43f5e');
    $titleColor = $hexOk($settings['title_color'] ?? '', '#0f172a');
    $textColor  = $hexOk($settings['text_color'] ?? '', '#475569');

    $isDarkBg   = in_array($bgStyle, ['gradient', 'dark'], true);
    $finalTitle = $isDarkBg ? '#ffffff' : $titleColor;
    $finalText  = $isDarkBg ? 'rgba(255,255,255,.78)' : $textColor;

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(e($highlight), '<mark class="hx-mark">' . e($highlight) . '</mark>', $titleHtml);
    }

    $radiusCss = ['md' => '14px', 'xl' => '22px', '2xl' => '30px', '3xl' => '42px'][$radius];
    $bodyPad   = $layout === 'split' ? '72px 64px' : '88px 40px';
@endphp

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --b: {{ $accent2 }};
        --a-rgb: {{ $rgb($accent) }};
        --b-rgb: {{ $rgb($accent2) }};
        --ti: {{ $finalTitle }};
        --tx: {{ $finalText }};
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .hx-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        isolation: isolate;
    }

    #{{ $uid }} .hx-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }
    #{{ $uid }}[data-bg="dark"] .hx-bg {
        background:
            radial-gradient(900px 420px at 0% 0%, rgba(var(--a-rgb), .28), transparent 60%),
            radial-gradient(700px 380px at 100% 100%, rgba(var(--b-rgb), .18), transparent 60%),
            #0b1020;
    }
    #{{ $uid }}[data-bg="gradient"] .hx-bg {
        background: linear-gradient(125deg, var(--a) 0%, var(--b) 100%);
    }
    #{{ $uid }}[data-bg="solid"] .hx-bg {
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, .1);
        border-radius: inherit;
    }
    #{{ $uid }}[data-bg="glass"] .hx-bg {
        background: rgba(255, 255, 255, .14);
        -webkit-backdrop-filter: blur(18px);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: inherit;
    }

    #{{ $uid }} .hx-body {
        position: relative;
        z-index: 1;
        padding: {{ $bodyPad }};
    }
    @media (max-width: 720px) {
        #{{ $uid }} .hx-body { padding: 52px 22px; }
    }

    #{{ $uid }} .hx-inner-centered {
        max-width: 740px;
        margin: 0 auto;
        text-align: center;
    }
    #{{ $uid }} .hx-inner-split {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 56px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .hx-inner-split {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }
        #{{ $uid }} .hx-inner-split .hx-actions,
        #{{ $uid }} .hx-inner-split .hx-chips { justify-content: center; }
        #{{ $uid }} .hx-inner-split .hx-desc { margin-left: auto; margin-right: auto; }
    }

    #{{ $uid }} .hx-badge {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 22px;
        padding: 6px 14px 6px 10px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        color: var(--ti);
        border: 1px solid rgba(var(--a-rgb), .35);
        background: rgba(var(--a-rgb), .08);
    }
    #{{ $uid }}[data-bg="dark"] .hx-badge,
    #{{ $uid }}[data-bg="gradient"] .hx-badge {
        border-color: rgba(255, 255, 255, .25);
        background: rgba(255, 255, 255, .1);
    }
    #{{ $uid }} .hx-badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--a);
    }
    #{{ $uid }}[data-bg="dark"] .hx-badge-dot,
    #{{ $uid }}[data-bg="gradient"] .hx-badge-dot { background: #fff; }

    #{{ $uid }} .hx-title {
        margin: 0 0 20px;
        font-size: clamp(32px, 4.6vw, 58px);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -.035em;
        color: var(--ti);
        text-wrap: balance;
    }

    #{{ $uid }} .hx-mark {
        color: inherit;
        padding: 0 .08em;
        margin: 0 -.08em;
        background-image: linear-gradient(rgba(var(--b-rgb), .45), rgba(var(--b-rgb), .45));
        background-repeat: no-repeat;
        background-position: 0 88%;
        background-size: 100% 36%;
        -webkit-box-decoration-break: clone;
        box-decoration-break: clone;
    }
    #{{ $uid }}[data-bg="dark"] .hx-mark {
        background-image: linear-gradient(rgba(var(--a-rgb), .6), rgba(var(--a-rgb), .6));
    }
    #{{ $uid }}[data-bg="gradient"] .hx-mark {
        background-image: linear-gradient(rgba(255, 255, 255, .35), rgba(255, 255, 255, .35));
    }

    #{{ $uid }} .hx-desc {
        margin: 0 0 34px;
        max-width: 56ch;
        font-size: 17px;
        line-height: 1.7;
        color: var(--tx);
    }
    #{{ $uid }} .hx-inner-centered .hx-desc { margin-left: auto; margin-right: auto; }

    #{{ $uid }} .hx-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 30px;
    }
    #{{ $uid }} .hx-inner-centered .hx-actions,
    #{{ $uid }} .hx-inner-centered .hx-chips { justify-content: center; }

    #{{ $uid }} .hx-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 26px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
    }
    #{{ $uid }} .hx-btn:focus-visible {
        outline: 3px solid var(--b);
        outline-offset: 3px;
    }
    #{{ $uid }} .hx-btn:active { transform: translateY(1px); }

    #{{ $uid }} .hx-btn-p {
        background: var(--a);
        color: #fff;
        box-shadow: 0 10px 24px -12px rgba(var(--a-rgb), .9);
    }
    #{{ $uid }} .hx-btn-p:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -14px rgba(var(--a-rgb), 1); }
    #{{ $uid }}[data-bg="dark"] .hx-btn-p,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-p {
        background: #fff;
        color: #0b1020;
        box-shadow: 0 10px 24px -12px rgba(0, 0, 0, .5);
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn-p:focus-visible,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-p:focus-visible { outline-color: #fff; }

    #{{ $uid }} .hx-btn-s {
        color: var(--ti);
        background: transparent;
        border: 1.5px solid rgba(var(--a-rgb), .4);
    }
    #{{ $uid }} .hx-btn-s:hover {
        background: rgba(var(--a-rgb), .1);
        border-color: var(--a);
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn-s,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-s { border-color: rgba(255, 255, 255, .35); }
    #{{ $uid }}[data-bg="dark"] .hx-btn-s:hover,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-s:hover {
        background: rgba(255, 255, 255, .12);
        border-color: rgba(255, 255, 255, .7);
    }
    #{{ $uid }}[data-bg="dark"] .hx-btn-s:focus-visible,
    #{{ $uid }}[data-bg="gradient"] .hx-btn-s:focus-visible { outline-color: #fff; }

    #{{ $uid }} .hx-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #{{ $uid }} .hx-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--tx);
    }
    #{{ $uid }} .hx-chip svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        color: var(--a);
    }
    #{{ $uid }}[data-bg="dark"] .hx-chip svg,
    #{{ $uid }}[data-bg="gradient"] .hx-chip svg { color: #fff; }

    #{{ $uid }} .hx-media {
        position: relative;
        margin: 0;
    }
    #{{ $uid }} .hx-media::before {
        content: "";
        position: absolute;
        inset: 14px -14px -14px 14px;
        border-radius: 22px;
        border: 2px solid rgba(var(--a-rgb), .55);
    }
    #{{ $uid }}[data-bg="dark"] .hx-media::before,
    #{{ $uid }}[data-bg="gradient"] .hx-media::before { border-color: rgba(255, 255, 255, .35); }
    #{{ $uid }} .hx-media-frame {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        border-radius: 20px;
        background: #111827;
        box-shadow: 0 30px 60px -30px rgba(0, 0, 0, .6);
    }
    #{{ $uid }} .hx-media-frame img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (prefers-reduced-motion: no-preference) {
        #{{ $uid }}[data-animate="1"] .hx-rise {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .7s ease, transform .8s cubic-bezier(.2, .8, .2, 1);
            transition-delay: calc(var(--i, 0) * 110ms);
        }
        #{{ $uid }}[data-animate="1"].is-in .hx-rise {
            opacity: 1;
            transform: none;
        }
        #{{ $uid }}[data-animate="1"] .hx-mark {
            background-size: 0% 36%;
            transition: background-size .9s .7s cubic-bezier(.2, .8, .2, 1);
        }
        #{{ $uid }}[data-animate="1"].is-in .hx-mark { background-size: 100% 36%; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}" data-animate="{{ $animateOn ? '1' : '0' }}">
    <div class="hx-wrap">
        <div class="hx-bg" aria-hidden="true"></div>

        <div class="hx-body">
            <div class="hx-inner-{{ $layout === 'split' ? 'split' : 'centered' }}">
                <div class="hx-content">
                    @if($badge !== '')
                        <p class="hx-badge hx-rise" style="--i:0">
                            <span class="hx-badge-dot" aria-hidden="true"></span>
                            <span>{{ $badge }}</span>
                        </p>
                    @endif

                    @if($title !== '')
                        <h2 class="hx-title hx-rise" style="--i:1">{!! $titleHtml !!}</h2>
                    @endif

                    @if($desc !== '')
                        <p class="hx-desc hx-rise" style="--i:2">{{ $desc }}</p>
                    @endif

                    @if($btn1Label !== '' || $btn2Label !== '')
                        <div class="hx-actions hx-rise" style="--i:3">
                            @if($btn1Label !== '')
                                <a href="{{ $btn1Url }}" class="hx-btn hx-btn-p">{{ $btn1Label }}</a>
                            @endif
                            @if($btn2Label !== '')
                                <a href="{{ $btn2Url }}" class="hx-btn hx-btn-s">{{ $btn2Label }}</a>
                            @endif
                        </div>
                    @endif

                    @if(!empty($chips))
                        <ul class="hx-chips hx-rise" style="--i:4">
                            @foreach($chips as $chip)
                                <li class="hx-chip">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $chip }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                @if($layout === 'split' && $image !== '')
                    <figure class="hx-media hx-rise" style="--i:2">
                        <div class="hx-media-frame">
                            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                        </div>
                    </figure>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    if (root.getAttribute('data-animate') !== '1' || !('IntersectionObserver' in window)) {
        root.classList.add('is-in');
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) {
            root.classList.add('is-in');
            io.disconnect();
        }
    }, { threshold: 0.15 });
    io.observe(root);
})();
</script>
