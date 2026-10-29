<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAgentService
{
    protected array $providers;

    public function __construct()
    {
        $this->providers = $this->buildProviders();
    }

    protected function buildProviders(): array
    {
        $providers = [];

        $keyed = [
            ['groq', 'https://api.groq.com/openai/v1/chat/completions', 'llama-3.3-70b-versatile', config('services.ai.groq_key')],
            ['gemini', 'https://generativelanguage.googleapis.com/v1beta/openai/chat/completions', 'gemini-2.0-flash', config('services.ai.gemini_key')],
            ['openrouter', 'https://openrouter.ai/api/v1/chat/completions', 'meta-llama/llama-3.3-70b-instruct:free', config('services.ai.openrouter_key')],
        ];

        foreach ($keyed as [$name, $url, $model, $key]) {
            if (!empty($key)) {
                $providers[] = ['name' => $name, 'type' => 'openai', 'url' => $url, 'model' => $model, 'key' => $key];
            }
        }

        $providers[] = ['name' => 'pollinations-openai', 'type' => 'openai', 'url' => 'https://text.pollinations.ai/openai', 'model' => 'openai', 'key' => null];
        $providers[] = ['name' => 'pollinations-mistral', 'type' => 'openai', 'url' => 'https://text.pollinations.ai/openai', 'model' => 'mistral', 'key' => null];
        $providers[] = ['name' => 'pollinations-get', 'type' => 'get', 'url' => 'https://text.pollinations.ai/', 'model' => 'openai', 'key' => null];

        return $providers;
    }

    public function ask(string $question, string $extraContext = ''): array
    {
        $docContext = '';
        $systemContext = '';

        try {
            $docContext = $this->searchDocs($question);
            $systemContext = $this->getSystemContext($question);
        } catch (\Throwable $e) {
            Log::warning('Context generation error: ' . $e->getMessage());
        }

        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        $cacheKey = 'ai_agent:' . md5($question . '|' . $fullContext);

        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        $systemPrompt = "You are the official support AI for RJ Nexus CMS. Use the provided CONTEXT to answer the user's question. If the context does not contain the answer, answer from your general knowledge. Respond in the SAME LANGUAGE as the user's question.\n\n--- CONTEXT ---\n" . mb_substr($fullContext, 0, 3500);

        $errors = [];

        foreach ($this->providers as $provider) {
            try {
                $content = $provider['type'] === 'get'
                    ? $this->callGet($provider, $systemPrompt, $question)
                    : $this->callOpenAi($provider, $systemPrompt, $question);

                if ($content !== null && $content !== '') {
                    $result = ['success' => true, 'answer' => $content, 'provider' => $provider['name']];
                    Cache::put($cacheKey, $result, now()->addHour());
                    return $result;
                }

                $errors[] = "{$provider['name']}: empty response";
            } catch (\Throwable $e) {
                $errors[] = "{$provider['name']}: " . mb_substr($e->getMessage(), 0, 150);
            }
        }

        Log::warning('AI providers failed', $errors);

        $local = $this->localFallback($docContext);

        $result = [
            'success' => true,
            'answer' => $local,
            'provider' => 'local',
        ];

        if (config('app.debug')) {
            $result['debug'] = $errors;
        }

        return $result;
    }

    protected function callOpenAi(array $provider, string $system, string $question): ?string
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($provider['key'])) {
            $headers['Authorization'] = 'Bearer ' . $provider['key'];
        }

        $response = Http::withHeaders($headers)
            ->timeout(30)
            ->retry(2, 700, throw: false)
            ->post($provider['url'], [
                'model' => $provider['model'],
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $question],
                ],
                'temperature' => 0.4,
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('HTTP ' . $response->status());
        }

        $content = $response->json('choices.0.message.content');

        return is_string($content) ? trim($content) : null;
    }

    protected function callGet(array $provider, string $system, string $question): ?string
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ])
            ->timeout(40)
            ->get($provider['url'] . rawurlencode(mb_substr($question, 0, 500)), [
                'system' => mb_substr($system, 0, 1500),
                'model' => $provider['model'],
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('HTTP ' . $response->status());
        }

        $body = trim($response->body());

        return $body !== '' ? $body : null;
    }

    protected function localFallback(string $docContext): string
    {
        $docContext = trim($docContext);

        if ($docContext === '') {
            return __('AI service is currently unavailable. Please try again in a moment.');
        }

        return __('AI service is currently unavailable. The closest documentation match:') . "\n\n" . mb_substr($docContext, 0, 1200);
    }

    protected function searchDocs(string $query): string
    {
        $docsPath = resource_path('docs');
        if (!File::exists($docsPath)) {
            return '';
        }

        $keywords = array_values(array_unique(array_filter(
            preg_split('/[^\p{L}\p{N}]+/u', mb_strtolower($query)),
            fn($w) => mb_strlen($w) > 2
        )));

        if (empty($keywords)) {
            return '';
        }

        $scores = [];
        $contents = [];

        foreach (File::files($docsPath) as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }

            $content = File::get($file->getPathname());
            $lower = mb_strtolower($content);
            $score = 0;

            foreach ($keywords as $kw) {
                $score += mb_substr_count($lower, $kw);
            }

            if ($score > 0) {
                $scores[$file->getFilename()] = $score;
                $contents[$file->getFilename()] = $content;
            }
        }

        arsort($scores);

        $context = '';
        foreach (array_slice($scores, 0, 2, true) as $name => $score) {
            $context .= "\n[Source: {$name}]\n" . mb_substr($contents[$name], 0, 2500) . "\n";
        }

        return $context;
    }

    protected function getSystemContext(string $query): string
    {
        $q = mb_strtolower($query);
        $context = "--- SYSTEM REAL-TIME DATA ---\n";
        $context .= 'Current Date: ' . now()->format('Y-m-d H:i:s') . "\n";

        foreach (['post', 'blog', 'yazı', 'paylaşım'] as $needle) {
            if (str_contains($q, $needle)) {
                $context .= "Today's Post Count: " . Post::where('type', 'post')->whereDate('created_at', today())->count() . "\n";
                $context .= 'Total Posts: ' . Post::where('type', 'post')->count() . "\n";
                break;
            }
        }

        return $context;
    }
}