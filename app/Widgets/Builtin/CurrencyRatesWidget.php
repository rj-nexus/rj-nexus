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
        return __('Live exchange rates for 160+ currencies with search, filters, starred currencies and a built-in converter.');
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
                    // key kept for backward compatibility with already saved pages
                    'exchangerate_host' => __('Open ER-API (free, no key)'),
                    'allratestoday'     => __('AllRatesToday – AMB official (needs key)'),
                ],
                'help'    => __('If the selected source is unreachable, free backup sources are used automatically.'),
            ],
            [
                'name'    => 'api_key',
                'type'    => 'text',
                'label'   => __('API Key (AllRatesToday only)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Paste your free API key from allratestoday.com/register. Note: the key is visible in the page source.'),
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
                    'GBP' => 'GBP',
                    'TRY' => 'TRY',
                    'RUB' => 'RUB',
                    'GEL' => 'GEL',
                    'KZT' => 'KZT',
                    'UAH' => 'UAH',
                    'AED' => 'AED',
                    'CNY' => 'CNY',
                    'JPY' => 'JPY',
                ],
            ],
            [
                'name'    => 'mode',
                'type'    => 'select',
                'label'   => __('Currencies Shown'),
                'default' => 'auto',
                'tab'     => 'content',
                'options' => [
                    'auto'   => __('All available (your list first)'),
                    'custom' => __('Only my list below'),
                ],
                'help'    => __('A currency from your list that the source does not provide is shown with an error message.'),
            ],
            [
                'name'    => 'show_extra',
                'type'    => 'toggle',
                'label'   => __('Include extra currencies (metals, crypto, etc.)'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'initial_count',
                'type'    => 'select',
                'label'   => __('Shown Before "Show all"'),
                'default' => '24',
                'tab'     => 'content',
                'options' => [
                    '12'  => '12',
                    '24'  => '24',
                    '48'  => '48',
                    '96'  => '96',
                    '0'   => __('Show everything'),
                ],
            ],
            [
                'name'    => 'refresh',
                'type'    => 'select',
                'label'   => __('Refresh Interval'),
                'default' => '3600',
                'tab'     => 'content',
                'options' => [
                    '0'     => __('Never (page load only)'),
                    '300'   => __('Every 5 minutes'),
                    '3600'  => __('Every hour'),
                    '21600' => __('Every 6 hours'),
                ],
            ],
            [
                'name'    => 'show_search',
                'type'    => 'toggle',
                'label'   => __('Show Search & Filters'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_converter',
                'type'    => 'toggle',
                'label'   => __('Show Converter'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Default Layout'),
                'default' => 'grid',
                'tab'     => 'style',
                'options' => [
                    'grid'    => __('Grid'),
                    'list'    => __('List'),
                    'compact' => __('Compact List'),
                ],
                'help'    => __('Visitors can switch the layout themselves.'),
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#1f4fff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'text_color',
                'type'    => 'color',
                'label'   => __('Text Color'),
                'default' => '#0e1a2b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'bg_color',
                'type'    => 'color',
                'label'   => __('Background Color'),
                'default' => '#eef1f7',
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
                'default' => 40,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
            [
                'name'   => 'currencies',
                'type'   => 'repeater',
                'label'  => __('Priority Currencies'),
                'tab'    => 'content',
                'help'   => __('Shown first. Name and flag are optional – they are filled in automatically.'),
                'fields' => [
                    ['name' => 'code', 'type' => 'text', 'label' => __('Currency Code (e.g. USD)')],
                    ['name' => 'name', 'type' => 'text', 'label' => __('Display Name (optional)')],
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
