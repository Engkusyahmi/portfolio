<?php

namespace App\Controllers;

use App\Models\ModelPengguna;
use CodeIgniter\Controller;

class Auth extends Controller
{
    
    public function forgotPassword()
{
    return view('forgot_password'); // Create this view at app/Views/forgot_password.php
}
    /**
     * Show login form
     */
    public function login()
    {
        return view('login'); // Make sure app/Views/login.php exists
    }

    /**
     * Process login POST form
     */
   public function authenticate()
{
    $request = service('request');
    $session = session();

    $username = $request->getPost('user');
    $password = $request->getPost('p');

    $model = new ModelPengguna();
    $user = $model->where('username', $username)->first();

   if (!$user) {
    return redirect()->back()->withInput()->with('error', 'Username not found.');
}

if ($password !== $user['password']) {
    return redirect()->back()->withInput()->with('error', 'Incorrect password.');
}

    // Login success: set session
    $session->set([
        'user_id'    => $user['id'],
        'username'   => $user['username'],
        'userlevel'  => $user['userlevel'],
        'isLoggedIn' => true,
    ]);

    // Redirect based on role
    switch ($user['userlevel']) {
        case 'admin':
            return redirect()->to('/admin');
        case 'driver':
            return redirect()->to('/driver');
        case 'student':
            return redirect()->to('/student');
        default:
            return redirect()->to('/')->with('error', 'Unknown role.');
    }
    
}

    /**
     * Logout user and clear session
     */
    public function logout()
    {
        session()->destroy();
        log_message('info', 'AUTH: User logged out.');
        return redirect()->to('/login')->with('message', 'You have been logged out.');
    }
}
