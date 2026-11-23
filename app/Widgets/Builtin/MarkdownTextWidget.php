<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Str;

class MarkdownTextWidget extends BaseWidget
{
    public function id(): string
    {
        return 'markdown-text';
    }

    public function name(): string
    {
        return __('Markdown Text');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Render Markdown with syntax highlighting, tables and auto TOC.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'content',
                'type' => 'textarea',
                'label' => __('Markdown Source'),
                'default' => "# Hello World\n\nThis is **Markdown** content with a [link](https://example.com).\n\n## Features\n\n- Tables\n- Task lists\n- Code blocks\n\n```php\necho \"Hello, World!\";\n```\n\n> Blockquotes work too.",
                'tab' => 'content',
                'placeholder' => "# Heading\n\nYour markdown here...",
                'help' => __('Supports GitHub Flavored Markdown: tables, task lists, strikethrough, autolinks.'),
            ],
            ['name' => 'show_toc', 'type' => 'toggle', 'label' => __('Show Table of Contents'), 'default' => false, 'tab' => 'content'],
            [
                'name' => 'toc_position',
                'type' => 'select',
                'label' => __('TOC Position'),
                'default' => 'top',
                'tab' => 'content',
                'options' => [
                    'top' => __('Top (Inline)'),
                    'sidebar' => __('Sidebar (Desktop)'),
                ],
            ],
            [
                'name' => 'toc_max_depth',
                'type' => 'select',
                'label' => __('TOC Max Depth'),
                'default' => '3',
                'tab' => 'content',
                'options' => [
                    '2' => __('H1 + H2'),
                    '3' => __('H1 + H2 + H3'),
                    '4' => __('H1 + H2 + H3 + H4'),
                ],
            ],
            [
                'name' => 'link_target',
                'type' => 'select',
                'label' => __('External Link Target'),
                'default' => '_blank',
                'tab' => 'content',
                'options' => [
                    '_self' => __('Same Tab'),
                    '_blank' => __('New Tab'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'clean',
                'tab' => 'style',
                'options' => [
                    'clean' => __('Clean (White)'),
                    'dark' => __('Dark Theme'),
                    'bordered' => __('Bordered (Minimal)'),
                ],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#6366f1', 'tab' => 'style'],
            [
                'name' => 'code_theme',
                'type' => 'select',
                'label' => __('Code Block Theme'),
                'default' => 'github',
                'tab' => 'style',
                'options' => [
                    'github' => __('GitHub Light'),
                    'tomorrow' => __('Tomorrow (Dark)'),
                    'dracula' => __('Dracula'),
                    'monokai' => __('Monokai'),
                ],
            ],
            [
                'name' => 'max_width',
                'type' => 'select',
                'label' => __('Content Width'),
                'default' => '800',
                'tab' => 'style',
                'options' => [
                    '600' => __('Narrow (600px)'),
                    '800' => __('Medium (800px)'),
                    '1000' => __('Wide (1000px)'),
                    '1200' => __('Extra Wide (1200px)'),
                    'full' => __('Full Width'),
                ],
            ],
            [
                'name' => 'padding',
                'type' => 'select',
                'label' => __('Padding'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $raw = (string) ($settings['content'] ?? '');

        if (trim($raw) === '') {
            return '';
        }

        // Server-side markdown rendering (SEO-friendly)
        try {
            $html = Str::markdown($raw, [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'max_nesting_level' => 20,
            ]);
        } catch (\Throwable $e) {
            return '';
        }

        $maxDepth = (int) ($settings['toc_max_depth'] ?? 3);
        $headings = $this->extractHeadings($html, $maxDepth);
        $html = $this->addHeadingIds($html);

        $opts = [
            'show_toc' => $this->toBool($settings['show_toc'] ?? null, false),
            'toc_position' => in_array($settings['toc_position'] ?? 'top', ['top', 'sidebar'], true)
                ? $settings['toc_position'] : 'top',
            'link_target' => in_array($settings['link_target'] ?? '_blank', ['_self', '_blank'], true)
                ? $settings['link_target'] : '_blank',
            'style' => in_array($settings['style'] ?? 'clean', ['clean', 'dark', 'bordered'], true)
                ? $settings['style'] : 'clean',
            'accent' => $this->hex($settings['accent_color'] ?? null, '#6366f1'),
            'code_theme' => in_array($settings['code_theme'] ?? 'github', ['github', 'tomorrow', 'dracula', 'monokai'], true)
                ? $settings['code_theme'] : 'github',
            'max_width' => in_array($settings['max_width'] ?? '800', ['600', '800', '1000', '1200', 'full'], true)
                ? $settings['max_width'] : '800',
            'padding' => in_array($settings['padding'] ?? 'md', ['none', 'sm', 'md', 'lg'], true)
                ? $settings['padding'] : 'md',
        ];

        $uid = 'md_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.markdown-text', compact('html', 'headings', 'opts', 'uid'))->render();
    }

    private function extractHeadings(string $html, int $maxDepth): array
    {
        $out = [];

        if (preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h\1>/is', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $level = (int) $m[1];
                if ($level > $maxDepth) {
                    continue;
                }
                $text = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($text !== '') {
                    $out[] = ['level' => $level, 'text' => $text, 'id' => $this->slugify($text)];
                }
            }
        }

        return $out;
    }

    private function addHeadingIds(string $html): string
    {
        return preg_replace_callback(
            '/<h([1-6])([^>]*)>(.*?)<\/h\1>/is',
            function ($m) {
                $level = $m[1];
                $attrs = $m[2];
                $content = $m[3];
                $text = trim(html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $id = $this->slugify($text);
                $attrs = preg_replace('/\sid="[^"]*"/i', '', $attrs);

                return "<h{$level} id=\"{$id}\"{$attrs}>{$content}</h{$level}>";
            },
            $html
        );
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = preg_replace('/[\s-]+/u', '-', $text);

        return trim($text, '-') ?: 'section';
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