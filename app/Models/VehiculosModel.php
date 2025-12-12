<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculosModel extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_cliente', 'placa', 'marca', 'modelo', 'anio', 'tipo_motor', 'color'];

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
