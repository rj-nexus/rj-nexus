<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        $role = $user->role ?? null;

        if (!in_array($role, ['admin', 'super-admin', 'super_admin'], true)) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        if (!$this->isIpAllowed($request)) {
            abort(403, __('Your IP address is not allowed to access the admin panel.'));
        }

        return $next($request);
    }

    protected function isIpAllowed(Request $request): bool
    {
        try {
            if (rj_get_option('ip_whitelist_enabled') !== '1') {
                return true;
            }

            $proxyStatus = rj_proxy_status();

            if ($proxyStatus['behind_proxy'] && !$proxyStatus['trusted']) {
                return true;
            }

            $raw = (string) rj_get_option('ip_whitelist', '');
        } catch (\Throwable $e) {
            return true;
        }

        $allowed = $this->parseIps($raw);

        if (empty($allowed)) {
            return true;
        }

        $currentIp = $this->normalizeIp((string) $request->ip());

        if ($currentIp === '') {
            return false;
        }

        foreach ($allowed as $entry) {
            if ($entry === $currentIp) {
                return true;
            }
        }

        return false;
    }

    protected function parseIps(string $raw): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $raw);
        $result = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (!filter_var($line, FILTER_VALIDATE_IP)) {
                continue;
            }

            $result[] = $this->normalizeIp($line);
        }

        return array_values(array_unique($result));
    }

    protected function normalizeIp(string $ip): string
    {
        $ip = trim($ip);

        if (str_starts_with($ip, '::ffff:')) {
            $ip = substr($ip, 7);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return '';
    }
}
