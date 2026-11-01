<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

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
$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=database') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '<button class="btn" type="submit">' . rj_esc($t['adm_continue']) . '</button>';
$body .= '</div></form>';

rj_render('admin', $body);
exit;
