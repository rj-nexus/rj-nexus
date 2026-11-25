@extends('admin.layouts.app')

@section('title', __('RJ About'))

@section('content')
@php
    $version = config('rj.version', '1.0.0');
@endphp

{{-- ALTair Series - Ümumi Məlumat Paneli --}}
<div class="relative bg-gray-900 rounded-3xl overflow-hidden shadow-2xl mb-8 border border-gray-800">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 via-purple-500/10 to-transparent pointer-events-none"></div>
    <div class="absolute -right-20 -top-20 w-64 h-64 bg-rj-purple/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative p-8 sm:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 z-10">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="px-3 py-1 rounded-full bg-white/10 text-white text-xs font-bold tracking-widest uppercase border border-white/20 backdrop-blur-sm">
                    {{ __('Version') }} {{ $version }}
                </span>
                <span class="px-3 py-1 rounded-full bg-rj-purple/20 text-rj-purple text-xs font-bold tracking-widest uppercase border border-rj-purple/30 backdrop-blur-sm">
                    Altair Series
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">RJ Nexus CMS</h1>
            <p class="text-gray-400 text-sm sm:text-base max-w-2xl leading-relaxed">
                {{ __('Modern, fast, and fully self-hosted content management system. Build stunning websites with RJBuilder, manage multilingual content, and scale your business globally.') }}
            </p>
        </div>
        <div class="flex-shrink-0 flex gap-3">
            <a href="https://rjnexus.org" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-gray-900 text-sm font-bold hover:bg-gray-100 transition shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                {{ __('Official Website') }}
            </a>
        </div>
    </div>
</div>

{{-- Sürətli Linklər --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <a href="https://rj-nexus.github.io/documents/" target="_blank" rel="noopener" class="group relative bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-rj-purple/40 transition-all overflow-hidden flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <div class="min-w-0">
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-rj-purple transition-colors truncate">{{ __('Documentation') }}</h3>
            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ __('Official RJ Nexus docs') }}</p>
        </div>
    </a>

    <a href="{{ url('/admin/services') }}" class="group relative bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-blue-400/40 transition-all overflow-hidden flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div class="min-w-0">
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ __('Services') }}</h3>
            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ __('Order custom development') }}</p>
        </div>
    </a>

    <a href="https://ruhidjavadoff.blogspot.com" target="_blank" rel="noopener" class="group relative bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-orange-400/40 transition-all overflow-hidden flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6M8 13h8M8 17h5"/></svg>
        </div>
        <div class="min-w-0">
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-orange-600 transition-colors truncate">{{ __('Personal Blog') }}</h3>
            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ __('Updates & tutorials') }}</p>
        </div>
    </a>

    <a href="https://ruhidjavadoff.blogspot.com/search/label/rj%20nexus" target="_blank" rel="noopener" class="group relative bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-emerald-400/40 transition-all overflow-hidden flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6M8 13h8M8 17h5"/></svg>
        </div>
        <div class="min-w-0">
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition-colors truncate">{{ __('RJ Nexus Blog') }}</h3>
            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ __('Development updates') }}</p>
        </div>
    </a>
</div>

{{-- Dəstək / Donate Bölməsi --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8 mb-8 relative overflow-hidden">
    <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-br from-pink-500/10 to-orange-500/10 rounded-full blur-3xl -z-10"></div>
    
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Support the Project') }}</h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                {{ __('If this project has been useful to you, consider supporting its continued development and maintenance.') }}
            </p>
            
            <div class="flex flex-wrap gap-4 items-center mb-6">
                <a href="https://kofe.al/@ruhidjavadoff" target="_blank" class="hover:-translate-y-1 transition-transform">
                    <img src="https://github.com/mr-ruhid/rare-logos-vault/blob/main/logo/monetization/kofe.al/kofe.al_logo.svg?raw=true" height="40" alt="Support on Kofe.al" style="background-color:#ffffff; padding:6px; border-radius:8px; border: 1px solid #e5e7eb;">
                </a>
                <a href="https://cayvoy.com/donate/ruhid4715" target="_blank" class="hover:-translate-y-1 transition-transform">
                    <img src="https://github.com/mr-ruhid/rare-logos-vault/blob/main/logo/monetization/cayvoy/cayvoy_logo.svg?raw=true" alt="Donate via Çayvoy" height="40">
                </a>
                <a href="https://www.paypal.com/paypalme/ruhidjavadoff" target="_blank" class="hover:-translate-y-1 transition-transform">
                    <img src="https://img.shields.io/badge/Donate-PayPal-00457C?style=for-the-badge&logo=paypal&logoColor=white" alt="Donate via PayPal" height="40" class="rounded-lg">
                </a>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-100/50">
                        <tr>
                            <th class="px-3 py-2 rounded-l-lg">{{ __('Method') }}</th>
                            <th class="px-3 py-2 rounded-r-lg">{{ __('Details') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">Kofe.al</td>
                            <td class="px-3 py-2"><a href="https://kofe.al/@ruhidjavadoff" target="_blank" class="text-indigo-600 hover:underline">@ruhidjavadoff</a></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">Çayvoy</td>
                            <td class="px-3 py-2"><a href="https://cayvoy.com/donate/ruhid4715" target="_blank" class="text-indigo-600 hover:underline">ruhid4715</a></td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900">PayPal</td>
                            <td class="px-3 py-2 text-gray-600">ruhidjavadoff@gmail.com</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">{{ __('Crypto (USDT, BEP20)') }}</td>
                            <td class="px-3 py-2 font-mono text-xs break-all text-gray-600">0x9a4AD41762D6B07B8C266b312Cf0dBe31FAd890</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 flex items-start gap-2 text-xs text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-100">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <strong>Crypto Warning:</strong> {{ __('Send only USDT on the BNB Smart Chain (BEP20) network. Funds sent on other networks may be lost.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection