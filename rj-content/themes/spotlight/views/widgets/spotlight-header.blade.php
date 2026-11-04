@php
    $menuId = $settings['menu_id'] ?? '';
    $menuTree = rj_menu_tree();
    $menuItems = $menuTree[$menuId]['items'] ?? [];
    $currentLocale = app()->getLocale();
    $locales = rj_frontend_locales();
    $logoImage = $settings['logo_image'] ?? '';
    $logoText = $settings['logo_text'] ?? 'RJ CMS';
    $ctaText = $settings['cta_text'] ?? '';
    $ctaUrl = $settings['cta_url'] ?? '#';
    $showLang = $settings['show_language'] ?? true;
@endphp

<header class="rj-glass-header" id="rj-header">
    <div class="rj-glass-header-inner">

        <a href="{{ url('/' . $currentLocale) }}" class="rj-glass-logo">
            @if($logoImage)
                <img src="{{ $logoImage }}" alt="{{ $logoText }}">
            @else
                <svg class="rj-glass-logo-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>{{ $logoText }}</span>
            @endif
        </a>

        <nav class="rj-glass-nav">
            @foreach($menuItems as $item)
                <div class="rj-glass-nav-item">
                    <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" class="rj-glass-nav-link">
                        {{ $item['label'] }}
                        @if(!empty($item['children']))
                            <svg class="rj-glass-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        @endif
                    </a>
                    @if(!empty($item['children']))
                        <div class="rj-glass-dropdown">
                            @foreach($item['children'] as $child)
                                <a href="{{ $child['url'] }}" target="{{ $child['target'] }}" class="rj-glass-dropdown-link">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <div class="rj-glass-actions">
            @if($showLang && count($locales) > 1)
                <div class="rj-glass-nav-item">
                    <button class="rj-glass-lang-btn">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        {{ strtoupper($currentLocale) }}
                    </button>
                    <div class="rj-glass-dropdown rj-dropdown-right">
                        @foreach($locales as $locale)
                            <a href="{{ route('rj.widget.locale', $locale) }}" class="rj-glass-dropdown-link {{ $locale === $currentLocale ? 'active' : '' }}">
                                {{ rj_lang_name($locale) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($ctaText)
                <a href="{{ $ctaUrl }}" class="rj-glass-cta">{{ $ctaText }}</a>
            @endif

            <button class="rj-glass-mobile-toggle" onclick="document.getElementById('rj-header').classList.toggle('rj-mobile-open')">
                <svg class="rj-icon-menu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg class="rj-icon-close" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

    </div>
</header>

<style>
    .rj-glass-header {
        position: sticky;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: rgba(10, 10, 15, 0.6);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    .rj-glass-header-inner {
        max-width: var(--rj-container);
        margin: 0 auto;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }
    .rj-glass-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        text-decoration: none;
        letter-spacing: -0.02em;
    }
    .rj-glass-logo-icon {
        width: 32px;
        height: 32px;
        color: var(--rj-primary);
    }
    .rj-glass-logo img {
        max-height: 36px;
        width: auto;
    }
    .rj-glass-nav {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .rj-glass-nav-item {
        position: relative;
    }
    .rj-glass-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.2s;
    }
    .rj-glass-nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
    }
    .rj-glass-chevron {
        width: 14px;
        height: 14px;
        opacity: 0.5;
        transition: transform 0.2s;
    }
    .rj-glass-nav-item:hover .rj-glass-chevron {
        transform: rotate(180deg);
    }
    .rj-glass-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 200px;
        padding: 8px;
        background: rgba(20, 20, 28, 0.95);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.3, 1);
    }
    .rj-glass-nav-item:hover .rj-glass-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .rj-dropdown-right {
        left: auto;
        right: 0;
    }
    .rj-glass-dropdown-link {
        display: block;
        padding: 10px 14px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.15s;
    }
    .rj-glass-dropdown-link:hover, .rj-glass-dropdown-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
    }
    .rj-glass-dropdown-link.active {
        color: var(--rj-primary);
        font-weight: 600;
    }
    .rj-glass-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .rj-glass-lang-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .rj-glass-lang-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }
    .rj-glass-cta {
        display: inline-flex;
        align-items: center;
        padding: 10px 22px;
        background: #fff;
        color: #000;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .rj-glass-cta:hover {
        background: var(--rj-primary);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 20px color-mix(in srgb, var(--rj-primary) 40%, transparent);
    }
    .rj-glass-mobile-toggle {
        display: none;
        background: transparent;
        border: none;
        color: #fff;
        cursor: pointer;
        padding: 8px;
    }
    .rj-glass-mobile-toggle svg {
        width: 24px;
        height: 24px;
    }
    .rj-icon-close {
        display: none;
    }

    @media (max-width: 968px) {
        .rj-glass-nav {
            display: none;
        }
        .rj-glass-nav-item {
            width: 100%;
        }
        .rj-glass-nav-link {
            width: 100%;
            justify-content: space-between;
            padding: 12px 16px;
        }
        .rj-glass-dropdown {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            background: transparent;
            border: none;
            padding: 0 0 0 16px;
            display: none;
        }
        .rj-glass-nav-item:hover .rj-glass-dropdown {
            display: block;
        }
        .rj-glass-mobile-toggle {
            display: block;
        }
        .rj-glass-cta {
            display: none;
        }
        .rj-glass-header.rj-mobile-open {
            height: 100vh;
            overflow-y: auto;
            background: rgba(10, 10, 15, 0.98);
        }
        .rj-glass-header.rj-mobile-open .rj-glass-header-inner {
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .rj-glass-header.rj-mobile-open .rj-glass-nav {
            display: flex;
            flex-direction: column;
            width: 100%;
            order: 3;
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }
        .rj-glass-header.rj-mobile-open .rj-glass-actions {
            margin-left: auto;
        }
        .rj-glass-header.rj-mobile-open .rj-icon-menu {
            display: none;
        }
        .rj-glass-header.rj-mobile-open .rj-icon-close {
            display: block;
        }
    }
</style>
