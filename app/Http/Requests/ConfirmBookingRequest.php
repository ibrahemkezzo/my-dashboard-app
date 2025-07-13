<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmBookingRequest extends FormRequest
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
            'scheduled_datetime' => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480'], // 15 minutes to 8 hours
            'total_price' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'scheduled_datetime.required' => __('dashboard.scheduled_datetime_required'),
            'scheduled_datetime.date' => __('dashboard.scheduled_datetime_invalid'),
            'scheduled_datetime.after' => __('dashboard.scheduled_datetime_future'),
            'duration_minutes.required' => __('dashboard.duration_required'),
            'duration_minutes.integer' => __('dashboard.duration_integer'),
            'duration_minutes.min' => __('dashboard.duration_min'),
            'duration_minutes.max' => __('dashboard.duration_max'),
            'total_price.required' => __('dashboard.total_price_required'),
            'total_price.numeric' => __('dashboard.total_price_numeric'),
            'total_price.min' => __('dashboard.total_price_min'),
            'deposit_amount.numeric' => __('dashboard.deposit_amount_numeric'),
            'deposit_amount.min' => __('dashboard.deposit_amount_min'),
            'notes.max' => __('dashboard.notes_max_length'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'scheduled_datetime' => __('dashboard.scheduled_datetime'),
            'duration_minutes' => __('dashboard.duration'),
            'total_price' => __('dashboard.total_price'),
            'deposit_amount' => __('dashboard.deposit_amount'),
            'notes' => __('dashboard.notes'),
        ];
    }
} 