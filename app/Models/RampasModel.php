<?php

namespace App\Models;

use CodeIgniter\Model;

class RampasModel extends Model
{
    protected $table = 'rampas';
    protected $primaryKey = 'id_rampa';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nombre', 'estado'];
}
