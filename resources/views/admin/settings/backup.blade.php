@extends('admin.settings.layout')

@section('settings')
<div class="space-y-6" x-data="{ mode: '{{ $options['backup_storage_mode'] ?? 'local' }}' }">

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">{{ __('Backup Settings') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Configure automatic backups and storage mode.') }}</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.backup.update') }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Storage Mode') }}</label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <label class="relative cursor-pointer">
                        <input type="radio" name="backup_storage_mode" value="local" x-model="mode" class="sr-only">
                        <div class="p-4 rounded-xl border-2 transition"
                             :class="mode === 'local' ? 'border-rj-purple bg-rj-purple/5' : 'border-gray-200 hover:border-gray-300'">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-rj-purple/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-rj-purple" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ __('Local Storage') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ __('Backups are saved on your server. Can download later.') }}</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="radio" name="backup_storage_mode" value="download" x-model="mode" class="sr-only">
                        <div class="p-4 rounded-xl border-2 transition"
                             :class="mode === 'download' ? 'border-rj-purple bg-rj-purple/5' : 'border-gray-200 hover:border-gray-300'">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-rj-purple/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-rj-purple" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ __('Download Only') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ __('Not saved on server. Downloads immediately. For small hosting.') }}</div>
                                </div>
                            </div>
                        </div>
                    </label>

                </div>
            </div>

            <div x-show="mode === 'local'" x-cloak x-transition class="border-t border-gray-100 pt-5 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Automatic Schedule') }}</label>
                    <select name="backup_schedule" class="w-full md:w-80 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        @foreach ($data['schedules'] as $value => $label)
                            <option value="{{ $value }}" {{ ($options['backup_schedule'] ?? 'never') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Requires cron job: php artisan schedule:run every minute.') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Keep Last N Backups') }}</label>
                    <input type="number" name="backup_retention" min="1" max="100"
                           value="{{ $options['backup_retention'] ?? '10' }}"
                           class="w-full md:w-40 rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    <p class="text-xs text-gray-500 mt-1">{{ __('Older backups are automatically deleted.') }}</p>
                </div>
            </div>

            <div x-show="mode === 'download'" x-cloak class="border-t border-gray-100 pt-5">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium">{{ __('Download mode active') }}</p>
                        <p class="mt-1 text-blue-700">{{ __('Backups are not stored on the server. When you click "Create Backup", the file downloads directly to your device. Automatic schedule is disabled.') }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-5">
                <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Include in Backup') }}</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="backup_include_db" value="1"
                               {{ ($options['backup_include_db'] ?? '1') === '1' ? 'checked' : '' }}
                               class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <span>
                            <span class="block text-sm font-medium text-gray-700">{{ __('Database') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('MySQL dump of all tables') }}</span>
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="backup_include_files" value="1"
                               {{ ($options['backup_include_files'] ?? '1') === '1' ? 'checked' : '' }}
                               class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <span>
                            <span class="block text-sm font-medium text-gray-700">{{ __('Files') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('Uploads and public storage') }}</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-5">
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition">
                    {{ __('Save Settings') }}
                </button>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">{{ __('Create Manual Backup') }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    <span x-show="mode === 'local'">{{ __('Backup will be saved on server.') }}</span>
                    <span x-show="mode === 'download'" x-cloak>{{ __('Backup will download immediately.') }}</span>
                </p>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-3">

            <form method="POST" action="{{ route('admin.settings.backup.create') }}" class="js-backup-form">
                @csrf
                <input type="hidden" name="type" value="database">
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 rounded-xl border border-gray-200 hover:border-rj-purple/30 hover:bg-rj-purple/5 transition text-left">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Database Only') }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('MySQL dump (.sql)') }}</div>
                    </div>
                </button>
            </form>

            <form method="POST" action="{{ route('admin.settings.backup.create') }}" class="js-backup-form">
                @csrf
                <input type="hidden" name="type" value="site">
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 rounded-xl border border-gray-200 hover:border-rj-purple/30 hover:bg-rj-purple/5 transition text-left">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Files Only') }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('Uploads and storage (.zip)') }}</div>
                    </div>
                </button>
            </form>

            <form method="POST" action="{{ route('admin.settings.backup.create') }}" class="js-backup-form">
                @csrf
                <input type="hidden" name="type" value="full">
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 rounded-xl border-2 border-rj-purple/20 hover:border-rj-purple/40 bg-rj-purple/5 hover:bg-rj-purple/10 transition text-left">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-rj-purple to-rj-pink flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Full Backup') }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('Database + files (.zip)') }}</div>
                    </div>
                </button>
            </form>

        </div>
    </div>

    <div x-show="mode === 'local'" x-cloak class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">{{ __('Stored Backups') }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $data['stats']['count'] }} {{ __('files') }} · {{ $data['stats']['total_size'] }}
                    · {{ __('Disk free') }}: {{ $data['stats']['disk_free'] }} / {{ $data['stats']['disk_total'] }}
                </p>
            </div>
        </div>

        @if (empty($data['backups']))
            <div class="p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                <p class="mt-3 text-sm text-gray-500">{{ __('No backups yet. Create your first backup above.') }}</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($data['backups'] as $backup)
                    <div class="px-6 py-4 flex items-center justify-between gap-4 hover:bg-gray-50/50">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                @if ($backup['extension'] === 'sql')
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                                @else
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/></svg>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-gray-900 font-mono truncate">{{ $backup['name'] }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $backup['created_at'] }} · {{ $backup['age'] }} · {{ $backup['size'] }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="button"
                                    class="js-restore-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-amber-300 bg-amber-50 text-xs font-medium text-amber-700 hover:bg-amber-100 transition"
                                    data-filename="{{ $backup['name'] }}"
                                    data-type="{{ $backup['storage'] }}"
                                    data-restore-url="{{ route('admin.settings.backup.restore', $backup['name']) }}"
                                    data-confirm="{{ __('Restore this backup? Current data will be overwritten.') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                {{ __('Restore') }}
                            </button>

                            <a href="{{ route('admin.settings.backup.download', $backup['name']) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                {{ __('Download') }}
                            </a>

                            <form method="POST" action="{{ route('admin.settings.backup.delete', $backup['name']) }}"
                                  onsubmit="return confirm('{{ __('Delete this backup?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="bkProgressOverlay" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-5">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
                <div id="bkProgressSpinner" class="w-9 h-9 flex-none rounded-full border-[3px] border-rj-purple/20 border-t-rj-purple animate-spin"></div>
                <div class="flex-1 min-w-0">
                    <div id="bkProgressTitle" class="text-base font-semibold text-gray-900">{{ __('Processing...') }}</div>
                    <div id="bkProgressSub" class="text-xs text-gray-500 mt-0.5">{{ __('Please do not close this tab') }}</div>
                </div>
            </div>

            <div class="px-6 py-5">
                <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div id="bkProgressBar" class="h-full w-0 rounded-full bg-gradient-to-r from-rj-purple to-rj-pink transition-all duration-500"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span id="bkProgressLabel">{{ __('Starting...') }}</span>
                    <b id="bkProgressPct" class="text-gray-900">0%</b>
                </div>

                <div id="bkProgressMessage" class="hidden mt-4 p-3 rounded-lg text-sm"></div>
            </div>

            <div class="px-6 pb-5 flex justify-end">
                <button type="button" id="bkProgressClose" class="hidden px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90">
                    {{ __('Reload Page') }}
                </button>
            </div>
        </div>
    </div>

</div>

<script>
(function () {
    var progressUrl = @json(route('admin.settings.backup.progress'));
    var overlay = document.getElementById('bkProgressOverlay');
    var spinner = document.getElementById('bkProgressSpinner');
    var pTitle = document.getElementById('bkProgressTitle');
    var pSub = document.getElementById('bkProgressSub');
    var pBar = document.getElementById('bkProgressBar');
    var pPct = document.getElementById('bkProgressPct');
    var pLabel = document.getElementById('bkProgressLabel');
    var pMsg = document.getElementById('bkProgressMessage');
    var pClose = document.getElementById('bkProgressClose');

    var pollTimer = null;

    function openOverlay(title, sub) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
        pTitle.textContent = title || '{{ __('Processing...') }}';
        pSub.textContent = sub || '{{ __('Please do not close this tab') }}';
        pBar.style.width = '0%';
        pPct.textContent = '0%';
        pLabel.textContent = '{{ __('Starting...') }}';
        spinner.className = 'w-9 h-9 flex-none rounded-full border-[3px] border-rj-purple/20 border-t-rj-purple animate-spin';
        pMsg.classList.add('hidden');
        pMsg.className = 'hidden mt-4 p-3 rounded-lg text-sm';
        pClose.classList.add('hidden');
    }

    function closeOverlay() {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function poll() {
        fetch(progressUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data) return;
                var pct = Math.max(0, Math.min(100, parseInt(data.percent, 10) || 0));
                pBar.style.width = pct + '%';
                pPct.textContent = pct + '%';
                if (data.label) pLabel.textContent = data.label;

                if (data.status === 'success') {
                    clearInterval(pollTimer);
                    spinner.className = 'w-9 h-9 flex-none rounded-full bg-green-500 flex items-center justify-center text-white';
                    spinner.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                    pTitle.textContent = '{{ __('Complete') }}';
                    pSub.textContent = '{{ __('The page will reload shortly') }}';
                    pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-green-50 border border-green-200 text-green-800';
                    pMsg.textContent = data.label || '';
                    pMsg.classList.remove('hidden');
                    pClose.classList.remove('hidden');
                    setTimeout(function () { window.location.reload(); }, 2000);
                    return;
                }

                if (data.status === 'error') {
                    clearInterval(pollTimer);
                    spinner.className = 'w-9 h-9 flex-none rounded-full bg-red-500 flex items-center justify-center text-white';
                    spinner.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                    pTitle.textContent = '{{ __('Failed') }}';
                    pSub.textContent = '{{ __('An error occurred') }}';
                    pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-800';
                    pMsg.textContent = data.label || '';
                    pMsg.classList.remove('hidden');
                    pClose.classList.remove('hidden');
                    return;
                }
            })
            .catch(function () {});
    }

    function startPolling() {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(poll, 1000);
        poll();
    }

    document.querySelectorAll('.js-backup-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            openOverlay('{{ __('Creating Backup') }}', '{{ __('Please do not close this tab') }}');
            startPolling();

            var fd = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: fd,
                credentials: 'same-origin'
            })
                .then(function (r) {
                    var ct = r.headers.get('Content-Type') || '';
                    if (ct.indexOf('application/json') !== -1) {
                        return r.json().then(function (j) { return { json: j, response: r }; });
                    }
                    return { json: null, response: r };
                })
                .then(function (result) {
                    if (result.json && !result.json.success) {
                        clearInterval(pollTimer);
                        spinner.className = 'w-9 h-9 flex-none rounded-full bg-red-500 flex items-center justify-center text-white';
                        spinner.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                        pTitle.textContent = '{{ __('Failed') }}';
                        pSub.textContent = '';
                        pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-800';
                        pMsg.textContent = result.json.message || '{{ __('Unknown error') }}';
                        pMsg.classList.remove('hidden');
                        pClose.classList.remove('hidden');
                    }
                })
                .catch(function (err) {
                    clearInterval(pollTimer);
                    pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-800';
                    pMsg.textContent = err.message || '{{ __('Network error') }}';
                    pMsg.classList.remove('hidden');
                    pClose.classList.remove('hidden');
                });
        });
    });

    document.querySelectorAll('.js-restore-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var msg = btn.getAttribute('data-confirm') || '{{ __('Restore this backup?') }}';
            if (!window.confirm(msg)) return;

            var url = btn.getAttribute('data-restore-url');
            var type = btn.getAttribute('data-type') || 'local';

            openOverlay('{{ __('Restoring Backup') }}', '{{ __('Please do not close this tab') }}');
            startPolling();

            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('_method', 'POST');
            fd.append('type', type);

            fetch(url, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: fd,
                credentials: 'same-origin'
            })
                .then(function (r) { return r.json().then(function (j) { return { json: j, ok: r.ok }; }); })
                .then(function (result) {
                    if (result.json && !result.json.success) {
                        clearInterval(pollTimer);
                        spinner.className = 'w-9 h-9 flex-none rounded-full bg-red-500 flex items-center justify-center text-white';
                        spinner.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                        pTitle.textContent = '{{ __('Restore Failed') }}';
                        pSub.textContent = '';
                        pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-800';
                        pMsg.textContent = result.json.message || '{{ __('Unknown error') }}';
                        pMsg.classList.remove('hidden');
                        pClose.classList.remove('hidden');
                    }
                })
                .catch(function (err) {
                    clearInterval(pollTimer);
                    pMsg.className = 'mt-4 p-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-800';
                    pMsg.textContent = err.message || '{{ __('Network error') }}';
                    pMsg.classList.remove('hidden');
                    pClose.classList.remove('hidden');
                });
        });
    });

    pClose.addEventListener('click', function () {
        window.location.reload();
    });
})();
</script>
@endsection