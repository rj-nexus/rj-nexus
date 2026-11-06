@extends('admin.settings.layout')

@section('settings')
    @php
        $proxyStatus = $proxyStatus ?? ['behind_proxy' => false, 'trusted' => false, 'remote_addr' => '', 'laravel_ip' => '', 'cf_ip' => '', 'forwarded_for' => ''];
        $showProxyWarning = $proxyStatus['behind_proxy'] && !$proxyStatus['trusted'];
    @endphp

    <form method="POST" action="{{ route('admin.settings.security.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Admin Security') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Protect admin panel access.') }}</p>
            </div>

            <div class="flex items-center justify-between py-3 border-t border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ __('Two-Factor Authentication') }}</div>
                    <div class="text-xs text-gray-500">{{ __('Require 2FA for all admin users.') }}</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="admin_2fa_enabled" value="0">
                    <input type="checkbox" name="admin_2fa_enabled" value="1" @checked(old('admin_2fa_enabled', $options['admin_2fa_enabled'] ?? '0') === '1') class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-rj-purple peer-checked:to-rj-pink transition after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('2FA Method') }}</label>
                <select name="admin_2fa_method" class="w-full max-w-xs rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                    <option value="authenticator" @selected(old('admin_2fa_method', $options['admin_2fa_method'] ?? 'authenticator') === 'authenticator')>{{ __('Authenticator App') }}</option>
                    <option value="email" @selected(old('admin_2fa_method', $options['admin_2fa_method'] ?? '') === 'email')>{{ __('Email') }}</option>
                    <option value="sms" @selected(old('admin_2fa_method', $options['admin_2fa_method'] ?? '') === 'sms')>{{ __('SMS') }}</option>
                </select>
                <div class="text-xs text-gray-500 mt-1">{{ __('Note: SMS requires an external gateway configuration.') }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Frontend Security') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Protect user accounts on the public site.') }}</p>
            </div>

            <div class="flex items-center justify-between py-3 border-t border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ __('Enable 2FA for Users') }}</div>
                    <div class="text-xs text-gray-500">{{ __('Allow users to secure their accounts.') }}</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="frontend_2fa_enabled" value="0">
                    <input type="checkbox" name="frontend_2fa_enabled" value="1" @checked(old('frontend_2fa_enabled', $options['frontend_2fa_enabled'] ?? '0') === '1') class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-rj-purple peer-checked:to-rj-pink transition after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pl-0 sm:pl-4">
                <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-rj-purple/40 cursor-pointer">
                    <input type="hidden" name="frontend_2fa_email" value="0">
                    <input type="checkbox" name="frontend_2fa_email" value="1" @checked(old('frontend_2fa_email', $options['frontend_2fa_email'] ?? '0') === '1') class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Email Code') }}</div>
                        <div class="text-xs text-gray-500">{{ __('Send code to email') }}</div>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-rj-purple/40 cursor-pointer">
                    <input type="hidden" name="frontend_2fa_mobile" value="0">
                    <input type="checkbox" name="frontend_2fa_mobile" value="1" @checked(old('frontend_2fa_mobile', $options['frontend_2fa_mobile'] ?? '0') === '1') class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('SMS Code') }}</div>
                        <div class="text-xs text-gray-500">{{ __('Requires gateway') }}</div>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:border-rj-purple/40 cursor-pointer">
                    <input type="hidden" name="frontend_2fa_authenticator" value="0">
                    <input type="checkbox" name="frontend_2fa_authenticator" value="1" @checked(old('frontend_2fa_authenticator', $options['frontend_2fa_authenticator'] ?? '0') === '1') class="mt-0.5 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Authenticator') }}</div>
                        <div class="text-xs text-gray-500">{{ __('Google, Authy and more') }}</div>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-between py-3 border-t border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ __('Require Email Verification') }}</div>
                    <div class="text-xs text-gray-500">{{ __('Users must verify their email before logging in.') }}</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="require_email_verification" value="0">
                    <input type="checkbox" name="require_email_verification" value="1" @checked(old('require_email_verification', $options['require_email_verification'] ?? '0') === '1') class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-rj-purple peer-checked:to-rj-pink transition after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5" x-data="{ kycDriver: '{{ old('kyc_driver', $options['kyc_driver'] ?? 'manual') }}' }">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('KYC Verification') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Request identity verification from users.') }}</p>
            </div>

            <div class="flex items-center justify-between py-3 border-t border-gray-100">
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ __('Enable KYC') }}</div>
                    <div class="text-xs text-gray-500">{{ __('Ask users to verify their identity.') }}</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="kyc_enabled" value="0">
                    <input type="checkbox" name="kyc_enabled" value="1" @checked(old('kyc_enabled', $options['kyc_enabled'] ?? '0') === '1') class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-rj-purple peer-checked:to-rj-pink transition after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('KYC Driver') }}</label>
                <select name="kyc_driver" x-model="kycDriver" class="w-full max-w-xs rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                    <option value="manual">{{ __('Manual Review (Admin)') }}</option>
                    <option value="api">{{ __('External API (Sumsub, Onfido)') }}</option>
                </select>
            </div>

            <div x-show="kycDriver === 'api'" x-cloak class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('API Endpoint') }}</label>
                    <input type="url" name="kyc_api_endpoint" value="{{ old('kyc_api_endpoint', $options['kyc_api_endpoint'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple" placeholder="https://api.sumsub.com">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('API Key') }}</label>
                        <input type="text" name="kyc_api_key" value="{{ old('kyc_api_key', $options['kyc_api_key'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple font-mono text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('API Secret') }}</label>
                        <input type="password" name="kyc_api_secret" value="{{ old('kyc_api_secret', $options['kyc_api_secret'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple font-mono text-sm">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('KYC Level') }}</label>
                <select name="kyc_level" class="w-full max-w-xs rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                    <option value="none" @selected(old('kyc_level', $options['kyc_level'] ?? 'none') === 'none')>{{ __('None') }}</option>
                    <option value="basic" @selected(old('kyc_level', $options['kyc_level'] ?? '') === 'basic')>{{ __('Basic') }}</option>
                    <option value="standard" @selected(old('kyc_level', $options['kyc_level'] ?? '') === 'standard')>{{ __('Standard') }}</option>
                    <option value="advanced" @selected(old('kyc_level', $options['kyc_level'] ?? '') === 'advanced')>{{ __('Advanced') }}</option>
                </select>
            </div>

            @php
                $kycFields = json_decode($options['kyc_required_fields'] ?? '[]', true) ?: [];
            @endphp

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Required Fields') }}</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="full_name" @checked(in_array('full_name', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('Full Name') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="phone" @checked(in_array('phone', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('Phone') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="address" @checked(in_array('address', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('Address') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="id_card" @checked(in_array('id_card', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('ID Card') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="passport" @checked(in_array('passport', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('Passport') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="kyc_required_fields[]" value="selfie" @checked(in_array('selfie', $kycFields)) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        {{ __('Selfie') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Proxy & IP Detection') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Verify how your server detects client IP addresses before enabling IP-based features.') }}</p>
            </div>

            @if($showProxyWarning)
                <div class="border border-amber-200 bg-amber-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-amber-900">{{ __('Proxy or Cloudflare detected') }}</div>
                            <p class="text-xs text-amber-800 mt-1 leading-relaxed">{{ __('Your site appears to be behind a proxy or CDN. IP-based features (whitelist, blacklist, rate limiting) will use the proxy\'s IP instead of the visitor\'s real IP. This can lock you out of the admin panel.') }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-amber-200 p-3 font-mono text-xs space-y-1.5">
                        @if($proxyStatus['cf_ip'])
                            <div class="flex justify-between gap-4"><span class="text-gray-500">CF-Connecting-IP:</span><span class="text-gray-900">{{ $proxyStatus['cf_ip'] }}</span></div>
                        @endif
                        @if($proxyStatus['forwarded_for'])
                            <div class="flex justify-between gap-4"><span class="text-gray-500">X-Forwarded-For:</span><span class="text-gray-900 truncate">{{ $proxyStatus['forwarded_for'] }}</span></div>
                        @endif
                        <div class="flex justify-between gap-4"><span class="text-gray-500">REMOTE_ADDR:</span><span class="text-gray-900">{{ $proxyStatus['remote_addr'] }}</span></div>
                        <div class="flex justify-between gap-4 border-t border-gray-100 pt-1.5"><span class="text-gray-500">request()->ip():</span><span class="text-red-600 font-semibold">{{ $proxyStatus['laravel_ip'] }} &larr; not real</span></div>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="text-xs text-red-800 leading-relaxed">
                            <strong>{{ __('IP Whitelist auto-disabled') }}</strong> {{ __('to prevent self-lockout. Configure') }} <code class="bg-white px-1.5 py-0.5 rounded border border-red-200">trustProxies</code> {{ __('in') }} <code class="bg-white px-1.5 py-0.5 rounded border border-red-200">bootstrap/app.php</code> {{ __('to enable IP-based features.') }}
                        </div>
                    </div>

                    <details class="text-xs">
                        <summary class="cursor-pointer font-semibold text-amber-900 hover:text-amber-950 select-none">{{ __('How to fix — configure trusted proxies') }}</summary>
                        <div class="mt-3 space-y-2">
                            <p class="text-amber-800 leading-relaxed">{{ __('Add this to') }} <code class="bg-white px-1.5 py-0.5 rounded border border-amber-200 font-mono">bootstrap/app.php</code>:</p>
                            <pre class="bg-gray-900 text-gray-100 rounded-lg p-3 overflow-x-auto text-[11px] leading-relaxed"><code>-&gt;withMiddleware(function (Middleware $middleware) {
    $middleware-&gt;trustProxies(at: [
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '104.16.0.0/13',
        '172.64.0.0/13',
        '131.0.72.0/22',
    ]);
})</code></pre>
                            <p class="text-amber-800 leading-relaxed">{{ __('Full list:') }} <a href="https://www.cloudflare.com/ips/" target="_blank" class="underline font-medium">cloudflare.com/ips</a>. {{ __('After editing, run') }} <code class="bg-white px-1.5 py-0.5 rounded border border-amber-200 font-mono">php artisan config:clear</code>.</p>
                        </div>
                    </details>
                </div>
            @elseif($proxyStatus['behind_proxy'] && $proxyStatus['trusted'])
                <div class="border border-green-200 bg-green-50 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-green-900">{{ __('Proxy detected and configured correctly') }}</div>
                        <p class="text-xs text-green-800 mt-1 leading-relaxed">{{ __('Your site is behind a proxy, but Laravel is configured to trust it. Real client IPs are detected correctly.') }}</p>
                        <div class="mt-2 font-mono text-xs space-y-1">
                            @if($proxyStatus['cf_ip'])
                                <div class="flex justify-between gap-4"><span class="text-green-700">CF-Connecting-IP:</span><span class="text-green-900">{{ $proxyStatus['cf_ip'] }}</span></div>
                            @endif
                            <div class="flex justify-between gap-4"><span class="text-green-700">request()->ip():</span><span class="text-green-900 font-semibold">{{ $proxyStatus['laravel_ip'] }} &#10003;</span></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="border border-green-200 bg-green-50 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-green-900">{{ __('No proxy detected') }}</div>
                        <p class="text-xs text-green-800 mt-1 leading-relaxed">{{ __('Your server receives connections directly. IP-based features (whitelist, blacklist, rate limiting) work correctly.') }}</p>
                        <div class="mt-2 font-mono text-xs">
                            <span class="text-green-700">request()->ip():</span>
                            <span class="text-green-900 font-semibold ml-2">{{ $proxyStatus['laravel_ip'] }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Advanced Protection') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Additional security layers.') }}</p>
            </div>

            <div class="space-y-4">
                <div>
                    <div class="text-sm font-medium text-gray-900 mb-2">{{ __('Login Rate Limit') }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Attempts') }}</label>
                            <input type="number" name="login_limit" min="1" max="100" value="{{ old('login_limit', $options['login_limit'] ?? 5) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Lockout (minutes)') }}</label>
                            <input type="number" name="login_lockout_minutes" min="1" max="1440" value="{{ old('login_lockout_minutes', $options['login_lockout_minutes'] ?? 15) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <div class="text-sm font-medium text-gray-900 mb-2">{{ __('Registration Rate Limit') }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Attempts') }}</label>
                            <input type="number" name="register_limit" min="1" max="100" value="{{ old('register_limit', $options['register_limit'] ?? 10) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Lockout (minutes)') }}</label>
                            <input type="number" name="register_lockout_minutes" min="1" max="1440" value="{{ old('register_lockout_minutes', $options['register_lockout_minutes'] ?? 60) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <div class="text-sm font-medium text-gray-900 mb-2">{{ __('2FA / OTP Rate Limit') }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Attempts') }}</label>
                            <input type="number" name="otp_limit" min="1" max="100" value="{{ old('otp_limit', $options['otp_limit'] ?? 6) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">{{ __('Lockout (minutes)') }}</label>
                            <input type="number" name="otp_lockout_minutes" min="1" max="1440" value="{{ old('otp_lockout_minutes', $options['otp_lockout_minutes'] ?? 1) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                        </div>
                    </div>
                </div>
            </div>

            @php
                $appUrlIsHttps = str_starts_with((string) config('app.url'), 'https://');
                $currentRequestSecure = request()->secure();
                $currentIp = request()->ip();
                $whitelistRaw = (string) ($options['ip_whitelist'] ?? '');
                $currentIpIsListed = false;
                foreach (preg_split('/\r\n|\r|\n/', $whitelistRaw) as $line) {
                    if (trim($line) === $currentIp) {
                        $currentIpIsListed = true;
                        break;
                    }
                }
            @endphp

            <div class="space-y-3 pt-2">
                <div class="flex items-start justify-between gap-4 py-3 border-t border-gray-100">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ __('Force HTTPS') }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ __('Redirect every HTTP request to HTTPS. Enable only after your SSL certificate works.') }}</div>
                        @if(!$appUrlIsHttps)
                            <div class="mt-2 flex items-start gap-2 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ __('Your site URL is not HTTPS. Turning this on without SSL will make the site unreachable.') }}</span>
                            </div>
                        @endif
                        @if(!$currentRequestSecure)
                            <div class="mt-2 text-xs text-gray-500">{{ __('You are currently connected over HTTP.') }}</div>
                        @endif
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
                        <input type="hidden" name="force_https" value="0">
                        <input type="checkbox" name="force_https" value="1" @checked(old('force_https', $options['force_https'] ?? '0') === '1') class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-rj-purple peer-checked:to-rj-pink transition after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                    </label>
                </div>

                <label class="flex items-center justify-between py-2 border-t border-gray-100">
                    <span class="text-sm text-gray-700">{{ __('Enable CAPTCHA') }}</span>
                    <input type="hidden" name="captcha_enabled" value="0">
                    <input type="checkbox" name="captcha_enabled" value="1" @checked(old('captcha_enabled', $options['captcha_enabled'] ?? '0') === '1') class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                </label>

                <label class="flex items-center justify-between py-2 border-t border-gray-100 {{ $showProxyWarning ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <span class="text-sm text-gray-700">
                        {{ __('IP Whitelist') }}
                        @if($showProxyWarning)
                            <span class="text-xs text-amber-600 font-medium ml-2">({{ __('Auto-disabled due to proxy') }})</span>
                        @endif
                    </span>
                    <input type="hidden" name="ip_whitelist_enabled" value="0">
                    <input type="checkbox" name="ip_whitelist_enabled" value="1" @checked(!$showProxyWarning && old('ip_whitelist_enabled', $options['ip_whitelist_enabled'] ?? '0') === '1') @disabled($showProxyWarning) class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple disabled:opacity-50">
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Allowed IPs') }}</label>

                <div class="mb-2 flex items-center gap-2 text-xs">
                    <span class="text-gray-500">{{ __('Your current IP:') }}</span>
                    <code class="px-2 py-1 rounded bg-gray-100 text-gray-900 font-mono">{{ $currentIp }}</code>
                    @if($currentIpIsListed)
                        <span class="text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded">{{ __('Listed') }}</span>
                    @else
                        <span class="text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">{{ __('Not in list') }}</span>
                    @endif
                </div>

                @if(!$currentIpIsListed && !$showProxyWarning)
                    <div class="mb-2 flex items-start gap-2 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ __('Add your current IP to the list before enabling the whitelist, otherwise you will be locked out of the admin panel.') }}</span>
                    </div>
                @endif

                <textarea name="ip_whitelist" rows="4" placeholder="192.168.1.1&#10;10.0.0.1" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple font-mono text-sm">{{ old('ip_whitelist', $options['ip_whitelist'] ?? '') }}</textarea>
                <div class="text-xs text-gray-500 mt-1">{{ __('One IP per line. Invalid entries are ignored. If the list is empty, the whitelist is disabled even if enabled above.') }}</div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-gradient-to-r from-rj-purple to-rj-pink text-white px-5 py-2.5 rounded-lg font-medium hover:opacity-90 transition">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
