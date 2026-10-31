<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

$currentSlide = isset($_GET['slide']) ? (int)$_GET['slide'] : 1;
if ($currentSlide < 1) $currentSlide = 1;
if ($currentSlide > 5) $currentSlide = 5;

$slideFile = __DIR__ . '/intro/slide-' . $currentSlide . '.php';
if (!file_exists($slideFile)) {
    $slideFile = __DIR__ . '/intro/slide-1.php';
}

ob_start();
require $slideFile;
$slideContent = ob_get_clean();

$nextUrl = $currentSlide < 5 ? rj_installer_url('step=intro&slide=' . ($currentSlide + 1)) : rj_installer_url('step=requirements');
$prevUrl = $currentSlide > 1 ? rj_installer_url('step=intro&slide=' . ($currentSlide - 1)) : null;
$skipUrl = rj_installer_url('step=requirements');

$body = '<div class="intro-container" style="text-align:center;">';
$body .= '<a href="' . $skipUrl . '" class="skip-link">' . rj_esc($t['skip'] ?? 'Skip') . ' <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;margin-left:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7m0 0l-7 7m7-7H3"/></svg></a>';

$body .= '<div class="slide-content" style="min-height: 220px; display:flex; flex-direction:column; justify-content:center; margin-bottom: 24px;">';
$body .= $slideContent;
$body .= '</div>';

$body .= '<div class="slide-dots" style="display:flex; justify-content:center; gap:8px; margin-bottom:32px;">';
for ($i = 1; $i <= 5; $i++) {
    $active = $i === $currentSlide ? 'background:#a855f7;width:24px;border-radius:4px;' : 'background:#2d1754;width:8px;border-radius:50%;';
    $body .= '<a href="' . rj_installer_url('step=intro&slide=' . $i) . '" style="height:8px;' . $active . 'transition:all .3s;display:inline-block;"></a>';
}
$body .= '</div>';

$body .= '<div class="row" style="justify-content:center; gap:16px;">';
if ($prevUrl) {
    $body .= '<a href="' . $prevUrl . '" class="btn ghost">' . rj_esc($t['back'] ?? 'Back') . '</a>';
}
$body .= '<a href="' . $nextUrl . '" class="btn">' . rj_esc($currentSlide === 5 ? ($t['req_btn'] ?? 'Continue') : ($t['next'] ?? 'Next')) . '</a>';
$body .= '</div>';
$body .= '</div>';

rj_render('intro', $body);
exit;
