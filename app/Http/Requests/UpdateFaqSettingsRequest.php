<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFaqSettingsRequest extends FormRequest
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
            'faq_description' => 'nullable|string',
            'faq_questions' => 'nullable|array',
            'faq_questions.*.question' => 'nullable|string',
            'faq_questions.*.answer' => 'nullable|string',
            'faq_questions.*.category' => 'nullable|string',
        ];
    }
}