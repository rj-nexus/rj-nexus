<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ButtonWidget extends BaseWidget
{
    private const SIZES = [
        'sm' => ['py' => '8px', 'px' => '16px', 'fs' => '0.75rem', 'gap' => '8px'],
        'md' => ['py' => '12px', 'px' => '24px', 'fs' => '0.875rem', 'gap' => '10px'],
        'lg' => ['py' => '16px', 'px' => '32px', 'fs' => '1rem', 'gap' => '12px'],
        'xl' => ['py' => '20px', 'px' => '40px', 'fs' => '1.125rem', 'gap' => '14px'],
    ];

    private const RADII = [
        'rounded-none' => '0px',
        'rounded-md' => '8px',
        'rounded-xl' => '14px',
        'rounded-2xl' => '22px',
        'rounded-full' => '999px',
    ];

    private const ENTRANCES = [
        'rise' => 'rjb-rise',
        'fade' => 'rjb-fade',
        'zoom' => 'rjb-zoom',
        'blur' => 'rjb-blur',
    ];

    public function id(): string
    {
        return 'button';
    }

    public function name(): string
    {
        return __('Button');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>';
    }

    public function category(): string
    {
        return 'basic';
    }

    public function description(): string
    {
        return __('Create highly customizable buttons with icons, animations, and various styles.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'text',
                'type' => 'text',
                'label' => __('Button Text'),
                'default' => __('Click Here'),
                'tab' => 'content',
            ],
            [
                'name' => 'url',
                'type' => 'text',
                'label' => __('Button URL'),
                'default' => '#',
                'tab' => 'content',
            ],
            [
                'name' => 'target',
                'type' => 'select',
                'label' => __('Target'),
                'default' => '_self',
                'tab' => 'content',
                'options' => [
                    '_self' => __('Same Window'),
                    '_blank' => __('New Window'),
                ],
            ],
            [
                'name' => 'aria_label',
                'type' => 'text',
                'label' => __('Accessible Label (optional)'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Useful for icon-only buttons. Read by screen readers instead of the text.'),
            ],
            [
                'name' => 'icon',
                'type' => 'icon',
                'label' => __('Icon'),
                'default' => 'ph:arrow-right',
                'tab' => 'content',
            ],
            [
                'name' => 'icon_position',
                'type' => 'select',
                'label' => __('Icon Position'),
                'default' => 'right',
                'tab' => 'content',
                'options' => [
                    'left' => __('Left'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'icon_style',
                'type' => 'select',
                'label' => __('Icon Style'),
                'default' => 'plain',
                'tab' => 'content',
                'options' => [
                    'plain' => __('Plain'),
                    'bubble' => __('In a circle'),
                ],
            ],

            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Button Style'),
                'default' => 'solid',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid'),
                    'outline' => __('Outline'),
                    'ghost' => __('Ghost (Transparent)'),
                    'gradient' => __('Gradient'),
                    'soft' => __('Soft (Tinted)'),
                    'neo' => __('3D (Pressable)'),
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
                    'xl' => __('Extra Large'),
                ],
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-md' => __('Small'),
                    'rounded-xl' => __('Medium'),
                    'rounded-2xl' => __('Large'),
                    'rounded-full' => __('Full (Pill)'),
                ],
            ],
            ['name' => 'uppercase', 'type' => 'select', 'label' => __('Uppercase Text'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'shadow',
                'type' => 'select',
                'label' => __('Shadow'),
                'default' => 'none',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'soft' => __('Soft'),
                    'strong' => __('Strong'),
                ],
            ],
            [
                'name' => 'bg_color',
                'type' => 'color',
                'label' => __('Background Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'text_color',
                'type' => 'color',
                'label' => __('Text & Icon Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'hover_bg_color',
                'type' => 'color',
                'label' => __('Hover Background Color'),
                'default' => '#7c3aed',
                'tab' => 'style',
            ],
            [
                'name' => 'hover_text_color',
                'type' => 'color',
                'label' => __('Hover Text Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'animation',
                'type' => 'select',
                'label' => __('Hover Animation'),
                'default' => 'hover-lift',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'hover-lift' => __('Lift Up'),
                    'hover-glow' => __('Glow (Shadow)'),
                    'hover-shine' => __('Shine Effect'),
                    'hover-slide' => __('Icon Slide'),
                    'hover-fill' => __('Fill Sweep'),
                    'hover-magnetic' => __('Magnetic (follows cursor)'),
                ],
            ],
            [
                'name' => 'idle',
                'type' => 'select',
                'label' => __('Attention Animation'),
                'default' => 'none',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'pulse' => __('Pulse ring'),
                    'float' => __('Float'),
                    'shimmer' => __('Shimmer'),
                    'wiggle' => __('Wiggle'),
                ],
            ],
            ['name' => 'ripple', 'type' => 'select', 'label' => __('Click Ripple'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'entrance',
                'type' => 'select',
                'label' => __('Entrance Animation'),
                'default' => 'none',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'rise' => __('Rise'),
                    'fade' => __('Fade'),
                    'zoom' => __('Zoom'),
                    'blur' => __('Blur in'),
                ],
            ],
            [
                'name' => 'full_width',
                'type' => 'toggle',
                'label' => __('Full Width'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $text = mb_substr(trim((string) ($settings['text'] ?? '')), 0, 120);
        $icon = $this->icon_name((string) ($settings['icon'] ?? ''));

        if ($text === '' && $icon === '') {
            $text = __('Button');
        }

        $size = self::SIZES[$this->pick($settings['size'] ?? 'md', array_keys(self::SIZES), 'md')];
        $radius = self::RADII[$this->pick($settings['border_radius'] ?? 'rounded-xl', array_keys(self::RADII), 'rounded-xl')];

        $bg = $this->color($settings['bg_color'] ?? null, '#8b5cf6');
        $fg = $this->color($settings['text_color'] ?? null, '#ffffff');
        $hbg = $this->color($settings['hover_bg_color'] ?? null, '#7c3aed');
        $hfg = $this->color($settings['hover_text_color'] ?? null, '#ffffff');

        $anim = $this->pick($settings['animation'] ?? 'hover-lift', ['none', 'hover-lift', 'hover-glow', 'hover-shine', 'hover-slide', 'hover-fill', 'hover-magnetic'], 'hover-lift');
        $idle = $this->pick($settings['idle'] ?? 'none', ['none', 'pulse', 'float', 'shimmer', 'wiggle'], 'none');
        $ripple = $this->flag($settings['ripple'] ?? null, true);
        $entrance = $this->pick($settings['entrance'] ?? 'none', array_merge(['none'], array_keys(self::ENTRANCES)), 'none');

        $iconHtml = ($icon !== '' && function_exists('rj_icon')) ? (string) rj_icon($icon, 'rjb-svg') : '';

        $opts = [
            'text' => $text,
            'url' => $this->safeUrl((string) ($settings['url'] ?? '#')),
            'blank' => ($settings['target'] ?? '_self') === '_blank',
            'aria' => mb_substr(trim((string) ($settings['aria_label'] ?? '')), 0, 160),
            'icon_html' => $iconHtml,
            'icon_pos' => $this->pick($settings['icon_position'] ?? 'right', ['left', 'right'], 'right'),
            'icon_style' => $this->pick($settings['icon_style'] ?? 'plain', ['plain', 'bubble'], 'plain'),
            'style' => $this->pick($settings['style'] ?? 'solid', ['solid', 'outline', 'ghost', 'gradient', 'soft', 'neo'], 'solid'),
            'py' => $size['py'],
            'px' => $size['px'],
            'fs' => $size['fs'],
            'gap' => $size['gap'],
            'radius' => $radius,
            'upper' => $this->flag($settings['uppercase'] ?? null, false),
            'shadow' => $this->pick($settings['shadow'] ?? 'none', ['none', 'soft', 'strong'], 'none'),
            'bg' => $bg,
            'fg' => $fg,
            'hbg' => $hbg,
            'hfg' => $hfg,
            'brgb' => $this->rgb($bg),
            'hrgb' => $this->rgb($hbg),
            'anim' => $anim,
            'idle' => $idle,
            'ripple' => $ripple,
            'entrance' => $entrance,
            'ent_anim' => self::ENTRANCES[$entrance] ?? 'rjb-fade',
            'full' => $this->flag($settings['full_width'] ?? null, false),
            'justify' => ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'][$this->pick($settings['align'] ?? 'left', ['left', 'center', 'right'], 'left')],
            'needs_js' => $ripple || $anim === 'hover-magnetic' || $entrance !== 'none',
        ];

        $uid = 'rjb_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.button', [
            'o' => $opts,
            'uid' => $uid,
        ])->render();
    }

    private function icon_name(string $icon): string
    {
        $icon = trim($icon);

        return preg_match('/^[\w:.\/\-]{1,100}$/', $icon) ? $icon : '';
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '#';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '#';
        }

        return $url;
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
