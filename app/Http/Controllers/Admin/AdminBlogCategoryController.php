<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogCategoryController extends Controller
{
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.page.blog_categories.index');
    }

    public function changeStatus(Request $request)
    {
        $blogCategory = BlogCategory::query()->findOrFail($request->id);
        $blogCategory->status = $request->status == 'true' ? 1 : 0;
        $blogCategory->save();
        return response([
            'message' => 'Cập nhật thành công Status',
        ]);
    }

    public function create()
    {
        return view('admin.page.blog_categories.create');
    }

    public function store(StoreBlogCategoryRequest $request)
    {
        $blogCategory = new BlogCategory();

        $blogCategory->name = $request->name;
        $blogCategory->slug = Str::slug($request->name);
        $blogCategory->status = $request->status;
        $blogCategory->save();
        toastr('Tạo thuộc tính danh mục thành công', 'success');
        return redirect()->route('admin.blog_categories.index');
    }

    public function edit(string $id)
    {
        $blogCategory = BlogCategory::query()->findOrFail($id);
        return view('admin.page.blog_categories.edit', compact('blogCategory'));
    }

    public function update(UpdateBlogCategoryRequest $request, string $id)
    {
        $blogCategory = BlogCategory::query()->findOrFail($id);

        $blogCategory->name = $request->name;
        $blogCategory->slug = Str::slug($request->name);
        $blogCategory->status = $request->status;
        $blogCategory->save();
        toastr('Cập nhật thuộc tính danh mục thành công', 'success');
        return redirect()->route('admin.blog_categories.index');
    }

    public function destroy(string $id)
    {
        $blogCategory = BlogCategory::query()->findOrFail($id);
        $blogCategory->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ]);
    }
}
