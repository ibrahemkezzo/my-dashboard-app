<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateServiceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'custom_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'seo_meta' => 'nullable|array',
            'seo_meta.title' => 'nullable|string|max:255',
            'seo_meta.description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
