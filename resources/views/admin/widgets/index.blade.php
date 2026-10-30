@extends('admin.layouts.app')

@section('title', __('Widgets'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ uploadOpen: false, selected: [], bulkAction: '' }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Widgets') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage custom RJBuilder widgets uploaded to your site.') }}</p>
        </div>
        <button type="button" @click="uploadOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            {{ __('Upload Widget') }}
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('All Widgets') }}</div>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Errors') }}</div>
            <div class="text-2xl font-bold text-red-600 mt-1">{{ number_format($counts['error']) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.widgets.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search by name or slug...') }}" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
            </div>
            <div class="w-48">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                <select name="category" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $key => $cat)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $cat['label'] ?? $key }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Status') }}</label>
                <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                    <option value="">{{ __('All') }}</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    <option value="error" {{ request('status') === 'error' ? 'selected' : '' }}>{{ __('Error') }}</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">{{ __('Filter') }}</button>
            @if(request()->anyFilled(['q', 'category', 'status']))
                <a href="{{ route('admin.widgets.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form method="POST" action="{{ route('admin.widgets.bulk') }}" @submit.prevent="if (selected.length === 0 || !bulkAction) return; $el.submit()">
            @csrf
            <div x-show="selected.length > 0" x-cloak class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <span class="text-xs text-gray-600"><b x-text="selected.length"></b> {{ __('selected') }}</span>
                <select x-model="bulkAction" class="rounded-lg border-gray-300 text-xs py-1 pl-2 pr-6">
                    <option value="">{{ __('Action') }}</option>
                    <option value="activate">{{ __('Activate') }}</option>
                    <option value="deactivate">{{ __('Deactivate') }}</option>
                    <option value="delete">{{ __('Delete') }}</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-gray-900 text-white rounded text-xs font-medium hover:bg-gray-800">{{ __('Apply') }}</button>
                <template x-for="slug in selected" :key="slug">
                    <input type="hidden" name="slugs[]" :value="slug">
                </template>
                <input type="hidden" name="action" :value="bulkAction">
            </div>

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="w-10 px-6 py-4">
                            <input type="checkbox" @change="selected = $event.target.checked ? {{ $widgets->pluck('slug')->toJson() }} : []" class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        </th>
                        <th class="px-6 py-4 font-semibold">{{ __('Name') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Category') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                        <th class="px-6 py-4 font-semibold text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($widgets as $widget)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <input type="checkbox" :value="'{{ $widget->slug }}'" x-model="selected" class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $widget->name }}</div>
                                <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $widget->slug }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-xs font-medium">
                                    {{ $widget->category ?: __('General') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($widget->status === 'active')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">{{ __('Active') }}</span>
                                @elseif($widget->status === 'error')
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">{{ __('Error') }}</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.widgets.show', $widget) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ __('View Details') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.46 12C3.73 7.94 7.52 5 12 5s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7S3.73 16.06 2.46 12z"/></svg>
                                    </a>

                                    @if($widget->status === 'active')
                                        <form method="POST" action="{{ route('admin.widgets.deactivate', $widget) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="{{ __('Deactivate') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.widgets.activate', $widget) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="{{ __('Activate') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.widgets.destroy', $widget) }}" onsubmit="return confirm('{{ __('Delete this widget permanently?') }}')" class="inline">
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
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                                <p>{{ __('No custom widgets found.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>

    <div x-show="uploadOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="uploadOpen" x-transition.opacity @click="uploadOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="uploadOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <form method="POST" action="{{ route('admin.widgets.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Upload Widget') }}</h3>
                    <button type="button" @click="uploadOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-sm text-gray-600">{{ __('Upload a .zip file containing your RJBuilder widget.') }}</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Widget Package (.zip)') }}</label>
                        <input type="file" name="file" accept=".zip" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rj-purple/10 file:text-rj-purple hover:file:bg-rj-purple/20">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-2">
                    <button type="button" @click="uploadOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90">{{ __('Upload & Install') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
