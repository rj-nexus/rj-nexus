<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAgentService
{
    protected const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    protected const COOLDOWN_KEY = 'ai_agent_cooldown_until';

    protected array $providers = [
        ['name' => 'pollinations-chat', 'type' => 'chat', 'url' => 'https://text.pollinations.ai/openai', 'model' => 'openai'],
        ['name' => 'pollinations-get', 'type' => 'get', 'url' => 'https://text.pollinations.ai/', 'model' => 'openai'],
    ];

    public function ask(string $question, string $extraContext = ''): array
    {
        @set_time_limit(120);

        $docContext = '';
        $systemContext = '';

        try {
            $docContext = $this->searchDocs($question);
            $systemContext = $this->getSystemContext($question);
        } catch (\Throwable $e) {
            Log::warning('AI context error: ' . $e->getMessage());
        }

        $fullContext = trim($extraContext . "\n" . $docContext . "\n" . $systemContext);

        $cacheKey = 'ai_agent:' . md5($question . '|' . $fullContext);

        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }

        $until = (int) Cache::get(self::COOLDOWN_KEY, 0);
        if ($until > time()) {
            return $this->fallbackResult($docContext, $until - time(), []);
        }

        $system = "You are the official support AI for RJ Nexus CMS. Use the provided CONTEXT to answer the user's question. If the context does not contain the answer, answer from your general knowledge. Respond in the SAME LANGUAGE as the user's question.\n\n--- CONTEXT ---\n" . mb_substr($fullContext, 0, 3500);

        $errors = [];
        $wait = 0;

        foreach ($this->providers as $provider) {
            try {
                $content = $provider['type'] === 'get'
                    ? $this->callGet($provider, $system, $question)
                    : $this->callChat($provider, $system, $question);

                if ($content !== null && $content !== '') {
                    $result = ['success' => true, 'answer' => $content, 'provider' => $provider['name']];
                    Cache::put($cacheKey, $result, now()->addHour());
                    return $result;
                }

                $errors[] = $provider['name'] . ': empty response';
                Log::warning('AI provider empty: ' . $provider['name']);
            } catch (\Throwable $e) {
                $errors[] = $provider['name'] . ': ' . mb_substr($e->getMessage(), 0, 200);
                Log::warning('AI provider failed: ' . $provider['name'] . ' - ' . $e->getMessage());

                if (in_array($e->getCode(), [402, 429], true)) {
                    $wait = $this->parseWait($e->getMessage());
                    Cache::put(self::COOLDOWN_KEY, time() + $wait, $wait);
                    break;
                }
            }
        }

        return $this->fallbackResult($docContext, $wait, $errors);
    }

    protected function fallbackResult(string $docContext, int $wait, array $errors): array
    {
        $result = [
            'success' => true,
            'answer' => $this->localFallback($docContext, $wait),
            'provider' => 'local',
            'retry_after' => $wait,
        ];

        if (config('app.debug')) {
            $result['debug'] = $errors;
        }

        return $result;
    }

    protected function parseWait(string $message): int
    {
        if (preg_match('/(\d+)\s*seconds?/i', $message, $m)) {
            return max(5, min(120, (int) $m[1] + 2));
        }

        return 30;
    }

    protected function callChat(array $provider, string $system, string $question): ?string
    {
        $response = Http::withHeaders([
            'User-Agent' => self::USER_AGENT,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->connectTimeout(5)
            ->timeout(40)
            ->post($provider['url'], [
                'model' => $provider['model'],
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $question],
                ],
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('HTTP ' . $response->status() . ' ' . mb_substr($response->body(), 0, 300), $response->status());
        }

        $content = $response->json('choices.0.message.content');

        return is_string($content) ? trim($content) : null;
    }

    protected function callGet(array $provider, string $system, string $question): ?string
    {
        $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
            ->connectTimeout(5)
            ->timeout(40)
            ->get($provider['url'] . rawurlencode(mb_substr($question, 0, 500)), [
                'system' => mb_substr($system, 0, 1500),
                'model' => $provider['model'],
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('HTTP ' . $response->status() . ' ' . mb_substr($response->body(), 0, 300), $response->status());
        }

        $body = trim($response->body());

        if ($body !== '' && str_starts_with($body, '{') && str_contains($body, '"error"')) {
            throw new \RuntimeException('API error: ' . mb_substr($body, 0, 300));
        }

        return $body !== '' ? $body : null;
    }

    protected function localFallback(string $docContext, int $wait = 0): string
    {
        $docContext = trim($docContext);

        $head = $wait > 0
            ? __('The free AI is busy right now. Please try again in :seconds seconds.', ['seconds' => $wait])
            : __('AI service is currently unavailable. Please try again in a moment.');

        if ($docContext === '') {
            return $head;
        }

        return $head . "\n\n" . __('The closest documentation match:') . "\n\n" . mb_substr($docContext, 0, 1200);
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