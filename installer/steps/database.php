<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang']) || !rj_requirements_ok()) {
    header('Location: ' . rj_installer_url('step=requirements'));
    exit;
}

$err = '';
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host']);

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
            rj_set_state($state);
            header('Location: ' . rj_installer_url('step=admin'));
            exit;
        }
        $err = $t['err_db'] . ': ' . $dbTest['msg'];
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
$body .= '<button class="btn" type="submit">' . rj_esc($t['db_test']) . '</button>';
$body .= '</div></form>';

rj_render('database', $body);
exit;
