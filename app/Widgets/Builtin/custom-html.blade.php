@php
    $wrapperClass = $isFullWidth ? 'w-full' : 'max-w-7xl mx-auto px-4';
    $uid = 'html_' . substr(md5(uniqid()), 0, 6);
@endphp

<div id="{{ $uid }}" class="{{ $wrapperClass }} rj-custom-html-block">
    {!! $code !!}
</div>

<script>
    (function() {
        const container = document.getElementById('{{ $uid }}');
        if (!container) return;

        // XSS/Builder issue: Scripts injected via innerHTML (x-html) don't execute automatically.
        // This workaround finds script tags and re-creates them so they run in the canvas.
        const scripts = container.querySelectorAll('script');
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
            newScript.appendChild(document.createTextNode(oldScript.innerHTML));
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    })();
</script>
