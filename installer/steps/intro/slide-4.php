<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div class="sl-wrap">
    <div class="sl-ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>

    <h2><?= rj_esc($t['intro_s4_title']) ?></h2>

    <p><?= rj_esc($t['intro_s4_desc']) ?></p>
</div>
