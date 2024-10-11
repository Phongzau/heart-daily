<?php

namespace App\Http\Controllers\Client;

use App\Helper\BadwordsHelper;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function blogDetails(string $slug)
    {
        $blog = Blog::query()->where('slug', $slug)->where('status', 1)->firstOrFail();
        $comments = BlogComment::query()->where('blog_id', $blog->id)->paginate(8);
        //        $moreBlogs = Blog::query()->where('slug', '!=', $slug)
        //            ->where('status', 1)
        //            ->orderBy('id', 'DESC')
        //            ->take(5)
        //            ->get();
        $countComments = BlogComment::query()->where('blog_id', $blog->id)->count();
        // Lấy các bài viết khác (trừ bài viết hiện tại) để hiển thị trong Recent Posts
        $recentPosts = Blog::query()
            ->where('slug', '!=', $slug) // Loại trừ bài viết hiện tại
            ->where('status', 1) // Chỉ lấy những bài viết có trạng thái là 1
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
            ->take(5) // Giới hạn 5 bài viết
            ->get();
        // Nếu bạn cần lấy comments, hãy chắc chắn biến này được định nghĩa.
        // $comments = Comment::where('blog_id', $blog->id)->get(); // Ví dụ lấy comment liên quan đến blog này

        $categories = BlogCategory::query()->where('status', 1)->get();

        return view('client.page.blog-details', compact('blog', 'recentPosts', 'categories', 'comments', 'countComments')); // Loại bỏ biến trống và thêm comments nếu cần
    }

    public function blogs(Request $request, $category = null)
    {
        $categories = BlogCategory::all(); // Lấy tất cả categories
        if ($category != null) {
            $category = BlogCategory::where('slug', $category)->first();
            if (isset($category) && !empty($category)) {
                $blogs = Blog::where('blog_category_id', $category->id)->where('status', 1)->paginate(9);
                return view('client.page.blog', compact('blogs', 'categories'));
            } else {
                toastr('Category không tồn tại');
                return redirect()->back();
            }
        } else {
            $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(9);
            return view('client.page.blog', compact('blogs', 'categories'));
        }
    }

    public function comments(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'max:250', 'string'],
            'blog_id' => ['required'],
        ], [
            'comment.required' => 'Bạn phải nhập bình luận.',
            'comment.max' => 'Bình luận không được vượt quá 250 ký tự.',
            'comment.string' => 'Bình luận phải là một chuỗi văn bản hợp lệ.',
            'blog_id.required' => 'Thiếu ID của bài viết.'
        ]);

        // Kiểm tra từ nhạy cảm
        if (BadwordsHelper::isProfane($request->comment)) {
            return response([
                'status' => 'error',
                'message' => 'Bình luận có chứa từ ngữ nhạy cảm',
            ]);
        }


        // Lưu comment vào cơ sở dữ liệu
        $comment = new BlogComment();
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->blog_id = $request->blog_id;
        $comment->save();

        // Trả về comment mới thêm vào
        return response([
            'status' => 'success',
            'message' => 'Bình luận thành công',
            'comment' => $comment,
        ]);
    }

    public function getAllComments(Request $request)
    {
        $comments = BlogComment::query()
            ->where('blog_id', $request->blog_id)
            ->with('user')
            ->paginate(8);

        // Sử dụng vòng lặp để thêm đường dẫn ảnh cho từng bình luận
        foreach ($comments as $comment) {
            if ($comment->user->image) {
                $comment->user->profile_image_url = Storage::url($comment->user->image);
            } else {
                $comment->user->profile_image_url = asset('frontend/assets/images/blog/author.jpg'); // Ảnh mặc định
            }
        }
        return $comments;
    }
}
