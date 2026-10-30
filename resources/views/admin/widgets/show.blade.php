@extends('admin.layouts.app')

@section('title', $widget->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.widgets.index') }}" class="p-2 text-gray-400 hover:text-gray-900 bg-white rounded-lg border border-gray-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $widget->name }}</h1>
                <p class="text-sm text-gray-500 font-mono">{{ $widget->slug }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($widget->isActive())
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">{{ __('Active') }}</span>
                <form method="POST" action="{{ route('admin.widgets.deactivate', $widget) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                        {{ __('Deactivate') }}
                    </button>
                </form>
            @else
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm font-bold">{{ __('Inactive') }}</span>
                <form method="POST" action="{{ route('admin.widgets.activate', $widget) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition">
                        {{ __('Activate') }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">{{ __('Description') }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $widget->description ?: __('No description provided.') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">{{ __('Schema (Settings Fields)') }}</h3>

                @if(empty($schema))
                    <p class="text-sm text-gray-500">{{ __('This widget has no configurable settings.') }}</p>
                @else
                    <div class="space-y-3">
                        @foreach($schema as $field)
                            <div class="flex items-start justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $field['label'] ?? $field['name'] }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $field['name'] }}</div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-white border border-gray-200 text-xs font-medium text-gray-600">
                                        {{ $field['type'] ?? 'text' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Details') }}</h3>

                <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
                    <span class="text-gray-500">{{ __('Version') }}</span>
                    <span class="font-mono font-bold text-gray-900">{{ $metadata['version'] ?? '1.0.0' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
                    <span class="text-gray-500">{{ __('Author') }}</span>
                    <span class="font-medium text-gray-900">{{ $metadata['author'] ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
                    <span class="text-gray-500">{{ __('Category') }}</span>
                    <span class="font-medium text-gray-900">{{ $widget->category ?: 'General' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">{{ __('Uploaded By') }}</span>
                    <span class="font-medium text-gray-900">{{ $widget->uploader->name ?? 'System' }}</span>
                </div>
            </div>

            @if(!empty($requires))
                <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                    <h3 class="text-sm font-bold text-amber-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ __('Requirements') }}
                    </h3>
                    <ul class="list-disc pl-5 text-sm text-amber-800 space-y-1">
                        @foreach($requires as $req)
                            <li>{{ $req }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
