@extends('layouts.client')


@section('title')
    {{ $generalSettings->site_name }} || Giỏ hàng
@endsection

@section('css')
    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 20px;
            border-left: 1px solid #ccc;
            z-index: 1001;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .sidebar-content {
            padding: 15px;
        }

        .code-coupon {
            font-weight: 700;
        }

        .coupon-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .coupon-card img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .coupon-details {
            flex: 1;
        }

        .coupon-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .coupon-code {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .coupon-condition {
            font-size: 14px;
            color: #888;
            margin-bottom: 5px;
        }

        .coupon-expiry {
            font-size: 12px;
            color: #2299dd;
        }

        .use-coupons {
            background-color: #2299dd;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .use-coupons:hover {
            background-color: #656362;
        }

        .used-coupon {
            background-color: #656362;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        .checkout-progress-bar .disabled a {
            pointer-events: none;
            /* Không cho phép nhấn */
            color: #ccc;
            /* Màu chữ mờ đi */
            text-decoration: none;
            /* Xóa gạch chân */
            cursor: not-allowed;
            /* Thay đổi con trỏ thành không được phép */
        }

        #openSidebarBtn {
            color: black;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        #openSidebarBtn:hover {
            color: #ffffff;
            background-color: #2299dd;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('section')
    @php
        $userPoints = 0;
    @endphp
    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active">
                <a href="{{ route('cart-details') }}">Giỏ hàng</a>
            </li>
            <li @if (count($carts) === 0) class="disabled" @endif>
                <a href="{{ count($carts) > 0 ? route('checkout') : '#' }}"
                    @if (count($carts) === 0) tabindex="-1" aria-disabled="true" @endif class="">Thanh toán</a>
            </li>
            <li class="disabled">
                <a href="cart.html">Hoàn thành đơn hàng</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table-container">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th class="thumbnail-col">
                                    @if (count($carts) !== 0)
                                        <a style="font-size: 9px; color:#ffffff; border-radius: 8%;"
                                            class="btn btn-danger clear_cart">
                                            Clear All
                                        </a>
                                    @endif
                                </th>
                                <th class="product-col">Sản phẩm</th>
                                <th class="price-col">Giá</th>
                                <th class="qty-col">Số lượng</th>
                                <th class="text-right">Tổng cộng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $keyCart => $item)
                                <tr class="product-row">
                                    <td>
                                        <figure class="product-image-container">
                                            <a href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}"
                                                class="product-image">
                                                <img src="{{ Storage::url($item['options']['image']) }}"
                                                    alt="{{ $item['name'] }}">
                                            </a>

                                            <a href="{{ route('cart.remove-product', ['cartKey' => $keyCart]) }}"
                                                class="btn-remove icon-cancel remove-product" title="Remove Product"></a>
                                        </figure>
                                    </td>
                                    <td class="product-col">
                                        <h5 class="product-title text-center">
                                            <a href="{{ route('product.detail', ['slug' => $item['options']['slug']]) }}">
                                                @if (isset($item['options']['variants']))
                                                    {{ $item['name'] }}
                                                    @foreach ($item['options']['variants'] as $key => $variant)
                                                        <span>
                                                            {{ $key }}: {{ $variant }}
                                                        </span> <br>
                                                    @endforeach
                                                @else
                                                    {{ $item['name'] }}
                                                @endif
                                            </a>
                                        </h5>
                                    </td>
                                    <td>{{ number_format($item['price']) }}{{ $generalSettings->currency_icon }}</td>
                                    <td>
                                        <div class="product-single-qty">
                                            <input class="horizontal-quantity product-qty form-control"
                                                data-cartkey="{{ $keyCart }}" value="{{ $item['qty'] }}"
                                                type="text">
                                        </div><!-- End .product-single-qty -->
                                    </td>
                                    <td class="text-right"><span
                                            id="{{ $keyCart }}">{{ number_format($item['price'] * $item['qty']) }}{{ $generalSettings->currency_icon }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($carts) === 0)
                                <div class="text-center">
                                    <span style="width: 100%; color:black; font-size: 20px; font-weight: 700">
                                        Cart is empty!
                                    </span>
                                </div>
                            @endif
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5" class="clearfix">
                                    <div class="float-left">
                                        <div class="cart-discount">
                                            <form id="coupon_form">
                                                <div class="input-group">
                                                    <input type="text" class="form-control ip-coupon form-control-sm"
                                                        placeholder="Coupon Code"
                                                        value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}"
                                                        name="coupon_code">

                                                    <button class="btn btn-sm" type="submit">Áp dụng mã giảm giá</button>

                                                </div><!-- End .input-group -->
                                            </form>
                                        </div>
                                    </div><!-- End .float-left -->
                                    <div style="display: inline-flex;" class="">
                                        <button class="btn choose-coupon btn-sm" id="openSidebarBtn" type="submit">Chọn
                                            mã giảm giá</button>

                                        <button id="myBtnUsePoint" class="btn btn-sm btn-success" style="margin:0px"
                                            id="payWithPoints">
                                            Sử dụng điểm
                                        </button>

                                    </div>


                                    <div style="width: 350px;" class="float-right">
                                        <div class="cart-summary">
                                            <h3>TỔNG GIỎ HÀNG</h3>

                                            <table class="table table-totals">
                                                <tbody>
                                                    <tr>
                                                        <td>Tổng cộng:</td>
                                                        <td id="sub_total" style="color: black; font-weight: 700">
                                                            {{ number_format(getCartTotal()) }}{{ $generalSettings->currency_icon }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                                <tbody id="tbody-cart">
                                                    <tr>
                                                        <td>Phí ship (+):</td>
                                                        <td style="color: black; font-weight: 700">
                                                            {{ number_format(getCartCod()) }}{{ $generalSettings->currency_icon }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mã giảm(-):</td>
                                                        <td id="discount" style="color: black; font-weight: 700">
                                                            {{ number_format(getCartDiscount()) }}{{ $generalSettings->currency_icon }}
                                                        </td>
                                                    </tr>
                                                    @if (session()->has('point'))
                                                        <tr id="pointTr">
                                                            <td>Điểm(-):</td>
                                                            <td id="pointTd" style="color: black; font-weight: 700">
                                                                {{ number_format(session()->get('point')['point_value']) }}{{ $generalSettings->currency_icon }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>Tổng:</td>
                                                        <td id="total" style="font-size: 16px;">
                                                            {{ number_format(getMainCartTotal()) }}{{ $generalSettings->currency_icon }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <div class="checkout-methods">
                                                <a href="{{ route('checkout') }}"
                                                    class="btn btn-block btn-dark @if (count($carts) === 0) disabled-link @endif"
                                                    @if (count($carts) === 0) tabindex="-1" aria-disabled="true" @endif>Tiến
                                                    hành thanh toán
                                                    <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div><!-- End .cart-summary -->
                                    </div><!-- End .float-right -->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
        @if (auth()->check())
            @php
                $userPoints = auth()->user()->point; // Lấy số điểm hiện có của user
                $pointToMoney = number_format($userPoints, 0, ',', '.'); // Quy đổi số điểm sang tiền
            @endphp
            <div id="myModalUsePoint" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h4>Quy đổi điểm để thanh toán</h4>

                    <!-- Hiển thị thông tin số point và tương ứng số tiền -->
                    <p>Bạn hiện có <strong>{{ $userPoints }}</strong> điểm, tương đương <strong>{{ $pointToMoney }}
                            {{ $generalSettings->currency_icon }}</strong>.</p>

                    <p><code></code>1.000 điểm tương ứng với <strong>1.000 {{ $generalSettings->currency_icon }}</strong>.
                    </p>

                    <!-- Input nhập số point muốn sử dụng -->
                    <div class="form-group">
                        <label for="pointsInput">Nhập số điểm bạn muốn sử dụng:</label>
                        <input type="number" id="pointsInput"
                            value="{{ session()->has('point') ? session()->get('point')['point_value'] : 0 }}"
                            min="0" max="{{ $userPoints }}" class="form-control" placeholder="Nhập điểm...">
                    </div>
                    <p>Giá tiền tương ứng: <strong
                            id="equivalentMoney">{{ number_format(session()->has('point') ? session()->get('point')['point_value'] : 0) }}
                            {{ $generalSettings->currency_icon }}</strong>
                    </p>


                    <!-- Nút xác nhận sử dụng điểm -->
                    <button id="confirmUsePoints" class="btn btn-primary">Xác nhận sử dụng điểm</button>

                </div>
            </div>
        @endif

        {{-- <div class="row">
            <div class="col-lg-8">
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>TỔNG GIỎ HÀNG</h3>

                    <table class="table table-totals">
                        <tbody>
                            <tr>
                                <td>Tổng cộng</td>
                                <td><strong style="color: black">{{ number_format(getCartTotal()) }} VND</strong></td>
                            </tr>

                        </tbody>
                        <tbody>
                            <tr>
                                <td>Mã giảm(-)</td>
                                <td><strong style="color: black">0 VND</strong></td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Tổng</td>
                                <td>$17.90</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        <a href="{{ route('checkout') }}" class="btn btn-block btn-dark">Tiến hành thanh toán
                            <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div><!-- End .cart-summary -->
            </div><!-- End .col-lg-4 -->
        </div> --}}
    </div><!-- End .container -->
    <div id="couponSidebar" class="sidebar">
        <span class="close-btn">&times;</span>
        @livewire('coupon-list')
    </div>
    <div class="mb-6"></div><!-- margin -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let timeDown;
            let isClickTriggered = true;

            // Mở modal khi nhấn nút "Choose coupon"
            // Mở sidebar và hiển thị overlay khi nhấn nút
            $("#openSidebarBtn").click(function() {
                $("#couponSidebar").css("width", "400px");
            });

            // Đóng sidebar và ẩn overlay khi nhấn vào dấu '×' hoặc overlay
            $(".close-btn, .overlay").click(function() {
                $("#couponSidebar").css("width", "0");
            });

            $(document).on('click', '#myBtnUsePoint', function() {
                if ($('#myModalUsePoint').length) {
                    $('#myModalUsePoint').fadeIn();
                } else {
                    toastr.error('Bạn phải đăng nhập để sử dụng điểm');
                }


            })

            $(".close").click(function() {
                $("#myModalUsePoint").fadeOut();
            });

            $(window).click(function(event) {
                if ($(event.target).is("#myModalUsePoint")) {
                    $("#myModalUsePoint").fadeOut();
                }
            });

            $(document).on('click', '#confirmUsePoints', function(e) {
                e.preventDefault();
                let inputPoint = $('#pointsInput').val();

                $.ajax({
                    url: "{{ route('use-point') }}",
                    method: "POST",
                    data: {
                        point: inputPoint,
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message +
                                '{{ $generalSettings->currency_icon }}');
                            if ($('#pointTr').length) {
                                $('#pointTr').find($('#pointTd')).html(data.useablePoint +
                                    "{{ $generalSettings->currency_icon }}");
                            } else {
                                let newRow = `
                                    <tr id="pointTr">
                                        <td>Điểm(-):</td>
                                        <td id="pointTd" style="color: black; font-weight: 700">
                                            ${data.useablePoint}{{ $generalSettings->currency_icon }}
                                        </td>
                                    </tr>
                                `
                                $('#tbody-cart').append(newRow);
                            }
                            renderCartSubTotal();
                            calculateCouponDiscount();
                            $("#myModalUsePoint").fadeOut();
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            })
                        }
                    }
                })
            })
            $(document).on('keyup', '#pointsInput', function() {
                let points = parseInt($(this).val());
                let userPoints = "{{ $userPoints }}";
                let money = 0;

                if (isNaN(points) || points === "") {
                    points = 0;
                }

                if (points < 0) {
                    $(this).val(0);
                    points = 0;
                } else if (points > userPoints) {
                    $(this).val(userPoints);
                    points = parseInt(userPoints);
                }

                money = points.toLocaleString('vi-VN');

                $('#equivalentMoney').html(`${money} {{ $generalSettings->currency_icon }}`)
            })



            // Tăng số lượng input-group-append
            // $(document).on('click', '.input-group-append', function() {
            //     let input = $(this).siblings('.product-qty');
            //     let cartKey = input.data('cartkey');
            //     let quantity = parseInt(input.val());
            //     clearTimeout(timeDown);
            //     timeDown = setTimeout(function() {
            //         $.ajax({
            //             url: "{{ route('cart.update-quantity') }}",
            //             method: "POST",
            //             data: {
            //                 cartKey: cartKey,
            //                 quantity: quantity,
            //             },
            //             success: function(data) {
            //                 if (data.status === 'success') {
            //                     let productId = '#' + cartKey;
            //                     let totalAmount = data.product_total +
            //                         '{{ $generalSettings->currency_icon }}';
            //                     $(productId).text(totalAmount);
            //                     renderCartSubTotal();
            //                     calculateCouponDiscount()
            //                 } else if (data.status === 'error') {
            //                     input.val(data.current_qty);
            //                     toastr.error(data.message);
            //                 }
            //             },
            //             error: function(xhr) {
            //                 if (xhr.status === 401) {
            //                     // Chuyển hướng người dùng đến trang đăng nhập
            //                     toastr.warning(
            //                         'Bạn cần đăng nhập để thực hiện điều này.');
            //                     setTimeout(() => {
            //                         window.location.href = '/login';
            //                     }, 1500);
            //                 }
            //             },
            //         })
            //     }, 1000);
            // })
            // Lắng nghe sự kiện click
            $(document).on('click', '.input-group-append', function() {
                isClickTriggered = true;
                let input = $(this).siblings('.product-qty');
                let cartKey = input.data('cartkey');
                let quantity = parseInt(input.val());
                console.log(timeDown);

                // Xóa hẹn giờ cũ
                clearTimeout(timeDown);

                // Tạo hẹn giờ mới
                timeDown = setTimeout(function() {
                    console.log('Request đang được gửi');
                    $.ajax({
                        url: "{{ route('cart.update-quantity') }}",
                        method: "POST",
                        data: {
                            cartKey: cartKey,
                            quantity: quantity,
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                let productId = '#' + cartKey;
                                let totalAmount = data.product_total +
                                    '{{ $generalSettings->currency_icon }}';
                                $(productId).text(totalAmount);
                                renderCartSubTotal();
                                calculateCouponDiscount();
                            } else if (data.status === 'error') {
                                input.val(data.current_qty);
                                toastr.error(data.message);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                toastr.warning(
                                    'Bạn cần đăng nhập để thực hiện điều này.');
                                setTimeout(() => {
                                    window.location.href = '/login';
                                }, 1500);
                            }
                        },
                    });
                    isClickTriggered = false;
                }, 1000); // Delay 1 giây sau lần click cuối cùng
            });

            // Giảm số lượng input-group-prepend
            $(document).on('click', '.input-group-prepend', function() {
                isClickTriggered = true;
                let input = $(this).siblings('.product-qty');
                let cartKey = input.data('cartkey');
                let quantity = parseInt(input.val());
                console.log(timeDown);

                // Xóa hẹn giờ cũ
                clearTimeout(timeDown);
                timeDown = setTimeout(function() {
                    console.log('Request đang được gửi');
                    $.ajax({
                        url: "{{ route('cart.update-quantity') }}",
                        method: "POST",
                        data: {
                            cartKey: cartKey,
                            quantity: quantity,
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                let productId = '#' + cartKey;
                                let totalAmount = data.product_total +
                                    '{{ $generalSettings->currency_icon }}';
                                $(productId).text(totalAmount);
                                renderCartSubTotal();
                                calculateCouponDiscount();
                            } else if (data.status === 'error') {
                                input.val(data.current_qty);
                                toastr.error(data.message);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                // Chuyển hướng người dùng đến trang đăng nhập
                                toastr.warning(
                                    'Bạn cần đăng nhập để thực hiện điều này.');
                                setTimeout(() => {
                                    window.location.href = '/login';
                                }, 1500);
                            }
                        },
                    });
                    isClickTriggered = false;
                }, 1000);
            })

            $(document).on('change', '.product-qty', function() {
                if (isClickTriggered) return;
                let input = $(this);
                let cartKey = input.data('cartkey');
                let quantity = parseInt(input.val());
                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: "POST",
                    data: {
                        cartKey: cartKey,
                        quantity: quantity,
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            let productId = '#' + cartKey;
                            let totalAmount = data.product_total +
                                '{{ $generalSettings->currency_icon }}';
                            $(productId).text(totalAmount);
                            renderCartSubTotal();
                            calculateCouponDiscount()
                        } else if (data.status === 'error') {
                            input.val(data.current_qty);
                            toastr.error(data.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            // Chuyển hướng người dùng đến trang đăng nhập
                            toastr.warning('Bạn cần đăng nhập để thực hiện điều này.');
                            setTimeout(() => {
                                window.location.href = '/login';
                            }, 1500);
                        }
                    },
                })
                console.log("hoạt động");
            })
            $(document).on('click', '.use-coupons', function() {
                let couponCode = $(this).siblings('.coupon-details').find('.code-coupon').text();
                let dataCode = $(this).data('code');

                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    method: 'GET',
                    data: {
                        coupon_code: couponCode,
                    },
                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message);
                        } else if (data.status == 'success') {
                            toastr.success(data.message);
                            $('.use-coupons[data-code="' + dataCode + '"]')
                                .text('Đang sử dụng')
                                .prop('disabled', true)
                                .addClass('used-coupon');
                            updateOtherCoupons(dataCode);
                            $('.ip-coupon').val(couponCode);
                            calculateCouponDiscount();

                        }
                    },
                    error: function(data) {

                    },
                })
            });

            function updateOtherCoupons(selectedCoupon) {
                $('.use-coupons').each(function() {
                    let dataCode = $(this).data('code');
                    if (dataCode !== selectedCoupon) {
                        $(this).text('Sử dụng').prop('disabled', false).removeClass('used-coupon');
                    }
                })
            }
            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    method: 'GET',
                    data: formData,
                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message);
                        } else if (data.status == 'success') {
                            toastr.success(data.message);
                            calculateCouponDiscount();
                        }
                    },
                    error: function(data) {

                    },
                })
            })

            $('.clear_cart').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Bạn có chắc không?",
                    text: "Hành động này sẽ xóa sạch giỏ hàng của bạn!",
                    icon: "warning",
                    width: '400px',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Đồng ý"

                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'GET',
                            url: "{{ route('clear.cart') }}",

                            success: function(data) {
                                if (data.status == 'success') {
                                    window.location.reload();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        })


                    }
                });
            })

            function renderCartSubTotal() {
                $.ajax({
                    url: "{{ route('cart.product-total') }}",
                    method: 'GET',
                    success: function(data) {
                        let totalAmount = data + '{{ $generalSettings->currency_icon }}';
                        $('#sub_total').text(totalAmount);
                    },
                    error: function(data) {

                    },
                })
            }

            function calculateCouponDiscount() {
                $.ajax({
                    url: "{{ route('coupon-calculation') }}",
                    method: 'GET',
                    success: function(data) {
                        if (data.status == 'success') {
                            console.log(data);

                            $('#discount').text(data.discount +
                                '{{ $generalSettings->currency_icon }}');
                            $('#total').text(data.cart_total +
                                '{{ $generalSettings->currency_icon }}');
                            if ($('#pointTr').length) {
                                $('#pointTd').text(data.point_value +
                                    "{{ $generalSettings->currency_icon }}");
                            }

                        }
                    },
                    error: function(data) {},
                })
            }
        })
    </script>
@endpush
