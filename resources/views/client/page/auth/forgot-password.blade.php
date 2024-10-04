@extends('layouts.client')
@section('title')
    Quên Mật Khẩu
@endsection
@section('section')

    <div class="page-header">
        <div class="container d-flex flex-column align-items-center">
            <h1 class="mt-2">Quên Mật Khẩu</h1>
        </div>
    </div>

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('send.reset.link') }}" method="POST">
                            @csrf
                            <label for="email">
                                Địa chỉ Email
                                <span class="required">*</span>
                            </label>
                            <input type="email" class="form-input form-wide" id="email" name="email" required />

                            <button type="submit" class="btn btn-dark btn-md w-100">
                                Gửi liên kết đặt lại mật khẩu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
