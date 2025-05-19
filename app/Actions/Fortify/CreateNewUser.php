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
        if (getJsonSetting('system_settings', 'registration') == 1) {
            Validator::make($input, [
                'username' => 'required|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'name' => 'required|string|max:255',
                'phone' => 'required|unique:users,phone|regex:/^\d{11}$/',
                'country' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'language' => 'required|string|max:10',
                'currency' => 'required|string|max:10',
                'time_zone' => 'required|string|max:50',
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            $user = User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'user_information' => json_encode(['address' => $input['address'], 'country' => $input['country']]),
                'status' => 1,
                'language' => $input['language'],
                'currency' => $input['currency'],
            ]);

            // Assign role to the user
            $user->assignRole('admin');

            return $user;
        } else {
            abort(403);
        }
    }
}
