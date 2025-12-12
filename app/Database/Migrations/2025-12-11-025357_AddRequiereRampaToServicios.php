<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRequiereRampaToServicios extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('requiere_rampa', 'servicios')) {
            $fields = [
                'requiere_rampa' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'after' => 'tiempo_estimado'
                ]
            ];
            $this->forge->addColumn('servicios', $fields);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('servicios') && $this->db->fieldExists('requiere_rampa', 'servicios')) {
            $this->forge->dropColumn('servicios', 'requiere_rampa');
        }
    }
}
