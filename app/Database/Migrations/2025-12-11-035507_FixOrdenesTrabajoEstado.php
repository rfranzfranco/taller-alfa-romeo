<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixOrdenesTrabajoEstado extends Migration
{
    public function up()
    {
        // Change 'estado' to VARCHAR to allow 'EN_PROCESO'
        $fields = [
            'estado' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'default' => 'PENDIENTE',
            ],
        ];
        $this->forge->modifyColumn('ordenes_trabajo', $fields);

        // Fix existing empty records
        $db = \Config\Database::connect();
        $db->query("UPDATE ordenes_trabajo SET estado = 'EN_PROCESO' WHERE estado = '' OR estado IS NULL");
    }

    public function down()
    {
        // Revert to ENUM if needed, but risky. Leaving as VARCHAR for safety.
    }
}
