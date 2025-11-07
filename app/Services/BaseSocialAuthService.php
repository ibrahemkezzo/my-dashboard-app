<?php
// app/Services/BaseSocialAuthService.php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class BaseSocialAuthService implements \App\Contracts\SocialAuthServiceInterface
{
    protected string $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    public function getDriverName(): string
    {
        return $this->driver;
    }

    public function redirectToProvider(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver($this->driver)->redirect();
    }

    abstract protected function getUniqueIdentifier($socialUser): ?string;
    abstract protected function getEmail($socialUser): ?string;
    abstract protected function getName($socialUser): string;

    public function handleProviderCallback(): array
    {
        $socialUser = Socialite::driver($this->driver)->user();

        $identifier = $this->getUniqueIdentifier($socialUser);
        $email      = $this->getEmail($socialUser);
        $fallbackEmail = $email ?? $identifier . '@' . $this->driver . '.local';

        // 1. البحث الأول: هل هو مسجل بالمنصة من قبل؟
        $user = User::where($this->getIdentifierColumn(), $identifier)->first();

        if ($user) {
            // موجود بالفعل بالمنصة → حدّث التوكن فقط
            $user->update([
                $this->getTokenColumn()        => $socialUser->token ?? null,
                $this->getRefreshTokenColumn() => $socialUser->refreshToken ?? null,
                'email_verified_at'            => $user->email_verified_at ?? now(),
            ]);

            Auth::login($user, true);
            if (!$user->roles()->exists()) $user->assignRole('user');
            return [
                'user' => $user,
                'action' => 'logged_in', // دخول عادي
            ];
        }

        // 2. البحث الثاني: هل لديه حساب قديم بنفس الإيميل (تسجيل يدوي)؟
        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                // نعم! نفس الشخص → نربط له المنصة الجديدة فقط
                $user->update([
                    $this->getIdentifierColumn()   => $identifier,
                    $this->getTokenColumn()        => $socialUser->token ?? null,
                    $this->getRefreshTokenColumn() => $socialUser->refreshToken ?? null,
                    'email_verified_at'            => $user->email_verified_at ?? now(),
                ]);

                Auth::login($user, true);
                return [
                    'user' => $user,
                    'action' => 'logged_in', // دخول عادي
                ];
            }
        }

        // 3. مستخدم جديد تمامًا → إنشاء حساب عادي
        $user = User::create([
            'name'       => $this->getName($socialUser),
            'email'      => $fallbackEmail,
            $this->getIdentifierColumn()   => $identifier,
            $this->getTokenColumn()        => $socialUser->token ?? null,
            $this->getRefreshTokenColumn() => $socialUser->refreshToken ?? null,
            'password'   => bcrypt(Str::random(16)),
            'email_verified_at'            => now(),
        ]);

        Auth::login($user, true);
        $user->assignRole('user');
        return [
            'user' => $user,
            'action' => 'registered', // أول تسجيل
        ];
    }

    protected function getIdentifierColumn(): string
    {
        return $this->driver . '_id';
    }

    protected function getTokenColumn(): string
    {
        return $this->driver . '_token';
    }

    protected function getRefreshTokenColumn(): string
    {
        return $this->driver . '_refresh_token';
    }
}
