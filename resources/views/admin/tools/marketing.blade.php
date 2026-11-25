@extends('admin.layouts.app')

@section('title', __('Marketing Post Generator'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

<div class="max-w-7xl mx-auto space-y-6 pb-12" x-data="marketingTool(@js($siteLogo))">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Marketing Post Generator') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Create beautiful social media posts for your brand.') }}</p>
        </div>
        <button type="button" @click="downloadImage()" :disabled="downloading" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-bold shadow-md hover:opacity-90 transition disabled:opacity-50">
            <svg x-show="!downloading" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <svg x-show="downloading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
            <span x-text="downloading ? '{{ __('Generating...') }}' : '{{ __('Download Image') }}'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Nizamlama Paneli (Controls) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-5">
                
                <!-- Aspect Ratio -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Format / Aspect Ratio') }}</label>
                    <div class="grid grid-cols-3 gap-2">
                        <template x-for="ratio in ratios" :key="ratio.value">
                            <button type="button" @click="aspectRatio = ratio.value" 
                                    :class="aspectRatio === ratio.value ? 'border-rj-purple bg-rj-purple/5 text-rj-purple font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                                    class="border-2 rounded-lg py-2 text-xs transition flex flex-col items-center justify-center gap-1">
                                <div :class="ratio.class" class="border border-current rounded-sm opacity-50"></div>
                                <span x-text="ratio.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Post Seçimi (Şəkillə birlikdə) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Select Post') }}</label>
                    <select @change="loadPostData($event)" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
                        <option value="">{{ __('-- Custom Text --') }}</option>
                        @foreach($posts as $post)
                            <option value="{{ $post->id }}" 
                                    data-title="{{ $post->title }}" 
                                    data-content="{{ Str::limit(strip_tags($post->content), 100) }}"
                                    data-image="{{ $post->featured_image ? (Str::startsWith($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image)) : '' }}">
                                {{ Str::limit($post->title, 50) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Şəkil Yükləmə (YENİ) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Background Image') }}</label>
                    <input type="file" accept="image/*" @change="handleImageUpload($event)" 
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rj-purple/10 file:text-rj-purple hover:file:bg-rj-purple/20 transition">
                    <p class="text-xs text-gray-500 mt-1">{{ __('Upload a high-quality image.') }}</p>
                    <button x-show="bgImage" @click="bgImage = ''" class="text-xs text-red-500 mt-2 hover:underline">{{ __('Remove Image') }}</button>
                </div>

                <!-- Text Content -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Title') }}</label>
                    <input type="text" x-model="title" placeholder="e.g. Summer Sale" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple font-bold">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Subtitle / Description') }}</label>
                    <textarea x-model="subtitle" rows="3" placeholder="e.g. Get 50% off on all items" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple"></textarea>
                </div>

                <!-- Colors -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">{{ __('Theme Color 1') }}</label>
                        <input type="color" x-model="color1" class="w-full h-10 rounded-lg cursor-pointer border-0 p-1">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">{{ __('Theme Color 2') }}</label>
                        <input type="color" x-model="color2" class="w-full h-10 rounded-lg cursor-pointer border-0 p-1">
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Önizləmə (Preview) -->
        <div class="lg:col-span-2 flex items-center justify-center bg-gray-100 rounded-2xl border border-gray-200 p-8 overflow-hidden relative" style="min-height: 600px;">
            
            <!-- Yüklənəcək Sahə (Canvas) -->
            <div id="post-canvas" 
                 class="relative overflow-hidden flex flex-col justify-end p-10 shadow-2xl transition-all duration-300"
                 :class="aspectRatio"
                 :style="`background: ${bgImage ? `url('${bgImage}') center/cover no-repeat` : `linear-gradient(135deg, ${color1}, ${color2})`}`">
                
                <!-- Qaralma effekti -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pointer-events-none"></div>

                <!-- Məzmun -->
                <div class="relative z-10 w-full">
                    <h2 class="text-white font-extrabold leading-tight mb-4" 
                        :class="aspectRatio === 'ratio-9-16' ? 'text-5xl' : 'text-4xl'"
                        x-text="title || 'Your Title Here'"></h2>
                    
                    <p class="text-white/80 font-medium leading-relaxed" 
                       :class="aspectRatio === 'ratio-9-16' ? 'text-xl' : 'text-lg'"
                       x-text="subtitle || 'Your subtitle or description goes here.'"></p>
                    
                    <!-- Dinamik Sayt Loqosu (YENİ) -->
                    <div class="mt-8 flex items-center gap-3">
                        <div x-show="logoUrl" class="h-10 px-3 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30 shadow-sm">
                            <img :src="logoUrl" alt="Logo" class="h-6 object-contain">
                        </div>
                        <div x-show="!logoUrl" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white font-bold border border-white/30">
                            RJ
                        </div>
                        <span class="text-white font-bold tracking-widest uppercase text-sm">RJ Nexus</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Aspect Ratio Class-ları */
    .ratio-1-1 { width: 500px; height: 500px; }
    .ratio-4-3 { width: 533px; height: 400px; }
    .ratio-16-9 { width: 600px; height: 337px; }
    .ratio-4-5 { width: 480px; height: 600px; }
    .ratio-9-16 { width: 337px; height: 600px; }
    
    @media (max-width: 1024px) {
        .ratio-1-1 { width: 100%; aspect-ratio: 1/1; height: auto; }
        .ratio-4-3 { width: 100%; aspect-ratio: 4/3; height: auto; }
        .ratio-16-9 { width: 100%; aspect-ratio: 16/9; height: auto; }
        .ratio-4-5 { width: 100%; aspect-ratio: 4/5; height: auto; }
        .ratio-9-16 { width: 100%; aspect-ratio: 9/16; height: auto; }
    }
</style>

<script>
function marketingTool(siteLogo) {
    return {
        bgImage: '', // Default olaraq boşdur, gradient işləyəcək
        title: 'Create Stunning Posts',
        subtitle: 'Generate beautiful marketing graphics directly from your admin panel in seconds.',
        color1: '#a78bfa',
        color2: '#f472b6',
        aspectRatio: 'ratio-1-1',
        downloading: false,
        logoUrl: siteLogo, // Bazadan gələn loqo
        ratios: [
            { label: '1:1', value: 'ratio-1-1', class: 'w-6 h-6' },
            { label: '4:3', value: 'ratio-4-3', class: 'w-7 h-5' },
            { label: '16:9', value: 'ratio-16-9', class: 'w-8 h-4' },
            { label: '4:5', value: 'ratio-4-5', class: 'w-5 h-6' },
            { label: '9:16', value: 'ratio-9-16', class: 'w-4 h-7' }
        ],

        // Şəkil yükləmə funksiyası
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.bgImage = e.target.result; // Base64 string kimi arxa plana veririk
                };
                reader.readAsDataURL(file);
            }
        },

        // Məqalə seçildikdə başlıq və mətni dolduran funksiya
        loadPostData(event) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                this.title = option.getAttribute('data-title');
                this.subtitle = option.getAttribute('data-content');
                // Yazı seçildikdə default rəngləri dəyişə bilərsiniz (istəyə bağlı)
            } else {
                this.title = 'Create Stunning Posts';
                this.subtitle = 'Generate beautiful marketing graphics directly from your admin panel in seconds.';
            }
        },

        async downloadImage() {
            this.downloading = true;
            const node = document.getElementById('post-canvas');
            
            try {
                // HTML-i şəklə çeviririk
                const dataUrl = await htmlToImage.toPng(node, { 
                    quality: 1.0,
                    pixelRatio: 2 // Yüksək keyfiyyət (Retina)
                });
                
                // Yükləmə linki yaradırıq
                const link = document.createElement('a');
                link.download = `rj-marketing-post-${Date.now()}.png`;
                link.href = dataUrl;
                link.click();
            } catch (error) {
                console.error('Error generating image:', error);
                alert('Failed to generate image. Please try again.');
            } finally {
                this.downloading = false;
            }
        }
    }
}
</script>
@endsection