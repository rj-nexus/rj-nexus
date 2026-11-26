@extends('admin.layouts.app')

@section('title', __('Notification Settings'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="soundSettings()">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Notification Settings') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Choose how and when you want to be notified about site events.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.notifications.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">{{ __('Back to Notifications') }}</a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-900">{{ __('Sound Preferences') }}</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Customize the sound played when a new notification arrives.') }}</p>
                </div>
                
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="sound_enabled" value="0">
                    <input type="checkbox" name="sound_enabled" value="1" x-model="soundEnabled" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rj-purple"></div>
                </label>
            </div>

            <div class="p-6 transition-opacity duration-300" :class="!soundEnabled ? 'opacity-40 pointer-events-none' : ''">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Notification Sound') }}</label>
                        <div class="flex gap-2">
                            <select name="sound" x-model="selectedSound" @change="stopPreview()" class="flex-1 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                                @foreach($sounds as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="button" @click="playPreview()" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-rj-purple/10 text-rj-purple hover:bg-rj-purple/20 transition focus:outline-none focus:ring-2 focus:ring-rj-purple/50">
                                <svg x-show="!isPlaying" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <svg x-show="isPlaying" x-cloak class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Volume') }}</label>
                            <span class="text-xs font-bold text-rj-purple" x-text="volume + '%'"></span>
                        </div>
                        <input type="range" name="sound_volume" min="0" max="100" x-model="volume" @input="updateVolume()" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-rj-purple">
                        <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                            <span>{{ __('Silent') }}</span>
                            <span>{{ __('Loud') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-sm font-bold text-gray-900">{{ __('Events & Channels') }}</h2>
                <p class="text-xs text-gray-500 mt-1">{{ __('Select which channels should be used for each event.') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold w-1/2">{{ __('Event') }}</th>
                            @foreach($channels as $channelKey => $channel)
                                <th class="px-6 py-3 font-semibold text-center">{{ $channel['label'] ?? ucfirst($channelKey) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($events as $eventKey => $event)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $event['label'] ?? ucfirst($eventKey) }}</div>
                                    @if(!empty($event['description']))
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $event['description'] }}</div>
                                    @endif
                                </td>
                                @foreach($channels as $channelKey => $channel)
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center justify-center cursor-pointer">
                                            <input type="hidden" name="settings[{{ $eventKey }}][{{ $channelKey }}]" value="0">
                                            <input type="checkbox"
                                                   name="settings[{{ $eventKey }}][{{ $channelKey }}]"
                                                   value="1"
                                                   @checked(old("settings.{$eventKey}.{$channelKey}", $settings[$eventKey]['channels'][$channelKey]['enabled'] ?? true))
                                                   class="w-5 h-5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple transition">
                                        </label>
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($channels) + 1 }}" class="px-6 py-12 text-center text-gray-500">
                                    <p>{{ __('No notification events available.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    {{ __('Save Preferences') }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function soundSettings() {
    return {
        soundEnabled: {{ $soundEnabled ? 'true' : 'false' }},
        selectedSound: '{{ $currentSound }}',
        volume: {{ $soundVolume }},
        isPlaying: false,
        audio: null,

        init() {
            this.audio = new Audio();
            this.audio.onended = () => { this.isPlaying = false; };
            this.updateVolume();
        },

        playPreview() {
            if (!this.soundEnabled) return;
            
            this.stopPreview();
            this.audio.src = `{{ asset('sounds/notifications') }}/${this.selectedSound}.wav`;
            this.audio.volume = this.volume / 100;
            
            this.audio.play().then(() => {
                this.isPlaying = true;
            }).catch(e => {
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