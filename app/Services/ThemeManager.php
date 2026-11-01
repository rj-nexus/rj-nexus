<?php

namespace App\Services;

use App\Models\Theme;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ThemeManager
{
    protected string $themesPath;
    protected static array $autoloaded = [];

    public function __construct()
    {
        $this->themesPath = base_path('rj-content/themes');
    }

    public function discover(): int
    {
        if (!File::isDirectory($this->themesPath)) {
            File::makeDirectory($this->themesPath, 0755, true);
            return 0;
        }

        $folders = File::directories($this->themesPath);
        $count = 0;

        foreach ($folders as $folder) {
            $manifestPath = $folder . '/theme.json';

            if (!File::exists($manifestPath)) {
                continue;
            }

            $manifest = json_decode(File::get($manifestPath), true);

            if (!is_array($manifest) || empty($manifest['name'])) {
                continue;
            }

            $slug = $manifest['slug'] ?? Str::slug($manifest['name']);

            Theme::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $manifest['name'],
                    'version' => $manifest['version'] ?? '1.0.0',
                    'description' => $manifest['description'] ?? null,
                    'author' => $manifest['author'] ?? null,
                    'author_url' => $manifest['author_url'] ?? null,
                    'preview_image' => $manifest['preview'] ?? null,
                    'folder' => basename($folder),
                    'is_child' => !empty($manifest['parent']),
                    'parent_slug' => $manifest['parent'] ?? null,
                    'supports' => $manifest['supports'] ?? [],
                    'metadata' => $manifest,
                ]
            );

            $count++;
        }

        // --- ƏLAVƏ: Əgər heç bir tema aktiv deyilsə, rj-default-u avtomatik aktiv et ---
        if (Theme::where('status', 'active')->count() === 0) {
            $defaultTheme = Theme::where('slug', 'rj-default')->first() ?? Theme::first();
            if ($defaultTheme) {
                $defaultTheme->markAsActive();
                // rj_options cədvəlini də sinxronlaşdıraq
                if (function_exists('rj_update_option')) {
                    rj_update_option('frontend_theme', $defaultTheme->slug);
                }
            }
        }

        return $count;
    }

    public function activate(Theme $theme): array
    {
        if ($theme->isActive()) {
            return ['success' => false, 'message' => __('Theme is already active.')];
        }

        if (!File::isDirectory($theme->path())) {
            $theme->markAsError(__('Theme directory not found.'));
            return ['success' => false, 'message' => __('Theme directory not found.')];
        }

        if ($theme->isChild() && $theme->parent_slug) {
            $parent = Theme::where('slug', $theme->parent_slug)->first();

            if (!$parent) {
                $theme->markAsError(__('Parent theme not found.'));
                return ['success' => false, 'message' => __('Parent theme not found.')];
            }
        }

        try {
            $theme->markAsActive();
            $this->clearCache();

            return ['success' => true, 'message' => __('Theme activated.')];
        } catch (\Throwable $e) {
            $theme->markAsError($e->getMessage());

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete(Theme $theme): array
    {
        if ($theme->isActive()) {
            return ['success' => false, 'message' => __('Cannot delete the active theme.')];
        }

        // --- ƏLAVƏ: Standart temanın silinməsinin qarşısını al ---
        if ($theme->slug === 'rj-default') {
            return ['success' => false, 'message' => __('Default system theme cannot be deleted.')];
        }

        try {
            $path = $theme->path();

            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            }

            $theme->customizations()->delete();
            $theme->delete();

            $this->clearCache();

            return ['success' => true, 'message' => __('Theme deleted.')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function installFromZip(UploadedFile $file): array
    {
        $tempPath = $file->getRealPath();

        $zip = new \ZipArchive();

        if ($zip->open($tempPath) !== true) {
            return ['success' => false, 'message' => __('Could not open ZIP archive.')];
        }

        $extractPath = storage_path('app/theme-temp/' . uniqid('theme_'));

        File::makeDirectory($extractPath, 0755, true);

        $zip->extractTo($extractPath);
        $zip->close();

        $manifestPath = $this->findManifest($extractPath);

        if (!$manifestPath) {
            File::deleteDirectory($extractPath);
            return ['success' => false, 'message' => __('theme.json not found in archive.')];
        }

        $manifest = json_decode(File::get($manifestPath), true);

        if (!is_array($manifest) || empty($manifest['name'])) {
            File::deleteDirectory($extractPath);
            return ['success' => false, 'message' => __('Invalid theme.json.')];
        }

        $slug = $manifest['slug'] ?? Str::slug($manifest['name']);

        if (Theme::where('slug', $slug)->exists()) {
            File::deleteDirectory($extractPath);
            return ['success' => false, 'message' => __('Theme already installed.')];
        }

        $sourceDir = dirname($manifestPath);
        $targetDir = $this->themesPath . '/' . basename($sourceDir);

        if (!File::isDirectory($this->themesPath)) {
            File::makeDirectory($this->themesPath, 0755, true);
        }

        File::moveDirectory($sourceDir, $targetDir, true);
        File::deleteDirectory($extractPath);

        $this->discover();

        return ['success' => true, 'message' => __('Theme uploaded.')];
    }

    public function export(Theme $theme): array
    {
        if (!File::isDirectory($theme->path())) {
            return ['success' => false, 'message' => __('Theme directory not found.')];
        }

        $filename = 'theme-' . $theme->slug . '-' . now()->format('Y-m-d-H-i-s') . '.zip';
        $zipPath = storage_path('app/exports/' . $filename);

        if (!File::isDirectory(dirname($zipPath))) {
            File::makeDirectory(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return ['success' => false, 'message' => __('Could not create ZIP archive.')];
        }

        $this->addDirectoryToZip($zip, $theme->path(), basename($theme->path()));

        $zip->close();

        return [
            'success' => true,
            'path' => $zipPath,
            'filename' => $filename,
            'message' => __('Theme exported.'),
        ];
    }

    public function customizerSchema(Theme $theme): array
    {
        $manifest = $theme->metadata();

        if (empty($manifest['customizer'])) {
            return [];
        }

        return $manifest['customizer'];
    }

    public function customizerSections(Theme $theme): array
    {
        $schema = $this->customizerSchema($theme);
        $sections = [];

        foreach ($schema['sections'] ?? [] as $key => $section) {
            $sections[$key] = [
                'label' => $section['label'] ?? $key,
                'icon' => $section['icon'] ?? null,
                'controls' => $section['controls'] ?? [],
            ];
        }

        return $sections;
    }

    public function clearCache(): void
    {
        Cache::forget('rj_active_theme');
        Cache::forget('rj_theme_schema');
        Cache::forget('rj_theme_customizations');
        Cache::forget('rj_widget_registry');
    }

    public function checkForUpdates(): array
    {
        $count = 0;

        foreach (Theme::all() as $theme) {
            $metadata = $theme->metadata();
            $updateUrl = $metadata['update_url'] ?? null;

            if (!$updateUrl) {
                continue;
            }

            try {
                $response = \Illuminate\Support\Facades\Http::timeout(10)->get($updateUrl);

                if (!$response->successful()) {
                    continue;
                }

                $remote = $response->json();

                if (!empty($remote['version']) && version_compare($remote['version'], $theme->version, '>')) {
                    $count++;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return ['success' => true, 'count' => $count];
    }

    public function updatesAvailable(): int
    {
        $count = 0;

        foreach (Theme::all() as $theme) {
            $metadata = $theme->metadata();

            if (!empty($metadata['latest_version']) && version_compare($metadata['latest_version'], $theme->version, '>')) {
                $count++;
            }
        }

        return $count;
    }

    public function update(Theme $theme): array
    {
        $metadata = $theme->metadata();
        $downloadUrl = $metadata['download_url'] ?? null;

        if (!$downloadUrl) {
            return ['success' => false, 'message' => __('No update source configured.')];
        }

        if ($theme->isActive()) {
            return ['success' => false, 'message' => __('Deactivate the theme before updating.')];
        }

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(60)->get($downloadUrl);

            if (!$response->successful()) {
                return ['success' => false, 'message' => __('Could not download update.')];
            }

            $tmpFile = tempnam(sys_get_temp_dir(), 'theme_update_');
            file_put_contents($tmpFile, $response->body());

            $fake = new UploadedFile($tmpFile, 'update.zip', 'application/zip', null, true);

            $result = $this->installFromZip($fake);

            if (!$result['success']) {
                return $result;
            }

            $newTheme = Theme::where('slug', $theme->slug)->first();

            if ($newTheme) {
                $newTheme->update(['version' => $metadata['latest_version'] ?? $newTheme->version]);
            }

            return ['success' => true, 'message' => __('Theme updated.')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function previewToken(Theme $theme): string
    {
        $token = hash_hmac('sha256', $theme->slug . '|' . auth()->id(), config('app.key'));

        session(['rj_theme_preview_token' => $token]);
        session(['rj_theme_preview_slug' => $theme->slug]);

        return $token;
    }

    public function verifyPreviewToken(string $token): ?Theme
    {
        $slug = session('rj_theme_preview_slug');
        $stored = session('rj_theme_preview_token');

        if (!$slug || !$stored || !hash_equals($stored, $token)) {
            return null;
        }

        return Theme::where('slug', $slug)->first();
    }

    public function activeTheme(): ?Theme
    {
        try {
            return Cache::remember('rj_active_theme', 3600, function () {
                // Bazada həm active_theme, həm də frontend_theme axtarılır
                $slug = rj_get_option('frontend_theme', rj_get_option('active_theme', ''));

                if ($slug) {
                    $theme = Theme::where('slug', $slug)->where('status', 'active')->first();
                    if ($theme) {
                        return $theme;
                    }
                }

                // Əgər aktiv tapılmasa, hər hansı aktiv temanı götür
                $active = Theme::where('status', 'active')->first();
                if ($active) {
                    return $active;
                }

                // --- ULTIMATE FALLBACK: rj-default-u məcburi aktiv et ---
                $default = Theme::where('slug', 'rj-default')->first() ?? Theme::first();
                if ($default) {
                    $default->markAsActive();
                    return $default;
                }

                return null;
            });
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function childTheme(Theme $parent): ?Theme
    {
        $slug = rj_get_option('child_theme_' . $parent->slug, '');

        if ($slug) {
            $child = Theme::where('slug', $slug)->where('is_child', true)->first();

            if ($child) {
                return $child;
            }
        }

        return Theme::where('parent_slug', $parent->slug)->where('status', 'active')->first();
    }

    public function registerViews(): void
    {
        $theme = $this->activeTheme();

        if (!$theme) {
            return;
        }

        $path = $theme->viewPath();

        if (!File::isDirectory($path)) {
            return;
        }

        $child = $this->childTheme($theme);

        if ($child) {
            $childPath = $child->viewPath();

            if (File::isDirectory($childPath)) {
                view()->prependNamespace('theme', $childPath);
            }
        }

        view()->addNamespace('theme', $path);
    }

    public function registerProviders(): void
    {
        $theme = $this->activeTheme();

        if (!$theme) {
            return;
        }

        $manifest = $theme->metadata();
        $providerClass = $manifest['provider'] ?? null;
        $namespace = $manifest['namespace'] ?? null;

        if (!$providerClass || !$namespace) {
            return;
        }

        $srcPath = $theme->path() . '/src';
        if (File::isDirectory($srcPath)) {
            $key = 'theme_' . $theme->slug;
            if (!isset(static::$autoloaded[$key])) {
                static::$autoloaded[$key] = true;

                $namespacePrefix = rtrim($namespace, '\\') . '\\';
                $srcPath = str_replace('\\', '/', rtrim($srcPath, '/'));

                spl_autoload_register(function ($class) use ($namespacePrefix, $srcPath) {
                    if (!str_starts_with($class, $namespacePrefix)) {
                        return;
                    }

                    $relative = substr($class, strlen($namespacePrefix));
                    $file = $srcPath . '/' . str_replace('\\', '/', $relative) . '.php';

                    if (File::exists($file)) {
                        require_once $file;
                    }
                });
            }
        }

        if (class_exists($providerClass)) {
            try {
                app()->register($providerClass);
            } catch (\Throwable $e) {
            }
        }
    }

    public function renderView(string $view, array $data = [])
    {
        $theme = $this->activeTheme();

        if ($theme) {
            $themeView = 'theme::' . $view;

            try {
                if (view()->exists($themeView)) {
                    return view($themeView, $data);
                }
            } catch (\Throwable $e) {
            }
        }

        // --- Fallback 1: resources/views/frontend/... ---
        if (view()->exists('frontend.' . $view)) {
            return view('frontend.' . $view, $data);
        }

        // --- ULTIMATE FALLBACK: Xəta vermək yerinə sadə HTML qaytar ---
        return response(
            '<html><head><title>RJ Nexus</title></head><body style="font-family:sans-serif;padding:2rem;text-align:center;">'
            . '<h1 style="color:#7c3aed;">RJ Nexus işləyir ✓</h1>'
            . '<p>Tema faylları yoxdur və ya <code>frontend.' . e($view) . '</code> tapılmadı.</p>'
            . '<p>Zəhmət olmasa admin panelindən <b>rj-default</b> temasını aktiv edin.</p>'
            . '<a href="/admin">Admin Panelinə Keç</a>'
            . '</body></html>',
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }

    public function renderPath(string $view = ''): string
    {
        $active = $this->activeTheme();

        if (!$active) {
            return '';
        }

        $child = $this->childTheme($active);

        if ($child && File::exists($child->viewPath($view))) {
            return $child->viewPath($view);
        }

        return $active->viewPath($view);
    }

    public function resolveAsset(string $slug, string $path): ?string
    {
        $theme = Theme::where('slug', $slug)->first();

        if (!$theme) {
            return null;
        }

        $fullPath = $theme->path() . '/assets/' . ltrim($path, '/');

        $real = realpath($fullPath);
        $base = realpath($theme->path() . '/assets');

        if (!$real || !$base || !str_starts_with($real, $base)) {
            return null;
        }

        if (!File::isFile($real)) {
            return null;
        }

        return $real;
    }

    protected function addDirectoryToZip(\ZipArchive $zip, string $dir, string $base): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $filePath = $file->getRealPath();
            $relative = $base . '/' . substr($filePath, strlen($dir) + 1);

            $zip->addFile($filePath, $relative);
        }
    }

    protected function findManifest(string $dir): ?string
    {
        $direct = $dir . '/theme.json';

        if (File::exists($direct)) {
            return $direct;
        }

        $folders = File::directories($dir);

        foreach ($folders as $folder) {
            $path = $folder . '/theme.json';

            if (File::exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
