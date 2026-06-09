<?php namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message_text', 'is_read', 'created_at'];

    // ✅ Fixed: Get all messages between two users
    public function getConversation($userId, $otherUserId)
{
    return $this->builder()
        ->groupStart()
            ->groupStart()
                ->where('sender_id', $userId)
                ->where('receiver_id', $otherUserId)
            ->groupEnd()
            ->orGroupStart()
                ->where('sender_id', $otherUserId)
                ->where('receiver_id', $userId)
            ->groupEnd()
        ->groupEnd()
        ->orderBy('created_at', 'ASC')
        ->get()
        ->getResultArray();
}

    public function getUnreadMessages($userId, $otherUserId)
    {
        return $this->where('sender_id', $otherUserId)
                    ->where('receiver_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function markAsRead($fromUserId, $toUserId)
    {
        return $this->where('sender_id', $fromUserId)
                    ->where('receiver_id', $toUserId)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }

    public function getUnreadCount($userId)
    {
        return $this->where('receiver_id', $userId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    public function getUnreadCountForConversation($userId, $otherUserId)
    {
        return $this->where('receiver_id', $userId)
                    ->where('sender_id', $otherUserId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }
}
