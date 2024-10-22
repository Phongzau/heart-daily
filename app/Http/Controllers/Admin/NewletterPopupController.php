<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewletterPopupDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewletterPopupRequest;
use App\Http\Requests\UpdateNewletterPopupRequest;
use App\Models\NewletterPopup;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NewletterPopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;


    public function index(NewletterPopupDataTable $dataTable)
    {
        return $dataTable->render('admin.page.popups.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.popups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewletterPopupRequest $request)
    {
        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            // Tải hình ảnh và lấy đường dẫn
            $imagePath = $this->uploadImage($request, 'image', 'popups');

            // Tạo mới Banner
            $popups = new NewletterPopup();
            $popups->image = $imagePath;
            $popups->title = $request->title;
            $popups->description = $request->description;
            $popups->status = $request->status;
            $popups->save();

            // Commit transaction
            DB::commit();

            toastr('Tạo thành công', 'success');
            return redirect()->route('admin.popups.index');
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
        $popups = NewletterPopup::query()->findOrFail($id);
        return view('admin.page.popups.edit', compact('popups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewletterPopupRequest $request, string $id)
    {
        $popups = NewletterPopup::query()->findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', $popups->image, 'popups');
        $popups->image = $imagePath;
        $popups->title = $request->title;
        $popups->description = $request->description;
        $popups->status = $request->status;
        $popups->save();
        toastr('Sửa thành công', 'success');
        return redirect()->route('admin.popups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $popups = NewletterPopup::query()->findOrFail($id);
        $this->deleteImage($popups->image);
        $popups->delete();

        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully!',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $popups = NewletterPopup::query()->findOrFail($request->id);
        $popups->status = $request->status == 'true' ? 1 : 0;
        $popups->save();

        return response([
            'message' => 'Status has been updated',
        ]);
    }
}
