@extends('spotlight::layout')

@section('content')
<div class="rj-container" style="padding-top: 80px; padding-bottom: 80px; max-width: 1000px;">
    <a href="{{ route('spotlight.plugins.index') }}" style="display: inline-block; margin-bottom: 24px; color: var(--rj-primary); text-decoration: none; font-weight: 600;">&larr; Bütün plaqinlər</a>
    
    <div style="background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 24px; overflow: hidden;">
        <div style="padding: 32px; border-bottom: 1px solid var(--rj-border); display: flex; flex-wrap: wrap; gap: 32px; align-items: flex-start;">
            <img src="{{ $plugin['logo'] ?? '' }}" style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; background: #1f2937;" alt="">
            
            <div style="flex-grow: 1; min-width: 250px;">
                <h1 style="font-size: 32px; font-weight: 800; color: var(--rj-text); margin: 0 0 12px 0;">{{ $plugin['name'] }}</h1>
                <p style="font-size: 16px; color: var(--rj-muted); margin: 0 0 16px 0;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 14px;">
                    <span style="padding: 4px 12px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">Versiya: <b>{{ $plugin['version'] }}</b></span>
                    <span style="padding: 4px 12px; border-radius: 999px; background: rgba(255,255,255,0.02); border: 1px solid var(--rj-border); color: var(--rj-text);">Müəllif: <b>{{ $plugin['author'] }}</b></span>
                </div>
            </div>

            <div style="width: 100%; max-width: 220px;">
                @if($plugin['release_available'])
                    <a href="{{ $plugin['zip_url'] }}" style="display: block; width: 100%; text-align: center; padding: 14px; border-radius: 12px; font-weight: 700; background: var(--rj-primary); color: #fff; text-decoration: none; box-shadow: 0 10px 20px -10px var(--rj-primary);">
                        İndi Yüklə
                    </a>
                    <p style="text-align: center; font-size: 12px; color: var(--rj-muted); margin-top: 8px;">{{ number_format($plugin['size'] / 1024 / 1024, 1) }} MB • ZIP</p>
                @endif
                
                <a href="{{ $plugin['docs'] }}" target="_blank" style="display: block; text-align: center; margin-top: 16px; font-size: 14px; font-weight: 600; color: var(--rj-primary); text-decoration: none;">Sənədləri Oxu &rarr;</a>
            </div>
        </div>

        <div style="padding: 32px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 48px;">
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">Xüsusiyyətlər</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
                    @foreach($plugin['features'] as $feature)
                        <li style="display: flex; align-items: flex-start; gap: 12px; color: var(--rj-muted);">
                            <svg style="width: 20px; height: 20px; color: var(--rj-primary); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div>
                <h3 style="font-size: 24px; font-weight: 700; color: var(--rj-text); margin: 0 0 24px 0;">Quraşdırılma Qaydası</h3>
                <ol style="list-style: none; padding: 0 0 0 16px; margin: 0; border-left: 2px solid var(--rj-border); display: flex; flex-direction: column; gap: 24px;">
                    @foreach($plugin['steps'] as $step)
                        <li style="position: relative;">
                            <span style="position: absolute; left: -23px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: var(--rj-primary); border: 3px solid var(--rj-surface);"></span>
                            <span style="font-size: 14px; color: var(--rj-muted);">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection