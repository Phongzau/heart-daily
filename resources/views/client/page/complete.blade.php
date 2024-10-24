@extends('layouts.client')

@section('section')
<div class="container text-center">
    <h1>Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã đặt hàng. Một email xác nhận đã được gửi đến địa chỉ email của bạn.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
</div>
@endsection
