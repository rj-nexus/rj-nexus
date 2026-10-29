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
        $this->providers = [
            [
                'name' => 'pollinations',
                'url'  => 'https://text.pollinations.ai/openai',
                'model'=> 'openai',
            ]
        ];
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        $docContext = '';
        $systemContext = '';
        
        try {
            $docContext = $this->searchDocs($question);
            $systemContext = $this->getSystemContext($question);
        } catch (\Throwable $e) {
            // Əgər daxili axtarış xəta versə, AI yenə də işləsin
            Log::warning('Context generation error: ' . $e->getMessage());
        }

        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        // AI-a həmişə İngilis dilində düşünməyi, lakin istifadəçinin dilində cavab verməyi tapşırırıq
        $systemPrompt = "You are the official support AI for RJ Nexus CMS. 
        Use the provided CONTEXT to answer the user's question.
        If the context doesn't have the answer, answer from your general knowledge.
        Respond in the SAME LANGUAGE as the user's question.";

        $prompt = $systemPrompt . "\n\n--- CONTEXT ---\n" . mb_substr($fullContext, 0, 3500) . "\n\n--- USER ---\n" . $question;

        $debugErrors = [];

        foreach ($this->providers as $provider) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post($provider['url'], [
                    'model' => $provider['model'],
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ]);

                if ($response->successful()) {
                    $content = $response->json('choices.0.message.content');
                    
                    if ($content) {
                        return ['success' => true, 'answer' => trim($content), 'provider' => $provider['name']];
                    }
                    
                    $debugErrors[] = "{$provider['name']}: Empty content in JSON";
                } else {
                    $debugErrors[] = "{$provider['name']}: HTTP " . $response->status() . " - " . mb_substr($response->body(), 0, 150);
                }

            } catch (\Throwable $e) {
                $debugErrors[] = "{$provider['name']}: " . $e->getMessage();
            }
        }

        // Əgər bura çatdıqsa, heç bir API işləməyib. Xətanı birbaşa frontend-ə qaytarırıq.
        return [
            'success' => false, 
            'answer' => 'AI service is currently unavailable.',
            'debug' => $debugErrors 
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

        return $context;
    }
}