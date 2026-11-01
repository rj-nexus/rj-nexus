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
        . 'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",system-ui,sans-serif;background:#1a1030;color:#e5e7eb;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:24px;text-align:center;line-height:1.5}'
        . '.card{max-width:480px;background:#231243;border:1px solid #2d1754;border-radius:16px;padding:40px}'
        . 'h1{font-size:22px;margin-bottom:12px;color:#fff}p{color:#9ca3af;margin-bottom:12px;line-height:1.5}'
        . 'code{background:#2d1754;padding:2px 8px;border-radius:4px;font-size:.9em;color:#e5e7eb}'
        . 'a.btn,.btn{display:inline-block;background:linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);color:#fff;padding:10px 22px;border-radius:8px;font-weight:600;text-decoration:none;margin-top:16px;border:none;cursor:pointer;font-family:inherit;font-size:14px}'
        . '</style></head><body><div class="card">' . $body . '</div></body></html>';
}

function rj_render(string $step, string $body, string $extra = ''): void
{
    $t = rj_t_current();
    $lang = $_SESSION['rj_install']['lang'] ?? 'en';
    $dir = rj_is_rtl($lang) ? 'rtl' : 'ltr';

    $stepsMap = ['language' => 1, 'ecosystem' => 2, 'intro' => 3, 'requirements' => 4, 'database' => 5, 'admin' => 6, 'install' => 7];
    $stepIdx = $stepsMap[$step] ?? 0;
    $totalSteps = 7;

    $nav = '';
    if ($stepIdx > 0) {
        for ($n = 1; $n <= $totalSteps; $n++) {
            $cls = $n === $stepIdx ? 'active' : ($n < $stepIdx ? 'done' : '');
            $nav .= '<span class="dot ' . $cls . '">' . $n . '</span>';
            if ($n < $totalSteps) {
                $nav .= '<span class="line ' . ($n < $stepIdx ? 'done' : '') . '"></span>';
            }
        }
    }

    $logoUrl = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-nexus/logo_header.png';

    $css = '*{box-sizing:border-box;margin:0;padding:0}'
        . 'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",system-ui,sans-serif;background:#1a1030;color:#e5e7eb;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;line-height:1.5}'
        . '.card{width:100%;max-width:560px;background:#231243;border:1px solid #2d1754;border-radius:16px;padding:32px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.5);position:relative}'
        . '.brand-logo{height:32px;margin-bottom:12px;display:block}'
        . 'h1{font-size:24px;font-weight:700;margin-bottom:4px;color:#fff}'
        . 'p.sub{color:#9ca3af;font-size:14px;margin-bottom:24px}'
        . '.steps{display:flex;align-items:center;margin:20px 0 28px}'
        . '.dot{width:28px;height:28px;border-radius:50%;border:1px solid #2d1754;color:#6b7280;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;transition:all .2s}'
        . '.dot.active{border-color:#a855f7;color:#a855f7;background:rgba(168,85,247,.15)}'
        . '.dot.done{border-color:#a855f7;color:#a855f7;background:rgba(168,85,247,.1)}'
        . '.line{flex:1;height:1px;background:#2d1754;margin:0 8px;transition:all .2s}'
        . '.line.done{background:#a855f7}'
        . 'label{display:block;font-size:12px;color:#9ca3af;margin:12px 0 6px;letter-spacing:.02em}'
        . 'input,select{width:100%;background:#1a1030;border:1px solid #2d1754;color:#e5e7eb;border-radius:8px;padding:10px 12px;font-size:14px;font-family:inherit;transition:border-color .15s}'
        . 'input:focus,select:focus{outline:none;border-color:#a855f7}'
        . 'input[dir="ltr"]{text-align:left}'
        . '.btn{display:inline-block;background:linear-gradient(135deg,#7c3aed 0%,#ec4899 100%);color:#fff;border:none;padding:11px 22px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:opacity .15s;font-family:inherit;text-align:center}'
        . '.btn:hover{opacity:.9}'
        . '.btn.ghost{background:transparent;color:#a855f7;border:1px solid #a855f7}'
        . '.btn.ghost:hover{background:rgba(168,85,247,.1)}'
        . '.row{display:flex;gap:12px;margin-top:24px;justify-content:space-between;align-items:center;flex-wrap:wrap}'
        . '.req{list-style:none;margin-top:8px}'
        . '.req li{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #2d1754;font-size:13px;gap:8px;color:#d1d5db}'
        . '.req li:last-child{border-bottom:none}'
        . '.ok{color:#a855f7;font-weight:600}'
        . '.fail{color:#ef4444;font-weight:600}'
        . '.langs{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:16px}'
        . '.lang-btn{background:#1a1030;border:1px solid #2d1754;color:#e5e7eb;padding:12px;border-radius:8px;cursor:pointer;font-size:14px;transition:.15s;text-align:start;font-family:inherit}'
        . '.lang-btn:hover{border-color:#a855f7}'
        . '.lang-btn.active{border-color:#a855f7;background:rgba(168,85,247,.15);color:#fff}'
        . '.alert{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.4);color:#fca5a5;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;word-break:break-word}'
        . '.alert-ok{background:rgba(168,85,247,.1);border:1px solid rgba(168,85,247,.4);color:#d8b4fe}'
        . '.log{background:#1a1030;border:1px solid #2d1754;border-radius:8px;padding:14px;font-family:ui-monospace,monospace;font-size:12px;color:#9ca3af;max-height:200px;overflow:auto;margin-top:12px;white-space:pre-wrap;word-break:break-all}'
        . 'code{background:#2d1754;padding:2px 6px;border-radius:4px;font-size:.9em;color:#e5e7eb}'
        . '.skip-link{position:absolute;top:24px;right:24px;font-size:13px;color:#9ca3af;text-decoration:none;transition:color .15s}'
        . '.skip-link:hover{color:#a855f7}'
        . '@media (max-width:520px){.langs{grid-template-columns:1fr}.card{padding:24px}.row{flex-direction:column-reverse}.row .btn{width:100%;text-align:center}}';

    echo '<!DOCTYPE html><html lang="' . rj_esc($lang) . '" dir="' . $dir . '"><head>'
        . '<meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width,initial-scale=1">'
        . '<meta name="robots" content="noindex,nofollow">'
        . '<title>' . rj_esc($t['title']) . '</title>'
        . '<style>' . $css . '</style>' . $extra . '</head><body>'
        . '<div class="card"><img src="' . $logoUrl . '" alt="RJ Nexus" class="brand-logo">'
        . '<h1>' . rj_esc($t['title']) . '</h1>'
        . '<p class="sub">' . rj_esc($t['sub']) . '</p>';

    if (!in_array($step, ['finish', 'intro'], true)) {
        echo '<div class="steps">' . $nav . '</div>';
    }

    echo $body . '</div></body></html>';
}

$step = $_GET['step'] ?? 'language';
$state = rj_state();
$t = rj_t_current();

if (file_exists(RJ_LOCK) && $step !== 'finish') {
    http_response_code(403);
    rj_html_standalone('RJ Nexus', '<h1>Already Installed</h1><p>RJ Nexus is already installed on this server.</p><p>To reinstall, delete <code>storage/installed.lock</code> and try again.</p><a href="/admin" class="btn">Open Admin</a>');
    exit;
}

$validSteps = ['language', 'ecosystem', 'intro', 'requirements', 'database', 'admin', 'install', 'finish'];
if (!in_array($step, $validSteps, true)) {
    $step = 'language';
}

require __DIR__ . '/steps/' . $step . '.php';
