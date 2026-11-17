<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SafeHttpService
{
    protected array $trustedGroups = [
        'github' => [
            'github.com',
            'api.github.com',
            'codeload.github.com',
            'objects.githubusercontent.com',
            'raw.githubusercontent.com',
            'github.githubassets.com',
            'github-releases.githubusercontent.com',
        ],
    ];

    public function validateUrl(string $url): array
    {
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if (!in_array($scheme, ['http', 'https'], true)) {
            return ['ok' => false, 'message' => __('Only http and https URLs are allowed.')];
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        if ($host === '') {
            return ['ok' => false, 'message' => __('Invalid URL: missing host.')];
        }

        $ips = $this->resolveHost($host);

        if (empty($ips)) {
            return ['ok' => false, 'message' => __('Could not resolve host: :host', ['host' => $host])];
        }

        foreach ($ips as $ip) {
            if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return ['ok' => false, 'message' => __('Blocked host :host — resolves to a private or reserved IP.', ['host' => $host])];
            }
        }

        return ['ok' => true, 'host' => $host, 'ips' => $ips];
    }

    protected function resolveHost(string $host): array
    {
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return [$host];
        }

        $ips = [];

        $v4 = @gethostbynamel($host) ?: [];
        foreach ($v4 as $ip) {
            $ips[] = $ip;
        }

        $records = @dns_get_record($host, DNS_AAAA) ?: [];
        foreach ($records as $r) {
            if (!empty($r['ipv6'])) {
                $ips[] = $r['ipv6'];
            }
        }

        return array_values(array_unique($ips));
    }

    public function download(string $url, string $sinkPath, int $maxBytes = 52428800): array
    {
        $check = $this->validateUrl($url);

        if (empty($check['ok'])) {
            return ['success' => false, 'message' => $check['message']];
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'RJ-Nexus/1.0',
                'Accept' => 'application/zip, application/octet-stream, */*',
            ])
                ->timeout(120)
                ->withOptions([
                    'sink' => $sinkPath,
                    'allow_redirects' => [
                        'max' => 5,
                        'strict' => true,
                        'referer' => false,
                        'protocols' => ['http', 'https'],
                        'track_redirects' => true,
                    ],
                ])
                ->get($url);

            if (!$response->successful()) {
                return ['success' => false, 'message' => __('Download failed: HTTP :code', ['code' => $response->status()])];
            }

            if (!file_exists($sinkPath) || filesize($sinkPath) < 1) {
                return ['success' => false, 'message' => __('Downloaded file is empty.')];
            }

            if (filesize($sinkPath) > $maxBytes) {
                @unlink($sinkPath);
                return ['success' => false, 'message' => __('File exceeds maximum allowed size.')];
            }

            return ['success' => true, 'path' => $sinkPath, 'size' => filesize($sinkPath)];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function extractDomain(string $url): ?string
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host !== '' ? $host : null;
    }

    public function originGroup(string $host): ?string
    {
        $host = strtolower($host);

        foreach ($this->trustedGroups as $group => $domains) {
            foreach ($domains as $domain) {
                if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                    return $group;
                }
            }
        }

        return null;
    }

    public function isSameOrigin(string $originDomain, string $downloadUrl): bool
    {
        $originDomain = strtolower($originDomain);
        $downloadHost = $this->extractDomain($downloadUrl);

        if ($downloadHost === null) {
            return false;
        }

        $originGroup = $this->originGroup($originDomain);
        $downloadGroup = $this->originGroup($downloadHost);

        if ($originGroup !== null) {
            return $originGroup === $downloadGroup;
        }

        return $originDomain === $downloadHost
            || str_ends_with($downloadHost, '.' . $originDomain);
    }

    public function isTrustedDomain(string $host, array $extraTrusted = []): bool
    {
        $host = strtolower($host);

        if ($this->originGroup($host) !== null) {
            return true;
        }

        foreach ($extraTrusted as $trusted) {
            $trusted = strtolower(trim($trusted));
            if ($trusted === '') continue;

            if ($host === $trusted || str_ends_with($host, '.' . $trusted)) {
                return true;
            }
        }

        return false;
    }

    public function trustedGroups(): array
    {
        return $this->trustedGroups;
    }
}