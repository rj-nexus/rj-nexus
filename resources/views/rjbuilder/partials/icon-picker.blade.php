<div x-show="iconPickerOpen" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4" @keydown.escape.window="iconPickerOpen = false">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="iconPickerOpen = false"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl flex flex-col h-[80vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50 rounded-t-2xl">
            <div>
                <h3 class="text-base font-semibold text-gray-900">{{ __('Select an Icon') }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('Search from thousands of open-source icons (Phosphor, Lucide, Tabler).') }}</p>
            </div>
            <button type="button" @click="iconPickerOpen = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Search -->
        <div class="p-4 border-b border-gray-100">
            <div class="relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="iconSearch" @input="searchIcons()" placeholder="{{ __('Search icons (e.g. home, cart, user, arrow...)') }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>
        </div>

        <!-- Grid -->
        <div class="flex-1 overflow-y-auto p-6 bg-slate-50/50">
            <div x-show="iconsLoading" class="text-center py-10 text-gray-400">
                <svg class="w-8 h-8 animate-spin mx-auto mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                {{ __('Loading icons...') }}
            </div>

            <div x-show="!iconsLoading && iconList.length === 0" class="text-center py-10 text-gray-500">
                {{ __('No icons found.') }}
            </div>

            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3" x-show="!iconsLoading">
                <template x-for="icon in iconList" :key="icon">
                    <button type="button"
                            @click="selectIcon(icon)"
                            class="flex flex-col items-center justify-center p-3 bg-white rounded-xl border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all group"
                            :title="icon">
                        <span x-html="getIconSvg(icon)" class="w-6 h-6 text-gray-600 group-hover:text-indigo-600"></span>
                        <span class="text-[9px] text-gray-400 mt-2 truncate w-full text-center" x-text="icon.split(':')[1]"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-white rounded-b-2xl flex justify-between items-center text-xs text-gray-500">
            <span>Powered by <a href="https://iconify.design" target="_blank" class="text-indigo-500 hover:underline">Iconify</a></span>
            <button type="button" @click="iconPickerOpen = false" class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">{{ __('Cancel') }}</button>
        </div>
    </div>
</div>
