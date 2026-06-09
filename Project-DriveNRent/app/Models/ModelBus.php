<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBus extends Model
{
    protected $table            = 'buses';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['bus_name', 'license_plate', 'capacity', 'status'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
