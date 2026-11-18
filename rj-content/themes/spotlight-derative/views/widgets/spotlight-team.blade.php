@php
    $uid = 'team_' . substr(md5(uniqid('', true)), 0, 8);

    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $members = $settings['members'] ?? [];
    if (!is_array($members)) $members = [];
    $members = array_slice(array_values($members), 0, 9);

    $toRaw = function ($url) {
        if (str_contains($url, 'github.com') && str_contains($url, '/blob/')) {
            return str_replace(['github.com/', '/blob/'], ['raw.githubusercontent.com/', '/'], $url);
        }
        return $url;
    };

    $demoBase = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/';
@endphp

<section class="rj-tm-section" id="{{ $uid }}">
    <div class="rj-tm-bg" aria-hidden="true">
        <span class="rj-tm-blob rj-tm-blob-a"></span>
        <span class="rj-tm-blob rj-tm-blob-b"></span>
    </div>

    <div class="rj-tm-inner">

        @if($title || $subtitle)
            <div class="rj-tm-header">
                @if($title)
                    <h2 class="rj-tm-title rj-tm-reveal" style="--i:0;">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-tm-sub rj-tm-reveal" style="--i:1;">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if(!empty($members))
            <div class="rj-tm-grid">
                @foreach($members as $index => $member)
                    @php
                        $imgUrl = trim($member['image'] ?? '');

                        if ($imgUrl === '') {
                            $imgUrl = $demoBase . 'team' . (($index % 6) + 1) . '.webp';
                        } else {
                            $imgUrl = $toRaw($imgUrl);
                        }

                        $name = $member['name'] ?? '';
                        $role = $member['role'] ?? '';
                    @endphp

                    <article class="rj-tm-card rj-tm-reveal" style="--i: {{ $index + 2 }};">
                        <div class="rj-tm-photo">
                            <img src="{{ $imgUrl }}" alt="{{ $name }}" loading="lazy" decoding="async">
                        </div>
                        <div class="rj-tm-info">
                            <h3 class="rj-tm-name">{{ $name }}</h3>
                            @if($role)
                                <p class="rj-tm-role">{{ $role }}</p>
                            @endif
                            <span class="rj-tm-line"></span>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-tm-section {
            --a1: #3b82f6;
            --a2: #6366f1;
            --a3: #22d3ee;
            position: relative;
            width: 100%;
            background: transparent;
            padding: 56px 24px;
            overflow: hidden;
            isolation: isolate;
            contain: paint;
        }

        #{{ $uid }} .rj-tm-bg {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: min(100%, 1100px);
            transform: translateX(-50%);
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            -webkit-mask-composite: source-in;
            mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            mask-composite: intersect;
        }
        #{{ $uid }} .rj-tm-blob {
            position: absolute;
            width: min(360px, 52%);
            aspect-ratio: 1;
            border-radius: 50%;
            mix-blend-mode: screen;
        }
        #{{ $uid }} .rj-tm-blob-a {
            top: 18%;
            left: 10%;
            background: radial-gradient(circle, rgba(59, 130, 246, .28), transparent 65%);
            animation: rjTmDriftA 18s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-tm-blob-b {
            bottom: 18%;
            right: 10%;
            background: radial-gradient(circle, rgba(139, 92, 246, .24), transparent 65%);
            animation: rjTmDriftB 22s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-tm-inner {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
        }

        #{{ $uid }}.rj-tm-ready .rj-tm-reveal:not(.is-in) { opacity: 0; }
        #{{ $uid }} .rj-tm-reveal.is-in {
            animation: rjTmReveal .8s cubic-bezier(.2, .7, .2, 1) backwards;
            animation-delay: calc(var(--i, 0) * 70ms);
        }

        #{{ $uid }} .rj-tm-header {
            text-align: center;
            margin-bottom: 36px;
        }
        #{{ $uid }} .rj-tm-title {
            font-size: clamp(28px, 3.6vw, 42px);
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: -.03em;
            margin: 0 0 12px;
            color: transparent;
            background: linear-gradient(180deg, #fff 30%, rgba(255, 255, 255, .62));
            -webkit-background-clip: text;
            background-clip: text;
        }
        #{{ $uid }} .rj-tm-sub {
            font-size: 15px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 560px;
        }

        #{{ $uid }} .rj-tm-grid {
            --cols: 4;
            --gap: 16px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: var(--gap);
            perspective: 1200px;
        }

        #{{ $uid }} .rj-tm-card {
            position: relative;
            isolation: isolate;
            flex: 0 0 calc((100% - (var(--cols) - 1) * var(--gap)) / var(--cols));
            min-width: 0;
            padding: 8px;
            border-radius: 26px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .09), rgba(255, 255, 255, .025));
            border: 1px solid rgba(255, 255, 255, .1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .16), 0 18px 40px rgba(0, 0, 0, .28);
            backdrop-filter: blur(20px) saturate(140%);
            -webkit-backdrop-filter: blur(20px) saturate(140%);
            transform: rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg));
            transition: transform .25s ease-out, translate .45s cubic-bezier(.2, .7, .2, 1), box-shadow .4s;
        }
        #{{ $uid }} .rj-tm-card:hover {
            translate: 0 -6px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 28px 56px rgba(0, 0, 0, .4), 0 0 44px rgba(59, 130, 246, .16);
        }
        #{{ $uid }} .rj-tm-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 1px;
            border-radius: inherit;
            background: radial-gradient(170px circle at var(--mx, 50%) var(--my, 0%), rgba(125, 211, 252, .95), rgba(99, 102, 241, .5) 45%, transparent 72%);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
            opacity: 0;
            transition: opacity .35s;
            pointer-events: none;
            z-index: 2;
        }
        #{{ $uid }} .rj-tm-card:hover::before { opacity: 1; }
        #{{ $uid }} .rj-tm-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(260px circle at var(--mx, 50%) var(--my, 0%), rgba(99, 102, 241, .18), transparent 65%);
            opacity: 0;
            transition: opacity .4s;
            pointer-events: none;
            z-index: 0;
        }
        #{{ $uid }} .rj-tm-card:hover::after { opacity: 1; }

        #{{ $uid }} .rj-tm-photo {
            position: relative;
            z-index: 1;
            aspect-ratio: 1 / 1.08;
            border-radius: 19px;
            overflow: hidden;
            background: linear-gradient(145deg, rgba(59, 130, 246, .2), rgba(99, 102, 241, .08));
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .06);
        }
        #{{ $uid }} .rj-tm-photo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            filter: grayscale(.7) brightness(.88) contrast(1.05);
            transform: scale(1.02);
            transition: filter .7s ease, transform .9s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-tm-card:hover .rj-tm-photo img {
            filter: grayscale(0) brightness(1) contrast(1.02);
            transform: scale(1.08);
        }
        #{{ $uid }} .rj-tm-photo::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: -70%;
            width: 45%;
            background: linear-gradient(105deg, transparent, rgba(255, 255, 255, .24), transparent);
            transform: skewX(-12deg);
            z-index: 2;
            pointer-events: none;
            transition: left .9s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-tm-card:hover .rj-tm-photo::before { left: 130%; }
        #{{ $uid }} .rj-tm-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 55%, rgba(6, 8, 20, .55));
            pointer-events: none;
        }

        #{{ $uid }} .rj-tm-info {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding: 14px 10px 8px;
        }
        #{{ $uid }} .rj-tm-name {
            font-size: 17px;
            font-weight: 600;
            letter-spacing: -.01em;
            line-height: 1.25;
            color: #fff;
            margin: 0;
        }
        #{{ $uid }} .rj-tm-role {
            font-size: 13px;
            line-height: 1.4;
            color: rgba(255, 255, 255, .6);
            margin: 0;
        }
        #{{ $uid }} .rj-tm-line {
            display: block;
            width: 18px;
            height: 2px;
            margin-top: 10px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--a1), var(--a3));
            transition: width .5s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-tm-card:hover .rj-tm-line { width: 52px; }

        @keyframes rjTmReveal {
            from { opacity: 0; transform: translateY(22px) scale(.97); filter: blur(8px); }
            to { opacity: 1; transform: none; filter: blur(0); }
        }
        @keyframes rjTmDriftA {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(40px, 24px) scale(1.1); }
        }
        @keyframes rjTmDriftB {
            from { transform: translate(0, 0) scale(1.05); }
            to { transform: translate(-36px, -20px) scale(.95); }
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-tm-grid { --cols: 3; }
        }
        @media (max-width: 700px) {
            #{{ $uid }}.rj-tm-section { padding: 44px 20px; }
            #{{ $uid }} .rj-tm-grid { --cols: 2; --gap: 12px; }
            #{{ $uid }} .rj-tm-card { border-radius: 22px; padding: 6px; }
            #{{ $uid }} .rj-tm-photo { border-radius: 16px; }
            #{{ $uid }} .rj-tm-info { padding: 12px 8px 6px; }
            #{{ $uid }} .rj-tm-name { font-size: 15px; }
            #{{ $uid }} .rj-tm-role { font-size: 12px; }
        }
        @media (max-width: 400px) {
            #{{ $uid }} .rj-tm-grid { --cols: 1; max-width: 320px; margin: 0 auto; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *,
            #{{ $uid }} *::before,
            #{{ $uid }} *::after { animation: none !important; transition: none !important; }
            #{{ $uid }}.rj-tm-ready .rj-tm-reveal:not(.is-in) { opacity: 1; }
        }
    </style>

    <script>
        (function () {
            var root = document.getElementById('{{ $uid }}');
            if (!root) return;
            root.classList.add('rj-tm-ready');

            var items = root.querySelectorAll('.rj-tm-reveal');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('is-in'); });
            } else {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-in');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });
                items.forEach(function (el) { io.observe(el); });
            }

            root.querySelectorAll('.rj-tm-card').forEach(function (card) {
                card.addEventListener('pointermove', function (e) {
                    if (e.pointerType === 'touch') return;
                    var r = card.getBoundingClientRect();
                    var x = e.clientX - r.left;
                    var y = e.clientY - r.top;
                    card.style.setProperty('--mx', x + 'px');
                    card.style.setProperty('--my', y + 'px');
                    card.style.setProperty('--ry', ((x / r.width - 0.5) * 8).toFixed(2) + 'deg');
                    card.style.setProperty('--rx', (-(y / r.height - 0.5) * 8).toFixed(2) + 'deg');
                });
                card.addEventListener('pointerleave', function () {
                    card.style.setProperty('--rx', '0deg');
                    card.style.setProperty('--ry', '0deg');
                });
            });
        })();
    </script>
</section>
