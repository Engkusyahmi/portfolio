<?php

namespace App\Controllers;

use App\Models\ModelPengguna;

class Auth extends BaseController
{
    // Load any view dynamically by name (optional)
    public function Open($page)
    {
        return view($page);
    }

    // Show login form
    public function login()
    {
        return view('auth/login');
    }

    // Process login form
    public function loginPost()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $modelpengguna = new ModelPengguna();
        $data = $modelpengguna->where("username", $username)->first();

        if ($data && password_verify($password, $data->password)) {
            session()->set([
                'id'        => $data->id,
                'username'  => $data->username,
                'userlevel' => $data->userlevel,
                'logged_in' => true
            ]);

            if ($data->userlevel === 'admin') {
                return redirect()->to("/admin");
            } elseif ($data->userlevel === 'user') {
                return redirect()->to("/user");
            }
        } 
        
        return redirect()->to('/login')->with('error', 'Wrong username/password');
    }

    // Show register form
    public function register()
    {
        return view('auth/register');
    }

    // Process registration form
    public function registerPost()
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if ($password !== $passwordConfirm) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        $model = new ModelPengguna();

        if ($model->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username is already taken.');
        }

        if ($model->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email is already registered.');
        }

        $data = [
            'username'  => $username,
            'fullname'  => $this->request->getPost('fullname'),
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'userlevel' => 'user',
        ];

        $model->insert($data);

        return redirect()->to('/login')->with('message', 'Registration successful! Please login.');
    }

    // Logout user
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Test route
    public function Test()
    {
        echo "Auth controller";
    }
}
