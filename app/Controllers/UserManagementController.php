<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagementController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $data = [
            'users' => $this->userModel->orderBy('created_at', 'DESC')->paginate(10),
            'pager' => $this->userModel->pager,
            'title' => 'User Management'
        ];

        return view('dashboard/users/index', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password_hash' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getVar('role'),
            'status' => 'active'
        ]);

        return redirect()->to('/dashboard/users')->with('success', 'User created successfully.');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $rules = [
            'username' => "required|is_unique[users.username,id,{$id}]|min_length[3]",
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'status' => $this->request->getVar('status')
        ];

        if ($this->request->getVar('password')) {
            $data['password_hash'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
        }

        $this->userModel->save($data);

        return redirect()->to('/dashboard/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if ($user['role'] === 'superadmin') {
            return redirect()->to('/dashboard/users')->with('error', 'Cannot delete Superadmin.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/dashboard/users')->with('success', 'User deleted successfully.');
    }
}
