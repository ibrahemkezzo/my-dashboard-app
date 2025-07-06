<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
       return $user && $user->hasPermissionTo('edit-users');    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
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
            'name.required' => 'اسم المستخدم مطلوب.',
            'name.max' => 'اسم المستخدم لا يمكن أن يتجاوز 255 حرفًا.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',
            'email.max' => 'البريد الإلكتروني لا يمكن أن يتجاوز 255 حرفًا.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'roles.required' => 'يجب اختيار دور واحد على الأقل.',
            'roles.min' => 'يجب اختيار دور واحد على الأقل.',
            'roles.*.exists' => 'الدور :value غير موجود.',
        ];
    }
}