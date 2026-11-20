<?php

use App\Support\ResponseCache\RjCacheProfile;
use Spatie\ResponseCache\Hasher\DefaultHasher;
use Spatie\ResponseCache\Replacers\CsrfTokenReplacer;
use Spatie\ResponseCache\Serializers\JsonSerializer;

return [
    'enabled' => env('RESPONSE_CACHE_ENABLED', false),

    'cache' => [
        'store' => env('RESPONSE_CACHE_DRIVER', 'file'),
        'lifetime_in_seconds' => (int) env('RESPONSE_CACHE_LIFETIME', 3600),
        'tag' => env('RESPONSE_CACHE_TAG', ''),
    ],

    'minimum_requests' => [
        'count' => (int) env('RESPONSE_CACHE_MINIMUM_REQUESTS', 1),
        'lifetime_in_seconds' => (int) env('RESPONSE_CACHE_MINIMUM_REQUESTS_LIFETIME', 60 * 60 * 24),
        'store' => env('RESPONSE_CACHE_MINIMUM_REQUESTS_STORE'),
    ],

    'bypass' => [
        'header_name' => env('CACHE_BYPASS_HEADER_NAME', 'X-RJ-Cache-Bypass'),
        'header_value' => env('CACHE_BYPASS_HEADER_VALUE', 'rj-nexus-bypass'),
    ],

    'debug' => [
        'enabled' => env('APP_DEBUG', false),
        'cache_time_header_name' => 'X-Cache-Time',
        'cache_status_header_name' => 'X-Cache-Status',
        'cache_age_header_name' => 'X-Cache-Age',
        'cache_key_header_name' => 'X-Cache-Key',
    ],

    'ignored_query_parameters' => [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
    ],

    'excluded_request_headers' => [
        'X-Livewire',
        'X-Livewire-Navigate',
        'X-Inertia',
    ],

    'cache_profile' => RjCacheProfile::class,

    'hasher' => DefaultHasher::class,

    'serializer' => JsonSerializer::class,

    'replacers' => [
        CsrfTokenReplacer::class,
    ],
];