@extends('admin.layouts.app')

@section('title', __('Global Widgets'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ showCreateModal: false }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Global Widgets') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage reusable blocks that can be inserted anywhere across your site.') }}</p>
        </div>
        <button type="button" @click="showCreateModal = true" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white font-medium hover:opacity-90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Create New') }}
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($widgets->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">{{ __('No global widgets yet') }}</h3>
                <p class="text-sm text-gray-500 mt-1 mb-6">{{ __('Create a reusable block and insert it anywhere in your builder.') }}</p>
                <button type="button" @click="showCreateModal = true" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition">
                    {{ __('Create your first widget') }}
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($widgets as $widget)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $widget->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-xs font-medium border border-gray-200 uppercase">
                                        {{ $widget->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($widget->description, 60) ?: '—' }}</td>
                                <td class="px-6 py-4 text-sm text-right flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.global-widgets.edit', $widget) }}" class="w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 flex items-center justify-center transition" title="{{ __('Edit') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.global-widgets.duplicate', $widget) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition" title="{{ __('Duplicate') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.global-widgets.destroy', $widget) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this widget?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition" title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($widgets->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $widgets->links() }}
                </div>
            @endif
        @endif
    </div>

    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div x-show="showCreateModal" x-transition.opacity class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showCreateModal = false"></div>

        <div x-show="showCreateModal" x-transition.scale.origin.center class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">{{ __('Create Global Widget') }}</h3>
                <button type="button" @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.global-widgets.store') }}" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }}</label>
                    <input type="text" name="name" required class="w-full rounded-xl border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm" placeholder="{{ __('e.g. Main Call to Action') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Type') }}</label>
                    <select name="type" required class="w-full rounded-xl border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        <option value="block">{{ __('Block') }}</option>
                        <option value="header">{{ __('Header') }}</option>
                        <option value="footer">{{ __('Footer') }}</option>
                        <option value="popup">{{ __('Popup') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description (optional)') }}</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm" placeholder="{{ __('Brief description of this widget') }}"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-6 py-2 rounded-xl bg-rj-purple text-white font-medium hover:bg-rj-purple/90 transition">
                        {{ __('Create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
