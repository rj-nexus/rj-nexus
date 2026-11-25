@extends('admin.layouts.app')

@section('title', __('Marketing Post Generator'))

@section('content')
{{-- Şəkli PNG-yə çevirmək üçün kitabxana --}}
<script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>

<div class="max-w-[1600px] mx-auto space-y-6 pb-12" x-data="marketingTool(@js($siteLogo))">
    
    {{-- Yuxarı Başlıq və Düymələr --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-rj-purple" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                {{ __('Marketing Post Generator') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Create beautiful social media graphics directly from your posts.') }}</p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- Sıfırlama Düyməsi --}}
            <button type="button" @click="resetAll()" :disabled="downloading" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition shadow-sm disabled:opacity-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                {{ __('Reset') }}
            </button>

            {{-- Yükləmə Düyməsi --}}
            <button type="button" @click="downloadImage()" :disabled="downloading" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-bold shadow-md hover:opacity-90 transition disabled:opacity-50">
                <svg x-show="!downloading" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <svg x-show="downloading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                <span x-text="downloading ? '{{ __('Generating...') }}' : '{{ __('Download Image') }}'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- SOL PANEL (İdarəetmə) --}}
        <div class="lg:col-span-4 xl:col-span-3 space-y-6 lg:sticky lg:top-24 h-fit">
            
            {{-- Məqalə Seçimi və Şəkil Yükləmə --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-6">
                
                {{-- Post Seçimi --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('1. Select a Post') }}</label>
                    <select @change="loadPostData($event)" x-model="selectedPostId" class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple bg-gray-50">
                        <option value="">{{ __('-- Custom Text (No Post) --') }}</option>
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

                <hr class="border-gray-100">

                {{-- Şəkil Yükləmə (Drag & Drop) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('2. Background Image') }}</label>
                    
                    <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:bg-gray-50 transition group">
                        <input type="file" accept="image/*" @change="handleImageUpload($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-rj-purple transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-gray-500 font-medium">{{ __('Click or drag image here') }}</span>
                        <span class="block text-[10px] text-gray-400 mt-1">{{ __('Overrides post image') }}</span>
                    </div>
                    
                    <button x-show="bgImage" @click="bgImage = ''" class="text-xs text-red-500 mt-2 hover:underline flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Remove Image') }}
                    </button>
                </div>

                <hr class="border-gray-100">

                {{-- Mətn Sahələri --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('3. Text Content') }}</label>
                        <input type="text" x-model="title" placeholder="Title..." class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple font-bold">
                    </div>
                    <div>
                        <textarea x-model="subtitle" rows="3" placeholder="Subtitle..." class="w-full rounded-xl border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple"></textarea>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Rənglər (Gradient üçün) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">{{ __('Gradient Colors') }}</label>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input type="color" x-model="color1" class="w-full h-10 rounded-lg cursor-pointer border border-gray-200 p-1">
                        </div>
                        <div class="flex-1">
                            <input type="color" x-model="color2" class="w-full h-10 rounded-lg cursor-pointer border border-gray-200 p-1">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- SAĞ PANEL (Önizləmə) --}}
        <div class="lg:col-span-8 xl:col-span-9">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-4 sm:p-8 flex items-center justify-center overflow-auto min-h-[700px] shadow-inner relative">
                
                {{-- Yükləmə zamanı loader --}}
                <div x-show="downloading" x-cloak class="absolute inset-0 z-50 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center rounded-2xl">
                    <div class="text-white text-center">
                        <svg class="w-10 h-10 animate-spin mx-auto text-rj-pink mb-3" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                        <p class="font-bold text-lg">Generating Image...</p>
                    </div>
                </div>

                {{-- Aspect Ratio Seçimi (Önizləmənin üstündə) --}}
                <div class="absolute top-4 left-4 right-4 z-20 flex justify-center gap-2 bg-black/40 backdrop-blur-md p-2 rounded-2xl border border-white/10 w-fit mx-auto">
                    <template x-for="ratio in ratios" :key="ratio.value">
                        <button type="button" @click="aspectRatio = ratio.value" 
                                :class="aspectRatio === ratio.value ? 'bg-rj-purple text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/10'"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                            <div :class="ratio.class" class="border border-current rounded-sm opacity-70"></div>
                            <span x-text="ratio.label"></span>
                        </button>
                    </template>
                </div>

                {{-- ŞƏKİL YARADILACAQ SAHƏ (CANVAS) --}}
                <div id="post-canvas" 
                     class="relative overflow-hidden flex flex-col justify-end p-8 sm:p-12 shadow-2xl transition-all duration-500 ease-out"
                     :class="aspectRatio"
                     :style="`background: ${bgImage ? `url('${bgImage}') center/cover no-repeat` : `linear-gradient(135deg, ${color1}, ${color2})`}`">
                    
                    {{-- Qaralma effekti (yazılar oxunsun deyə) --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>
                    <div class="absolute inset-0 bg-black/10 pointer-events-none"></div>

                    {{-- Məzmun --}}
                    <div class="relative z-10 w-full">
                        
                        {{-- Başlıq (Çox uzun olsa 3 sətrə qədər kəsilir) --}}
                        <h2 class="text-white font-extrabold leading-tight mb-3 drop-shadow-lg" 
                            :class="aspectRatio === 'ratio-9-16' ? 'text-4xl sm:text-5xl' : 'text-3xl sm:text-4xl'"
                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"
                            x-text="title || 'Your Title Here'"></h2>
                        
                        {{-- Alt Mətn (2 sətrə qədər) --}}
                        <p class="text-white/80 font-medium leading-relaxed drop-shadow-md" 
                           :class="aspectRatio === 'ratio-9-16' ? 'text-lg sm:text-xl' : 'text-base sm:text-lg'"
                           style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                           x-text="subtitle || 'Your subtitle or description goes here.'"></p>
                        
                        {{-- Logo və Brend --}}
                        <div class="mt-8 flex items-center gap-3">
                            <div class="h-10 px-3 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30 shadow-sm">
                                <template x-if="logoUrl">
                                    <img :src="logoUrl" alt="Logo" crossorigin="anonymous" class="h-6 object-contain">
                                </template>
                                <template x-if="!logoUrl">
                                    <span class="text-white font-bold text-lg">RJ</span>
                                </template>
                            </div>
                            <span class="text-white font-bold tracking-widest uppercase text-sm drop-shadow-md">RJ Nexus</span>
                        </div>
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
    
    /* Mobil ekranlar üçün responsiv */
    @media (max-width: 1024px) {
        .ratio-1-1 { width: 100%; max-width: 500px; aspect-ratio: 1/1; height: auto; }
        .ratio-4-3 { width: 100%; max-width: 533px; aspect-ratio: 4/3; height: auto; }
        .ratio-16-9 { width: 100%; max-width: 600px; aspect-ratio: 16/9; height: auto; }
        .ratio-4-5 { width: 100%; max-width: 480px; aspect-ratio: 4/5; height: auto; }
        .ratio-9-16 { width: 100%; max-width: 337px; aspect-ratio: 9/16; height: auto; }
    }
</style>

<script>
function marketingTool(siteLogo) {
    return {
        // Vəziyyətlər (State)
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
            { label: '1:1', value: 'ratio-1-1', class: 'w-5 h-5' },
            { label: '4:3', value: 'ratio-4-3', class: 'w-6 h-4' },
            { label: '16:9', value: 'ratio-16-9', class: 'w-7 h-3' },
            { label: '4:5', value: 'ratio-4-5', class: 'w-4 h-5' },
            { label: '9:16', value: 'ratio-9-16', class: 'w-3 h-6' }
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

        // Məqalə seçildikdə məlumatları dolduran funksiya
        loadPostData(event) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                this.title = option.getAttribute('data-title');
                this.subtitle = option.getAttribute('data-content');
                
                // Şəkli postdan çəkirik (əgər varsa)
                const postImage = option.getAttribute('data-image');
                if (postImage) {
                    this.bgImage = postImage;
                } else {
                    this.bgImage = ''; // Postun şəkli yoxdursa gradient qalsın
                }
            } else {
                this.resetAll(); // Custom seçilibsə hər şeyi sıfırla
            }
        },

        // Hər şeyi ilk vəziyyətə qaytaran funksiya
        resetAll() {
            this.selectedPostId = '';
            this.bgImage = '';
            this.title = 'Create Stunning Posts';
            this.subtitle = 'Generate beautiful marketing graphics directly from your admin panel in seconds.';
            this.color1 = '#a78bfa';
            this.color2 = '#f472b6';
            this.aspectRatio = 'ratio-1-1';
        },

        // Şəkli PNG kimi yükləyən funksiya
        async downloadImage() {
            this.downloading = true;
            const node = document.getElementById('post-canvas');
            
            try {
                // HTML-i şəklə çeviririk
                const dataUrl = await htmlToImage.toPng(node, { 
                    quality: 1.0,
                    pixelRatio: 2, // Yüksək keyfiyyət (Retina)
                    cacheBust: true // Xarici şəkillərin keshini yeniləyir ki, xəta verməsin
                });
                
                // Yükləmə linki yaradırıq
                const link = document.createElement('a');
                link.download = `rj-post-${Date.now()}.png`;
                link.href = dataUrl;
                link.click();
            } catch (error) {
                console.error('Error generating image:', error);
                alert('Failed to generate image. Ensure the background image allows CORS.');
            } finally {
                this.downloading = false;
            }
        }
    }
}
</script>
@endsection