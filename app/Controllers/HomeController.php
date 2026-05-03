<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResearchModel;
use App\Models\CategoryModel;
use App\Models\SectionModel;

class HomeController extends BaseController
{
    public function index()
    {
        $researchModel = new ResearchModel();
        $categoryModel = new CategoryModel();

        $data = [
            'categories' => $categoryModel->findAll(),
            'latest' => $researchModel->where('status', 'published')->orderBy('created_at', 'DESC')->limit(6)->find(),
            'popular' => $researchModel->where('status', 'published')->orderBy('views', 'DESC')->limit(6)->find(),
        ];

        return view('frontend/home', $data);
    }

    public function detail($slug)
    {
        $researchModel = new ResearchModel();
        $sectionModel = new SectionModel();

        $research = $researchModel->where('slug', $slug)->where('status', 'published')->first();
        
        if (!$research) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Increment views
        $researchModel->update($research['id'], ['views' => $research['views'] + 1]);

        $data = [
            'research' => $research,
            'sections' => $sectionModel->where('research_id', $research['id'])->orderBy('sort_order', 'ASC')->findAll(),
        ];

        return view('frontend/detail', $data);
    }

    public function search()
    {
        $researchModel = new ResearchModel();
        $keyword = $this->request->getVar('q');

        $query = $researchModel->where('status', 'published');
        if ($keyword) {
            $query->groupStart()
                  ->like('title', $keyword)
                  ->orLike('abstract', $keyword)
                  ->groupEnd();
        }

        $data = [
            'keyword' => $keyword,
            'researches' => $query->paginate(12),
            'pager' => $researchModel->pager,
        ];

        return view('frontend/search', $data);
    }
}
