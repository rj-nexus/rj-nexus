<?php

namespace App\Widgets;

use App\Widgets\Builtin\ContainerWidget;
use App\Widgets\Builtin\HeadingWidget;
use App\Widgets\Builtin\HeroSlideWidget;
use App\Widgets\Builtin\ImageWidget;
use App\Widgets\Builtin\LogoWidget;
use App\Widgets\Builtin\MenuWidget;
use App\Widgets\Builtin\PostsWidget;
use App\Widgets\Builtin\TextWidget;

class WidgetList
{
    public static function get(): array
    {
        return [
            new HeroSlideWidget(),
            new HeadingWidget(),
            new TextWidget(),
            new ImageWidget(),
            new ContainerWidget(),
            new LogoWidget(),
            new MenuWidget(),
            new PostsWidget(),
        ];
    }
}
