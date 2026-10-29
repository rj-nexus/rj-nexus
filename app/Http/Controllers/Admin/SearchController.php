<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FreeAiService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request, FreeAiService $ai)
    {
        $query = trim($request->input('q', ''));

        if (empty($query)) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $menus = $this->getDynamicMenus();

        // 1. Yerli (Offline) Axtarış Məntiqi
        $localResults = [];
        foreach ($menus as $menu) {
            $score = 0;
            if (stripos($menu['title'], $query) !== false) $score += 10;
            if (stripos($menu['keywords'], $query) !== false) $score += 5;
            if (stripos($menu['desc'], $query) !== false) $score += 2;

            if ($score > 0) {
                $menu['score'] = $score;
                $localResults[] = $menu;
            }
        }

        usort($localResults, fn($a, $b) => $b['score'] - $a['score']);
        $localResults = array_slice($localResults, 0, 5);
        foreach ($localResults as &$item) unset($item['score']);

        // 2. AI (Ağıllı) Axtarış Məntiqi
        try {
            // AI-a bütün dinamik menyuları JSON kimi veririk
            $menusJson = json_encode(array_map(function($m) {
                return ['title' => $m['title'], 'url' => $m['url'], 'desc' => $m['desc']];
            }, $menus));

            $prompt = "You are an admin panel search router. User query: '{$query}'.\n";
            $prompt .= "Here is the complete list of available admin menus and pages: {$menusJson}\n";
            $prompt .= "Return ONLY a valid JSON array of the top 3 most relevant matches. Example: [{\"title\":\"Email Settings\",\"url\":\"/admin/settings/email\",\"desc\":\"Configure SMTP\"}]. If none match, return []. Do not include any other text, markdown formatting, or explanations.";

            $response = $ai->ask($prompt, 'Admin Menu Search');

            if ($response['success']) {
                $answer = $response['answer'];
                $answer = preg_replace('/```json/i', '', $answer);
                $answer = preg_replace('/```/i', '', $answer);
                $answer = trim($answer);

                $aiResults = json_decode($answer, true);

                if (is_array($aiResults) && !empty($aiResults)) {
                    return response()->json(['success' => true, 'results' => $aiResults, 'source' => 'ai']);
                }
            }
        } catch (\Throwable $e) {
            // AI xətası zamanı heç nə etmirik, yerli axtarış nəticələri qayıdacaq
        }

        return response()->json(['success' => true, 'results' => $localResults, 'source' => 'local']);
    }

    /**
     * Laravel-in bütün Route-larını oxuyaraq menyu siyahısı yaradır.
     * Beləliklə Settings daxilindəki bütün alt-menyular və plugin menyuları avtomatik daxil olur.
     */
    protected function getDynamicMenus(): array
    {
        $menus = [];
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $name = $route->getName();
            $uri = $route->uri();
            $methods = $route->methods();

            // Yalnız GET metodlu və adı 'admin.' ilə başlayan route-ları götürürük
            if (in_array('GET', $methods) && $name && str_starts_with($name, 'admin.')) {
                // Yalnız index, edit, view və s. səhifələri göstər (store, update, destroy kimi action-ları yox)
                if (preg_match('/(store|update|destroy|delete|bulk|clear|fetch|export|import|create|edit)$/i', $name)) {
                    continue;
                }

                // Route adından oxunaqlı başlıq düzəldirik (Məs: admin.settings.email -> Settings Email)
                $cleanName = str_replace(['admin.', '.index', '.show', '.edit'], '', $name);
                $title = Str::headline(str_replace('.', ' ', $cleanName));

                // Bəzi xüsusi adları düzəldək
                $title = str_ireplace(['Seo', 'Smtp', 'Api', 'Kyc', 'Ai'], ['SEO', 'SMTP', 'API', 'KYC', 'AI'], $title);

                $menus[] = [
                    'title' => $title,
                    'url' => '/' . $uri,
                    'desc' => ucfirst(str_replace(['.', '/'], ' ', $cleanName)),
                    'keywords' => strtolower(str_replace(['.', '-', '_'], ' ', $cleanName)),
                ];
            }
        }

        // Təkrarlanan URL-ləri təmizləyirik
        $uniqueMenus = [];
        foreach ($menus as $menu) {
            $uniqueMenus[$menu['url']] = $menu;
        }

        return array_values($uniqueMenus);
    }
}
