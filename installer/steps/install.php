<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['admin'])) {
    header('Location: ' . rj_installer_url('step=admin'));
    exit;
}

function rj_activate_bundled_plugins(): void
{
    $bundled = ['form-builder'];

    try {
        if (!class_exists(\Illuminate\Foundation\Application::class)) {
            require_once RJ_ROOT . '/vendor/autoload.php';
        }

        if (function_exists('app') && app() instanceof \Illuminate\Contracts\Foundation\Application) {
            $app = app();
        } else {
            $app = require RJ_ROOT . '/bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();
        }

        $manager = $app->make(\App\Services\PluginManager::class);
        $manager->discover();

        foreach ($bundled as $slug) {
            $plugin = \App\Models\Plugin::where('slug', $slug)->first();
            if ($plugin && !$plugin->isActive()) {
                $manager->activate($plugin);
            }
        }
    } catch (\Throwable $e) {
        if (defined('RJ_LOG')) {
            @file_put_contents(
                RJ_LOG,
                '[' . date('Y-m-d H:i:s') . '] Bundled plugin activation failed: ' . $e->getMessage() . "\n",
                FILE_APPEND
            );
        }
    }
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    @set_time_limit(300);
    @ini_set('memory_limit', '256M');

    $action = $_POST['action'] ?? 'normal';
    $sqlContent = null;

    if ($action === 'import') {
        $state['db_imported'] = true;
        rj_set_state($state);

        if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['sql_file']['tmp_name'];
            $sqlContent = file_get_contents($tmpName);

            if (substr($sqlContent, 0, 2) === "\xFF\xFE") {
                $sqlContent = mb_convert_encoding($sqlContent, 'UTF-8', 'UTF-16LE');
            }
        } else {
            $err = $t['err_sql_required'] ?? 'Please upload a valid .sql file.';
        }
    } else {
        $state['db_imported'] = false;
        rj_set_state($state);
    }

    if (!$err) {
        $result = rj_install_run($sqlContent);
        if (!empty($result['ok'])) {
            rj_activate_bundled_plugins();
            header('Location: ' . rj_installer_url('step=finish'));
            exit;
        }
        $err = $result['error'] ?? '';
    }
}

$activeTab = (isset($_POST['action']) && $_POST['action'] === 'import') || (isset($_GET['tab']) && $_GET['tab'] === 'import') ? 'import' : 'normal';

$extra = <<<'HTML'
<style>
html,body{min-height:100%;background:#05040f}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(120% 90% at 75% 25%,#1c1450 0%,#0d0a2b 50%,#05040f 100%)}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(22px);background:radial-gradient(40% 35% at 85% 15%,rgba(244,114,182,.24),transparent 70%),radial-gradient(35% 30% at 15% 75%,rgba(167,139,250,.26),transparent 70%),radial-gradient(40% 35% at 55% 95%,rgba(96,165,250,.18),transparent 70%);animation:in-neb 30s ease-in-out infinite alternate}
@keyframes in-neb{from{transform:translate3d(3%,-1%,0) scale(1)}to{transform:translate3d(-4%,2%,0) scale(1.16)}}
#inSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

.card{position:relative!important;z-index:2;background:none!important;border:0!important;box-shadow:none!important;-webkit-backdrop-filter:none!important;backdrop-filter:none!important;overflow:visible!important}
.card::before{content:"";position:absolute;inset:-8% -14%;z-index:-1;pointer-events:none;background:radial-gradient(closest-side,rgba(8,5,28,.74),transparent)}
.brand-logo{filter:drop-shadow(0 0 20px rgba(167,139,250,.55))}
.card h1{background:linear-gradient(90deg,#fff 0%,#e9d5ff 45%,#f9a8d4 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:#fff;font-weight:800;filter:drop-shadow(0 0 22px rgba(167,139,250,.4))}
.card p.sub{color:#b4bad4!important}

.tabs{position:relative;display:flex;margin:24px 0 26px;padding:4px;border-radius:9999px;background:transparent;border:1.5px solid rgba(168,85,247,.4);opacity:0;animation:in-rise .7s .15s cubic-bezier(.2,.8,.2,1) forwards}
.tabs::before{content:"";position:absolute;top:4px;bottom:4px;left:4px;width:calc(50% - 4px);border-radius:9999px;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 26px -6px rgba(236,72,153,.9),0 0 0 1px rgba(255,255,255,.22) inset;transition:transform .55s cubic-bezier(.2,.9,.3,1.15);animation:in-flow 6s linear infinite}
.tabs[data-tab="import"]::before{transform:translateX(100%)}
.tab-btn{position:relative;z-index:1;flex:1;padding:11px 10px;text-align:center;font-size:12px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#c4b5fd;border:0;background:none;border-radius:9999px;cursor:pointer;font-family:inherit;transition:color .35s}
.tab-btn:hover{color:#fff}
.tab-btn.active{color:#fff}
.tab-btn:focus-visible{outline:2px solid #fff;outline-offset:2px}

.tab-content{display:none}
.tab-content.active{display:block;animation:in-swap .6s cubic-bezier(.2,.8,.2,1)}
@keyframes in-swap{from{opacity:0;transform:translateY(14px) scale(.98);filter:blur(6px)}to{opacity:1;transform:none;filter:none}}
@keyframes in-rise{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.tab-desc{margin:0 0 26px;color:#b4bad4;font-size:14px;line-height:1.7;text-align:center}

.drop-zone{position:relative;display:block;padding:34px 20px;border-radius:28px;text-align:center;cursor:pointer;background:transparent;border:1.5px dashed rgba(168,85,247,.5);transition:border-color .3s,box-shadow .3s,transform .3s}
.drop-zone:hover{border-color:#f472b6;box-shadow:0 0 30px -8px rgba(244,114,182,.7),inset 0 0 24px rgba(167,139,250,.12)}
.drop-zone.drag{border-color:#f9a8d4;transform:scale(1.02);box-shadow:0 0 40px -6px rgba(244,114,182,.9),inset 0 0 30px rgba(167,139,250,.2)}
.drop-zone.has-file{border-style:solid;border-color:#6ee7b7;box-shadow:0 0 28px -8px rgba(110,231,183,.7),inset 0 0 20px rgba(110,231,183,.08)}
.drop-zone input[type="file"]{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;z-index:10}
.dz-icon{position:relative;width:60px;height:60px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;border-radius:50%;color:#d8b4fe;transition:color .3s}
.dz-icon::before{content:"";position:absolute;inset:0;border-radius:50%;border:1.5px solid transparent;border-top-color:#f472b6;border-right-color:rgba(167,139,250,.7);animation:in-orbit 4s linear infinite}
.dz-icon::after{content:"";position:absolute;inset:8px;border-radius:50%;border:1px solid rgba(168,85,247,.35);animation:in-orbit 7s linear infinite reverse}
.dz-icon svg{position:relative;z-index:1;animation:in-float 3s ease-in-out infinite}
.drop-zone.has-file .dz-icon{color:#6ee7b7}
.drop-zone.has-file .dz-icon::before{border-top-color:#6ee7b7;border-right-color:rgba(110,231,183,.6)}
@keyframes in-orbit{to{transform:rotate(360deg)}}
@keyframes in-float{0%,100%{transform:translateY(2px)}50%{transform:translateY(-3px)}}
.dz-text{margin-bottom:4px;color:#f3f4f6;font-size:15px;font-weight:700;pointer-events:none}
.dz-sub{color:#9ca3af;font-size:12px;pointer-events:none}
.dz-file{display:none;margin-top:8px;color:#6ee7b7;font-size:13px;font-weight:700;word-break:break-all;pointer-events:none}
.drop-zone.has-file .dz-file{display:block}
.drop-zone.has-file .dz-sub{display:none}

.card .alert{margin:18px 0 0;padding:14px 18px;border-radius:16px;background:rgba(251,113,133,.06)!important;border:1px solid rgba(251,113,133,.4)!important;color:#fda4af!important;line-height:1.6;word-break:break-word}

.card .row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:28px}
.card .btn{position:relative;display:inline-flex;align-items:center;justify-content:center;padding:13px 28px;border-radius:9999px;border:0;color:#fff;font-weight:800;letter-spacing:.03em;text-decoration:none;cursor:pointer;overflow:hidden;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 16px 40px -14px rgba(236,72,153,.85),0 0 46px -10px rgba(124,58,237,.7);animation:in-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s,border-color .25s,color .25s}
@keyframes in-flow{to{background-position:-300% 0}}
.card .btn::before{content:"";position:absolute;top:0;bottom:0;left:-60%;width:40%;background:linear-gradient(100deg,transparent,rgba(255,255,255,.45),transparent);transform:skewX(-20deg);animation:in-sheen 3.6s ease-in-out infinite}
@keyframes in-sheen{0%,55%{left:-60%}100%{left:130%}}
.card .btn:hover{transform:scale(1.06)}
.card .btn:active{transform:scale(.96)}
.card .btn.ghost{background:transparent;color:#d8b4fe;border:1.5px solid rgba(168,85,247,.5);box-shadow:none;animation:none;font-weight:600}
.card .btn.ghost::before{display:none}
.card .btn.ghost:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 26px -4px rgba(236,72,153,.8)}
.card .btn:disabled{opacity:.75;cursor:wait}
.card .btn.busy::after{content:"";width:14px;height:14px;margin-left:12px;border-radius:50%;border:2px solid rgba(255,255,255,.35);border-top-color:#fff;animation:in-orbit .8s linear infinite}
.card .btn:focus-visible{outline:2px solid #fff;outline-offset:4px}

body.launching .card{animation:in-launch 2.4s ease-in forwards}
@keyframes in-launch{0%{opacity:1;transform:none;filter:none}100%{opacity:.35;transform:scale(.96);filter:blur(1.5px)}}

@media (max-width:560px){
.tab-btn{font-size:11px;letter-spacing:.06em;padding:11px 6px}
.card .row{flex-direction:column-reverse;align-items:stretch}
.card .btn{width:100%}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var tabs=document.querySelector('.tabs');
var bN=document.getElementById('tab-btn-normal'),bI=document.getElementById('tab-btn-import');
var cN=document.getElementById('tab-content-normal'),cI=document.getElementById('tab-content-import');
function sw(t){
var imp=t==='import';
tabs.setAttribute('data-tab',t);
bN.classList.toggle('active',!imp);bI.classList.toggle('active',imp);
cN.classList.toggle('active',!imp);cI.classList.toggle('active',imp)
}
bN.addEventListener('click',function(){sw('normal')});
bI.addEventListener('click',function(){sw('import')});

var fi=document.getElementById('sql_file'),dz=document.getElementById('drop_zone'),fn=document.getElementById('dz_file_name');
if(fi){
fi.addEventListener('change',function(e){
if(e.target.files.length>0){dz.classList.add('has-file');fn.textContent=e.target.files[0].name}
else{dz.classList.remove('has-file');fn.textContent=''}
});
['dragenter','dragover'].forEach(function(n){fi.addEventListener(n,function(){dz.classList.add('drag')})});
['dragleave','drop'].forEach(function(n){fi.addEventListener(n,function(){dz.classList.remove('drag')})})
}

var warpTarget=1;
var forms=document.querySelectorAll('form');
for(var k=0;k<forms.length;k++)forms[k].addEventListener('submit',function(e){
var b=e.target.querySelector('button[type=submit]');
if(b){b.classList.add('busy');setTimeout(function(){b.disabled=true},0)}
document.body.classList.add('launching');
warpTarget=16
});

try{
var cv=document.createElement('canvas');cv.id='inSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,D=0,dpr=1,stars=[],gal=[],shocks=[],mx=0,my=0,tmx=0,tmy=0,gT=0,lastT=0,warp=1,running=true,T0=performance.now();
var scols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}
function center(){var big=W<700;return{x:(big?W*.5:W*.82)+mx*16,y:(big?H*.16:H*.28)+my*10}}

function build(){
stars=[];
var n=Math.round(clamp(W*H/4200,120,380));
for(var i=0;i<n;i++){var z=Math.pow(Math.random(),1.5)*1.3+.2;stars.push({a:rnd(0,6.2832),d:Math.random(),z:z,r:.3+z*.7,ph:rnd(0,6.28),sp:rnd(.4,1.6),c:scols[(Math.random()*scols.length)|0]})}
gal=[];
var g=W<700?700:1300,arm,r,ang;
for(i=0;i<g;i++){
arm=i%3;r=Math.pow(Math.random(),.6);
ang=arm*2.0944+r*4+rnd(-.3,.3)*(1-r*.4);
gal.push({r:r,a:ang,s:rnd(.6,1.9),o:rnd(.35,1),c:r<.18?'#fff4e6':(r<.5?(Math.random()<.5?'#f9a8d4':'#e9d5ff'):(Math.random()<.5?'#a5b4fc':'#c4b5fd'))})
}
for(i=0;i<200;i++){r=Math.pow(Math.random(),2)*.22;gal.push({r:r,a:rnd(0,6.283),s:rnd(.7,2),o:rnd(.5,1),c:'#fff4e6'})}
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;D=Math.sqrt(W*W+H*H);
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
build()
}
function drawGalaxy(t,dt){
var gF=easeOut(clamp(t/2.4,0,1));
gT+=dt*(1+(warp-1)*.5);
var big=W<700,c=center(),cx=c.x,cy=c.y;
var Rg=Math.min(W,H)*(big?.8:.72)*(.6+.4*gF);
var tl=.3,ct=Math.cos(tl),st=Math.sin(tl);
ctx.globalCompositeOperation='lighter';
var pulse=1+.05*Math.sin(t*1.5)+(warp-1)*.012;
var gr=ctx.createRadialGradient(cx,cy,0,cx,cy,Rg*.5*pulse);
gr.addColorStop(0,'rgba(255,236,255,'+clamp(.55*gF+(warp-1)*.03,0,.95)+')');
gr.addColorStop(.3,'rgba(190,150,255,'+(.22*gF)+')');
gr.addColorStop(1,'rgba(90,70,200,0)');
ctx.fillStyle=gr;ctx.beginPath();ctx.arc(cx,cy,Rg*.5*pulse,0,6.283);ctx.fill();
for(var i=0;i<gal.length;i++){
var p=gal[i],a=p.a+gT*.12/(.25+p.r);
var x=Math.cos(a)*p.r*Rg,y=Math.sin(a)*p.r*Rg*.5;
var X=cx+x*ct-y*st,Y=cy+x*st+y*ct;
ctx.globalAlpha=p.o*(1-p.r*.5)*gF*.9;
ctx.fillStyle=p.c;
var sz=p.s*(1.25-p.r*.4);
ctx.fillRect(X,Y,sz,sz)
}
ctx.globalAlpha=1;ctx.globalCompositeOperation='source-over'
}
function drawStars(t,dt){
var fade=clamp(t/1,0,1),c=center(),cx=c.x,cy=c.y;
for(var i=0;i<stars.length;i++){
var s=stars[i],v=dt*.028*s.z*warp*(.25+s.d);
s.d+=v;
if(s.d>1){s.d=rnd(0,.04);s.a=rnd(0,6.2832)}
var ca=Math.cos(s.a),sa=Math.sin(s.a);
var px=cx+ca*s.d*D+mx*s.z*10,py=cy+sa*s.d*D+my*s.z*7;
var al=fade*clamp(s.d*7,0,1)*(.25+.65*(.5+.5*Math.sin(t*s.sp+s.ph)));
ctx.globalAlpha=al;
if(warp>1.8){
var tail=Math.max(0,s.d-(warp-1)*.0045*s.z*(.25+s.d));
ctx.strokeStyle=s.c;ctx.lineWidth=s.r*1.1;
ctx.beginPath();ctx.moveTo(cx+ca*tail*D+mx*s.z*10,cy+sa*tail*D+my*s.z*7);ctx.lineTo(px,py);ctx.stroke()
}else{
ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(px,py,s.r*(.6+s.d*.8),0,6.283);ctx.fill()
}
}
ctx.globalAlpha=1
}
function drawShocks(now){
ctx.globalCompositeOperation='lighter';
for(var j=shocks.length-1;j>=0;j--){
var sh=shocks[j],p=(now-sh.t)/sh.d;
if(p>=1){shocks.splice(j,1);continue}
if(p<0)continue;
var e=easeOut(p),a=1-p;
ctx.strokeStyle='rgba('+sh.c+','+(a*.7).toFixed(3)+')';ctx.lineWidth=1.5+a*4;
ctx.beginPath();ctx.arc(sh.x,sh.y,20+(sh.m-20)*e,0,6.283);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
}
function frame(now){
if(!running)return;
try{
var t=(now-T0)/1000,dt=Math.min(.1,Math.max(.001,(now-lastT)/1000||.016));
lastT=now;
mx+=(tmx-mx)*.05;my+=(tmy-my)*.05;
warp+=(warpTarget-warp)*Math.min(1,dt*2.2);
ctx.clearRect(0,0,W,H);
drawStars(t,dt);
drawGalaxy(t,dt);
drawShocks(performance.now());
requestAnimationFrame(frame)
}catch(e){running=false;cv.style.display='none'}
}
window.addEventListener('pointermove',function(e){tmx=(e.clientX/W-.5)*2;tmy=(e.clientY/H-.5)*2});
document.addEventListener('click',function(e){
var b=e.target.closest&&e.target.closest('.btn');
if(!b)return;
var r=b.getBoundingClientRect(),n=performance.now(),m=Math.max(W,H)*.7,x=r.left+r.width/2,y=r.top+r.height/2;
shocks.push({x:x,y:y,t:n,d:1200,m:m,c:'244,114,182'});
shocks.push({x:x,y:y,t:n+170,d:1400,m:m,c:'167,139,250'})
});
var rt=0;
window.addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(layout,80)});
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;lastT=performance.now();requestAnimationFrame(frame)}
});
layout();
requestAnimationFrame(frame)
}catch(e){}
});
</script>
HTML;

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';

$body .= '<div class="tabs" data-tab="' . $activeTab . '">';
$body .= '<button type="button" id="tab-btn-normal" class="tab-btn ' . ($activeTab === 'normal' ? 'active' : '') . '">' . rj_esc($t['ins_tab_normal'] ?? 'Standard Install') . '</button>';
$body .= '<button type="button" id="tab-btn-import" class="tab-btn ' . ($activeTab === 'import' ? 'active' : '') . '">' . rj_esc($t['ins_tab_import'] ?? 'Migrate from RJ CMS') . '</button>';
$body .= '</div>';

$body .= '<div id="tab-content-normal" class="tab-content ' . ($activeTab === 'normal' ? 'active' : '') . '">';
$body .= '<p class="tab-desc">' . rj_esc($t['ins_normal_desc'] ?? 'Fresh installation. The system will create all necessary database tables, run migrations, and populate default settings.') . '</p>';
$body .= '<form method="post">';
$body .= '<input type="hidden" name="action" value="normal">';
$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back'] ?? 'Back') . '</a>';
$body .= '<button class="btn" type="submit">' . rj_esc($t['install'] ?? 'Start Installation') . '</button>';
$body .= '</div>';
$body .= '</form>';
$body .= '</div>';

$body .= '<div id="tab-content-import" class="tab-content ' . ($activeTab === 'import' ? 'active' : '') . '">';
$body .= '<p class="tab-desc">' . rj_esc($t['ins_import_desc'] ?? 'Already have an RJ CMS database? Upload your .sql file. Migrations and seeds will be skipped, and your existing content will be preserved.') . '</p>';
$body .= '<form method="post" enctype="multipart/form-data">';
$body .= '<input type="hidden" name="action" value="import">';
$body .= '<label class="drop-zone" id="drop_zone">';
$body .= '<input type="file" name="sql_file" id="sql_file" accept=".sql">';
$body .= '<div class="dz-icon">';
$body .= '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>';
$body .= '</div>';
$body .= '<div class="dz-text">' . rj_esc($t['ins_import_choose'] ?? 'Click to select your .sql file') . '</div>';
$body .= '<div class="dz-sub">' . rj_esc($t['ins_import_sub'] ?? 'or drag and drop it here') . '</div>';
$body .= '<div class="dz-file" id="dz_file_name"></div>';
$body .= '</label>';
$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=admin') . '" class="btn ghost">' . rj_esc($t['back'] ?? 'Back') . '</a>';
$body .= '<button class="btn" type="submit">' . rj_esc($t['ins_import_btn'] ?? 'Import & Install') . '</button>';
$body .= '</div>';
$body .= '</form>';
$body .= '</div>';

rj_render('install', $body, $extra);
exit;
