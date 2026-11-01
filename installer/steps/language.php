<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$langs = rj_languages();
$n = count($langs);
$nIn = (int) round($n * 0.45);
$nOut = $n - $nIn;
$o1 = '';
$o2 = '';
$idx = 0;

foreach ($langs as $code => $label) {
    $inner = $idx < $nIn;
    $pos = $inner ? $idx : $idx - $nIn;
    $cnt = $inner ? $nIn : $nOut;
    $ang = round(360 / max(1, $cnt) * $pos + ($inner ? 0 : 180 / max(1, $cnt)) - 90, 2);
    $active = $code === $selectedLang ? ' active' : '';

    $html = '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn planet' . $active . '" style="--a:' . $ang . 'deg;--i:' . $idx . '">'
        . '<span class="pc"><span class="pi"><span class="chip">'
        . '<b class="cd">' . rj_esc(strtoupper($code)) . '</b>'
        . '<i class="nm">' . rj_esc($label) . '</i>'
        . '</span></span></span></button>';

    if ($inner) {
        $o1 .= $html;
    } else {
        $o2 .= $html;
    }
    $idx++;
}

$body = '<p class="rj-lead">' . rj_esc($t['lang']) . '</p>'
    . '<form method="post" class="langs rj-stage" id="rjStage">'
    . '<div class="rj-core" id="rjCore"><div class="g"></div><div class="rg c"></div><div class="rg b"></div><div class="rg a"></div><div class="ry"></div><div class="ry r2"></div><div class="co"></div></div>'
    . '<div class="rj-orbits"><div class="track t1"></div><div class="track t2"></div>'
    . '<div class="orbit o1">' . $o1 . '</div><div class="orbit o2">' . $o2 . '</div></div>'
    . '</form>';

$extra = <<<'HTML'
<style>
html,body{background:#05040f}
body{overflow-x:hidden}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 40%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 3s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(14px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.26),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.2),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.18),transparent 70%);animation:rj-neb 40s ease-in-out infinite alternate,rj-bg 4s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-2%,0,0) rotate(0) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}
.rj-flash{position:fixed;inset:0;z-index:9;pointer-events:none;opacity:0;background:radial-gradient(circle at 50% 50%,#fff 0%,rgba(200,210,255,.85) 35%,rgba(120,100,255,.4) 70%);animation:rj-boom 1.6s .5s ease-out both}
.rj-flash.on{animation:none;opacity:1;transition:opacity .9s ease-in}
@keyframes rj-boom{0%{opacity:0}14%{opacity:.95}100%{opacity:0}}
.card{position:relative;z-index:2;max-width:900px;background:none;border:0;box-shadow:none;padding:0;overflow:visible}
.brand-logo{margin:0 auto 6px;opacity:0;animation:rj-up 1s 1.3s both}
.card h1{text-align:center;font-size:clamp(30px,5vw,46px);font-weight:800;margin-bottom:2px;background:linear-gradient(90deg,#e0e7ff,#fff,#fbcfe8,#c4b5fd,#e0e7ff);background-size:300% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;filter:drop-shadow(0 0 22px rgba(167,139,250,.5));opacity:0;animation:rj-title 1.6s 1.1s cubic-bezier(.2,.8,.2,1) both,rj-shine 8s 2.7s linear infinite}
.card p.sub{text-align:center;margin-bottom:10px;opacity:0;animation:rj-up 1s 1.6s both}
.steps{justify-content:center;opacity:0;animation:rj-up 1s 1.9s both}
.steps .line{flex:0 0 28px}
@keyframes rj-title{from{opacity:0;letter-spacing:.6em;filter:blur(16px) drop-shadow(0 0 22px rgba(167,139,250,.5))}to{opacity:1;letter-spacing:.02em;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.5))}}
@keyframes rj-shine{to{background-position:-300% 0}}
@keyframes rj-up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
.rj-lead{text-align:center;font-size:14px;color:#a5b4fc;letter-spacing:.14em;text-transform:uppercase;margin:6px 0 0;opacity:0;animation:rj-up 1s 2.1s both}
.rj-stage{--s:clamp(520px,min(92vw,660px,calc(100vh - 270px)),660px);--r1:calc(var(--s) * .25);--r2:calc(var(--s) * .42);position:relative;display:block;width:var(--s);height:var(--s);margin:0 auto}
.rj-core{position:absolute;left:50%;top:50%;width:150px;height:150px;margin:-75px 0 0 -75px;cursor:pointer;z-index:3;transform:translate3d(calc(var(--ax,0) * 10px),calc(var(--ay,0) * 7px),0);animation:rj-corein 1.4s .5s cubic-bezier(.2,1.2,.3,1) both}
@keyframes rj-corein{from{opacity:0;transform:scale(.05)}to{opacity:1;transform:none}}
.rj-core .g{position:absolute;inset:-150px;border-radius:9999px;pointer-events:none;background:radial-gradient(circle,rgba(200,215,255,.55) 0%,rgba(150,130,255,.22) 28%,rgba(0,0,0,0) 62%);animation:rj-breathe 5s ease-in-out infinite}
@keyframes rj-breathe{0%,100%{transform:scale(.88);opacity:.75}50%{transform:scale(1.12);opacity:1}}
.rj-core .ry{position:absolute;inset:0;pointer-events:none;animation:rj-spin 20s linear infinite}
.rj-core .ry::before,.rj-core .ry::after{content:"";position:absolute;left:50%;top:50%;transform:translate(-50%,-50%)}
.rj-core .ry::before{width:360px;height:2px;background:linear-gradient(90deg,transparent,rgba(255,255,255,.95),transparent)}
.rj-core .ry::after{width:2px;height:360px;background:linear-gradient(180deg,transparent,rgba(255,255,255,.95),transparent)}
.rj-core .ry.r2{animation-duration:34s;animation-direction:reverse;opacity:.55;transform:scale(.72)}
.rj-core .rg{position:absolute;border-radius:9999px;pointer-events:none;animation:rj-spin 26s linear infinite}
.rj-core .rg.a{inset:30px;border:1px dashed rgba(190,200,255,.4)}
.rj-core .rg.b{inset:6px;border:1px solid rgba(244,114,182,.26);animation-duration:40s;animation-direction:reverse}
.rj-core .rg.c{inset:-24px;border:1px dashed rgba(147,197,253,.2);animation-duration:60s}
.rj-core .rg::after{content:"";position:absolute;top:-3px;left:50%;width:6px;height:6px;margin-left:-3px;border-radius:9999px;background:#a78bfa;box-shadow:0 0 12px 3px #a78bfa}
.rj-core .rg.b::after{background:#f472b6;box-shadow:0 0 12px 3px #f472b6}
.rj-core .rg.c::after{background:#93c5fd;box-shadow:0 0 12px 3px #93c5fd}
.rj-core .co{position:absolute;left:50%;top:50%;width:52px;height:45px;margin:-22px 0 0 -26px;border-radius:9999px;background:radial-gradient(circle at 40% 36%,#fff 0%,#eef3ff 42%,#b6c9ff 100%);box-shadow:0 0 26px 10px rgba(255,255,255,.85),0 0 80px 32px rgba(150,180,255,.6);animation:rj-pulse 4s ease-in-out infinite;transition:transform .3s}
.rj-core:hover .co{transform:scale(1.18)}
@keyframes rj-pulse{0%,100%{filter:brightness(1)}50%{filter:brightness(1.2)}}
@keyframes rj-spin{to{transform:rotate(360deg)}}
.rj-core.hyper .ry{animation-duration:1.2s}
.rj-core.hyper .ry.r2{animation-duration:2s}
.rj-core.hyper .rg{animation-duration:2.6s}
.rj-core.hyper .co{animation:rj-hyper .3s ease-in-out infinite}
@keyframes rj-hyper{0%,100%{transform:scale(1)}50%{transform:scale(1.4)}}
.rj-shock{position:absolute;left:50%;top:50%;width:20px;height:20px;margin:-10px 0 0 -10px;border-radius:9999px;border:2px solid rgba(255,255,255,.9);pointer-events:none;z-index:2;animation:rj-shock 1.2s ease-out forwards}
@keyframes rj-shock{to{transform:scale(34);opacity:0;border-width:1px}}
.rj-orbits{position:absolute;inset:0;animation:rj-expand 1.6s 1s cubic-bezier(.2,1.1,.3,1) both}
@keyframes rj-expand{from{opacity:0;transform:scale(.05) rotate(-80deg)}to{opacity:1;transform:none}}
.track{position:absolute;left:50%;top:50%;border-radius:9999px;border:1px dashed rgba(167,139,250,.24);animation:rj-spin 90s linear infinite}
.track.t1{width:calc(var(--r1) * 2);height:calc(var(--r1) * 2);margin:calc(var(--r1) * -1) 0 0 calc(var(--r1) * -1)}
.track.t2{width:calc(var(--r2) * 2);height:calc(var(--r2) * 2);margin:calc(var(--r2) * -1) 0 0 calc(var(--r2) * -1);border-color:rgba(244,114,182,.2);animation-direction:reverse;animation-duration:140s}
.orbit{position:absolute;left:50%;top:50%;width:0;height:0;animation:rj-spin var(--d) linear infinite;animation-direction:var(--dir)}
.orbit.o1{--d:80s;--dir:normal;--pdir:reverse;--r:var(--r1)}
.orbit.o2{--d:120s;--dir:reverse;--pdir:normal;--r:var(--r2)}
.planet{position:absolute;left:50%;top:50%;width:0;height:0;padding:0;margin:0;border:0;background:none;overflow:visible;opacity:1;animation:none;cursor:pointer;transform:rotate(var(--a)) translateX(var(--r));text-align:center}
.planet::before{display:none}
.pc{position:absolute;left:0;top:0;transform:translate(-50%,-50%) rotate(calc(var(--a) * -1))}
.pi{display:block;animation:rj-spin var(--d,80s) linear infinite;animation-direction:var(--pdir)}
.o1 .pi{--d:80s}
.o2 .pi{--d:120s}
.rj-stage:hover .orbit,.rj-stage:hover .pi,.rj-stage:hover .track{animation-play-state:paused}
.chip{display:flex;align-items:center;gap:8px;white-space:nowrap;padding:6px 14px 6px 6px;border-radius:9999px;color:#e5e7eb;background:rgba(24,16,58,.78);border:1px solid rgba(168,85,247,.3);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);box-shadow:0 8px 24px -10px rgba(110,80,240,.8);opacity:0;animation:rj-chip .7s calc(1.9s + var(--i) * 80ms) cubic-bezier(.2,1.3,.3,1) forwards;transition:transform .25s,border-color .25s,box-shadow .25s,background .25s}
@keyframes rj-chip{from{opacity:0;transform:scale(.3)}to{opacity:1;transform:none}}
.chip .cd{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:26px;padding:0 6px;border-radius:9999px;font-size:11px;font-weight:800;letter-spacing:.08em;font-style:normal;color:#c4b5fd;background:rgba(168,85,247,.2);border:1px solid rgba(168,85,247,.35)}
.chip .nm{font-style:normal;font-size:13px}
.planet:hover .chip,.planet:focus-visible .chip{transform:scale(1.18);border-color:#ec4899;box-shadow:0 0 34px -2px rgba(236,72,153,.85);background:rgba(60,24,90,.9)}
.planet:hover{z-index:5}
.planet.active .chip{border-color:#ec4899;background:linear-gradient(135deg,rgba(124,58,237,.55),rgba(236,72,153,.4));box-shadow:0 0 30px -4px rgba(236,72,153,.8)}
.planet.active .chip .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.rj-leave .card h1,.rj-leave .card p.sub,.rj-leave .steps,.rj-leave .rj-lead,.rj-leave .brand-logo{opacity:0!important;transition:opacity .5s;animation:none}
.rj-leave .rj-orbits{transform:scale(2.4);opacity:0;transition:transform .9s ease-in,opacity .8s ease-in;animation:none}
.rj-leave .rj-core{transform:scale(2.6);opacity:0;transition:transform .9s ease-in,opacity .8s ease-in;animation:none}
@media (max-width:699px){
.rj-stage{--s:auto;display:grid;grid-template-columns:repeat(2,1fr);gap:10px;width:auto;height:auto;margin-top:8px}
.rj-core{position:relative;left:auto;top:auto;grid-column:1/-1;margin:0 auto 4px;width:110px;height:110px;transform:scale(.7)}
.rj-orbits{position:static;display:contents;animation:none}
.track{display:none}
.orbit{position:static;display:contents;animation:none}
.planet{position:static;width:auto;height:auto;transform:none}
.pc{position:static;transform:none;display:block}
.pi{animation:none}
.chip{width:100%}
.rj-leave .rj-orbits{transform:none}
}
@media (prefers-reduced-motion:reduce){
body::before,body::after,.rj-flash,.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.rj-core,.rj-core *,.rj-orbits,.track,.orbit,.pi,.chip{animation:none!important}
.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.chip{opacity:1}
}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('rjStage'),core=document.getElementById('rjCore');
if(!stage)return;
var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var fl=document.createElement('div');
fl.className='rj-flash';
document.body.appendChild(fl);
var ctx=cv.getContext('2d');
var W=0,H=0,F=0,dpr=1,mx=0,my=0,tx=0,ty=0,stars=[],go=false,running=true;
var speed=reduce?0:.1,target=reduce?0:.0014,ease=.028;
var cols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
function rnd(a,b){return a+Math.random()*(b-a)}
function mk(s,fresh){
s.x=rnd(-1,1);s.y=rnd(-1,1);s.z=fresh?rnd(.03,1):1;
s.r=rnd(.5,1.5);s.ph=rnd(0,6.28);s.c=cols[(Math.random()*cols.length)|0]
}
function resize(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;F=Math.max(W,H)*.55;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var n=Math.round(Math.min(480,Math.max(220,W*H/3600)));
stars=[];
for(var i=0;i<n;i++){var s={};mk(s,true);stars.push(s)}
}
function draw(){
var ox=W/2+mx*28,oy=H/2+my*18;
ctx.clearRect(0,0,W,H);
for(var i=0;i<stars.length;i++){
var s=stars[i],pz=s.z+speed;
s.z-=speed;
if(s.z<.03){mk(s,false);continue}
var k=F/s.z,x=ox+s.x*k,y=oy+s.y*k;
if(x<-60||x>W+60||y<-60||y>H+60){mk(s,false);continue}
var a=Math.min(1,(1-s.z)*1.5+.18);
ctx.strokeStyle=s.c;ctx.fillStyle=s.c;
if(speed>.004){
var pk=F/Math.min(pz,1.8),px=ox+s.x*pk,py=oy+s.y*pk;
ctx.globalAlpha=a;ctx.lineWidth=s.r*(.6+(1-s.z)*1.6);
ctx.beginPath();ctx.moveTo(px,py);ctx.lineTo(x,y);ctx.stroke()
}else{
ctx.globalAlpha=a*(.55+.45*Math.sin(performance.now()/700+s.ph));
ctx.beginPath();ctx.arc(x,y,s.r*(.5+(1-s.z)*1.1),0,6.283);ctx.fill()
}
}
ctx.globalAlpha=1
}
function frame(){
if(!running)return;
speed+=(target-speed)*ease;
mx+=(tx-mx)*.05;my+=(ty-my)*.05;
core.style.setProperty('--ax',mx.toFixed(3));
core.style.setProperty('--ay',my.toFixed(3));
draw();
if(!reduce)requestAnimationFrame(frame)
}
window.addEventListener('mousemove',function(e){tx=(e.clientX/W-.5)*2;ty=(e.clientY/H-.5)*2});
window.addEventListener('touchmove',function(e){var q=e.touches[0];if(q){tx=(q.clientX/W-.5)*2;ty=(q.clientY/H-.5)*2}},{passive:true});
core.addEventListener('click',function(){
if(go||reduce)return;
var sh=document.createElement('div');
sh.className='rj-shock';
stage.appendChild(sh);
setTimeout(function(){if(sh.parentNode)sh.parentNode.removeChild(sh)},1300);
core.classList.add('hyper');
speed=.07;
setTimeout(function(){core.classList.remove('hyper')},2000)
});
stage.addEventListener('submit',function(e){
if(go)return;
var b=e.submitter;
if(!b||!b.value||reduce)return;
e.preventDefault();
go=true;
var h=document.createElement('input');
h.type='hidden';h.name='rj_lang';h.value=b.value;
stage.appendChild(h);
document.body.classList.add('rj-leave');
target=.16;ease=.08;
fl.classList.add('on');
setTimeout(function(){stage.submit()},950)
});
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;requestAnimationFrame(frame)}
});
window.addEventListener('resize',resize);
resize();
if(reduce){draw()}else{requestAnimationFrame(frame)}
});
</script>
HTML;

rj_render('language', $body, $extra);
exit;
