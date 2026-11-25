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
        $table = (new Post)->getTable();
        $available = Schema::getColumnListing($table);

        $wanted = ['id', 'title', 'slug', 'excerpt', 'summary', 'description', 'meta_description', 'content', 'featured_image'];
        $columns = array_values(array_intersect($wanted, $available));

        $query = Post::query()->select($columns);

        if (in_array('status', $available, true)) {
            $query->where('status', 'published');
        }

        foreach (['type', 'post_type'] as $col) {
            if (in_array($col, $available, true)) {
                $query->where($col, 'post');
                break;
            }
        }

        $query->orderByDesc(in_array('created_at', $available, true) ? 'created_at' : 'id');

        $posts = $query->take(100)->get()->map(function ($post) use ($columns) {
            $text = '';

            foreach (['excerpt', 'summary', 'description', 'meta_description', 'content'] as $field) {
                if (!in_array($field, $columns, true)) {
                    continue;
                }

                $text = $this->plainText($post->getAttribute($field));

                if ($text !== '') {
                    break;
                }
            }

            return [
                'id' => $post->id,
                'title' => $this->plainText($post->getAttribute('title')),
                'excerpt' => Str::limit($text, 200),
                'image' => $this->absoluteUrl($post->getAttribute('featured_image')),
            ];
        })->values();

        $siteLogo = $this->absoluteUrl(
            rj_site_option('logo_light')
                ?: rj_site_option('logo_dark')
                ?: rj_get_option('site_logo')
                ?: rj_get_option('logo')
        );

        $brand = rj_get_option('site_name') ?: config('app.name', 'RJ Nexus');
        $domain = request()->getHost();

        return view('admin.tools.marketing', compact('posts', 'siteLogo', 'brand', 'domain'));
    }

    private function plainText($value): string
    {
        if ($value === null) {
            return '';
        }

        if (is_string($value)) {
            $trimmed = ltrim($value);

            if ($trimmed !== '' && in_array($trimmed[0], ['{', '['], true)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $value = $decoded;
                }
            }
        }

        if (is_array($value)) {
            $locale = app()->getLocale();

            if (isset($value[$locale]) && is_string($value[$locale])) {
                return $this->plainText($value[$locale]);
            }

            $parts = [];

            array_walk_recursive($value, function ($item) use (&$parts) {
                if (is_string($item) && mb_strlen($item) > 15 && preg_match('/\s/u', $item)) {
                    $parts[] = $item;
                }
            });

            $value = implode(' ', $parts);
        }

        $value = (string) $value;
        $value = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', ' ', $value);
        $value = strip_tags($value);
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $value));
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