<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$body = '<p class="rj-lead">' . rj_esc($t['lang']) . '</p><form method="post" class="langs">';
$i = 0;
foreach (rj_languages() as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $body .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn' . $active . '" style="--i:' . $i . '">'
        . '<span class="lb-code">' . rj_esc(strtoupper($code)) . '</span>'
        . '<span class="lb-name">' . rj_esc($label) . '</span>'
        . '</button>';
    $i++;
}
$body .= '</form>';

$extra = <<<'HTML'
<style>
body{background:#07061a;overflow-x:hidden}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 0%,#251a5e 0%,#120d33 45%,#07061a 100%)}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(12px);opacity:.9;background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.28),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.22),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.2),transparent 70%);animation:rj-neb 40s ease-in-out infinite alternate}
@keyframes rj-neb{from{transform:translate3d(-2%,0,0) rotate(0deg) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}
.card{position:relative;z-index:2;margin-top:104px;background:rgba(20,14,52,.62);-webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);border:1px solid rgba(167,139,250,.28);box-shadow:0 24px 70px -24px rgba(110,80,240,.65),inset 0 0 0 1px rgba(255,255,255,.04);animation:rj-card 1s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-card{from{opacity:0;transform:translateY(26px) scale(.97)}to{opacity:1;transform:none}}
.brand-logo{margin-left:auto;margin-right:auto;margin-top:18px;animation:rj-fade 1s .3s both}
.card h1{text-align:center;font-size:30px;letter-spacing:.02em;background:linear-gradient(90deg,#e0e7ff,#fff,#fbcfe8,#c4b5fd,#e0e7ff);background-size:300% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:rj-shine 7s linear infinite,rj-fade 1s .4s both;filter:drop-shadow(0 0 18px rgba(167,139,250,.45))}
.card p.sub{text-align:center;animation:rj-fade 1s .5s both}
@keyframes rj-shine{to{background-position:-300% 0}}
@keyframes rj-fade{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
.rj-lead{font-size:14px;color:#9ca3af;margin-bottom:8px;text-align:center;animation:rj-fade 1s .6s both}
.dot.active{box-shadow:0 0 18px rgba(168,85,247,.7);animation:rj-dot 2.4s ease-in-out infinite}
@keyframes rj-dot{0%,100%{box-shadow:0 0 8px rgba(168,85,247,.5)}50%{box-shadow:0 0 22px rgba(236,72,153,.8)}}
.langs{gap:10px}
.lang-btn{position:relative;display:flex;align-items:center;gap:12px;overflow:hidden;background:rgba(26,16,48,.7);border:1px solid rgba(168,85,247,.22);opacity:0;animation:rj-pop .6s calc(.55s + var(--i) * 55ms) cubic-bezier(.2,.8,.2,1) forwards;transition:transform .2s,border-color .2s,box-shadow .2s,background .2s}
@keyframes rj-pop{from{opacity:0;transform:translateY(14px) scale(.96)}to{opacity:1;transform:none}}
.lang-btn::before{content:"";position:absolute;inset:0;background:linear-gradient(120deg,transparent 30%,rgba(255,255,255,.14) 50%,transparent 70%);transform:translateX(-120%);transition:transform .6s}
.lang-btn:hover{transform:translateY(-2px);border-color:#a855f7;box-shadow:0 10px 30px -10px rgba(168,85,247,.8)}
.lang-btn:hover::before{transform:translateX(120%)}
.lang-btn:active{transform:scale(.97)}
.lang-btn.active{border-color:#ec4899;background:linear-gradient(135deg,rgba(124,58,237,.35),rgba(236,72,153,.25));box-shadow:0 0 28px -6px rgba(236,72,153,.7)}
.lb-code{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:24px;padding:0 6px;border-radius:6px;font-size:11px;font-weight:700;letter-spacing:.08em;color:#c4b5fd;background:rgba(168,85,247,.16);border:1px solid rgba(168,85,247,.3)}
.lang-btn.active .lb-code{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.lb-name{font-size:14px}
.rj-altair{position:absolute;top:-122px;left:50%;width:120px;height:120px;margin-left:-60px;cursor:pointer;z-index:3;transform:translate3d(calc(var(--ax,0) * 12px),calc(var(--ay,0) * 8px),0);transition:transform .25s ease-out;animation:rj-fade 1.2s .1s both}
.rj-altair .g{position:absolute;inset:-110px;border-radius:9999px;pointer-events:none;background:radial-gradient(circle,rgba(200,215,255,.55) 0%,rgba(150,130,255,.22) 28%,rgba(0,0,0,0) 62%);animation:rj-breathe 5s ease-in-out infinite}
@keyframes rj-breathe{0%,100%{transform:scale(.88);opacity:.75}50%{transform:scale(1.12);opacity:1}}
.rj-altair .ry{position:absolute;inset:0;pointer-events:none;animation:rj-spin 20s linear infinite}
.rj-altair .ry::before,.rj-altair .ry::after{content:"";position:absolute;left:50%;top:50%;transform:translate(-50%,-50%)}
.rj-altair .ry::before{width:300px;height:2px;background:linear-gradient(90deg,transparent,rgba(255,255,255,.95),transparent)}
.rj-altair .ry::after{width:2px;height:300px;background:linear-gradient(180deg,transparent,rgba(255,255,255,.95),transparent)}
.rj-altair .ry.r2{animation-duration:34s;animation-direction:reverse;opacity:.55;transform:scale(.72)}
.rj-altair .rg{position:absolute;border-radius:9999px;pointer-events:none;animation:rj-spin 26s linear infinite}
.rj-altair .rg.a{inset:12px;border:1px dashed rgba(190,200,255,.4)}
.rj-altair .rg.b{inset:-14px;border:1px solid rgba(244,114,182,.24);animation-duration:40s;animation-direction:reverse}
.rj-altair .rg.c{inset:-42px;border:1px dashed rgba(147,197,253,.2);animation-duration:60s}
.rj-altair .rg::after{content:"";position:absolute;top:-3px;left:50%;width:6px;height:6px;margin-left:-3px;border-radius:9999px;background:#a78bfa;box-shadow:0 0 12px 3px #a78bfa}
.rj-altair .rg.b::after{background:#f472b6;box-shadow:0 0 12px 3px #f472b6}
.rj-altair .rg.c::after{background:#93c5fd;box-shadow:0 0 12px 3px #93c5fd}
.rj-altair .co{position:absolute;left:50%;top:50%;width:42px;height:36px;margin:-18px 0 0 -21px;border-radius:9999px;background:radial-gradient(circle at 40% 36%,#fff 0%,#eef3ff 42%,#b6c9ff 100%);box-shadow:0 0 22px 8px rgba(255,255,255,.85),0 0 64px 26px rgba(150,180,255,.6);animation:rj-pulse 4s ease-in-out infinite;transition:transform .3s}
.rj-altair:hover .co{transform:scale(1.15)}
@keyframes rj-pulse{0%,100%{filter:brightness(1)}50%{filter:brightness(1.18)}}
@keyframes rj-spin{to{transform:rotate(360deg)}}
.rj-altair.hyper .ry{animation-duration:1.4s}
.rj-altair.hyper .ry.r2{animation-duration:2.4s}
.rj-altair.hyper .rg{animation-duration:3s}
.rj-altair.hyper .co{animation:rj-hyper .35s ease-in-out infinite}
@keyframes rj-hyper{0%,100%{transform:scale(1)}50%{transform:scale(1.35)}}
@media (max-width:520px){.card{margin-top:88px}.rj-altair{top:-108px;width:104px;height:104px;margin-left:-52px}}
@media (prefers-reduced-motion:reduce){body::after,.card,.card h1,.lang-btn,.rj-altair,.rj-altair *,.dot.active{animation:none!important}.lang-btn{opacity:1}}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var card=document.querySelector('.card');
if(!card)return;
var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.appendChild(cv);
var ctx=cv.getContext('2d');
var star=document.createElement('div');
star.className='rj-altair';
star.innerHTML='<div class="g"></div><div class="rg c"></div><div class="rg b"></div><div class="rg a"></div><div class="ry"></div><div class="ry r2"></div><div class="co"></div>';
card.insertBefore(star,card.firstChild);
var W=0,H=0,dpr=1,t=0,mx=0,my=0,tx=0,ty=0,stars=[],parts=[],rings=[],shoots=[],last=0,running=true;
var cols=['#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
function rnd(a,b){return a+Math.random()*(b-a)}
function resize(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var n=Math.round(Math.min(260,Math.max(100,W*H/3200)));
stars=[];
for(var i=0;i<n;i++){stars.push({x:Math.random(),y:Math.random(),z:rnd(.15,1),r:rnd(.4,1.6),sp:rnd(.6,2.6),ph:rnd(0,6.28),c:Math.random()<.12?cols[(Math.random()*cols.length)|0]:'#ffffff'})}
}
function center(){
var r=star.getBoundingClientRect();
return{x:r.left+r.width/2,y:r.top+r.height/2}
}
function burst(x,y,n,p){
for(var i=0;i<n;i++){
var a=rnd(0,6.283),s=rnd(.4,1)*p;
parts.push({x:x,y:y,vx:Math.cos(a)*s,vy:Math.sin(a)*s,life:0,max:rnd(50,110),r:rnd(.8,2.4),c:cols[(Math.random()*cols.length)|0]})
}
if(parts.length>600)parts.splice(0,parts.length-600)
}
function ring(x,y,max,sp,c){rings.push({x:x,y:y,r:6,max:max,sp:sp,c:c})}
function frame(){
if(!running)return;
t+=1/60;
mx+=(tx-mx)*.06;my+=(ty-my)*.06;
star.style.setProperty('--ax',mx.toFixed(3));
star.style.setProperty('--ay',my.toFixed(3));
ctx.clearRect(0,0,W,H);
for(var i=0;i<stars.length;i++){
var s=stars[i];
var px=s.x*W+mx*s.z*26+Math.sin(t*.05*s.z+s.ph)*4*s.z;
var py=s.y*H+my*s.z*16;
var a=.3+.7*(.5+.5*Math.sin(t*s.sp+s.ph));
ctx.globalAlpha=a*(.4+s.z*.6);
ctx.fillStyle=s.c;
ctx.beginPath();ctx.arc(px,py,s.r*(.6+s.z*.6),0,6.283);ctx.fill();
if(s.r>1.35&&a>.8){
ctx.globalAlpha=a*.35;ctx.strokeStyle=s.c;ctx.lineWidth=.6;
ctx.beginPath();ctx.moveTo(px-5,py);ctx.lineTo(px+5,py);ctx.moveTo(px,py-5);ctx.lineTo(px,py+5);ctx.stroke()
}
}
ctx.globalAlpha=1;
if(!reduce&&t-last>rnd(4,8)){
last=t;
shoots.push({x:rnd(W*.3,W),y:rnd(0,H*.4),vx:-rnd(7,11),vy:rnd(3.5,6),life:0,max:46})
}
for(var k=shoots.length-1;k>=0;k--){
var h=shoots[k];h.x+=h.vx;h.y+=h.vy;h.life++;
var al=1-h.life/h.max;
if(al<=0){shoots.splice(k,1);continue}
var g=ctx.createLinearGradient(h.x,h.y,h.x-h.vx*9,h.y-h.vy*9);
g.addColorStop(0,'rgba(255,255,255,'+al+')');g.addColorStop(1,'rgba(255,255,255,0)');
ctx.strokeStyle=g;ctx.lineWidth=1.6;
ctx.beginPath();ctx.moveTo(h.x,h.y);ctx.lineTo(h.x-h.vx*9,h.y-h.vy*9);ctx.stroke()
}
ctx.globalCompositeOperation='lighter';
for(var j=rings.length-1;j>=0;j--){
var r=rings[j];r.r+=r.sp;r.sp*=.985;
var ra=1-r.r/r.max;
if(ra<=0){rings.splice(j,1);continue}
ctx.strokeStyle=r.c+(ra*.8)+')';ctx.lineWidth=2+ra*3;
ctx.beginPath();ctx.arc(r.x,r.y,r.r,0,6.283);ctx.stroke()
}
for(var m=parts.length-1;m>=0;m--){
var p=parts[m];p.x+=p.vx;p.y+=p.vy;p.vx*=.975;p.vy=p.vy*.975+.015;p.life++;
var pk=1-p.life/p.max;
if(pk<=0){parts.splice(m,1);continue}
ctx.globalAlpha=pk;ctx.fillStyle=p.c;
ctx.beginPath();ctx.arc(p.x,p.y,p.r*(.4+pk),0,6.283);ctx.fill()
}
ctx.globalAlpha=1;ctx.globalCompositeOperation='source-over';
if(!reduce)requestAnimationFrame(frame)
}
function nova(){
var c=center();
burst(c.x,c.y,170,4.2);
ring(c.x,c.y,Math.max(W,H)*.8,7,'rgba(255,255,255,');
ring(c.x,c.y,Math.max(W,H)*.6,5,'rgba(167,139,250,');
ring(c.x,c.y,Math.max(W,H)*.45,3.4,'rgba(147,197,253,');
star.classList.add('hyper');
setTimeout(function(){star.classList.remove('hyper')},2200)
}
window.addEventListener('mousemove',function(e){tx=(e.clientX/W-.5)*2;ty=(e.clientY/H-.5)*2});
window.addEventListener('touchmove',function(e){var q=e.touches[0];if(q){tx=(q.clientX/W-.5)*2;ty=(q.clientY/H-.5)*2}},{passive:true});
window.addEventListener('click',function(e){
if(e.target.closest('.lang-btn'))return;
if(e.target.closest('.rj-altair')){nova();return}
burst(e.clientX,e.clientY,30,2.4);
ring(e.clientX,e.clientY,70,2.2,'rgba(196,181,253,')
});
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;requestAnimationFrame(frame)}
});
window.addEventListener('resize',resize);
resize();
requestAnimationFrame(frame);
setTimeout(function(){var c=center();ring(c.x,c.y,Math.max(W,H)*.5,4,'rgba(255,255,255,');burst(c.x,c.y,60,2.8)},700)
});
</script>
HTML;

rj_render('language', $body, $extra);
exit;
