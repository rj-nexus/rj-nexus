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
    . '<div class="slides" id="inSlides">' . $slidesHtml . '</div>'
    . '<nav class="tl" id="inTl">' . $timelineHtml . '</nav>'
    . '<div class="ctrls">'
    . '<a href="' . rj_esc($prevUrl) . '" id="inBack" class="bk' . ($startSlide > 1 ? '' : ' off') . '">' . $arrowBack . '<span>' . rj_esc($t['back'] ?? 'Back') . '</span></a>'
    . '<div class="go-wrap" id="inWrap"><b class="ring r1"></b><b class="ring r2"></b>'
    . '<a href="' . rj_esc($nextUrl) . '" id="inNext" class="go" data-next="' . rj_esc($labelNext) . '" data-last="' . rj_esc($labelLast) . '">'
    . '<span class="go-t">' . rj_esc($startSlide === $totalSlides ? $labelLast : $labelNext) . '</span><span class="arr">' . $arrow . '</span></a></div>'
    . '</div>'
    . '</div></div>';

$extra = <<<'HTML'
<noscript><style>.card{position:static!important;transform:none!important;pointer-events:auto!important}.brand-logo{opacity:1!important;animation:none!important}.intro{position:static!important;overflow:visible!important}.tl,.ctrls,.in-skip{animation:none!important}.in-skip{position:static!important}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;overscroll-behavior:none}
body{display:block;padding:0;min-height:100vh}
html,body,.card,.intro{-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
::selection{background:transparent;color:inherit}
img{-webkit-user-drag:none;user-drag:none}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 2s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(20px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.3),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.24),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.22),transparent 70%);animation:rj-neb 26s ease-in-out infinite alternate,rj-bg 3s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-5%,1%,0) scale(1)}to{transform:translate3d(5%,-2%,0) scale(1.18)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

/* logo */
.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(56px,10vh,92px);width:auto;margin:0 auto;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(167,139,250,.55));animation:rj-logo 1.5s .6s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-logo{from{opacity:0;transform:translateY(10px) scale(.82);filter:blur(14px) drop-shadow(0 0 22px rgba(167,139,250,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.55))}}
.card h1,.card p.sub,.card .steps{display:none}
@keyframes in-up{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}

.intro{position:fixed;inset:0;z-index:3;display:flex;justify-content:center;align-items:flex-start;overflow:hidden;touch-action:none}
.in-fit{width:min(92vw,820px);transform-origin:top center}
.in-skip{position:fixed;top:clamp(12px,2.6vh,24px);right:clamp(12px,2.4vw,28px);z-index:6;display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:13px;color:#d8b4fe;text-decoration:none;background:rgba(24,16,58,.45);border:1px solid rgba(168,85,247,.3);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);animation:in-up .8s 2s backwards;transition:.25s}
.in-skip:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 22px -4px rgba(236,72,153,.8)}
.in-skip svg{width:15px;height:15px}

/* ---- yazilar birbasa ekranda ---- */
.slides{position:relative;display:grid;min-height:220px}
.slides::before{content:"";position:absolute;left:-10%;right:-10%;top:-30%;bottom:-30%;z-index:0;pointer-events:none;background:radial-gradient(closest-side,rgba(8,5,28,.62),transparent)}
.slide{position:relative;z-index:1;grid-area:1/1;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;color:#e5e7eb;opacity:0;visibility:hidden;pointer-events:none;
transform:translateX(calc(var(--sg,1)*-150px)) scaleX(1.25);filter:blur(10px);
transition:transform .8s cubic-bezier(.2,.8,.2,1),opacity .5s ease,filter .6s ease,visibility 0s .8s}
.slide.active{opacity:1;visibility:visible;pointer-events:auto;transform:none;filter:none;transition:transform .8s cubic-bezier(.2,.8,.2,1),opacity .55s .12s ease,filter .6s .08s ease,visibility 0s 0s}
.sl-in{max-width:100%}
.sl-in h1,.sl-in h2,.sl-in h3{margin:0 0 16px;font-size:clamp(26px,5vw,46px);line-height:1.15;font-weight:800;letter-spacing:-.01em;color:#fff;background:linear-gradient(90deg,#fff 0%,#e9d5ff 45%,#f9a8d4 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 0 24px rgba(167,139,250,.45))}
.sl-in p{max-width:640px;margin-left:auto;margin-right:auto;color:#cbd0e6;line-height:1.75;font-size:clamp(15px,2vw,18px);text-shadow:0 2px 18px rgba(5,4,15,.9)}
.sl-in svg,.sl-in img{max-width:100%}
.slide.active .st{animation:in-up .75s calc(.3s + var(--k,0)*.09s) cubic-bezier(.2,.8,.2,1) backwards}
.intro.boot .slide.active .st{animation-delay:calc(1.9s + var(--k,0)*.1s)}

/* ---- timeline (fonsuz, dairevi haşiye) ---- */
.tl{position:relative;display:flex;justify-content:center;gap:34px;margin:34px auto 0;animation:in-up .9s 2s backwards}
.tl-n{position:relative;z-index:1;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#8b8fa8;background:transparent;border:1.5px solid rgba(168,85,247,.45);text-decoration:none;transition:transform .4s cubic-bezier(.2,.9,.3,1.4),color .4s,border-color .4s,box-shadow .4s}
.tl-n:not(:first-child)::before{content:"";position:absolute;right:100%;top:50%;width:34px;height:2px;margin-top:-1px;background:rgba(168,85,247,.25);transition:background .5s}
.tl-n.done::before,.tl-n.cur::before{background:linear-gradient(90deg,#7c3aed,#ec4899)!important}
.tl-n:hover{border-color:#ec4899;color:#fff}
.tl-n.done{color:#f9a8d4;border-color:#ec4899}
.tl-n.cur{color:#fff;transform:scale(1.25);border-color:#f472b6;box-shadow:0 0 14px rgba(244,114,182,.7),inset 0 0 10px rgba(244,114,182,.35);animation:in-pulse 2s ease-out infinite}
@keyframes in-pulse{0%{box-shadow:0 0 0 0 rgba(236,72,153,.6),inset 0 0 10px rgba(244,114,182,.35)}100%{box-shadow:0 0 0 14px rgba(236,72,153,0),inset 0 0 10px rgba(244,114,182,.35)}}

/* ---- duymeler ---- */
.ctrls{display:flex;align-items:center;justify-content:center;gap:18px;margin-top:26px;animation:in-up .9s 2.2s backwards}
.bk{display:inline-flex;align-items:center;gap:8px;padding:14px 22px;border-radius:9999px;color:#d8b4fe;font-size:14px;font-weight:600;text-decoration:none;background:rgba(24,16,58,.5);border:1px solid rgba(168,85,247,.45);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);transition:opacity .4s,transform .4s,box-shadow .25s,color .25s,border-color .25s}
.bk:hover{color:#fff;border-color:#ec4899;box-shadow:0 0 26px -4px rgba(236,72,153,.8)}
.bk.off{opacity:0;pointer-events:none;transform:translateX(14px)}
.go-wrap{position:relative;display:inline-block;transform:translate(var(--mx,0px),var(--my,0px));transition:transform .25s ease-out}
.go{position:relative;display:inline-flex;align-items:center;gap:16px;padding:14px 18px 14px 32px;border-radius:9999px;overflow:hidden;color:#fff;text-decoration:none;font-size:17px;font-weight:800;letter-spacing:.04em;background:linear-gradient(110deg,#7c3aed,#ec4899,#f59e0b,#7c3aed);background-size:300% 100%;box-shadow:0 0 0 1px rgba(255,255,255,.25) inset,0 18px 44px -14px rgba(236,72,153,.85),0 0 54px -8px rgba(124,58,237,.7);animation:in-flow 6s linear infinite;transition:transform .3s cubic-bezier(.2,.9,.3,1.3),box-shadow .3s}
@keyframes in-flow{to{background-position:-300% 0}}
.go::after{content:"";position:absolute;top:0;bottom:0;left:-40%;width:30%;transform:skewX(-22deg);background:linear-gradient(90deg,transparent,rgba(255,255,255,.55),transparent);animation:in-shine 3s 2.6s ease-in-out infinite}
@keyframes in-shine{0%{left:-40%}55%,100%{left:130%}}
.go .arr{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;background:transparent;border:2px solid rgba(255,255,255,.95);color:#fff;animation:in-nudge 1.6s ease-in-out infinite}
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
.rj-fb .brand-logo,.rj-fb .tl,.rj-fb .ctrls{opacity:1!important}
.rj-fb #rjSky{display:none}

@media (max-width:560px){
.go{font-size:15px;padding:12px 14px 12px 26px}
.bk{padding:12px 16px}
.ctrls{gap:12px}
.tl{gap:28px}
.tl-n:not(:first-child)::before{width:28px}
}
@media (max-height:520px){.slides{min-height:0}.tl{margin-top:16px}.ctrls{margin-top:14px}}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('inStage');
if(!stage)return;
var running=true;
function fallback(){running=false;document.body.classList.add('rj-fb')}
try{
var INTRO=3.0;
var card=document.querySelector('.card');
var fit=document.getElementById('inFit');
var slides=[].slice.call(stage.querySelectorAll('.slide'));
var nodes=[].slice.call(stage.querySelectorAll('.tl-n'));
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
function gauss(){return (Math.random()+Math.random()+Math.random()-1.5)/1.5}

/* ---------- qalaktika: soldan saga axan ulduz sahesi ---------- */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,stars=[],gx=[],mx=0,my=0,tmx=0,tmy=0,lastT=0,burst=0;
var scols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4','#fde7ff'];

function buildStars(){
stars=[];
var n=Math.round(clamp(W*H/2600,260,720)),i,band;
for(i=0;i<n;i++){
band=Math.random()<.4;
var x=Math.random(),y=band?(.78-.5*x+gauss()*.1):Math.random();
var z=Math.pow(Math.random(),1.6)*1.4+.15;
stars.push({x:x,y:y,z:z,r:.35+z*.7+(Math.random()<.04?.8:0),ph:rnd(0,6.28),c:scols[(Math.random()*scols.length)|0]})
}
gx=[];
var gc=[['244,114,182'],['167,139,250'],['96,165,250'],['216,180,254'],['251,191,236']];
for(i=0;i<5;i++)gx.push({x:Math.random(),y:rnd(.1,.9),rx:rnd(40,90),ry:rnd(12,28),rot:rnd(-.8,.8),z:rnd(.12,.3),c:gc[i][0],a:rnd(.14,.26)})
}
function drawSky(t,dt){
var ib=Math.pow(clamp(1-t/2.6,0,1),2)*1.1;
var b=Math.max(burst,ib);
var spd=34+b*2500;
var fade=clamp(t/.9,0,1),i,s,X,Y,a,len;

/* Sud Yolu zolagi */
ctx.globalCompositeOperation='lighter';
ctx.save();
ctx.translate(W*.5,H*.5);ctx.rotate(-Math.atan2(H*.5,W)*.9);
var mg=ctx.createLinearGradient(0,-H*.3,0,H*.3);
mg.addColorStop(0,'rgba(167,139,250,0)');mg.addColorStop(.5,'rgba(216,180,254,'+(.1*fade).toFixed(3)+')');mg.addColorStop(1,'rgba(244,114,182,0)');
ctx.fillStyle=mg;ctx.fillRect(-W,-H*.3,W*2,H*.6);
ctx.restore();

/* uzaq qalaktikalar */
for(i=0;i<gx.length;i++){
var g=gx[i];
g.x+=spd*g.z*dt/W*.4;
if(g.x>1.2){g.x=-.2;g.y=rnd(.1,.9)}
var GX=g.x*W+mx*g.z*30,GY=g.y*H+my*g.z*20;
ctx.save();ctx.translate(GX,GY);ctx.rotate(g.rot);ctx.scale(1,g.ry/g.rx);
var rg=ctx.createRadialGradient(0,0,0,0,0,g.rx);
rg.addColorStop(0,'rgba(255,240,255,'+(g.a*1.6*fade).toFixed(3)+')');
rg.addColorStop(.25,'rgba('+g.c+','+(g.a*fade).toFixed(3)+')');
rg.addColorStop(1,'rgba('+g.c+',0)');
ctx.fillStyle=rg;ctx.beginPath();ctx.arc(0,0,g.rx,0,6.283);ctx.fill();
ctx.restore()
}
ctx.globalCompositeOperation='source-over';

/* ulduzlar */
for(i=0;i<stars.length;i++){
s=stars[i];
s.x+=spd*s.z*dt/W;
len=Math.min(260,spd*s.z*.06);
if(s.x*W-len>W+4){s.x=-len/W-.01;if(Math.random()<.6)s.y=Math.random()}
X=s.x*W+mx*s.z*16;Y=s.y*H+my*s.z*10;
a=fade*(.35+.55*(.5+.5*Math.sin(t*1.4*s.z+s.ph)));
if(len>3){
ctx.globalAlpha=Math.min(1,a+b*.35);
ctx.strokeStyle=s.c;ctx.lineWidth=s.r*.9+.2;ctx.lineCap='round';
ctx.beginPath();ctx.moveTo(X-len,Y);ctx.lineTo(X,Y);ctx.stroke()
}else{
ctx.globalAlpha=a;ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(X,Y,s.r,0,6.283);ctx.fill()
}
}
ctx.globalAlpha=1;

/* sürət zamanı parlaq iz */
if(b>.08){
ctx.globalCompositeOperation='lighter';
var fg=ctx.createRadialGradient(W/2,H*.5,0,W/2,H*.5,Math.max(W,H)*.6);
fg.addColorStop(0,'rgba(216,180,254,'+(Math.min(.2,b*.12)).toFixed(3)+')');
fg.addColorStop(1,'rgba(124,58,237,0)');
ctx.fillStyle=fg;ctx.fillRect(0,0,W,H);
ctx.globalCompositeOperation='source-over'
}
}

function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
if(!stars.length)buildStars();
var hb=card?card.getBoundingClientRect().bottom:120;
stage.style.paddingTop=(hb+10)+'px';
var availH=H-hb-20;
fit.style.transform='none';fit.style.marginTop='0';fit.style.marginBottom='0';
var nh=fit.offsetHeight,nw=fit.offsetWidth;
var sc=Math.max(.4,Math.min(1,availH/nh,(W-12)/nw));
fit.style.transform='scale('+sc+')';
fit.style.marginTop=Math.max(0,(availH-nh*sc)/2)+'px';
fit.style.marginBottom=(-(nh*(1-sc)))+'px';
}

/* ---------- zaman ---------- */
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
burst*=Math.pow(.955,dt*60);
ctx.clearRect(0,0,W,H);
drawSky(t,dt);
requestAnimationFrame(frame)
}catch(err){fallback()}
}

/* ---------- slaydlar ---------- */
var lock=false;
function urlOf(i){return slides[i].getAttribute('data-url')}
function ui(){
nodes.forEach(function(n,i){n.classList.toggle('done',i<idx);n.classList.toggle('cur',i===idx)});
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
burst=1;
ui();
try{history.replaceState(null,'',urlOf(idx))}catch(e){}
setTimeout(function(){lock=false},750)
}
function leave(){
var r=next.getBoundingClientRect(),w=document.createElement('div');
w.className='rj-wipe';
w.style.setProperty('--wx',(r.left+r.width/2)+'px');
w.style.setProperty('--wy',(r.top+r.height/2)+'px');
document.body.appendChild(w);
burst=1.6;
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
if(k==='ArrowRight'||k==='ArrowDown'||k==='PageDown'||((k===' '||k==='Enter')&&!onCtl)){
e.preventDefault();
if(idx<N-1)show(idx+1);else if(k==='Enter'||k===' ')leave()
}else if(k==='ArrowLeft'||k==='ArrowUp'||k==='PageUp'){e.preventDefault();show(idx-1)}
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
if(window.ResizeObserver){
if(card)new ResizeObserver(rs).observe(card);
new ResizeObserver(rs).observe(document.getElementById('inSlides'))
}
var imgs=document.querySelectorAll('.intro img,.brand-logo');
for(var m=0;m<imgs.length;m++)imgs[m].addEventListener('load',rs);
layout();ui();
setTimeout(layout,350);setTimeout(layout,1200);
setTimeout(function(){stage.classList.remove('boot')},3200);
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
