@php
    $title      = $settings['title'] ?? '';
    $layout     = $settings['layout'] ?? 'vertical';
    $align      = $settings['align'] ?? 'left';
    $gap        = $settings['gap'] ?? 'md';
    $titleColor = $settings['title_color'] ?? '#ffffff';
    $iconColor  = $settings['icon_color'] ?? '#8b5cf6';
    $textColor  = $settings['text_color'] ?? '#94a3b8';
    $items      = $settings['items'] ?? [];

    $gapMap = ['sm' => '10px', 'md' => '16px', 'lg' => '24px'];
    $gapCss = $gapMap[$gap] ?? '16px';

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

    $getIconUrl = function ($name) use ($iconColor) {
        if (empty($name)) return '';
        $cleanColor = urlencode($iconColor);
        return 'https://api.iconify.design/' . str_replace(':', '/', $name) . '.svg?color=' . $cleanColor;
    };
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
    }
    #{{ $uid }} .rj-fct-title {
        font-size: 16px;
        font-weight: 700;
        color: {{ $titleColor }};
        margin: 0 0 20px;
        letter-spacing: -.01em;
        text-align: {{ $textAlign }};
    }
    #{{ $uid }} .rj-fct-list {
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
    #{{ $uid }} .rj-fct-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        text-decoration: none;
        color: {{ $textColor }};
        transition: opacity 0.2s ease;
        max-width: 100%;
    }
    #{{ $uid }} .rj-fct-item.is-link:hover {
        opacity: 0.8;
    }
    #{{ $uid }} .rj-fct-icon {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
    }
    #{{ $uid }} .rj-fct-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    #{{ $uid }} .rj-fct-body {
        display: flex;
        flex-direction: column;
        text-align: {{ $textAlign }};
    }
    #{{ $uid }} .rj-fct-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.7;
        margin-bottom: 2px;
    }
    #{{ $uid }} .rj-fct-value {
        font-size: 14px;
        font-weight: 500;
        line-height: 1.4;
        word-break: break-word;
    }
</style>

<div id="{{ $uid }}">
    @if($title !== '')
        <h3 class="rj-fct-title">{{ $title }}</h3>
    @endif

    @if(!empty($items))
        <div class="rj-fct-list">
            @foreach($items as $item)
                @php
                    $iconUrl = $getIconUrl($item['icon'] ?? '');
                    $value = $item['value'] ?? '';
                    $label = $item['label'] ?? '';
                    $url = $item['url'] ?? '';

                    $tag = $url !== '' ? 'a' : 'div';
                    $linkClass = $url !== '' ? 'is-link' : '';
                @endphp

                @if($value !== '' || $label !== '')
                    <{{ $tag }}
                        class="rj-fct-item {{ $linkClass }}"
                        @if($url !== '') href="{{ $url }}" target="_blank" rel="noopener noreferrer" @endif
                    >
                        @if($iconUrl !== '')
                            <div class="rj-fct-icon">
                                <img src="{{ $iconUrl }}" alt="" loading="lazy">
                            </div>
                        @endif

                        <div class="rj-fct-body">
                            @if($label !== '')
                                <span class="rj-fct-label">{{ $label }}</span>
                            @endif
                            @if($value !== '')
                                <span class="rj-fct-value">{{ $value }}</span>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endif
            @endforeach
        </div>
    @endif
</div>
