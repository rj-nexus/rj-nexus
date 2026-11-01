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

    $sqlContent = null;
    if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['sql_file']['tmp_name'];
        $sqlContent = file_get_contents($tmpName);

        if (substr($sqlContent, 0, 2) === "\xFF\xFE") {
            $sqlContent = mb_convert_encoding($sqlContent, 'UTF-8', 'UTF-16LE');
        }
    }

    $result = rj_install_run($sqlContent);

    if (!empty($result['ok'])) {
        header('Location: ' . rj_installer_url('step=finish'));
        exit;
    }

    $err = $result['error'] ?? '';
}

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
$body .= '<form method="post" enctype="multipart/form-data">';
$body .= '<p style="color:#9ca3af;font-size:14px;margin-bottom:16px;">' . rj_esc($t['ins_sql_prompt'] ?? 'If you have an SQL dump (e.g., from RJ CMS), upload it here. Otherwise, the system will run standard migrations.') . '</p>';

$body .= '<label>' . rj_esc($t['ins_sql_file'] ?? 'SQL File (Optional)') . '</label>';
$body .= '<input type="file" name="sql_file" accept=".sql" style="background:#1a1030;border:1px solid #2d1754;color:#e5e7eb;border-radius:8px;padding:10px 12px;width:100%;">';

$body .= '<div class="row" style="margin-top:24px;">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '<button class="btn" type="submit">' . rj_esc($t['install']) . '</button>';
$body .= '</div>';
$body .= '</form>';

rj_render('install', $body);
exit;
