<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewletterPopupDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewletterPopupRequest;
use App\Http\Requests\UpdateNewletterPopupRequest;
use App\Mail\NewletterPopupNotification;
use App\Models\NewletterPopup;
use App\Models\NewsletterSubscriber;
use App\Models\Social;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewletterPopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;


    public function index(NewletterPopupDataTable $dataTable)
    {
        $popupExists = NewletterPopup::exists();
        $subscribers = NewsletterSubscriber::all();
        return $dataTable->render('admin.page.popups.index', compact('subscribers', 'popupExists'));
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
        $existingPopup = NewletterPopup::first();
        if ($existingPopup) {
            toastr('Chỉ có thể thêm một quảng cáo.', 'error');
            return redirect()->back()->withInput();
        }
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

            $subscribers = NewsletterSubscriber::all();
            $socials = Social::query()->where('status', 1)->get();
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewletterPopupNotification($popups, $subscriber, $socials));
            }
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

        $subscribers = NewsletterSubscriber::all();
        $socials = Social::query()->where('status', 1)->get();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewletterPopupNotification($popups, $subscriber, $socials));
        }
        toastr('Cập nhật thành công', 'success');
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
            'message' => 'Xóa thành công !',
        ]);
    }
    public function subscribe(Request $request)
    {
        $email = $request->input('email');

        // Kiểm tra email đã tồn tại hay chưa
        if (NewsletterSubscriber::where('email', $email)->exists()) {
            toastr('Email này đã được đăng ký!', 'error');
            return redirect()->back();
        }

        // Lưu email vào bảng subscribers
        $subscriber = new NewsletterSubscriber();
        $subscriber->email = $email;
        $subscriber->save();

        // Gửi mail thông báo
        $popup = NewletterPopup::query()->latest()->first();
        $socials = Social::query()->where('status', 1)->get();
        Mail::to($email)->send(new NewletterPopupNotification($popup, $email, $socials));

        toastr('Đăng ký thành công!', 'success');
        return redirect()->back();
    }
    public function destroySubscribe($id)
    {
        $subscriber = NewsletterSubscriber::query()->findOrFail($id);
        $subscriber->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }
    public function changeStatus(Request $request)
    {
        $popups = NewletterPopup::query()->findOrFail($request->id);
        $popups->status = $request->status == 'true' ? 1 : 0;
        $popups->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
