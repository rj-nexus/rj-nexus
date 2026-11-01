<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\Option;

class DemoSeeder extends Seeder
{
    private string $path;
    private array $idMap = [];
    private string $oldUrl = '';
    private string $newUrl = '';

    private array $skipOptionPatterns = [
        'api_key', 'secret', 'password', 'token', '_hash', 'installed',
        'mail_password', 'mail_username', 'license_key',
    ];

    public function run(): void
    {
        $this->path = database_path('seeders/data/demo');
        $this->newUrl = rtrim(config('app.url', ''), '/');

        if (!File::isDirectory($this->path)) {
            $this->command?->error("Demo data not found: {$this->path}");
            return;
        }

        $opts = $this->load('options.json');
        foreach ($opts as $opt) {
            $name = $opt['option_name'] ?? $opt['name'] ?? '';
            if ($name === 'site_url') {
                $this->oldUrl = rtrim($opt['option_value'] ?? $opt['value'] ?? '', '/');
                break;
            }
        }

        $this->command?->info("Replacing URLs: [{$this->oldUrl}] -> [{$this->newUrl}]");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            $this->importOptions('options.json');
            $this->safeImport('post_types.json', 'rj_post_types');
            $this->safeImport('taxonomies.json', 'rj_taxonomies', [
                'post_type_id' => 'rj_post_types',
            ]);

            // Tema cədvəlini silmirik, sadəcə update edirik
            $this->importThemes('themes.json');

            $this->safeImport('categories.json', 'rj_categories');
            $this->safeImport('tags.json', 'rj_tags');
            $this->safeImport('terms.json', 'rj_terms');
            $this->safeImport('media.json', 'rj_media');
            $this->safeImport('custom_fields.json', 'rj_custom_fields');
            $this->safeImport('custom_fonts.json', 'rj_custom_fonts');
            $this->safeImport('custom_icons.json', 'rj_custom_icons');
            $this->safeImport('menus.json', 'rj_menus');
            $this->safeImport('forms.json', 'rj_forms');

            $this->importPosts('posts.json');

            $this->safeImport('category_translations.json', 'rj_category_translations', [
                'category_id' => 'rj_categories',
            ]);
            $this->safeImport('tag_translations.json', 'rj_tag_translations', [
                'tag_id' => 'rj_tags',
            ]);
            $this->safeImport('term_translations.json', 'rj_term_translations', [
                'term_id' => 'rj_terms',
            ]);
            $this->safeImport('post_translations.json', 'rj_post_translations', [
                'post_id' => 'rj_posts',
            ]);

            $this->importPivot('post_category.json', 'rj_post_category', 'post_id', 'rj_posts', 'category_id', 'rj_categories');
            $this->importPivot('post_tag.json', 'rj_post_tag', 'post_id', 'rj_posts', 'tag_id', 'rj_tags');
            $this->importPivot('post_term.json', 'rj_post_term', 'post_id', 'rj_posts', 'term_id', 'rj_terms');

            $this->importMenuItems('menu_items.json');
            $this->importTemplates('templates.json');

            $this->safeImport('form_fields.json', 'rj_form_fields', [
                'form_id' => 'rj_forms',
            ]);

            $this->safeImport('theme_customizations.json', 'rj_theme_customizations', [
                'theme_id' => 'rj_themes',
            ]);

            $this->safeImport('widgets.json', 'rj_widgets', $this->autoDetectRemaps('rj_widgets'));
            $this->safeImport('global_widgets.json', 'rj_global_widgets', $this->autoDetectRemaps('rj_global_widgets'));

            $this->copyMediaFiles();

            $this->command?->info('Demo data imported successfully.');

        } catch (\Throwable $e) {
            $this->command?->error('Error during demo import: ' . $e->getMessage());
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            try { Option::flush(); } catch (\Throwable $e) {}
            $this->command?->info('Options cache flushed.');
        }
    }

    private function replaceUrls(array $row): array
    {
        if (empty($this->oldUrl) || empty($this->newUrl) || $this->oldUrl === $this->newUrl) {
            return $row;
        }

        $json = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $json = str_replace($this->oldUrl, $this->newUrl, $json);
        $json = str_replace(str_replace('/', '\/', $this->oldUrl), str_replace('/', '\/', $this->newUrl), $json);
        $json = str_replace(addslashes($this->oldUrl), addslashes($this->newUrl), $json);

        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : $row;
    }

    private function importThemes(string $file): void
    {
        if (!Schema::hasTable('rj_themes')) {
            return;
        }

        $rows = $this->load($file);
        if (empty($rows)) {
            return;
        }

        foreach ($rows as $row) {
            $row = $this->replaceUrls($row);
            unset($row['id']);

            // Əgər slug varsa update et, yoxsa insert et
            if (isset($row['slug'])) {
                DB::table('rj_themes')->updateOrInsert(
                    ['slug' => $row['slug']],
                    $row
                );
            } else {
                DB::table('rj_themes')->insert($row);
            }
        }

        $this->command?->line("Imported rj_themes: " . count($rows));
    }

    private function safeImport(string $file, string $table, array $remaps = []): void
    {
        try {
            $this->importTruncate($file, $table, $remaps);
        } catch (\Throwable $e) {
            $this->command?->error("Failed to import {$table}: " . $e->getMessage());
        }
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
            $name = $row['option_name'] ?? $row['name'] ?? null;
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

            if ($name === 'site_url' && !empty($this->newUrl)) {
                $row['option_value'] = $this->newUrl;
                $row['value'] = $this->newUrl;
            } else {
                $row = $this->replaceUrls($row);
            }

            $insertData = $row;
            if (isset($row['option_name'])) {
                $insertData['option_name'] = $row['option_name'];
                $insertData['option_value'] = $row['option_value'] ?? '';
                $insertData['option_group'] = $row['option_group'] ?? 'general';
                $insertData['option_type'] = $row['option_type'] ?? 'text';
                $insertData['autoload'] = $row['autoload'] ?? 1;
            }

            $keyColumn = isset($row['option_name']) ? 'option_name' : 'name';

            DB::table('rj_options')->updateOrInsert(
                [$keyColumn => $name],
                $insertData
            );
            $count++;
        }

        $this->command?->line("Upserted rj_options: {$count}");
    }

    private function importTruncate(string $file, string $table, array $remaps = []): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $validRemaps = [];
        foreach ($remaps as $column => $refTable) {
            if (Schema::hasColumn($table, $column)) {
                $validRemaps[$column] = $refTable;
            }
        }

        $rows = $this->load($file);

        if (empty($rows)) {
            return;
        }

        DB::table($table)->delete();
        $this->idMap[$table] = [];

        foreach ($rows as $row) {
            $row = $this->replaceUrls($row);

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

        if (empty($rows)) {
            return;
        }

        DB::table('rj_posts')->delete();
        $this->idMap['rj_posts'] = [];

        $fallbackAuthor = DB::table('users')->orderBy('id')->value('id');

        foreach ($rows as $row) {
            $row = $this->replaceUrls($row);

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

        if (empty($rows)) {
            return;
        }

        DB::table($table)->delete();

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

        if (empty($rows)) {
            return;
        }

        DB::table('rj_menu_items')->delete();
        $this->idMap['rj_menu_items'] = [];

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

                $row = $this->replaceUrls($row);

                $oldId = $row['id'] ?? null;
                unset($row['id']);

                if (!empty($row['menu_id'])) {
                    $row['menu_id'] = $this->idMap['rj_menus'][$row['menu_id']] ?? $row['menu_id'];
                }
                if (!empty($parentOld)) {
                    $row['parent_id'] = $this->idMap['rj_menu_items'][$parentOld];
                }

                if (!empty($row['object_id']) && !empty($row['object_type'])) {
                    $type = $row['object_type'];
                    if (in_array($type, ['page', 'post'])) {
                        if (isset($this->idMap['rj_posts'][$row['object_id']])) {
                            $row['object_id'] = $this->idMap['rj_posts'][$row['object_id']];
                        }
                    } elseif ($type === 'category') {
                        if (isset($this->idMap['rj_categories'][$row['object_id']])) {
                            $row['object_id'] = $this->idMap['rj_categories'][$row['object_id']];
                        }
                    }
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

    private function importTemplates(string $file): void
    {
        if (!Schema::hasTable('rj_templates')) {
            return;
        }

        $rows = $this->load($file);

        if (empty($rows)) {
            return;
        }

        DB::table('rj_templates')->delete();
        $this->idMap['rj_templates'] = [];

        foreach ($rows as $row) {
            $row = $this->replaceUrls($row);

            $oldId = $row['id'] ?? null;
            unset($row['id']);

            if (isset($row['content'])) {
                $content = json_decode($row['content'], true);
                if (is_array($content)) {
                    $content = $this->remapTemplateContent($content);
                    $row['content'] = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
            }

            $newId = DB::table('rj_templates')->insertGetId($row);

            if ($oldId !== null) {
                $this->idMap['rj_templates'][$oldId] = $newId;
            }
        }

        $this->command?->line("Imported rj_templates: " . count($rows));
    }

    private function remapTemplateContent(array $content): array
    {
        foreach ($content as $key => $value) {
            try {
                if (is_array($value)) {
                    $content[$key] = $this->remapTemplateContent($value);
                } elseif (is_scalar($value)) {
                    $keyLower = strtolower((string) $key);
                    $intVal = (int) $value;

                    if (str_contains($keyLower, 'menu') && isset($this->idMap['rj_menus'][$intVal])) {
                        $content[$key] = $this->idMap['rj_menus'][$intVal];
                    }
                    if (str_contains($keyLower, 'post') && isset($this->idMap['rj_posts'][$intVal])) {
                        $content[$key] = $this->idMap['rj_posts'][$intVal];
                    }
                    if (str_contains($keyLower, 'category') && isset($this->idMap['rj_categories'][$intVal])) {
                        $content[$key] = $this->idMap['rj_categories'][$intVal];
                    }
                    if (str_contains($keyLower, 'tag') && isset($this->idMap['rj_tags'][$intVal])) {
                        $content[$key] = $this->idMap['rj_tags'][$intVal];
                    }
                    if (str_contains($keyLower, 'form') && isset($this->idMap['rj_forms'][$intVal])) {
                        $content[$key] = $this->idMap['rj_forms'][$intVal];
                    }
                    if (str_contains($keyLower, 'media') && isset($this->idMap['rj_media'][$intVal])) {
                        $content[$key] = $this->idMap['rj_media'][$intVal];
                    }
                }
            } catch (\Throwable $e) {
                // Xəta olsa belə davam et
            }
        }

        return $content;
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
