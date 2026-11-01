<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$idx = 0;
$buttons = '';

foreach (rj_languages() as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $buttons .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn planet' . $active . '" data-name="' . rj_esc($label) . '" style="--i:' . $idx . '">'
        . '<span class="chip"><b class="cd">' . rj_esc(strtoupper($code)) . '</b><i class="nm">' . rj_esc($label) . '</i></span>'
        . '</button>';
    $idx++;
}

$body = '<p class="rj-lead">' . rj_esc($t['lang']) . '</p>'
    . '<form method="post" class="langs rj-stage" id="rjStage">' . $buttons . '</form>';

$extra = <<<'HTML'
<noscript><style>.rj-stage{position:static!important;display:grid!important;grid-template-columns:repeat(2,1fr);gap:10px}.planet{position:static!important;opacity:1!important;transform:none!important}.card{position:static!important;transform:none!important}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;touch-action:none}
body{display:block;padding:0;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 3s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(14px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.26),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.2),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.18),transparent 70%);animation:rj-neb 40s ease-in-out infinite alternate,rj-bg 4s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-2%,0,0) rotate(0) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}
.rj-flash{position:fixed;inset:0;z-index:9;pointer-events:none;opacity:0;background:radial-gradient(circle at 50% 50%,#fff 0%,rgba(200,210,255,.85) 35%,rgba(120,100,255,.4) 70%);animation:rj-boom 1.8s 1.25s ease-out both}
.rj-flash.on{animation:none;opacity:1;transition:opacity .9s ease-in}
@keyframes rj-boom{0%{opacity:0}14%{opacity:.95}100%{opacity:0}}
.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:26px;margin:0 auto 4px;opacity:0;animation:rj-up 1s 2s both}
.card h1{text-align:center;font-size:clamp(26px,4.2vw,40px);font-weight:800;margin-bottom:0;background:linear-gradient(90deg,#e0e7ff,#fff,#fbcfe8,#c4b5fd,#e0e7ff);background-size:300% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;filter:drop-shadow(0 0 22px rgba(167,139,250,.5));opacity:0;animation:rj-title 1.6s 1.9s cubic-bezier(.2,.8,.2,1) both,rj-shine 8s 3.6s linear infinite}
.card p.sub{text-align:center;margin-bottom:0;opacity:0;animation:rj-up 1s 2.4s both}
.steps{justify-content:center;margin:10px 0 2px;opacity:0;animation:rj-up 1s 2.6s both}
.steps .line{flex:0 0 26px}
@keyframes rj-title{from{opacity:0;letter-spacing:.6em;filter:blur(16px) drop-shadow(0 0 22px rgba(167,139,250,.5))}to{opacity:1;letter-spacing:.02em;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.5))}}
@keyframes rj-shine{to{background-position:-300% 0}}
@keyframes rj-up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
.rj-lead{text-align:center;font-size:12px;color:#a5b4fc;letter-spacing:.2em;text-transform:uppercase;margin:6px 0 0;opacity:0;animation:rj-up 1s 2.8s both}
.rj-stage{position:fixed;inset:0;z-index:3;display:block;margin:0;pointer-events:none}
.planet{position:absolute;left:0;top:0;display:block;margin:0;padding:0;border:0;background:none;overflow:visible;cursor:pointer;pointer-events:auto;opacity:0;animation:none;will-change:transform,opacity;text-align:center}
.planet::before{display:none}
.chip{display:flex;align-items:center;gap:8px;white-space:nowrap;padding:6px 14px 6px 6px;border-radius:9999px;color:#e5e7eb;background:rgba(24,16,58,.8);border:1px solid rgba(168,85,247,.32);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);box-shadow:0 8px 26px -10px rgba(110,80,240,.85);transition:border-color .25s,box-shadow .25s,background .25s}
.chip .cd{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:26px;padding:0 6px;border-radius:9999px;font-size:11px;font-weight:800;letter-spacing:.08em;font-style:normal;color:#c4b5fd;background:rgba(168,85,247,.2);border:1px solid rgba(168,85,247,.35)}
.chip .nm{font-style:normal;font-size:13px}
.planet:hover .chip,.planet:focus-visible .chip{border-color:#ec4899;background:rgba(70,26,100,.92);box-shadow:0 0 40px -2px rgba(236,72,153,.9)}
.planet.active .chip{border-color:#ec4899;background:linear-gradient(135deg,rgba(124,58,237,.6),rgba(236,72,153,.45));box-shadow:0 0 32px -4px rgba(236,72,153,.85)}
.planet.active .chip .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.rj-cap{position:fixed;left:0;right:0;bottom:clamp(14px,3.4vh,34px);z-index:4;text-align:center;font-size:clamp(20px,3vw,30px);font-weight:700;letter-spacing:.06em;color:#fff;text-shadow:0 0 26px rgba(167,139,250,.95);pointer-events:none;opacity:0;animation:rj-up 1s 3.1s both;min-height:1.3em}
.rj-curtain{position:fixed;inset:0;z-index:20;pointer-events:none;overflow:hidden}
.rj-seam{position:absolute;left:50%;top:-5%;width:4px;height:110%;margin-left:-2px;background:linear-gradient(180deg,rgba(255,255,255,0),#fff 20%,#fff 80%,rgba(255,255,255,0));box-shadow:0 0 50px 18px rgba(167,139,250,.85),0 0 140px 50px rgba(244,114,182,.5);opacity:0;animation:rj-seam 1.7s .25s ease-in forwards}
@keyframes rj-seam{0%{opacity:0;transform:scaleX(.4)}30%{opacity:1;transform:scaleX(1)}100%{opacity:0;transform:scaleX(520)}}
.rj-cp{position:absolute;top:0;bottom:0;width:50.4%;background:repeating-linear-gradient(90deg,rgba(255,255,255,.04) 0 2px,rgba(0,0,0,.18) 2px 52px),linear-gradient(180deg,#0c0828 0%,#150f40 50%,#0a0722 100%);will-change:transform}
.rj-cp.l{left:0;box-shadow:inset -3px 0 46px rgba(167,139,250,.6),12px 0 60px rgba(120,90,255,.5);animation:rj-cl 1.6s .75s cubic-bezier(.75,0,.2,1) forwards}
.rj-cp.r{right:0;box-shadow:inset 3px 0 46px rgba(244,114,182,.5),-12px 0 60px rgba(120,90,255,.5);animation:rj-cr 1.6s .75s cubic-bezier(.75,0,.2,1) forwards}
@keyframes rj-cl{to{transform:translateX(-104%)}}
@keyframes rj-cr{to{transform:translateX(104%)}}
body:not(.rj-run) *{animation-play-state:paused!important}
.rj-leave .card h1,.rj-leave .card p.sub,.rj-leave .steps,.rj-leave .rj-lead,.rj-leave .brand-logo,.rj-leave .rj-cap{opacity:0!important;transition:opacity .5s;animation:none}
@media (max-width:699px){.chip{padding:5px}.chip .nm{display:none}.chip .cd{min-width:30px;height:24px}.rj-lead{font-size:11px}}
@media (prefers-reduced-motion:reduce){body::before,body::after,.rj-flash,.rj-curtain,.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.rj-cap{animation:none!important}.brand-logo,.card h1,.card p.sub,.steps,.rj-lead,.rj-cap{opacity:1}}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
var stage=document.getElementById('rjStage');
if(!stage)return;
document.body.appendChild(stage);
var cap=document.createElement('div');
cap.className='rj-cap';
document.body.appendChild(cap);
var card=document.querySelector('.card');
var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var fl=document.createElement('div');
fl.className='rj-flash';
document.body.appendChild(fl);
var cu=null,born=false,curT=0,INTRO=4.8;
function startIntro(){
document.body.classList.add('rj-run');
if(reduce)return;
cu=document.createElement('div');
cu.className='rj-curtain';
cu.innerHTML='<div class="rj-seam"></div><div class="rj-cp l"></div><div class="rj-cp r"></div>';
document.body.appendChild(cu);
setTimeout(function(){if(cu&&cu.parentNode){cu.parentNode.removeChild(cu);cu=null}},3300)
}
function skipIntro(){
if(curT>=INTRO||reduce)return;
t0-=(INTRO-curT)*1000;
speed=.0014;
if(cu&&cu.parentNode){cu.parentNode.removeChild(cu);cu=null}
if(fl&&fl.parentNode){fl.parentNode.removeChild(fl)}
}
var ctx=cv.getContext('2d');
var planets=[].slice.call(stage.querySelectorAll('.planet'));
var N=planets.length;
var W=0,H=0,dpr=1,F=0,cx=0,cy=0,R=200,AX=1,Rs=40,cam=700;
var mx=0,my=0,tx=0,ty=0;
var yaw=0,pitch=.25,cyw=0,cpt=.25,vy=0,vp=0,autoF=1,drag=false,moved=0,lx=0,ly=0;
var hov=-1,go=false,chosen=-1,goT0=0,beamA=0,spin=0,capName='';
var speed=reduce?0:.1,target=reduce?0:.0014,ease=.028;
var t0=0,lastT=0,running=true;
var sx=[],sy=[];
var base=[],pts=[],dust=[],stars=[],shocks=[],rings=[];
var cols=['#ffffff','#ffffff','#c4b5fd','#93c5fd','#f9a8d4'];
var ringCol=['167,139,250','244,114,182','147,197,253'];
var ringTilt=[[0,0],[1.2,.4],[-.9,-.7]];
function rnd(a,b){return a+Math.random()*(b-a)}
function clamp(v,a,b){return v<a?a:(v>b?b:v)}
function eob(x){var c1=1.70158,c3=c1+1;return 1+c3*Math.pow(x-1,3)+c1*Math.pow(x-1,2)}
function rot(x,y,z,yw,pt){
var c=Math.cos(yw),s=Math.sin(yw),x1=x*c+z*s,z1=-x*s+z*c,c2=Math.cos(pt),s2=Math.sin(pt);
return[x1,y*c2-z1*s2,y*s2+z1*c2]
}
var i,k;
for(i=0;i<N;i++){var yy=1-2*(i+.5)/N,rr=Math.sqrt(1-yy*yy),ph=i*2.399963;base.push([Math.cos(ph)*rr,yy,Math.sin(ph)*rr]);sx.push(0);sy.push(0)}
for(i=0;i<520;i++){var y2=1-2*(i+.5)/520,r2=Math.sqrt(1-y2*y2),p2=i*2.399963;pts.push([Math.cos(p2)*r2,y2,Math.sin(p2)*r2,rnd(.4,1),rnd(0,6.28)])}
for(i=0;i<240;i++){var a1=rnd(0,6.283),b1=rnd(-1,1),r1=Math.sqrt(1-b1*b1);dust.push([Math.cos(a1)*r1,b1,Math.sin(a1)*r1,rnd(.85,1.22),rnd(.6,1.8)])}
for(k=0;k<3;k++){
var arr=[],ax=ringTilt[k][0],az=ringTilt[k][1];
for(i=0;i<90;i++){
var a=i/90*6.283185,x=Math.cos(a),y=0,z=Math.sin(a);
var yp=y*Math.cos(ax)-z*Math.sin(ax),zp=y*Math.sin(ax)+z*Math.cos(ax);
arr.push([x*Math.cos(az)-yp*Math.sin(az),x*Math.sin(az)+yp*Math.cos(az),zp])
}
rings.push(arr)
}
function mk(s,fresh){
s.x=rnd(-1,1);s.y=rnd(-1,1);s.z=fresh?rnd(.03,1):1;
s.r=rnd(.5,1.5);s.ph=rnd(0,6.28);s.c=cols[(Math.random()*cols.length)|0]
}
function resize(){
dpr=Math.min(window.devicePixelRatio||1,2);
W=window.innerWidth;H=window.innerHeight;F=Math.max(W,H)*.55;
cv.width=W*dpr;cv.height=H*dpr;
ctx.setTransform(dpr,0,0,dpr,0,0);
var hdr=card?card.getBoundingClientRect().bottom+6:120;
var avail=H-hdr-76;
R=clamp(avail*.5-14,100,460);
AX=clamp(clamp(W*.43,110,860)/R,.45,3);
Rs=R*.3;cam=R*3.4;cx=W/2;cy=hdr+avail/2+4;
var n=Math.round(Math.min(460,Math.max(200,W*H/3800)));
stars=[];
for(var j=0;j<n;j++){var s={};mk(s,true);stars.push(s)}
}
function drawStars(ox,oy){
for(var j=0;j<stars.length;j++){
var s=stars[j],pz=s.z+speed;
s.z-=speed;
if(s.z<.03){mk(s,false);continue}
var kk=F/s.z,x=ox+s.x*kk,y=oy+s.y*kk;
if(x<-60||x>W+60||y<-60||y>H+60){mk(s,false);continue}
var al=Math.min(1,(1-s.z)*1.5+.18);
ctx.strokeStyle=s.c;ctx.fillStyle=s.c;
if(speed>.004){
var pk=F/Math.min(pz,1.8),px=ox+s.x*pk,py=oy+s.y*pk;
ctx.globalAlpha=al;ctx.lineWidth=s.r*(.6+(1-s.z)*1.6);
ctx.beginPath();ctx.moveTo(px,py);ctx.lineTo(x,y);ctx.stroke()
}else{
ctx.globalAlpha=al*(.55+.45*Math.sin(performance.now()/700+s.ph));
ctx.beginPath();ctx.arc(x,y,s.r*(.5+(1-s.z)*1.1),0,6.283);ctx.fill()
}
}
ctx.globalAlpha=1
}
function drawRings(rm,vis){
if(vis<=.01)return;
ctx.lineWidth=1.1;
for(var q=0;q<3;q++){
var arr=rings[q],prev=null;
for(var j=0;j<=arr.length;j++){
var v=arr[j%arr.length];
var p=rot(v[0]*R*rm,v[1]*R*rm,v[2]*R*rm,cyw,cpt);
var s=cam/(cam-p[2]),X=cx+p[0]*AX*s,Y=cy+p[1]*s;
if(prev){
var d=(p[2]/R+1)/2;
ctx.strokeStyle='rgba('+ringCol[q]+','+((.05+.3*d)*vis).toFixed(3)+')';
ctx.beginPath();ctx.moveTo(prev[0],prev[1]);ctx.lineTo(X,Y);ctx.stroke()
}
prev=[X,Y]
}
}
}
function drawDust(rm,vis){
if(vis<=.01)return;
ctx.fillStyle='#c4b5fd';
for(var j=0;j<dust.length;j++){
var d=dust[j],p=rot(d[0]*R*d[3]*rm,d[1]*R*d[3]*rm,d[2]*R*d[3]*rm,cyw,cpt);
var s=cam/(cam-p[2]),dd=(p[2]/R+1)/2;
ctx.globalAlpha=(.1+.55*dd)*vis;
ctx.beginPath();ctx.arc(cx+p[0]*AX*s,cy+p[1]*s,d[4]*s*(.6+dd*.6),0,6.283);ctx.fill()
}
ctx.globalAlpha=1
}
function drawStar(t,sc,vis){
if(vis<=.01)return;
var ox=cx+mx*10,oy=cy+my*7,r=Rs*sc,pu=1+.06*Math.sin(t*2.2);
ctx.globalCompositeOperation='lighter';
var g=ctx.createRadialGradient(ox,oy,0,ox,oy,r*6.5*pu);
g.addColorStop(0,'rgba(215,225,255,'+(.6*vis)+')');
g.addColorStop(.3,'rgba(160,140,255,'+(.24*vis)+')');
g.addColorStop(1,'rgba(90,70,200,0)');
ctx.fillStyle=g;ctx.beginPath();ctx.arc(ox,oy,r*6.5*pu,0,6.283);ctx.fill();
for(var f=0;f<2;f++){
var an=t*.25+f*1.5708,dx=Math.cos(an)*r*9,dy=Math.sin(an)*r*9;
var lg=ctx.createLinearGradient(ox-dx,oy-dy,ox+dx,oy+dy);
lg.addColorStop(0,'rgba(255,255,255,0)');lg.addColorStop(.5,'rgba(255,255,255,'+(.8*vis)+')');lg.addColorStop(1,'rgba(255,255,255,0)');
ctx.strokeStyle=lg;ctx.lineWidth=1.6;
ctx.beginPath();ctx.moveTo(ox-dx,oy-dy);ctx.lineTo(ox+dx,oy+dy);ctx.stroke()
}
var yw=t*(.55+spin*3)+mx*.7,pt=.35+my*.5;
for(var j=0;j<pts.length;j++){
var q=pts[j],rr=r*(1+.05*Math.sin(t*3+q[4])),p=rot(q[0]*rr,q[1]*rr,q[2]*rr,yw,pt);
var dz=(p[2]/rr+1)/2,al=(.2+.8*dz)*q[3]*vis;
ctx.fillStyle='rgba('+((200+55*q[3])|0)+','+((215+40*q[3])|0)+',255,'+al.toFixed(3)+')';
ctx.beginPath();ctx.arc(ox+p[0],oy+p[1],(.7+dz*1.3)*(r/46),0,6.283);ctx.fill()
}
var cg=ctx.createRadialGradient(ox,oy,0,ox,oy,r*1.1);
cg.addColorStop(0,'rgba(255,255,255,'+vis+')');cg.addColorStop(.55,'rgba(225,235,255,'+(.9*vis)+')');cg.addColorStop(1,'rgba(160,185,255,0)');
ctx.fillStyle=cg;ctx.beginPath();ctx.arc(ox,oy,r*1.1,0,6.283);ctx.fill();
for(var m=0;m<3;m++){
var ma=t*(.9+m*.4)+m*2,mr=r*(1.9+m*.7),sa=Math.sin(ma),ca=Math.cos(ma);
var mxp=ca*mr,myp=sa*mr*.35,tl=m*.6;
var px=ox+mxp*Math.cos(tl)-myp*Math.sin(tl),py=oy+mxp*Math.sin(tl)+myp*Math.cos(tl);
ctx.fillStyle='rgba(255,255,255,'+((.35+.5*(sa+1)/2)*vis)+')';
ctx.beginPath();ctx.arc(px,py,2.2+m*.4,0,6.283);ctx.fill()
}
ctx.globalCompositeOperation='source-over'
}
function drawBeam(t){
if(hov>=0&&!go){beamA+=(1-beamA)*.12}else{beamA*=.85}
if(beamA<.02||hov<0)return;
var ex=sx[hov],ey=sy[hov];
ctx.globalCompositeOperation='lighter';
var g=ctx.createLinearGradient(cx,cy,ex,ey);
g.addColorStop(0,'rgba(255,255,255,'+(.8*beamA)+')');g.addColorStop(1,'rgba(244,114,182,'+(.5*beamA)+')');
ctx.strokeStyle=g;ctx.lineWidth=2.2;
ctx.beginPath();ctx.moveTo(cx,cy);ctx.lineTo(ex,ey);ctx.stroke();
var u=(t*1.6)%1;
ctx.fillStyle='rgba(255,255,255,'+beamA+')';
ctx.beginPath();ctx.arc(cx+(ex-cx)*u,cy+(ey-cy)*u,3.2,0,6.283);ctx.fill();
ctx.globalCompositeOperation='source-over'
}
function drawShocks(now){
ctx.globalCompositeOperation='lighter';
for(var j=shocks.length-1;j>=0;j--){
var sh=shocks[j],p=Math.max(0,(now-sh.t)/sh.d);
if(p>=1){shocks.splice(j,1);continue}
var e=1-Math.pow(1-p,3),r=Rs+(sh.max-Rs)*e,a=1-p;
ctx.strokeStyle='rgba('+sh.c+','+(a*.8).toFixed(3)+')';ctx.lineWidth=1.5+a*4;
ctx.beginPath();ctx.arc(cx,cy,r,0,6.283);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
}
function blast(){
var mxr=Math.max(W,H)*.7,n=performance.now();
shocks.push({t:n,d:1500,max:mxr,c:'255,255,255'});
shocks.push({t:n,d:1900,max:mxr*.8,c:'167,139,250'});
shocks.push({t:n,d:2300,max:mxr*.6,c:'244,114,182'})
}
function frame(now){
if(!running)return;
if(!t0){t0=now;startIntro()}
var t=(now-t0)/1000;
curT=t;
if(!born&&!reduce&&t>1.2){born=true;blast()}
var dt=Math.min(.1,Math.max(.001,(now-lastT)/1000));
lastT=now;
if(!reduce&&!go&&t<1.6){speed=.12}else{speed+=(target-speed)*(1-Math.pow(1-ease,dt*60))}
mx+=(tx-mx)*.05;my+=(ty-my)*.05;
spin*=.96;
autoF+=((hov>=0&&!go?.1:1)-autoF)*.08;
if(!drag){
yaw+=vy+(reduce?0:.0038*autoF);vy*=.95;
pitch+=vp;vp*=.95
}else{vy*=.8;vp*=.8}
cyw=yaw+mx*.14;cpt=pitch-my*.14;
var e=0;
if(go){e=clamp((now-goT0)/950,0,1);e=e*e*(3-2*e)}
var introT=reduce?1:clamp((t-1.6)/1.9,0,1);
var rm=(reduce?1:eob(introT))*(1+e*2.2);
var vis=(reduce?1:clamp((t-1.7)/1.2,0,1))*(1-e);
var sS=reduce?1:eob(clamp((t-1.15)/1.1,0,1));
ctx.clearRect(0,0,W,H);
drawStars(W/2+mx*28,H/2+my*18);
drawRings(rm,vis);
drawDust(rm,vis);
drawStar(t,sS*(1+e*1.6),(reduce?1:clamp((t-1.1)/.9,0,1))*(1-e*.7));
drawBeam(t);
drawShocks(now);
var best=-1,bz=-1e9;
for(var j=0;j<N;j++){
var b=base[j],p=rot(b[0]*R*rm,b[1]*R*rm,b[2]*R*rm,cyw,cpt);
var s=cam/(cam-p[2]),X=cx+p[0]*AX*s,Y=cy+p[1]*s;
var d=(clamp(p[2]/R,-1,1)+1)/2;
var sc=(W<700?.9:1.12)*s*(hov===j&&!go?1.25:1);
var op=(.28+.72*d)*(reduce?1:clamp((t-2.1-j*.08)/.5,0,1));
if(go){
if(j===chosen){X+=(cx-X)*e;Y+=(cy-Y)*e;sc*=1+e*1.4;op=1-clamp((e-.65)/.35,0,1)}
else{op*=1-e}
}
sx[j]=X;sy[j]=Y;
var el=planets[j];
el.style.transform='translate3d('+X.toFixed(1)+'px,'+Y.toFixed(1)+'px,0) translate(-50%,-50%) scale('+sc.toFixed(3)+')';
el.style.opacity=op.toFixed(3);
el.style.zIndex=hov===j?1000:500+Math.round(p[2]);
el.style.pointerEvents=(op<.08||go)?'none':'auto';
if(p[2]>bz){bz=p[2];best=j}
}
if(!go&&introT<1){
ctx.globalCompositeOperation='lighter';
for(var q=0;q<N;q++){
var tg=ctx.createLinearGradient(cx,cy,sx[q]+.01,sy[q]+.01);
tg.addColorStop(0,'rgba(255,255,255,'+(.55*(1-introT))+')');
tg.addColorStop(1,'rgba(244,114,182,0)');
ctx.strokeStyle=tg;ctx.lineWidth=2;
ctx.beginPath();ctx.moveTo(cx,cy);ctx.lineTo(sx[q],sy[q]);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
}
var nm=planets[hov>=0?hov:(best>=0?best:0)].getAttribute('data-name')||'';
if(nm!==capName){capName=nm;cap.textContent=nm}
requestAnimationFrame(frame)
}
planets.forEach(function(el,idx){
el.addEventListener('mouseenter',function(){hov=idx});
el.addEventListener('mouseleave',function(){if(hov===idx)hov=-1});
el.addEventListener('focus',function(){hov=idx});
el.addEventListener('blur',function(){if(hov===idx)hov=-1})
});
window.addEventListener('pointerdown',function(e){drag=true;moved=0;lx=e.clientX;ly=e.clientY;vy=0;vp=0});
window.addEventListener('pointermove',function(e){
tx=(e.clientX/W-.5)*2;ty=(e.clientY/H-.5)*2;
if(!drag)return;
var dx=e.clientX-lx,dy=e.clientY-ly;
lx=e.clientX;ly=e.clientY;
moved+=Math.abs(dx)+Math.abs(dy);
yaw+=dx*.006;pitch-=dy*.006;
vy=dx*.006;vp=-dy*.006
});
window.addEventListener('pointerup',function(){drag=false});
window.addEventListener('pointercancel',function(){drag=false});
window.addEventListener('wheel',function(e){
e.preventDefault();
if(go)return;
vp=clamp(vp+e.deltaY*.0003,-.09,.09);
vy=clamp(vy+e.deltaX*.0003,-.09,.09)
},{passive:false});
window.addEventListener('keydown',function(e){
if(e.key==='Escape'||e.key==='Enter'||e.key===' '){skipIntro()}
if(go)return;
var kk=e.key;
if(kk==='ArrowUp')vp+=.03;
else if(kk==='ArrowDown')vp-=.03;
else if(kk==='ArrowLeft')vy-=.03;
else if(kk==='ArrowRight')vy+=.03
});
stage.addEventListener('click',function(e){if(moved>6){e.preventDefault();e.stopPropagation()}},true);
window.addEventListener('click',function(e){
if(go||moved>6||(e.target.closest&&e.target.closest('.planet')))return;
if(Math.hypot(e.clientX-cx,e.clientY-cy)<Rs*1.6){blast();spin=1;speed=.07}
});
stage.addEventListener('submit',function(e){
if(go)return;
var b=e.submitter;
if(!b||!b.value||reduce)return;
e.preventDefault();
go=true;chosen=planets.indexOf(b);goT0=performance.now();hov=-1;
var h=document.createElement('input');
h.type='hidden';h.name='rj_lang';h.value=b.value;
stage.appendChild(h);
document.body.classList.add('rj-leave');
target=.16;ease=.08;spin=1;
blast();
fl.classList.add('on');
setTimeout(function(){stage.submit()},950)
});
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;requestAnimationFrame(frame)}
});
window.addEventListener('resize',resize);
resize();
requestAnimationFrame(frame)
});
</script>
HTML;

rj_render('language', $body, $extra);
exit;
