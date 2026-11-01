<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if (empty($state['lang'])) {
    header('Location: ' . rj_installer_url('step=language'));
    exit;
}

$logoRjCms   = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-cms/rj%20cms%20transparent.png';
$logoRjAi    = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-cms/rj%20cms%20ai%20transparent.png';
$logoRjShop  = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-shop/rj%20shop%20transparent.png';
$logoRjCloud = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/web_panels/rj_cloud/rj%20cloud_transparent.png';
$logoNexus   = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/cms/rj-nexus/logo_header.png';

$desc = $t['eco_desc'] ?? 'Welcome to the new era of RJ CMS. Whether you are migrating from a legacy version or starting fresh, RJ Nexus is your new open-source home. When your business grows, seamlessly scale to our premium ecosystems.';
$arrow = '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$back = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$body = '<div class="eco" id="ecoStage" data-p="0">'
    // ---------- panel 1: ecosystem map ----------
    . '<section class="panel p1" id="ecoP1"><div class="fit" id="ecoFit">'
    . '<p class="eco-desc">' . rj_esc($desc) . '</p>'
    . '<div class="eco-flow" id="ecoFlow"><canvas id="ecoLines"></canvas>'
    . '<div class="node legacy"><img src="' . $logoRjCms . '" alt="RJ CMS 5.1"><b>RJ CMS 5.1</b><span>Legacy</span></div>'
    . '<div class="node core"><i class="halo"></i><img src="' . $logoNexus . '" alt="RJ Nexus"><b>RJ NEXUS</b><span>Open Source</span></div>'
    . '<div class="premium">'
    . '<div class="node pnode"><img src="' . $logoRjAi . '" alt="RJ CMS AI"><em>RJ CMS AI</em></div>'
    . '<div class="node pnode"><img src="' . $logoRjShop . '" alt="RJ Shop"><em>RJ Shop</em></div>'
    . '<div class="node pnode"><img src="' . $logoRjCloud . '" alt="RJ Cloud"><em>RJ Cloud</em></div>'
    . '</div></div>'
    . '<div class="eco-tags">'
    . '<span class="tag t1"><i></i>' . rj_esc($t['eco_migrate'] ?? 'Free Migration') . '</span>'
    . '<span class="tag t2"><i></i>' . rj_esc($t['eco_upgrade'] ?? 'Premium Upgrade') . '</span>'
    . '</div></div>'
    . '<button type="button" class="hint" id="ecoHint"><span class="mouse"><i></i></span><span>' . rj_esc($t['scroll'] ?? 'Scroll') . '</span></button>'
    . '</section>'
    // ---------- panel 2: next ----------
    . '<section class="panel p2" id="ecoP2">'
    . '<i class="streak" style="--sy:38%;--sd:.15s"></i><i class="streak" style="--sy:46%;--sd:.05s"></i><i class="streak" style="--sy:54%;--sd:.22s"></i><i class="streak" style="--sy:62%;--sd:.1s"></i>'
    . '<div class="go-wrap" id="ecoWrap"><b class="ring r1"></b><b class="ring r2"></b>'
    . '<span class="orbit o1"><i></i></span><span class="orbit o2"><i></i></span>'
    . '<a id="ecoGo" class="go" href="' . rj_installer_url('step=intro&slide=1') . '"><span class="go-t">' . rj_esc($t['next'] ?? 'Continue') . '</span><span class="arr">' . $arrow . '</span></a></div>'
    . '<button type="button" class="back" id="ecoBack" aria-label="Back">' . $back . '</button>'
    . '</section>'
    . '</div>';

$extra = <<<'HTML'
<noscript><style>.card{position:static!important;transform:none!important;pointer-events:auto!important}.brand-logo,.card p.sub,.steps{opacity:1!important;animation:none!important}.eco{position:static!important;overflow:visible!important}.panel{position:static!important;visibility:visible!important;opacity:1!important;transform:none!important;padding:0!important}.node,.tag,.eco-desc,.go{animation:none!important}#ecoLines,.hint,.back,.streak{display:none}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;overscroll-behavior:none}
body{display:block;padding:0;min-height:100vh}
html,body,.card,.eco{-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
::selection{background:transparent;color:inherit}
img{-webkit-user-drag:none;user-drag:none}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 2.4s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(18px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.28),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.22),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.2),transparent 70%);animation:rj-neb 22s ease-in-out infinite alternate,rj-bg 3s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-4%,1%,0) rotate(0) scale(1)}to{transform:translate3d(4%,-3%,0) rotate(12deg) scale(1.18)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

/* header (same as language step) */
.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(56px,10vh,92px);width:auto;margin:0 auto 6px;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(167,139,250,.55));animation:rj-logo 1.5s .6s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-logo{from{opacity:0;transform:translateY(10px) scale(.82);filter:blur(14px) drop-shadow(0 0 22px rgba(167,139,250,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.55))}}
.card h1{display:none}
.card p.sub{text-align:center;margin-bottom:0;opacity:0;animation:rj-up 1s 1.1s both}
.steps{justify-content:center;margin:10px 0 2px;opacity:0;animation:rj-up 1s 1.3s both}
.steps .line{flex:0 0 26px}
@keyframes rj-up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}

/* stage + sliding panels */
.eco{position:fixed;inset:0;z-index:3;overflow:hidden;touch-action:none}
.panel{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;transition:transform .95s cubic-bezier(.7,0,.2,1),opacity .7s ease,visibility 0s 0s}
.p1{justify-content:flex-start}
.p2{justify-content:center;transform:translateX(70vw);opacity:0;visibility:hidden;transition:transform .95s cubic-bezier(.7,0,.2,1),opacity .7s ease,visibility 0s .95s}
.eco[data-p="1"] .p1{transform:translateX(-45vw) scale(.96);opacity:0;visibility:hidden;pointer-events:none;transition:transform .95s cubic-bezier(.7,0,.2,1),opacity .6s ease,visibility 0s .95s}
.eco[data-p="1"] .p2{transform:none;opacity:1;visibility:visible;transition:transform .95s cubic-bezier(.7,0,.2,1),opacity .7s ease,visibility 0s 0s}

.fit{width:min(100%,880px);padding:0 18px;transform-origin:top center}
.eco-desc{max-width:600px;text-align:center;font-size:14px;line-height:1.65;color:#b4bad4;margin:0 auto;text-shadow:0 2px 14px rgba(5,4,15,.95);animation:rj-up 1s 1.4s backwards}
.eco-flow{position:relative;display:grid;grid-template-columns:1fr 1.15fr 1fr;align-items:center;gap:clamp(48px,9vw,120px);width:100%;margin:30px auto 8px}
#ecoLines{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:0}
.node{position:relative;z-index:1;text-align:center;padding:16px 14px;border-radius:20px;background:rgba(24,16,58,.66);border:1px solid rgba(168,85,247,.3);-webkit-backdrop-filter:blur(12px);backdrop-filter:blur(12px);box-shadow:0 16px 38px -18px rgba(110,80,240,.8);animation:rj-pop .95s var(--d,0s) cubic-bezier(.2,.9,.25,1.15) backwards;transition:transform .3s,border-color .3s,box-shadow .3s}
.node img{display:block;margin:0 auto 8px;max-width:100%;-webkit-user-drag:none}
.node b{display:block;font-size:12px;font-weight:800;letter-spacing:.08em}
.node span{display:block;font-size:10px;margin-top:2px}
@keyframes rj-pop{0%{opacity:0;transform:translate(var(--fx,0px),40px) scale(.8);filter:blur(8px)}60%{filter:blur(0)}100%{opacity:1;transform:none;filter:blur(0)}}
.legacy{--d:1.7s;--fx:-80px}
.legacy img{height:34px;opacity:.7;filter:grayscale(100%)}
.legacy b{color:#9ca3af}.legacy span{color:#6b7280}
.core{padding:24px 18px;border-color:#a855f7;background:linear-gradient(160deg,rgba(124,58,237,.38),rgba(236,72,153,.22));box-shadow:0 0 50px -8px rgba(168,85,247,.8),0 18px 40px -18px rgba(236,72,153,.6);animation:rj-core 1.1s 2.9s cubic-bezier(.2,.9,.25,1.1) backwards}
@keyframes rj-core{0%{opacity:0;transform:scale(.4);filter:blur(12px) brightness(2.2)}55%{opacity:1;transform:scale(1.1);filter:blur(0) brightness(1.5)}100%{opacity:1;transform:none;filter:none}}
.core img{height:46px;margin-bottom:10px}
.core b{color:#e9d5ff;font-size:13px}.core span{color:#d8b4fe}
.core .halo{position:absolute;inset:-1px;border-radius:20px;pointer-events:none;animation:rj-ring 2.8s 4s ease-out infinite}
@keyframes rj-ring{0%{box-shadow:0 0 0 0 rgba(236,72,153,.5)}100%{box-shadow:0 0 0 24px rgba(236,72,153,0)}}
.premium{display:flex;flex-direction:column;gap:12px}
.pnode{padding:12px 10px;--fx:80px}
.pnode:nth-child(1){--d:4s}.pnode:nth-child(2){--d:4.15s}.pnode:nth-child(3){--d:4.3s}
.pnode img{height:24px;margin-bottom:6px;opacity:.92}
.pnode em{display:block;font-style:normal;font-size:11px;color:#c4b5fd}
.pnode:hover{transform:translateY(-3px);border-color:#ec4899;box-shadow:0 18px 40px -12px rgba(236,72,153,.7)}
.eco-tags{display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-top:22px}
.tag{display:inline-flex;align-items:center;gap:8px;font-size:11px;letter-spacing:.04em;color:#d1d5db;padding:7px 14px;border-radius:9999px;background:rgba(24,16,58,.6);border:1px solid rgba(168,85,247,.28);animation:rj-up .9s backwards}
.tag i{width:7px;height:7px;border-radius:50%;background:#a78bfa;box-shadow:0 0 10px #a78bfa}
.t1{animation-delay:4.7s}.t2{animation-delay:4.85s}.t2 i{background:#f472b6;box-shadow:0 0 10px #f472b6}

/* scroll hint */
.hint{position:absolute;left:50%;bottom:clamp(14px,4vh,34px);transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:8px;background:none;border:0;color:#c4b5fd;font-family:inherit;font-weight:600;font-size:11px;line-height:1;letter-spacing:.22em;text-transform:uppercase;cursor:pointer;animation:rj-hint 1s 5.2s backwards,rj-bob 2.2s 6.2s ease-in-out infinite}
@keyframes rj-hint{from{opacity:0;transform:translate(-50%,14px)}to{opacity:1;transform:translate(-50%,0)}}
@keyframes rj-bob{50%{transform:translate(-50%,6px)}}
.mouse{width:20px;height:31px;border:1.5px solid rgba(196,181,253,.7);border-radius:12px;position:relative;display:block}
.mouse i{position:absolute;left:50%;top:6px;width:3px;height:7px;margin-left:-1.5px;border-radius:2px;background:#fff;animation:rj-wheel 1.6s ease-in-out infinite}
@keyframes rj-wheel{0%{opacity:0;transform:translateY(0)}30%{opacity:1}100%{opacity:0;transform:translateY(10px)}}

/* panel 2: next button */
.streak{position:absolute;top:var(--sy);left:100%;width:280px;height:2px;border-radius:2px;background:linear-gradient(90deg,transparent,rgba(244,114,182,.9),#fff);opacity:0;pointer-events:none}
.eco[data-p="1"] .streak{animation:rj-streak 1.1s var(--sd) cubic-bezier(.2,.7,.2,1) backwards}
@keyframes rj-streak{0%{opacity:0;transform:translateX(0)}20%{opacity:1}100%{opacity:0;transform:translateX(calc(-100vw - 360px))}}
.go-wrap{position:relative;display:inline-block;transform:translate(var(--mx,0px),var(--my,0px));transition:transform .25s ease-out}
.go{position:relative;display:inline-flex;align-items:center;gap:18px;padding:18px 26px 18px 44px;border-radius:9999px;overflow:hidden;color:#fff;text-decoration:none;font-size:20px;font-weight:800;letter-spacing:.04em;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 20px 50px -14px rgba(236,72,153,.85),0 0 60px -6px rgba(124,58,237,.7);animation:rj-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s}
.eco[data-p="1"] .go{animation:rj-goin 1.1s .3s cubic-bezier(.2,.9,.25,1.15) backwards,rj-flow 6s linear infinite}
@keyframes rj-goin{0%{opacity:0;transform:translateX(220px) skewX(-18deg) scale(.7);filter:blur(10px)}60%{filter:blur(0)}100%{opacity:1;transform:none}}
@keyframes rj-flow{to{background-position:-300% 0}}
.go::after{content:"";position:absolute;top:0;bottom:0;left:-40%;width:30%;transform:skewX(-22deg);background:linear-gradient(90deg,transparent,rgba(255,255,255,.55),transparent);animation:rj-shine 3s 1.2s ease-in-out infinite}
@keyframes rj-shine{0%{left:-40%}55%,100%{left:130%}}
.go .arr{display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.95);color:#7c3aed;box-shadow:0 6px 18px -4px rgba(0,0,0,.45);animation:rj-nudge 1.6s ease-in-out infinite}
@keyframes rj-nudge{50%{transform:translateX(6px)}}
.go:hover{transform:scale(1.07);box-shadow:0 0 0 1px rgba(255,255,255,.4) inset,0 26px 64px -12px rgba(236,72,153,1),0 0 90px -4px rgba(168,85,247,.95)}
.go:active{transform:scale(.97)}
.go:focus-visible{outline:2px solid #fff;outline-offset:4px}
.ring{position:absolute;inset:0;border-radius:9999px;border:1.5px solid rgba(244,114,182,.7);pointer-events:none;opacity:0;animation:rj-expand 2.6s ease-out infinite}
.r2{animation-delay:1.3s;border-color:rgba(167,139,250,.7)}
@keyframes rj-expand{0%{opacity:.9;transform:scale(1)}100%{opacity:0;transform:scale(1.6,2.1)}}
.orbit{position:absolute;left:50%;top:50%;width:0;height:0;transform:scaleY(.4);pointer-events:none}
.orbit i{position:absolute;left:0;top:0;width:8px;height:8px;margin:-4px;border-radius:50%;background:#fff;box-shadow:0 0 14px 3px rgba(244,114,182,.9);animation:rj-orb 5.5s linear infinite;--rx:190px}
.o2 i{--rx:150px;animation-duration:4s;animation-direction:reverse;background:#c4b5fd;box-shadow:0 0 14px 3px rgba(167,139,250,.9)}
@keyframes rj-orb{from{transform:rotate(0) translateX(var(--rx))}to{transform:rotate(360deg) translateX(var(--rx))}}
.back{position:absolute;left:50%;bottom:clamp(18px,5vh,44px);transform:translateX(-50%);width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#c4b5fd;background:rgba(24,16,58,.6);border:1px solid rgba(168,85,247,.35);cursor:pointer;transition:.25s}
.back:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 24px -2px rgba(236,72,153,.8)}

/* leave wipe */
.rj-wipe{position:fixed;inset:0;z-index:30;pointer-events:none;background:radial-gradient(circle at var(--wx,50%) var(--wy,50%),#fff 0%,#e9d5ff 30%,#a78bfa 62%,#7c3aed 100%);clip-path:circle(0% at var(--wx,50%) var(--wy,50%));transition:clip-path .8s cubic-bezier(.65,0,.25,1)}
.rj-wipe.on{clip-path:circle(150% at var(--wx,50%) var(--wy,50%))}

/* JS failure fallback */
.rj-fb *{animation:none!important}
.rj-fb .brand-logo,.rj-fb .card p.sub,.rj-fb .steps{opacity:1!important}
.rj-fb #ecoLines,.rj-fb #rjSky,.rj-fb .hint,.rj-fb .back,.rj-fb .streak{display:none}
.rj-fb .eco{overflow:auto;padding-top:200px}
.rj-fb .panel{position:relative;inset:auto;transform:none!important;opacity:1!important;visibility:visible!important}

@media (max-width:720px){
.eco-flow{grid-template-columns:1fr;gap:54px;max-width:420px}
.premium{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.pnode{--fx:0px}
.legacy{--fx:0px}
.pnode img{height:20px}
.pnode em{font-size:10px}
.go{font-size:18px;padding:16px 22px 16px 36px}
}
@media (max-height:520px){
.card p.sub,.steps{display:none}.card{top:8px}.brand-logo{height:36px;margin-bottom:2px}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('ecoStage');
if(!stage)return;
var running=true;
function fallback(){running=false;document.body.classList.add('rj-fb')}
try{
var INTRO=5.2;
var card=document.querySelector('.card');
var flow=document.getElementById('ecoFlow'),lc=document.getElementById('ecoLines'),lctx=lc.getContext('2d');
var fit=document.getElementById('ecoFit'),p1=document.getElementById('ecoP1'),p2=document.getElementById('ecoP2');
var go=document.getElementById('ecoGo'),wrap=document.getElementById('ecoWrap'),backBtn=document.getElementById('ecoBack'),hint=document.getElementById('ecoHint');
document.body.appendChild(stage);
document.addEventListener('selectstart',function(e){e.preventDefault()});
document.addEventListener('dragstart',function(e){e.preventDefault()});

function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}

/* ---------- canvas background: stars + moving galaxy ---------- */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,stars=[],gal=[],galW=0,shoots=[],nextShoot=2.2,shocks=[],bornShock=false;
var gT=0,extra=0,camX=0,camT=0,mx=0,my=0,tmx=0,tmy=0,lastT=0;
var scols=['#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];

function buildGalaxy(){
gal=[];
var n=W<700?620:1050,i,r,ang,arm;
for(i=0;i<n;i++){
arm=i%3;r=Math.pow(Math.random(),.55);
ang=arm*2.0944+r*3.7+rnd(-.34,.34)*(1-r*.35);
gal.push({r:r,a:ang,s:rnd(.6,1.8),o:rnd(.35,1),c:r<.2?'#fff4e6':(r<.5?(Math.random()<.5?'#f9a8d4':'#e9d5ff'):(Math.random()<.5?'#a5b4fc':'#c4b5fd'))})
}
for(i=0;i<170;i++){
r=Math.pow(Math.random(),2)*.24;
gal.push({r:r,a:rnd(0,6.283),s:rnd(.7,2),o:rnd(.5,1),c:'#fff4e6'})
}
galW=W
}
function drawGalaxy(t,dt){
var gF=easeOut(clamp((t-.1)/2.4,0,1));
var boost=5*Math.pow(1-clamp(t/3.4,0,1),2)+extra;
extra*=Math.pow(.97,dt*60);
gT+=dt*(1+boost);
camX+=(camT-camX)*(1-Math.pow(.93,dt*60));
var cx=W/2+camX+mx*18,cy=H*.54+my*12;
var Rg=Math.min(W*.4,H*.62)*(.4+.6*gF);
var tl=-.33,ct=Math.cos(tl),st=Math.sin(tl);
ctx.globalCompositeOperation='lighter';
var g=ctx.createRadialGradient(cx,cy,0,cx,cy,Rg*.55);
g.addColorStop(0,'rgba(255,236,255,'+(.5*gF)+')');
g.addColorStop(.3,'rgba(190,150,255,'+(.2*gF)+')');
g.addColorStop(1,'rgba(90,70,200,0)');
ctx.fillStyle=g;ctx.beginPath();ctx.arc(cx,cy,Rg*.55,0,6.283);ctx.fill();
for(var i=0;i<gal.length;i++){
var p=gal[i],om=.2/(.22+p.r),a=p.a+gT*om;
var x=Math.cos(a)*p.r*Rg,y=Math.sin(a)*p.r*Rg*.42;
var X=cx+x*ct-y*st,Y=cy+x*st+y*ct;
ctx.globalAlpha=p.o*(1-p.r*.55)*gF*.9;
ctx.fillStyle=p.c;
var sz=p.s*(1.25-p.r*.45);
ctx.fillRect(X,Y,sz,sz)
}
ctx.globalAlpha=1;ctx.globalCompositeOperation='source-over'
}
function drawStars(t){
var fade=clamp(t/1.2,0,1);
for(var i=0;i<stars.length;i++){
var s=stars[i];
s.y-=s.sp;s.x+=s.sx;
if(s.y<-.02){s.y=1.02;s.x=Math.random()}
if(s.x<-.02)s.x=1.02;
ctx.globalAlpha=fade*(.3+.6*(.5+.5*Math.sin(t*1.5+s.ph)));
ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(s.x*W+mx*s.z*14,s.y*H+my*s.z*9,s.r,0,6.283);ctx.fill()
}
ctx.globalAlpha=1
}
function drawShoots(t){
if(t>nextShoot){
var k=Math.random()<.35?2:1;
for(var q=0;q<k;q++)shoots.push({x:rnd(.25,1)*W,y:rnd(-.05,.4)*H,vx:-rnd(8,12),vy:rnd(4,6.5),l:0});
nextShoot=t+rnd(2.2,4.5)
}
for(var j=shoots.length-1;j>=0;j--){
var s=shoots[j];
s.x+=s.vx;s.y+=s.vy;s.l+=.018;
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
ctx.strokeStyle='rgba('+sh.c+','+(a*.75).toFixed(3)+')';ctx.lineWidth=1.5+a*4;
ctx.beginPath();ctx.arc(sh.x,sh.y,40+(sh.m-40)*e,0,6.283);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
}
var fitScale=1;
function coreCenter(){
var fr=flow.getBoundingClientRect(),c=flow.querySelector('.core');
return[fr.left+(c.offsetLeft+c.offsetWidth/2)*fitScale,fr.top+(c.offsetTop+c.offsetHeight/2)*fitScale]
}
function blast(){
var c=coreCenter(),n=performance.now(),m=Math.max(W,H)*.75;
shocks.push({t:n,d:1500,m:m,c:'255,255,255',x:c[0],y:c[1]});
shocks.push({t:n+120,d:1900,m:m*.85,c:'167,139,250',x:c[0],y:c[1]});
shocks.push({t:n+240,d:2300,m:m*.65,c:'244,114,182',x:c[0],y:c[1]});
extra=Math.max(extra,3)
}

/* ---------- ecosystem lines ---------- */
var edges=[],FW=0,FH=0;
function box(el){return{l:el.offsetLeft,t:el.offsetTop,r:el.offsetLeft+el.offsetWidth,b:el.offsetTop+el.offsetHeight,cx:el.offsetLeft+el.offsetWidth/2,cy:el.offsetTop+el.offsetHeight/2}}
function mkEdge(a,b){
var A=box(a),B=box(b),h;
if(B.l>A.r-6){h=(B.l-A.r)*.5;return[[A.r,A.cy],[A.r+h,A.cy],[B.l-h,B.cy],[B.l,B.cy]]}
if(B.r<A.l+6){h=(A.l-B.r)*.5;return[[A.l,A.cy],[A.l-h,A.cy],[B.r+h,B.cy],[B.r,B.cy]]}
h=(B.t-A.b)*.5;
return[[A.cx,A.b],[A.cx,A.b+h],[B.cx,B.t-h],[B.cx,B.t]]
}
function bez(p,u){
var v=1-u,a=v*v*v,b=3*v*v*u,c=3*v*u*u,d=u*u*u;
return[a*p[0][0]+b*p[1][0]+c*p[2][0]+d*p[3][0],a*p[0][1]+b*p[1][1]+c*p[2][1]+d*p[3][1]]
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var n=Math.round(clamp(W*H/5500,90,260));
if(!stars.length||Math.abs(n-stars.length)>30){
stars=[];
for(var i=0;i<n;i++)stars.push({x:Math.random(),y:Math.random(),r:rnd(.4,1.6),ph:rnd(0,6.28),sp:rnd(.00004,.00022),sx:rnd(-.00006,.00006),z:rnd(.3,1.4),c:scols[(Math.random()*scols.length)|0]})
}
if(!gal.length||(galW<700)!==(W<700))buildGalaxy();
camT=stage.getAttribute('data-p')==='1'?-W*.13:0;
var hb=card?card.getBoundingClientRect().bottom:120;
p1.style.paddingTop=(hb+14)+'px';
p2.style.paddingTop=hb+'px';
var availH=H-hb-14-(H<520?54:88);
var nh=fit.offsetHeight,nw=fit.offsetWidth;
var sc=Math.max(.36,Math.min(1,availH/nh,(W-12)/nw));
fitScale=sc;
fit.style.transform='scale('+sc+')';
fit.style.marginTop=Math.max(0,(availH-nh*sc)/2)+'px';
fit.style.marginBottom=(-(nh*(1-sc)))+'px';
FW=flow.offsetWidth;FH=flow.offsetHeight;
lc.width=FW*dpr;lc.height=FH*dpr;
lctx.setTransform(dpr,0,0,dpr,0,0);
var core=flow.querySelector('.core'),legacy=flow.querySelector('.legacy'),pn=flow.querySelectorAll('.pnode');
edges=[{p:mkEdge(legacy,core),s:2.1,d:.9,c:'167,139,250'}];
for(var k=0;k<pn.length;k++)edges.push({p:mkEdge(core,pn[k]),s:3.2+k*.2,d:.85,c:'244,114,182'})
}
function drawLines(t){
lctx.clearRect(0,0,FW,FH);
lctx.globalCompositeOperation='lighter';
for(var i=0;i<edges.length;i++){
var e=edges[i],p=clamp((t-e.s)/e.d,0,1);
if(p<=0)continue;
var pe=1-Math.pow(1-p,3),last=Math.max(2,Math.round(48*pe)),j,q;
for(var w=0;w<2;w++){
lctx.strokeStyle='rgba('+e.c+','+(w?.4:.09)+')';lctx.lineWidth=w?1.7:7;
lctx.beginPath();
for(j=0;j<=last;j++){q=bez(e.p,pe*j/last);if(j===0)lctx.moveTo(q[0],q[1]);else lctx.lineTo(q[0],q[1])}
lctx.stroke()
}
if(p<1){
var hd=bez(e.p,pe);
lctx.fillStyle='rgba('+e.c+',.35)';lctx.beginPath();lctx.arc(hd[0],hd[1],11,0,6.283);lctx.fill();
lctx.fillStyle='rgba(255,255,255,1)';lctx.beginPath();lctx.arc(hd[0],hd[1],3.6,0,6.283);lctx.fill()
}else{
for(var k=0;k<3;k++){
var u=((t-e.s-e.d)*.24+k/3+i*.17)%1,q2=bez(e.p,u<0?u+1:u);
lctx.fillStyle='rgba('+e.c+',.25)';lctx.beginPath();lctx.arc(q2[0],q2[1],7.5,0,6.283);lctx.fill();
lctx.fillStyle='rgba(255,255,255,.95)';lctx.beginPath();lctx.arc(q2[0],q2[1],2.5,0,6.283);lctx.fill()
}
}
}
lctx.globalCompositeOperation='source-over'
}

/* ---------- timeline ---------- */
var T0=performance.now(),off=0;
function tNow(){return(performance.now()-T0)/1000+off}
function skip(){
var t=tNow();
if(t>=INTRO)return;
off+=INTRO-t;
try{
document.getAnimations().forEach(function(a){
try{if(a.effect.getComputedTiming().iterations!==Infinity)a.finish()}catch(e){}
})
}catch(e){}
}
function frame(now){
if(!running)return;
try{
var t=tNow(),dt=Math.min(.1,Math.max(.001,(now-lastT)/1000||.016));
lastT=now;
mx+=(tmx-mx)*.05;my+=(tmy-my)*.05;
if(!bornShock&&t>3.15){bornShock=true;blast()}
ctx.clearRect(0,0,W,H);
drawStars(t);
drawGalaxy(t,dt);
drawShoots(t);
drawShocks(performance.now());
drawLines(t);
requestAnimationFrame(frame)
}catch(err){fallback()}
}

/* ---------- panels: scroll down => slide left, Next arrives from the right ---------- */
var idx=0,lock=false;
function goTo(n){
if(n===idx||lock)return;
idx=n;lock=true;
stage.setAttribute('data-p',String(n));
camT=n?-W*.13:0;
extra=Math.max(extra,2.6);
if(!n){wrap.style.setProperty('--mx','0px');wrap.style.setProperty('--my','0px')}
setTimeout(function(){lock=false},1000)
}
function gate(fn){if(tNow()<INTRO){skip();return}fn()}
window.addEventListener('wheel',function(e){
e.preventDefault();
var v=Math.abs(e.deltaY)>=Math.abs(e.deltaX)?e.deltaY:e.deltaX;
if(Math.abs(v)<12)return;
gate(function(){goTo(v>0?1:0)})
},{passive:false});
window.addEventListener('keydown',function(e){
var k=e.key;
if(tNow()<INTRO&&(k==='Escape'||k==='Enter'||k===' '||k.indexOf('Arrow')===0||k==='PageDown')){skip();return}
if(k==='ArrowDown'||k==='ArrowRight'||k==='PageDown'||(k===' '&&idx===0)){e.preventDefault();goTo(1)}
else if(k==='ArrowUp'||k==='ArrowLeft'||k==='PageUp'){e.preventDefault();goTo(0)}
else if(k==='Enter'&&idx===1){go.click()}
});
var ts=null;
window.addEventListener('touchstart',function(e){var t=e.touches[0];ts=[t.clientX,t.clientY]},{passive:true});
window.addEventListener('touchend',function(e){
if(!ts)return;
var t=e.changedTouches[0],dx=ts[0]-t.clientX,dy=ts[1]-t.clientY;
ts=null;
if(Math.abs(dx)<44&&Math.abs(dy)<44)return;
var v=Math.abs(dy)>=Math.abs(dx)?dy:dx;
gate(function(){goTo(v>0?1:0)})
},{passive:true});
hint.addEventListener('click',function(){gate(function(){goTo(1)})});
backBtn.addEventListener('click',function(){goTo(0)});
window.addEventListener('pointerdown',function(e){
if(e.target.closest&&e.target.closest('#ecoGo,#ecoHint,#ecoBack'))return;
skip()
});
/* parallax + magnetic Next button */
window.addEventListener('pointermove',function(e){
tmx=(e.clientX/W-.5)*2;tmy=(e.clientY/H-.5)*2;
if(idx!==1)return;
var r=wrap.getBoundingClientRect(),cx=r.left+r.width/2-(parseFloat(wrap.style.getPropertyValue('--mx'))||0),cy=r.top+r.height/2-(parseFloat(wrap.style.getPropertyValue('--my'))||0);
var dx=e.clientX-cx,dy=e.clientY-cy,d=Math.sqrt(dx*dx+dy*dy);
if(d<260){wrap.style.setProperty('--mx',clamp(dx*.16,-16,16).toFixed(1)+'px');wrap.style.setProperty('--my',clamp(dy*.22,-12,12).toFixed(1)+'px')}
else{wrap.style.setProperty('--mx','0px');wrap.style.setProperty('--my','0px')}
});

/* continue: ripple wipe, then navigate */
go.addEventListener('click',function(e){
if(e.metaKey||e.ctrlKey||e.shiftKey||e.button!==0)return;
e.preventDefault();
var r=go.getBoundingClientRect(),w=document.createElement('div');
w.className='rj-wipe';
w.style.setProperty('--wx',(r.left+r.width/2)+'px');
w.style.setProperty('--wy',(r.top+r.height/2)+'px');
document.body.appendChild(w);
extra=6;
requestAnimationFrame(function(){requestAnimationFrame(function(){w.classList.add('on')})});
setTimeout(function(){window.location.href=go.href},820)
});

var rt=0;
function rs(){clearTimeout(rt);rt=setTimeout(layout,60)}
window.addEventListener('resize',rs);
window.addEventListener('orientationchange',function(){setTimeout(layout,150);setTimeout(layout,450)});
if(window.visualViewport)window.visualViewport.addEventListener('resize',rs);
if(window.ResizeObserver){new ResizeObserver(rs).observe(card)}
var imgs=document.querySelectorAll('.eco img,.brand-logo');
for(var m=0;m<imgs.length;m++)imgs[m].addEventListener('load',rs);
layout();
setTimeout(layout,350);
setTimeout(layout,1200);
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running&&!document.body.classList.contains('rj-fb')){running=true;lastT=performance.now();requestAnimationFrame(frame)}
});
requestAnimationFrame(frame)
}catch(err){fallback()}
});
</script>
HTML;

rj_render('ecosystem', $body, $extra);
exit;
