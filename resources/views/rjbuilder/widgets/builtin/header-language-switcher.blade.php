@php
    $styleType       = $settings['style'] ?? 'dropdown';
    $showFlag        = $settings['show_flag'] ?? true;
    $showName        = $settings['show_name'] ?? true;
    $showFullName    = $settings['show_full_name'] ?? false;
    $showArrow       = $settings['show_arrow'] ?? true;
    $dropdownAlign   = $settings['dropdown_align'] ?? 'auto';
    $size            = $settings['size'] ?? 'md';
    $btnStyle        = $settings['btn_style'] ?? 'ghost';
    $accent          = $settings['accent'] ?? '#8b5cf6';
    $radius          = $settings['radius'] ?? 'full';
    $showCodeCompact = $settings['show_code_on_compact'] ?? true;

    $radiusMap = ['none' => '0px', 'sm' => '6px', 'md' => '8px', 'lg' => '12px', 'full' => '9999px'];
    $radiusCss = $radiusMap[$radius] ?? '9999px';

    $sizeMap = [
        'sm' => ['pad' => '4px 10px', 'fs' => '12px', 'flag' => '18px', 'gap' => '6px', 'icon' => '12px', 'mflag' => '26px'],
        'md' => ['pad' => '5px 12px', 'fs' => '13px', 'flag' => '22px', 'gap' => '8px', 'icon' => '14px', 'mflag' => '30px'],
        'lg' => ['pad' => '7px 14px', 'fs' => '14px', 'flag' => '26px', 'gap' => '9px', 'icon' => '16px', 'mflag' => '34px'],
    ];
    $sz = $sizeMap[$size] ?? $sizeMap['md'];

    $available = function_exists('rj_frontend_locales') ? rj_frontend_locales() : ['en'];
    $current   = app()->getLocale();
    $isCompact = !$showFlag && !$showName && $showCodeCompact;

    $getFlag = function (string $code): string {
        if (function_exists('rj_lang_flag_url')) {
            $url = rj_lang_flag_url($code);
            if ($url) {
                return '<img src="' . e($url) . '" alt="">';
            }
        }
        $label = $code === 'en' ? 'GB' : strtoupper(mb_substr($code, 0, 2));
        return '<b>' . e($label) . '</b>';
    };

    $flagAttrs = function (string $code): string {
        $hasImg = function_exists('rj_lang_flag_url') && rj_lang_flag_url($code);
        if ($hasImg) {
            return 'class="rj-hls-flag"';
        }
        $h  = crc32($code) % 360;
        $h2 = ($h + 50) % 360;
        return 'class="rj-hls-flag is-badge" style="background:linear-gradient(135deg,hsl(' . $h . ' 75% 62%),hsl(' . $h2 . ' 72% 48%));"';
    };

    $getShort = function (string $code): string {
        return strtoupper($code);
    };

    $getFull = function (string $code): string {
        if (function_exists('rj_lang_name')) {
            $full = rj_lang_name($code);
            if ($full) return $full;
        }
        return strtoupper($code);
    };

    $getName = function (string $code) use ($showFullName, $getShort, $getFull): string {
        return $showFullName ? $getFull($code) : $getShort($code);
    };
@endphp

@if (count($available) > 1)
<style>
    #{{ $uid }} {
        --hls-accent: {{ $accent }};
        position: relative;
        display: inline-flex;
        align-items: center;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    #{{ $uid }} .rj-hls-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: {{ $sz['gap'] }};
        padding: {{ $sz['pad'] }};
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        color: inherit;
        transition: background .18s ease, border-color .18s ease, color .18s ease, opacity .18s ease, transform .15s ease;
        font-family: inherit;
        line-height: 1;
        white-space: nowrap;
        -webkit-tap-highlight-color: transparent;
    }

    #{{ $uid }}[data-btn="ghost"] .rj-hls-btn:hover {
        background: rgba(15,23,42,.06);
    }
    #{{ $uid }}[data-btn="outline"] .rj-hls-btn {
        border-color: rgba(15,23,42,.14);
    }
    #{{ $uid }}[data-btn="outline"] .rj-hls-btn:hover {
        border-color: var(--hls-accent);
        color: var(--hls-accent);
    }
    #{{ $uid }}[data-btn="soft"] .rj-hls-btn {
        background: color-mix(in srgb, var(--hls-accent) 10%, transparent);
        color: var(--hls-accent);
    }
    #{{ $uid }}[data-btn="soft"] .rj-hls-btn:hover {
        background: color-mix(in srgb, var(--hls-accent) 16%, transparent);
    }
    #{{ $uid }}[data-btn="solid"] .rj-hls-btn {
        background: var(--hls-accent);
        color: #fff;
    }
    #{{ $uid }}[data-btn="solid"] .rj-hls-btn:hover {
        opacity: .9;
    }

    #{{ $uid }} .rj-hls-flag {
        width: {{ $sz['flag'] }};
        height: {{ $sz['flag'] }};
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        line-height: 1;
        background: #f1f5f9;
        box-shadow: 0 0 0 1px rgba(15,23,42,.08);
    }
    #{{ $uid }} .rj-hls-flag img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-hls-flag.is-badge b {
        color: #fff;
        font-size: calc({{ $sz['flag'] }} * 0.4);
        font-weight: 800;
        letter-spacing: .02em;
        line-height: 1;
        text-shadow: 0 1px 2px rgba(0,0,0,.18);
    }

    #{{ $uid }} .rj-hls-code {
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    #{{ $uid }} .rj-hls-caret {
        width: {{ $sz['icon'] }};
        height: {{ $sz['icon'] }};
        flex-shrink: 0;
        opacity: .5;
        transition: transform .2s ease;
    }
    #{{ $uid }} .rj-hls-btn.is-open .rj-hls-caret {
        transform: rotate(180deg);
    }

    #{{ $uid }} .rj-hls-chip {
        display: none;
    }

    #{{ $uid }} .rj-hls-menu {
        position: absolute;
        top: calc(100% + 6px);
        min-width: 140px;
        width: max-content;
        max-width: calc(100vw - 24px);
        background: #fff;
        border: 1px solid rgba(15,23,42,.08);
        border-radius: 12px;
        box-shadow: 0 12px 28px -12px rgba(15,23,42,.28);
        padding: 4px;
        opacity: 0;
        transform: translateY(-4px);
        pointer-events: none;
        transition: opacity .16s ease, transform .16s ease;
        z-index: 9999;
        max-height: 320px;
        overflow-y: auto;
    }
    #{{ $uid }}[data-align="right"] .rj-hls-menu { right: 0; left: auto; }
    #{{ $uid }}[data-align="left"] .rj-hls-menu { left: 0; right: auto; }
    #{{ $uid }}[data-align="auto"] .rj-hls-menu { right: 0; left: auto; }
    html[dir="rtl"] #{{ $uid }}[data-align="auto"] .rj-hls-menu { right: auto; left: 0; }

    #{{ $uid }} .rj-hls-menu.is-open {
        opacity: 1;
        transform: none;
        pointer-events: auto;
    }
    #{{ $uid }} .rj-hls-menu::-webkit-scrollbar { width: 5px; }
    #{{ $uid }} .rj-hls-menu::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

    #{{ $uid }} .rj-hls-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 7px 10px;
        border-radius: 8px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: background .12s ease, color .12s ease;
        width: 100%;
        font-family: inherit;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-hls-item:hover {
        background: #f8fafc;
        color: var(--hls-accent);
    }
    #{{ $uid }} .rj-hls-item.is-active {
        color: var(--hls-accent);
        font-weight: 700;
    }
    #{{ $uid }} .rj-hls-item .rj-hls-dot {
        width: 5px;
        height: 5px;
        margin-left: auto;
        border-radius: 50%;
        background: var(--hls-accent);
        opacity: 0;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-hls-item.is-active .rj-hls-dot {
        opacity: 1;
    }
    #{{ $uid }} .rj-hls-item .rj-hls-full { display: none; }

    #{{ $uid }}[data-style="inline-flags"] .rj-hls-inline,
    #{{ $uid }}[data-style="inline-names"] .rj-hls-inline,
    #{{ $uid }}[data-style="pills"] .rj-hls-inline {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    #{{ $uid }}[data-style="inline-flags"] .rj-hls-inline-btn,
    #{{ $uid }}[data-style="inline-names"] .rj-hls-inline-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 6px;
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 600;
        color: inherit;
        text-decoration: none;
        transition: background .18s ease, opacity .18s ease;
        opacity: .5;
        line-height: 1;
    }
    #{{ $uid }}[data-style="inline-flags"] .rj-hls-inline-btn:hover,
    #{{ $uid }}[data-style="inline-names"] .rj-hls-inline-btn:hover {
        opacity: 1;
        background: rgba(15,23,42,.05);
    }
    #{{ $uid }}[data-style="inline-flags"] .rj-hls-inline-btn.is-active,
    #{{ $uid }}[data-style="inline-names"] .rj-hls-inline-btn.is-active {
        opacity: 1;
        background: color-mix(in srgb, var(--hls-accent) 10%, transparent);
        color: var(--hls-accent);
    }

    #{{ $uid }}[data-style="pills"] .rj-hls-inline-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: {{ $sz['pad'] }};
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 600;
        color: inherit;
        text-decoration: none;
        background: transparent;
        border: 1px solid rgba(15,23,42,.12);
        transition: background .18s ease, border-color .18s ease, color .18s ease;
        line-height: 1;
    }
    #{{ $uid }}[data-style="pills"] .rj-hls-inline-btn:hover {
        border-color: var(--hls-accent);
        color: var(--hls-accent);
    }
    #{{ $uid }}[data-style="pills"] .rj-hls-inline-btn.is-active {
        background: var(--hls-accent);
        border-color: var(--hls-accent);
        color: #fff;
    }

    @keyframes rjHlsIn{{ $uid }} {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: none; }
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-hls-btn.has-flag {
            padding: 0;
            gap: 0;
            border-radius: 50%;
            background: transparent;
            border-color: transparent;
        }
        #{{ $uid }} .rj-hls-btn.has-flag:active {
            transform: scale(.92);
        }
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-label,
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-caret {
            display: none;
        }
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-flag {
            width: {{ $sz['mflag'] }};
            height: {{ $sz['mflag'] }};
            box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px color-mix(in srgb, var(--hls-accent) 45%, transparent), 0 4px 10px -2px rgba(15,23,42,.2);
            transition: box-shadow .2s ease;
        }
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-flag.is-badge b {
            font-size: calc({{ $sz['mflag'] }} * 0.36);
        }
        #{{ $uid }} .rj-hls-btn.has-flag.is-open .rj-hls-flag {
            box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px var(--hls-accent), 0 4px 10px -2px rgba(15,23,42,.2);
        }
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-chip {
            position: absolute;
            right: -3px;
            bottom: -3px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--hls-accent);
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            color: #fff;
            transition: transform .25s ease;
        }
        #{{ $uid }} .rj-hls-btn.has-flag .rj-hls-chip svg {
            width: 7px;
            height: 7px;
            display: block;
        }
        #{{ $uid }} .rj-hls-btn.has-flag.is-open .rj-hls-chip {
            transform: rotate(180deg);
        }
        #{{ $uid }} .rj-hls-btn:not(.has-flag) {
            padding: 4px 8px;
        }

        #{{ $uid }} .rj-hls-menu {
            top: calc(100% + 12px);
            min-width: 172px;
            padding: 5px;
            border-radius: 16px;
            background: rgba(255,255,255,.9);
            -webkit-backdrop-filter: blur(14px) saturate(1.4);
            backdrop-filter: blur(14px) saturate(1.4);
            border: 1px solid rgba(255,255,255,.7);
            box-shadow: 0 18px 40px -14px rgba(15,23,42,.35), 0 0 0 1px rgba(15,23,42,.05);
            overflow: visible;
            max-height: none;
        }
        #{{ $uid }}[data-align="right"] .rj-hls-menu,
        #{{ $uid }}[data-align="auto"] .rj-hls-menu {
            right: -4px;
            left: auto;
        }
        #{{ $uid }}[data-align="left"] .rj-hls-menu {
            left: -4px;
            right: auto;
        }
        #{{ $uid }} .rj-hls-menu::before {
            content: "";
            position: absolute;
            top: -5px;
            width: 10px;
            height: 10px;
            background: rgba(255,255,255,.95);
            transform: rotate(45deg);
            border-radius: 2px 0 0 0;
            border-left: 1px solid rgba(15,23,42,.06);
            border-top: 1px solid rgba(15,23,42,.06);
        }
        #{{ $uid }}[data-align="right"] .rj-hls-menu::before,
        #{{ $uid }}[data-align="auto"] .rj-hls-menu::before {
            right: 16px;
        }
        #{{ $uid }}[data-align="left"] .rj-hls-menu::before {
            left: 16px;
        }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item {
            animation: rjHlsIn{{ $uid }} .26s ease both;
        }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item:nth-child(2) { animation-delay: .04s; }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item:nth-child(3) { animation-delay: .08s; }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item:nth-child(4) { animation-delay: .12s; }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item:nth-child(5) { animation-delay: .16s; }
        #{{ $uid }} .rj-hls-menu.is-open .rj-hls-item:nth-child(n+6) { animation-delay: .2s; }

        #{{ $uid }} .rj-hls-item {
            justify-content: space-between;
            gap: 18px;
            padding: 11px 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 11px;
        }
        #{{ $uid }} .rj-hls-item .rj-hls-flag,
        #{{ $uid }} .rj-hls-item .rj-hls-dot {
            display: none;
        }
        #{{ $uid }} .rj-hls-item .rj-hls-full {
            display: inline;
            order: 1;
            flex: 1;
        }
        #{{ $uid }} .rj-hls-item .rj-hls-short {
            order: 2;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            opacity: .45;
        }
        #{{ $uid }} .rj-hls-item.is-active {
            background: color-mix(in srgb, var(--hls-accent) 12%, transparent);
        }
        #{{ $uid }} .rj-hls-item.is-active .rj-hls-short {
            opacity: .8;
        }

        #{{ $uid }} .rj-hls-inline.has-flag .rj-hls-inline-btn {
            padding: 3px;
            gap: 0;
        }
        #{{ $uid }} .rj-hls-inline.has-flag span[data-name] {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}"
     data-style="{{ $styleType }}"
     data-btn="{{ $btnStyle }}"
     data-align="{{ $dropdownAlign }}">

    @if($styleType === 'dropdown')
        <button type="button" class="rj-hls-btn {{ $showFlag ? 'has-flag' : '' }}" data-toggle aria-haspopup="true" aria-label="{{ $getFull($current) }}">
            @if($showFlag)
                <span {!! $flagAttrs($current) !!}>{!! $getFlag($current) !!}</span>
            @endif
            @if($showName)
                <span class="rj-hls-label">{{ $getName($current) }}</span>
            @elseif($isCompact)
                <span class="rj-hls-code">{{ strtoupper($current) }}</span>
            @endif
            @if($showArrow)
                <svg class="rj-hls-caret" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
                <span class="rj-hls-chip">
                    <svg fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            @endif
        </button>

        <div class="rj-hls-menu" data-menu>
            @foreach($available as $loc)
                <a href="{{ route('rj.widget.locale', ['locale' => $loc, 'redirect' => request()->path() === '/' ? '/' : request()->path()]) }}"
                   class="rj-hls-item {{ $loc === $current ? 'is-active' : '' }}"
                   data-locale="{{ $loc }}">
                    @if($showFlag)
                        <span {!! $flagAttrs($loc) !!}>{!! $getFlag($loc) !!}</span>
                    @endif
                    <span class="rj-hls-short">{{ $getName($loc) }}</span>
                    <span class="rj-hls-full">{{ $getFull($loc) }}</span>
                    <span class="rj-hls-dot"></span>
                </a>
            @endforeach
        </div>
    @else
        <div class="rj-hls-inline {{ $showFlag ? 'has-flag' : '' }}">
            @foreach($available as $loc)
                <a href="{{ route('rj.widget.locale', ['locale' => $loc, 'redirect' => request()->path() === '/' ? '/' : request()->path()]) }}"
                   class="rj-hls-inline-btn {{ $loc === $current ? 'is-active' : '' }}"
                   data-locale="{{ $loc }}"
                   aria-label="{{ $getFull($loc) }}">
                    @if($showFlag)
                        <span {!! $flagAttrs($loc) !!}>{!! $getFlag($loc) !!}</span>
                    @endif
                    @if($showName)
                        <span data-name>{{ $getName($loc) }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var toggleBtn = root.querySelector('[data-toggle]');
    var menu      = root.querySelector('[data-menu]');
    if (!toggleBtn || !menu) return;

    function openMenu() {
        menu.classList.add('is-open');
        toggleBtn.classList.add('is-open');
    }
    function closeMenu() {
        menu.classList.remove('is-open');
        toggleBtn.classList.remove('is-open');
    }
    function toggleMenu() {
        if (menu.classList.contains('is-open')) closeMenu();
        else openMenu();
    }

    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu();
    });

    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) closeMenu();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });

    menu.addEventListener('click', function (e) {
        if (e.target.closest('[data-locale]')) closeMenu();
    });
})();
</script>
@endif
