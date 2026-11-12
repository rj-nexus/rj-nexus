<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Menu;
use App\Models\Template;
use Illuminate\Support\Facades\File;

class ExportThemeDemoCommand extends Command
{
    protected $signature = 'rj:export-theme-demo {theme? : The slug of the theme to export}';
    protected $description = 'Export current database content into the specific theme demo directory';

    public function handle()
    {
        $themeSlug = $this->argument('theme') ?? rj_get_option('active_theme', 'spotlight');
        $themePath = base_path('rj-content/themes/' . $themeSlug);
        
        if (!File::exists($themePath)) {
            $this->error("Theme path not found: {$themePath}");
            return 1;
        }

        $demoPath = $themePath . '/demo/data';
        File::ensureDirectoryExists($demoPath);
        
        // Köhnə məlumatları tam təmizləyirik ki, qarışıqlıq olmasın
        File::cleanDirectory($demoPath);

        $this->info("Exporting demo content for theme: {$themeSlug}...");

        // 1. Səhifələr və Postlar
        $posts = Post::with(['translations'])->get();
        File::put($demoPath . '/posts.json', $posts->toJson(JSON_PRETTY_PRINT));
        $this->info("Pages and Posts exported: " . $posts->count());

        // 2. Şablonlar (Header, Footer, Builder Pages)
        $templates = Template::all();
        File::put($demoPath . '/templates.json', $templates->toJson(JSON_PRETTY_PRINT));
        $this->info("Templates (Header/Footer) exported: " . $templates->count());

        // 3. Menyular
        $menus = Menu::with(['items'])->get();
        File::put($demoPath . '/menus.json', $menus->toJson(JSON_PRETTY_PRINT));
        $this->info("Menus exported: " . $menus->count());

        // 4. Customizer Ayarları (Rənglər, Loqo, s.)
        $themeMods = rj_get_option('theme_mods_' . $themeSlug, []);
        File::put($demoPath . '/theme_mods.json', json_encode($themeMods, JSON_PRETTY_PRINT));
        $this->info('Customizer settings exported.');

        // 5. Sayt Parametrləri (Ana səhifə, menyu yerləri)
        $options = [
            'site_name' => rj_get_option('site_name'),
            'site_tagline' => rj_get_option('site_tagline'),
            'reading_settings' => rj_get_option('reading_settings'),
            'menu_locations' => rj_get_option('menu_locations'),
        ];
        File::put($demoPath . '/options.json', json_encode($options, JSON_PRETTY_PRINT));
        $this->info('General site options exported.');

        $this->info("Demo content successfully exported to: {$demoPath}");
        return 0;
    }
}