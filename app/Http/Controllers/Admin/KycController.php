<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Models\User;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index()
    {
        $verifications = KycVerification::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('admin.kyc.index', compact('verifications'));
    }

    public function show(KycVerification $verification)
    {
        $verification->load('user');
        return view('admin.kyc.show', compact('verification'));
    }

    public function approve(Request $request, KycVerification $verification)
    {
        $verification->status = 'approved';
        $verification->rejection_reason = null;
        $verification->save();

        $user = $verification->user;
        $user->kyc_status = 'approved';
        $user->kyc_verified_at = now();
        $user->save();

        return redirect()->route('admin.kyc.index')->with('success', __('KYC verification approved successfully.'));
    }

    public function reject(Request $request, KycVerification $verification)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $verification->status = 'rejected';
        $verification->rejection_reason = $validated['rejection_reason'];
        $verification->save();

        $user = $verification->user;
        $user->kyc_status = 'rejected';
        $user->kyc_verified_at = null;
        $user->save();

        return redirect()->route('admin.kyc.index')->with('success', __('KYC verification rejected.'));
    }
}
