@extends('admin.layouts.app')

@section('title', __('Notification Settings'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
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
                                                   @checked(old("settings.{$eventKey}.{$channelKey}", $settings[$eventKey][$channelKey] ?? true))
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
@endsection
