<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

$totalSlides = 5;
$currentSlide = isset($_GET['slide']) ? (int)$_GET['slide'] : 1;
if ($currentSlide < 1) $currentSlide = 1;
if ($currentSlide > $totalSlides) $currentSlide = $totalSlides;
$startSlide = $currentSlide;

$finalUrl = rj_installer_url('step=requirements');
$skipUrl  = $finalUrl;

$slidesHtml = '';
$timelineHtml = '';
$urls = [];
foreach (range(1, $totalSlides) as $slideNo) {
    $slideFile = __DIR__ . '/intro/slide-' . $slideNo . '.php';
    if (!file_exists($slideFile)) {
        $slideFile = __DIR__ . '/intro/slide-1.php';
    }
    $currentSlide = $slideNo;
    ob_start();
    require $slideFile;
    $slideContent = ob_get_clean();

    $slideUrl = rj_installer_url('step=intro&slide=' . $slideNo);
    $urls[$slideNo] = $slideUrl;
    $isActive = $slideNo === $startSlide;

    $slidesHtml .= '<section class="slide' . ($isActive ? ' active' : '') . '" data-url="' . rj_esc($slideUrl) . '"'
        . ' aria-hidden="' . ($isActive ? 'false' : 'true') . '"><div class="sl-in">' . $slideContent . '</div></section>';
    $timelineHtml .= '<a class="tl-n" href="' . rj_esc($slideUrl) . '" data-i="' . ($slideNo - 1) . '">' . $slideNo . '</a>';
}
$currentSlide = $startSlide;

$prevUrl = $startSlide > 1 ? $urls[$startSlide - 1] : '#';
$nextUrl = $startSlide < $totalSlides ? $urls[$startSlide + 1] : $finalUrl;
$labelNext = $t['next'] ?? 'Next';
$labelLast = $t['req_btn'] ?? 'Continue';

$arrow = '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrowBack = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$body = '<div class="intro boot" id="inStage" data-i="' . ($startSlide - 1) . '" data-final="' . rj_esc($finalUrl) . '">'
    . '<a href="' . rj_esc($skipUrl) . '" class="in-skip">' . rj_esc($t['skip'] ?? 'Skip') . ' ' . $arrow . '</a>'
    . '<div class="in-fit" id="inFit">'
    . '<div class="deck" id="inDeck"><div class="panel" id="inPanel"><div class="panel-in">'
    . '<span class="cnt"><b id="inNum">' . $startSlide . '</b> / ' . $totalSlides . '</span>'
    . '<div class="slides">' . $slidesHtml . '</div>'
    . '</div></div></div>'
    . '<nav class="tl" id="inTl"><i class="tl-bar"><i class="tl-fill" id="inFill"></i></i>' . $timelineHtml . '</nav>'
    . '<div class="ctrls">'
    . '<a href="' . rj_esc($prevUrl) . '" id="inBack" class="bk' . ($startSlide > 1 ? '' : ' off') . '">' . $arrowBack . '<span>' . rj_esc($t['back'] ?? 'Back') . '</span></a>'
    . '<div class="go-wrap" id="inWrap"><b class="ring r1"></b><b class="ring r2"></b>'
    . '<a href="' . rj_esc($nextUrl) . '" id="inNext" class="go" data-next="' . rj_esc($labelNext) . '" data-last="' . rj_esc($labelLast) . '">'
    . '<span class="go-t">' . rj_esc($startSlide === $totalSlides ? $labelLast : $labelNext) . '</span><span class="arr">' . $arrow . '</span></a></div>'
    . '</div>'
    . '</div></div>';

$extra = <<<'HTML'
<noscript><style>.card{position:static!important;transform:none!important;pointer-events:auto!important}.brand-logo{opacity:1!important;animation:none!important}.intro{position:static!important;overflow:visible!important}.deck,.tl,.ctrls,.in-skip{animation:none!important}.in-skip{position:static!important}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;overscroll-behavior:none}
body{display:block;padding:0;min-height:100vh}
html,body,.card,.intro{-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
::selection{background:transparent;color:inherit}
img{-webkit-user-drag:none;user-drag:none}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 2.4s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(18px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.28),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.22),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.2),transparent 70%);animation:rj-neb 22s ease-in-out infinite alternate,rj-bg 3s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-4%,1%,0) rotate(0) scale(1)}to{transform:translate3d(4%,-3%,0) rotate(12deg) scale(1.18)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(56px,10vh,92px);width:auto;margin:0 auto;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(167,139,250,.55));animation:rj-logo 1.5s .6s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-logo{from{opacity:0;transform:translateY(10px) scale(.82);filter:blur(14px) drop-shadow(0 0 22px rgba(167,139,250,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.55))}}
.card h1,.card p.sub,.card .steps{display:none}
@keyframes in-up{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}

.intro{position:fixed;inset:0;z-index:3;display:flex;justify-content:center;align-items:flex-start;overflow:hidden;touch-action:none}
.in-fit{width:min(94vw,760px);transform-origin:top center}
.in-skip{position:fixed;top:clamp(12px,2.6vh,24px);right:clamp(12px,2.4vw,28px);z-index:6;display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:13px;color:#d8b4fe;text-decoration:none;background:rgba(24,16,58,.55);border:1px solid rgba(168,85,247,.3);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);animation:in-up .8s 2.6s backwards;transition:.25s}
.in-skip:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 22px -4px rgba(236,72,153,.8)}
.in-skip svg{width:15px;height:15px}

.deck{perspective:1300px;animation:in-deck 1.3s 1.2s cubic-bezier(.2,.9,.25,1.05) backwards}
@keyframes in-deck{0%{opacity:0;transform:translateY(90px) rotateX(40deg) scale(.88);filter:blur(12px)}60%{filter:blur(0)}100%{opacity:1;transform:none}}
.panel{position:relative;border-radius:24px;transform-style:preserve-3d;will-change:transform;box-shadow:0 30px 80px -24px rgba(236,72,153,.3),0 0 90px -20px rgba(124,58,237,.4)}
.panel-in{position:relative;border-radius:24px;background:rgba(24,16,58,.75);-webkit-backdrop-filter:blur(18px);backdrop-filter:blur(18px);border:1px solid rgba(168,85,247,.3);padding:clamp(24px,5vh,44px) clamp(20px,4vw,48px);min-height:260px;overflow:hidden}
.panel-in::after{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(420px circle at var(--gx,50%) var(--gy,0%),rgba(255,255,255,.07),transparent 60%)}
.cnt{position:absolute;top:16px;right:24px;z-index:2;font-size:11px;letter-spacing:.2em;color:#6b7280}
.cnt b{color:#f9a8d4;font-weight:700}

.slides{display:grid;perspective:1100px}
.slide{grid-area:1/1;display:flex;flex-direction:column;justify-content:center;text-align:center;color:#e5e7eb;opacity:0;visibility:hidden;pointer-events:none;transform:translateX(calc(var(--sg,1)*80px)) rotateY(calc(var(--sg,1)*-55deg)) scale(.88);filter:blur(8px);transition:transform .85s cubic-bezier(.2,.8,.2,1),opacity .55s ease,filter .7s ease,visibility 0s .85s}
.slide.active{opacity:1;visibility:visible;pointer-events:auto;transform:none;filter:none;transition:transform .85s cubic-bezier(.2,.8,.2,1),opacity .55s .1s ease,filter .7s ease,visibility 0s 0s}
.sl-in h1,.sl-in h2,.sl-in h3{color:#fff;margin:0 0 12px;font-size:clamp(22px,3.2vw,28px);font-weight:800}
.sl-in p{color:#b4bad4;line-height:1.7;font-size:15px}
.slide.active .st{animation:in-up .75s calc(.3s + var(--k,0)*.09s) cubic-bezier(.2,.8,.2,1) backwards}
.intro.boot .slide.active .st{animation-delay:calc(2.1s + var(--k,0)*.1s)}

.tl{position:relative;display:flex;justify-content:space-between;width:min(84vw,360px);margin:30px auto 0;animation:in-up .9s 2.2s backwards}
.tl-bar{position:absolute;left:14px;right:14px;top:50%;height:2px;margin-top:-1px;border-radius:2px;background:rgba(168,85,247,.25)}
.tl-fill{position:absolute;left:0;top:0;bottom:0;width:0;border-radius:2px;background:linear-gradient(90deg,#7c3aed,#ec4899);box-shadow:0 0 12px rgba(236,72,153,.8);transition:width .85s cubic-bezier(.7,0,.2,1)}
.tl-fill::after{content:"";position:absolute;right:-5px;top:50%;width:10px;height:10px;margin-top:-5px;border-radius:50%;background:#fff;box-shadow:0 0 16px 4px rgba(244,114,182,.9)}
.tl-n{position:relative;z-index:1;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#8b8fa8;background:#150d33;border:1px solid rgba(168,85,247,.32);text-decoration:none;transition:transform .4s cubic-bezier(.2,.9,.3,1.4),background .4s,color .4s,border-color .4s}
.tl-n:hover{border-color:#ec4899;color:#fff}
.tl-n.done{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.tl-n.cur{color:#fff;transform:scale(1.28);background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent;animation:in-pulse 2s ease-out infinite}
@keyframes in-pulse{0%{box-shadow:0 0 0 0 rgba(236,72,153,.6)}100%{box-shadow:0 0 0 14px rgba(236,72,153,0)}}

.ctrls{display:flex;align-items:center;justify-content:center;gap:18px;margin-top:26px;animation:in-up .9s 2.4s backwards}
.bk{display:inline-flex;align-items:center;gap:8px;padding:14px 22px;border-radius:9999px;color:#d8b4fe;font-size:14px;font-weight:600;text-decoration:none;background:rgba(24,16,58,.6);border:1px solid rgba(168,85,247,.45);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);transition:opacity .4s,transform .4s,box-shadow .25s,color .25s,border-color .25s}
.bk:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 26px -4px rgba(236,72,153,.8)}
.bk.off{opacity:0;pointer-events:none;transform:translateX(14px)}
.go-wrap{position:relative;display:inline-block;transform:translate(var(--mx,0px),var(--my,0px));transition:transform .25s ease-out}
.go{position:relative;display:inline-flex;align-items:center;gap:16px;padding:14px 18px 14px 32px;border-radius:9999px;overflow:hidden;color:#fff;text-decoration:none;font-size:17px;font-weight:800;letter-spacing:.04em;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 18px 44px -14px rgba(236,72,153,.85),0 0 54px -8px rgba(124,58,237,.7);animation:in-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s}
@keyframes in-flow{to{background-position:-300% 0}}
.go::after{content:"";position:absolute;top:0;bottom:0;left:-40%;width:30%;transform:skewX(-22deg);background:linear-gradient(90deg,transparent,rgba(255,255,255,.55),transparent);animation:in-shine 3s 2.6s ease-in-out infinite}
@keyframes in-shine{0%{left:-40%}55%,100%{left:130%}}
.go .arr{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.95);color:#7c3aed;box-shadow:0 6px 16px -4px rgba(0,0,0,.45);animation:in-nudge 1.6s ease-in-out infinite}
@keyframes in-nudge{50%{transform:translateX(5px)}}
.go:hover{transform:scale(1.07);box-shadow:0 0 0 1px rgba(255,255,255,.4) inset,0 24px 58px -12px rgba(236,72,153,1),0 0 84px -4px rgba(168,85,247,.95)}
.go:active{transform:scale(.96)}
.go:focus-visible,.bk:focus-visible{outline:2px solid #fff;outline-offset:4px}
.ring{position:absolute;inset:0;border-radius:9999px;border:1.5px solid rgba(244,114,182,.7);pointer-events:none;opacity:0;animation:in-expand 2.6s ease-out infinite}
.r2{animation-delay:1.3s;border-color:rgba(167,139,250,.7)}
@keyframes in-expand{0%{opacity:.9;transform:scale(1)}100%{opacity:0;transform:scale(1.5,1.9)}}

.rj-wipe{position:fixed;inset:0;z-index:30;pointer-events:none;background:radial-gradient(circle at var(--wx,50%) var(--wy,50%),#fff 0%,#fbcfe8 28%,#ec4899 60%,#7c3aed 100%);clip-path:circle(0% at var(--wx,50%) var(--wy,50%));transition:clip-path .8s cubic-bezier(.65,0,.25,1)}
.rj-wipe.on{clip-path:circle(150% at var(--wx,50%) var(--wy,50%))}

.rj-fb *{animation:none!important}
.rj-fb .brand-logo,.rj-fb .deck,.rj-fb .tl,.rj-fb .ctrls{opacity:1!important}
.rj-fb #rjSky{display:none}
body.rj-fb{background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%)}

@media (max-width:560px){
.go{font-size:15px;padding:12px 14px 12px 26px}
.bk{padding:12px 16px}
.ctrls{gap:12px}
}
@media (max-height:520px){.panel-in{padding:16px 22px;min-height:0}.tl{margin-top:16px}.ctrls{margin-top:14px}}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('inStage');
if(!stage)return;
var running=true;
function fallback(){running=false;document.body.classList.add('rj-fb')}
try{
var INTRO=3.4;
var card=document.querySelector('.card');
var fit=document.getElementById('inFit'),panel=document.getElementById('inPanel');
var slides=[].slice.call(stage.querySelectorAll('.slide'));
var nodes=[].slice.call(stage.querySelectorAll('.tl-n'));
var fill=document.getElementById('inFill'),num=document.getElementById('inNum');
var back=document.getElementById('inBack'),next=document.getElementById('inNext'),wrap=document.getElementById('inWrap');
var N=slides.length,idx=parseInt(stage.getAttribute('data-i'),10)||0;
var finalUrl=stage.getAttribute('data-final');
idx=Math.max(0,Math.min(N-1,idx));
document.body.appendChild(stage);
document.addEventListener('selectstart',function(e){e.preventDefault()});
document.addEventListener('dragstart',function(e){e.preventDefault()});

slides.forEach(function(s,si){
var inner=s.firstElementChild,c=inner?inner.children:[];
if(c.length===1&&c[0].children.length>1)c=c[0].children;
for(var i=0;i<c.length;i++){c[i].classList.add('st');c[i].style.setProperty('--k',i)}
s.style.setProperty('--sg',si<idx?-1:1)
});

function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}

/* ---------- galaxy background from ecosystem ---------- */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,stars=[],gal=[],galW=0,shoots=[],nextShoot=2.2,shocks=[];
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
var hb=card?card.getBoundingClientRect().bottom:120;
stage.style.paddingTop=(hb+14)+'px';
var availH=H-hb-24-(H<520?54:88);
var nh=fit.offsetHeight,nw=fit.offsetWidth;
var sc=Math.max(.36,Math.min(1,availH/nh,(W-12)/nw));
fit.style.transform='scale('+sc+')';
fit.style.marginTop=Math.max(0,(availH-nh*sc)/2)+'px';
fit.style.marginBottom=(-(nh*(1-sc)))+'px';
}

/* ---------- timeline ---------- */
var T0=performance.now(),off=0;
function tNow(){return(performance.now()-T0)/1000+off}
function skip(){
var t=tNow();
if(t>=INTRO)return;
off+=INTRO-t;
try{document.getAnimations().forEach(function(a){try{if(a.effect.getComputedTiming().iterations!==Infinity)a.finish()}catch(e){}})}catch(e){}
stage.classList.remove('boot')
}
function frame(now){
if(!running)return;
try{
var t=tNow(),dt=Math.min(.1,Math.max(.001,(now-lastT)/1000||.016));
lastT=now;
mx+=(tmx-mx)*.05;my+=(tmy-my)*.05;
ctx.clearRect(0,0,W,H);
drawStars(t);
drawGalaxy(t,dt);
drawShoots(t);
drawShocks(performance.now());
var rx=-my*4,ry=mx*6;
panel.style.transform='rotateX('+rx.toFixed(2)+'deg) rotateY('+ry.toFixed(2)+'deg)';
panel.style.setProperty('--gx',((mx+1)/2*100).toFixed(1)+'%');
panel.style.setProperty('--gy',((my+1)/2*100).toFixed(1)+'%');
requestAnimationFrame(frame)
}catch(err){fallback()}
}

/* ---------- slides ---------- */
var lock=false;
function urlOf(i){return slides[i].getAttribute('data-url')}
function ui(){
num.textContent=String(idx+1);
nodes.forEach(function(n,i){n.classList.toggle('done',i<idx);n.classList.toggle('cur',i===idx)});
fill.style.width=(N>1?idx/(N-1)*100:0)+'%';
back.classList.toggle('off',idx===0);
back.setAttribute('href',idx>0?urlOf(idx-1):'#');
var last=idx===N-1;
next.querySelector('.go-t').textContent=last?next.getAttribute('data-last'):next.getAttribute('data-next');
next.setAttribute('href',last?finalUrl:urlOf(idx+1))
}
function show(n){
n=clamp(n,0,N-1);
if(n===idx||lock)return;
idx=n;lock=true;
stage.setAttribute('data-i',String(n));
stage.classList.remove('boot');
slides.forEach(function(s,i){
s.style.setProperty('--sg',i<idx?-1:1);
s.classList.toggle('active',i===idx);
s.setAttribute('aria-hidden',i===idx?'false':'true')
});
extra=Math.max(extra,4.5);
ui();
try{history.replaceState(null,'',urlOf(idx))}catch(e){}
setTimeout(function(){lock=false},700)
}
function leave(){
var r=next.getBoundingClientRect(),w=document.createElement('div');
w.className='rj-wipe';
w.style.setProperty('--wx',(r.left+r.width/2)+'px');
w.style.setProperty('--wy',(r.top+r.height/2)+'px');
document.body.appendChild(w);
extra=12;
requestAnimationFrame(function(){requestAnimationFrame(function(){w.classList.add('on')})});
setTimeout(function(){window.location.href=finalUrl},820)
}
next.addEventListener('click',function(e){
if(e.metaKey||e.ctrlKey||e.shiftKey||e.button!==0)return;
e.preventDefault();
if(idx<N-1)show(idx+1);else leave()
});
back.addEventListener('click',function(e){e.preventDefault();if(idx>0)show(idx-1)});
nodes.forEach(function(n){n.addEventListener('click',function(e){e.preventDefault();show(parseInt(n.getAttribute('data-i'),10))})});
window.addEventListener('keydown',function(e){
var k=e.key;
if(tNow()<INTRO){if(k==='Escape'||k==='Enter'||k===' '||k.indexOf('Arrow')===0){skip();return}}
var el=document.activeElement,onCtl=el&&(el.tagName==='A'||el.tagName==='BUTTON');
if(k==='ArrowRight'||k==='ArrowDown'||k==='PageDown'||((k===' '||k==='Enter')&&!onCtl)){e.preventDefault();if(idx<N-1)show(idx+1);else if(k!=='ArrowDown'&&k!=='ArrowRight')leave()}
else if(k==='ArrowLeft'||k==='ArrowUp'||k==='PageUp'){e.preventDefault();show(idx-1)}
});
window.addEventListener('wheel',function(e){
e.preventDefault();
var v=Math.abs(e.deltaY)>=Math.abs(e.deltaX)?e.deltaY:e.deltaX;
if(Math.abs(v)<14)return;
if(tNow()<INTRO){skip();return}
show(idx+(v>0?1:-1))
},{passive:false});
var ts=null;
window.addEventListener('touchstart',function(e){var t=e.touches[0];ts=[t.clientX,t.clientY]},{passive:true});
window.addEventListener('touchend',function(e){
if(!ts)return;
var t=e.changedTouches[0],dx=ts[0]-t.clientX,dy=ts[1]-t.clientY;
ts=null;
if(Math.abs(dx)<44&&Math.abs(dy)<44)return;
var v=Math.abs(dx)>=Math.abs(dy)?dx:dy;
if(tNow()<INTRO){skip();return}
show(idx+(v>0?1:-1))
},{passive:true});
window.addEventListener('pointerdown',function(e){
if(e.target.closest&&e.target.closest('a,button'))return;
skip()
});
window.addEventListener('pointermove',function(e){
tmx=(e.clientX/W-.5)*2;tmy=(e.clientY/H-.5)*2;
var r=wrap.getBoundingClientRect(),cx=r.left+r.width/2-(parseFloat(wrap.style.getPropertyValue('--mx'))||0),cy=r.top+r.height/2-(parseFloat(wrap.style.getPropertyValue('--my'))||0);
var dx=e.clientX-cx,dy=e.clientY-cy,d=Math.sqrt(dx*dx+dy*dy);
if(d<240){wrap.style.setProperty('--mx',clamp(dx*.16,-14,14).toFixed(1)+'px');wrap.style.setProperty('--my',clamp(dy*.22,-10,10).toFixed(1)+'px')}
else{wrap.style.setProperty('--mx','0px');wrap.style.setProperty('--my','0px')}
});

var rt=0;
function rs(){clearTimeout(rt);rt=setTimeout(layout,60)}
window.addEventListener('resize',rs);
window.addEventListener('orientationchange',function(){setTimeout(layout,150);setTimeout(layout,450)});
if(window.visualViewport)window.visualViewport.addEventListener('resize',rs);
if(window.ResizeObserver){new ResizeObserver(rs).observe(card);new ResizeObserver(rs).observe(panel)}
var imgs=document.querySelectorAll('.intro img,.brand-logo');
for(var m=0;m<imgs.length;m++)imgs[m].addEventListener('load',rs);
layout();ui();
setTimeout(layout,350);setTimeout(layout,1200);
setTimeout(function(){stage.classList.remove('boot')},3600);
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running&&!document.body.classList.contains('rj-fb')){running=true;lastT=performance.now();requestAnimationFrame(frame)}
});
requestAnimationFrame(frame)
}catch(err){fallback()}
});
</script>
HTML;

rj_render('intro', $body, $extra);
exit;
