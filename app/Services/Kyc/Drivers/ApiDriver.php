<?php

namespace App\Services\Kyc\Drivers;

use App\Contracts\Kyc\KycDriverInterface;
use App\Models\KycVerification;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiDriver implements KycDriverInterface
{
    public function isEnabled(): bool
    {
        return !empty(rj_get_option('kyc_api_key')) && !empty(rj_get_option('kyc_api_secret'));
    }

    public function submit(User $user, array $data): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . rj_get_option('kyc_api_key'),
            ])->post(rj_get_option('kyc_api_endpoint', 'https://api.example.com/kyc'), [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                $verification = new KycVerification();
                $verification->user_id = $user->id;
                $verification->driver = 'api';
                $verification->status = 'pending';
                $verification->metadata = $responseData;
                $verification->save();

                $user->kyc_status = 'pending';
                $user->save();

                return true;
            }

            Log::error('KYC API Submit Failed', ['response' => $response->json()]);
            return false;
        } catch (\Throwable $e) {
            Log::error('KYC API Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function handleWebhook(array $payload): bool
    {
        if (isset($payload['user_id']) && isset($payload['status'])) {
            $user = User::find($payload['user_id']);

            if ($user) {
                $verification = KycVerification::where('user_id', $user->id)->latest()->first();

                if ($verification) {
                    $verification->status = $payload['status'];
                    $verification->save();

                    $user->kyc_status = $payload['status'];
                    $user->kyc_verified_at = $payload['status'] === 'approved' ? now() : null;
                    $user->save();

                    return true;
                }
            }
        }

        return false;
    }
}
