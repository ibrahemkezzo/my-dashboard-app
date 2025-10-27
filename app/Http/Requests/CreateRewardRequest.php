<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateRewardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'required_points' => [
                'required',
                'integer',
                Rule::unique('rewards', 'required_points')->whereNull('deleted_at'),
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
            'required_points.unique' => 'عدد النقاط هذا مستخدم بالفعل لجائزة نشطة.',
            'description.required' => 'الوصف مطلوب.',
        ];
    }
}
