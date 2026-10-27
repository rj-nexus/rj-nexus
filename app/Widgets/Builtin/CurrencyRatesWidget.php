<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class CurrencyRatesWidget extends BaseWidget
{
    public function id(): string
    {
        return 'currency-rates';
    }

    public function name(): string
    {
        return __('Currency Rates');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Live exchange rates (AZN, USD, EUR and more) fetched from a free API and displayed in a beautiful table.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Currency Rates'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => __('Live exchange rates against AZN'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'api_source',
                'type'    => 'select',
                'label'   => __('API Source'),
                'default' => 'exchangerate_host',
                'tab'     => 'content',
                'options' => [
                    'exchangerate_host' => __('Exchangerate.host (free, no key)'),
                    'allratestoday'     => __('AllRatesToday – AMB official (needs key)'),
                ],
                'help'    => __('Exchangerate.host works without an API key. AllRatesToday requires a free API key from allratestoday.com.'),
            ],
            [
                'name'    => 'api_key',
                'type'    => 'text',
                'label'   => __('API Key (AllRatesToday only)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Paste your free API key from allratestoday.com/register'),
            ],
            [
                'name'    => 'base',
                'type'    => 'select',
                'label'   => __('Base Currency'),
                'default' => 'AZN',
                'tab'     => 'content',
                'options' => [
                    'AZN' => 'AZN',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'TRY' => 'TRY',
                    'RUB' => 'RUB',
                    'GBP' => 'GBP',
                ],
            ],
            [
                'name'    => 'refresh',
                'type'    => 'select',
                'label'   => __('Refresh Interval'),
                'default' => '3600',
                'tab'     => 'content',
                'options' => [
                    '0'    => __('Never (page load only)'),
                    '300'  => __('Every 5 minutes'),
                    '3600' => __('Every hour'),
                    '21600'=> __('Every 6 hours'),
                ],
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'table',
                'tab'     => 'style',
                'options' => [
                    'table'  => __('Table'),
                    'cards'  => __('Cards'),
                    'compact'=> __('Compact List'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'bg_color',
                'type'    => 'color',
                'label'   => __('Card Background'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_flags',
                'type'    => 'toggle',
                'label'   => __('Show Country Flags'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_change',
                'type'    => 'toggle',
                'label'   => __('Show Daily Change'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
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
                'default' => 40,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'   => 'currencies',
                'type'   => 'repeater',
                'label'  => __('Currencies to Display'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'code', 'type' => 'text', 'label' => __('Currency Code (e.g. USD)')],
                    ['name' => 'name', 'type' => 'text', 'label' => __('Display Name')],
                    ['name' => 'flag', 'type' => 'text', 'label' => __('Flag Emoji (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'cr_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.currency-rates', compact('settings', 'uid'))->render();
    }
}
