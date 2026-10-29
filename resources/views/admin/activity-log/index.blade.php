@extends('admin.layouts.app')

@section('title', __('Activity Log'))

@section('content')
<div class="space-y-6" x-data="{ selected: [], clearOpen: false, clearDays: '30' }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Activity Log') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Track all changes and actions made by users.') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="clearOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                {{ __('Clear Logs') }}
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="text-sm font-medium text-gray-500">{{ __('Total Logs') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['all']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="text-sm font-medium text-gray-500">{{ __('Today') }}</div>
            <div class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($counts['today']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="text-sm font-medium text-gray-500">{{ __('This Week') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['week']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="text-sm font-medium text-gray-500">{{ __('This Month') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['month']) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form method="GET" action="{{ route('admin.activity-log.index') }}" class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search description, IP...') }}" class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('Log Type') }}</label>
                <select name="log_name" class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">{{ __('All Types') }}</option>
                    @foreach($logNames as $name)
                        <option value="{{ $name }}" {{ request('log_name') === $name ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('Event') }}</label>
                <select name="event" class="w-full h-9 rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">{{ __('All Events') }}</option>
                    @foreach($events as $event)
                        <option value="{{ $event }}" {{ request('event') === $event ? 'selected' : '' }}>{{ ucfirst($event) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('From') }}</label>
                <input type="date" name="from" value="{{ request('from') }}" class="h-9 rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('To') }}</label>
                <input type="date" name="to" value="{{ request('to') }}" class="h-9 rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="h-9 px-4 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">{{ __('Filter') }}</button>
                @if(request()->anyFilled(['q', 'log_name', 'event', 'from', 'to']))
                    <a href="{{ route('admin.activity-log.index') }}" class="h-9 px-4 rounded-lg bg-white border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition flex items-center">{{ __('Reset') }}</a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 w-10">
                            <input type="checkbox" @change="selected = $event.target.checked ? {{ $logs->pluck('id') }} : []" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-4 py-3 font-semibold">{{ __('User') }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('Event') }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('Description') }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('IP Address') }}</th>
                        <th class="px-4 py-3 font-semibold text-right">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <input type="checkbox" value="{{ $log->id }}" x-model="selected" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($log->causerName(), 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $log->causerName() }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $log->logNameLabel() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $log->eventLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="max-w-md truncate" title="{{ $log->description }}">{{ $log->description }}</div>
                                @if($log->subjectLabel())
                                    <div class="text-[11px] text-gray-400 mt-0.5">{{ __('Subject:') }} {{ $log->subjectLabel() }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address ?: '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-gray-400" title="{{ $log->created_at->format('H:i:s') }}">{{ $log->ago() }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p>{{ __('No activity logs found.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <div x-show="selected.length > 0" x-cloak x-transition class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-4">
        <span class="text-sm font-medium"><span x-text="selected.length"></span> {{ __('items selected') }}</span>
        <div class="w-px h-4 bg-gray-700"></div>
        <button type="button" @click="fetch('{{ route('admin.activity-log.bulk') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ ids: selected, action: 'delete' }) }).then(() => window.location.reload())" class="text-sm font-semibold text-red-400 hover:text-red-300 transition">{{ __('Delete Selected') }}</button>
        <button type="button" @click="selected = []" class="text-gray-400 hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>

    <div x-show="clearOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="clearOpen" x-transition.opacity @click="clearOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="clearOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Clear Activity Logs') }}</h3>
            <p class="text-sm text-gray-500 mb-4">{{ __('Select how far back you want to keep logs. Older logs will be permanently deleted.') }}</p>

            <form method="POST" action="{{ route('admin.activity-log.clear') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Delete logs older than') }}</label>
                        <select name="days" x-model="clearDays" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="7">{{ __('1 Week') }}</option>
                            <option value="30">{{ __('1 Month') }}</option>
                            <option value="90">{{ __('3 Months') }}</option>
                            <option value="365">{{ __('1 Year') }}</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="clearOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">{{ __('Clear Logs') }}</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
