<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang'])) {
    header('Location: ' . rj_installer_url('step=language'));
    exit;
}

if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    $reqs = rj_requirements();
    $allOk = rj_requirements_ok();
    $res = ['all_ok' => $allOk, 'reqs' => []];
    foreach ($reqs as $k => $r) {
        $res['reqs'][] = ['key' => $k, 'ok' => $r['ok']];
    }
    $res['ok_text'] = $t['ok'];
    $res['fail_text'] = $t['fail'];
    $res['check_text'] = $t['check'] ?? 'Check';
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
}

$reqs = rj_requirements();
$allOk = rj_requirements_ok();

$body = '<ul class="req">';
foreach ($reqs as $k => $r) {
    $label = $t['req_' . $k] ?? $k;
    $body .= '<li><span>' . rj_esc($label) . '</span><span id="req-' . $k . '" class="' . ($r['ok'] ? 'ok' : 'fail') . '">' . ($r['ok'] ? rj_esc($t['ok']) : rj_esc($t['fail'])) . '</span></li>';
}
$body .= '</ul>';

$body .= '<div id="req-error" class="alert" style="margin-top:16px; ' . ($allOk ? 'display:none;' : '') . '">' . rj_esc($t['err_req']) . '</div>';

$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=intro&slide=5') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';

$body .= '<div style="display:flex; gap:12px;">';
$body .= '<button type="button" id="check-btn" class="btn ghost" data-text="' . rj_esc($t['check'] ?? 'Check') . '">' . rj_esc($t['check'] ?? 'Check') . '</button>';
$body .= '<a href="' . rj_installer_url('step=database') . '" class="btn" id="next-btn" style="' . ($allOk ? '' : 'display:none;') . '">' . rj_esc($t['req_btn']) . '</a>';
$body .= '</div>';
$body .= '</div>';

$js = '<script>
document.getElementById("check-btn").addEventListener("click", function() {
    const btn = this;
    const originalText = btn.dataset.text;
    btn.textContent = "...";
    btn.disabled = true;

    fetch(window.location.pathname + "?step=requirements&ajax=1")
        .then(res => res.json())
        .then(data => {
            data.reqs.forEach(req => {
                const el = document.getElementById("req-" + req.key);
                if (el) {
                    el.className = req.ok ? "ok" : "fail";
                    el.textContent = req.ok ? data.ok_text : data.fail_text;
                }
            });

            const nextBtn = document.getElementById("next-btn");
            const errDiv = document.getElementById("req-error");

            if (data.all_ok) {
                nextBtn.style.display = "inline-block";
                errDiv.style.display = "none";
            } else {
                nextBtn.style.display = "none";
                errDiv.style.display = "block";
            }

            btn.textContent = originalText;
            btn.disabled = false;
        })
        .catch(() => {
            btn.textContent = originalText;
            btn.disabled = false;
        });
});
</script>';

rj_render('requirements', $body, $js);
exit;
