<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

// Default language is English (installer + admin panel start with it)
if (empty($state['lang']) || !isset(rj_languages()[$state['lang']])) {
    $state['lang'] = 'en';
    rj_set_state(array_merge(rj_state(), ['lang' => 'en']));
}
$selectedLang = $state['lang'];

// English always first
$langs = rj_languages();
if (isset($langs['en'])) {
    $langs = ['en' => $langs['en']] + $langs;
}

$idx = 0;
$buttons = '';

foreach ($langs as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $buttons .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn planet' . $active . '" data-name="' . rj_esc($label) . '" style="--i:' . $idx . '">'
        . '<span class="chip"><b class="cd">' . rj_esc(strtoupper($code)) . '</b><i class="nm">' . rj_esc($label) . '</i><em class="ck">&#10003;</em></span>'
        . '</button>';
    $idx++;
}

$body = '<p class="rj-lead">' . rj_esc($t['lang']) . '</p>'
    . '<form method="post" class="langs rj-stage" id="rjStage"><div class="rj-grid">' . $buttons . '</div></form>';

$extra = <<<'HTML'
<noscript><style>.rj-stage{position:static!important;overflow:visible!important}.planet,.rj-lead,.card h1,.card p.sub,.steps,.brand-logo{opacity:1!important;animation:none!important}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f}
body{display:block;padding:0;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 40%,#1a1248 0%,#0c0929 55%,#05040f 100%);animation:rj-fade 1.6s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(30px);background:radial-gradient(38% 32% at 22% 28%,rgba(139,92,246,.30),transparent 70%),radial-gradient(34% 30% at 80% 22%,rgba(236,72,153,.22),transparent 70%),radial-gradient(42% 36% at 62% 88%,rgba(59,130,246,.20),transparent 70%);animation:rj-aurora 28s ease-in-out infinite alternate,rj-fade 2.4s .2s ease-out both}
@keyframes rj-fade{from{opacity:0}to{opacity:1}}
@keyframes rj-aurora{from{transform:translate3d(-3%,0,0) rotate(0) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(6deg) scale(1.1)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}

/* header */
.card{position:fixed;top:clamp(14px,3vh,30px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:26px;margin:0 auto 6px;opacity:0;animation:rj-up 1s 1.1s both}
.card h1{text-align:center;font-size:clamp(28px,4.4vw,44px);font-weight:800;margin-bottom:0;background:linear-gradient(90deg,#e0e7ff,#fff,#fbcfe8,#c4b5fd,#e0e7ff);background-size:300% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;opacity:0;animation:rj-title 1.5s 1.1s cubic-bezier(.2,.8,.2,1) both,rj-shine 9s 2.8s linear infinite}
.card p.sub{text-align:center;margin-bottom:0;opacity:0;animation:rj-up 1s 1.7s both}
.steps{justify-content:center;margin:10px 0 2px;opacity:0;animation:rj-up 1s 1.9s both}
.steps .line{flex:0 0 26px}
@keyframes rj-title{from{opacity:0;letter-spacing:.5em;filter:blur(14px);transform:translateY(8px) scale(.96)}to{opacity:1;letter-spacing:.02em;filter:blur(0);transform:none}}
@keyframes rj-shine{to{background-position:-300% 0}}
@keyframes rj-up{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
.rj-lead{position:fixed;left:0;right:0;z-index:4;text-align:center;font-size:12px;color:#a5b4fc;letter-spacing:.22em;text-transform:uppercase;margin:0;opacity:0;animation:rj-up 1s 2.1s both;pointer-events:none}

/* language grid */
.rj-stage{position:fixed;inset:0;z-index:3;display:block;margin:0;overflow-y:auto;overflow-x:hidden;padding:190px 18px 40px;-webkit-overflow-scrolling:touch}
.rj-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:14px;max-width:980px;margin:0 auto;min-height:100%;align-content:flex-start}
.planet{position:relative;display:block;margin:0;padding:0;border:0;background:none;cursor:pointer;perspective:700px;text-align:center;opacity:0;animation:rj-pop .95s calc(2.3s + var(--i)*.075s) cubic-bezier(.2,.9,.25,1.15) both;-webkit-tap-highlight-color:transparent}
.planet::before{display:none}
@keyframes rj-pop{0%{opacity:0;transform:translateY(46px) scale(.82) rotateX(-35deg);filter:blur(8px)}60%{filter:blur(0)}100%{opacity:1;transform:none;filter:blur(0)}}
.chip{position:relative;display:flex;align-items:center;gap:12px;min-width:170px;white-space:nowrap;padding:12px 18px 12px 12px;border-radius:18px;color:#e5e7eb;background:rgba(24,16,58,.62);border:1px solid rgba(168,85,247,.28);-webkit-backdrop-filter:blur(12px);backdrop-filter:blur(12px);box-shadow:0 14px 34px -16px rgba(110,80,240,.8);overflow:hidden;transform:rotateX(var(--rx,0deg)) rotateY(var(--ry,0deg));transition:transform .18s ease-out,border-color .3s,box-shadow .3s,background .3s}
.chip::after{content:"";position:absolute;inset:0;pointer-events:none;opacity:0;transition:opacity .3s;background:radial-gradient(180px circle at var(--mx,50%) var(--my,50%),rgba(255,255,255,.18),transparent 60%)}
.chip .cd{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:34px;padding:0 8px;border-radius:11px;font-size:12px;font-weight:800;letter-spacing:.08em;font-style:normal;color:#c4b5fd;background:rgba(168,85,247,.18);border:1px solid rgba(168,85,247,.35);transition:.3s}
.chip .nm{font-style:normal;font-size:14px;font-weight:600;flex:1;text-align:left}
.chip .ck{font-style:normal;font-size:13px;width:20px;height:20px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);opacity:0;transform:scale(.3);transition:.35s cubic-bezier(.2,.9,.3,1.4)}
.planet:hover .chip,.planet:focus-visible .chip{border-color:#c084fc;background:rgba(60,30,110,.78);box-shadow:0 18px 44px -12px rgba(192,132,252,.75)}
.planet:hover .chip::after{opacity:1}
.planet:focus-visible{outline:none}
.planet.active .chip{border-color:#ec4899;background:linear-gradient(135deg,rgba(124,58,237,.55),rgba(236,72,153,.4));box-shadow:0 0 36px -6px rgba(236,72,153,.7);animation:rj-glow 2.8s ease-in-out infinite}
.planet.active .chip .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.planet.active .chip .ck{opacity:1;transform:none}
@keyframes rj-glow{50%{box-shadow:0 0 54px -2px rgba(236,72,153,.9)}}

/* selection transition */
.rj-wipe{position:fixed;inset:0;z-index:30;pointer-events:none;background:radial-gradient(circle at var(--wx,50%) var(--wy,50%),#fff 0%,#e9d5ff 30%,#a78bfa 62%,#7c3aed 100%);clip-path:circle(0% at var(--wx,50%) var(--wy,50%));transition:clip-path .85s cubic-bezier(.65,0,.25,1)}
.rj-wipe.on{clip-path:circle(150% at var(--wx,50%) var(--wy,50%))}
.rj-leave .planet:not(.chosen){opacity:0!important;transform:scale(.85) translateY(10px);transition:opacity .45s,transform .45s;animation:none}
.rj-leave .planet.chosen{animation:none;opacity:1;transform:scale(1.12);transition:transform .5s cubic-bezier(.2,.9,.3,1.2)}
.rj-leave .card,.rj-leave .rj-lead{opacity:0;transition:opacity .5s}
.rj-fast .planet,.rj-fast .card h1,.rj-fast .card p.sub,.rj-fast .steps,.rj-fast .brand-logo,.rj-fast .rj-lead{animation-delay:0s!important;animation-duration:.35s!important}

@media (max-width:640px){
.rj-stage{padding:170px 14px 30px}
.rj-grid{gap:10px}
.planet{flex:0 0 calc(50% - 5px)}
.chip{min-width:0;width:100%;padding:10px 12px 10px 10px;gap:9px}
.chip .nm{font-size:13px;overflow:hidden;text-overflow:ellipsis}
.chip .ck{display:none}
}
@media (prefers-reduced-motion:reduce){body::before,body::after,.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.planet,.planet.active .chip{animation:none!important}.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.planet{opacity:1}.rj-wipe{transition:none}}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('rjStage');
if(!stage)return;
var lead=document.querySelector('.rj-lead');
if(lead)document.body.appendChild(lead);
document.body.appendChild(stage);
var card=document.querySelector('.card');
var planets=[].slice.call(stage.querySelectorAll('.planet'));
var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;

/* layout: keep grid below header */
function layout(){
var b=card?card.getBoundingClientRect().bottom:120;
stage.style.paddingTop=(b+54)+'px';
if(lead)lead.style.top=(b+16)+'px';
}
layout();
window.addEventListener('resize',layout);
setTimeout(layout,400);

/* particle field */
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var ctx=cv.getContext('2d');
var W=0,H=0,dpr=1,P=[],mx=-9999,my=-9999,t0=0,running=true;
var cols=['196,181,253','249,168,212','147,197,253','255,255,255'];
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function easeOut(x){return 1-Math.pow(1-x,3)}
function resize(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var n=Math.round(clamp(W*H/15000,36,120));
P=[];
for(var i=0;i<n;i++){
P.push({hx:Math.random()*W,hy:Math.random()*H,vx:(Math.random()-.5)*.22,vy:(Math.random()-.5)*.22,r:Math.random()*1.6+.6,c:cols[(Math.random()*cols.length)|0],d:Math.random()*.5,ox:0,oy:0})
}
}
resize();
window.addEventListener('resize',resize);
window.addEventListener('pointermove',function(e){mx=e.clientX;my=e.clientY});
window.addEventListener('pointerleave',function(){mx=-9999;my=-9999});

var rings=[];
function frame(now){
if(!running)return;
if(!t0)t0=now;
var t=(now-t0)/1000;
ctx.clearRect(0,0,W,H);
var cx=W/2,cy=H*.42;
/* soft expanding rings at intro */
if(!reduce){
for(var r=0;r<3;r++){
var rt=(t-.3-r*.35)/1.8;
if(rt>0&&rt<1){
var rad=easeOut(rt)*Math.max(W,H)*.65;
ctx.strokeStyle='rgba('+(r===1?'244,114,182':'167,139,250')+','+((1-rt)*.35).toFixed(3)+')';
ctx.lineWidth=1.5;
ctx.beginPath();ctx.arc(cx,cy,rad,0,6.283);ctx.stroke()
}
}
}
var ip=reduce?1:easeOut(clamp((t-.2)/2.4,0,1));
var pos=[];
for(var i=0;i<P.length;i++){
var p=P[i];
p.hx+=p.vx;p.hy+=p.vy;
if(p.hx<-20)p.hx=W+20;else if(p.hx>W+20)p.hx=-20;
if(p.hy<-20)p.hy=H+20;else if(p.hy>H+20)p.hy=-20;
var dx=p.hx-mx,dy=p.hy-my,dd=dx*dx+dy*dy,tx=0,ty=0;
if(dd<16000){var f=(1-dd/16000)*26,dl=Math.sqrt(dd)||1;tx=dx/dl*f;ty=dy/dl*f}
p.ox+=(tx-p.ox)*.08;p.oy+=(ty-p.oy)*.08;
var e=clamp(ip*(1+p.d)-p.d*.5,0,1);
var x=cx+(p.hx-cx)*e+p.ox,y=cy+(p.hy-cy)*e+p.oy;
pos.push([x,y,e]);
ctx.fillStyle='rgba('+p.c+','+(.75*e).toFixed(3)+')';
ctx.beginPath();ctx.arc(x,y,p.r,0,6.283);ctx.fill()
}
ctx.lineWidth=.8;
var maxD=W<700?90:130,m2=maxD*maxD;
for(var a=0;a<pos.length;a++){
for(var b=a+1;b<pos.length;b++){
var ddx=pos[a][0]-pos[b][0],ddy=pos[a][1]-pos[b][1],d2=ddx*ddx+ddy*ddy;
if(d2<m2){
var al=(1-d2/m2)*.22*Math.min(pos[a][2],pos[b][2]);
ctx.strokeStyle='rgba(167,139,250,'+al.toFixed(3)+')';
ctx.beginPath();ctx.moveTo(pos[a][0],pos[a][1]);ctx.lineTo(pos[b][0],pos[b][1]);ctx.stroke()
}
}
}
requestAnimationFrame(frame)
}
requestAnimationFrame(frame);
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;requestAnimationFrame(frame)}
});

/* skip intro on early interaction */
var skipped=false;
function skip(){
if(skipped)return;skipped=true;
if(performance.now()<3200)document.body.classList.add('rj-fast')
}
window.addEventListener('keydown',skip);

/* card tilt + spotlight */
planets.forEach(function(el){
var chip=el.querySelector('.chip');
el.addEventListener('mousemove',function(e){
var r=el.getBoundingClientRect(),px=(e.clientX-r.left)/r.width,py=(e.clientY-r.top)/r.height;
chip.style.setProperty('--ry',((px-.5)*14).toFixed(2)+'deg');
chip.style.setProperty('--rx',((.5-py)*14).toFixed(2)+'deg');
chip.style.setProperty('--mx',(px*100).toFixed(1)+'%');
chip.style.setProperty('--my',(py*100).toFixed(1)+'%')
});
el.addEventListener('mouseleave',function(){
chip.style.setProperty('--rx','0deg');chip.style.setProperty('--ry','0deg')
})
});

/* selection: ripple wipe, then submit */
var go=false;
stage.addEventListener('submit',function(e){
if(go)return;
var b=e.submitter;
if(!b||!b.value||reduce)return;
e.preventDefault();
go=true;
var r=b.getBoundingClientRect();
var h=document.createElement('input');
h.type='hidden';h.name='rj_lang';h.value=b.value;
stage.appendChild(h);
b.classList.add('chosen');
var w=document.createElement('div');
w.className='rj-wipe';
w.style.setProperty('--wx',(r.left+r.width/2)+'px');
w.style.setProperty('--wy',(r.top+r.height/2)+'px');
document.body.appendChild(w);
document.body.classList.add('rj-leave');
requestAnimationFrame(function(){requestAnimationFrame(function(){w.classList.add('on')})});
setTimeout(function(){stage.submit()},900)
});
});
</script>
HTML;

rj_render('language', $body, $extra);
exit;
