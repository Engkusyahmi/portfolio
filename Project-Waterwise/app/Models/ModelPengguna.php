<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengguna extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';

    protected $allowedFields    = [
        'username',
        'password',
        'fullname',
        'email',
        'userlevel',
        'ecopoints',
        'badge',
        'last_login_date',
        'login_streak',
        'xp',
        'profile_pic',
        'border_style',
        'subscription_plan'
    ];

    // 🏆 Get top 10 leaderboard (users only)
    public function getTop10Leaderboard()
    {
        return $this->where('userlevel', 'user')
                    ->orderBy('ecopoints', 'DESC')
                    ->limit(10)
                    ->findAll();
    }

    // 🏅 Get rank of current user
    public function getUserRank($userId)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT rank FROM (
                SELECT id, RANK() OVER (ORDER BY ecopoints DESC) AS rank
                FROM pengguna
                WHERE userlevel = 'user'
            ) AS ranked
            WHERE id = ?", [$userId]);

        return $query->getRow();
    }

    // 👤 Get full data for a user
    public function getUserData($userId)
    {
        return $this->find($userId);
    }

    // 📅 Get last login date
    public function getLastLoginDate($userId)
    {
        return $this->select('last_login_date')->find($userId)->last_login_date ?? null;
    }

    // 🔄 Update login streak and last login date
    public function updateLoginStreak($userId, $streak)
    {
        return $this->update($userId, [
            'login_streak' => $streak,
            'last_login_date' => date('Y-m-d')
        ]);
    }

    // ❌ Reset login streak
    public function resetLoginStreak($userId)
    {
        return $this->update($userId, [
            'login_streak' => 0,
            'last_login_date' => date('Y-m-d')
        ]);
    }

    // 🎯 Update user XP and level
    public function addXP($userId, $xpAmount)
    {
        $user = $this->find($userId);
        $newXP = ($user->xp ?? 0) + $xpAmount;
        
        return $this->update($userId, ['xp' => $newXP]);
    }

    // 💰 Add EcoPoints
    public function addEcoPoints($userId, $points)
    {
        $user = $this->find($userId);
        $newPoints = $user->ecopoints + $points;
        
        return $this->update($userId, ['ecopoints' => $newPoints]);
    }

    // 📊 Get user level from XP
    public function getUserLevel($userId)
    {
        $user = $this->find($userId);
        return floor(($user->xp ?? 0) / 100);
    }
}