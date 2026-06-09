<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengguna; // Make sure your ModelPengguna is correctly namespaced and exists

class RegisterController extends BaseController
{
    protected $penggunaModel;
    protected $session;

    public function __construct()
    {
        $this->penggunaModel = new ModelPengguna();
        $this->session = \Config\Services::session();
    }

    // Displays the registration form
    public function index()
    {
        // If user is already logged in, redirect them away from register page
        if ($this->session->has('isLoggedIn')) {
            // Determine where to redirect based on user level
            $userlevel = $this->session->get('userlevel');
            if ($userlevel === 'admin') {
                return redirect()->to(base_url('register/store'));
            } elseif ($userlevel === 'student') {
                return redirect()->to(base_url('register/store'));
            } elseif ($userlevel === 'driver') {
                return redirect()->to(base_url('register/store'));
            }
        }

        // Load the registration view, passing validation service for error display
        return view('register', [
            'validation' => \Config\Services::validation()
        ]);
    }

    // Handles the registration form submission
    public function store()
    {
        // 1. Define Validation Rules
        // Updated contact validation to allow hyphen and match ModelPengguna's regex
        $rules = [
            'fullname'  => 'required|min_length[3]|max_length[100]',
            'username'  => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[pengguna.username]',
            'contact'   => 'required|regex_match[/^[0-9]{3}-[0-9]{7,8}$/]|min_length[11]|max_length[12]', // FIX APPLIED HERE
            'password'  => 'required|min_length[8]',
            'pass_confirm' => 'required_with[password]|matches[password]',
            'userlevel' => 'required|in_list[student,driver]', // Only allow student or driver for self-registration
            'image'     => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/gif]',
        ];

        // 2. Run Validation
        if (!$this->validate($rules)) {
            // If validation fails, redirect back with input data and errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Handle File Upload
        $file = $this->request->getFile('image');
        $fileName = null;

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName(); // Generate a random name for the file
            $file->move(ROOTPATH . 'public/uploads/images', $fileName); // Move to public/uploads/images
        }

        // 4. Prepare Data for Database Insertion
        $data = [
            'fullname'  => $this->request->getPost('fullname'),
            'username'  => $this->request->getPost('username'),
            'contact'   => $this->request->getPost('contact'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash the password
            'userlevel' => $this->request->getPost('userlevel'),
            'image'     => $fileName, // Save the generated filename
        ];

        // 5. Save Data to Database
        if ($this->penggunaModel->insert($data)) {
            // Success: Redirect to login with a success message
            return redirect()->to(base_url('login'))->with('success', 'Registration successful! Please login.');
        } else {
            // Failure: Redirect back with an error message
            // Optionally, delete the uploaded file if DB insertion fails
            if ($fileName && file_exists(ROOTPATH . 'public/uploads/images/' . $fileName)) {
                unlink(ROOTPATH . 'public/uploads/images/' . $fileName);
            }
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }
}
