<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AiTestController extends Controller
{
    public function index()
    {
        $vaultUrl = env('RJ_VAULT_URL', 'https://twilight-art-0b0e.ruhidjavadoff.workers.dev');
        $vaultStatus = 'Failed';
        $keys = [];

        try {
            $res = Http::timeout(10)->get($vaultUrl);
            if ($res->successful()) {
                $vaultStatus = 'Success';
                $keys = $res->json() ?: [];
            } else {
                $vaultStatus = 'HTTP ' . $res->status();
            }
        } catch (\Throwable $e) {
            $vaultStatus = $e->getMessage();
        }

        $providers = [
            ['name' => 'groq', 'key' => 'groq', 'url' => 'https://api.groq.com/openai/v1/chat/completions', 'model' => 'llama-3.3-70b-versatile', 'type' => 'openai'],
            ['name' => 'ovh', 'key' => 'ovh', 'url' => 'https://oai.endpoints.kepler.ai.cloud.ovh.net/v1/chat/completions', 'model' => 'Meta-Llama-3_3-70B-Instruct', 'type' => 'openai'],
            ['name' => 'gemini', 'key' => 'gemini', 'url' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', 'model' => 'gemini-1.5-flash', 'type' => 'gemini'],
            ['name' => 'mistral', 'key' => 'mistral', 'url' => 'https://api.mistral.ai/v1/chat/completions', 'model' => 'open-mistral-7b', 'type' => 'openai'],
            ['name' => 'nvidia', 'key' => 'nvidia', 'url' => 'https://integrate.api.nvidia.com/v1/chat/completions', 'model' => 'meta/llama3-70b-instruct', 'type' => 'openai'],
            ['name' => 'huggingface', 'key' => 'huggingface', 'url' => 'https://api-inference.huggingface.co/v1/chat/completions', 'model' => 'mistralai/Mistral-7B-Instruct-v0.2', 'type' => 'openai'],
            ['name' => 'llm7', 'key' => 'llm7', 'url' => 'https://api.llm7.io/v1/chat/completions', 'model' => 'gpt-4o', 'type' => 'openai'],
            ['name' => 'pollinations', 'key' => 'pollinations', 'url' => 'https://text.pollinations.ai/openai', 'model' => 'openai', 'type' => 'openai'],
            ['name' => 'cohere', 'key' => 'cohere', 'url' => 'https://api.cohere.ai/v1/chat', 'model' => 'command-r', 'type' => 'cohere'],
        ];

        $results = [];

        foreach ($providers as $p) {
            $key = $keys[$p['key']] ?? null;

            if (!$key) {
                $results[] = ['name' => $p['name'], 'status' => 'Not Configured', 'code' => '-', 'response' => 'No key found in Vault', 'time' => 0];
                continue;
            }

            $start = microtime(true);
            $status = 'Failed';
            $code = '-';
            $responseText = '';

            try {
                $headers = ['User-Agent' => 'RJ-Nexus-Test', 'Accept' => 'application/json'];
                $prompt = 'Say "OK"';

                if ($p['type'] === 'gemini') {
                    $r = Http::withHeaders($headers)->timeout(10)->post($p['url'] . '?key=' . $key, [
                        'contents' => [['parts' => [['text' => $prompt]]]]
                    ]);
                } elseif ($p['type'] === 'cohere') {
                    $r = Http::withHeaders($headers)->withToken($key)->timeout(10)->post($p['url'], [
                        'model' => $p['model'],
                        'message' => $prompt,
                    ]);
                } else {
                    $r = Http::withHeaders($headers)->withToken($key)->timeout(10)->post($p['url'], [
                        'model' => $p['model'],
                        'messages' => [['role' => 'user', 'content' => $prompt]],
                    ]);
                }

                $code = $r->status();
                if ($r->successful()) {
                    $status = 'Success';
                    $responseText = mb_substr($r->body(), 0, 150);
                } else {
                    $responseText = mb_substr($r->body(), 0, 150);
                }
            } catch (\Throwable $e) {
                $responseText = $e->getMessage();
            }

            $time = round((microtime(true) - $start) * 1000);

            $results[] = [
                'name' => $p['name'],
                'status' => $status,
                'code' => $code,
                'response' => $responseText,
                'time' => $time . ' ms'
            ];
        }

        return view('admin.test-ai', compact('vaultStatus', 'results'));
    }
}
