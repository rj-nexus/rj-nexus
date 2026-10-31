<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (session_status() === PHP_SESSION_NONE) session_start();
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

if (!defined('RJ_ROOT')) define('RJ_ROOT', dirname(__DIR__));
if (!defined('RJ_ENV')) define('RJ_ENV', RJ_ROOT . '/.env');
if (!defined('RJ_ENV_EXAMPLE')) define('RJ_ENV_EXAMPLE', RJ_ROOT . '/.env.example');
if (!defined('RJ_LOCK')) define('RJ_LOCK', RJ_ROOT . '/storage/installed.lock');
if (!defined('RJ_LOG')) define('RJ_LOG', RJ_ROOT . '/storage/logs/install.log');

require_once __DIR__ . '/helpers.php';

function rj_html_standalone(string $title, string $body): void
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><title>' . rj_esc($title) . '</title><style>'
        . 'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",system-ui,sans-serif;background:#0a0a0b;color:#e5e7eb;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:24px;text-align:center;line-height:1.5}'
        . '.card{max-width:480px;background:#131315;border:1px solid #26262a;border-radius:16px;padding:40px}'
        . 'h1{font-size:22px;margin-bottom:12px}p{color:#8a8a92;margin-bottom:12px;line-height:1.5}'
        . 'code{background:#1f1f23;padding:2px 8px;border-radius:4px;font-size:.9em}'
        . 'a.btn,.btn{display:inline-block;background:#d4af37;color:#0a0a0b;padding:10px 22px;border-radius:8px;font-weight:600;text-decoration:none;margin-top:16px;border:none;cursor:pointer;font-family:inherit;font-size:14px}'
        . '</style></head><body><div class="card">' . $body . '</div></body></html>';
}

function rj_render(string $step, string $body, string $extra = ''): void
{
    $t = rj_t_current();
    $lang = $_SESSION['rj_install']['lang'] ?? 'en';
    $dir = rj_is_rtl($lang) ? 'rtl' : 'ltr';
    $stepIdx = ['language' => 1, 'requirements' => 2, 'database' => 3, 'admin' => 4, 'install' => 5, 'finish' => 6][$step] ?? 1;
    $nav = '';
    for ($n = 1; $n <= 5; $n++) {
        $cls = $n === $stepIdx ? 'active' : ($n < $stepIdx ? 'done' : '');
        $nav .= '<span class="dot ' . $cls . '">' . $n . '</span>';
        if ($n < 5) {
            $nav .= '<span class="line ' . ($n < $stepIdx ? 'done' : '') . '"></span>';
        }
    }
    $css = '*{box-sizing:border-box;margin:0;padding:0}'
        . 'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",system-ui,sans-serif;background:#0a0a0b;color:#e5e7eb;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;line-height:1.5}'
        . '.card{width:100%;max-width:560px;background:#131315;border:1px solid #26262a;border-radius:16px;padding:32px}'
        . '.brand{font-size:13px;letter-spacing:.3em;text-transform:uppercase;color:#d4af37;font-weight:700;margin-bottom:6px}'
        . 'h1{font-size:24px;font-weight:700;margin-bottom:4px}'
        . 'p.sub{color:#8a8a92;font-size:14px;margin-bottom:24px}'
        . '.steps{display:flex;align-items:center;margin:20px 0 28px}'
        . '.dot{width:28px;height:28px;border-radius:50%;border:1px solid #2c2c31;color:#555;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0}'
        . '.dot.active{border-color:#d4af37;color:#d4af37;background:rgba(212,175,55,.08)}'
        . '.dot.done{border-color:#2e7d32;color:#2e7d32;background:rgba(46,125,50,.1)}'
        . '.line{flex:1;height:1px;background:#2c2c31;margin:0 8px}'
        . '.line.done{background:#2e7d32}'
        . 'label{display:block;font-size:12px;color:#8a8a92;margin:12px 0 6px;letter-spacing:.02em}'
        . 'input,select{width:100%;background:#0a0a0b;border:1px solid #26262a;color:#e5e7eb;border-radius:8px;padding:10px 12px;font-size:14px;font-family:inherit}'
        . 'input:focus,select:focus{outline:none;border-color:#d4af37}'
        . 'input[dir="ltr"]{text-align:left}'
        . '.btn{display:inline-block;background:#d4af37;color:#0a0a0b;border:none;padding:11px 22px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:opacity .15s;font-family:inherit}'
        . '.btn:hover{opacity:.9}'
        . '.btn.ghost{background:transparent;color:#d4af37;border:1px solid #d4af37}'
        . '.row{display:flex;gap:12px;margin-top:24px;justify-content:space-between;align-items:center;flex-wrap:wrap}'
        . '.req{list-style:none;margin-top:8px}'
        . '.req li{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #1e1e22;font-size:13px;gap:8px}'
        . '.req li:last-child{border-bottom:none}'
        . '.ok{color:#2e7d32;font-weight:600}'
        . '.fail{color:#dc2626;font-weight:600}'
        . '.langs{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:16px}'
        . '.lang-btn{background:#0a0a0b;border:1px solid #26262a;color:#e5e7eb;padding:12px;border-radius:8px;cursor:pointer;font-size:14px;transition:.15s;text-align:start;font-family:inherit}'
        . '.lang-btn:hover{border-color:#d4af37}'
        . '.lang-btn.active{border-color:#d4af37;background:rgba(212,175,55,.08)}'
        . '.alert{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.4);color:#fca5a5;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;word-break:break-word}'
        . '.alert-ok{background:rgba(46,125,50,.1);border:1px solid rgba(46,125,50,.4);color:#86efac}'
        . '.log{background:#0a0a0b;border:1px solid #1e1e22;border-radius:8px;padding:14px;font-family:ui-monospace,monospace;font-size:12px;color:#a1a1aa;max-height:200px;overflow:auto;margin-top:12px;white-space:pre-wrap;word-break:break-all}'
        . 'code{background:#1f1f23;padding:2px 6px;border-radius:4px;font-size:.9em}'
        . '@media (max-width:520px){.langs{grid-template-columns:1fr}.card{padding:24px}.row{flex-direction:column-reverse}.row .btn{width:100%;text-align:center}}';
    echo '<!DOCTYPE html><html lang="' . rj_esc($lang) . '" dir="' . $dir . '"><head>'
        . '<meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width,initial-scale=1">'
        . '<meta name="robots" content="noindex,nofollow">'
        . '<title>' . rj_esc($t['title']) . '</title>'
        . '<style>' . $css . '</style>' . $extra . '</head><body>'
        . '<div class="card"><div class="brand">RJ NEXUS</div>'
        . '<h1>' . rj_esc($t['title']) . '</h1>'
        . '<p class="sub">' . rj_esc($t['sub']) . '</p>'
        . '<div class="steps">' . $nav . '</div>'
        . $body
        . '</div></body></html>';
}

if (isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=requirements'));
    exit;
}

$step = $_GET['step'] ?? 'language';
$state = rj_state();
$t = rj_t_current();

if (file_exists(RJ_LOCK) && $step !== 'finish') {
    http_response_code(403);
    rj_html_standalone('RJ Nexus', '<h1>Already Installed</h1><p>RJ Nexus is already installed on this server.</p><p>To reinstall, delete <code>storage/installed.lock</code> and try again.</p><a href="/admin" class="btn">Open Admin</a>');
    exit;
}

if ($step === 'requirements') {
    if (empty($state['lang'])) {
        header('Location: ' . rj_installer_url('step=language'));
        exit;
    }
    $reqs = rj_requirements();
    $allOk = rj_requirements_ok();
    $body = '<ul class="req">';
    foreach ($reqs as $k => $r) {
        $label = $t['req_' . $k] ?? $k;
        $body .= '<li><span>' . rj_esc($label) . '</span><span class="' . ($r['ok'] ? 'ok' : 'fail') . '">' . ($r['ok'] ? rj_esc($t['ok']) : rj_esc($t['fail'])) . '</span></li>';
    }
    $body .= '</ul>';
    if (!$allOk) {
        $body .= '<div class="alert" style="margin-top:16px">' . rj_esc($t['err_req']) . '</div>';
    }
    $body .= '<div class="row">'
        . '<a href="' . rj_installer_url('step=language') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
    if ($allOk) {
        $body .= '<a href="' . rj_installer_url('step=database') . '" class="btn">' . rj_esc($t['req_btn']) . '</a>';
    }
    $body .= '</div>';
    rj_render('requirements', $body);
    exit;
}

if ($step === 'database') {
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
    $body .= '<div class="row">'
        . '<a href="' . rj_installer_url('step=requirements') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>'
        . '<button class="btn" type="submit">' . rj_esc($t['db_test']) . '</button>'
        . '</div></form>';
    rj_render('database', $body);
    exit;
}

if ($step === 'admin') {
    if (empty($state['db'])) {
        header('Location: ' . rj_installer_url('step=database'));
        exit;
    }
    $err = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adm_email'])) {
        $name = trim($_POST['adm_name'] ?? '');
        $email = trim($_POST['adm_email'] ?? '');
        $pass = (string) ($_POST['adm_pass'] ?? '');
        $pass2 = (string) ($_POST['adm_pass2'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
            $err = $t['err_admin'];
        } elseif ($pass !== $pass2) {
            $err = $t['adm_mismatch'];
        } else {
            $state['admin'] = ['name' => $name, 'email' => $email, 'pass' => $pass];
            rj_set_state($state);
            header('Location: ' . rj_installer_url('step=install'));
            exit;
        }
    }
    $body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
    $body .= '<form method="post">';
    $body .= '<label>' . rj_esc($t['adm_name']) . '</label><input name="adm_name" value="' . rj_esc($_POST['adm_name'] ?? '') . '" required>';
    $body .= '<label>' . rj_esc($t['adm_email']) . '</label><input name="adm_email" type="email" dir="ltr" value="' . rj_esc($_POST['adm_email'] ?? '') . '" required>';
    $body .= '<label>' . rj_esc($t['adm_pass']) . '</label><input name="adm_pass" type="password" dir="ltr" minlength="8" required>';
    $body .= '<label>' . rj_esc($t['adm_pass2']) . '</label><input name="adm_pass2" type="password" dir="ltr" minlength="8" required>';
    $body .= '<div class="row">'
        . '<a href="' . rj_installer_url('step=database') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>'
        . '<button class="btn" type="submit">' . rj_esc($t['adm_continue']) . '</button>'
        . '</div></form>';
    rj_render('admin', $body);
    exit;
}

if ($step === 'install') {
    if (empty($state['admin'])) {
        header('Location: ' . rj_installer_url('step=admin'));
        exit;
    }
    @set_time_limit(300);
    @ini_set('memory_limit', '256M');
    $result = rj_install_run();
    if (!empty($result['ok'])) {
        header('Location: ' . rj_installer_url('step=finish'));
        exit;
    }
    $body = '<div class="alert">' . rj_esc($t['err_inst']) . '</div>';
    $body .= '<div class="log">' . rj_esc($result['error'] ?? '') . '</div>';
    $body .= '<div class="row">'
        . '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>'
        . '<a href="' . rj_installer_url('step=install') . '" class="btn">' . rj_esc($t['retry']) . '</a>'
        . '</div>';
    rj_render('install', $body);
    exit;
}

if ($step === 'finish') {
    if (!file_exists(RJ_LOCK)) {
        header('Location: ' . rj_installer_url('step=install'));
        exit;
    }
    if (isset($_POST['delete_installer'])) {
        $files = [
            __DIR__ . '/../public/install.php',
            __FILE__,
            __DIR__ . '/helpers.php',
        ];
        foreach (glob(__DIR__ . '/lang/*.php') as $f) {
            $files[] = $f;
        }
        foreach ($files as $f) {
            @unlink($f);
        }
        @rmdir(__DIR__ . '/lang');
        @rmdir(__DIR__);
        header('Location: /admin');
        exit;
    }
    $body = '<div class="alert alert-ok">' . rj_esc($t['ins_done']) . '</div>';
    $body .= '<p style="color:#8a8a92;margin-top:16px;font-size:14px;line-height:1.6">' . rj_esc($t['fin_sub']) . '</p>';
    $body .= '<p style="color:#8a8a92;margin-top:12px;font-size:13px">For your security, delete <code>public/install.php</code> and the <code>installer/</code> folder after setup.</p>';
    $body .= '<form method="post" style="margin-top:24px"><button type="submit" name="delete_installer" class="btn">' . rj_esc($t['delete_installer']) . '</button></form>';
    rj_render('finish', $body);
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$body = '<p style="font-size:14px;color:#8a8a92;margin-bottom:8px">' . rj_esc($t['lang']) . '</p><form method="post" class="langs">';
foreach (rj_languages() as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $body .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn' . $active . '">' . rj_esc($label) . '</button>';
}
$body .= '</form>';
rj_render('language', $body);
exit;
