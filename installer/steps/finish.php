<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (!file_exists(RJ_LOCK)) {
    header('Location: ' . rj_installer_url('step=install'));
    exit;
}

if (isset($_POST['delete_installer'])) {
    $files = [
        RJ_ROOT . '/public/install.php',
        RJ_ROOT . '/installer/bootstrap.php',
        RJ_ROOT . '/installer/helpers.php',
    ];

    foreach (glob(RJ_ROOT . '/installer/lang/*.php') as $f) {
        $files[] = $f;
    }
    foreach (glob(RJ_ROOT . '/installer/steps/*.php') as $f) {
        $files[] = $f;
    }
    foreach (glob(RJ_ROOT . '/installer/steps/intro/*.php') as $f) {
        $files[] = $f;
    }

    foreach ($files as $f) {
        if (file_exists($f)) {
            @unlink($f);
        }
    }

    @rmdir(RJ_ROOT . '/installer/steps/intro');
    @rmdir(RJ_ROOT . '/installer/steps');
    @rmdir(RJ_ROOT . '/installer/lang');
    @rmdir(RJ_ROOT . '/installer');

    header('Location: /admin');
    exit;
}

$extra = <<<'HTML'
<style>
html,body{min-height:100%;background:#03020a}
body::before{content:"";position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(100% 70% at 50% 30%,#1c1450 0%,#0b0824 55%,#03020a 100%)}
body::after{content:"";position:fixed;inset:-10%;z-index:0;pointer-events:none;background:radial-gradient(70% 45% at 50% 108%,rgba(245,158,11,.4),rgba(236,72,153,.26) 45%,transparent 72%),radial-gradient(35% 30% at 12% 18%,rgba(96,165,250,.18),transparent 70%),radial-gradient(35% 30% at 90% 25%,rgba(167,139,250,.24),transparent 70%);animation:fn-breathe 9s ease-in-out infinite alternate}
@keyframes fn-breathe{from{opacity:.8;transform:scale(1)}to{opacity:1;transform:scale(1.06)}}
#fnSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}
#fnFlash{position:fixed;inset:0;z-index:60;pointer-events:none;background:radial-gradient(circle at 50% 38%,#fff 0%,#ffe9fb 30%,#c4b5fd 70%,#4c1d95 100%);animation:fn-flash 2.1s .05s ease-out forwards}
@keyframes fn-flash{0%,30%{opacity:1}99%{opacity:0;visibility:visible}100%{opacity:0;visibility:hidden}}

.card{position:relative!important;z-index:2;background:none!important;border:0!important;box-shadow:none!important;-webkit-backdrop-filter:none!important;backdrop-filter:none!important;overflow:visible!important}
.card::before{content:"";position:absolute;inset:-10% -16%;z-index:-1;pointer-events:none;background:radial-gradient(closest-side,rgba(4,3,14,.72),transparent)}
.brand-logo{filter:drop-shadow(0 0 20px rgba(167,139,250,.55));animation:fn-rise .9s .9s cubic-bezier(.2,.8,.2,1) both}
.card h1{background:linear-gradient(90deg,#fff 0%,#e9d5ff 45%,#f9a8d4 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:#fff;font-weight:800;filter:drop-shadow(0 0 22px rgba(167,139,250,.4));animation:fn-rise .9s 1s cubic-bezier(.2,.8,.2,1) both}
.card p.sub{color:#b4bad4!important;animation:fn-rise .9s 1.1s cubic-bezier(.2,.8,.2,1) both}
@keyframes fn-rise{from{opacity:0;transform:translateY(18px);filter:blur(6px)}to{opacity:1;transform:none;filter:none}}

.fn-emblem{position:relative;width:132px;height:132px;margin:26px auto 22px;display:grid;place-items:center;animation:fn-pop 1s .85s cubic-bezier(.2,1.4,.4,1) both}
@keyframes fn-pop{from{transform:scale(0) rotate(-40deg);opacity:0}to{transform:none;opacity:1}}
.fn-emblem svg{position:relative;z-index:1;width:100%;height:100%;overflow:visible;filter:drop-shadow(0 0 18px rgba(244,114,182,.8)) drop-shadow(0 0 40px rgba(167,139,250,.55))}
.fn-d{fill:rgba(167,139,250,.14);animation:fn-appear 1s 2.3s both}
.fn-c{fill:none;stroke:url(#fnG);stroke-width:3.5;stroke-linecap:round;stroke-dasharray:327;stroke-dashoffset:327;transform:rotate(-90deg);transform-origin:60px 60px;animation:fn-draw 1.2s 1.3s cubic-bezier(.6,.1,.2,1) forwards}
.fn-k{fill:none;stroke:#fff;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:80;stroke-dashoffset:80;animation:fn-draw .6s 2.35s cubic-bezier(.6,.1,.2,1) forwards}
@keyframes fn-draw{to{stroke-dashoffset:0}}
@keyframes fn-appear{from{opacity:0}to{opacity:1}}
.fn-o1,.fn-o2{position:absolute;border-radius:50%;border:1px solid rgba(168,85,247,.3);opacity:0}
.fn-o1{inset:-16px;animation:fn-spin 6s linear infinite,fn-appear 1s 2.5s forwards}
.fn-o2{inset:-30px;border-color:rgba(244,114,182,.22);animation:fn-spin 10s linear infinite reverse,fn-appear 1s 2.7s forwards}
.fn-o1::after,.fn-o2::after{content:"";position:absolute;inset:-1px;border-radius:50%;background:radial-gradient(circle at 50% 0%,#fff 0 2.5px,rgba(252,211,77,.85) 3px,transparent 6px)}
.fn-o2::after{background:radial-gradient(circle at 50% 0%,#fff 0 2px,rgba(244,114,182,.85) 2.5px,transparent 5.5px)}
@keyframes fn-spin{to{transform:rotate(360deg)}}
.fn-emblem::after{content:"";position:absolute;inset:-4px;border-radius:50%;border:1.5px solid rgba(252,211,77,.5);opacity:0;animation:fn-halo 3s 2.8s ease-out infinite}
@keyframes fn-halo{0%{transform:scale(.8);opacity:.9}100%{transform:scale(2.1);opacity:0}}

.fn-title{margin:0 0 10px;font-size:24px;font-weight:800;line-height:1.3;text-align:center;letter-spacing:.01em;background:linear-gradient(100deg,#fde68a 0%,#f9a8d4 35%,#c4b5fd 65%,#fde68a 100%);background-size:200% 100%;-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;animation:fn-rise .9s 2.2s cubic-bezier(.2,.8,.2,1) both,fn-shine 5s 3s linear infinite}
@keyframes fn-shine{to{background-position:-200% 0}}
.fn-sub{margin:0 auto;max-width:420px;color:#d8b4fe;font-size:14px;line-height:1.7;text-align:center;animation:fn-rise .9s 2.35s cubic-bezier(.2,.8,.2,1) both}

.fn-s{animation:fn-rise .85s cubic-bezier(.2,.8,.2,1) both}
.fn-d1{animation-delay:2.6s}
.fn-d2{animation-delay:2.75s}
.fn-d3{animation-delay:2.95s}
.fn-d4{animation-delay:3.1s}

.fn-actions{display:flex;flex-direction:column;gap:14px;margin-top:32px}
.fn-go{position:relative;display:block;padding:2px;border-radius:9999px;overflow:hidden;isolation:isolate;text-decoration:none;color:#fff;font-size:16px;font-weight:800;letter-spacing:.04em;text-align:center;box-shadow:0 0 44px -10px rgba(245,158,11,.8);transition:transform .35s cubic-bezier(.2,.9,.3,1.3)}
.fn-go::before{content:"";position:absolute;z-index:0;inset:-150%;background:conic-gradient(from 0deg,transparent 0 50%,#fde68a,#f59e0b,#f472b6,#a78bfa,transparent);animation:fn-spin 3s linear infinite}
.fn-go span{position:relative;z-index:1;display:block;padding:17px 32px;border-radius:9999px;background:linear-gradient(90deg,#0a0722 50%,#7c3aed 50%,#ec4899 80%,#f59e0b 100%);background-size:200% 100%;background-position:0 0;transition:background-position .7s cubic-bezier(.2,.8,.2,1)}
.fn-go:hover span,.fn-go:focus-visible span{background-position:100% 0}
.fn-go:hover{transform:scale(1.04)}
.fn-go:active{transform:scale(.97)}
.fn-go:focus-visible{outline:2px solid #fff;outline-offset:4px}

.fn-ghost{position:relative;display:block;padding:14px 28px;border-radius:9999px;overflow:hidden;border:1.5px solid rgba(168,85,247,.5);color:#d8b4fe;font-size:15px;font-weight:600;text-decoration:none;text-align:center;transition:color .3s,border-color .3s,box-shadow .3s,transform .3s cubic-bezier(.2,.9,.3,1.3)}
.fn-ghost::before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(168,85,247,.28),rgba(236,72,153,.28));transform:translateX(-101%);transition:transform .5s cubic-bezier(.2,.8,.2,1)}
.fn-ghost span{position:relative}
.fn-ghost:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 28px -4px rgba(236,72,153,.75);transform:scale(1.03)}
.fn-ghost:hover::before{transform:none}
.fn-ghost:focus-visible{outline:2px solid #fff;outline-offset:4px}

.fn-danger{position:relative;margin-top:34px;padding-top:24px;text-align:center}
.fn-danger::before{content:"";position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(248,113,113,.5),transparent)}
.fn-note{margin:0 0 14px;color:#9ca3af;font-size:13px;line-height:1.6}
.fn-del{position:relative;display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:13px 24px;border-radius:9999px;overflow:hidden;border:1.5px dashed rgba(248,113,113,.6);background:transparent;color:#fca5a5;font-family:inherit;font-size:14px;font-weight:600;cursor:pointer;transition:color .3s,border-color .3s,box-shadow .3s,background .3s}
.fn-del svg{flex:none;transition:transform .4s cubic-bezier(.2,.9,.3,1.3)}
.fn-del:hover{color:#fff;border-style:solid;border-color:#ef4444;background:rgba(239,68,68,.16);box-shadow:0 0 30px -4px rgba(239,68,68,.75)}
.fn-del:hover svg{transform:rotate(-14deg) scale(1.15)}
.fn-del:focus-visible{outline:2px solid #fff;outline-offset:4px}
.fn-del.arming{pointer-events:none;color:#fff;border-style:solid;border-color:#ef4444;background:rgba(239,68,68,.35);animation:fn-shake .12s linear infinite}
@keyframes fn-shake{0%{transform:translateX(-2px)}50%{transform:translateX(2px)}100%{transform:translateX(-2px)}}

@media (max-width:560px){
.fn-title{font-size:21px}
.fn-emblem{width:116px;height:116px}
}
@media (prefers-reduced-motion:reduce){
#fnFlash{display:none}
.fn-c,.fn-k{animation:none;stroke-dashoffset:0}
.fn-o1,.fn-o2{animation:none;opacity:1}
.fn-emblem::after,.fn-go::before,body::after,.fn-title{animation:none}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var shocks=[],sparks=[],embers=[],bg=[];
var W=0,H=0,dpr=1,mx=0,my=0,tmx=0,tmy=0,lastT=0,running=true,T0=performance.now(),boom=false,pop=false,nextFw=3.4;
var em={x:0,y:0};
var warm=['255,236,170','252,211,77','249,168,212','244,114,182','196,181,253','255,255,255'];
var scols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}
function burst(x,y,n,spd,g,life,cols){
if(sparks.length>2200)return;
for(var i=0;i<n;i++){
var a=rnd(0,6.2832),s=spd*(.2+Math.random()*.8),l=life*(.6+Math.random()*.6);
sparks.push({x:x,y:y,vx:Math.cos(a)*s,vy:Math.sin(a)*s,g:g,l:l,m:l,w:rnd(.8,2.2),c:cols[(Math.random()*cols.length)|0]})
}
}
function ring(x,y,m,d,c,delay){shocks.push({x:x,y:y,t:performance.now()+(delay||0),d:d,m:m,c:c})}

var del=document.getElementById('fn-del'),dform=document.getElementById('fn-del-form');
if(del&&dform)del.addEventListener('click',function(){
if(!window.confirm(del.getAttribute('data-confirm')))return;
var r=del.getBoundingClientRect(),x=r.left+r.width/2,y=r.top+r.height/2;
del.classList.add('arming');
ring(x,y,Math.max(W,H)*.7,1000,'248,113,113');
burst(x,y,90,520,200,1.2,['248,113,113','254,202,202','239,68,68','255,255,255']);
setTimeout(function(){dform.submit()},750)
});

document.addEventListener('click',function(e){
var b=e.target.closest&&e.target.closest('.fn-go,.fn-ghost');
if(!b)return;
var r=b.getBoundingClientRect(),x=r.left+r.width/2,y=r.top+r.height/2;
ring(x,y,Math.max(W,H)*.6,1200,'244,114,182');
ring(x,y,Math.max(W,H)*.6,1400,'252,211,77',160);
burst(x,y,50,420,120,1.2,warm)
});

try{
var cv=document.createElement('canvas');cv.id='fnSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var emEl=document.getElementById('fnEmblem');

function getEm(){
if(emEl){var r=emEl.getBoundingClientRect();em.x=r.left+r.width/2;em.y=r.top+r.height/2}
else{em.x=W*.5;em.y=H*.3}
}
function build(){
bg=[];
var n=Math.round(clamp(W*H/5000,110,320));
for(var i=0;i<n;i++)bg.push({x:Math.random(),y:Math.random(),z:Math.random()*1.2+.2,r:rnd(.3,1.1),ph:rnd(0,6.28),sp:rnd(.4,1.6),c:scols[(Math.random()*scols.length)|0]});
embers=[];
var m=W<700?36:72;
for(i=0;i<m;i++)embers.push({x:Math.random()*W,y:Math.random()*H,vy:rnd(14,52),sw:rnd(8,38),ph:rnd(0,6.28),r:rnd(.8,2.4),c:warm[(Math.random()*4)|0]})
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
build()
}
function drawBg(t){
var fade=clamp(t/.8,0,1);
for(var i=0;i<bg.length;i++){
var s=bg[i];
ctx.globalAlpha=fade*(.2+.6*(.5+.5*Math.sin(t*s.sp+s.ph)));
ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(s.x*W+mx*s.z*12,s.y*H+my*s.z*8,s.r,0,6.283);ctx.fill()
}
ctx.globalAlpha=1
}
function drawRays(t){
var f=easeOut(clamp((t-.9)/1.8,0,1))*(.75+.25*Math.sin(t*.9));
if(f<=0)return;
ctx.globalCompositeOperation='lighter';
var R=Math.max(W,H)*.9;
for(var i=0;i<14;i++){
var a=i*.4488+t*.07,hw=.045+.02*Math.sin(t*.7+i);
var g=ctx.createLinearGradient(em.x,em.y,em.x+Math.cos(a)*R,em.y+Math.sin(a)*R);
g.addColorStop(0,'rgba(255,214,150,'+(.2*f)+')');
g.addColorStop(1,'rgba(255,214,150,0)');
ctx.fillStyle=g;
ctx.beginPath();
ctx.moveTo(em.x,em.y);
ctx.lineTo(em.x+Math.cos(a-hw)*R,em.y+Math.sin(a-hw)*R);
ctx.lineTo(em.x+Math.cos(a+hw)*R,em.y+Math.sin(a+hw)*R);
ctx.closePath();ctx.fill()
}
var gl=ctx.createRadialGradient(em.x,em.y,0,em.x,em.y,230);
gl.addColorStop(0,'rgba(255,224,170,'+(.4*f)+')');
gl.addColorStop(.5,'rgba(244,114,182,'+(.12*f)+')');
gl.addColorStop(1,'rgba(244,114,182,0)');
ctx.fillStyle=gl;ctx.beginPath();ctx.arc(em.x,em.y,230,0,6.283);ctx.fill();
ctx.globalCompositeOperation='source-over'
}
function drawEmbers(t,dt){
ctx.globalCompositeOperation='lighter';
var fade=clamp((t-.6)/1.5,0,1);
for(var i=0;i<embers.length;i++){
var e=embers[i];
e.y-=e.vy*dt;
if(e.y<-10){e.y=H+10;e.x=Math.random()*W}
var x=e.x+Math.sin(t*.6+e.ph)*e.sw;
ctx.globalAlpha=fade*clamp(e.y/H,0,1)*.8*(.6+.4*Math.sin(t*2+e.ph));
ctx.fillStyle='rgb('+e.c+')';
ctx.beginPath();ctx.arc(x,e.y,e.r,0,6.283);ctx.fill()
}
ctx.globalAlpha=1;ctx.globalCompositeOperation='source-over'
}
function drawSparks(dt){
ctx.globalCompositeOperation='lighter';
var k=Math.exp(-1.7*dt);
for(var i=sparks.length-1;i>=0;i--){
var s=sparks[i];
s.vx*=k;s.vy=s.vy*k+s.g*dt;
s.x+=s.vx*dt;s.y+=s.vy*dt;s.l-=dt;
if(s.l<=0){sparks.splice(i,1);continue}
ctx.strokeStyle='rgba('+s.c+','+clamp(s.l/s.m,0,1).toFixed(3)+')';
ctx.lineWidth=s.w;
ctx.beginPath();ctx.moveTo(s.x-s.vx*.035,s.y-s.vy*.035);ctx.lineTo(s.x,s.y);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
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
getEm();
if(!boom&&t>.12){
boom=true;
var big=Math.max(W,H);
burst(em.x,em.y,W<700?260:480,big*1.15,0,2.8,warm);
burst(em.x,em.y,120,big*.35,30,3.4,warm);
ring(em.x,em.y,big*.85,1700,'255,214,150');
ring(em.x,em.y,big*.85,1900,'244,114,182',150);
ring(em.x,em.y,big*.85,2100,'167,139,250',300)
}
if(!pop&&t>2.95){
pop=true;
burst(em.x,em.y,80,340,70,1.7,warm);
ring(em.x,em.y,220,1100,'252,211,77')
}
if(t>nextFw){
nextFw=t+rnd(2.6,4.4);
var fx=rnd(.15,.85)*W,fy=rnd(.08,.45)*H,pair=Math.random()<.5?['252,211,77','255,236,170','255,255,255']:['244,114,182','249,168,212','196,181,253'];
burst(fx,fy,64,300,150,1.8,pair);
ring(fx,fy,70,700,pair[0])
}
ctx.clearRect(0,0,W,H);
drawBg(t);
drawRays(t);
drawEmbers(t,dt);
drawSparks(dt);
drawShocks(performance.now());
requestAnimationFrame(frame)
}catch(e){running=false;cv.style.display='none'}
}
window.addEventListener('pointermove',function(e){tmx=(e.clientX/W-.5)*2;tmy=(e.clientY/H-.5)*2});
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

$emblem = <<<'HTML'
<div class="fn-emblem" id="fnEmblem">
<svg viewBox="0 0 120 120" aria-hidden="true">
<defs><linearGradient id="fnG" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fcd34d"/><stop offset=".5" stop-color="#f472b6"/><stop offset="1" stop-color="#a78bfa"/></linearGradient></defs>
<circle class="fn-d" cx="60" cy="60" r="46"/>
<circle class="fn-c" cx="60" cy="60" r="52"/>
<path class="fn-k" d="M36 62 l17 17 l33 -36"/>
</svg>
<i class="fn-o1"></i><i class="fn-o2"></i>
</div>
HTML;

$trash = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2m2 0v14a2 2 0 01-2 2H8a2 2 0 01-2-2V6m4 5v6m4-6v6"/></svg>';

$body = '<div id="fnFlash"></div>';
$body .= $emblem;
$body .= '<h2 class="fn-title">' . rj_esc($t['ins_done'] ?? 'Installation complete') . '</h2>';
$body .= '<p class="fn-sub">' . rj_esc($t['fin_sub'] ?? '') . '</p>';

$body .= '<div class="fn-actions">';
$body .= '<a href="/admin" class="fn-go fn-s fn-d1"><span>' . rj_esc($t['fin_admin'] ?? 'Go to Admin Panel') . '</span></a>';
$body .= '<a href="/" class="fn-ghost fn-s fn-d2"><span>' . rj_esc($t['fin_frontend'] ?? 'Go to Website') . '</span></a>';
$body .= '</div>';

$body .= '<div class="fn-danger fn-s fn-d3">';
$body .= '<p class="fn-note">' . rj_esc($t['fin_security'] ?? 'For security reasons, please delete the installer files.') . '</p>';
$body .= '<form method="post" id="fn-del-form">';
$body .= '<input type="hidden" name="delete_installer" value="1">';
$body .= '<button type="button" id="fn-del" class="fn-del" data-confirm="' . rj_esc($t['fin_delete_confirm'] ?? 'Are you sure? This will delete the installer files.') . '">' . $trash . '<span>' . rj_esc($t['fin_delete_btn'] ?? 'Delete Installer Files') . '</span></button>';
$body .= '</form>';
$body .= '</div>';

rj_render('finish', $body, $extra);
exit;
