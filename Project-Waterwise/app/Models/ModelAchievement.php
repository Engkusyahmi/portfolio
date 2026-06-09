<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAchievement extends Model
{
    protected $table = 'achievements';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'title',
        'description',
        'image_path',
        'level_required',
        'category',
        'tier'
    ];

    // Get all achievements
    public function getAllAchievements()
    {
        return $this->orderBy('level_required', 'ASC')->findAll();
    }

    // Get achievements unlocked by this user
    public function getUserAchievements($userId)
    {
        return $this->db->table('user_achievements')
                        ->where('user_id', $userId)
                        ->get()
                        ->getResultArray();
    }

    // Check if user has unlocked a specific achievement
    public function isAchievementUnlocked($userId, $achievementId)
    {
        return $this->db->table('user_achievements')
                        ->where('user_id', $userId)
                        ->where('achievement_id', $achievementId)
                        ->countAllResults() > 0;
    }

    // Unlock an achievement for user (optional helper)
    public function unlockAchievement($userId, $achievementId)
    {
        try {
            return $this->db->table('user_achievements')->insert([
                'user_id' => $userId,
                'achievement_id' => $achievementId
            ]);
        } catch (\Exception $e) {
            // Ignore duplicate inserts
            return false;
        }
    }
}