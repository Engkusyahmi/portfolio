<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUserQuest extends Model
{
    protected $table = 'user_quests';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = ['user_id', 'quest_id', 'status', 'accepted_at', 'completed_at'];

    // Get quests accepted by user
    public function getUserQuests($userId)
    {
        $builder = $this->db->table('user_quests as uq');
        $builder->select('uq.*, q.title, q.description, q.xp_reward, q.ecopoints_reward');
        $builder->join('quests q', 'uq.quest_id = q.id');
        $builder->where('uq.user_id', $userId);
        return $builder->get()->getResult();
    }

    // Check if user already accepted quest
    public function hasAcceptedQuest($userId, $questId)
    {
        return $this->where(['user_id' => $userId, 'quest_id' => $questId])->countAllResults() > 0;
    }
}
