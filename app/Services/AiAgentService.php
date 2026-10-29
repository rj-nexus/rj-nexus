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
            ],
            [
                'name' => 'llm7',
                'url'  => 'https://api.llm7.io/v1/chat/completions',
                'model'=> 'gpt-4o-mini',
            ],
            [
                'name' => 'kilo',
                'url'  => 'https://api.kilo.ai/api/gateway/chat/completions',
                'model'=> 'gpt-4o-mini',
            ],
        ];
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        $docContext = $this->searchDocs($question);
        $systemContext = $this->getSystemContext($question);

        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        $systemPrompt = "You are the RJ Nexus support AI. Answer based on context. If user asks for ideas, be creative.";
        
        // API limitinə düşməmək üçün mətni 1500 simvolla məhdudlaşdırırıq
        $prompt = $systemPrompt . "\n\nContext:\n" . mb_substr($fullContext, 0, 1500) . "\n\nUser: " . $question;

        $errors = [];

        foreach ($this->providers as $provider) {
            try {
                $response = Http::withOptions([
                    'verify' => false,
                ])->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json',
                ])->timeout(30)->post($provider['url'], [
                    'model' => $provider['model'],
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ]);

                if ($response->successful()) {
                    $content = $response->json('choices.0.message.content');
                    if ($content) {
                        return ['success' => true, 'answer' => trim($content), 'provider' => $provider['name']];
                    }
                }
                
                // Əgər API xəta qaytarıbsa, onu yadda saxlayırıq
                $errors[] = $provider['name'] . ': Status ' . $response->status() . ' - ' . mb_substr($response->body(), 0, 100);

            } catch (\Throwable $e) {
                $errors[] = $provider['name'] . ': ' . $e->getMessage();
            }
        }

        // Əgər bura çatdıqsa, heç bir API işləməyib. Xətaları birbaşa ekrana qaytarırıq ki, görək problem nədədir.
        return [
            'success' => false, 
            'answer' => __('Bütün AI xidmətləri hazırda əlçatmazdır.'),
            'debug' => $errors // Bu hissə brauzerin "Network" tabında görünəcək
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
            if ($score > 0) $results[$file->getFilename()] = mb_substr($content, 0, 1000);
        }
        arsort($results);
        $context = '';
        foreach (array_slice($results, 0, 1, true) as $name => $text) {
            $context .= "\n[Source: {$name}]\n{$text}\n";
        }
        return $context;
    }

    protected function getSystemContext(string $query): string
    {
        $q = strtolower($query);
        $context = "System Data: ";
        if (str_contains($q, 'post') || str_contains($q, 'blog') || str_contains($q, 'yazı') || str_contains($q, 'paylaşım')) {
            $todayPosts = Post::where('type', 'post')->whereDate('created_at', today())->count();
            $totalPosts = Post::where('type', 'post')->count();
            $context .= "Today's Posts: {$todayPosts}, Total Posts: {$totalPosts}. ";
        }
        return $context;
    }
}