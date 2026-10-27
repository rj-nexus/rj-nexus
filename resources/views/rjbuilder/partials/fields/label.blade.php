<template x-if="field.type !== 'toggle' && field.type !== 'dimensions'">
    <div class="rj-lbl">
        <span style="display:inline-flex; align-items:center; gap:6px; min-width:0;">
            <!-- Mətn Hissəsi -->
            <span x-text="field.label"></span>

            <!-- Tərcümə İkonu (Qlobus SVG) -->
            <span x-show="templateType === 'page' && locales.length > 1 && isTranslatableField(field.name)"
                  style="display: inline-flex; align-items: center; color: #a78bfa; opacity: 0.8;"
                  title="{{ __('Translatable') }}">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </span>

            <!-- Responsive İkonu (Cihaz SVG) -->
            <button type="button"
                    x-show="isResponsiveField(field)"
                    @click="cycleFieldDevice(field.name)"
                    class="rj-fdev"
                    :data-on="getFieldDevice(field.name)"
                    :title="t('Responsive') + ' — ' + t(getFieldDevice(field.name) === 'desktop' ? 'Desktop' : getFieldDevice(field.name) === 'tablet' ? 'Tablet' : 'Mobile')"
                    style="display: inline-flex; align-items: center; justify-content: center;">

                <!-- Desktop İkonu -->
                <svg x-show="getFieldDevice(field.name) === 'desktop'" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>

                <!-- Tablet İkonu -->
                <svg x-show="getFieldDevice(field.name) === 'tablet'" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M12 18h.01"/></svg>

                <!-- Mobile İkonu -->
                <svg x-show="getFieldDevice(field.name) === 'mobile'" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
            </button>
        </span>

        <button type="button" class="rj-reset" x-show="!isDefault(field)" @click="resetField(field)" :title="t('Reset to default')">↺</button>
    </div>
</template>
