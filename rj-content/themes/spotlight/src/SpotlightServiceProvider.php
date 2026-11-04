<?php

namespace Spotlight;

use Illuminate\Support\ServiceProvider;
use Spotlight\Widgets\SpotlightHeroWidget;
use Spotlight\Widgets\SpotlightHeaderWidget;
use Spotlight\Widgets\SpotlightLogosWidget;
use Spotlight\Widgets\SpotlightDividerWidget;
use Spotlight\Widgets\SpotlightShowcaseWidget;
use Spotlight\Widgets\SpotlightTabsWidget;
use Spotlight\Widgets\SpotlightFeaturesWidget;
use Spotlight\Widgets\SpotlightStepsWidget;
use Spotlight\Widgets\SpotlightPricingWidget;
use Spotlight\Widgets\SpotlightTestimonialsWidget;
use Spotlight\Widgets\SpotlightFaqWidget;
use Spotlight\Widgets\SpotlightNewsletterWidget;
use Spotlight\Widgets\SpotlightFooterWidget; // Yeni əlavə

class SpotlightServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->registerWidgets();
    }

    protected function registerWidgets(): void
    {
        if (function_exists('rj_add_filter')) {
            rj_add_filter('builder.widgets', function ($existing) {
                $widgets = [
                    new SpotlightHeroWidget(),
                    new SpotlightHeaderWidget(),
                    new SpotlightLogosWidget(),
                    new SpotlightDividerWidget(),
                    new SpotlightShowcaseWidget(),
                    new SpotlightTabsWidget(),
                    new SpotlightFeaturesWidget(),
                    new SpotlightStepsWidget(),
                    new SpotlightPricingWidget(),
                    new SpotlightTestimonialsWidget(),
                    new SpotlightFaqWidget(),
                    new SpotlightNewsletterWidget(),
                    new SpotlightFooterWidget(), // Yeni əlavə
                ];
                return array_merge($existing, $widgets);
            });
        }
    }
}
