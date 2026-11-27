@extends('admin.layouts.app')

@section('title', __('Marketing Post Generator'))

@section('content')
@php
    $config = [
        'posts' => $posts,
        'logo' => $siteLogo,
        'brand' => $brand,
        'domain' => $domain,
        'i18n' => [
            'defaultTitle' => __('Create Stunning Posts'),
            'defaultSubtitle' => __('Generate beautiful marketing graphics directly from your admin panel in seconds.'),
            'titlePlaceholder' => __('Your title here'),
            'copied' => __('Image copied to clipboard'),
            'copyFailed' => __('Copying images is not supported in this browser'),
            'renderFailed' => __('Could not generate the image'),
            'zipMissing' => __('ZIP library failed to load'),
            'colorsApplied' => __('Colors extracted from the image'),
            'tplSaved' => __('Template saved'),
            'download' => __('Download'),
            'generating' => __('Generating...'),
            'custom' => __('Custom'),
            'tabContent' => __('Content'),
            'tabLayout' => __('Layout'),
            'tabBackground' => __('Background'),
            'tabText' => __('Text'),
            'tabEffects' => __('Effects'),
            'tabExport' => __('Export'),
            'left' => __('Left'),
            'center' => __('Center'),
            'right' => __('Right'),
            'top' => __('Top'),
            'middle' => __('Middle'),
            'bottom' => __('Bottom'),
            'sans' => __('Sans'),
            'serif' => __('Serif'),
            'mono' => __('Mono'),
            'layCover' => __('Full image'),
            'layGlass' => __('Glass'),
            'laySplit' => __('Split'),
            'layBrowser' => __('Browser'),
            'layPhone' => __('Phone'),
            'layCard' => __('Card'),
            'layPolaroid' => __('Polaroid'),
            'layText' => __('Text only'),
            'linear' => __('Linear'),
            'radial' => __('Radial'),
            'patNone' => __('None'),
            'patDots' => __('Dots'),
            'patGrid' => __('Grid'),
            'patLines' => __('Lines'),
            'decNone' => __('None'),
            'decOrbs' => __('Orbs'),
            'decRings' => __('Rings'),
            'decGlow' => __('Glow'),
            'wSemi' => __('Semi'),
            'wBold' => __('Bold'),
            'wExtra' => __('Extra'),
            'wBlack' => __('Black'),
            'ctaSolid' => __('Solid'),
            'ctaOutline' => __('Outline'),
            'ctaGlass' => __('Glass'),
            'preBold' => __('Bold'),
            'preClean' => __('Clean'),
            'preMidnight' => __('Midnight'),
            'preSunset' => __('Sunset'),
            'preEditorial' => __('Editorial'),
            'preNeon' => __('Neon'),
            'preOcean' => __('Ocean'),
            'preMono' => __('Mono'),
        ],
    ];
@endphp

<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>

<div id="mk-root" x-data="marketingTool(@js($config))" x-cloak>

    <div class="mk-head">
        <div class="mk-head-left">
            <div class="mk-badge-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <h1 class="mk-h1">{{ __('Marketing Post Generator') }}</h1>
                <p class="mk-sub">{{ __('Turn your posts into ready-to-share graphics') }}</p>
            </div>
        </div>

        <div class="mk-actions">
            <button type="button" class="mk-btn" @click="reset()" :disabled="busy">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M5.6 15A8 8 0 0018.4 9"/></svg>
                {{ __('Reset') }}
            </button>
            <button type="button" class="mk-btn" @click="copy()" :disabled="busy">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                {{ __('Copy') }}
            </button>
            <button type="button" class="mk-btn" @click="downloadAll()" :disabled="busy">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                {{ __('All sizes (ZIP)') }}
            </button>
            <button type="button" class="mk-btn mk-btn-primary" @click="download()" :disabled="busy">
                <svg x-show="!busy" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <svg x-show="busy" class="mk-spin" width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                <span x-text="busy ? i18n.generating : i18n.download + ' ' + exportType.toUpperCase()"></span>
            </button>
        </div>
    </div>

    <div class="mk-layout">

        <aside class="mk-panel">
            <div class="mk-tabs-wrap">
                <div class="mk-tabs">
                    <template x-for="t in tabs" :key="t.id">
                        <button type="button" class="mk-tab" :class="{ 'is-on': tab === t.id }" @click="tab = t.id" x-text="t.label"></button>
                    </template>
                </div>
            </div>

            <div class="mk-scroll">

                <div x-show="tab === 'content'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('Pick a post') }}</label>
                        <input type="text" class="mk-input" x-model="search" placeholder="{{ __('Search posts...') }}">
                        <div class="mk-posts">
                            <template x-for="p in filteredPosts" :key="p.id">
                                <button type="button" class="mk-post" :class="{ 'is-on': selectedPostId === p.id }" @click="selectPost(p)">
                                    <span class="mk-thumb">
                                        <img x-show="p.image" :src="p.image" loading="lazy" alt="" x-on:error="$el.style.display = 'none'">
                                    </span>
                                    <span class="mk-post-info">
                                        <span class="mk-post-title" x-text="p.title"></span>
                                        <span class="mk-post-desc" x-text="p.excerpt"></span>
                                    </span>
                                </button>
                            </template>
                            <p class="mk-empty" x-show="filteredPosts.length === 0">{{ __('No posts found') }}</p>
                        </div>
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Badge') }}</label>
                        <input type="text" class="mk-input" x-model="badge" maxlength="30" placeholder="{{ __('e.g. NEW, UPDATE, BLOG') }}">
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Title') }}</label>
                        <textarea class="mk-input mk-bold" x-model="title" rows="2"></textarea>
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Subtitle') }}</label>
                        <textarea class="mk-input" x-model="subtitle" rows="3"></textarea>
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Button text') }}</label>
                        <input type="text" class="mk-input" x-model="cta" maxlength="30" placeholder="{{ __('e.g. Read more') }}">
                    </div>
                </div>

                <div x-show="tab === 'layout'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('Quick styles') }}</label>
                        <div class="mk-presets">
                            <template x-for="p in presets" :key="p.id">
                                <button type="button" class="mk-preset" @click="applyPreset(p)">
                                    <span class="mk-preset-sw" :style="`background: linear-gradient(135deg, ${p.c[0]}, ${p.c[1]})`"></span>
                                    <span x-text="p.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Layout') }}</label>
                        <div class="mk-layouts">
                            <template x-for="l in layouts" :key="l.id">
                                <button type="button" class="mk-lay" :class="{ 'is-on': layout === l.id }" @click="setLayout(l.id)">
                                    <svg viewBox="0 0 48 48" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.6" x-html="l.svg"></svg>
                                    <span x-text="l.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'background'">
                    <div class="mk-field">
                        <div class="mk-row">
                            <label class="mk-label">{{ __('Gradient presets') }}</label>
                            <button type="button" class="mk-mini" @click="shuffle()">{{ __('Shuffle') }}</button>
                        </div>
                        <div class="mk-gradients">
                            <template x-for="g in gradients" :key="g[0] + g[1]">
                                <button type="button" class="mk-grad" :class="{ 'is-on': color1 === g[0] && color2 === g[1] }"
                                        :style="`background: linear-gradient(135deg, ${g[0]}, ${g[1]})`"
                                        @click="color1 = g[0]; color2 = g[1]"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field">
                        <div class="mk-seg two">
                            <button type="button" :class="{ 'is-on': gradType === 'linear' }" @click="gradType = 'linear'" x-text="i18n.linear"></button>
                            <button type="button" :class="{ 'is-on': gradType === 'radial' }" @click="gradType = 'radial'" x-text="i18n.radial"></button>
                        </div>
                    </div>

                    <div class="mk-field mk-two">
                        <div>
                            <label class="mk-label">{{ __('Color 1') }}</label>
                            <input type="color" class="mk-color" x-model="color1">
                        </div>
                        <div>
                            <label class="mk-label">{{ __('Color 2') }}</label>
                            <input type="color" class="mk-color" x-model="color2">
                        </div>
                    </div>

                    <div class="mk-field" x-show="gradType === 'linear'">
                        <div class="mk-row">
                            <label class="mk-label">{{ __('Angle') }}</label>
                            <span class="mk-val" x-text="angle + '°'"></span>
                        </div>
                        <input type="range" class="mk-range" min="0" max="360" step="5" x-model.number="angle">
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Image / screenshot') }}</label>
                        <div class="mk-drop">
                            <input type="file" accept="image/*" @change="handleUpload($event)">
                            <span x-show="!bgImage">{{ __('Click or drop an image here') }}</span>
                            <div x-show="bgImage" class="mk-drop-preview">
                                <span class="mk-drop-thumb" :style="`background-image:url('${bgImage}')`"></span>
                                <span>{{ __('Click to replace') }}</span>
                            </div>
                        </div>
                        <div class="mk-row" style="margin-top:8px" x-show="bgImage">
                            <button type="button" class="mk-link-danger" @click="bgImage = ''">{{ __('Remove image') }}</button>
                            <button type="button" class="mk-mini" @click="autoColors()">{{ __('Auto colors') }}</button>
                        </div>
                    </div>

                    <div x-show="bgImage">
                        <div class="mk-field">
                            <div class="mk-row">
                                <label class="mk-label">{{ __('Zoom') }}</label>
                                <span class="mk-val" x-text="imgZoom + '%'"></span>
                            </div>
                            <input type="range" class="mk-range" min="100" max="300" step="5" x-model.number="imgZoom">
                        </div>
                        <div class="mk-field mk-two">
                            <div>
                                <div class="mk-row"><label class="mk-label">{{ __('Position X') }}</label><span class="mk-val" x-text="imgX + '%'"></span></div>
                                <input type="range" class="mk-range" min="0" max="100" x-model.number="imgX">
                            </div>
                            <div>
                                <div class="mk-row"><label class="mk-label">{{ __('Position Y') }}</label><span class="mk-val" x-text="imgY + '%'"></span></div>
                                <input type="range" class="mk-range" min="0" max="100" x-model.number="imgY">
                            </div>
                        </div>
                        <div class="mk-field">
                            <div class="mk-row"><label class="mk-label">{{ __('Brightness') }}</label><span class="mk-val" x-text="imgBright + '%'"></span></div>
                            <input type="range" class="mk-range" min="50" max="150" step="5" x-model.number="imgBright">
                        </div>
                        <div class="mk-field">
                            <div class="mk-row"><label class="mk-label">{{ __('Saturation') }}</label><span class="mk-val" x-text="imgSat + '%'"></span></div>
                            <input type="range" class="mk-range" min="0" max="200" step="5" x-model.number="imgSat">
                        </div>
                        <div class="mk-field">
                            <div class="mk-row"><label class="mk-label">{{ __('Blur') }}</label><span class="mk-val" x-text="imgBlur"></span></div>
                            <input type="range" class="mk-range" min="0" max="20" x-model.number="imgBlur">
                        </div>
                        <button type="button" class="mk-link-danger" style="color:#6b7280" @click="resetImage()">{{ __('Reset image adjustments') }}</button>
                    </div>

                    <div class="mk-field" x-show="showFullImage" style="margin-top:18px">
                        <div class="mk-row">
                            <label class="mk-label">{{ __('Overlay darkness') }}</label>
                            <span class="mk-val" x-text="overlay + '%'"></span>
                        </div>
                        <input type="range" class="mk-range" min="0" max="90" step="5" x-model.number="overlay">
                    </div>
                </div>

                <div x-show="tab === 'text'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('Alignment') }}</label>
                        <div class="mk-seg">
                            <template x-for="o in alignOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': align === o.value }" @click="align = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Vertical position') }}</label>
                        <div class="mk-seg">
                            <template x-for="o in vAlignOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': vAlign === o.value }" @click="vAlign = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Font') }}</label>
                        <div class="mk-seg">
                            <template x-for="o in fontOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': font === o.value }" @click="font = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Weight') }}</label>
                        <div class="mk-seg four">
                            <template x-for="o in weightOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': titleWeight === o.value }" @click="titleWeight = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field">
                        <div class="mk-row"><label class="mk-label">{{ __('Title size') }}</label><span class="mk-val" x-text="textScale + '%'"></span></div>
                        <input type="range" class="mk-range" min="60" max="150" step="5" x-model.number="textScale">
                    </div>

                    <div class="mk-field">
                        <div class="mk-row"><label class="mk-label">{{ __('Subtitle size') }}</label><span class="mk-val" x-text="subScale + '%'"></span></div>
                        <input type="range" class="mk-range" min="70" max="150" step="5" x-model.number="subScale">
                    </div>

                    <div class="mk-field">
                        <div class="mk-row"><label class="mk-label">{{ __('Line height') }}</label><span class="mk-val" x-text="lineH + '%'"></span></div>
                        <input type="range" class="mk-range" min="90" max="150" step="2" x-model.number="lineH">
                    </div>

                    <label class="mk-check"><span>{{ __('Uppercase title') }}</span><input type="checkbox" x-model="upper"></label>
                    <label class="mk-check"><span>{{ __('Text shadow') }}</span><input type="checkbox" x-model="shadow"></label>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Text color') }}</label>
                        <div class="mk-swatches">
                            <input type="color" class="mk-color mk-color-sm" x-model="textColor">
                            <button type="button" class="mk-swatch" style="background:#ffffff" @click="textColor = '#ffffff'"></button>
                            <button type="button" class="mk-swatch" style="background:#111827" @click="textColor = '#111827'"></button>
                        </div>
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Button style') }}</label>
                        <div class="mk-seg">
                            <template x-for="o in ctaOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': ctaStyle === o.value }" @click="ctaStyle = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>
                    <div class="mk-field" x-show="ctaStyle === 'solid'">
                        <label class="mk-label">{{ __('Button color') }}</label>
                        <input type="color" class="mk-color mk-color-sm" x-model="ctaBg">
                    </div>

                    <hr class="mk-hr">

                    <label class="mk-check"><span>{{ __('Show logo and brand') }}</span><input type="checkbox" x-model="showBrand"></label>

                    <div x-show="showBrand">
                        <label class="mk-check"><span>{{ __('Show brand name') }}</span><input type="checkbox" x-model="showBrandName"></label>

                        <div class="mk-field">
                            <label class="mk-label">{{ __('Brand position') }}</label>
                            <div class="mk-seg two">
                                <button type="button" :class="{ 'is-on': !brandTop }" @click="brandTop = false" x-text="i18n.bottom"></button>
                                <button type="button" :class="{ 'is-on': brandTop }" @click="brandTop = true" x-text="i18n.top"></button>
                            </div>
                        </div>

                        <div class="mk-field">
                            <div class="mk-row"><label class="mk-label">{{ __('Logo size') }}</label><span class="mk-val" x-text="logoScale + '%'"></span></div>
                            <input type="range" class="mk-range" min="60" max="250" step="10" x-model.number="logoScale">
                        </div>

                        <div class="mk-field">
                            <label class="mk-label">{{ __('Brand name') }}</label>
                            <input type="text" class="mk-input" x-model="brand">
                        </div>
                        <div class="mk-field">
                            <label class="mk-label">{{ __('Link or call to action') }}</label>
                            <input type="text" class="mk-input" x-model="linkText" placeholder="example.com">
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'effects'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('Pattern') }}</label>
                        <div class="mk-seg four">
                            <template x-for="o in patternOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': pattern === o.value }" @click="pattern = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>
                    <div class="mk-field" x-show="pattern !== 'none'">
                        <div class="mk-row"><label class="mk-label">{{ __('Pattern opacity') }}</label><span class="mk-val" x-text="patternOpacity + '%'"></span></div>
                        <input type="range" class="mk-range" min="3" max="50" x-model.number="patternOpacity">
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Decoration') }}</label>
                        <div class="mk-seg four">
                            <template x-for="o in decorOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': decor === o.value }" @click="decor = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <div class="mk-row"><label class="mk-label">{{ __('Frame thickness') }}</label><span class="mk-val" x-text="frame"></span></div>
                        <input type="range" class="mk-range" min="0" max="24" x-model.number="frame">
                    </div>
                    <div class="mk-field" x-show="frame > 0">
                        <label class="mk-label">{{ __('Frame color') }}</label>
                        <input type="color" class="mk-color mk-color-sm" x-model="frameColor">
                    </div>

                    <div class="mk-field">
                        <div class="mk-row"><label class="mk-label">{{ __('Corner radius') }}</label><span class="mk-val" x-text="radius"></span></div>
                        <input type="range" class="mk-range" min="0" max="160" step="4" x-model.number="radius">
                    </div>
                </div>

                <div x-show="tab === 'export'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('File type') }}</label>
                        <div class="mk-seg">
                            <button type="button" :class="{ 'is-on': exportType === 'png' }" @click="exportType = 'png'">PNG</button>
                            <button type="button" :class="{ 'is-on': exportType === 'jpg' }" @click="exportType = 'jpg'">JPG</button>
                            <button type="button" :class="{ 'is-on': exportType === 'webp' }" @click="exportType = 'webp'">WebP</button>
                        </div>
                    </div>

                    <div class="mk-field" x-show="exportType !== 'png'">
                        <div class="mk-row"><label class="mk-label">{{ __('Quality') }}</label><span class="mk-val" x-text="jpgQuality + '%'"></span></div>
                        <input type="range" class="mk-range" min="50" max="100" step="1" x-model.number="jpgQuality">
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Resolution') }}</label>
                        <div class="mk-seg two">
                            <button type="button" :class="{ 'is-on': exportScale === 1 }" @click="exportScale = 1">1x</button>
                            <button type="button" :class="{ 'is-on': exportScale === 2 }" @click="exportScale = 2">2x</button>
                        </div>
                        <p class="mk-note" x-text="'{{ __('Output size') }}: ' + (w * exportScale) + ' × ' + (h * exportScale) + ' px'"></p>
                    </div>

                    <hr class="mk-hr">

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Save current design as template') }}</label>
                        <div class="mk-inline">
                            <input type="text" class="mk-input" x-model="tplName" maxlength="30" placeholder="{{ __('Template name') }}" @keydown.enter.prevent="saveTemplate()">
                            <button type="button" class="mk-btn mk-btn-primary" @click="saveTemplate()">{{ __('Save') }}</button>
                        </div>
                        <div class="mk-tpls">
                            <template x-for="t in templates" :key="t.id">
                                <div class="mk-tpl">
                                    <span class="mk-tpl-name" x-text="t.name"></span>
                                    <span class="mk-tpl-actions">
                                        <button type="button" class="mk-mini" @click="applyTemplate(t)">{{ __('Apply') }}</button>
                                        <button type="button" class="mk-mini mk-mini-danger" @click="deleteTemplate(t.id)">&times;</button>
                                    </span>
                                </div>
                            </template>
                        </div>
                        <p class="mk-note">{{ __('Your design settings are saved automatically in this browser.') }}</p>
                    </div>
                </div>

            </div>
        </aside>

        <section class="mk-main">

            <div class="mk-toolbar">
                <div class="mk-formats">
                    <template x-for="f in formats" :key="f.id">
                        <button type="button" class="mk-fmt" :class="{ 'is-on': formatId === f.id }" @click="formatId = f.id" x-text="f.label"></button>
                    </template>
                    <button type="button" class="mk-fmt" :class="{ 'is-on': formatId === 'custom' }" @click="formatId = 'custom'" x-text="i18n.custom"></button>
                </div>

                <div class="mk-custom" x-show="formatId === 'custom'">
                    <input type="number" class="mk-input mk-num" min="200" max="4000" x-model.number="customW">
                    <span>×</span>
                    <input type="number" class="mk-input mk-num" min="200" max="4000" x-model.number="customH">
                </div>

                <label class="mk-inline-check"><input type="checkbox" x-model="guides"> {{ __('Guides') }}</label>
                <span class="mk-size" x-text="w + ' × ' + h + ' px'"></span>
            </div>

            <div class="mk-stage" x-ref="stage" :style="`min-height:${stageH + 48}px`">

                <div class="mk-loader" x-show="busy">
                    <div>
                        <svg class="mk-spin" width="34" height="34" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                        <p>{{ __('Generating...') }}</p>
                    </div>
                </div>

                <div class="mk-toast" x-show="notice" x-transition :class="{ 'is-error': notice && notice.type === 'error' }" x-text="notice ? notice.text : ''"></div>

                <div class="mk-frame" :style="frameWrapStyle">
                    <div id="post-canvas" :style="canvasStyle">
                        <div :style="gradientStyle"></div>

                        <template x-if="showFullImage && bgImage"><div :style="imageStyle"></div></template>
                        <template x-if="showFullImage"><div :style="overlayStyle"></div></template>

                        <template x-if="pattern !== 'none'"><div :style="patternStyle"></div></template>

                        <template x-if="decor === 'orbs'"><div :style="orbAStyle"></div></template>
                        <template x-if="decor === 'orbs'"><div :style="orbBStyle"></div></template>
                        <template x-if="decor === 'rings'"><div :style="ringAStyle"></div></template>
                        <template x-if="decor === 'rings'"><div :style="ringBStyle"></div></template>
                        <template x-if="decor === 'glow'"><div :style="glowStyle"></div></template>

                        <div :style="layerStyle">

                            <template x-if="hasMedia">
                                <div :style="mediaBoxStyle">

                                    <template x-if="layout === 'split'">
                                        <div :style="splitShotStyle"></div>
                                    </template>

                                    <template x-if="layout === 'browser'">
                                        <div :style="browserStyle">
                                            <div :style="browserBarStyle">
                                                <span :style="dotStyle('#ff5f57')"></span>
                                                <span :style="dotStyle('#febc2e')"></span>
                                                <span :style="dotStyle('#28c840')"></span>
                                                <span :style="urlPillStyle" x-text="urlText"></span>
                                            </div>
                                            <div :style="browserFillStyle"></div>
                                        </div>
                                    </template>

                                    <template x-if="layout === 'phone'">
                                        <div :style="phoneStyle">
                                            <div :style="phoneScreenStyle"></div>
                                            <span :style="phoneNotchStyle"></span>
                                        </div>
                                    </template>

                                    <template x-if="layout === 'card'">
                                        <div :style="cardStyle"></div>
                                    </template>

                                    <template x-if="layout === 'polaroid'">
                                        <div :style="polaroidStyle">
                                            <div :style="polaroidFillStyle"></div>
                                            <span :style="polaroidCaptionStyle" x-text="polaroidCaption"></span>
                                        </div>
                                    </template>

                                </div>
                            </template>

                            <div :style="textWrapStyle">
                                <div :style="mainStyle">
                                    <template x-if="badge"><span :style="badgeStyle" x-text="badge"></span></template>
                                    <h2 :style="titleStyle" x-text="title || i18n.titlePlaceholder"></h2>
                                    <template x-if="subtitle"><p :style="subtitleStyle" x-text="subtitle"></p></template>
                                    <template x-if="cta"><span :style="ctaCss" x-text="cta"></span></template>
                                </div>

                                <template x-if="showBrand">
                                    <div :style="footerStyle">
                                        <div :style="brandGroupStyle">
                                            <template x-if="logoData"><img :src="logoData" alt="" :style="logoStyle"></template>
                                            <template x-if="!logoData"><span :style="logoFallbackStyle" x-text="(brand || 'R').charAt(0).toUpperCase()"></span></template>
                                            <template x-if="showBrandName && brand"><span :style="brandTextStyle" x-text="brand"></span></template>
                                        </div>
                                        <template x-if="linkText"><span :style="linkStyle" x-text="linkText"></span></template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <template x-if="frame > 0"><div :style="frameStyle"></div></template>
                    </div>

                    <template x-if="guides"><div :style="guideStyle"></div></template>
                    <template x-if="guides && formatId === 'story'"><div :style="guideTopStyle"></div></template>
                    <template x-if="guides && formatId === 'story'"><div :style="guideBottomStyle"></div></template>
                </div>
            </div>

        </section>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }

    #mk-root {
        --mk-accent: rgb(var(--rj-purple, 124 58 237));
        --mk-accent-2: rgb(var(--rj-pink, 236 72 153));
        --mk-border: #e5e7eb;
        --mk-muted: #6b7280;
        --mk-text: #111827;
        width: 100%;
        max-width: 100%;
        padding-bottom: 48px;
        color: var(--mk-text);
    }
    #mk-root * { box-sizing: border-box; }

    #mk-root .mk-head {
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;
        background: #fff; border: 1px solid var(--mk-border); border-radius: 16px;
        padding: 16px; margin-bottom: 24px; box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    #mk-root .mk-head-left { display: flex; align-items: center; gap: 12px; }
    #mk-root .mk-badge-icon {
        width: 40px; height: 40px; border-radius: 12px; color: #fff;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--mk-accent), var(--mk-accent-2));
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }
    #mk-root .mk-h1 { margin: 0; font-size: 18px; font-weight: 700; line-height: 1.2; }
    #mk-root .mk-sub { margin: 2px 0 0; font-size: 12px; color: var(--mk-muted); }
    #mk-root .mk-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }

    #mk-root .mk-btn {
        display: inline-flex; align-items: center; gap: 8px; cursor: pointer;
        padding: 9px 16px; border-radius: 12px; font-size: 14px; font-weight: 600;
        background: #fff; color: #1f2937; border: 1px solid #d1d5db; transition: .15s;
    }
    #mk-root .mk-btn:hover { background: #f3f4f6; }
    #mk-root .mk-btn:disabled { opacity: .5; cursor: not-allowed; }
    #mk-root .mk-btn-primary {
        color: #fff; border-color: transparent; font-weight: 700;
        background: linear-gradient(90deg, var(--mk-accent), var(--mk-accent-2));
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }
    #mk-root .mk-btn-primary:hover { opacity: .9; background: linear-gradient(90deg, var(--mk-accent), var(--mk-accent-2)); }

    #mk-root .mk-mini {
        padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;
        background: #f3f4f6; border: 1px solid #e5e7eb; color: #374151; transition: .15s;
    }
    #mk-root .mk-mini:hover { background: #e5e7eb; }
    #mk-root .mk-mini-danger { color: #dc2626; }

    #mk-root .mk-layout {
        display: grid; grid-template-columns: minmax(0, 1fr); gap: 24px; align-items: start; width: 100%;
    }
    @media (min-width: 1024px) {
        #mk-root .mk-layout { grid-template-columns: 360px minmax(0, 1fr); }
        #mk-root .mk-panel { position: sticky; top: 16px; }
        #mk-root .mk-scroll { max-height: calc(100vh - 230px); overflow-y: auto; }
    }

    #mk-root .mk-panel {
        background: #fff; border: 1px solid var(--mk-border); border-radius: 16px;
        overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,.04); min-width: 0;
    }
    #mk-root .mk-tabs-wrap { padding: 12px; border-bottom: 1px solid #f3f4f6; }
    #mk-root .mk-tabs { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px; padding: 4px; background: #f3f4f6; border-radius: 12px; }
    #mk-root .mk-tab {
        padding: 8px 2px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
        font-size: 12px; font-weight: 700; color: var(--mk-muted); transition: .15s;
    }
    #mk-root .mk-tab:hover { color: var(--mk-text); }
    #mk-root .mk-tab.is-on { background: #fff; color: var(--mk-text); box-shadow: 0 1px 3px rgba(0,0,0,.12); }

    #mk-root .mk-scroll { padding: 20px; }
    #mk-root .mk-field { margin-bottom: 18px; }
    #mk-root .mk-label { display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700; color: #374151; }
    #mk-root .mk-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; gap: 8px; }
    #mk-root .mk-row .mk-label { margin: 0; }
    #mk-root .mk-val { font-size: 12px; color: var(--mk-muted); font-weight: 600; }
    #mk-root .mk-hr { border: 0; border-top: 1px solid #f3f4f6; margin: 18px 0; }
    #mk-root .mk-note { margin: 8px 0 0; font-size: 11.5px; color: var(--mk-muted); }

    #mk-root .mk-input {
        display: block; width: 100%; padding: 9px 12px; font-size: 14px; font-family: inherit;
        background: #fff; color: var(--mk-text); border: 1px solid #d1d5db; border-radius: 12px; outline: none; resize: vertical;
    }
    #mk-root .mk-input:focus { border-color: var(--mk-accent); box-shadow: 0 0 0 3px rgba(124,58,237,.15); }
    #mk-root .mk-bold { font-weight: 700; }
    #mk-root .mk-inline { display: flex; gap: 8px; align-items: center; }

    #mk-root .mk-posts { margin-top: 8px; max-height: 260px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px; padding-right: 2px; }
    #mk-root .mk-post {
        display: flex; align-items: center; gap: 10px; width: 100%; text-align: left; cursor: pointer;
        padding: 8px; background: #fff; border: 1px solid var(--mk-border); border-radius: 12px; transition: .15s;
    }
    #mk-root .mk-post:hover { background: #f9fafb; }
    #mk-root .mk-post.is-on { border-color: var(--mk-accent); background: #f5f3ff; }
    #mk-root .mk-thumb { flex: 0 0 44px; width: 44px; height: 44px; border-radius: 8px; background: #f3f4f6; overflow: hidden; }
    #mk-root .mk-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    #mk-root .mk-post-info { min-width: 0; display: flex; flex-direction: column; gap: 2px; }
    #mk-root .mk-post-title {
        font-size: 13px; font-weight: 700; color: #1f2937; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }
    #mk-root .mk-post-desc {
        font-size: 11.5px; color: var(--mk-muted); line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    #mk-root .mk-empty { margin: 0; padding: 12px 0; text-align: center; font-size: 12px; color: var(--mk-muted); }

    #mk-root .mk-presets { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; }
    #mk-root .mk-preset {
        display: flex; flex-direction: column; align-items: center; gap: 5px; padding: 6px 4px; cursor: pointer;
        background: #fff; border: 1px solid var(--mk-border); border-radius: 10px; font-size: 11px; font-weight: 700; color: #374151; transition: .15s;
    }
    #mk-root .mk-preset:hover { background: #f9fafb; transform: translateY(-1px); }
    #mk-root .mk-preset-sw { display: block; width: 100%; height: 30px; border-radius: 7px; border: 1px solid rgba(0,0,0,.08); }

    #mk-root .mk-layouts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    #mk-root .mk-lay {
        display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 12px 6px; cursor: pointer;
        background: #fff; border: 1px solid var(--mk-border); border-radius: 12px; color: #6b7280;
        font-size: 12px; font-weight: 700; transition: .15s;
    }
    #mk-root .mk-lay:hover { background: #f9fafb; color: var(--mk-text); }
    #mk-root .mk-lay.is-on { border-color: var(--mk-accent); background: #f5f3ff; color: var(--mk-accent); }

    #mk-root .mk-gradients { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 8px; }
    #mk-root .mk-grad { height: 40px; border-radius: 10px; border: 1px solid rgba(0,0,0,.1); cursor: pointer; transition: .15s; }
    #mk-root .mk-grad:hover { transform: scale(1.06); }
    #mk-root .mk-grad.is-on { outline: 2px solid var(--mk-accent); outline-offset: 2px; }

    #mk-root .mk-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    #mk-root .mk-color { display: block; width: 100%; height: 40px; padding: 4px; background: #fff; border: 1px solid #d1d5db; border-radius: 10px; cursor: pointer; }
    #mk-root .mk-color-sm { width: 48px; }
    #mk-root .mk-swatches { display: flex; align-items: center; gap: 8px; }
    #mk-root .mk-swatch { width: 40px; height: 40px; border-radius: 10px; border: 1px solid #d1d5db; cursor: pointer; transition: .15s; }
    #mk-root .mk-swatch:hover { transform: scale(1.06); }

    #mk-root .mk-range { width: 100%; accent-color: var(--mk-accent); }

    #mk-root .mk-seg { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px; padding: 4px; background: #f3f4f6; border-radius: 12px; }
    #mk-root .mk-seg.two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    #mk-root .mk-seg.four { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    #mk-root .mk-seg button {
        padding: 7px 2px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
        font-size: 12px; font-weight: 700; color: var(--mk-muted); transition: .15s;
    }
    #mk-root .mk-seg button:hover { color: var(--mk-text); }
    #mk-root .mk-seg button.is-on { background: #fff; color: var(--mk-text); box-shadow: 0 1px 3px rgba(0,0,0,.12); }

    #mk-root .mk-drop {
        position: relative; padding: 16px; text-align: center; font-size: 12px; font-weight: 600; color: #4b5563;
        border: 2px dashed #d1d5db; border-radius: 12px; transition: .15s;
    }
    #mk-root .mk-drop:hover { background: #f9fafb; }
    #mk-root .mk-drop input { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    #mk-root .mk-drop-preview { display: flex; align-items: center; gap: 12px; }
    #mk-root .mk-drop-thumb { width: 56px; height: 56px; border-radius: 8px; border: 1px solid var(--mk-border); background-size: cover; background-position: center; flex: 0 0 56px; }
    #mk-root .mk-link-danger { padding: 0; background: none; border: 0; color: #ef4444; font-size: 12px; cursor: pointer; }
    #mk-root .mk-link-danger:hover { text-decoration: underline; }

    #mk-root .mk-check { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; font-size: 12px; font-weight: 700; color: #374151; cursor: pointer; }
    #mk-root .mk-check input { width: 16px; height: 16px; accent-color: var(--mk-accent); }

    #mk-root .mk-tpls { margin-top: 10px; display: flex; flex-direction: column; gap: 6px; }
    #mk-root .mk-tpl { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 8px 10px; border: 1px solid var(--mk-border); border-radius: 10px; background: #fafafa; }
    #mk-root .mk-tpl-name { font-size: 13px; font-weight: 600; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    #mk-root .mk-tpl-actions { display: flex; gap: 6px; flex: 0 0 auto; }

    #mk-root .mk-main { min-width: 0; width: 100%; }
    #mk-root .mk-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 16px; }
    #mk-root .mk-formats { display: flex; flex-wrap: wrap; gap: 6px; padding: 6px; background: #fff; border: 1px solid var(--mk-border); border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    #mk-root .mk-fmt {
        padding: 7px 14px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
        font-size: 12px; font-weight: 700; color: #4b5563; transition: .15s;
    }
    #mk-root .mk-fmt:hover { background: #f3f4f6; }
    #mk-root .mk-fmt.is-on { background: var(--mk-accent); color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.2); }
    #mk-root .mk-custom { display: flex; align-items: center; gap: 6px; font-weight: 700; color: var(--mk-muted); }
    #mk-root .mk-num { width: 84px; padding: 7px 8px; font-size: 13px; }
    #mk-root .mk-inline-check { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #4b5563; cursor: pointer; }
    #mk-root .mk-inline-check input { accent-color: var(--mk-accent); }
    #mk-root .mk-size { margin-left: auto; font-size: 12px; font-weight: 600; color: var(--mk-muted); }

    #mk-root .mk-stage {
        position: relative; display: flex; align-items: center; justify-content: center;
        width: 100%; padding: 24px; overflow: hidden;
        background: #f3f4f6; border: 1px solid var(--mk-border); border-radius: 16px;
        box-shadow: inset 0 2px 6px rgba(0,0,0,.05);
    }
    #mk-root .mk-frame { position: relative; flex: 0 0 auto; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,.25); outline: 1px solid rgba(0,0,0,.1); }

    #mk-root .mk-loader { position: absolute; inset: 0; z-index: 30; display: flex; align-items: center; justify-content: center; background: rgba(243,244,246,.85); backdrop-filter: blur(4px); text-align: center; color: var(--mk-text); }
    #mk-root .mk-loader svg { color: var(--mk-accent); margin: 0 auto 8px; display: block; }
    #mk-root .mk-loader p { margin: 0; font-size: 14px; font-weight: 700; }
    #mk-root .mk-toast { position: absolute; top: 12px; right: 12px; z-index: 40; max-width: 80%; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #fff; background: #111827; box-shadow: 0 8px 20px rgba(0,0,0,.25); }
    #mk-root .mk-toast.is-error { background: #dc2626; }

    #mk-root .mk-spin { animation: mk-spin 1s linear infinite; }
    @keyframes mk-spin { to { transform: rotate(360deg); } }
</style>

<script>
function hslToHex(h, s, l) {
    s /= 100; l /= 100;
    const k = n => (n + h / 30) % 12;
    const a = s * Math.min(l, 1 - l);
    const f = n => l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)));
    return '#' + [f(0), f(8), f(4)].map(x => Math.round(x * 255).toString(16).padStart(2, '0')).join('');
}

function lum(hex) {
    const m = /^#?([0-9a-f]{6})$/i.exec(hex || '');
    if (!m) return 0;
    const n = parseInt(m[1], 16);
    return (0.299 * ((n >> 16) & 255) + 0.587 * ((n >> 8) & 255) + 0.114 * (n & 255)) / 255;
}

function clampSize(v) {
    return Math.min(4000, Math.max(200, parseInt(v, 10) || 1080));
}

// 1x1 transparent GIF used when a remote image cannot be loaded during export
const EMPTY_IMAGE = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

function marketingTool(config) {
    const i18n = config.i18n;

    const styleDefaults = {
        layout: 'cover',
        gradType: 'linear',
        color1: '#7c3aed',
        color2: '#ec4899',
        angle: 135,
        imgZoom: 100,
        imgX: 50,
        imgY: 50,
        imgBright: 100,
        imgSat: 100,
        imgBlur: 0,
        overlay: 40,
        pattern: 'none',
        patternOpacity: 18,
        decor: 'none',
        frame: 0,
        frameColor: '#ffffff',
        radius: 0,
        align: 'left',
        vAlign: 'end',
        font: 'sans',
        textScale: 100,
        subScale: 100,
        titleWeight: 800,
        upper: false,
        lineH: 108,
        shadow: true,
        textColor: '#ffffff',
        ctaStyle: 'solid',
        ctaBg: '#ffffff'
    };

    const defaults = {
        selectedPostId: null,
        search: '',
        title: i18n.defaultTitle,
        subtitle: i18n.defaultSubtitle,
        badge: '',
        cta: '',
        bgImage: '',
        ...styleDefaults,
        showBrand: true,
        brand: config.brand,
        showBrandName: true,
        brandTop: false,
        logoScale: 100,
        linkText: '',
        formatId: 'square',
        customW: 1080,
        customH: 1350,
        exportScale: 1,
        exportType: 'png',
        jpgQuality: 92,
        guides: false
    };

    const styleKeys = Object.keys(styleDefaults);
    const designKeys = styleKeys.concat([
        'showBrand', 'showBrandName', 'brandTop', 'logoScale', 'linkText',
        'formatId', 'customW', 'customH', 'exportScale', 'exportType', 'jpgQuality'
    ]);

    const fontStacks = {
        sans: 'Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
        serif: 'Georgia, "Times New Roman", Times, serif',
        mono: 'ui-monospace, SFMono-Regular, Menlo, Consolas, "Courier New", monospace'
    };

    const flex = { left: 'flex-start', center: 'center', right: 'flex-end', start: 'flex-start', end: 'flex-end' };

    const mediaMeta = {
        split:    { f: 0.56, first: true },
        browser:  { f: 0.60, first: false },
        phone:    { f: 0.64, first: false },
        card:     { f: 0.58, first: true },
        polaroid: { f: 0.62, first: true }
    };

    const svgs = {
        cover: '<rect x="6" y="6" width="36" height="36" rx="4" fill="currentColor" opacity=".22" stroke="none"/><rect x="11" y="28" width="22" height="3.5" rx="1.7" fill="currentColor" stroke="none"/><rect x="11" y="34" width="15" height="2.5" rx="1.2" fill="currentColor" opacity=".6" stroke="none"/>',
        glass: '<rect x="6" y="6" width="36" height="36" rx="4" fill="currentColor" opacity=".22" stroke="none"/><rect x="11" y="15" width="26" height="18" rx="5" fill="currentColor" opacity=".18"/><rect x="16" y="21" width="16" height="3" rx="1.5" fill="currentColor" stroke="none"/><rect x="16" y="27" width="10" height="2.5" rx="1.2" fill="currentColor" opacity=".6" stroke="none"/>',
        split: '<rect x="6" y="6" width="36" height="21" rx="3" fill="currentColor" opacity=".3" stroke="none"/><rect x="6" y="29" width="36" height="13" rx="3"/><rect x="10" y="33" width="18" height="3" rx="1.5" fill="currentColor" stroke="none"/>',
        browser: '<rect x="5" y="15" width="38" height="27" rx="3"/><line x1="5" y1="21" x2="43" y2="21"/><circle cx="9.5" cy="18" r="1" fill="currentColor"/><circle cx="13" cy="18" r="1" fill="currentColor"/><rect x="9" y="6" width="22" height="3" rx="1.5" fill="currentColor" stroke="none"/>',
        phone: '<rect x="16" y="5" width="16" height="38" rx="4"/><rect x="19" y="10" width="10" height="26" rx="2" fill="currentColor" opacity=".25" stroke="none"/><rect x="4" y="14" width="9" height="3" rx="1.5" fill="currentColor" stroke="none"/><rect x="4" y="20" width="7" height="2.5" rx="1.2" fill="currentColor" opacity=".6" stroke="none"/>',
        card: '<g transform="rotate(-6 24 20)"><rect x="9" y="8" width="30" height="22" rx="4" fill="currentColor" opacity=".25"/></g><rect x="9" y="35" width="24" height="3" rx="1.5" fill="currentColor" stroke="none"/>',
        polaroid: '<g transform="rotate(4 24 24)"><rect x="10" y="6" width="28" height="34" rx="2"/><rect x="13" y="9" width="22" height="20" fill="currentColor" opacity=".25" stroke="none"/></g>',
        text: '<rect x="9" y="14" width="30" height="4" rx="2" fill="currentColor" stroke="none"/><rect x="9" y="22" width="30" height="4" rx="2" fill="currentColor" stroke="none"/><rect x="9" y="30" width="18" height="3" rx="1.5" fill="currentColor" opacity=".6" stroke="none"/>'
    };

    return {
        ...defaults,
        tab: 'content',
        posts: config.posts || [],
        domain: config.domain || '',
        i18n,
        logoData: config.logo || '',
        imgNat: { w: 0, h: 0 },
        busy: false,
        notice: null,
        scale: 0.4,
        stageH: 520,
        noticeTimer: null,
        templates: [],
        tplName: '',
        storeKey: 'rj_marketing_design_v2',
        tplKey: 'rj_marketing_templates_v2',

        tabs: [
            { id: 'content', label: i18n.tabContent },
            { id: 'layout', label: i18n.tabLayout },
            { id: 'background', label: i18n.tabBackground },
            { id: 'text', label: i18n.tabText },
            { id: 'effects', label: i18n.tabEffects },
            { id: 'export', label: i18n.tabExport }
        ],
        layouts: [
            { id: 'cover', label: i18n.layCover, svg: svgs.cover },
            { id: 'glass', label: i18n.layGlass, svg: svgs.glass },
            { id: 'split', label: i18n.laySplit, svg: svgs.split },
            { id: 'browser', label: i18n.layBrowser, svg: svgs.browser },
            { id: 'phone', label: i18n.layPhone, svg: svgs.phone },
            { id: 'card', label: i18n.layCard, svg: svgs.card },
            { id: 'polaroid', label: i18n.layPolaroid, svg: svgs.polaroid },
            { id: 'text', label: i18n.layText, svg: svgs.text }
        ],
        presets: [
            { id: 'bold', name: i18n.preBold, c: ['#7c3aed', '#ec4899'], p: { layout: 'cover', decor: 'orbs' } },
            { id: 'clean', name: i18n.preClean, c: ['#f8fafc', '#e2e8f0'], p: { layout: 'browser', color1: '#f8fafc', color2: '#e2e8f0', angle: 160, textColor: '#0f172a', shadow: false, pattern: 'dots', patternOpacity: 16, vAlign: 'center', ctaBg: '#0f172a' } },
            { id: 'midnight', name: i18n.preMidnight, c: ['#312e81', '#0f172a'], p: { layout: 'glass', gradType: 'radial', color1: '#312e81', color2: '#0f172a', pattern: 'grid', patternOpacity: 8, decor: 'glow', align: 'center', vAlign: 'center', overlay: 30 } },
            { id: 'sunset', name: i18n.preSunset, c: ['#f97316', '#e11d48'], p: { layout: 'phone', color1: '#f97316', color2: '#e11d48', angle: 150, decor: 'rings', vAlign: 'center' } },
            { id: 'editorial', name: i18n.preEditorial, c: ['#fef3c7', '#fde68a'], p: { layout: 'polaroid', color1: '#fef3c7', color2: '#fde68a', angle: 160, font: 'serif', textColor: '#1f2937', titleWeight: 700, shadow: false, vAlign: 'center', ctaBg: '#1f2937' } },
            { id: 'neon', name: i18n.preNeon, c: ['#022c22', '#064e3b'], p: { layout: 'split', color1: '#022c22', color2: '#064e3b', font: 'mono', textColor: '#a7f3d0', upper: true, titleWeight: 700, pattern: 'grid', patternOpacity: 10, vAlign: 'center', ctaBg: '#34d399' } },
            { id: 'ocean', name: i18n.preOcean, c: ['#0ea5e9', '#6366f1'], p: { layout: 'card', color1: '#0ea5e9', color2: '#6366f1', decor: 'orbs', vAlign: 'center' } },
            { id: 'mono', name: i18n.preMono, c: ['#111827', '#374151'], p: { layout: 'text', color1: '#111827', color2: '#374151', upper: true, titleWeight: 900, align: 'center', vAlign: 'center', frame: 6, frameColor: '#ffffff', pattern: 'lines', patternOpacity: 6 } }
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
        fontOptions: [
            { value: 'sans', label: i18n.sans },
            { value: 'serif', label: i18n.serif },
            { value: 'mono', label: i18n.mono }
        ],
        weightOptions: [
            { value: 600, label: i18n.wSemi },
            { value: 700, label: i18n.wBold },
            { value: 800, label: i18n.wExtra },
            { value: 900, label: i18n.wBlack }
        ],
        ctaOptions: [
            { value: 'solid', label: i18n.ctaSolid },
            { value: 'outline', label: i18n.ctaOutline },
            { value: 'glass', label: i18n.ctaGlass }
        ],
        patternOptions: [
            { value: 'none', label: i18n.patNone },
            { value: 'dots', label: i18n.patDots },
            { value: 'grid', label: i18n.patGrid },
            { value: 'lines', label: i18n.patLines }
        ],
        decorOptions: [
            { value: 'none', label: i18n.decNone },
            { value: 'orbs', label: i18n.decOrbs },
            { value: 'rings', label: i18n.decRings },
            { value: 'glow', label: i18n.decGlow }
        ],

        async init() {
            this.loadStore();

            this.$watch('formatId', () => this.$nextTick(() => this.fit()));
            this.$watch('customW', () => this.$nextTick(() => this.fit()));
            this.$watch('customH', () => this.$nextTick(() => this.fit()));
            this.$watch('bgImage', (v) => this.loadNat(v));
            this.$watch('designJson', (v) => {
                try { localStorage.setItem(this.storeKey, v); } catch (e) {}
            });

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

        loadStore() {
            try {
                const raw = localStorage.getItem(this.storeKey);
                if (raw) this.applyDesign(JSON.parse(raw));
            } catch (e) {}
            try {
                const t = JSON.parse(localStorage.getItem(this.tplKey) || '[]');
                this.templates = Array.isArray(t) ? t : [];
            } catch (e) {
                this.templates = [];
            }
        },

        applyDesign(d) {
            if (!d || typeof d !== 'object') return;
            designKeys.forEach(k => {
                if (k in d && typeof d[k] === typeof defaults[k]) this[k] = d[k];
            });
        },

        get designJson() {
            const o = {};
            designKeys.forEach(k => { o[k] = this[k]; });
            return JSON.stringify(o);
        },

        storeTemplates() {
            try { localStorage.setItem(this.tplKey, JSON.stringify(this.templates)); } catch (e) {}
        },

        saveTemplate() {
            const name = this.tplName.trim();
            if (!name) return;
            this.templates.push({ id: Date.now(), name, data: JSON.parse(this.designJson) });
            this.tplName = '';
            this.storeTemplates();
            this.notify(i18n.tplSaved);
        },

        applyTemplate(t) {
            this.applyDesign(t.data);
        },

        deleteTemplate(id) {
            this.templates = this.templates.filter(t => t.id !== id);
            this.storeTemplates();
        },

        applyPreset(p) {
            styleKeys.forEach(k => { this[k] = styleDefaults[k]; });
            Object.keys(p.p).forEach(k => { this[k] = p.p[k]; });
        },

        setLayout(id) {
            this.layout = id;
            this.vAlign = id === 'cover' ? 'end' : 'center';
        },

        resetImage() {
            this.imgZoom = 100; this.imgX = 50; this.imgY = 50;
            this.imgBright = 100; this.imgSat = 100; this.imgBlur = 0;
        },

        shuffle() {
            const h = Math.floor(Math.random() * 360);
            const h2 = (h + 40 + Math.floor(Math.random() * 80)) % 360;
            this.color1 = hslToHex(h, 75, 52);
            this.color2 = hslToHex(h2, 80, 58);
            this.angle = [45, 90, 135, 160, 200][Math.floor(Math.random() * 5)];
        },

        autoColors() {
            if (!this.bgImage) return;
            const img = new Image();
            img.onload = () => {
                try {
                    const n = 48;
                    const c = document.createElement('canvas');
                    c.width = n; c.height = n;
                    const x = c.getContext('2d');
                    x.drawImage(img, 0, 0, n, n);
                    const d = x.getImageData(0, 0, n, n).data;
                    const buckets = {};
                    for (let i = 0; i < d.length; i += 4) {
                        if (d[i + 3] < 200) continue;
                        const key = (d[i] >> 5) + ',' + (d[i + 1] >> 5) + ',' + (d[i + 2] >> 5);
                        const o = buckets[key] || (buckets[key] = { r: 0, g: 0, b: 0, n: 0 });
                        o.r += d[i]; o.g += d[i + 1]; o.b += d[i + 2]; o.n++;
                    }
                    const list = Object.values(buckets)
                        .map(o => ({ r: o.r / o.n, g: o.g / o.n, b: o.b / o.n, n: o.n }))
                        .sort((a, b) => b.n - a.n);
                    if (!list.length) return;
                    const hex = o => '#' + [o.r, o.g, o.b].map(v => Math.round(v).toString(16).padStart(2, '0')).join('');
                    const dist = (a, b) => Math.hypot(a.r - b.r, a.g - b.g, a.b - b.b);
                    const first = list[0];
                    const second = list.find(o => dist(o, first) > 70) || list[Math.min(1, list.length - 1)];
                    this.color1 = hex(first);
                    this.color2 = hex(second);
                    this.notify(i18n.colorsApplied);
                } catch (e) {
                    this.notify(i18n.renderFailed, 'error');
                }
            };
            img.src = this.bgImage;
        },

        loadNat(src) {
            if (!src) { this.imgNat = { w: 0, h: 0 }; return; }
            const im = new Image();
            im.onload = () => { this.imgNat = { w: im.naturalWidth, h: im.naturalHeight }; };
            im.src = src;
        },

        get format() {
            if (this.formatId === 'custom') {
                return { id: 'custom', label: i18n.custom, w: clampSize(this.customW), h: clampSize(this.customH) };
            }
            return this.formats.find(f => f.id === this.formatId) || this.formats[0];
        },
        get w() { return this.format.w; },
        get h() { return this.format.h; },
        get base() { return Math.min(this.w, this.h); },
        get sc() { return this.base / 1080; },
        get landscape() { return this.w > this.h; },
        get meta() { return mediaMeta[this.layout] || null; },
        get hasMedia() { return !!this.meta; },
        get showFullImage() { return this.layout === 'cover' || this.layout === 'glass'; },
        get pad() { return this.layout === 'split' ? 0 : Math.round(this.base * 0.07); },
        get textPad() { return Math.round(this.base * 0.07); },
        get gap() { return this.layout === 'split' ? 0 : Math.round(this.base * 0.04); },
        get layoutFactor() { return this.hasMedia ? (this.landscape ? 0.68 : 0.86) : 1; },
        get titleSize() { return Math.round(this.base * 0.078 * (this.textScale / 100) * this.layoutFactor); },
        get ext() { return this.exportType; },
        get isLightText() { return lum(this.textColor) > 0.5; },

        get mediaSize() {
            const m = this.meta;
            if (!m) return { w: 0, h: 0 };
            const cw = this.w - 2 * this.pad;
            const ch = this.h - 2 * this.pad;
            if (this.landscape) return { w: Math.round(cw * 0.5), h: ch };
            return { w: cw, h: Math.round(ch * m.f) };
        },

        get filteredPosts() {
            const q = this.search.trim().toLowerCase();
            if (!q) return this.posts;
            return this.posts.filter(p => (p.title || '').toLowerCase().includes(q));
        },

        filterStr(extraBlur = 0) {
            const bl = Math.round((this.imgBlur * this.sc + extraBlur) * 10) / 10;
            if (this.imgBright === 100 && this.imgSat === 100 && bl === 0) return '';
            return `filter:brightness(${this.imgBright}%) saturate(${this.imgSat}%)${bl ? ` blur(${bl}px)` : ''};`;
        },

        shot(bw, bh, extraBlur = 0) {
            if (!this.bgImage) {
                return 'background:linear-gradient(135deg,rgba(255,255,255,0.4),rgba(255,255,255,0.12));';
            }
            let size = 'cover';
            const z = this.imgZoom / 100;
            if (z > 1 && this.imgNat.w) {
                const k = Math.max(bw / this.imgNat.w, bh / this.imgNat.h) * z;
                size = `${Math.ceil(this.imgNat.w * k)}px ${Math.ceil(this.imgNat.h * k)}px`;
            }
            return `background-image:url('${this.bgImage}');background-size:${size};background-position:${this.imgX}% ${this.imgY}%;background-repeat:no-repeat;${this.filterStr(extraBlur)}`;
        },

        get canvasStyle() {
            const r = Math.round(this.radius * this.sc);
            return `position:absolute;top:0;left:0;width:${this.w}px;height:${this.h}px;transform:scale(${this.scale});transform-origin:top left;overflow:hidden;background:#111827;border-radius:${r}px;font-family:${fontStacks[this.font]};`;
        },
        get frameWrapStyle() {
            const r = Math.round(this.radius * this.sc * this.scale);
            return `width:${this.w * this.scale}px;height:${this.h * this.scale}px;border-radius:${r}px;`;
        },
        get gradientStyle() {
            const g = this.gradType === 'radial'
                ? `radial-gradient(circle at 30% 20%, ${this.color1}, ${this.color2})`
                : `linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2})`;
            return `position:absolute;inset:0;background:${g};`;
        },
        get imageStyle() {
            if (this.layout === 'glass') {
                return `position:absolute;inset:0;${this.shot(this.w, this.h, this.base * 0.02)}transform:scale(1.12);`;
            }
            return `position:absolute;inset:0;${this.shot(this.w, this.h)}`;
        },
        get overlayStyle() {
            const o = this.overlay / 100;
            let bg;
            if (this.layout === 'glass' || this.vAlign === 'center') {
                bg = `rgba(0,0,0,${(o * 0.7).toFixed(3)})`;
            } else if (this.vAlign === 'start') {
                bg = `linear-gradient(to bottom, rgba(0,0,0,${o}) 0%, rgba(0,0,0,${(o * 0.5).toFixed(3)}) 55%, rgba(0,0,0,${(o * 0.35).toFixed(3)}) 100%)`;
            } else {
                bg = `linear-gradient(to top, rgba(0,0,0,${o}) 0%, rgba(0,0,0,${(o * 0.5).toFixed(3)}) 55%, rgba(0,0,0,${(o * 0.12).toFixed(3)}) 100%)`;
            }
            return `position:absolute;inset:0;background:${bg};`;
        },

        get patternStyle() {
            const rgb = this.isLightText ? '255,255,255' : '0,0,0';
            const c = `rgba(${rgb},${(this.patternOpacity / 100).toFixed(2)})`;
            const u = Math.round(this.base * 0.04);
            const t = Math.max(1, Math.round(this.base / 540));
            let img = '';
            let size = '';
            if (this.pattern === 'dots') {
                img = `radial-gradient(${c} ${Math.max(2, Math.round(u * 0.07))}px, transparent ${Math.max(3, Math.round(u * 0.09))}px)`;
                size = `background-size:${u}px ${u}px;`;
            } else if (this.pattern === 'grid') {
                const g = Math.round(u * 1.6);
                img = `linear-gradient(${c} ${t}px, transparent ${t}px), linear-gradient(90deg, ${c} ${t}px, transparent ${t}px)`;
                size = `background-size:${g}px ${g}px;`;
            } else {
                img = `repeating-linear-gradient(45deg, ${c} 0, ${c} ${t * 2}px, transparent ${t * 2}px, transparent ${u}px)`;
            }
            return `position:absolute;inset:0;background-image:${img};${size}`;
        },

        get orbAStyle() {
            const s = Math.round(this.base * 0.9);
            return `position:absolute;width:${s}px;height:${s}px;right:-${Math.round(s * 0.3)}px;top:-${Math.round(s * 0.3)}px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.32),rgba(255,255,255,0) 68%);`;
        },
        get orbBStyle() {
            const s = Math.round(this.base * 0.7);
            return `position:absolute;width:${s}px;height:${s}px;left:-${Math.round(s * 0.3)}px;bottom:-${Math.round(s * 0.3)}px;border-radius:50%;background:radial-gradient(circle,rgba(0,0,0,0.3),rgba(0,0,0,0) 68%);`;
        },
        ringCss(size) {
            const s = Math.round(this.base * size);
            const cx = this.w * 0.9;
            const cy = this.h * 0.1;
            const b = Math.max(2, Math.round(this.base * 0.003));
            return `position:absolute;width:${s}px;height:${s}px;left:${Math.round(cx - s / 2)}px;top:${Math.round(cy - s / 2)}px;border-radius:50%;border:${b}px solid rgba(255,255,255,0.28);box-sizing:border-box;`;
        },
        get ringAStyle() { return this.ringCss(1.0); },
        get ringBStyle() { return this.ringCss(0.64); },
        get glowStyle() {
            const x = this.align === 'right' ? 25 : 75;
            return `position:absolute;inset:0;background:radial-gradient(circle at ${x}% 20%, rgba(255,255,255,0.3), rgba(255,255,255,0) 55%);`;
        },

        get frameStyle() {
            const inset = Math.round(34 * this.sc);
            const bw = Math.max(1, Math.round(this.frame * this.sc));
            const r = Math.max(0, Math.round(this.radius * this.sc) - inset);
            return `position:absolute;inset:${inset}px;border:${bw}px solid ${this.frameColor};border-radius:${r}px;pointer-events:none;box-sizing:border-box;`;
        },

        get guideStyle() {
            const m = Math.round(this.base * 0.06 * this.scale);
            return `position:absolute;inset:${m}px;border:1px dashed rgba(255,255,255,0.9);box-shadow:0 0 0 1px rgba(0,0,0,0.35);pointer-events:none;z-index:5;`;
        },
        get guideTopStyle() {
            return `position:absolute;left:0;right:0;top:0;height:${Math.round(this.h * 0.13 * this.scale)}px;background:rgba(239,68,68,0.28);pointer-events:none;z-index:5;`;
        },
        get guideBottomStyle() {
            return `position:absolute;left:0;right:0;bottom:0;height:${Math.round(this.h * 0.2 * this.scale)}px;background:rgba(239,68,68,0.28);pointer-events:none;z-index:5;`;
        },

        get layerStyle() {
            if (this.layout === 'glass') {
                return `position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:${this.pad}px;box-sizing:border-box;`;
            }
            const dir = this.hasMedia && this.landscape ? 'row' : 'column';
            return `position:absolute;inset:0;display:flex;flex-direction:${dir};padding:${this.pad}px;gap:${this.hasMedia ? this.gap : 0}px;box-sizing:border-box;`;
        },
        get mediaBoxStyle() {
            const s = this.mediaSize;
            return `position:relative;flex:0 0 auto;width:${s.w}px;height:${s.h}px;order:${this.meta && this.meta.first ? 0 : 2};display:flex;align-items:center;justify-content:center;`;
        },
        get textWrapStyle() {
            if (this.layout === 'glass') {
                const p = Math.round(this.base * 0.06);
                const w = Math.round(this.w * (this.landscape ? 0.62 : 0.86));
                return `flex:0 1 auto;width:${w}px;max-width:100%;max-height:100%;display:flex;flex-direction:column;overflow:hidden;box-sizing:border-box;padding:${p}px;border-radius:${Math.round(this.base * 0.05)}px;background:rgba(255,255,255,0.14);border:2px solid rgba(255,255,255,0.35);box-shadow:0 30px 80px rgba(0,0,0,0.3);`;
            }
            let s = 'flex:1 1 0;min-width:0;min-height:0;display:flex;flex-direction:column;order:1;box-sizing:border-box;';
            if (this.layout === 'split') {
                const bg = this.isLightText ? 'rgba(0,0,0,0.28)' : 'rgba(255,255,255,0.35)';
                s += `padding:${this.textPad}px;background:${bg};`;
            }
            return s;
        },
        get mainStyle() {
            return `order:1;flex:1;min-height:0;display:flex;flex-direction:column;overflow:hidden;justify-content:${flex[this.vAlign]};align-items:${flex[this.align]};text-align:${this.align};`;
        },

        get splitShotStyle() {
            const s = this.mediaSize;
            return `width:${s.w}px;height:${s.h}px;${this.shot(s.w, s.h)}`;
        },

        get barH() { return Math.round(this.base * 0.06); },
        get browserStyle() {
            const s = this.mediaSize;
            return `width:${s.w}px;height:${s.h}px;border-radius:${Math.round(this.base * 0.025)}px;overflow:hidden;background:#fff;display:flex;flex-direction:column;box-shadow:0 30px 80px rgba(0,0,0,0.4);`;
        },
        get browserBarStyle() {
            const b = this.barH;
            return `flex:0 0 ${b}px;height:${b}px;display:flex;align-items:center;gap:${Math.round(b * 0.22)}px;padding:0 ${Math.round(b * 0.4)}px;background:#f1f3f5;border-bottom:1px solid #dee2e6;`;
        },
        get browserFillStyle() {
            const s = this.mediaSize;
            return `flex:1;min-height:0;width:100%;${this.shot(s.w, s.h - this.barH)}`;
        },
        dotStyle(color) {
            const d = Math.round(this.barH * 0.26);
            return `display:block;flex:0 0 ${d}px;width:${d}px;height:${d}px;border-radius:50%;background:${color};`;
        },
        get urlPillStyle() {
            const b = this.barH;
            const hh = Math.round(b * 0.62);
            return `display:block;flex:1;min-width:0;margin-left:${Math.round(b * 0.3)}px;height:${hh}px;line-height:${hh}px;padding:0 ${Math.round(b * 0.4)}px;border-radius:999px;background:#fff;border:1px solid #e5e7eb;color:#6b7280;font-size:${Math.round(b * 0.3)}px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;`;
        },
        get urlText() {
            return (this.linkText || this.domain || 'example.com').replace(/^https?:\/\//, '');
        },

        get phoneDims() {
            const s = this.mediaSize;
            let ph = Math.round(s.h * 0.98);
            let pw = Math.round(ph * 0.49);
            if (pw > s.w * 0.92) {
                pw = Math.round(s.w * 0.92);
                ph = Math.round(pw / 0.49);
            }
            return { pw, ph };
        },
        get phoneStyle() {
            const { pw, ph } = this.phoneDims;
            return `position:relative;flex:0 0 auto;width:${pw}px;height:${ph}px;border-radius:${Math.round(pw * 0.14)}px;background:#0b0b10;padding:${Math.round(pw * 0.035)}px;box-sizing:border-box;box-shadow:0 30px 70px rgba(0,0,0,0.45),inset 0 0 0 ${Math.max(2, Math.round(pw * 0.008))}px rgba(255,255,255,0.18);`;
        },
        get phoneScreenStyle() {
            const { pw, ph } = this.phoneDims;
            const iw = Math.round(pw * 0.93);
            const ih = Math.round(ph - pw * 0.07);
            return `width:100%;height:100%;border-radius:${Math.round(pw * 0.11)}px;overflow:hidden;${this.shot(iw, ih)}`;
        },
        get phoneNotchStyle() {
            const { pw } = this.phoneDims;
            return `position:absolute;top:${Math.round(pw * 0.05)}px;left:50%;width:${Math.round(pw * 0.28)}px;height:${Math.round(pw * 0.055)}px;margin-left:-${Math.round(pw * 0.14)}px;border-radius:999px;background:#0b0b10;`;
        },

        get cardStyle() {
            const s = this.mediaSize;
            const cw = Math.round(s.w * 0.9);
            const ch = Math.round(s.h * 0.9);
            const b = Math.max(4, Math.round(this.base * 0.012));
            return `flex:0 0 auto;width:${cw}px;height:${ch}px;border-radius:${Math.round(this.base * 0.045)}px;border:${b}px solid rgba(255,255,255,0.92);box-sizing:border-box;transform:rotate(-3deg);box-shadow:0 30px 70px rgba(0,0,0,0.4);${this.shot(cw - 2 * b, ch - 2 * b)}`;
        },

        get polaroidDims() {
            const s = this.mediaSize;
            let fw = Math.round(Math.min(s.w * 0.82, s.h * 0.82 * 0.84));
            let fh = Math.round(fw / 0.84);
            if (fh > s.h * 0.94) {
                fh = Math.round(s.h * 0.94);
                fw = Math.round(fh * 0.84);
            }
            return { fw, fh, p: Math.round(fw * 0.05), cap: Math.round(fw * 0.17) };
        },
        get polaroidStyle() {
            const { fw, fh, p } = this.polaroidDims;
            return `flex:0 0 auto;width:${fw}px;height:${fh}px;background:#fff;padding:${p}px;box-sizing:border-box;display:flex;flex-direction:column;transform:rotate(3deg);border-radius:${Math.round(this.base * 0.006)}px;box-shadow:0 30px 70px rgba(0,0,0,0.4);`;
        },
        get polaroidFillStyle() {
            const { fw, fh, p, cap } = this.polaroidDims;
            return `flex:1;min-height:0;width:100%;${this.shot(fw - 2 * p, fh - 2 * p - cap)}`;
        },
        get polaroidCaptionStyle() {
            const { cap } = this.polaroidDims;
            return `flex:0 0 ${cap}px;height:${cap}px;display:flex;align-items:center;justify-content:center;font-family:Georgia,'Times New Roman',serif;font-style:italic;font-size:${Math.round(cap * 0.42)}px;color:#374151;white-space:nowrap;overflow:hidden;`;
        },
        get polaroidCaption() {
            return this.badge || this.brand || '';
        },

        get shadowCss() {
            return this.shadow ? 'text-shadow:0 2px 24px rgba(0,0,0,0.3);' : '';
        },
        get badgeStyle() {
            const s = this.titleSize;
            return `display:inline-block;margin-bottom:${Math.round(s * 0.35)}px;padding:${Math.round(s * 0.12)}px ${Math.round(s * 0.3)}px;border-radius:999px;font-size:${Math.round(s * 0.26)}px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:${this.textColor};background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.4);`;
        },
        get titleStyle() {
            return `margin:0;max-width:100%;font-size:${this.titleSize}px;line-height:${this.lineH / 100};font-weight:${this.titleWeight};letter-spacing:${this.upper ? '0.02em' : '-0.02em'};${this.upper ? 'text-transform:uppercase;' : ''}color:${this.textColor};word-break:break-word;${this.shadowCss}`;
        },
        get subtitleStyle() {
            const s = this.titleSize;
            return `margin:${Math.round(s * 0.3)}px 0 0;max-width:100%;font-size:${Math.round(s * 0.4 * this.subScale / 100)}px;line-height:1.5;font-weight:500;color:${this.textColor};opacity:0.88;word-break:break-word;${this.shadowCss}`;
        },
        get ctaCss() {
            const s = this.titleSize;
            const fs = Math.round(s * 0.32);
            let bg, col, bd;
            if (this.ctaStyle === 'outline') {
                bg = 'transparent'; col = this.textColor; bd = `2px solid ${this.textColor}`;
            } else if (this.ctaStyle === 'glass') {
                bg = 'rgba(255,255,255,0.18)'; col = this.textColor; bd = '2px solid rgba(255,255,255,0.4)';
            } else {
                bg = this.ctaBg; col = lum(this.ctaBg) > 0.6 ? '#111827' : '#ffffff'; bd = `2px solid ${this.ctaBg}`;
            }
            return `display:inline-block;margin-top:${Math.round(s * 0.5)}px;padding:${Math.round(fs * 0.65)}px ${Math.round(fs * 1.5)}px;border-radius:999px;font-size:${fs}px;font-weight:700;line-height:1;background:${bg};color:${col};border:${bd};white-space:nowrap;`;
        },
        get footerStyle() {
            const dir = this.align === 'right' ? 'row-reverse' : 'row';
            const just = this.align === 'center' ? 'center' : 'space-between';
            const m = Math.round(this.titleSize * 0.55);
            return `flex-shrink:0;order:${this.brandTop ? 0 : 2};${this.brandTop ? `margin-bottom:${m}px;` : `margin-top:${m}px;`}display:flex;flex-direction:${dir};align-items:center;justify-content:${just};gap:${Math.round(this.titleSize * 0.5)}px;`;
        },
        get brandGroupStyle() {
            return `display:flex;align-items:center;gap:${Math.round(this.titleSize * 0.2)}px;`;
        },
        get logoH() { return Math.round(this.titleSize * 0.55 * this.logoScale / 100); },
        get logoStyle() {
            return `height:${this.logoH}px;width:auto;max-width:${Math.round(this.logoH * 4.4)}px;object-fit:contain;`;
        },
        get logoFallbackStyle() {
            const s = this.logoH;
            return `width:${s}px;height:${s}px;border-radius:${Math.round(s * 0.28)}px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:${Math.round(s * 0.55)}px;color:${this.textColor};background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.4);`;
        },
        get brandTextStyle() {
            return `font-size:${Math.round(this.titleSize * 0.3)}px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:${this.textColor};${this.shadowCss}`;
        },
        get linkStyle() {
            return `font-size:${Math.round(this.titleSize * 0.3)}px;font-weight:600;color:${this.textColor};opacity:0.85;${this.shadowCss}`;
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
            this.noticeTimer = setTimeout(() => { this.notice = null; }, type === 'error' ? 6000 : 2800);
        },

        // Turns any thrown value (including DOM Event objects) into readable text
        describeError(e) {
            if (!e) return 'unknown error';
            if (e.message) return e.message;
            if (e.type === 'error') return 'image failed to load while rendering (too large, blocked or invalid)';
            return String(e);
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

        // Downscales large images so the exported SVG stays within browser limits
        async shrink(src, max = 1600) {
            if (!src) return src;
            return await new Promise(resolve => {
                const img = new Image();
                img.onload = () => {
                    try {
                        const k = Math.min(1, max / Math.max(img.naturalWidth, img.naturalHeight));
                        if (k === 1 && src.length < 800000) return resolve(src);
                        const c = document.createElement('canvas');
                        c.width = Math.max(1, Math.round(img.naturalWidth * k));
                        c.height = Math.max(1, Math.round(img.naturalHeight * k));
                        c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
                        resolve(c.toDataURL('image/jpeg', 0.85));
                    } catch (e) {
                        resolve(src);
                    }
                };
                img.onerror = () => resolve(src);
                img.src = src;
            });
        },

        async selectPost(post) {
            this.selectedPostId = post.id;
            this.title = post.title || '';
            this.subtitle = post.excerpt || '';
            this.bgImage = post.image ? await this.shrink(await this.toDataUrl(post.image)) : '';
        },

        handleUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = async (e) => { this.bgImage = await this.shrink(e.target.result); };
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

        renderOptions(type) {
            let bg = '#111827';
            if (type === 'jpg') bg = '#ffffff';
            else if (this.radius > 0) bg = undefined;
            return {
                width: this.w,
                height: this.h,
                pixelRatio: this.exportScale,
                cacheBust: false,
                skipFonts: true,
                imagePlaceholder: EMPTY_IMAGE,
                backgroundColor: bg,
                style: { transform: 'none', top: '0', left: '0' }
            };
        },

        async renderBlob(type) {
            if (typeof htmlToImage === 'undefined') {
                throw new Error('html-to-image library did not load (CDN blocked, ad blocker or CSP)');
            }
            const mime = type === 'jpg' ? 'image/jpeg' : (type === 'webp' ? 'image/webp' : 'image/png');
            const { node, holder } = this.buildExportNode();
            try {
                const canvas = await htmlToImage.toCanvas(node, this.renderOptions(type));
                return await new Promise((resolve, reject) => {
                    canvas.toBlob(b => (b ? resolve(b) : reject(new Error('toBlob returned null'))), mime, this.jpgQuality / 100);
                });
            } catch (e) {
                console.error('[marketing] export failed', {
                    size: this.w + 'x' + this.h,
                    scale: this.exportScale,
                    layout: this.layout,
                    bgImageKB: Math.round((this.bgImage || '').length / 1024),
                    bgImageIsData: (this.bgImage || '').startsWith('data:'),
                    logoIsData: (this.logoData || '').startsWith('data:'),
                    htmlKB: Math.round(node.outerHTML.length / 1024)
                });
                throw e;
            } finally {
                holder.remove();
            }
        },

        // Builds a clean offscreen copy of the canvas for export.
        // Alpine attributes (:style, @click, x-*) and <template> tags are not valid XML,
        // so they break the SVG that html-to-image creates. Inline styles already hold all styling.
        buildExportNode() {
            const src = document.getElementById('post-canvas');
            const clone = src.cloneNode(true);

            clone.querySelectorAll('template').forEach(t => t.remove());

            [clone, ...clone.querySelectorAll('*')].forEach(el => {
                Array.from(el.attributes).forEach(a => {
                    const n = a.name;
                    if (n.startsWith(':') || n.startsWith('@') || n.startsWith('x-')) {
                        el.removeAttribute(n);
                    }
                });
            });

            clone.removeAttribute('id');
            clone.style.transform = 'none';
            clone.style.top = '0';
            clone.style.left = '0';

            const holder = document.createElement('div');
            holder.setAttribute('aria-hidden', 'true');
            holder.style.cssText = `position:fixed;left:-99999px;top:0;width:${this.w}px;height:${this.h}px;overflow:hidden;pointer-events:none;`;
            holder.appendChild(clone);
            document.body.appendChild(holder);

            return { node: clone, holder };
        },

        saveBlob(blob, name) {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = name;
            document.body.appendChild(a);
            a.click();
            a.remove();
            setTimeout(() => URL.revokeObjectURL(url), 2000);
        },

        async download() {
            if (this.busy) return;
            this.busy = true;
            try {
                const blob = await this.renderBlob(this.exportType);
                this.saveBlob(blob, `${this.slug()}-${this.w}x${this.h}.${this.ext}`);
            } catch (e) {
                console.error(e);
                this.notify(i18n.renderFailed + ': ' + this.describeError(e), 'error');
            } finally {
                this.busy = false;
            }
        },

        async downloadAll() {
            if (this.busy) return;
            if (typeof JSZip === 'undefined') {
                this.notify(i18n.zipMissing, 'error');
                return;
            }
            this.busy = true;
            const keep = this.formatId;
            try {
                const zip = new JSZip();
                for (const f of this.formats) {
                    this.formatId = f.id;
                    await this.$nextTick();
                    await new Promise(r => setTimeout(r, 250));
                    const blob = await this.renderBlob(this.exportType);
                    zip.file(`${this.slug()}-${f.label.replace(':', 'x')}-${f.w}x${f.h}.${this.ext}`, blob);
                }
                const out = await zip.generateAsync({ type: 'blob' });
                this.saveBlob(out, `${this.slug()}-all-sizes.zip`);
            } catch (e) {
                console.error(e);
                this.notify(i18n.renderFailed + ': ' + this.describeError(e), 'error');
            } finally {
                this.formatId = keep;
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
                const blob = await this.renderBlob('png');
                await navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })]);
                this.notify(i18n.copied);
            } catch (e) {
                console.error(e);
                this.notify(i18n.renderFailed + ': ' + this.describeError(e), 'error');
            } finally {
                this.busy = false;
            }
        }
    };
}
</script>
@endsection