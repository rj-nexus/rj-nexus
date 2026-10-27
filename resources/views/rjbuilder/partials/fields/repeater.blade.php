<template x-if="field.type === 'repeater'">
    <div class="rj-field" @media-selected.window="onRepeaterMedia($event)">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <div class="rj-lbl"><span x-text="field.label"></span></div>
            <button type="button" @click="addRepeaterItem(field)"
                    style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:6px; background:#8b5cf6; color:#fff; border:0; cursor:pointer; font-size:11px; font-weight:600;">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>{{ __('Add') }}</span>
            </button>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:6px;">
            <template x-for="(item, idx) in (currentSettings[field.name] || [])" :key="idx">
                <div @click="openRepeaterItem(field, idx)"
                     style="position:relative; aspect-ratio:1/1; border-radius:8px; overflow:hidden; border:1px solid var(--line); background:var(--bg2); cursor:pointer; transition:border-color .15s;">
                    <template x-if="item.image">
                        <img :src="item.image" style="width:100%; height:100%; object-fit:cover; display:block;">
                    </template>
                    <template x-if="!item.image">
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#6b7280; font-size:10px; text-align:center; padding:4px;">{{ __('Click to edit') }}</div>
                    </template>
                    <button type="button" @click.stop="removeRepeaterItem(field, idx)"
                            style="position:absolute; top:4px; right:4px; width:18px; height:18px; border-radius:50%; background:rgba(220,38,38,.9); color:#fff; border:0; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0; z-index:2;">
                        <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div x-show="item.title" style="position:absolute; bottom:0; left:0; right:0; padding:3px 5px; background:linear-gradient(transparent, rgba(0,0,0,.75)); color:#fff; font-size:9px; font-weight:600; text-overflow:ellipsis; overflow:hidden; white-space:nowrap; z-index:1;" x-text="item.title"></div>
                </div>
            </template>
        </div>

        <p x-show="(currentSettings[field.name] || []).length === 0" style="text-align:center; padding:14px 8px; color:#6b7280; font-size:11px; border:1px dashed var(--line); border-radius:8px; margin:6px 0 0;">
            {{ __('No items yet. Click Add to start.') }}
        </p>

        <div x-show="repeaterEdit.open" x-cloak
             style="position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.7); padding:20px;"
             @click.self="repeaterEdit.open = false">
            <div style="background:var(--bg1); border:1px solid var(--line); border-radius:14px; width:100%; max-width:440px; max-height:80vh; overflow:auto; padding:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h3 style="font-size:13px; font-weight:600; margin:0;" x-text="repeaterEdit.field ? repeaterEdit.field.label : ''"></h3>
                    <button type="button" @click="repeaterEdit.open = false" style="background:none; border:0; color:#6b7280; cursor:pointer; padding:0;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <template x-for="(sub, si) in (repeaterEdit.field ? repeaterEdit.field.fields : [])" :key="si">
                    <div class="rj-field">
                        <div class="rj-lbl"><span x-text="sub.label"></span></div>

                        <template x-if="sub.type === 'media'">
                            <div>
                                <div x-show="repeaterEdit.item && repeaterEdit.item[sub.name]" style="position:relative; margin-bottom:8px; border:1px solid var(--line); border-radius:6px; overflow:hidden;">
                                    <img :src="repeaterEdit.item ? repeaterEdit.item[sub.name] : ''" style="width:100%; height:120px; object-fit:cover; display:block;">
                                    <button type="button" @click="setRepeaterField(sub.name, '')" style="position:absolute; top:6px; right:6px; width:22px; height:22px; border-radius:50%; background:#dc2626; color:#fff; border:0; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <button type="button" class="rj-btn" style="width:100%; justify-content:center; border-style:dashed;"
                                        @click="pickRepeaterMedia(sub.name)"
                                        x-text="(repeaterEdit.item && repeaterEdit.item[sub.name]) ? t('Change Image') : t('Select Image')"></button>
                            </div>
                        </template>

                        <!-- KATEQORİYA SEÇİMİ VƏ YENİ YARATMA -->
                        <template x-if="sub.type === 'text' && sub.source">
                            <div style="position: relative;" @click.outside="repeaterEdit.dropdown = null">

                                <div x-show="repeaterEdit.creatingNewCat === sub.name" style="display: flex; gap: 6px;">
                                    <input type="text" class="rj-in" style="flex: 1;"
                                           :value="repeaterEdit.item ? (repeaterEdit.item[sub.name] || '') : ''"
                                           @input="setRepeaterField(sub.name, $event.target.value)"
                                           placeholder="{{ __('Type new category...') }}" autofocus>
                                    <button type="button" class="rj-btn" style="padding: 0 12px;"
                                            @click="repeaterEdit.creatingNewCat = null">
                                        {{ __('Done') }}
                                    </button>
                                </div>

                                <div x-show="repeaterEdit.creatingNewCat !== sub.name"
                                     @click="repeaterEdit.dropdown = (repeaterEdit.dropdown === sub.name ? null : sub.name)"
                                     style="width: 100%; padding: 10px 12px; background: var(--bg2); border: 1px solid var(--line); border-radius: 6px; font-size: 13px; color: var(--text); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
                                    <span x-text="(repeaterEdit.item && repeaterEdit.item[sub.name]) ? repeaterEdit.item[sub.name] : '{{ __('Select Category...') }}'"
                                          :style="(!repeaterEdit.item || !repeaterEdit.item[sub.name]) ? 'color: var(--mut)' : ''"></span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>

                                <div x-show="repeaterEdit.dropdown === sub.name" x-cloak
                                     style="position: absolute; top: 100%; left: 0; right: 0; z-index: 50; background: var(--bg2); border: 1px solid var(--line); border-radius: 8px; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.6); max-height: 200px; overflow-y: auto; margin-top: 4px; padding: 4px;">

                                    <div @click="repeaterEdit.dropdown = null; repeaterEdit.creatingNewCat = sub.name; setRepeaterField(sub.name, '')"
                                         style="padding: 8px 10px; font-size: 12px; font-weight: 600; color: #a78bfa; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 6px; border-bottom: 1px solid var(--line); margin-bottom: 4px; padding-bottom: 8px;"
                                         onmouseover="this.style.background='var(--bg1)'" onmouseout="this.style.background='transparent'">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        <span>{{ __('Add New Category') }}</span>
                                    </div>

                                    <template x-for="opt in (currentSettings[sub.source] || '').split(',').map(s => s.trim()).filter(Boolean)" :key="opt">
                                        <div @click="setRepeaterField(sub.name, opt); repeaterEdit.dropdown = null"
                                             style="padding: 8px 10px; font-size: 12px; color: var(--text); border-radius: 4px; cursor: pointer; transition: background .15s; display: flex; justify-content: space-between; align-items: center;"
                                             onmouseover="this.style.background='var(--bg1)'" onmouseout="this.style.background='transparent'">
                                            <span x-text="opt"></span>
                                            <svg x-show="repeaterEdit.item && repeaterEdit.item[sub.name] === opt" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="color:#a78bfa;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="sub.type === 'text' && !sub.source">
                            <input type="text" class="rj-in" :value="repeaterEdit.item ? (repeaterEdit.item[sub.name] || '') : ''"
                                   @input="setRepeaterField(sub.name, $event.target.value)">
                        </template>

                        <template x-if="sub.type === 'textarea'">
                            <textarea class="rj-ta" rows="3" :value="repeaterEdit.item ? (repeaterEdit.item[sub.name] || '') : ''"
                                      @input="setRepeaterField(sub.name, $event.target.value)"></textarea>
                        </template>

                        <template x-if="sub.type === 'select'">
                            <select class="rj-in" @change="setRepeaterField(sub.name, $event.target.value)">
                                <template x-for="(lbl, val) in sub.options" :key="val">
                                    <option :value="val" :selected="repeaterEdit.item && String(repeaterEdit.item[sub.name]) === String(val)" x-text="lbl"></option>
                                </template>
                            </select>
                        </template>
                    </div>
                </template>

                <button type="button" class="rj-btn" style="width:100%; justify-content:center; margin-top:10px;" @click="repeaterEdit.open = false" x-text="t('Close')"></button>
            </div>
        </div>
    </div>
</template>
