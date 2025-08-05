<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\SocialAuthServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
            return redirect()->route('front.home')->with('message', ['type' => 'error', 'content' =>'تم تسجيل الدخول بنجاح']);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('login')->with('message', ['type' => 'error', 'content' =>'فشل تسجيل الدخول باستخدام Google.']);
        }
    }
}
