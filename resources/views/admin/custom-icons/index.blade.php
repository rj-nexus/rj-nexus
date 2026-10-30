@extends('admin.layouts.app')

@section('title', __('Custom Icons'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ addOpen: false }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Custom Icons') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage SVG icons available for RJBuilder and widgets.') }}</p>
        </div>
        <button type="button" @click="addOpen = !addOpen" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Add New Icon') }}
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Form (Collapsible) -->
    <div x-show="addOpen" x-cloak x-transition class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-900">{{ __('Add Icon') }}</h2>
            <button type="button" @click="addOpen = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.custom-icons.store') }}" enctype="multipart/form-data" class="p-6" x-data="{ source: 'svg' }">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Icon Name') }}</label>
                        <input type="text" name="name" required placeholder="e.g. Home, User, Settings" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Library (Optional)') }}</label>
                        <input type="text" name="library" placeholder="e.g. Feather, FontAwesome" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        <p class="text-xs text-gray-500 mt-1">{{ __('Group icons by library for easier finding.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Source') }}</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="source" value="svg" x-model="source" class="text-rj-purple focus:ring-rj-purple">
                                <span class="text-sm">{{ __('Paste SVG Code') }}</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="source" value="upload" x-model="source" class="text-rj-purple focus:ring-rj-purple">
                                <span class="text-sm">{{ __('Upload SVG File') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div x-show="source === 'svg'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SVG Code') }}</label>
                        <textarea name="svg" rows="6" placeholder="<svg ...>...</svg>" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono"></textarea>
                    </div>
                    <div x-show="source === 'upload'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SVG File') }}</label>
                        <input type="file" name="file" accept=".svg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rj-purple/10 file:text-rj-purple hover:file:bg-rj-purple/20">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition">
                    {{ __('Save Icon') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.custom-icons.index') }}" class="flex flex-wrap gap-4 items-end bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search icons...') }}" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
        </div>
        <div class="w-48">
            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Library') }}</label>
            <select name="library" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                <option value="">{{ __('All Libraries') }}</option>
                @foreach($libraries as $lib)
                    <option value="{{ $lib }}" {{ request('library') === $lib ? 'selected' : '' }}>{{ $lib }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
            {{ __('Filter') }}
        </button>
        @if(request()->anyFilled(['q', 'library']))
            <a href="{{ route('admin.custom-icons.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">{{ __('Clear') }}</a>
        @endif
    </form>

    <!-- Icons Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-px bg-gray-100 border-b border-gray-100">
            @forelse($icons as $icon)
                <div class="bg-white p-4 flex flex-col items-center justify-center group relative">
                    <!-- Icon Preview -->
                    <div class="w-12 h-12 text-gray-700 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        {!! $icon->svg !!}
                    </div>

                    <!-- Icon Info -->
                    <div class="text-center w-full min-w-0">
                        <div class="text-xs font-semibold text-gray-900 truncate" title="{{ $icon->name }}">{{ $icon->name }}</div>
                        @if($icon->library)
                            <div class="text-[10px] text-gray-400 truncate">{{ $icon->library }}</div>
                        @endif
                    </div>

                    <!-- Delete Button (Hover) -->
                    <div class="absolute inset-0 bg-white/90 backdrop-blur-sm opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-none">
                        <form method="POST" action="{{ route('admin.custom-icons.destroy', $icon) }}" onsubmit="return confirm('{{ __('Delete this icon?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-full hover:bg-red-100 transition shadow-sm" title="{{ __('Delete') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center text-gray-500 bg-white">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>{{ __('No custom icons found.') }}</p>
                </div>
            @endforelse
        </div>

        @if($icons->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $icons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
