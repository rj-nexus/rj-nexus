<?php

namespace Spotlight\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GitHubRegistry;
use Illuminate\Http\Request;

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
        
        if (!$plugin) {
            abort(404, 'Plugin tapılmadı: ' . $slug);
        }

        return view('spotlight::directory.plugin-details', compact('plugin'));
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
        
        if (!$theme) {
            abort(404, 'Tema tapılmadı: ' . $slug);
        }

        return view('spotlight::directory.theme-details', compact('theme'));
    }
}