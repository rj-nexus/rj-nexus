@extends('admin.layouts.app')

@section('title', __('Revisions'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ pruneOpen: false, pruneDays: 90 }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Revisions') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Track and restore previous versions of your content.') }}</p>
        </div>
        <button type="button" @click="pruneOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
            {{ __('Prune Old Revisions') }}
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Total Revisions') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['all']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Today') }}</div>
            <div class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($counts['today']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('This Week') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['week']) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.revisions.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search title or note...') }}" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
            </div>
            <div class="w-48">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Type') }}</label>
                <select name="type" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                    <option value="">{{ __('All Types') }}</option>
                    @foreach($types as $t)
                        <option value="{{ $t['value'] }}" {{ request('type') === $t['value'] ? 'selected' : '' }}>{{ $t['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">{{ __('Filter') }}</button>
            @if(request()->anyFilled(['q', 'type']))
                <a href="{{ route('admin.revisions.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">{{ __('Item') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Version') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('User') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Note') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Date') }}</th>
                    <th class="px-6 py-4 font-semibold text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($revisions as $revision)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $revision->title ?: __('(no title)') }}</div>
                            <div class="text-xs text-gray-500 font-mono mt-0.5">
                                {{ class_basename($revision->revisionable_type) }} #{{ $revision->revisionable_id }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-rj-purple/10 text-rj-purple text-xs font-bold">
                                v{{ $revision->version }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-700">{{ $revision->user->name ?? __('System') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-500 text-xs max-w-xs truncate" title="{{ $revision->note }}">{{ $revision->note ?: '—' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-700">{{ $revision->created_at->format('M d, Y') }}</div>
                            <div class="text-gray-400 text-xs">{{ $revision->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.revisions.show', $revision) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ __('View Details') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.46 12C3.73 7.94 7.52 5 12 5s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7S3.73 16.06 2.46 12z"/></svg>
                                </a>

                                <form method="POST" action="{{ route('admin.revisions.restore', $revision) }}" onsubmit="return confirm('{{ __('Restore this version? Current changes will be backed up.') }}')" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="{{ __('Restore Version') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.revisions.destroy', $revision) }}" onsubmit="return confirm('{{ __('Delete this revision permanently?') }}')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('Delete') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p>{{ __('No revisions found.') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($revisions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $revisions->links() }}
            </div>
        @endif
    </div>

    <div x-show="pruneOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="pruneOpen" x-transition.opacity @click="pruneOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="pruneOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <form method="POST" action="{{ route('admin.revisions.prune') }}">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Prune Old Revisions') }}</h3>
                    <button type="button" @click="pruneOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">{{ __('Select how old a revision must be before it is permanently deleted. This action cannot be undone.') }}</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Delete revisions older than') }}</label>
                        <select name="days" x-model="pruneDays" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="30">{{ __('1 Month (30 days)') }}</option>
                            <option value="90">{{ __('3 Months (90 days)') }}</option>
                            <option value="180">{{ __('6 Months (180 days)') }}</option>
                            <option value="365">{{ __('1 Year (365 days)') }}</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-2">
                    <button type="button" @click="pruneOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700" onclick="return confirm('{{ __('Are you sure you want to permanently delete old revisions?') }}')">{{ __('Prune Now') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
