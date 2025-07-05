<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePrivacySettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && $user->hasRole('super-admin');
    }

    public function rules(): array
    {
        return [
            'privacy_description' => 'nullable|string',
            'privacy_sections' => 'nullable|array',
            'privacy_sections.*.title' => 'nullable|string',
            'privacy_sections.*.content' => 'nullable|string',
        ];
    }
}