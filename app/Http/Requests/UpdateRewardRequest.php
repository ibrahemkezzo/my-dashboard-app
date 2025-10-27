<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRewardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('super-admin'); // افترض وجود نظام أدوار
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'required_points' => [
                'required',
                'integer',
                Rule::unique('rewards', 'required_points')->whereNull('deleted_at')->ignore($this->reward->id),
            ],
            'description' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required_points.required' => 'عدد النقاط المطلوبة مطلوب.',
            'required_points.unique' => 'عدد النقاط هذا مستخدم بالفعل.',
            'description.required' => 'الوصف مطلوب.',
        ];
    }
}
