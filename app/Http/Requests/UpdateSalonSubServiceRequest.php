<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalonSubServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'sub_service_id' => 'required|exists:sub_services,id',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'materials_used' => 'nullable|string|max:1000',
            'requirements' => 'nullable|string|max:1000',
            'special_notes' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => __('dashboard.service_required'),
            'service_id.exists' => __('dashboard.service_not_found'),
            'sub_service_id.required' => __('dashboard.sub_service_required'),
            'sub_service_id.exists' => __('dashboard.sub_service_not_found'),
            'price.numeric' => __('dashboard.price_must_be_numeric'),
            'price.min' => __('dashboard.price_must_be_positive'),
            'duration.integer' => __('dashboard.duration_must_be_integer'),
            'duration.min' => __('dashboard.duration_must_be_positive'),
            'images.*.image' => __('dashboard.file_must_be_image'),
            'images.*.max' => __('dashboard.image_size_too_large'),
        ];
    }
} 