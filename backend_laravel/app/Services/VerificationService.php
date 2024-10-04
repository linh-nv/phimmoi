<?php

namespace App\Services;

use App\Mail\VerificationEmail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VerificationService
{
    public function sendVerificationCode(string $email): void
    {
        $verificationCode = Str::random(6);
        $this->storeEmailVerification($email, $verificationCode);

        Mail::to($email)->send(new VerificationEmail($verificationCode));
    }

    public function storeEmailVerification(string $email, string $code): void
    {
        EmailVerification::updateOrCreate(['email' => $email], [
            'email' => $email,
            'verification_code' => $code,
            'verified' => false,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
    }
    public function verifyCode(string $email, string $code): bool
    {
        $verification = EmailVerification::where('email', $email)
            ->where('verification_code', $code)
            ->where('verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $verification ? $verification->update(['verified' => true]) : false;
    }
}
