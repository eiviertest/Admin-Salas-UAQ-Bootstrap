<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estatus;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estatus::create([
            'nomEst' => 'En proceso'
        ]);

        Estatus::create([
            'nomEst' => 'Aceptada'
        ]);

        Estatus::create([
            'nomEst' => 'Rechazada'
        ]);
    }
}
