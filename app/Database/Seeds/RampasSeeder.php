<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RampasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Rampa 1', 'estado' => 'LIBRE'],
            ['nombre' => 'Rampa 2', 'estado' => 'LIBRE'],
            ['nombre' => 'Rampa 3', 'estado' => 'LIBRE'],
        ];

        // Using Query Builder
        $this->db->table('rampas')->insertBatch($data);
    }
}
