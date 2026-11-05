<?php

declare(strict_types=1);

return [
    'fail_on' => 'high',

    'checks' => [
        'config.app-key' => ['enabled' => true],
        'config.app-env' => ['enabled' => true],
        'config.env-not-committed' => ['enabled' => true],
        'config.env-example-sync' => ['enabled' => true],
        'config.log-level' => ['enabled' => true],
        'config.env-calls-outside-config' => ['enabled' => true],
        'config.debug-blacklist' => ['enabled' => true],
        'config.trusted-proxies' => ['enabled' => true],
        'config.mail-smtp-encryption' => ['enabled' => true],
        'cookies.session-secure' => ['enabled' => true],
        'cookies.session-http-only' => ['enabled' => true],
        'cookies.session-same-site' => ['enabled' => true],
        'cookies.session-encrypt' => ['enabled' => true],
        'cookies.session-lifetime' => ['enabled' => true],
        'cookies.encrypt-middleware' => ['enabled' => true],
        'cookies.encrypt-excludes' => ['enabled' => true],
        'headers.cors-wildcard' => ['enabled' => true],
        'headers.hsts' => ['enabled' => true],
        'headers.x-content-type-options' => ['enabled' => true],
        'headers.x-frame-options' => ['enabled' => true],
        'headers.referrer-policy' => ['enabled' => true],
        'headers.csp-defined' => ['enabled' => true],
        'headers.csp-unsafe-inline' => ['enabled' => true],
        'php.expose-php' => ['enabled' => true],
        'php.display-errors' => ['enabled' => true],
        'php.allow-url-fopen' => ['enabled' => true],
        'php.public-sensitive-files' => ['enabled' => true],
        'php.phpinfo' => ['enabled' => true],
        'auth.bcrypt-rounds' => ['enabled' => true],
        'auth.sanctum-expiration' => ['enabled' => true],
        'auth.login-throttle' => ['enabled' => true],
        'auth.password-column-plain' => ['enabled' => true],
        'auth.signed-routes-verify' => ['enabled' => true],
        'auth.api-ability-scoping' => ['enabled' => true],
        'crypto.weak-hash' => ['enabled' => true],
        'crypto.weak-random' => ['enabled' => true],
        'crypto.cipher-not-pinned' => ['enabled' => true],
        'crypto.hardcoded-secret' => ['enabled' => true],
        'injection.command' => ['enabled' => true],
        'injection.process-shell' => ['enabled' => true],
        'injection.unserialize' => ['enabled' => true],
        'injection.open-redirect' => ['enabled' => true],
        'injection.host-header' => ['enabled' => true],
        'xss.blade-unescaped' => ['enabled' => true],
        'xss.html-string' => ['enabled' => true],
        'xss.url-javascript-protocol' => ['enabled' => true],
        'files.path-traversal' => ['enabled' => true],
        'files.unlink-user-input' => ['enabled' => true],
        'files.upload-mimes-validation' => ['enabled' => true],
        'files.public-executable-uploads' => ['enabled' => true],
        'files.disk-visibility' => ['enabled' => true],
        'sql.raw-user-input' => ['enabled' => true],
        'sql.raw-order-by' => ['enabled' => true],
        'sql.variable-table-column' => ['enabled' => true],
        'sql.validation-rule-injection' => ['enabled' => true],
        'csrf.middleware-disabled' => ['enabled' => true],
        'csrf.except-suspicious' => ['enabled' => true],
        'models.unguarded' => ['enabled' => true],
        'models.unguard-call' => ['enabled' => true],
        'models.foreign-key-fillable' => ['enabled' => true],
        'models.force-fill-user-input' => ['enabled' => true],
        'logging.dd-dump-debug' => ['enabled' => true],
        'logging.custom-error-pages' => ['enabled' => true],
        'logging.sensitive-in-log-context' => ['enabled' => true],
        'repo.dependabot' => ['enabled' => true],
        'repo.gitleaks-history' => ['enabled' => true],
        'repo.debug-toolbars' => ['enabled' => true],
        'ecosystem.telescope-production' => ['enabled' => true],
        'ecosystem.horizon-gate' => ['enabled' => true],
        'ecosystem.pulse-gate' => ['enabled' => true],
        'ecosystem.debugbar-enabled' => ['enabled' => true],
        'ecosystem.livewire-upload-rules' => ['enabled' => true],
        'dependencies.composer-audit' => ['enabled' => true],
        'dependencies.npm-audit' => ['enabled' => true],
        'dependencies.minimum-stability-dev' => ['enabled' => true],
        'dependencies.outdated-php' => ['enabled' => true],
    ],

    /*
     * Runtime probe (`php artisan larascan:probe`). Performs ONE real HTTP GET
     * against the running app and verifies the live response headers/cookies
     * match what the static checks expect.
     */
    'probe' => [
        'url' => env('LARASCAN_PROBE_URL'),
        'timeout' => 5,
        'probes' => [
            'probe.hsts' => ['enabled' => true],
            'probe.x-content-type-options' => ['enabled' => true],
            'probe.x-frame-options' => ['enabled' => true],
            'probe.referrer-policy' => ['enabled' => true],
            'probe.csp' => ['enabled' => true],
            'probe.cookie-flags' => ['enabled' => true],
            'probe.server-disclosure' => ['enabled' => true],
            'probe.https-redirect' => ['enabled' => true],
        ],
    ],

    'ignore' => [
        'vendor/*',
        'node_modules/*',
        'storage/*',
        'bootstrap/cache/*',
    ],

    'tools' => [
        'composer' => env('LARASCAN_COMPOSER_BIN', 'composer'),
        'npm' => env('LARASCAN_NPM_BIN', 'npm'),
        'semgrep' => env('LARASCAN_SEMGREP_BIN', 'semgrep'),
    ],

    /*
     * Baseline file written by `php artisan larascan:baseline`. Findings in
     * the baseline are suppressed on subsequent scans so only new findings
     * fail CI.
     *
     * null   = auto-detect larascan-baseline.json in the project root
     * string = custom path to the baseline file
     */
    'baseline' => null,
];
