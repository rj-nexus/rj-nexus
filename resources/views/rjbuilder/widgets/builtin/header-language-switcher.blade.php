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
    $radius          = $settings['radius'] ?? 'md';
    $showCodeCompact = $settings['show_code_on_compact'] ?? true;

    $radiusMap = ['none' => '0px', 'sm' => '6px', 'md' => '10px', 'lg' => '14px', 'full' => '9999px'];
    $radiusCss = $radiusMap[$radius] ?? '10px';

    $sizeMap = [
        'sm' => ['pad' => '6px 10px', 'fs' => '12px', 'flag' => '16px', 'gap' => '6px', 'icon' => '11px'],
        'md' => ['pad' => '8px 12px', 'fs' => '13px', 'flag' => '18px', 'gap' => '8px', 'icon' => '12px'],
        'lg' => ['pad' => '10px 16px', 'fs' => '14px', 'flag' => '20px', 'gap' => '10px', 'icon' => '14px'],
    ];
    $sz = $sizeMap[$size] ?? $sizeMap['md'];

    $available = function_exists('rj_available_locales') ? rj_available_locales() : ['en'];
    $current   = app()->getLocale();
    if (!in_array($current, $available, true)) {
        $current = $available[0] ?? 'en';
    }

    $flags = [
        'az' => '🇦🇿', 'en' => '🇬🇧', 'de' => '🇩🇪', 'es' => '🇪🇸',
        'fr' => '🇫🇷', 'pt' => '🇵🇹', 'ru' => '🇷🇺', 'tr' => '🇹🇷',
        'it' => '🇮🇹', 'ja' => '🇯🇵', 'zh' => '🇨🇳', 'ar' => '🇸🇦',
        'nl' => '🇳🇱', 'pl' => '🇵🇱', 'sv' => '🇸🇪', 'uk' => '🇺🇦',
    ];

    $getFlag = function (string $code) use ($flags): string {
        if (function_exists('rj_lang_flag_url')) {
            $url = rj_lang_flag_url($code);
            if ($url) {
                return '<img src="' . e($url) . '" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:2px;">';
            }
        }
        return $flags[$code] ?? '🌐';
    };

    $getName = function (string $code) use ($showFullName): string {
        $upper = strtoupper($code);
        if ($showFullName && function_exists('rj_lang_name')) {
            $full = rj_lang_name($code);
            if ($full) return $full;
        }
        return $upper;
    };

    $currentUrl = request()->fullUrl();
    $isCompact = !$showFlag && !$showName && $showCodeCompact;
@endphp

<style>
    #{{ $uid }} {
        --hls-accent: {{ $accent }};
        position: relative;
        display: inline-flex;
        align-items: center;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    #{{ $uid }} .rj-hls-btn {
        display: inline-flex;
        align-items: center;
        gap: {{ $sz['gap'] }};
        padding: {{ $sz['pad'] }};
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 700;
        border: 1.5px solid transparent;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        color: inherit;
        transition: background .2s ease, border-color .2s ease, color .2s ease, transform .15s ease;
        font-family: inherit;
        line-height: 1;
        white-space: nowrap;
    }
    #{{ $uid }} .rj-hls-btn:active { transform: scale(.97); }

    /* ---------- BUTTON STYLES ---------- */
    #{{ $uid }}[data-btn="ghost"] .rj-hls-btn:hover {
        background: rgba(15,23,42,.06);
    }
    #{{ $uid }}[data-btn="outline"] .rj-hls-btn {
        border-color: rgba(15,23,42,.15);
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

    /* ---------- FLAG ---------- */
    #{{ $uid }} .rj-hls-flag {
        width: {{ $sz['flag'] }};
        height: {{ $sz['flag'] }};
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: {{ $sz['flag'] }};
        line-height: 1;
        overflow: hidden;
    }
    #{{ $uid }} .rj-hls-flag img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 2px;
        display: block;
    }

    #{{ $uid }} .rj-hls-code {
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    #{{ $uid }} .rj-hls-caret {
        width: {{ $sz['icon'] }};
        height: {{ $sz['icon'] }};
        flex-shrink: 0;
        opacity: .55;
        transition: transform .25s ease;
    }
    #{{ $uid }} .rj-hls-btn.is-open .rj-hls-caret {
        transform: rotate(180deg);
    }

    /* ---------- DROPDOWN ---------- */
    #{{ $uid }} .rj-hls-menu {
        position: absolute;
        top: calc(100% + 8px);
        min-width: 180px;
        background: #fff;
        border: 1px solid rgba(15,23,42,.08);
        border-radius: 12px;
        box-shadow: 0 20px 40px -16px rgba(15,23,42,.35);
        padding: 6px;
        opacity: 0;
        transform: translateY(-6px) scale(.96);
        pointer-events: none;
        transition: opacity .2s ease, transform .22s cubic-bezier(.34,1.56,.64,1);
        z-index: 9999;
        max-height: 340px;
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
    #{{ $uid }} .rj-hls-menu::-webkit-scrollbar { width: 6px; }
    #{{ $uid }} .rj-hls-menu::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

    #{{ $uid }} .rj-hls-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s ease, color .15s ease;
        border: 0;
        background: transparent;
        width: 100%;
        text-align: left;
        font-family: inherit;
    }
    #{{ $uid }} .rj-hls-item:hover {
        background: #f8fafc;
        color: var(--hls-accent);
    }
    #{{ $uid }} .rj-hls-item.is-active {
        background: color-mix(in srgb, var(--hls-accent) 10%, transparent);
        color: var(--hls-accent);
    }
    #{{ $uid }} .rj-hls-item .rj-hls-check {
        width: 14px;
        height: 14px;
        margin-left: auto;
        color: var(--hls-accent);
        opacity: 0;
    }
    #{{ $uid }} .rj-hls-item.is-active .rj-hls-check {
        opacity: 1;
    }

    /* ---------- INLINE FLAGS / NAMES ---------- */
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
        padding: 4px 8px;
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 700;
        color: inherit;
        text-decoration: none;
        transition: background .2s ease, opacity .2s ease;
        opacity: .55;
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
        font-weight: 700;
        color: inherit;
        text-decoration: none;
        background: transparent;
        border: 1.5px solid rgba(15,23,42,.12);
        transition: background .2s ease, border-color .2s ease, color .2s ease;
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

    @media (max-width: 640px) {
        #{{ $uid }}[data-style="inline-names"] .rj-hls-inline-btn span[data-name] {
            display: none;
        }
        #{{ $uid }}[data-style="pills"] .rj-hls-inline-btn span[data-name] {
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
        <button type="button" class="rj-hls-btn" data-toggle>
            @if($showFlag)
                <span class="rj-hls-flag">{!! $getFlag($current) !!}</span>
            @endif
            @if($showName)
                <span>{{ $getName($current) }}</span>
            @elseif($isCompact)
                <span class="rj-hls-code">{{ strtoupper($current) }}</span>
            @endif
            @if($showArrow)
                <svg class="rj-hls-caret" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            @endif
        </button>

        <div class="rj-hls-menu" data-menu>
            @foreach($available as $loc)
                <a href="{{ route('rj.widget.locale', ['locale' => $loc, 'redirect' => request()->path() === '/' ? '/' : request()->path()]) }}"
                   class="rj-hls-item {{ $loc === $current ? 'is-active' : '' }}"
                   data-locale="{{ $loc }}">
                    @if($showFlag)
                        <span class="rj-hls-flag">{!! $getFlag($loc) !!}</span>
                    @endif
                    <span>{{ $getName($loc) }}</span>
                    <svg class="rj-hls-check" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </a>
            @endforeach
        </div>
    @else
        <div class="rj-hls-inline">
            @foreach($available as $loc)
                <a href="{{ route('rj.widget.locale', ['locale' => $loc, 'redirect' => request()->path() === '/' ? '/' : request()->path()]) }}"
                   class="rj-hls-inline-btn {{ $loc === $current ? 'is-active' : '' }}"
                   data-locale="{{ $loc }}">
                    @if($showFlag)
                        <span class="rj-hls-flag">{!! $getFlag($loc) !!}</span>
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
