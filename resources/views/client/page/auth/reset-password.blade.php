@extends('layouts.client')
@section('title')
    Đặt lại mật khẩu
@endsection
@section('section')

    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <h1 class="mt-2">Đặt lại mật khẩu</h1>
        </div>
    </div>

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('reset.password.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <label for="email">
                                Địa chỉ Email
                                <span class="required">*</span>
                            </label>
                            <input type="email" class="form-input form-wide" id="email" name="email" required />

                            <label for="password">
                                Mật khẩu mới
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" id="password" name="password" required />

                            <label for="password-confirm">
                                Xác nhận mật khẩu mới
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" id="password-confirm" name="password_confirmation" required />

                            <button type="submit" class="btn btn-dark btn-md w-100">
                                Đặt lại mật khẩu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
