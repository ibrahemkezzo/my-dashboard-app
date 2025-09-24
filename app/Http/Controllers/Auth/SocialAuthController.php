<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\SocialAuthServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
        private $socialAuthService;

    public function __construct(SocialAuthServiceInterface $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return $this->socialAuthService->redirectToProvider();
    }

public function handleGoogleCallback(): RedirectResponse
{
    try {
        $user = $this->socialAuthService->handleProviderCallback();
        return redirect()->route('front.home')->with('message', ['type' => 'success', 'content' => 'تم تسجيل الدخول بنجاح']);
    } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        Log::error('Invalid State Exception: ' . $e->getMessage());
        return redirect()->route('login')->with('message', ['type' => 'error', 'content' => 'فشل تسجيل الدخول باستخدام Google بسبب مشكلة في الحالة.']);
    } catch (\Exception $e) {
        Log::error('Google Login Error: ' . $e->getMessage());
        return redirect()->route('login')->with('message', ['type' => 'error', 'content' => 'فشل تسجيل الدخول باستخدام Google.']);
    }
}
}
