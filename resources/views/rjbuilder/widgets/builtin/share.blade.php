<style>
    #{{ $uid }} { --acc: {{ $o['accent'] }}; --s: {{ $o['size'] }}px; --tx: #0f172a; --bg: rgba(255,255,255,.22); --box: rgba(255,255,255,.2); --bd: rgba(255,255,255,.45); width: 100%; padding: 16px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}[data-style="glass-dark"] { --tx: #fff; --bg: rgba(15,23,42,.35); --box: rgba(15,23,42,.35); --bd: rgba(255,255,255,.16); }
    #{{ $uid }}[data-style="outline"] { --tx: var(--acc); --bg: transparent; --box: transparent; --bd: color-mix(in srgb, var(--acc) 45%, transparent); }

    #{{ $uid }} .rjsh-stage { display: flex; justify-content: {{ $o['justify'] }}; }
    #{{ $uid }} .rjsh-stage.has-bd { padding: 28px 20px; border-radius: 24px; background: linear-gradient(135deg, color-mix(in srgb, var(--acc) 75%, #fff) 0%, color-mix(in srgb, var(--acc) 45%, #ec4899) 55%, color-mix(in srgb, var(--acc) 50%, #22d3ee) 100%); }

    #{{ $uid }} .rjsh-box { display: inline-flex; flex-direction: column; gap: 12px; padding: 14px 16px; border-radius: 22px; max-width: 100%; color: var(--tx); background: var(--box); border: 1px solid var(--bd); }
    #{{ $uid }}[data-style="glass"] .rjsh-box,
    #{{ $uid }}[data-style="glass-dark"] .rjsh-box { -webkit-backdrop-filter: blur(18px) saturate(170%); backdrop-filter: blur(18px) saturate(170%); box-shadow: 0 8px 32px rgba(15,23,42,.18), inset 0 1px 0 rgba(255,255,255,.35); }

    #{{ $uid }} .rjsh-title { margin: 0; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; opacity: .85; text-align: center; }
    #{{ $uid }} .rjsh-list { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; flex-direction: {{ $o['layout'] }}; {{ $o['layout'] === 'column' ? 'align-items: stretch;' : '' }} }

    #{{ $uid }} .rjsh-btn { all: unset; box-sizing: border-box; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: var(--s); min-width: var(--s); {{ $o['labels'] ? 'padding: 0 18px;' : '' }} border-radius: {{ ['circle' => '50%', 'rounded' => '14px', 'pill' => '999px'][$o['shape']] }}; color: var(--tx); background: var(--bg); border: 1px solid var(--bd); font-size: .85rem; font-weight: 600; line-height: 1; text-decoration: none; transition: transform .2s, background .2s, color .2s, border-color .2s, box-shadow .2s; }
    #{{ $uid }} .rjsh-btn svg { width: calc(var(--s) * .45); height: calc(var(--s) * .45); flex: none; }
    #{{ $uid }} .rjsh-btn:hover { transform: translateY(-3px); background: var(--c); border-color: var(--c); color: #fff; box-shadow: 0 8px 20px -6px var(--c); }
    #{{ $uid }} .rjsh-btn:focus-visible { outline: 2px solid var(--acc); outline-offset: 2px; }
    #{{ $uid }} .rjsh-btn.is-done { background: #22c55e; border-color: #22c55e; color: #fff; }
    #{{ $uid }} .rjsh-btn[hidden] { display: none; }
    #{{ $uid }} .rjsh-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .rjsh-stage.has-bd { padding: 20px 12px; }
    }
</style>

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-url="{{ e($o['url']) }}" data-text="{{ e($o['text']) }}">
    <div class="rjsh-stage {{ $o['backdrop'] && $o['style'] !== 'outline' ? 'has-bd' : '' }}">
        <div class="rjsh-box">

            @if ($o['show_title'] && $o['title'] !== '')
                <h4 class="rjsh-title">{{ $o['title'] }}</h4>
            @endif

            <div class="rjsh-list">
                @foreach ($networks as $n)
                    @if ($n['key'] === 'copy' || $n['key'] === 'native')
                        <button type="button" class="rjsh-btn" data-act="{{ $n['key'] }}" style="--c: {{ $n['color'] }}" title="{{ $n['label'] }}" aria-label="{{ $n['label'] }}" {{ $n['key'] === 'native' ? 'hidden' : '' }}>
                            {!! $n['svg'] !!}
                            @if ($o['labels'])<span data-label>{{ $n['label'] }}</span>@endif
                        </button>
                    @else
                        <a class="rjsh-btn" data-net="{{ $n['key'] }}" data-tpl="{{ $n['tpl'] }}" href="{{ $n['href'] }}" target="_blank" rel="noopener noreferrer" style="--c: {{ $n['color'] }}" title="{{ $n['label'] }}" aria-label="{{ $n['label'] }}">
                            {!! $n['svg'] !!}
                            @if ($o['labels'])<span>{{ $n['label'] }}</span>@endif
                        </a>
                    @endif
                @endforeach
            </div>

            <span class="rjsh-sr" role="status" aria-live="polite" data-act="live"></span>
        </div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var COPIED = @json(__('Copied!'));

    // Avto rejim: link boşdursa cari səhifə, mətn boşdursa səhifə başlığı
    function shareUrl() { return root.dataset.url || window.location.href.split('#')[0]; }
    function shareText() { return root.dataset.text || document.title || ''; }

    function build(tpl) {
        return tpl
            .replace('{url}', encodeURIComponent(shareUrl()))
            .replace('{text}', encodeURIComponent(shareText()));
    }

    // Linkləri cari səhifəyə görə yenilə
    root.querySelectorAll('a[data-net]').forEach(function (a) {
        a.href = build(a.dataset.tpl);

        // Sosial şəbəkələr kiçik pəncərədə açılsın (email istisna)
        if (a.dataset.net !== 'email') {
            a.addEventListener('click', function (e) {
                var w = window.open(a.href, 'rjshare', 'noopener,noreferrer,width=640,height=560');
                if (w) { e.preventDefault(); }
            });
        }
    });

    var live = root.querySelector('[data-act="live"]');

    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        ta.style.cssText = 'position:fixed;top:-1000px;opacity:0;';
        document.body.appendChild(ta);
        ta.select();
        var ok = false;
        try { ok = document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
        return ok;
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text).then(function () { return true; }, function () { return fallbackCopy(text); });
        }
        return Promise.resolve(fallbackCopy(text));
    }

    // Link kopyala
    var copyBtn = root.querySelector('[data-act="copy"]');
    if (copyBtn) {
        var origHtml = copyBtn.innerHTML;
        var timer;
        copyBtn.addEventListener('click', function () {
            copyText(shareUrl()).then(function (ok) {
                if (!ok) { return; }
                clearTimeout(timer);
                copyBtn.classList.add('is-done');
                copyBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>' +
                    (copyBtn.querySelector('[data-label]') ? '<span>' + COPIED + '</span>' : '');
                if (live) { live.textContent = COPIED; }
                timer = setTimeout(function () {
                    copyBtn.classList.remove('is-done');
                    copyBtn.innerHTML = origHtml;
                    if (live) { live.textContent = ''; }
                }, 1800);
            });
        });
    }

    // Native paylaşım (yalnız dəstəkləyən cihazlarda görünür)
    var nativeBtn = root.querySelector('[data-act="native"]');
    if (nativeBtn) {
        if (navigator.share) {
            nativeBtn.hidden = false;
            nativeBtn.addEventListener('click', function () {
                navigator.share({ title: document.title, text: shareText(), url: shareUrl() }).catch(function () {});
            });
        }
    }
})();
</script>