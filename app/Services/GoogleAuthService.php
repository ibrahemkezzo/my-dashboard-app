<?php

namespace App\Services;

use App\Contracts\SocialAuthServiceInterface;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthService implements SocialAuthServiceInterface
{
    public function redirectToProvider(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(): User
    {
        $googleUser = Socialite::driver('google')->user();
        // dd($googleUser);
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user, true);
        $user->assignRole('user');

        return $user;
    }
}
