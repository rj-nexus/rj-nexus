<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ImageComparisonWidget extends BaseWidget
{
    private const HEIGHTS = [
        'aspect-video' => 'aspect-ratio:16/9;min-height:200px;',
        'aspect-square' => 'aspect-ratio:1/1;min-height:200px;',
        'aspect-[4/3]' => 'aspect-ratio:4/3;min-height:200px;',
        'aspect-[21/9]' => 'aspect-ratio:21/9;min-height:200px;',
        'h-[400px]' => 'height:400px;',
        'h-[600px]' => 'height:600px;',
    ];

    private const RADII = [
        'none' => '0px',
        'sm' => '8px',
        'md' => '16px',
        'lg' => '28px',
    ];

    private const HANDLE_SIZES = [
        'sm' => 36,
        'md' => 44,
        'lg' => 56,
    ];

    private const LINE_WIDTHS = [
        'thin' => 1,
        'md' => 2,
        'thick' => 4,
    ];

    public function id(): string
    {
        return 'image-comparison';
    }

    public function name(): string
    {
        return __('Image Comparison');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('A draggable before/after slider with horizontal or vertical mode, keyboard support, intro animation and clickable labels.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        return [
            ['name' => 'before_image', 'type' => 'media', 'label' => __('Before Image'), 'default' => '', 'tab' => 'content'],
            ['name' => 'after_image', 'type' => 'media', 'label' => __('After Image'), 'default' => '', 'tab' => 'content'],
            ['name' => 'before_label', 'type' => 'text', 'label' => __('Before Label'), 'default' => __('Before'), 'tab' => 'content'],
            ['name' => 'after_label', 'type' => 'text', 'label' => __('After Label'), 'default' => __('After'), 'tab' => 'content'],
            ['name' => 'caption', 'type' => 'text', 'label' => __('Caption (optional)'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'start',
                'type' => 'range',
                'label' => __('Start Position (%)'),
                'default' => 50,
                'min' => 0,
                'max' => 100,
                'tab' => 'content',
            ],

            [
                'name' => 'orientation',
                'type' => 'select',
                'label' => __('Direction'),
                'default' => 'horizontal',
                'tab' => 'style',
                'options' => [
                    'horizontal' => __('Horizontal (left / right)'),
                    'vertical' => __('Vertical (top / bottom)'),
                ],
            ],
            [
                'name' => 'interaction',
                'type' => 'select',
                'label' => __('Interaction'),
                'default' => 'drag',
                'tab' => 'style',
                'options' => [
                    'drag' => __('Drag or click'),
                    'hover' => __('Follow mouse on hover'),
                ],
            ],
            ['name' => 'intro', 'type' => 'select', 'label' => __('Intro Animation'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_hint', 'type' => 'select', 'label' => __('Show "Drag" Hint'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'aspect-video',
                'tab' => 'style',
                'options' => [
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-square' => __('Square (1:1)'),
                    'aspect-[4/3]' => __('Classic (4:3)'),
                    'aspect-[21/9]' => __('Cinematic (21:9)'),
                    'h-[400px]' => __('Fixed (400px)'),
                    'h-[600px]' => __('Fixed (600px)'),
                ],
            ],
            [
                'name' => 'radius',
                'type' => 'select',
                'label' => __('Corner Radius'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            ['name' => 'shadow', 'type' => 'select', 'label' => __('Drop Shadow'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'handle_style',
                'type' => 'select',
                'label' => __('Handle Style'),
                'default' => 'circle',
                'tab' => 'style',
                'options' => [
                    'circle' => __('Circle with arrows'),
                    'pill' => __('Pill'),
                    'dot' => __('Dot'),
                ],
            ],
            [
                'name' => 'handle_size',
                'type' => 'select',
                'label' => __('Handle Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'line_width',
                'type' => 'select',
                'label' => __('Line Thickness'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'thin' => __('Thin'),
                    'md' => __('Medium'),
                    'thick' => __('Thick'),
                ],
            ],
            ['name' => 'slider_color', 'type' => 'color', 'label' => __('Slider Line & Handle Color'), 'default' => '#ffffff', 'tab' => 'style'],
            [
                'name' => 'show_labels',
                'type' => 'toggle',
                'label' => __('Show Labels'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'label_position',
                'type' => 'select',
                'label' => __('Label Position'),
                'default' => 'bottom',
                'tab' => 'style',
                'options' => [
                    'top' => __('Top'),
                    'bottom' => __('Bottom'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $before = $this->mediaUrl((string) ($settings['before_image'] ?? ''));
        $after = $this->mediaUrl((string) ($settings['after_image'] ?? ''));

        if ($before === '' || $after === '') {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please select both Before and After images.') . '</div>';
        }

        $beforeLabel = trim((string) ($settings['before_label'] ?? __('Before')));
        $afterLabel = trim((string) ($settings['after_label'] ?? __('After')));
        $color = $this->color($settings['slider_color'] ?? null, '#ffffff');
        $heightKey = (string) ($settings['height'] ?? 'aspect-video');

        $content = [
            'before' => $before,
            'after' => $after,
            'before_label' => $beforeLabel,
            'after_label' => $afterLabel,
            'caption' => trim((string) ($settings['caption'] ?? '')),
        ];

        $opts = [
            'height_css' => self::HEIGHTS[$heightKey] ?? self::HEIGHTS['aspect-video'],
            'radius' => self::RADII[$this->pick($settings['radius'] ?? 'md', array_keys(self::RADII), 'md')],
            'shadow' => $this->flag($settings['shadow'] ?? null, true),
            'orientation' => $this->pick($settings['orientation'] ?? 'horizontal', ['horizontal', 'vertical'], 'horizontal'),
            'interaction' => $this->pick($settings['interaction'] ?? 'drag', ['drag', 'hover'], 'drag'),
            'intro' => $this->flag($settings['intro'] ?? null, true),
            'hint' => $this->flag($settings['show_hint'] ?? null, true),
            'handle_style' => $this->pick($settings['handle_style'] ?? 'circle', ['circle', 'pill', 'dot'], 'circle'),
            'handle_px' => self::HANDLE_SIZES[$this->pick($settings['handle_size'] ?? 'md', array_keys(self::HANDLE_SIZES), 'md')],
            'line_px' => self::LINE_WIDTHS[$this->pick($settings['line_width'] ?? 'md', array_keys(self::LINE_WIDTHS), 'md')],
            'color' => $color,
            'fg' => $this->contrast($color),
            'labels' => $this->flag($settings['show_labels'] ?? null, true),
            'label_pos' => $this->pick($settings['label_position'] ?? 'bottom', ['top', 'bottom'], 'bottom'),
            'start' => max(0, min(100, (int) ($settings['start'] ?? 50))),
        ];

        $uid = 'rjic_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.image-comparison', [
            'o' => $opts,
            'c' => $content,
            'uid' => $uid,
        ])->render();
    }

    private function mediaUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^https?:/i', $url) ? $url : '';
        }

        return $url;
    }

    private function color(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }

    private function contrast(string $hex): string
    {
        $h = ltrim($hex, '#');

        if (strlen($h) <= 4) {
            $h = preg_replace('/(.)/', '$1$1', $h);
        }

        $h = substr($h, 0, 6);
        $luma = 0.299 * hexdec(substr($h, 0, 2)) + 0.587 * hexdec(substr($h, 2, 2)) + 0.114 * hexdec(substr($h, 4, 2));

        return $luma > 160 ? '#111827' : '#ffffff';
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
