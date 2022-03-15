<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sala;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sala::create([
            'nomSala' => 'A',
        ]);

        Sala::create([
            'nomSala' => 'B',
        ]);
    }
}
