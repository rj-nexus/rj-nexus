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
                'default' => "<div class=\"p-8 text-center bg-slate-100 rounded-xl border border-slate-300\">\n    <h2 class=\"text-2xl font-bold text-slate-800\">Hello World</h2>\n    <p class=\"text-slate-500\">Your custom HTML goes here.</p>\n</div>",
                'tab' => 'content',
                'placeholder' => __('Paste your HTML, <style>, or <script> here...'),
                'help' => __('Use with caution. Scripts will be executed on the live site.'),
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

        if (trim($code) === '') {
            return '';
        }

        return view('rjbuilder.widgets.builtin.custom-html', compact('code', 'isFullWidth'))->render();
    }
}
