<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\SeoController;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

Route::get('/test-ai-connection', function () {
    $results = [];
    
    // 1. Pollinations Test
    try {
        $res = \Illuminate\Support\Facades\Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
        ])->timeout(15)->post('https://text.pollinations.ai/openai', [
            'model' => 'openai',
            'messages' => [['role' => 'user', 'content' => 'Say hello in one word.']],
        ]);
        $results['pollinations'] = [
            'status' => $res->status(),
            'body' => mb_substr($res->body(), 0, 200)
        ];
    } catch (\Throwable $e) {
        $results['pollinations'] = ['error' => $e->getMessage()];
    }

    // 2. LLM7 Test
    try {
        $res2 = \Illuminate\Support\Facades\Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0'
        ])->timeout(15)->post('https://api.llm7.io/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [['role' => 'user', 'content' => 'Say hello in one word.']],
        ]);
        $results['llm7'] = [
            'status' => $res2->status(),
            'body' => mb_substr($res2->body(), 0, 200)
        ];
    } catch (\Throwable $e) {
        $results['llm7'] = ['error' => $e->getMessage()];
    }

    // 3. Groq (Açarsız yox, amma serverin çıxışını yoxlamaq üçün)
    try {
        $res3 = \Illuminate\Support\Facades\Http::timeout(15)->get('https://api.groq.com/openai/v1/models');
        $results['groq_reachability'] = [
            'status' => $res3->status(), // 401 qaytarmalıdır (açar yoxdur), amma 200/401 gəlməsi əlaqənin olduğunu göstərir
        ];
    } catch (\Throwable $e) {
        $results['groq_reachability'] = ['error' => $e->getMessage()];
    }

    return response()->json($results);
});
