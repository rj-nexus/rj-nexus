<template x-if="dynamicTagPicker.open">
    <div class="rj-modal" @keydown.escape.window="closeTagPicker()">
        <div class="bg" @click="closeTagPicker()"></div>
        <div class="box" style="max-width:640px; background:#1e1e24; border:1px solid #333; border-radius:16px; padding:24px; box-shadow:0 20px 40px -10px rgba(0,0,0,0.8);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div>
                    <!-- Başlıq rəngi ağ edildi -->
                    <h2 style="font-size:18px; font-weight:600; margin:0 0 4px; color:#ffffff;" x-text="t('Dynamic Tags')"></h2>
                    <p style="font-size:13px; color:#9ca3af; margin:0;" x-text="t('Choose a dynamic value to bind to this field.')"></p>
                </div>
                <button type="button" @click="closeTagPicker()" style="background:transparent; border:0; color:#9ca3af; cursor:pointer; padding:4px; display:flex; align-items:center; justify-content:center; transition:color .15s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#9ca3af'">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div style="max-height:420px; overflow-y:auto; padding-right:4px;" class="rj-scrollbar">
                <template x-for="group in dynamicTagGrouped" :key="group.key">
                    <div style="margin-bottom:18px;">
                        <!-- Qrup başlığı rəngi -->
                        <div style="font-size:11px; font-weight:700; color:#a78bfa; text-transform:uppercase; letter-spacing:.05em; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                            <span x-html="group.icon"></span>
                            <span x-text="group.label"></span>
                        </div>
                        <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px;">
                            <template x-for="tag in group.items" :key="tag.id">
                                <button type="button"
                                        @click="applyTag(tag)"
                                        style="text-align:left; padding:12px 14px; background:#27272a; border:1px solid #3f3f46; border-radius:10px; cursor:pointer; transition:all .15s;"
                                        onmouseover="this.style.borderColor='#8b5cf6'; this.style.background='rgba(139,92,246,0.1)';"
                                        onmouseout="this.style.borderColor='#3f3f46'; this.style.background='#27272a';">
                                    <!-- Düymə daxilindəki yazılar ağ edildi -->
                                    <div style="font-size:13px; font-weight:600; color:#ffffff; margin-bottom:2px;" x-text="tag.name"></div>
                                    <div style="font-size:11px; color:#a1a1aa; line-height:1.4;" x-text="tag.description"></div>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <div x-show="dynamicTagGrouped.length === 0" style="text-align:center; padding:32px 16px; color:#a1a1aa; font-size:13px;">
                    <span x-text="t('No dynamic tags available.')"></span>
                </div>
            </div>

            <div style="margin-top:20px; padding-top:16px; border-top:1px solid #3f3f46; text-align:right;">
                <button type="button" @click="closeTagPicker()" style="padding:8px 16px; background:#27272a; border:1px solid #3f3f46; border-radius:8px; color:#ffffff; font-size:13px; cursor:pointer; font-weight:600; transition:background .15s;" onmouseover="this.style.background='#3f3f46'" onmouseout="this.style.background='#27272a'" x-text="t('Cancel')"></button>
            </div>
        </div>
    </div>
</template>
