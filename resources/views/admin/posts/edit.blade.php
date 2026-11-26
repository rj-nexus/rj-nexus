@extends('admin.layouts.app')

@section('title', $post->type === 'page' ? __('Edit Page') : __('Edit Post'))

@section('content')
@php
    // Bayraq faylını tapır (svg, webp, png... və zh_TW -> zh-tw kimi variantlar)
    $rjFlagUrl = function (string $code) {
        static $cache = [];
        if (array_key_exists($code, $cache)) {
            return $cache[$code];
        }

        $names = array_values(array_unique(array_filter([
            $code,
            strtolower($code),
            str_replace('_', '-', strtolower($code)),
            strtolower(preg_split('/[-_]/', $code)[0] ?? ''),
        ])));

        foreach ($names as $n) {
            foreach (['svg', 'webp', 'png', 'jpg', 'jpeg', 'gif', 'avif'] as $e) {
                if (file_exists(public_path("images/flags/{$n}.{$e}"))) {
                    return $cache[$code] = asset("images/flags/{$n}.{$e}");
                }
            }
        }

        return $cache[$code] = null;
    };

    // Hansı dillərdə xəta var (tabda qırmızı nöqtə üçün)
    $rjErrLocales = [];
    foreach ($locales as $l) {
        $keys = $l === $baseLocale
            ? ['title', 'slug', 'excerpt', 'seo_title', 'seo_description', 'focus_keyword']
            : ["translations.{$l}.title", "translations.{$l}.slug"];
        foreach ($keys as $k) {
            if ($errors->has($k)) {
                $rjErrLocales[] = $l;
                break;
            }
        }
    }
@endphp

<style>
    .rj-cflag { display: inline-block; flex-shrink: 0; width: 20px; height: 20px; border-radius: 50%; object-fit: cover; background: #e2e8f0; box-shadow: 0 0 0 1px rgba(15, 23, 42, .08), 0 2px 5px -1px rgba(15, 23, 42, .18); transition: box-shadow .2s, transform .2s; }
    .rj-cflag-ph { display: inline-flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700; text-transform: uppercase; color: #64748b; }
    .rj-ltab.is-on .rj-cflag { box-shadow: 0 0 0 2px #8b5cf6, 0 0 0 4px rgba(139, 92, 246, .2); transform: scale(1.08); }
</style>

<div class="space-y-6" x-data="postEditor()" x-init="init()">

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" class="space-y-6" @submit="publishing = true">
        @csrf
        @method('PUT')

        <input type="hidden" name="edit_mode" :value="editMode">
        <input type="hidden" name="theme_template" :value="editMode === 'theme' ? themeTemplate : ''">

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('admin.posts.index', ['type' => $post->type]) }}" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div class="min-w-0">
                    <h2 class="text-base font-semibold text-gray-900">{{ $post->type === 'page' ? __('Edit Page') : __('Edit Post') }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5 truncate max-w-md">{{ $post->title ?: __('(no title)') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if ($post->status === 'published')
                    <a href="{{ $post->public_url }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-rj-purple transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        {{ __('View') }}
                    </a>
                @endif

                <a href="{{ route('admin.posts.index', ['type' => $post->type]) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Cancel') }}
                </a>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    {{ __('Save') }}
                </button>

                <template x-if="editMode === 'builder'">
                    <a href="{{ route('admin.posts.build', $post) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                        {{ __('Open Builder') }}
                    </a>
                </template>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r-lg">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($post->isBuilderMode() && $post->hasBlocks())
            <div class="bg-gradient-to-r from-rj-purple/10 to-rj-pink/10 rounded-lg border border-rj-purple/30 p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-rj-purple to-rj-pink flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-900">{{ __('Designed in RJBuilder') }}</div>
                    <div class="text-xs text-gray-600 mt-0.5">{{ __(':n block(s). Click "Open Builder" to continue editing.', ['n' => count($post->blocks['blocks'] ?? [])]) }}</div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-lg shadow-sm border border-gray-100">

                    <div class="border-b border-gray-100 px-6">
                        <nav class="flex gap-1 -mb-px overflow-x-auto rj-scrollbar">
                            <button type="button" @click="activeTab = 'content'"
                                    :class="activeTab === 'content' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-4 py-3 border-b-2 text-sm font-medium transition whitespace-nowrap">
                                {{ __('Content') }}
                            </button>
                            <button type="button" @click="activeTab = 'seo'"
                                    :class="activeTab === 'seo' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-4 py-3 border-b-2 text-sm font-medium transition whitespace-nowrap inline-flex items-center gap-2">
                                {{ __('SEO') }}
                                <span x-show="seoScore !== null" x-cloak
                                      class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold text-white"
                                      :style="'background:' + seoColor"
                                      x-text="seoScore"></span>
                            </button>
                            <button type="button" @click="activeTab = 'social'"
                                    :class="activeTab === 'social' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-4 py-3 border-b-2 text-sm font-medium transition whitespace-nowrap">
                                {{ __('Social') }}
                            </button>
                            <button type="button" @click="activeTab = 'advanced'"
                                    :class="activeTab === 'advanced' ? 'border-rj-purple text-rj-purple' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-4 py-3 border-b-2 text-sm font-medium transition whitespace-nowrap">
                                {{ __('Advanced') }}
                            </button>
                        </nav>
                    </div>

                    {{-- Dil tabları --}}
                    <template x-if="activeTab !== 'advanced'">
                        <div class="border-b border-gray-100 relative flex items-center bg-white overflow-hidden group"
                             x-data="{
                                 isDown: false,
                                 moved: false,
                                 startX: 0,
                                 scrollLeft: 0,
                                 startDrag(e) {
                                     this.isDown = true;
                                     this.moved = false;
                                     this.startX = e.pageX;
                                     this.scrollLeft = this.$refs.langTabs.scrollLeft;
                                 },
                                 stopDrag() {
                                     this.isDown = false;
                                     this.$refs.langTabs.classList.remove('cursor-grabbing', 'select-none');
                                 },
                                 doDrag(e) {
                                     if (!this.isDown) return;
                                     const dx = e.pageX - this.startX;
                                     if (Math.abs(dx) > 5) {
                                         this.moved = true;
                                         this.$refs.langTabs.classList.add('cursor-grabbing', 'select-none');
                                     }
                                     if (this.moved) {
                                         e.preventDefault();
                                         this.$refs.langTabs.scrollLeft = this.scrollLeft - dx;
                                     }
                                 },
                                 pick(l) {
                                     if (this.moved) { this.moved = false; return; }
                                     activeLocale = l;
                                 },
                                 reveal() {
                                     this.$nextTick(() => {
                                         const nav = this.$refs.langTabs;
                                         const el = nav ? nav.querySelector('.rj-ltab.is-on') : null;
                                         if (!nav || !el) return;
                                         nav.scrollTo({ left: Math.max(0, el.offsetLeft - nav.clientWidth / 2 + el.offsetWidth / 2), behavior: 'smooth' });
                                     });
                                 }
                             }"
                             x-init="$watch('activeLocale', () => reveal()); reveal()"
                             @mouseup.window="stopDrag()">

                            <button type="button" @click="$refs.langTabs.scrollBy({ left: -200, behavior: 'smooth' })"
                                    class="absolute left-1 z-10 w-6 h-6 flex items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-rj-purple transition sm:opacity-0 sm:group-hover:opacity-100 focus:outline-none"
                                    aria-label="{{ __('Previous') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <nav class="flex gap-1 overflow-x-auto rj-scrollbar w-full px-8 pb-px"
                                 x-ref="langTabs"
                                 @mousedown="startDrag($event)"
                                 @mouseleave="stopDrag()"
                                 @mousemove="doDrag($event)"
                                 style="scrollbar-width: none; -ms-overflow-style: none; cursor: grab;"
                                 role="tablist">
                                @foreach ($locales as $locale)
                                    @php
                                        $translation = $post->translations->firstWhere('locale', $locale);
                                        $hasTranslation = $locale === $baseLocale || ($translation && $translation->title);
                                        $flag = $rjFlagUrl($locale);
                                    @endphp
                                    <button type="button"
                                            role="tab"
                                            @click="pick(@js($locale))"
                                            :class="activeLocale === @js($locale) ? 'is-on border-rj-purple text-rj-purple bg-rj-purple/5' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50'"
                                            :aria-selected="activeLocale === @js($locale)"
                                            class="rj-ltab px-3 py-2.5 border-b-2 text-xs font-medium transition flex items-center gap-2 whitespace-nowrap rounded-t-lg">
                                        @if ($flag)
                                            <img src="{{ $flag }}" alt="{{ strtoupper($locale) }}" class="rj-cflag" loading="lazy" draggable="false">
                                        @else
                                            <span class="rj-cflag rj-cflag-ph">{{ substr($locale, 0, 2) }}</span>
                                        @endif
                                        {{ rj_lang_name($locale) }}
                                        <span class="uppercase opacity-60">{{ $locale }}</span>
                                        @if ($locale === $baseLocale)
                                            <span class="w-1.5 h-1.5 rounded-full bg-rj-pink" title="{{ __('Default language') }}"></span>
                                        @elseif ($hasTranslation)
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500" title="{{ __('Translated') }}"></span>
                                        @endif
                                        @if (in_array($locale, $rjErrLocales, true))
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500" title="{{ __('This language has errors.') }}"></span>
                                        @endif
                                    </button>
                                @endforeach
                            </nav>

                            <button type="button" @click="$refs.langTabs.scrollBy({ left: 200, behavior: 'smooth' })"
                                    class="absolute right-1 z-10 w-6 h-6 flex items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 text-gray-500 hover:text-rj-purple transition sm:opacity-0 sm:group-hover:opacity-100 focus:outline-none"
                                    aria-label="{{ __('Next') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </button>

                        </div>
                    </template>

                    <div x-show="activeTab === 'content'" class="p-6 space-y-5">
                        @foreach ($locales as $locale)
                            @php
                                $t = $post->translations->firstWhere('locale', $locale);
                                $isBase = $locale === $baseLocale;
                                $titleValue = $isBase ? $post->getRawOriginal('title') : ($t?->title);
                                $excerptValue = $isBase ? $post->getRawOriginal('excerpt') : ($t?->excerpt);
                                $contentValue = $isBase ? $post->getRawOriginal('content') : ($t?->content);
                                $slugValue = $isBase ? $post->getRawOriginal('slug') : ($t?->slug);
                            @endphp

                            <div x-show="activeLocale === @js($locale)" x-cloak class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('Title') }}
                                    </label>
                                    <input type="text"
                                           name="{{ $isBase ? 'title' : "translations[{$locale}][title]" }}"
                                           value="{{ old($isBase ? 'title' : "translations.{$locale}.title", $titleValue) }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-base font-medium">
                                    @error($isBase ? 'title' : "translations.{$locale}.title")
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Slug') }}</label>
                                    <input type="text"
                                           name="{{ $isBase ? 'slug' : "translations[{$locale}][slug]" }}"
                                           value="{{ old($isBase ? 'slug' : "translations.{$locale}.slug", $slugValue) }}"
                                           placeholder="{{ __('auto-generated from title') }}"
                                           onblur="this.value = this.value.trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\p{L}\p{N}\-_]+/gu, '').replace(/-+/g, '-').replace(/^-|-$/g, '')"
                                           class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono lowercase">
                                    @error($isBase ? 'slug' : "translations.{$locale}.slug")
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Excerpt') }}</label>
                                    <textarea name="{{ $isBase ? 'excerpt' : "translations[{$locale}][excerpt]" }}"
                                              rows="3"
                                              placeholder="{{ __('Short summary. Auto-used for SEO description if empty.') }}"
                                              class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old($isBase ? 'excerpt' : "translations.{$locale}.excerpt", $excerptValue) }}</textarea>
                                </div>

                                @if ($isBase)
                                    <template x-if="editMode === 'classic'">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Content') }}</label>
                                            <textarea name="content"
                                                      rows="14"
                                                      class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono">{{ old('content', $contentValue) }}</textarea>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('Supports HTML and RJ shortcodes.') }}</p>
                                        </div>
                                    </template>

                                    <template x-if="editMode === 'builder'">
                                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-xs text-blue-800 leading-relaxed">
                                            <strong>{{ __('RJBuilder mode active') }}</strong> — {{ __('Content is managed visually. Click "Open Builder" at the top to edit.') }}
                                        </div>
                                    </template>

                                    <template x-if="editMode === 'theme'">
                                        <div class="bg-purple-50 border border-purple-100 rounded-lg p-4 text-xs text-purple-800 leading-relaxed">
                                            <strong>{{ __('Theme Template mode active') }}</strong> — {{ __('Content structure comes from the theme. Fill in Title and Excerpt to customize the page.') }}
                                        </div>
                                    </template>
                                @endif

                            </div>
                        @endforeach
                    </div>

                    <div x-show="activeTab === 'seo'" x-cloak class="p-6 space-y-6">

                        <div class="flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ __('Search Engine Optimization') }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">{{ __('Control how this page appears in search results.') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="generateSeo()" :disabled="seoLoading"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold border border-purple-200 hover:bg-purple-100 transition disabled:opacity-50">
                                    <svg x-show="!seoLoading" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    <svg x-show="seoLoading" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    {{ __('Auto SEO') }}
                                </button>

                                <button type="button" @click="analyzeSeo()" :disabled="analyzing"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-xs font-medium hover:opacity-90 transition disabled:opacity-60">
                                    <svg x-show="!analyzing" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    <svg x-show="analyzing" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                                    <span x-text="analyzing ? @js(__('Analyzing...')) : @js(__('Analyze'))"></span>
                                </button>
                            </div>
                        </div>

                        <div x-show="seoAnalysis" x-cloak class="rounded-lg border p-4 text-xs leading-relaxed"
                             :class="seoAnalysis?.level === 'good' ? 'bg-green-50 border-green-200 text-green-900' : (seoAnalysis?.level === 'warn' ? 'bg-amber-50 border-amber-200 text-amber-900' : 'bg-red-50 border-red-200 text-red-900')">
                            <div class="flex items-center gap-2 font-semibold mb-1">
                                <span x-text="@js(__('SEO Score')) + ': ' + (seoAnalysis?.score ?? 0) + '/100'"></span>
                            </div>
                            <ul class="space-y-1 ml-4 list-disc">
                                <template x-for="(item, i) in (seoAnalysis?.issues || [])" :key="i">
                                    <li x-text="item"></li>
                                </template>
                            </ul>
                        </div>

                        @foreach ($locales as $locale)
                            @php
                                $t = $post->translations->firstWhere('locale', $locale);
                                $isBase = $locale === $baseLocale;
                                $fName = fn($f) => $isBase ? $f : "translations[{$locale}][{$f}]";
                                $fOld  = fn($f) => $isBase ? $f : "translations.{$locale}.{$f}";
                            @endphp

                            <div x-show="activeLocale === @js($locale)" x-cloak class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Focus Keyword') }}</label>
                                    <input type="text"
                                           name="{{ $fName('focus_keyword') }}"
                                           value="{{ old($fOld('focus_keyword'), $t?->focus_keyword) }}"
                                           placeholder="{{ __('e.g. laravel tutorial') }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                </div>

                                <div x-data="{ len: {{ mb_strlen((string) old($fOld('seo_title'), $t?->seo_title ?? '')) }} }">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('SEO Title') }}</label>
                                    <input type="text"
                                           name="{{ $fName('seo_title') }}"
                                           value="{{ old($fOld('seo_title'), $t?->seo_title) }}"
                                           maxlength="255"
                                           @input="len = $event.target.value.length"
                                           placeholder="{{ $post->title }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <div class="flex items-center justify-between mt-1 text-xs">
                                        <span class="text-gray-500">{{ __('Recommended: 50-60 chars') }}</span>
                                        <span :class="len >= 40 && len <= 65 ? 'text-green-600 font-medium' : (len > 65 ? 'text-amber-600' : 'text-gray-400')">
                                            <span x-text="len"></span> / 60
                                        </span>
                                    </div>
                                </div>

                                <div x-data="{ len: {{ mb_strlen((string) old($fOld('seo_description'), $t?->seo_description ?? '')) }} }">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('SEO Description') }}</label>
                                    <textarea name="{{ $fName('seo_description') }}"
                                              rows="3"
                                              maxlength="500"
                                              @input="len = $event.target.value.length"
                                              placeholder="{{ $post->excerpt }}"
                                              class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old($fOld('seo_description'), $t?->seo_description) }}</textarea>
                                    <div class="flex items-center justify-between mt-1 text-xs">
                                        <span class="text-gray-500">{{ __('Recommended: 150-160 chars') }}</span>
                                        <span :class="len >= 140 && len <= 165 ? 'text-green-600 font-medium' : (len > 165 ? 'text-amber-600' : 'text-gray-400')">
                                            <span x-text="len"></span> / 160
                                        </span>
                                    </div>
                                </div>

                                <div x-data="{ image: @js(old($fOld('seo_image'), $t?->seo_image ?? '')) }"
                                     @media-selected.window="if ($event.detail.target === $refs.imgInput) image = $event.detail.url">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('SEO Image') }}</label>
                                    <p class="text-xs text-gray-500 mb-2">{{ __('Used for Open Graph and Twitter previews.') }}</p>

                                    <div x-show="image" class="rounded-lg overflow-hidden border border-gray-200 relative mb-2">
                                        <img :src="image" alt="" class="w-full h-32 object-cover">
                                        <button type="button" @click="image = ''; $refs.imgInput.value = ''"
                                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>

                                    <input type="hidden" name="{{ $fName('seo_image') }}" x-ref="imgInput" :value="image">

                                    <button type="button"
                                            @click="$dispatch('open-media-picker', { value: $refs.imgInput, type: 'image' })"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border-2 border-dashed border-gray-300 text-gray-700 text-xs font-medium hover:border-rj-purple hover:bg-rj-purple/5 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span x-text="image ? @js(__('Change Image')) : @js(__('Select Image'))"></span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Robots') }}</label>
                                        <select name="{{ $fName('robots') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                            @php $robots = old($fOld('robots'), $t?->robots ?? 'index,follow'); @endphp
                                            <option value="index,follow" {{ $robots === 'index,follow' ? 'selected' : '' }}>{{ __('Index, Follow') }}</option>
                                            <option value="noindex,follow" {{ $robots === 'noindex,follow' ? 'selected' : '' }}>{{ __('No Index, Follow') }}</option>
                                            <option value="index,nofollow" {{ $robots === 'index,nofollow' ? 'selected' : '' }}>{{ __('Index, No Follow') }}</option>
                                            <option value="noindex,nofollow" {{ $robots === 'noindex,nofollow' ? 'selected' : '' }}>{{ __('No Index, No Follow') }}</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Schema Type') }}</label>
                                        <select name="{{ $fName('schema_type') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                            @php $schema = old($fOld('schema_type'), $t?->schema_type ?? 'Article'); @endphp
                                            @foreach (['Article', 'BlogPosting', 'WebPage', 'AboutPage', 'ContactPage', 'FAQPage', 'Product', 'NewsArticle'] as $st)
                                                <option value="{{ $st }}" {{ $schema === $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Canonical URL') }}</label>
                                    <input type="text"
                                           name="{{ $fName('canonical_url') }}"
                                           value="{{ old($fOld('canonical_url'), $t?->canonical_url) }}"
                                           placeholder="{{ __('Leave empty to use the default URL') }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div x-show="activeTab === 'social'" x-cloak class="p-6 space-y-6">

                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ __('Social Media Preview') }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('How this content looks when shared. Empty fields fall back to SEO values.') }}</p>
                        </div>

                        @foreach ($locales as $locale)
                            @php
                                $t = $post->translations->firstWhere('locale', $locale);
                                $isBase = $locale === $baseLocale;
                                $fName = fn($f) => $isBase ? $f : "translations[{$locale}][{$f}]";
                                $fOld  = fn($f) => $isBase ? $f : "translations.{$locale}.{$f}";
                            @endphp

                            <div x-show="activeLocale === @js($locale)" x-cloak class="space-y-5">

                                <div class="border-t border-gray-100 pt-5">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">{{ __('Open Graph (Facebook, LinkedIn)') }}</h4>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('OG Title') }}</label>
                                            <input type="text" name="{{ $fName('og_title') }}"
                                                   value="{{ old($fOld('og_title'), $t?->og_title) }}"
                                                   placeholder="{{ $t?->seo_title ?? $post->title }}"
                                                   class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('OG Description') }}</label>
                                            <textarea name="{{ $fName('og_description') }}" rows="2"
                                                      placeholder="{{ $t?->seo_description }}"
                                                      class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old($fOld('og_description'), $t?->og_description) }}</textarea>
                                        </div>

                                        <div x-data="{ image: @js(old($fOld('og_image'), $t?->og_image ?? '')) }"
                                             @media-selected.window="if ($event.detail.target === $refs.ogInput) image = $event.detail.url">
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('OG Image') }}</label>
                                            <div x-show="image" class="rounded-lg overflow-hidden border border-gray-200 relative mb-2">
                                                <img :src="image" alt="" class="w-full h-32 object-cover">
                                                <button type="button" @click="image = ''; $refs.ogInput.value = ''"
                                                        class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>
                                            <input type="hidden" name="{{ $fName('og_image') }}" x-ref="ogInput" :value="image">
                                            <button type="button" @click="$dispatch('open-media-picker', { value: $refs.ogInput, type: 'image' })"
                                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border-2 border-dashed border-gray-300 text-gray-700 text-xs font-medium hover:border-rj-purple hover:bg-rj-purple/5 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span x-text="image ? @js(__('Change Image')) : @js(__('Select Image'))"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 pt-5">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">{{ __('Twitter / X Card') }}</h4>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Card Type') }}</label>
                                            <select name="{{ $fName('twitter_card') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                                @php $card = old($fOld('twitter_card'), $t?->twitter_card ?? 'summary_large_image'); @endphp
                                                <option value="summary" {{ $card === 'summary' ? 'selected' : '' }}>Summary</option>
                                                <option value="summary_large_image" {{ $card === 'summary_large_image' ? 'selected' : '' }}>Summary with Large Image</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Twitter Title') }}</label>
                                            <input type="text" name="{{ $fName('twitter_title') }}"
                                                   value="{{ old($fOld('twitter_title'), $t?->twitter_title) }}"
                                                   placeholder="{{ $t?->og_title ?? $t?->seo_title ?? $post->title }}"
                                                   class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Twitter Description') }}</label>
                                            <textarea name="{{ $fName('twitter_description') }}" rows="2"
                                                      placeholder="{{ $t?->og_description ?? $t?->seo_description }}"
                                                      class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old($fOld('twitter_description'), $t?->twitter_description) }}</textarea>
                                        </div>

                                        <div x-data="{ image: @js(old($fOld('twitter_image'), $t?->twitter_image ?? '')) }"
                                             @media-selected.window="if ($event.detail.target === $refs.twInput) image = $event.detail.url">
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Twitter Image') }}</label>
                                            <div x-show="image" class="rounded-lg overflow-hidden border border-gray-200 relative mb-2">
                                                <img :src="image" alt="" class="w-full h-32 object-cover">
                                                <button type="button" @click="image = ''; $refs.twInput.value = ''"
                                                        class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>
                                            <input type="hidden" name="{{ $fName('twitter_image') }}" x-ref="twInput" :value="image">
                                            <button type="button" @click="$dispatch('open-media-picker', { value: $refs.twInput, type: 'image' })"
                                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border-2 border-dashed border-gray-300 text-gray-700 text-xs font-medium hover:border-rj-purple hover:bg-rj-purple/5 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span x-text="image ? @js(__('Change Image')) : @js(__('Select Image'))"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div x-show="activeTab === 'advanced'" x-cloak class="p-6 space-y-6">

                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ __('Advanced Settings') }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Additional options for this :type.', ['type' => $post->type === 'page' ? __('page') : __('post')]) }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Author') }}</label>
                                <input type="text" disabled
                                       value="{{ $post->author->name ?? '—' }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-600 text-sm">
                                <p class="text-xs text-gray-500 mt-1">{{ __('Author changes coming in a future update.') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Post ID') }}</label>
                                <input type="text" disabled value="{{ $post->id }}"
                                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-600 text-sm font-mono">
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">{{ __('Custom CSS / JS') }}</h4>
                            <p class="text-xs text-gray-500 mb-3">{{ __('Per-post overrides. Leave empty to skip.') }}</p>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Custom CSS') }}</label>
                                    <textarea name="settings[custom_css]" rows="4"
                                              placeholder=".my-class { color: red; }"
                                              class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono">{{ old('settings.custom_css', $post->settings['custom_css'] ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Custom JS') }}</label>
                                    <textarea name="settings[custom_js]" rows="4"
                                              placeholder="console.log('hello');"
                                              class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono">{{ old('settings.custom_js', $post->settings['custom_js'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">{{ __('Danger Zone') }}</h4>

                            @if($post->status === 'trash')
                                <div class="flex items-center gap-2">
                                    <button type="submit" form="restoreForm" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-green-300 text-green-700 text-xs font-medium hover:bg-green-50 transition">
                                        {{ __('Restore from Trash') }}
                                    </button>
                                    <button type="submit" form="deleteForm"
                                            onclick="return confirm(@js(__('Permanently delete? This cannot be undone.')))"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-red-300 text-red-700 text-xs font-medium hover:bg-red-50 transition">
                                        {{ __('Delete Permanently') }}
                                    </button>
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.posts.trash-action', $post) }}"
                                      onsubmit="return confirm(@js(__('Move to trash?')))">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-sm text-red-600 hover:text-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                        {{ __('Move to Trash') }}
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Edit Mode') }}</h3>
                    </div>

                    <div class="p-6 space-y-3">

                        <label class="flex items-start gap-3 p-3 rounded-lg border-2 cursor-pointer transition"
                               :class="editMode === 'builder' ? 'border-rj-purple bg-rj-purple/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" value="builder" x-model="editMode" class="mt-0.5 text-rj-purple focus:ring-rj-purple">
                            <span class="flex-1">
                                <span class="block text-sm font-semibold text-gray-900">RJBuilder</span>
                                <span class="block text-xs text-gray-500 mt-0.5">{{ __('Drag-and-drop blocks.') }}</span>
                            </span>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-lg border-2 cursor-pointer transition"
                               :class="editMode === 'classic' ? 'border-rj-purple bg-rj-purple/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" value="classic" x-model="editMode" class="mt-0.5 text-rj-purple focus:ring-rj-purple">
                            <span class="flex-1">
                                <span class="block text-sm font-semibold text-gray-900">{{ __('Classic Editor') }}</span>
                                <span class="block text-xs text-gray-500 mt-0.5">{{ __('HTML content in textarea.') }}</span>
                            </span>
                        </label>

                        @if(!empty($themeTemplates))
                            <label class="flex items-start gap-3 p-3 rounded-lg border-2 cursor-pointer transition"
                                   :class="editMode === 'theme' ? 'border-rj-purple bg-rj-purple/5' : 'border-gray-200 hover:border-gray-300'">
                                <input type="radio" value="theme" x-model="editMode" class="mt-0.5 text-rj-purple focus:ring-rj-purple">
                                <span class="flex-1">
                                    <span class="block text-sm font-semibold text-gray-900">{{ __('Theme Template') }}</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">{{ __('Pre-built layout from your theme.') }}</span>
                                </span>
                            </label>

                            <div x-show="editMode === 'theme'" x-cloak class="pt-3 border-t border-gray-100">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Template') }}</label>
                                <select x-model="themeTemplate"
                                        class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                    <option value="">{{ __('— Select template —') }}</option>
                                    @foreach($themeTemplates as $tpl)
                                        <option value="{{ $tpl['id'] }}">{{ $tpl['label'] }}</option>
                                    @endforeach
                                </select>
                                @foreach($themeTemplates as $tpl)
                                    <p x-show="themeTemplate === @js($tpl['id'])" x-cloak class="text-xs text-gray-500 mt-2 leading-relaxed">
                                        {{ $tpl['description'] ?? '' }}
                                    </p>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Publish Settings') }}</h3>

                        @if ($post->status === 'trash')
                            <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-700 text-xs font-medium">{{ __('In Trash') }}</span>
                        @endif
                    </div>

                    <div class="p-6 space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Status') }}</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                                @if ($post->status === 'trash')
                                    <option value="trash" selected>{{ __('Trash') }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Publish Date') }}</label>
                            <input type="datetime-local"
                                   name="published_at"
                                   value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-3">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="is_sticky" value="1" {{ old('is_sticky', $post->is_sticky) ? 'checked' : '' }}
                                       class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                <span>
                                    <span class="block text-sm font-medium text-gray-700">{{ __('Sticky') }}</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">{{ __('Pin to top of archive.') }}</span>
                                </span>
                            </label>

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', $post->allow_comments) ? 'checked' : '' }}
                                       class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                <span>
                                    <span class="block text-sm font-medium text-gray-700">{{ __('Allow Comments') }}</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">{{ __('Enable comment form.') }}</span>
                                </span>
                            </label>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <div class="text-xs text-gray-500 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Created') }}</span>
                                    <span class="text-gray-700">{{ $post->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Updated') }}</span>
                                    <span class="text-gray-700">{{ $post->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('Views') }}</span>
                                    <span class="text-gray-700">{{ number_format($post->view_count) }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Featured Image') }}</h3>
                    </div>
                    <div class="p-6" x-data="{ imageUrl: @js(old('featured_image', $post->featured_image ?? '')) }"
                         @media-selected.window="if ($event.detail.target === $refs.imageInput) imageUrl = $event.detail.url">
                        <div x-show="imageUrl" class="rounded-lg overflow-hidden border border-gray-200 relative mb-3">
                            <img :src="imageUrl" alt="" class="w-full h-40 object-cover">
                            <button type="button" @click="imageUrl = ''; $refs.imageInput.value = ''"
                                    class="absolute top-2 right-2 w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <input type="hidden" name="featured_image" x-ref="imageInput" :value="imageUrl">
                        <button type="button"
                                @click="$dispatch('open-media-picker', { value: $refs.imageInput, type: 'image' })"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 border-dashed border-gray-300 text-gray-700 text-sm font-medium hover:border-rj-purple hover:bg-rj-purple/5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span x-text="imageUrl ? @js(__('Change Image')) : @js(__('Select Image'))"></span>
                        </button>
                    </div>
                </div>

                @if($post->type !== 'page')
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-semibold text-gray-900">{{ __('Categories') }}</h3>
                        </div>
                        <div class="p-6">
                            @php $selectedCats = old('categories', $post->categories->pluck('id')->toArray()); @endphp
                            @if ($categories->isEmpty())
                                <p class="text-sm text-gray-500">{{ __('No categories yet.') }}</p>
                            @else
                                <div class="max-h-64 overflow-y-auto rj-scrollbar space-y-1.5 pr-1">
                                    @foreach ($categories as $cat)
                                        <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                                   {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                            <span class="text-sm text-gray-700">{{ $cat->indented_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-semibold text-gray-900">{{ __('Tags') }}</h3>
                        </div>
                        <div class="p-6">
                            @php $selectedTags = old('tags', $post->tags->pluck('id')->toArray()); @endphp
                            @if ($tags->isEmpty())
                                <p class="text-sm text-gray-500">{{ __('No tags yet.') }}</p>
                            @else
                                <div class="max-h-48 overflow-y-auto rj-scrollbar space-y-1.5 pr-1">
                                    @foreach ($tags as $tag)
                                        <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                   {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </form>

    @if ($post->status === 'trash')
        <form id="restoreForm" method="POST" action="{{ route('admin.posts.restore', $post) }}" class="hidden">
            @csrf
        </form>
        <form id="deleteForm" method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif

</div>

<script>
function postEditor() {
    const baseLocale = @js($baseLocale);
    const errLocales = @js($rjErrLocales);
    const tabKey = 'rj_post_editor_tab_' + @js($post->id);

    return {
        activeTab: 'content',
        // Xəta olan dil varsa, ilk onu aç
        activeLocale: errLocales.length ? errLocales[0] : baseLocale,
        editMode: @js(old('edit_mode', $post->edit_mode ?: 'classic')),
        themeTemplate: @js(old('theme_template', $post->theme_template ?? '')),
        publishing: false,

        analyzing: false,
        seoAnalysis: null,
        seoScore: null,
        seoColor: '#10b981',

        seoLoading: false,

        init() {
            try {
                const saved = sessionStorage.getItem(tabKey);
                if (saved) this.activeTab = saved;
            } catch (e) {}

            this.$watch('activeTab', (val) => {
                try { sessionStorage.setItem(tabKey, val); } catch (e) {}
            });
        },

        async generateSeo() {
            const isBase = this.activeLocale === baseLocale;
            const titleSel = isBase ? 'title' : 'translations[' + this.activeLocale + '][title]';

            const titleInput = document.querySelector('[name="' + titleSel + '"]');
            const contentInput = document.querySelector('textarea[name="content"]');

            const title = titleInput ? titleInput.value : '';
            const content = contentInput ? contentInput.value : '';

            if (!title) {
                alert(@js(__('Please enter a title first.')));
                return;
            }

            this.seoLoading = true;

            try {
                const res = await fetch(@js(route('admin.posts.ai.generate-seo')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @js(csrf_token()),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        content: content,
                        locale: this.activeLocale,
                        post_id: @js((string) $post->id)
                    })
                });
                const data = await res.json();

                if (data.success) {
                    const n = (f) => isBase ? f : 'translations[' + this.activeLocale + '][' + f + ']';

                    const titleEl = document.querySelector('[name="' + n('seo_title') + '"]');
                    const descEl  = document.querySelector('[name="' + n('seo_description') + '"]');
                    const kwEl    = document.querySelector('[name="' + n('focus_keyword') + '"]');

                    if (titleEl) {
                        titleEl.value = data.seo_title;
                        titleEl.dispatchEvent(new Event('input'));
                    }
                    if (descEl) {
                        descEl.value = data.seo_description;
                        descEl.dispatchEvent(new Event('input'));
                    }
                    if (kwEl) {
                        kwEl.value = data.focus_keyword;
                    }
                } else {
                    alert(data.message || @js(__('AI generation failed.')));
                }
            } catch (e) {
                alert(@js(__('Network error.')));
            } finally {
                this.seoLoading = false;
            }
        },

        async analyzeSeo() {
            this.analyzing = true;

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]').content;

                const res = await fetch(@js(route('admin.posts.ai.seo-analyze', $post)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({
                        locale: this.activeLocale,
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    this.seoAnalysis = data;
                    this.seoScore = data.score;
                    this.seoColor = data.level === 'good' ? '#10b981' : (data.level === 'warn' ? '#f59e0b' : '#ef4444');
                } else {
                    alert(data.message || @js(__('Analysis failed.')));
                }
            } catch (e) {
                alert(@js(__('Network error.')));
            } finally {
                this.analyzing = false;
            }
        },
    };
}
</script>
@endsection