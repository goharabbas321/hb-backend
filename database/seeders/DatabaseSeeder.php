<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Medical\Database\Seeders\MedicalDatabaseSeeder;
use Modules\Setting\Database\Seeders\SettingDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserDatabaseSeeder::class);
        $this->call(SettingDatabaseSeeder::class);
        $this->call(MedicalDatabaseSeeder::class);
    }
}
