<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

$isAz = ($state['lang'] ?? 'en') === 'az';
?>

<div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
    <div style="width:80px; height:80px; background:linear-gradient(135deg,#7c3aed 0%,#ec4899 100%); border-radius:20px; display:flex; align-items:center; justify-content:center; margin-bottom:24px; box-shadow:0 10px 25px -5px rgba(168,85,247,0.4);">
        <svg width="40" height="40" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <h2 style="font-size:28px; font-weight:800; color:#fff; margin-bottom:12px;">
        <?= $isAz ? 'Xoş Gəlmisiniz!' : 'Welcome to RJ Nexus!' ?>
    </h2>

    <p style="font-size:15px; color:#9ca3af; line-height:1.6; max-width:400px; margin:0 auto;">
        <?= $isAz
            ? 'Müasir, sürətli və tam nəzarət imkanı verən self-hosted CMS sisteminə xoş gəlmisiniz. Gəlin saytınızı birlikdə quraq.'
            : 'Welcome to the modern, fast, and fully self-hosted CMS that gives you complete control. Let\'s set up your site together.' ?>
    </p>
</div>
