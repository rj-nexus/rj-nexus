<?php

namespace Spotlight\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GitHubRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str; // Markdown üçün vacibdir

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
            $plugins = array_filter($plugins, function($p) use ($search) {
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

        // README-ni çəkirik
        $readmeHtml = $this->fetchReadme($plugin['docs']);

        return view('spotlight::directory.plugin-details', compact('plugin', 'readmeHtml'));
    }

    public function themes(Request $request)
    {
        $themes = $this->registry->enrichThemes();

        if ($search = $request->query('search')) {
            $themes = array_filter($themes, function($t) use ($search) {
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

        // README-ni çəkirik
        $readmeHtml = $this->fetchReadme($theme['docs']);

        return view('spotlight::directory.theme-details', compact('theme', 'readmeHtml'));
    }

    // README-ni GitHub-dan çəkən köməkçi funksiya
    private function fetchReadme($docsUrl)
    {
        // URL-dən owner və repo adını çıxarırıq (məs: rj-nexus/rj-commerce)
        if (preg_match('/github\.com\/([^\/]+)\/([^\/#]+)/', $docsUrl, $matches)) {
            $owner = $matches[1];
            $repo = $matches[2];

            // README-nin xam (raw) linki
            $rawUrl = "https://raw.githubusercontent.com/{$owner}/{$repo}/main/README.md";

            // 1 saatlıq kesh edirik ki, hər dəfə GitHub-a sorğu getməsin
            return Cache::remember("plugin_readme_{$owner}_{$repo}", 3600, function () use ($rawUrl) {
                try {
                    $response = Http::timeout(10)->get($rawUrl);
                    if ($response->successful()) {
                        // Markdown-u HTML-ə çeviririk
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
}