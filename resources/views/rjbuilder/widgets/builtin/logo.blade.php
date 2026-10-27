<style>
    #{{ $uid }} { display: flex; justify-content: {{ $o['justify'] }}; width: 100%; margin: 0; padding: 0; --w: {{ $o['width'] }}px; --mh: {{ $o['max_h'] }}px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }

    /* The link owns the width, the image fills it: no percentage-width collapse inside shrink-wrapped containers */
    #{{ $uid }} .rjl-link { display: block; flex: 0 1 auto; width: var(--w); min-width: min(var(--w), 32px); max-width: 100%; margin: 0; padding: 0; line-height: 0; text-decoration: none; transition: opacity .2s ease, transform .3s ease; }
    #{{ $uid }} .rjl-link:focus-visible { outline: 2px solid currentColor; outline-offset: 4px; border-radius: 4px; }
    @if($o['hover'])
    #{{ $uid }} .rjl-link:hover { opacity: .7; }
    @endif

    #{{ $uid }} .rjl-img { display: block; width: 100%; height: auto; max-width: none; max-height: var(--mh); margin: 0; object-fit: contain; object-position: {{ $o['objpos'] }} center; }
    #{{ $uid }}[data-filter="white"] .rjl-img { filter: brightness(0) invert(1); }
    #{{ $uid }}[data-filter="black"] .rjl-img { filter: brightness(0); }

    #{{ $uid }} .rjl-ph { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; width: 100%; min-height: 40px; padding: 8px; overflow: hidden; border: 1px dashed #cbd5e1; border-radius: 6px; background: #f1f5f9; color: #94a3b8; font-size: 10px; font-weight: 700; line-height: 1.3; letter-spacing: .08em; text-align: center; text-transform: uppercase; }
    #{{ $uid }} .rjl-err { border-color: #fca5a5; background: #fef2f2; color: #dc2626; }
    #{{ $uid }} .rjl-err small { display: block; max-width: 100%; overflow: hidden; font-size: 9px; font-weight: 500; letter-spacing: 0; text-overflow: ellipsis; text-transform: none; white-space: nowrap; opacity: .85; }
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
                 data-placeholder-applied="1"
                 onerror="this.hidden=true;var p=this.nextElementSibling;if(p){p.hidden=false;}">
            <span class="rjl-ph rjl-err" hidden title="{{ $o['src'] }}">
                <span>{{ __('Image not found') }}</span>
                <small>{{ $o['src'] }}</small>
            </span>
        @else
            <span class="rjl-ph">{{ __('LOGO') }}</span>
        @endif
    </a>
</div>
