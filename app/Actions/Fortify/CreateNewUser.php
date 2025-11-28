<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        try {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // نحدد طول مناسب لرقم الهاتف (عادة 20 حرف كافية جدًا مع الرموز)
                'phone_number' => ['required', 'string', 'max:20', 'regex:/^[\+]?[0-9\(\)\-\s]+$/'],
                'city_id' => ['nullable', 'integer', 'exists:cities,id'],
                'profile_photo_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : [],
            ], [
                // رسائل مخصصة بالعربية
                'phone_number.max' => 'رقم الهاتف طويل جداً، يجب ألا يتجاوز 20 حرفاً.',
                'phone_number.regex' => 'صيغة رقم الهاتف غير صحيحة، يسمح فقط بالأرقام والرموز (+, -, (, ), -, مسافة).',
            ])->validate();

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone_number' => $input['phone_number'],
                'city_id' => $input['city_id'] ?? null,
                'profile_photo_path' => $input['profile_photo_path'] ?? null,
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole('user');

            session()->flash('message', [
                'type' => 'info',
                'content' => 'تم إنشاء الحساب بنجاح. مرحباً بك!',
                'img' => asset('frontend/assets/img/welcome-register.png')
            ]);

            return $user;

        } catch (QueryException $e) {
            // التقاط أخطاء قاعدة البيانات مثل "Data too long"
            if ($e->getCode() == '22001') {
                throw ValidationException::withMessages([
                    'phone_number' => 'رقم الهاتف طويل جداً ولا يمكن حفظه. الرجاء إدخال رقم أقصر أو بدون رموز زائدة.',
                ]);
            }

            // أي خطأ آخر في قاعدة البيانات نعيده كـ Validation (لئلا يظهر صفحة خطأ لارافل)
            throw ValidationException::withMessages([
                'email' => 'حدث خطأ أثناء إنشاء الحساب، يرجى المحاولة مرة أخرى.',
            ]);
        } catch (\Exception $e) {
            // أي خطأ غير متوقع
            throw ValidationException::withMessages([
                'email' => 'فشل في إنشاء الحساب، يرجى المحاولة لاحقاً.',
            ]);
        }
    }
}
