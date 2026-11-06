<?php

return [

    // BÜTÜN SKANERLƏR BURADA SADALANIB
    'default_scanners' => [
        'livewire',
        'rate-limit',
        'function-security',
        'data-exposure',
        'authentication',
        'authorization',
        'xss',
        'sql-injection',
        'csrf',
        'command-injection',
        'file-upload',
        'mass-assignment',
        'session-security',
        'sensitive-data',
        'route-security',
        'dependency',
        'environment',
    ],

    'scan_paths' => [
        'app',
        'resources/views',
        'routes',
        'config',
        'database',
        'rj-content',
    ],

    'exclude_paths' => [
        'vendor',
        'node_modules',
        'storage',
        'bootstrap/cache',
        'public',
        'tests',
    ],

    'file_extensions' => [
        'php',
        'blade.php',
    ],

    'severity_threshold' => 'low',

    'report' => [
        'format' => 'html', // HTML hesabatı
        'output_dir' => storage_path('scanner-reports'),
        'auto_save' => true, // Avtomatik yadda saxla
    ],

    'livewire' => [
        'check_public_properties' => true,
        'check_authorization' => true,
        'check_validation' => true,
        'check_mass_assignment' => true,
        'protected_properties' => ['password', 'token', 'secret', 'api_key'],
    ],

    'rate_limit' => [
        'check_routes' => true,
        'check_api_routes' => true,
        'check_auth_routes' => true,
        'required_on_patterns' => [
            '/api/*',
            '/login',
            '/register',
            '/password/reset',
            '/rj-widget/login',
            '/*/account/password',
            '/admin/profile/password',
        ],
    ],

    'function_security' => [
        'dangerous_functions' => [
            'eval', 'exec', 'system', 'shell_exec', 'passthru', 'proc_open', 'popen', 'unserialize', 'assert', 'create_function',
        ],
        'check_raw_queries' => true,
        'check_file_operations' => true,
    ],

    'data_exposure' => [
        'check_debug_mode' => true,
        'check_stack_traces' => true,
        'check_api_responses' => true,
        'sensitive_keywords' => [
            'password', 'secret', 'token', 'api_key', 'private_key', 'access_token', 'refresh_token', 'bearer',
        ],
    ],

    'authentication' => [
        'check_password_validation' => true,
        'check_session_config' => true,
        'check_remember_token' => true,
        'minimum_password_length' => 8,
    ],

    'xss' => [
        'check_blade_raw_output' => true,
        'check_javascript_injection' => true,
        'check_url_injection' => true,
    ],

    'sql_injection' => [
        'check_raw_queries' => true,
        'check_whereRaw' => true,
        'check_orderByRaw' => true,
        'check_havingRaw' => true,
    ],

    'dependencies' => [
        'check_outdated' => true,
        'check_security_advisories' => true,
        'minimum_support_versions' => [
            'laravel/framework' => '10.0',
            'php' => '8.1',
        ],
    ],

    'custom_rules' => [
        //
    ],

    'show_fix_suggestions' => true,
    'show_progress' => true,
];
