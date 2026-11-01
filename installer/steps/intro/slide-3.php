<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div class="sl-wrap">
    <div class="sl-ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>

    <h2><?= rj_esc($t['intro_s3_title']) ?></h2>

    <p><?= rj_esc($t['intro_s3_desc']) ?></p>
</div>
