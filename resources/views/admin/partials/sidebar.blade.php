<div class="rj-aside-back lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     x-transition:enter="rj-o-e" x-transition:enter-start="rj-o-0" x-transition:enter-end="rj-o-1"
     x-transition:leave="rj-o-l" x-transition:leave-start="rj-o-1" x-transition:leave-end="rj-o-0"></div>

<aside class="rj-aside w-64 h-screen sticky top-0 self-start z-50 bg-gradient-to-b from-rj-dark-1 via-rj-dark-2 to-rj-dark-1 text-gray-300 flex-shrink-0 flex flex-col" :class="{ 'is-open': sidebarOpen }">
    <div class="h-20 flex items-center justify-center px-5 border-b border-white/5 flex-shrink-0 relative">
        <a href="{{ route('admin.dashboard') }}" class="hover:opacity-90 transition inline-flex items-center">
            @if ($logoMask)
                <div class="rj-logo-mask h-12 w-40" style="-webkit-mask-image: url('{{ $logoMask }}'); mask-image: url('{{ $logoMask }}');"></div>
            @else
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto">
            @endif
        </a>
        <button type="button" class="lg:hidden absolute top-3 end-3 p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition" @click="sidebarOpen = false" aria-label="{{ __('Close') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>

    <nav class="rj-scrollbar flex-1 overflow-y-auto p-3 space-y-0.5 text-sm">
        @foreach ($navSections as $section)
            @if (!empty($section['items']))
                @if ($section['title'])
                    <div class="pt-3 mt-3 border-t border-white/5">
                        <div class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ $section['title'] }}
                        </div>
                @endif

                @foreach ($section['items'] as $item)
                    @php
                        $hasChildren = !empty($item['children']);
                        $itemUrl = $item['url'] ?? ($hasChildren ? $item['children'][0]['url'] : '#');

                        $hasActiveChild = false;
                        if ($hasChildren) {
                            foreach ($item['children'] as $child) {
                                if (!empty($child['route']) && request()->routeIs($child['route'])) {
                                    $hasActiveChild = true;
                                    break;
                                }
                            }
                        }
                        $isParentActive = ($item['active'] ?? false) || $hasActiveChild;
                    @endphp

                    @if ($hasChildren)
                        @if ($isParentActive)
                            <div>
                                <a href="{{ $itemUrl }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition bg-white/10 text-white">
                                    <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                                <div class="mt-1 space-y-0.5 ms-4 border-s border-white/10 ps-2">
                                    @foreach ($item['children'] as $child)
                                        @php $childActive = !empty($child['route']) && request()->routeIs($child['route']); @endphp
                                        <a href="{{ $child['url'] }}"
                                           class="block px-3 py-1.5 rounded-lg text-sm transition {{ $childActive ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="relative"
                                 x-data="{
                                     open: false,
                                     top: 0,
                                     timer: null,
                                     show(el) {
                                         clearTimeout(this.timer);
                                         this.open = true;
                                         const r = el.getBoundingClientRect();
                                         this.top = r.top;
                                         this.$nextTick(() => {
                                             const h = this.$refs.fly ? this.$refs.fly.offsetHeight : 0;
                                             this.top = Math.max(8, Math.min(r.top, window.innerHeight - h - 8));
                                         });
                                     },
                                     hide() {
                                         this.timer = setTimeout(() => { this.open = false; }, 150);
                                     },
                                     keep() {
                                         clearTimeout(this.timer);
                                     }
                                 }"
                                 @mouseenter="show($el)"
                                 @mouseleave="hide()">

                                <a href="{{ $itemUrl }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-white/5 hover:text-white">
                                    <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                                    <span>{{ $item['label'] }}</span>
                                </a>

                                <div x-show="open" x-cloak x-ref="fly"
                                     @mouseenter="keep()"
                                     @mouseleave="hide()"
                                     class="fixed z-[99999] ps-2"
                                     :style="`top:${top}px; inset-inline-start:16rem;`">
                                    <div class="min-w-[12rem] overflow-hidden rounded-lg border border-white/10 shadow-2xl py-2 text-sm bg-gradient-to-b from-rj-dark-1 via-rj-dark-2 to-rj-dark-1"
                                         style="background-color:#14121f;">
                                        <div class="px-4 pb-1.5 mb-1 border-b border-white/10 text-white font-semibold">{{ $item['label'] }}</div>
                                        @foreach ($item['children'] as $child)
                                            @php $childActive = !empty($child['route']) && request()->routeIs($child['route']); @endphp
                                            <a href="{{ $child['url'] }}"
                                               class="block px-4 py-1.5 transition {{ $childActive ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                                {{ $child['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <a href="{{ $itemUrl }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ ($item['active'] ?? false) ? 'bg-gradient-to-r from-rj-purple/30 to-rj-pink/20 text-white border-s-2 border-rj-purple-light' : 'hover:bg-white/5 hover:text-white' }}">
                            <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach

                @if ($section['title'])
                    </div>
                @endif
            @endif
        @endforeach
    </nav>

    <div class="p-3 border-t border-white/5 text-xs text-gray-500 flex items-center justify-between flex-shrink-0">
        <span>v{{ config('app.version', '1.0.0') }}</span>
        <a href="{{ route('home') }}" target="_blank" class="hover:text-white transition flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            {{ __('View Site') }}
        </a>
    </div>
</aside>