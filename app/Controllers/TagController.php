<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TagModel;

class TagController extends BaseController
{
    protected $tagModel;

    public function __construct()
    {
        $this->tagModel = new TagModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Allowed for Superadmin and Admin
        if (!in_array(session()->get('role'), ['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title' => 'Manajemen Tag',
            'tags' => $this->tagModel->orderBy('name', 'ASC')->findAll()
        ];

        return view('dashboard/tags/index', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|is_unique[tags.name]|min_length[2]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getVar('name');
        $this->tagModel->insert([
            'name' => $name,
            'slug' => url_title($name, '-', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/tags')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function update($id)
    {
        $rules = [
            'name' => "required|is_unique[tags.name,id,{$id}]|min_length[2]|max_length[50]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getVar('name');
        $this->tagModel->update($id, [
            'name' => $name,
            'slug' => url_title($name, '-', true),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/tags')->with('success', 'Tag berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Check if tag is used
        $db = \Config\Database::connect();
        $count = $db->table('research_tags')->where('tag_id', $id)->countAllResults();

        if ($count > 0) {
            return redirect()->to('/dashboard/tags')->with('error', 'Tag tidak dapat dihapus karena masih digunakan oleh penelitian.');
        }

        $this->tagModel->delete($id);
        return redirect()->to('/dashboard/tags')->with('success', 'Tag berhasil dihapus.');
    }
}
