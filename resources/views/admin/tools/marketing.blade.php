@extends('admin.layouts.app')

@section('title', __('Marketing Post Generator'))

@section('content')
@php
    $config = [
        'posts' => $posts,
        'logo' => $siteLogo,
        'brand' => $brand,
        'i18n' => [
            'defaultTitle' => __('Create Stunning Posts'),
            'defaultSubtitle' => __('Generate beautiful marketing graphics directly from your admin panel in seconds.'),
            'titlePlaceholder' => __('Your title here'),
            'copied' => __('Image copied to clipboard'),
            'copyFailed' => __('Copying images is not supported in this browser'),
            'renderFailed' => __('Could not generate the image'),
            'tabContent' => __('Content'),
            'tabBackground' => __('Background'),
            'tabText' => __('Text & Brand'),
            'left' => __('Left'),
            'center' => __('Center'),
            'right' => __('Right'),
            'top' => __('Top'),
            'middle' => __('Middle'),
            'bottom' => __('Bottom'),
            'sans' => __('Sans'),
            'serif' => __('Serif'),
            'mono' => __('Mono'),
        ],
    ];
@endphp

<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

<div class="w-full max-w-full space-y-6 pb-12" x-data="marketingTool(@js($config))" x-cloak>

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rj-purple to-rj-pink flex items-center justify-center text-white shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">{{ __('Marketing Post Generator') }}</h1>
                <p class="text-xs text-gray-500">{{ __('Turn your posts into ready-to-share graphics') }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" @click="reset()" :disabled="busy" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition disabled:opacity-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M5.6 15A8 8 0 0018.4 9M18.4 9L20 9M5.6 15L4 15"/></svg>
                {{ __('Reset') }}
            </button>
            <button type="button" @click="copy()" :disabled="busy" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-300 text-gray-800 text-sm font-semibold hover:bg-gray-50 transition disabled:opacity-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                {{ __('Copy') }}
            </button>
            <button type="button" @click="download('jpeg')" :disabled="busy" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-300 text-gray-800 text-sm font-semibold hover:bg-gray-50 transition disabled:opacity-50">
                JPG
            </button>
            <button type="button" @click="download('png')" :disabled="busy" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-bold shadow-md hover:opacity-90 transition disabled:opacity-50">
                <svg x-show="!busy" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <svg x-show="busy" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                <span x-text="busy ? '{{ __('Generating...') }}' : '{{ __('Download PNG') }}'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start w-full min-w-0">

        <div class="lg:col-span-4 w-full min-w-0">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden lg:sticky lg:top-4">

                <div class="p-3 border-b border-gray-100">
                    <div class="grid grid-cols-3 gap-1 p-1 bg-gray-100 rounded-xl">
                        <template x-for="t in tabs" :key="t.id">
                            <button type="button" @click="tab = t.id"
                                    :class="tab === t.id ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-800'"
                                    class="py-2 rounded-lg text-xs font-bold transition" x-text="t.label"></button>
                        </template>
                    </div>
                </div>

                <div class="p-5 space-y-5 lg:max-h-[calc(100vh-14rem)] overflow-y-auto">

                    <div x-show="tab === 'content'" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Pick a post') }}</label>
                            <input type="text" x-model="search" placeholder="{{ __('Search posts...') }}" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                            <div class="mt-2 max-h-52 overflow-y-auto space-y-1.5 pr-1">
                                <template x-for="p in filteredPosts" :key="p.id">
                                    <button type="button" @click="selectPost(p)"
                                            :class="selectedPostId === p.id ? 'border-rj-purple bg-gray-50' : 'border-gray-200 hover:bg-gray-50'"
                                            class="w-full flex items-center gap-3 p-2 rounded-xl border text-left transition">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
                                            <img x-show="p.image" :src="p.image" loading="lazy" class="w-full h-full object-cover" @error="$el.style.display = 'none'">
                                        </div>
                                        <span class="text-sm font-semibold text-gray-800 line-clamp-2" x-text="p.title"></span>
                                    </button>
                                </template>
                                <p x-show="filteredPosts.length === 0" class="text-xs text-gray-500 py-3 text-center">{{ __('No posts found') }}</p>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Badge') }}</label>
                            <input type="text" x-model="badge" maxlength="30" placeholder="{{ __('e.g. NEW, UPDATE, BLOG') }}" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Title') }}</label>
                            <textarea x-model="title" rows="2" class="w-full rounded-xl border-gray-300 text-sm font-bold focus:ring-rj-purple focus:border-rj-purple"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Subtitle') }}</label>
                            <textarea x-model="subtitle" rows="3" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple"></textarea>
                        </div>
                    </div>

                    <div x-show="tab === 'background'" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('Gradient presets') }}</label>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="g in gradients" :key="g[0] + g[1]">
                                    <button type="button" @click="color1 = g[0]; color2 = g[1]"
                                            :style="`background: linear-gradient(135deg, ${g[0]}, ${g[1]})`"
                                            :class="color1 === g[0] && color2 === g[1] ? 'ring-2 ring-offset-2 ring-rj-purple' : ''"
                                            class="h-10 rounded-lg border border-black/10 transition hover:scale-105"></button>
                                </template>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Color 1') }}</label>
                                <input type="color" x-model="color1" class="w-full h-10 rounded-lg cursor-pointer border border-gray-200 p-1 bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Color 2') }}</label>
                                <input type="color" x-model="color2" class="w-full h-10 rounded-lg cursor-pointer border border-gray-200 p-1 bg-white">
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5">
                                <span>{{ __('Angle') }}</span>
                                <span class="text-gray-500" x-text="angle + '°'"></span>
                            </div>
                            <input type="range" min="0" max="360" step="5" x-model.number="angle" class="mk-range w-full">
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Background image') }}</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:bg-gray-50 transition">
                                <input type="file" accept="image/*" @change="handleUpload($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div x-show="!bgImage" class="text-xs text-gray-600 font-semibold">{{ __('Click or drop an image here') }}</div>
                                <div x-show="bgImage" class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-lg bg-cover bg-center border border-gray-200 shrink-0" :style="`background-image:url('${bgImage}')`"></div>
                                    <span class="text-xs text-gray-600 font-semibold">{{ __('Click to replace') }}</span>
                                </div>
                            </div>
                            <button type="button" x-show="bgImage" @click="bgImage = ''" class="text-xs text-red-500 mt-2 hover:underline">{{ __('Remove image') }}</button>
                        </div>

                        <div x-show="bgImage">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Image focus') }}</label>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-gray-100 rounded-xl">
                                <template x-for="o in imagePosOptions" :key="o.value">
                                    <button type="button" @click="imagePos = o.value"
                                            :class="imagePos === o.value ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-800'"
                                            class="py-1.5 rounded-lg text-xs font-bold transition" x-text="o.label"></button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5">
                                <span>{{ __('Overlay darkness') }}</span>
                                <span class="text-gray-500" x-text="overlay + '%'"></span>
                            </div>
                            <input type="range" min="0" max="90" step="5" x-model.number="overlay" class="mk-range w-full">
                        </div>
                    </div>

                    <div x-show="tab === 'text'" class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Alignment') }}</label>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-gray-100 rounded-xl">
                                <template x-for="o in alignOptions" :key="o.value">
                                    <button type="button" @click="align = o.value"
                                            :class="align === o.value ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-800'"
                                            class="py-1.5 rounded-lg text-xs font-bold transition" x-text="o.label"></button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Vertical position') }}</label>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-gray-100 rounded-xl">
                                <template x-for="o in vAlignOptions" :key="o.value">
                                    <button type="button" @click="vAlign = o.value"
                                            :class="vAlign === o.value ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-800'"
                                            class="py-1.5 rounded-lg text-xs font-bold transition" x-text="o.label"></button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Font') }}</label>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-gray-100 rounded-xl">
                                <template x-for="o in fontOptions" :key="o.value">
                                    <button type="button" @click="font = o.value"
                                            :class="font === o.value ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-800'"
                                            class="py-1.5 rounded-lg text-xs font-bold transition" x-text="o.label"></button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5">
                                <span>{{ __('Text size') }}</span>
                                <span class="text-gray-500" x-text="textScale + '%'"></span>
                            </div>
                            <input type="range" min="60" max="150" step="5" x-model.number="textScale" class="mk-range w-full">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Text color') }}</label>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="textColor" class="w-12 h-10 rounded-lg cursor-pointer border border-gray-200 p-1 bg-white">
                                <button type="button" @click="textColor = '#ffffff'" class="w-10 h-10 rounded-lg bg-white border border-gray-300 hover:scale-105 transition"></button>
                                <button type="button" @click="textColor = '#111827'" class="w-10 h-10 rounded-lg bg-gray-900 border border-gray-300 hover:scale-105 transition"></button>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-gray-700">{{ __('Show logo and brand') }}</span>
                            <input type="checkbox" x-model="showBrand" class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        </label>

                        <div x-show="showBrand" class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Brand name') }}</label>
                                <input type="text" x-model="brand" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ __('Link or call to action') }}</label>
                                <input type="text" x-model="linkText" placeholder="example.com" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="lg:col-span-8 w-full min-w-0 space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-1.5 bg-white p-1.5 rounded-xl border border-gray-200 shadow-sm">
                    <template x-for="f in formats" :key="f.id">
                        <button type="button" @click="formatId = f.id"
                                :class="formatId === f.id ? 'bg-rj-purple text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'"
                                class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition" x-text="f.label"></button>
                    </template>
                </div>
                <span class="text-xs font-semibold text-gray-500" x-text="w + ' × ' + h + ' px'"></span>
            </div>

            <div x-ref="stage"
                 class="relative bg-gray-100 rounded-2xl border border-gray-200 p-6 flex items-center justify-center shadow-inner w-full overflow-hidden"
                 :style="`min-height:${stageH + 48}px`">

                <div x-show="busy" class="absolute inset-0 z-30 bg-gray-100/80 backdrop-blur-sm flex items-center justify-center">
                    <div class="text-center text-gray-900">
                        <svg class="w-9 h-9 animate-spin mx-auto text-rj-purple mb-2" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                        <p class="font-bold text-sm">{{ __('Generating...') }}</p>
                    </div>
                </div>

                <div x-show="notice" x-transition class="absolute top-3 right-3 z-40 px-3 py-2 rounded-lg text-xs font-semibold shadow-lg"
                     :class="notice && notice.type === 'error' ? 'bg-red-600 text-white' : 'bg-gray-900 text-white'"
                     x-text="notice ? notice.text : ''"></div>

                <div class="relative shadow-2xl rounded-lg overflow-hidden ring-1 ring-black/10 shrink-0" :style="`width:${w * scale}px;height:${h * scale}px`">
                    <div id="post-canvas" :style="canvasStyle">
                        <div :style="gradientStyle"></div>
                        <div x-show="bgImage" :style="imageStyle"></div>
                        <div :style="overlayStyle"></div>

                        <div :style="layerStyle">
                            <div :style="mainStyle">
                                <span x-show="badge" :style="badgeStyle" x-text="badge"></span>
                                <h2 :style="titleStyle" x-text="title || i18n.titlePlaceholder"></h2>
                                <p x-show="subtitle" :style="subtitleStyle" x-text="subtitle"></p>
                            </div>

                            <div x-show="showBrand" :style="footerStyle">
                                <div :style="brandGroupStyle">
                                    <img x-show="logoData" :src="logoData" alt="" :style="logoStyle">
                                    <span x-show="!logoData" :style="logoFallbackStyle" x-text="(brand || 'R').charAt(0).toUpperCase()"></span>
                                    <span :style="brandTextStyle" x-text="brand"></span>
                                </div>
                                <span x-show="linkText" :style="linkStyle" x-text="linkText"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .mk-range { accent-color: rgb(var(--rj-purple, 124 58 237)); }
</style>

<script>
function marketingTool(config) {
    const i18n = config.i18n;

    const defaults = {
        selectedPostId: null,
        search: '',
        title: i18n.defaultTitle,
        subtitle: i18n.defaultSubtitle,
        badge: '',
        bgImage: '',
        imagePos: 'center',
        color1: '#7c3aed',
        color2: '#ec4899',
        angle: 135,
        overlay: 40,
        align: 'left',
        vAlign: 'end',
        font: 'sans',
        textScale: 100,
        textColor: '#ffffff',
        showBrand: true,
        brand: config.brand,
        linkText: '',
        formatId: 'square'
    };

    const fontStacks = {
        sans: 'Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
        serif: 'Georgia, "Times New Roman", Times, serif',
        mono: 'ui-monospace, SFMono-Regular, Menlo, Consolas, "Courier New", monospace'
    };

    const flex = { left: 'flex-start', center: 'center', right: 'flex-end', start: 'flex-start', end: 'flex-end' };

    return {
        ...defaults,
        tab: 'content',
        posts: config.posts || [],
        i18n,
        logoData: config.logo || '',
        busy: false,
        notice: null,
        scale: 0.4,
        stageH: 520,
        noticeTimer: null,

        tabs: [
            { id: 'content', label: i18n.tabContent },
            { id: 'background', label: i18n.tabBackground },
            { id: 'text', label: i18n.tabText }
        ],
        formats: [
            { id: 'square', label: '1:1', w: 1080, h: 1080 },
            { id: 'portrait', label: '4:5', w: 1080, h: 1350 },
            { id: 'story', label: '9:16', w: 1080, h: 1920 },
            { id: 'wide', label: '16:9', w: 1920, h: 1080 },
            { id: 'classic', label: '4:3', w: 1440, h: 1080 }
        ],
        gradients: [
            ['#7c3aed', '#ec4899'],
            ['#0ea5e9', '#6366f1'],
            ['#10b981', '#84cc16'],
            ['#f97316', '#e11d48'],
            ['#111827', '#374151'],
            ['#06b6d4', '#3b82f6'],
            ['#f59e0b', '#ef4444'],
            ['#a78bfa', '#f472b6']
        ],
        alignOptions: [
            { value: 'left', label: i18n.left },
            { value: 'center', label: i18n.center },
            { value: 'right', label: i18n.right }
        ],
        vAlignOptions: [
            { value: 'start', label: i18n.top },
            { value: 'center', label: i18n.middle },
            { value: 'end', label: i18n.bottom }
        ],
        imagePosOptions: [
            { value: 'top', label: i18n.top },
            { value: 'center', label: i18n.middle },
            { value: 'bottom', label: i18n.bottom }
        ],
        fontOptions: [
            { value: 'sans', label: i18n.sans },
            { value: 'serif', label: i18n.serif },
            { value: 'mono', label: i18n.mono }
        ],

        async init() {
            this.$watch('formatId', () => this.$nextTick(() => this.fit()));
            this.$nextTick(() => {
                this.fit();
                if (typeof ResizeObserver !== 'undefined' && this.$refs.stage) {
                    new ResizeObserver(() => this.fit()).observe(this.$refs.stage);
                }
                window.addEventListener('resize', () => this.fit());
            });

            if (this.logoData) {
                this.logoData = await this.toDataUrl(this.logoData);
            }
        },

        get format() { return this.formats.find(f => f.id === this.formatId) || this.formats[0]; },
        get w() { return this.format.w; },
        get h() { return this.format.h; },
        get base() { return Math.min(this.w, this.h); },
        get pad() { return Math.round(this.base * 0.07); },
        get titleSize() { return Math.round(this.base * 0.078 * (this.textScale / 100)); },

        get filteredPosts() {
            const q = this.search.trim().toLowerCase();
            if (!q) return this.posts;
            return this.posts.filter(p => (p.title || '').toLowerCase().includes(q));
        },

        get canvasStyle() {
            return `position:absolute;top:0;left:0;width:${this.w}px;height:${this.h}px;transform:scale(${this.scale});transform-origin:top left;overflow:hidden;background:#111827;font-family:${fontStacks[this.font]};`;
        },
        get gradientStyle() {
            return `position:absolute;inset:0;background:linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2});`;
        },
        get imageStyle() {
            return `position:absolute;inset:0;background-image:url('${this.bgImage}');background-size:cover;background-repeat:no-repeat;background-position:center ${this.imagePos};`;
        },
        get overlayStyle() {
            const o = this.overlay / 100;
            let bg;
            if (this.vAlign === 'center') {
                bg = `rgba(0,0,0,${(o * 0.75).toFixed(3)})`;
            } else if (this.vAlign === 'start') {
                bg = `linear-gradient(to bottom, rgba(0,0,0,${o}) 0%, rgba(0,0,0,${(o * 0.5).toFixed(3)}) 55%, rgba(0,0,0,${(o * 0.35).toFixed(3)}) 100%)`;
            } else {
                bg = `linear-gradient(to top, rgba(0,0,0,${o}) 0%, rgba(0,0,0,${(o * 0.5).toFixed(3)}) 55%, rgba(0,0,0,${(o * 0.12).toFixed(3)}) 100%)`;
            }
            return `position:absolute;inset:0;background:${bg};`;
        },
        get layerStyle() {
            return `position:absolute;inset:0;display:flex;flex-direction:column;padding:${this.pad}px;box-sizing:border-box;`;
        },
        get mainStyle() {
            return `flex:1;min-height:0;display:flex;flex-direction:column;overflow:hidden;justify-content:${flex[this.vAlign]};align-items:${flex[this.align]};text-align:${this.align};`;
        },
        get badgeStyle() {
            const s = this.titleSize;
            return `display:inline-block;margin-bottom:${Math.round(s * 0.35)}px;padding:${Math.round(s * 0.12)}px ${Math.round(s * 0.3)}px;border-radius:999px;font-size:${Math.round(s * 0.26)}px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:${this.textColor};background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.4);`;
        },
        get titleStyle() {
            return `margin:0;max-width:100%;font-size:${this.titleSize}px;line-height:1.08;font-weight:800;letter-spacing:-0.02em;color:${this.textColor};word-break:break-word;text-shadow:0 2px 24px rgba(0,0,0,0.3);`;
        },
        get subtitleStyle() {
            const s = this.titleSize;
            return `margin:${Math.round(s * 0.3)}px 0 0;max-width:100%;font-size:${Math.round(s * 0.4)}px;line-height:1.5;font-weight:500;color:${this.textColor};opacity:0.88;word-break:break-word;text-shadow:0 2px 16px rgba(0,0,0,0.3);`;
        },
        get footerStyle() {
            const dir = this.align === 'right' ? 'row-reverse' : 'row';
            const just = this.align === 'center' ? 'center' : 'space-between';
            return `flex-shrink:0;margin-top:${Math.round(this.titleSize * 0.55)}px;display:flex;flex-direction:${dir};align-items:center;justify-content:${just};gap:${Math.round(this.titleSize * 0.5)}px;`;
        },
        get brandGroupStyle() {
            return `display:flex;align-items:center;gap:${Math.round(this.titleSize * 0.2)}px;`;
        },
        get logoStyle() {
            return `height:${Math.round(this.titleSize * 0.55)}px;width:auto;max-width:${Math.round(this.titleSize * 2.4)}px;object-fit:contain;`;
        },
        get logoFallbackStyle() {
            const s = Math.round(this.titleSize * 0.55);
            return `width:${s}px;height:${s}px;border-radius:${Math.round(s * 0.28)}px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:${Math.round(s * 0.55)}px;color:${this.textColor};background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.4);`;
        },
        get brandTextStyle() {
            return `font-size:${Math.round(this.titleSize * 0.3)}px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:${this.textColor};text-shadow:0 2px 12px rgba(0,0,0,0.3);`;
        },
        get linkStyle() {
            return `font-size:${Math.round(this.titleSize * 0.3)}px;font-weight:600;color:${this.textColor};opacity:0.85;text-shadow:0 2px 12px rgba(0,0,0,0.3);`;
        },

        fit() {
            const stage = this.$refs.stage;
            if (!stage) return;
            const aw = Math.max(stage.clientWidth - 48, 200);
            const ah = Math.max(Math.min(window.innerHeight - 260, 780), 360);
            this.stageH = ah;
            this.scale = Math.min(aw / this.w, ah / this.h);
        },

        notify(text, type = 'success') {
            this.notice = { text, type };
            clearTimeout(this.noticeTimer);
            this.noticeTimer = setTimeout(() => { this.notice = null; }, 2800);
        },

        async toDataUrl(url) {
            if (!url || url.startsWith('data:')) return url;
            try {
                const res = await fetch(url, { mode: 'cors' });
                if (!res.ok) throw new Error('fetch failed');
                const blob = await res.blob();
                return await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(blob);
                });
            } catch (e) {
                return url;
            }
        },

        async selectPost(post) {
            this.selectedPostId = post.id;
            this.title = post.title;
            this.subtitle = post.excerpt;
            this.bgImage = post.image ? await this.toDataUrl(post.image) : '';
        },

        handleUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => { this.bgImage = e.target.result; };
            reader.readAsDataURL(file);
            event.target.value = '';
        },

        reset() {
            Object.assign(this, defaults);
            this.tab = 'content';
        },

        slug() {
            const s = (this.title || 'post')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '')
                .slice(0, 40);
            return s || 'post';
        },

        renderOptions() {
            return {
                width: this.w,
                height: this.h,
                pixelRatio: 1,
                cacheBust: false,
                backgroundColor: '#111827',
                style: { transform: 'none', top: '0', left: '0' }
            };
        },

        async download(type) {
            if (this.busy) return;
            this.busy = true;
            try {
                const node = document.getElementById('post-canvas');
                const opts = this.renderOptions();
                const dataUrl = type === 'jpeg'
                    ? await htmlToImage.toJpeg(node, { ...opts, quality: 0.95 })
                    : await htmlToImage.toPng(node, opts);

                const link = document.createElement('a');
                link.download = `${this.slug()}-${this.format.label.replace(':', 'x')}.${type === 'jpeg' ? 'jpg' : 'png'}`;
                link.href = dataUrl;
                link.click();
            } catch (e) {
                console.error(e);
                this.notify(i18n.renderFailed, 'error');
            } finally {
                this.busy = false;
            }
        },

        async copy() {
            if (this.busy) return;
            if (!navigator.clipboard || typeof ClipboardItem === 'undefined') {
                this.notify(i18n.copyFailed, 'error');
                return;
            }
            this.busy = true;
            try {
                const blob = await htmlToImage.toBlob(document.getElementById('post-canvas'), this.renderOptions());
                await navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })]);
                this.notify(i18n.copied);
            } catch (e) {
                console.error(e);
                this.notify(i18n.renderFailed, 'error');
            } finally {
                this.busy = false;
            }
        }
    };
}
</script>
@endsection