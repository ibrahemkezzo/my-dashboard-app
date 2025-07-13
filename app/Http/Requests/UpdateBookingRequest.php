<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
            'user_id' => ['sometimes', 'required', 'exists:users,id'],
            'salon_id' => ['sometimes', 'required', 'exists:salons,id'],
            'salon_sub_service_id' => [
                'sometimes',
                'required',
                'exists:salon_sub_service,id',
                // Rule::exists('salon_sub_service')->where(function ($query) {
                //     $query->where('salon_id', $this->salon_id ?? $this->booking->salon_id)
                //           ->where('status', true);
                // }),
            ],
            'service_description' => ['sometimes', 'required', 'string', 'min:10', 'max:1000'],
            'preferred_datetime' => ['sometimes', 'required', 'date', 'after:now'],
            'status' => ['sometimes', 'required', 'in:pending,confirmed,rejected,cancelled'],
            'rejection_reason' => ['nullable', 'string', 'max:500'],
            'special_requirements' => ['nullable', 'string', 'max:500'],
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
            'status.required' => __('dashboard.status_required'),
            'status.in' => __('dashboard.status_invalid'),
            'rejection_reason.max' => __('dashboard.rejection_reason_max_length'),
            'special_requirements.max' => __('dashboard.special_requirements_max_length'),
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
            'status' => __('dashboard.status'),
            'rejection_reason' => __('dashboard.rejection_reason'),
            'special_requirements' => __('dashboard.special_requirements'),
        ];
    }
}