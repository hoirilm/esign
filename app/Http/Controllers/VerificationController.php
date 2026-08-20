<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function show(string $qr_token)
    {
        $verification = Verification::with(['labRequest.patient', 'labRequest.results', 'verifier'])
            ->where('qr_token', $qr_token)
            ->first();

        return view('verify', [
            'verification' => $verification,
            'qr_token' => $qr_token,
        ]);
    }
}
