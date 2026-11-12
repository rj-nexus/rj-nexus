<?php
if (!defined('RJ_INSTALLER')) { http_response_code(403); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ' . rj_installer_url('step=ecosystem'));
    exit;
}

if (empty($state['lang']) || !isset(rj_languages()[$state['lang']])) {
    $state['lang'] = 'en';
    rj_set_state(array_merge(rj_state(), ['lang' => 'en']));
}
$selectedLang = $state['lang'];

$langs = rj_languages();
if (isset($langs['en'])) {
    $langs = ['en' => $langs['en']] + $langs;
}

$aliases = [
    'en' => 'English', 'az' => 'Azerbaijani', 'tr' => 'Turkish', 'ru' => 'Russian', 'de' => 'German',
    'fr' => 'French', 'es' => 'Spanish', 'it' => 'Italian', 'pt' => 'Portuguese', 'nl' => 'Dutch',
    'pl' => 'Polish', 'uk' => 'Ukrainian', 'ar' => 'Arabic', 'fa' => 'Persian', 'he' => 'Hebrew',
    'hi' => 'Hindi', 'zh' => 'Chinese', 'ja' => 'Japanese', 'ko' => 'Korean', 'id' => 'Indonesian',
    'ms' => 'Malay', 'vi' => 'Vietnamese', 'th' => 'Thai', 'hy' => 'Armenian', 'ka' => 'Georgian',
    'kk' => 'Kazakh', 'uz' => 'Uzbek', 'tk' => 'Turkmen', 'ky' => 'Kyrgyz', 'tg' => 'Tajik',
    'sv' => 'Swedish', 'no' => 'Norwegian', 'nb' => 'Norwegian', 'da' => 'Danish', 'fi' => 'Finnish',
    'cs' => 'Czech', 'sk' => 'Slovak', 'ro' => 'Romanian', 'bg' => 'Bulgarian', 'el' => 'Greek',
    'hu' => 'Hungarian', 'hr' => 'Croatian', 'sr' => 'Serbian', 'sl' => 'Slovenian', 'lt' => 'Lithuanian',
    'lv' => 'Latvian', 'et' => 'Estonian', 'bn' => 'Bengali', 'ur' => 'Urdu', 'ta' => 'Tamil',
    'te' => 'Telugu', 'sw' => 'Swahili', 'af' => 'Afrikaans', 'sq' => 'Albanian', 'bs' => 'Bosnian',
    'mk' => 'Macedonian', 'be' => 'Belarusian', 'mn' => 'Mongolian', 'ne' => 'Nepali', 'fil' => 'Filipino',
    'tl' => 'Filipino', 'ca' => 'Catalan', 'is' => 'Icelandic', 'ga' => 'Irish', 'cy' => 'Welsh',
    'mt' => 'Maltese', 'pt_br' => 'Brazilian Portuguese', 'zh_cn' => 'Chinese Simplified', 'zh_tw' => 'Chinese Traditional',
];

$idx = 0;
$buttons = '';

foreach ($langs as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $alias = $aliases[strtolower($code)] ?? '';
    $buttons .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn planet' . $active . '" data-name="' . rj_esc($label) . '" data-code="' . rj_esc($code) . '" data-alias="' . rj_esc($alias) . '" style="--i:' . $idx . '">'
        . '<span class="chip"><b class="cd">' . rj_esc(strtoupper($code)) . '</b><i class="nm">' . rj_esc($label) . '</i></span>'
        . '</button>';
    $idx++;
}

$placeholder = $t['search'] ?? 'Search language...';
$noResults = $t['no_results'] ?? 'No language found';

$search = '<div class="rj-search" id="rjSearch" data-none="' . rj_esc($noResults) . '">'
    . '<div class="rj-sbox">'
    . '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>'
    . '<input type="text" id="rjQ" class="rj-q" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" enterkeyhint="go" role="combobox" aria-expanded="false" aria-controls="rjRes" placeholder="' . rj_esc($placeholder) . '" aria-label="' . rj_esc($placeholder) . '">'
    . '<span class="rj-count" id="rjCount"></span>'
    . '<button type="button" class="rj-clear" id="rjClr" aria-label="Clear">&times;</button>'
    . '</div>'
    . '<ul class="rj-res" id="rjRes" role="listbox" hidden></ul>'
    . '</div>';

$body = '<p class="rj-lead">' . rj_esc($t['lang']) . '</p>'
    . $search
    . '<form method="post" class="langs rj-stage" id="rjStage">' . $buttons . '</form>';

$extra = <<<'HTML'
<noscript><style>.rj-stage{position:static!important;display:grid!important;grid-template-columns:repeat(2,1fr);gap:10px}.planet{position:static!important;opacity:1!important;transform:none!important}.card{position:static!important;transform:none!important}.rj-search{display:none!important}</style></noscript>
<style>
html,body{height:100%;overflow:hidden;background:#05040f;touch-action:none;overscroll-behavior:none}
body{display:block;padding:0;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:0;background:radial-gradient(120% 90% at 50% 45%,#1c1450 0%,#0d0a2b 50%,#05040f 100%);animation:rj-bg 3s ease-out both}
body::after{content:"";position:fixed;inset:-20%;z-index:0;pointer-events:none;filter:blur(14px);background:radial-gradient(40% 35% at 25% 30%,rgba(167,139,250,.26),transparent 70%),radial-gradient(35% 30% at 78% 22%,rgba(244,114,182,.2),transparent 70%),radial-gradient(45% 40% at 60% 85%,rgba(96,165,250,.18),transparent 70%);animation:rj-neb 40s ease-in-out infinite alternate,rj-bg 4s ease-out both}
@keyframes rj-bg{from{opacity:0}to{opacity:1}}
@keyframes rj-neb{from{transform:translate3d(-2%,0,0) rotate(0) scale(1)}to{transform:translate3d(3%,-2%,0) rotate(8deg) scale(1.12)}}
#rjSky{position:fixed;inset:0;width:100%;height:100%;z-index:1;pointer-events:none}
.rj-flash{position:fixed;inset:0;z-index:9;pointer-events:none;opacity:0;background:radial-gradient(circle at 50% 50%,#fff 0%,rgba(200,210,255,.85) 35%,rgba(120,100,255,.4) 70%);transition:opacity .9s ease-in}
.rj-flash.on{opacity:1}
.card{position:fixed;top:clamp(12px,2.6vh,26px);left:50%;transform:translateX(-50%);z-index:4;width:min(92vw,900px);max-width:none;background:none;border:0;box-shadow:none;padding:0;overflow:visible;pointer-events:none;text-align:center}
.brand-logo{height:clamp(56px,10vh,92px);width:auto;margin:0 auto 6px;opacity:0;pointer-events:none;-webkit-user-drag:none;filter:drop-shadow(0 0 22px rgba(167,139,250,.55));animation:rj-logo 1.7s 1s cubic-bezier(.2,.8,.2,1) both}
@keyframes rj-logo{from{opacity:0;transform:translateY(10px) scale(.82);filter:blur(14px) drop-shadow(0 0 22px rgba(167,139,250,.55))}to{opacity:1;transform:none;filter:blur(0) drop-shadow(0 0 22px rgba(167,139,250,.55))}}
.card h1{display:none}
html,body,.card,.rj-stage,.planet{-webkit-user-select:none;-moz-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
::selection{background:transparent;color:inherit}
img{-webkit-user-drag:none;user-drag:none}
.card p.sub{text-align:center;margin-bottom:0;opacity:0;animation:rj-up 1.1s 1.8s both}
.steps{justify-content:center;margin:10px 0 2px;opacity:0;animation:rj-up 1.1s 2s both}
.steps .line{flex:0 0 26px}
@keyframes rj-up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
.rj-lead{text-align:center;font-size:12px;color:#a5b4fc;letter-spacing:.2em;text-transform:uppercase;margin:6px 0 0;opacity:0;animation:rj-up 1.1s 2.2s both}
.rj-search{position:relative;width:min(88vw,440px);margin:12px auto 0;pointer-events:auto;text-align:left;opacity:0;animation:rj-up 1.1s 2.4s both}
.rj-sbox{display:flex;align-items:center;gap:10px;height:46px;padding:0 14px;border-radius:9999px;background:rgba(24,16,58,.8);border:1px solid rgba(168,85,247,.38);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);box-shadow:0 10px 30px -12px rgba(110,80,240,.85);transition:border-color .2s,box-shadow .2s}
.rj-sbox:focus-within{border-color:#ec4899;box-shadow:0 0 38px -6px rgba(236,72,153,.75)}
.rj-sbox svg{width:18px;height:18px;flex:none;color:#a5b4fc}
.rj-sbox input.rj-q{flex:1;min-width:0;width:auto!important;height:100%;margin:0!important;padding:0!important;border:0!important;outline:0!important;box-shadow:none!important;background:none!important;color:#fff!important;font-size:16px;font-family:inherit;letter-spacing:.01em;border-radius:0!important;-webkit-appearance:none;appearance:none;-webkit-user-select:text;user-select:text}
.rj-sbox input.rj-q::placeholder{color:#8b8fc7;opacity:1}
.rj-sbox input.rj-q::selection{background:rgba(168,85,247,.5);color:#fff}
.rj-count{display:none;font-size:11px;font-weight:700;letter-spacing:.06em;color:#a5b4fc;white-space:nowrap}
.rj-count.on{display:block}
.rj-clear{display:none;flex:none;width:24px;height:24px;padding:0;border:0;border-radius:50%;background:rgba(168,85,247,.28);color:#e9d5ff;font-size:16px;line-height:24px;cursor:pointer;text-align:center}
.rj-clear.on{display:block}
.rj-clear:hover{background:rgba(236,72,153,.5)}
.rj-res{position:absolute;left:0;right:0;top:calc(100% + 8px);z-index:20;max-height:min(44vh,300px);margin:0;padding:6px;list-style:none;overflow-y:auto;border-radius:18px;background:rgba(16,10,44,.95);border:1px solid rgba(168,85,247,.35);-webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);box-shadow:0 24px 60px -16px rgba(0,0,0,.9);touch-action:pan-y;overscroll-behavior:contain;scrollbar-width:thin;scrollbar-color:rgba(168,85,247,.5) transparent}
.rj-res[hidden]{display:none}
.rj-res li{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:12px;color:#e5e7eb;font-size:14px;cursor:pointer;-webkit-user-select:none;user-select:none}
.rj-res li .cd{display:inline-flex;align-items:center;justify-content:center;flex:none;min-width:34px;height:24px;padding:0 6px;border-radius:9999px;font-size:11px;font-weight:800;letter-spacing:.08em;font-style:normal;color:#c4b5fd;background:rgba(168,85,247,.2);border:1px solid rgba(168,85,247,.35)}
.rj-res li .nm{font-style:normal;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.rj-res li .al{margin-left:auto;font-size:12px;color:#8b8fc7;white-space:nowrap}
.rj-res li.on,.rj-res li:hover{background:linear-gradient(135deg,rgba(124,58,237,.5),rgba(236,72,153,.38));color:#fff}
.rj-res li.on .al,.rj-res li:hover .al{color:#e9d5ff}
.rj-res li.cur .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.rj-res li.none{justify-content:center;padding:16px;color:#a5b4fc;cursor:default;background:none}
.rj-stage{position:fixed;inset:0;z-index:3;display:block;margin:0;pointer-events:none}
.planet{position:absolute;left:0;top:0;display:block;margin:0;padding:0;border:0;background:none;overflow:visible;cursor:pointer;pointer-events:auto;opacity:0;animation:none;will-change:transform,opacity;text-align:center}
.planet::before{display:none}
.chip{display:flex;align-items:center;gap:8px;white-space:nowrap;padding:6px 14px 6px 6px;border-radius:9999px;color:#e5e7eb;background:rgba(24,16,58,.8);border:1px solid rgba(168,85,247,.32);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);box-shadow:0 8px 26px -10px rgba(110,80,240,.85);transition:border-color .25s,box-shadow .25s,background .25s,padding .2s}
.chip .cd{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:26px;padding:0 6px;border-radius:9999px;font-size:11px;font-weight:800;letter-spacing:.08em;font-style:normal;color:#c4b5fd;background:rgba(168,85,247,.2);border:1px solid rgba(168,85,247,.35)}
.chip .nm{font-style:normal;font-size:13px}
.planet.mini .chip{padding:5px}
.planet.mini .chip .nm{display:none}
.planet:hover .chip,.planet:focus-visible .chip{border-color:#ec4899;background:rgba(70,26,100,.92);box-shadow:0 0 40px -2px rgba(236,72,153,.9)}
.planet.active .chip{border-color:#ec4899;background:linear-gradient(135deg,rgba(124,58,237,.6),rgba(236,72,153,.45));box-shadow:0 0 32px -4px rgba(236,72,153,.85)}
.planet.active .chip .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.planet.hl .chip{border-color:#f9a8d4;background:linear-gradient(135deg,rgba(124,58,237,.75),rgba(236,72,153,.6));box-shadow:0 0 46px 0 rgba(236,72,153,.95)}
.planet.hl .chip .cd{color:#fff;background:linear-gradient(135deg,#7c3aed,#ec4899);border-color:transparent}
.rj-cap{position:fixed;left:0;right:0;bottom:clamp(14px,3.4vh,34px);z-index:4;text-align:center;font-size:clamp(20px,3vw,30px);font-weight:700;letter-spacing:.06em;color:#fff;text-shadow:0 0 26px rgba(167,139,250,.95);pointer-events:none;opacity:0;animation:rj-up 1.1s 3.2s both;min-height:1.3em}
body:not(.rj-run) *{animation-play-state:paused!important}
.rj-leave .card p.sub,.rj-leave .steps,.rj-leave .rj-lead,.rj-leave .brand-logo,.rj-leave .rj-cap,.rj-leave .rj-search{opacity:0!important;transition:opacity .5s;animation:none;pointer-events:none}
@media (max-width:699px){.chip{padding:5px}.chip .nm{display:none}.chip .cd{min-width:30px;height:24px}.rj-lead{font-size:11px}.rj-res li .al{display:none}}
.planet.lang-btn,.planet.lang-btn:hover,.planet.lang-btn.active{background:none;border:0;padding:0;border-radius:0;color:inherit}
@media (max-height:520px){.card p.sub,.steps{display:none}.card{top:8px}.brand-logo{height:34px;margin-bottom:2px}.rj-lead{font-size:10px;margin-top:2px}.rj-search{margin-top:6px;width:min(60vw,360px)}.rj-sbox{height:36px}.rj-res{max-height:34vh}.rj-cap{font-size:16px;bottom:8px}.chip{padding:4px 10px 4px 4px}.chip .cd{height:22px;min-width:28px}.chip .nm{font-size:12px}}
.rj-fb #rjSky{display:none}
.rj-fb .rj-stage{display:grid!important;grid-template-columns:repeat(2,1fr);gap:10px;padding:240px 16px 24px;overflow:auto;pointer-events:auto}
.rj-fb .planet{position:relative!important;opacity:1!important;transform:none!important;pointer-events:auto!important}
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
var sbx=document.getElementById('rjSearch'),qEl=document.getElementById('rjQ'),res=document.getElementById('rjRes'),cnt=document.getElementById('rjCount'),clr=document.getElementById('rjClr');
var noneTxt=sbx.getAttribute('data-none')||'';
function ins(n){var el=n&&n.nodeType===1?n:(n&&n.parentElement);return!!(el&&el.closest&&el.closest('.rj-search'))}
document.addEventListener('selectstart',function(e){if(!ins(e.target))e.preventDefault()});
document.addEventListener('dragstart',function(e){e.preventDefault()});
document.addEventListener('contextmenu',function(e){if(!ins(e.target)&&!(e.target.closest&&e.target.closest('.planet')))e.preventDefault()});
var force=/[?&]fx=1/.test(location.search);
var soft=!!(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches)&&!force;
var reduce=false;
function fallback(){running=false;document.body.classList.add('rj-fb');for(var z=0;z<planets.length;z++){planets[z].removeAttribute('style')}applyFb()}
var cv=document.createElement('canvas');
cv.id='rjSky';
document.body.insertBefore(cv,document.body.firstChild);
var fl=document.createElement('div');
fl.className='rj-flash';
document.body.appendChild(fl);
var born=false,curT=0,INTRO=4.6,sf=1;
function startIntro(){document.body.classList.add('rj-run')}
function skipIntro(){
if(curT>=INTRO||reduce)return;
t0-=(INTRO-curT)*1000;
speed=.0014
}
var ctx=cv.getContext('2d');
var planets=[].slice.call(stage.querySelectorAll('.planet'));
var N=planets.length;
var dens=Math.max(.58,Math.min(1,Math.sqrt(20/Math.max(N,1))));
var stg=Math.min(.07,1.7/Math.max(N,1));
INTRO=1.5+stg*N+1.15;
var W=0,H=0,dpr=1,F=0,cx=0,cy=0,R=200,AX=1,Rs=40,cam=700,cs=1;
var mx=0,my=0,tx=0,ty=0;
var yaw=0,pitch=.25,cyw=0,cpt=.25,vy=0,vp=0,autoF=1,drag=false,moved=0,lx=0,ly=0;
var hov=-1,go=false,chosen=-1,goT0=0,beamA=0,spin=0,capName='';
var target=.0014,speed=soft?.0014:.012,ease=.028;
var t0=0,lastT=0,running=true;
var sx=[],sy=[],lps=[],miniS=[],hlS=[];
var base=[],pts=[],dust=[],stars=[],shocks=[],rings=[];
var q='',filtering=false,matches=[],mset={},act=-1,seek=-1;
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
function wrap(a){return a-Math.round(a/6.283185)*6.283185}
function fold(s){s=String(s).toLowerCase();return s.normalize?s.normalize('NFD').replace(/[\u0300-\u036f]/g,''):s}
function esc(s){return String(s).replace(/[&<>"']/g,function(c){return{'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]})}
var i,k;
for(i=0;i<N;i++){var yy=1-2*(i+.5)/N,rr=Math.sqrt(1-yy*yy),ph=i*2.399963;base.push([Math.cos(ph)*rr,yy,Math.sin(ph)*rr]);sx.push(0);sy.push(0);lps.push(0);miniS.push(false);hlS.push(false)}
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
var items=planets.map(function(el,idx){
var nm=el.getAttribute('data-name')||'',al=el.getAttribute('data-alias')||'',cd=el.getAttribute('data-code')||'';
var fn=fold(nm),fa=fold(al);
return{i:idx,code:cd,cd:fold(cd),name:nm,alias:al,nm:fn,al:fa,words:(fn+' '+fa).split(/[\s\-_(),.\/]+/)}
});
function applyFb(){
if(!document.body.classList.contains('rj-fb'))return;
for(var z=0;z<planets.length;z++){planets[z].style.display=(!filtering||mset[z]===1)?'':'none'}
}
function openList(){res.hidden=false;qEl.setAttribute('aria-expanded','true')}
function closeList(){res.hidden=true;qEl.setAttribute('aria-expanded','false')}
function renderList(){
if(!matches.length){res.innerHTML='<li class="none">'+esc(noneTxt)+'</li>';return}
var h='';
for(var m=0;m<matches.length;m++){
var it=items[matches[m]];
var cur=planets[it.i].classList.contains('active');
var showAl=it.alias&&fold(it.alias)!==it.nm;
h+='<li role="option" data-i="'+it.i+'" data-m="'+m+'" class="'+(m===act?'on':'')+(cur?' cur':'')+'"><b class="cd">'+esc(it.code.toUpperCase())+'</b><span class="nm">'+esc(it.name)+'</span>'+(showAl?'<span class="al">'+esc(it.alias)+'</span>':'')+'</li>'
}
res.innerHTML=h
}
function paintAct(scroll){
var els=res.querySelectorAll('li[data-m]');
for(var z=0;z<els.length;z++){
var on=+els[z].getAttribute('data-m')===act;
els[z].classList.toggle('on',on);
if(on&&scroll&&els[z].scrollIntoView)els[z].scrollIntoView({block:'nearest'})
}
}
function runFilter(){
q=qEl.value.trim();
var f=fold(q);
matches=[];mset={};
if(!f){
for(var z=0;z<N;z++)matches.push(z)
}else{
var sc=[];
for(var z2=0;z2<N;z2++){
var it=items[z2],s=-1,w;
if(it.cd===f)s=0;
else if(it.cd.indexOf(f)===0)s=1;
else if(it.nm.indexOf(f)===0||it.al.indexOf(f)===0)s=2;
else{
for(w=0;w<it.words.length;w++){if(it.words[w]&&it.words[w].indexOf(f)===0){s=3;break}}
if(s<0&&(it.nm.indexOf(f)>-1||it.al.indexOf(f)>-1))s=4
}
if(s>=0)sc.push([s,z2])
}
sc.sort(function(a,b){return a[0]-b[0]||a[1]-b[1]});
matches=sc.map(function(x){return x[1]})
}
filtering=!!f;
for(var m=0;m<matches.length;m++)mset[matches[m]]=1;
act=filtering&&matches.length?0:-1;
seek=act>=0?matches[act]:-1;
cnt.textContent=filtering?matches.length+' / '+N:'';
cnt.classList.toggle('on',filtering);
clr.classList.toggle('on',qEl.value.length>0);
renderList();
applyFb()
}
function stepAct(d){
if(!matches.length)return;
openList();
if(act<0)act=d>0?0:matches.length-1;
else act=(act+d+matches.length)%matches.length;
seek=matches[act];
paintAct(true)
}
function pick(idx){
if(go||idx<0||idx>=N)return;
var b=planets[idx];
go=true;chosen=idx;goT0=performance.now();hov=-1;seek=-1;
closeList();
if(document.activeElement===qEl)qEl.blur();
var h=document.createElement('input');
h.type='hidden';h.name='rj_lang';h.value=b.value;
stage.appendChild(h);
document.body.classList.add('rj-leave');
target=.16;ease=.08;spin=1;
blast();
fl.classList.add('on');
setTimeout(function(){stage.submit()},950)
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
var short=H<520;
var hdr=card?card.getBoundingClientRect().bottom+6:120;
var avail=Math.max(H-hdr-(short?40:76),60);
R=clamp(avail*.5-(short?6:14),52,460);
AX=clamp(clamp(W*.43,110,860)/R,.45,short?6:3);
cs=clamp(R/170,.6,1);
Rs=R*.3;cam=R*3.4;cx=W/2;cy=hdr+avail/2+4;
var n=Math.round(Math.min(460,Math.max(200,W*H/3800)));
if(!stars.length||Math.abs(n-stars.length)>40){
stars=[];
for(var j=0;j<n;j++){var s={};mk(s,true);stars.push(s)}
}
}
var rt=0;
function rs(){clearTimeout(rt);rt=setTimeout(resize,60)}
function drawStars(ox,oy){
for(var j=0;j<stars.length;j++){
var s=stars[j],pz=s.z+speed;
s.z-=speed;
if(s.z<.03){mk(s,false);continue}
var kk=F/s.z,x=ox+s.x*kk,y=oy+s.y*kk;
if(x<-60||x>W+60||y<-60||y>H+60){mk(s,false);continue}
var al=Math.min(1,(1-s.z)*1.5+.18)*sf;
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
for(var q2=0;q2<3;q2++){
var arr=rings[q2],prev=null;
for(var j=0;j<=arr.length;j++){
var v=arr[j%arr.length];
var p=rot(v[0]*R*rm,v[1]*R*rm,v[2]*R*rm,cyw,cpt);
var s=cam/(cam-p[2]),X=cx+p[0]*AX*s,Y=cy+p[1]*s;
if(prev){
var d=(p[2]/R+1)/2;
ctx.strokeStyle='rgba('+ringCol[q2]+','+((.05+.3*d)*vis).toFixed(3)+')';
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
var qq=pts[j],rr2=r*(1+.05*Math.sin(t*3+qq[4])),p=rot(qq[0]*rr2,qq[1]*rr2,qq[2]*rr2,yw,pt);
var dz=(p[2]/rr2+1)/2,al=(.2+.8*dz)*qq[3]*vis;
ctx.fillStyle='rgba('+((200+55*qq[3])|0)+','+((215+40*qq[3])|0)+',255,'+al.toFixed(3)+')';
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
var bi=hov>=0?hov:seek;
if(bi>=0&&!go){beamA+=(1-beamA)*.12}else{beamA*=.85}
if(beamA<.02||bi<0)return;
var ex=sx[bi],ey=sy[bi];
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
try{frameInner(now)}catch(err){fallback()}
}
function frameInner(now){
if(!running)return;
if(!t0){t0=now;startIntro()}
var t=(now-t0)/1000;
curT=t;
if(!born&&!soft&&t>1.1){born=true;blast()}
var dt=Math.min(.1,Math.max(.001,(now-lastT)/1000));
lastT=now;
sf=reduce?1:clamp(t/1.6,0,1);
speed+=(target-speed)*(1-Math.pow(1-ease,dt*60));
mx+=(tx-mx)*.05;my+=(ty-my)*.05;
spin*=.96;
autoF+=((seek>=0?0:(hov>=0&&!go?.1:1))-autoF)*.08;
var introT=reduce?1:clamp((t-1.4)/2.8,0,1);
if(!drag){
yaw+=vy+(reduce?0:.0038*autoF);vy*=.95;
pitch+=vp;vp*=.95
}else{vy*=.8;vp*=.8}
if(seek>=0&&!drag&&!go){
var bs=base[seek],rs2=Math.sqrt(bs[0]*bs[0]+bs[2]*bs[2])||.0001;
var ks=1-Math.pow(.91,dt*60);
yaw+=wrap(Math.atan2(-bs[0],bs[2])-yaw)*ks;
pitch+=wrap(Math.atan2(bs[1],rs2)-pitch)*ks;
vy=0;vp=0
}
var spinIn=Math.pow(1-introT,3)*(soft?1.2:6.5);
cyw=yaw+mx*.14+spinIn;cpt=pitch-my*.14;
var e=0;
if(go){e=clamp((now-goT0)/950,0,1);e=e*e*(3-2*e)}
var rm=(reduce?1:eob(clamp((t-1.3)/1.9,0,1)))*(1+e*2.2);
var vis=(reduce?1:clamp((t-1.5)/1.2,0,1))*(1-e);
var sS=reduce?1:eob(clamp((t-.5)/1.3,0,1));
ctx.clearRect(0,0,W,H);
drawStars(W/2+mx*28,H/2+my*18);
drawRings(rm,vis);
drawDust(rm,vis);
drawStar(t,sS*(1+e*1.6),(reduce?1:clamp((t-.4)/1,0,1))*(1-e*.7));
drawBeam(t);
drawShocks(now);
var best=-1,bz=-1e9,f=filtering;
for(var j=0;j<N;j++){
var lp=reduce?1:clamp((t-1.5-j*stg)/1.15,0,1);
var le=reduce?1:eob(lp);
lps[j]=lp;
var rmj=le*(1+e*2.2);
var b=base[j],p=rot(b[0]*R*rmj,b[1]*R*rmj,b[2]*R*rmj,cyw+(1-lp)*(soft?.6:2.6),cpt);
var s=cam/(cam-p[2]),X=cx+p[0]*AX*s,Y=cy+p[1]*s;
var d=(clamp(p[2]/R,-1,1)+1)/2;
var isM=f&&mset[j]===1,isH=hov===j;
var sc=cs*dens*(W<700?.9:1.12)*s*(isH&&!go?1.25:1)*(reduce?1:(.3+.7*Math.min(1,lp*1.4)));
var op=(.28+.72*d)*(reduce?1:clamp(lp*2,0,1));
if(f){
if(isM){op=Math.max(op,.92*(reduce?1:clamp(lp*2,0,1)));sc*=1.12}
else{op*=.1;sc*=.82}
}
if(j===seek)sc*=1.25;
if(go){
if(j===chosen){X+=(cx-X)*e;Y+=(cy-Y)*e;sc*=1+e*1.4;op=1-clamp((e-.65)/.35,0,1)}
else{op*=1-e}
}
sx[j]=X;sy[j]=Y;
var el=planets[j];
el.style.transform='translate3d('+X.toFixed(1)+'px,'+Y.toFixed(1)+'px,0) translate(-50%,-50%) scale('+sc.toFixed(3)+')';
el.style.opacity=op.toFixed(3);
el.style.zIndex=isH?3000:(j===seek?2500:(isM?1500+Math.round(p[2]):500+Math.round(p[2])));
el.style.pointerEvents=(op<.08||go)?'none':'auto';
var mn=d<.42&&!isM&&!isH&&j!==seek;
if(miniS[j]!==mn){miniS[j]=mn;el.classList.toggle('mini',mn)}
var hl=j===seek;
if(hlS[j]!==hl){hlS[j]=hl;el.classList.toggle('hl',hl)}
if(p[2]>bz){bz=p[2];best=j}
}
if(!go&&introT<1){
ctx.globalCompositeOperation='lighter';
for(var q3=0;q3<N;q3++){
var lq=lps[q3];
if(lq<=0||lq>=1)continue;
var tg=ctx.createLinearGradient(cx,cy,sx[q3]+.01,sy[q3]+.01);
tg.addColorStop(0,'rgba(255,255,255,'+(.5*Math.sin(lq*3.1416))+')');
tg.addColorStop(1,'rgba(244,114,182,0)');
ctx.strokeStyle=tg;ctx.lineWidth=2;
ctx.beginPath();ctx.moveTo(cx,cy);ctx.lineTo(sx[q3],sy[q3]);ctx.stroke()
}
ctx.globalCompositeOperation='source-over'
}
var ci=hov>=0?hov:(seek>=0?seek:(best>=0?best:0));
var nm=planets[ci].getAttribute('data-name')||'';
if(nm!==capName){capName=nm;cap.textContent=nm}
requestAnimationFrame(frame)
}
planets.forEach(function(el,idx){
el.addEventListener('mouseenter',function(){hov=idx});
el.addEventListener('mouseleave',function(){if(hov===idx)hov=-1});
el.addEventListener('focus',function(){hov=idx});
el.addEventListener('blur',function(){if(hov===idx)hov=-1})
});
qEl.addEventListener('focus',function(){runFilter();openList()});
qEl.addEventListener('blur',function(){setTimeout(function(){if(document.activeElement!==qEl)closeList()},140)});
qEl.addEventListener('input',function(){runFilter();openList()});
res.addEventListener('mousedown',function(e){e.preventDefault()});
res.addEventListener('click',function(e){
var li=e.target.closest&&e.target.closest('li[data-i]');
if(li)pick(+li.getAttribute('data-i'))
});
res.addEventListener('mouseover',function(e){
var li=e.target.closest&&e.target.closest('li[data-i]');
if(!li)return;
act=+li.getAttribute('data-m');
seek=+li.getAttribute('data-i');
paintAct(false)
});
clr.addEventListener('mousedown',function(e){e.preventDefault()});
clr.addEventListener('click',function(){qEl.value='';runFilter();openList();qEl.focus()});
window.addEventListener('pointerdown',function(e){
if(ins(e.target))return;
if(document.activeElement===qEl)qEl.blur();
closeList();
drag=true;moved=0;lx=e.clientX;ly=e.clientY;vy=0;vp=0;seek=-1
});
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
if(e.target.closest&&e.target.closest('.rj-res'))return;
e.preventDefault();
if(go)return;
vp=clamp(vp+e.deltaY*.0003,-.09,.09);
vy=clamp(vy+e.deltaX*.0003,-.09,.09)
},{passive:false});
window.addEventListener('keydown',function(e){
if(ins(e.target)){
if(e.key==='ArrowDown'){e.preventDefault();stepAct(1)}
else if(e.key==='ArrowUp'){e.preventDefault();stepAct(-1)}
else if(e.key==='Enter'){
e.preventDefault();
if(act>=0&&matches[act]!==undefined)pick(matches[act]);
else if(matches.length===1)pick(matches[0])
}else if(e.key==='Escape'){
if(qEl.value){qEl.value='';runFilter();openList()}
else{closeList();qEl.blur()}
}
return
}
if(e.key==='/'||((e.ctrlKey||e.metaKey)&&(e.key==='k'||e.key==='K'))){e.preventDefault();qEl.focus();return}
if(e.key==='Escape'||e.key==='Enter'||e.key===' '){skipIntro()}
if(go)return;
if(e.key.length===1&&e.key!==' '&&!e.ctrlKey&&!e.metaKey&&!e.altKey){qEl.focus();return}
var kk=e.key;
if(kk==='ArrowUp')vp+=.03;
else if(kk==='ArrowDown')vp-=.03;
else if(kk==='ArrowLeft')vy-=.03;
else if(kk==='ArrowRight')vy+=.03
});
stage.addEventListener('click',function(e){if(moved>6){e.preventDefault();e.stopPropagation()}},true);
window.addEventListener('click',function(e){
if(go||moved>6||ins(e.target)||(e.target.closest&&e.target.closest('.planet')))return;
if(Math.hypot(e.clientX-cx,e.clientY-cy)<Rs*1.6){blast();spin=1;speed=.07}
});
stage.addEventListener('submit',function(e){
if(go)return;
var b=e.submitter;
if(!b||!b.value)return;
e.preventDefault();
pick(planets.indexOf(b))
});
document.addEventListener('visibilitychange',function(){
if(document.hidden){running=false}else if(!running){running=true;requestAnimationFrame(frame)}
});
window.addEventListener('resize',rs);
window.addEventListener('orientationchange',function(){setTimeout(resize,120);setTimeout(resize,450)});
if(window.visualViewport)window.visualViewport.addEventListener('resize',rs);
if(window.ResizeObserver&&card)new ResizeObserver(rs).observe(card);
runFilter();
closeList();
resize();
setTimeout(resize,350);
requestAnimationFrame(frame)
});
</script>
HTML;

rj_render('language', $body, $extra);
exit;