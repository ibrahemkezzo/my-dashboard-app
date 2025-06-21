<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('إعدادات الموقع') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        [dir="rtl"] label, [dir="rtl"] input, [dir="rtl"] textarea, [dir="rtl"] select {
            text-align: right;
        }
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .accordion-header {
            cursor: pointer;
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }
        .accordion-content {
            display: none;
            padding: 1rem;
        }
        .accordion-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('إعدادات الموقع') }}
            </h2>
        </x-slot>

        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- General Settings -->
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <h3 class="text-lg font-semibold">{{ __('إعدادات الموقع العامة') }}</h3>
            </div>
            <div class="accordion-content active">
                <form action="{{ route('settings.updateGeneral') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700">{{ __('اسم الموقع') }}</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $generalSettings['site_name']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('site_name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('عنوان الموقع') }}</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $generalSettings['site_title']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('site_title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('وصف الموقع (SEO)') }}</label>
                        <textarea name="meta_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('meta_description', $generalSettings['meta_description']) }}</textarea>
                        @error('meta_description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الكلمات المفتاحية (SEO)') }}</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $generalSettings['meta_keywords']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('meta_keywords')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('اللغة الافتراضية') }}</label>
                        <select name="default_language" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="ar" {{ old('default_language', $generalSettings['default_language']) === 'ar' ? 'selected' : '' }}>العربية</option>
                            <option value="en" {{ old('default_language', $generalSettings['default_language']) === 'en' ? 'selected' : '' }}>English</option>
                        </select>
                        @error('default_language')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('حالة الموقع') }}</label>
                        <select name="site_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="active" {{ old('site_status', $generalSettings['site_status']) === 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="maintenance" {{ old('site_status', $generalSettings['site_status']) === 'maintenance' ? 'selected' : '' }}>صيانة</option>
                        </select>
                        @error('site_status')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('رسالة الصيانة') }}</label>
                        <textarea name="maintenance_message" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('maintenance_message', $generalSettings['maintenance_message']) }}</textarea>
                        @error('maintenance_message')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('البريد الإلكتروني') }}</label>
                        <input type="email" name="email_settings" value="{{ old('email_settings', $generalSettings['email_settings']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('email_settings')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('كود التحليلات') }}</label>
                        <textarea name="analytics_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('analytics_code', $generalSettings['analytics_code']) }}</textarea>
                        @error('analytics_code')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('روابط التواصل الاجتماعي') }}</label>
                        <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $generalSettings['social_links']['facebook'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="فيسبوك">
                        @error('social_links.facebook')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $generalSettings['social_links']['twitter'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="تويتر">
                        @error('social_links.twitter')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $generalSettings['social_links']['instagram'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="إنستغرام">
                        @error('social_links.instagram')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('نص التذييل') }}</label>
                        <textarea name="footer_text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('footer_text', $generalSettings['footer_text']) }}</textarea>
                        @error('footer_text')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('شعار الموقع') }}</label>
                        <input type="file" name="site_logo" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('site_logo')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('صورة الغلاف') }}</label>
                        <input type="file" name="cover_image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('cover_image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('أيقونة الموقع (Favicon)') }}</label>
                        <input type="file" name="favicon" accept="image/ico,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('favicon')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('حفظ الإعدادات') }}</button>
                </form>
            </div>

            <!-- About Us Settings -->
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <h3 class="text-lg font-semibold">{{ __('إعدادات من نحن') }}</h3>
            </div>
            <div class="accordion-content">
                <form action="{{ route('settings.updateAboutUs') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700">{{ __('العنوان') }}</label>
                        <input type="text" name="title" value="{{ old('title', $aboutUsSettings['about_us_title']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الوصف') }}</label>
                        <textarea name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description', $aboutUsSettings['about_us_description']) }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الرؤية') }}</label>
                        <textarea name="vision" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('vision', $aboutUsSettings['about_us_vision']) }}</textarea>
                        @error('vision')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الرسالة') }}</label>
                        <textarea name="mission" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('mission', $aboutUsSettings['about_us_mission']) }}</textarea>
                        @error('mission')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('القيم') }}</label>
                        <div id="values-container">
                            @foreach (old('values', $aboutUsSettings['about_us_values']) as $value)
                                <div class="flex items-center mb-2">
                                    <input type="text" name="values[]" value="{{ $value }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                                </div>
                            @endforeach
                            <div class="flex items-center mb-2">
                                <input type="text" name="values[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="قيمة جديدة">
                                <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                            </div>
                        </div>
                        <button type="button" class="text-blue-600 hover:text-blue-800" onclick="addField('values-container', 'values[]', 'قيمة جديدة')">إضافة قيمة</button>
                        @error('values.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('رابط الفيديو التعريفي') }}</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $aboutUsSettings['about_us_video_url']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('video_url')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('تاريخ التأسيس') }}</label>
                        <input type="date" name="founded_at" value="{{ old('founded_at', $aboutUsSettings['about_us_founded_at']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('founded_at')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('عدد الموظفين') }}</label>
                        <input type="number" name="employees_count" value="{{ old('employees_count', $aboutUsSettings['about_us_employees_count']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0">
                        @error('employees_count')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('إحصائيات') }}</label>
                        <div id="statistics-container">
                            @foreach (old('statistics', $aboutUsSettings['about_us_statistics']) as $statistic)
                                <div class="flex items-center mb-2">
                                    <input type="text" name="statistics[]" value="{{ $statistic }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                                </div>
                            @endforeach
                            <div class="flex items-center mb-2">
                                <input type="text" name="statistics[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="إحصائية جديدة">
                                <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                            </div>
                        </div>
                        <button type="button" class="text-blue-600 hover:text-blue-800" onclick="addField('statistics-container', 'statistics[]', 'إحصائية جديدة')">إضافة إحصائية</button>
                        @error('statistics.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('صورة تعريفية') }}</label>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('حفظ الإعدادات') }}</button>
                </form>
            </div>

            <!-- Contact Us Settings -->
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <h3 class="text-lg font-semibold">{{ __('إعدادات اتصل بنا') }}</h3>
            </div>
            <div class="accordion-content">
                <form action="{{ route('settings.updateContactUs') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700">{{ __('العنوان') }}</label>
                        <input type="text" name="title" value="{{ old('title', $contactUsSettings['contact_us_title']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الوصف') }}</label>
                        <textarea name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description', $contactUsSettings['contact_us_description']) }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('البريد الإلكتروني') }}</label>
                        <input type="email" name="email" value="{{ old('email', $contactUsSettings['contact_us_email']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('أرقام الهاتف') }}</label>
                        <div id="phone-numbers-container">
                            @foreach (old('phone_numbers', $contactUsSettings['contact_us_phone_numbers']) as $phone)
                                <div class="flex items-center mb-2">
                                    <input type="text" name="phone_numbers[]" value="{{ $phone }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                                </div>
                            @endforeach
                            <div class="flex items-center mb-2">
                                <input type="text" name="phone_numbers[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="رقم جديد">
                                <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
                            </div>
                        </div>
                        <button type="button" class="text-blue-600 hover:text-blue-800" onclick="addField('phone-numbers-container', 'phone_numbers[]', 'رقم جديد')">إضافة رقم</button>
                        @error('phone_numbers.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('العنوان') }}</label>
                        <textarea name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('address', $contactUsSettings['contact_us_address']) }}</textarea>
                        @error('address')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('رابط الخريطة') }}</label>
                        <input type="url" name="map_url" value="{{ old('map_url', $contactUsSettings['contact_us_map_url']) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('map_url')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('روابط التواصل الاجتماعي') }}</label>
                        <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $contactUsSettings['contact_us_social_links']['facebook'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="فيسبوك">
                        @error('social_links.facebook')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $contactUsSettings['contact_us_social_links']['twitter'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="تويتر">
                        @error('social_links.twitter')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $contactUsSettings['contact_us_social_links']['instagram'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="إنستغرام">
                        @error('social_links.instagram')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('إعدادات النموذج') }}</label>
                        <label class="flex items-center">
                            <input type="checkbox" name="form_settings[enabled]" {{ old('form_settings.enabled', $contactUsSettings['contact_us_form_settings']['enabled'] ?? false) ? 'checked' : '' }} class="mr-2">
                            {{ __('تفعيل نموذج التواصل') }}
                        </label>
                        <input type="url" name="form_settings[redirect_url]" value="{{ old('form_settings.redirect_url', $contactUsSettings['contact_us_form_settings']['redirect_url'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="رابط إعادة التوجيه">
                        @error('form_settings.enabled')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        @error('form_settings.redirect_url')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('ساعات العمل') }}</label>
                        <textarea name="working_hours" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('working_hours', $contactUsSettings['contact_us_working_hours']) }}</textarea>
                        @error('working_hours')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('رسالة النجاح') }}</label>
                        <textarea name="success_message" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('success_message', $contactUsSettings['contact_us_success_message']) }}</textarea>
                        @error('success_message')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('حفظ الإعدادات') }}</button>
                </form>
            </div>

            <!-- Services Settings -->
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <h3 class="text-lg font-semibold">{{ __('إعدادات الخدمات') }}</h3>
            </div>
            <div class="accordion-content">
                @foreach ($services as $service)
                    <form action="{{ route('settings.updateService', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-6 border-b pb-6">
                        @csrf
                        @method('PUT')
                        <div>
                        <label class="block text-gray-700">{{ __('اسم الخدمة') }}</label>
                            <input type="text" name="name" value="{{ old('name', $service->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('وصف مختصر') }}</label>
                            <textarea name="short_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('short_description', $service->short_description) }}</textarea>
                            @error('short_description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('وصف مطوّل') }}</label>
                            <textarea name="long_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('long_description', $service->long_description) }}</textarea>
                            @error('long_description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('رابط مخصص') }}</label>
                            <input type="url" name="custom_url" value="{{ old('custom_url', $service->custom_url) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('custom_url')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('ترتيب العرض') }}</label>
                            <input type="number" name="order" value="{{ old('order', $service->order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0">
                            @error('order')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('الحالة') }}</label>
                            <input type="checkbox" name="status" {{ old('status', $service->status) ? 'checked' : '' }} value="1" class="mr-2">
                            {{ __('مفعل') }}
                            @error('status')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('معلومات SEO') }}</label>
                            <input type="text" name="seo_meta[title]" value="{{ old('seo_meta.title', $service->seo_meta['title'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="عنوان SEO">
                            @error('seo_meta.title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            <textarea name="seo_meta[description]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('seo_meta.description', $service->seo_meta['description'] ?? '') }}</textarea>
                            @error('seo_meta.description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700">{{ __('صورة الخدمة') }}</label>
                            <input type="file" name="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('image')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('تحديث الخدمة') }}</button>
                            <form action="{{ route('settings.destroyService', $service) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                            </form>
                        </div>
                    </form>
                @endforeach

                <!-- Add New Service -->
                <h4 class="text-md font-semibold mt-6 mb-4">{{ __('إضافة خدمة جديدة') }}</h4>
                <form action="{{ route('settings.storeService') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700">{{ __('اسم الخدمة') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('وصف مختصر') }}</label>
                        <textarea name="short_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('وصف مطوّل') }}</label>
                        <textarea name="long_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('long_description') }}</textarea>
                        @error('long_description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('رابط مخصص') }}</label>
                        <input type="url" name="custom_url" value="{{ old('custom_url') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('custom_url')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('ترتيب العرض') }}</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0">
                        @error('order')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('الحالة') }}</label>
                        <input type="checkbox" name="status" {{ old('status', true) ? 'checked' : '' }} value="1" class="mr-2">
                        {{ __('مفعل') }}
                        @error('status')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('معلومات SEO') }}</label>
                        <input type="text" name="seo_meta[title]" value="{{ old('seo_meta.title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="عنوان SEO">
                        @error('seo_meta.title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <textarea name="seo_meta[description]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('seo_meta.description') }}</textarea>
                        @error('seo_meta.description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700">{{ __('صورة الخدمة') }}</label>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('إضافة الخدمة') }}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(element) {
            const content = element.nextElementSibling;
            content.classList.toggle('active');
        }

        function addField(containerId, name, placeholder) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'flex items-center mb-2';
            div.innerHTML = `
                <input type="text" name="${name}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="${placeholder}">
                <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeField(this)">إزالة</button>
            `;
            container.appendChild(div);
        }

        function removeField(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>