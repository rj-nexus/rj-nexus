<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HeroSlideWidget extends BaseWidget
{
    private const MAX_SLIDES = 5;

    private const HEIGHTS = [
        'aspect-video'  => 'aspect-ratio:16/9;min-height:420px;max-height:900px;',
        'aspect-[21/9]' => 'aspect-ratio:21/9;min-height:420px;max-height:900px;',
        'h-[500px]'     => 'height:500px;',
        'h-[700px]'     => 'height:700px;',
        'min-h-screen'  => 'min-height:100vh;min-height:100svh;',
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
        return __('A full-width slider hero with up to 5 slides, text overlays, CTA buttons, swipe and autoplay controls.');
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
                'name' => 'text_align',
                'type' => 'select',
                'label' => __('Text Alignment'),
                'default' => 'center',
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
                'label' => __('Content Vertical Position'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'center' => __('Center'),
                    'bottom' => __('Bottom'),
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
            ['name' => 'show_dots', 'type' => 'select', 'label' => __('Show Dots'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_progress', 'type' => 'select', 'label' => __('Show Progress Bar'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_counter', 'type' => 'select', 'label' => __('Show Slide Counter'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'btn_new_tab', 'type' => 'select', 'label' => __('Open Buttons in New Tab'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
        ];

        $slideDefaults = [
            1 => ['title' => __('Welcome to Our Store'), 'subtitle' => __('Discover our latest collection.'), 'btn_text' => __('Shop Now'), 'btn_url' => '/shop'],
            2 => ['title' => '', 'subtitle' => '', 'btn_text' => __('View Collection'), 'btn_url' => '/shop'],
            3 => ['title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
            4 => ['title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
            5 => ['title' => '', 'subtitle' => '', 'btn_text' => __('Learn More'), 'btn_url' => '/about'],
        ];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $d = $slideDefaults[$i];
            $fields[] = ['name' => "s{$i}_image", 'type' => 'media', 'label' => __('Slide :n - Image', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_title", 'type' => 'text', 'label' => __('Slide :n - Title', ['n' => $i]), 'default' => $d['title'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_subtitle", 'type' => 'textarea', 'label' => __('Slide :n - Subtitle', ['n' => $i]), 'default' => $d['subtitle'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn_text", 'type' => 'text', 'label' => __('Slide :n - Button Text', ['n' => $i]), 'default' => $d['btn_text'], 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_btn_url", 'type' => 'text', 'label' => __('Slide :n - Button URL', ['n' => $i]), 'default' => $d['btn_url'], 'tab' => 'content'];
        }

        return array_merge($fields, [
            [
                'name' => 'overlay_style',
                'type' => 'select',
                'label' => __('Overlay Style'),
                'default' => 'solid',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid'),
                    'gradient' => __('Gradient (bottom to top)'),
                ],
            ],
            ['name' => 'overlay_color', 'type' => 'color', 'label' => __('Overlay Color'), 'default' => '#000000', 'tab' => 'style'],
            ['name' => 'overlay_opacity', 'type' => 'range', 'label' => __('Overlay Opacity (%)'), 'default' => 40, 'min' => 0, 'max' => 100, 'tab' => 'style'],
            ['name' => 'title_color', 'type' => 'color', 'label' => __('Title Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'subtitle_color', 'type' => 'color', 'label' => __('Subtitle Color'), 'default' => '#f3f4f6', 'tab' => 'style'],
            ['name' => 'btn_bg', 'type' => 'color', 'label' => __('Button Background'), 'default' => '#111827', 'tab' => 'style'],
            ['name' => 'btn_text_color', 'type' => 'color', 'label' => __('Button Text Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'btn_hover_bg', 'type' => 'color', 'label' => __('Button Hover Background'), 'default' => '#374151', 'tab' => 'style'],
            ['name' => 'btn_hover_text_color', 'type' => 'color', 'label' => __('Button Hover Text Color'), 'default' => '#ffffff', 'tab' => 'style'],
        ]);
    }

    public function render(array $settings): string
    {
        $slides = [];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $image = trim((string) ($settings["s{$i}_image"] ?? ''));

            if ($image === '') {
                continue;
            }

            $slides[] = [
                'image' => $image,
                'title' => trim((string) ($settings["s{$i}_title"] ?? '')),
                'subtitle' => trim((string) ($settings["s{$i}_subtitle"] ?? '')),
                'btn_text' => trim((string) ($settings["s{$i}_btn_text"] ?? '')),
                'btn_url' => $this->safeUrl((string) ($settings["s{$i}_btn_url"] ?? '')),
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

        $opts = [
            'height_css' => self::HEIGHTS[$heightKey] ?? self::HEIGHTS['aspect-[21/9]'],
            'effect' => $this->pick($settings['effect'] ?? 'fade', ['fade', 'slide'], 'fade'),
            'text_align' => $this->pick($settings['text_align'] ?? 'center', ['left', 'center', 'right'], 'center'),
            'content_valign' => $this->pick($settings['content_valign'] ?? 'center', ['center', 'bottom'], 'center'),
            'image_position' => $this->pick($settings['image_position'] ?? 'center', ['center', 'top', 'bottom'], 'center'),
            'image_blur' => $this->int($settings['image_blur'] ?? 0, 0, 20),
            'kenburns' => $this->flag($settings['kenburns'] ?? null, true),
            'transition' => $transition,
            'autoplay' => $autoplay,
            'kb_ms' => $autoplay > 0 ? $autoplay + $transition * 2 : 12000,
            'pause_on_hover' => $this->flag($settings['pause_on_hover'] ?? null, true),
            'show_arrows' => $this->flag($settings['show_arrows'] ?? null, true),
            'show_dots' => $this->flag($settings['show_dots'] ?? null, true),
            'show_progress' => $this->flag($settings['show_progress'] ?? null, true),
            'show_counter' => $this->flag($settings['show_counter'] ?? null, false),
            'btn_new_tab' => $this->flag($settings['btn_new_tab'] ?? null, false),
            'overlay_style' => $this->pick($settings['overlay_style'] ?? 'solid', ['solid', 'gradient'], 'solid'),
            'overlay_color' => $this->color($settings['overlay_color'] ?? null, '#000000'),
            'overlay_opacity' => round($this->int($settings['overlay_opacity'] ?? 40, 0, 100) / 100, 2),
            'title_color' => $this->color($settings['title_color'] ?? null, '#ffffff'),
            'subtitle_color' => $this->color($settings['subtitle_color'] ?? null, '#f3f4f6'),
            'btn_bg' => $this->color($settings['btn_bg'] ?? null, '#111827'),
            'btn_text' => $this->color($settings['btn_text_color'] ?? null, '#ffffff'),
            'btn_hover_bg' => $this->color($settings['btn_hover_bg'] ?? null, '#374151'),
            'btn_hover_text' => $this->color($settings['btn_hover_text_color'] ?? null, '#ffffff'),
        ];

        $uid = 'slider_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.hero-slide', [
            'o' => $opts,
            'slides' => $slides,
            'uid' => $uid,
        ])->render();
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
