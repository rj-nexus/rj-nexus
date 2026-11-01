<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['admin'])) {
    header('Location: ' . rj_installer_url('step=admin'));
    exit;
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    @set_time_limit(300);
    @ini_set('memory_limit', '256M');

    $action = $_POST['action'] ?? 'normal';
    $sqlContent = null;

    if ($action === 'import') {
        $state['db_imported'] = true;
        rj_set_state($state);

        if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['sql_file']['tmp_name'];
            $sqlContent = file_get_contents($tmpName);

            if (substr($sqlContent, 0, 2) === "\xFF\xFE") {
                $sqlContent = mb_convert_encoding($sqlContent, 'UTF-8', 'UTF-16LE');
            }
        }
    } else {
        $state['db_imported'] = false;
        rj_set_state($state);
    }

    $result = rj_install_run($sqlContent);

    if (!empty($result['ok'])) {
        header('Location: ' . rj_installer_url('step=finish'));
        exit;
    }

    $err = $result['error'] ?? '';
}

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
$body .= '<p style="color:#9ca3af;font-size:14px;margin-bottom:20px;text-align:center;">' . rj_esc($t['ins_choice'] ?? 'Choose your installation type below.') . '</p>';

$body .= '<div style="display:flex; gap:16px; flex-wrap:wrap;">';

$body .= '<form method="post" style="flex:1; min-width:240px; background:#1a1030; padding:24px; border-radius:12px; border:1px solid #2d1754; text-align:center; display:flex; flex-direction:column; justify-content:space-between;">';
$body .= '<div>';
$body .= '<div style="width:48px; height:48px; background:rgba(168,85,247,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px auto;">';
$body .= '<svg width="24" height="24" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>';
$body .= '</div>';
$body .= '<h3 style="color:#fff; margin-bottom:8px; font-size:16px;">' . rj_esc($t['ins_normal_title'] ?? 'Standard Installation') . '</h3>';
$body .= '<p style="color:#9ca3af; font-size:13px; margin-bottom:24px; line-height:1.5;">' . rj_esc($t['ins_normal_desc'] ?? 'Runs all migrations and seeds to create a fresh, fully working site.') . '</p>';
$body .= '</div>';
$body .= '<button class="btn" type="submit" name="action" value="normal" style="width:100%;">' . rj_esc($t['install'] ?? 'Install') . '</button>';
$body .= '</form>';

$body .= '<form method="post" enctype="multipart/form-data" style="flex:1; min-width:240px; background:#1a1030; padding:24px; border-radius:12px; border:1px solid #2d1754; text-align:center; display:flex; flex-direction:column; justify-content:space-between;">';
$body .= '<div>';
$body .= '<div style="width:48px; height:48px; background:rgba(236,72,153,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px auto;">';
$body .= '<svg width="24" height="24" fill="none" stroke="#ec4899" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>';
$body .= '</div>';
$body .= '<h3 style="color:#fff; margin-bottom:8px; font-size:16px;">' . rj_esc($t['ins_migrate_title'] ?? 'Migrate from RJ CMS') . '</h3>';
$body .= '<p style="color:#9ca3af; font-size:13px; margin-bottom:12px; line-height:1.5;">' . rj_esc($t['ins_migrate_desc'] ?? 'Upload your existing RJ CMS database (.sql) to preserve your content. Migrations and seeds will be skipped.') . '</p>';
$body .= '<input type="file" name="sql_file" accept=".sql" style="background:#0a0a0b; border:1px solid #26262a; color:#e5e7eb; border-radius:8px; padding:8px; width:100%; margin-bottom:16px; font-size:12px; cursor:pointer;">';
$body .= '</div>';
$body .= '<button class="btn" type="submit" name="action" value="import" style="width:100%; background:linear-gradient(135deg, #ec4899 0%, #7c3aed 100%);">' . rj_esc($t['ins_migrate_btn'] ?? 'Import & Install') . '</button>';
$body .= '</form>';

$body .= '</div>';

$body .= '<div class="row" style="justify-content:center; margin-top:24px;">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '</div>';

rj_render('install', $body);
exit;
