<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadosModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_usuario', 'nombre_completo', 'cargo', 'especialidad', 'fecha_contratacion'];

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
