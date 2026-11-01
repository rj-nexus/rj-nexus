<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div class="sl-wrap">
    <div class="sl-ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <h2><?= rj_esc($t['intro_s1_title']) ?></h2>

    <p><?= rj_esc($t['intro_s1_desc']) ?></p>
</div>
