<style>
    #{{ $uid }} { display: flex; justify-content: {{ $o['justify'] }}; width: 100%; margin: 0; padding: 0; --w: {{ $o['width'] }}px; --mh: {{ $o['max_h'] }}px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rjl-link {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 1 auto;
        width: var(--w);
        min-width: min(var(--w), 32px);
        min-height: 40px;
        max-width: 100%;
        margin: 0;
        padding: 0;
        line-height: 0;
        text-decoration: none;
        transition: opacity .2s ease, transform .3s ease;
    }
    #{{ $uid }} .rjl-link:focus-visible { outline: 2px solid currentColor; outline-offset: 4px; border-radius: 4px; }
    @if($o['hover'])
    #{{ $uid }} .rjl-link:hover { opacity: .7; }
    @endif

    #{{ $uid }} .rjl-img {
        display: block;
        width: 100%;
        height: auto;
        max-width: 100%;
        max-height: var(--mh);
        margin: 0;
        object-fit: contain;
        object-position: {{ $o['objpos'] }} center;
    }
    #{{ $uid }}[data-filter="white"] .rjl-img { filter: brightness(0) invert(1); }
    #{{ $uid }}[data-filter="black"] .rjl-img { filter: brightness(0); }

    #{{ $uid }} .rjl-ph {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: 40px;
        padding: 0 8px;
        overflow: hidden;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: .08em;
        text-align: center;
        text-transform: uppercase;
    }
    #{{ $uid }} .rjl-ph[hidden] { display: none !important; }
    #{{ $uid }} .rjl-err { border-color: #fca5a5; background: #fef2f2; color: #dc2626; }
</style>

<div id="{{ $uid }}" class="rjl" data-filter="{{ $o['filter'] }}">
    <a class="rjl-link"
       href="{{ $o['url'] }}"
       aria-label="{{ $o['alt'] }}"
       @if ($o['blank']) target="_blank" rel="noopener noreferrer" @endif>

        @if ($o['src'] !== '')
            <img class="rjl-img"
                 src="{{ $o['src'] }}"
                 alt="{{ $o['alt'] }}"
                 decoding="async"
                 loading="lazy"
                 onerror="this.style.display='none';var p=this.nextElementSibling;if(p){p.removeAttribute('hidden');}">
            <span class="rjl-ph rjl-err" hidden title="{{ $o['src'] }}">{{ __('Image not found') }}</span>
        @else
            <span class="rjl-ph">{{ __('LOGO') }}</span>
        @endif
    </a>
</div>
