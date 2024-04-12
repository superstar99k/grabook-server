<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $testUserNotExist = DB::table('users')->where('email', config('mics.test_user.email'))->doesntExist();

        if ($testUserNotExist) {
            DB::table('users')->insert([
                'role' => \App\Enums\Role\Type::Admin,
                'name' => config('mics.test_user.name'),
                'postal_code' => '000-0000',
                'address' => 'XXXXXXXXXXX',
                'tel' => '012345678',
                'email' => config('mics.test_user.email'),
                'password' => Hash::make(config('mics.test_user.password')),
                'verification_code' => '',
                'verification_generated_at' => now(),
                'status' => \App\Enums\User\Status::Activated,
            ]);
        }
    }
}
