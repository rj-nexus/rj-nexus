@extends('theme::layout')

@section('content')
<style>
    /* Tab Düymələri */
    .rj-tab-btn {
        padding: 12px 24px; font-size: 15px; font-weight: 600; color: var(--rj-muted);
        background: transparent; border: none; border-bottom: 2px solid transparent;
        cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px;
        white-space: nowrap;
    }
    .rj-tab-btn:hover { color: var(--rj-text); }
    .rj-tab-btn.active { color: var(--rj-primary); border-bottom-color: var(--rj-primary); }
    
    /* Tab Məzmunu (Default olaraq gizli) */
    .rj-tab-content { display: none; }
    .rj-tab-content.active { display: block; animation: fadeIn 0.3s ease; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    
    /* README Markdown Stilləri */
    .rj-markdown { color: var(--rj-muted); font-size: 15px; line-height: 1.7; }
    .rj-markdown h1, .rj-markdown h2, .rj-markdown h3 { color: var(--rj-text); margin-top: 24px; margin-bottom: 16px; font-weight: 700; }
    .rj-markdown h1 { font-size: 28px; border-bottom: 1px solid var(--rj-border); padding-bottom: 10px; }
    .rj-markdown h2 { font-size: 22px; }
    .rj-markdown h3 { font-size: 18px; }
    .rj-markdown p { margin-bottom: 16px; }
    .rj-markdown a { color: var(--rj-primary); text-decoration: none; }
    .rj-markdown a:hover { text-decoration: underline; }
    .rj-markdown ul, .rj-markdown ol { padding-left: 24px; margin-bottom: 16px; }
    .rj-markdown li { margin-bottom: 8px; }
    .rj-markdown code { background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; font-family: monospace; color: #f472b6; }
    .rj-markdown pre { background: var(--rj-surface); padding: 16px; border-radius: 8px; overflow-x: auto; border: 1px solid var(--rj-border); margin-bottom: 16px; }
    .rj-markdown pre code { background: transparent; padding: 0; color: var(--rj-text); }
    .rj-markdown img { max-width: 100%; height: auto; border-radius: 8px; margin: 16px 0; }
</style>

<div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1100px;">
    
    <a href="{{ url(app()->getLocale() . '/plugins') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px; color: var(--rj-primary); text-decoration: none; font-weight: 600; font-size: 14px;">
        &larr; {{ __('Back to all plugins') }}
    </a>
    
    <div style="background: linear-gradient(145deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 32px; overflow: hidden; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8);">
        
        <!-- Üst Hissə (Hero) -->
        <div style="padding: 48px; border-bottom: 1px solid var(--rj-border); display: flex; flex-wrap: wrap; gap: 40px; align-items: flex-start; background: radial-gradient(circle at top right, rgba(167, 139, 250, 0.08), transparent 60%);">
            <div style="width: 120px; height: 120px; border-radius: 24px; background: var(--rj-surface); border: 1px solid var(--rj-border); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);">
                <img src="{{ $plugin['logo'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
            </div>
            
            <div style="flex-grow: 1; min-width: 280px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <h1 style="font-size: 42px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">{{ $plugin['name'] }}</h1>
                    @if($plugin['verified'] ?? false)
                        <svg style="width: 24px; height: 24px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    @endif
                </div>
                <p style="font-size: 18px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px;">
                    <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Version') }}: <b>{{ $plugin['version'] }}</b></span>
                    <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Author') }}: <b>{{ $plugin['author'] }}</b></span>
                </div>
            </div>

            <div style="width: 100%; max-width: 220px; flex-shrink: 0;">
                @if($plugin['release_available'] ?? false)
                    <a href="{{ $plugin['zip_url'] }}" style="display: block; padding: 16px; font-size: 16px; text-align: center; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; text-decoration: none; box-shadow: 0 8px 25px -8px var(--rj-primary); transition: all 0.2s;">
                        {{ __('Download') }}
                    </a>
                    <p style="text-align: center; font-size: 12px; color: var(--rj-muted); margin-top: 10px;">v{{ $plugin['version'] }} &bull; {{ number_format($plugin['size'] / 1024 / 1024, 1) }} MB</p>
                @endif
            </div>
        </div>

        <!-- Tab Menyusu -->
        <div style="display: flex; gap: 8px; padding: 0 48px; border-bottom: 1px solid var(--rj-border); background: rgba(0,0,0,0.2); overflow-x: auto;">
            <button onclick="switchTab(event, 'tab-overview')" class="rj-tab-btn active">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ __('Overview') }}
            </button>
            <button onclick="switchTab(event, 'tab-readme')" class="rj-tab-btn">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                {{ __('Readme') }}
            </button>
            <button onclick="switchTab(event, 'tab-installation')" class="rj-tab-btn">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('Installation') }}
            </button>
            @if(!empty($plugin['screenshots']))
            <button onclick="switchTab(event, 'tab-screenshots')" class="rj-tab-btn">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ __('Screenshots') }}
            </button>
            @endif
        </div>

        <!-- Tab Məzmunları -->
        <div style="padding: 48px;">
            
            <!-- 1. Overview Tab -->
            <div id="tab-overview" class="rj-tab-content active">
                <h3 style="font-size: 22px; font-weight: 700; color: var(--rj-text); margin: 0 0 20px 0;">{{ __('Key Features') }}</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    @foreach($plugin['features'] as $feature)
                        <li style="display: flex; align-items: flex-start; gap: 12px; background: rgba(255,255,255,0.02); padding: 16px; border-radius: 12px; border: 1px solid var(--rj-border); color: var(--rj-text); font-size: 14px;">
                            <svg style="width: 18px; height: 18px; color: var(--rj-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 2. Readme Tab -->
            <div id="tab-readme" class="rj-tab-content">
                @if($readmeHtml)
                    <div class="rj-markdown">
                        {!! $readmeHtml !!}
                    </div>
                @else
                    <div style="padding: 40px; text-align: center; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px dashed var(--rj-border);">
                        <p style="color: var(--rj-muted); font-size: 14px; margin: 0;">{{ __('Readme could not be fetched from GitHub.') }}</p>
                        <a href="{{ $plugin['docs'] }}" target="_blank" style="display: inline-block; margin-top: 16px; color: var(--rj-primary); font-weight: 600;">{{ __('View on GitHub') }} &rarr;</a>
                    </div>
                @endif
            </div>

            <!-- 3. Installation Tab -->
            <div id="tab-installation" class="rj-tab-content">
                <h3 style="font-size: 22px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">{{ __('Installation Steps') }}</h3>
                <ol style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 24px; max-width: 600px;">
                    @foreach($plugin['steps'] as $index => $step)
                        <li style="display: flex; gap: 16px; background: rgba(255,255,255,0.02); padding: 20px; border-radius: 16px; border: 1px solid var(--rj-border);">
                            <span style="width: 32px; height: 32px; flex-shrink: 0; border-radius: 50%; background: rgba(167, 139, 250, 0.1); color: var(--rj-primary); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; border: 1px solid rgba(167, 139, 250, 0.2);">
                                {{ $index + 1 }}
                            </span>
                            <span style="font-size: 15px; line-height: 1.6; color: var(--rj-muted); padding-top: 4px;">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- 4. Screenshots Tab -->
            @if(!empty($plugin['screenshots']))
            <div id="tab-screenshots" class="rj-tab-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    @foreach($plugin['screenshots'] as $screenshot)
                        <a href="{{ $screenshot }}" target="_blank" style="display: block; border-radius: 16px; overflow: hidden; border: 1px solid var(--rj-border);">
                            <img src="{{ $screenshot }}" style="width: 100%; height: auto; display: block;" alt="Screenshot">
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Tablar üçün Təmiz JavaScript -->
<script>
    function switchTab(event, tabId) {
        // 1. Bütün düymələrdən 'active' klasını sil
        const buttons = document.querySelectorAll('.rj-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // 2. Kliklənən düyməyə 'active' klasını əlavə et
        event.currentTarget.classList.add('active');

        // 3. Bütün məzmunları gizlət
        const contents = document.querySelectorAll('.rj-tab-content');
        contents.forEach(content => content.classList.remove('active'));

        // 4. Hədəf məzmunu göstər
        const targetContent = document.getElementById(tabId);
        if (targetContent) {
            targetContent.classList.add('active');
        }
    }
</script>
@endsection