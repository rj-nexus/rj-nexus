@php
    $title      = $settings['title'] ?? '';
    $layout     = $settings['layout'] ?? 'vertical';
    $align      = $settings['align'] ?? 'left';
    $gap        = $settings['gap'] ?? 'md';
    $titleColor = $settings['title_color'] ?? '#ffffff';
    $linkColor  = $settings['link_color'] ?? '#94a3b8';
    $hoverColor = $settings['hover_color'] ?? '#8b5cf6';
    $links      = $settings['links'] ?? [];

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
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
    }
    #{{ $uid }} .rj-fl-title {
        font-size: 16px;
        font-weight: 700;
        color: {{ $titleColor }};
        margin: 0 0 20px;
        letter-spacing: -.01em;
        text-align: {{ $textAlign }};
    }
    #{{ $uid }} .rj-fl-list {
        display: flex;
        flex-direction: {{ $flexDirection }};
        flex-wrap: wrap;
        gap: {{ $gapCss }};
        align-items: {{ $alignItems }};
        justify-content: {{ $alignItems }};
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #{{ $uid }} .rj-fl-link {
        font-size: 14px;
        color: {{ $linkColor }};
        text-decoration: none;
        transition: color 0.2s ease, transform 0.2s ease;
        display: inline-block;
    }
    #{{ $uid }} .rj-fl-link:hover {
        color: {{ $hoverColor }};
        transform: translateX(2px);
    }
    #{{ $uid }}[data-layout="horizontal"] .rj-fl-link:hover {
        transform: translateY(-1px);
    }
</style>

<div id="{{ $uid }}" data-layout="{{ $layout }}">
    @if($title !== '')
        <h3 class="rj-fl-title">{{ $title }}</h3>
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
