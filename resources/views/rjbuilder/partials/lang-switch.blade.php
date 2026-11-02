@once
<style>
.rj-lang{position:relative;display:inline-block}
.rj-lang-btn{display:flex;align-items:center;gap:8px;height:34px;padding:0 10px 0 6px;border-radius:999px;border:1.5px solid transparent;background:linear-gradient(#1c1d22,#1c1d22) padding-box,linear-gradient(135deg,#8b5cf6,#ec4899) border-box;color:#fff;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;transition:box-shadow .2s,transform .15s}
.rj-lang-btn:hover{box-shadow:0 0 0 3px rgba(139,92,246,.28);transform:translateY(-1px)}
.rj-lang-btn[data-open="true"]{box-shadow:0 0 0 3px rgba(139,92,246,.35)}
.rj-lang-globe{width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg,#8b5cf6,#ec4899);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.rj-lang-chev{opacity:.7;transition:transform .2s}
.rj-lang-btn[data-open="true"] .rj-lang-chev{transform:rotate(180deg)}
.rj-lang-dot{width:7px;height:7px;border-radius:50%;background:#fbbf24;animation:rjlangpulse 1.6s infinite}
@keyframes rjlangpulse{0%{box-shadow:0 0 0 0 rgba(251,191,36,.6)}70%{box-shadow:0 0 0 7px rgba(251,191,36,0)}100%{box-shadow:0 0 0 0 rgba(251,191,36,0)}}
.rj-lang-pop{position:absolute;top:calc(100% + 10px);right:0;min-width:230px;background:#1c1d22;border:1px solid #383a43;border-radius:14px;padding:6px;box-shadow:0 20px 44px rgba(0,0,0,.5);z-index:9999}
.rj-lang--left .rj-lang-pop{left:0;right:auto}
.rj-lang-title{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#8e919d;padding:8px 10px 6px}
.rj-lang-item{width:100%;display:flex;align-items:center;gap:10px;padding:8px 10px;border:0;border-radius:10px;background:transparent;color:#d6d8e0;cursor:pointer;text-align:left;transition:background .15s}
.rj-lang-item:hover{background:rgba(139,92,246,.14)}
.rj-lang-item[data-active="true"]{background:linear-gradient(135deg,rgba(139,92,246,.22),rgba(236,72,153,.18));color:#fff}
.rj-lang-badge{width:30px;height:30px;border-radius:9px;background:#2a2c35;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;letter-spacing:.04em;text-transform:uppercase;color:#c4b5fd;flex-shrink:0}
.rj-lang-item[data-active="true"] .rj-lang-badge{background:linear-gradient(135deg,#8b5cf6,#ec4899);color:#fff}
.rj-lang-name{flex:1;min-width:0;display:flex;flex-direction:column;font-size:13px;font-weight:600;line-height:1.2}
.rj-lang-name small{font-size:10px;font-weight:500;color:#8e919d;margin-top:2px}
.rj-lang-warn{display:flex;align-items:center;gap:6px;margin:6px 4px 2px;padding:8px 10px;border-radius:10px;background:rgba(251,191,36,.1);border:1px dashed rgba(251,191,36,.4);color:#fbbf24;font-size:11px;font-weight:600}
</style>
@endonce

<div class="rj-lang {{ ($align ?? 'right') === 'left' ? 'rj-lang--left' : '' }}"
     x-data="{
        open: false,
        name(l) { try { return new Intl.DisplayNames([l], { type: 'language' }).of(l); } catch (e) { return l; } },
        pick(l) {
            if (l === activeLocale) { this.open = false; return; }
            if (!saved && !confirm(t('You have unsaved changes. Switching language will discard them. Continue?'))) { this.open = false; return; }
            activeLocale = l;
            this.open = false;
        }
     }"
     @click.outside="open = false"
     @keydown.escape.stop="open = false">

    <button type="button" class="rj-lang-btn" :data-open="open" @click="open = !open" :title="t('Translate')">
        <span class="rj-lang-globe">
            <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 010 18M12 3a14 14 0 000 18"/></svg>
        </span>
        <span x-text="activeLocale"></span>
        <span class="rj-lang-dot" x-show="!saved" :title="t('Save first!')"></span>
        <svg class="rj-lang-chev" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
    </button>

    <div class="rj-lang-pop" x-show="open" x-cloak x-transition.scale.origin.top.duration.150ms>
        <div class="rj-lang-title" x-text="t('Edit content in')"></div>
        <template x-for="loc in locales" :key="loc">
            <button type="button" class="rj-lang-item" :data-active="loc === activeLocale" @click="pick(loc)">
                <span class="rj-lang-badge" x-text="loc"></span>
                <span class="rj-lang-name">
                    <span x-text="name(loc)" style="text-transform:capitalize;"></span>
                    <small x-show="loc === baseLocale" x-text="'Default'"></small>
                </span>
                <svg x-show="loc === activeLocale" width="16" height="16" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            </button>
        </template>
        <div class="rj-lang-warn" x-show="!saved">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span x-text="t('Save first!')"></span>
        </div>
    </div>
</div>
