@extends('admin.layouts.app')

@section('title', __('Options'))

@section('content')
<div class="space-y-6" x-data="appearanceOptions(@js($options), @js($defaults))">

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-base font-semibold text-gray-900">{{ __('Site Options') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Theme-independent global settings: identity, custom code, tracking.') }}</p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" @click="resetAll()" :disabled="saving"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50 transition disabled:opacity-60">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                {{ __('Restore Defaults') }}
            </button>

            <button type="button" @click="save()" :disabled="saving || !isDirty"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition disabled:opacity-60">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                <span x-text="saving ? '{{ __('Saving...') }}' : '{{ __('Save Changes') }}'"></span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">

        <div class="border-b border-gray-100">
            <nav class="flex px-4 gap-1">
                <button type="button" @click="tab = 'identity'"
                        :class="tab === 'identity' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-3 border-b-2 text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ __('Site Identity') }}
                </button>
                <button type="button" @click="tab = 'code'"
                        :class="tab === 'code' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-3 border-b-2 text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    {{ __('Custom Code') }}
                </button>
                <button type="button" @click="tab = 'tracking'"
                        :class="tab === 'tracking' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-3 border-b-2 text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ __('Tracking') }}
                </button>
            </nav>
        </div>

        <div class="p-6">

            <div x-show="tab === 'identity'" x-cloak class="space-y-6">

                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-blue-800">
                        {{ __('These are global and persist across theme changes. Themes reference them via rj_site_option().') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Logo Light --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Logo (Light)') }}</label>
                        <div class="flex items-center gap-3">
                            <div class="w-20 h-20 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                <template x-if="options.logo_light">
                                    <img :src="options.logo_light" class="max-w-full max-h-full object-contain" alt="">
                                </template>
                                <template x-if="!options.logo_light">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </template>
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" x-model="options.logo_light" @input="markDirty()" placeholder="https://... or /storage/..."
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <button type="button" @click="openMediaPicker('logo_light')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 whitespace-nowrap transition">
                                        {{ __('Select') }}
                                    </button>
                                </div>
                                <button type="button" @click="options.logo_light = ''; markDirty()" x-show="options.logo_light" class="text-xs text-red-600 hover:underline">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </div>

                    {{-- Logo Dark --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Logo (Dark)') }}</label>
                        <div class="flex items-center gap-3">
                            <div class="w-20 h-20 rounded-lg bg-gray-800 border border-gray-700 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                <template x-if="options.logo_dark">
                                    <img :src="options.logo_dark" class="max-w-full max-h-full object-contain" alt="">
                                </template>
                                <template x-if="!options.logo_dark">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </template>
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" x-model="options.logo_dark" @input="markDirty()" placeholder="https://... or /storage/..."
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <button type="button" @click="openMediaPicker('logo_dark')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 whitespace-nowrap transition">
                                        {{ __('Select') }}
                                    </button>
                                </div>
                                <button type="button" @click="options.logo_dark = ''; markDirty()" x-show="options.logo_dark" class="text-xs text-red-600 hover:underline">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Favicon') }}</label>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                <template x-if="options.favicon">
                                    <img :src="options.favicon" class="max-w-full max-h-full object-contain" alt="">
                                </template>
                                <template x-if="!options.favicon">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </template>
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" x-model="options.favicon" @input="markDirty()" placeholder="/images/favicon.png"
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <button type="button" @click="openMediaPicker('favicon')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 whitespace-nowrap transition">
                                        {{ __('Select') }}
                                    </button>
                                </div>
                                <button type="button" @click="options.favicon = ''; markDirty()" x-show="options.favicon" class="text-xs text-red-600 hover:underline">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </div>

                    {{-- OG Image --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('OG Image') }}</label>
                        <div class="flex items-center gap-3">
                            <div class="w-20 h-12 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                <template x-if="options.og_image">
                                    <img :src="options.og_image" class="max-w-full max-h-full object-contain" alt="">
                                </template>
                                <template x-if="!options.og_image">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                                </template>
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" x-model="options.og_image" @input="markDirty()" placeholder="1200x630 recommended"
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <button type="button" @click="openMediaPicker('og_image')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 whitespace-nowrap transition">
                                        {{ __('Select') }}
                                    </button>
                                </div>
                                <button type="button" @click="options.og_image = ''; markDirty()" x-show="options.og_image" class="text-xs text-red-600 hover:underline">{{ __('Clear') }}</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-xs text-gray-500 bg-gray-50 rounded-lg p-3">
                    {{ __('Tip: click "Select" to choose an image from your Media Library, or paste a URL manually.') }}
                </div>
            </div>

            <div x-show="tab === 'code'" x-cloak class="space-y-6">
                {{-- Custom Code Tab Content --}}
            </div>

            <div x-show="tab === 'tracking'" x-cloak class="space-y-6">
                {{-- Tracking Tab Content --}}
            </div>

        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
            <div>
                <span x-show="isDirty" class="inline-flex items-center gap-1.5 text-amber-600">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    {{ __('Unsaved changes') }}
                </span>
                <span x-show="!isDirty" class="inline-flex items-center gap-1.5 text-green-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ __('All changes saved') }}
                </span>
            </div>
            <div class="font-mono">{{ __('Keys are stored in rj_options with site_opt_ prefix') }}</div>
        </div>
    </div>

    <div x-show="toast.show" x-cloak x-transition
         class="fixed bottom-6 right-6 px-5 py-3 rounded-xl shadow-2xl text-white text-sm font-medium z-50"
         :style="'background:' + (toast.type === 'error' ? '#dc2626' : '#059669')"
         x-text="toast.message"></div>

</div>

@include('admin.partials.media-picker')

<script>
function appearanceOptions(initial, defaults) {
    return {
        tab: 'identity',
        options: JSON.parse(JSON.stringify(initial)),
        originalSnapshot: JSON.stringify(initial),
        defaults: defaults,
        saving: false,
        isDirty: false,
        toast: { show: false, message: '', type: 'success' },
        mediaTarget: null,

        init() {
            window.addEventListener('media-selected', (e) => {
                if (this.mediaTarget) {
                    this.options[this.mediaTarget] = e.detail.url;
                    this.markDirty();
                    this.mediaTarget = null;
                }
            });
        },

        openMediaPicker(field) {
            this.mediaTarget = field;
            window.dispatchEvent(new CustomEvent('open-media-picker'));
        },

        markDirty() {
            this.isDirty = JSON.stringify(this.options) !== this.originalSnapshot;
        },

        showToast(message, type) {
            this.toast = { show: true, message, type: type || 'success' };
            setTimeout(() => { this.toast.show = false; }, 3500);
        },

        async save() {
            this.saving = true;

            try {
                const res = await fetch('{{ route('admin.appearance.options.save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.options),
                });

                const data = await res.json().catch(() => ({}));

                if (res.ok && data.success) {
                    this.originalSnapshot = JSON.stringify(this.options);
                    this.isDirty = false;
                    this.showToast(data.message || '{{ __('Saved.') }}', 'success');
                } else {
                    this.showToast(data.message || '{{ __('Save failed.') }}', 'error');
                }
            } catch (e) {
                this.showToast('{{ __('Network error.') }}', 'error');
            } finally {
                this.saving = false;
            }
        },

        async resetAll() {
            if (!confirm('{{ __('Reset all site options to defaults? This cannot be undone.') }}')) return;

            this.saving = true;

            try {
                const res = await fetch('{{ route('admin.appearance.options.reset') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const data = await res.json().catch(() => ({}));

                if (res.ok && data.success) {
                    this.options = JSON.parse(JSON.stringify(data.options || this.defaults));
                    this.originalSnapshot = JSON.stringify(this.options);
                    this.isDirty = false;
                    this.showToast(data.message || '{{ __('Reset.') }}', 'success');
                } else {
                    this.showToast(data.message || '{{ __('Reset failed.') }}', 'error');
                }
            } catch (e) {
                this.showToast('{{ __('Network error.') }}', 'error');
            } finally {
                this.saving = false;
            }
        },
    };
}
</script>
@endsection