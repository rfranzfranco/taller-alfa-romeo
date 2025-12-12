<?php

namespace App\Models;

use CodeIgniter\Model;

class InsumosModel extends Model
{
    protected $table = 'insumos';
    protected $primaryKey = 'id_insumo';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['codigo', 'nombre', 'descripcion', 'precio_venta', 'stock_actual', 'stock_minimo'];

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
