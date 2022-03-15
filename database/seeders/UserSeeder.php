<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin_system@uaq.com',
            'password' => Hash::make('$Admin_system$3277'),
        ])->assignRole('Admin');

        User::create([
            'email' => 'user_system@uaq.com',
            'password' => Hash::make('$User_system$3277'),
        ])->assignRole('User');
    }
}
