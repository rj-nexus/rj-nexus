@extends('admin.layouts.app')

@section('title', __('Post Types'))

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{ deleteId: null }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Post Types') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage custom content structures (e.g., Portfolio, Services).') }}</p>
        </div>
        <a href="{{ route('admin.post-types.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Add New Type') }}
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">{{ __('Name') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Slug') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Position') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                    <th class="px-6 py-4 font-semibold text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($postTypes as $type)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-rj-purple/10 text-rj-purple flex items-center justify-center">
                                    @if($type->icon)
                                        {!! rj_icon($type->icon) !!}
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $type->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $type->singular_name }} / {{ $type->plural_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $type->slug }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $type->menu_position }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ $type->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($type->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.post-types.edit', $type) }}" class="p-2 text-gray-400 hover:text-rj-purple hover:bg-rj-purple/10 rounded-lg transition" title="{{ __('Edit') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                @if(!in_array($type->slug, ['post', 'page']))
                                    <form method="POST" action="{{ route('admin.post-types.destroy', $type) }}" onsubmit="return confirm('{{ __('Delete this post type?') }}')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <p>{{ __('No custom post types found.') }}</p>
                        </a>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
