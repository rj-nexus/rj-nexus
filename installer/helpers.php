<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

function rj_languages(): array
{
    return [
        'en' => 'English',
        'az' => 'Azərbaycan',
        'de' => 'Deutsch',
        'es' => 'Español',
        'fr' => 'Français',
        'pt' => 'Português',
        'ru' => 'Русский',
        'tr' => 'Türkçe',
        'hi' => 'हिन्दी',
        'zh' => '中文',
        'ja' => '日本語',
        'id' => 'Bahasa Indonesia',
        'ar' => 'العربية',
        'it' => 'Italiano',
        'nl' => 'Nederlands',
        'hy' => 'Հայերեն',
        'ka' => 'ქართული',
    ];
}

function rj_rtl_languages(): array
{
    return ['ar', 'fa', 'he', 'ur'];
}

function rj_is_rtl(?string $lang = null): bool
{
    $lang = $lang ?? ($_SESSION['rj_install']['lang'] ?? 'en');
    return in_array($lang, rj_rtl_languages(), true);
}

function rj_t_current(): array
{
    static $cache = [];
    $lang = $_SESSION['rj_install']['lang'] ?? 'en';
    $available = rj_languages();

    if (!isset($available[$lang])) {
        $lang = 'en';
    }

    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $file = __DIR__ . '/lang/' . $lang . '.php';
    if (!file_exists($file)) {
        $file = __DIR__ . '/lang/en.php';
    }

    $data = require $file;
    $cache[$lang] = $data;

    return $data;
}

function rj_esc(?string $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

function rj_log(string $msg): void
{
    $dir = dirname(RJ_LOG);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    @file_put_contents(RJ_LOG, '[' . date('c') . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

function rj_requirements(): array
{
    $root = RJ_ROOT;

    return [
        'php' => [
            'ok' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'val' => PHP_VERSION,
        ],
        'pdo' => [
            'ok' => extension_loaded('pdo_mysql'),
            'val' => extension_loaded('pdo_mysql') ? 'yes' : 'no',
        ],
        'mb' => [
            'ok' => extension_loaded('mbstring'),
            'val' => extension_loaded('mbstring') ? 'yes' : 'no',
        ],
        'ssl' => [
            'ok' => extension_loaded('openssl'),
            'val' => extension_loaded('openssl') ? 'yes' : 'no',
        ],
        'file' => [
            'ok' => extension_loaded('fileinfo'),
            'val' => extension_loaded('fileinfo') ? 'yes' : 'no',
        ],
        'gd' => [
            'ok' => extension_loaded('gd'),
            'val' => extension_loaded('gd') ? 'yes' : 'no',
        ],
        'zip' => [
            'ok' => extension_loaded('zip'),
            'val' => extension_loaded('zip') ? 'yes' : 'no',
        ],
        'curl' => [
            'ok' => extension_loaded('curl'),
            'val' => extension_loaded('curl') ? 'yes' : 'no',
        ],
        'json' => [
            'ok' => extension_loaded('json'),
            'val' => extension_loaded('json') ? 'yes' : 'no',
        ],
        'tok' => [
            'ok' => extension_loaded('tokenizer'),
            'val' => extension_loaded('tokenizer') ? 'yes' : 'no',
        ],
        'xml' => [
            'ok' => extension_loaded('xml'),
            'val' => extension_loaded('xml') ? 'yes' : 'no',
        ],
        'ctype' => [
            'ok' => extension_loaded('ctype'),
            'val' => extension_loaded('ctype') ? 'yes' : 'no',
        ],
        'storage' => [
            'ok' => is_dir($root . '/storage') && is_writable($root . '/storage'),
            'val' => $root . '/storage',
        ],
        'cache' => [
            'ok' => is_dir($root . '/bootstrap/cache') && is_writable($root . '/bootstrap/cache'),
            'val' => $root . '/bootstrap/cache',
        ],
        'env' => [
            'ok' => is_writable($root),
            'val' => $root,
        ],
        'example' => [
            'ok' => file_exists(RJ_ENV_EXAMPLE),
            'val' => '.env.example',
        ],
    ];
}

function rj_requirements_ok(): bool
{
    foreach (rj_requirements() as $r) {
        if (!$r['ok']) {
            return false;
        }
    }
    return true;
}

function rj_db_test(array $cfg): array
{
    try {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $cfg['host'],
            (int) $cfg['port'],
            $cfg['name']
        );

        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);

        return ['ok' => true, 'msg' => 'OK', 'pdo' => $pdo];
    } catch (Throwable $e) {
        return ['ok' => false, 'msg' => $e->getMessage()];
    }
}

function rj_env_write(array $values): void
{
    if (!file_exists(RJ_ENV)) {
        if (!file_exists(RJ_ENV_EXAMPLE)) {
            throw new RuntimeException('.env.example missing');
        }
        copy(RJ_ENV_EXAMPLE, RJ_ENV);
    }

    $content = (string) file_get_contents(RJ_ENV);

    foreach ($values as $k => $v) {
        $v = (string) $v;

        $quoted = ($v === '' || str_contains($v, ' ') || str_contains($v, '#') || str_contains($v, '"'))
            ? '"' . addcslashes($v, '"\\') . '"'
            : $v;

        $pattern = '/^' . preg_quote($k, '/') . '=.*$/m';

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $k . '=' . $quoted, $content, 1);
        } else {
            $content = rtrim($content) . "\n{$k}={$quoted}\n";
        }
    }

    if (file_put_contents(RJ_ENV, $content) === false) {
        throw new RuntimeException('.env write failed');
    }

    @chmod(RJ_ENV, 0644);
}

function rj_artisan(array $args): array
{
    if (!function_exists('exec')) {
        return ['code' => -1, 'out' => 'exec() disabled on server'];
    }

    $outFile = tempnam(sys_get_temp_dir(), 'rj_art_');

    $cmd = escapeshellarg(PHP_BINARY)
        . ' '
        . escapeshellarg(RJ_ROOT . '/artisan')
        . ' '
        . implode(' ', array_map('escapeshellarg', $args))
        . ' > ' . escapeshellarg($outFile) . ' 2>&1';

    $code = 0;
    @exec($cmd, $dummy, $code);

    $output = file_exists($outFile) ? file_get_contents($outFile) : '';
    @unlink($outFile);

    return ['code' => $code, 'out' => $output];
}


function rj_install_run(?string $sqlContent = null): array
{
    $cfg = $_SESSION['rj_install'];
    $log = [];
    $lang = $cfg['lang'] ?? 'en';

    try {
        rj_env_write([
            'APP_NAME' => $cfg['site_name'],
            'APP_URL' => rtrim($cfg['site_url'], '/'),
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'APP_LOCALE' => $lang,
            'APP_KEY' => 'base64:' . base64_encode(random_bytes(32)),
            'DB_HOST' => $cfg['db']['host'],
            'DB_PORT' => $cfg['db']['port'],
            'DB_DATABASE' => $cfg['db']['name'],
            'DB_USERNAME' => $cfg['db']['user'],
            'DB_PASSWORD' => $cfg['db']['pass'],
        ]);
        $log[] = '.env written with app key';

        rj_artisan(['config:clear']);
        rj_artisan(['cache:clear']);

        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $cfg['db']['host'], (int) $cfg['db']['port'], $cfg['db']['name']),
            $cfg['db']['user'],
            $cfg['db']['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        if (!empty($sqlContent)) {
            $log[] = 'importing uploaded sql file';
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
            $pdo->exec($sqlContent);
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
            $log[] = 'sql file imported';
        } elseif (!empty($cfg['db_imported'])) {
            $log[] = 'skipping migrations (database imported manually)';
        } else {
            $mg = rj_artisan(['migrate', '--force', '--no-interaction']);
            if ($mg['code'] !== 0) {
                throw new RuntimeException('migrate failed: ' . $mg['out']);
            }
            $log[] = 'migrations run';

            $sd = rj_artisan(['db:seed', '--class=DatabaseSeeder', '--force', '--no-interaction']);
            if ($sd['code'] !== 0) {
                $log[] = 'seeder warning: ' . substr($sd['out'], 0, 500);
            } else {
                $log[] = 'base seeders run';
            }

            if (file_exists(RJ_ROOT . '/database/seeders/data/demo/manifest.json')) {
                $dm = rj_artisan(['db:seed', '--class=DemoSeeder', '--force', '--no-interaction']);
                if ($dm['code'] !== 0) {
                    throw new RuntimeException('Demo import failed: ' . $dm['out']);
                }
                $log[] = 'demo imported successfully';
            }
        }

        try {
            // 1. "language" parametrini yeniləyirik
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM rj_options WHERE option_name = 'language'");
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $pdo->prepare("UPDATE rj_options SET option_value = ? WHERE option_name = 'language'")->execute([$lang]);
            } else {
                $pdo->prepare("INSERT INTO rj_options (option_name, option_value, option_group, option_type, autoload, created_at, updated_at) VALUES ('language', ?, 'general', 'text', 1, NOW(), NOW())")->execute([$lang]);
            }

            // 2. "frontend_locale" parametrini yeniləyirik
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM rj_options WHERE option_name = 'frontend_locale'");
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $pdo->prepare("UPDATE rj_options SET option_value = ? WHERE option_name = 'frontend_locale'")->execute([$lang]);
            } else {
                $pdo->prepare("INSERT INTO rj_options (option_name, option_value, option_group, option_type, autoload, created_at, updated_at) VALUES ('frontend_locale', ?, 'language', 'text', 1, NOW(), NOW())")->execute([$lang]);
            }

            // 3. "frontend_locales" (array) parametrini yoxlayıb, seçilən dili əlavə edirik
            $stmt = $pdo->prepare("SELECT option_value FROM rj_options WHERE option_name = 'frontend_locales'");
            $stmt->execute();
            $flRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($flRow) {
                $fl = json_decode($flRow['option_value'], true);
                if (is_array($fl) && !in_array($lang, $fl)) {
                    $fl[] = $lang;
                    $pdo->prepare("UPDATE rj_options SET option_value = ? WHERE option_name = 'frontend_locales'")->execute([json_encode(array_values($fl))]);
                    $log[] = 'selected language added to frontend locales array';
                }
            } else {
                $pdo->prepare("INSERT INTO rj_options (option_name, option_value, option_group, option_type, autoload, created_at, updated_at) VALUES ('frontend_locales', ?, 'general', 'text', 1, NOW(), NOW())")->execute([json_encode([$lang])]);
                $log[] = 'frontend locales created with selected language';
            }

            $log[] = 'site languages updated in db successfully';
        } catch (Throwable $e) {
            $log[] = 'site language db update failed: ' . $e->getMessage();
        }

        if (empty($cfg['skip_admin']) && !empty($cfg['admin'])) {
            $hash = password_hash($cfg['admin']['pass'], PASSWORD_BCRYPT, ['cost' => 12]);
            $existing = 0;

            try {
                $existing = (int) $pdo->query("SELECT id FROM users ORDER BY id LIMIT 1")->fetchColumn();
            } catch (Throwable $e) {
                $log[] = 'users table check failed, skipping admin creation';
            }

            if ($existing > 0) {
                $pdo->prepare("UPDATE users SET name=?, email=?, password=?, email_verified_at=NOW(), updated_at=NOW() WHERE id=?")
                    ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash, $existing]);
                $log[] = 'admin user updated';
            } else {
                try {
                    $hasRole = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'")->fetch();
                } catch (Throwable $e) {
                    $hasRole = false;
                }

                if ($hasRole) {
                    $pdo->prepare("INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW(),NOW())")
                        ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash, 'admin']);
                } else {
                    $pdo->prepare("INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?,?,?,NOW(),NOW(),NOW())")
                        ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash]);
                }
                $log[] = 'admin user created';
            }
        }

        $sl = rj_artisan(['storage:link']);
        $log[] = $sl['code'] === 0 ? 'storage linked' : 'storage link warning: ' . substr($sl['out'], 0, 200);

        $lockDir = dirname(RJ_LOCK);
        if (!is_dir($lockDir)) {
            @mkdir($lockDir, 0755, true);
        }

        file_put_contents(RJ_LOCK, json_encode([
            'installed_at' => date('c'),
            'version' => '1.5.0',
            'lang' => $lang,
        ], JSON_PRETTY_PRINT));

        rj_artisan(['config:clear']);
        rj_artisan(['cache:clear']);
        rj_artisan(['optimize:clear']);

        rj_log(implode(' | ', $log));

        return ['ok' => true, 'log' => $log];
    } catch (Throwable $e) {
        rj_log('INSTALL FAIL: ' . $e->getMessage());
        return ['ok' => false, 'error' => $e->getMessage(), 'log' => $log];
    }
}

function rj_state(): array
{
    return $_SESSION['rj_install'] ?? [];
}

function rj_set_state(array $data): void
{
    $_SESSION['rj_install'] = $data;
}

function rj_http_host(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $scheme . '://' . $host;
}

function rj_installer_url(string $query = ''): string
{
    $base = strtok($_SERVER['REQUEST_URI'] ?? '/install.php', '?');
    return $base . ($query !== '' ? '?' . ltrim($query, '?') : '');
}
