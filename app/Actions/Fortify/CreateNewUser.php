<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number'=>['required','string','max:255'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'profile_photo_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number'=>$input['phone_number'],
            'city_id' =>$input['city_id'],
            'profile_photo_path' =>$input['profile_photo_path'] ?? null,
            'password' => Hash::make($input['password']),
        ]);
        $user->assignRole('user');
        return $user;
    }
}
