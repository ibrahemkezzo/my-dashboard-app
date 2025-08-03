<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontStoreSalonRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // 'email'=> 'sometimes|email',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:beauty_center,home_salon',
            'phone' => 'required|string|max:20',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'working_hours' => 'required',
            'working_hours.*.open' => 'nullable|date_format:H:i',
            'working_hours.*.close' => 'nullable|date_format:H:i',
            'working_hours.*.closed' => 'nullable|string|in:on',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.instagram' => 'nullable|url|max:255',
            'social_links.snapchat' => 'nullable|url|max:255',
            'social_links.tiktok' => 'nullable|url|max:255',
            'social_links.youtube' => 'nullable|url|max:255',
            'social_links.twitter' => 'nullable|url|max:255',
            'features' => ['nullable', 'array', 'min:1'],
            'features.*' => ['in:on'],
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'verification' => 'nullable|boolean',
            'license_document' => 'nullable|image',
            'license_start_date' => 'nullable|date',
            'license_end_date' => 'nullable|date|after_or_equal:license_start_date',
            'hasOffer' => 'nullable|boolean',
            'offer' => 'nullable|json',

            // 'password' => 'required|string|min:8|confirmed',
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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'اسم الصالون مطلوب.',
            'name.string' => 'اسم الصالون يجب أن يكون نصاً.',
            'name.max' => 'اسم الصالون يجب ألا يتجاوز 255 حرفاً.',
            'description.required' => 'وصف الصالون مطلوب.',
            'description.string' => 'وصف الصالون يجب أن يكون نصاً.',
            'description.max' => 'وصف الصالون يجب ألا يتجاوز 1000 حرف.',
            'salonType.required' => 'نوع الصالون مطلوب.',
            'salonType.in' => 'نوع الصالون يجب أن يكون إما مركز معتمد أو صالون منزلي.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 حرفاً.',
            'city_id.required' => 'المدينة مطلوبة.',
            'city_id.exists' => 'المدينة المحددة غير موجودة.',
            'address.required' => 'العنوان الكامل مطلوب.',
            'address.string' => 'العنوان يجب أن يكون نصاً.',
            'address.max' => 'العنوان يجب ألا يتجاوز 255 حرفاً.',
            'logo.image' => 'شعار الصالون يجب أن يكون صورة.',
            'logo.mimes' => 'شعار الصالون يجب أن يكون من نوع jpeg، png، jpg، أو gif.',
            'logo.max' => 'حجم شعار الصالون يجب ألا يتجاوز 2 ميغابايت.',
            'cover_image.image' => 'صورة الغلاف يجب أن تكون صورة.',
            'cover_image.mimes' => 'صورة الغلاف يجب أن تكون من نوع jpeg، png، jpg، أو gif.',
            'cover_image.max' => 'حجم صورة الغلاف يجب ألا يتجاوز 2 ميغابايت.',
            'gallery_images.*.image' => 'الصور الإضافية يجب أن تكون صور.',
            'gallery_images.*.mimes' => 'الصور الإضافية يجب أن تكون من نوع jpeg، png، jpg، أو gif.',
            'gallery_images.*.max' => 'حجم الصور الإضافية يجب ألا يتجاوز 2 ميغابايت.',
            'working_hours.required' => 'ساعات العمل مطلوبة.',
            'working_hours.*.open.date_format' => 'وقت الافتتاح يجب أن يكون بصيغة ساعة:دقيقة (مثال: 09:00).',
            'working_hours.*.close.date_format' => 'وقت الإغلاق يجب أن يكون بصيغة ساعة:دقيقة (مثال: 17:00).',
            'working_hours.*.satuts.boolean' => 'حالة يوم العمل يجب أن تكون إما مفتوح أو مغلق.',
            'social_links.*.url' => 'رابط التواصل الاجتماعي يجب أن يكون رابطاً صالحاً.',
            'social_links.*.max' => 'رابط التواصل الاجتماعي يجب ألا يتجاوز 255 حرفاً.',
            'license_document.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'license_document.max' => 'حجم الصورة يجب ألا يزيد عن 2 ميغابايت.',
            // 'password.required' => 'كلمة المرور مطلوبة.',
            // 'password.string' => 'كلمة المرور يجب أن تكون نصاً.',
            // 'password.min' => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            // 'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
            // 'agree_terms.required' => 'يجب الموافقة على الشروط والأحكام.',
            // 'agree_terms.accepted' => 'يجب الموافقة على الشروط والأحكام.',
        ];
    }
}
