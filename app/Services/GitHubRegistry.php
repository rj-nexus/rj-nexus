<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GitHubRegistry
{
    protected string $indexUrl;
    protected ?string $token;
    protected int $cacheMinutes;

    public function __construct()
    {
        $this->indexUrl = rj_get_option(
            'registry_url',
            'https://raw.githubusercontent.com/rj-nexus/rj-registration/main/registry.json'
        );
        $this->token = rj_get_option('github_token') ?: null;
        $this->cacheMinutes = (int) rj_get_option('registry_cache_minutes', 60);
    }

    public function index(): array
    {
        return Cache::remember('rj_registry_index', 600, function () {
            return $this->fetchJson($this->indexUrl);
        });
    }

    public function themes(): array
    {
        $index = $this->index();
        $url = $index['themes']['url'] ?? null;

        if (!$url) {
            return [];
        }

        $data = Cache::remember('rj_registry_themes', $this->cacheMinutes * 60, function () use ($url) {
            return $this->fetchJson($url);
        });

        return $data['themes'] ?? [];
    }

    public function plugins(): array
    {
        $index = $this->index();
        $url = $index['plugins']['url'] ?? null;

        if (!$url) {
            return [];
        }

        $data = Cache::remember('rj_registry_plugins', $this->cacheMinutes * 60, function () use ($url) {
            return $this->fetchJson($url);
        });

        return $data['plugins'] ?? [];
    }

    public function fetch(): array
    {
        $index = $this->index();

        return [
            'themes' => $this->themes(),
            'plugins' => $this->plugins(),
            'updated_at' => $index['updated_at'] ?? null,
            'error' => $index['error'] ?? null,
        ];
    }

    public function enrichThemes(): array
    {
        return array_values(array_filter(array_map([$this, 'enrichEntry'], $this->themes())));
    }

    public function enrichPlugins(): array
    {
        return array_values(array_filter(array_map([$this, 'enrichEntry'], $this->plugins())));
    }

    protected function enrichEntry(array $entry): ?array
    {
        $repo = $entry['repo'] ?? null;

        if (!$repo || !preg_match('#^[^/]+/[^/]+$#', $repo)) {
            return null;
        }

        $release = Cache::remember('rj_repo_' . md5($repo), 1800, function () use ($repo) {
            return $this->fetchLatestRelease($repo);
        });

        $details = $entry['details'] ?? [];
        $installation = $entry['installation'] ?? [];
        $development = $entry['development'] ?? [];

        $name = $entry['name'] ?? $repo;

        return [
            'repo' => $repo,
            'owner' => explode('/', $repo)[0],
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'author' => $entry['author'] ?? '',
            'version' => $entry['version'] ?? ($release['release_version'] ?? '0.0.0'),
            'description' => $details['description'] ?? ($entry['description'] ?? ''),
            'features' => $details['features'] ?? [],
            'verified' => (bool) ($entry['verified'] ?? false),
            'featured' => (bool) ($entry['featured'] ?? false),
            'category' => $entry['category'] ?? 'general',
            'tags' => $entry['tags'] ?? [],
            'logo' => $entry['logo'] ?? null,
            'screenshots' => $entry['screenshots'] ?? [],
            'steps' => $installation['steps'] ?? [],
            'requires' => $development['requires'] ?? '',
            'docs' => $development['docs'] ?? "https://github.com/{$repo}",
            'tag' => $release['tag'] ?? null,
            'is_prerelease' => (bool) ($release['is_prerelease'] ?? false),
            'zip_url' => $release['zip_url'] ?? null,
            'size' => (int) ($release['size'] ?? 0),
            'published_at' => $release['published_at'] ?? null,
            'html_url' => "https://github.com/{$repo}",
            'release_available' => !empty($release['zip_url']),
        ];
    }

    protected function fetchJson(string $url): array
    {
        try {
            $headers = ['User-Agent' => 'RJ-Nexus'];

            if ($this->token && str_contains($url, 'api.github.com')) {
                $headers['Authorization'] = 'Bearer ' . $this->token;
            }

            $res = Http::timeout(15)->withHeaders($headers)->get($url);

            if (!$res->successful()) {
                return ['error' => 'HTTP ' . $res->status()];
            }

            $json = $res->json();

            if (!is_array($json)) {
                return ['error' => 'Invalid JSON'];
            }

            return $json;
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    protected function fetchLatestRelease(string $repo): ?array
    {
        try {
            $headers = [
                'Accept' => 'application/vnd.github+json',
                'User-Agent' => 'RJ-Nexus',
            ];

            if ($this->token) {
                $headers['Authorization'] = 'Bearer ' . $this->token;
            }

            $res = Http::timeout(15)->withHeaders($headers)
                ->get("https://api.github.com/repos/{$repo}/releases?per_page=1");

            if (!$res->successful() || empty($res->json())) {
                return null;
            }

            $release = $res->json()[0];
            $tag = $release['tag_name'] ?? null;

            if (!$tag) {
                return null;
            }

            $zip = null;
            $size = 0;

            foreach ($release['assets'] ?? [] as $asset) {
                if (str_ends_with(strtolower($asset['name'] ?? ''), '.zip')) {
                    $zip = $asset['browser_download_url'] ?? null;
                    $size = (int) ($asset['size'] ?? 0);
                    break;
                }
            }

            return [
                'tag' => $tag,
                'release_version' => ltrim($tag, 'vV'),
                'is_prerelease' => (bool) ($release['prerelease'] ?? false),
                'zip_url' => $zip,
                'size' => $size,
                'published_at' => $release['published_at'] ?? null,
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function clearCache(): void
    {
        $themes = $this->themes();
        $plugins = $this->plugins();

        Cache::forget('rj_registry_index');
        Cache::forget('rj_registry_themes');
        Cache::forget('rj_registry_plugins');

        foreach (array_merge($themes, $plugins) as $entry) {
            if (!empty($entry['repo'])) {
                Cache::forget('rj_repo_' . md5($entry['repo']));
            }
        }
    }

    public function hasToken(): bool
    {
        return !empty($this->token);
    }
}
