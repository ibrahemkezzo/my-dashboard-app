<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrontSalonSubServiceRequest extends FormRequest
{
    /**
     * تحديد من له صلاحية استخدام هذا الريكوست
     */
    public function authorize(): bool
    {
        return true; // خليها true إذا ما عندك نظام صلاحيات مخصص
    }

    /**
     * قواعد التحقق
     */
    public function rules(): array
    {
        return [
            'salon_services' => 'required|array',
            'salon_services.*.service_id' => 'required|exists:services,id',
            'salon_services.*.sub_service_id' => 'required|exists:sub_services,id',
            'salon_services.*.price' => 'nullable|numeric',
            'salon_services.*.max_price' => 'nullable|numeric|gt:salon_services.*.price',
            'salon_services.*.duration' => 'nullable|integer',
            'salon_services.*.status' => 'nullable|boolean',
        ];
    }

    /**
     * رسائل الأخطاء المخصصة
     */
    public function messages(): array
    {
        return [
            'salon_services.required' => 'يجب إدخال الخدمات المقدمة في الصالون.',
            'salon_services.array' => 'تنسيق الخدمات غير صحيح.',

            'salon_services.*.service_id.required' => 'الخدمة الرئيسية مطلوبة.',
            'salon_services.*.service_id.exists' => 'الخدمة الرئيسية غير موجودة في النظام.',

            'salon_services.*.sub_service_id.required' => 'الخدمة الفرعية مطلوبة.',
            'salon_services.*.sub_service_id.exists' => 'الخدمة الفرعية غير موجودة في النظام.',

            'salon_services.*.price.numeric' => 'السعر يجب أن يكون رقماً.',
            'salon_services.*.max_price.numeric' => 'أقصى سعر يجب أن يكون رقماً.',
            'salon_services.*.max_price.gt' => 'أقصى سعر يجب أن يكون أكبر من السعر الأدنى.',

            'salon_services.*.duration.integer' => 'المدة يجب أن تكون قيمة صحيحة (عدد دقائق).',
            'salon_services.*.status.boolean' => 'الحالة يجب أن تكون صحيحة أو خاطئة.',
        ];
    }
}
