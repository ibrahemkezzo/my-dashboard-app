<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
         /** @var User|null $user */
        $user = Auth::user();
        return $user && $user->hasPermissionTo('create-permissions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الصلاحية مطلوب.',
            'name.unique' => 'اسم الصلاحية موجود مسبقًا.',
            'name.max' => 'اسم الصلاحية لا يمكن أن يتجاوز 255 حرفًا.',
            'description.max' => 'الوصف لا يمكن أن يتجاوز 1000 حرف.',
        ];
    }
}