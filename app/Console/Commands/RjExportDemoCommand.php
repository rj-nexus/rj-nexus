<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class RjExportDemoCommand extends Command
{
    protected $signature = 'rj:export-demo {--path= : Export directory path}';

    protected $description = 'Export current site content to demo JSON files';

    private array $tables = [
        'options' => 'rj_options',
        'post_types' => 'rj_post_types',
        'taxonomies' => 'rj_taxonomies',
        'categories' => 'rj_categories',
        'category_translations' => 'rj_category_translations',
        'tags' => 'rj_tags',
        'tag_translations' => 'rj_tag_translations',
        'terms' => 'rj_terms',
        'term_translations' => 'rj_term_translations',
        'posts' => 'rj_posts',
        'post_translations' => 'rj_post_translations',
        'post_category' => 'rj_post_category',
        'post_tag' => 'rj_post_tag',
        'post_term' => 'rj_post_term',
        'menus' => 'rj_menus',
        'menu_items' => 'rj_menu_items',
        'forms' => 'rj_forms',
        'form_fields' => 'rj_form_fields',
        'themes' => 'rj_themes',
        'theme_customizations' => 'rj_theme_customizations',
        'widgets' => 'rj_widgets',
        'global_widgets' => 'rj_global_widgets',
        'media' => 'rj_media',
        'custom_fields' => 'rj_custom_fields',
        'custom_fonts' => 'rj_custom_fonts',
        'custom_icons' => 'rj_custom_icons',
    ];

    public function handle(): int
    {
        $path = $this->option('path') ?: database_path('seeders/data/demo');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $exported = [];
        $totalRows = 0;

        foreach ($this->tables as $name => $table) {
            if (!Schema::hasTable($table)) {
                $this->warn("Skip: {$table} does not exist");
                continue;
            }

            $rows = DB::table($table)->get()
                ->map(fn($row) => (array) $row)
                ->all();

            File::put(
                $path . DIRECTORY_SEPARATOR . $name . '.json',
                json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            );

            $exported[$name] = count($rows);
            $totalRows += count($rows);
            $this->line("Exported {$name}.json: " . count($rows) . " rows");
        }

        $manifest = [
            'name' => 'RJ Nexus Starter Demo',
            'exported_at' => now()->toIso8601String(),
            'tables' => $exported,
            'total_rows' => $totalRows,
        ];

        File::put(
            $path . DIRECTORY_SEPARATOR . 'manifest.json',
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $this->info("Demo export complete: {$path} ({$totalRows} rows)");

        return self::SUCCESS;
    }
}
