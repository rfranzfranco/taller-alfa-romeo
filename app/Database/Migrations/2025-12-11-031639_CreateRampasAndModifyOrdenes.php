<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRampasAndModifyOrdenes extends Migration
{
    public function up()
    {
        // 1. Create Rampas Table (si no existe)
        if (! $this->db->tableExists('rampas')) {
            $this->forge->addField([
            'id_rampa' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['LIBRE', 'OCUPADA'],
                'default' => 'LIBRE',
            ],
            ]);
            $this->forge->addKey('id_rampa', true);
            $this->forge->createTable('rampas');
        }

        // 2. Add id_rampa to ordenes_trabajo
        $fields = [
            'id_rampa' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
                'after' => 'id_empleado_asignado'
            ]
        ];
        if ($this->db->tableExists('ordenes_trabajo') && ! $this->db->fieldExists('id_rampa', 'ordenes_trabajo')) {
            $this->forge->addColumn('ordenes_trabajo', $fields);
        }

        // Optional: Foreign Key
        // $this->forge->addForeignKey('id_rampa', 'rampas', 'id_rampa', 'CASCADE', 'SET NULL');
        // CodeIgniter migrations FK support is sometimes tricky with existing tables, omitting for simplicity/speed but recommended for prod.
    }

    public function down()
    {
        if ($this->db->tableExists('ordenes_trabajo')) {
            // Intentar eliminar la FK antes de eliminar la columna para evitar errores de restricción
            try {
                $this->db->query('ALTER TABLE `ordenes_trabajo` DROP FOREIGN KEY `ordenes_trabajo_id_rampa_foreign`');
            } catch (\Throwable $e) {
                // Ignorar si la FK no existe
            }

            if ($this->db->fieldExists('id_rampa', 'ordenes_trabajo')) {
                $this->forge->dropColumn('ordenes_trabajo', 'id_rampa');
            }
        }
        if ($this->db->tableExists('rampas')) {
            $this->forge->dropTable('rampas');
        }
    }
}
