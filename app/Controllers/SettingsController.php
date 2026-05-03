<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingsController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $settingModel = new SettingModel();
        $data = [
            'title' => 'Pengaturan Website',
            'settings' => $settingModel->findAll()
        ];

        return view('dashboard/settings', $data);
    }

    public function update()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $settingModel = new SettingModel();
        $inputs = $this->request->getPost('settings');

        foreach ($inputs as $key => $value) {
            $settingModel->where('key', $key)->set([
                'value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ])->update();
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
