<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Requieren Rampa
            [
                'nombre' => 'Lavado',
                'descripcion' => 'Lavado completo de carrocería y chasis.',
                'costo_mano_obra' => 50.00,
                'tiempo_estimado' => 40,
                'requiere_rampa' => 1
            ],
            [
                'nombre' => 'Limpieza',
                'descripcion' => 'Limpieza profunda de interiores y motor.',
                'costo_mano_obra' => 70.00,
                'tiempo_estimado' => 60,
                'requiere_rampa' => 1
            ],
            [
                'nombre' => 'Fumigado',
                'descripcion' => 'Fumigado y desinfección del vehículo.',
                'costo_mano_obra' => 40.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 1
            ],
            // No requieren Rampa directa (según requerimiento, aunque cambio de aceite suele requerir, el usuario especificó solo 3 rampas para los 3 de arriba? 
            // Re-reading: "son 3 servicios que requieren rampa". The list was "son 3 rampas para: lavado, limpieza, fumigado."
            // But he also said "cambio de aceite, engrasado... cambio de frenos... Hay algunos servicios que requieren el uso de rampa".
            // Let's assume standard mechanical jobs also need ramp logically, but let's stick to his EXPLICIT list of "3 rampas para: lavado, limpieza, fumigado".
            // Wait, "Hay algunos servicios que requieren el uso de rampa... son 3 servicios que requieren rampa".
            // It strongly implies ONLY those 3 explicitly mentioned for the 3 ramps. 
            // However, Oil Change and Brake Change visually need a ramp or pit.
            // Let's set 'requiere_rampa' = 1 for the explicit ones mostly. 
            // Actually, "cambio de frenos, ajuste de frenos" usually need a jack or ramp.
            // Let's follow the user's specific text: "son 3 servicios que requieren rampa".
            // So I will only mark Lavado, Limpieza, Fumigado as 1?
            // "son 3 rampas para: lavado, limpieza, fumigado." -> Likely these are the SPECIAL ramps inside the Washing Area?
            // "Hay algunos servicios que requieren el uso de rampa... son 3 servicios que requieren rampa".
            // Okay, I will interpret that ONLY {Lavado, Limpieza, Fumigado} are the ones triggering the "Rampa Constraint" mentioned. 
            // OR maybe he meant there are 3 physical ramps available, and 3 services that *use* them.
            // I'll stick to Lavado, Limpieza, Fumigado as the 'requiere_rampa=1' ones for now based on the phrasing "3 rampas para: ...".

            [
                'nombre' => 'Cambio de Aceite',
                'descripcion' => 'Cambio de aceite de motor y filtro.',
                'costo_mano_obra' => 30.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 0
            ],
            [
                'nombre' => 'Engrasado',
                'descripcion' => 'Engrasado general de suspensión y dirección.',
                'costo_mano_obra' => 40.00,
                'tiempo_estimado' => 40,
                'requiere_rampa' => 0
            ],
            [
                'nombre' => 'Cambio de Frenos',
                'descripcion' => 'Cambio de pastillas o balatas.',
                'costo_mano_obra' => 80.00,
                'tiempo_estimado' => 90,
                'requiere_rampa' => 0
            ],
            [
                'nombre' => 'Ajuste de Frenos',
                'descripcion' => 'Regulación y limpieza de frenos.',
                'costo_mano_obra' => 50.00,
                'tiempo_estimado' => 45,
                'requiere_rampa' => 0
            ],
            [
                'nombre' => 'Encerado',
                'descripcion' => 'Encerado manual de carrocería.',
                'costo_mano_obra' => 60.00,
                'tiempo_estimado' => 45,
                'requiere_rampa' => 0
            ],
            [
                'nombre' => 'Pulido',
                'descripcion' => 'Pulido de pintura para eliminar rayas superficiales.',
                'costo_mano_obra' => 100.00,
                'tiempo_estimado' => 120,
                'requiere_rampa' => 0
            ],
        ];

        // Using Query Builder
        $this->db->table('servicios')->insertBatch($data);
    }
}
