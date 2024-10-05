<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Mail\ConfirmEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{

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
            toastr('Đăng nhập thành công!', 'success');
            return redirect()->route('home');
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
        return view('client.page.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            toastr('Mật khẩu của bạn đã được đặt lại thành công!', 'success');
            return redirect()->route('login');
        }

        toastr('Có lỗi xảy ra, vui lòng thử lại.', 'error');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        toastr('Bạn đã đăng xuất thành công.', 'success');
        return redirect()->route('home');
    }
}
