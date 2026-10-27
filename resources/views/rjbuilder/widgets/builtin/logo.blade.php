<style>
    #{{ $uid }} {
        display: flex;
        justify-content: {{ $o['justify'] }};
        width: 100%;
        margin: 0;
        padding: 0;
    }
    #{{ $uid }} .rjl-link {
        display: inline-block;
        text-decoration: none;
        transition: opacity .2s ease;
        line-height: 0;
    }
    #{{ $uid }} .rjl-link:focus-visible {
        outline: 2px solid currentColor;
        outline-offset: 4px;
        border-radius: 4px;
    }
    @if($o['hover'])
    #{{ $uid }} .rjl-link:hover {
        opacity: .7;
    }
    @endif
    #{{ $uid }} .rjl-ph {
        display: flex;
        align-items: center;
        justify-content: center;
        width: {{ $o['width'] }}px;
        max-width: 100%;
        height: 40px;
        padding: 0 8px;
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
    #{{ $uid }} .rjl-ph[hidden] {
        display: none;
    }
    #{{ $uid }} .rjl-err {
        border-color: #fca5a5;
        background: #fef2f2;
        color: #dc2626;
    }
</style>

<div id="{{ $uid }}" class="rjl">
    <a class="rjl-link"
       href="{{ $o['url'] }}"
       aria-label="{{ $o['alt'] }}"
       @if ($o['blank']) target="_blank" rel="noopener noreferrer" @endif>

        @if ($o['src'] !== '')
            <img src="{{ $o['src'] }}"
                 alt="{{ $o['alt'] }}"
                 decoding="async"
                 style="display: block; width: {{ $o['width'] }}px !important; max-width: 100%; height: auto; max-height: {{ $o['max_h'] }}px; object-fit: contain; object-position: {{ $o['objpos'] }} center; filter: none !important;"
                 onerror="this.hidden=true;var p=this.nextElementSibling;if(p){p.hidden=false;}">
            <span class="rjl-ph rjl-err" hidden title="{{ $o['src'] }}">{{ __('Image not found') }}</span>
        @else
            <span class="rjl-ph">{{ __('LOGO') }}</span>
        @endif
    </a>
</div>
