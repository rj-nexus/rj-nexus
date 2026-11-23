<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

/**
 * Instagram story tipli video karuseli. Dairə əvəzinə künc-yumrulanmış 6 bucaqlı (hexagon).
 * Şəkil və video media picker ilə seçilir.
 */
class VideoStoriesCarouselWidget extends BaseWidget
{
    private const MAX = 8;

    public function id(): string
    {
        return 'video-stories-carousel';
    }

    public function name(): string
    {
        return __('Video Stories Carousel');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5l8 4.6v9.8l-8 4.6-8-4.6V7.1l8-4.6zM10 9.5v5l4.2-2.5L10 9.5z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Instagram-style video stories in animated hexagon shapes with a full-screen story viewer. Glass style, works on desktop, tablet and mobile.');
    }

    public function schema(): array
    {
        $fields = [
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Stories'),
                'default' => '6',
                'tab' => 'content',
                'options' => ['3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'],
                'help' => __('Stories with neither a cover nor a video are skipped.'),
            ],
        ];

        for ($i = 1; $i <= self::MAX; $i++) {
            $p = __('Story') . " {$i}: ";
            $fields[] = ['name' => "s{$i}_title", 'type' => 'text', 'label' => $p . __('Title'), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_cover", 'type' => 'media', 'label' => $p . __('Cover Image'), 'default' => '', 'tab' => 'content', 'help' => $i === 1 ? __('Shown inside the hexagon. If empty, the first frame of the video is used.') : ''];
            $fields[] = ['name' => "s{$i}_video", 'type' => 'media', 'label' => $p . __('Video'), 'default' => '', 'tab' => 'content', 'help' => $i === 1 ? __('Pick an MP4 or WebM file. If empty, the cover image is shown as the story.') : ''];
            $fields[] = ['name' => "s{$i}_caption", 'type' => 'text', 'label' => $p . __('Caption'), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "s{$i}_url", 'type' => 'text', 'label' => $p . __('Button Link (optional)'), 'default' => '', 'tab' => 'content'];
        }

        return array_merge($fields, [
            ['name' => 'cta_label', 'type' => 'text', 'label' => __('Button Text'), 'default' => __('Learn more'), 'tab' => 'content'],
            ['name' => 'new_tab', 'type' => 'toggle', 'label' => __('Open Links in New Tab'), 'default' => true, 'tab' => 'content'],
            [
                'name' => 'image_duration',
                'type' => 'select',
                'label' => __('Image Story Duration'),
                'default' => '5',
                'tab' => 'content',
                'options' => ['3' => '3 s', '5' => '5 s', '7' => '7 s', '10' => '10 s'],
            ],
            ['name' => 'start_muted', 'type' => 'toggle', 'label' => __('Start Muted'), 'default' => false, 'tab' => 'content'],

            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Hexagon Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => ['sm' => __('Small'), 'md' => __('Medium'), 'lg' => __('Large')],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => ['left' => __('Left'), 'center' => __('Center')],
            ],
            ['name' => 'show_title', 'type' => 'toggle', 'label' => __('Show Titles'), 'default' => true, 'tab' => 'style'],
            ['name' => 'show_arrows', 'type' => 'toggle', 'label' => __('Show Arrows (desktop)'), 'default' => true, 'tab' => 'style'],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'glass',
                'tab' => 'style',
                'options' => ['glass' => __('Glass'), 'glass-dark' => __('Glass (Dark)')],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
        ]);
    }

    public function render(array $settings): string
    {
        $total = (int) $this->pick($settings['count'] ?? '6', ['3', '4', '5', '6', '7', '8'], '6');

        $items = [];

        for ($i = 1; $i <= $total; $i++) {
            $cover = $this->mediaUrl($settings["s{$i}_cover"] ?? '', true);
            $video = $this->mediaUrl($settings["s{$i}_video"] ?? '', false);

            if ($cover === '' && $video === '') {
                continue;
            }

            $url = trim((string) ($settings["s{$i}_url"] ?? ''));

            $items[] = [
                'title' => $this->text($settings["s{$i}_title"] ?? '', 40),
                'cover' => $cover,
                'video' => $video,
                'caption' => $this->text($settings["s{$i}_caption"] ?? '', 200),
                'url' => $url !== '' ? $this->safeUrl($url) : '',
            ];
        }

        if (empty($items)) {
            return '';
        }

        $sizes = ['sm' => 84, 'md' => 104, 'lg' => 128];
        $size = $this->pick($settings['size'] ?? 'md', array_keys($sizes), 'md');

        $opts = [
            'size' => $sizes[$size],
            'align' => $this->pick($settings['align'] ?? 'center', ['left', 'center'], 'center'),
            'titles' => $this->flag($settings['show_title'] ?? null, true),
            'arrows' => $this->flag($settings['show_arrows'] ?? null, true),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'hex' => $this->hexPath(0.2),
        ];

        $labels = [
            'story' => __('Story'),
            'close' => __('Close'),
            'mute' => __('Mute'),
            'unmute' => __('Unmute'),
            'prev' => __('Previous'),
            'next' => __('Next'),
            'scroll_l' => __('Scroll left'),
            'scroll_r' => __('Scroll right'),
        ];

        $payload = [
            'items' => $items,
            'sig' => substr(md5(json_encode(array_map(fn ($x) => [$x['cover'], $x['video']], $items))), 0, 10),
            'cta' => $this->text($settings['cta_label'] ?? '', 30),
            'blank' => $this->flag($settings['new_tab'] ?? null, true),
            'dur' => ((int) $this->pick($settings['image_duration'] ?? '5', ['3', '5', '7', '10'], '5')) * 1000,
            'muted' => $this->flag($settings['start_muted'] ?? null, false),
            'accent' => $opts['accent'],
            'style' => $opts['style'],
            'labels' => $labels,
        ];

        return view('rjbuilder.widgets.builtin.video-stories-carousel', [
            'o' => $opts,
            'uid' => 'vs_' . substr(md5(uniqid('', true)), 0, 8),
            'items' => $items,
            'payload' => $payload,
            'labels' => $labels,
        ])->render();
    }

    /**
     * Künc-yumrulanmış hexagon (objectBoundingBox 0..1). Hər təpədə kvadratik əyri ilə yumrulama.
     */
    private function hexPath(float $t): string
    {
        $v = [[.5, 0], [.933, .25], [.933, .75], [.5, 1], [.067, .75], [.067, .25]];
        $n = count($v);
        $d = '';

        for ($i = 0; $i < $n; $i++) {
            $p = $v[($i + $n - 1) % $n];
            $c = $v[$i];
            $q = $v[($i + 1) % $n];

            $ax = round($c[0] + ($p[0] - $c[0]) * $t, 4);
            $ay = round($c[1] + ($p[1] - $c[1]) * $t, 4);
            $bx = round($c[0] + ($q[0] - $c[0]) * $t, 4);
            $by = round($c[1] + ($q[1] - $c[1]) * $t, 4);

            $d .= ($i === 0 ? 'M' : 'L') . "{$ax} {$ay} Q{$c[0]} {$c[1]} {$bx} {$by} ";
        }

        return $d . 'Z';
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function mediaUrl(mixed $value, bool $allowData): string
    {
        if (is_object($value)) { $value = (array) $value; }

        if (is_array($value)) {
            $found = '';
            foreach (['url', 'src', 'path', 'file', 'original', 'full'] as $key) {
                if (!empty($value[$key]) && is_string($value[$key])) { $found = $value[$key]; break; }
            }
            $value = $found;
        }

        if (!is_string($value)) { return ''; }
        $value = trim($value);
        if ($value === '') { return ''; }

        if (str_starts_with($value, '//')) { $value = request()->getScheme() . ':' . $value; }

        if ($allowData && preg_match('#^data:image/(png|jpe?g|gif|webp|avif|svg\+xml)[;,]#i', $value)) {
            return $value;
        }

        $origin = rtrim(request()->getSchemeAndHttpHost(), '/');

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $value)) {
            if (!preg_match('/^https?:/i', $value)) { return ''; }
            $parts = parse_url($value);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $reqHost = strtolower(request()->getHost());
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
            $local = in_array($host, ['localhost', '127.0.0.1', '::1', '[::1]'], true) || ($appHost !== '' && $host === $appHost);
            if ($host !== '' && $host !== $reqHost && $local) {
                return $origin . ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
            }
            return $value;
        }

        if (str_starts_with($value, '/')) { return $origin . $value; }
        return $origin . '/' . ltrim($value, '/');
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') { return '/'; }
        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '/';
        }
        return $url;
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

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}
