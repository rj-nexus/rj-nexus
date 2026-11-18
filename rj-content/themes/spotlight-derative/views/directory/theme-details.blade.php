@extends('theme::layout')

@section('content')
<header class="rj-frontend-header">
    @php $headerTmpl = app(\App\Services\ThemeResolver::class)->header(); @endphp
    @if($headerTmpl)
        {!! rj_render_template($headerTmpl) !!}
    @endif
</header>

<main class="rj-frontend-main">
    <style>
        .rj-tab-btn {
            padding: 12px 24px; font-size: 15px; font-weight: 600; color: var(--rj-muted);
            background: transparent; border: none; border-bottom: 2px solid transparent;
            cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px;
            white-space: nowrap; outline: none;
        }
        .rj-tab-btn:hover { color: var(--rj-text); }
        .rj-tab-btn.active { color: var(--rj-primary); border-bottom-color: var(--rj-primary); }
        
        .rj-tab-content { display: none; }
        .rj-tab-content.active { display: block; animation: fadeIn 0.3s ease; }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        .rj-markdown { color: var(--rj-muted); font-size: 15px; line-height: 1.7; }
        .rj-markdown h1, .rj-markdown h2, .rj-markdown h3 { color: var(--rj-text); margin-top: 24px; margin-bottom: 16px; font-weight: 700; }
        .rj-markdown h1 { font-size: 28px; border-bottom: 1px solid var(--rj-border); padding-bottom: 10px; }
        .rj-markdown h2 { font-size: 22px; }
        .rj-markdown h3 { font-size: 18px; }
        .rj-markdown p { margin-bottom: 16px; }
        .rj-markdown a { color: var(--rj-primary); text-decoration: none; }
        .rj-markdown ul, .rj-markdown ol { padding-left: 24px; margin-bottom: 16px; }
        .rj-markdown code { background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px; font-family: monospace; color: #f472b6; }
        .rj-markdown pre { background: var(--rj-surface); padding: 16px; border-radius: 8px; overflow-x: auto; border: 1px solid var(--rj-border); margin-bottom: 16px; }
        .rj-markdown pre code { background: transparent; padding: 0; color: var(--rj-text); }

        .rj-back-btn {
            display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px;
            color: var(--rj-primary); text-decoration: none; font-weight: 600; font-size: 14px;
            padding: 10px 20px; border-radius: 12px; background: rgba(167, 139, 250, 0.1);
            border: 1px solid rgba(167, 139, 250, 0.2); outline: none; transition: all 0.2s;
        }
        .rj-back-btn:hover { background: rgba(167, 139, 250, 0.2); }
    </style>

    <div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1100px;">
        
        <a href="{{ url(app()->getLocale() . '/themes') }}" class="rj-back-btn">
            &larr; {{ __('Back to all themes') }}
        </a>
        
        <div style="background: linear-gradient(145deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 32px; overflow: hidden; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8);">
            
            <!-- Hero -->
            <div style="padding: 48px; border-bottom: 1px solid var(--rj-border); display: flex; flex-wrap: wrap; gap: 40px; align-items: flex-start; background: radial-gradient(circle at top right, rgba(167, 139, 250, 0.08), transparent 60%);">
                <div style="width: 120px; height: 120px; border-radius: 24px; background: var(--rj-surface); border: 1px solid var(--rj-border); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);">
                    <img src="{{ $theme['logo'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                </div>
                
                <div style="flex-grow: 1; min-width: 280px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <h1 style="font-size: 42px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">{{ $theme['name'] }}</h1>
                        @if($theme['verified'] ?? false)
                            <svg style="width: 24px; height: 24px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        @endif
                    </div>
                    <p style="font-size: 18px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0;">{{ $theme['description'] }}</p>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px;">
                        <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Version') }}: <b>{{ $theme['version'] }}</b></span>
                        <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Author') }}: <b>{{ $theme['author'] }}</b></span>
                    </div>
                </div>

                <div style="width: 100%; max-width: 220px; flex-shrink: 0;">
                    @if($theme['release_available'] ?? false)
                        <a href="{{ $theme['zip_url'] }}" style="display: block; padding: 16px; font-size: 16px; text-align: center; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; text-decoration: none; box-shadow: 0 8px 25px -8px var(--rj-primary); transition: all 0.2s;">
                            {{ __('Download') }}
                        </a>
                        <p style="text-align: center; font-size: 12px; color: var(--rj-muted); margin-top: 10px;">v{{ $theme['version'] }} &bull; {{ number_format($theme['size'] / 1024 / 1024, 1) }} MB</p>
                    @endif
                </div>
            </div>

            <!-- Tab Menyusu -->
            <div style="display: flex; gap: 8px; padding: 0 48px; border-bottom: 1px solid var(--rj-border); background: rgba(0,0,0,0.2); overflow-x: auto;">
                <button onclick="switchTab(event, 'tab-overview')" class="rj-tab-btn active">
                    {{ __('Overview') }}
                </button>
                <button onclick="switchTab(event, 'tab-readme')" class="rj-tab-btn">
                    {{ __('Readme') }}
                </button>
                <button onclick="switchTab(event, 'tab-installation')" class="rj-tab-btn">
                    {{ __('Installation') }}
                </button>
                @if(!empty($theme['screenshots']))
                <button onclick="switchTab(event, 'tab-screenshots')" class="rj-tab-btn">
                    {{ __('Screenshots') }}
                </button>
                @endif
            </div>

            <!-- Tab Məzmunları -->
            <div style="padding: 48px;">
                
                <div id="tab-overview" class="rj-tab-content active">
                    <h3 style="font-size: 22px; font-weight: 700; color: var(--rj-text); margin: 0 0 20px 0;">{{ __('Key Features') }}</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        @foreach($theme['features'] as $feature)
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: rgba(255,255,255,0.02); padding: 16px; border-radius: 12px; border: 1px solid var(--rj-border); color: var(--rj-text); font-size: 14px;">
                                <svg style="width: 18px; height: 18px; color: var(--rj-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="tab-readme" class="rj-tab-content">
                    @if($readmeHtml)
                        <div class="rj-markdown">{!! $readmeHtml !!}</div>
                    @else
                        <div style="padding: 40px; text-align: center; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px dashed var(--rj-border);">
                            <p style="color: var(--rj-muted); font-size: 14px; margin: 0;">{{ __('Readme could not be fetched from GitHub.') }}</p>
                            <a href="{{ $theme['docs'] }}" target="_blank" style="display: inline-block; margin-top: 16px; color: var(--rj-primary); font-weight: 600;">{{ __('View on GitHub') }} &rarr;</a>
                        </div>
                    @endif
                </div>

                <div id="tab-installation" class="rj-tab-content">
                    <ol style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 24px; max-width: 600px;">
                        @foreach($theme['steps'] as $index => $step)
                            <li style="display: flex; gap: 16px; background: rgba(255,255,255,0.02); padding: 20px; border-radius: 16px; border: 1px solid var(--rj-border);">
                                <span style="width: 32px; height: 32px; flex-shrink: 0; border-radius: 50%; background: rgba(167, 139, 250, 0.1); color: var(--rj-primary); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; border: 1px solid rgba(167, 139, 250, 0.2);">
                                    {{ $index + 1 }}
                                </span>
                                <span style="font-size: 15px; line-height: 1.6; color: var(--rj-muted); padding-top: 4px;">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                @if(!empty($theme['screenshots']))
                <div id="tab-screenshots" class="rj-tab-content">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($theme['screenshots'] as $screenshot)
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
</main>

<footer class="rj-frontend-footer">
    @php $footerTmpl = app(\App\Services\ThemeResolver::class)->footer(); @endphp
    @if($footerTmpl)
        {!! rj_render_template($footerTmpl) !!}
    @endif
</footer>

<script>
    function switchTab(event, tabId) {
        const buttons = document.querySelectorAll('.rj-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        const contents = document.querySelectorAll('.rj-tab-content');
        contents.forEach(content => content.classList.remove('active'));

        const targetContent = document.getElementById(tabId);
        if (targetContent) {
            targetContent.classList.add('active');
        }
    }
</script>
@endsection