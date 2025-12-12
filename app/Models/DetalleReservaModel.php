<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleReservaModel extends Model
{
    protected $table = 'detalle_reserva';
    protected $primaryKey = 'id_detalle';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_reserva', 'id_servicio', 'id_insumo', 'cantidad_insumo', 'precio_unitario_momento'];

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
