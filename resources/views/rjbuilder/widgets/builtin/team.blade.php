@php
    $columns = $settings['columns'] ?? '3';
    $style = $settings['style'] ?? 'light';

    $isDark = $style === 'dark';
    $cardBg = $isDark ? 'bg-slate-900 border-slate-800' : 'bg-white border-slate-200';
    $textColor = $isDark ? 'text-white' : 'text-slate-900';
    $subColor = $isDark ? 'text-slate-400' : 'text-slate-500';
    $borderAccent = $isDark ? 'border-slate-700' : 'border-slate-200';

    $totalMembers = count($members);
    $initialShow = 4;
@endphp

<style>
    #{{ $uid }} .rj-team-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-team-card:hover {
        transform: translateY(-8px);
    }
    #{{ $uid }} .rj-team-img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-team-card:hover .rj-team-img {
        transform: scale(1.08);
    }
    #{{ $uid }} .rj-team-social {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    #{{ $uid }} .rj-team-card:hover .rj-team-social {
        opacity: 1;
        transform: translateY(0);
    }
    #{{ $uid }} .rj-team-hidden {
        display: none;
    }
</style>

<div id="{{ $uid }}" class="w-full py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $columns }} gap-8 md:gap-12">
        @foreach($members as $index => $member)
            <div class="rj-team-card group relative flex flex-col {{ $index >= $initialShow ? 'rj-team-hidden' : '' }}" data-index="{{ $index }}">

                <div class="relative w-full rounded-2xl overflow-hidden border-2 {{ $borderAccent }} {{ $isDark ? 'bg-slate-800' : 'bg-slate-50' }} aspect-[4/5]">
                    @if(!empty($member['image']))
                        <img src="{{ $member['image'] }}" class="rj-team-img w-full h-full object-cover object-center" alt="{{ $member['name'] }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center {{ $subColor }}">
                            <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <div class="rj-team-social flex items-center gap-3">
                            @if(!empty($member['facebook']) && $member['facebook'] !== '#')
                                <a href="{{ $member['facebook'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-white hover:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if(!empty($member['twitter']) && $member['twitter'] !== '#')
                                <a href="{{ $member['twitter'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-white hover:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if(!empty($member['linkedin']) && $member['linkedin'] !== '#')
                                <a href="{{ $member['linkedin'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-white hover:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="relative mt-6 text-center px-2">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-12 h-1 bg-indigo-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <h3 class="text-xl font-extrabold {{ $textColor }} tracking-tight">{{ $member['name'] }}</h3>
                    @if(!empty($member['position']))
                        <p class="text-sm font-medium {{ $subColor }} mt-1">{{ $member['position'] }}</p>
                    @endif

                    @if(!empty($member['btn_text']) && !empty($member['btn_url']))
                        <div class="mt-5">
                            <a href="{{ $member['btn_url'] }}" class="inline-flex items-center justify-center px-6 py-2 border border-slate-300 {{ $isDark ? 'border-slate-700 hover:border-indigo-500' : 'hover:border-slate-900' }} text-xs font-bold uppercase tracking-widest {{ $textColor }} rounded-full transition-colors">
                                {{ $member['btn_text'] }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($totalMembers > $initialShow)
        <div class="mt-12 text-center">
            <button type="button" class="rj-team-more-btn inline-flex items-center gap-2 px-8 py-3 bg-slate-900 text-white font-bold text-sm rounded-full hover:bg-slate-800 transition-colors shadow-lg">
                <span>{{ __('Show More') }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </div>
    @endif
</div>

<script>
(function() {
    function initTeam_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const btn = root.querySelector('.rj-team-more-btn');
        const hiddenItems = root.querySelectorAll('.rj-team-hidden');

        if (btn && hiddenItems.length > 0) {
            btn.addEventListener('click', () => {
                hiddenItems.forEach(item => {
                    item.classList.remove('rj-team-hidden');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 50);
                });
                btn.parentElement.style.display = 'none';
            });
        }
    }

    initTeam_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTeam_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
