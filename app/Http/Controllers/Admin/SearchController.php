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
            return response()->json(['success' => true, 'answer' => null, 'menus' => []]);
        }

        $menus = $this->getDynamicMenus();
        $menusJson = json_encode(array_map(function($m) {
            return ['title' => $m['title'], 'url' => $m['url'], 'desc' => $m['desc']];
        }, $menus));

        $prompt = "You are an admin panel search AI. User query: '{$query}'.
        Return ONLY a valid JSON object with exactly two keys:
        1. 'answer': A short, helpful text answer to the user's question (based on your CMS/Laravel knowledge). If the user just typed a keyword (like 'Posts'), set this to null.
        2. 'menus': An array of the top 3 most relevant admin menus from the provided list.
        
        AVAILABLE MENUS: {$menusJson}
        
        Example output: {\"answer\":\"To change your site colors, go to Appearance > Colors.\", \"menus\":[{\"title\":\"Colors\",\"url\":\"/admin/appearance/colors\",\"desc\":\"Appearance settings\"}]}
        Do not include markdown formatting.";

        try {
            $response = $agent->ask($prompt, '');
            
            if ($response['success']) {
                $answer = preg_replace('/```json/i', '', $response['answer']);
                $answer = preg_replace('/```/i', '', $answer);
                $answer = trim($answer);
                
                $json = json_decode($answer, true);
                
                if (is_array($json)) {
                    return response()->json([
                        'success' => true,
                        'answer' => $json['answer'] ?? null,
                        'menus' => $json['menus'] ?? [],
                        'source' => 'ai'
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('AI Search Error: ' . $e->getMessage());
        }

        // Fallback (Yerli axtarış)
        $localResults = [];
        foreach ($menus as $menu) {
            if (stripos($menu['title'], $query) !== false || stripos($menu['keywords'], $query) !== false) {
                $localResults[] = $menu;
            }
        }

        return response()->json([
            'success' => true, 
            'answer' => null,
            'menus' => array_slice($localResults, 0, 5),
            'source' => 'local'
        ]);
    }

    protected function getDynamicMenus(): array
    {
        $menus = [];
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $name = $route->getName();
            $uri = $route->uri();
            $methods = $route->methods();

            if (in_array('GET', $methods) && $name && str_starts_with($name, 'admin.')) {
                if (preg_match('/(store|update|destroy|delete|bulk|clear|fetch|export|import|create|edit|recent|unread|mark)/i', $name)) continue;

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
        foreach ($menus as $menu) $uniqueMenus[$menu['url']] = $menu;
        return array_values($uniqueMenus);
    }
}