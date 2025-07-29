<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToggleFavoriteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'salon_id' => ['required', 'exists:salons,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'salon_id.required' => 'معرف الصالون مطلوب.',
            'salon_id.exists' => 'الصالون المحدد غير موجود.',
        ];
    }
}
