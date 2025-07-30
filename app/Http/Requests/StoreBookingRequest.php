<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'salon_id' => ['required', 'exists:salons,id'],
            'salon_sub_service_id' => [
                'required',
                'exists:salon_sub_service,id',
                // Rule::exists('salon_sub_service')->where(function ($query) {
                //     $query->where('salon_id', $this->salon_id)
                //           ->where('status', true);
                // }),
            ],
            'service_description' => ['required', 'string', 'min:10', 'max:1000'],
            'preferred_datetime' => ['required', 'date', 'after:now'],
            'additional_data' => ['nullable', 'array'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => __('dashboard.user_is_required'),
            'user_id.exists' => __('dashboard.user_not_found'),
            'salon_id.required' => __('dashboard.salon_is_required'),
            'salon_id.exists' => __('dashboard.salon_not_found'),
            'salon_sub_service_id.required' => __('dashboard.service_is_required'),
            'salon_sub_service_id.exists' => __('dashboard.service_not_available'),
            'service_description.required' => __('dashboard.service_description_required'),
            'service_description.min' => __('dashboard.service_description_min_length'),
            'service_description.max' => __('dashboard.service_description_max_length'),
            'preferred_datetime.required' => __('dashboard.preferred_datetime_required'),
            'preferred_datetime.date' => __('dashboard.preferred_datetime_invalid'),
            'preferred_datetime.after' => __('dashboard.preferred_datetime_future'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => __('dashboard.user'),
            'salon_id' => __('dashboard.salon'),
            'salon_sub_service_id' => __('dashboard.service'),
            'service_description' => __('dashboard.service_description'),
            'preferred_datetime' => __('dashboard.preferred_datetime'),
        ];
    }
}