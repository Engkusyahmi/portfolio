<?php namespace App\Controllers;

use App\Models\ModelPengguna; // Ensure this correctly points to your User Model
use CodeIgniter\Controller; // Use CodeIgniter\Controller if not extending your own BaseController

class AuthController extends Controller // This controller is for Registration ONLY
{
    protected $penggunaModel;
    protected $helpers = ['form', 'url']; // 'form' helper for validation errors, 'url' for base_url()

    public function __construct()
    {
        $this->penggunaModel = new ModelPengguna();
    }

    /**
     * Handles both displaying the registration form (GET)
     * and processing the registration submission (POST).
     * Accessible via GET /register and POST /register
     */
    public function register()
    {
        // If it's a GET request, just show the form
        if ($this->request->getMethod() === 'get') {
            $data = [
                'title' => 'Register for BusTracker',
                'validation' => \Config\Services::validation(), // Pass validation service to the view
            ];
            return view('register', $data);
        }

        // --- If it's a POST request, proceed with validation and registration ---

        // Define validation rules
        $rules = [
            'fullname' => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[pengguna.username]', // Ensure 'pengguna' is your table name
            'contact'  => 'required|min_length[7]|max_length[20]',
            'password' => 'required|min_length[6]',
            'pass_confirm' => 'required_with[password]|matches[password]', // Assuming you have a confirm password field
            'image'    => 'uploaded[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png,image/gif]',
        ];

        // Check validation
        if (!$this->validate($rules)) {
            // If validation fails, redirect back with input data and errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $file = $this->request->getFile('image');
        $imageName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName(); // Generate a random name
            // Ensure the 'uploads/images' directory exists and is writable
            $uploadPath = FCPATH . 'uploads/images';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true); // Create directory if it doesn't exist
            }
            $file->move($uploadPath, $imageName); // Move to public/uploads/images
        }

        // Prepare data for database insertion
        $data = [
            'fullname'  => $this->request->getPost('fullname'),
            'username'  => $this->request->getPost('username'),
            'contact'   => $this->request->getPost('contact'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // HASH THE PASSWORD
            'userlevel' => 'student', // Default new registrations to 'student'
            'image'     => $imageName,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Save data to database
        if ($this->penggunaModel->insert($data)) {
    session()->setFlashdata('success', 'Registration successful! You can now log in.');
    return redirect()->to(base_url('login'));
} else {
    // 🔴 ADD THIS TO SEE WHY INSERT FAILED
    log_message('error', 'Registration failed: ' . json_encode($this->penggunaModel->errors()));

    session()->setFlashdata('error', 'Registration failed. Please try again.');
    return redirect()->back()->withInput();
}
        
        
        else {
            // Failure: Redirect back with an error message
            // Optionally, delete the uploaded file if DB insertion fails
            if ($imageName && file_exists(FCPATH . 'uploads/images/' . $imageName)) {
                unlink(FCPATH . 'uploads/images/' . $imageName);
            }
            session()->setFlashdata('error', 'Registration failed. Please try again.');
            return redirect()->back()->withInput();
        }
    }
}
