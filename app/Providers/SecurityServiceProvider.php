<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SecurityServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));
            $key = Str::transliterate($email . '|' . $request->ip());

            return Limit::perMinutes(
                $this->optionInt('login_lockout_minutes', 15),
                $this->optionInt('login_limit', 5)
            )->by($key)->response(function () {
                return back()->withErrors([
                    'email' => __('Too many login attempts. Please try again later.'),
                ]);
            });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinutes(
                $this->optionInt('register_lockout_minutes', 60),
                $this->optionInt('register_limit', 10)
            )->by($request->ip())->response(function () {
                return back()->withErrors([
                    'email' => __('Too many registration attempts. Please try again later.'),
                ]);
            });
        });

        RateLimiter::for('otp', function (Request $request) {
            $userKey = $request->user()?->getAuthIdentifier() ?: $request->ip();

            return Limit::perMinutes(
                $this->optionInt('otp_lockout_minutes', 1),
                $this->optionInt('otp_limit', 6)
            )->by('otp|' . $userKey)->response(function () {
                return back()->withErrors([
                    'code' => __('Too many verification attempts. Please try again later.'),
                ]);
            });
        });
    }

    protected function optionInt(string $name, int $default): int
    {
        if (!file_exists(storage_path('installed.lock'))) {
            return $default;
        }

        try {
            if (!Schema::hasTable('rj_options')) {
                return $default;
            }

            $value = rj_get_option($name);

            if ($value === null || $value === '') {
                return $default;
            }

            return max(1, (int) $value);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
