<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <div style="width:80px; height:80px; background:linear-gradient(135deg,#7c3aed 0%,#ec4899 100%); border-radius:20px; display:flex; align-items:center; justify-content:center; margin-bottom:24px; box-shadow:0 10px 25px -5px rgba(168,85,247,0.4);">
        <svg width="40" height="40" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>

    <h2 style="font-size:28px; font-weight:800; color:#fff; margin-bottom:12px;">
        <?= rj_esc($t['intro_s4_title']) ?>
    </h2>

    <p style="font-size:15px; color:#9ca3af; line-height:1.6; max-width:400px; margin:0 auto;">
        <?= rj_esc($t['intro_s4_desc']) ?>
    </p>
</div>
