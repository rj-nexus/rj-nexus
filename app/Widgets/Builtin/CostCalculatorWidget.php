<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CostCalculatorWidget extends BaseWidget
{
    public function id(): string
    {
        return 'cost-calculator';
    }

    public function name(): string
    {
        return __('Cost Calculator');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 12h.01M12 12h.01M16 12h.01M8 16h.01M12 16h.01M16 16h.01"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Interactive price calculator. Visitors move sliders, tick options and pick from dropdowns while the total updates live with animations, then send the order.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Calculate your price'), 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => __('Adjust the options and see the estimate instantly.'), 'tab' => 'content'],
            ['name' => 'currency', 'type' => 'text', 'label' => __('Currency Symbol'), 'default' => '$', 'tab' => 'content'],
            [
                'name' => 'currency_position',
                'type' => 'select',
                'label' => __('Currency Position'),
                'default' => 'before',
                'tab' => 'content',
                'options' => ['before' => __('Before the amount'), 'after' => __('After the amount')],
            ],
            [
                'name' => 'decimals',
                'type' => 'select',
                'label' => __('Decimal Places'),
                'default' => '0',
                'tab' => 'content',
                'options' => ['0' => '0', '1' => '1', '2' => '2'],
            ],
            ['name' => 'base_label', 'type' => 'text', 'label' => __('Base Price Label'), 'default' => __('Base price'), 'tab' => 'content'],
            ['name' => 'base_price', 'type' => 'text', 'label' => __('Base Price'), 'default' => '300', 'tab' => 'content', 'help' => __('Added to every calculation. Use 0 to disable.')],
            [
                'name' => 'items',
                'type' => 'repeater',
                'label' => __('Calculator Fields'),
                'tab' => 'content',
                'default' => [
                    ['type' => 'slider', 'label' => __('Number of pages'), 'price' => '50', 'price_type' => 'amount', 'min' => '1', 'max' => '30', 'step' => '1', 'default' => '5', 'unit' => __('pages'), 'options' => ''],
                    ['type' => 'select', 'label' => __('Design level'), 'price' => '0', 'price_type' => 'amount', 'min' => '0', 'max' => '0', 'step' => '1', 'default' => '0', 'unit' => '', 'options' => "Standard|0\nPremium|400\nCustom|900"],
                    ['type' => 'checkbox', 'label' => __('SEO optimization'), 'price' => '250', 'price_type' => 'amount', 'min' => '0', 'max' => '0', 'step' => '1', 'default' => '0', 'unit' => '', 'options' => ''],
                    ['type' => 'checkbox', 'label' => __('Rush delivery'), 'price' => '20', 'price_type' => 'percent', 'min' => '0', 'max' => '0', 'step' => '1', 'default' => '0', 'unit' => '', 'options' => ''],
                ],
                'fields' => [
                    [
                        'name' => 'type',
                        'type' => 'select',
                        'label' => __('Field Type'),
                        'default' => 'slider',
                        'options' => ['slider' => __('Slider'), 'number' => __('Number'), 'checkbox' => __('Checkbox'), 'select' => __('Dropdown')],
                    ],
                    ['name' => 'label', 'type' => 'text', 'label' => __('Label'), 'default' => ''],
                    ['name' => 'price', 'type' => 'text', 'label' => __('Price'), 'default' => '0', 'help' => __('Slider and Number: price per unit. Checkbox: fixed price. Dropdown: set prices in the options list.')],
                    [
                        'name' => 'price_type',
                        'type' => 'select',
                        'label' => __('Price Type'),
                        'default' => 'amount',
                        'options' => ['amount' => __('Amount'), 'percent' => __('Percent of subtotal')],
                    ],
                    ['name' => 'min', 'type' => 'text', 'label' => __('Minimum'), 'default' => '0'],
                    ['name' => 'max', 'type' => 'text', 'label' => __('Maximum'), 'default' => '10'],
                    ['name' => 'step', 'type' => 'text', 'label' => __('Step'), 'default' => '1'],
                    ['name' => 'default', 'type' => 'text', 'label' => __('Default Value'), 'default' => '0', 'help' => __('Checkbox: 1 means checked by default.')],
                    ['name' => 'unit', 'type' => 'text', 'label' => __('Unit'), 'default' => ''],
                    ['name' => 'options', 'type' => 'textarea', 'label' => __('Dropdown Options'), 'default' => '', 'help' => __('One option per line in the format: Label|Price')],
                ],
            ],

            ['name' => 'result_label', 'type' => 'text', 'label' => __('Result Label'), 'default' => __('Estimated total'), 'tab' => 'content'],
            ['name' => 'note', 'type' => 'text', 'label' => __('Note Under Result'), 'default' => __('The final price may vary after a detailed review.'), 'tab' => 'content'],
            ['name' => 'show_breakdown', 'type' => 'toggle', 'label' => __('Show Breakdown'), 'default' => true, 'tab' => 'content'],
            [
                'name' => 'submit_mode',
                'type' => 'select',
                'label' => __('Order Method'),
                'default' => 'whatsapp',
                'tab' => 'content',
                'options' => ['whatsapp' => 'WhatsApp', 'email' => __('Email'), 'webhook' => __('Send to URL (POST JSON)'), 'none' => __('No order button')],
            ],
            ['name' => 'submit_target', 'type' => 'text', 'label' => __('Order Target'), 'default' => '', 'tab' => 'content', 'placeholder' => '994501234567', 'help' => __('WhatsApp: phone number with country code. Email: address. URL: endpoint that accepts POST JSON.')],
            ['name' => 'button_label', 'type' => 'text', 'label' => __('Order Button'), 'default' => __('Place order'), 'tab' => 'content'],

            [
                'name' => 'theme',
                'type' => 'select',
                'label' => __('Theme'),
                'default' => 'dark',
                'tab' => 'style',
                'options' => ['dark' => __('Dark'), 'light' => __('Light')],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'accent_color_2', 'type' => 'color', 'label' => __('Second Accent Color'), 'default' => '#ec4899', 'tab' => 'style'],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $items = $this->items($settings['items'] ?? []);

        $mode = $this->pick($settings['submit_mode'] ?? 'whatsapp', ['whatsapp', 'email', 'webhook', 'none'], 'whatsapp');
        $target = $this->target($mode, (string) ($settings['submit_target'] ?? ''));
        if ($target === '') {
            $mode = 'none';
        }

        $animate = $this->flag($settings['animate'] ?? null, true);
        $accent = $this->hex($settings['accent_color'] ?? null, '#8b5cf6');
        $accent2 = $this->hex($settings['accent_color_2'] ?? null, '#ec4899');
        $title = $this->text($settings['title'] ?? '', 120);
        $resultLabel = $this->text($settings['result_label'] ?? '', 80);

        $opts = [
            'title' => $title,
            'subtitle' => $this->text($settings['subtitle'] ?? '', 240),
            'result_label' => $resultLabel,
            'note' => $this->text($settings['note'] ?? '', 240),
            'button' => $this->text($settings['button_label'] ?? '', 60),
            'theme' => $this->pick($settings['theme'] ?? 'dark', ['dark', 'light'], 'dark'),
            'accent' => $accent,
            'accent2' => $accent2,
            'animate' => $animate,
            'breakdown' => $this->flag($settings['show_breakdown'] ?? null, true),
            'mode' => $mode,
        ];

        $labels = [
            'total' => $resultLabel,
            'name' => __('Name'),
            'phone' => __('Phone'),
            'message' => __('Message (optional)'),
            'send' => $opts['button'],
            'sending' => __('Sending'),
            'sent' => __('Thank you! Your order has been sent.'),
            'failed' => __('Could not send. Please try again.'),
            'invalid' => __('Please enter a valid phone number.'),
            'details' => __('Details'),
        ];

        $payload = [
            'title' => $title,
            'cur' => $this->text($settings['currency'] ?? '$', 6),
            'pos' => $this->pick($settings['currency_position'] ?? 'before', ['before', 'after'], 'before'),
            'dec' => (int) $this->pick($settings['decimals'] ?? '0', ['0', '1', '2'], '0'),
            'base' => $this->num($settings['base_price'] ?? 0, 0.0),
            'baseLabel' => $this->text($settings['base_label'] ?? '', 80),
            'items' => $items,
            'mode' => $mode,
            'target' => $target,
            'acc' => $accent,
            'acc2' => $accent2,
            'anim' => $animate,
            'labels' => $labels,
        ];

        return view('rjbuilder.widgets.builtin.cost-calculator', [
            'o' => $opts,
            'uid' => 'cc_' . substr(md5(uniqid('', true)), 0, 8),
            'payload' => $payload,
            'labels' => $labels,
        ])->render();
    }

    private function items(mixed $raw): array
    {
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }
        if (!is_array($raw)) {
            return [];
        }

        $out = [];
        foreach (array_slice(array_values($raw), 0, 30, true) as $i => $row) {
            if (!is_array($row)) {
                continue;
            }

            $label = $this->text($row['label'] ?? '', 80);
            if ($label === '') {
                continue;
            }

            $type = $this->pick($row['type'] ?? 'slider', ['slider', 'number', 'checkbox', 'select'], 'slider');
            $item = [
                'id' => 'i' . $i,
                'type' => $type,
                'label' => $label,
                'pt' => $this->pick($row['price_type'] ?? 'amount', ['amount', 'percent'], 'amount'),
                'price' => $this->num($row['price'] ?? 0, 0.0),
                'unit' => $this->text($row['unit'] ?? '', 20),
            ];

            if ($type === 'slider' || $type === 'number') {
                $min = $this->num($row['min'] ?? 0, 0.0);
                $max = $this->num($row['max'] ?? ($min + 10), $min + 10);
                if ($max <= $min) {
                    $max = $min + 1;
                }
                $step = $this->num($row['step'] ?? 1, 1.0);
                if ($step <= 0) {
                    $step = 1.0;
                }
                $item['min'] = $min;
                $item['max'] = $max;
                $item['step'] = $step;
                $item['def'] = max($min, min($max, $this->num($row['default'] ?? $min, $min)));
            } elseif ($type === 'checkbox') {
                $item['def'] = $this->flag($row['default'] ?? null, false);
            } else {
                $options = $this->options((string) ($row['options'] ?? ''));
                if ($options === []) {
                    continue;
                }
                $item['options'] = $options;
                $item['def'] = 0;
            }

            $out[] = $item;
        }

        return $out;
    }

    private function options(string $raw): array
    {
        $out = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) ?: [] as $line) {
            $parts = explode('|', $line, 2);
            $label = $this->text($parts[0] ?? '', 80);
            if ($label === '') {
                continue;
            }
            $out[] = [$label, $this->num($parts[1] ?? 0, 0.0)];
            if (count($out) >= 20) {
                break;
            }
        }

        return $out;
    }

    private function target(string $mode, string $value): string
    {
        $value = trim($value);

        return match ($mode) {
            'whatsapp' => preg_replace('/\D+/', '', $value) ?? '',
            'email' => filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : '',
            'webhook' => $this->safeUrl($value),
            default => '',
        };
    }

    private function num(mixed $value, float $default): float
    {
        $value = str_replace(',', '.', trim((string) $value));

        return is_numeric($value) ? (float) $value : $default;
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^https?:/i', $url) ? $url : '';
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