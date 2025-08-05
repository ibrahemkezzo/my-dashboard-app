<?php

namespace App\Contracts;

interface SocialAuthServiceInterface
{
    public function redirectToProvider(): \Illuminate\Http\RedirectResponse;
    public function handleProviderCallback(): \App\Models\User;
}
