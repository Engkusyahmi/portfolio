<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengguna;
use App\Models\ModelSchedule;
use App\Models\MessageModel;
use App\Models\ModelRatings;
use CodeIgniter\API\ResponseTrait;

class DriverController extends BaseController
{
    use ResponseTrait;

    protected $session;
    protected $penggunaModel;
    protected $scheduleModel;
    protected $messageModel;
    protected $ratingModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->penggunaModel = new ModelPengguna();
        $this->scheduleModel = new ModelSchedule();
        $this->messageModel = new MessageModel();
        $this->ratingModel = new ModelRatings();
    }

    public function index()
    {
        // Ensure user is logged in and is a driver
        if (!session()->get('isLoggedIn') || session()->get('userlevel') !== 'driver') {
            return redirect()->to(base_url('login'))->with('error', 'Access Denied.');
        }

        $driverId = session()->get('user_id');
        $driverData = $this->penggunaModel->find($driverId);
        $unreadMessagesCount = $this->messageModel->getUnreadCount($driverId);

        // Fetch next schedule for the dashboard card
        $nextSchedule = $this->scheduleModel->getNextScheduleForDriver($driverId);

        $nextDepartureTime = 'N/A';
        $nextDepartureRoute = 'N/A';

        if ($nextSchedule) {
            $nextDepartureTime = date('h:i A', strtotime($nextSchedule['departure_time']));
            $nextDepartureRoute = $nextSchedule['route_name'];
        }

        $data = [
            'username' => $driverData['username'] ?? 'Driver',
            'nextDepartureTime' => $nextDepartureTime,
            'nextDepartureRoute' => $nextDepartureRoute,
            'passengersOnboard' => 0, // This might need actual logic to count passengers
            'unreadMessagesCount' => $unreadMessagesCount,
            'driverData' => $driverData
        ];

        return view('driver/main', $data);
    }

    // AJAX Endpoint: Get Schedules for the current driver
 public function getSchedules()
    {
        try {
            $schedules = $this->scheduleModel->getSchedulesWithDriver();
            return $this->respond(['status' => 'success', 'schedules' => $schedules]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // AJAX Endpoint: Update Schedule Status
    public function updateScheduleStatus()
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
            $rules = [
                'schedule_id' => 'required|integer',
                'status' => 'required|in_list[on_time,delayed,completed,cancelled]',
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $scheduleId = $this->request->getPost('schedule_id');
            $newStatus = $this->request->getPost('status');
            $driverId = session()->get('user_id');

            try {
                $schedule = $this->scheduleModel->find($scheduleId);
                if (!$schedule || $schedule['driver_id'] != $driverId) {
                    return $this->failUnauthorized('You are not authorized to update this schedule.');
                }

                $this->scheduleModel->update($scheduleId, ['status' => $newStatus]);
                return $this->respond(['status' => 'success', 'message' => 'Schedule status updated successfully!']);
            } catch (\Exception $e) {
                return $this->failServerError($e->getMessage());
            }
        }
        return $this->failUnauthorized('Invalid request.');
    }

    // AJAX Endpoint: Get Students for Chat (This is the method called by frontend JS)
    public function getDriversForChat()
   {
    $penggunaModel = new \App\Models\ModelPengguna();
    $student = $penggunaModel->where('userlevel', 'student')->findAll();
}
    // AJAX Endpoint: Get Student Ratings for the current driver
    // AJAX Endpoint: Get Student Ratings for the current driver
    
    public function ratings()
{
    $driverId = session()->get('user_id');

    $model = new \App\Models\StudentRatingModel(); // or ModelRatings
    $ratings = $model->where('driver_id', $driverId)->findAll();

    return view('driver/ratings', ['ratings' => $ratings]);
}

    
public function getStudentRatings()
{
    try {
        $driverId = session()->get('user_id'); // CONSISTENT KEY
        if (!$driverId) {
            return $this->failUnauthorized('Driver not logged in.');
        }

        $ratings = $this->ratingModel->getRatingsForDriver($driverId);

        return $this->respond(['status' => 'success', 'ratings' => $ratings]);
    } catch (\Exception $e) {
        return $this->failServerError($e->getMessage());
    }
}
    // AJAX Endpoint: Get Driver Profile Details
    public function getProfileDetails()
{
    try {
        $driverId = session()->get('user_id');

        if (!$driverId) {
            return $this->failUnauthorized('Not logged in');
        }

        $profile = $this->penggunaModel
                        ->where('id', $driverId)
                        ->where('userlevel', 'driver')
                        ->first();

        if ($profile) {
            return $this->respond(['status' => 'success', 'profile' => $profile]);
        } else {
            return $this->failNotFound('Driver profile not found.');
        }
    } catch (\Exception $e) {
        return $this->failServerError($e->getMessage());
    }
}
    public function chatList()
    {
        $driverId = session()->get('user_id'); // Corrected to user_id for consistency
        $messageModel = new MessageModel();
        $userModel = new ModelPengguna();

        // Get all unique user IDs the driver has chatted with
        $partnerIds = $messageModel->select('sender_id, receiver_id')
            ->groupStart()
                ->where('sender_id', $driverId)
                ->orWhere('receiver_id', $driverId)
            ->groupEnd()
            ->findAll();

        $userIds = [];

        foreach ($partnerIds as $chat) {
            if ($chat['sender_id'] != $driverId) {
                $userIds[] = $chat['sender_id'];
            }
            if ($chat['receiver_id'] != $driverId) {
                $userIds[] = $chat['receiver_id'];
            }
        }

        $userIds = array_unique($userIds);

        $chatUsers = [];

        if (!empty($userIds)) {
            $chatUsers = $userModel
                ->whereIn('id', $userIds)
                ->where('userlevel', 'student') // Only show students
                ->findAll();
        }

        return view('driver/chat_list', ['chatUsers' => $chatUsers]);
    }

    public function chatSection()
    {
        $driverId = session()->get('user_id'); // Corrected to user_id for consistency
        $messageModel = new MessageModel();
        $userModel = new ModelPengguna();

        // Get all user IDs the driver has chatted with
        $messages = $messageModel->select('sender_id, receiver_id')
            ->groupStart()
                ->where('sender_id', $driverId)
                ->orWhere('receiver_id', $driverId)
            ->groupEnd()
            ->findAll();

        $userIds = [];
        foreach ($messages as $m) {
            if ($m['sender_id'] != $driverId) {
                $userIds[] = $m['sender_id'];
            }
            if ($m['receiver_id'] != $driverId) {
                $userIds[] = $m['receiver_id'];
            }
        }

        $userIds = array_unique($userIds);

        $chatPartners = [];

        if (!empty($userIds)) {
            $users = $userModel
                ->whereIn('id', $userIds)
                ->where('userlevel', 'student')
                ->findAll();

            foreach ($users as $user) {
                $unread = $messageModel->getUnreadCountForConversation($driverId, $user['id']);
                $user['unread_count'] = $unread;
                $chatPartners[] = $user;
            }
        }

        return view('driver/chat_section', ['chatPartners' => $chatPartners]);
    }

    public function viewChat($receiverId)
    {
        $currentUserId = session()->get('user_id'); // Corrected to user_id for consistency
        $messageModel = new MessageModel();
        $userModel = new ModelPengguna();

        $receiver = $userModel->find($receiverId);
        if (!$receiver) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Mark messages as read
        $messageModel->markAsRead($receiverId, $currentUserId);

        $messages = $messageModel->getConversation($currentUserId, $receiverId);

        return view('driver/chat_view', [
            'receiver' => $receiver,
            'messages' => $messages,
            'currentUserId' => $currentUserId,
        ]);
    }

    public function send()
    {
        $messageModel = new MessageModel();
        $senderId = session()->get('user_id'); // Corrected to user_id for consistency
        $receiverId = $this->request->getPost('receiver_id');
        $messageText = $this->request->getPost('message');

        if ($messageText && $receiverId) {
            $messageModel->insert([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message_text' => $messageText,
                'is_read' => 0,
            ]);
        }

        return redirect()->to('driver/chat/' . $receiverId);
    }

   public function get_schedules()
{
    $scheduleModel = new \App\Models\ModelSchedule();
    $schedules = $scheduleModel->getSchedulesWithDriver(); // or your logic here

    return $this->response->setJSON($schedules);
}
}


