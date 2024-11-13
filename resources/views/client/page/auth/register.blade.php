@extends('layouts.client')
@section('title')
    Đăng ký
@endsection
@section('section')
    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="category.html">Cửa hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tài khoản của bạn
                        </li>
                    </ol>
                </div>
            </nav>

            <h1 class="mt-2">Đăng ký</h1>

        </div>
    </div>
    <div class="container login-container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="row">
                    <div class="col-md-12 ">

                        <form action="{{ route('postRegister') }}" method="POST">
                            @csrf


                            <label for="register-name">
                                Tên người dùng
                                <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input form-wide" id="register-name" name="name" required />

                            <label for="register-email">
                                Email
                                <span class="required">*</span>
                            </label>
                            <input type="email" class="form-input form-wide" id="register-email" name="email"
                                required />

                            <label for="register-password">
                                Mật khẩu
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" id="register-password" name="password"
                                required />

                            <label for="confirm-password">
                                Xác nhận mật khẩu
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" id="confirm-password"
                                name="password_confirmation" required />


                            <div class="form-footer mb-2">
                                <button type="submit" class="btn btn-dark btn-md w-100 mr-0">Đăng ký</button>
                            </div>
                            <div class="text-center mt-2">
                                Bạn chưa có tài khoản ?
                                <a href="{{ route('login') }}" class="text-dark form-footer-right">Đăng nhập</a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
