<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FooterBadgesWidget extends BaseWidget
{
    public function id(): string
    {
        return 'footer-badges';
    }

    public function name(): string
    {
        return __('Footer Badges');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>';
    }

    public function category(): string
    {
        return 'footer';
    }

    public function description(): string
    {
        return __('Display payment methods, trust badges, or partner logos in the footer.');
    }

    public function contexts(): array
    {
        return ['footer'];
    }

    public function getLogos(): array
    {
        return [
            'm10' => ['name' => 'M10', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/m10_azerbaijan/m10.svg'],
            'alipay' => ['name' => 'Alipay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/alipay/alipay.webp'],
            'amex' => ['name' => 'American Express', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/amex/amex.svg'],
            'apple-pay' => ['name' => 'Apple Pay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/apple-pay/apple_pay_transparent.svg'],
            'birbank' => ['name' => 'Birbank', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/birbank_azerbaijan/birbank.svg'],
            'google-pay' => ['name' => 'Google Pay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/google-pay/Google_Pay_Logo.webp'],
            'jcb' => ['name' => 'JCB', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/jcb/jcb.webp'],
            'leobank' => ['name' => 'Leobank', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/leobank_azerbaijan/Logo_of_Leobank.webp'],
            'm-pesa' => ['name' => 'M-Pesa', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/m-pesa_africa/m-pesa.webp'],
            'maestro' => ['name' => 'Maestro', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/maestro/maestro_logo_variant2.webp'],
            'million' => ['name' => 'Million', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/million_azerbaijan/million.svg'],
            'mastercard' => ['name' => 'Mastercard', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/mastercard/mastercard_footer_logo.webp'],
            'paypal' => ['name' => 'PayPal', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/pay-pal/paypal.webp'],
            '3d-secure' => ['name' => '3-D Secure', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/payment-component/3d-secure.svg'],
            'pci-dss' => ['name' => 'PCI DSS', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/payment-component/pci-dss.svg'],
            'phonepe' => ['name' => 'PhonePe', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/phonepe/PhonePe_Logo.webp'],
            'pix' => ['name' => 'Pix', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/pix_brasil/pix.webp'],
            'stc-pay' => ['name' => 'stc pay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/stc_pay/stc-pay.webp'],
            'stripe' => ['name' => 'Stripe', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/stripe/stripe.webp'],
            'unionpay' => ['name' => 'UnionPay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/unionpay/unionpay.webp'],
            'visa' => ['name' => 'Visa', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/visa/visa_inc.webp'],
            'wechat-pay' => ['name' => 'WeChat Pay', 'url' => 'https://cdn.jsdelivr.net/gh/mr-ruhid/rare-logos-vault@main/logo/payment-gateway/wechat-pay/wechat-pay.svg'],
        ];
    }

    public function schema(): array
    {
        $logoOptions = [];
        foreach ($this->getLogos() as $key => $logo) {
            $logoOptions[$key] = $logo['name'];
        }

        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title / Heading'),
                'default' => __('Secure Payment Options'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'left',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                    'right'  => __('Right'),
                ],
            ],
            [
                'name'    => 'gap',
                'type'    => 'select',
                'label'   => __('Item Spacing'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'height',
                'type'    => 'range',
                'label'   => __('Max Logo Height (px)'),
                'default' => 36,
                'min'     => 16,
                'max'     => 80,
                'step'    => 2,
                'tab'     => 'style',
            ],
            [
                'name'    => 'color_mode',
                'type'    => 'select',
                'label'   => __('Logo Color Mode'),
                'default' => 'original',
                'tab'     => 'style',
                'options' => [
                    'original'  => __('Original Colors'),
                    'white'     => __('Force White'),
                    'black'     => __('Force Black'),
                    'grayscale' => __('Grayscale'),
                ],
            ],
            [
                'name'    => 'title_color',
                'type'    => 'color',
                'label'   => __('Title Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'items',
                'type'    => 'repeater',
                'label'   => __('Selected Badges'),
                'tab'     => 'content',
                'fields'  => [
                    [
                        'name'    => 'logo_id',
                        'type'    => 'select',
                        'label'   => __('Select Logo'),
                        'options' => $logoOptions,
                    ],
                    [
                        'name'  => 'url',
                        'type'  => 'text',
                        'label' => __('Custom URL (optional)'),
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fb_' . substr(md5(uniqid('', true)), 0, 8);

        $allLogos = $this->getLogos();
        $items = [];

        if (!empty($settings['items']) && is_array($settings['items'])) {
            foreach ($settings['items'] as $row) {
                $id = $row['logo_id'] ?? '';
                if (isset($allLogos[$id])) {
                    $items[] = [
                        'name' => $allLogos[$id]['name'],
                        'url'  => $allLogos[$id]['url'],
                        'link' => $row['url'] ?? '',
                    ];
                }
            }
        }

        return view('rjbuilder.widgets.builtin.footer-badges', compact('settings', 'uid', 'items'))->render();
    }
}
