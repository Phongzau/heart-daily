<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AdminProfileController extends Controller
{
    use ImageUploadTrait;
    public function AdminProfile()
    {
        $userData = User::where('id', Auth::user()->id)->first();

        return view('admin.page.profile.index', compact('userData'));
    }
    // public function AdminProfileEdit()
    // {
    //     $editData = User::where('role_id', 1)->first();
    //     return view('admin.page.profile.edit', compact('editData'));
    // }
    public function AdminProfileUpdate(Request $request)
    {
        // $data = User::where('role_id', 1)->first();
        $data = User::where('id', Auth::user()->id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        $image = $this->updateImage($request, 'image', $data->image ?? '', 'avatar');
        $data->image = $image;
        $data->save();
        return redirect()->route('admin.profile');
    }
    public function updatePassword(Request $request)
    {

        // Validate đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Lấy ra user
        $user = User::find(Auth::id());

        // Kiểm tra mật khẩu hiện tại có khớp không
        if (!Hash::check($request->current_password, $user->password)) {
            toastr('Mật khẩu hiện tại không đúng.', 'error');
            return back();
        }

        // Kiểm tra mật khẩu mới không giống mật khẩu hiện tại
        if (Hash::check($request->new_password, $user->password)) {
            toastr('Mật khẩu mới không được trùng với mật khẩu hiện tại.', 'error');
            return back();
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        toastr('Mật khẩu của bạn đã được cập nhật thành công!', 'success');
        return back();
    }
    // public function AdminChangePassword()
    // {
    //     return view('admin.page.admin_profile.admin_change_password');
    // }
}
