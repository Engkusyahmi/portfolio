<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReward extends Model
{
    protected $table = 'rewards';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'name',
        'description',
        'image_path',
        'cost_ecopoints',
        'type',
        'available'
    ];

    // Get all rewards
    public function getAllRewards()
    {
        return $this->findAll();
    }

    // Get available rewards only
    public function getAvailableRewards()
    {
        return $this->where('available', 1)->findAll();
    }
}