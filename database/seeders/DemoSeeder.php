<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DemoSeeder extends Seeder
{
    private string $path;
    private array $idMap = [];

    private array $skipOptionPatterns = [
        'api_key', 'secret', 'password', 'token', '_hash', 'installed',
        'mail_password', 'mail_username', 'license_key',
    ];

    public function run(): void
    {
        $this->path = database_path('seeders/data/demo');

        if (!File::isDirectory($this->path)) {
            $this->command?->error("Demo data not found: {$this->path}");
            return;
        }

        $this->command?->info('Importing demo data...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            DB::transaction(function () {
                $this->importOptions('options.json');
                $this->importTruncate('post_types.json', 'rj_post_types');
                $this->importTruncate('taxonomies.json', 'rj_taxonomies', [
                    'post_type_id' => 'rj_post_types',
                ]);
                $this->importTruncate('themes.json', 'rj_themes');

                $this->importTruncate('categories.json', 'rj_categories');
                $this->importTruncate('tags.json', 'rj_tags');
                $this->importTruncate('terms.json', 'rj_terms');
                $this->importTruncate('media.json', 'rj_media');
                $this->importTruncate('custom_fields.json', 'rj_custom_fields');
                $this->importTruncate('custom_fonts.json', 'rj_custom_fonts');
                $this->importTruncate('custom_icons.json', 'rj_custom_icons');
                $this->importTruncate('menus.json', 'rj_menus');
                $this->importTruncate('forms.json', 'rj_forms');
                $this->importPosts('posts.json');

                $this->importTruncate('category_translations.json', 'rj_category_translations', [
                    'category_id' => 'rj_categories',
                ]);
                $this->importTruncate('tag_translations.json', 'rj_tag_translations', [
                    'tag_id' => 'rj_tags',
                ]);
                $this->importTruncate('term_translations.json', 'rj_term_translations', [
                    'term_id' => 'rj_terms',
                ]);
                $this->importTruncate('post_translations.json', 'rj_post_translations', [
                    'post_id' => 'rj_posts',
                ]);

                $this->importPivot('post_category.json', 'rj_post_category', 'post_id', 'rj_posts', 'category_id', 'rj_categories');
                $this->importPivot('post_tag.json', 'rj_post_tag', 'post_id', 'rj_posts', 'tag_id', 'rj_tags');
                $this->importPivot('post_term.json', 'rj_post_term', 'post_id', 'rj_posts', 'term_id', 'rj_terms');

                $this->importMenuItems('menu_items.json');

                $this->importTruncate('form_fields.json', 'rj_form_fields', [
                    'form_id' => 'rj_forms',
                ]);

                $this->importTruncate('theme_customizations.json', 'rj_theme_customizations', [
                    'theme_id' => 'rj_themes',
                ]);

                $this->importTruncate('widgets.json', 'rj_widgets', $this->autoDetectRemaps('rj_widgets'));
                $this->importTruncate('global_widgets.json', 'rj_global_widgets', $this->autoDetectRemaps('rj_global_widgets'));

                $this->copyMediaFiles();
            });
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->command?->info('Demo data imported successfully.');
    }

    private function autoDetectRemaps(string $table): array
    {
        if (!Schema::hasTable($table)) {
            return [];
        }

        $remaps = [];
        $map = [
            'post_id' => 'rj_posts',
            'category_id' => 'rj_categories',
            'tag_id' => 'rj_tags',
            'term_id' => 'rj_terms',
            'menu_id' => 'rj_menus',
            'form_id' => 'rj_forms',
            'theme_id' => 'rj_themes',
            'media_id' => 'rj_media',
        ];

        foreach ($map as $column => $refTable) {
            if (Schema::hasColumn($table, $column)) {
                $remaps[$column] = $refTable;
            }
        }

        return $remaps;
    }

    private function load(string $file): array
    {
        $full = $this->path . DIRECTORY_SEPARATOR . $file;
        if (!File::exists($full)) {
            return [];
        }

        $data = json_decode(File::get($full), true);

        return is_array($data) ? $data : [];
    }

    private function importOptions(string $file): void
    {
        if (!Schema::hasTable('rj_options')) {
            return;
        }

        $rows = $this->load($file);
        if (empty($rows)) {
            return;
        }

        $count = 0;
        foreach ($rows as $row) {
            $name = $row['name'] ?? null;
            if (!$name) {
                continue;
            }

            $skip = false;
            foreach ($this->skipOptionPatterns as $pattern) {
                if (str_contains(strtolower($name), $pattern)) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) {
                continue;
            }

            unset($row['id']);

            DB::table('rj_options')->updateOrInsert(
                ['name' => $name],
                $row
            );
            $count++;
        }

        $this->command?->line("Upserted rj_options: {$count}");
    }

    private function importTruncate(string $file, string $table, array $remaps = []): void
    {
        if (!Schema::hasTable($table)) {
            $this->command?->warn("Table {$table} not found, skipping {$file}");
            return;
        }

        $validRemaps = [];
        foreach ($remaps as $column => $refTable) {
            if (Schema::hasColumn($table, $column)) {
                $validRemaps[$column] = $refTable;
            }
        }

        $rows = $this->load($file);

        DB::table($table)->delete();
        $this->idMap[$table] = [];

        if (empty($rows)) {
            return;
        }

        foreach ($rows as $row) {
            $oldId = $row['id'] ?? null;
            unset($row['id']);

            foreach ($validRemaps as $column => $refTable) {
                if (isset($row[$column]) && $row[$column] !== null) {
                    $oldRef = $row[$column];
                    $row[$column] = $this->idMap[$refTable][$oldRef] ?? $oldRef;
                }
            }

            $newId = DB::table($table)->insertGetId($row);

            if ($oldId !== null) {
                $this->idMap[$table][$oldId] = $newId;
            }
        }

        $this->command?->line("Imported {$table}: " . count($rows));
    }

    private function importPosts(string $file): void
    {
        if (!Schema::hasTable('rj_posts')) {
            return;
        }

        $rows = $this->load($file);

        DB::table('rj_posts')->delete();
        $this->idMap['rj_posts'] = [];

        if (empty($rows)) {
            return;
        }

        $fallbackAuthor = DB::table('users')->orderBy('id')->value('id');

        foreach ($rows as $row) {
            $oldId = $row['id'] ?? null;
            unset($row['id']);

            if (!empty($row['author_id'])) {
                $exists = DB::table('users')->where('id', $row['author_id'])->exists();
                if (!$exists && $fallbackAuthor) {
                    $row['author_id'] = $fallbackAuthor;
                }
            } elseif ($fallbackAuthor) {
                $row['author_id'] = $fallbackAuthor;
            }

            $newId = DB::table('rj_posts')->insertGetId($row);

            if ($oldId !== null) {
                $this->idMap['rj_posts'][$oldId] = $newId;
            }
        }

        $this->command?->line("Imported rj_posts: " . count($rows));
    }

    private function importPivot(string $file, string $table, string $col1, string $ref1, string $col2, string $ref2): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $rows = $this->load($file);

        DB::table($table)->delete();

        if (empty($rows)) {
            return;
        }

        foreach ($rows as $row) {
            if (isset($row[$col1])) {
                $row[$col1] = $this->idMap[$ref1][$row[$col1]] ?? $row[$col1];
            }
            if (isset($row[$col2])) {
                $row[$col2] = $this->idMap[$ref2][$row[$col2]] ?? $row[$col2];
            }
            DB::table($table)->insert($row);
        }

        $this->command?->line("Imported {$table}: " . count($rows));
    }

    private function importMenuItems(string $file): void
    {
        if (!Schema::hasTable('rj_menu_items')) {
            return;
        }

        $rows = $this->load($file);

        DB::table('rj_menu_items')->delete();
        $this->idMap['rj_menu_items'] = [];

        if (empty($rows)) {
            return;
        }

        $pending = $rows;
        $maxIterations = count($rows) + 1;
        $iterations = 0;

        while (!empty($pending) && $iterations < $maxIterations) {
            $iterations++;
            $stillPending = [];

            foreach ($pending as $row) {
                $parentOld = $row['parent_id'] ?? null;

                if (!empty($parentOld) && !isset($this->idMap['rj_menu_items'][$parentOld])) {
                    $stillPending[] = $row;
                    continue;
                }

                $oldId = $row['id'] ?? null;
                unset($row['id']);

                if (!empty($row['menu_id'])) {
                    $row['menu_id'] = $this->idMap['rj_menus'][$row['menu_id']] ?? $row['menu_id'];
                }
                if (!empty($parentOld)) {
                    $row['parent_id'] = $this->idMap['rj_menu_items'][$parentOld];
                }

                $newId = DB::table('rj_menu_items')->insertGetId($row);

                if ($oldId !== null) {
                    $this->idMap['rj_menu_items'][$oldId] = $newId;
                }
            }

            $pending = $stillPending;
        }

        $this->command?->line("Imported rj_menu_items: " . count($rows));
    }

    private function copyMediaFiles(): void
    {
        $source = $this->path . DIRECTORY_SEPARATOR . 'media';
        if (!File::isDirectory($source)) {
            return;
        }

        $target = storage_path('app/public');
        File::ensureDirectoryExists($target);
        File::copyDirectory($source, $target);

        $this->command?->line('Copied demo media files.');
    }
}
