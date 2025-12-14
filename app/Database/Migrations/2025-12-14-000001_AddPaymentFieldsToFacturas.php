<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentFieldsToFacturas extends Migration
{
    public function up()
    {
        // Add payment method and payment date fields to facturas table
        $this->forge->addColumn('facturas', [
            'metodo_pago' => [
                'type' => 'ENUM',
                'constraint' => ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA'],
                'null' => true,
                'after' => 'estado_pago'
            ],
            'fecha_pago' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'metodo_pago'
            ],
            'monto_pagado' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'fecha_pago'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('facturas', ['metodo_pago', 'fecha_pago', 'monto_pagado']);
    }
}
