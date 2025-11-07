<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;

class FacebookAuthService extends BaseSocialAuthService
{
    public function __construct()
    {
        parent::__construct('facebook');
    }

    protected function getUniqueIdentifier($socialUser): ?string
    {
        return $socialUser->getId();
    }

    protected function getEmail($socialUser): ?string
    {
        return $socialUser->getEmail();
    }

    protected function getName($socialUser): string
    {
        return $socialUser->getName() ?? 'Facebook User';
    }

    public function redirectToProvider(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }
}
