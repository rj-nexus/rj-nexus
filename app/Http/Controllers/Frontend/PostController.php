<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Term;
use App\Services\ThemeManager;
use App\Services\ThemeResolver;
use Illuminate\Http\Request;

class PostController extends Controller
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
        $post = Post::with(['author', 'categories', 'tags', 'translations', 'template'])
            ->where('type', 'post')
            ->published()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhereHas('translations', function ($inner) use ($slug) {
                      $inner->where('slug', $slug);
                  });
            })
            ->firstOrFail();

        $correctSlug = $post->localizedSlug($locale);

        if ($correctSlug === '') {
            abort(404);
        }

        if ($slug !== $correctSlug) {
            return redirect()->to('/' . $locale . '/blog/' . $correctSlug, 301);
        }

        // Header-in düzgün dili (və slug-ı) görməsi üçün postu əvvəlcədən paylaşırıq
        view()->share('post', $post);

        $post->incrementViews();

        $related = Post::where('type', 'post')
            ->published()
            ->where('id', '!=', $post->id)
            ->when($post->categories->isNotEmpty(), function ($q) use ($post) {
                $q->whereHas('categories', function ($inner) use ($post) {
                    $inner->whereIn('rj_categories.id', $post->categories->pluck('id'));
                });
            })
            ->latest('published_at')
            ->limit(4)
            ->get();

        $header = $this->resolver->header();
        $footer = $this->resolver->footer();

        return $this->themes->renderView('single-post', [
            'post' => $post,
            'related' => $related,
            'header' => $header,
            'footer' => $footer,
            'title' => $post->title,
        ]);
    }
}
