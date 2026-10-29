<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ExportDefaultContent extends Command
{
    protected $signature = 'rj:export-defaults';
    protected $description = 'Export current default templates, pages, and menus to JSON files for seeders';

    public function handle()
    {
        $dir = database_path('seeders/data');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $header = Template::where('type', 'header')->where('is_default', true)->first()
               ?? Template::where('type', 'header')->first();
        if ($header) {
            $content = is_array($header->content) ? json_encode($header->content, JSON_PRETTY_PRINT) : $header->content;
            File::put($dir . '/default-header.json', $content);
        }

        $footer = Template::where('type', 'footer')->where('is_default', true)->first()
               ?? Template::where('type', 'footer')->first();
        if ($footer) {
            $content = is_array($footer->content) ? json_encode($footer->content, JSON_PRETTY_PRINT) : $footer->content;
            File::put($dir . '/default-footer.json', $content);
        }

        $pages = DB::table('rj_posts')->where('type', 'page')->get();
        File::put($dir . '/default-pages.json', json_encode($pages, JSON_PRETTY_PRINT));

        $pageTranslations = DB::table('rj_post_translations')->whereIn('post_id', $pages->pluck('id'))->get();
        File::put($dir . '/default-page-translations.json', json_encode($pageTranslations, JSON_PRETTY_PRINT));

        $categories = DB::table('rj_categories')->get();
        File::put($dir . '/default-categories.json', json_encode($categories, JSON_PRETTY_PRINT));

        $categoryTranslations = DB::table('rj_category_translations')->get();
        File::put($dir . '/default-category-translations.json', json_encode($categoryTranslations, JSON_PRETTY_PRINT));

        $menus = DB::table('rj_menus')->get();
        File::put($dir . '/default-menus.json', json_encode($menus, JSON_PRETTY_PRINT));

        $menuItems = DB::table('rj_menu_items')->get();
        File::put($dir . '/default-menu-items.json', json_encode($menuItems, JSON_PRETTY_PRINT));

        $this->info('All default content exported successfully to database/seeders/data/');
    }
}
