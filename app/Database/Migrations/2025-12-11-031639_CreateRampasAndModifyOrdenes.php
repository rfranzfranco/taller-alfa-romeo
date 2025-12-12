<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRampasAndModifyOrdenes extends Migration
{
    public function up()
    {
        // 1. Create Rampas Table
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
        $this->forge->addColumn('ordenes_trabajo', $fields);

        // Optional: Foreign Key
        // $this->forge->addForeignKey('id_rampa', 'rampas', 'id_rampa', 'CASCADE', 'SET NULL');
        // CodeIgniter migrations FK support is sometimes tricky with existing tables, omitting for simplicity/speed but recommended for prod.
    }

    public function down()
    {
        $this->forge->dropColumn('ordenes_trabajo', 'id_rampa');
        $this->forge->dropTable('rampas');
    }
}
