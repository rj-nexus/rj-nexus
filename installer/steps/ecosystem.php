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

$body = '<div class="eco" id="ecoStage">'
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
    . '</div>'
    . '<div class="eco-cta"><a id="ecoGo" class="btn" href="' . rj_installer_url('step=intro&slide=1') . '">' . rj_esc($t['next'] ?? 'Continue') . '</a></div>'
    . '</div>';

$extra = <<<'HTML'
<noscript><style>.card{position:static!important;transform:none!important;pointer-events:auto!important}.brand-logo,.card p.sub,.steps{opacity:1!important;animation:none!important}.eco{position:static!important;padding:0!important}.node,.tag,.eco-cta,.eco-desc{animation:none!important}#ecoLines{display:none}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;overscroll-behavior:none}
body{display:block;padding:0;min-height:100vh}
html,body,.card,.eco{-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
::selection{background:transparent;color:inherit}
img{-webkit-user-drag:none;user-drag:none}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 2.4s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(14px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.26),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.2),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.18),transparent 70%);animation:rj-neb 40s ease-in-out infinite alternate,rj-bg 3s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-2%,0,0) rotate(0) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

/* header (same as language step) */
.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(56px,10vh,92px);width:auto;margin:0 auto 6px;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(167,139,250,.55));animation:rj-logo 1.5s .5s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-logo{from{opacity:0;transform:translateY(10px) scale(.82);filter:blur(14px) drop-shadow(0 0 22px rgba(167,139,250,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.55))}}
.card h1{display:none}
.card p.sub{text-align:center;margin-bottom:0;opacity:0;animation:rj-up 1s 1.1s both}
.steps{justify-content:center;margin:10px 0 2px;opacity:0;animation:rj-up 1s 1.3s both}
.steps .line{flex:0 0 26px}
@keyframes rj-up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}

/* stage */
.eco{position:fixed;inset:0;z-index:3;overflow-y:auto;overflow-x:hidden;padding:200px 18px 36px;display:flex;flex-direction:column;align-items:center;-webkit-overflow-scrolling:touch}
.eco-desc{max-width:600px;text-align:center;font-size:14px;line-height:1.65;color:#a5acc6;margin:0 auto;animation:rj-up 1s 1.4s backwards}
.eco-flow{position:relative;display:grid;grid-template-columns:1fr 1.15fr 1fr;align-items:center;gap:clamp(48px,9vw,120px);width:100%;max-width:880px;margin:30px auto 8px}
#ecoLines{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:0}
.node{position:relative;z-index:1;text-align:center;padding:16px 14px;border-radius:20px;background:rgba(24,16,58,.62);border:1px solid rgba(168,85,247,.28);-webkit-backdrop-filter:blur(12px);backdrop-filter:blur(12px);box-shadow:0 16px 38px -18px rgba(110,80,240,.8);animation:rj-pop .95s var(--d,0s) cubic-bezier(.2,.9,.25,1.15) backwards;transition:transform .3s,border-color .3s,box-shadow .3s}
.node img{display:block;margin:0 auto 8px;max-width:100%;-webkit-user-drag:none}
.node b{display:block;font-size:12px;font-weight:800;letter-spacing:.08em}
.node span{display:block;font-size:10px;margin-top:2px}
@keyframes rj-pop{0%{opacity:0;transform:translateY(40px) scale(.82);filter:blur(8px)}60%{filter:blur(0)}100%{opacity:1;transform:none;filter:blur(0)}}
.legacy{--d:1.6s}
.legacy img{height:34px;opacity:.7;filter:grayscale(100%)}
.legacy b{color:#9ca3af}.legacy span{color:#6b7280}
.core{--d:2.3s;padding:24px 18px;border-color:#a855f7;background:linear-gradient(160deg,rgba(124,58,237,.35),rgba(236,72,153,.2));box-shadow:0 0 50px -8px rgba(168,85,247,.75),0 18px 40px -18px rgba(236,72,153,.6)}
.core img{height:46px;margin-bottom:10px}
.core b{color:#e9d5ff;font-size:13px}.core span{color:#d8b4fe}
.core .halo{position:absolute;inset:-1px;border-radius:20px;pointer-events:none;animation:rj-ring 2.8s 3.4s ease-out infinite}
@keyframes rj-ring{0%{box-shadow:0 0 0 0 rgba(236,72,153,.5)}100%{box-shadow:0 0 0 24px rgba(236,72,153,0)}}
.premium{display:flex;flex-direction:column;gap:12px}
.pnode{padding:12px 10px}
.pnode:nth-child(1){--d:2.9s}.pnode:nth-child(2){--d:3.1s}.pnode:nth-child(3){--d:3.3s}
.pnode img{height:24px;margin-bottom:6px;opacity:.9}
.pnode em{display:block;font-style:normal;font-size:11px;color:#c4b5fd}
.pnode:hover{transform:translateY(-3px);border-color:#ec4899;box-shadow:0 18px 40px -12px rgba(236,72,153,.7)}
.eco-tags{display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-top:22px}
.tag{display:inline-flex;align-items:center;gap:8px;font-size:11px;letter-spacing:.04em;color:#d1d5db;padding:7px 14px;border-radius:9999px;background:rgba(24,16,58,.6);border:1px solid rgba(168,85,247,.28);animation:rj-up .9s backwards}
.tag i{width:7px;height:7px;border-radius:50%;background:#a78bfa;box-shadow:0 0 10px #a78bfa}
.t1{animation-delay:3.6s}.t2{animation-delay:3.75s}.t2 i{background:#f472b6;box-shadow:0 0 10px #f472b6}
.eco-cta{margin-top:26px;animation:rj-pop 1s 3.9s cubic-bezier(.2,.9,.25,1.15) backwards}
.eco-cta .btn{padding:13px 34px;border-radius:12px;box-shadow:0 14px 34px -12px rgba(236,72,153,.7)}
.eco-cta .btn:hover{opacity:1;transform:translateY(-2px);box-shadow:0 18px 42px -10px rgba(236,72,153,.9)}
.eco-cta .btn{transition:transform .25s,box-shadow .25s}

/* leave wipe */
.rj-wipe{position:fixed;inset:0;z-index:30;pointer-events:none;background:radial-gradient(circle at var(--wx,50%) var(--wy,50%),#fff 0%,#e9d5ff 30%,#a78bfa 62%,#7c3aed 100%);clip-path:circle(0% at var(--wx,50%) var(--wy,50%));transition:clip-path .8s cubic-bezier(.65,0,.25,1)}
.rj-wipe.on{clip-path:circle(150% at var(--wx,50%) var(--wy,50%))}

/* JS failure fallback: everything static and visible */
.rj-fb *{animation:none!important}
.rj-fb .brand-logo,.rj-fb .card p.sub,.rj-fb .steps{opacity:1!important}
.rj-fb #ecoLines,.rj-fb #rjSky{display:none}

@media (max-width:720px){
.eco{padding-top:190px}
.eco-flow{grid-template-columns:1fr;gap:54px;max-width:420px}
.premium{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.pnode img{height:20px}
.pnode em{font-size:10px}
}
@media (max-height:520px){
.card p.sub,.steps{display:none}.card{top:8px}.brand-logo{height:36px;margin-bottom:2px}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('ecoStage');
if(!stage)return;
function fallback(){document.body.classList.add('rj-fb');running=false}
var running=true;
try{
var card=document.querySelector('.card');
var flow=document.getElementById('ecoFlow');
var lc=document.getElementById('ecoLines');
var lctx=lc.getContext('2d');
document.body.appendChild(stage);
document.addEventListener('selectstart',function(e){e.preventDefault()});
document.addEventListener('dragstart',function(e){e.preventDefault()});

/* background stars */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,stars=[],shoot=null,nextShoot=2.5;
function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
var cols=['255,255,255','196,181,253','147,197,253','249,168,212'];

var edges=[],FW=0,FH=0;
function layoutHead(){
var b=card?card.getBoundingClientRect().bottom:120;
stage.style.paddingTop=(b+22)+'px'
}
function rect(el){
var r=el.getBoundingClientRect(),f=flow.getBoundingClientRect();
return{l:r.left-f.left,t:r.top-f.top,r:r.right-f.left,b:r.bottom-f.top,cx:r.left-f.left+r.width/2,cy:r.top-f.top+r.height/2}
}
function mkEdge(a,b){
var A=rect(a),B=rect(b),h;
if(B.l>A.r-6){h=(B.l-A.r)*.5;return[[A.r,A.cy],[A.r+h,A.cy],[B.l-h,B.cy],[B.l,B.cy]]}
if(B.r<A.l+6){h=(A.l-B.r)*.5;return[[A.l,A.cy],[A.l-h,A.cy],[B.r+h,B.cy],[B.r,B.cy]]}
h=(B.t-A.b)*.5;
return[[A.cx,A.b],[A.cx,A.b+h],[B.cx,B.t-h],[B.cx,B.t]]
}
function layout(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var n=Math.round(clamp(W*H/6500,80,240));
if(!stars.length||Math.abs(n-stars.length)>30){
stars=[];
for(var i=0;i<n;i++)stars.push({x:Math.random(),y:Math.random(),r:rnd(.4,1.5),ph:rnd(0,6.28),sp:rnd(.00002,.00009),c:cols[(Math.random()*cols.length)|0]})
}
layoutHead();
var fr=flow.getBoundingClientRect();
FW=fr.width;FH=fr.height;
lc.width=FW*dpr;lc.height=FH*dpr;
lctx.setTransform(dpr,0,0,dpr,0,0);
var ns=flow.querySelectorAll('.node'),legacy=ns[0],core=ns[1],pn=flow.querySelectorAll('.pnode');
edges=[{p:mkEdge(legacy,core),s:1.9,d:.8,c:'167,139,250'}];
for(var k=0;k<pn.length;k++)edges.push({p:mkEdge(core,pn[k]),s:2.6+k*.2,d:.8,c:'244,114,182'})
}
function bez(p,u){
var v=1-u,a=v*v*v,b=3*v*v*u,c=3*v*u*u,d=u*u*u;
return[a*p[0][0]+b*p[1][0]+c*p[2][0]+d*p[3][0],a*p[0][1]+b*p[1][1]+c*p[2][1]+d*p[3][1]]
}

var T0=performance.now(),off=0;
function tNow(){return(performance.now()-T0)/1000+off}
function skip(){
var t=tNow();
if(t>4.4)return;
off+=4.4-t;
try{
document.getAnimations().forEach(function(a){
try{if(a.effect.getComputedTiming().iterations!==Infinity)a.finish()}catch(e){}
})
}catch(e){}
}
window.addEventListener('keydown',skip);
window.addEventListener('pointerdown',function(e){if(!(e.target.closest&&e.target.closest('#ecoGo')))skip()});

function drawBg(t){
ctx.clearRect(0,0,W,H);
var fade=clamp(t/1.2,0,1);
for(var i=0;i<stars.length;i++){
var s=stars[i];
s.y-=s.sp;if(s.y<-.02){s.y=1.02;s.x=Math.random()}
ctx.globalAlpha=fade*(.35+.55*(.5+.5*Math.sin(t*1.2+s.ph)));
ctx.fillStyle='rgba('+s.c+',1)';
ctx.beginPath();ctx.arc(s.x*W,s.y*H,s.r,0,6.283);ctx.fill()
}
ctx.globalAlpha=1;
if(t>nextShoot&&!shoot){
shoot={x:rnd(.2,.9)*W,y:rnd(0,.35)*H,vx:-rnd(7,10),vy:rnd(3.5,5.5),l:0};
nextShoot=t+rnd(4,8)
}
if(shoot){
shoot.x+=shoot.vx;shoot.y+=shoot.vy;shoot.l+=.02;
var a=1-shoot.l;
if(a<=0||shoot.x<-80||shoot.y>H+80){shoot=null}
else{
var g=ctx.createLinearGradient(shoot.x,shoot.y,shoot.x-shoot.vx*9,shoot.y-shoot.vy*9);
g.addColorStop(0,'rgba(255,255,255,'+a+')');g.addColorStop(1,'rgba(167,139,250,0)');
ctx.strokeStyle=g;ctx.lineWidth=1.6;
ctx.beginPath();ctx.moveTo(shoot.x,shoot.y);ctx.lineTo(shoot.x-shoot.vx*9,shoot.y-shoot.vy*9);ctx.stroke()
}
}
}
function drawLines(t){
lctx.clearRect(0,0,FW,FH);
lctx.globalCompositeOperation='lighter';
for(var i=0;i<edges.length;i++){
var e=edges[i],p=clamp((t-e.s)/e.d,0,1);
if(p<=0)continue;
var pe=1-Math.pow(1-p,3),steps=48,last=Math.max(2,Math.round(steps*pe));
lctx.strokeStyle='rgba('+e.c+',.38)';lctx.lineWidth=1.6;
lctx.beginPath();
for(var j=0;j<=last;j++){var q=bez(e.p,pe*j/last);if(j===0)lctx.moveTo(q[0],q[1]);else lctx.lineTo(q[0],q[1])}
lctx.stroke();
var hd=bez(e.p,pe);
lctx.fillStyle='rgba(255,255,255,'+(p<1?.9:0)+')';
if(p<1){lctx.beginPath();lctx.arc(hd[0],hd[1],3.2,0,6.283);lctx.fill()}
if(p>=1){
for(var k=0;k<3;k++){
var u=((t-e.s-e.d)*.22+k/3+i*.17)%1,q2=bez(e.p,u<0?u+1:u);
lctx.fillStyle='rgba(255,255,255,.9)';
lctx.beginPath();lctx.arc(q2[0],q2[1],2.4,0,6.283);lctx.fill();
lctx.fillStyle='rgba('+e.c+',.22)';
lctx.beginPath();lctx.arc(q2[0],q2[1],7,0,6.283);lctx.fill()
}
}
}
lctx.globalCompositeOperation='source-over'
}
function frame(){
if(!running)return;
try{
var t=tNow();
drawBg(t);drawLines(t);
requestAnimationFrame(frame)
}catch(err){fallback()}
}

var rt=0;
function rs(){clearTimeout(rt);rt=setTimeout(layout,60)}
window.addEventListener('resize',rs);
window.addEventListener('orientationchange',function(){setTimeout(layout,150);setTimeout(layout,450)});
if(window.visualViewport)window.visualViewport.addEventListener('resize',rs);
if(window.ResizeObserver){new ResizeObserver(rs).observe(card);new ResizeObserver(rs).observe(flow)}
var imgs=flow.querySelectorAll('img');
for(var m=0;m<imgs.length;m++)imgs[m].addEventListener('load',rs);
layout();
setTimeout(layout,350);
setTimeout(layout,1200);
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running&&!document.body.classList.contains('rj-fb')){running=true;requestAnimationFrame(frame)}
});
requestAnimationFrame(frame);

/* continue: ripple wipe then navigate */
var go=document.getElementById('ecoGo');
go.addEventListener('click',function(e){
if(e.metaKey||e.ctrlKey||e.shiftKey||e.button!==0)return;
e.preventDefault();
var r=go.getBoundingClientRect(),w=document.createElement('div');
w.className='rj-wipe';
w.style.setProperty('--wx',(r.left+r.width/2)+'px');
w.style.setProperty('--wy',(r.top+r.height/2)+'px');
document.body.appendChild(w);
requestAnimationFrame(function(){requestAnimationFrame(function(){w.classList.add('on')})});
setTimeout(function(){window.location.href=go.href},820)
})
}catch(err){fallback()}
});
</script>
HTML;

rj_render('ecosystem', $body, $extra);
exit;
