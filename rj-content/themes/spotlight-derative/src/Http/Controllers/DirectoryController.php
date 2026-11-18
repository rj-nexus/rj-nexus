<?php

namespace Spotlight\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GitHubRegistry;

class DirectoryController extends Controller
{
    protected GitHubRegistry $registry;

    public function __construct()
    {
        // Mövcud olan GitHubRegistry servisini çağırırıq
        $this->registry = app(GitHubRegistry::class);
    }

    public function plugins()
    {
        $plugins = $this->registry->enrichPlugins();
        return view('spotlight::directory.plugins', compact('plugins'));
    }

    public function pluginDetails($slug)
    {
        $plugins = $this->registry->enrichPlugins();
        $plugin = collect($plugins)->firstWhere('slug', $slug);
        
        if (!$plugin) {
            abort(404);
        }

        return view('spotlight::directory.plugin-details', compact('plugin'));
    }

    public function themes()
    {
        $themes = $this->registry->enrichThemes();
        return view('spotlight::directory.themes', compact('themes'));
    }

    public function themeDetails($slug)
    {
        $themes = $this->registry->enrichThemes();
        $theme = collect($themes)->firstWhere('slug', $slug);
        
        if (!$theme) {
            abort(404);
        }

        return view('spotlight::directory.theme-details', compact('theme'));
    }
}