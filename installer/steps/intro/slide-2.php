<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <div style="width:80px; height:80px; background:linear-gradient(135deg,#7c3aed 0%,#ec4899 100%); border-radius:20px; display:flex; align-items:center; justify-content:center; margin-bottom:24px; box-shadow:0 10px 25px -5px rgba(168,85,247,0.4);">
        <svg width="40" height="40" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>

    <h2 style="font-size:28px; font-weight:800; color:#fff; margin-bottom:12px;">
        <?= rj_esc($t['intro_s2_title']) ?>
    </h2>

    <p style="font-size:15px; color:#9ca3af; line-height:1.6; max-width:400px; margin:0 auto;">
        <?= rj_esc($t['intro_s2_desc']) ?>
    </p>
</div>
