<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <div style="width:80px; height:80px; background:linear-gradient(135deg,#7c3aed 0%,#ec4899 100%); border-radius:20px; display:flex; align-items:center; justify-content:center; margin-bottom:24px; box-shadow:0 10px 25px -5px rgba(168,85,247,0.4);">
        <svg width="40" height="40" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>

    <h2 style="font-size:28px; font-weight:800; color:#fff; margin-bottom:12px;">
        <?= rj_esc($t['intro_s5_title']) ?>
    </h2>

    <p style="font-size:15px; color:#9ca3af; line-height:1.6; max-width:400px; margin:0 auto;">
        <?= rj_esc($t['intro_s5_desc']) ?>
    </p>
</div>
