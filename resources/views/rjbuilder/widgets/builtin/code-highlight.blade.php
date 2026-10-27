@php
    $language   = $settings['language'] ?? 'php';
    $filename   = trim($settings['filename'] ?? '');
    $code       = rtrim((string) ($settings['code'] ?? ''), "\n");
    $theme      = $settings['theme'] ?? 'dark';
    $showLines  = $settings['show_lines'] ?? true;
    $showCopy   = $settings['show_copy'] ?? true;
    $showLang   = $settings['show_lang'] ?? true;
    $maxHeight  = (int) ($settings['max_height'] ?? 500);
    $radius     = $settings['radius'] ?? 'lg';
    $paddingY   = (int) ($settings['padding_y'] ?? 32);

    $radiusMap = ['none' => '0px', 'md' => '8px', 'lg' => '12px', 'xl' => '18px'];
    $radiusCss = $radiusMap[$radius] ?? '12px';

    $labelMap = [
        'php' => 'PHP', 'javascript' => 'JS', 'typescript' => 'TS', 'python' => 'PY',
        'html' => 'HTML', 'css' => 'CSS', 'sql' => 'SQL', 'json' => 'JSON',
        'bash' => 'BASH', 'go' => 'GO', 'rust' => 'RS', 'java' => 'JAVA',
        'ruby' => 'RB', 'yaml' => 'YML', 'markdown' => 'MD',
    ];
    $langLabel = $labelMap[$language] ?? strtoupper($language);
@endphp

@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css">
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
@endonce

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-ch-wrap {
        max-width: 900px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        border: 1px solid rgba(148,163,184,.22);
    }
    #{{ $uid }}[data-theme="dark"] .rj-ch-wrap {
        background: #0f172a;
        box-shadow: 0 24px 48px -20px rgba(15,23,42,.5);
    }
    #{{ $uid }}[data-theme="darker"] .rj-ch-wrap {
        background: #060a14;
        box-shadow: 0 24px 48px -20px rgba(0,0,0,.6);
    }
    #{{ $uid }}[data-theme="light"] .rj-ch-wrap {
        background: #f8fafc;
        border-color: #e2e8f0;
        box-shadow: 0 24px 48px -20px rgba(15,23,42,.15);
    }

    #{{ $uid }} .rj-ch-head {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-bottom: 1px solid rgba(148,163,184,.18);
        font-size: 12px;
        font-weight: 600;
    }
    #{{ $uid }}[data-theme="dark"] .rj-ch-head { background: #111c33; color: #94a3b8; }
    #{{ $uid }}[data-theme="darker"] .rj-ch-head { background: #0b1220; color: #94a3b8; }
    #{{ $uid }}[data-theme="light"] .rj-ch-head { background: #eef2f7; color: #475569; }

    #{{ $uid }} .rj-ch-dots {
        display: flex;
        gap: 5px;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-ch-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    #{{ $uid }} .rj-ch-dot:nth-child(1) { background: #ef4444; }
    #{{ $uid }} .rj-ch-dot:nth-child(2) { background: #eab308; }
    #{{ $uid }} .rj-ch-dot:nth-child(3) { background: #22c55e; }

    #{{ $uid }} .rj-ch-fname {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace;
        font-size: 11.5px;
    }
    #{{ $uid }} .rj-ch-lang {
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        flex-shrink: 0;
    }
    #{{ $uid }}[data-theme="dark"] .rj-ch-lang,
    #{{ $uid }}[data-theme="darker"] .rj-ch-lang {
        background: rgba(139,92,246,.18);
        color: #c4b5fd;
    }
    #{{ $uid }}[data-theme="light"] .rj-ch-lang {
        background: rgba(139,92,246,.12);
        color: #7c3aed;
    }

    #{{ $uid }} .rj-ch-copy {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(148,163,184,.25);
        background: transparent;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
        flex-shrink: 0;
    }
    #{{ $uid }}[data-theme="dark"] .rj-ch-copy,
    #{{ $uid }}[data-theme="darker"] .rj-ch-copy {
        color: #cbd5e1;
    }
    #{{ $uid }}[data-theme="light"] .rj-ch-copy { color: #475569; }
    #{{ $uid }} .rj-ch-copy:hover {
        background: rgba(139,92,246,.15);
        border-color: rgba(139,92,246,.4);
        color: #a78bfa;
    }
    #{{ $uid }} .rj-ch-copy.is-done {
        background: rgba(34,197,94,.18);
        border-color: rgba(34,197,94,.5);
        color: #4ade80;
    }
    #{{ $uid }} .rj-ch-copy svg { width: 11px; height: 11px; }

    #{{ $uid }} .rj-ch-body {
        position: relative;
        @if($maxHeight > 0)
        max-height: {{ $maxHeight }}px;
        overflow-y: auto;
        @endif
    }
    #{{ $uid }}[data-theme="dark"] .rj-ch-body { background: #0f172a; }
    #{{ $uid }}[data-theme="darker"] .rj-ch-body { background: #060a14; }
    #{{ $uid }}[data-theme="light"] .rj-ch-body { background: #f8fafc; }

    #{{ $uid }} .rj-ch-body::-webkit-scrollbar { width: 10px; height: 10px; }
    #{{ $uid }}[data-theme="dark"] .rj-ch-body::-webkit-scrollbar-track,
    #{{ $uid }}[data-theme="darker"] .rj-ch-body::-webkit-scrollbar-track { background: #0b1220; }
    #{{ $uid }}[data-theme="dark"] .rj-ch-body::-webkit-scrollbar-thumb,
    #{{ $uid }}[data-theme="darker"] .rj-ch-body::-webkit-scrollbar-thumb { background: #334155; border-radius: 5px; }
    #{{ $uid }}[data-theme="light"] .rj-ch-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 5px; }

    #{{ $uid }} pre[class*="language-"] {
        margin: 0 !important;
        padding: 16px 18px !important;
        border-radius: 0 !important;
        background: transparent !important;
        font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace !important;
        font-size: 13px !important;
        line-height: 1.7 !important;
        tab-size: 4;
        overflow-x: auto;
        text-shadow: none !important;
    }
    #{{ $uid }}[data-theme="dark"] pre[class*="language-"] code,
    #{{ $uid }}[data-theme="darker"] pre[class*="language-"] code {
        color: #e2e8f0;
    }
    #{{ $uid }}[data-theme="light"] pre[class*="language-"] code { color: #1e293b; }
    #{{ $uid }} code[class*="language-"] {
        font-family: inherit !important;
        font-size: inherit !important;
        text-shadow: none !important;
    }

    @if($showLines)
    #{{ $uid }} pre.line-numbers {
        padding-left: 3.6em !important;
    }
    #{{ $uid }} .line-numbers .line-numbers-rows {
        border-right: 1px solid rgba(148,163,184,.18) !important;
        padding: 16px 0;
        left: 0 !important;
        top: 0 !important;
        width: 3em !important;
        border-radius: 0 !important;
    }
    #{{ $uid }}[data-theme="dark"] .line-numbers .line-numbers-rows > span::before,
    #{{ $uid }}[data-theme="darker"] .line-numbers .line-numbers-rows > span::before {
        color: #475569 !important;
    }
    #{{ $uid }}[data-theme="light"] .line-numbers .line-numbers-rows > span::before {
        color: #94a3b8 !important;
    }
    #{{ $uid }} .line-numbers .line-numbers-rows > span::before {
        font-size: 12px !important;
        padding-right: 1em !important;
    }
    @else
    #{{ $uid }} pre.line-numbers { padding-left: 18px !important; }
    #{{ $uid }} .line-numbers .line-numbers-rows { display: none !important; }
    @endif

    /* Token colors */
    #{{ $uid }} .token.comment,
    #{{ $uid }} .token.prolog,
    #{{ $uid }} .token.doctype,
    #{{ $uid }} .token.cdata { color: #64748b; font-style: italic; }
    #{{ $uid }} .token.punctuation { color: #94a3b8; }
    #{{ $uid }} .token.property,
    #{{ $uid }} .token.tag,
    #{{ $uid }} .token.constant,
    #{{ $uid }} .token.symbol,
    #{{ $uid }} .token.deleted { color: #f472b6; }
    #{{ $uid }} .token.boolean,
    #{{ $uid }} .token.number { color: #fbbf24; }
    #{{ $uid }} .token.selector,
    #{{ $uid }} .token.attr-name,
    #{{ $uid }} .token.string,
    #{{ $uid }} .token.char,
    #{{ $uid }} .token.builtin,
    #{{ $uid }} .token.inserted { color: #86efac; }
    #{{ $uid }} .token.operator,
    #{{ $uid }} .token.entity,
    #{{ $uid }} .token.url,
    #{{ $uid }} .language-css .token.string,
    #{{ $uid }} .style .token.string { color: #7dd3fc; }
    #{{ $uid }} .token.atrule,
    #{{ $uid }} .token.attr-value,
    #{{ $uid }} .token.keyword { color: #a78bfa; font-weight: 600; }
    #{{ $uid }} .token.function,
    #{{ $uid }} .token.class-name { color: #fbbf24; }
    #{{ $uid }} .token.regex,
    #{{ $uid }} .token.important,
    #{{ $uid }} .token.variable { color: #fda4af; }
    #{{ $uid }} .token.important,
    #{{ $uid }} .token.bold { font-weight: 700; }
    #{{ $uid }} .token.italic { font-style: italic; }

    #{{ $uid }}[data-theme="light"] .token.comment,
    #{{ $uid }}[data-theme="light"] .token.prolog { color: #94a3b8; }
    #{{ $uid }}[data-theme="light"] .token.punctuation { color: #64748b; }
    #{{ $uid }}[data-theme="light"] .token.property,
    #{{ $uid }}[data-theme="light"] .token.tag,
    #{{ $uid }}[data-theme="light"] .token.constant { color: #db2777; }
    #{{ $uid }}[data-theme="light"] .token.boolean,
    #{{ $uid }}[data-theme="light"] .token.number { color: #b45309; }
    #{{ $uid }}[data-theme="light"] .token.selector,
    #{{ $uid }}[data-theme="light"] .token.attr-name,
    #{{ $uid }}[data-theme="light"] .token.string,
    #{{ $uid }}[data-theme="light"] .token.char,
    #{{ $uid }}[data-theme="light"] .token.builtin,
    #{{ $uid }}[data-theme="light"] .token.inserted { color: #059669; }
    #{{ $uid }}[data-theme="light"] .token.operator,
    #{{ $uid }}[data-theme="light"] .token.url { color: #0284c7; }
    #{{ $uid }}[data-theme="light"] .token.atrule,
    #{{ $uid }}[data-theme="light"] .token.attr-value,
    #{{ $uid }}[data-theme="light"] .token.keyword { color: #7c3aed; }
    #{{ $uid }}[data-theme="light"] .token.function,
    #{{ $uid }}[data-theme="light"] .token.class-name { color: #b45309; }
    #{{ $uid }}[data-theme="light"] .token.regex,
    #{{ $uid }}[data-theme="light"] .token.variable { color: #be185d; }
</style>

<div id="{{ $uid }}" data-theme="{{ $theme }}">
    <div class="rj-ch-wrap">
        <div class="rj-ch-head">
            <div class="rj-ch-dots">
                <span class="rj-ch-dot"></span>
                <span class="rj-ch-dot"></span>
                <span class="rj-ch-dot"></span>
            </div>
            @if($filename !== '')
                <span class="rj-ch-fname">{{ $filename }}</span>
            @else
                <span class="rj-ch-fname" style="opacity:.4;">&nbsp;</span>
            @endif
            @if($showLang)
                <span class="rj-ch-lang">{{ $langLabel }}</span>
            @endif
            @if($showCopy)
                <button type="button" class="rj-ch-copy" data-copy>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    <span data-copy-label>{{ __('Copy') }}</span>
                </button>
            @endif
        </div>
        <div class="rj-ch-body">
            <pre class="line-numbers"><code class="language-{{ $language }}">{{ $code }}</code></pre>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var copyBtn = root.querySelector('[data-copy]');
    var codeEl  = root.querySelector('code');

    function getCodeText() {
        return codeEl ? codeEl.textContent || '' : '';
    }

    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            var text = getCodeText();
            var done = function () {
                var label = copyBtn.querySelector('[data-copy-label]');
                var original = label ? label.textContent : '';
                if (label) label.textContent = @js(__('Copied!'));
                copyBtn.classList.add('is-done');
                setTimeout(function () {
                    if (label) label.textContent = original;
                    copyBtn.classList.remove('is-done');
                }, 1800);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(done).catch(function () {});
            } else {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        });
    }

    function highlight() {
        if (!window.Prism) return false;
        if (window.Prism.plugins && window.Prism.plugins.autoloader) {
            window.Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';
        }
        try {
            window.Prism.highlightAllUnder(root);
            return true;
        } catch (e) {
            return false;
        }
    }

    if (!highlight()) {
        var tries = 0;
        var timer = setInterval(function () {
            tries++;
            if (highlight() || tries > 60) {
                clearInterval(timer);
            }
        }, 100);
    }
})();
</script>
