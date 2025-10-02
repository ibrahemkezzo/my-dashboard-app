<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateSalonSubServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // تأكد من أن المستخدم لديه صالون
        return Auth::check() && Auth::user()->salon !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0|gt:price',
            'duration' => 'required|integer|min:0',
            'status' => 'nullable|boolean',
            'materials_used' => 'nullable|string|max:1000',
            'requirements' => 'nullable|string|max:1000',
            'special_notes' => 'nullable|string|max:1000',
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
            'price.required' => 'السعر مطلوب.',
            'price.numeric' => 'يجب أن يكون السعر رقمًا.',
            'price.min' => 'يجب أن يكون السعر أكبر من أو يساوي 0.',
            'max_price.required' => 'السعر الأقصى مطلوب.',
            'max_price.numeric' => 'يجب أن يكون السعر الأقصى رقمًا.',
            'max_price.min' => 'يجب أن يكون السعر الأقصى أكبر من أو يساوي 0.',
            'max_price.gt' => 'يجب أن يكون السعر الأقصى أكبر من السعر الأدنى.',
            'duration.required' => 'المدة مطلوبة.',
            'duration.integer' => 'يجب أن تكون المدة عددًا صحيحًا.',
            'duration.min' => 'يجب أن تكون المدة أكبر من أو تساوي 0.',
            'materials_used.max' => 'المواد المستخدمة يجب ألا تتجاوز 1000 حرف.',
            'requirements.max' => 'المتطلبات يجب ألا تتجاوز 1000 حرف.',
            'special_notes.max' => 'الملاحظات الخاصة يجب ألا تتجاوز 1000 حرف.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $errorMessage = implode(' ', $errors); // دمج الأخطاء في نص واحد

        throw new HttpResponseException(
            back()->with('message', [
                'type' => 'error',
                'content' => $errorMessage
            ])->withInput()
        );
    }
}

