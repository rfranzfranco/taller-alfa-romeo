<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturasModel extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_orden', 'fecha_emision', 'monto_total', 'nit_facturacion', 'razon_social', 'estado_pago'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
