<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResearchModel;
use App\Models\CategoryModel;
use App\Models\TagModel;

class ResearchController extends BaseController
{
    protected $researchModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->researchModel = new ResearchModel();
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url', 'slug', 'upload', 'security']);
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        if ($role === 'superadmin' || $role === 'admin') {
            $researches = $this->researchModel->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $researches = $this->researchModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate(10);
        }

        $data = [
            'researches' => $researches,
            'pager' => $this->researchModel->pager,
            'title' => 'Manage Research'
        ];

        return view('dashboard/research/index', $data);
    }

    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'title' => 'Create Research'
        ];
        return view('dashboard/research/create', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'category_id' => 'required',
            'abstract' => 'required',
            'cover_image' => 'uploaded[cover_image]|max_size[cover_image,2048]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getVar('title');
        $slug = generate_slug($title, 'researches');

        $imgFile = $this->request->getFile('cover_image');
        $imgName = handle_upload($imgFile);

        $this->researchModel->save([
            'user_id' => session()->get('id'),
            'title' => $title,
            'slug' => $slug,
            'abstract' => sanitize_html($this->request->getVar('abstract')),
            'category_id' => $this->request->getVar('category_id'),
            'cover_image' => $imgName,
            'type' => $this->request->getVar('type') ?? 'simple',
            'status' => 'pending', // default to pending for moderation
        ]);

        return redirect()->to('/dashboard/research')->with('success', 'Research submitted successfully. Waiting for moderation.');
    }

    public function edit($id)
    {
        $research = $this->researchModel->find($id);
        if (!$research) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // Check permission
        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $data = [
            'research' => $research,
            'categories' => $this->categoryModel->findAll(),
            'title' => 'Edit Research'
        ];
        return view('dashboard/research/edit', $data);
    }

    public function update($id)
    {
        $research = $this->researchModel->find($id);
        if (!$research) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'title' => 'required|max_length[255]',
            'category_id' => 'required',
            'abstract' => 'required',
            'cover_image' => 'max_size[cover_image,2048]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getVar('title');
        $slug = ($title != $research['title']) ? generate_slug($title, 'researches', $id) : $research['slug'];

        $data = [
            'id' => $id,
            'title' => $title,
            'slug' => $slug,
            'abstract' => sanitize_html($this->request->getVar('abstract')),
            'category_id' => $this->request->getVar('category_id'),
            'type' => $this->request->getVar('type'),
        ];

        $imgFile = $this->request->getFile('cover_image');
        if ($imgFile && $imgFile->isValid()) {
            // Delete old image if possible
            if ($research['cover_image'] && file_exists(ROOTPATH . 'writable/uploads/research/' . $research['cover_image'])) {
                unlink(ROOTPATH . 'writable/uploads/research/' . $research['cover_image']);
            }
            $data['cover_image'] = handle_upload($imgFile);
        }

        $this->researchModel->save($data);

        return redirect()->to('/dashboard/research')->with('success', 'Research updated successfully.');
    }

    public function delete($id)
    {
        $research = $this->researchModel->find($id);
        if (!$research) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $this->researchModel->delete($id);
        return redirect()->to('/dashboard/research')->with('success', 'Research deleted successfully.');
    }

    public function moderate($id)
    {
        if (session()->get('role') === 'user') {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $status = $this->request->getVar('status');
        if (!in_array($status, ['published', 'rejected', 'pending'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $this->researchModel->update($id, ['status' => $status]);
        return redirect()->to('/dashboard/research')->with('success', 'Status updated to ' . $status);
    }
}
