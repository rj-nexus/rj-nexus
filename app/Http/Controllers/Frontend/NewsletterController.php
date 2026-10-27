<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'name'  => ['nullable', 'string', 'max:120'],
        ]);

        $key = 'newsletter:' . Str::lower($data['email']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'ok'      => false,
                'message' => __('Too many attempts. Please try again in :s seconds.', ['s' => $seconds]),
            ], 429);
        }

        RateLimiter::hit($key, 300);

        try {
            $subscriber = NewsletterSubscriber::subscribe(
                $data['email'],
                $data['name'] ?? null,
                'widget'
            );
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => __('Something went wrong. Please try again.'),
            ], 500);
        }

        return response()->json([
            'ok'      => true,
            'message' => __('You are subscribed! Thank you.'),
            'email'   => $subscriber->email,
        ]);
    }
}
