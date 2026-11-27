{{-- 1. TEXT, URL, EMAIL --}}
<template x-if="field.type === 'text' || field.type === 'url' || field.type === 'email'">
    <div>
        <template x-if="isDynamicValue(fieldValue(field))">
            <div class="rj-dyn-chip">
                <span class="rj-dyn-chip-icon" style="display:inline-flex; align-items:center; justify-content:center; color:#fbbf24;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </span>
                <span class="rj-dyn-chip-label" x-text="getDynamicTagLabel(fieldValue(field))"></span>
                <button type="button" class="rj-dyn-chip-btn" @click="openTagPicker(field)" :title="t('Change tag')" style="display:inline-flex; align-items:center; justify-content:center;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <button type="button" class="rj-dyn-chip-btn rj-dyn-chip-x" @click="clearTag(field.name)" :title="t('Remove tag')" style="display:inline-flex; align-items:center; justify-content:center;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </template>

        <template x-if="!isDynamicValue(fieldValue(field))">
            <div style="display:flex; align-items:center; gap:6px;">
                <input type="text" class="rj-in" :value="fieldValue(field)" :placeholder="field.placeholder || ''" @input="updateSetting(field.name, $event.target.value)">
                <button type="button"
                        x-show="dynamicTagList.length > 0"
                        @click="openTagPicker(field)"
                        class="rj-dyn-btn"
                        :title="t('Insert Dynamic Tag')"
                        style="display:inline-flex; align-items:center; justify-content:center; color:#fbbf24; background:transparent; border:0; cursor:pointer; padding:4px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </button>
            </div>
        </template>
    </div>
</template>

{{-- 2. TEXTAREA --}}
<template x-if="field.type === 'textarea'">
    <textarea class="rj-ta" rows="4" :value="fieldValue(field)" :placeholder="field.placeholder || ''" @input="updateSetting(field.name, $event.target.value)"></textarea>
</template>

{{-- 3. SELECT (Açılan siyahı) --}}
<template x-if="field.type === 'select'">
    <select class="rj-in" @change="updateSetting(field.name, $event.target.value)">
        <template x-for="(label, value) in field.options" :key="value">
            <option :value="value" :selected="String(fieldValue(field)) === String(value)" x-text="label"></option>
        </template>
    </select>
</template>

{{-- 4. TOGGLE (Aç/Qapa düyməsi) --}}
<template x-if="field.type === 'toggle'">
    <label class="rj-row" style="padding:2px 0;">
        <span x-text="field.label"></span>
        <span class="rj-switch">
            <input type="checkbox" :checked="!!fieldValue(field)" @change="updateSetting(field.name, $event.target.checked)">
            <span></span>
        </span>
    </label>
</template>

{{-- 5. NUMBER --}}
<template x-if="field.type === 'number'">
    <input type="number" class="rj-in" :value="fieldValue(field)" :min="field.min" :max="field.max" :step="field.step || 1" @input="updateSetting(field.name, $event.target.value)">
</template>

{{-- 6. RANGE (Sürüşdürmə) --}}
<template x-if="field.type === 'range'">
    <div style="display:flex; align-items:center; gap:10px;">
        <input type="range" :value="fieldValue(field)" :min="field.min ?? 0" :max="field.max ?? 100" :step="field.step || 1" @input="updateSetting(field.name, $event.target.value)" style="flex:1; accent-color:#8b5cf6;">
        <span style="font-size:12px; color:#b9bcc8; min-width:32px; text-align:right;" x-text="fieldValue(field)"></span>
    </div>
</template>

{{-- 7. COLOR (Rəng seçimi) --}}
<template x-if="field.type === 'color'">
    <div style="display:flex; align-items:center; gap:10px;">
        <input type="color" :value="fieldValue(field) || '#000000'" @input="updateSetting(field.name, $event.target.value)" style="width: 40px; height: 40px; padding: 0; border-radius: 6px; cursor: pointer; border: 1px solid var(--line);">
        <input type="text" class="rj-in" :value="fieldValue(field)" @input="updateSetting(field.name, $event.target.value)" placeholder="#000000">
    </div>
</template>

{{-- 8. DIMENSIONS (Padding / Margin - Sizin əlavə etdiyiniz yeni tip) --}}
<template x-if="field.type === 'dimensions'">
    <div>
        <div style="display: flex; gap: 6px; align-items: flex-end;">
            {{-- Top --}}
            <div style="flex: 1;">
                <span style="font-size: 10px; color: var(--mut); display:block; margin-bottom:2px;">{{ __('Top') }}</span>
                <input type="number" class="rj-in" style="padding: 6px; text-align:center;" 
                       :value="currentSettings[field.name]?.top" 
                       @input="updateSetting(field.name, { ...(currentSettings[field.name] || {unit: 'px'}), top: $event.target.value })" placeholder="0">
            </div>
            {{-- Right --}}
            <div style="flex: 1;">
                <span style="font-size: 10px; color: var(--mut); display:block; margin-bottom:2px;">{{ __('Right') }}</span>
                <input type="number" class="rj-in" style="padding: 6px; text-align:center;" 
                       :value="currentSettings[field.name]?.right" 
                       @input="updateSetting(field.name, { ...(currentSettings[field.name] || {unit: 'px'}), right: $event.target.value })" placeholder="0">
            </div>
            {{-- Bottom --}}
            <div style="flex: 1;">
                <span style="font-size: 10px; color: var(--mut); display:block; margin-bottom:2px;">{{ __('Bottom') }}</span>
                <input type="number" class="rj-in" style="padding: 6px; text-align:center;" 
                       :value="currentSettings[field.name]?.bottom" 
                       @input="updateSetting(field.name, { ...(currentSettings[field.name] || {unit: 'px'}), bottom: $event.target.value })" placeholder="0">
            </div>
            {{-- Left --}}
            <div style="flex: 1;">
                <span style="font-size: 10px; color: var(--mut); display:block; margin-bottom:2px;">{{ __('Left') }}</span>
                <input type="number" class="rj-in" style="padding: 6px; text-align:center;" 
                       :value="currentSettings[field.name]?.left" 
                       @input="updateSetting(field.name, { ...(currentSettings[field.name] || {unit: 'px'}), left: $event.target.value })" placeholder="0">
            </div>
            {{-- Unit --}}
            <div style="width: 65px;">
                <span style="font-size: 10px; color: var(--mut); display:block; margin-bottom:2px;">{{ __('Unit') }}</span>
                <select class="rj-in" style="padding: 6px;" 
                        @change="updateSetting(field.name, { ...(currentSettings[field.name] || {}), unit: $event.target.value })">
                    <option value="px" :selected="(currentSettings[field.name]?.unit || 'px') === 'px'">px</option>
                    <option value="rem" :selected="currentSettings[field.name]?.unit === 'rem'">rem</option>
                    <option value="%" :selected="currentSettings[field.name]?.unit === '%'">%</option>
                </select>
            </div>
        </div>
    </div>
</template>

{{-- 9. IMAGE SELECT (Şəkil seçimi) --}}
<template x-if="field.type === 'image_select'">
    <div style="display: flex; flex-direction: column; gap: 12px;">
        <template x-for="(opt, val) in field.options" :key="val">
            <label style="cursor: pointer; border: 2px solid transparent; border-radius: 8px; overflow: hidden; display: block; transition: all 0.2s; position: relative;"
                   :style="String(fieldValue(field)) === String(val) ? 'border-color: #8b5cf6; box-shadow: 0 0 0 1px #8b5cf6;' : 'border-color: var(--line);'">
                <input type="radio" :value="val" :checked="String(fieldValue(field)) === String(val)" @change="updateSetting(field.name, val)" style="display: none;">

                <div x-show="String(fieldValue(field)) === String(val)" style="position: absolute; top: 8px; right: 8px; background: #8b5cf6; color: #fff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>

                <img :src="opt.image" style="width: 100%; height: auto; display: block;" />
                <div style="text-align: center; font-size: 12px; font-weight: 600; padding: 10px; background: var(--bg2); color: var(--text); border-top: 1px solid var(--line);" x-text="opt.label"></div>
            </label>
        </template>
    </div>
</template>

{{-- 10. MEDIA (Şəkil/Media yükləmə) --}}
<template x-if="field.type === 'media'">
    <div>
        <div x-show="currentSettings[field.name]" style="position:relative; margin-bottom:8px; border:1px solid var(--line); border-radius:6px; overflow:hidden;">
            <img :src="currentSettings[field.name]" style="width:100%; height:110px; object-fit:cover; display:block;" alt="">
            <button type="button" @click="updateSetting(field.name, '')" style="position:absolute; top:6px; right:6px; width:24px; height:24px; border-radius:50%; background:#dc2626; color:#fff; border:0; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <button type="button" class="rj-btn" style="width:100%; justify-content:center; border-style:dashed;" @click="openMediaPicker(field.name)" x-text="currentSettings[field.name] ? t('Change Image') : t('Select Image')"></button>
    </div>
</template>

{{-- 11. ICON (İkon seçimi) --}}
<template x-if="field.type === 'icon'">
    <div>
        <div x-show="currentSettings[field.name]" style="display:flex; align-items:center; gap:10px; margin-bottom:8px; padding:12px; border:1px solid var(--line); border-radius:6px; background:var(--bg2);">
            <span x-html="getIconSvg(currentSettings[field.name])" style="width:24px; height:24px; display:inline-block;"></span>
            <span style="font-size:13px; color:var(--text); font-family:monospace;" x-text="currentSettings[field.name]"></span>
            <button type="button" @click="updateSetting(field.name, '')" style="margin-left:auto; background:none; border:0; color:#dc2626; cursor:pointer; padding:0;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <button type="button" class="rj-btn" style="width:100%; justify-content:center; border-style:dashed;" @click="openIconPicker(field.name)" x-text="currentSettings[field.name] ? t('Change Icon') : t('Select Icon')"></button>
        <a href="https://icon-sets.iconify.design/" target="_blank" rel="noopener noreferrer"
           style="display:block; margin-top:8px; font-size:11px; color:#a78bfa; text-decoration:underline;">
            {{ __('Browse all icons') }} ↗
        </a>
    </div>
</template>