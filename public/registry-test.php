<?php

header('Content-Type: text/plain; charset=utf-8');

$base = 'https://raw.githubusercontent.com/rj-nexus/rj-registration/main';

$endpoints = [
    'registry.json' => $base . '/registry.json',
    'themes.json'   => $base . '/themes.json',
    'plugins.json'  => $base . '/plugins.json',
];

foreach ($endpoints as $name => $url) {
    echo "=== {$name} ===\n";
    echo "URL: {$url}\n";

    $ctx = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: RJ-Test\r\n",
            'timeout' => 15,
        ],
    ]);

    $body = @file_get_contents($url, false, $ctx);

    if ($body === false) {
        $err = error_get_last();
        echo "STATUS: FAILED\n";
        echo "ERROR: " . ($err['message'] ?? 'unknown') . "\n\n";
        continue;
    }

    $json = json_decode($body, true);

    if (!is_array($json)) {
        echo "STATUS: INVALID JSON\n";
        echo "BODY (first 200): " . substr($body, 0, 200) . "\n\n";
        continue;
    }

    echo "STATUS: OK\n";
    echo "SIZE: " . strlen($body) . " bytes\n";

    if ($name === 'registry.json') {
        echo "version: " . ($json['version'] ?? '-') . "\n";
        echo "updated_at: " . ($json['updated_at'] ?? '-') . "\n";
        echo "themes.url: " . ($json['themes']['url'] ?? '-') . "\n";
        echo "themes.count: " . ($json['themes']['count'] ?? '-') . "\n";
        echo "plugins.url: " . ($json['plugins']['url'] ?? '-') . "\n";
        echo "plugins.count: " . ($json['plugins']['count'] ?? '-') . "\n";
    } elseif ($name === 'themes.json') {
        $items = $json['themes'] ?? [];
        echo "count: " . count($items) . "\n";
        foreach (array_slice($items, 0, 3) as $i => $t) {
            echo "  [{$i}] " . ($t['repo'] ?? '-') . " | " . ($t['name'] ?? '-') . " | v" . ($t['version'] ?? '-') . "\n";
        }
    } elseif ($name === 'plugins.json') {
        $items = $json['plugins'] ?? [];
        echo "count: " . count($items) . "\n";
        foreach (array_slice($items, 0, 3) as $i => $p) {
            echo "  [{$i}] " . ($p['repo'] ?? '-') . " | " . ($p['name'] ?? '-') . " | v" . ($p['version'] ?? '-') . "\n";
        }
    }

    echo "\n";
}

echo "=== Worker /submit (sadece OPTIONS) ===\n";
$worker = 'https://twilight-art-0b0e.ruhidjavadoff.workers.dev/submit';
$ctx = stream_context_create([
    'http' => [
        'method' => 'OPTIONS',
        'header' => "Origin: https://rj-nexus.github.io\r\nAccess-Control-Request-Method: POST\r\n",
        'timeout' => 10,
        'ignore_errors' => true,
    ],
]);
$body = @file_get_contents($worker, false, $ctx);
$headers = isset($http_response_header) ? $http_response_header : [];
echo "URL: {$worker}\n";
echo "STATUS LINE: " . ($headers[0] ?? 'unknown') . "\n";
foreach ($headers as $h) {
    if (stripos($h, 'access-control-') === 0) {
        echo "  " . $h . "\n";
    }
}
echo $body === false ? "BODY: (none)\n" : "BODY: " . substr($body, 0, 120) . "\n";
