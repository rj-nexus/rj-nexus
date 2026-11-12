@extends('admin.layouts.app')

@section('title', $plugin->name)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Başlıq və Düymələr -->
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.plugins.index') }}" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    {{ $plugin->name }}
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                        v{{ $plugin->version }}
                    </span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $plugin->description }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if($plugin->isActive())
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 text-green-700 text-sm font-medium border border-green-200">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    {{ __('Active') }}
                </span>
                <form method="POST" action="{{ route('admin.plugins.deactivate', $plugin) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        {{ __('Deactivate') }}
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 text-gray-600 text-sm font-medium border border-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    {{ __('Inactive') }}
                </span>
                <form method="POST" action="{{ route('admin.plugins.activate', $plugin) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition shadow-sm">
                        {{ __('Activate Plugin') }}
                    </button>
                </form>
            @endif

            @if($plugin->settings_schema ?? false)
                <a href="{{ route('admin.plugins.settings', $plugin) }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    {{ __('Settings') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Detallar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Sol tərəf (Metadata) -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-semibold text-gray-900">{{ __('Plugin Information') }}</h3>
                </div>
                <div class="p-6 space-y-4 text-sm">
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <span class="text-gray-500">{{ __('Author') }}</span>
                        <span class="col-span-2 text-gray-900">
                            @if($plugin->author_url)
                                <a href="{{ $plugin->author_url }}" target="_blank" class="text-rj-purple hover:underline">{{ $plugin->author ?? 'Unknown' }}</a>
                            @else
                                {{ $plugin->author ?? 'Unknown' }}
                            @endif
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <span class="text-gray-500">{{ __('Folder') }}</span>
                        <span class="col-span-2 text-gray-900 font-mono text-xs bg-gray-50 px-2 py-1 rounded">{{ $plugin->folder }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <span class="text-gray-500">{{ __('Main File') }}</span>
                        <span class="col-span-2 text-gray-900 font-mono text-xs">{{ $plugin->main_file }}</span>
                    </div>
                    @if(isset($metadata['namespace']))
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <span class="text-gray-500">{{ __('Namespace') }}</span>
                        <span class="col-span-2 text-gray-900 font-mono text-xs">{{ $metadata['namespace'] }}</span>
                    </div>
                    @endif
                    @if(isset($metadata['provider']))
                    <div class="grid grid-cols-3 gap-4">
                        <span class="text-gray-500">{{ __('Service Provider') }}</span>
                        <span class="col-span-2 text-gray-900 font-mono text-xs truncate" title="{{ $metadata['provider'] }}">{{ $metadata['provider'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sağ tərəf (Tələblər və Təhlükəsizlik) -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-semibold text-gray-900">{{ __('Requirements') }}</h3>
                </div>
                <div class="p-6 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">RJ Nexus</span>
                        <span class="text-gray-900 font-medium">{{ $requires['rj_cms'] ?? 'Any' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">PHP</span>
                        <span class="text-gray-900 font-medium">{{ $requires['php'] ?? 'Any' }}</span>
                    </div>
                </div>
            </div>

            <!-- Təhlükəli Zona -->
            @if(!$plugin->isActive())
            <div class="bg-red-50 rounded-xl border border-red-100 p-6">
                <h3 class="text-sm font-semibold text-red-900 mb-2">{{ __('Danger Zone') }}</h3>
                <p class="text-xs text-red-700 mb-4">{{ __('Once you delete a plugin, there is no going back. Please be certain.') }}</p>
                <form method="POST" action="{{ route('admin.plugins.destroy', $plugin) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this plugin? All files will be removed.') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                        {{ __('Delete Plugin') }}
                    </button>
                </form>
            </div>
            @endif
        </div>

    </div>

</div>
@endsection