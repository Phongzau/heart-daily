<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|string|min:6|confirmed',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);

        try {
            User::create($request->all());
            return redirect()->route('register')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Đăng ký thất bại. Vui lòng thử lại.');
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

        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        } else {
            return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác.');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
