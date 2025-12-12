<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder para datos iniciales del sistema
 * Incluye: Usuario admin, servicios, insumos y rampas básicas
 */
class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // =============================================
        // 1. USUARIO ADMINISTRADOR
        // =============================================
        $this->db->table('usuarios')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'rol' => 'ADMIN',
            'estado' => 1,
        ]);

        // =============================================
        // 2. USUARIO RECEPCIONISTA DE EJEMPLO
        // =============================================
        $this->db->table('usuarios')->insert([
            'username' => 'recepcion',
            'password' => password_hash('recepcion123', PASSWORD_DEFAULT),
            'rol' => 'RECEPCIONISTA',
            'estado' => 1,
        ]);

        // =============================================
        // 3. USUARIOS EMPLEADOS (Técnicos)
        // =============================================
        $empleadoUserId1 = $this->db->table('usuarios')->insert([
            'username' => 'tecnico1',
            'password' => password_hash('tecnico123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idUsuarioEmpleado1 = $this->db->insertID();

        $empleadoUserId2 = $this->db->table('usuarios')->insert([
            'username' => 'tecnico2',
            'password' => password_hash('tecnico123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idUsuarioEmpleado2 = $this->db->insertID();

        // =============================================
        // 4. EMPLEADOS (vinculados a usuarios)
        // =============================================
        $this->db->table('empleados')->insert([
            'id_usuario' => $idUsuarioEmpleado1,
            'nombre_completo' => 'Juan Pérez Técnico',
            'cargo' => 'Técnico Mecánico',
            'especialidad' => 'Motor y Transmisión',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        $this->db->table('empleados')->insert([
            'id_usuario' => $idUsuarioEmpleado2,
            'nombre_completo' => 'Carlos López Técnico',
            'cargo' => 'Técnico Eléctrico',
            'especialidad' => 'Sistema Eléctrico y Electrónico',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // =============================================
        // 5. SERVICIOS BÁSICOS
        // =============================================
        $servicios = [
            [
                'nombre' => 'Cambio de Aceite',
                'descripcion' => 'Cambio de aceite de motor con filtro incluido',
                'costo_mano_obra' => 50.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Alineación y Balanceo',
                'descripcion' => 'Alineación de dirección y balanceo de las 4 ruedas',
                'costo_mano_obra' => 80.00,
                'tiempo_estimado' => 60,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Cambio de Frenos',
                'descripcion' => 'Cambio de pastillas o zapatas de freno',
                'costo_mano_obra' => 100.00,
                'tiempo_estimado' => 90,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Diagnóstico Electrónico',
                'descripcion' => 'Escaneo y diagnóstico computarizado del vehículo',
                'costo_mano_obra' => 60.00,
                'tiempo_estimado' => 45,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Cambio de Batería',
                'descripcion' => 'Instalación de batería nueva',
                'costo_mano_obra' => 30.00,
                'tiempo_estimado' => 20,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Revisión General',
                'descripcion' => 'Inspección completa del vehículo (niveles, luces, frenos, suspensión)',
                'costo_mano_obra' => 70.00,
                'tiempo_estimado' => 60,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Cambio de Filtro de Aire',
                'descripcion' => 'Reemplazo del filtro de aire del motor',
                'costo_mano_obra' => 20.00,
                'tiempo_estimado' => 15,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Cambio de Bujías',
                'descripcion' => 'Reemplazo de bujías de encendido',
                'costo_mano_obra' => 40.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Reparación de Suspensión',
                'descripcion' => 'Reparación o cambio de amortiguadores y componentes de suspensión',
                'costo_mano_obra' => 150.00,
                'tiempo_estimado' => 120,
                'requiere_rampa' => 1,
            ],
        ];

        $this->db->table('servicios')->insertBatch($servicios);

        // =============================================
        // 6. INSUMOS BÁSICOS
        // =============================================
        $insumos = [
            [
                'codigo' => 'ACE-001',
                'nombre' => 'Aceite de Motor 10W40 (4L)',
                'descripcion' => 'Aceite sintético para motor 10W40',
                'precio_venta' => 120.00,
                'stock_actual' => 20,
                'stock_minimo' => 5,
            ],
            [
                'codigo' => 'FIL-001',
                'nombre' => 'Filtro de Aceite Universal',
                'descripcion' => 'Filtro de aceite compatible con múltiples marcas',
                'precio_venta' => 25.00,
                'stock_actual' => 30,
                'stock_minimo' => 10,
            ],
            [
                'codigo' => 'FIL-002',
                'nombre' => 'Filtro de Aire',
                'descripcion' => 'Filtro de aire para motor',
                'precio_venta' => 35.00,
                'stock_actual' => 15,
                'stock_minimo' => 5,
            ],
            [
                'codigo' => 'PAS-001',
                'nombre' => 'Pastillas de Freno Delanteras',
                'descripcion' => 'Juego de pastillas de freno delanteras',
                'precio_venta' => 80.00,
                'stock_actual' => 10,
                'stock_minimo' => 3,
            ],
            [
                'codigo' => 'BUJ-001',
                'nombre' => 'Bujía NGK',
                'descripcion' => 'Bujía de encendido NGK estándar',
                'precio_venta' => 15.00,
                'stock_actual' => 40,
                'stock_minimo' => 10,
            ],
            [
                'codigo' => 'LIQ-001',
                'nombre' => 'Líquido de Frenos DOT4',
                'descripcion' => 'Líquido de frenos DOT4 500ml',
                'precio_venta' => 30.00,
                'stock_actual' => 12,
                'stock_minimo' => 5,
            ],
            [
                'codigo' => 'REF-001',
                'nombre' => 'Refrigerante Anticongelante',
                'descripcion' => 'Refrigerante verde anticongelante 1L',
                'precio_venta' => 25.00,
                'stock_actual' => 18,
                'stock_minimo' => 5,
            ],
        ];

        $this->db->table('insumos')->insertBatch($insumos);

        // =============================================
        // 7. RAMPAS
        // =============================================
        $rampas = [
            ['nombre' => 'Rampa 1', 'estado' => 'LIBRE'],
            ['nombre' => 'Rampa 2', 'estado' => 'LIBRE'],
            ['nombre' => 'Rampa 3', 'estado' => 'LIBRE'],
        ];

        $this->db->table('rampas')->insertBatch($rampas);

        echo "✅ Datos iniciales insertados correctamente.\n";
        echo "   - Usuario admin: admin / admin123\n";
        echo "   - Usuario recepción: recepcion / recepcion123\n";
        echo "   - Técnicos: tecnico1, tecnico2 / tecnico123\n";
        echo "   - " . count($servicios) . " servicios creados\n";
        echo "   - " . count($insumos) . " insumos creados\n";
        echo "   - " . count($rampas) . " rampas creadas\n";
    }
}
