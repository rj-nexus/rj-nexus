<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;

class AiAgentService
{
    protected array $providers = [];

    public function __construct()
    {
        $this->loadProvidersFromVault();
    }

    protected function loadProvidersFromVault(): void
    {
        $vaultUrl = env('RJ_VAULT_URL', 'https://twilight-art-0b0e.ruhidjavadoff.workers.dev');

        $keys = Cache::remember('rj_ai_keys_pool', 3600, function () use ($vaultUrl) {
            try {
                $response = Http::timeout(15)->get($vaultUrl);
                if ($response->successful()) {
                    return $response->json() ?: [];
                }
                Log::error('AI Vault Error: HTTP ' . $response->status());
            } catch (\Throwable $e) {
                Log::error('AI Vault Exception: ' . $e->getMessage());
            }
            return [];
        });

        if (empty($keys)) {
            return;
        }

        $configuredProviders = config('rj-ai.providers', []);
        $this->providers = [];

        foreach ($configuredProviders as $p) {
            $key = $keys[$p['key_name']] ?? null;

            if ($key) {
                $this->providers[] = [
                    'name' => $p['name'],
                    'type' => $p['type'],
                    'url'  => $p['url'],
                    'model'=> $p['model'],
                    'key'  => $key,
                ];
            }
        }
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        $docContext = $this->searchDocs($question);
        $systemContext = $this->getSystemContext($question);
        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        $systemPrompt = "You are the intelligent support AI for RJ Nexus (a self-hosted CMS).
        INSTRUCTIONS:
        1. Use the provided CONTEXT to answer.
        2. If the context doesn't have the answer, answer from your general knowledge.
        3. Respond in the SAME LANGUAGE as the user's question.";

        $prompt = $systemPrompt . "\n\n--- CONTEXT ---\n" . mb_substr($fullContext, 0, 3500) . "\n\n--- USER ---\n" . $question;

        $debugErrors = [];

        foreach ($this->providers as $provider) {
            try {
                $response = $this->callProvider($provider, $prompt);

                if ($response) {
                    return ['success' => true, 'answer' => trim($response), 'provider' => $provider['name']];
                }
            } catch (\Throwable $e) {
                $debugErrors[] = "{$provider['name']}: " . $e->getMessage();
                Log::warning("AI Provider Error ({$provider['name']}): " . $e->getMessage());
            }
        }

        if (!empty($docContext)) {
            return [
                'success' => true,
                'answer' => __('The AI service is currently at its limit. Here is the most relevant information I found in the documentation:') . "\n\n" . strip_tags($docContext),
                'provider' => 'local_rag'
            ];
        }

        return [
            'success' => false,
            'answer' => __('All AI services are currently unavailable. Please try again later.'),
            'debug' => $debugErrors
        ];
    }

    protected function callProvider(array $provider, string $prompt): ?string
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($provider['type'] === 'gemini') {
            $url = $provider['url'] . '?key=' . $provider['key'];
            $response = Http::withHeaders($headers)->timeout(45)->post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
            throw new \Exception("HTTP " . $response->status());
        }

        if ($provider['type'] === 'cohere') {
            $headers['Authorization'] = 'Bearer ' . $provider['key'];
            $response = Http::withHeaders($headers)->timeout(45)->post($provider['url'], [
                'model' => $provider['model'],
                'message' => $prompt,
            ]);

            if ($response->successful()) {
                return $response->json('text');
            }
            throw new \Exception("HTTP " . $response->status());
        }

        $headers['Authorization'] = 'Bearer ' . $provider['key'];

        $response = Http::withHeaders($headers)->timeout(45)->post($provider['url'], [
            'model' => $provider['model'],
            'messages' => [['role' => 'user', 'content' => $prompt]],
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        throw new \Exception("HTTP " . $response->status());
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

        return $context;
    }
}
