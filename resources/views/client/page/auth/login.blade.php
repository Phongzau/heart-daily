@extends('layouts.client')

@section('title')
    Đăng nhập
@endsection

@section('section')
    <main class="main">
        <div class="page-header">
            <div class="container d-flex flex-column align-items-center">
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <div class="container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="category.html">Shop</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                    </div>
                </nav>
                <h1>My Account</h1>
            </div>
        </div>

        <div class="container login-container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column">
                            <div class="heading mb-1">
                                <h2 class="title">Đăng nhập</h2>
                            </div>

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
                                <input type="password" class="form-input form-wide" id="login-password" name="password" required />
                            
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

                        <div class="col-md-8 d-flex flex-column mt-4 mt-md-0">
                            <div class="heading mb-1">
                                <h2 class="title">Đăng ký</h2>
                            </div>

                            <form action="{{ route('postRegister') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="register-name">
                                            Tài khoản
                                            <span class="required">*</span>
                                        </label>
                                        <input type="text" class="form-input form-wide" id="register-name" name="name" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="register-email">
                                            Email
                                            <span class="required">*</span>
                                        </label>
                                        <input type="email" class="form-input form-wide" id="register-email" name="email" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="register-password">
                                            Mật khẩu
                                            <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-input form-wide" id="register-password" name="password" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="confirm-password">
                                            Xác nhận mật khẩu
                                            <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-input form-wide" id="confirm-password" name="password_confirmation" required />
                                    </div>

                                    <div class="form-footer mb-2">
                                        <button type="submit" class="btn btn-dark btn-md w-100 mr-0">Đăng ký</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Hiển thị thông báo lỗi đăng ký nếu có -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- End .main -->
@endsection
