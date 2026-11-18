@extends('spotlight::layout')

@section('content')
<style>
    .rj-dir-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--rj-border);
        border-radius: 20px;
        backdrop-filter: blur(12px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 28px;
        display: flex;
        flex-direction: column;
    }
    .rj-dir-card:hover {
        border-color: rgba(167, 139, 250, 0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8);
    }
</style>

<div class="rj-container" style="padding-top: 100px; padding-bottom: 100px; min-height: 100vh;">
    <div style="margin-bottom: 60px; text-align: center;">
        <h1 style="font-size: 48px; font-weight: 800; color: var(--rj-text); margin: 0 0 16px 0; letter-spacing: -0.03em; background: linear-gradient(to right, #fff, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {{ __('Plugins') }}
        </h1>
        <p style="font-size: 18px; color: var(--rj-muted); margin: 0;">{{ __('Addons that power up RJ Nexus.') }}</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
        @foreach($plugins as $plugin)
            <div class="rj-dir-card">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 64px; height: 64px; border-radius: 16px; background: var(--rj-surface); border: 1px solid var(--rj-border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="{{ $plugin['logo'] ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                    </div>
                    <div>
                        <h2 style="font-size: 20px; font-weight: 700; color: var(--rj-text); margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                            {{ $plugin['name'] }}
                            @if($plugin['verified'])
                                <svg style="width: 18px; height: 18px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            @endif
                        </h2>
                        <p style="font-size: 13px; color: var(--rj-muted); margin: 0;">v{{ $plugin['version'] }} &bull; {{ $plugin['author'] }}</p>
                    </div>
                </div>
                
                <p style="font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('spotlight.plugins.show', $plugin['slug']) }}" class="rj-btn-secondary">{{ __('Details') }}</a>
                    @if($plugin['release_available'])
                        <a href="{{ $plugin['zip_url'] }}" class="rj-btn-primary">{{ __('Download') }}</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection