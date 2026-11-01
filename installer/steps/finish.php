<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (!file_exists(RJ_LOCK)) {
    header('Location: ' . rj_installer_url('step=install'));
    exit;
}

if (isset($_POST['delete_installer'])) {
    $files = [
        RJ_ROOT . '/public/install.php',
        RJ_ROOT . '/installer/bootstrap.php',
        RJ_ROOT . '/installer/helpers.php',
    ];

    foreach (glob(RJ_ROOT . '/installer/lang/*.php') as $f) {
        $files[] = $f;
    }
    foreach (glob(RJ_ROOT . '/installer/steps/*.php') as $f) {
        $files[] = $f;
    }
    foreach (glob(RJ_ROOT . '/installer/steps/intro/*.php') as $f) {
        $files[] = $f;
    }

    foreach ($files as $f) {
        if (file_exists($f)) {
            @unlink($f);
        }
    }

    @rmdir(RJ_ROOT . '/installer/steps/intro');
    @rmdir(RJ_ROOT . '/installer/steps');
    @rmdir(RJ_ROOT . '/installer/lang');
    @rmdir(RJ_ROOT . '/installer');

    header('Location: /admin');
    exit;
}

$body = '<div class="alert alert-ok" style="text-align:center; padding:20px; margin-bottom:24px;">';
$body .= '<svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#a855f7; margin-bottom:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
$body .= '<h3 style="font-size:18px; font-weight:700; margin-bottom:8px; color:#fff;">' . rj_esc($t['ins_done']) . '</h3>';
$body .= '<p style="font-size:14px; color:#d8b4fe;">' . rj_esc($t['fin_sub']) . '</p>';
$body .= '</div>';

$body .= '<p style="color:#9ca3af;margin-top:16px;font-size:13px;text-align:center;">' . rj_esc($t['fin_security'] ?? 'For security reasons, please delete the installer files.') . '</p>';

$body .= '<div style="display:flex; flex-direction:column; gap:12px; margin-top:24px;">';
$body .= '<div style="display:flex; gap:12px;">';
$body .= '<a href="/admin" class="btn" style="flex:1;">' . rj_esc($t['fin_admin'] ?? 'Go to Admin Panel') . '</a>';
$body .= '<a href="/" class="btn ghost" style="flex:1;">' . rj_esc($t['fin_frontend'] ?? 'Go to Website') . '</a>';
$body .= '</div>';

$body .= '<form method="post" style="margin-top:12px;">';
$body .= '<button type="submit" name="delete_installer" class="btn ghost" style="width:100%; border-color:#ef4444; color:#ef4444;" onclick="return confirm(\'Are you sure? This will delete the installer files.\');">';
$body .= rj_esc($t['fin_delete_btn'] ?? 'Delete Installer Files');
$body .= '</button>';
$body .= '</form>';
$body .= '</div>';

rj_render('finish', $body);
exit;
