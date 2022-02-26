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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ])->assignRole('Admin');

        User::create([
            'email' => 'user@gmail.com',
            'password' => Hash::make('1234'),
        ])->assignRole('User');
    }
}