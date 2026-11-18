@extends('theme::layout')

@section('content')
<div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1100px;">
    
    <!-- Geri Qayıt Linki -->
    <a href="{{ url(app()->getLocale() . '/plugins') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px; color: var(--rj-primary); text-decoration: none; font-weight: 600; font-size: 14px;">
        &larr; {{ __('Back to all plugins') }}
    </a>
    
    <div style="background: linear-gradient(145deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 32px; overflow: hidden; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8);">
        
        <!-- 1. BÖLMƏ: Üst Hissə (Hero) -->
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
                    @if(!empty($plugin['requires']))
                        <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Requires') }}: <b>{{ $plugin['requires'] }}</b></span>
                    @endif
                </div>
            </div>

            <!-- Yükləmə Düyməsi -->
            <div style="width: 100%; max-width: 220px; flex-shrink: 0;">
                @if($plugin['release_available'] ?? false)
                    <a href="{{ $plugin['zip_url'] }}" style="display: block; padding: 16px; font-size: 16px; text-align: center; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; text-decoration: none; box-shadow: 0 8px 25px -8px var(--rj-primary); transition: all 0.2s;">
                        {{ __('Download') }}
                    </a>
                    <p style="text-align: center; font-size: 12px; color: var(--rj-muted); margin-top: 10px;">v{{ $plugin['version'] }} &bull; {{ number_format($plugin['size'] / 1024 / 1024, 1) }} MB</p>
                @endif
            </div>
        </div>

        <!-- 2. BÖLMƏ: Əsas Məzmun (İki sütunlu) -->
        <div style="padding: 48px; display: grid; grid-template-columns: 1fr; md:grid-template-columns: 2fr 1fr; gap: 60px;">
            <div style="display: flex; flex-direction: column; gap: 60px;">
                
                <!-- Xüsusiyyətlər (Features) -->
                <div>
                    <h2 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0; display: flex; align-items: center; gap: 12px;">
                        <svg style="width: 24px; height: 24px; color: var(--rj-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        {{ __('Key Features') }}
                    </h2>
                    <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                        @foreach($plugin['features'] as $feature)
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: rgba(255,255,255,0.02); padding: 16px; border-radius: 12px; border: 1px solid var(--rj-border); color: var(--rj-text); font-size: 14px;">
                                <svg style="width: 18px; height: 18px; color: var(--rj-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Şəkillər (Screenshots) -->
                <div>
                    <h2 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0; display: flex; align-items: center; gap: 12px;">
                        <svg style="width: 24px; height: 24px; color: var(--rj-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ __('Screenshots') }}
                    </h2>
                    @if(!empty($plugin['screenshots']))
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">
                            @foreach($plugin['screenshots'] as $screenshot)
                                <a href="{{ $screenshot }}" target="_blank" style="display: block; border-radius: 16px; overflow: hidden; border: 1px solid var(--rj-border);">
                                    <img src="{{ $screenshot }}" style="width: 100%; height: auto; display: block;" alt="Screenshot">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div style="padding: 40px; text-align: center; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px dashed var(--rj-border);">
                            <p style="color: var(--rj-muted); font-size: 14px; margin: 0;">{{ __('No screenshots available for this plugin.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sağ Sütun: Quraşdırma və Readme -->
            <div style="display: flex; flex-direction: column; gap: 40px;">
                
                <!-- Quraşdırma Addımları (Installation Steps) -->
                <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--rj-border); border-radius: 20px; padding: 32px;">
                    <h3 style="font-size: 20px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">{{ __('Installation') }}</h3>
                    <ol style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 20px;">
                        @foreach($plugin['steps'] as $index => $step)
                            <li style="display: flex; gap: 16px;">
                                <span style="width: 28px; height: 28px; flex-shrink: 0; border-radius: 50%; background: rgba(167, 139, 250, 0.1); color: var(--rj-primary); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; border: 1px solid rgba(167, 139, 250, 0.2);">
                                    {{ $index + 1 }}
                                </span>
                                <span style="font-size: 14px; line-height: 1.6; color: var(--rj-muted); padding-top: 4px;">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <!-- Readme / Sənədlər (Documentation) -->
                <div style="background: linear-gradient(145deg, rgba(167, 139, 250, 0.05) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid rgba(167, 139, 250, 0.2); border-radius: 20px; padding: 32px; text-align: center;">
                    <svg style="width: 40px; height: 40px; color: var(--rj-primary); margin: 0 auto 16px auto; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--rj-text); margin: 0 0 12px 0;">{{ __('Readme & Docs') }}</h3>
                    <p style="font-size: 13px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 20px 0;">
                        {{ __('Read the full documentation, changelog, and advanced configuration guide on GitHub.') }}
                    </p>
                    <a href="{{ $plugin['docs'] }}" target="_blank" style="display: block; padding: 12px; font-size: 14px; font-weight: 600; border-radius: 10px; background: rgba(255,255,255,0.05); color: var(--rj-text); text-decoration: none; border: 1px solid var(--rj-border); transition: all 0.2s;">
                        {{ __('View Full Readme') }}
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection