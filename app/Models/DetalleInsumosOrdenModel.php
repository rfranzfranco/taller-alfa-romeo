<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleInsumosOrdenModel extends Model
{
    protected $table = 'detalle_insumos_orden';
    protected $primaryKey = 'id_detalle_insumo';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_orden', 'id_insumo', 'cantidad', 'costo_unitario'];
    protected $useTimestamps = false;
}
