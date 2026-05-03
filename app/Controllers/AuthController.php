<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AuthLoginModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['title' => 'Login - Akademika']);
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register', ['title' => 'Daftar Peneliti - Akademika']);
    }

    public function processRegister()
    {
        $rules = [
            'username' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        
        $userModel->save([
            'username'      => $this->request->getVar('username'),
            'email'         => $this->request->getVar('email'),
            'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role'          => 'user',
            'status'        => 'active',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login untuk mulai meneliti.');
    }

    public function process()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $authLoginModel = new AuthLoginModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['status'] !== 'active') {
                return redirect()->back()->with('error', 'Your account is suspended.');
            }

            // Record success login
            $authLoginModel->save([
                'ip_address' => $this->request->getIPAddress(),
                'username' => $username,
                'attempt_time' => date('Y-m-d H:i:s'),
                'success' => 1
            ]);

            session()->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            // Regenerate session for security
            session()->regenerate();

            return redirect()->to('/dashboard');
        }

        // Record failed login
        $authLoginModel->save([
            'ip_address' => $this->request->getIPAddress(),
            'username' => $username,
            'attempt_time' => date('Y-m-d H:i:s'),
            'success' => 0
        ]);

        return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
