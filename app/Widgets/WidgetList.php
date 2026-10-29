<?php

namespace App\Widgets;

use App\Widgets\Builtin\AccordionWidget;
use App\Widgets\Builtin\AdvancedSearchWidget;
use App\Widgets\Builtin\AlertWidget;
use App\Widgets\Builtin\AnimatedHeadlineWidget;
use App\Widgets\Builtin\AnimatedHeroWidget;
use App\Widgets\Builtin\BasicGalleryWidget;
use App\Widgets\Builtin\BlockquoteWidget;
use App\Widgets\Builtin\BusinessHoursWidget;
use App\Widgets\Builtin\ButtonWidget;
use App\Widgets\Builtin\CallToActionWidget;
use App\Widgets\Builtin\CodeHighlightWidget;
use App\Widgets\Builtin\ContactInfoWidget;
use App\Widgets\Builtin\ContainerWidget;
use App\Widgets\Builtin\StructureContainerWidget;
use App\Widgets\Builtin\CookieNoticeWidget;
use App\Widgets\Builtin\CounterWidget;
use App\Widgets\Builtin\CountdownWidget;
use App\Widgets\Builtin\CurrencyRatesWidget;
use App\Widgets\Builtin\CustomHtmlWidget;
use App\Widgets\Builtin\DividerWidget;
use App\Widgets\Builtin\DualColorHeadingWidget;
use App\Widgets\Builtin\FlipBoxWidget;
use App\Widgets\Builtin\FooterAboutWidget;
use App\Widgets\Builtin\FooterBadgesWidget;
use App\Widgets\Builtin\FooterContactWidget;
use App\Widgets\Builtin\FooterCopyrightWidget;
use App\Widgets\Builtin\FooterLinksWidget;
use App\Widgets\Builtin\FooterNewsletterWidget;
use App\Widgets\Builtin\GalleryAdvancedWidget;
use App\Widgets\Builtin\Google360Widget;
use App\Widgets\Builtin\GoogleReviewsWidget;
use App\Widgets\Builtin\HeaderLanguageSwitcherWidget;
use App\Widgets\Builtin\HeaderLoginButtonWidget;
use App\Widgets\Builtin\HeadingWidget;
use App\Widgets\Builtin\HeroSlideWidget;
use App\Widgets\Builtin\HotspotWidget;
use App\Widgets\Builtin\IconBoxWidget;
use App\Widgets\Builtin\ImageBoxWidget;
use App\Widgets\Builtin\ImageComparisonWidget;
use App\Widgets\Builtin\ImageWidget;
use App\Widgets\Builtin\InteractiveMapWidget;
use App\Widgets\Builtin\LoginWidget;
use App\Widgets\Builtin\LogoGridWidget;
use App\Widgets\Builtin\LogoWidget;
use App\Widgets\Builtin\LottieWidget;
use App\Widgets\Builtin\MenuWidget;
use App\Widgets\Builtin\MultiChatWidget;
use App\Widgets\Builtin\MusicPlayerWidget;
use App\Widgets\Builtin\NewsletterSignupWidget;
use App\Widgets\Builtin\Object3DWidget;
use App\Widgets\Builtin\PortfolioWidget;
use App\Widgets\Builtin\PostsWidget;
use App\Widgets\Builtin\PriceListWidget;
use App\Widgets\Builtin\PriceTableWidget;
use App\Widgets\Builtin\ProgressBarWidget;
use App\Widgets\Builtin\PromoBannerWidget;
use App\Widgets\Builtin\SocialFeedWidget;
use App\Widgets\Builtin\SocialIconsWidget;
use App\Widgets\Builtin\SoundCloudWidget;
use App\Widgets\Builtin\StepFlowWidget;
use App\Widgets\Builtin\TabsWidget;
use App\Widgets\Builtin\TeamWidget;
use App\Widgets\Builtin\TestimonialWidget;
use App\Widgets\Builtin\TextWidget;
use App\Widgets\Builtin\ToggleCardsWidget;
use App\Widgets\Builtin\VideoHeroWidget;
use App\Widgets\Builtin\VideoMaskTextWidget;
use App\Widgets\Builtin\VideoWidget;
use App\Widgets\Builtin\WheelOfFortuneWidget;

class WidgetList
{
    public static function get(): array
    {
        return [
            // --- Header Widgets ---
            new HeaderLoginButtonWidget(),
            new HeaderLanguageSwitcherWidget(),

            // --- Footer Widgets ---
            new FooterAboutWidget(),
            new FooterBadgesWidget(),
            new FooterContactWidget(),
            new FooterCopyrightWidget(),
            new FooterLinksWidget(),
            new FooterNewsletterWidget(),

            // --- Core / Basic ---
            new HeadingWidget(),
            new TextWidget(),
            new ImageWidget(),
            new ContainerWidget(),
            new StructureContainerWidget(),
            new ButtonWidget(),
            new DividerWidget(),
            new CustomHtmlWidget(),
            new ProgressBarWidget(),
            new AlertWidget(),

            // --- Hero & Media ---
            new HeroSlideWidget(),
            new AnimatedHeroWidget(),
            new VideoHeroWidget(),
            new VideoWidget(),
            new ImageComparisonWidget(),
            new InteractiveMapWidget(),
            new Google360Widget(),
            new BasicGalleryWidget(),
            new GalleryAdvancedWidget(),
            new LottieWidget(),
            new HotspotWidget(),
            new VideoMaskTextWidget(),
            new Object3DWidget(),
            new LogoGridWidget(),
            new LogoWidget(),
            new MusicPlayerWidget(),
            new SoundCloudWidget(),

            // --- Content & Blog ---
            new PostsWidget(),
            new AccordionWidget(),
            new TabsWidget(),
            new ToggleCardsWidget(),
            new CounterWidget(),
            new CountdownWidget(),
            new TeamWidget(),
            new TestimonialWidget(),
            new BlockquoteWidget(),
            new StepFlowWidget(),
            new AnimatedHeadlineWidget(),
            new DualColorHeadingWidget(),
            new PriceListWidget(),
            new PriceTableWidget(),
            new CallToActionWidget(),
            new FlipBoxWidget(),

            // --- Marketing & Conversion ---
            new PromoBannerWidget(),
            new WheelOfFortuneWidget(),
            new CookieNoticeWidget(),
            new NewsletterSignupWidget(),
            new SocialFeedWidget(),
            new SocialIconsWidget(),
            new MultiChatWidget(),
            new ContactInfoWidget(),
            new BusinessHoursWidget(),
            new GoogleReviewsWidget(),
            new CurrencyRatesWidget(),

            // --- Forms & E-commerce ---
            new LoginWidget(),

            // --- Advanced / Developer ---
            new PortfolioWidget(),
            new CodeHighlightWidget(),

            // --- System / Menu ---
            new MenuWidget(),
        ];
    }
}
