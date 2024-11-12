<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Mail\ConfirmEmail;
use App\Models\Commune;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        return view('client.page.auth.login');
    }

    public function register()
    {
        return view('client.page.auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = Str::random(60);
        $user->status = 0;
        $user->role_id = 4;
        $user->save();

        $confirmationLink = route('confirm.email', ['token' => $user->token, 'email' => $user->email]);
        Mail::to($user->email)->send(new ConfirmEmail($user, $confirmationLink));

        toastr('Vui lòng kiểm tra email để xác nhận tài khoản!', 'success');
        return redirect()->route('login');
    }

    public function confirmEmail(Request $request)
    {
        $user = User::where('email', $request->email)->where('token', $request->token)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->token = null;
            $user->status = 1;
            $user->save();

            toastr('Tài khoản của bạn đã được xác nhận!', 'success');
            return redirect()->route('login');
        } else {
            toastr('Liên kết xác nhận không hợp lệ.', 'error');
            return redirect()->route('login');
        }
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'password' => $request->password,
        ];

        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->login;
        } else {
            $credentials['name'] = $request->login;
        }

        $user = User::where('email', $request->login)->orWhere('name', $request->login)->first();
        if ($user && $user->status === 0) {
            toastr('Bạn cần xác nhận email trước khi đăng nhập.', 'error');
            return redirect()->back();
        }

        if (Auth::attempt($credentials)) {
            // if (Auth::user()->role_id == 1) {
            //     toastr('Đăng nhập thành công!', 'success');
            //     return redirect()->intended('admin/dashboard');
            // }
            toastr('Đăng nhập thành công!', 'success');
            return redirect()->intended('/');
        } else {
            toastr('Thông tin đăng nhập không chính xác.', 'error');
            return redirect()->back();
        }
    }


    public function showForgotPasswordForm()
    {
        return view('client.page.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            toastr('Liên kết đặt lại mật khẩu đã được gửi đến email của bạn!', 'success');
            return back();
        }

        toastr('Có lỗi xảy ra, vui lòng thử lại.', 'error');
        return back();
    }

    public function showResetPasswordForm($token)
    {
        return view('client.page.auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
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

    public function logout()
    {
        Auth::logout();
        toastr('Bạn đã đăng xuất thành công.', 'success');
        return redirect()->route('home');
    }

    public function updateProfile(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'display_name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'image' => ['image', 'max:2048'],
        ]);

        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            // Lấy người dùng hiện tại
            $user = User::find(Auth::id());

            if (!$user->image) {
                // Kiểm tra nếu có file ảnh được tải lên
                if ($request->hasFile('image')) {
                    // Upload ảnh và lấy đường dẫn
                    $imagePath = $this->uploadImage($request, 'image', 'users');
                }
            } else {
                $imagePath = $this->updateImage($request, 'image', $user->image, 'users');
            }

            // Cập nhật các thông tin khác
            $user->image = $imagePath;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->display_name = $request->display_name;
            $user->email = $request->email;
            $user->save();

            // Commit transaction
            DB::commit();

            // Thông báo thành công
            toastr()->success('Profile updated successfully');
            return redirect()->back();
        } catch (QueryException $e) {
            // Rollback nếu có lỗi
            DB::rollBack();

            // Xóa ảnh nếu có lỗi
            if (isset($imagePath)) {
                $this->deleteImage($imagePath);
            }

            // Thông báo lỗi
            toastr('Có lỗi xảy ra: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    public function createOrUpdateAddress(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'commune_id' => 'required|exists:communes,id',
            'address' => 'required|string|max:500',
        ]);

        $user = User::updateOrCreate(
            ['id' => Auth::id()], // Điều kiện: tìm user theo id
            [
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone' => $validatedData['phone'],
                'province_id' => $validatedData['province_id'],
                'district_id' => $validatedData['district_id'],
                'commune_id' => $validatedData['commune_id'],
                'address' => $validatedData['address'],
            ]
        );

        // return response()->json([
        //     'message' => 'Thông tin địa chỉ đã được cập nhật thành công.',
        //     'user' => $user,
        // ]);

        return redirect()->back();
    }

    public function userDashboard(Request $request)
    {
        // Khởi tạo query để lấy danh sách đơn hàng của người dùng
        $query = Order::query()->with('orderProducts')
            ->where('user_id', Auth::user()->id);

        // Lọc theo trạng thái nếu có chọn
        if ($request->has('status') && !empty($request->status)) {
            $query->where('order_status', $request->status);
        }

        // Lọc theo khoảng thời gian nếu có chọn
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Phân trang đơn hàng
        $orders = $query->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('client.page.dashboard.sections.order-list', compact('orders'))->render();
        }

        return view('client.page.dashboard.dashboard', compact('orders'));
    }

    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json($provinces);
        // return view('client.page.dashboard.dashboard', compact('provinces'));
    }

    public function getDistrictsByProvince($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
        // return view('client.page.dashboard.dashboard', compact('districts'));
    }

    public function getCommunesByDistrict($district_id)
    {
        $communes = Commune::where('district_id', $district_id)->get();
        return response()->json($communes);
    }
}
