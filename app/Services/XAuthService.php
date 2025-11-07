<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;

class XAuthService extends BaseSocialAuthService
{
    public function __construct()
    {
        parent::__construct('x'); // أو 'twitter-oauth-2'
        config(['services.x.client_id' => env('X_CLIENT_ID')]);
        config(['services.x.client_secret' => env('X_CLIENT_SECRET')]);
    }

    protected function getUniqueIdentifier($socialUser): ?string
    {
        return $socialUser->getId();
    }

    protected function getEmail($socialUser): ?string
    {
        return $socialUser->getEmail(); // قد يكون null إلا إذا طلبت صلاحية email
    }

    protected function getName($socialUser): string
    {
        return $socialUser->getName() ?? $socialUser->getNickname() ?? 'X User';
    }

    public function redirectToProvider(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('x')
            // ->setScopes(['users.read', 'tweet.read', 'offline.access'])
            ->redirect();
    }
}
