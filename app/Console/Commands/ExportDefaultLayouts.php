<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\File;

class ExportDefaultLayouts extends Command
{
    protected $signature = 'rj:export-layouts';
    protected $description = 'Export current default header and footer to JSON files for seeders';

    public function handle()
    {
        $dir = database_path('seeders/data');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Header-i tap (default olanı, yoxdursa ilk header-i)
        $header = Template::where('type', 'header')->where('is_default', true)->first()
               ?? Template::where('type', 'header')->first();

        if ($header) {
            File::put($dir . '/default-header.json', $header->content);
            $this->info('Header uğurla ixrac edildi: default-header.json');
        } else {
            $this->error('Header tapılmadı!');
        }

        // Footer-i tap (default olanı, yoxdursa ilk footer-i)
        $footer = Template::where('type', 'footer')->where('is_default', true)->first()
               ?? Template::where('type', 'footer')->first();

        if ($footer) {
            File::put($dir . '/default-footer.json', $footer->content);
            $this->info('Footer uğurla ixrac edildi: default-footer.json');
        } else {
            $this->error('Footer tapılmadı!');
        }
    }
}
