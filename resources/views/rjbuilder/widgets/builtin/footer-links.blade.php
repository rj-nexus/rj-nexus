@php
    $title      = $settings['title'] ?? '';
    $layout     = $settings['layout'] ?? 'vertical';
    $align      = $settings['align'] ?? 'left';
    $gap        = $settings['gap'] ?? 'md';
    $titleColor = $settings['title_color'] ?? '#ffffff';
    $linkColor  = $settings['link_color'] ?? '#94a3b8';
    $hoverColor = $settings['hover_color'] ?? '#8b5cf6';
    $links      = $settings['links'] ?? [];
    $reserve    = filter_var($settings['reserve_title'] ?? true, FILTER_VALIDATE_BOOLEAN);

    $gapMap = ['sm' => '8px', 'md' => '14px', 'lg' => '24px'];
    $gapCss = $gapMap[$gap] ?? '14px';

    $alignItems = 'flex-start';
    $textAlign = 'left';
    if ($align === 'center') {
        $alignItems = 'center';
        $textAlign = 'center';
    } elseif ($align === 'right') {
        $alignItems = 'flex-end';
        $textAlign = 'right';
    }

    $flexDirection = $layout === 'horizontal' ? 'row' : 'column';
    $justify = $layout === 'horizontal' ? $alignItems : 'flex-start';
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        min-width: 0;
        max-width: 100%;
        box-sizing: border-box;
    }
    #{{ $uid }} .rj-fl-title {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        overflow: hidden;
        box-sizing: border-box;
        @if($reserve)
        min-height: 2.6em;
        @endif
        margin: 0 0 20px;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
        letter-spacing: -.01em;
        color: {{ $titleColor }};
        text-align: {{ $textAlign }};
        overflow-wrap: anywhere;
        word-break: break-word;
    }
    #{{ $uid }} .rj-fl-list {
        display: flex;
        flex-direction: {{ $flexDirection }};
        flex-wrap: wrap;
        gap: {{ $gapCss }};
        align-items: {{ $alignItems }};
        justify-content: {{ $justify }};
        min-width: 0;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #{{ $uid }} .rj-fl-list li {
        min-width: 0;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }
    #{{ $uid }} .rj-fl-link {
        display: inline-block;
        max-width: 100%;
        font-size: 14px;
        line-height: 1.4;
        color: {{ $linkColor }};
        text-decoration: none;
        overflow-wrap: anywhere;
        word-break: break-word;
        transition: color .2s ease, transform .2s ease;
    }
    #{{ $uid }} .rj-fl-link:hover {
        color: {{ $hoverColor }};
        transform: translateX(2px);
    }
    #{{ $uid }}[data-layout="horizontal"] .rj-fl-link:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-fl-title {
            margin-bottom: 14px;
            font-size: 15px;
        }
        #{{ $uid }} .rj-fl-list {
            gap: calc({{ $gapCss }} * .8);
        }
        #{{ $uid }} .rj-fl-link {
            font-size: 13.5px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-fl-link {
            transition: color .2s ease;
        }
        #{{ $uid }} .rj-fl-link:hover {
            transform: none;
        }
    }
</style>

<div id="{{ $uid }}" data-layout="{{ $layout }}">
    @if($title !== '')
        <h3 class="rj-fl-title" title="{{ $title }}">{{ $title }}</h3>
    @elseif($reserve)
        <h3 class="rj-fl-title" aria-hidden="true"></h3>
    @endif

    @if(!empty($links))
        <ul class="rj-fl-list">
            @foreach($links as $link)
                @if(!empty($link['label']))
                    <li>
                        <a href="{{ $link['url'] ?? '#' }}" class="rj-fl-link">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>
