<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_cliente', 'id_vehiculo', 'fecha_reserva', 'estado'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha_registro';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
