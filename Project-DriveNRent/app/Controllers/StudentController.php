<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelPengguna;
use App\Models\ModelSchedule;
use App\Models\MessageModel;
use App\Models\ModelRatings;
use App\Models\StudentRatingModel;
use CodeIgniter\API\ResponseTrait;

class StudentController extends BaseController
{
    use ResponseTrait; // For easy JSON responses

    protected $ModelPengguna;
    protected $ModelSchedule;
    protected $MessageModel;
    protected $ModelRatings;

    public function __construct()
    {
       $this->penggunaModel = new ModelPengguna();
        $this->scheduleModel = new ModelSchedule();
        $this->messageModel = new MessageModel();
        $this->ratingModel = new ModelRatings();
        $this->ratingModel = new StudentRatingModel(); // Must match your actual model
    }

    public function index()
    {
        // Ensure user is logged in and is a student
        if (!session()->get('isLoggedIn') || session()->get('userlevel') !== 'student') {
            return redirect()->to(base_url('login')); // Redirect to login
        }

        $studentId = session()->get('user_id');
        $username = session()->get('username');

        // Dashboard Data (example, fetch real data)
        $nextBusDue = '10 mins'; // Replace with logic to find next bus
        $upcomingTripsCount = $this->scheduleModel->where('status !=', 'Cancelled')->countAllResults(); // Example count
      $unreadMessagesCount = $this->messageModel->getUnreadCount($studentId);
      

        $data = [
            'username' => $username,
            'nextBusDue' => $nextBusDue,
            'upcomingTripsCount' => $upcomingTripsCount,
            'unreadMessagesCount' => $unreadMessagesCount,
            // Initial data for schedules can also be passed here, or loaded via AJAX
            'schedules' => $this->scheduleModel->getSchedulesWithDriver(), // For initial load if not using AJAX for schedule
            'studentData' => $this->penggunaModel->getStudentProfile($studentId) // For initial load of profile if not using AJAX for profile
        ];

        return view('student/main', $data);
    }

   public function updateProfile()
   {
    $username = session()->get('username');
    $studentModel = new \App\Models\ModelPengguna();

    $student = $studentModel->where('username', $username)->first();
    if (!$student) {
        return redirect()->to('student#profile')->with('error', 'User not found.');
    }

    // Prepare data to update
    $data = [
        'fullname' => $this->request->getPost('fullname'),
        'contact'  => $this->request->getPost('contact'),
    ];

    // Handle image upload
    $imageFile = $this->request->getFile('image');
    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $newName = $imageFile->getRandomName();
        $imageFile->move(ROOTPATH . 'public/uploads/images', $newName);
        $data['image'] = $newName;

        // Optionally delete old image
        if (!empty($student['image']) && file_exists(ROOTPATH . 'public/uploads/images/' . $student['image'])) {
            unlink(ROOTPATH . 'public/uploads/images/' . $student['image']);
        }
    }

    // Update database
    $studentModel->update($student['id'], $data);

    // Redirect back to student profile section
    return redirect()->to('student#profile')->with('success', 'Profile updated successfully.');
    }


    // AJAX Endpoint: Get Schedules
    public function getSchedules()
    {
        try {
            $schedules = $this->scheduleModel->getSchedulesWithDriver();
            return $this->respond(['status' => 'success', 'schedules' => $schedules]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getDriversForChat()
{
    $penggunaModel = new \App\Models\ModelPengguna();
    $drivers = $penggunaModel->where('userlevel', 'driver')->findAll();

    return $this->response->setJSON($drivers);
}
    
    public function chatWithDriver($driverId)
{
    $studentId = session()->get('user_id');
    $driver = $this->penggunaModel->find($driverId);

    if (!$driver || $driver['userlevel'] !== 'driver') {
        return redirect()->to('student')->with('error', 'Invalid driver selected.');
    }

    // Mark messages from driver as read
    $this->messageModel->markAsRead($driverId, $studentId);

    $messages = $this->messageModel->getConversation($studentId, $driverId);

    return view('student/chat_with_driver', [
        'driver' => $driver,
        'messages' => $messages,
        'studentId' => $studentId
    ]);
}

    // AJAX Endpoint: Get Drivers for Rating
   public function getDriversForRating()
{
    $penggunaModel = new \App\Models\ModelPengguna();
    $drivers = $penggunaModel->where('userlevel', 'driver')->findAll();

    return $this->response->setJSON($drivers);
}

    // AJAX Endpoint: Submit Rating
  public function submitRating()
{
    // ADD THESE DEBUGGING LINES
    log_message('debug', 'submitRating method hit.');
    log_message('debug', 'Is AJAX detected: ' . ($this->request->isAJAX() ? 'true' : 'false'));
    log_message('debug', 'Request Method: ' . $this->request->getMethod());
    log_message('debug', 'POST data received: ' . json_encode($this->request->getPost())); // This will show what data is actually received

    if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
        $rules = [
           'driver_id' => 'required|string',
            'rating'    => 'required|in_list[1,2,3,4,5]',
            'comment'   => 'permit_empty|string|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Rating validation failed: ' . json_encode($this->validator->getErrors())); // Log validation errors
            return $this->respond([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        $studentId = session()->get('user_id');

        $data = [
            'driver_id'  => $this->request->getPost('driver_id'),
            'student_id' => $studentId,
            'rating'     => $this->request->getPost('rating'),
            'comment'    => $this->request->getPost('comment'),
        ];

        try {
            if ($this->ratingModel->insert($data)) {
                log_message('debug', 'Rating inserted successfully.');
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Rating submitted successfully!'
                ]);
            } else {
                log_message('error', 'Rating insert failed: ' . json_encode($this->ratingModel->errors())); // Log model errors
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Insert failed',
                    'errors' => $this->ratingModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('critical', 'Exception during rating submission: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile());
            return $this->respond([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    } else {
        // ADD THIS LOG FOR THE 'Invalid request.' case
        log_message('error', 'Rating submission failed AJAX/POST check: Not AJAX or not POST.');
        return $this->respond([
            'status' => 'error',
            'message' => 'Invalid request.'
        ]);
    }
}

    // AJAX Endpoint: Get Student Profile Details
    public function getProfileDetails()
    {
        try {
            $studentId = session()->get('user_id');
            $profile =$this->penggunaModel->getStudentProfile($studentId);

            if ($profile) {
                return $this->respond(['status' => 'success', 'profile' => $profile]);
            } else {
                return $this->failNotFound('Student profile not found.');
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
    public function chatDrivers()
{
    $model = new \App\Models\ModelPengguna();
    $drivers = $model->where('userlevel', 'driver')->findAll();

    return $this->response->setJSON($drivers);
}
public function sendMessage()
{
    if ($this->request->getMethod() === 'post') {
        $senderId = session()->get('user_id');
        $receiverId = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message_text');

        if (!$receiverId || !$message) {
            return $this->response->setJSON(['error' => 'Missing required fields.']);
        }

        $messageModel = new \App\Models\MessageModel();
        $messageModel->insert([
            'sender_id'    => $senderId,
            'receiver_id'  => $receiverId,
            'message_text' => $message,
            'is_read'      => 0,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['success' => 'Message sent.']);
    }

    return $this->response->setJSON(['error' => 'Invalid request.']);
}
    
}