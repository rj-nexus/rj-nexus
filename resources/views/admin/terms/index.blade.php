@extends('admin.layouts.app')

@section('title', $taxonomy ? $taxonomy->plural_name : __('Terms'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ addOpen: false }">

    <!-- Header with Taxonomy Selector -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $taxonomy ? $taxonomy->plural_name : __('Terms') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $taxonomy ? __('Manage terms for this taxonomy.') : __('Select a taxonomy to manage its terms.') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if($taxonomies->isNotEmpty())
                <form method="GET" action="{{ route('admin.terms.index') }}" class="flex items-center gap-2">
                    <select name="taxonomy" onchange="this.form.submit()" class="rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm py-2 pl-3 pr-8">
                        @foreach($taxonomies as $tax)
                            <option value="{{ $tax->slug }}" {{ $taxonomySlug === $tax->slug ? 'selected' : '' }}>
                                {{ $tax->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            @if($taxonomy)
                <button type="button" @click="addOpen = !addOpen" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Add New') }}
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    @if(!$taxonomy)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <h3 class="text-lg font-bold text-gray-900">{{ __('No Taxonomies Found') }}</h3>
            <p class="text-gray-500 mt-1 mb-6">{{ __('You need to create a taxonomy before you can add terms.') }}</p>
            <a href="{{ route('admin.taxonomies.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition">
                {{ __('Create Taxonomy') }}
            </a>
        </div>
    @else
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('All') }}</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['all']) }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Active') }}</div>
                <div class="text-2xl font-bold text-green-600 mt-1">{{ number_format($counts['active']) }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Inactive') }}</div>
                <div class="text-2xl font-bold text-gray-400 mt-1">{{ number_format($counts['inactive']) }}</div>
            </div>
        </div>

        <!-- Add Term Form -->
        <div x-show="addOpen" x-cloak x-transition class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900">{{ __('Add New :type', ['type' => $taxonomy->singular_name]) }}</h2>
                <button type="button" @click="addOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.terms.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="taxonomy" value="{{ $taxonomySlug }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Slug') }}</label>
                            <input type="text" name="slug" placeholder="auto-generated" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono text-xs">
                        </div>
                        @if($taxonomy->is_hierarchical)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Parent') }}</label>
                                <select name="parent_id" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <option value="">{{ __('— None —') }}</option>
                                    @foreach($terms as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Terms List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.terms.index') }}" class="flex-1 max-w-md relative">
                    <input type="hidden" name="taxonomy" value="{{ $taxonomySlug }}">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search terms...') }}" class="w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                </form>
            </div>

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">{{ __('Name') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Slug') }}</th>
                        @if($taxonomy->is_hierarchical)
                            <th class="px-6 py-4 font-semibold">{{ __('Parent') }}</th>
                        @endif
                        <th class="px-6 py-4 font-semibold">{{ __('Count') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                        <th class="px-6 py-4 font-semibold text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($terms as $term)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $term->name }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $term->slug }}</td>
                            @if($taxonomy->is_hierarchical)
                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ $term->parent ? $term->parent->name : '—' }}
                                </td>
                            @endif
                            <td class="px-6 py-4 text-gray-600">{{ $term->posts()->count() }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $term->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $term->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.terms.edit', $term) }}" class="p-2 text-gray-400 hover:text-rj-purple hover:bg-rj-purple/10 rounded-lg transition" title="{{ __('Edit') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.terms.destroy', $term) }}" onsubmit="return confirm('{{ __('Delete this term?') }}')" class="inline">
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
                            <td colspan="{{ $taxonomy->is_hierarchical ? '6' : '5' }}" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <p>{{ __('No terms found.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($terms->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $terms->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
