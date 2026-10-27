<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WidgetAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $key = Str::lower($data['email']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'ok'      => false,
                'message' => __('Too many login attempts. Please try again in :s seconds.', ['s' => $seconds]),
            ], 429);
        }

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']], (bool) ($data['remember'] ?? false))) {
            RateLimiter::hit($key, 60);

            return response()->json([
                'ok'      => false,
                'message' => __('These credentials do not match our records.'),
            ], 422);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        $user = Auth::user();
        $initials = $this->initials($user->name);

        return response()->json([
            'ok'   => true,
            'user' => [
                'name'     => $user->name,
                'email'    => $user->email,
                'initials' => $initials,
                'admin'    => method_exists($user, 'isAdmin') ? $user->isAdmin() : false,
                'account'  => route('frontend.account.index', absolute: false),
                'adminUrl' => method_exists($user, 'isAdmin') && $user->isAdmin() ? route('admin.dashboard', absolute: false) : null,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true]);
    }

    private function initials(?string $name): string
    {
        $name = trim((string) $name);
        if ($name === '') {
            return '?';
        }

        $parts = preg_split('/\s+/u', $name) ?: [];
        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 1));
        }

        $first = mb_substr($parts[0], 0, 1);
        $last  = mb_substr($parts[count($parts) - 1], 0, 1);

        return mb_strtoupper($first . $last);
    }
}
