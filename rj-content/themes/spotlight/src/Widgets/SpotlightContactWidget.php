<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;
use RjPlugins\FormBuilder\Models\Form;

class SpotlightContactWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-contact';
    }

    public function name(): string
    {
        return __('Spotlight Contact (Form)');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A two-column contact layout with info on the left and a dynamic RJ Form on the right.');
    }

    public function schema(): array
    {
        $forms = Form::active()->get();
        $options = ['' => __('— Select Form —')];

        foreach ($forms as $form) {
            $options[$form->id] = $form->name;
        }

        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => 'Send us a message',
            ],
            [
                'name' => 'office_label',
                'type' => 'text',
                'label' => __('Office Label'),
                'default' => 'Office',
            ],
            [
                'name' => 'office_address',
                'type' => 'textarea',
                'label' => __('Office Address'),
                'default' => "123 Innovation Drive, Tech City, TC 12345",
            ],
            [
                'name' => 'email_label',
                'type' => 'text',
                'label' => __('Email Label'),
                'default' => 'Email',
            ],
            [
                'name' => 'email_address',
                'type' => 'text',
                'label' => __('Email Address'),
                'default' => 'hello@example.com',
            ],
            [
                'name' => 'phone_label',
                'type' => 'text',
                'label' => __('Phone Label'),
                'default' => 'Phone',
            ],
            [
                'name' => 'phone_number',
                'type' => 'text',
                'label' => __('Phone Number'),
                'default' => '+1 (555) 123-4567',
            ],
            [
                'name' => 'form_id',
                'type' => 'select',
                'label' => __('Select RJ Form'),
                'default' => '',
                'options' => $options,
            ],
        ];
    }

    public function render(array $settings): string
    {
        $formId = $settings['form_id'] ?? null;
        $form = null;

        if ($formId && class_exists('\RjPlugins\FormBuilder\Models\Form')) {
            $form = Form::with('fields')->find($formId);
        }

        return view('theme::widgets.spotlight-contact', compact('settings', 'form'))->render();
    }
}
