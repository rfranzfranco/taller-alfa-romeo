<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_usuario', 'nombre_completo', 'ci_nit', 'telefono', 'correo', 'direccion'];

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
