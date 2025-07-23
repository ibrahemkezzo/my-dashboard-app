<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalonConfirmBookingRequest extends FormRequest
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
            'action' => 'required|in:confirm,modify',
            'salon_proposed_datetime' => 'nullable|date|after:now',
            'salon_proposed_price' => 'nullable|numeric|min:0',
            'salon_proposed_duration' => 'nullable|integer|min:15|max:480',
            'salon_notes' => 'nullable|string|max:1000',
            'salon_modification_reason' => 'required_if:action,modify|nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => __('dashboard.action_is_required'),
            'action.in' => __('dashboard.invalid_action'),
            'salon_proposed_datetime.date' => __('dashboard.invalid_datetime'),
            'salon_proposed_datetime.after' => __('dashboard.datetime_must_be_future'),
            'salon_proposed_price.numeric' => __('dashboard.price_must_be_numeric'),
            'salon_proposed_price.min' => __('dashboard.price_must_be_positive'),
            'salon_proposed_duration.integer' => __('dashboard.duration_must_be_integer'),
            'salon_proposed_duration.min' => __('dashboard.duration_minimum'),
            'salon_proposed_duration.max' => __('dashboard.duration_maximum'),
            'salon_notes.max' => __('dashboard.notes_max_length'),
            'salon_modification_reason.required_if' => __('dashboard.modification_reason_required'),
            'salon_modification_reason.max' => __('dashboard.modification_reason_max_length'),
        ];
    }
}