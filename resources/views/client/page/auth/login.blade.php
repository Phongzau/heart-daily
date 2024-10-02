@extends('layouts.client')
@section('title')
    Đăng nhập
@endsection
@section('section')


    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.html">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            My Account
                        </li>
                    </ol>
                </div>
            </nav>

            <h1 class="mt-2">Login</h1>
        </div>
    </div>

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('postLogin') }}" method="POST">
                            @csrf
                            <label for="login">
                                Tên hoặc Email
                                <span class="required">*</span>
                            </label>
                            <input type="text" class="form-input form-wide" id="login" name="login" required />

                            <label for="login-password">
                                Mật khẩu
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" id="login-password" name="password"
                                required />

                            <div class="form-footer">
                                <div class="custom-control custom-checkbox mb-0">
                                    <input type="checkbox" class="custom-control-input" id="lost-password" />
                                    <label class="custom-control-label mb-0" for="lost-password">Ghi nhớ tôi</label>
                                </div>

                                <a href="forgot-password.html" class="forget-password text-dark form-footer-right">Quên
                                    mật khẩu?</a>
                            </div>
                            <button type="submit" class="btn btn-dark btn-md w-100">
                                Đăng nhập
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
