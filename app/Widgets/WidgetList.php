<?php

namespace App\Widgets;

use App\Widgets\Builtin\AccordionWidget;
use App\Widgets\Builtin\AdvancedSearchWidget;
use App\Widgets\Builtin\AlertWidget;
use App\Widgets\Builtin\AnimatedHeroWidget;
use App\Widgets\Builtin\BasicGalleryWidget;
use App\Widgets\Builtin\ButtonWidget;
use App\Widgets\Builtin\ContainerWidget;
use App\Widgets\Builtin\CounterWidget;
use App\Widgets\Builtin\CountdownWidget;
use App\Widgets\Builtin\CustomHtmlWidget;
use App\Widgets\Builtin\DividerWidget;
use App\Widgets\Builtin\Google360Widget;
use App\Widgets\Builtin\HeadingWidget;
use App\Widgets\Builtin\HeroSlideWidget;
use App\Widgets\Builtin\IconBoxWidget;
use App\Widgets\Builtin\ImageBoxWidget;
use App\Widgets\Builtin\ImageComparisonWidget;
use App\Widgets\Builtin\ImageWidget;
use App\Widgets\Builtin\InteractiveMapWidget;
use App\Widgets\Builtin\LogoWidget;
use App\Widgets\Builtin\MenuWidget;
use App\Widgets\Builtin\PostsWidget;
use App\Widgets\Builtin\ProgressBarWidget;
use App\Widgets\Builtin\SocialIconsWidget;
use App\Widgets\Builtin\SoundCloudWidget;
use App\Widgets\Builtin\TabsWidget;
use App\Widgets\Builtin\TeamWidget;
use App\Widgets\Builtin\TestimonialWidget;
use App\Widgets\Builtin\TextWidget;
use App\Widgets\Builtin\ToggleCardsWidget;
use App\Widgets\Builtin\VideoHeroWidget;
use App\Widgets\Builtin\VideoWidget;

class WidgetList
{
    public static function get(): array
    {
        return [
            new HeroSlideWidget(),
            new AnimatedHeroWidget(),
            new VideoHeroWidget(),
            new HeadingWidget(),
            new TextWidget(),
            new ImageWidget(),
            new ContainerWidget(),
            new LogoWidget(),
            new MenuWidget(),
            new PostsWidget(),
            new CustomHtmlWidget(),
            new AccordionWidget(),
            new CountdownWidget(),
            new TabsWidget(),
            new ToggleCardsWidget(),
            new CounterWidget(),
            new ImageComparisonWidget(),
            new InteractiveMapWidget(),
            new AdvancedSearchWidget(),
            new TeamWidget(),
            new ProgressBarWidget(),
            new AlertWidget(),
            new Google360Widget(),
            new VideoWidget(),
            new ButtonWidget(),
            new DividerWidget(),
            new ImageBoxWidget(),
            new IconBoxWidget(),
            new BasicGalleryWidget(),
            new TestimonialWidget(),
            new SocialIconsWidget(),
            new SoundCloudWidget(),
        ];
    }
}
