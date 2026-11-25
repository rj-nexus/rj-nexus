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
            'tabContent' => __('Content'),
            'tabLayout' => __('Layout'),
            'tabBackground' => __('Background'),
            'tabText' => __('Text'),
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
        ],
    ];
@endphp

<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

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
            <button type="button" class="mk-btn" @click="download('jpeg')" :disabled="busy">JPG</button>
            <button type="button" class="mk-btn mk-btn-primary" @click="download('png')" :disabled="busy">
                <svg x-show="!busy" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <svg x-show="busy" class="mk-spin" width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                <span x-text="busy ? '{{ __('Generating...') }}' : '{{ __('Download PNG') }}'"></span>
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
                </div>

                <div x-show="tab === 'layout'">
                    <div class="mk-layouts">
                        <template x-for="l in layouts" :key="l.id">
                            <button type="button" class="mk-lay" :class="{ 'is-on': layout === l.id }" @click="setLayout(l.id)">
                                <svg viewBox="0 0 48 48" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.6" x-html="l.svg"></svg>
                                <span x-text="l.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="tab === 'background'">
                    <div class="mk-field">
                        <label class="mk-label">{{ __('Gradient presets') }}</label>
                        <div class="mk-gradients">
                            <template x-for="g in gradients" :key="g[0] + g[1]">
                                <button type="button" class="mk-grad" :class="{ 'is-on': color1 === g[0] && color2 === g[1] }"
                                        :style="`background: linear-gradient(135deg, ${g[0]}, ${g[1]})`"
                                        @click="color1 = g[0]; color2 = g[1]"></button>
                            </template>
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

                    <div class="mk-field">
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
                        <button type="button" class="mk-link-danger" x-show="bgImage" @click="bgImage = ''">{{ __('Remove image') }}</button>
                    </div>

                    <div class="mk-field" x-show="bgImage">
                        <label class="mk-label">{{ __('Image focus') }}</label>
                        <div class="mk-seg">
                            <template x-for="o in imagePosOptions" :key="o.value">
                                <button type="button" :class="{ 'is-on': imagePos === o.value }" @click="imagePos = o.value" x-text="o.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="mk-field" x-show="showFullImage">
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
                        <div class="mk-row">
                            <label class="mk-label">{{ __('Text size') }}</label>
                            <span class="mk-val" x-text="textScale + '%'"></span>
                        </div>
                        <input type="range" class="mk-range" min="60" max="150" step="5" x-model.number="textScale">
                    </div>

                    <div class="mk-field">
                        <label class="mk-label">{{ __('Text color') }}</label>
                        <div class="mk-swatches">
                            <input type="color" class="mk-color mk-color-sm" x-model="textColor">
                            <button type="button" class="mk-swatch" style="background:#ffffff" @click="textColor = '#ffffff'"></button>
                            <button type="button" class="mk-swatch" style="background:#111827" @click="textColor = '#111827'"></button>
                        </div>
                    </div>

                    <hr class="mk-hr">

                    <label class="mk-check">
                        <span>{{ __('Show logo and brand') }}</span>
                        <input type="checkbox" x-model="showBrand">
                    </label>

                    <div x-show="showBrand">
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

            </div>
        </aside>

        <section class="mk-main">

            <div class="mk-toolbar">
                <div class="mk-formats">
                    <template x-for="f in formats" :key="f.id">
                        <button type="button" class="mk-fmt" :class="{ 'is-on': formatId === f.id }" @click="formatId = f.id" x-text="f.label"></button>
                    </template>
                </div>
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

                <div class="mk-frame" :style="`width:${w * scale}px;height:${h * scale}px`">
                    <div id="post-canvas" :style="canvasStyle">
                        <div :style="gradientStyle"></div>

                        <template x-if="showFullImage && bgImage"><div :style="imageStyle"></div></template>
                        <template x-if="showFullImage"><div :style="overlayStyle"></div></template>

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
                                            <div :style="shotFillStyle"></div>
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
                                            <div :style="shotFillStyle"></div>
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
                                </div>

                                <template x-if="showBrand">
                                    <div :style="footerStyle">
                                        <div :style="brandGroupStyle">
                                            <template x-if="logoData"><img :src="logoData" alt="" :style="logoStyle"></template>
                                            <template x-if="!logoData"><span :style="logoFallbackStyle" x-text="(brand || 'R').charAt(0).toUpperCase()"></span></template>
                                            <span :style="brandTextStyle" x-text="brand"></span>
                                        </div>
                                        <template x-if="linkText"><span :style="linkStyle" x-text="linkText"></span></template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
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

    #mk-root .mk-layout {
        display: grid; grid-template-columns: minmax(0, 1fr); gap: 24px; align-items: start; width: 100%;
    }
    @media (min-width: 1024px) {
        #mk-root .mk-layout { grid-template-columns: 360px minmax(0, 1fr); }
        #mk-root .mk-panel { position: sticky; top: 16px; }
        #mk-root .mk-scroll { max-height: calc(100vh - 220px); overflow-y: auto; }
    }

    #mk-root .mk-panel {
        background: #fff; border: 1px solid var(--mk-border); border-radius: 16px;
        overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,.04); min-width: 0;
    }
    #mk-root .mk-tabs-wrap { padding: 12px; border-bottom: 1px solid #f3f4f6; }
    #mk-root .mk-tabs { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 4px; padding: 4px; background: #f3f4f6; border-radius: 12px; }
    #mk-root .mk-tab {
        padding: 8px 2px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
        font-size: 12px; font-weight: 700; color: var(--mk-muted); transition: .15s;
    }
    #mk-root .mk-tab:hover { color: var(--mk-text); }
    #mk-root .mk-tab.is-on { background: #fff; color: var(--mk-text); box-shadow: 0 1px 3px rgba(0,0,0,.12); }

    #mk-root .mk-scroll { padding: 20px; }
    #mk-root .mk-field { margin-bottom: 18px; }
    #mk-root .mk-label { display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700; color: #374151; }
    #mk-root .mk-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
    #mk-root .mk-row .mk-label { margin: 0; }
    #mk-root .mk-val { font-size: 12px; color: var(--mk-muted); font-weight: 600; }
    #mk-root .mk-hr { border: 0; border-top: 1px solid #f3f4f6; margin: 18px 0; }

    #mk-root .mk-input {
        display: block; width: 100%; padding: 9px 12px; font-size: 14px; font-family: inherit;
        background: #fff; color: var(--mk-text); border: 1px solid #d1d5db; border-radius: 12px; outline: none; resize: vertical;
    }
    #mk-root .mk-input:focus { border-color: var(--mk-accent); box-shadow: 0 0 0 3px rgba(124,58,237,.15); }
    #mk-root .mk-bold { font-weight: 700; }

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
    #mk-root .mk-seg button {
        padding: 7px 4px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
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
    #mk-root .mk-link-danger { margin-top: 8px; padding: 0; background: none; border: 0; color: #ef4444; font-size: 12px; cursor: pointer; }
    #mk-root .mk-link-danger:hover { text-decoration: underline; }

    #mk-root .mk-check { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; font-size: 12px; font-weight: 700; color: #374151; cursor: pointer; }
    #mk-root .mk-check input { width: 16px; height: 16px; accent-color: var(--mk-accent); }

    #mk-root .mk-main { min-width: 0; width: 100%; }
    #mk-root .mk-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    #mk-root .mk-formats { display: flex; flex-wrap: wrap; gap: 6px; padding: 6px; background: #fff; border: 1px solid var(--mk-border); border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    #mk-root .mk-fmt {
        padding: 7px 14px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
        font-size: 12px; font-weight: 700; color: #4b5563; transition: .15s;
    }
    #mk-root .mk-fmt:hover { background: #f3f4f6; }
    #mk-root .mk-fmt.is-on { background: var(--mk-accent); color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.2); }
    #mk-root .mk-size { font-size: 12px; font-weight: 600; color: var(--mk-muted); }

    #mk-root .mk-stage {
        position: relative; display: flex; align-items: center; justify-content: center;
        width: 100%; padding: 24px; overflow: hidden;
        background: #f3f4f6; border: 1px solid var(--mk-border); border-radius: 16px;
        box-shadow: inset 0 2px 6px rgba(0,0,0,.05);
    }
    #mk-root .mk-frame { position: relative; flex: 0 0 auto; overflow: hidden; border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,.25); outline: 1px solid rgba(0,0,0,.1); }

    #mk-root .mk-loader { position: absolute; inset: 0; z-index: 30; display: flex; align-items: center; justify-content: center; background: rgba(243,244,246,.85); backdrop-filter: blur(4px); text-align: center; color: var(--mk-text); }
    #mk-root .mk-loader svg { color: var(--mk-accent); margin: 0 auto 8px; display: block; }
    #mk-root .mk-loader p { margin: 0; font-size: 14px; font-weight: 700; }
    #mk-root .mk-toast { position: absolute; top: 12px; right: 12px; z-index: 40; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #fff; background: #111827; box-shadow: 0 8px 20px rgba(0,0,0,.25); }
    #mk-root .mk-toast.is-error { background: #dc2626; }

    #mk-root .mk-spin { animation: mk-spin 1s linear infinite; }
    @keyframes mk-spin { to { transform: rotate(360deg); } }
</style>

<script>
function marketingTool(config) {
    const i18n = config.i18n;

    const defaults = {
        selectedPostId: null,
        search: '',
        layout: 'cover',
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
        busy: false,
        notice: null,
        scale: 0.4,
        stageH: 520,
        noticeTimer: null,

        tabs: [
            { id: 'content', label: i18n.tabContent },
            { id: 'layout', label: i18n.tabLayout },
            { id: 'background', label: i18n.tabBackground },
            { id: 'text', label: i18n.tabText }
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

        setLayout(id) {
            this.layout = id;
            this.vAlign = id === 'cover' ? 'end' : 'center';
        },

        get format() { return this.formats.find(f => f.id === this.formatId) || this.formats[0]; },
        get w() { return this.format.w; },
        get h() { return this.format.h; },
        get base() { return Math.min(this.w, this.h); },
        get landscape() { return this.w > this.h; },
        get meta() { return mediaMeta[this.layout] || null; },
        get hasMedia() { return !!this.meta; },
        get showFullImage() { return this.layout === 'cover' || this.layout === 'glass'; },
        get pad() { return this.layout === 'split' ? 0 : Math.round(this.base * 0.07); },
        get textPad() { return Math.round(this.base * 0.07); },
        get gap() { return this.layout === 'split' ? 0 : Math.round(this.base * 0.04); },
        get layoutFactor() { return this.hasMedia ? (this.landscape ? 0.68 : 0.86) : 1; },
        get titleSize() { return Math.round(this.base * 0.078 * (this.textScale / 100) * this.layoutFactor); },

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

        get shotBg() {
            if (this.bgImage) {
                return `background-image:url('${this.bgImage}');background-size:cover;background-position:center ${this.imagePos};background-repeat:no-repeat;`;
            }
            return 'background:linear-gradient(135deg,rgba(255,255,255,0.4),rgba(255,255,255,0.12));';
        },

        get canvasStyle() {
            return `position:absolute;top:0;left:0;width:${this.w}px;height:${this.h}px;transform:scale(${this.scale});transform-origin:top left;overflow:hidden;background:#111827;font-family:${fontStacks[this.font]};`;
        },
        get gradientStyle() {
            return `position:absolute;inset:0;background:linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2});`;
        },
        get imageStyle() {
            const blur = this.layout === 'glass'
                ? `filter:blur(${Math.round(this.base * 0.02)}px);transform:scale(1.12);`
                : '';
            return `position:absolute;inset:0;background-image:url('${this.bgImage}');background-size:cover;background-repeat:no-repeat;background-position:center ${this.imagePos};${blur}`;
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
                s += `padding:${this.textPad}px;background:rgba(0,0,0,0.28);`;
            }
            return s;
        },
        get mainStyle() {
            return `flex:1;min-height:0;display:flex;flex-direction:column;overflow:hidden;justify-content:${flex[this.vAlign]};align-items:${flex[this.align]};text-align:${this.align};`;
        },

        get splitShotStyle() {
            const s = this.mediaSize;
            return `width:${s.w}px;height:${s.h}px;${this.shotBg}`;
        },
        get shotFillStyle() {
            return `flex:1;min-height:0;width:100%;${this.shotBg}`;
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
            const t = (this.linkText || this.domain || 'example.com').replace(/^https?:\/\//, '');
            return t;
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
            const { pw } = this.phoneDims;
            return `width:100%;height:100%;border-radius:${Math.round(pw * 0.11)}px;overflow:hidden;${this.shotBg}`;
        },
        get phoneNotchStyle() {
            const { pw } = this.phoneDims;
            return `position:absolute;top:${Math.round(pw * 0.05)}px;left:50%;width:${Math.round(pw * 0.28)}px;height:${Math.round(pw * 0.055)}px;margin-left:-${Math.round(pw * 0.14)}px;border-radius:999px;background:#0b0b10;`;
        },

        get cardStyle() {
            const s = this.mediaSize;
            return `flex:0 0 auto;width:${Math.round(s.w * 0.9)}px;height:${Math.round(s.h * 0.9)}px;border-radius:${Math.round(this.base * 0.045)}px;border:${Math.max(4, Math.round(this.base * 0.012))}px solid rgba(255,255,255,0.92);box-sizing:border-box;transform:rotate(-3deg);box-shadow:0 30px 70px rgba(0,0,0,0.4);${this.shotBg}`;
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
        get polaroidCaptionStyle() {
            const { cap } = this.polaroidDims;
            return `flex:0 0 ${cap}px;height:${cap}px;display:flex;align-items:center;justify-content:center;font-family:Georgia,'Times New Roman',serif;font-style:italic;font-size:${Math.round(cap * 0.42)}px;color:#374151;white-space:nowrap;overflow:hidden;`;
        },
        get polaroidCaption() {
            return this.badge || this.brand || '';
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
            this.title = post.title || '';
            this.subtitle = post.excerpt || '';
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