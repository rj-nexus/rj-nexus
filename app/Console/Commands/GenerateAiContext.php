<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class GenerateAiContext extends Command
{
    protected $signature = 'rj:context {--output=storage/app/ai-context.md}';
    protected $description = 'Generate AI context file with project structure and status';

    public function handle(): int
    {
        $this->info('Scanning project...');

        $sections = [
            'Project Overview' => $this->projectOverview(),
            'Tech Stack' => $this->techStack(),
            'AI Architecture' => $this->aiArchitecture(),
            'Languages & Localization' => $this->languages(),
            'Directory Structure' => $this->directoryStructure(),
            'Database Tables' => $this->databaseTables(),
            'Models' => $this->models(),
            'Controllers' => $this->controllers(),
            'Routes' => $this->routes(),
            'Views' => $this->views(),
            'Settings Status' => $this->settingsStatus(),
            'Sidebar Status' => $this->sidebarStatus(),
            'Helpers' => $this->helpers(),
            'Recent Git Commits' => $this->gitCommits(),
            'Conventions' => $this->conventions(),
        ];

        $output = "# RJ Nexus — AI Context\n";
        $output .= "_Generated: " . now()->format('Y-m-d H:i:s') . "_\n\n";

        foreach ($sections as $title => $content) {
            $output .= "## {$title}\n\n{$content}\n\n";
        }

        $path = base_path($this->option('output'));
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, $output);

        $this->info("Context written to: {$path}");
        $this->line("Size: " . round(strlen($output) / 1024, 1) . " KB");
        $this->line("Lines: " . substr_count($output, "\n"));

        return self::SUCCESS;
    }

    protected function projectOverview(): string
    {
        $name = rj_get_option('site_name', config('app.name'));
        $version = rj_get_option('rj_version', '1.8.2');

        return "- **Name:** RJ Nexus (RJ CMS)\n"
            . "- **Version:** {$version} (RJ CORE 1 / Altair Series)\n"
            . "- **Type:** Self-hosted CMS (WordPress alternative)\n"
            . "- **Site Name:** {$name}\n"
            . "- **Admin URL:** " . url('/admin') . "\n"
            . "- **Environment:** " . app()->environment() . "\n"
            . "- **Debug Mode:** " . (config('app.debug') ? 'ON' : 'OFF') . "\n";
    }

    protected function techStack(): string
    {
        return "- **Backend:** Laravel " . app()->version() . " (PHP " . PHP_VERSION . ")\n"
            . "- **Frontend:** Blade + Tailwind CSS v3\n"
            . "- **JS:** Alpine.js\n"
            . "- **Build Tool:** Vite\n"
            . "- **Database:** " . config('database.default') . " (" . config('database.connections.mysql.database') . ")\n"
            . "- **Auth:** Laravel Breeze (Blade) + 2FA\n"
            . "- **Prefix:** `rj_` (tables, functions, routes, constants)\n"
            . "- **Timezone:** " . config('app.timezone') . "\n"
            . "- **Locale:** " . config('app.locale') . "\n";
    }

    protected function aiArchitecture(): string
    {
        return "- **Free AI (Dashboard & Search):** Keyless, uses Cloudflare Proxy (Groq, Mistral, Pollinations, LLM7). Used for Ctrl+K search and AI support.\n"
            . "- **OpenRouter AI (SEO, Code, Translation):** Requires user API key from Admin Settings.\n"
            . "- **RAG System:** Reads `resources/docs/` for answers.\n";
    }

    protected function languages(): string
    {
        $locales = function_exists('rj_available_locales') ? rj_available_locales() : [];
        $frontend = function_exists('rj_frontend_locales') ? rj_frontend_locales() : [];

        $out = "- **Available Languages (17):** " . implode(', ', $locales) . "\n";
        $out .= "- **Active Frontend Languages:** " . implode(', ', $frontend) . "\n";
        $out .= "- **Per-Language Slugs:** Implemented in `rj_post_translations` table.\n";

        return $out;
    }

    protected function directoryStructure(): string
    {
        $root = base_path();
        $paths = [
            'app/Http/Controllers/Admin',
            'app/Http/Controllers/Admin/Settings',
            'app/Http/Controllers/Auth',
            'app/Http/Controllers/Frontend',
            'app/Models',
            'app/Services',
            'app/Mail',
            'app/Helpers',
            'app/Widgets',
            'app/DynamicTags',
            'app/Observers',
            'app/Console/Commands',
            'installer',
            'database/migrations',
            'database/seeders',
            'resources/views/admin',
            'resources/views/admin/settings',
            'resources/views/auth',
            'resources/views/frontend',
            'resources/views/errors',
            'resources/views/rjbuilder',
            'resources/css',
            'resources/js',
            'routes',
            'lang',
            'rj-content/themes',
            'rj-content/plugins',
            'public/images',
        ];

        $out = "";

        foreach ($paths as $rel) {
            $full = $root . '/' . $rel;

            if (!is_dir($full)) {
                continue;
            }

            $out .= "### `{$rel}/`\n\n";

            $files = array_diff(scandir($full), ['.', '..']);

            if (empty($files)) {
                $out .= "_empty_\n\n";
                continue;
            }

            foreach ($files as $file) {
                $marker = is_dir($full . '/' . $file) ? '[DIR]' : '[FILE]';
                $out .= "- {$marker} `{$file}`\n";
            }

            $out .= "\n";
        }

        return $out;
    }

    protected function databaseTables(): string
    {
        try {
            $tables = \DB::select('SHOW TABLES');
            $key = 'Tables_in_' . config('database.connections.mysql.database');

            $out = "";
            $rowCounts = [];

            foreach ($tables as $table) {
                $name = $table->$key;
                $count = \DB::table($name)->count();
                $rowCounts[$name] = $count;
            }

            ksort($rowCounts);

            $out .= "| Table | Rows |\n|---|---|\n";

            foreach ($rowCounts as $name => $count) {
                $out .= "| `{$name}` | {$count} |\n";
            }

            return $out;
        } catch (\Throwable $e) {
            return "_Could not read tables: " . $e->getMessage() . "_";
        }
    }

    protected function models(): string
    {
        $path = app_path('Models');
        $files = File::files($path);

        $out = "| Model | Table |\n|---|---|\n";

        foreach ($files as $file) {
            $name = $file->getFilenameWithoutExtension();
            $class = "App\\Models\\{$name}";

            if (!class_exists($class)) {
                continue;
            }

            try {
                $table = (new $class)->getTable();
                $out .= "| `{$name}` | `{$table}` |\n";
            } catch (\Throwable $e) {
                $out .= "| `{$name}` | _error_ |\n";
            }
        }

        return $out;
    }

    protected function controllers(): string
    {
        $base = app_path('Http/Controllers');

        $groups = [
            'Admin' => $base . '/Admin',
            'Admin/Settings' => $base . '/Admin/Settings',
            'Auth' => $base . '/Auth',
            'Frontend' => $base . '/Frontend',
            'Root' => $base,
        ];

        $out = "";

        foreach ($groups as $label => $dir) {
            if (!is_dir($dir)) {
                continue;
            }

            $out .= "### {$label}\n\n";

            foreach (File::files($dir) as $file) {
                $out .= "- `{$file->getFilename()}`\n";
            }

            $out .= "\n";
        }

        return $out;
    }

    protected function routes(): string
    {
        $routeFiles = ['web.php', 'admin.php', 'auth.php', 'frontend.php', 'console.php'];
        $out = "";

        foreach ($routeFiles as $file) {
            $path = base_path('routes/' . $file);

            if (!file_exists($path)) {
                continue;
            }

            $size = round(filesize($path) / 1024, 1);
            $lines = count(file($path));

            $out .= "- `routes/{$file}` — {$lines} lines, {$size} KB\n";
        }

        $out .= "\n### Route Counts by Prefix\n\n";

        $routes = Route::getRoutes();
        $groups = [];

        foreach ($routes as $route) {
            $name = $route->getName() ?? '';
            $prefix = explode('.', $name)[0] ?? 'unnamed';
            $groups[$prefix] = ($groups[$prefix] ?? 0) + 1;
        }

        ksort($groups);

        foreach ($groups as $prefix => $count) {
            $out .= "- `{$prefix}.*` — {$count} routes\n";
        }

        return $out;
    }

    protected function views(): string
    {
        $out = "";

        $out .= "### Admin Views\n\n";
        $out .= $this->scanViews(resource_path('views/admin'), 'admin');

        $out .= "### Frontend Views\n\n";
        $out .= $this->scanViews(resource_path('views/frontend'), 'frontend');

        $out .= "### Auth Views\n\n";
        $out .= $this->scanViews(resource_path('views/auth'), 'auth');

        $out .= "### Error Views\n\n";
        $out .= $this->scanViews(resource_path('views/errors'), 'errors');

        $out .= "### RJBuilder Views\n\n";
        $out .= $this->scanViews(resource_path('views/rjbuilder'), 'rjbuilder');

        return $out;
    }

    protected function scanViews(string $dir, string $prefix): string
    {
        if (!is_dir($dir)) {
            return "_No views_\n";
        }

        $out = "";
        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $full = $dir . '/' . $item;

            if (is_dir($full)) {
                $out .= "**{$prefix}/{$item}/**\n";
                foreach (array_diff(scandir($full), ['.', '..']) as $sub) {
                    if (is_dir($full . '/' . $sub)) {
                        continue;
                    }
                    $out .= "- `{$prefix}/{$item}/{$sub}`\n";
                }
                $out .= "\n";
            } else {
                $out .= "- `{$prefix}/{$item}`\n";
            }
        }

        return $out;
    }

    protected function settingsStatus(): string
    {
        $settings = [
            'General' => 'general',
            'Writing' => 'writing',
            'Reading' => 'reading',
            'Discussion' => 'discussion',
            'Media' => 'media',
            'Permalinks' => 'permalinks',
            'Language' => 'language',
            'Colors' => 'colors',
            'SEO' => 'seo',
            'Email / SMTP' => 'email',
            'Security' => 'security',
            'Backup' => 'backup',
            'Cache' => 'cache',
            'Social Login' => 'social',
            'Notifications' => 'notifications',
            'API & Integrations' => 'api',
            'AI' => 'ai',
            'Advanced' => 'advanced',
            'Roles' => 'roles',
        ];

        $routes = Route::getRoutes();
        $out = "| Tab | Route | Controller | Status |\n|---|---|---|---|\n";

        foreach ($settings as $label => $key) {
            $routeName = "admin.settings.{$key}";
            $route = null;

            foreach ($routes as $r) {
                if ($r->getName() === $routeName) {
                    $route = $r;
                    break;
                }
            }

            if (!$route) {
                $out .= "| {$label} | `{$routeName}` | — | [MISSING] |\n";
                continue;
            }

            $action = $route->getActionName();
            $controller = '—';
            $status = '[SOON]';

            if (str_contains($action, 'RedirectController')) {
                $status = '[REDIRECT]';
                $controller = '`redirect`';
            } elseif (str_contains($action, 'Controller') && str_contains($action, '@')) {
                $parts = explode('@', $action);
                $controllerClass = class_basename($parts[0] ?? '');
                $method = $parts[1] ?? 'index';
                $controller = "`{$controllerClass}@{$method}`";
                $status = '[OK]';
            } elseif (str_contains($action, 'view')) {
                $status = '[VIEW]';
            }

            $out .= "| {$label} | `{$routeName}` | {$controller} | {$status} |\n";
        }

        return $out;
    }

    protected function sidebarStatus(): string
    {
        $sections = [
            'Dashboard' => ['admin.dashboard'],
            'Posts' => ['admin.posts.index'],
            'Pages' => ['admin.pages.index'],
            'Media' => ['admin.media.index'],
            'Comments' => ['admin.comments.index'],
            'Appearance' => ['admin.appearance.index'],
            'Plugins' => ['admin.plugins.index'],
            'AI Center' => ['admin.ai.index'],
            'Users' => ['admin.users.index'],
            'Support' => ['admin.support.index'],
            'Tools' => ['admin.tools.index'],
            'Updates' => ['admin.updates.index'],
            'Settings' => ['admin.settings.index'],
            'RJ About' => ['admin.about.index'],
        ];

        $routes = Route::getRoutes();
        $out = "| Section | Status | Notes |\n|---|---|---|\n";

        foreach ($sections as $label => $names) {
            $status = '[MISSING]';
            $note = '';

            foreach ($names as $routeName) {
                foreach ($routes as $r) {
                    if ($r->getName() === $routeName) {
                        $action = $r->getActionName();

                        if (str_contains($action, 'Controller') && !str_contains($action, 'coming-soon')) {
                            $status = '[OK]';
                        } elseif (str_contains($action, 'view')) {
                            $status = '[PLACEHOLDER]';
                        }
                        break 2;
                    }
                }
            }

            $out .= "| {$label} | {$status} | {$note} |\n";
        }

        return $out;
    }

    protected function helpers(): string
    {
        $path = app_path('Helpers/rj.php');

        if (!file_exists($path)) {
            return "_No helpers file_";
        }

        $content = file_get_contents($path);
        preg_match_all('/function\s+(rj_\w+)\s*\(/', $content, $matches);

        $out = "Functions in `app/Helpers/rj.php`:\n\n";

        foreach ($matches[1] as $fn) {
            $out .= "- `{$fn}()`\n";
        }

        return $out;
    }

    protected function gitCommits(): string
    {
        try {
            $output = shell_exec('git log --oneline -20 2>&1');

            if (!$output) {
                return "_No git history_";
            }

            $lines = explode("\n", trim($output));
            $out = "";

            foreach ($lines as $line) {
                $out .= "- `{$line}`\n";
            }

            return $out;
        } catch (\Throwable $e) {
            return "_Git not available_";
        }
    }

    protected function conventions(): string
    {
        return "- **Prefix:** `rj_` for tables, functions, routes\n"
            . "- **Translations:** UI texts in `__()`\n"
            . "- **Tailwind:** v3 with CSS variables for colors\n"
            . "- **Commit format:** `lowercase verb + description`\n"
            . "- **Color palette:** via `rj_color_presets()` helper\n"
            . "- **Options:** stored in `rj_options` table, accessed via `rj_get_option()`\n"
            . "- **Cache:** `Cache::rememberForever('rj_options', ...)`\n"
            . "- **AI Provider:** OpenRouter (`OpenRouterService`) + Free AI Proxy\n"
            . "- **Views:** `admin.layouts.app` base, settings use `admin.settings.layout`\n"
            . "- **Installer:** `public/install.php` & `installer/` folder (standalone)\n"
            . "- **Demo Import:** `php artisan rj:export-demo` -> JSON -> `DemoSeeder`\n";
    }
}
