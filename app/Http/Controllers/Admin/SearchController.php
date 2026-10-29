<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AiAgentService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request, AiAgentService $agent)
    {
        $query = trim($request->input('q', ''));

        if (empty($query)) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $menus = $this->getDynamicMenus();

        // 1. Yerli (Offline) Axtarış Məntiqi - AI xəta versə belə işləyəcək
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

        // 2. Ağıllı AI Axtarış Məntiqi (RAG + Dərin Düşüncə)
        try {
            $menusJson = json_encode(array_map(function($m) {
                return ['title' => $m['title'], 'url' => $m['url'], 'desc' => $m['desc']];
            }, $menus));

            $extraContext = "AVAILABLE ADMIN MENUS:\n{$menusJson}\n";
            
            $prompt = "You are a smart search assistant for RJ Nexus Admin Panel.
            User query: '{$query}'.
            
            INSTRUCTIONS:
            1. If the user is asking a 'how-to' question (e.g., 'how to change theme', 'where is email settings'), find the answer in the DOCUMENTATION CONTEXT and write a brief, helpful explanation in the 'desc' field. 
            2. Match the answer to the most relevant URL from the AVAILABLE ADMIN MENUS.
            3. If it's just a keyword (e.g., 'posts', 'users'), just return the matching menu with a short desc.
            4. Return ONLY a valid JSON array of the top 3 most relevant matches. 
            Example format: [{\"title\":\"Theme Settings\",\"url\":\"/admin/themes\",\"desc\":\"Go to Appearance > Themes to change your active site theme.\"}]. 
            Do not include markdown formatting, just raw JSON.";

            $response = $agent->ask($prompt, $extraContext);

            if ($response['success']) {
                $answer = $response['answer'];
                // Təmizləmə: AI bəzən ```json ... ``` kimi markdown qaytarır
                $answer = preg_replace('/```json/i', '', $answer);
                $answer = preg_replace('/```/i', '', $answer);
                $answer = trim($answer);

                $aiResults = json_decode($answer, true);

                if (is_array($aiResults) && !empty($aiResults)) {
                    return response()->json([
                        'success' => true, 
                        'results' => $aiResults, 
                        'source' => 'ai'
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('AI Search Error: ' . $e->getMessage());
            // AI xətası zamanı heç nə etmirik, aşağıdakı yerli nəticələr qayıdacaq
        }

        return response()->json([
            'success' => true, 
            'results' => $localResults, 
            'source' => 'local'
        ]);
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

            if (in_array('GET', $methods) && $name && str_starts_with($name, 'admin.')) {
                // Texniki action-ları (store, update, delete) siyahıdan çıxarırıq
                if (preg_match('/(store|update|destroy|delete|bulk|clear|fetch|export|import|create|edit|recent|unread|mark)/i', $name)) {
                    continue;
                }

                $cleanName = str_replace(['admin.', '.index', '.show', '.edit'], '', $name);
                $title = Str::headline(str_replace('.', ' ', $cleanName));              
                $title = str_ireplace(['Seo', 'Smtp', 'Api', 'Kyc', 'Ai', 'Rjbuilder'], ['SEO', 'SMTP', 'API', 'KYC', 'AI', 'RJ Builder'], $title);

                $menus[] = [
                    'title' => $title,
                    'url' => '/' . $uri,
                    'desc' => ucfirst(str_replace(['.', '/'], ' ', $cleanName)),
                    'keywords' => strtolower(str_replace(['.', '-', '_'], ' ', $cleanName)),
                ];
            }
        }

        $uniqueMenus = [];
        foreach ($menus as $menu) {
            $uniqueMenus[$menu['url']] = $menu;
        }

        return array_values($uniqueMenus);
    }
}