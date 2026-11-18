<?php

namespace Spotlight\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GitHubRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    protected GitHubRegistry $registry;

    public function __construct()
    {
        $this->registry = app(GitHubRegistry::class);
    }

    public function plugins(Request $request)
    {
        $plugins = $this->registry->enrichPlugins();

        if ($search = $request->query('search')) {
            $plugins = array_filter($plugins, function ($p) use ($search) {
                return stripos($p['name'], $search) !== false || stripos($p['description'], $search) !== false;
            });
        }

        return view('spotlight::directory.plugins', compact('plugins'));
    }

    public function pluginDetails(Request $request, $locale, $slug)
    {
        $plugins = $this->registry->enrichPlugins();
        $plugin = collect($plugins)->firstWhere('slug', $slug);

        if (!$plugin) abort(404);

        $readmeHtml = $this->fetchReadme($plugin['docs']);

        return view('spotlight::directory.plugin-details', compact('plugin', 'readmeHtml'));
    }

    public function themes(Request $request)
    {
        $themes = $this->registry->enrichThemes();

        if ($search = $request->query('search')) {
            $themes = array_filter($themes, function ($t) use ($search) {
                return stripos($t['name'], $search) !== false || stripos($t['description'], $search) !== false;
            });
        }

        return view('spotlight::directory.themes', compact('themes'));
    }

    public function themeDetails(Request $request, $locale, $slug)
    {
        $themes = $this->registry->enrichThemes();
        $theme = collect($themes)->firstWhere('slug', $slug);

        if (!$theme) abort(404);

        $readmeHtml = $this->fetchReadme($theme['docs']);

        return view('spotlight::directory.theme-details', compact('theme', 'readmeHtml'));
    }

    public function docs(Request $request, $locale, $slug = null)
    {
        $menu = $this->fetchJson('https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/documents/menu.json');
        $searchIndex = $this->fetchJson('https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/documents/documentation/search.json');

        if (!$slug && !empty($menu)) {
            $slug = $menu[0]['slug'] ?? 'getting-started';
        }

        $contentHtml = null;
        $docTitle = null;

        if ($slug) {
            if (!empty($menu)) {
                foreach ($menu as $item) {
                    if (($item['slug'] ?? '') === $slug) {
                        $docTitle = $item['title'] ?? $slug;
                        break;
                    }
                }
            }

            $rawUrl = "https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/documents/documentation/content/{$slug}.md";
            $md = $this->fetchRaw($rawUrl, 3600);

            if ($md) {
                $contentHtml = Str::markdown($md);
            }
        }

        return view('spotlight::directory.docs', compact('menu', 'searchIndex', 'slug', 'contentHtml', 'docTitle'));
    }

    private function fetchReadme($docsUrl)
    {
        if (preg_match('/github\.com\/([^\/]+)\/([^\/#]+)/', $docsUrl, $matches)) {
            $owner = $matches[1];
            $repo = $matches[2];
            $rawUrl = "https://raw.githubusercontent.com/{$owner}/{$repo}/main/README.md";

            return Cache::remember("plugin_readme_{$owner}_{$repo}", 3600, function () use ($rawUrl) {
                try {
                    $response = Http::timeout(10)->get($rawUrl);
                    if ($response->successful()) {
                        return Str::markdown($response->body());
                    }
                } catch (\Exception $e) {
                    return null;
                }
                return null;
            });
        }
        return null;
    }

    private function fetchJson(string $url): array
    {
        $cacheKey = 'rj_docs_json_' . md5($url);

        return Cache::remember($cacheKey, 3600, function () use ($url) {
            try {
                $response = Http::timeout(10)->get($url);
                if ($response->successful()) {
                    $data = $response->json();
                    return is_array($data) ? $data : [];
                }
            } catch (\Exception $e) {
                return [];
            }
            return [];
        });
    }

    private function fetchRaw(string $url, int $ttl = 3600): ?string
    {
        $cacheKey = 'rj_docs_raw_' . md5($url);

        return Cache::remember($cacheKey, $ttl, function () use ($url) {
            try {
                $response = Http::timeout(10)->get($url);
                if ($response->successful()) {
                    return $response->body();
                }
            } catch (\Exception $e) {
                return null;
            }
            return null;
        });
    }
}