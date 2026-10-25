<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AlertWidget extends BaseWidget
{
    private const TYPE_COLORS = [
        'info'    => '#3b82f6',
        'success' => '#10b981',
        'warning' => '#f59e0b',
        'error'   => '#ef4444',
    ];

    private const TYPE_ICONS = [
        'info'    => 'ph:info',
        'success' => 'ph:check-circle',
        'warning' => 'ph:warning',
        'error'   => 'ph:x-circle',
    ];

    private const STYLES     = ['soft', 'outline', 'filled'];
    private const ANIMATIONS = ['none', 'fade', 'slide', 'zoom', 'shake'];

    public function id(): string
    {
        return 'alert';
    }

    public function name(): string
    {
        return __('Alert / Notification');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Display an animated message with optional auto-hide, dismiss memory and call-to-action button.');
    }

    public function schema(): array
    {
        return [
            // ---- STYLE TAB ----
            [
                'name'    => 'type',
                'type'    => 'select',
                'label'   => __('Default Type'),
                'default' => 'info',
                'tab'     => 'style',
                'options' => [
                    'info'    => __('Info (Blue)'),
                    'success' => __('Success (Green)'),
                    'warning' => __('Warning (Yellow)'),
                    'error'   => __('Error (Red)'),
                ],
            ],
            [
                'name'    => 'custom_color',
                'type'    => 'color',
                'label'   => __('Custom Color (Optional)'),
                'default' => '',
                'tab'     => 'style',
                'help'    => __('Override the default color of the alert.'),
            ],
            [
                'name'    => 'style',
                'type'    => 'select',
                'label'   => __('Design Style'),
                'default' => 'soft',
                'tab'     => 'style',
                'options' => [
                    'soft'    => __('Soft (Light Background)'),
                    'outline' => __('Outline (Border Only)'),
                    'filled'  => __('Filled (Solid Color)'),
                ],
            ],
            [
                'name'    => 'animation',
                'type'    => 'select',
                'label'   => __('Entrance Animation'),
                'default' => 'slide',
                'tab'     => 'style',
                'options' => [
                    'none'  => __('None'),
                    'fade'  => __('Fade'),
                    'slide' => __('Slide Down'),
                    'zoom'  => __('Zoom'),
                    'shake' => __('Shake'),
                ],
            ],

            // ---- CONTENT TAB ----
            [
                'name'    => 'icon',
                'type'    => 'icon',
                'label'   => __('Icon (Empty = auto by type)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_icon',
                'type'    => 'toggle',
                'label'   => __('Show Icon'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'pulse_icon',
                'type'    => 'toggle',
                'label'   => __('Pulse Icon'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title (Optional)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'content',
                'type'    => 'textarea',
                'label'   => __('Message'),
                'default' => __('This is a sample notification message. You can customize it in the widget settings.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'button_text',
                'type'    => 'text',
                'label'   => __('Button Text (Optional)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'button_url',
                'type'    => 'text',
                'label'   => __('Button URL'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Full URL, /relative path or mailto:'),
            ],

            // ---- BEHAVIOUR TAB ----
            [
                'name'    => 'dismissible',
                'type'    => 'toggle',
                'label'   => __('Dismissible (Close Button)'),
                'default' => false,
                'tab'     => 'behaviour',
            ],
            [
                'name'    => 'remember_dismiss',
                'type'    => 'toggle',
                'label'   => __('Remember Dismissal'),
                'default' => false,
                'tab'     => 'behaviour',
                'help'    => __('Stays hidden for returning visitors after they close it.'),
            ],
            [
                'name'    => 'auto_dismiss',
                'type'    => 'number',
                'label'   => __('Auto-hide After (Seconds)'),
                'default' => 0,
                'tab'     => 'behaviour',
                'help'    => __('0 = never hide. Shows a progress bar when enabled.'),
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'alert_' . substr(md5(uniqid('', true)), 0, 8);
        $cfg = $this->prepare($settings);

        return view('rjbuilder.widgets.builtin.alert', compact('uid', 'cfg'))->render();
    }

    /**
     * Normalise and derive every value the view needs.
     * The view stays dumb: it only renders what is passed in.
     */
    protected function prepare(array $s): array
    {
        $type      = array_key_exists($s['type'] ?? '', self::TYPE_COLORS) ? $s['type'] : 'info';
        $style     = in_array($s['style'] ?? '', self::STYLES, true) ? $s['style'] : 'soft';
        $animation = in_array($s['animation'] ?? '', self::ANIMATIONS, true) ? $s['animation'] : 'slide';

        $color = $this->normalizeHex($s['custom_color'] ?? '', self::TYPE_COLORS[$type]);

        $r = hexdec(substr($color, 1, 2));
        $g = hexdec(substr($color, 3, 2));
        $b = hexdec(substr($color, 5, 2));

        // Relative luminance decides whether white or dark text reads better on the solid color
        $luma    = 0.299 * $r + 0.587 * $g + 0.114 * $b;
        $onColor = $luma > 170 ? '#111827' : '#ffffff';

        // Darker shade of the color, used for text on light backgrounds (readable on yellow etc.)
        $strong = sprintf('#%02x%02x%02x', (int) ($r * 0.6), (int) ($g * 0.6), (int) ($b * 0.6));

        $title   = trim((string) ($s['title'] ?? ''));
        $content = trim((string) ($s['content'] ?? ''));

        $buttonUrl = trim((string) ($s['button_url'] ?? ''));
        if ($buttonUrl !== '' && !preg_match('#^(https?://|/|mailto:)#i', $buttonUrl)) {
            $buttonUrl = '';
        }

        $remember = $this->flag($s['remember_dismiss'] ?? false, false);

        return [
            'type'         => $type,
            'style'        => $style,
            'animation'    => $animation,
            'color'        => $color,
            'rgb'          => "$r, $g, $b",
            'strong'       => $strong,
            'on_color'     => $onColor,
            'icon'         => trim((string) ($s['icon'] ?? '')) ?: self::TYPE_ICONS[$type],
            'show_icon'    => $this->flag($s['show_icon'] ?? true, true),
            'pulse_icon'   => $this->flag($s['pulse_icon'] ?? false, false),
            'dismissible'  => $this->flag($s['dismissible'] ?? false, false) || $remember,
            'remember'     => $remember,
            'remember_key' => md5($type . '|' . $title . '|' . $content),
            'auto_dismiss' => max(0, min(60, (int) ($s['auto_dismiss'] ?? 0))),
            'title'        => $title,
            'content'      => $content,
            'button_text'  => trim((string) ($s['button_text'] ?? '')),
            'button_url'   => $buttonUrl,
        ];
    }

    private function normalizeHex(?string $hex, string $fallback): string
    {
        $hex = trim((string) $hex);

        // Expand #abc -> #aabbcc
        if (preg_match('/^#?([0-9a-f])([0-9a-f])([0-9a-f])$/i', $hex, $m)) {
            $hex = '#' . $m[1] . $m[1] . $m[2] . $m[2] . $m[3] . $m[3];
        }

        if (preg_match('/^#?([0-9a-f]{6})$/i', $hex, $m)) {
            return '#' . strtolower($m[1]);
        }

        return $fallback;
    }

    private function flag(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }
}
