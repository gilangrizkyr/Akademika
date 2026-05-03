<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResearchModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $researchModel = new ResearchModel();
        
        $role = session()->get('role');
        $userId = session()->get('id');

        $data = [];

        if ($role === 'superadmin' || $role === 'admin') {
            $data['total_research'] = $researchModel->countAllResults();
            $data['pending_research'] = $researchModel->where('status', 'pending')->countAllResults();
            
            if ($role === 'superadmin') {
                $userModel = new UserModel();
                $data['total_users'] = $userModel->countAllResults();
            }
        } else {
            $data['my_research'] = $researchModel->where('user_id', $userId)->countAllResults();
            $data['my_published'] = $researchModel->where('user_id', $userId)->where('status', 'published')->countAllResults();
        }

        return view('dashboard/index', $data);
    }
}
