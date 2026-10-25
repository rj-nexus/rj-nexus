<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HeroSlideWidget extends BaseWidget
{
    private const MAX_SLIDES = 5;

    private const HEIGHTS = [
        'aspect-video'  => 'aspect-ratio:16/9;min-height:460px;max-height:900px;',
        'aspect-[21/9]' => 'aspect-ratio:21/9;min-height:460px;max-height:900px;',
        'h-[500px]'     => 'height:500px;',
        'h-[700px]'     => 'height:700px;',
        'min-h-screen'  => 'min-height:100vh;min-height:100svh;',
    ];

    private const TITLE_SIZES = [
        'sm' => 'clamp(1.75rem,4vw,3.25rem)',
        'md' => 'clamp(2rem,5.5vw,4.5rem)',
        'lg' => 'clamp(2.5rem,7.5vw,6.25rem)',
    ];

    private const BTN_RADIUS = [
        'sm' => '4px',
        'md' => '12px',
        'pill' => '999px',
    ];

    public function id(): string
    {
        return 'hero-slide';
    }

    public function name(): string
    {
        return __('Hero Slider');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A full-width hero slider with up to 5 slides, per-slide text position, animated text, CTA buttons, swipe and autoplay controls.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        $fields = [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Hero Size'),
                'default' => 'aspect-[21/9]',
                'tab' => 'content',
                'options' => [
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-[21/9]' => __('Cinematic (21:9)'),
                    'h-[500px]' => __('Fixed Medium (500px)'),
                    'h-[700px]' => __('Fixed Large (700px)'),
                    'min-h-screen' => __('Full Screen'),
                ],
            ],
            [
                'name' => 'text_align',
                'type' => 'select',
                'label' => __('Default Text Position (horizontal)'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'content_valign',
                'type' => 'select',
                'label' => __('Default Text Position (vertical)'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'top' => __('Top'),
                    'center' => __('Center'),
                    'bottom' => __('Bottom'),
                ],
            ],
            [
                'name' => 'content_style',
                'type' => 'select',
                'label' => __('Content Style'),
                'default' => 'plain',
                'tab' => 'style',
                'options' => [
                    'plain' => __('Plain text'),
                    'glass' => __('Glass card'),
                ],
            ],
            [
                'name' => 'title_size',
                'type' => 'select',
                'label' => __('Title Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'text_animation',
                'type' => 'select',
                'label' => __('Text Animation'),
                'default' => 'rise',
                'tab' => 'style',
                'options' => [
                    'rise' => __('Rise'),
                    'fade' => __('Fade'),
                    'zoom' => __('Zoom'),
                    'blur' => __('Blur in'),
                ],
            ],
            [
                'name' => 'effect',
                'type' => 'select',
                'label' => __('Transition Effect'),
                'default' => 'fade',
                'tab' => 'style',
                'options' => [
                    'fade' => __('Fade'),
                    'slide' => __('Slide'),
                ],
            ],
            [
                'name' => 'image_position',
                'type' => 'select',
                'label' => __('Image Focus Point'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'center' => __('Center'),
                    'top' => __('Top'),
                    'bottom' => __('Bottom'),
                ],
            ],
            [
                'name' => 'image_blur',
                'type' => 'range',
                'label' => __('Image Blur (px)'),
                'default' => 0,
                'min' => 0,
                'max' => 20,
                'tab' => 'style',
            ],
            ['name' => 'kenburns', 'type' => 'select', 'label' => __('Zoom Animation (Ken Burns)'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'parallax', 'type' => 'select', 'label' => __('Mouse Parallax on Text'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'transition_duration',
                'type' => 'number',
                'label' => __('Slide Transition Speed (ms)'),
                'default' => 1000,
                'tab' => 'style',
            ],
            [
                'name' => 'autoplay_speed',
                'type' => 'number',
                'label' => __('Autoplay Delay (ms)'),
                'default' => 5000,
                'tab' => 'style',
                'help' => __('Set to 0 to disable autoplay.'),
            ],
            ['name' => 'pause_on_hover', 'type' => 'select', 'label' => __('Pause on Hover'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_arrows', 'type' => 'select', 'label' => __('Show Arrows'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_dots', 'type' => 'select', 'label' => __('Show Navigation'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'dots_style',
                'type' => 'select',
                'label' => __('Navigation Style'),
                'default' => 'dots',
                'tab' => 'style',
                'options' => [
                    'dots' => __('Dots'),
                    'lines' => __('Lines'),
                ],
            ],
            ['name' => 'show_progress', 'type' => 'select', 'label' => __('Show Progress Bar'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_counter', 'type' => 'select', 'label' => __('Show Slide Counter'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'btn_new_tab', 'type' => 'select', 'label' => __('Open Buttons in New Tab'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'btn_radius',
                'type' => 'select',
                'label' => __('Button Shape'),
                'default' => 'pill',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Square'),
                    'md' => __('Rounded'),
                    'pill' => __('Pill'),
                ],
            ],
        ];

        $slideDefaults = [
            1 => ['eyebrow' => __('New Collection'), 'title' => __('Welcome to *Our Store*'), 'subtitle' => __('Discover our latest collection.'), 'btn_text' => __('Shop Now'), 'btn_url' => '/shop'],
            2 => ['eyebrow' => '', 'title' => '', 'subtitle' => '', 'btn_text' => __('View Collection'), 'btn_url' => '/shop'],
            3 => ['eyebrow' => '', 'title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
            4 => ['eyebrow' => '', 'title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
            5 => ['eyebrow' => '', 'title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
        ];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $d = $slideDefaults[$i];

            $fields[] = ['name' => "s{$i}_image", 'type' => 'media', 'label' => __('Slide :n - Image', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_eyebrow", 'type' => 'text', 'label' => __('Slide :n - Small Label', ['n' => $i]), 'default' => $d['eyebrow'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_title", 'type' => 'text', 'label' => __('Slide :n - Title', ['n' => $i]), 'default' => $d['title'], 'tab' => 'content', 'help' => __('Wrap a word in *asterisks* to highlight it.')];
            $fields[] = ['name' => "s{$i}_subtitle", 'type' => 'textarea', 'label' => __('Slide :n - Subtitle', ['n' => $i]), 'default' => $d['subtitle'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn_text", 'type' => 'text', 'label' => __('Slide :n - Button Text', ['n' => $i]), 'default' => $d['btn_text'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn_url", 'type' => 'text', 'label' => __('Slide :n - Button URL', ['n' => $i]), 'default' => $d['btn_url'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn2_text", 'type' => 'text', 'label' => __('Slide :n - Second Button Text', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn2_url", 'type' => 'text', 'label' => __('Slide :n - Second Button URL', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = [
                'name' => "s{$i}_align",
                'type' => 'select',
                'label' => __('Slide :n - Text Position (horizontal)', ['n' => $i]),
                'default' => 'inherit',
                'tab' => 'content',
                'options' => [
                    'inherit' => __('Use default'),
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ];
            $fields[] = [
                'name' => "s{$i}_valign",
                'type' => 'select',
                'label' => __('Slide :n - Text Position (vertical)', ['n' => $i]),
                'default' => 'inherit',
                'tab' => 'content',
                'options' => [
                    'inherit' => __('Use default'),
                    'top' => __('Top'),
                    'center' => __('Center'),
                    'bottom' => __('Bottom'),
                ],
            ];
        }

        return array_merge($fields, [
            [
                'name' => 'overlay_style',
                'type' => 'select',
                'label' => __('Overlay Style'),
                'default' => 'side',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid'),
                    'gradient' => __('Gradient (bottom to top)'),
                    'side' => __('Follows text position'),
                ],
            ],
            ['name' => 'overlay_color', 'type' => 'color', 'label' => __('Overlay Color'), 'default' => '#000000', 'tab' => 'style'],
            ['name' => 'overlay_opacity', 'type' => 'range', 'label' => __('Overlay Opacity (%)'), 'default' => 45, 'min' => 0, 'max' => 100, 'tab' => 'style'],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#f59e0b', 'tab' => 'style'],
            ['name' => 'title_color', 'type' => 'color', 'label' => __('Title Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'subtitle_color', 'type' => 'color', 'label' => __('Subtitle Color'), 'default' => '#f3f4f6', 'tab' => 'style'],
            ['name' => 'btn_bg', 'type' => 'color', 'label' => __('Button Background'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'btn_text_color', 'type' => 'color', 'label' => __('Button Text Color'), 'default' => '#111827', 'tab' => 'style'],
            ['name' => 'btn_hover_bg', 'type' => 'color', 'label' => __('Button Hover Background'), 'default' => '#f59e0b', 'tab' => 'style'],
            ['name' => 'btn_hover_text_color', 'type' => 'color', 'label' => __('Button Hover Text Color'), 'default' => '#111827', 'tab' => 'style'],
        ]);
    }

    public function render(array $settings): string
    {
        $defaultAlign = $this->pick($settings['text_align'] ?? 'left', ['left', 'center', 'right'], 'left');
        $defaultValign = $this->pick($settings['content_valign'] ?? 'center', ['top', 'center', 'bottom'], 'center');

        $slides = [];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $image = trim((string) ($settings["s{$i}_image"] ?? ''));

            if ($image === '') {
                continue;
            }

            $title = trim((string) ($settings["s{$i}_title"] ?? ''));

            $slides[] = [
                'image' => $image,
                'eyebrow' => trim((string) ($settings["s{$i}_eyebrow"] ?? '')),
                'title' => str_replace('*', '', $title),
                'title_html' => $title === '' ? '' : $this->accent($title),
                'subtitle' => trim((string) ($settings["s{$i}_subtitle"] ?? '')),
                'btn_text' => trim((string) ($settings["s{$i}_btn_text"] ?? '')),
                'btn_url' => $this->safeUrl((string) ($settings["s{$i}_btn_url"] ?? '')),
                'btn2_text' => trim((string) ($settings["s{$i}_btn2_text"] ?? '')),
                'btn2_url' => $this->safeUrl((string) ($settings["s{$i}_btn2_url"] ?? '')),
                'align' => $this->pick($settings["s{$i}_align"] ?? '', ['left', 'center', 'right'], $defaultAlign),
                'valign' => $this->pick($settings["s{$i}_valign"] ?? '', ['top', 'center', 'bottom'], $defaultValign),
            ];
        }

        if (empty($slides)) {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please add at least one slide image to display the slider.') . '</div>';
        }

        $transition = $this->int($settings['transition_duration'] ?? 1000, 0, 5000);
        $autoplay = $this->int($settings['autoplay_speed'] ?? 5000, 0, 60000);

        if ($autoplay > 0) {
            $autoplay = max($autoplay, $transition + 1000);
        }

        $heightKey = (string) ($settings['height'] ?? 'aspect-[21/9]');
        $titleSize = $this->pick($settings['title_size'] ?? 'md', array_keys(self::TITLE_SIZES), 'md');
        $btnRadius = $this->pick($settings['btn_radius'] ?? 'pill', array_keys(self::BTN_RADIUS), 'pill');
        $textAnim = $this->pick($settings['text_animation'] ?? 'rise', ['rise', 'fade', 'zoom', 'blur'], 'rise');
        $overlayOpacity = $this->int($settings['overlay_opacity'] ?? 45, 0, 100) / 100;

        $opts = [
            'height_css' => self::HEIGHTS[$heightKey] ?? self::HEIGHTS['aspect-[21/9]'],
            'effect' => $this->pick($settings['effect'] ?? 'fade', ['fade', 'slide'], 'fade'),
            'content_style' => $this->pick($settings['content_style'] ?? 'plain', ['plain', 'glass'], 'plain'),
            'title_font' => self::TITLE_SIZES[$titleSize],
            'text_anim' => 'rjhs-' . $textAnim,
            'image_position' => $this->pick($settings['image_position'] ?? 'center', ['center', 'top', 'bottom'], 'center'),
            'image_blur' => $this->int($settings['image_blur'] ?? 0, 0, 20),
            'kenburns' => $this->flag($settings['kenburns'] ?? null, true),
            'parallax' => $this->flag($settings['parallax'] ?? null, true),
            'transition' => $transition,
            'autoplay' => $autoplay,
            'kb_ms' => $autoplay > 0 ? $autoplay + $transition * 2 : 12000,
            'pause_on_hover' => $this->flag($settings['pause_on_hover'] ?? null, true),
            'show_arrows' => $this->flag($settings['show_arrows'] ?? null, true),
            'show_dots' => $this->flag($settings['show_dots'] ?? null, true),
            'dots_style' => $this->pick($settings['dots_style'] ?? 'dots', ['dots', 'lines'], 'dots'),
            'show_progress' => $this->flag($settings['show_progress'] ?? null, true),
            'show_counter' => $this->flag($settings['show_counter'] ?? null, true),
            'btn_new_tab' => $this->flag($settings['btn_new_tab'] ?? null, false),
            'btn_radius' => self::BTN_RADIUS[$btnRadius],
            'overlay_style' => $this->pick($settings['overlay_style'] ?? 'side', ['solid', 'gradient', 'side'], 'side'),
            'overlay_color' => $this->color($settings['overlay_color'] ?? null, '#000000'),
            'overlay_opacity' => round($overlayOpacity, 2),
            'overlay_opacity_g' => round(min(1, $overlayOpacity * 1.7), 2),
            'accent' => $this->color($settings['accent_color'] ?? null, '#f59e0b'),
            'title_color' => $this->color($settings['title_color'] ?? null, '#ffffff'),
            'subtitle_color' => $this->color($settings['subtitle_color'] ?? null, '#f3f4f6'),
            'btn_bg' => $this->color($settings['btn_bg'] ?? null, '#ffffff'),
            'btn_text' => $this->color($settings['btn_text_color'] ?? null, '#111827'),
            'btn_hover_bg' => $this->color($settings['btn_hover_bg'] ?? null, '#f59e0b'),
            'btn_hover_text' => $this->color($settings['btn_hover_text_color'] ?? null, '#111827'),
        ];

        $uid = 'rjhs_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.hero-slide', [
            'o' => $opts,
            'slides' => $slides,
            'uid' => $uid,
        ])->render();
    }

    private function accent(string $text): string
    {
        $escaped = e($text);

        return preg_replace('/\*(.+?)\*/u', '<span class="rjhs-accent">$1</span>', $escaped) ?? $escaped;
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

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '';
        }

        return $url;
    }
}
