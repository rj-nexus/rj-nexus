@php
    $align      = $settings['align'] ?? 'center';
    $textColor  = $settings['text_color'] ?? '#94a3b8';
    $rawText    = $settings['text'] ?? __('© :year :site_name. All rights reserved.');
    $links      = $settings['links'] ?? [];

    $year = date('Y');
    $siteName = rj_get_option('site_name', config('app.name'));
    $text = str_replace([':year', ':site_name'], [$year, $siteName], $rawText);

    $justify = 'center';
    if ($align === 'left') {
        $justify = 'flex-start';
    } elseif ($align === 'right') {
        $justify = 'flex-end';
    }
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        padding: 8px 0;
    }
    #{{ $uid }} .rj-fc-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: {{ $justify }};
        gap: 16px;
        font-size: 14px;
        color: {{ $textColor }};
        line-height: 1.5;
    }
    @media (max-width: 768px) {
        #{{ $uid }} .rj-fc-inner {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
    }
    #{{ $uid }} .rj-fc-links {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        justify-content: {{ $justify }};
    }
    #{{ $uid }} .rj-fc-link {
        color: {{ $textColor }};
        text-decoration: none;
        transition: color 0.2s ease, opacity 0.2s ease;
    }
    #{{ $uid }} .rj-fc-link:hover {
        opacity: 0.8;
        text-decoration: underline;
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-fc-inner">
        <span>{!! $text !!}</span>

        @if(!empty($links))
            <div class="rj-fc-links">
                @foreach($links as $link)
                    @if(!empty($link['label']) && !empty($link['url']))
                        <a href="{{ $link['url'] }}" class="rj-fc-link">{{ $link['label'] }}</a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
