<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryAttributeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryAttributeRequest;
use App\Http\Requests\UpdateCategoryAttributeRequest;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;

class AdminCategoryAttributeController extends Controller
{
    public function index(CategoryAttributeDataTable $dataTable)
    {
        return $dataTable->render('admin.page.category_attributes.index');
    }

    public function changeStatus(Request $request)
    {
        $categoryAttribute = CategoryAttribute::query()->findOrFail($request->id);
        $categoryAttribute->status = $request->status == 'true' ? 1 : 0;
        $categoryAttribute->save();

        return response([
            'message' => 'Cập nhật thành công Status',
        ]);
    }

    public function create()
    {
        return view('admin.page.category_attributes.create');
    }

    public function store(StoreCategoryAttributeRequest $request)
    {
        if (CategoryAttribute::where('order', $request->order)->exists()) {
            toastr('Giá trị order đã tồn tại!', 'error');
            return redirect()->back()->withInput();
        }

        $categoryAttribute = new CategoryAttribute();

        $categoryAttribute->title = $request->title;
        $categoryAttribute->slug = $request->slug;
        $categoryAttribute->order = $request->order;
        $categoryAttribute->status = $request->status;
        $categoryAttribute->created_by = auth()->id();
        $categoryAttribute->updated_by = auth()->id();
        $categoryAttribute->save();

        toastr('Tạo thuộc tính danh mục thành công', 'success');
        return redirect()->route('admin.category_attributes.index');
    }

    public function edit(string $id)
    {
        $categoryAttribute = CategoryAttribute::query()->findOrFail($id);
        return view('admin.page.category_attributes.edit', compact('categoryAttribute'));
    }

    public function update(UpdateCategoryAttributeRequest $request, string $id)
    {
        $categoryAttribute = CategoryAttribute::query()->findOrFail($id);
        if (CategoryAttribute::where('order', $request->order)
            ->where('id', '!=', $id) 
            ->exists()
        ) {
            toastr('Giá trị order đã tồn tại!', 'error');
            return redirect()->back()->withInput(); 
        }
        $categoryAttribute->title = $request->title;
        $categoryAttribute->slug = $request->slug;
        $categoryAttribute->order = $request->order;
        $categoryAttribute->status = $request->status;
        $categoryAttribute->updated_by = auth()->id();
        $categoryAttribute->save();

        toastr('Cập nhật thuộc tính danh mục thành công', 'success');
        return redirect()->route('admin.category_attributes.index');
    }

    public function destroy(string $id)
    {
        $categoryAttribute = CategoryAttribute::query()->findOrFail($id);
        $categoryAttribute->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ]);
    }
}
