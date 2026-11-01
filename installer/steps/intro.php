<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

$totalSlides = 5;
$currentSlide = isset($_GET['slide']) ? (int)$_GET['slide'] : 1;
if ($currentSlide < 1) $currentSlide = 1;
if ($currentSlide > $totalSlides) $currentSlide = $totalSlides;
$startSlide = $currentSlide;

$finalUrl = rj_installer_url('step=requirements');
$skipUrl  = $finalUrl;

// Render every slide up front so they can be switched without reloading the page
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
    . '<div class="deck" id="inDeck"><div class="panel" id="inPanel"><i class="glow"></i><div class="panel-in">'
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
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none}

/* header: logo only */
.card{position:fixed;top:clamp(10px,2.2vh,22px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(44px,8vh,70px);width:auto;margin:0 auto;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(236,72,153,.55));animation:in-logo 1.4s .4s cubic-bezier(.2,.8,.2,1) both}
@keyframes in-logo{from{opacity:0;transform:translateY(-14px) scale(.85);filter:blur(12px) drop-shadow(0 0 22px rgba(236,72,153,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(236,72,153,.55))}}
.card h1,.card p.sub,.card .steps{display:none}
@keyframes in-up{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}

/* stage */
.intro{position:fixed;inset:0;z-index:3;display:flex;justify-content:center;align-items:flex-start;overflow:hidden;touch-action:none}
.in-fit{width:min(94vw,760px);transform-origin:top center}
.in-skip{position:fixed;top:clamp(12px,2.6vh,24px);right:clamp(12px,2.4vw,28px);z-index:6;display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:13px;color:#d8b4fe;text-decoration:none;background:rgba(24,16,58,.55);border:1px solid rgba(168,85,247,.3);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);animation:in-up .8s 2.6s backwards;transition:.25s}
.in-skip:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 22px -4px rgba(236,72,153,.8)}
.in-skip svg{width:15px;height:15px}

/* glass panel with spinning neon border */
.deck{perspective:1300px;animation:in-deck 1.3s 1.2s cubic-bezier(.2,.9,.25,1.05) backwards}
@keyframes in-deck{0%{opacity:0;transform:translateY(90px) rotateX(40deg) scale(.88);filter:blur(12px)}60%{filter:blur(0)}100%{opacity:1;transform:none}}
.panel{position:relative;border-radius:26px;padding:1.5px;overflow:hidden;transform-style:preserve-3d;will-change:transform;box-shadow:0 30px 80px -24px rgba(236,72,153,.55),0 0 90px -20px rgba(124,58,237,.7)}
.panel .glow{position:absolute;left:50%;top:50%;width:200%;aspect-ratio:1;margin:-100% 0 0 -100%;background:conic-gradient(from 0deg,transparent 0 55%,#7c3aed 68%,#ec4899 80%,#fbbf24 88%,transparent 95%);animation:in-spin 5s linear infinite}
@keyframes in-spin{to{transform:rotate(360deg)}}
.panel-in{position:relative;border-radius:24.5px;background:rgba(12,7,34,.9);-webkit-backdrop-filter:blur(18px);backdrop-filter:blur(18px);padding:clamp(22px,4vh,40px) clamp(18px,4vw,44px);min-height:240px;overflow:hidden}
.panel-in::after{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(420px circle at var(--gx,50%) var(--gy,0%),rgba(255,255,255,.09),transparent 60%)}
.cnt{position:absolute;top:14px;right:20px;z-index:2;font-size:11px;letter-spacing:.2em;color:#6b7280}
.cnt b{color:#f9a8d4;font-weight:700}

/* slides: all stacked in one grid cell, flip in 3D */
.slides{display:grid;perspective:1100px}
.slide{grid-area:1/1;display:flex;flex-direction:column;justify-content:center;text-align:center;color:#e5e7eb;opacity:0;visibility:hidden;pointer-events:none;transform:translateX(calc(var(--sg,1)*80px)) rotateY(calc(var(--sg,1)*-55deg)) scale(.88);filter:blur(8px);transition:transform .85s cubic-bezier(.2,.8,.2,1),opacity .55s ease,filter .7s ease,visibility 0s .85s}
.slide.active{opacity:1;visibility:visible;pointer-events:auto;transform:none;filter:none;transition:transform .85s cubic-bezier(.2,.8,.2,1),opacity .55s .1s ease,filter .7s ease,visibility 0s 0s}
.sl-in h1,.sl-in h2,.sl-in h3{color:#fff;margin:0 0 10px}
.sl-in p{color:#b4bad4;line-height:1.7}
.slide.active .st{animation:in-up .75s calc(.3s + var(--k,0)*.09s) cubic-bezier(.2,.8,.2,1) backwards}
.intro.boot .slide.active .st{animation-delay:calc(2.1s + var(--k,0)*.1s)}

/* timeline with comet */
.tl{position:relative;display:flex;justify-content:space-between;width:min(84vw,360px);margin:30px auto 0;animation:in-up .9s 2.2s backwards}
.tl-bar{position:absolute;left:14px;right:14px;top:50%;height:2px;margin-top:-1px;border-radius:2px;background:rgba(168,85,247,.25)}
.tl-fill{position:absolute;left:0;top:0;bottom:0;width:0;border-radius:2px;background:linear-gradient(90deg,#7c3aed,#ec4899);box-shadow:0 0 12px rgba(236,72,153,.8);transition:width .85s cubic-bezier(.7,0,.2,1)}
.tl-fill::after{content:"";position:absolute;right:-5px;top:50%;width:10px;height:10px;margin-top:-5px;border-radius:50%;background:#fff;box-shadow:0 0 16px 4px rgba(244,114,182,.9)}
.tl-n{position:relative;z-index:1;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#8b8fa8;background:#150d33;border:1px solid rgba(168,85,247,.32);text-decoration:none;transition:transform .4s cubic-bezier(.2,.9,.3,1.4),background .4s,color .4s,border-color .4s}
.tl-n:hover{border-color:#ec4899;color:#fff}
.tl-n.done{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.tl-n.cur{color:#fff;transform:scale(1.28);background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent;animation:in-pulse 2s ease-out infinite}
@keyframes in-pulse{0%{box-shadow:0 0 0 0 rgba(236,72,153,.6)}100%{box-shadow:0 0 0 14px rgba(236,72,153,0)}}

/* controls */
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

/* leave wipe */
.rj-wipe{position:fixed;inset:0;z-index:30;pointer-events:none;background:radial-gradient(circle at var(--wx,50%) var(--wy,50%),#fff 0%,#fbcfe8 28%,#ec4899 60%,#7c3aed 100%);clip-path:circle(0% at var(--wx,50%) var(--wy,50%));transition:clip-path .8s cubic-bezier(.65,0,.25,1)}
.rj-wipe.on{clip-path:circle(150% at var(--wx,50%) var(--wy,50%))}

/* JS failure fallback */
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

/* stagger content of each slide */
slides.forEach(function(s,si){
var inner=s.firstElementChild,c=inner?inner.children:[];
if(c.length===1&&c[0].children.length>1)c=c[0].children;
for(var i=0;i<c.length;i++){c[i].classList.add('st');c[i].style.setProperty('--k',i)}
s.style.setProperty('--sg',si<idx?-1:1)
});

function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}

/* ---------- neon horizon canvas ---------- */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var sunC=document.createElement('canvas'),sctx=sunC.getContext('2d');
var W=0,H=0,dpr=1,hz=0,R=100;
var stars=[],embers=[],shapes=[];
var roadT=0,extra=0,flash=0,mx=0,my=0,tmx=0,tmy=0,lastT=0,tx=0,ty=0;

function mkSolid(v,e){return{v:v,e:e}}
var cubeV=[[-1,-1,-1],[1,-1,-1],[1,1,-1],[-1,1,-1],[-1,-1,1],[1,-1,1],[1,1,1],[-1,1,1]];
var cubeE=[[0,1],[1,2],[2,3],[3,0],[4,5],[5,6],[6,7],[7,4],[0,4],[1,5],[2,6],[3,7]];
var octV=[[1,0,0],[-1,0,0],[0,1,0],[0,-1,0],[0,0,1],[0,0,-1]],octE=[];
(function(){for(var a=0;a<6;a++)for(var b=a+1;b<6;b++){if(b===a+1&&a%2===0)continue;octE.push([a,b])}})();
function buildShapes(){
shapes=[
{s:mkSolid(cubeV,cubeE),x:.12,y:.30,z:.06,col:'236,72,153',sp:[.5,.7,.3]},
{s:mkSolid(octV,octE),x:.88,y:.25,z:.07,col:'96,165,250',sp:[.6,.4,.5]},
{s:mkSolid(cubeV,cubeE),x:.20,y:.70,z:.03,col:'167,139,250',sp:[.8,.3,.6]},
{s:mkSolid(octV,octE),x:.81,y:.72,z:.04,col:'244,114,182',sp:[.4,.9,.3]},
{s:mkSolid(octV,octE),x:.5,y:.09,z:.03,col:'251,191,36',sp:[.7,.5,.8]}
];
shapes.forEach(function(o){o.a=[rnd(0,6),rnd(0,6),rnd(0,6)];o.ph=rnd(0,6.28)})
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
hz=H*(H<520?.5:.56);
R=Math.min(W*.22,H*.26);
sunC.width=sunC.height=Math.ceil(R*2+4);
if(!stars.length){
for(var i=0;i<110;i++)stars.push({x:Math.random(),y:Math.random()*.92,r:rnd(.4,1.5),ph:rnd(0,6.28)});
for(i=0;i<70;i++)embers.push({x:Math.random(),y:Math.random(),vy:rnd(.00008,.00026),ph:rnd(0,6.28),c:Math.random()<.5?'244,114,182':'167,139,250'});
buildShapes()
}
var hb=card?card.getBoundingClientRect().bottom:70;
stage.style.paddingTop=(hb+10)+'px';
var availH=H-hb-24,nh=fit.offsetHeight,nw=fit.offsetWidth;
var sc=Math.max(.4,Math.min(1,availH/nh,(W-10)/nw));
fit.style.transform='scale('+sc+')';
fit.style.marginTop=Math.max(0,(availH-nh*sc)/2)+'px';
fit.style.marginBottom=(-(nh*(1-sc)))+'px'
}
function drawSky(t,gF){
var g=ctx.createLinearGradient(0,0,0,hz);
g.addColorStop(0,'#05040f');g.addColorStop(.55,'#130833');g.addColorStop(.85,'#3a0f5c');g.addColorStop(1,'#8a2a86');
ctx.fillStyle=g;ctx.fillRect(0,0,W,hz+1);
for(var i=0;i<stars.length;i++){
var s=stars[i];
ctx.globalAlpha=gF*(.25+.65*(.5+.5*Math.sin(t*1.6+s.ph)))*(1-s.y*.5);
ctx.fillStyle='#fff';
ctx.fillRect(s.x*W+mx*6*s.r,s.y*hz,s.r,s.r)
}
ctx.globalAlpha=1
}
function drawSun(t,riseE){
var cx=W/2-mx*14,cy=hz-R*.12+(1-riseE)*R*1.5;
ctx.globalCompositeOperation='lighter';
var gl=ctx.createRadialGradient(cx,cy,R*.4,cx,cy,R*2.4);
gl.addColorStop(0,'rgba(244,114,182,'+(.4*riseE)+')');gl.addColorStop(1,'rgba(124,58,237,0)');
ctx.fillStyle=gl;ctx.beginPath();ctx.arc(cx,cy,R*2.4,0,6.283);ctx.fill();
ctx.globalCompositeOperation='source-over';
var D=sunC.width,c=D/2;
sctx.clearRect(0,0,D,D);
var g=sctx.createLinearGradient(0,c-R,0,c+R);
g.addColorStop(0,'#fde68a');g.addColorStop(.45,'#f472b6');g.addColorStop(1,'#6d28d9');
sctx.fillStyle=g;sctx.beginPath();sctx.arc(c,c,R,0,6.283);sctx.fill();
sctx.globalCompositeOperation='destination-out';
var fr=(t*.05)%1;
for(var k=-1;k<9;k++){
var yk=c+R*(-.1+(k+fr)*.14),th=R*(.008+Math.max(0,(yk-c)/R)*.06);
if(yk>c+R)break;
sctx.fillRect(0,yk,D,th)
}
sctx.globalCompositeOperation='source-over';
ctx.save();ctx.beginPath();ctx.rect(0,0,W,hz);ctx.clip();
ctx.drawImage(sunC,cx-c,cy-c);
ctx.restore()
}
function mtn(amp,seed,fillc,lineA){
ctx.beginPath();ctx.moveTo(0,hz);
for(var x=0;x<=W+10;x+=10){
var v=Math.max(.02,.45+.35*Math.sin(x*.006+seed+mx*.4)+.2*Math.sin(x*.017+seed*2.1)+.12*Math.sin(x*.043+seed*3));
ctx.lineTo(x,hz-amp*v)
}
ctx.lineTo(W+10,hz);ctx.closePath();
ctx.fillStyle=fillc;ctx.fill();
if(lineA){
ctx.strokeStyle='rgba(236,72,153,'+lineA+')';ctx.lineWidth=1.2;
ctx.beginPath();
for(var x2=0;x2<=W+10;x2+=10){
var v2=Math.max(.02,.45+.35*Math.sin(x2*.006+seed+mx*.4)+.2*Math.sin(x2*.017+seed*2.1)+.12*Math.sin(x2*.043+seed*3));
if(x2===0)ctx.moveTo(x2,hz-amp*v2);else ctx.lineTo(x2,hz-amp*v2)
}
ctx.stroke()
}
}
function drawFloor(t,gF){
var g=ctx.createLinearGradient(0,hz,0,H);
g.addColorStop(0,'#1d0a3d');g.addColorStop(.35,'#0e0524');g.addColorStop(1,'#05040f');
ctx.fillStyle=g;ctx.fillRect(0,hz,W,H-hz);
var vx=W/2+mx*34+tx*0,ofs=roadT%1,N2=22,k,y,a;
ctx.globalCompositeOperation='lighter';
for(k=0;k<=N2;k++){
var zk=(k+ofs)/N2;
if(zk>1)continue;
y=hz+(H-hz)*Math.pow(zk,2.4);
a=(.12+.75*zk)*gF;
ctx.strokeStyle='rgba(236,72,153,'+(a*.18).toFixed(3)+')';ctx.lineWidth=5;
ctx.beginPath();ctx.moveTo(0,y);ctx.lineTo(W,y);ctx.stroke();
ctx.strokeStyle='rgba(244,114,182,'+a.toFixed(3)+')';ctx.lineWidth=1.3;
ctx.beginPath();ctx.moveTo(0,y);ctx.lineTo(W,y);ctx.stroke()
}
var gap=Math.max(60,W*.075),M=Math.ceil(W*.7/gap);
for(var i=-M;i<=M;i++){
var x2=vx+i*gap;
ctx.strokeStyle='rgba(167,139,250,'+(.14*gF)+')';ctx.lineWidth=5;
ctx.beginPath();ctx.moveTo(vx,hz);ctx.lineTo(x2,H);ctx.stroke();
ctx.strokeStyle='rgba(196,181,253,'+(.7*gF)+')';ctx.lineWidth=1.2;
ctx.beginPath();ctx.moveTo(vx,hz);ctx.lineTo(x2,H);ctx.stroke()
}
ctx.globalCompositeOperation='source-over';
var fg=ctx.createLinearGradient(0,hz,0,hz+H*.14);
fg.addColorStop(0,'rgba(60,16,90,.95)');fg.addColorStop(1,'rgba(60,16,90,0)');
ctx.fillStyle=fg;ctx.fillRect(0,hz,W,H*.14);
ctx.globalCompositeOperation='lighter';
var hg=ctx.createLinearGradient(0,hz-H*.07,0,hz+H*.07);
hg.addColorStop(0,'rgba(244,114,182,0)');hg.addColorStop(.5,'rgba(244,114,182,'+clamp(.5*gF+flash*.5,0,1)+')');hg.addColorStop(1,'rgba(244,114,182,0)');
ctx.fillStyle=hg;ctx.fillRect(0,hz-H*.07,W,H*.14);
ctx.globalCompositeOperation='source-over'
}
function drawShapes(t,dt){
var base=Math.min(W,H),i,j;
ctx.globalCompositeOperation='lighter';
for(i=0;i<shapes.length;i++){
var o=shapes[i];
for(j=0;j<3;j++)o.a[j]+=dt*o.sp[j]*(1+extra*1.2);
var cx=o.x*W-mx*22*(1+o.z*10),cy=o.y*H+Math.sin(t*.8+o.ph)*10-my*12,sz=o.z*base*1.5+base*.03;
var ca=Math.cos(o.a[0]),sa=Math.sin(o.a[0]),cb=Math.cos(o.a[1]),sb=Math.sin(o.a[1]),cc=Math.cos(o.a[2]),sc2=Math.sin(o.a[2]);
var pts=[];
for(j=0;j<o.s.v.length;j++){
var p=o.s.v[j],x=p[0],y=p[1],z=p[2],x1,y1,z1;
y1=y*ca-z*sa;z1=y*sa+z*ca;y=y1;z=z1;
x1=x*cb+z*sb;z1=-x*sb+z*cb;x=x1;z=z1;
x1=x*cc-y*sc2;y1=x*sc2+y*cc;x=x1;y=y1;
var k=1/(1-z*.18);
pts.push([cx+x*sz*k,cy+y*sz*k])
}
for(var w=0;w<2;w++){
ctx.strokeStyle='rgba('+o.col+','+(w?.9:.14)+')';ctx.lineWidth=w?1.4:6;
ctx.beginPath();
for(j=0;j<o.s.e.length;j++){var e=o.s.e[j];ctx.moveTo(pts[e[0]][0],pts[e[0]][1]);ctx.lineTo(pts[e[1]][0],pts[e[1]][1])}
ctx.stroke()
}
}
ctx.globalCompositeOperation='source-over'
}
function drawEmbers(t,dt){
ctx.globalCompositeOperation='lighter';
for(var i=0;i<embers.length;i++){
var e=embers[i];
e.y-=e.vy*dt*60*(1+extra*.8);
if(e.y<-.02){e.y=1.02;e.x=Math.random()}
ctx.globalAlpha=.25+.6*(.5+.5*Math.sin(t*2+e.ph));
ctx.fillStyle='rgba('+e.c+',1)';
ctx.fillRect(e.x*W+mx*8,e.y*H,2,2)
}
ctx.globalAlpha=1;ctx.globalCompositeOperation='source-over'
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
mx+=(tmx-mx)*.06;my+=(tmy-my)*.06;
var gF=easeOut(clamp((t-.3)/1.8,0,1)),riseE=easeOut(clamp((t-.2)/2.2,0,1));
var boost=3.5*Math.pow(1-clamp(t/2.8,0,1),2)+extra;
extra*=Math.pow(.96,dt*60);flash*=Math.pow(.94,dt*60);
roadT+=dt*(.28+boost);
ctx.clearRect(0,0,W,H);
drawSky(t,gF);
drawSun(t,riseE);
mtn(H*.1,1.3,'#1a0b3d',.25);
mtn(H*.065,4.7,'#0a0620',.55);
drawFloor(t,gF);
drawShapes(t,dt);
drawEmbers(t,dt);
/* panel tilt + glare */
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
extra=Math.max(extra,4.5);flash=1;
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
extra=12;flash=1;
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
