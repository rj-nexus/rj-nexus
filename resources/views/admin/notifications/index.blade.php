@extends('admin.layouts.app')

@section('title', __('Notifications'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ selected: [], bulkAction: '' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Notifications') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Stay updated with what is happening on your site.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.notifications.settings') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('Settings') }}
            </a>
            <form method="POST" action="{{ route('admin.notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    {{ __('Mark all as read') }}
                </button>
            </form>
        </div>
    </div>

    <div class="flex items-center gap-2 border-b border-gray-200">
        <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ !request('filter') ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ __('All') }} <span class="ml-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('filter') === 'unread' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ __('Unread') }} <span class="ml-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs">{{ $counts['unread'] }}</span>
        </a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}" class="px-4 py-2 text-sm font-medium border-b-2 {{ request('filter') === 'read' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ __('Read') }} <span class="ml-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs">{{ $counts['read'] }}</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form method="POST" action="{{ route('admin.notifications.bulk') }}" @submit.prevent="if (selected.length === 0 || !bulkAction) return; $el.submit()">
            @csrf
            <div x-show="selected.length > 0" x-cloak class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <span class="text-xs text-gray-600"><b x-text="selected.length"></b> {{ __('selected') }}</span>
                <select x-model="bulkAction" class="rounded-lg border-gray-300 text-xs py-1 pl-2 pr-6">
                    <option value="">{{ __('Action') }}</option>
                    <option value="read">{{ __('Mark Read') }}</option>
                    <option value="unread">{{ __('Mark Unread') }}</option>
                    <option value="delete">{{ __('Delete') }}</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-gray-900 text-white rounded text-xs font-medium hover:bg-gray-800">{{ __('Apply') }}</button>
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <input type="hidden" name="action" :value="bulkAction">
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <div class="flex items-start gap-4 p-4 hover:bg-gray-50/50 transition {{ !$notification->isRead() ? 'bg-indigo-50/30' : '' }}">
                        <div class="pt-1">
                            <input type="checkbox" :value="{{ $notification->id }}" x-model.number="selected" class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        </div>

                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: {{ $notification->color ?? '#7c3aed' }}15; color: {{ $notification->color ?? '#7c3aed' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.notifications.show', $notification) }}" class="text-sm font-bold {{ !$notification->isRead() ? 'text-gray-900' : 'text-gray-600' }} hover:text-rj-purple truncate">
                                    {{ $notification->title }}
                                </a>
                                <span class="text-[10px] text-gray-400 whitespace-nowrap">{{ $notification->ago() }}</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                            @if($notification->action_url)
                                <a href="{{ $notification->action_url }}" class="inline-block mt-2 text-xs font-bold text-rj-purple hover:underline">
                                    {{ $notification->action_label ?: __('View Details') }} &rarr;
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-1 flex-shrink-0">
                            <form method="POST" action="{{ route('admin.notifications.' . ($notification->isRead() ? 'unread' : 'read'), $notification) }}">
                                @csrf
                                <button type="submit" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ $notification->isRead() ? __('Mark Unread') : __('Mark Read') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/></svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" onsubmit="return confirm('{{ __('Delete this notification?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('Delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <p>{{ __('No notifications found.') }}</p>
                    </div>
                @endforelse
            </div>
        </form>

        @if($notifications->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
