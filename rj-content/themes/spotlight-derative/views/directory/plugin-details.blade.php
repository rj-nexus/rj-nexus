@extends('theme::layout')

@section('content')
<div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1000px;">
    
    <!-- Geri Qayıt Linki (Düzəldildi) -->
    <a href="{{ url(app()->getLocale() . '/plugins') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px; color: var(--rj-primary); text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s;">
        &larr; {{ __('Back to all plugins') }}
    </a>
    
    <div style="background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 32px; overflow: hidden; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8);">
        
        <!-- Üst Hissə (Hero) -->
        <div style="padding: 48px; border-bottom: 1px solid var(--rj-border); display: flex; flex-wrap: wrap; gap: 40px; align-items: flex-start; background: radial-gradient(circle at top right, rgba(167, 139, 250, 0.05), transparent 50%);">
            <div style="width: 140px; height: 140px; border-radius: 24px; background: var(--rj-surface); border: 1px solid var(--rj-border); display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);">
                <img src="{{ $plugin['logo'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
            </div>
            
            <div style="flex-grow: 1; min-width: 280px;">
                <h1 style="font-size: 40px; font-weight: 800; color: var(--rj-text); margin: 0 0 16px 0; letter-spacing: -0.02em;">{{ $plugin['name'] }}</h1>
                <p style="font-size: 18px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px;">
                    <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Version') }}: <b>{{ $plugin['version'] }}</b></span>
                    <span style="padding: 6px 14px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Author') }}: <b>{{ $plugin['author'] }}</b></span>
                </div>
            </div>

            <div style="width: 100%; max-width: 240px; background: rgba(255,255,255,0.01); padding: 24px; border-radius: 20px; border: 1px solid var(--rj-border);">
                @if($plugin['release_available'])
                    <a href="{{ $plugin['zip_url'] }}" class="rj-btn-primary" style="display: block; padding: 16px; font-size: 16px; text-align: center; border-radius: 12px; font-weight: 700; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; text-decoration: none; box-shadow: 0 4px 15px -5px var(--rj-primary); transition: all 0.2s;">
                        {{ __('Download Now') }}
                    </a>
                    <p style="text-align: center; font-size: 12px; color: var(--rj-muted); margin-top: 12px;">{{ number_format($plugin['size'] / 1024 / 1024, 1) }} MB &bull; ZIP</p>
                @endif
                
                <a href="{{ $plugin['docs'] }}" target="_blank" style="display: block; text-align: center; margin-top: 16px; font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none;">
                    {{ __('Read Documentation') }} &rarr;
                </a>
            </div>
        </div>

        <!-- Alt Hissə (Xüsusiyyətlər və Qaydalar) -->
        <div style="padding: 48px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 60px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(167, 139, 250, 0.1); display: flex; align-items: center; justify-content: center; color: var(--rj-primary);">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    {{ __('Features') }}
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                    @foreach($plugin['features'] as $feature)
                        <li style="display: flex; align-items: flex-start; gap: 12px; color: var(--rj-muted); font-size: 15px; line-height: 1.5;">
                            <svg style="width: 20px; height: 20px; color: var(--rj-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(167, 139, 250, 0.1); display: flex; align-items: center; justify-content: center; color: var(--rj-primary);">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </span>
                    {{ __('Installation Steps') }}
                </h3>
                <ol style="list-style: none; padding: 0 0 0 20px; margin: 0; border-left: 2px solid var(--rj-border); display: flex; flex-direction: column; gap: 32px;">
                    @foreach($plugin['steps'] as $step)
                        <li style="position: relative;">
                            <span style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: var(--rj-primary); border: 3px solid var(--rj-surface); box-shadow: 0 0 10px var(--rj-primary);"></span>
                            <span style="font-size: 15px; line-height: 1.5; color: var(--rj-muted);">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection