@php
    $wrapperClass = $isFullWidth ? 'w-full' : 'max-w-7xl mx-auto px-4';
    $uid = 'html_' . substr(md5(uniqid('', true)), 0, 8);
@endphp

@if ($mode === 'none')
    <div id="{{ $uid }}" class="{{ $wrapperClass }} rj-custom-html-block">{!! $code !!}</div>

    <script>
    (function () {
        var c = document.getElementById('{{ $uid }}');
        if (!c) return;
        c.querySelectorAll('script').forEach(function (old) {
            var s = document.createElement('script');
            Array.from(old.attributes).forEach(function (a) { s.setAttribute(a.name, a.value); });
            s.appendChild(document.createTextNode(old.innerHTML));
            old.parentNode.replaceChild(s, old);
        });
    })();
    </script>
@else
    <div id="{{ $uid }}" class="{{ $wrapperClass }} rj-custom-html-block"
         data-mode="{{ $mode }}" data-site-css="{{ $siteCss ? '1' : '0' }}">
        <template>{!! $code !!}</template>
    </div>

    <script>
    (function () {
        var host = document.getElementById('{{ $uid }}');
        if (!host || host.dataset.ready) return;
        host.dataset.ready = '1';

        var tpl = host.querySelector('template');
        if (!tpl) return;
        var mode = host.dataset.mode;
        var withSite = host.dataset.siteCss === '1';

        /* ---------- SHADOW DOM ---------- */
        if (mode === 'shadow') {
            var root = host.attachShadow({ mode: 'open' });
            var base = document.createElement('style');
            base.textContent = ':host{display:block}';
            root.appendChild(base);

            if (withSite) {
                document.querySelectorAll('link[rel="stylesheet"], style').forEach(function (n) {
                    if (!host.contains(n)) root.appendChild(n.cloneNode(true));
                });
            }

            var frag = tpl.content.cloneNode(true);
            frag.querySelectorAll('script').forEach(function (old) {
                var s = document.createElement('script');
                Array.from(old.attributes).forEach(function (a) { s.setAttribute(a.name, a.value); });
                s.textContent = old.textContent;
                old.replaceWith(s);
            });
            root.appendChild(frag);
            return;
        }

        /* ---------- IFRAME ---------- */
        var code = tpl.innerHTML;
        var head = '<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">'
                 + '<style>html,body{margin:0;padding:0}body{display:flow-root}</style>';

        if (withSite) {
            document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
                head += '<link rel="stylesheet" href="' + l.href + '">';
            });
            document.querySelectorAll('style').forEach(function (st) {
                if (!host.contains(st)) head += st.outerHTML;
            });
        }

        var f = document.createElement('iframe');
        f.style.cssText = 'display:block;width:100%;border:0;overflow:hidden;';
        f.setAttribute('scrolling', 'no');
        f.setAttribute('title', 'Custom content');
        f.srcdoc = '<!doctype html><html><head>' + head + '</head><body>' + code + '</body></html>';

        f.addEventListener('load', function () {
            var d = f.contentDocument;
            if (!d || !d.body) return;
            function fit() { f.style.height = Math.ceil(d.body.getBoundingClientRect().height) + 'px'; }
            fit();
            if ('ResizeObserver' in window) new ResizeObserver(fit).observe(d.body);
            window.addEventListener('resize', fit);
        });

        host.appendChild(f);
    })();
    </script>
@endif
