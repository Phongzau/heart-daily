<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(BlogCommentDataTable $dataTable)
    {
        return $dataTable->render('admin.page.blog_comments.index');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công!',
        ]);
    }
}
