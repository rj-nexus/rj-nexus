<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang']) || !rj_requirements_ok()) {
    header('Location: ' . rj_installer_url('step=requirements'));
    exit;
}

$err = '';
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host']);
$action = $_POST['action'] ?? 'normal';

if ($submitted) {
    $cfg = [
        'host' => trim($_POST['db_host'] ?? '127.0.0.1'),
        'port' => (int) ($_POST['db_port'] ?? 3306),
        'name' => trim($_POST['db_name'] ?? ''),
        'user' => trim($_POST['db_user'] ?? ''),
        'pass' => (string) ($_POST['db_pass'] ?? ''),
    ];
    $siteName = trim($_POST['site_name'] ?? '');
    $siteUrl = trim($_POST['site_url'] ?? '');

    if ($cfg['name'] === '' || $cfg['user'] === '' || $siteName === '' || $siteUrl === '') {
        $err = $t['err_db'];
    } else {
        $dbTest = rj_db_test($cfg);
        if ($dbTest['ok']) {
            $state['db'] = $cfg;
            $state['site_name'] = $siteName;
            $state['site_url'] = $siteUrl;

            if ($action === 'imported_next') {
                $state['db_imported'] = true;
                rj_set_state($state);
                header('Location: ' . rj_installer_url('step=admin'));
                exit;
            } elseif ($action === 'imported_finish') {
                $state['db_imported'] = true;
                $state['skip_admin'] = true;
                rj_set_state($state);

                try {
                    rj_env_write([
                        'APP_NAME' => $siteName,
                        'APP_URL' => rtrim($siteUrl, '/'),
                        'APP_ENV' => 'production',
                        'APP_DEBUG' => 'false',
                        'APP_LOCALE' => $state['lang'] ?? 'en',
                        'APP_KEY' => '',
                        'DB_HOST' => $cfg['host'],
                        'DB_PORT' => $cfg['port'],
                        'DB_DATABASE' => $cfg['name'],
                        'DB_USERNAME' => $cfg['user'],
                        'DB_PASSWORD' => $cfg['pass'],
                    ]);

                    $kg = rj_artisan(['key:generate', '--force']);
                    $lockDir = dirname(RJ_LOCK);
                    if (!is_dir($lockDir)) @mkdir($lockDir, 0755, true);
                    file_put_contents(RJ_LOCK, json_encode(['installed_at' => date('c'), 'version' => '1.5.0', 'lang' => $state['lang'] ?? 'en'], JSON_PRETTY_PRINT));

                    header('Location: ' . rj_installer_url('step=finish'));
                    exit;
                } catch (Throwable $e) {
                    $err = 'Env write error: ' . $e->getMessage();
                }
            } else {
                rj_set_state($state);
                header('Location: ' . rj_installer_url('step=admin'));
                exit;
            }
        } else {
            $err = $t['err_db'] . ': ' . $dbTest['msg'];
        }
    }
}

$db = $state['db'] ?? [];
if ($submitted) {
    $db = [
        'host' => trim($_POST['db_host'] ?? '127.0.0.1'),
        'port' => (int) ($_POST['db_port'] ?? 3306),
        'name' => trim($_POST['db_name'] ?? ''),
        'user' => trim($_POST['db_user'] ?? ''),
        'pass' => (string) ($_POST['db_pass'] ?? ''),
    ];
} elseif (empty($db)) {
    $db = ['host' => '127.0.0.1', 'port' => '3306', 'name' => '', 'user' => '', 'pass' => ''];
}

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
$body .= '<form method="post" class="gx-form">';

$body .= '<div class="gx-grid">';
$body .= '<div class="fld f-host"><label>' . rj_esc($t['db_host']) . '</label><input name="db_host" dir="ltr" value="' . rj_esc($db['host']) . '" required></div>';
$body .= '<div class="fld f-port"><label>' . rj_esc($t['db_port']) . '</label><input name="db_port" type="number" dir="ltr" value="' . rj_esc((string) $db['port']) . '" required></div>';
$body .= '<div class="fld f-full"><label>' . rj_esc($t['db_name']) . '</label><input name="db_name" dir="ltr" value="' . rj_esc($db['name']) . '" required></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_user']) . '</label><input name="db_user" dir="ltr" value="' . rj_esc($db['user']) . '" required></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_pass']) . '</label><input name="db_pass" type="password" dir="ltr" value=""></div>';
$body .= '<div class="fld f-full"><label>' . rj_esc($t['site_name']) . '</label><input name="site_name" value="' . rj_esc($state['site_name'] ?? 'RJ Nexus') . '" required></div>';
$body .= '<div class="fld f-full"><label>' . rj_esc($t['site_url']) . '</label><input name="site_url" type="url" dir="ltr" value="' . rj_esc($state['site_url'] ?? rj_http_host()) . '" required></div>';
$body .= '</div>';

$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=requirements') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '<button class="btn" type="submit" name="action" value="normal">' . rj_esc($t['db_test'] ?? 'Test & Continue') . '</button>';
$body .= '</div>';

$body .= '<div class="alt">';
$body .= '<p>' . rj_esc($t['db_imported'] ?? 'Already imported the database?') . '</p>';
$body .= '<div class="alt-r">';
$body .= '<button class="btn ghost sm" type="submit" name="action" value="imported_next">' . rj_esc($t['db_imported_next'] ?? 'Go to Admin Setup') . '</button>';
$body .= '<button class="btn ghost sm" type="submit" name="action" value="imported_finish">' . rj_esc($t['db_imported_finish'] ?? 'Finish Installation') . '</button>';
$body .= '</div>';
$body .= '</div>';
$body .= '</form>';

$extra = <<<'HTML'
<style>
html,body{min-height:100%;background:#05040f}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(120% 90% at 30% 70%,#1c1450 0%,#0d0a2b 50%,#05040f 100%)}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(22px);background:radial-gradient(40% 35% at 15% 80%,rgba(244,114,182,.24),transparent 70%),radial-gradient(35% 30% at 80% 20%,rgba(167,139,250,.26),transparent 70%),radial-gradient(40% 35% at 55% 95%,rgba(96,165,250,.18),transparent 70%);animation:db-neb 28s ease-in-out infinite alternate}
@keyframes db-neb{from{transform:translate3d(4%,1%,0) scale(1)}to{transform:translate3d(-4%,-2%,0) scale(1.15)}}
#dbSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

.card{position:relative!important;z-index:2;background:none!important;border:0!important;box-shadow:none!important;-webkit-backdrop-filter:none!important;backdrop-filter:none!important;overflow:visible!important}
.card::before{content:"";position:absolute;inset:-8% -14%;z-index:-1;pointer-events:none;background:radial-gradient(closest-side,rgba(8,5,28,.74),transparent)}
.brand-logo{filter:drop-shadow(0 0 20px rgba(167,139,250,.55))}
.card h1{background:linear-gradient(90deg,#fff 0%,#e9d5ff 45%,#f9a8d4 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:#fff;font-weight:800;filter:drop-shadow(0 0 22px rgba(167,139,250,.4))}
.card p.sub{color:#b4bad4!important}

.gx-form{margin-top:22px}
.gx-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:16px 16px}
.fld{opacity:0;animation:db-in .7s calc(.15s + var(--i,0)*.08s) cubic-bezier(.2,.8,.2,1) forwards}
.f-host{grid-column:span 4}
.f-port{grid-column:span 2}
.f-half{grid-column:span 3}
.f-full{grid-column:span 6}
@keyframes db-in{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.fld label{display:block;margin:0 0 7px 6px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#c4b5fd;transition:color .3s}
.fld:focus-within label{color:#f9a8d4}
.fld input{display:block;width:100%;box-sizing:border-box;padding:13px 20px;border-radius:9999px;background:transparent!important;border:1.5px solid rgba(168,85,247,.4)!important;color:#fff!important;font-size:15px;outline:none;box-shadow:none;transition:border-color .3s,box-shadow .3s}
.fld input::placeholder{color:#6b7280}
.fld input:hover{border-color:rgba(236,72,153,.55)!important}
.fld input:focus{border-color:#f472b6!important;box-shadow:0 0 22px -4px rgba(244,114,182,.75),inset 0 0 12px rgba(167,139,250,.18)}
.fld input:-webkit-autofill{-webkit-text-fill-color:#fff;transition:background-color 9999s ease-out 0s;box-shadow:0 0 0 1000px #0d0a2b inset}

.card .alert{margin:18px 0 0;padding:14px 18px;border-radius:16px;background:rgba(251,113,133,.06)!important;border:1px solid rgba(251,113,133,.4)!important;color:#fda4af!important;line-height:1.6}

.card .row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:28px}
.card .btn{position:relative;display:inline-flex;align-items:center;justify-content:center;padding:13px 28px;border-radius:9999px;border:0;color:#fff;font-weight:800;letter-spacing:.03em;text-decoration:none;cursor:pointer;overflow:hidden;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 16px 40px -14px rgba(236,72,153,.85),0 0 46px -10px rgba(124,58,237,.7);animation:db-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s,border-color .25s,color .25s}
@keyframes db-flow{to{background-position:-300% 0}}
.card .btn:hover{transform:scale(1.06)}
.card .btn:active{transform:scale(.96)}
.card .btn.ghost{background:transparent;color:#d8b4fe;border:1.5px solid rgba(168,85,247,.5);box-shadow:none;animation:none;font-weight:600}
.card .btn.ghost:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 26px -4px rgba(236,72,153,.8)}
.card .btn.sm{font-size:13px;padding:9px 18px}
.card .btn:focus-visible{outline:2px solid #fff;outline-offset:4px}

.alt{margin-top:26px;padding-top:20px;text-align:center;position:relative}
.alt::before{content:"";position:absolute;left:10%;right:10%;top:0;height:1px;background:linear-gradient(90deg,transparent,rgba(168,85,247,.5),transparent)}
.alt p{margin:0 0 12px;font-size:13px;color:#9ca3af}
.alt-r{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}

@media (max-width:560px){
.f-host,.f-port,.f-half{grid-column:span 6}
.card .row{flex-direction:column-reverse;align-items:stretch}
.card .btn{width:100%}
.alt-r{flex-direction:column}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var items=document.querySelectorAll('.fld');
for(var q=0;q<items.length;q++)items[q].style.setProperty('--i',q);
try{
var cv=document.createElement('canvas');cv.id='dbSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,stars=[],gal=[],shoots=[],shocks=[],nextShoot=2,mx=0,my=0,tmx=0,tmy=0,gT=0,lastT=0,running=true,T0=performance.now();
var scols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}

function build(){
stars=[];
var n=Math.round(clamp(W*H/4200,120,380));
for(var i=0;i<n;i++){var z=Math.pow(Math.random(),1.5)*1.3+.2;stars.push({x:Math.random(),y:Math.random(),z:z,r:.3+z*.7,ph:rnd(0,6.28),sp:rnd(.4,1.6),c:scols[(Math.random()*scols.length)|0]})}
gal=[];
var g=W<700?700:1300,arm,r,ang;
for(i=0;i<g;i++){
arm=i%4;r=Math.pow(Math.random(),.6);
ang=arm*1.5708+r*4.2+rnd(-.3,.3)*(1-r*.4);
gal.push({r:r,a:ang,s:rnd(.6,1.9),o:rnd(.35,1),c:r<.18?'#fff4e6':(r<.5?(Math.random()<.5?'#f9a8d4':'#e9d5ff'):(Math.random()<.5?'#a5b4fc':'#c4b5fd'))})
}
for(i=0;i<200;i++){r=Math.pow(Math.random(),2)*.22;gal.push({r:r,a:rnd(0,6.283),s:rnd(.7,2),o:rnd(.5,1),c:'#fff4e6'})}
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
build()
}
function drawGalaxy(t,dt){
var gF=easeOut(clamp(t/2.4,0,1));
gT+=dt;
var big=W<700,cx=(big?W*.45:W*.2)+mx*16,cy=(big?H*.84:H*.7)+my*10;
var Rg=Math.min(W,H)*(big?.9:.78)*(.6+.4*gF);
var tl=.5,ct=Math.cos(tl),st=Math.sin(tl);
ctx.globalCompositeOperation='lighter';
var pulse=1+.05*Math.sin(t*1.5);
var gr=ctx.createRadialGradient(cx,cy,0,cx,cy,Rg*.5*pulse);
gr.addColorStop(0,'rgba(255,236,255,'+(.55*gF)+')');
gr.addColorStop(.3,'rgba(190,150,255,'+(.22*gF)+')');
gr.addColorStop(1,'rgba(90,70,200,0)');
ctx.fillStyle=gr;ctx.beginPath();ctx.arc(cx,cy,Rg*.5*pulse,0,6.283);ctx.fill();
for(var i=0;i<gal.length;i++){
var p=gal[i],a=p.a-gT*.12/(.25+p.r);
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
var fade=clamp(t/1,0,1);
for(var i=0;i<stars.length;i++){
var s=stars[i];
s.y-=dt*.004*s.z;s.x-=dt*.002*s.z;
if(s.y<-.02){s.y=1.02;s.x=Math.random()}
if(s.x<-.02)s.x=1.02;
ctx.globalAlpha=fade*(.25+.65*(.5+.5*Math.sin(t*s.sp+s.ph)));
ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(s.x*W+mx*s.z*14,s.y*H+my*s.z*9,s.r,0,6.283);ctx.fill()
}
ctx.globalAlpha=1
}
function drawShoots(t){
if(t>nextShoot){shoots.push({x:rnd(.3,1)*W,y:rnd(-.05,.35)*H,vx:-rnd(9,13),vy:rnd(4,6.5),l:0});nextShoot=t+rnd(2.5,5)}
for(var j=shoots.length-1;j>=0;j--){
var s=shoots[j];s.x+=s.vx;s.y+=s.vy;s.l+=.018;
var a=1-s.l;
if(a<=0||s.x<-120||s.y>H+120){shoots.splice(j,1);continue}
var g=ctx.createLinearGradient(s.x,s.y,s.x-s.vx*10,s.y-s.vy*10);
g.addColorStop(0,'rgba(255,255,255,'+a+')');g.addColorStop(1,'rgba(167,139,250,0)');
ctx.strokeStyle=g;ctx.lineWidth=1.8;
ctx.beginPath();ctx.moveTo(s.x,s.y);ctx.lineTo(s.x-s.vx*10,s.y-s.vy*10);ctx.stroke()
}
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
ctx.clearRect(0,0,W,H);
drawStars(t,dt);
drawGalaxy(t,dt);
drawShoots(t);
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

rj_render('database', $body, $extra);
exit;
