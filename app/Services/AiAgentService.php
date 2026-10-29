<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAgentService
{
    protected array $providers;

    public function __construct()
    {
        // Açarsız (Keyless) API Provayderləri
        $this->providers = [
            [
                'name' => 'keylessai',
                'url'  => 'https://keylessai.thryx.workers.dev/v1/chat/completions',
                'type' => 'openai',
            ],
            [
                'name' => 'kilo',
                'url'  => 'https://api.kilo.ai/api/gateway/chat/completions',
                'type' => 'openai',
            ],
            [
                'name' => 'pollinations',
                'url'  => 'https://text.pollinations.ai/',
                'type' => 'pollinations',
            ],
        ];
    }

    public function ask(string $question, string $context = ''): array
    {
        $systemPrompt = "You are the official AI support assistant for RJ Nexus. Answer clearly, accurately, and concisely based ONLY on the provided documentation context. If the answer is not in the context, politely say you don't know and suggest checking the RJ About section. Respond in the same language as the user's question.";
        
        // Kontekstin həcmini məhdudlaşdırırıq ki, API limitini aşmasın
        $prompt = $systemPrompt . "\n\n--- DOCUMENTATION CONTEXT ---\n" . mb_substr($context, 0, 6000) . "\n\n--- USER QUESTION ---\n" . $question;

        foreach ($this->providers as $provider) {
            try {
                $answer = match ($provider['type']) {
                    'openai'       => $this->callOpenAiCompatible($provider['url'], $prompt),
                    'pollinations' => $this->callPollinations($provider['url'], $prompt),
                    default        => null,
                };

                if ($answer) {
                    return [
                        'success' => true, 
                        'answer' => trim($answer), 
                        'provider' => $provider['name']
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning("AI Agent: {$provider['name']} xəta verdi. Səbəb: " . $e->getMessage());
                continue; // Növbəti provayderə keç
            }
        }

        return [
            'success' => false, 
            'answer' => __('Bütün AI xidmətləri hazırda əlçatmazdır. Zəhmət olmasa bir az sonra yenidən cəhd edin.')
        ];
    }

    /**
     * OpenAI uyğunluğunda olan API-lər üçün (KeylessAI, Kilo)
     */
    protected function callOpenAiCompatible(string $url, string $prompt): ?string
    {
        $response = Http::timeout(30)->post($url, [
            'model' => 'gpt-4o-mini',
            'messages' => [['role' => 'user', 'content' => $prompt]],
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }
        
        return null;
    }

    /**
     * Pollinations API üçün (GET sorğusu)
     */
    protected function callPollinations(string $baseUrl, string $prompt): ?string
    {
        $response = Http::timeout(30)->get($baseUrl . urlencode($prompt));
        return $response->successful() ? $response->body() : null;
    }
}