<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!in_array(session()->get('role'), ['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $data = [
            'title' => 'Manajemen Kategori',
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll()
        ];

        return view('dashboard/categories/index', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|is_unique[categories.name]|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getVar('name');
        $this->categoryModel->insert([
            'name' => $name,
            'slug' => url_title($name, '-', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update($id)
    {
        $rules = [
            'name' => "required|is_unique[categories.name,id,{$id}]|min_length[3]|max_length[100]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getVar('name');
        $this->categoryModel->update($id, [
            'name' => $name,
            'slug' => url_title($name, '-', true),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Check if category is used in researches
        $db = \Config\Database::connect();
        $count = $db->table('researches')->where('category_id', $id)->countAllResults();

        if ($count > 0) {
            return redirect()->to('/dashboard/categories')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh penelitian.');
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/dashboard/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
