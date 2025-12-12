<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenesTrabajoModel extends Model
{
    protected $table = 'ordenes_trabajo';
    protected $primaryKey = 'id_orden';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_reserva', 'id_empleado_asignado', 'id_rampa', 'fecha_inicio_real', 'fecha_fin_real', 'observaciones_tecnicas', 'estado'];

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
