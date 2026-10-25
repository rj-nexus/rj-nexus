<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AnimatedHeroWidget extends BaseWidget
{
    private const MAX_SLIDES = 5;

    public function id(): string
    {
        return 'animated-hero';
    }

    public function name(): string
    {
        return __('Animated Scroll Hero');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A premium, scroll-driven hero with up to 5 slides (each with its own text and link) and a final CTA slide.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        $fields = [];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $fields[] = ['name' => "image_{$i}", 'type' => 'media', 'label' => $i === 1 ? __('Image 1 (Required)') : __('Image :n', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "label_{$i}", 'type' => 'text', 'label' => __('Slide :n - Small Label', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "title_{$i}", 'type' => 'text', 'label' => __('Slide :n - Title', ['n' => $i]), 'default' => '', 'tab' => 'content', 'help' => __('Wrap a word in *asterisks* to highlight it.')];
            $fields[] = ['name' => "text_{$i}", 'type' => 'textarea', 'label' => __('Slide :n - Text', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "btn_text_{$i}", 'type' => 'text', 'label' => __('Slide :n - Button Text', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "btn_url_{$i}", 'type' => 'text', 'label' => __('Slide :n - Button URL', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = [
                'name' => "align_{$i}",
                'type' => 'select',
                'label' => __('Slide :n - Text Position', ['n' => $i]),
                'default' => 'inherit',
                'tab' => 'content',
                'options' => [
                    'inherit' => __('Use default'),
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ];
        }

        return array_merge($fields, [
            ['name' => 'final_bg_image', 'type' => 'media', 'label' => __('Final Slide Background (Optional)'), 'default' => '', 'tab' => 'content', 'help' => __('If left empty, the last image will be used with a blur effect.')],
            ['name' => 'final_title', 'type' => 'text', 'label' => __('Final Slide Title'), 'default' => __('Discover Our *Latest* Collection'), 'tab' => 'content'],
            ['name' => 'final_subtitle', 'type' => 'text', 'label' => __('Final Slide Label'), 'default' => __('Elevate your style with our premium selection.'), 'tab' => 'content'],
            ['name' => 'final_btn_text', 'type' => 'text', 'label' => __('Final Slide Button Text'), 'default' => __('Explore Now'), 'tab' => 'content'],
            ['name' => 'final_btn_url', 'type' => 'text', 'label' => __('Final Slide Button URL'), 'default' => '/shop', 'tab' => 'content'],

            [
                'name' => 'text_align',
                'type' => 'select',
                'label' => __('Default Text Position'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'scroll_length',
                'type' => 'select',
                'label' => __('Scroll Length per Slide'),
                'default' => '140',
                'tab' => 'style',
                'options' => [
                    '100' => __('Short'),
                    '140' => __('Normal'),
                    '200' => __('Long'),
                ],
            ],
            [
                'name' => 'reveal_style',
                'type' => 'select',
                'label' => __('Slide Reveal Style'),
                'default' => 'mixed',
                'tab' => 'style',
                'options' => [
                    'mixed' => __('Mixed'),
                    'circle' => __('Circle'),
                    'inset' => __('Side wipe'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#818cf8', 'tab' => 'style'],
            ['name' => 'show_dots', 'type' => 'select', 'label' => __('Show Side Dots'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_counter', 'type' => 'select', 'label' => __('Show Slide Counter'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_hint', 'type' => 'select', 'label' => __('Show "Scroll" Hint'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
        ]);
    }

    public function render(array $settings): string
    {
        $defaultAlign = $this->pick($settings['text_align'] ?? 'left', ['left', 'center', 'right'], 'left');

        $slides = [];

        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            $image = trim((string) ($settings["image_{$i}"] ?? ''));

            if ($image === '') {
                continue;
            }

            $title = trim((string) ($settings["title_{$i}"] ?? ''));

            $slides[] = [
                'image' => $image,
                'label' => trim((string) ($settings["label_{$i}"] ?? '')),
                'title' => str_replace('*', '', $title),
                'title_html' => $title === '' ? '' : $this->accent($title),
                'text' => trim((string) ($settings["text_{$i}"] ?? '')),
                'btn_text' => trim((string) ($settings["btn_text_{$i}"] ?? '')),
                'btn_url' => $this->safeUrl((string) ($settings["btn_url_{$i}"] ?? '')),
                'align' => $this->pick($settings["align_{$i}"] ?? '', ['left', 'center', 'right'], $defaultAlign),
            ];
        }

        if (empty($slides)) {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please select at least Image 1 to display the animated hero.') . '</div>';
        }

        $finalBg = trim((string) ($settings['final_bg_image'] ?? ''));
        $finalTitle = trim((string) ($settings['final_title'] ?? __('Discover More')));

        $final = [
            'image' => $finalBg !== '' ? $finalBg : $slides[array_key_last($slides)]['image'],
            'blurred' => $finalBg === '',
            'label' => trim((string) ($settings['final_subtitle'] ?? __('Premium Collection'))),
            'title' => str_replace('*', '', $finalTitle),
            'title_html' => $finalTitle === '' ? '' : $this->accent($finalTitle),
            'btn_text' => trim((string) ($settings['final_btn_text'] ?? '')),
            'btn_url' => $this->safeUrl((string) ($settings['final_btn_url'] ?? '')),
        ];

        $opts = [
            'step_vh' => (int) $this->pick($settings['scroll_length'] ?? '140', ['100', '140', '200'], '140'),
            'reveal' => $this->pick($settings['reveal_style'] ?? 'mixed', ['mixed', 'circle', 'inset'], 'mixed'),
            'accent' => $this->color($settings['accent_color'] ?? null, '#818cf8'),
            'show_dots' => $this->flag($settings['show_dots'] ?? null, true),
            'show_counter' => $this->flag($settings['show_counter'] ?? null, true),
            'show_hint' => $this->flag($settings['show_hint'] ?? null, true),
        ];

        $uid = 'rjsc_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.animated-hero', [
            'o' => $opts,
            'slides' => $slides,
            'final' => $final,
            'uid' => $uid,
        ])->render();
    }

    private function accent(string $text): string
    {
        $escaped = e($text);

        return preg_replace('/\*(.+?)\*/u', '<span class="rjsc-accent">$1</span>', $escaped) ?? $escaped;
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
