<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Str;

class TabsWidget extends BaseWidget
{
    private const MAX_TABS = 20;

    public function id(): string
    {
        return 'tabs';
    }

    public function name(): string
    {
        return __('Tabs');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Organize content into animated, switchable tabs.');
    }

    public function schema(): array
    {
        return [
            // ---------- Content ----------
            ['name' => 't1_title', 'type' => 'text', 'label' => __('Tab 1 - Title'), 'default' => __('Description'), 'tab' => 'content'],
            ['name' => 't1_icon', 'type' => 'icon', 'label' => __('Tab 1 - Icon'), 'default' => 'ph:file-text', 'tab' => 'content'],
            ['name' => 't1_content', 'type' => 'textarea', 'label' => __('Tab 1 - Content (HTML supported)'), 'default' => __('<p>This is the description tab content.</p>'), 'tab' => 'content'],

            ['name' => 't2_title', 'type' => 'text', 'label' => __('Tab 2 - Title'), 'default' => __('Shipping & Returns'), 'tab' => 'content'],
            ['name' => 't2_icon', 'type' => 'icon', 'label' => __('Tab 2 - Icon'), 'default' => 'ph:truck', 'tab' => 'content'],
            ['name' => 't2_content', 'type' => 'textarea', 'label' => __('Tab 2 - Content (HTML supported)'), 'default' => __('<p>Details about shipping and return policies go here.</p>'), 'tab' => 'content'],

            ['name' => 't3_title', 'type' => 'text', 'label' => __('Tab 3 - Title'), 'default' => __('Reviews'), 'tab' => 'content'],
            ['name' => 't3_icon', 'type' => 'icon', 'label' => __('Tab 3 - Icon'), 'default' => 'ph:star', 'tab' => 'content'],
            ['name' => 't3_content', 'type' => 'textarea', 'label' => __('Tab 3 - Content (HTML supported)'), 'default' => __('<p>Customer reviews will appear here.</p>'), 'tab' => 'content'],

            ['name' => 't4_title', 'type' => 'text', 'label' => __('Tab 4 - Title'), 'default' => '', 'tab' => 'content'],
            ['name' => 't4_icon', 'type' => 'icon', 'label' => __('Tab 4 - Icon'), 'default' => '', 'tab' => 'content'],
            ['name' => 't4_content', 'type' => 'textarea', 'label' => __('Tab 4 - Content (HTML supported)'), 'default' => '', 'tab' => 'content'],

            [
                'name' => 'extra_tabs',
                'type' => 'textarea',
                'label' => __('Extra Tabs'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => "ph:gift | Tab 5 title\n<p>Tab 5 content...</p>\n---\nTab 6 title\n<p>Tab 6 content...</p>",
                'help' => __('Unlimited extra tabs (max 20 total). First line = title (optionally "icon | title"), following lines = HTML content. Separate tabs with a line containing only ---'),
            ],
            ['name' => 'default_tab', 'type' => 'range', 'label' => __('Default Open Tab (number)'), 'default' => 1, 'min' => 1, 'max' => 20, 'tab' => 'content'],
            [
                'name' => 'autoplay',
                'type' => 'range',
                'label' => __('Auto Switch (seconds, 0 = off)'),
                'default' => 0,
                'min' => 0,
                'max' => 15,
                'tab' => 'content',
                'help' => __('Stops automatically once the visitor picks a tab.'),
            ],
            [
                'name' => 'hash_sync',
                'type' => 'toggle',
                'label' => __('Link Tabs to URL (#tab-name)'),
                'default' => false,
                'tab' => 'content',
                'help' => __('Lets visitors share a link that opens a specific tab.'),
            ],

            // ---------- Style ----------
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Tab Style'),
                'default' => 'underline',
                'tab' => 'style',
                'options' => [
                    'underline' => __('Underline (Minimal)'),
                    'pills' => __('Pills (Rounded)'),
                    'segmented' => __('Segmented (Switch)'),
                    'boxed' => __('Boxed (Solid)'),
                ],
            ],
            [
                'name' => 'orientation',
                'type' => 'select',
                'label' => __('Layout'),
                'default' => 'horizontal',
                'tab' => 'style',
                'options' => [
                    'horizontal' => __('Horizontal (tabs on top)'),
                    'vertical' => __('Vertical (tabs on the side)'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Tab Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'width',
                'type' => 'select',
                'label' => __('Width'),
                'default' => 'normal',
                'tab' => 'style',
                'options' => [
                    'narrow' => __('Narrow'),
                    'normal' => __('Normal'),
                    'wide' => __('Wide'),
                    'full' => __('Full'),
                ],
            ],
            ['name' => 'panel_card', 'type' => 'toggle', 'label' => __('Show Content in a Card'), 'default' => false, 'tab' => 'style'],
            ['name' => 'active_color', 'type' => 'color', 'label' => __('Active Tab Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'inactive_color', 'type' => 'color', 'label' => __('Inactive Tab Text Color'), 'default' => '#64748b', 'tab' => 'style'],
            ['name' => 'text_color', 'type' => 'color', 'label' => __('Content Text Color'), 'default' => '#334155', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $tabs = [];

        for ($i = 1; $i <= 4; $i++) {
            $title = trim((string) ($settings['t' . $i . '_title'] ?? ''));
            if ($title !== '') {
                $tabs[] = [
                    'title' => $title,
                    'icon' => trim((string) ($settings['t' . $i . '_icon'] ?? '')),
                    'content' => (string) ($settings['t' . $i . '_content'] ?? ''),
                ];
            }
        }

        foreach ($this->parseExtra((string) ($settings['extra_tabs'] ?? '')) as $extra) {
            $tabs[] = $extra;
        }

        $tabs = array_slice($tabs, 0, self::MAX_TABS);

        if (empty($tabs)) {
            return '';
        }

        // Unique, URL-friendly slugs
        $used = [];
        foreach ($tabs as $i => &$tab) {
            $slug = Str::slug($tab['title']) ?: 'tab-' . ($i + 1);
            $base = $slug;
            $n = 2;
            while (in_array($slug, $used, true)) {
                $slug = $base . '-' . $n++;
            }
            $used[] = $slug;
            $tab['slug'] = $slug;
        }
        unset($tab);

        $opts = [
            'style' => $this->pick($settings['style'] ?? 'underline', ['underline', 'pills', 'segmented', 'boxed'], 'underline'),
            'orient' => $this->pick($settings['orientation'] ?? 'horizontal', ['horizontal', 'vertical'], 'horizontal'),
            'align' => $this->pick($settings['align'] ?? 'left', ['left', 'center', 'right'], 'left'),
            'width' => $this->pick($settings['width'] ?? 'normal', ['narrow', 'normal', 'wide', 'full'], 'normal'),
            'card' => $this->toBool($settings['panel_card'] ?? null, false),
            'active' => $this->hex($settings['active_color'] ?? null, '#8b5cf6'),
            'inactive' => $this->hex($settings['inactive_color'] ?? null, '#64748b'),
            'text' => $this->hex($settings['text_color'] ?? null, '#334155'),
            'default' => max(1, min(count($tabs), (int) ($settings['default_tab'] ?? 1))) - 1,
            'autoplay' => max(0, min(15, (int) ($settings['autoplay'] ?? 0))),
            'hash' => $this->toBool($settings['hash_sync'] ?? null, false),
        ];

        $uid = 'tabs_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.tabs', compact('tabs', 'opts', 'uid'))->render();
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
            $head = trim($parts[0] ?? '');
            $icon = '';

            if (str_contains($head, '|')) {
                [$maybeIcon, $rest] = array_map('trim', explode('|', $head, 2));
                if (preg_match('/^[a-z0-9_-]+:[a-z0-9_-]+$/i', $maybeIcon)) {
                    $icon = $maybeIcon;
                    $head = $rest;
                }
            }

            if ($head !== '' && $head !== '---') {
                $out[] = ['title' => $head, 'icon' => $icon, 'content' => trim($parts[1] ?? '')];
            }
        }

        return $out;
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
