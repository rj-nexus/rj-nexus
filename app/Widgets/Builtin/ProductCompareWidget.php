<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ProductCompareWidget extends BaseWidget
{
    private const MAX_ROWS = 40;

    public function id(): string
    {
        return 'product-compare';
    }

    public function name(): string
    {
        return __('Product Comparison');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18M9 3v18M15 3v18"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Compare 2 to 4 products side by side with images, prices and a feature table. Animated, glass style, mobile friendly.');
    }

    public function schema(): array
    {
        $fields = [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Compare Products'), 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => __('Find the best choice for you'), 'tab' => 'content'],
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Products'),
                'default' => '3',
                'tab' => 'content',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'help' => __('Minimum 2, maximum 4. Products beyond this number are ignored.'),
            ],
        ];

        $defaults = ['Product A', 'Product B', 'Product C', 'Product D'];

        for ($i = 1; $i <= 4; $i++) {
            $fields[] = ['name' => "p{$i}_name", 'type' => 'text', 'label' => __('Product') . " {$i}: " . __('Name'), 'default' => $defaults[$i - 1], 'tab' => 'content'];
            $fields[] = ['name' => "p{$i}_image", 'type' => 'media', 'label' => __('Product') . " {$i}: " . __('Image'), 'default' => '', 'tab' => 'content'];
            $fields[] = ['name' => "p{$i}_price", 'type' => 'text', 'label' => __('Product') . " {$i}: " . __('Price'), 'default' => '', 'tab' => 'content', 'placeholder' => '$499'];
            $fields[] = ['name' => "p{$i}_url", 'type' => 'text', 'label' => __('Product') . " {$i}: " . __('Link URL'), 'default' => '', 'tab' => 'content'];
        }

        return array_merge($fields, [
            [
                'name' => 'rows',
                'type' => 'textarea',
                'label' => __('Comparison Rows'),
                'default' => "# Performance\nProcessor | Fast | Faster | Fastest | Fast\nBattery | 18h | 22h | 30h | 20h\n# Features\nWireless charging | ✓ | ✓ | ✓ | ✗\nWaterproof | ✗ | ✓ | ✓ | ✓\nWarranty | 1 year | 2 years | 2 years | 1 year",
                'tab' => 'content',
                'help' => __('One row per line: Feature | value 1 | value 2 | ... Start a line with # for a section title. Use ✓ or yes for a check, ✗ or no for a cross, - for empty.'),
            ],
            [
                'name' => 'highlight',
                'type' => 'select',
                'label' => __('Highlighted Product'),
                'default' => '0',
                'tab' => 'content',
                'options' => ['0' => __('None'), '1' => '1', '2' => '2', '3' => '3', '4' => '4'],
            ],
            ['name' => 'badge_text', 'type' => 'text', 'label' => __('Badge Text'), 'default' => __('Best choice'), 'tab' => 'content'],
            ['name' => 'cta_label', 'type' => 'text', 'label' => __('Button Text'), 'default' => __('View'), 'tab' => 'content'],
            ['name' => 'new_tab', 'type' => 'toggle', 'label' => __('Open Links in New Tab'), 'default' => true, 'tab' => 'content'],
            ['name' => 'diff_toggle', 'type' => 'toggle', 'label' => __('Show "Only Differences" Button'), 'default' => true, 'tab' => 'content'],

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
        $total = (int) $this->pick($settings['count'] ?? '3', ['2', '3', '4'], '3');
        $newTab = $this->flag($settings['new_tab'] ?? null, true);

        $products = [];
        $keep = [];

        for ($i = 1; $i <= $total; $i++) {
            $name = $this->text($settings["p{$i}_name"] ?? '', 60);
            $img = $this->imageUrl($settings["p{$i}_image"] ?? '');

            if ($name === '' && $img === '') {
                continue; // boş məhsul sütunu göstərilmir
            }

            $keep[] = $i - 1;
            $products[] = [
                'orig' => $i,
                'name' => $name !== '' ? $name : __('Product') . ' ' . $i,
                'img' => $img,
                'initial' => mb_strtoupper(mb_substr($name !== '' ? $name : 'P', 0, 1)),
                'price' => $this->text($settings["p{$i}_price"] ?? '', 30),
                'url' => ($u = trim((string) ($settings["p{$i}_url"] ?? ''))) !== '' ? $this->safeUrl($u) : '',
            ];
        }

        if (count($products) < 2) {
            return '';
        }

        $hl = (int) $this->pick($settings['highlight'] ?? '0', ['0', '1', '2', '3', '4'], '0');
        $hlPos = -1;
        foreach ($products as $pos => $p) {
            if ($p['orig'] === $hl) {
                $hlPos = $pos;
            }
        }

        $rows = $this->parseRows((string) ($settings['rows'] ?? ''), $keep);

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 100),
            'subtitle' => $this->text($settings['subtitle'] ?? '', 160),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'diff' => $this->flag($settings['diff_toggle'] ?? null, true),
            'badge' => $this->text($settings['badge_text'] ?? '', 30),
            'cta' => $this->text($settings['cta_label'] ?? '', 30),
            'blank' => $newTab,
            'hl' => $hlPos,
        ];

        return view('rjbuilder.widgets.builtin.product-compare', [
            'o' => $opts,
            'uid' => 'pc_' . substr(md5(uniqid('', true)), 0, 8),
            'products' => $products,
            'rows' => $rows,
            'n' => count($products),
            'labels' => [
                'diff' => __('Show only differences'),
                'all' => __('Show all'),
                'yes' => __('Yes'),
                'no' => __('No'),
            ],
        ])->render();
    }

    /**
     * "Xüsusiyyət | dəyər1 | dəyər2" sətirlərini strukturlaşdırır.
     * "# Başlıq" — bölmə başlığı.
     */
    private function parseRows(string $raw, array $keep): array
    {
        $yes = ['✓', '✔', '✅', 'yes', 'true', '+', 'bəli', 'beli', 'да'];
        $no = ['✗', '✘', '❌', '×', 'x', 'no', 'false', 'xeyr', 'yox', 'нет'];

        $out = [];

        foreach (preg_split('/\r\n|\r|\n/', $raw) ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (count($out) >= self::MAX_ROWS) {
                break;
            }

            if ($line[0] === '#') {
                $label = $this->text(ltrim($line, "# \t"), 80);
                if ($label !== '') {
                    $out[] = ['type' => 'group', 'label' => $label];
                }
                continue;
            }

            $parts = array_map('trim', explode('|', $line));
            $label = $this->text($parts[0] ?? '', 80);

            if ($label === '') {
                continue;
            }

            $cells = [];
            $sig = [];

            foreach ($keep as $idx) {
                $v = $this->text($parts[$idx + 1] ?? '', 80);
                $low = mb_strtolower($v);

                if ($v === '' || $v === '-' || $v === '—' || $v === '–') {
                    $cell = ['kind' => 'none', 'text' => ''];
                } elseif (in_array($low, $yes, true)) {
                    $cell = ['kind' => 'yes', 'text' => ''];
                } elseif (in_array($low, $no, true)) {
                    $cell = ['kind' => 'no', 'text' => ''];
                } else {
                    $cell = ['kind' => 'text', 'text' => $v];
                }

                $cells[] = $cell;
                $sig[] = $cell['kind'] . ':' . mb_strtolower($cell['text']);
            }

            $out[] = [
                'type' => 'row',
                'label' => $label,
                'cells' => $cells,
                'same' => count(array_unique($sig)) === 1,
            ];
        }

        return $out;
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function imageUrl(mixed $value): string
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
        if (preg_match('#^data:image/(png|jpe?g|gif|webp|avif|svg\+xml)[;,]#i', $value)) { return $value; }

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
