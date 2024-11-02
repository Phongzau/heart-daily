<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryProductDataTable $dataTable)
    {
        return $dataTable->render('admin.page.category_products.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProduct = CategoryProduct::query()->get();
        $maxOrderChild = CategoryProduct::query()
            ->where('parent_id', 0)
            ->orderBy('order', 'desc')
            ->first();
        $maxOrder = $maxOrderChild ? $maxOrderChild->order + 1 : 0;
        return view('admin.page.category_products.create', compact('categoryProduct', 'maxOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryProductRequest $request)
    {
        // Kiểm tra giá trị order có tồn tại trong cùng danh mục cha không
        if (CategoryProduct::where('order', $request->order)
            ->where('parent_id', $request->parent_id)
            ->exists()
        ) {
            toastr('Giá trị order đã tồn tại trong danh mục cha!', 'error');
            return redirect()->back()->withInput();
        }

        $CategoryProduct = new CategoryProduct();

        // Gán các giá trị từ request
        $CategoryProduct->title = $request->title;
        $CategoryProduct->slug = Str::slug($request->title);
        $CategoryProduct->parent_id = $request->parent_id;
        $CategoryProduct->order = $request->order;
        $CategoryProduct->status = $request->status;

        // Tự động thiết lập level dựa trên parent_id
        if ($request->parent_id) {
            // Nếu có danh mục cha, thiết lập level bằng level của danh mục cha + 1
            $parentCategory = CategoryProduct::find($request->parent_id);
            $CategoryProduct->level = $parentCategory->level + 1;
        } else {
            // Nếu không có danh mục cha, level được đặt mặc định là 1
            $CategoryProduct->level = 1;
        }

        // Gán người tạo và người cập nhật là ID của người dùng hiện tại
        // $CategoryProduct->userid_created = auth()->id();

        // Lưu danh mục sản phẩm
        $CategoryProduct->save();

        // Thông báo thành công
        toastr('Tạo thuộc tính danh mục thành công', 'success');
        return redirect()->route('admin.category_products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Tìm category product theo ID
        $categoryProduct = CategoryProduct::findOrFail($id);
        $categoryProductAll = CategoryProduct::query()
            ->where('id', '!=', $id)
            ->where('parent_id', '!=', $id)->get();
        // Trả về view 'create' để chỉnh sửa danh mục
        return view('admin.page.category_products.edit', compact('categoryProduct', 'categoryProductAll'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryProductRequest $request, string $id)
    {
        // Tìm danh mục sản phẩm theo ID
        $categoryProduct = CategoryProduct::findOrFail($id);
      
        // Chỉ kiểm tra khi parent_id thay đổi
        if ($request->parent_id != $categoryProduct->parent_id) {
            if (CategoryProduct::where('parent_id', '=', $id)->first()) {
                toastr('Danh mục này đã có danh mục con!', 'error');
                return redirect()->back()->withInput();
            }
        }

        // Kiểm tra giá trị order có tồn tại trong cùng danh mục cha (ngoại trừ bản ghi hiện tại)
        if (CategoryProduct::where('order', $request->order)
            ->where('parent_id', $request->parent_id)
            ->where('id', '!=', $categoryProduct->id) // Loại bỏ bản ghi hiện tại ra khỏi điều kiện
            ->exists()
        ) {
            toastr('Giá trị order đã tồn tại trong danh mục cha!', 'error');
            return redirect()->back()->withInput();
        }

        // Cập nhật các giá trị từ request
        $categoryProduct->title = $request->title;
        $categoryProduct->slug = Str::slug($request->title);
        $categoryProduct->parent_id = $request->parent_id;
        $categoryProduct->order = $request->order;
        $categoryProduct->status = $request->status;

        // Tự động thiết lập level dựa trên parent_id
        if ($request->parent_id) {
            // Nếu có danh mục cha, thiết lập level bằng level của danh mục cha + 1
            $parentCategory = CategoryProduct::find($request->parent_id);
            $categoryProduct->level = $parentCategory->level + 1;
        } else {
            // Nếu không có danh mục cha, level được đặt mặc định là 1
            $categoryProduct->level = 1;
        }

        // Cập nhật người sửa là ID của người dùng hiện tại
        // $categoryProduct->userid_updated = auth()->id();

        // Lưu các thay đổi
        $categoryProduct->save();

        // Thông báo thành công
        toastr('Cập nhật danh mục thành công', 'success');
        return redirect()->route('admin.category_products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm danh mục theo ID
        $categoryProduct = CategoryProduct::findOrFail($id);
        $check = CategoryProduct::where('parent_id', '=', $id)->first();
        // Xóa danh mục
        if ($check) {
            return response([
                'status' => 'error',
                'message' => 'Danh mục con đang tồn tại xóa danh mục con trước khi xóa danh mục cha',
            ]);
        } else {
            $categoryProduct->delete();
            return response([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        $categoryProduct = CategoryProduct::query()->findOrFail($request->id);
        $categoryProduct->status = $request->status == 'true' ? 1 : 0;

        // Khởi tạo mảng idArray để đảm bảo luôn tồn tại
        $idArray = [];
        if ($request->status == 'false') {
            $productCategories = CategoryProduct::where('parent_id', '=', $categoryProduct->id)->get();

            foreach ($productCategories as $category) {
                $idArray[] = $category->id;
                $category->status = $request->status == 'true' ? 1 : 0;
                $category->save();
            }
        }

        $categoryProduct->save();

        return response([
            'message' => 'Trạng thái đã được cập nhật',
            'id_array' => $idArray,
        ]);
    }

    public function getParentCategory(Request $request)
    {
        if ($request->id == 0) {
            $categoryProduct = CategoryProduct::query()
                ->where('parent_id', 0)
                ->orderBy('order', 'desc')
                ->first();
            return $categoryProduct;
        }
        $categoryProduct = CategoryProduct::query()->findOrFail($request->id);
        $maxOrderChild = CategoryProduct::query()
            ->where('parent_id', $categoryProduct->id)
            ->orderBy('order', 'desc')
            ->first();
        $level = $categoryProduct->level + 1;
        return response([
            'order' => $maxOrderChild ? $maxOrderChild->order : null,
            'level' => $level,
        ]);
    }
}
