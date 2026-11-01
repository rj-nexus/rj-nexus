<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }
?>

<div class="sl-wrap">
    <div class="sl-ic">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
        </svg>
    </div>

    <h2><?= rj_esc($t['intro_s5_title']) ?></h2>

    <p><?= rj_esc($t['intro_s5_desc']) ?></p>
</div>
