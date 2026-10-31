<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

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

$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=intro&slide=5') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';

if ($allOk) {
    $body .= '<a href="' . rj_installer_url('step=database') . '" class="btn">' . rj_esc($t['req_btn']) . '</a>';
} else {
    $body .= '<a href="' . rj_installer_url('step=requirements') . '" class="btn">' . rj_esc($t['retry'] ?? 'Retry') . '</a>';
}

$body .= '</div>';

rj_render('requirements', $body);
exit;
