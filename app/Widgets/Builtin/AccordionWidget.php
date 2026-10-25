<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AccordionWidget extends BaseWidget
{
    private const MAX_ITEMS = 100;

    public function id(): string
    {
        return 'accordion';
    }

    public function name(): string
    {
        return __('Accordion / FAQ');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('An animated, collapsible accordion for Frequently Asked Questions.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Section Title'), 'default' => __('Frequently Asked Questions'), 'tab' => 'content'],
            ['name' => 'subtitle', 'type' => 'text', 'label' => __('Subtitle'), 'default' => '', 'tab' => 'content'],

            ['name' => 'q1', 'type' => 'text', 'label' => __('Question 1'), 'default' => __('How long does shipping take?'), 'tab' => 'content'],
            ['name' => 'a1', 'type' => 'textarea', 'label' => __('Answer 1'), 'default' => __('Standard shipping usually takes 3-5 business days. Express shipping is available at checkout.'), 'tab' => 'content'],

            ['name' => 'q2', 'type' => 'text', 'label' => __('Question 2'), 'default' => __('What is your return policy?'), 'tab' => 'content'],
            ['name' => 'a2', 'type' => 'textarea', 'label' => __('Answer 2'), 'default' => __('We offer a 30-day money-back guarantee. If you are not satisfied, you can return the item for a full refund.'), 'tab' => 'content'],

            ['name' => 'q3', 'type' => 'text', 'label' => __('Question 3'), 'default' => __('Do you ship internationally?'), 'tab' => 'content'],
            ['name' => 'a3', 'type' => 'textarea', 'label' => __('Answer 3'), 'default' => __('Yes, we ship to over 100 countries worldwide. Shipping costs will be calculated at checkout.'), 'tab' => 'content'],

            ['name' => 'q4', 'type' => 'text', 'label' => __('Question 4'), 'default' => '', 'tab' => 'content'],
            ['name' => 'a4', 'type' => 'textarea', 'label' => __('Answer 4'), 'default' => '', 'tab' => 'content'],

            [
                'name' => 'extra_items',
                'type' => 'textarea',
                'label' => __('Extra Questions'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => "Question 5?\nAnswer 5...\n---\nQuestion 6?\nAnswer 6...",
                'help' => __('Unlimited extra items. First line = question, following lines = answer. Separate items with a line containing only ---'),
            ],

            ['name' => 'first_open', 'type' => 'toggle', 'label' => __('Open First Item by Default'), 'default' => true, 'tab' => 'content'],
            ['name' => 'allow_multiple', 'type' => 'toggle', 'label' => __('Allow Multiple Open Items'), 'default' => false, 'tab' => 'content'],
            ['name' => 'show_search', 'type' => 'toggle', 'label' => __('Show Search Box'), 'default' => false, 'tab' => 'content'],
            [
                'name' => 'seo_schema',
                'type' => 'toggle',
                'label' => __('Add FAQ Schema (SEO)'),
                'default' => false,
                'tab' => 'content',
                'help' => __('Use on only one FAQ block per page.'),
            ],

            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'glow',
                'tab' => 'style',
                'options' => [
                    'glow' => __('Glow (Gradient)'),
                    'clean' => __('Clean (White Cards)'),
                    'dark' => __('Dark Theme'),
                    'bordered' => __('Bordered (Minimal)'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'],
            ['name' => 'show_numbers', 'type' => 'toggle', 'label' => __('Show Numbers (01, 02...)'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $items = [];

        for ($i = 1; $i <= 4; $i++) {
            $q = trim((string) ($settings['q' . $i] ?? ''));
            if ($q !== '') {
                $items[] = ['question' => $q, 'answer' => trim((string) ($settings['a' . $i] ?? ''))];
            }
        }

        foreach ($this->parseExtra((string) ($settings['extra_items'] ?? '')) as $extra) {
            $items[] = $extra;
        }

        $items = array_slice($items, 0, self::MAX_ITEMS);

        if (empty($items)) {
            return '';
        }

        $style = (string) ($settings['style'] ?? 'glow');
        if (!in_array($style, ['glow', 'clean', 'dark', 'bordered'], true)) {
            $style = 'glow';
        }

        $opts = [
            'title' => trim((string) ($settings['title'] ?? '')),
            'subtitle' => trim((string) ($settings['subtitle'] ?? '')),
            'style' => $style,
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
            'first_open' => $this->toBool($settings['first_open'] ?? null, true),
            'multiple' => $this->toBool($settings['allow_multiple'] ?? null, false),
            'search' => $this->toBool($settings['show_search'] ?? null, false),
            'numbers' => $this->toBool($settings['show_numbers'] ?? null, true),
            'seo' => $this->toBool($settings['seo_schema'] ?? null, false),
        ];

        $uid = 'acc_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.accordion', compact('items', 'opts', 'uid'))->render();
    }

    private function parseExtra(string $raw): array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return [];
        }

        $out = [];

        foreach (preg_split('/\R\s*---\s*\R/u', $raw) ?: [] as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }

            $parts = preg_split('/\R/u', $block, 2);
            $q = trim($parts[0] ?? '');

            if ($q !== '' && $q !== '---') {
                $out[] = ['question' => $q, 'answer' => trim($parts[1] ?? '')];
            }
        }

        return $out;
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
