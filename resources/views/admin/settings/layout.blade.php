@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row gap-6 items-start">
        <aside class="w-full md:w-64 flex-shrink-0">
            <nav class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 space-y-1 text-sm sticky top-6">
                <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                    {{ __('Configuration') }}
                </div>

                <a href="{{ route('admin.settings.general') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.general') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('General') }}</a>
                <a href="{{ route('admin.settings.writing') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.writing') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Writing') }}</a>
                <a href="{{ route('admin.settings.reading') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.reading') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Reading') }}</a>
                <a href="{{ route('admin.settings.discussion') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.discussion') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Discussion') }}</a>
                <a href="{{ route('admin.settings.media') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.media') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Media') }}</a>
                <a href="{{ route('admin.settings.permalinks') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.permalinks') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Permalinks') }}</a>

                <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
                    {{ __('Design & Content') }}
                </div>

                <a href="{{ route('admin.settings.language') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.language*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Language') }}</a>
                <a href="{{ route('admin.settings.colors') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.colors') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Colors') }}</a>
                <a href="{{ route('admin.settings.seo') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.seo') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('SEO') }}</a>

                <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
                    {{ __('System') }}
                </div>

                <a href="{{ route('admin.settings.email') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.email*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Email / SMTP') }}</a>
                <a href="{{ route('admin.settings.security') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.security') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Security') }}</a>
                <a href="{{ route('admin.settings.backup') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.backup') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Backup') }}</a>
                <a href="{{ route('admin.settings.cache') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.cache') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Cache') }}</a>
                <a href="{{ route('admin.settings.social') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.social') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Social Login') }}</a>
                <a href="{{ route('admin.settings.notifications') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.notifications') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Notifications') }}</a>
                <a href="{{ route('admin.settings.api') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.api') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('API & Integrations') }}</a>
                <a href="{{ route('admin.settings.ai') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.ai') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('AI Settings') }}</a>

                <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
                    {{ __('Advanced') }}
                </div>

                <a href="{{ route('admin.settings.advanced') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.advanced') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Advanced') }}</a>

                <a href="{{ route('admin.activity-log.index') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.activity-log.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Activity Log') }}</a>

                <a href="{{ route('admin.settings.roles') }}" class="block px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.roles') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Roles') }}</a>
            </nav>
        </aside>

        <div class="flex-1 min-w-0">
            @yield('settings')
        </div>
    </div>
@endsection
