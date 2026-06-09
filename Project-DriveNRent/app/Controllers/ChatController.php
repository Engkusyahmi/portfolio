<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MessageModel;
use CodeIgniter\API\ResponseTrait;

class ChatController extends BaseController
{
    use ResponseTrait;

    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    // ✅ Send a new message
    public function send()
    {
        $senderId = session()->get('user_id');
        $receiverId = $this->request->getPost('receiver_id');
        $messageText = $this->request->getPost('message_text');

        if (!$senderId || !$receiverId || !$messageText) {
            return $this->failValidationErrors('Missing required fields.');
        }

        $this->messageModel->save([
            'sender_id'    => $senderId,
            'receiver_id'  => $receiverId,
            'message_text' => $messageText,
            'is_read'      => 0,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        return $this->respond(['status' => 'success', 'message' => 'Message sent.']);
    }

    // ✅ Get all messages in a conversation
    public function messagesByUser($otherUserId)
    {
        $currentUserId = session()->get('user_id');
        if (!$currentUserId) {
            return $this->failUnauthorized('Not logged in.');
        }

        try {
            $messages = $this->messageModel->getConversation($currentUserId, $otherUserId);
            return $this->respond(['status' => 'success', 'messages' => $messages]);
        } catch (\Exception $e) {
            log_message('error', 'Failed to load messages: ' . $e->getMessage());
            return $this->failServerError('Failed to load messages.');
        }
    }

    // ✅ Poll new unread messages for current chat
    public function newMessages()
    {
        $userId = session()->get('user_id');
        $otherUserId = $this->request->getGet('other_user_id');

        if (!$userId || !$otherUserId) {
            return $this->failValidationErrors('Invalid request.');
        }

        try {
            $messages = $this->messageModel->getUnreadMessages($userId, $otherUserId);
            return $this->respond(['status' => 'success', 'messages' => $messages]);
        } catch (\Exception $e) {
            return $this->failServerError('Error loading new messages.');
        }
    }

    // ✅ Mark messages as read
    public function markRead($otherUserId)
    {
        $userId = session()->get('user_id');
        if (!$userId) return $this->failUnauthorized('Unauthorized');

        $this->messageModel->markAsRead($otherUserId, $userId);
        return $this->respond(['status' => 'success']);
    }

    // ✅ Get global unread message count for current user
    public function unreadCountApi()
    {
        $userId = session()->get('user_id');
        if (!$userId) return $this->respond(['status' => 'success', 'unread_count' => 0]);

        $count = $this->messageModel->getUnreadCount($userId);
        return $this->respond(['status' => 'success', 'unread_count' => $count]);
    }

    // ✅ Return list of students available for chat (for driver)
    public function students()
    {
        $db = db_connect();
        $students = $db->table('pengguna')->where('userlevel', 'student')->get()->getResultArray();
        return $this->respond($students);
    }

    // ✅ Return list of drivers available for chat (for student)
    public function drivers()
    {
        $db = db_connect();
        $drivers = $db->table('pengguna')->where('userlevel', 'driver')->get()->getResultArray();
        return $this->respond($drivers);
    }
}
