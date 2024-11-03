<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\DataTables\BlogDataTable;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    use ImageUploadTrait;
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.page.blogs.index');
    }
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.page.blogs.create',compact('categories'));
    }
    public function store(BlogRequest $request)
    {

        DB::beginTransaction();
        try {
            $imagePath = $this->uploadImage($request, 'image', 'blogs');
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->slug = Str::slug($request->title);
            $blog->blog_category_id = $request->blog_category_id;
            $blog->status = $request->status;
            $blog->image = $imagePath;
            $blog->save();

            DB::commit();
            toastr('Tạo thành công', 'success');
            return redirect()->route('admin.blogs.index');
        } catch (QueryException $e) {
            // Rollback nếu có lỗi
            DB::rollBack();

            // Xóa ảnh nếu có lỗi
            $this->deleteImage($imagePath);

            // Thông báo lỗi
            toastr('Có lỗi xảy ra: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $blog = Blog::query()->findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.page.blogs.edit', compact('blog','categories'));
    }

    public function update(UpdateBlogRequest $request, $id)
    {
        $blog = Blog::query()->findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', $blog->image, 'blogs');
        $blog->image = $imagePath;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->slug = Str::slug($request->title);
        $blog->blog_category_id = $request->blog_category_id;
        $blog->status = $request->status;
        $blog->save();
        toastr('Cập nhật thành công', 'success');
        return redirect()->route('admin.blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::query()->findOrFail($id);
        $this->deleteImage($blog->image);
        $blog->delete();
        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $blog = Blog::query()->findOrFail($request->id);
        $blog->status = $request->status == 'true' ? 1 : 0;
        $blog->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
