@extends('admin.layouts.app')

@section('title', __('Notification Settings'))

@section('content')
<style>
    .rj-ns { max-width: 56rem; margin-inline: auto; display: flex; flex-direction: column; gap: 24px; }

    .rj-ns-top { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .rj-ns-top h1 { margin: 0; font-size: 24px; font-weight: 700; color: #0f172a; }
    .rj-ns-top p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    .rj-ns-back {
        display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px;
        border: 1px solid #e2e8f0; border-radius: 999px; background: #fff;
        font-size: 13px; font-weight: 600; color: #475569; text-decoration: none;
        transition: border-color .15s, color .15s, transform .15s, box-shadow .15s;
    }
    .rj-ns-back:hover { border-color: #c4b5fd; color: #7c3aed; transform: translateY(-1px); box-shadow: 0 8px 20px -12px rgba(139,92,246,.6); }
    .rj-ns-back svg { width: 16px; height: 16px; }
    [dir="rtl"] .rj-ns-back svg { transform: scaleX(-1); }

    .rj-ns-alert { padding: 14px 16px; border-radius: 12px; font-size: 14px; border: 1px solid; }
    .rj-ns-alert.ok { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    .rj-ns-alert.err { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

    .rj-ns-card { overflow: hidden; border: 1px solid #f1f5f9; border-radius: 18px; background: #fff; box-shadow: 0 10px 30px -18px rgba(15,23,42,.25); }
    .rj-ns-head {
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        padding: 18px 22px; border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(90deg, rgba(139,92,246,.07), rgba(236,72,153,.03));
    }
    .rj-ns-head-l { display: flex; align-items: center; gap: 14px; min-width: 0; }
    .rj-ns-ico {
        display: grid; place-items: center; flex: 0 0 40px; height: 40px; border-radius: 12px;
        background: linear-gradient(135deg, #8b5cf6, #ec4899); color: #fff;
    }
    .rj-ns-ico svg { width: 20px; height: 20px; }
    .rj-ns-head h2 { margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; }
    .rj-ns-head p { margin: 2px 0 0; font-size: 12.5px; color: #64748b; }

    /* Toggle */
    .rj-ns-sw { position: relative; display: inline-block; flex-shrink: 0; width: 48px; height: 28px; cursor: pointer; }
    .rj-ns-sw input[type="checkbox"] { position: absolute; inset: 0; width: 100%; height: 100%; margin: 0; opacity: 0; cursor: pointer; z-index: 2; }
    .rj-ns-sw i { position: absolute; inset: 0; border-radius: 999px; background: #cbd5e1; transition: background .2s; }
    .rj-ns-sw i::after {
        content: ""; position: absolute; top: 3px; inset-inline-start: 3px; width: 22px; height: 22px;
        border-radius: 50%; background: #fff; box-shadow: 0 2px 6px rgba(15,23,42,.3);
        transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    }
    .rj-ns-sw input:checked + i { background: linear-gradient(135deg, #8b5cf6, #ec4899); }
    .rj-ns-sw input:checked + i::after { transform: translateX(20px); }
    [dir="rtl"] .rj-ns-sw input:checked + i::after { transform: translateX(-20px); }
    .rj-ns-sw input:focus-visible + i { outline: 3px solid rgba(139,92,246,.35); outline-offset: 2px; }

    /* Sound body */
    .rj-ns-body { padding: 22px; transition: opacity .25s; }
    .rj-ns-body.is-off { opacity: .4; pointer-events: none; }
    .rj-ns-grid { display: grid; grid-template-columns: 1fr; gap: 28px; }
    @media (min-width: 768px) { .rj-ns-grid { grid-template-columns: 1fr 1fr; } }
    .rj-ns-lbl { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; font-size: 13px; font-weight: 600; color: #334155; }
    .rj-ns-val { font-size: 12px; font-weight: 700; color: #7c3aed; background: #f5f3ff; padding: 2px 8px; border-radius: 999px; }

    .rj-ns-pick { display: flex; gap: 10px; }
    .rj-ns-select {
        flex: 1; min-width: 0; height: 44px; padding: 0 40px 0 14px;
        border: 1px solid #e2e8f0; border-radius: 12px; background-color: #f8fafc; color: #0f172a;
        font: inherit; font-size: 14px; cursor: pointer;
        -webkit-appearance: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        transition: border-color .15s, box-shadow .15s;
    }
    [dir="rtl"] .rj-ns-select { padding: 0 14px 0 40px; background-position: left 14px center; }
    .rj-ns-select:focus { outline: 0; border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,.18); background-color: #fff; }

    .rj-ns-play {
        display: grid; place-items: center; flex: 0 0 44px; width: 44px; height: 44px; padding: 0;
        border: 0; border-radius: 12px; cursor: pointer; color: #fff;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        box-shadow: 0 10px 20px -10px rgba(139,92,246,.8);
        transition: transform .15s, box-shadow .15s;
    }
    .rj-ns-play:hover { transform: translateY(-1px); box-shadow: 0 14px 24px -10px rgba(139,92,246,.9); }
    .rj-ns-play:active { transform: scale(.94); }
    .rj-ns-play:focus-visible { outline: 3px solid rgba(139,92,246,.35); outline-offset: 2px; }
    .rj-ns-play svg { width: 20px; height: 20px; }

    /* Range */
    .rj-ns-range {
        -webkit-appearance: none; appearance: none; display: block; width: 100%; height: 8px; margin: 18px 0 0;
        border-radius: 999px; outline: 0; cursor: pointer;
        background: linear-gradient(90deg, #8b5cf6, #ec4899) left / var(--p, 50%) 100% no-repeat, #e2e8f0;
    }
    .rj-ns-range::-webkit-slider-thumb {
        -webkit-appearance: none; appearance: none; width: 22px; height: 22px; border-radius: 50%;
        background: #fff; border: 3px solid #8b5cf6; box-shadow: 0 3px 8px rgba(15,23,42,.25); cursor: grab;
    }
    .rj-ns-range::-moz-range-thumb { width: 16px; height: 16px; border-radius: 50%; background: #fff; border: 3px solid #8b5cf6; box-shadow: 0 3px 8px rgba(15,23,42,.25); cursor: grab; }
    .rj-ns-range:focus-visible::-webkit-slider-thumb { box-shadow: 0 0 0 4px rgba(139,92,246,.3); }
    .rj-ns-ends { display: flex; justify-content: space-between; margin-top: 8px; font-size: 11px; color: #94a3b8; }

    /* Table */
    .rj-ns-wrap { overflow-x: auto; }
    .rj-ns-tbl { width: 100%; border-collapse: collapse; text-align: start; font-size: 14px; }
    .rj-ns-tbl th {
        padding: 12px 22px; background: #f8fafc; border-bottom: 1px solid #f1f5f9;
        font-size: 12px; font-weight: 600; color: #64748b; text-align: center; white-space: nowrap;
    }
    .rj-ns-tbl th:first-child, .rj-ns-tbl td:first-child { text-align: start; width: 50%; }
    .rj-ns-tbl td { padding: 16px 22px; border-bottom: 1px solid #f1f5f9; text-align: center; }
    .rj-ns-tbl tbody tr:last-child td { border-bottom: 0; }
    .rj-ns-tbl tbody tr { transition: background .15s; }
    .rj-ns-tbl tbody tr:hover { background: #faf9ff; }
    .rj-ns-ev b { display: block; font-size: 14px; font-weight: 600; color: #0f172a; }
    .rj-ns-ev span { display: block; margin-top: 2px; font-size: 12px; color: #64748b; }
    .rj-ns-none { padding: 48px 16px !important; color: #94a3b8; text-align: center !important; }

    .rj-ns-chk {
        -webkit-appearance: none; appearance: none; display: inline-grid; place-content: center;
        width: 24px; height: 24px; margin: 0; border: 2px solid #cbd5e1; border-radius: 8px;
        background: #fff; cursor: pointer; transition: background .15s, border-color .15s, transform .15s;
    }
    .rj-ns-chk:hover { border-color: #a78bfa; }
    .rj-ns-chk:active { transform: scale(.9); }
    .rj-ns-chk:checked { border-color: transparent; background: linear-gradient(135deg, #8b5cf6, #ec4899); }
    .rj-ns-chk:checked::after {
        content: ""; width: 6px; height: 11px; margin-top: -2px;
        border: solid #fff; border-width: 0 2.5px 2.5px 0; transform: rotate(45deg);
    }
    .rj-ns-chk:focus-visible { outline: 3px solid rgba(139,92,246,.35); outline-offset: 2px; }

    .rj-ns-foot { display: flex; justify-content: flex-end; padding: 16px 22px; border-top: 1px solid #f1f5f9; background: #f8fafc; }
    .rj-ns-save {
        display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; border: 0; border-radius: 12px; cursor: pointer;
        background: linear-gradient(135deg, #8b5cf6, #ec4899); color: #fff; font: inherit; font-size: 14px; font-weight: 700;
        box-shadow: 0 12px 24px -12px rgba(139,92,246,.9); transition: transform .15s, box-shadow .15s;
    }
    .rj-ns-save:hover { transform: translateY(-1px); box-shadow: 0 16px 28px -12px rgba(139,92,246,1); }
    .rj-ns-save:active { transform: scale(.97); }
    .rj-ns-save:focus-visible { outline: 3px solid rgba(139,92,246,.35); outline-offset: 2px; }
    .rj-ns-save svg { width: 16px; height: 16px; }

    @media (max-width: 767px) {
        .rj-ns-head { padding: 16px; }
        .rj-ns-body { padding: 16px; }
        .rj-ns-tbl th, .rj-ns-tbl td { padding-inline: 14px; }
        .rj-ns-foot { padding: 14px 16px; }
        .rj-ns-save { width: 100%; justify-content: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        .rj-ns-sw i::after, .rj-ns-play, .rj-ns-save, .rj-ns-back { transition: none; }
    }
</style>

<div class="rj-ns" x-data="soundSettings()">
    <div class="rj-ns-top">
        <div>
            <h1>{{ __('Notification Settings') }}</h1>
            <p>{{ __('Choose how and when you want to be notified about site events.') }}</p>
        </div>
        <a href="{{ route('admin.notifications.index') }}" class="rj-ns-back">
            <svg fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            {{ __('Back to Notifications') }}
        </a>
    </div>

    @if(session('success'))
        <div class="rj-ns-alert ok">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rj-ns-alert err">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.settings.update') }}" style="display:flex;flex-direction:column;gap:24px;">
        @csrf
        @method('PUT')

        <div class="rj-ns-card">
            <div class="rj-ns-head">
                <div class="rj-ns-head-l">
                    <span class="rj-ns-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M11 5L6 9H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.07M19.07 4.93a10 10 0 010 14.14"/></svg>
                    </span>
                    <div>
                        <h2>{{ __('Sound Preferences') }}</h2>
                        <p>{{ __('Customize the sound played when a new notification arrives.') }}</p>
                    </div>
                </div>

                <label class="rj-ns-sw" aria-label="{{ __('Sound Preferences') }}">
                    <input type="hidden" name="sound_enabled" value="0">
                    <input type="checkbox" name="sound_enabled" value="1" x-model="soundEnabled" @change="if (!soundEnabled) stopPreview()">
                    <i></i>
                </label>
            </div>

            <div class="rj-ns-body" :class="!soundEnabled ? 'is-off' : ''">
                <div class="rj-ns-grid">
                    <div>
                        <div class="rj-ns-lbl"><label for="rj-ns-sound">{{ __('Notification Sound') }}</label></div>
                        <div class="rj-ns-pick">
                            <select id="rj-ns-sound" name="sound" x-model="selectedSound" @change="stopPreview(); playPreview()" class="rj-ns-select">
                                @foreach($sounds as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="button" @click="isPlaying ? stopPreview() : playPreview()" class="rj-ns-play" :aria-label="isPlaying ? '{{ __('Stop') }}' : '{{ __('Play') }}'">
                                <svg x-show="!isPlaying" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.14v13.72a1 1 0 001.53.85l10.3-6.86a1 1 0 000-1.7L9.53 4.29A1 1 0 008 5.14z"/></svg>
                                <svg x-show="isPlaying" x-cloak fill="currentColor" viewBox="0 0 24 24"><rect x="6" y="5" width="4" height="14" rx="1.2"/><rect x="14" y="5" width="4" height="14" rx="1.2"/></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="rj-ns-lbl">
                            <label for="rj-ns-vol">{{ __('Volume') }}</label>
                            <span class="rj-ns-val" x-text="volume + '%'"></span>
                        </div>
                        <input id="rj-ns-vol" type="range" name="sound_volume" min="0" max="100" step="1"
                               x-model="volume" @input="updateVolume()" :style="'--p:' + volume + '%'" class="rj-ns-range">
                        <div class="rj-ns-ends">
                            <span>{{ __('Silent') }}</span>
                            <span>{{ __('Loud') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rj-ns-card">
            <div class="rj-ns-head">
                <div class="rj-ns-head-l">
                    <span class="rj-ns-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4-5.66V5a2 2 0 10-4 0v.34C7.67 6.17 6 8.39 6 11v3.2c0 .53-.21 1.04-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </span>
                    <div>
                        <h2>{{ __('Events & Channels') }}</h2>
                        <p>{{ __('Select which channels should be used for each event.') }}</p>
                    </div>
                </div>
            </div>

            <div class="rj-ns-wrap">
                <table class="rj-ns-tbl">
                    <thead>
                        <tr>
                            <th>{{ __('Event') }}</th>
                            @foreach($channels as $channelKey => $channel)
                                <th>{{ $channel['label'] ?? ucfirst($channelKey) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $eventKey => $event)
                            <tr>
                                <td class="rj-ns-ev">
                                    <b>{{ $event['label'] ?? ucfirst($eventKey) }}</b>
                                    @if(!empty($event['description']))
                                        <span>{{ $event['description'] }}</span>
                                    @endif
                                </td>
                                @foreach($channels as $channelKey => $channel)
                                    <td>
                                        <input type="hidden" name="settings[{{ $eventKey }}][{{ $channelKey }}]" value="0">
                                        <input type="checkbox"
                                               name="settings[{{ $eventKey }}][{{ $channelKey }}]"
                                               value="1"
                                               @checked(old("settings.{$eventKey}.{$channelKey}", $settings[$eventKey]['channels'][$channelKey]['enabled'] ?? true))
                                               class="rj-ns-chk"
                                               aria-label="{{ ($event['label'] ?? ucfirst($eventKey)) . ' - ' . ($channel['label'] ?? ucfirst($channelKey)) }}">
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($channels) + 1 }}" class="rj-ns-none">{{ __('No notification events available.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="rj-ns-foot">
                <button type="submit" class="rj-ns-save">
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    {{ __('Save Preferences') }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function soundSettings() {
    return {
        soundEnabled: @js((bool) $soundEnabled),
        selectedSound: @js($currentSound),
        volume: @js((int) $soundVolume),
        isPlaying: false,
        audio: null,
        base: @js(asset('sounds/notifications')),

        init() {
            this.audio = new Audio();
            this.audio.onended = () => { this.isPlaying = false; };
            this.updateVolume();
        },

        playPreview() {
            if (!this.soundEnabled) return;

            this.stopPreview();
            this.audio.src = this.base + '/' + this.selectedSound + '.wav';
            this.audio.volume = this.volume / 100;

            this.audio.play().then(() => {
                this.isPlaying = true;
            }).catch(e => {
                this.isPlaying = false;
                console.error('Audio playback failed:', e);
            });
        },

        stopPreview() {
            if (this.audio) {
                this.audio.pause();
                this.audio.currentTime = 0;
            }
            this.isPlaying = false;
        },

        updateVolume() {
            if (this.audio) {
                this.audio.volume = this.volume / 100;
            }
        }
    }
}
</script>
@endsection