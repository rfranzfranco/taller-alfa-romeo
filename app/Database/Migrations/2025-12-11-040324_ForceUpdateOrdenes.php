<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ForceUpdateOrdenes extends Migration
{
    public function up()
    {
        // Force Type Change to VARCHAR(100) and Update Data
        $fields = [
            'estado' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'default' => 'PENDIENTE',
            ],
        ];
        $this->forge->modifyColumn('ordenes_trabajo', $fields);

        // Force Update
        $db = \Config\Database::connect();
        $db->query("UPDATE ordenes_trabajo SET estado = 'EN_PROCESO' WHERE estado = '' OR estado IS NULL OR estado = '0'");
    }

    public function down()
    {
        //
    }
}
