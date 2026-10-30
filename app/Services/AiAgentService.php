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
            } catch (\Throwable $e) {
                Log::error('AI Vault Exception: ' . $e->getMessage());
            }
            return [];
        });

        $configuredProviders = config('rj-ai.providers', []);

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

        $userOpenRouterKey = rj_get_option('openrouter_api_key');
        if (!empty($userOpenRouterKey)) {
            if (str_starts_with($userOpenRouterKey, 'eyJ')) {
                try {
                    $userOpenRouterKey = \Illuminate\Support\Facades\Crypt::decryptString($userOpenRouterKey);
                } catch (\Throwable $e) { $userOpenRouterKey = null; }
            }

            if (!empty($userOpenRouterKey)) {
                $this->providers[] = [
                    'name' => 'user_openrouter',
                    'type' => 'openai',
                    'url'  => 'https://openrouter.ai/api/v1/chat/completions',
                    'model'=> 'openai/gpt-4o-mini',
                    'key'  => $userOpenRouterKey,
                ];
            }
        }
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        // 1. KESHLƏMƏ (Semantic Caching): Eyni sual verilibsə, API-yə getmədən cavab qaytarırıq
        $normalizedQuery = strtolower(trim(preg_replace('/[^\w\s]/u', '', $question)));
        $cacheKey = 'rj_ai_q_' . md5($normalizedQuery);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // 2. SİSTEM MƏLUMATLARI (System Context): Əgər sadə statistika soruşulursa, AI-a getmədən cavab veririk
        $q = strtolower($question);
        if (str_contains($q, 'neçə post') || str_contains($q, 'neçə yazı') || str_contains($q, 'how many posts')) {
            $count = Post::where('type', 'post')->count();
            $result = ['success' => true, 'answer' => __('Hazırda saytınızda ümumilikdə :count post var.', ['count' => $count]), 'provider' => 'system_direct'];
            Cache::put($cacheKey, $result, 86400); // 24 saat yadda saxla
            return $result;
        }

        // 3. LOKAL RAG (Local Search): Əgər cavab sənədlərdə varsa və çox uyğundursa, API-yə getmirik
        $docContext = $this->searchDocs($question);

        // Əgər sənədlərdən kifayət qədər uzun (məzmunlu) cavab tapılıbsa, birbaşa onu qaytarırıq
        if (!empty($docContext) && strlen($docContext) > 300) {
            $result = [
                'success' => true,
                'answer' => __("Sənədlərdə bu suala uyğun məlumat tapdım:") . "\n\n" . strip_tags($docContext),
                'provider' => 'local_rag_direct'
            ];
            Cache::put($cacheKey, $result, 43200); // 12 saat yadda saxla
            return $result;
        }

        // 4. AI API-LƏRİ (Fallback): Əgər yuxarıdakılar işləməsə, API-lərə müraciət edirik
        $systemContext = $this->getSystemContext($question);
        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        // Prompt-u qısaltdıq (Token qənaəti)
        $systemPrompt = "You are the AI support for RJ Nexus CMS. Use the context to answer. If context is missing, use general knowledge. Reply in user's language.";
        $prompt = $systemPrompt . "\n\nContext:\n" . mb_substr($fullContext, 0, 1500) . "\n\nUser: " . $question;

        $debugErrors = [];

        foreach ($this->providers as $provider) {
            try {
                $response = $this->callProvider($provider, $prompt);

                if ($response) {
                    $result = ['success' => true, 'answer' => trim($response), 'provider' => $provider['name']];
                    Cache::put($cacheKey, $result, 86400); // Uğurlu cavabı 24 saat keşdə saxla
                    return $result;
                }
            } catch (\Throwable $e) {
                $debugErrors[] = "{$provider['name']}: " . $e->getMessage();
                Log::warning("AI Provider Error ({$provider['name']}): " . $e->getMessage());
            }
        }

        // 5. Son Çarə: Local RAG (Əgər API-lər tamamilə çökübsə)
        if (!empty($docContext)) {
            return [
                'success' => true,
                'answer' => __('AI xidmətləri hazırda əlçatmazdır. Sənədlərdə tapdığım məlumat:') . "\n\n" . strip_tags($docContext),
                'provider' => 'local_rag_fallback'
            ];
        }

        return [
            'success' => false,
            'answer' => __('Bütün AI xidmətləri hazırda əlçatmazdır. Zəhmət olmasa sonra yenidən cəhd edin.'),
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
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => ['maxOutputTokens' => 400] // Cavab uzunluğunu məhdudlaşdırırıq
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
                'max_tokens' => 400
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
            'max_tokens' => 400 // OpenAI uyğun API-lər üçün
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
                $results[$file->getFilename()] = mb_substr($content, 0, 1500);
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
        $context = "--- SYSTEM DATA ---\n";
        $context .= "Current Date: " . now()->format('Y-m-d H:i:s') . "\n";

        if (str_contains($q, 'post') || str_contains($q, 'blog') || str_contains($q, 'yazı')) {
            $todayPosts = Post::where('type', 'post')->whereDate('created_at', today())->count();
            $totalPosts = Post::where('type', 'post')->count();
            $context .= "Today's Posts: {$todayPosts}, Total Posts: {$totalPosts}\n";
        }

        return $context;
    }
}
