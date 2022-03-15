<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Persona;
use App\Models\Area;
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

        $user = User::create([
            'email' => 'user_system@uaq.com',
            'password' => Hash::make('$User_system$3277'),
        ])->assignRole('User');

        $area = Area::create([
            'nomArea' => 'Informatizacion'
        ]);

        Persona::create([
            'nomPer' => 'User',
            'apePatPer' => 'Informatizacion',
            'apeMatPer' => 'UAQ',
            'telPer' => 3277,
            'idUsr' => $user->id,
            'idArea' => $area->idArea,
        ]);
    }
}
