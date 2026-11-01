<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$body = '<p style="font-size:14px;color:#9ca3af;margin-bottom:8px">' . rj_esc($t['lang']) . '</p><form method="post" class="langs">';
foreach (rj_languages() as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $body .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn' . $active . '">' . rj_esc($label) . '</button>';
}
$body .= '</form>';
rj_render('language', $body);
exit;
