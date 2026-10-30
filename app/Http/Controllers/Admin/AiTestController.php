<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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

        // Bütün provayderləri mərkəzi config faylından oxuyuruq
        $providers = config('rj-ai.providers', []);
        $results = [];

        foreach ($providers as $p) {
            $key = $keys[$p['key_name']] ?? null;

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
