<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ThemeManager;
use App\Services\ThemeResolver;

class PageController extends Controller
{
    protected ThemeResolver $resolver;
    protected ThemeManager $themes;

    public function __construct(ThemeResolver $resolver, ThemeManager $themes)
    {
        $this->resolver = $resolver;
        $this->themes = $themes;
    }

    public function show(string $locale, string $slug)
    {
        $baseLocale = config('app.locale');

        $query = Post::with(['author', 'translations', 'template'])
            ->where('type', 'page')
            ->published();

        if ($locale === $baseLocale) {
            $query->where(function ($q) use ($slug, $locale) {
                $q->where('slug', $slug)
                  ->orWhereHas('translations', function ($inner) use ($slug, $locale) {
                      $inner->where('slug', $slug)->where('locale', $locale);
                  });
            });
        } else {
            $query->whereHas('translations', function ($inner) use ($slug, $locale) {
                $inner->where('slug', $slug)->where('locale', $locale);
            });
        }

        $page = $query->firstOrFail();

        view()->share('post', $page);

        if ($page->isFrontPage()) {
            return redirect()->to(url('/' . $locale), 301);
        }

        $page->incrementViews();

        $header = $this->resolver->header();
        $footer = $this->resolver->footer();

        if ($page->isThemeMode() && $page->theme_template) {
            $themeView = 'theme::templates.' . $page->theme_template;

            try {
                if (view()->exists($themeView)) {
                    return view($themeView, [
                        'page' => $page,
                        'header' => $header,
                        'footer' => $footer,
                        'title' => $page->title,
                    ]);
                }
            } catch (\Throwable $e) {
            }
        }

        return $this->themes->renderView('single-page', [
            'page' => $page,
            'header' => $header,
            'footer' => $footer,
            'title' => $page->title,
        ]);
    }
}
