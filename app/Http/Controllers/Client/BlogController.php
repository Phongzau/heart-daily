<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function blogDetails(string $slug)
    {
        $blog = Blog::query()->where('slug', $slug)->where('status', 1)->firstOrFail();

//        $moreBlogs = Blog::query()->where('slug', '!=', $slug)
//            ->where('status', 1)
//            ->orderBy('id', 'DESC')
//            ->take(5)
//            ->get();

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

        return view('client.page.blog-details', compact('blog','recentPosts' , 'categories')); // Loại bỏ biến trống và thêm comments nếu cần
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
            return view('client.page.blog', compact('blogs','categories'));
        }
    }
}
