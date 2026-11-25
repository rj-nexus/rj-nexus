<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    public function index()
    {
        $query = Post::query()->where('status', 'published');

        if (Schema::hasColumn('posts', 'type')) {
            $query->where('type', 'post');
        }

        $posts = $query
            ->orderByDesc('created_at')
            ->take(100)
            ->get(['id', 'title', 'content', 'featured_image'])
            ->map(fn ($post) => [
                'id' => $post->id,
                'title' => (string) $post->title,
                'excerpt' => Str::limit(
                    trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode((string) $post->content)))),
                    160
                ),
                'image' => $this->absoluteUrl($post->featured_image),
            ])
            ->values();

        $siteLogo = $this->absoluteUrl(
            rj_site_option('logo_light')
                ?: rj_site_option('logo_dark')
                ?: rj_get_option('site_logo')
                ?: rj_get_option('logo')
        );

        $brand = rj_get_option('site_name') ?: config('app.name', 'RJ Nexus');

        return view('admin.tools.marketing', compact('posts', 'siteLogo', 'brand'));
    }

    private function absoluteUrl($path): string
    {
        if (empty($path) || !is_string($path)) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}