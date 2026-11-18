@extends('theme::layout')

@section('content')
<div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1100px;">
    
    <a href="{{ url(app()->getLocale() . '/plugins') }}" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px; color: var(--rj-primary); text-decoration: none; font-weight: 600; font-size: 14px;">
        &larr; {{ __('Back to all plugins') }}
    </a>
    
    <div style="background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid var(--rj-border); border-radius: 32px; overflow: hidden; backdrop-filter: blur(20px); box-shadow: 0 30px 60px -30px rgba(0,0,0,0.8);">
        
        <!-- Hero Section -->
        <div style="padding: 48px; border-bottom: 1px solid var(--rj-border); display: flex; flex-wrap: wrap; gap: 40px; align-items: flex-start; background: radial-gradient(circle at top right, rgba(167, 139, 250, 0.08), transparent 60%);">
            <div style="flex-grow: 1; min-width: 280px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <h1 style="font-size: 48px; font-weight: 800; color: var(--rj-text); margin: 0; letter-spacing: -0.02em;">{{ $plugin['name'] }}</h1>
                    @if($plugin['verified'])
                        <svg style="width: 24px; height: 24px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    @endif
                </div>
                <p style="font-size: 18px; line-height: 1.7; color: var(--rj-muted); margin: 0 0 24px 0;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 14px;">
                    <span style="padding: 8px 16px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Version') }}: <b>{{ $plugin['version'] }}</b></span>
                    <span style="padding: 8px 16px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">{{ __('Author') }}: <b>{{ $plugin['author'] }}</b></span>
                </div>
            </div>

            <div style="width: 100%; max-width: 260px; background: rgba(255,255,255,0.02); padding: 28px; border-radius: 24px; border: 1px solid var(--rj-border);">
                @if($plugin['release_available'])
                    <a href="{{ $plugin['zip_url'] }}" class="rj-btn-primary" style="display: block; padding: 16px; font-size: 16px; text-align: center; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; text-decoration: none; box-shadow: 0 8px 25px -8px var(--rj-primary); transition: all 0.3s;">
                        {{ __('Download Plugin') }}
                    </a>
                    <p style="text-align: center; font-size: 13px; color: var(--rj-muted); margin-top: 12px;">{{ number_format($plugin['size'] / 1024 / 1024, 1) }} MB &bull; ZIP</p>
                @endif
                
                <a href="{{ $plugin['docs'] }}" target="_blank" style="display: block; text-align: center; margin-top: 16px; font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none;">
                    {{ __('Read Documentation') }} &rarr;
                </a>
            </div>
        </div>

        <!-- Screenshots Gallery -->
        @if(!empty($plugin['screenshots']))
            <div style="padding: 48px; border-bottom: 1px solid var(--rj-border);">
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">{{ __('Screenshots') }}</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    @foreach($plugin['screenshots'] as $screenshot)
                        <a href="{{ $screenshot }}" target="_blank" style="display: block; border-radius: 16px; overflow: hidden; border: 1px solid var(--rj-border); transition: transform 0.3s;">
                            <img src="{{ $screenshot }}" style="width: 100%; height: auto; display: block;" alt="Screenshot">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Features & Installation -->
        <div style="padding: 48px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 60px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">{{ __('Features') }}</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                    @foreach($plugin['features'] as $feature)
                        <li style="display: flex; align-items: flex-start; gap: 12px; color: var(--rj-muted); font-size: 15px; line-height: 1.6;">
                            <svg style="width: 20px; height: 20px; color: var(--rj-primary); flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">{{ __('Installation Steps') }}</h3>
                <ol style="list-style: none; padding: 0 0 0 20px; margin: 0; border-left: 2px solid var(--rj-border); display: flex; flex-direction: column; gap: 32px;">
                    @foreach($plugin['steps'] as $step)
                        <li style="position: relative;">
                            <span style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: var(--rj-primary); border: 3px solid var(--rj-surface);"></span>
                            <span style="font-size: 15px; line-height: 1.6; color: var(--rj-muted);">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection