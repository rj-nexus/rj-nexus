@extends('admin.layouts.app')

@php
    $groups = [
        __('Configuration') => [
            ['route' => 'admin.settings.general',     'match' => 'admin.settings.general',     'label' => __('General'),     'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'],
            ['route' => 'admin.settings.writing',     'match' => 'admin.settings.writing',     'label' => __('Writing'),     'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
            ['route' => 'admin.settings.reading',     'match' => 'admin.settings.reading',     'label' => __('Reading'),     'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['route' => 'admin.settings.discussion',  'match' => 'admin.settings.discussion',  'label' => __('Discussion'),  'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ['route' => 'admin.settings.media',       'match' => 'admin.settings.media',       'label' => __('Media'),       'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['route' => 'admin.settings.permalinks',  'match' => 'admin.settings.permalinks',  'label' => __('Permalinks'),  'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
        ],
        __('Design & Content') => [
            ['route' => 'admin.settings.language',    'match' => 'admin.settings.language*',   'label' => __('Language'),    'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
            ['route' => 'admin.settings.colors',      'match' => 'admin.settings.colors',      'label' => __('Colors'),      'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
            ['route' => 'admin.settings.seo',         'match' => 'admin.settings.seo',         'label' => __('SEO'),         'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
        ],
        __('System') => [
            ['route' => 'admin.settings.email',         'match' => 'admin.settings.email*',      'label' => __('Email / SMTP'),      'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['route' => 'admin.settings.security',      'match' => 'admin.settings.security',    'label' => __('Security'),          'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['route' => 'admin.settings.backup',        'match' => 'admin.settings.backup',      'label' => __('Backup'),            'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
            ['route' => 'admin.settings.cache',         'match' => 'admin.settings.cache',       'label' => __('Cache'),             'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
            ['route' => 'admin.settings.social',        'match' => 'admin.settings.social',      'label' => __('Social Login'),      'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['route' => 'admin.settings.notifications', 'match' => 'admin.settings.notifications','label' => __('Notifications'),     'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
            ['route' => 'admin.settings.api',           'match' => 'admin.settings.api',         'label' => __('API & Integrations'),'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
            ['route' => 'admin.settings.ai',            'match' => 'admin.settings.ai',          'label' => __('AI Settings'),       'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
        ],
        __('Advanced') => [
            ['route' => 'admin.settings.advanced',    'match' => 'admin.settings.advanced',    'label' => __('Advanced'),     'icon' => 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['route' => 'admin.activity-log.index',   'match' => 'admin.activity-log.*',       'label' => __('Activity Log'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
            ['route' => 'admin.settings.roles',       'match' => 'admin.settings.roles',       'label' => __('Roles'),        'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
        ],
    ];

    // Current section label (for the mobile toggle button)
    $currentLabel = __('Settings');
    foreach ($groups as $items) {
        foreach ($items as $item) {
            if (request()->routeIs($item['match'])) { $currentLabel = $item['label']; }
        }
    }
@endphp

@section('content')
    <div class="flex flex-col md:flex-row gap-6 items-start">

        {{-- Sticky wrapper: sticky must be on the aside itself (not on the nav inside it) --}}
        <aside class="w-full md:w-64 flex-shrink-0 md:sticky md:top-6 md:self-start" x-data="{ open: false }">

            {{-- Mobile toggle --}}
            <button type="button" @click="open = !open"
                    class="md:hidden w-full flex items-center justify-between px-4 py-3 bg-white rounded-xl shadow-sm border border-gray-100 text-sm font-semibold text-gray-800">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    {{ $currentLabel }}
                </span>
                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <nav :class="{ 'hidden': !open }"
                 class="md:block mt-2 md:mt-0 bg-white rounded-xl shadow-sm border border-gray-100 p-2.5 text-sm
                        md:max-h-[calc(100vh-3rem)] md:overflow-y-auto overscroll-contain">

                @foreach ($groups as $groupTitle => $items)
                    <div class="px-3 pt-3 pb-1.5 flex items-center gap-2 {{ $loop->first ? 'pt-1.5' : 'mt-2 border-t border-gray-100' }}">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ $groupTitle }}</span>
                    </div>

                    <div class="space-y-0.5">
                        @foreach ($items as $item)
                            @php $active = request()->routeIs($item['match']); @endphp
                            <a href="{{ route($item['route']) }}"
                               class="group relative flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-150
                                      {{ $active
                                          ? 'bg-indigo-50 text-indigo-700 font-semibold'
                                          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:translate-x-0.5' }}">

                                {{-- active indicator --}}
                                @if ($active)
                                    <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-indigo-600"></span>
                                @endif

                                <svg class="w-[18px] h-[18px] flex-shrink-0 transition-colors {{ $active ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                                     fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>

                                <span class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 min-w-0">
            @yield('settings')
        </div>
    </div>
@endsection