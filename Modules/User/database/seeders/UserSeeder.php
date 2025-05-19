<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //super_admin
        $new_user = User::create([
            'name' => 'هيئة الصحة والتعليم الطبي',
            'username' => 'super_admin',
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('11223344'),
            'phone' => '07751279111',
            'user_information' => json_encode(['address' => 'كربلاء، العراق', 'country' => 'Iraq']),
            'status' => 1,
            'language' => 'ar',
        ]);

        $new_user->assignRole('super_admin');

        //hospital
        $new_user = User::create([
            'name' => 'مستشفى السفير',
            'email' => 'safeer@hospital.com',
            'username' => 'safeer_hospital',
            'email_verified_at' => now(),
            'password' => Hash::make('11223344'),
            'phone' => '07751279233',
            'user_information' => json_encode(['address' => 'كربلاء، العراق', 'country' => 'Iraq']),
            'status' => 1,
            'language' => 'ar',
        ]);

        $new_user->assignRole('hospital');

        //hospital
        $new_user = User::create([
            'name' => 'مستشفى الإمام زين العابدين',
            'email' => 'zain@hospital.com',
            'username' => 'zain_hospital',
            'email_verified_at' => now(),
            'password' => Hash::make('11223344'),
            'phone' => '07751279222',
            'user_information' => json_encode(['address' => 'كربلاء، العراق', 'country' => 'Iraq']),
            'status' => 1,
            'language' => 'ar',
        ]);

        $new_user->assignRole('hospital');

        //patient
        $new_user = User::create([
            'name' => 'جوهر عباس',
            'email' => 'user1@admin.com',
            'username' => 'user1',
            'email_verified_at' => now(),
            'password' => Hash::make('11223344'),
            'phone' => '07751279232',
            'user_information' => json_encode(['address' => 'Column no 4, Boobyat', 'city' => 'Karbala', 'country' => 'Iraq', 'age' => 30, 'gender' => 'Male', 'emergency_contact' => '07751279222']),
            'status' => 1,
            'language' => 'ar',
        ]);

        $new_user->assignRole('patient');
    }
}
