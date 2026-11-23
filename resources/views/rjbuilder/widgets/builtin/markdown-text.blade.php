@php
    $widthMap = ['600' => '37.5rem', '800' => '50rem', '1000' => '62.5rem', '1200' => '75rem', 'full' => '100%'];
    $padMap = ['none' => '0px', 'sm' => '16px', 'md' => '32px', 'lg' => '64px'];

    $maxWidth = $widthMap[$opts['max_width']] ?? '50rem';
    $padding = $padMap[$opts['padding']] ?? '32px';

    $hasToc = $opts['show_toc'] && count($headings) > 0;
    $tocSidebar = $hasToc && $opts['toc_position'] === 'sidebar';
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1/themes/prism-{{ $opts['code_theme'] }}.min.css">

<style>
    #{{ $uid }} { --acc: {{ $opts['accent'] }}; --t: #0f172a; --m: #475569; --bd: #e2e8f0; --bg: #fff; --code-bg: #f6f8fa; width: 100%; padding: {{ $padding }} 16px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}[data-style="dark"] { --t: #e5e7eb; --m: #a5b0c5; --bd: rgba(255,255,255,.1); --bg: #0f172a; --code-bg: #1e293b; }
    #{{ $uid }}[data-style="bordered"] { --bg: transparent; }

    #{{ $uid }} .rjmd-wrap { max-width: {{ $maxWidth }}; margin: 0 auto; }
    #{{ $uid }} .rjmd-wrap.rjmd-has-sidebar { display: grid; grid-template-columns: 220px 1fr; gap: 40px; max-width: 100%; }
    @media (max-width: 900px) { #{{ $uid }} .rjmd-wrap.rjmd-has-sidebar { grid-template-columns: 1fr; gap: 20px; } }

    /* TOC */
    #{{ $uid }} .rjmd-toc { border-left: 2px solid var(--bd); padding: 8px 0 8px 16px; margin: 0; }
    #{{ $uid }}[data-style="dark"] .rjmd-toc { border-color: rgba(255,255,255,.15); }
    #{{ $uid }} .rjmd-toc h3 { margin: 0 0 12px; font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; color: var(--m); font-weight: 700; }
    #{{ $uid }} .rjmd-toc ol { list-style: none; padding: 0; margin: 0; }
    #{{ $uid }} .rjmd-toc li { margin: 0 0 6px; font-size: .9rem; line-height: 1.4; }
    #{{ $uid }} .rjmd-toc li.rjmd-toc-l2 { padding-left: 14px; }
    #{{ $uid }} .rjmd-toc li.rjmd-toc-l3 { padding-left: 28px; }
    #{{ $uid }} .rjmd-toc li.rjmd-toc-l4 { padding-left: 42px; }
    #{{ $uid }} .rjmd-toc a { color: var(--m); text-decoration: none; transition: color .2s ease; }
    #{{ $uid }} .rjmd-toc a:hover, #{{ $uid }} .rjmd-toc a.is-active { color: var(--acc); }

    #{{ $uid }} .rjmd-toc-top { margin: 0 0 32px; padding: 20px 24px; background: var(--code-bg); border: 1px solid var(--bd); border-radius: 12px; border-left-width: 4px; border-left-color: var(--acc); }
    #{{ $uid }}[data-style="dark"] .rjmd-toc-top { background: rgba(255,255,255,.03); }

    #{{ $uid }} .rjmd-sidebar { position: sticky; top: 24px; align-self: start; max-height: calc(100vh - 48px); overflow-y: auto; }

    /* Content */
    #{{ $uid }} .rjmd-content { color: var(--t); line-height: 1.75; font-size: 1.02rem; }
    #{{ $uid }}[data-style="bordered"] .rjmd-content { border: 1px solid var(--bd); border-radius: 12px; padding: 32px; background: var(--bg); }

    #{{ $uid }} .rjmd-content > :first-child { margin-top: 0; }
    #{{ $uid }} .rjmd-content > :last-child { margin-bottom: 0; }

    #{{ $uid }} .rjmd-content h1,
    #{{ $uid }} .rjmd-content h2,
    #{{ $uid }} .rjmd-content h3,
    #{{ $uid }} .rjmd-content h4,
    #{{ $uid }} .rjmd-content h5,
    #{{ $uid }} .rjmd-content h6 { color: var(--t); font-weight: 700; line-height: 1.3; margin: 2em 0 .75em; letter-spacing: -.02em; scroll-margin-top: 24px; }
    #{{ $uid }} .rjmd-content h1 { font-size: 2.1rem; }
    #{{ $uid }} .rjmd-content h2 { font-size: 1.6rem; border-bottom: 1px solid var(--bd); padding-bottom: .35em; }
    #{{ $uid }} .rjmd-content h3 { font-size: 1.28rem; }
    #{{ $uid }} .rjmd-content h4 { font-size: 1.1rem; }
    #{{ $uid }} .rjmd-content h5,
    #{{ $uid }} .rjmd-content h6 { font-size: 1rem; color: var(--m); }

    #{{ $uid }} .rjmd-content p { margin: 0 0 1.1em; }
    #{{ $uid }} .rjmd-content a { color: var(--acc); text-decoration: underline; text-decoration-thickness: 1px; text-underline-offset: 2px; transition: opacity .2s; }
    #{{ $uid }} .rjmd-content a:hover { opacity: .75; }

    #{{ $uid }} .rjmd-content ul,
    #{{ $uid }} .rjmd-content ol { margin: 0 0 1.1em; padding-left: 1.5em; }
    #{{ $uid }} .rjmd-content li { margin: 0 0 .35em; }
    #{{ $uid }} .rjmd-content li > ul,
    #{{ $uid }} .rjmd-content li > ol { margin-top: .35em; margin-bottom: 0; }

    #{{ $uid }} .rjmd-content blockquote { margin: 0 0 1.1em; padding: .75em 1.25em; border-left: 4px solid var(--acc); background: var(--code-bg); color: var(--m); border-radius: 0 8px 8px 0; font-style: italic; }
    #{{ $uid }} .rjmd-content blockquote > :last-child { margin-bottom: 0; }

    #{{ $uid }} .rjmd-content hr { border: 0; border-top: 1px solid var(--bd); margin: 2em 0; }

    #{{ $uid }} .rjmd-content img { max-width: 100%; height: auto; border-radius: 8px; margin: .5em 0; }

    /* Code */
    #{{ $uid }} .rjmd-content code { font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace; font-size: .88em; background: var(--code-bg); padding: .15em .4em; border-radius: 4px; color: #d946ef; }
    #{{ $uid }}[data-style="dark"] .rjmd-content code { color: #f472b6; }
    #{{ $uid }} .rjmd-content pre { margin: 0 0 1.1em; padding: 16px 20px; background: var(--code-bg); border: 1px solid var(--bd); border-radius: 10px; overflow-x: auto; font-size: .88rem; line-height: 1.6; }
    #{{ $uid }} .rjmd-content pre code { background: none; padding: 0; color: inherit; font-size: inherit; }

    /* Tables */
    #{{ $uid }} .rjmd-content table { width: 100%; border-collapse: collapse; margin: 0 0 1.1em; font-size: .95rem; border: 1px solid var(--bd); border-radius: 8px; overflow: hidden; }
    #{{ $uid }} .rjmd-content th,
    #{{ $uid }} .rjmd-content td { padding: 10px 14px; text-align: left; border-bottom: 1px solid var(--bd); }
    #{{ $uid }} .rjmd-content th { background: var(--code-bg); font-weight: 700; color: var(--t); }
    #{{ $uid }} .rjmd-content tr:last-child td { border-bottom: 0; }

    /* Task lists */
    #{{ $uid }} .rjmd-content input[type="checkbox"] { margin-right: 6px; accent-color: var(--acc); }
    #{{ $uid }} .rjmd-content li:has(> input[type="checkbox"]) { list-style: none; margin-left: -1.2em; }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 24px 12px; }
        #{{ $uid }} .rjmd-content h1 { font-size: 1.7rem; }
        #{{ $uid }} .rjmd-content h2 { font-size: 1.35rem; }
        #{{ $uid }} .rjmd-content h3 { font-size: 1.15rem; }
        #{{ $uid }}[data-style="bordered"] .rjmd-content { padding: 20px; }
    }
</style>

<section id="{{ $uid }}" data-style="{{ $opts['style'] }}">
    <div class="rjmd-wrap {{ $tocSidebar ? 'rjmd-has-sidebar' : '' }}">

        @if ($hasToc && !$tocSidebar)
            <nav class="rjmd-toc rjmd-toc-top" aria-label="{{ __('Table of Contents') }}">
                <h3>{{ __('Contents') }}</h3>
                <ol>
                    @foreach ($headings as $h)
                        <li class="rjmd-toc-l{{ $h['level'] }}">
                            <a href="#{{ $h['id'] }}">{{ $h['text'] }}</a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        @if ($tocSidebar)
            <aside class="rjmd-sidebar">
                <nav class="rjmd-toc rjmd-toc-side" aria-label="{{ __('Table of Contents') }}">
                    <h3>{{ __('Contents') }}</h3>
                    <ol>
                        @foreach ($headings as $h)
                            <li class="rjmd-toc-l{{ $h['level'] }}">
                                <a href="#{{ $h['id'] }}">{{ $h['text'] }}</a>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </aside>
        @endif

        <div class="rjmd-content">{!! $html !!}</div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/prismjs@1/prism.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1/plugins/autoloader/prism-autoloader.min.js" defer></script>
<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    // External link target
    var target = '{{ $opts['link_target'] }}';
    root.querySelectorAll('.rjmd-content a').forEach(function (a) {
        var href = a.getAttribute('href') || '';
        if (href.indexOf('http') === 0 && a.hostname !== window.location.hostname) {
            a.setAttribute('target', target);
            a.setAttribute('rel', 'noopener noreferrer');
        }
    });

    // Smooth scroll for TOC + active highlight
    var links = [].slice.call(root.querySelectorAll('.rjmd-toc a'));
    links.forEach(function (a) {
        a.addEventListener('click', function (e) {
            var id = a.getAttribute('href');
            if (!id || id.charAt(0) !== '#') { return; }
            var el = root.querySelector(id);
            if (!el) { return; }
            e.preventDefault();
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (history.pushState) { history.pushState(null, '', id); }
        });
    });

    if (links.length && 'IntersectionObserver' in window) {
        var headingMap = {};
        links.forEach(function (a) {
            var id = a.getAttribute('href');
            if (!id) { return; }
            var el = root.querySelector(id);
            if (el) { headingMap[id] = a; }
        });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    links.forEach(function (l) { l.classList.remove('is-active'); });
                    var id = '#' + entry.target.id;
                    if (headingMap[id]) { headingMap[id].classList.add('is-active'); }
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });

        Object.keys(headingMap).forEach(function (id) {
            var el = root.querySelector(id);
            if (el) { io.observe(el); }
        });
    }
})();
</script>