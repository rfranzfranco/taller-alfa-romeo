<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetalleInsumosOrden extends Migration
{
    public function up()
    {
        $this->forge->dropTable('detalle_insumos_orden', true);
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
                'unsigned' => false,
            ],
            'id_insumo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
            ],
            'cantidad' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'costo_unitario' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true, // Snapshotted cost
            ],
        ]);
        $this->forge->addKey('id_detalle_insumo', true);
        $this->forge->addForeignKey('id_orden', 'ordenes_trabajo', 'id_orden', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('id_insumo', 'insumos', 'id_insumo', 'CASCADE', 'RESTRICT'); // Optional

        $this->forge->createTable('detalle_insumos_orden');
    }

    public function down()
    {
        $this->forge->dropTable('detalle_insumos_orden');
    }
}
