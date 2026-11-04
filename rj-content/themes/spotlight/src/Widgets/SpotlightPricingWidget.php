<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightPricingWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-pricing';
    }

    public function name(): string
    {
        return __('Spotlight Pricing');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('Glass pricing cards with cursor spotlight, border beam, lamp light, 3D tilt and a monthly/yearly toggle.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'badge_text',
                'type' => 'text',
                'label' => __('Badge Text'),
                'default' => __('Simple, transparent pricing'),
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Pick a plan. Start creating.'),
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Subtitle'),
                'default' => __('Start free and upgrade when you grow. No hidden fees, cancel anytime.'),
            ],
            [
                'name' => 'plans',
                'type' => 'textarea',
                'label' => __('Plans (max 4, separate plans with a line containing ---)'),
                'default' => "Name: Starter\nPrice: 0\nDesc: Everything you need to start creating.\nButton: Get started | /register\n- 50 AI generations / month\n- 1 workspace\n- Community support\n- ~Priority generation\n- ~Custom models\n---\nName: Pro\nBadge: Most popular\nFeatured: yes\nPrice: 29\nYearly: 24\nDesc: For creators and teams who ship every week.\nButton: Start free trial | /register\n- Unlimited generations\n- Multi-model engine\n- 10 workspaces\n- Priority support\n- Export in 4K\n---\nName: Business\nPrice: 99\nYearly: 79\nDesc: Advanced control for growing companies.\nButton: Contact sales | /contact\n- Everything in Pro\n- Unlimited seats\n- Custom model tuning\n- SSO and audit logs\n- Dedicated manager",
                'help' => __('Keys: Name, Price, Yearly (monthly price when billed yearly), Period, Desc, Badge, Featured (yes), Hue (0-360), Button (Text | URL). Lines starting with "-" are features; use "- ~Text" for a feature that is not included. A non-numeric price such as "Custom" is shown as text.'),
            ],
            [
                'name' => 'currency',
                'type' => 'text',
                'label' => __('Currency Symbol'),
                'default' => '$',
            ],
            [
                'name' => 'billing_toggle',
                'type' => 'toggle',
                'label' => __('Show Monthly / Yearly Toggle'),
                'default' => true,
                'help' => __('Only appears when at least one plan has a Yearly price.'),
            ],
            [
                'name' => 'monthly_label',
                'type' => 'text',
                'label' => __('Monthly Label'),
                'default' => __('Monthly'),
            ],
            [
                'name' => 'yearly_label',
                'type' => 'text',
                'label' => __('Yearly Label'),
                'default' => __('Yearly'),
            ],
            [
                'name' => 'save_text',
                'type' => 'text',
                'label' => __('Yearly Savings Tag'),
                'default' => __('Save 20%'),
            ],
            [
                'name' => 'note',
                'type' => 'text',
                'label' => __('Footnote'),
                'default' => __('No credit card required · Cancel anytime'),
            ],
            [
                'name' => 'show_hud',
                'type' => 'toggle',
                'label' => __('Show HUD Labels'),
                'default' => true,
            ],
            [
                'name' => 'hud_left',
                'type' => 'text',
                'label' => __('HUD Left Text'),
                'default' => '[ 05 / 09 ]',
            ],
            [
                'name' => 'hud_right',
                'type' => 'text',
                'label' => __('HUD Right Text'),
                'default' => '[ PRICING ]',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-pricing', compact('settings'))->render();
    }
}
