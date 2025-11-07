<?php

namespace App\Services;

class GoogleAuthService extends BaseSocialAuthService
{
    public function __construct()
    {
        parent::__construct('google');
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
        return $socialUser->getName() ?? 'Google User';
    }
}
