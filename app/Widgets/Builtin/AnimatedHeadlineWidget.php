<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AnimatedHeadlineWidget extends BaseWidget
{
    private const SIZES = [
        'lg' => 'clamp(22px, 2.2vw, 32px)',
        'xl' => 'clamp(28px, 3.4vw, 48px)',
        '2xl' => 'clamp(36px, 4.4vw, 64px)',
        '3xl' => 'clamp(44px, 5.4vw, 80px)',
    ];

    private const SPEEDS = ['slow' => 1.5, 'normal' => 1.0, 'fast' => 0.65];

    private const UNDERLINES = [
        'pen' => [['d' => 'M 3 12 C 30 8, 60 14, 90 10 S 150 8, 197 11', 'w' => 2.5, 'dash' => '', 'o' => 1]],
        'brush' => [['d' => 'M 3 11 C 40 5, 80 16, 120 9 S 180 7, 197 11', 'w' => 6, 'dash' => '', 'o' => 0.9]],
        'wave' => [['d' => 'M 3 10 Q 15 2, 27 10 T 51 10 T 75 10 T 99 10 T 123 10 T 147 10 T 171 10 T 195 10', 'w' => 2.5, 'dash' => '', 'o' => 1]],
        'plain' => [['d' => 'M 3 10 L 197 10', 'w' => 3, 'dash' => '', 'o' => 1]],
        'double' => [
            ['d' => 'M 3 6 L 197 6', 'w' => 2, 'dash' => '', 'o' => 1],
            ['d' => 'M 3 14 L 197 14', 'w' => 2, 'dash' => '', 'o' => 1],
        ],
        'dashed' => [['d' => 'M 3 10 L 197 10', 'w' => 3, 'dash' => '8 6', 'o' => 1]],
        'zigzag' => [['d' => 'M 3 14 L 15 6 L 27 14 L 39 6 L 51 14 L 63 6 L 75 14 L 87 6 L 99 14 L 111 6 L 123 14 L 135 6 L 147 14 L 159 6 L 171 14 L 183 6 L 195 14', 'w' => 2.5, 'dash' => '', 'o' => 1]],
        'swoosh' => [['d' => 'M 3 15 C 60 19, 140 2, 197 8', 'w' => 3.5, 'dash' => '', 'o' => 1]],
    ];

    private const CIRCLE = 'M 100 6 C 38 4, 8 22, 6 50 C 5 76, 40 94, 98 96 C 160 94, 194 74, 194 52 C 193 26, 158 6, 100 6 Z';

    public function id(): string
    {
        return 'animated-headline';
    }

    public function name(): string
    {
        return __('Animated Headline');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h14"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4l3 3-3 3"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('An animated headline with underline, circle, typing, gradient, letters and glow effects, plus rotating words.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'text_before', 'type' => 'text', 'label' => __('Text Before'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'text_highlight',
                'type' => 'text',
                'label' => __('Highlighted Text'),
                'default' => __('Amazing'),
                'tab' => 'content',
                'help' => __('This part receives the effect. Separate several words with | to rotate them, for example: Fast | Reliable | Beautiful'),
            ],
            ['name' => 'text_after', 'type' => 'text', 'label' => __('Text After'), 'default' => '', 'tab' => 'content'],
            [
                'name' => 'tag',
                'type' => 'select',
                'label' => __('HTML Tag'),
                'default' => 'h2',
                'tab' => 'content',
                'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'div' => 'div'],
            ],
            [
                'name' => 'effect',
                'type' => 'select',
                'label' => __('Highlight Effect'),
                'default' => 'underline',
                'tab' => 'content',
                'options' => [
                    'underline' => __('Underline'),
                    'circle' => __('Circle'),
                    'highlight' => __('Background'),
                    'typing' => __('Typing'),
                    'gradient' => __('Flowing Gradient'),
                    'letters' => __('Letters (bounce in)'),
                    'glow' => __('Glow'),
                    'none' => __('None'),
                ],
            ],
            [
                'name' => 'underline_style',
                'type' => 'select',
                'label' => __('Underline Style'),
                'default' => 'pen',
                'tab' => 'content',
                'options' => [
                    'pen' => __('Pen Stroke'),
                    'brush' => __('Brush'),
                    'wave' => __('Wave'),
                    'plain' => __('Plain'),
                    'double' => __('Double'),
                    'dashed' => __('Dashed'),
                    'zigzag' => __('Zigzag'),
                    'swoosh' => __('Swoosh'),
                ],
                'help' => __('Applies only to the Underline effect.'),
            ],
            [
                'name' => 'direction',
                'type' => 'select',
                'label' => __('Animation Direction'),
                'default' => 'left',
                'tab' => 'content',
                'options' => [
                    'left' => __('Left → Right'),
                    'right' => __('Right → Left'),
                    'both' => __('Both Sides'),
                ],
                'help' => __('Applies to Underline, Circle and Background.'),
            ],
            [
                'name' => 'speed',
                'type' => 'select',
                'label' => __('Animation Speed'),
                'default' => 'normal',
                'tab' => 'content',
                'options' => ['slow' => __('Slow'), 'normal' => __('Normal'), 'fast' => __('Fast')],
            ],
            ['name' => 'loop', 'type' => 'toggle', 'label' => __('Repeat Animation'), 'default' => false, 'tab' => 'content'],
            ['name' => 'hover_replay', 'type' => 'toggle', 'label' => __('Replay Effect on Hover'), 'default' => true, 'tab' => 'content'],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => ['left' => __('Left'), 'center' => __('Center'), 'right' => __('Right')],
            ],
            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Size'),
                'default' => 'xl',
                'tab' => 'style',
                'options' => [
                    'lg' => __('Large'),
                    'xl' => __('Extra Large'),
                    '2xl' => __('Huge'),
                    '3xl' => __('Massive'),
                ],
            ],
            [
                'name' => 'weight',
                'type' => 'select',
                'label' => __('Font Weight'),
                'default' => '800',
                'tab' => 'style',
                'options' => ['600' => '600', '700' => '700', '800' => '800', '900' => '900'],
            ],
            ['name' => 'color', 'type' => 'color', 'label' => __('Text Color'), 'default' => '#0f172a', 'tab' => 'style'],
            ['name' => 'accent', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'accent2', 'type' => 'color', 'label' => __('Second Gradient Color'), 'default' => '#ec4899', 'tab' => 'style'],
            ['name' => 'hover_change', 'type' => 'toggle', 'label' => __('Color Change on Hover'), 'default' => true, 'tab' => 'style'],
            ['name' => 'hover_color', 'type' => 'color', 'label' => __('Hover Color'), 'default' => '#ec4899', 'tab' => 'style'],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animate on Scroll'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'padding_y',
                'type' => 'range',
                'label' => __('Vertical Padding'),
                'default' => 40,
                'min' => 0,
                'max' => 120,
                'step' => 4,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $before = trim((string) ($settings['text_before'] ?? ''));
        $after = trim((string) ($settings['text_after'] ?? ''));

        $words = array_values(array_filter(
            array_map('trim', explode('|', (string) ($settings['text_highlight'] ?? ''))),
            fn ($w) => $w !== ''
        ));

        if ($before === '' && $after === '' && empty($words)) {
            return '';
        }

        $effect = empty($words)
            ? 'none'
            : $this->pick($settings['effect'] ?? 'underline', ['underline', 'circle', 'highlight', 'typing', 'gradient', 'letters', 'glow', 'none'], 'underline');

        $direction = $this->pick($settings['direction'] ?? 'left', ['left', 'right', 'both'], 'left');
        $underline = $this->pick($settings['underline_style'] ?? 'pen', array_keys(self::UNDERLINES), 'pen');

        $parts = [];
        if ($before !== '') {
            $parts[] = ['type' => 'text', 'text' => $before];
        }
        if (!empty($words)) {
            $parts[] = ['type' => 'word'];
        }
        if ($after !== '') {
            $parts[] = ['type' => 'text', 'text' => $after];
        }

        $ghost = '';
        foreach ($words as $w) {
            if (mb_strlen($w) > mb_strlen($ghost)) {
                $ghost = $w;
            }
        }

        $o = [
            'tag' => $this->pick($settings['tag'] ?? 'h2', ['h1', 'h2', 'h3', 'h4', 'div'], 'h2'),
            'parts' => $parts,
            'words' => $words,
            'ghost' => $ghost,
            'effect' => $effect,
            'direction' => $direction,
            'origin' => ['left' => 'left center', 'right' => 'right center', 'both' => 'center center'][$direction],
            'paths' => self::UNDERLINES[$underline],
            'circle' => self::CIRCLE,
            'align' => $this->pick($settings['align'] ?? 'center', ['left', 'center', 'right'], 'center'),
            'size' => self::SIZES[$this->pick($settings['size'] ?? 'xl', array_keys(self::SIZES), 'xl')],
            'weight' => $this->pick($settings['weight'] ?? '800', ['600', '700', '800', '900'], '800'),
            'color' => $this->hex($settings['color'] ?? null, '#0f172a'),
            'accent' => $this->hex($settings['accent'] ?? null, '#8b5cf6'),
            'accent2' => $this->hex($settings['accent2'] ?? null, '#ec4899'),
            'hover_color' => $this->hex($settings['hover_color'] ?? null, '#ec4899'),
            'hover' => $this->toBool($settings['hover_change'] ?? null, true),
            'animate' => $this->toBool($settings['animate'] ?? null, true),
            'loop' => $this->toBool($settings['loop'] ?? null, false),
            'replay' => $this->toBool($settings['hover_replay'] ?? null, true),
            'speed' => self::SPEEDS[$this->pick($settings['speed'] ?? 'normal', array_keys(self::SPEEDS), 'normal')],
            'padding' => max(0, min(200, (int) ($settings['padding_y'] ?? 40))),
        ];

        $uid = 'ah_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.animated-headline', compact('o', 'uid'))->render();
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function toBool(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}
