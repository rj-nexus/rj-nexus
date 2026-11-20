@extends('admin.settings.layout')

@section('settings')
<div class="space-y-6">

    {{-- ============ INSTALLED LANGUAGES ============ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-gray-900">{{ __('Languages') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Manage installed languages and translate them.') }}</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-gray-100 text-xs font-medium text-gray-600">
                {{ count($data['locales']) }} {{ __('installed') }}
            </span>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach ($data['locales'] as $loc)
                <div class="px-6 py-4 hover:bg-gray-50/60 transition" x-data="{ nameOpen: false, flagOpen: false }">
                    <div class="flex flex-wrap items-center justify-between gap-4">

                        {{-- Flag + name --}}
                        <div class="flex items-center gap-4 min-w-0">
                            @php $flag = rj_lang_flag_url($loc); @endphp
                            <div class="flex-shrink-0 w-11 h-11 rounded-full overflow-hidden bg-gray-100 ring-2 ring-white shadow-md border border-gray-200">
                                @if ($flag)
                                    <img src="{{ $flag }}" alt="{{ strtoupper($loc) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs font-semibold text-gray-400">
                                        {{ strtoupper($loc) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ rj_lang_name($loc) }}</span>
                                    <span class="text-[11px] font-medium text-gray-500 bg-gray-100 rounded px-1.5 py-0.5">{{ strtoupper($loc) }}</span>
                                    @if ($loc === config('app.locale'))
                                        <span class="text-[11px] font-medium text-rj-purple bg-rj-purple/10 rounded-full px-2 py-0.5">{{ __('Default language') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="button" @click="flagOpen = !flagOpen; nameOpen = false"
                                    :class="flagOpen ? 'bg-gray-100 border-gray-400' : 'border-gray-200'"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ __('Flag') }}
                            </button>

                            <button type="button" @click="nameOpen = !nameOpen; flagOpen = false"
                                    :class="nameOpen ? 'bg-gray-100 border-gray-400' : 'border-gray-200'"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                {{ __('Name') }}
                            </button>

                            <a href="{{ route('admin.settings.language.translations', $loc) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rj-purple/10 text-xs font-medium text-rj-purple hover:bg-rj-purple/20 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                {{ __('Translate') }}
                            </a>

                            @if ($loc !== config('app.locale'))
                                <form method="POST" action="{{ route('admin.settings.language.remove', $loc) }}"
                                      onsubmit="return confirm('{{ __('Remove this language? This cannot be undone.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="{{ __('Remove') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Flag upload panel --}}
                    <div x-show="flagOpen" x-cloak x-transition class="mt-4 sm:pl-[60px]">
                        <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                            <form method="POST" action="{{ route('admin.settings.language.meta', $loc) }}" enctype="multipart/form-data" class="flex items-center gap-3">
                                @csrf
                                <input type="file" name="flag" accept=".svg,.png,.jpg,.jpeg,.webp" required
                                       class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-rj-purple/10 file:text-rj-purple hover:file:bg-rj-purple/20 cursor-pointer">
                                <button type="submit" class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-gray-900 text-white text-xs font-medium hover:bg-gray-800 transition whitespace-nowrap">
                                    {{ __('Upload') }}
                                </button>
                            </form>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Recommended: SVG or PNG, max 512KB.') }}</p>
                        </div>
                    </div>

                    {{-- Name panel --}}
                    <div x-show="nameOpen" x-cloak x-transition class="mt-4 sm:pl-[60px]">
                        <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                            <form method="POST" action="{{ route('admin.settings.language.meta', $loc) }}" class="flex items-center gap-3">
                                @csrf
                                <input type="text" name="name" value="{{ rj_get_option('lang_name_' . $loc, '') }}"
                                       placeholder="{{ __('e.g. Azərbaycan dili') }}"
                                       class="flex-1 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                <button type="submit" class="inline-flex items-center px-3.5 py-2 rounded-lg bg-gray-900 text-white text-xs font-medium hover:bg-gray-800 transition whitespace-nowrap">
                                    {{ __('Save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Add language --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            <form method="POST" action="{{ route('admin.settings.language.add') }}" class="flex flex-wrap items-center gap-3">
                @csrf
                <input type="text" name="locale" required placeholder="{{ __('e.g. de, fr, es') }}"
                       pattern="[a-z]{2}(_[A-Z]{2})?"
                       class="w-40 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono lowercase">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium shadow-sm hover:opacity-90 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Add Language') }}
                </button>
                <p class="text-xs text-gray-500">{{ __('Use ISO 639-1 code (lowercase), e.g. de, fr, es, ja') }}</p>
            </form>
        </div>
    </div>

    {{-- ============ FRONTEND LANGUAGES ============ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">{{ __('Frontend Languages') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Select which languages appear in the frontend language switcher. Admin panel always shows all installed languages.') }}</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.language.frontend-locales') }}">
            @csrf
            @method('PUT')

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                @foreach ($data['locales'] as $loc)
                    @php
                        $isChecked = in_array($loc, $data['frontend_locales'] ?? [], true);
                        $flag = rj_lang_flag_url($loc);
                    @endphp
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="frontend_locales[]" value="{{ $loc }}" {{ $isChecked ? 'checked' : '' }} class="peer sr-only">

                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 bg-white transition
                                    hover:border-gray-300
                                    peer-checked:border-rj-purple peer-checked:bg-rj-purple/5 peer-checked:ring-1 peer-checked:ring-rj-purple
                                    peer-focus-visible:ring-2 peer-focus-visible:ring-rj-purple">
                            <div class="flex-shrink-0 w-9 h-9 rounded-full overflow-hidden bg-gray-100 ring-2 ring-white shadow border border-gray-200">
                                @if ($flag)
                                    <img src="{{ $flag }}" alt="{{ strtoupper($loc) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[10px] font-semibold text-gray-400">
                                        {{ strtoupper($loc) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ rj_lang_name($loc) }}</div>
                                <div class="text-[11px] text-gray-400">
                                    {{ strtoupper($loc) }}@if ($loc === config('app.locale')) · {{ __('Default') }}@endif
                                </div>
                            </div>

                            {{-- check mark --}}
                            <div class="flex-shrink-0 w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center text-transparent
                                        peer-checked:[&]:bg-rj-purple">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>

                        {{-- visible check indicator driven by peer --}}
                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-rj-purple text-white items-center justify-center hidden peer-checked:flex">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-wrap items-center justify-between gap-4">
                <p class="text-xs text-gray-500">{{ __('If none are selected, only the default language will be available in the frontend switcher.') }}</p>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium shadow-sm hover:opacity-90 transition whitespace-nowrap">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- ============ LANGUAGE + AI SETTINGS ============ --}}
    <form method="POST" action="{{ route('admin.settings.language.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">{{ __('Language Settings') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Configure admin and frontend languages.') }}</p>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Admin Language') }}</label>
                        <select name="admin_locale" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            @foreach ($data['locales'] as $loc)
                                <option value="{{ $loc }}" {{ ($options['admin_locale'] ?? config('app.locale')) === $loc ? 'selected' : '' }}>
                                    {{ rj_lang_name($loc) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Frontend Language') }}</label>
                        <select name="frontend_locale" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            @foreach ($data['locales'] as $loc)
                                <option value="{{ $loc }}" {{ ($options['frontend_locale'] ?? config('app.locale')) === $loc ? 'selected' : '' }}>
                                    {{ rj_lang_name($loc) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-2 divide-y divide-gray-100">
                    {{-- Auto-detect --}}
                    <label class="flex items-center justify-between gap-6 py-4 cursor-pointer">
                        <span>
                            <span class="block text-sm font-medium text-gray-800">{{ __('Auto-detect browser language') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('Automatically set locale based on visitor browser.') }}</span>
                        </span>
                        <span class="relative inline-flex flex-shrink-0">
                            <input type="checkbox" name="auto_detect_locale" value="1" {{ ($options['auto_detect_locale'] ?? '0') === '1' ? 'checked' : '' }} class="peer sr-only">
                            <span class="w-11 h-6 rounded-full bg-gray-200 transition peer-checked:bg-rj-purple peer-focus-visible:ring-2 peer-focus-visible:ring-rj-purple peer-focus-visible:ring-offset-2"></span>
                            <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                        </span>
                    </label>

                    {{-- RTL --}}
                    <label class="flex items-center justify-between gap-6 py-4 cursor-pointer">
                        <span>
                            <span class="block text-sm font-medium text-gray-800">{{ __('Enable RTL support') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('For right-to-left languages like Arabic, Hebrew.') }}</span>
                        </span>
                        <span class="relative inline-flex flex-shrink-0">
                            <input type="checkbox" name="rtl_support" value="1" {{ ($options['rtl_support'] ?? '0') === '1' ? 'checked' : '' }} class="peer sr-only">
                            <span class="w-11 h-6 rounded-full bg-gray-200 transition peer-checked:bg-rj-purple peer-focus-visible:ring-2 peer-focus-visible:ring-rj-purple peer-focus-visible:ring-offset-2"></span>
                            <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">{{ __('AI Translation') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Translate missing strings automatically using AI.') }}</p>
            </div>

            <div class="px-6 divide-y divide-gray-100">
                <label class="flex items-center justify-between gap-6 py-4 cursor-pointer">
                    <span>
                        <span class="block text-sm font-medium text-gray-800">{{ __('Enable AI translation') }}</span>
                        <span class="block text-xs text-gray-500 mt-0.5">{{ __('Use OpenRouter to translate missing translation keys.') }}</span>
                    </span>
                    <span class="relative inline-flex flex-shrink-0">
                        <input type="checkbox" name="ai_translation_enabled" value="1" {{ ($options['ai_translation_enabled'] ?? '0') === '1' ? 'checked' : '' }} class="peer sr-only">
                        <span class="w-11 h-6 rounded-full bg-gray-200 transition peer-checked:bg-rj-purple peer-focus-visible:ring-2 peer-focus-visible:ring-rj-purple peer-focus-visible:ring-offset-2"></span>
                        <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                    </span>
                </label>

                <label class="flex items-center justify-between gap-6 py-4 cursor-pointer">
                    <span>
                        <span class="block text-sm font-medium text-gray-800">{{ __('Auto-translate on save') }}</span>
                        <span class="block text-xs text-gray-500 mt-0.5">{{ __('Translate new keys immediately when they are added.') }}</span>
                    </span>
                    <span class="relative inline-flex flex-shrink-0">
                        <input type="checkbox" name="ai_translation_auto" value="1" {{ ($options['ai_translation_auto'] ?? '0') === '1' ? 'checked' : '' }} class="peer sr-only">
                        <span class="w-11 h-6 rounded-full bg-gray-200 transition peer-checked:bg-rj-purple peer-focus-visible:ring-2 peer-focus-visible:ring-rj-purple peer-focus-visible:ring-offset-2"></span>
                        <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                    </span>
                </label>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <p class="text-xs text-gray-500">
                    {{ __('AI provider is configured in') }}
                    <a href="{{ route('admin.settings.ai') }}" class="text-rj-purple font-medium hover:underline">{{ __('Settings → AI') }}</a>
                </p>
            </div>
        </div>

        {{-- Sticky save bar --}}
        <div class="sticky bottom-4 z-10">
            <div class="flex items-center justify-end gap-3 rounded-2xl bg-white/90 backdrop-blur border border-gray-100 shadow-lg px-5 py-3">
                <button type="submit" class="inline-flex items-center px-5 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium shadow-sm hover:opacity-90 transition">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </div>

    </form>

</div>
@endsection