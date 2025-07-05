<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTermsSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole('super-admin');
    }

    public function rules(): array
    {
        return [
            'terms_description' => 'nullable|string',
            'terms_content' => 'nullable|string',
        ];
    }
} 