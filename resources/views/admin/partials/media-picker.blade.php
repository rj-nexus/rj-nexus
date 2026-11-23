<div x-data="mediaPicker()" x-init="init()" @open-media-picker.window="open($event.detail)">

    <div x-show="isOpen" x-cloak
         @keydown.escape.window="close()"
         style="position: fixed; top: 0; right: 0; bottom: 0; left: 16rem; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem;">

        <div x-show="isOpen" x-transition.opacity
             @click="close()"
             style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);"></div>

        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-5xl flex flex-col overflow-hidden"
             style="max-height: 90vh;">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Media Library') }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('Select a file or upload a new one.') }}</p>
                </div>

                <button type="button" @click="close()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="px-6 py-3 border-b border-gray-100 flex items-center gap-3 flex-wrap flex-shrink-0">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="search" @input.debounce.300ms="page = 1; loadMedia()"
                           placeholder="{{ __('Search...') }}"
                           class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                </div>

                <select x-model="filter" @change="page = 1; loadMedia()"
                        class="rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    <option value="">{{ __('All types') }}</option>
                    <option value="image">{{ __('Images') }}</option>
                    <option value="video">{{ __('Videos') }}</option>
                    <option value="audio">{{ __('Audio') }}</option>
                    <option value="pdf">{{ __('PDF') }}</option>
                    <option value="document">{{ __('Documents') }}</option>
                    <option value="archive">{{ __('Archives') }}</option>
                </select>

                <label class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Upload') }}
                    <input type="file" class="hidden" multiple
                           accept="image/*,video/*,audio/*,.jpg,.jpeg,.png,.gif,.webp,.svg,.bmp,.ico,.avif,.tiff,.tif,.heic,.mp4,.webm,.mov,.avi,.mkv,.m4v,.wmv,.flv,.3gp,.mpeg,.mpg,.ogv,.mp3,.wav,.ogg,.m4a,.aac,.flac,.opus,.wma,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.rtf,.odt,.ods,.odp,.zip,.rar,.7z,.tar,.gz"
                           @change="uploadFile($event)">
                </label>
            </div>

            <div class="flex-1 overflow-y-auto rj-scrollbar p-4" style="min-height: 200px;">

                <div x-show="loading" class="py-12 text-center">
                    <svg class="w-8 h-8 mx-auto text-rj-purple animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                </div>

                <div x-show="!loading && items.length === 0" x-cloak class="py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="mt-3 text-sm text-gray-500">{{ __('No media found.') }}</p>
                </div>

                <div x-show="!loading && items.length > 0" x-cloak
                     class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    <template x-for="item in items" :key="item.id">
                        <button type="button"
                                @click="select(item)"
                                :class="selected && selected.id === item.id ? 'ring-2 ring-rj-purple ring-offset-2' : 'hover:border-rj-purple'"
                                class="relative rounded-lg overflow-hidden border border-gray-200 transition text-left group">
                            <div class="aspect-square bg-gray-50 flex items-center justify-center overflow-hidden relative">

                                <template x-if="item.type === 'image'">
                                    <img :src="item.url" :alt="item.original_name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition">
                                </template>

                                <template x-if="item.type === 'video'">
                                    <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </template>

                                <template x-if="item.type === 'audio'">
                                    <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                                </template>

                                <template x-if="item.type === 'pdf'">
                                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </template>

                                <template x-if="item.type === 'archive'">
                                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </template>

                                <template x-if="item.type === 'document'">
                                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </template>

                                <span x-show="item.type !== 'image' && item.ext" x-text="item.ext"
                                      class="absolute bottom-2 left-2 px-1.5 py-0.5 rounded bg-gray-900/70 text-white text-[9px] font-semibold uppercase tracking-wide"></span>
                            </div>

                            <div class="p-2 bg-white">
                                <div class="text-xs text-gray-900 truncate" x-text="item.original_name"></div>
                                <div class="text-[10px] text-gray-500 mt-0.5" x-text="item.size_human"></div>
                            </div>

                            <div x-show="selected && selected.id === item.id" x-cloak
                                 class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rj-purple flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </button>
                    </template>
                </div>

                <div x-show="!loading && total > items.length" x-cloak class="mt-4 text-center">
                    <button type="button" @click="loadMore()"
                            class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition">
                        {{ __('Load more') }}
                    </button>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-4 flex-shrink-0">
                <div class="text-xs text-gray-500">
                    <span x-show="!selected">{{ __('No file selected.') }}</span>
                    <span x-show="selected" x-cloak class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="selected?.original_name"></span>
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" @click="close()"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition">
                        {{ __('Cancel') }}
                    </button>
                    <button type="button" @click="confirm()" :disabled="!selected"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('Select') }}
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
function mediaPicker() {
    return {
        isOpen: false,
        target: null,
        search: '',
        filter: '',
        items: [],
        total: 0,
        page: 1,
        loading: false,
        selected: null,

        init() {},

        open(detail) {
            this.target = detail.value;
            this.selected = null;
            this.items = [];
            this.page = 1;
            this.search = '';
            // Sahə tip göndərirsə (məs. 'pdf', 'video'), filtr avtomatik seçilir
            this.filter = detail.type
                || (detail.value && detail.value.dataset ? (detail.value.dataset.mediaType || '') : '');
            this.isOpen = true;
            this.loadMedia();
        },

        close() {
            this.isOpen = false;
            this.selected = null;
        },

        async loadMedia(append = false) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: this.page,
                    search: this.search || '',
                    type: this.filter || '',
                });
                const res = await fetch(`{{ route('admin.media.picker') }}?${params}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                this.items = append ? [...this.items, ...data.items] : data.items;
                this.total = data.total;
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },

        loadMore() {
            this.page++;
            this.loadMedia(true);
        },

        select(item) {
            this.selected = item;
        },

        confirm() {
            if (!this.selected || !this.target) return;
            this.target.value = this.selected.url;
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { url: this.selected.url, item: this.selected, target: this.target }
            }));
            this.close();
        },

        async uploadFile(event) {
            const files = Array.from(event.target.files || []);
            if (!files.length) return;

            const formData = new FormData();
            files.forEach(function (f) { formData.append('files[]', f); });

            this.loading = true;
            try {
                const res = await fetch(`{{ route('admin.media.store') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                });

                if (res.status === 422) {
                    const data = await res.json();
                    alert(Object.values(data.errors || {}).flat().join('\n') || '{{ __('Upload failed.') }}');
                } else if (res.status === 413) {
                    alert('{{ __('File is too large.') }}');
                } else if (res.ok || res.redirected) {
                    this.page = 1;
                    await this.loadMedia();
                }
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
                event.target.value = '';
            }
        }
    }
}
</script>