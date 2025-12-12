<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migración completa de la base de datos del Taller Automotriz
 * Esta migración crea todas las tablas necesarias para el sistema
 */
class CreateFullDatabase extends Migration
{
    public function up()
    {
        // =============================================
        // 1. TABLA USUARIOS (tabla principal de autenticación)
        // =============================================
        $this->forge->addField([
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'rol' => [
                'type' => 'ENUM',
                'constraint' => ['ADMIN', 'RECEPCIONISTA', 'EMPLEADO', 'CLIENTE'],
            ],
            'estado' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => true,
            ],
            'fecha_creacion' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_usuario', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('usuarios', true);

        // Agregar default CURRENT_TIMESTAMP después de crear la tabla
        $this->db->query("ALTER TABLE usuarios MODIFY fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        // =============================================
        // 2. TABLA CLIENTES
        // =============================================
        $this->forge->addField([
            'id_cliente' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nombre_completo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'ci_nit' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'correo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_cliente', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('clientes', true);

        // =============================================
        // 3. TABLA EMPLEADOS
        // =============================================
        $this->forge->addField([
            'id_empleado' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nombre_completo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'cargo' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'especialidad' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'fecha_contratacion' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_empleado', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario', 'CASCADE', 'CASCADE');
        $this->forge->createTable('empleados', true);

        // =============================================
        // 4. TABLA VEHICULOS
        // =============================================
        $this->forge->addField([
            'id_vehiculo' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_cliente' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'placa' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'marca' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'modelo' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'anio' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tipo_motor' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_vehiculo', true);
        $this->forge->addUniqueKey('placa');
        $this->forge->addForeignKey('id_cliente', 'clientes', 'id_cliente', 'CASCADE', 'CASCADE');
        $this->forge->createTable('vehiculos', true);

        // =============================================
        // 5. TABLA SERVICIOS
        // =============================================
        $this->forge->addField([
            'id_servicio' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'costo_mano_obra' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'tiempo_estimado' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'requiere_rampa' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_servicio', true);
        $this->forge->createTable('servicios', true);

        // =============================================
        // 6. TABLA INSUMOS
        // =============================================
        $this->forge->addField([
            'id_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'codigo' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'precio_venta' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'stock_actual' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => true,
            ],
            'stock_minimo' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 5,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_insumo', true);
        $this->forge->createTable('insumos', true);

        // =============================================
        // 7. TABLA RAMPAS
        // =============================================
        $this->forge->addField([
            'id_rampa' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['LIBRE', 'OCUPADA', 'MANTENIMIENTO'],
                'default' => 'LIBRE',
            ],
        ]);
        $this->forge->addKey('id_rampa', true);
        $this->forge->createTable('rampas', true);

        // =============================================
        // 8. TABLA RESERVAS
        // =============================================
        $this->forge->addField([
            'id_reserva' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_cliente' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_vehiculo' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'fecha_reserva' => [
                'type' => 'DATETIME',
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['PENDIENTE', 'EN_PROCESO', 'FINALIZADA', 'CANCELADA'],
                'default' => 'PENDIENTE',
                'null' => true,
            ],
            'fecha_registro' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_reserva', true);
        $this->forge->addForeignKey('id_cliente', 'clientes', 'id_cliente', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_vehiculo', 'vehiculos', 'id_vehiculo', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reservas', true);

        // Agregar default CURRENT_TIMESTAMP
        $this->db->query("ALTER TABLE reservas MODIFY fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        // =============================================
        // 9. TABLA DETALLE_RESERVA
        // =============================================
        $this->forge->addField([
            'id_detalle' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_reserva' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_servicio' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'cantidad_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'null' => true,
            ],
            'precio_unitario_momento' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_detalle', true);
        $this->forge->addForeignKey('id_reserva', 'reservas', 'id_reserva', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_servicio', 'servicios', 'id_servicio', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detalle_reserva', true);

        // =============================================
        // 10. TABLA ORDENES_TRABAJO
        // =============================================
        $this->forge->addField([
            'id_orden' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_reserva' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_empleado_asignado' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_rampa' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
            'fecha_inicio_real' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_fin_real' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'observaciones_tecnicas' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'PENDIENTE',
            ],
        ]);
        $this->forge->addKey('id_orden', true);
        $this->forge->addForeignKey('id_reserva', 'reservas', 'id_reserva', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_empleado_asignado', 'empleados', 'id_empleado', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_rampa', 'rampas', 'id_rampa', 'SET NULL', 'CASCADE');
        $this->forge->createTable('ordenes_trabajo', true);

        // =============================================
        // 11. TABLA DETALLE_INSUMOS_ORDEN
        // =============================================
        $this->forge->addField([
            'id_detalle_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_orden' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'cantidad' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'costo_unitario' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_detalle_insumo', true);
        $this->forge->addForeignKey('id_orden', 'ordenes_trabajo', 'id_orden', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_insumo', 'insumos', 'id_insumo', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detalle_insumos_orden', true);

        // =============================================
        // 12. TABLA FACTURAS
        // =============================================
        $this->forge->addField([
            'id_factura' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_orden' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'fecha_emision' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'monto_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'nit_facturacion' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'razon_social' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'estado_pago' => [
                'type' => 'ENUM',
                'constraint' => ['PENDIENTE', 'PAGADO', 'ANULADO'],
                'default' => 'PENDIENTE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_factura', true);
        $this->forge->addForeignKey('id_orden', 'ordenes_trabajo', 'id_orden', 'CASCADE', 'CASCADE');
        $this->forge->createTable('facturas', true);

        // Agregar default CURRENT_TIMESTAMP
        $this->db->query("ALTER TABLE facturas MODIFY fecha_emision DATETIME DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        // Eliminar tablas en orden inverso (por las foreign keys)
        $this->forge->dropTable('facturas', true);
        $this->forge->dropTable('detalle_insumos_orden', true);
        $this->forge->dropTable('ordenes_trabajo', true);
        $this->forge->dropTable('detalle_reserva', true);
        $this->forge->dropTable('reservas', true);
        $this->forge->dropTable('rampas', true);
        $this->forge->dropTable('insumos', true);
        $this->forge->dropTable('servicios', true);
        $this->forge->dropTable('vehiculos', true);
        $this->forge->dropTable('empleados', true);
        $this->forge->dropTable('clientes', true);
        $this->forge->dropTable('usuarios', true);
    }
}
