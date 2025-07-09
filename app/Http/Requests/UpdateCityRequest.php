<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'country' => 'nullable|string|max:255',
            'google_place_id' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
            // 'is_active' => 'sometimes|boolean',
        ];
    }
}