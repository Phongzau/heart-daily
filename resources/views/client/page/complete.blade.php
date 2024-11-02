@extends('layouts.client')
@section('title')
    Đặt hàng thành công
@endsection
@section('section')
    <div class="container text-center" style="margin-top: 50px;">
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã đặt hàng. Một email xác nhận đã được gửi đến địa chỉ email của bạn.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
    <div class="mb-6"></div>
@endsection
