@extends('admin.layouts.app')

@section('title', __('AI Diagnostics'))

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('AI Services Diagnostics') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Test connectivity to the Vault and individual AI providers.') }}</p>
        </div>
        <a href="{{ route('admin.test-ai') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            {{ __('Refresh Tests') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h2 class="text-base font-semibold text-gray-900">{{ __('Cloudflare Vault Status') }}</h2>
            @if($vaultStatus === 'Success')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> {{ __('Connected') }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold border border-red-200">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> {{ __('Failed') }}
                </span>
            @endif
        </div>
        @if($vaultStatus !== 'Success')
            <div class="p-6 text-sm text-red-600 bg-red-50 border-b border-red-100 font-mono">
                {{ $vaultStatus }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-base font-semibold text-gray-900">{{ __('Providers') }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">{{ __('Provider') }}</th>
                        <th class="px-6 py-3 font-semibold">{{ __('Status') }}</th>
                        <th class="px-6 py-3 font-semibold">{{ __('HTTP Code') }}</th>
                        <th class="px-6 py-3 font-semibold">{{ __('Time') }}</th>
                        <th class="px-6 py-3 font-semibold">{{ __('Response Snippet') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($results as $r)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-medium text-gray-900 capitalize">
                                {{ $r['name'] }}
                            </td>
                            <td class="px-6 py-4">
                                @if($r['status'] === 'Success')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                                        {{ __('Success') }}
                                    </span>
                                @elseif($r['status'] === 'Not Configured')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                                        {{ __('Missing Key') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-red-50 text-red-700 text-xs font-bold border border-red-200">
                                        {{ __('Failed') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600">
                                {{ $r['code'] }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600">
                                {{ $r['time'] }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-500 max-w-md truncate" title="{{ $r['response'] }}">
                                {{ $r['response'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
