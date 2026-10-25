<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CustomHtmlWidget extends BaseWidget
{
    public function id(): string
    {
        return 'custom-html';
    }

    public function name(): string
    {
        return __('Custom HTML / Code');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>';
    }

    public function category(): string
    {
        return 'advanced';
    }

    public function description(): string
    {
        return __('Add custom HTML, CSS, or JavaScript code directly to your page.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'code',
                'type' => 'textarea',
                'label' => __('HTML / Code'),
                'default' => "<div style=\"padding:32px;text-align:center;background:#f1f5f9;border-radius:12px;border:1px solid #cbd5e1\">\n    <h2 style=\"margin:0 0 8px;font:700 24px sans-serif;color:#1e293b\">Hello World</h2>\n    <p style=\"margin:0;color:#64748b\">Your custom HTML goes here.</p>\n</div>",
                'tab' => 'content',
                'placeholder' => __('Paste your HTML, <style>, or <script> here...'),
                'help' => __('Use with caution. Scripts will be executed on the live site.'),
            ],
            [
                'name' => 'isolation',
                'type' => 'select',
                'label' => __('Isolation'),
                'default' => 'iframe',
                'tab' => 'content',
                'options' => [
                    'iframe' => __('Iframe (full isolation, recommended)'),
                    'shadow' => __('Shadow DOM (CSS isolation)'),
                    'none'   => __('None (inherit site styles)'),
                ],
                'help' => __('Prevents your CSS from clashing with the site CSS.'),
            ],
            [
                'name' => 'site_css',
                'type' => 'toggle',
                'label' => __('Include site CSS (Tailwind) inside'),
                'default' => false,
                'tab' => 'content',
                'help' => __('Only for Iframe / Shadow modes. Lets Tailwind classes work in your code.'),
            ],
            [
                'name' => 'full_width',
                'type' => 'toggle',
                'label' => __('Full Width'),
                'default' => false,
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $code = $settings['code'] ?? '';
        $isFullWidth = !empty($settings['full_width']);
        $mode = in_array($settings['isolation'] ?? 'iframe', ['iframe', 'shadow', 'none'], true)
            ? $settings['isolation']
            : 'iframe';
        $siteCss = !empty($settings['site_css']);

        if (trim($code) === '') {
            return '';
        }

        return view('rjbuilder.widgets.builtin.custom-html', compact('code', 'isFullWidth', 'mode', 'siteCss'))->render();
    }
}
