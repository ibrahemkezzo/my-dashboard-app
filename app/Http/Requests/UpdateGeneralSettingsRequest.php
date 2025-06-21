<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateGeneralSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       /** @var User|null $user */
        $user = Auth::user();
        return $user && $user->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_name' => 'required|string|max:255',
            'site_title' => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'default_language' => 'nullable|string|in:ar,en',
            'site_status' => 'nullable|string|in:active,maintenance',
            'maintenance_message' => 'nullable|string|max:1000',
            'email_settings' => 'nullable|email',
            'analytics_code' => 'nullable|string|max:1000',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
            'notification_settings' => 'nullable|array',
            'footer_text' => 'nullable|string|max:1000',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
        ];
    }
}
