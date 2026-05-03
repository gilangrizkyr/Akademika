<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookmarkModel;

class BookmarkController extends BaseController
{
    public function toggle($researchId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please login to bookmark research.'
            ]);
        }

        $userId = session()->get('id');
        $bookmarkModel = new BookmarkModel();

        $existing = $bookmarkModel->where('user_id', $userId)
                                 ->where('research_id', $researchId)
                                 ->first();

        if ($existing) {
            $bookmarkModel->delete($existing['id']);
            return $this->response->setJSON([
                'status' => 'success',
                'action' => 'removed',
                'message' => 'Bookmark removed.'
            ]);
        } else {
            $bookmarkModel->save([
                'user_id' => $userId,
                'research_id' => $researchId
            ]);
            return $this->response->setJSON([
                'status' => 'success',
                'action' => 'added',
                'message' => 'Bookmark added.'
            ]);
        }
    }
}
