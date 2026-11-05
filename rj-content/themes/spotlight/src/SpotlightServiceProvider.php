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
use Spotlight\Widgets\SpotlightFooterWidget;
use Spotlight\Widgets\SpotlightTeamWidget;
<<<<<<< HEAD
use Spotlight\Widgets\SpotlightActionGridWidget;
use Spotlight\Widgets\SpotlightTrustpilotWidget;
use Spotlight\Widgets\SpotlightFeaturesGridWidget;
use Spotlight\Widgets\SpotlightMapWidget;
use Spotlight\Widgets\SpotlightContactWidget;
=======
use Spotlight\Widgets\SpotlightAnimatedFeaturesWidget;
use Spotlight\Widgets\SpotlightActionGridWidget;
use Spotlight\Widgets\SpotlightTrustpilotWidget; // YENİ ƏLAVƏ OLUNDU
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d

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
                    new SpotlightFooterWidget(),
                    new SpotlightTeamWidget(),
<<<<<<< HEAD
                    new SpotlightActionGridWidget(),
                    new SpotlightTrustpilotWidget(),
                    new SpotlightFeaturesGridWidget(),
                    new SpotlightMapWidget(),
                    new SpotlightContactWidget(),
=======
                    new SpotlightAnimatedFeaturesWidget(),
                    new SpotlightActionGridWidget(),
                    new SpotlightTrustpilotWidget(), // YENİ ƏLAVƏ OLUNDU
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
                ];
                return array_merge($existing, $widgets);
            });
        }
    }
}
