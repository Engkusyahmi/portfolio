<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelQuest extends Model
{
    protected $table = 'quests';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = ['title', 'description', 'xp_reward', 'ecopoints_reward', 'created_at'];

    // Get all quests
    public function getAllQuests()
    {
        return $this->findAll();
    }
}
