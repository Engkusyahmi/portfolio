<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUserReward extends Model
{
    protected $table = 'user_rewards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'reward_id', 'redeemed_at'];
    protected $useTimestamps = true;
    protected $createdField = 'redeemed_at';
}
