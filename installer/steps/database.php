<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang'])) {
    header('Location: ' . rj_installer_url('step=language'));
    exit;
}

$err = '';
$old = $state['db'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host'])) {
    $host = trim($_POST['db_host'] ?? '');
    $port = (int) ($_POST['db_port'] ?? 3306);
    $name = trim($_POST['db_name'] ?? '');
    $user = trim($_POST['db_user'] ?? '');
    $pass = (string) ($_POST['db_pass'] ?? '');
    $prefix = trim($_POST['db_prefix'] ?? '');

    if ($host === '' || $name === '' || $user === '' || $port < 1 || $port > 65535) {
        $err = $t['err_db_fields'] ?? 'Please fill in all required fields.';
    } elseif (!preg_match('/^[A-Za-z0-9_]*$/', $prefix) || !preg_match('/^[A-Za-z0-9_$\-]+$/', $name)) {
        $err = $t['err_db_chars'] ?? 'Database name or prefix contains invalid characters.';
    } else {
        try {
            $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $name . ';charset=utf8mb4';
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);
            $pdo = null;
            $state['db'] = [
                'host' => $host,
                'port' => $port,
                'name' => $name,
                'user' => $user,
                'pass' => $pass,
                'prefix' => $prefix,
            ];
            rj_set_state($state);
            header('Location: ' . rj_installer_url('step=admin'));
            exit;
        } catch (Throwable $e) {
            $err = ($t['err_db'] ?? 'Could not connect to the database.') . ' ' . $e->getMessage();
        }
    }
    $old = [
        'host' => $host,
        'port' => $port,
        'name' => $name,
        'user' => $user,
        'prefix' => $prefix,
    ];
}

$v = function ($k, $d = '') use ($old) {
    return rj_esc((string) ($old[$k] ?? $d));
};

$body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
$body .= '<form method="post" class="gx-form" id="db-form">';

$body .= '<div class="gx-grid">';
$body .= '<div class="fld f-wide"><label>' . rj_esc($t['db_host'] ?? 'Host') . '</label><input name="db_host" dir="ltr" value="' . $v('host', 'localhost') . '" required></div>';
$body .= '<div class="fld f-narrow"><label>' . rj_esc($t['db_port'] ?? 'Port') . '</label><input name="db_port" type="number" dir="ltr" min="1" max="65535" value="' . $v('port', '3306') . '" required></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_name'] ?? 'Database') . '</label><input name="db_name" dir="ltr" value="' . $v('name') . '" required></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_prefix'] ?? 'Table prefix') . '</label><input name="db_prefix" dir="ltr" value="' . $v('prefix', 'rj_') . '"></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_user'] ?? 'Username') . '</label><input name="db_user" dir="ltr" autocomplete="off" value="' . $v('user') . '" required></div>';
$body .= '<div class="fld f-half"><label>' . rj_esc($t['db_pass'] ?? 'Password') . '</label><input name="db_pass" type="password" dir="ltr" autocomplete="new-password"></div>';
$body .= '</div>';

$body .= '<div class="row">';
$body .= '<a href="' . rj_installer_url('step=requirements') . '" class="btn ghost">' . rj_esc($t['back']) . '</a>';
$body .= '<button class="btn" type="submit" id="db-submit" data-text="' . rj_esc($t['db_continue'] ?? 'Continue') . '">' . rj_esc($t['db_continue'] ?? 'Continue') . '</button>';
$body .= '</div>';
$body .= '</form>';

$extra = <<<'HTML'
<style>
html,body{min-height:100%;background:#05040f}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(120% 90% at 70% 70%,#1c1450 0%,#0d0a2b 50%,#05040f 100%)}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(22px);background:radial-gradient(40% 35% at 20% 25%,rgba(167,139,250,.26),transparent 70%),radial-gradient(35% 30% at 85% 80%,rgba(244,114,182,.24),transparent 70%),radial-gradient(40% 35% at 45% 90%,rgba(96,165,250,.18),transparent 70%);animation:db-neb 28s ease-in-out infinite alternate}
@keyframes db-neb{from{transform:translate3d(-4%,1%,0) scale(1)}to{transform:translate3d(4%,-2%,0) scale(1.15)}}
#dbSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

.card{position:relative!important;z-index:2;background:none!important;border:0!important;box-shadow:none!important;-webkit-backdrop-filter:none!important;backdrop-filter:none!important;overflow:visible!important}
.card::before{content:"";position:absolute;inset:-8% -14%;z-index:-1;pointer-events:none;background:radial-gradient(closest-side,rgba(8,5,28,.74),transparent)}
.brand-logo{filter:drop-shadow(0 0 20px rgba(167,139,250,.55))}
.card h1{background:linear-gradient(90deg,#fff 0%,#e9d5ff 45%,#f9a8d4 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:#fff;font-weight:800;filter:drop-shadow(0 0 22px rgba(167,139,250,.4))}
.card p.sub{color:#b4bad4!important}

.gx-form{margin-top:22px}
.gx-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:16px}
.fld{position:relative;opacity:0;animation:db-in .7s calc(.15s + var(--i,0)*.09s) cubic-bezier(.2,.8,.2,1) forwards}
.f-wide{grid-column:span 4}
.f-narrow{grid-column:span 2}
.f-half{grid-column:span 3}
@keyframes db-in{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.fld label{display:block;margin:0 0 7px 6px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#c4b5fd;transition:color .3s}
.fld:focus-within label{color:#f9a8d4}
.fld input{display:block;width:100%;box-sizing:border-box;padding:13px 20px;border-radius:9999px;background:transparent!important;border:1.5px solid rgba(168,85,247,.4)!important;color:#fff!important;font-size:15px;outline:none;box-shadow:none;transition:border-color .3s,box-shadow .3s}
.fld input::placeholder{color:#6b7280}
.fld input:hover{border-color:rgba(236,72,153,.55)!important}
.fld input:focus{border-color:#f472b6!important;box-shadow:0 0 22px -4px rgba(244,114,182,.75),inset 0 0 12px rgba(167,139,250,.18)}
.fld input:-webkit-autofill{-webkit-text-fill-color:#fff;transition:background-color 9999s ease-out 0s;box-shadow:0 0 0 1000px #0d0a2b inset}
.fld input[type=number]{-moz-appearance:textfield}
.fld input[type=number]::-webkit-outer-spin-button,.fld input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}

.card .alert{margin:18px 0 0;padding:14px 18px;border-radius:16px;background:rgba(251,113,133,.06)!important;border:1px solid rgba(251,113,133,.4)!important;color:#fda4af!important;line-height:1.6;word-break:break-word}

.card .row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:30px}
.card .btn{position:relative;display:inline-flex;align-items:center;justify-content:center;padding:13px 28px;border-radius:9999px;border:0;color:#fff;font-weight:800;letter-spacing:.03em;text-decoration:none;cursor:pointer;overflow:hidden;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 16px 40px -14px rgba(236,72,153,.85),0 0 46px -10px rgba(124,58,237,.7);animation:db-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s,border-color .25s,color .25s}
@keyframes db-flow{to{background-position:-300% 0}}
.card .btn:hover{transform:scale(1.05)}
.card .btn:active{transform:scale(.97)}
.card .btn.ghost{background:transparent;color:#d8b4fe;border:1.5px solid rgba(168,85,247,.5);box-shadow:none;animation:none;font-weight:600}
.card .btn.ghost:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 26px -4px rgba(236,72,153,.8)}
.card .btn:disabled{opacity:.7;cursor:wait}
.card .btn.busy::after{content:"";width:14px;height:14px;margin-left:12px;border-radius:50%;border:2px solid rgba(255,255,255,.35);border-top-color:#fff;animation:db-spin .8s linear infinite}
@keyframes db-spin{to{transform:rotate(360deg)}}
.card .btn:focus-visible{outline:2px solid #fff;outline-offset:4px}

@media (max-width:560px){
.f-wide,.f-narrow,.f-half{grid-column:span 6}
.card .row{flex-direction:column-reverse;align-items:stretch}
.card .btn{width:100%}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var items=document.querySelectorAll('.fld');
for(var q=0;q<items.length;q++)items[q].style.setProperty('--i',q);

var form=document.getElementById('db-form'),sb=document.getElementById('db-submit');
if(form&&sb)form.addEventListener('submit',function(){
sb.classList.add('busy');
setTimeout(function(){sb.disabled=true},0)
});

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
var big=W<700,cx=(big?W*.55:W*.8)+mx*16,cy=(big?H*.82:H*.68)+my*10;
var Rg=Math.min(W,H)*(big?.9:.78)*(.6+.4*gF);
var tl=-.5,ct=Math.cos(tl),st=Math.sin(tl);
ctx.globalCompositeOperation='lighter';
var pulse=1+.05*Math.sin(t*1.5);
var gr=ctx.createRadialGradient(cx,cy,0,cx,cy,Rg*.5*pulse);
gr.addColorStop(0,'rgba(255,236,255,'+(.55*gF)+')');
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
var fade=clamp(t/1,0,1);
for(var i=0;i<stars.length;i++){
var s=stars[i];
s.y-=dt*.004*s.z;s.x+=dt*.002*s.z;
if(s.y<-.02){s.y=1.02;s.x=Math.random()}
if(s.x>1.02)s.x=-.02;
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
