<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$tests = [
    ['POST openai', fn() => Http::timeout(20)->post('https://text.pollinations.ai/openai', [
        'model' => 'openai',
        'messages' => [['role' => 'user', 'content' => 'salam']],
    ])],
    ['POST mistral', fn() => Http::timeout(20)->post('https://text.pollinations.ai/openai', [
        'model' => 'mistral',
        'messages' => [['role' => 'user', 'content' => 'salam']],
    ])],
    ['GET', fn() => Http::timeout(20)->get('https://text.pollinations.ai/salam')],
];

foreach ($tests as [$name, $call]) {
    echo "=== $name ===\n";
    try {
        $r = $call();
        echo $r->status() . ' ' . substr($r->body(), 0, 300) . "\n\n";
    } catch (\Throwable $e) {
        echo 'ERROR: ' . $e->getMessage() . "\n\n";
    }
}