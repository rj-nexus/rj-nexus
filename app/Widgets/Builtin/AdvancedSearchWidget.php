<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AdvancedSearchWidget extends BaseWidget
{
    private const WIDTHS = [
        'sm' => '28rem',
        'md' => '42rem',
        'lg' => '56rem',
        'full' => '100%',
    ];

    private const MARGINS = [
        'left' => '0 auto 0 0',
        'center' => '0 auto',
        'right' => '0 0 0 auto',
    ];

    private const SIZES = [
        'sm' => ['py' => '10px', 'fs' => '1rem'],
        'md' => ['py' => '14px', 'fs' => '1.05rem'],
        'lg' => ['py' => '18px', 'fs' => '1.2rem'],
    ];

    private const RADII = [
        'sm' => '10px',
        'md' => '16px',
        'pill' => '999px',
    ];

    public function id(): string
    {
        return 'advanced-search';
    }

    public function name(): string
    {
        return __('Advanced Search');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>';
    }

    public function category(): string
    {
        return 'navigation';
    }

    public function description(): string
    {
        return __('A live AJAX search bar with autocomplete, keyboard navigation, recent searches and highlighted results.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'placeholder',
                'type' => 'text',
                'label' => __('Placeholder Text'),
                'default' => __('Search for products, posts...'),
                'tab' => 'content',
            ],
            [
                'name' => 'search_url',
                'type' => 'text',
                'label' => __('Search Endpoint'),
                'default' => '/search',
                'tab' => 'content',
                'help' => __('Must return JSON for AJAX requests and a results page for normal requests.'),
            ],
            [
                'name' => 'query_param',
                'type' => 'text',
                'label' => __('Query Parameter'),
                'default' => 'q',
                'tab' => 'content',
            ],
            [
                'name' => 'min_chars',
                'type' => 'number',
                'label' => __('Minimum Characters'),
                'default' => 2,
                'tab' => 'content',
            ],
            [
                'name' => 'max_results',
                'type' => 'number',
                'label' => __('Maximum Results in Dropdown'),
                'default' => 8,
                'tab' => 'content',
            ],
            [
                'name' => 'debounce',
                'type' => 'number',
                'label' => __('Typing Delay (ms)'),
                'default' => 300,
                'tab' => 'content',
            ],
            ['name' => 'show_recent', 'type' => 'select', 'label' => __('Show Recent Searches'), 'default' => '1', 'tab' => 'content', 'options' => $this->yesNo()],
            ['name' => 'show_view_all', 'type' => 'select', 'label' => __('Show "View all results" Link'), 'default' => '1', 'tab' => 'content', 'options' => $this->yesNo()],
            ['name' => 'show_shortcut', 'type' => 'select', 'label' => __('Focus with "/" Key'), 'default' => '0', 'tab' => 'content', 'options' => $this->yesNo()],

            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'minimal',
                'tab' => 'style',
                'options' => [
                    'minimal' => __('Minimal (Underline)'),
                    'filled' => __('Filled (Gray Background)'),
                    'dark' => __('Dark Theme'),
                    'outline' => __('Outline (Card)'),
                ],
            ],
            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'radius',
                'type' => 'select',
                'label' => __('Corner Shape'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Slightly rounded'),
                    'md' => __('Rounded'),
                    'pill' => __('Pill'),
                ],
            ],
            [
                'name' => 'width',
                'type' => 'select',
                'label' => __('Max Width'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                    'full' => __('Full width'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#4f46e5', 'tab' => 'style'],
            [
                'name' => 'show_image',
                'type' => 'toggle',
                'label' => __('Show Result Images'),
                'default' => true,
                'tab' => 'style',
            ],
            ['name' => 'show_excerpt', 'type' => 'select', 'label' => __('Show Result Excerpt'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_type', 'type' => 'select', 'label' => __('Show Result Type Badge'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'group_results', 'type' => 'select', 'label' => __('Group Results by Type'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
        ];
    }

    public function render(array $settings): string
    {
        $searchUrl = $this->searchUrl((string) ($settings['search_url'] ?? '/search'));
        $param = $this->param((string) ($settings['query_param'] ?? 'q'));

        $style = $this->pick($settings['style'] ?? 'minimal', ['minimal', 'filled', 'dark', 'outline'], 'minimal');
        $size = self::SIZES[$this->pick($settings['size'] ?? 'md', array_keys(self::SIZES), 'md')];
        $radius = self::RADII[$this->pick($settings['radius'] ?? 'md', array_keys(self::RADII), 'md')];
        $width = self::WIDTHS[$this->pick($settings['width'] ?? 'md', array_keys(self::WIDTHS), 'md')];
        $margin = self::MARGINS[$this->pick($settings['align'] ?? 'center', array_keys(self::MARGINS), 'center')];
        $accent = $this->color($settings['accent_color'] ?? null, '#4f46e5');

        $placeholder = trim((string) ($settings['placeholder'] ?? ''));
        if ($placeholder === '') {
            $placeholder = __('Search...');
        }

        $cfg = [
            'searchUrl' => $searchUrl,
            'param' => $param,
            'minChars' => $this->int($settings['min_chars'] ?? 2, 1, 5),
            'maxResults' => $this->int($settings['max_results'] ?? 8, 3, 15),
            'debounce' => $this->int($settings['debounce'] ?? 300, 150, 800),
            'showImage' => $this->flag($settings['show_image'] ?? null, true),
            'showExcerpt' => $this->flag($settings['show_excerpt'] ?? null, true),
            'showType' => $this->flag($settings['show_type'] ?? null, true),
            'group' => $this->flag($settings['group_results'] ?? null, false),
            'showRecent' => $this->flag($settings['show_recent'] ?? null, true),
            'showViewAll' => $this->flag($settings['show_view_all'] ?? null, true),
            'shortcut' => $this->flag($settings['show_shortcut'] ?? null, false),
            'strings' => [
                'viewAll' => __('View all results for “:query”'),
                'noResults' => __('No results found for “:query”'),
                'error' => __('Something went wrong. Please try again.'),
                'retry' => __('Try again'),
                'recent' => __('Recent searches'),
                'clearRecent' => __('Clear'),
                'count' => __(':count results available'),
                'none' => __('No results'),
            ],
        ];

        $prefill = '';
        $path = trim((string) parse_url($searchUrl, PHP_URL_PATH), '/');
        if ($path !== '' && request()->is($path)) {
            $value = request()->query($param);
            $prefill = is_string($value) ? mb_substr($value, 0, 200) : '';
        }

        $opts = [
            'placeholder' => $placeholder,
            'search_url' => $searchUrl,
            'param' => $param,
            'prefill' => $prefill,
            'style' => $style,
            'py' => $size['py'],
            'fs' => $size['fs'],
            'radius' => $radius,
            'max_width' => $width,
            'margin' => $margin,
            'accent' => $accent,
            'accent_rgb' => $this->rgb($accent),
            'shortcut' => $cfg['shortcut'],
            'config_json' => json_encode($cfg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ];

        $uid = 'rjsr_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.advanced-search', [
            'o' => $opts,
            'uid' => $uid,
        ])->render();
    }

    private function searchUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return url('/search');
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^https?:/i', $url) ? $url : url('/search');
        }

        return str_starts_with($url, '/') ? url($url) : url('/' . $url);
    }

    private function param(string $param): string
    {
        $param = trim($param);

        return preg_match('/^[A-Za-z0-9_\-]{1,32}$/', $param) ? $param : 'q';
    }

    private function int(mixed $value, int $min, int $max): int
    {
        return max($min, min($max, (int) $value));
    }

    private function color(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }

    private function rgb(string $hex): string
    {
        $h = ltrim($hex, '#');

        if (strlen($h) <= 4) {
            $h = preg_replace('/(.)/', '$1$1', $h);
        }

        $h = substr($h, 0, 6);

        return hexdec(substr($h, 0, 2)) . ',' . hexdec(substr($h, 2, 2)) . ',' . hexdec(substr($h, 4, 2));
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function flag(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }
}
