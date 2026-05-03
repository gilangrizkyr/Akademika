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
            'latest' => $researchModel->select('researches.*, categories.name as category_name')
                                      ->join('categories', 'categories.id = researches.category_id', 'left')
                                      ->where('status', 'published')
                                      ->orderBy('created_at', 'DESC')
                                      ->limit(6)
                                      ->find(),
            'popular' => $researchModel->select('researches.*, categories.name as category_name')
                                       ->join('categories', 'categories.id = researches.category_id', 'left')
                                       ->where('status', 'published')
                                       ->orderBy('views', 'DESC')
                                       ->limit(6)
                                       ->find(),
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

        // View increment moved to async fetch in app.js

        $bookmarkModel = new \App\Models\BookmarkModel();
        $isBookmarked = false;
        if (session()->get('isLoggedIn')) {
            $isBookmarked = $bookmarkModel->where('user_id', session()->get('id'))
                                         ->where('research_id', $research['id'])
                                         ->first() ? true : false;
        }

        $data = [
            'research' => $research,
            'sections' => $sectionModel->where('research_id', $research['id'])->orderBy('sort_order', 'ASC')->findAll(),
            'isBookmarked' => $isBookmarked,
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
            'researches' => $query->select('researches.*, categories.name as category_name')
                                 ->join('categories', 'categories.id = researches.category_id', 'left')
                                 ->paginate(12),
            'pager' => $researchModel->pager,
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data['researches'],
                'keyword' => $keyword
            ]);
        }

        return view('frontend/search', $data);
    }

    public function incrementView($id)
    {
        $researchModel = new ResearchModel();
        $research = $researchModel->find($id);
        
        if ($research) {
            $researchModel->update($id, ['views' => $research['views'] + 1]);
            return $this->response->setJSON(['status' => 'success', 'new_views' => $research['views'] + 1]);
        }
        
        return $this->response->setJSON(['status' => 'error'], 404);
    }
}
