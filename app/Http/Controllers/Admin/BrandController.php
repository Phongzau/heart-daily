<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\BrandDataTable;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUploadTrait;

use App\Models\Brand;

class BrandController extends Controller
{
    use ImageUploadTrait;

    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.page.brands.index');
    }

    public function create()
    {
        return view('admin.page.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        DB::beginTransaction();

        try {
            // Tải hình ảnh và lấy đường dẫn
            $imagePath = $this->uploadImage($request, 'image', 'brands');

            // Tạo mới Brands
            $brands = new Brand();
            $brands->name = $request->name;
            $brands->description = $request->description;
            $brands->slug = Str::slug($request->name);
            $brands->image = $imagePath;
            $brands->status = $request->status;
            $brands->save();

            // Commit transaction
            DB::commit();

            toastr('Tạo thành công', 'success');
            return redirect()->route('admin.brands.index');
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

    public function edit(string $id)
    {
        $brands = Brand::query()->findOrFail($id);
        return view('admin.page.brands.edit', compact('brands'));
    }


    public function update(UpdateBrandRequest $request, string $id)
    {
        $brands = Brand::query()->findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', $brands->image, 'brands');
        $brands->image = $imagePath;
        $brands->name = $request->name;
        $brands->description = $request->description;
        $brands->status = $request->status;
        $brands->save();
        toastr('Cập nhật thành công', 'success');
        return redirect()->route('admin.brands.index');
    }

    public function destroy(string $id)
    {
        $brands = Brand::query()->findOrFail($id);
        $this->deleteImage($brands->image);
        $brands->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $brands = Brand::query()->findOrFail($request->id);
        $brands->status = $request->status == 'true' ? 1 : 0;
        $brands->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
