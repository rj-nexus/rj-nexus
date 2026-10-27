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
