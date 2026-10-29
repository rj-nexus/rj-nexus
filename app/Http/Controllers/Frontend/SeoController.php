<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function sitemap()
    {
        if (rj_get_option('sitemap_enabled', '1') !== '1') {
            abort(404);
        }

        $posts = collect();
        if (rj_get_option('sitemap_include_posts', '1') === '1') {
            $posts = Post::where('type', 'post')
                ->where('status', 'published')
                ->orderByDesc('updated_at')
                ->get();
        }

        $pages = collect();
        if (rj_get_option('sitemap_include_pages', '1') === '1') {
            $pages = Post::where('type', 'page')
                ->where('status', 'published')
                ->orderByDesc('updated_at')
                ->get();
        }

        $categories = collect();
        if (rj_get_option('sitemap_include_categories', '1') === '1') {
            $categories = Category::ordered()->get();
        }

        return response()->view('frontend.sitemap', compact('posts', 'pages', 'categories'))
            ->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content = rj_get_option('robots_txt', '');

        if (empty($content)) {
            $content = "User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml');
        }

        return response($content)->header('Content-Type', 'text/plain');
    }
}
