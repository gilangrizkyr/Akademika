<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SectionModel;
use App\Models\ResearchModel;

class SectionController extends BaseController
{
    protected $sectionModel;
    protected $researchModel;

    public function __construct()
    {
        $this->sectionModel = new SectionModel();
        $this->researchModel = new ResearchModel();
        helper(['form', 'url', 'upload', 'youtube', 'security']);
    }

    public function index($researchId)
    {
        $research = $this->researchModel->find($researchId);
        if (!$research) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // Check permission
        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $data = [
            'research' => $research,
            'sections' => $this->sectionModel->where('research_id', $researchId)->orderBy('sort_order', 'ASC')->findAll(),
            'title' => 'Research Sections: ' . $research['title']
        ];

        return view('dashboard/section/index', $data);
    }

    public function store($researchId)
    {
        $research = $this->researchModel->find($researchId);
        if (!$research) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // Ownership Check
        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'youtube_url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imgFile = $this->request->getFile('image');
        $imgName = ($imgFile && $imgFile->isValid()) ? handle_upload($imgFile) : null;
        
        $youtubeUrl = $this->request->getVar('youtube_url');
        $embedUrl = $youtubeUrl ? get_youtube_embed($youtubeUrl) : null;

        $this->sectionModel->save([
            'research_id' => $researchId,
            'title' => $this->request->getVar('title'),
            'content' => sanitize_html($this->request->getVar('content')),
            'image' => $imgName,
            'youtube_url' => $embedUrl,
            'sort_order' => $this->request->getVar('sort_order') ?? 0,
        ]);

        return redirect()->to('/dashboard/section/' . $researchId)->with('success', 'Section added successfully.');
    }

    public function update($id)
    {
        $section = $this->sectionModel->find($id);
        if (!$section) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $research = $this->researchModel->find($section['research_id']);
        
        // Ownership Check
        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'youtube_url' => 'permit_empty|valid_url'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'title' => $this->request->getVar('title'),
            'content' => sanitize_html($this->request->getVar('content')),
            'sort_order' => $this->request->getVar('sort_order') ?? 0,
        ];

        $imgFile = $this->request->getFile('image');
        if ($imgFile && $imgFile->isValid()) {
            if ($section['image'] && file_exists(ROOTPATH . 'writable/uploads/research/' . $section['image'])) {
                unlink(ROOTPATH . 'writable/uploads/research/' . $section['image']);
            }
            $data['image'] = handle_upload($imgFile);
        }

        $youtubeUrl = $this->request->getVar('youtube_url');
        if ($youtubeUrl) {
            $data['youtube_url'] = get_youtube_embed($youtubeUrl);
        }

        $this->sectionModel->save($data);

        return redirect()->to('/dashboard/section/' . $section['research_id'])->with('success', 'Section updated successfully.');
    }

    public function delete($id)
    {
        $section = $this->sectionModel->find($id);
        if (!$section) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $research = $this->researchModel->find($section['research_id']);
        
        // Ownership Check
        if (session()->get('role') !== 'superadmin' && $research['user_id'] != session()->get('id')) {
            return redirect()->to('/dashboard/research')->with('error', 'Unauthorized access.');
        }

        $this->sectionModel->delete($id);
        return redirect()->to('/dashboard/section/' . $section['research_id'])->with('success', 'Section deleted successfully.');
    }
}
