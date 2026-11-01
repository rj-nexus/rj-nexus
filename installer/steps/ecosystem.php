<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang'])) {
    header('Location: ' . rj_installer_url('step=language'));
    exit;
}

$logoRjCms = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-cms/rj%20cms%20transparent.png';
$logoRjAi = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-cms/rj%20cms%20ai%20transparent.png';
$logoRjShop = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-shop/rj%20shop%20transparent.png';
$logoRjCloud = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/web_panels/rj_cloud/rj%20cloud_transparent.png';

$body = '<div style="text-align:center; margin-bottom: 24px;">';
$body .= '<p style="font-size:14px; color:#9ca3af; line-height:1.6;">' . rj_esc($t['eco_desc'] ?? 'Welcome to the new era of RJ CMS. Whether you are migrating from a legacy version or starting fresh, RJ Nexus is your new open-source home. When your business grows, seamlessly scale to our premium ecosystems.') . '</p>';
$body .= '</div>';

$body .= '<div style="background:#1a1030; border:1px solid #2d1754; border-radius:12px; padding:24px 16px; display:flex; flex-direction:column; gap:16px; align-items:center; justify-content:center; width:100%;">';

$body .= '<div style="display:flex; align-items:center; justify-content:center; width:100%; gap:12px;">';
$body .= '<div style="flex:1; text-align:center;">';
$body .= '<img src="' . $logoRjCms . '" alt="RJ CMS 5.1" style="height:32px; margin:0 auto 8px auto; display:block; opacity:0.7; filter:grayscale(100%);">';
$body .= '<div style="font-size:11px; font-weight:700; color:#9ca3af;">RJ CMS 5.1</div>';
$body .= '<div style="font-size:10px; color:#6b7280;">Legacy</div>';
$body .= '</div>';

$body .= '<div style="color:#a855f7; font-weight:bold; font-size:18px;">&rarr;</div>';

$body .= '<div style="flex:1; text-align:center; background:rgba(168,85,247,0.1); padding:12px 8px; border-radius:8px; border:1px solid #a855f7;">';
$body .= '<img src="https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-nexus/logo_header.png" alt="RJ Nexus" style="height:32px; margin:0 auto 8px auto; display:block;">';
$body .= '<div style="font-size:12px; font-weight:800; color:#a855f7;">RJ NEXUS</div>';
$body .= '<div style="font-size:10px; color:#d8b4fe;">Open Source</div>';
$body .= '</div>';

$body .= '<div style="color:#ec4899; font-weight:bold; font-size:18px;">&rarr;</div>';

$body .= '<div style="flex:1; display:flex; flex-direction:column; gap:8px;">';
$body .= '<div style="background:#231243; border:1px solid #2d1754; padding:8px; border-radius:6px; text-align:center;">';
$body .= '<img src="' . $logoRjAi . '" alt="RJ CMS AI" style="height:16px; margin:0 auto; display:block; opacity:0.8;">';
$body .= '</div>';
$body .= '<div style="background:#231243; border:1px solid #2d1754; padding:8px; border-radius:6px; text-align:center;">';
$body .= '<img src="' . $logoRjShop . '" alt="RJ Shop" style="height:16px; margin:0 auto; display:block; opacity:0.8;">';
$body .= '</div>';
$body .= '<div style="background:#231243; border:1px solid #2d1754; padding:8px; border-radius:6px; text-align:center;">';
$body .= '<img src="' . $logoRjCloud . '" alt="RJ Cloud" style="height:16px; margin:0 auto; display:block; opacity:0.8;">';
$body .= '</div>';
$body .= '</div>';
$body .= '</div>';

$body .= '<div style="width:100%; display:flex; justify-content:space-between; font-size:10px; color:#9ca3af; margin-top:8px; padding:0 8px;">';
$body .= '<div style="text-align:left; flex:1;">' . rj_esc($t['eco_migrate'] ?? 'Free Migration') . '</div>';
$body .= '<div style="text-align:right; flex:1;">' . rj_esc($t['eco_upgrade'] ?? 'Premium Upgrade') . '</div>';
$body .= '</div>';

$body .= '</div>';

$body .= '<div class="row" style="justify-content:center; margin-top:24px;">';
$body .= '<a href="' . rj_installer_url('step=intro&slide=1') . '" class="btn">' . rj_esc($t['next'] ?? 'Continue') . '</a>';
$body .= '</div>';

rj_render('ecosystem', $body);
exit;
