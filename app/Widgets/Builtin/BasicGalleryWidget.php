<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class Google360Widget extends BaseWidget
{
    private const RATIOS = [
        'aspect-video' => '16 / 9',
        'aspect-square' => '1 / 1',
        'aspect-[4/3]' => '4 / 3',
        'aspect-[21/9]' => '21 / 9',
    ];

    private const FIXED = [
        'h-[400px]' => '400px',
        'h-[500px]' => '500px',
        'h-[600px]' => '600px',
        'h-[80vh]' => 'min(80vh, 860px)',
    ];

    private const RADII = [
        'rounded-none' => 0,
        'rounded-xl' => 16,
        'rounded-3xl' => 28,
        'rounded-full' => 56,
    ];

    private const SHADOWS = [
        'shadow-none' => 'none',
        'shadow-md' => '0 4px 6px -1px rgba(15,23,42,.1), 0 2px 4px -2px rgba(15,23,42,.1)',
        'shadow-xl' => '0 20px 25px -5px rgba(15,23,42,.14), 0 8px 10px -6px rgba(15,23,42,.1)',
        'shadow-2xl' => '0 30px 60px -12px rgba(15,23,42,.35)',
    ];

    private const WIDTHS = [
        'md' => '900px',
        'lg' => '1152px',
        'full' => '100%',
    ];

    private const FRAME_WIDTHS = [
        'thin' => 2,
        'md' => 4,
        'thick' => 8,
    ];

    public function id(): string
    {
        return 'google-360';
    }

    public function name(): string
    {
        return __('Google 360 Tour');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M3 12h2m14 0h2M5.6 5.6l1.4 1.4m10 10l1.4 1.4m0-12.8l-1.4 1.4m-10 10l-1.4 1.4"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('Embed a Google 360-degree virtual tour or Street View in a custom frame, with click-to-explore or Shift-to-zoom modes and fullscreen.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Section Title (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'subtitle',
                'type' => 'text',
                'label' => __('Section Subtitle (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'iframe_code',
                'type' => 'textarea',
                'label' => __('Google Maps / 360 Iframe Code'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => '<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" ...></iframe>',
                'help' => __('Paste the full iframe code. Width, height and style are removed automatically and the tour is fitted to the widget size.'),
            ],
            [
                'name' => 'badge',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => '360°',
                'tab' => 'content',
                'help' => __('Small label in the corner. Leave empty to hide.'),
            ],
            [
                'name' => 'interaction',
                'type' => 'select',
                'label' => __('Interaction Mode'),
                'default' => 'click',
                'tab' => 'content',
                'options' => [
                    'click' => __('Click / tap to explore (page scrolls normally until activated)'),
                    'shift' => __('Hold Shift to zoom & move (desktop)'),
                    'free' => __('Always interactive'),
                ],
            ],

            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'embed',
                'tab' => 'style',
                'options' => [
                    'embed' => __('From embed code (original proportions)'),
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-square' => __('Square (1:1)'),
                    'aspect-[4/3]' => __('Classic (4:3)'),
                    'aspect-[21/9]' => __('Cinematic (21:9)'),
                    'h-[400px]' => __('Fixed (400px)'),
                    'h-[500px]' => __('Fixed (500px)'),
                    'h-[600px]' => __('Fixed (600px)'),
                    'h-[80vh]' => __('Tall (80% of screen)'),
                ],
            ],
            [
                'name' => 'width',
                'type' => 'select',
                'label' => __('Max Width'),
                'default' => 'lg',
                'tab' => 'style',
                'options' => [
                    'md' => __('Medium (900px)'),
                    'lg' => __('Large (1152px)'),
                    'full' => __('Full width'),
                ],
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-3xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-xl' => __('Medium'),
                    'rounded-3xl' => __('Large'),
                    'rounded-full' => __('Full Round (Pill)'),
                ],
            ],
            [
                'name' => 'frame_style',
                'type' => 'select',
                'label' => __('Frame Style'),
                'default' => 'gradient',
                'tab' => 'style',
                'options' => [
                    'gradient' => __('Animated gradient'),
                    'card' => __('Card (white mat + colored border)'),
                    'line' => __('Line (colored border only)'),
                    'none' => __('None'),
                ],
            ],
            [
                'name' => 'frame_width',
                'type' => 'select',
                'label' => __('Border Thickness'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'thin' => __('Thin (2px)'),
                    'md' => __('Medium (4px)'),
                    'thick' => __('Thick (8px)'),
                ],
            ],
            [
                'name' => 'overlay_color',
                'type' => 'color',
                'label' => __('Border Color'),
                'default' => '#6366f1',
                'tab' => 'style',
            ],
            [
                'name' => 'fs_bg',
                'type' => 'color',
                'label' => __('Fullscreen Background'),
                'default' => '#0b1220',
                'tab' => 'style',
                'help' => __('Color around the framed tour when it is shown fullscreen.'),
            ],
            [
                'name' => 'box_shadow',
                'type' => 'select',
                'label' => __('Shadow'),
                'default' => 'shadow-xl',
                'tab' => 'style',
                'options' => [
                    'shadow-none' => __('None'),
                    'shadow-md' => __('Small'),
                    'shadow-xl' => __('Medium'),
                    'shadow-2xl' => __('Large'),
                ],
            ],
            [
                'name' => 'hover_effect',
                'type' => 'toggle',
                'label' => __('Lift & Glow on Hover'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'entrance',
                'type' => 'toggle',
                'label' => __('Reveal Animation on Scroll'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'show_fullscreen',
                'type' => 'toggle',
                'label' => __('Show Fullscreen Button'),
                'default' => true,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $code = trim((string) ($settings['iframe_code'] ?? ''));

        if ($code === '') {
            return '';
        }

        $embed = $this->parseEmbed($code);

        if ($embed['url'] === '') {
            return '<div style="padding:24px;text-align:center;color:#64748b;background:#f1f5f9;border-radius:12px;font-size:.9rem;">'
                . e(__('Could not find a valid https embed link in the pasted code.'))
                . '</div>';
        }

        $title = mb_substr(trim((string) ($settings['title'] ?? '')), 0, 160);
        $subtitle = mb_substr(trim((string) ($settings['subtitle'] ?? '')), 0, 160);

        $heightKey = (string) ($settings['height'] ?? 'embed');

        if ($heightKey === 'embed') {
            $ratio = $embed['ratio'] ?? (4 / 3);
            $stageCss = 'aspect-ratio:' . round($ratio, 4) . ';min-height:240px;max-height:min(78vh,760px);';
        } elseif (isset(self::RATIOS[$heightKey])) {
            $stageCss = 'aspect-ratio:' . self::RATIOS[$heightKey] . ';min-height:240px;max-height:min(78vh,760px);';
        } elseif (isset(self::FIXED[$heightKey])) {
            $stageCss = 'height:' . self::FIXED[$heightKey] . ';';
        } else {
            $stageCss = 'aspect-ratio:16 / 9;min-height:240px;max-height:min(78vh,760px);';
        }

        $border = $this->color($settings['overlay_color'] ?? null, '') ?: '#6366f1';
        $mode = $this->pick($settings['interaction'] ?? 'click', ['click', 'shift', 'free'], 'click');
        $showFs = $this->flag($settings['show_fullscreen'] ?? null, true);
        $badge = mb_substr(trim((string) ($settings['badge'] ?? '360°')), 0, 24);

        $cfg = [
            'mode' => $mode,
            'strings' => [
                'click' => __('Click to explore'),
                'tap' => __('Tap to explore'),
                'shift' => __('Hold Shift to zoom & move'),
                'activeClick' => __('Interactive'),
                'activeShift' => __('Zoom & move on — release Shift to scroll the page'),
                'enterFs' => __('Fullscreen'),
                'exitFs' => __('Exit fullscreen'),
            ],
        ];

        $opts = [
            'stage_css' => $stageCss,
            'shell_w' => self::WIDTHS[$this->pick($settings['width'] ?? 'lg', array_keys(self::WIDTHS), 'lg')],
            'r_px' => self::RADII[$this->pick($settings['border_radius'] ?? 'rounded-3xl', array_keys(self::RADII), 'rounded-3xl')],
            'fw_px' => self::FRAME_WIDTHS[$this->pick($settings['frame_width'] ?? 'md', array_keys(self::FRAME_WIDTHS), 'md')],
            'frame' => $this->pick($settings['frame_style'] ?? 'gradient', ['gradient', 'card', 'line', 'none'], 'gradient'),
            'bc' => $border,
            'bcl' => $this->mix($border, '#ffffff', 0.55),
            'bcd' => $this->mix($border, '#000000', 0.35),
            'brgb' => $this->rgb($border),
            'fs_bg' => $this->color($settings['fs_bg'] ?? null, '') ?: '#0b1220',
            'shadow' => self::SHADOWS[$this->pick($settings['box_shadow'] ?? 'shadow-xl', array_keys(self::SHADOWS), 'shadow-xl')],
            'hover' => $this->flag($settings['hover_effect'] ?? null, true),
            'entrance' => $this->flag($settings['entrance'] ?? null, true),
            'show_fs' => $showFs,
            'mode' => $mode,
            'badge' => $badge,
            'config_json' => json_encode($cfg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ];

        $uid = 'rjg_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.google-360', [
            'o' => $opts,
            't' => ['title' => $title, 'subtitle' => $subtitle],
            'iframeUrl' => $embed['url'],
            'uid' => $uid,
        ])->render();
    }

    /**
     * Extracts the src (and original proportions) from a pasted <iframe> or a plain URL.
     * Width, height and inline styles of the pasted code are intentionally discarded.
     */
    private function parseEmbed(string $code): array
    {
        $result = ['url' => '', 'ratio' => null];
        $src = '';
        $w = null;
        $h = null;

        if (preg_match('/<iframe\b[^>]*>/is', $code, $tag)) {
            $tagHtml = $tag[0];

            if (preg_match('/(?<![\w-])src\s*=\s*(["\'])(.*?)\1/is', $tagHtml, $m)) {
                $src = $m[2];
            }
            if (preg_match('/(?<![\w-])width\s*=\s*(["\']?)(\d{2,5})\1/i', $tagHtml, $m)) {
                $w = (int) $m[2];
            }
            if (preg_match('/(?<![\w-])height\s*=\s*(["\']?)(\d{2,5})\1/i', $tagHtml, $m)) {
                $h = (int) $m[2];
            }
        } else {
            $src = $code;
        }

        $src = trim(html_entity_decode($src, ENT_QUOTES | ENT_HTML5));

        if (str_starts_with($src, '//')) {
            $src = 'https:' . $src;
        }

        if (!preg_match('#^https://[^\s"\'<>]+$#i', $src)) {
            return $result;
        }

        $result['url'] = $src;

        if ($w && $h) {
            $result['ratio'] = max(0.6, min(3.2, $w / $h));
        }

        return $result;
    }

    private function color(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }

    private function rgbArray(string $hex): array
    {
        $h = ltrim($hex, '#');

        if (strlen($h) <= 4) {
            $h = preg_replace('/(.)/', '$1$1', $h);
        }

        $h = substr($h, 0, 6);

        return [hexdec(substr($h, 0, 2)), hexdec(substr($h, 2, 2)), hexdec(substr($h, 4, 2))];
    }

    private function rgb(string $hex): string
    {
        return implode(',', $this->rgbArray($hex));
    }

    private function mix(string $hex, string $with, float $t): string
    {
        $a = $this->rgbArray($hex);
        $b = $this->rgbArray($with);

        $out = array_map(fn ($x, $y) => (int) round($x + ($y - $x) * $t), $a, $b);

        return sprintf('#%02x%02x%02x', $out[0], $out[1], $out[2]);
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
