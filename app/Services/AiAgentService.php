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
        // Daha stabil işləyən açarsız provayderlər (POST metoduna keçirildi)
        $this->providers = [
            [
                'name' => 'pollinations-post',
                'url'  => 'https://text.pollinations.ai/',
                'type' => 'pollinations_post',
            ],
            [
                'name' => 'keylessai',
                'url'  => 'https://keylessai.thryx.workers.dev/v1/chat/completions',
                'type' => 'openai',
            ]
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
        2. If the user asks about site stats (e.g., 'how many posts today'), use the SYSTEM DATA.
        3. If the user asks how to do something, use the DOCUMENTATION CONTEXT.
        4. If the user asks for ideas (e.g., 'what should I post today'), be creative and provide 3-4 engaging blog post ideas related to CMS, Web Design, or Technology.
        5. Answer clearly and in the same language as the user's question.";

        $prompt = $systemPrompt . "\n\n--- DOCUMENTATION CONTEXT ---\n" . mb_substr($fullContext, 0, 5000) . "\n\n--- USER QUESTION ---\n" . $question;

        foreach ($this->providers as $provider) {
            try {
                $answer = match ($provider['type']) {
                    'openai' => $this->callOpenAiCompatible($provider['url'], $prompt),
                    'pollinations_post' => $this->callPollinationsPost($provider['url'], $prompt),
                    default => null,
                };

                if ($answer) {
                    return ['success' => true, 'answer' => trim($answer), 'provider' => $provider['name']];
                }
            } catch (\Throwable $e) {
                Log::error("AI Agent Xətası ({$provider['name']}): " . $e->getMessage());
                continue;
            }
        }

        return ['success' => false, 'answer' => __('Bütün AI xidmətləri hazırda əlçatmazdır. Zəhmət olmasa bir az sonra yenidən cəhd edin.')];
    }

    /**
     * Pollinations POST Metodu (URL limitini aşmaq üçün)
     */
    protected function callPollinationsPost(string $url, string $prompt): ?string
    {
        // Brauzer kimi görünmək üçün User-Agent əlavə edirik ki, Cloudflare bloklamasın
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept' => 'text/plain'
        ])->timeout(40)->post($url, [
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'model' => 'openai' // Pollinations üçün default model
        ]);

        if ($response->successful()) {
            return $response->body();
        }

        Log::warning("Pollinations POST Xətası: " . $response->status() . " - " . $response->body());
        return null;
    }

    /**
     * OpenAI uyğunluğunda olan API-lər üçün
     */
    protected function callOpenAiCompatible(string $url, string $prompt): ?string
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ])->timeout(40)->post($url, [
            'model' => 'gpt-4o-mini',
            'messages' => [['role' => 'user', 'content' => $prompt]],
        ]);

        return $response->successful() ? $response->json('choices.0.message.content') : null;
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
                $results[$file->getFilename()] = mb_substr($content, 0, 2000);
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