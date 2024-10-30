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

        $request->validate([


            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/'
            ]

        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
        toastr('Đã cập nhật mật khẩu thành công  ', 'success');
        return redirect()->back();
    }
    // public function AdminChangePassword()
    // {
    //     return view('admin.page.admin_profile.admin_change_password');
    // }
}
