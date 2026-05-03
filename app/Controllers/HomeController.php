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
            'stats' => [
                'research' => $researchModel->where('status', 'published')->countAllResults(),
                'views' => $researchModel->selectSum('views')->get()->getRow()->views ?? 0,
                'categories' => $categoryModel->countAllResults(),
                'researchers' => (new \App\Models\UserModel())->countAllResults(),
            ]
        ];

        return view('frontend/home', $data);
    }

    public function detail($slug)
    {
        $researchModel = new ResearchModel();
        $sectionModel = new SectionModel();

        $research = $researchModel->select('researches.*, categories.name as category_name')
                                  ->join('categories', 'categories.id = researches.category_id', 'left')
                                  ->where('researches.slug', $slug)
                                  ->where('researches.status', 'published')
                                  ->first();
        
        if (!$research) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Bookmark check
        $bookmarkModel = new \App\Models\BookmarkModel();
        $isBookmarked = false;
        if (session()->get('isLoggedIn')) {
            $isBookmarked = $bookmarkModel->where('user_id', session()->get('id'))
                                         ->where('research_id', $research['id'])
                                         ->first() ? true : false;
        }

        // Related content (same category)
        $related = $researchModel->where('category_id', $research['category_id'])
                                 ->where('id !=', $research['id'])
                                 ->where('status', 'published')
                                 ->limit(3)
                                 ->find();

        // SEO & Schema
        $data = [
            'title' => $research['title'] . ' - Akademika',
            'meta_description' => character_limiter(strip_tags($research['abstract']), 160),
            'meta_image' => base_url('uploads/research/' . ($research['cover_image'] ?? 'default.jpg')),
            'research' => $research,
            'sections' => $sectionModel->where('research_id', $research['id'])->orderBy('sort_order', 'ASC')->findAll(),
            'isBookmarked' => $isBookmarked,
            'related' => $related,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ScholarlyArticle',
                'headline' => $research['title'],
                'description' => strip_tags($research['abstract']),
                'author' => [
                    '@type' => 'Person',
                    'name' => 'Peneliti Akademika'
                ],
                'datePublished' => $research['created_at'],
                'image' => base_url('uploads/research/' . ($research['cover_image'] ?? 'default.jpg')),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Akademika',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => base_url('favicon.ico')
                    ]
                ]
            ]
        ];

        return view('frontend/detail', $data);
    }

    public function search()
    {
        $researchModel = new ResearchModel();
        $keyword = $this->request->getVar('q');
        
        // Validation: Limit length and sanitize
        if ($keyword) {
            $keyword = strip_tags(substr($keyword, 0, 100));
        }

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
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $researchModel = new ResearchModel();
        $research = $researchModel->find($id);
        
        if ($research) {
            $researchModel->update($id, ['views' => $research['views'] + 1]);
            return $this->response->setJSON(['status' => 'success', 'new_views' => $research['views'] + 1]);
        }
        
        return $this->response->setJSON(['status' => 'error'], 404);
    }
}
