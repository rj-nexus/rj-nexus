<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultAssetsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Standart Temanı Aktiv Et
        $currentTheme = DB::table('rj_options')->where('option_name', 'frontend_theme')->value('option_value');

        // Əgər tema boşdursa və ya DB-də ümumiyyətlə yoxdursa, rj-default aktiv et
        if (empty($currentTheme)) {
            DB::table('rj_options')->updateOrInsert(
                ['option_name' => 'frontend_theme'],
                [
                    'option_value' => 'rj-default',
                    'option_group' => 'colors',
                    'option_type'  => 'text',
                    'autoload'     => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }

        // 2. Standart Plugini Aktiv Et
        $currentPlugins = DB::table('rj_options')->where('option_name', 'active_plugins')->value('option_value');
        $pluginsArray = $currentPlugins ? json_decode($currentPlugins, true) : [];

        if (!in_array('form-builder', $pluginsArray)) {
            $pluginsArray[] = 'form-builder';

            DB::table('rj_options')->updateOrInsert(
                ['option_name' => 'active_plugins'],
                [
                    'option_value' => json_encode(array_unique($pluginsArray)),
                    'option_group' => 'plugins',
                    'option_type'  => 'json',
                    'autoload'     => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }
    }
}
