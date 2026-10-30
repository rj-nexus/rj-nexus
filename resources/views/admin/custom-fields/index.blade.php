@extends('admin.layouts.app')

@section('title', __('Custom Fields'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Custom Fields') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage additional data fields for posts, taxonomies, and users.') }}</p>
        </div>
        <a href="{{ route('admin.custom-fields.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Add New Field') }}
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach(['all' => __('All Fields'), 'post' => __('Posts'), 'taxonomy' => __('Taxonomies'), 'user' => __('Users')] as $key => $label)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wide">{{ $label }}</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts[$key] ?? 0) }}</div>
            </div>
        @endforeach
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.custom-fields.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search by name or key...') }}" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Location') }}</label>
                <select name="location" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                    <option value="">{{ __('All') }}</option>
                    <option value="post" {{ request('location') === 'post' ? 'selected' : '' }}>{{ __('Post') }}</option>
                    <option value="taxonomy" {{ request('location') === 'taxonomy' ? 'selected' : '' }}>{{ __('Taxonomy') }}</option>
                    <option value="user" {{ request('location') === 'user' ? 'selected' : '' }}>{{ __('User') }}</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">{{ __('Filter') }}</button>
            @if(request()->anyFilled(['q', 'location', 'type']))
                <a href="{{ route('admin.custom-fields.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">{{ __('Name') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Key') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Type') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Location') }}</th>
                    <th class="px-6 py-4 font-semibold text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($fields as $field)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $field->name }}</div>
                            @if($field->is_required)
                                <span class="text-[10px] font-bold text-red-500 uppercase">{{ __('Required') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $field->key }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-xs font-medium">{{ $field->type }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-xs font-medium">{{ ucfirst($field->location) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.custom-fields.edit', $field) }}" class="p-2 text-gray-400 hover:text-rj-purple hover:bg-rj-purple/10 rounded-lg transition" title="{{ __('Edit') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.custom-fields.destroy', $field) }}" onsubmit="return confirm('{{ __('Delete this field?') }}')" class="inline">
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
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p>{{ __('No custom fields found.') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($fields->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">{{ $fields->links() }}</div>
        @endif
    </div>
</div>
@endsection
