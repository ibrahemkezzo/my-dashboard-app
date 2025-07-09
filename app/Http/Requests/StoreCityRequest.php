<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'country' => 'nullable|string|max:255',
            'google_place_id' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
            // 'is_active' => 'sometimes|boolean',
        ];
    }
}