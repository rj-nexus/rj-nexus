<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CodeHighlightWidget extends BaseWidget
{
    public function id(): string
    {
        return 'code-highlight';
    }

    public function name(): string
    {
        return __('Code Highlight');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-3 3 3 3M16 9l3 3-3 3M14 5l-4 14"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A syntax-highlighted code block with copy button, filename header and line numbers.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'language',
                'type'    => 'select',
                'label'   => __('Language'),
                'default' => 'php',
                'tab'     => 'content',
                'options' => [
                    'php'        => 'PHP',
                    'javascript' => 'JavaScript',
                    'typescript' => 'TypeScript',
                    'python'     => 'Python',
                    'html'       => 'HTML',
                    'css'        => 'CSS',
                    'sql'        => 'SQL',
                    'json'       => 'JSON',
                    'bash'       => 'Bash',
                    'go'         => 'Go',
                    'rust'       => 'Rust',
                    'java'       => 'Java',
                    'ruby'       => 'Ruby',
                    'yaml'       => 'YAML',
                    'markdown'   => 'Markdown',
                ],
            ],
            [
                'name'    => 'filename',
                'type'    => 'text',
                'label'   => __('Filename (optional)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'code',
                'type'    => 'textarea',
                'label'   => __('Code'),
                'default' => "<?php\n\necho 'Hello, World!';\n",
                'tab'     => 'content',
            ],
            [
                'name'    => 'theme',
                'type'    => 'select',
                'label'   => __('Theme'),
                'default' => 'dark',
                'tab'     => 'style',
                'options' => [
                    'dark'   => __('Dark'),
                    'darker' => __('Darker'),
                    'light'  => __('Light'),
                ],
            ],
            [
                'name'    => 'show_lines',
                'type'    => 'toggle',
                'label'   => __('Show Line Numbers'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_copy',
                'type'    => 'toggle',
                'label'   => __('Show Copy Button'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_lang',
                'type'    => 'toggle',
                'label'   => __('Show Language Badge'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'max_height',
                'type'    => 'range',
                'label'   => __('Max Height (px, 0 = none)'),
                'default' => 500,
                'min'     => 0,
                'max'     => 1200,
                'step'    => 20,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Corner Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 32,
                'min'     => 0,
                'max'     => 120,
                'step'    => 4,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'ch_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.code-highlight', compact('settings', 'uid'))->render();
    }
}
