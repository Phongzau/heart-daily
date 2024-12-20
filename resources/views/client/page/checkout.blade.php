@extends('layouts.client')


@section('title')
    {{ $generalSettings->site_name }} || Thanh toán đơn hàng
@endsection

@section('section')
    <div class="container checkout-container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li>
                <a href="{{ route('cart-details') }}">Giỏ hàng</a>
            </li>
            <li class="active">
                <a href="{{ route('checkout') }}">Thanh toán</a>
            </li>
            <li class="disabled">
                <a href="#">Hoàn thành đơn hàng</a>
            </li>
        </ul>

        <div class="checkout-discount">
            <h4>Bạn có phiếu giảm giá không?
                <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne"
                    class="btn btn-link btn-toggle">
                    NHẬP MÃ CỦA BẠN</button>
            </h4>

            <div id="collapseTwo" class="collapse">
                <div class="feature-box">
                    <div class="feature-box-content">
                        <p>Nếu bạn có mã giảm giá vui lòng áp dụng bên dưới.</p>

                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm w-auto" placeholder="Nhập mã"
                                    required="" />
                                <div class="input-group-append">
                                    <button class="btn btn-sm mt-0" type="submit">
                                        Áp dụng mã
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
                        <h2 class="step-title">Chi tiết thanh toán</h2>

                        <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                            @csrf
                            <label>Thông tin liên hệ</label>
                            <div class="form-group">
                                {{-- <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Fist name" /> --}}
                                <input type="text" name="first_name" class="form-control" required
                                    value="{{ old('first_name', Auth::user()->first_name) }}"
                                    placeholder="Nhập tên của bạn">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', Auth::user()->phone) }}"placeholder="Nhập SĐT của bạn">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="editor@gmail.com" value="{{ old('email', Auth::user()->email) }}"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <label>Địa chỉ</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="province" name="province_id"
                                            style="border: 1px solid #dfdfdf; height: 40px; color: #777; width:100%; padding: 0.3rem 0.5rem;">
                                            <option value="">Thành phố/tỉnh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="district" name="district_id" disabled
                                            style="border: 1px solid #dfdfdf; height: 40px; color: #777; width:100%; padding: 0.3rem 0.5rem;">
                                            <option value="">Quận/huyện</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="commune" name="commune_id" disabled
                                            style="border: 1px solid #dfdfdf; height: 40px; color: #777; width:100%; padding: 0.3rem 0.5rem;">
                                            <option value="">Xã/phường</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="address" class="form-control" required
                                    value="{{ old('address', Auth::user()->address) }}" />
                            </div>

                            {{-- <div class="form-group mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create-account" />
                                        <label class="custom-control-label" data-toggle="collapse"
                                            data-target="#collapseThree" aria-controls="collapseThree"
                                            for="create-account">Tạo bảo mật tài khoản?</label>
                                    </div>
                                </div>

                                <div id="collapseThree" class="collapse">
                                    <div class="form-group">
                                        <label>
                                        Tạo mật khẩu tài khoản
                                            <abbr class="required" title="required">*</abbr></label>
                                        <input type="password" placeholder="Password" class="form-control" required />
                                    </div>
                                </div> --}}

                            <div class="form-group">
                                <label class="order-comments">Ghi chú đơn hàng</label>
                                <textarea class="form-control" id="order_comments" name="order_comments"></textarea>
                            </div>

                    </li>
                </ul>
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-5">
                <div class="order-summary">
                    <h3>Đơn hàng của bạn</h3>

                    <table class="table table-mini-cart">
                        <thead>
                            <tr>
                                <th colspan="2">Sản phẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $keyCart => $item)
                                <tr>
                                    <td class="product-col">
                                        <h3 class="product-title">
                                            {{ $item['name'] }}
                                            @if (isset($item['options']['variants']))
                                                ({{ implode(' - ', $item['options']['variants']) }})
                                            @endif
                                            ×
                                            <span class="product-qty">{{ $item['qty'] }}</span>
                                        </h3>
                                    </td>

                                    <td class="price-col">
                                        <span>{{ number_format($item['price'] * $item['qty']) }}{{ $generalSettings->currency_icon }}</span>
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
                                    <span>{{ number_format(getCartTotal()) }}{{ $generalSettings->currency_icon }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        Ship COD
                                    </h3>
                                </td>

                                <td class="price-col">
                                    <span>{{ number_format(getCartCod()) }}{{ $generalSettings->currency_icon }}</span>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        Mã giảm giá
                                    </h3>
                                </td>

                                <td class="price-col">
                                    -<span>{{ number_format(getCartDiscount()) }}{{ $generalSettings->currency_icon }}</span>
                                </td>
                            </tr>
                            @if (session()->has('point'))
                                <tr>
                                    <td class="product-col">
                                        <h3 class="product-title">
                                            Điểm
                                        </h3>
                                    </td>

                                    <td class="price-col">
                                        -<span>{{ number_format(session()->get('point')['point_value']) }}{{ $generalSettings->currency_icon }}</span>
                                    </td>
                                </tr>
                            @endif


                            <tr>

                                <td>
                                    <h4>Tổng thanh toán</h4>
                                </td>
                                <td>
                                    <b
                                        class="total-price"><span>{{ number_format(getMainCartTotal()) }}{{ $generalSettings->currency_icon }}</span></b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="payment-methods">
                        <h4>Chọn phương thức thanh toán</h4>
                        <div class="form-group">
                            {{-- <label for="payment_method">Chọn phương thức thanh toán</label> --}}
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="" disabled selected>-- Chọn phương thức --</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->method }}">{{ $method->name }}</option>
                                @endforeach
                                {{-- <option value="momo">Thanh toán qua MoMo</option> --}}

                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark btn-place-order"form="checkout-form">Đặt hàng
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let userProvinceId = "{{ old('province_id', Auth::user()->province_id) }}";
            let userDistrictId = "{{ old('district_id', Auth::user()->district_id) }}";
            let userCommuneId = "{{ old('commune_id', Auth::user()->commune_id) }}";
            // Load all provinces on page load
            $.getJSON('/provinces', function(provinces) {
                $('#province').append(provinces.map(function(province) {
                    return `<option value="${province.id}" ${province.id == userProvinceId ? 'selected' : ''}>${province.title}</option>`;
                }));

                // Trigger change event to load districts if a province is pre-selected
                if (userProvinceId) {
                    $('#province').trigger('change');
                }
            });

            // Load districts when a province is selected
            $('#province').on('change', function() {
                let province_id = $(this).val();
                if (province_id) {
                    $('#district').prop('disabled', false);
                    $.getJSON(`/provinces/${province_id}/districts`, function(districts) {
                        $('#district').html('<option value="">Quận/huyện</option>');
                        $('#district').append(districts.map(function(district) {
                            return `<option value="${district.id}" ${district.id == userDistrictId ? 'selected' : ''}>${district.title}</option>`;
                        }));

                        // Trigger change event to load communes if a district is pre-selected
                        if (userDistrictId) {
                            $('#district').trigger('change');
                        }
                    });
                } else {
                    $('#district').prop('disabled', true).html('<option value="">Quận/huyện</option>');
                    $('#commune').prop('disabled', true).html('<option value="">Phường/xã</option>');
                }
            });

            // Load communes when a district is selected
            $('#district').on('change', function() {
                let district_id = $(this).val();
                if (district_id) {
                    $('#commune').prop('disabled', false);
                    $.getJSON(`/districts/${district_id}/communes`, function(communes) {
                        $('#commune').html('<option value="">Phường/xã</option>');
                        $('#commune').append(communes.map(function(commune) {
                            return `<option value="${commune.id}" ${commune.id == userCommuneId ? 'selected' : ''}>${commune.title}</option>`;
                        }));
                    });
                } else {
                    $('#commune').prop('disabled', true).html('<option value="">Phường/xã</option>');
                }
            });
        });
    </script>
@endsection
