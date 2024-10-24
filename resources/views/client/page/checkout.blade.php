@extends('layouts.client')

@section('section')
    <div class="container checkout-container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li>
                <a href="{{ route('cart-details') }}">Shopping Cart</a>
            </li>
            <li class="active">
                <a href="{{ route('checkout') }}">Checkout</a>
            </li>
            <li class="disabled">
                <a href="#">Order Complete</a>
            </li>
        </ul>



        <div class="checkout-discount">
            <h4>Have a coupon?
                <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne"
                    class="btn btn-link btn-toggle">ENTER YOUR CODE</button>
            </h4>

            <div id="collapseTwo" class="collapse">
                <div class="feature-box">
                    <div class="feature-box-content">
                        <p>If you have a coupon code, please apply it below.</p>

                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm w-auto" placeholder="Coupon code"
                                    required="" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm mt-0" type="submit">
                                        Apply Coupon
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Billing details</h2>

                        <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                            @csrf
                            <label>Liên hệ</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Họ và tên" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="tel" class="form-control" id="phone" name="phone" required
                                            placeholder="Số điện thoại" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" required
                                            placeholder="Email" />
                                    </div>
                                </div>
                            </div>
                            <label>Địa chỉ</label>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="city" name="city" required
                                            placeholder="Tỉnh/Thành phố" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="district" name="district" required
                                            placeholder="Quận/Huyện" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="ward" name="ward" required
                                            placeholder="Phường/Xã" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="address" name="address" required
                                    placeholder="Tên dường, Tòa nhà, Số nhà." />
                            </div>

                            {{-- <div class="form-group mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create-account" />
                                        <label class="custom-control-label" data-toggle="collapse"
                                            data-target="#collapseThree" aria-controls="collapseThree"
                                            for="create-account">Create an
                                            account?</label>
                                    </div>
                                </div>

                                <div id="collapseThree" class="collapse">
                                    <div class="form-group">
                                        <label>Create account password
                                            <abbr class="required" title="required">*</abbr></label>
                                        <input type="password" placeholder="Password" class="form-control" required />
                                    </div>
                                </div> --}}

                            <div class="form-group">
                                <label class="order-comments">Order notes (optional)</label>
                                <textarea class="form-control" id="order_comments" name="order_comments"
                                    placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>

                    </li>
                </ul>
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-5">
                <div class="order-summary">
                    <h3>YOUR ORDER</h3>

                    <table class="table table-mini-cart">
                        <thead>
                            <tr>
                                <th colspan="2">Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $keyCart => $item)
                                <tr>
                                    <td class="product-col">
                                        <h3 class="product-title">
                                            {{ $item['name'] }} ×
                                            <span class="product-qty">{{ $item['qty'] }}</span>
                                        </h3>
                                    </td>

                                    <td class="price-col">
                                        <span>{{ number_format($item['price'] * $item['qty']) }}</span>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th>Chi tiết thanh toán</th>
                                <th>
                                    <hr>
                                </th>
                            </tr>
                            <tr class="cart-subtotal">
                                <td>
                                    <h4>Tổng tiền hàng</h4>
                                </td>

                                <td class="price-col">
                                    <span>{{ number_format(getCartTotal()) }} VND</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        Ship COD
                                    </h3>
                                </td>

                                <td class="price-col">
                                    <span>{{ number_format(getCartCod()) }} VND</span>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>



                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        Coupon
                                    </h3>
                                </td>

                                <td class="price-col">
                                    -<span>{{ number_format(getCartDiscount()) }} VND</span>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <h4>Tổng thanh toán</h4>
                                </td>
                                <td>
                                    <b class="total-price"><span>{{ number_format(getMainCartTotal()) }} VND</span></b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="payment-methods">
                        <h4>Payment methods</h4>
                        <div class="form-group">
                            <label for="payment_method">Chọn phương thức thanh toán</label>
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="" disabled selected>-- Chọn phương thức --</option>
                                <option value="cod">Khi nhận hàng</option>
                                <option value="vnpay">Thanh toán qua VNPay</option>
                            </select>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-dark btn-place-order" form="checkout-form">
                        Place order
                    </button>
                    </form>
                </div>
                <!-- End .cart-summary -->
            </div>
            <!-- End .col-lg-4 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->
@endsection
