<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    use ImageUploadTrait;
    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('admin.page.banners.index');
    }

    public function create()
    {
        return view('admin.page.banners.create');
    }

    public function store(StoreBannerRequest $request)
    {
        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            // Tải hình ảnh và lấy đường dẫn
            $imagePath = $this->uploadImage($request, 'image', 'banners');

            // Tạo mới Banner
            $banner = new Banner();
            $banner->image = $imagePath;
            $banner->url = $request->url;
            $banner->description = $request->description;
            $banner->status = $request->status;
            $banner->save();

            // Commit transaction
            DB::commit();

            toastr('Tạo thành công', 'success');
            return redirect()->route('admin.banners.index');
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
        $banner = Banner::query()->findOrFail($id);
        return view('admin.page.banners.edit', compact('banner'));
    }

    public function update(UpdateBannerRequest $request, string $id)
    {
        $banner = Banner::query()->findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', $banner->image, 'banners');
        $banner->image = $imagePath;
        $banner->url = $request->url;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $banner->save();
        toastr('Sửa thành công', 'success');
        return redirect()->route('admin.banners.index');
    }

    public function destroy(string $id)
    {
        $banner = Banner::query()->findOrFail($id);
        $this->deleteImage($banner->image);
        $banner->delete();

        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully!',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $banner = Banner::query()->findOrFail($request->id);
        $banner->status = $request->status == 'true' ? 1 : 0;
        $banner->save();

        return response([
            'message' => 'Status has been updated',
        ]);
    }
}
