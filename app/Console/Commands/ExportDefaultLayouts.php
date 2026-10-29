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

        $header = Template::where('type', 'header')->where('is_default', true)->first()
               ?? Template::where('type', 'header')->first();

        if ($header) {
            $content = is_array($header->content) ? json_encode($header->content, JSON_PRETTY_PRINT) : $header->content;
            File::put($dir . '/default-header.json', $content);
            $this->info('Header uğurla ixrac edildi: default-header.json');
        } else {
            $this->error('Header tapılmadı!');
        }

        $footer = Template::where('type', 'footer')->where('is_default', true)->first()
               ?? Template::where('type', 'footer')->first();

        if ($footer) {
            $content = is_array($footer->content) ? json_encode($footer->content, JSON_PRETTY_PRINT) : $footer->content;
            File::put($dir . '/default-footer.json', $content);
            $this->info('Footer uğurla ixrac edildi: default-footer.json');
        } else {
            $this->error('Footer tapılmadı!');
        }
    }
}
