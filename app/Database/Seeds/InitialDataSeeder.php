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
        // 2. JEFE DE TALLER
        // =============================================
        $this->db->table('usuarios')->insert([
            'username' => 'jefetaller',
            'password' => password_hash('jefetaller123', PASSWORD_DEFAULT),
            'rol' => 'RECEPCIONISTA',
            'estado' => 1,
        ]);
        $idUsuarioJefeTaller = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idUsuarioJefeTaller,
            'nombre_completo' => 'Roberto Mendoza García',
            'cargo' => 'Jefe de Taller',
            'especialidad' => 'Administración y Supervisión General',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // =============================================
        // 3. ÁREA DE CAMBIO DE ACEITE Y ENGRASADO
        // =============================================
        
        // Técnico Mecánico Supervisor
        $this->db->table('usuarios')->insert([
            'username' => 'supervisor_mecanico',
            'password' => password_hash('supervisor123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idSupervisorMecanico = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idSupervisorMecanico,
            'nombre_completo' => 'Juan Carlos Pérez',
            'cargo' => 'Técnico Mecánico Supervisor',
            'especialidad' => 'Cambio de Aceite y Engrasado',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Ayudante Mecánico 1
        $this->db->table('usuarios')->insert([
            'username' => 'ayudante_mec1',
            'password' => password_hash('ayudante123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idAyudanteMec1 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idAyudanteMec1,
            'nombre_completo' => 'Pedro Martínez López',
            'cargo' => 'Ayudante Mecánico',
            'especialidad' => 'Cambio de Aceite y Engrasado',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Ayudante Mecánico 2
        $this->db->table('usuarios')->insert([
            'username' => 'ayudante_mec2',
            'password' => password_hash('ayudante123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idAyudanteMec2 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idAyudanteMec2,
            'nombre_completo' => 'Miguel Ángel Rodríguez',
            'cargo' => 'Ayudante Mecánico',
            'especialidad' => 'Cambio de Aceite y Engrasado',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Ayudante Mecánico 3
        $this->db->table('usuarios')->insert([
            'username' => 'ayudante_mec3',
            'password' => password_hash('ayudante123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idAyudanteMec3 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idAyudanteMec3,
            'nombre_completo' => 'Luis Fernando Gómez',
            'cargo' => 'Ayudante Mecánico',
            'especialidad' => 'Cambio de Aceite y Engrasado',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // =============================================
        // 4. ÁREA DE LAVADO Y LIMPIEZA
        // =============================================
        
        // Encargado de Lavado - Rampa 1
        $this->db->table('usuarios')->insert([
            'username' => 'encargado_lavado1',
            'password' => password_hash('lavado123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idEncargadoLavado1 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idEncargadoLavado1,
            'nombre_completo' => 'Carlos Alberto Sánchez',
            'cargo' => 'Encargado de Lavado',
            'especialidad' => 'Lavado y Limpieza - Rampa 1',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Encargado de Lavado - Rampa 2
        $this->db->table('usuarios')->insert([
            'username' => 'encargado_lavado2',
            'password' => password_hash('lavado123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idEncargadoLavado2 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idEncargadoLavado2,
            'nombre_completo' => 'José Manuel Hernández',
            'cargo' => 'Encargado de Lavado',
            'especialidad' => 'Lavado y Limpieza - Rampa 2',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Encargado de Lavado - Rampa 3
        $this->db->table('usuarios')->insert([
            'username' => 'encargado_lavado3',
            'password' => password_hash('lavado123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idEncargadoLavado3 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idEncargadoLavado3,
            'nombre_completo' => 'Ricardo Torres Vargas',
            'cargo' => 'Encargado de Lavado',
            'especialidad' => 'Lavado y Limpieza - Rampa 3',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Ayudante de Lavado 1 (Recepción y Aspirado)
        $this->db->table('usuarios')->insert([
            'username' => 'ayudante_lavado1',
            'password' => password_hash('ayudante123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idAyudanteLavado1 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idAyudanteLavado1,
            'nombre_completo' => 'Diego Alejandro Ruiz',
            'cargo' => 'Ayudante de Lavado',
            'especialidad' => 'Recepción de Vehículos y Aspirado Interior',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // Ayudante de Lavado 2 (Recepción y Aspirado)
        $this->db->table('usuarios')->insert([
            'username' => 'ayudante_lavado2',
            'password' => password_hash('ayudante123', PASSWORD_DEFAULT),
            'rol' => 'EMPLEADO',
            'estado' => 1,
        ]);
        $idAyudanteLavado2 = $this->db->insertID();

        $this->db->table('empleados')->insert([
            'id_usuario' => $idAyudanteLavado2,
            'nombre_completo' => 'Andrés Felipe Morales',
            'cargo' => 'Ayudante de Lavado',
            'especialidad' => 'Recepción de Vehículos y Aspirado Interior',
            'fecha_contratacion' => date('Y-m-d'),
        ]);

        // =============================================
        // 5. SERVICIOS BÁSICOS (según enunciado del proyecto)
        // =============================================
        $servicios = [
            // === SERVICIOS DE MECÁNICA (Cambio de Aceite y Engrasado) ===
            [
                'nombre' => 'Cambio de Aceite',
                'descripcion' => 'Cambio de aceite de motor con filtro incluido',
                'costo_mano_obra' => 50.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Engrasado de Partes',
                'descripcion' => 'Engrasado completo de partes móviles, bisagras, rodamientos y articulaciones del vehículo',
                'costo_mano_obra' => 40.00,
                'tiempo_estimado' => 45,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Cambio de Frenos',
                'descripcion' => 'Cambio de pastillas o zapatas de freno',
                'costo_mano_obra' => 100.00,
                'tiempo_estimado' => 90,
                'requiere_rampa' => 1,
            ],
            // === SERVICIOS DE LAVADO Y LIMPIEZA ===
            [
                'nombre' => 'Aspirado',
                'descripcion' => 'Aspirado completo del interior del vehículo incluyendo asientos, alfombras y maletero',
                'costo_mano_obra' => 25.00,
                'tiempo_estimado' => 20,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Lavado',
                'descripcion' => 'Lavado exterior completo del vehículo con shampoo automotriz y secado',
                'costo_mano_obra' => 35.00,
                'tiempo_estimado' => 30,
                'requiere_rampa' => 1,
            ],
            [
                'nombre' => 'Fumigado',
                'descripcion' => 'Fumigado y desinfección completa del interior del vehículo',
                'costo_mano_obra' => 45.00,
                'tiempo_estimado' => 25,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Encerado',
                'descripcion' => 'Aplicación de cera protectora en toda la carrocería del vehículo',
                'costo_mano_obra' => 50.00,
                'tiempo_estimado' => 40,
                'requiere_rampa' => 0,
            ],
            [
                'nombre' => 'Pulido',
                'descripcion' => 'Pulido profesional para eliminar rayones superficiales y restaurar el brillo de la pintura',
                'costo_mano_obra' => 80.00,
                'tiempo_estimado' => 60,
                'requiere_rampa' => 0,
            ],
        ];

        $this->db->table('servicios')->insertBatch($servicios);

        // =============================================
        // 6. INSUMOS BÁSICOS (según servicios del enunciado)
        // =============================================
        $insumos = [
            // === INSUMOS DE MECÁNICA ===
            // Para Cambio de Aceite
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
            // Para Engrasado de Partes
            [
                'codigo' => 'GRA-001',
                'nombre' => 'Grasa Multiusos (1kg)',
                'descripcion' => 'Grasa de litio para lubricación de partes móviles',
                'precio_venta' => 45.00,
                'stock_actual' => 15,
                'stock_minimo' => 5,
            ],
            // Para Cambio de Frenos
            [
                'codigo' => 'PAS-001',
                'nombre' => 'Pastillas de Freno Delanteras',
                'descripcion' => 'Juego de pastillas de freno delanteras',
                'precio_venta' => 80.00,
                'stock_actual' => 10,
                'stock_minimo' => 3,
            ],
            [
                'codigo' => 'LIQ-001',
                'nombre' => 'Líquido de Frenos DOT4',
                'descripcion' => 'Líquido de frenos DOT4 500ml',
                'precio_venta' => 30.00,
                'stock_actual' => 12,
                'stock_minimo' => 5,
            ],
            // === INSUMOS DE LAVADO Y LIMPIEZA ===
            // Para Lavado
            [
                'codigo' => 'SHA-001',
                'nombre' => 'Shampoo Automotriz (5L)',
                'descripcion' => 'Shampoo concentrado para lavado de vehículos',
                'precio_venta' => 35.00,
                'stock_actual' => 10,
                'stock_minimo' => 3,
            ],
            // Para Fumigado
            [
                'codigo' => 'FUM-001',
                'nombre' => 'Fumigante Desinfectante',
                'descripcion' => 'Spray fumigante para desinfección de interiores',
                'precio_venta' => 40.00,
                'stock_actual' => 15,
                'stock_minimo' => 5,
            ],
            // Para Encerado
            [
                'codigo' => 'CER-001',
                'nombre' => 'Cera Protectora (500ml)',
                'descripcion' => 'Cera líquida para protección y brillo de carrocería',
                'precio_venta' => 55.00,
                'stock_actual' => 12,
                'stock_minimo' => 4,
            ],
            // Para Pulido
            [
                'codigo' => 'PUL-001',
                'nombre' => 'Pulidor de Carrocería (500ml)',
                'descripcion' => 'Compuesto pulidor para eliminar rayones y restaurar brillo',
                'precio_venta' => 65.00,
                'stock_actual' => 8,
                'stock_minimo' => 3,
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

        // =============================================
        // 8. CLIENTES DE EJEMPLO
        // =============================================
        
        // Cliente 1 - María García
        $this->db->table('usuarios')->insert([
            'username' => 'maria_garcia',
            'password' => password_hash('cliente123', PASSWORD_DEFAULT),
            'rol' => 'CLIENTE',
            'estado' => 1,
        ]);
        $idUsuarioCliente1 = $this->db->insertID();

        $this->db->table('clientes')->insert([
            'id_usuario' => $idUsuarioCliente1,
            'nombre_completo' => 'María García Flores',
            'ci_nit' => '4532167',
            'telefono' => '72512345',
            'correo' => 'maria.garcia@gmail.com',
            'direccion' => 'Calle Bolívar #456, Oruro',
        ]);
        $idCliente1 = $this->db->insertID();

        // Vehículo del Cliente 1
        $this->db->table('vehiculos')->insert([
            'id_cliente' => $idCliente1,
            'placa' => '1234-ABC',
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'anio' => 2020,
            'tipo_motor' => 'Gasolina 1.8L',
            'color' => 'Blanco',
        ]);

        // Cliente 2 - Carlos Mendoza
        $this->db->table('usuarios')->insert([
            'username' => 'carlos_mendoza',
            'password' => password_hash('cliente123', PASSWORD_DEFAULT),
            'rol' => 'CLIENTE',
            'estado' => 1,
        ]);
        $idUsuarioCliente2 = $this->db->insertID();

        $this->db->table('clientes')->insert([
            'id_usuario' => $idUsuarioCliente2,
            'nombre_completo' => 'Carlos Mendoza Quispe',
            'ci_nit' => '6789234',
            'telefono' => '71598765',
            'correo' => 'carlos.mendoza@hotmail.com',
            'direccion' => 'Av. 6 de Octubre #789, Oruro',
        ]);
        $idCliente2 = $this->db->insertID();

        // Vehículo del Cliente 2
        $this->db->table('vehiculos')->insert([
            'id_cliente' => $idCliente2,
            'placa' => '5678-DEF',
            'marca' => 'Nissan',
            'modelo' => 'Sentra',
            'anio' => 2018,
            'tipo_motor' => 'Gasolina 1.6L',
            'color' => 'Gris',
        ]);

        // Cliente 3 - Ana Rodríguez
        $this->db->table('usuarios')->insert([
            'username' => 'ana_rodriguez',
            'password' => password_hash('cliente123', PASSWORD_DEFAULT),
            'rol' => 'CLIENTE',
            'estado' => 1,
        ]);
        $idUsuarioCliente3 = $this->db->insertID();

        $this->db->table('clientes')->insert([
            'id_usuario' => $idUsuarioCliente3,
            'nombre_completo' => 'Ana Rodríguez Mamani',
            'ci_nit' => '3456789',
            'telefono' => '67834521',
            'correo' => 'ana.rodriguez@gmail.com',
            'direccion' => 'Calle Junín #234, Oruro',
        ]);
        $idCliente3 = $this->db->insertID();

        // Vehículo 1 del Cliente 3
        $this->db->table('vehiculos')->insert([
            'id_cliente' => $idCliente3,
            'placa' => '9012-GHI',
            'marca' => 'Hyundai',
            'modelo' => 'Tucson',
            'anio' => 2022,
            'tipo_motor' => 'Gasolina 2.0L',
            'color' => 'Rojo',
        ]);

        // Vehículo 2 del Cliente 3
        $this->db->table('vehiculos')->insert([
            'id_cliente' => $idCliente3,
            'placa' => '3456-JKL',
            'marca' => 'Suzuki',
            'modelo' => 'Swift',
            'anio' => 2019,
            'tipo_motor' => 'Gasolina 1.2L',
            'color' => 'Azul',
        ]);

        echo "✅ Datos iniciales insertados correctamente.\n";
        echo "   ADMINISTRACIÓN:\n";
        echo "   - Administrador: admin / admin123\n";
        echo "   - Jefe de Taller: jefetaller / jefetaller123\n";
        echo "   ÁREA DE CAMBIO DE ACEITE Y ENGRASADO:\n";
        echo "   - Supervisor Mecánico: supervisor_mecanico / supervisor123\n";
        echo "   - Ayudantes Mecánicos: ayudante_mec1, ayudante_mec2, ayudante_mec3 / ayudante123\n";
        echo "   ÁREA DE LAVADO Y LIMPIEZA:\n";
        echo "   - Encargados de Lavado: encargado_lavado1, encargado_lavado2, encargado_lavado3 / lavado123\n";
        echo "   - Ayudantes de Lavado: ayudante_lavado1, ayudante_lavado2 / ayudante123\n";
        echo "   CLIENTES DE EJEMPLO:\n";
        echo "   - maria_garcia, carlos_mendoza, ana_rodriguez / cliente123\n";
        echo "   - " . count($servicios) . " servicios creados\n";
        echo "   - " . count($insumos) . " insumos creados\n";
        echo "   - " . count($rampas) . " rampas creadas\n";
        echo "   - 3 clientes con 4 vehículos creados\n";
    }
}
