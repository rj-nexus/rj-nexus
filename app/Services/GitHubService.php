<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GitHubService
{
    protected string $proxyUrl;

    public function __construct()
    {
        $this->proxyUrl = env('RJ_VAULT_URL', 'https://twilight-art-0b0e.ruhidjavadoff.workers.dev');
    }

    public function getReleases(string $owner, string $repo): array
    {
        $cacheKey = "github_releases_{$owner}_{$repo}";

        return Cache::remember($cacheKey, 3600, function () use ($owner, $repo) {
            try {
                $response = Http::timeout(20)->get($this->proxyUrl . '/releases', [
                    'owner' => $owner,
                    'repo'  => $repo,
                ]);

                if ($response->successful()) {
                    return $response->json() ?: [];
                }

                return [];
            } catch (\Throwable $e) {
                return [];
            }
        });
    }
}
