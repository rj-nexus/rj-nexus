@extends('admin.layouts.app')

@section('title', __('Custom Fonts'))

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Custom Fonts') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Upload custom typography files (WOFF, TTF, etc.) for your theme.') }}</p>
        </div>
        <a href="{{ route('frontend.fonts.css') }}" target="_blank" class="text-sm font-medium text-rj-purple hover:underline">
            {{ __('View Generated CSS') }} &rarr;
        </a>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- UPLOAD FORM --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-900">{{ __('Add New Font') }}</h2>
                </div>
                <form method="POST" action="{{ route('admin.custom-fonts.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Font Name') }}</label>
                        <input type="text" name="name" required placeholder="e.g. Inter" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Font Family (CSS)') }}</label>
                        <input type="text" name="family" placeholder="e.g. inter-sans" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        <p class="text-xs text-gray-500 mt-1">{{ __('Leave empty to auto-generate from name.') }}</p>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Font Files') }}</label>

                        <div class="space-y-3">
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <input type="file" name="files[0][file]" required class="w-full text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-rj-purple/10 file:text-rj-purple hover:file:bg-rj-purple/20 mb-2">
                                <div class="flex gap-2">
                                    <select name="files[0][weight]" class="flex-1 rounded-lg border-gray-300 text-xs">
                                        <option value="300">Light (300)</option>
                                        <option value="400" selected>Regular (400)</option>
                                        <option value="500">Medium (500)</option>
                                        <option value="600">SemiBold (600)</option>
                                        <option value="700">Bold (700)</option>
                                        <option value="900">Black (900)</option>
                                    </select>
                                    <select name="files[0][style]" class="flex-1 rounded-lg border-gray-300 text-xs">
                                        <option value="normal" selected>Normal</option>
                                        <option value="italic">Italic</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition">
                        {{ __('Upload Font') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- FONTS LIST --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-900">{{ __('Installed Fonts') }}</h2>
                    <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-700 text-xs font-bold">{{ $fonts->count() }}</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($fonts as $font)
                        <div class="p-6 flex items-start gap-4 hover:bg-gray-50 transition">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 font-serif text-xl">
                                Aa
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-gray-900">{{ $font->name }}</h3>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $font->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $font->status }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500 font-mono mt-0.5">{{ $font->family }}</div>

                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach($font->variants ?? [] as $variant)
                                        <span class="px-2 py-1 rounded bg-gray-100 border border-gray-200 text-xs text-gray-600">
                                            {{ $variant['weight'] ?? '400' }} {{ $variant['style'] ?? 'normal' }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <form method="POST" action="{{ route('admin.custom-fonts.destroy', $font) }}" onsubmit="return confirm('{{ __('Delete this font and all its files?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('Delete') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                            <p class="text-gray-500 text-sm">{{ __('No custom fonts uploaded yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
