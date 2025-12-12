<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiciosModel extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nombre', 'descripcion', 'costo_mano_obra', 'tiempo_estimado', 'requiere_rampa'];

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
