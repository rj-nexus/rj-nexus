@extends('admin.layouts.app')

@section('title', __('Marketing Post Generator'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

<div class="w-full max-w-full space-y-6 pb-12" x-data="marketingTool(@js($siteLogo))">
    
    {{-- Yuxarı Başlıq və Düymələr --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-rj-purple" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                {{ __('Marketing Post Generator') }}
            </h1>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="button" @click="resetAll()" :disabled="downloading" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition disabled:opacity-50">
                {{ __('Reset') }}
            </button>

            <button type="button" @click="downloadImage()" :disabled="downloading" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-bold shadow-md hover:opacity-90 transition disabled:opacity-50">
                <svg x-show="!downloading" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span x-text="downloading ? '{{ __('Generating...') }}' : '{{ __('Download') }}'"></span>
            </button>
        </div>
    </div>

    {{-- ƏSAS LAYOUT: GRID SİSTEMİ İLƏ MƏCBURİ YAN-YANA --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start w-full min-w-0">
        
        {{-- SOL PANEL (4 Sütun) --}}
        <div class="lg:col-span-4 w-full min-w-0 space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-5">
                
                {{-- Yalnız Postlar Görünəcək --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('Select Post') }}</label>
                    <select @change="loadPostData($event)" x-model="selectedPostId" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple bg-gray-50 cursor-pointer">
                        <option value="">{{ __('-- Custom Text --') }}</option>
                        @foreach($posts as $post)
                            <option value="{{ $post->id }}" 
                                    data-title="{{ $post->title }}" 
                                    data-content="{{ Str::limit(strip_tags($post->content), 120) }}"
                                    data-image="{{ $post->featured_image ? (Str::startsWith($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image)) : '' }}">
                                {{ Str::limit($post->title, 45) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Şəkil Yükləmə --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('Custom Image (Optional)') }}</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:bg-gray-50 transition group">
                        <input type="file" accept="image/*" @change="handleImageUpload($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <span class="text-xs text-gray-600 font-semibold">{{ __('Upload Image') }}</span>
                    </div>
                    <button x-show="bgImage" @click="bgImage = ''" class="text-xs text-red-500 mt-2 hover:underline">
                        {{ __('Remove Uploaded Image') }}
                    </button>
                </div>

                <hr class="border-gray-100">

                {{-- Mətn --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Title') }}</label>
                        <input type="text" x-model="title" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Subtitle') }}</label>
                        <textarea x-model="subtitle" rows="2" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple"></textarea>
                    </div>
                </div>

                {{-- Rənglər --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Background Colors') }}</label>
                    <div class="flex gap-2">
                        <input type="color" x-model="color1" class="w-1/2 h-8 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                        <input type="color" x-model="color2" class="w-1/2 h-8 rounded cursor-pointer border border-gray-200 p-1 bg-white">
                    </div>
                </div>

            </div>
        </div>

        {{-- SAĞ PANEL (8 Sütun) --}}
        <div class="lg:col-span-8 w-full min-w-0 space-y-4">
            
            {{-- Ölçü Düymələri --}}
            <div class="flex flex-wrap items-center gap-2 bg-white p-2 rounded-xl border border-gray-200 w-fit shadow-sm">
                <span class="text-xs font-bold text-gray-500 uppercase px-2">{{ __('Size') }}:</span>
                <template x-for="ratio in ratios" :key="ratio.value">
                    <button type="button" @click="aspectRatio = ratio.value" 
                            :class="aspectRatio === ratio.value ? 'bg-rj-purple text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                        <span x-text="ratio.label"></span>
                    </button>
                </template>
            </div>

            {{-- Kətan Sahəsi --}}
            <div class="bg-gray-100 rounded-2xl border border-gray-200 p-4 sm:p-8 flex items-center justify-center overflow-hidden min-h-[600px] shadow-inner relative w-full">
                
                {{-- Loader --}}
                <div x-show="downloading" x-cloak class="absolute inset-0 z-50 bg-gray-100/80 backdrop-blur-sm flex items-center justify-center rounded-2xl">
                    <div class="text-gray-900 text-center">
                        <svg class="w-10 h-10 animate-spin mx-auto text-rj-purple mb-3" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                        <p class="font-bold text-lg">Generating Image...</p>
                    </div>
                </div>

                {{-- ŞƏKİL --}}
                <div id="post-canvas" 
                     class="relative overflow-hidden flex flex-col justify-end p-6 sm:p-10 shadow-2xl transition-all duration-300 ease-out bg-gray-900 rounded-xl"
                     :class="aspectRatio"
                     :style="`background: ${bgImage ? `url('${bgImage}') center/cover no-repeat` : `linear-gradient(135deg, ${color1}, ${color2})`}`">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent pointer-events-none"></div>

                    <div class="relative z-10 w-full">
                        <h2 class="text-white font-extrabold leading-tight mb-2 drop-shadow-lg" 
                            :class="aspectRatio === 'ratio-9-16' ? 'text-4xl' : 'text-2xl sm:text-4xl'"
                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"
                            x-text="title || 'Your Title Here'"></h2>
                        
                        <p class="text-white/80 font-medium leading-relaxed drop-shadow-md" 
                           :class="aspectRatio === 'ratio-9-16' ? 'text-lg' : 'text-sm sm:text-lg'"
                           style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                           x-text="subtitle || 'Your subtitle goes here.'"></p>
                        
                        <div class="mt-6 flex items-center gap-2">
                            <div class="h-8 px-2 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/30">
                                <template x-if="logoUrl">
                                    <img :src="logoUrl" alt="Logo" crossorigin="anonymous" class="h-4 object-contain">
                                </template>
                                <template x-if="!logoUrl">
                                    <span class="text-white font-bold text-xs">RJ</span>
                                </template>
                            </div>
                            <span class="text-white font-bold tracking-widest uppercase text-[10px] drop-shadow-md">RJ Nexus</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .ratio-1-1 { width: 100%; max-width: 500px; aspect-ratio: 1/1; }
    .ratio-4-3 { width: 100%; max-width: 533px; aspect-ratio: 4/3; }
    .ratio-16-9 { width: 100%; max-width: 700px; aspect-ratio: 16/9; }
    .ratio-4-5 { width: 100%; max-width: 480px; aspect-ratio: 4/5; }
    .ratio-9-16 { width: 100%; max-width: 380px; aspect-ratio: 9/16; }
</style>

<script>
function marketingTool(siteLogo) {
    return {
        selectedPostId: '',
        bgImage: '', 
        title: 'Create Stunning Posts',
        subtitle: 'Generate beautiful marketing graphics directly from your admin panel in seconds.',
        color1: '#a78bfa',
        color2: '#f472b6',
        aspectRatio: 'ratio-1-1',
        downloading: false,
        logoUrl: siteLogo,
        
        ratios: [
            { label: '1:1', value: 'ratio-1-1' },
            { label: '4:3', value: 'ratio-4-3' },
            { label: '16:9', value: 'ratio-16-9' },
            { label: '4:5', value: 'ratio-4-5' },
            { label: '9:16', value: 'ratio-9-16' }
        ],

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.bgImage = e.target.result; };
                reader.readAsDataURL(file);
            }
        },

        loadPostData(event) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                this.title = option.getAttribute('data-title');
                this.subtitle = option.getAttribute('data-content');
                const postImage = option.getAttribute('data-image');
                this.bgImage = postImage ? postImage : '';
            } else {
                this.resetAll();
            }
        },

        resetAll() {
            this.selectedPostId = '';
            this.bgImage = '';
            this.title = 'Create Stunning Posts';
            this.subtitle = 'Generate beautiful marketing graphics directly from your admin panel in seconds.';
            this.color1 = '#a78bfa';
            this.color2 = '#f472b6';
            this.aspectRatio = 'ratio-1-1';
        },

        async downloadImage() {
            this.downloading = true;
            const node = document.getElementById('post-canvas');
            try {
                const dataUrl = await htmlToImage.toPng(node, { quality: 1, pixelRatio: 2, cacheBust: true });
                const link = document.createElement('a');
                link.download = `rj-post-${Date.now()}.png`;
                link.href = dataUrl;
                link.click();
            } catch (error) {
                console.error('Error:', error);
                alert('Şəkil yüklənərkən xəta baş verdi.');
            } finally {
                this.downloading = false;
            }
        }
    }
}
</script>
@endsection