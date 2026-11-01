<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['admin'])) {
    header('Location: ' . rj_installer_url('step=admin'));
    exit;
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // MÜVƏQQƏTİ BYPASS: Real quraşdırma yerinə sadəcə lock faylı yaradıb finish-ə keçirik
    $lockDir = dirname(RJ_LOCK);
    if (!is_dir($lockDir)) @mkdir($lockDir, 0755, true);
    file_put_contents(RJ_LOCK, json_encode(['installed_at' => date('c'), 'test_mode' => true]));

    header('Location: ' . rj_installer_url('step=finish'));
    exit;
}

$activeTab = (isset($_GET['tab']) && $_GET['tab'] === 'import') ? 'import' : 'normal';

$extra = <<<'HTML'
<style>
.tabs{display:flex; background:#1a1030; border-radius:10px; padding:4px; margin-bottom:24px; border:1px solid #2d1754;}
.tab-btn{flex:1; padding:10px; text-align:center; font-size:13px; font-weight:600; color:#9ca3af; border-radius:8px; cursor:pointer; transition:.2s; border:none; background:none; font-family:inherit;}
.tab-btn:hover{color:#fff;}
.tab-btn.active{background:#2d1754; color:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.2);}
.tab-content{display:none;}
.tab-content.active{display:block; animation:rj-fade-in .3s ease-out;}
@keyframes rj-fade-in{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}

.drop-zone{position:relative; border:2px dashed #2d1754; border-radius:12px; padding:32px 20px; text-align:center; transition:.2s; cursor:pointer; background:#1a1030;}
.drop-zone:hover{border-color:#a855f7; background:rgba(168,85,247,.05);}
.drop-zone.has-file{border-color:#ec4899; background:rgba(236,72,153,.05); border-style:solid;}
.drop-zone input[type="file"]{position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:10;}
.dz-icon{width:48px; height:48px; margin:0 auto 12px auto; display:flex; align-items:center; justify-content:center; border-radius:50%; background:#231243; color:#a855f7; transition:.3s;}
.drop-zone:hover .dz-icon{transform:translateY(-4px); box-shadow:0 4px 12px rgba(168,85,247,.3);}
.drop-zone.has-file .dz-icon{background:rgba(236,72,153,.1); color:#ec4899;}
.dz-text{font-size:14px; color:#e5e7eb; font-weight:600; margin-bottom:4px; pointer-events:none;}
.dz-sub{font-size:12px; color:#9ca3af; pointer-events:none;}
.dz-file{display:none; font-size:13px; color:#ec4899; font-weight:700; margin-top:8px; word-break:break-all; pointer-events:none;}
.drop-zone.has-file .dz-file{display:block;}
.drop-zone.has-file .dz-sub{display:none;}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabNormal = document.getElementById('tab-btn-normal');
    const tabImport = document.getElementById('tab-btn-import');
    const contentNormal = document.getElementById('tab-content-normal');
    const contentImport = document.getElementById('tab-content-import');

    function switchTab(tab) {
        if(tab === 'normal') {
            tabNormal.classList.add('active');
            tabImport.classList.remove('active');
            contentNormal.classList.add('active');
            contentImport.classList.remove('active');
        } else {
            tabImport.classList.add('active');
            tabNormal.classList.remove('active');
            contentImport.classList.add('active');
            contentNormal.classList.remove('active');
        }
    }

    if(tabNormal && tabImport) {
        tabNormal.addEventListener('click', () => switchTab('normal'));
        tabImport.addEventListener('click', () => switchTab('import'));
    }

    const fileInput = document.getElementById('sql_file');
    const dropZone = document.getElementById('drop_zone');
    const fileNameDisplay = document.getElementById('dz_file_name');

    if(fileInput && dropZone) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                dropZone.classList.add('has-file');
                fileNameDisplay.textContent = e.target.files[0].name;
            } else {
                dropZone.classList.remove('has-file');
                fileNameDisplay.textContent = '';
            }
        });
    }
});
</script>
HTML;

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';

$body .= '<div class="tabs">';
$body .= '<button type="button" id="tab-btn-normal" class="tab-btn ' . ($activeTab === 'normal' ? 'active' : '') . '">' . rj_esc($t['ins_tab_normal'] ?? 'Standard Install') . '</button>';
$body .= '<button type="button" id="tab-btn-import" class="tab-btn ' . ($activeTab === 'import' ? 'active' : '') . '">' . rj_esc($t['ins_tab_import'] ?? 'Migrate from RJ CMS') . '</button>';
$body .= '</div>';

$body .= '<div id="tab-content-normal" class="tab-content ' . ($activeTab === 'normal' ? 'active' : '') . '">';
$body .= '<p style="color:#9ca3af;font-size:14px;margin-bottom:24px;line-height:1.6;text-align:center;">' . rj_esc($t['ins_normal_desc'] ?? 'Fresh installation. The system will create all necessary database tables, run migrations, and populate default settings.') . '</p>';
$body .= '<form method="post">';
$body .= '<div class="row" style="justify-content:space-between;">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back'] ?? 'Back') . '</a>';
$body .= '<button class="btn" type="submit">' . rj_esc($t['install'] ?? 'Start Installation') . '</button>';
$body .= '</div>';
$body .= '</form>';
$body .= '</div>';

$body .= '<div id="tab-content-import" class="tab-content ' . ($activeTab === 'import' ? 'active' : '') . '">';
$body .= '<p style="color:#9ca3af;font-size:14px;margin-bottom:24px;line-height:1.6;text-align:center;">' . rj_esc($t['ins_import_desc'] ?? 'Already have an RJ CMS database? Upload your .sql file. Migrations and seeds will be skipped, and your existing content will be preserved.') . '</p>';
$body .= '<form method="post" enctype="multipart/form-data">';
$body .= '<label class="drop-zone" id="drop_zone">';
$body .= '<input type="file" name="sql_file" id="sql_file" accept=".sql">';
$body .= '<div class="dz-icon">';
$body .= '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>';
$body .= '</div>';
$body .= '<div class="dz-text">' . rj_esc($t['ins_import_choose'] ?? 'Click to select your .sql file') . '</div>';
$body .= '<div class="dz-sub">' . rj_esc($t['ins_import_sub'] ?? 'or drag and drop it here') . '</div>';
$body .= '<div class="dz-file" id="dz_file_name"></div>';
$body .= '</label>';
$body .= '<div class="row" style="justify-content:space-between;margin-top:24px;">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back'] ?? 'Back') . '</a>';
$body .= '<button class="btn" type="submit" style="background:linear-gradient(135deg,#ec4899 0%,#7c3aed 100%);">' . rj_esc($t['ins_import_btn'] ?? 'Import & Install') . '</button>';
$body .= '</div>';
$body .= '</form>';
$body .= '</div>';

rj_render('install', $body, $extra);
exit;
