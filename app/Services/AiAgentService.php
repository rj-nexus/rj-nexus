<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\Post;

class AiAgentService
{
    protected array $providers;

    public function __construct()
    {
        // Yalnız işləyən açarsız API-lər
        $this->providers = [
            [
                'name' => 'pollinations',
                'url'  => 'https://text.pollinations.ai/openai',
                'type' => 'openai',
                'model'=> 'openai',
            ],
            [
                'name' => 'llm7',
                'url'  => 'https://api.llm7.io/v1/chat/completions',
                'type' => 'openai',
                'model'=> 'gpt-4o', // Model adı dəyişdirildi (gpt-4o-mini yox)
            ],
        ];
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        $docContext = $this->searchDocs($question);
        $systemContext = $this->getSystemContext($question);

        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        $systemPrompt = "You are the intelligent support AI for RJ Nexus (a self-hosted CMS).
        INSTRUCTIONS:
        1. Read the provided DOCUMENTATION CONTEXT and SYSTEM DATA carefully.
        2. If the user asks about site stats, use the SYSTEM DATA.
        3. If the user asks how to do something, use the DOCUMENTATION CONTEXT.
        4. If the user asks for ideas, be creative and provide 3-4 engaging blog post ideas.
        5. Answer clearly and in the same language as the user's question.";

        $prompt = $systemPrompt . "\n\n--- DOCUMENTATION CONTEXT ---\n" . mb_substr($fullContext, 0, 4000) . "\n\n--- USER QUESTION ---\n" . $question;

        foreach ($this->providers as $provider) {
            try {
                $response = Http::withOptions([
                    'verify' => false, // SSL xətalarını keçmək üçün
                ])->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->timeout(45)->post($provider['url'], [
                    'model' => $provider['model'],
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ]);

                if ($response->successful()) {
                    // Düzgün JSON oxunması
                    $content = $response->json('choices.0.message.content');
                    
                    if ($content) {
                        return ['success' => true, 'answer' => trim($content), 'provider' => $provider['name']];
                    }
                }
                
                Log::warning("AI Provayder Xətası ({$provider['name']}): Status " . $response->status() . " - " . mb_substr($response->body(), 0, 200));

            } catch (\Throwable $e) {
                Log::error("AI Provayder İstisnası ({$provider['name']}): " . $e->getMessage());
            }
        }

        return [
            'success' => false, 
            'answer' => __('Bütün AI xidmətləri hazırda əlçatmazdır. Zəhmət olmasa bir az sonra yenidən cəhd edin.')
        ];
    }

    protected function searchDocs(string $query): string
    {
        $docsPath = resource_path('docs');
        if (!File::exists($docsPath)) return '';

        $files = File::files($docsPath);
        $results = [];
        $keywords = array_filter(explode(' ', strtolower($query)), fn($w) => strlen($w) > 3);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'md') continue;
            $content = File::get($file->getPathname());
            $score = 0;
            foreach ($keywords as $kw) {
                if (stripos($content, $kw) !== false) $score++;
            }
            if ($score > 0) {
                $results[$file->getFilename()] = mb_substr($content, 0, 2500);
            }
        }

        arsort($results);
        $topResults = array_slice($results, 0, 2, true);
        $context = '';
        foreach ($topResults as $name => $text) {
            $context .= "\n[Source: {$name}]\n{$text}\n";
        }
        return $context;
    }

    protected function getSystemContext(string $query): string
    {
        $q = strtolower($query);
        $context = "--- SYSTEM REAL-TIME DATA ---\n";
        $context .= "Current Date: " . now()->format('Y-m-d H:i:s') . "\n";

        if (str_contains($q, 'post') || str_contains($q, 'blog') || str_contains($q, 'yazı') || str_contains($q, 'paylaşım')) {
            $todayPosts = Post::where('type', 'post')->whereDate('created_at', today())->count();
            $totalPosts = Post::where('type', 'post')->count();
            $context .= "Today's Post Count: {$todayPosts}\n";
            $context .= "Total Posts: {$totalPosts}\n";
        }

        if (str_contains($q, 'page') || str_contains($q, 'səhifə')) {
            $totalPages = Post::where('type', 'page')->count();
            $context .= "Total Pages: {$totalPages}\n";
        }

        return $context;
    }
}