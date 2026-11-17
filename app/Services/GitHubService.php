<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    protected string $proxyUrl;

    public function __construct()
    {
        $this->proxyUrl = (string) config('rj-ai.vault_url', '');
    }

    public function getReleases(string $owner, string $repo): array
    {
        $cacheKey = "github_releases_{$owner}_{$repo}";

        return Cache::remember($cacheKey, 3600, function () use ($owner, $repo) {
            $fromProxy = $this->fetchFromProxy($owner, $repo);

            if (!empty($fromProxy)) {
                return $fromProxy;
            }

            return $this->fetchFromGitHub($owner, $repo);
        });
    }

    protected function fetchFromProxy(string $owner, string $repo): array
    {
        if ($this->proxyUrl === '') {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'RJ-Nexus/1.0',
                'Accept' => 'application/json',
            ])
                ->timeout(15)
                ->get($this->proxyUrl . '/releases', [
                    'owner' => $owner,
                    'repo' => $repo,
                ]);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            if (!is_array($data)) {
                return [];
            }

            if (isset($data['releases']) && is_array($data['releases'])) {
                return $data['releases'];
            }

            return array_is_list($data) ? $data : [];
        } catch (\Throwable $e) {
            Log::warning('GitHubService proxy failed: ' . $e->getMessage());
            return [];
        }
    }

    protected function fetchFromGitHub(string $owner, string $repo): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'RJ-Nexus/1.0',
                'Accept' => 'application/vnd.github+json',
            ])
                ->timeout(20)
                ->get("https://api.github.com/repos/{$owner}/{$repo}/releases", [
                    'per_page' => 10,
                ]);

            if (!$response->successful()) {
                Log::warning('GitHub API direct failed: HTTP ' . $response->status());
                return [];
            }

            $data = $response->json();

            return is_array($data) ? $data : [];
        } catch (\Throwable $e) {
            Log::warning('GitHub API direct failed: ' . $e->getMessage());
            return [];
        }
    }
}