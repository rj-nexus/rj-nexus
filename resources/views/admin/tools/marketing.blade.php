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
                                    <span class="mk-post-title" x-text="p.title"></span>
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
                        <label class="mk-label">{{ __('Background image') }}</label>
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

                    <div class="mk-field">
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
    #mk-root .mk-tabs { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 4px; padding: 4px; background: #f3f4f6; border-radius: 12px; }
    #mk-root .mk-tab {
        padding: 8px 4px; border: 0; border-radius: 8px; background: transparent; cursor: pointer;
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

    #mk-root .mk-posts { margin-top: 8px; max-height: 210px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px; padding-right: 2px; }
    #mk-root .mk-post {
        display: flex; align-items: center; gap: 10px; width: 100%; text-align: left; cursor: pointer;
        padding: 8px; background: #fff; border: 1px solid var(--mk-border); border-radius: 12px; transition: .15s;
    }
    #mk-root .mk-post:hover { background: #f9fafb; }
    #mk-root .mk-post.is-on { border-color: var(--mk-accent); background: #f5f3ff; }
    #mk-root .mk-thumb { flex: 0 0 40px; width: 40px; height: 40px; border-radius: 8px; background: #f3f4f6; overflow: hidden; }
    #mk-root .mk-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    #mk-root .mk-post-title {
        font-size: 13px; font-weight: 600; color: #1f2937; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    #mk-root .mk-empty { margin: 0; padding: 12px 0; text-align: center; font-size: 12px; color: var(--mk-muted); }

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