<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class InteractiveMapWidget extends BaseWidget
{
    private const MAX_LOCATIONS = 5;

    private const STYLES = ['light', 'dark', 'voyager', 'streets', 'satellite'];

    private const HEIGHTS = [
        'h-[300px]' => '300px',
        'h-[400px]' => '400px',
        'h-[500px]' => '500px',
        'h-[700px]' => '700px',
        'h-[80vh]' => 'min(80vh, 860px)',
    ];

    private const RADII = [
        'none' => 0,
        'md' => 16,
        'lg' => 24,
        'xl' => 32,
    ];

    public function id(): string
    {
        return 'interactive-map';
    }

    public function name(): string
    {
        return __('Interactive Map');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
    }

    public function category(): string
    {
        return 'advanced';
    }

    public function description(): string
    {
        return __('An OpenStreetMap-based interactive map with up to 5 locations, animated markers, an info card, style switcher and directions.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        $fields = [
            [
                'name' => 'address',
                'type' => 'text',
                'label' => __('Location Address'),
                'default' => 'Baku, Azerbaijan',
                'tab' => 'content',
                'help' => __('Shown on the info card. The map position is set by the coordinates below.'),
            ],
            [
                'name' => 'latitude',
                'type' => 'text',
                'label' => __('Latitude'),
                'default' => '40.4093',
                'tab' => 'content',
                'help' => __('Decimal degrees, e.g. 40.4093'),
            ],
            [
                'name' => 'longitude',
                'type' => 'text',
                'label' => __('Longitude'),
                'default' => '49.8671',
                'tab' => 'content',
                'help' => __('Decimal degrees, e.g. 49.8671'),
            ],
            [
                'name' => 'popup_title',
                'type' => 'text',
                'label' => __('Popup Title'),
                'default' => __('Our Location'),
                'tab' => 'content',
            ],
            [
                'name' => 'popup_text',
                'type' => 'textarea',
                'label' => __('Popup Text'),
                'default' => __('Visit us at our main office. We are open Monday to Friday, 9am - 6pm.'),
                'tab' => 'content',
            ],
            ['name' => 'phone', 'type' => 'text', 'label' => __('Phone'), 'default' => '', 'tab' => 'content'],
            ['name' => 'hours', 'type' => 'textarea', 'label' => __('Working Hours'), 'default' => '', 'tab' => 'content'],
        ];

        for ($i = 2; $i <= self::MAX_LOCATIONS; $i++) {
            $fields[] = ['name' => "loc{$i}_title", 'type' => 'text', 'label' => __('Location :n - Title', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "loc{$i}_lat", 'type' => 'text', 'label' => __('Location :n - Latitude', ['n' => $i]), 'default' => '', 'tab' => 'content', 'help' => __('Leave empty to hide this location.')];
            $fields[] = ['name' => "loc{$i}_lng", 'type' => 'text', 'label' => __('Location :n - Longitude', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "loc{$i}_address", 'type' => 'text', 'label' => __('Location :n - Address', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "loc{$i}_text", 'type' => 'textarea', 'label' => __('Location :n - Text', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "loc{$i}_phone", 'type' => 'text', 'label' => __('Location :n - Phone', ['n' => $i]), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "loc{$i}_hours", 'type' => 'textarea', 'label' => __('Location :n - Working Hours', ['n' => $i]), 'default' => '', 'tab' => 'content'];
        }

        return array_merge($fields, [
            [
                'name' => 'zoom',
                'type' => 'range',
                'label' => __('Zoom Level'),
                'default' => 13,
                'min' => 1,
                'max' => 19,
                'tab' => 'style',
            ],
            [
                'name' => 'map_style',
                'type' => 'select',
                'label' => __('Map Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light (Minimal)'),
                    'dark' => __('Dark Mode'),
                    'voyager' => __('Colorful (Voyager)'),
                    'streets' => __('Standard Streets'),
                    'satellite' => __('Satellite'),
                ],
            ],
            [
                'name' => 'marker_icon',
                'type' => 'icon',
                'label' => __('Marker Icon'),
                'default' => 'ph:map-pin',
                'tab' => 'style',
            ],
            [
                'name' => 'marker_color',
                'type' => 'color',
                'label' => __('Marker Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'h-[500px]',
                'tab' => 'style',
                'options' => [
                    'h-[300px]' => __('Small (300px)'),
                    'h-[400px]' => __('Compact (400px)'),
                    'h-[500px]' => __('Medium (500px)'),
                    'h-[700px]' => __('Large (700px)'),
                    'h-[80vh]' => __('Tall (80% of screen)'),
                ],
            ],
            [
                'name' => 'radius',
                'type' => 'select',
                'label' => __('Corner Radius'),
                'default' => 'lg',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                    'xl' => __('Extra large'),
                ],
            ],
            ['name' => 'shadow', 'type' => 'select', 'label' => __('Drop Shadow'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_card', 'type' => 'select', 'label' => __('Show Info Card'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'card_position',
                'type' => 'select',
                'label' => __('Info Card Position'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'right' => __('Right'),
                ],
            ],
            ['name' => 'show_directions', 'type' => 'select', 'label' => __('Show "Get directions" Button'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_switcher', 'type' => 'select', 'label' => __('Show Map Style Switcher'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_controls', 'type' => 'select', 'label' => __('Show Map Controls'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'intro', 'type' => 'select', 'label' => __('Fly-in Animation'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'scroll_guard', 'type' => 'select', 'label' => __('Require Ctrl + Scroll to Zoom'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
        ]);
    }

    public function render(array $settings): string
    {
        $style = $this->pick($settings['map_style'] ?? 'light', self::STYLES, 'light');
        $zoom = max(1, min(19, (int) ($settings['zoom'] ?? 13)));
        $color = $this->color($settings['marker_color'] ?? null, '#8b5cf6');
        $heightKey = (string) ($settings['height'] ?? 'h-[500px]');
        $radius = $this->pick($settings['radius'] ?? 'lg', array_keys(self::RADII), 'lg');

        $locations = [];
        for ($i = 1; $i <= self::MAX_LOCATIONS; $i++) {
            $loc = $this->location($settings, $i);

            if ($loc !== null) {
                $locations[] = $loc;
            }
        }

        $icon = trim((string) ($settings['marker_icon'] ?? ''));
        if (!preg_match('/^[a-z0-9:_\-]{1,64}$/i', $icon)) {
            $icon = 'ph:map-pin';
        }

        $labels = [
            'light' => __('Light'),
            'dark' => __('Dark'),
            'voyager' => __('Colorful'),
            'streets' => __('Streets'),
            'satellite' => __('Satellite'),
        ];

        $styleKeys = array_slice(array_values(array_unique(array_merge([$style], ['light', 'dark', 'satellite']))), 0, 4);
        $styles = array_map(fn ($k) => ['key' => $k, 'label' => $labels[$k]], $styleKeys);

        $showCard = $this->flag($settings['show_card'] ?? null, true);

        $cfg = [
            'locations' => $locations,
            'zoom' => $zoom,
            'style' => $style,
            'showCard' => $showCard,
            'cardPos' => $this->pick($settings['card_position'] ?? 'left', ['left', 'right'], 'left'),
            'directions' => $this->flag($settings['show_directions'] ?? null, true),
            'intro' => $this->flag($settings['intro'] ?? null, true),
            'guard' => $this->flag($settings['scroll_guard'] ?? null, true),
            'strings' => [
                'zoomIn' => __('Zoom in'),
                'zoomOut' => __('Zoom out'),
                'recenter' => __('Show all locations'),
                'locate' => __('Show my location'),
                'fs' => __('Fullscreen'),
                'exitFs' => __('Exit fullscreen'),
                'location' => __('Location'),
                'guardKey' => __('Use :key + scroll to zoom the map'),
                'twoFingers' => __('Use two fingers to move the map'),
                'locateFail' => __('Could not get your location'),
                'away' => __(':distance away'),
                'collapse' => __('Hide details'),
                'expand' => __('Show details'),
            ],
        ];

        $first = $locations[0];
        $iconHtml = function_exists('rj_icon') ? (string) rj_icon($icon, 'rjm-icon') : '';

        $opts = [
            'height' => self::HEIGHTS[$heightKey] ?? self::HEIGHTS['h-[500px]'],
            'radius_px' => self::RADII[$radius],
            'shadow' => $this->flag($settings['shadow'] ?? null, true),
            'theme' => in_array($style, ['dark', 'satellite'], true) ? 'dark' : 'light',
            'style' => $style,
            'accent' => $color,
            'accent_rgb' => $this->rgb($color),
            'accent_fg' => $this->contrast($color),
            'show_card' => $showCard,
            'many' => count($locations) > 1,
            'card_pos' => $cfg['cardPos'],
            'directions' => $cfg['directions'],
            'show_switcher' => $this->flag($settings['show_switcher'] ?? null, true),
            'show_controls' => $this->flag($settings['show_controls'] ?? null, true),
            'styles' => $styles,
            'icon_html' => $iconHtml,
            'first' => $first,
            'config_json' => json_encode($cfg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ];

        $uid = 'rjm_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.interactive-map', [
            'o' => $opts,
            'uid' => $uid,
        ])->render();
    }

    private function location(array $s, int $i): ?array
    {
        if ($i === 1) {
            $lat = $this->coord($s['latitude'] ?? null, 90);
            $lng = $this->coord($s['longitude'] ?? null, 180);

            if ($lat === null || $lng === null) {
                $lat = 40.4093;
                $lng = 49.8671;
            }

            $keys = ['title' => 'popup_title', 'text' => 'popup_text', 'address' => 'address', 'phone' => 'phone', 'hours' => 'hours'];
        } else {
            $lat = $this->coord($s["loc{$i}_lat"] ?? null, 90);
            $lng = $this->coord($s["loc{$i}_lng"] ?? null, 180);

            if ($lat === null || $lng === null) {
                return null;
            }

            $keys = ['title' => "loc{$i}_title", 'text' => "loc{$i}_text", 'address' => "loc{$i}_address", 'phone' => "loc{$i}_phone", 'hours' => "loc{$i}_hours"];
        }

        $phone = $this->text($s[$keys['phone']] ?? '', 40);

        return [
            'title' => $this->text($s[$keys['title']] ?? '', 120),
            'text' => $this->text($s[$keys['text']] ?? '', 600),
            'address' => $this->text($s[$keys['address']] ?? '', 200),
            'phone' => $phone,
            'phone_href' => preg_replace('/[^0-9+]/', '', $phone),
            'hours' => $this->text($s[$keys['hours']] ?? '', 300),
            'lat' => $lat,
            'lng' => $lng,
        ];
    }

    private function coord(mixed $value, int $limit): ?float
    {
        $v = str_replace(',', '.', trim((string) $value));

        if (!preg_match('/^-?\d{1,3}(?:\.\d+)?$/', $v)) {
            return null;
        }

        $f = (float) $v;

        return ($f >= -$limit && $f <= $limit) ? round($f, 6) : null;
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim((string) $value), 0, $max);
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

    private function contrast(string $hex): string
    {
        $h = ltrim($hex, '#');

        if (strlen($h) <= 4) {
            $h = preg_replace('/(.)/', '$1$1', $h);
        }

        $h = substr($h, 0, 6);
        $luma = 0.299 * hexdec(substr($h, 0, 2)) + 0.587 * hexdec(substr($h, 2, 2)) + 0.114 * hexdec(substr($h, 4, 2));

        return $luma > 170 ? '#111827' : '#ffffff';
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
