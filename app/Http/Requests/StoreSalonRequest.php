<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:beauty_center,home_salon',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'owner_id' => 'required|exists:users,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'nullable|boolean',
            'working_hours' => 'required',
            'working_hours.*.open' => 'nullable|date_format:H:i',
            'working_hours.*.close' => 'nullable|date_format:H:i',
            'working_hours.*.status' => 'nullable|boolean',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.instagram' => 'nullable|url|max:255',
            'social_links.snapchat' => 'nullable|url|max:255',
            'social_links.tiktok' => 'nullable|url|max:255',
            'social_links.youtube' => 'nullable|url|max:255',
            'social_links.twitter' => 'nullable|url|max:255',
            'features' => 'nullable',
            'seo_meta' => 'nullable|array',
            'seo_meta.title' => 'nullable|string|max:255',
            'seo_meta.description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'features' => ['nullable', 'array', 'min:1'],
            'features.*' => ['in:on'],
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'verification' => 'nullable|boolean',

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $allowedFeatures = ['parking', 'wifi', 'ac', 'waiting-area', 'refreshments', 'child-care'];
            $features = $this->input('features', []);
            $invalidKeys = array_diff(array_keys($features), $allowedFeatures);

            if (!empty($invalidKeys)) {
                $validator->errors()->add('features', 'مفاتيح المميزات غير صالحة: ' . implode(', ', $invalidKeys));
            }
        });
    }
}
