<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TextWidget extends BaseWidget
{
    public function id(): string { return 'text'; }
    public function name(): string { return __('Text Editor'); }
    public function icon(): string { return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h10"/></svg>'; }
    public function category(): string { return 'basic'; }
    public function description(): string { return __('Add rich text, images, and headings.'); }

    public function schema(): array
    {
        return [
            [
                'name' => 'content',
                'type' => 'rich_text',
                'label' => __('Content'),
                'default' => '<p>Write something beautiful here...</p>',
                'tab' => 'content',
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
                    'justify' => __('Justify'),
                ],
            ]
        ];
    }

    public function render(array $settings): string
    {
        $html = $settings['content'] ?? '';
        $align = $settings['align'] ?? 'left';

        $safeHtml = strip_tags($html, '<p><a><strong><b><em><i><u><ul><ol><li><h1><h2><h3><h4><blockquote><img><br><span>');

        return '<div class="rj-text-content" style="text-align:'.e($align).'; line-height: 1.6;">' . $safeHtml . '</div>';
    }
}