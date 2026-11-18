@extends('spotlight::layout')

@section('content')
<div class="rj-container" style="padding-top: 80px; padding-bottom: 80px; min-height: 100vh;">
    <div style="margin-bottom: 48px;">
        <h1 style="font-size: 36px; font-weight: 800; color: var(--rj-text); margin: 0 0 16px 0;">Plaqinlər</h1>
        <p style="font-size: 18px; color: var(--rj-muted); margin: 0;">RJ Nexus-un gücünü artıran əlavələr.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
        @foreach($plugins as $plugin)
            <div style="display: flex; flex-direction: column; background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 16px; padding: 24px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <img src="{{ $plugin['logo'] ?? '' }}" style="width: 56px; height: 56px; border-radius: 12px; object-fit: cover; background: #1f2937;" alt="">
                    <div>
                        <h2 style="font-size: 20px; font-weight: 700; color: var(--rj-text); margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                            {{ $plugin['name'] }}
                            @if($plugin['verified'])
                                <svg style="width: 16px; height: 16px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            @endif
                        </h2>
                        <p style="font-size: 14px; color: var(--rj-muted); margin: 0;">v{{ $plugin['version'] }} • {{ $plugin['author'] }}</p>
                    </div>
                </div>
                
                <p style="font-size: 14px; color: var(--rj-muted); margin: 0 0 24px 0; flex-grow: 1;">{{ $plugin['description'] }}</p>
                
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('spotlight.plugins.show', $plugin['slug']) }}" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; background: rgba(255,255,255,0.05); color: var(--rj-text); border: 1px solid var(--rj-border); text-decoration: none;">Ətraflı</a>
                    @if($plugin['release_available'])
                        <a href="{{ $plugin['zip_url'] }}" style="flex: 1; text-align: center; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; background: var(--rj-primary); color: #fff; text-decoration: none;">Yüklə</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection