<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePointsPerBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User|null $user */
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
            'points_per_booking' => 'required|integer|min:1',
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
            'points_per_booking.required' => 'عدد النقاط لكل حجز مطلوب.',
            'points_per_booking.integer' => 'يجب أن يكون عدد النقاط رقماً صحيحاً.',
            'points_per_booking.min' => 'يجب أن يكون عدد النقاط أكبر من أو يساوي 1.',
        ];
    }
}
