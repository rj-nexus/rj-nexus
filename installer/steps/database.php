<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang']) || !rj_requirements_ok()) {
    header('Location: ' . rj_installer_url('step=requirements'));
    exit;
}

$err = '';
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host']);
$action = $_POST['action'] ?? 'normal';

if ($submitted) {
    $cfg = [
        'host' => trim($_POST['db_host'] ?? '127.0.0.1'),
        'port' => (int) ($_POST['db_port'] ?? 3306),
        'name' => trim($_POST['db_name'] ?? ''),
        'user' => trim($_POST['db_user'] ?? ''),
        'pass' => (string) ($_POST['db_pass'] ?? ''),
    ];
    $siteName = trim($_POST['site_name'] ?? '');
    $siteUrl = trim($_POST['site_url'] ?? '');

    if ($cfg['name'] === '' || $cfg['user'] === '' || $siteName === '' || $siteUrl === '') {
        $err = $t['err_db'];
    } else {
        $dbTest = rj_db_test($cfg);
        if ($dbTest['ok']) {
            $state['db'] = $cfg;
            $state['site_name'] = $siteName;
            $state['site_url'] = $siteUrl;

            if ($action === 'imported_next') {
                $state['db_imported'] = true;
                rj_set_state($state);
                header('Location: ' . rj_installer_url('step=admin'));
                exit;
            } elseif ($action === 'imported_finish') {
                $state['db_imported'] = true;
                $state['skip_admin'] = true;
                rj_set_state($state);

                try {
                    rj_env_write([
                        'APP_NAME' => $siteName,
                        'APP_URL' => rtrim($siteUrl, '/'),
                        'APP_ENV' => 'production',
                        'APP_DEBUG' => 'false',
                        'APP_LOCALE' => $state['lang'] ?? 'en',
                        'APP_KEY' => '',
                        'DB_HOST' => $cfg['host'],
                        'DB_PORT' => $cfg['port'],
                        'DB_DATABASE' => $cfg['name'],
                        'DB_USERNAME' => $cfg['user'],
                        'DB_PASSWORD' => $cfg['pass'],
                    ]);

                    $kg = rj_artisan(['key:generate', '--force']);
                    $lockDir = dirname(RJ_LOCK);
                    if (!is_dir($lockDir)) @mkdir($lockDir, 0755, true);
                    file_put_contents(RJ_LOCK, json_encode(['installed_at' => date('c'), 'version' => '1.5.0', 'lang' => $state['lang'] ?? 'en'], JSON_PRETTY_PRINT));

                    header('Location: ' . rj_installer_url('step=finish'));
                    exit;
                } catch (Throwable $e) {
                    $err = 'Env write error: ' . $e->getMessage();
                }
            } else {
                rj_set_state($state);
                header('Location: ' . rj_installer_url('step=admin'));
                exit;
            }
        } else {
            $err = $t['err_db'] . ': ' . $dbTest['msg'];
        }
    }
}

$db = $state['db'] ?? [];
if ($submitted) {
    $db = [
        'host' => trim($_POST['db_host'] ?? '127.0.0.1'),
        'port' => (int) ($_POST['db_port'] ?? 3306),
        'name' => trim($_POST['db_name'] ?? ''),
        'user' => trim($_POST['db_user'] ?? ''),
        'pass' => (string) ($_POST['db_pass'] ?? ''),
    ];
} elseif (empty($db)) {
    $db = ['host' => '127.0.0.1', 'port' => '3306', 'name' => '', 'user' => '', 'pass' => ''];
}

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
$body .= '<form method="post">';
$body .= '<label>' . rj_esc($t['db_host']) . '</label><input name="db_host" dir="ltr" value="' . rj_esc($db['host']) . '" required>';
$body .= '<label>' . rj_esc($t['db_port']) . '</label><input name="db_port" type="number" dir="ltr" value="' . rj_esc((string) $db['port']) . '" required>';
$body .= '<label>' . rj_esc($t['db_name']) . '</label><input name="db_name" dir="ltr" value="' . rj_esc($db['name']) . '" required>';
$body .= '<label>' . rj_esc($t['db_user']) . '</label><input name="db_user" dir="ltr" value="' . rj_esc($db['user']) . '" required>';
$body .= '<label>' . rj_esc($t['db_pass']) . '</label><input name="db_pass" type="password" dir="ltr" value="">';
$body .= '<label>' . rj_esc($t['site_name']) . '</label><input name="site_name" value="' . rj_esc($state['site_name'] ?? 'RJ Nexus') . '" required>';
$body .= '<label>' . rj_esc($t['site_url']) . '</label><input name="site_url" type="url" dir="ltr" value="' . rj_esc($state['site_url'] ?? rj_http_host()) . '" required>';

$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=requirements') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '<button class="btn" type="submit" name="action" value="normal">' . rj_esc($t['db_test'] ?? 'Test & Continue') . '</button>';
$body .= '</div>';

$body .= '<div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #2d1754;">';
$body .= '<p style="font-size: 13px; color: #9ca3af; margin-bottom: 12px; text-align: center;">' . rj_esc($t['db_imported'] ?? 'Already imported the database?') . '</p>';
$body .= '<div style="display:flex; gap:12px; justify-content:center;">';
$body .= '<button class="btn ghost" type="submit" name="action" value="imported_next" style="font-size:13px; padding:8px 16px;">' . rj_esc($t['db_imported_next'] ?? 'Go to Admin Setup') . '</button>';
$body .= '<button class="btn ghost" type="submit" name="action" value="imported_finish" style="font-size:13px; padding:8px 16px;">' . rj_esc($t['db_imported_finish'] ?? 'Finish Installation') . '</button>';
$body .= '</div>';
$body .= '</div>';
$body .= '</form>';

rj_render('database', $body);
exit;
