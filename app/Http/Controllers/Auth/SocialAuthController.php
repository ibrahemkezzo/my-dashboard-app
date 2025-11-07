<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\SocialAuthServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    protected SocialAuthServiceInterface $socialAuthService;

    public function __construct(SocialAuthServiceInterface $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirect(): RedirectResponse
    {
        return $this->socialAuthService->redirectToProvider();
    }

    public function callback(): RedirectResponse
    {
        try {
            $result = $this->socialAuthService->handleProviderCallback();
            $user = $result['user'];
            $action = $result['action']; // ← جديد!

            $driverName = ucfirst($this->socialAuthService->getDriverName());

            // رسائل مخصصة حسب الإجراء
            $messages = [
                'registered' => [
                    'type' => 'success',
                    // 'content' => "أهلاً وسهلاً بكِ في عائلة Glowzelle! تم إنشاء حسابك بنجاح عبر $driverName",
                    'img' => asset('frontend/assets/img/welcome-register.png'), // صورة كبيرة + GIF
                ],
                // 'linked' => [
                //     'type' => 'success',
                //     'content' => "تم ربط حسابك بـ $driverName بنجاح! مرحباً بعودتك",
                //     'img' => asset('storage/glowzelle/account-linked.png'),
                // ],
                'logged_in' => [
                    'type' => 'success',
                    // 'content' => "مرحباً بعودتك! تم تسجيل الدخول عبر $driverName",
                    'img' => asset('frontend/assets/img/welcome-login.png'), // أو صورة صغيرة
                ],
            ];

            $message = $messages[$action] ?? $messages['logged_in'];

            return redirect()->route('front.home')->with('message', $message);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Invalid State: ' . $e->getMessage());
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'content' => 'فشل تسجيل الدخول: جلسة منتهية الصلاحية.'
            ]);
        } catch (\Exception $e) {
            Log::error($this->socialAuthService->getDriverName() . ' Login Error: ' . $e->getMessage());
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'content' => 'فشل تسجيل الدخول عبر ' . ucfirst($this->socialAuthService->getDriverName())
            ]);
        }
    }
}
