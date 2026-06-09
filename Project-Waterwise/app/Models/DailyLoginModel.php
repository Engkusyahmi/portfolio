<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyLoginModel extends Model
{
    protected $table = 'daily_logins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'login_date'];

    public function hasLoggedInToday($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('login_date', date('Y-m-d'))
                    ->first();
    }
}
