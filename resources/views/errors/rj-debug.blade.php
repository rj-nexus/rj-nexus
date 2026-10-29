<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $statusCode }} | RJ Nexus — System Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        rjbg: '#0b0f19',
                        rjcard: '#111827',
                        rjborder: '#1f2937',
                        rjaccent: '#8b5cf6',
                        rjaccent2: '#ec4899',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0b0f19; color: #f3f4f6; margin: 0; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glow { box-shadow: 0 0 40px -10px rgba(139, 92, 246, 0.3); }
        .glass { background: rgba(17, 24, 39, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .scrollbar-custom::-webkit-scrollbar { width: 8px; height: 8px; }
        .scrollbar-custom::-webkit-scrollbar-track { background: #0b0f19; border-radius: 4px; }
        .scrollbar-custom::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        .scrollbar-custom::-webkit-scrollbar-thumb:hover { background: #4b5563; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-rjaccent selection:text-white">

    <header class="w-full border-b border-rjborder bg-rjbg/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.svg') }}" alt="RJ Nexus" class="h-8 w-auto" style="filter: brightness(0) invert(1);">
                <span class="px-2 py-0.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-semibold uppercase tracking-wider ml-2">Debug Mode</span>
            </div>
            <div class="flex items-center gap-4 text-sm text-gray-400 font-medium">
                <span>Laravel {{ app()->version() }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                <span>PHP {{ PHP_VERSION }}</span>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="glass rounded-2xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl font-bold text-white mb-2 break-words">
                            {{ $exception->getMessage() ?: 'A server error occurred.' }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10 font-mono text-gray-300">
                                {{ get_class($exception) }}
                            </span>
                            <span class="text-gray-500">at</span>
                            <span class="font-mono text-rjaccent break-all">
                                {{ $exception->getFile() }}:{{ $exception->getLine() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">Stack Trace</h2>
                <div class="space-y-2 font-mono text-xs scrollbar-custom max-h-[500px] overflow-y-auto pr-2">
                    @foreach(collect($exception->getTrace())->take(20) as $key => $trace)
                        <div class="p-3 rounded-lg bg-black/40 border border-white/5 hover:border-rjaccent/30 transition-colors">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-rjaccent font-bold">#{{ $key }}</span>
                                <span class="text-gray-300">{{ $trace['file'] ?? 'Unknown File' }}</span>
                                <span class="text-gray-500">:{{ $trace['line'] ?? '0' }}</span>
                            </div>
                            <div class="text-gray-400 pl-4 border-l-2 border-rjborder py-0.5">
                                {{ $trace['class'] ?? '' }}{{ $trace['type'] ?? '' }}{{ $trace['function'] ?? '' }}()
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass rounded-2xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">Request Details</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Method</div>
                        <div class="font-mono text-sm font-bold text-emerald-400">{{ request()->method() }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">URL</div>
                        <div class="font-mono text-sm text-gray-200 break-all">{{ request()->fullUrl() }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">IP Address</div>
                        <div class="font-mono text-sm text-gray-200">{{ request()->ip() }}</div>
                    </div>
                    @if(request()->user())
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Authenticated User</div>
                        <div class="text-sm text-gray-200">{{ request()->user()->name }} (ID: {{ request()->user()->id }})</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="glass rounded-2xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">Environment</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">App Env</span>
                        <span class="font-mono text-gray-200">{{ app()->environment() }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Debug Mode</span>
                        <span class="font-mono text-red-400">{{ config('app.debug') ? 'TRUE' : 'FALSE' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-gray-500">Timezone</span>
                        <span class="font-mono text-gray-200">{{ config('app.timezone') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Memory Usage</span>
                        <span class="font-mono text-gray-200">{{ round(memory_get_peak_usage() / 1024 / 1024, 2) }} MB</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ url('/') }}" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-rjaccent text-white font-semibold hover:bg-purple-600 transition-colors shadow-lg shadow-rjaccent/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Return Home
                </a>
            </div>
        </div>
    </main>

    <footer class="border-t border-rjborder py-6 text-center text-sm text-gray-600">
        RJ Nexus &copy; {{ date('Y') }} — Built with Laravel. All rights reserved.
    </footer>

</body>
</html>
