<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateContactUsSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       /** @var User|null $user */
       $user = Auth::user();
       return $user && $user->hasRole('super-admin');    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'phone_numbers' => 'required|array',
            'phone_numbers.*' => 'string|max:20',
            'address' => 'required|string|max:500',
            'map_url' => 'nullable|url',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
            'form_settings' => 'nullable|array',
            'form_settings.enabled' => 'boolean',
            'form_settings.redirect_url' => 'nullable|url',
            'working_hours' => 'nullable|string|max:500',
            'success_message' => 'nullable|string|max:500',
        ];
    }
}
